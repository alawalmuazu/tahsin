"""
Deploy local FastConformer engine to Hostinger VPS (CPU).
Does not print credentials. Reads VPS_PASS from env, else from NYSC deploy.py.

Usage:
  set VPS_PASS=...
  python scripts/deploy_tarteel_vps.py
"""
from __future__ import annotations

import os
import re
import sys
import tarfile
import tempfile
import time
from pathlib import Path

import paramiko

HOST = os.environ.get("VPS_HOST", "72.62.232.120")
USER = os.environ.get("VPS_USER", "root")
REMOTE = "/opt/local-tarteel-engine"
ENGINE = Path(r"C:\Users\OMEN\Documents\ProjectFlow\projectflow\local-tarteel-engine")
QURAN_JSON = Path(
    r"C:\Users\OMEN\Documents\ProjectFlow\projectflow\src\app\api\tarteel\quran_ayahs.json"
)


def load_password() -> str:
    env = os.environ.get("VPS_PASS", "").strip()
    if env:
        return env
    # Prefer CAC deploy.ps1 / NYSC deploy.py without executing them
    for path in (
        Path(r"C:\Users\OMEN\Documents\NYSC\deploy.py"),
        Path(r"C:\Users\OMEN\Documents\CAC\deploy.ps1"),
    ):
        if not path.is_file():
            continue
        text = path.read_text(encoding="utf-8", errors="replace")
        m = re.search(r"""(?:PASS|password)\s*=\s*['\"]([^'\"]+)['\"]""", text, re.I)
        if m:
            return m.group(1)
    raise SystemExit("Set VPS_PASS or keep NYSC/CAC deploy credentials on this machine.")


def build_archive(dest: Path) -> None:
    model = ENGINE / "models" / "muno459-fastconformer-quran"
    must = [
        ENGINE / "app",
        model / "onnx" / "model_with_encoder.onnx",
        model / "tokenizer.model",
        model / "head" / "pronunciation_head.pt",
        model / "tajweed",
    ]
    for p in must:
        if not p.exists():
            raise SystemExit(f"Missing: {p}")

    req = """fastapi==0.115.6
uvicorn[standard]==0.34.0
numpy>=1.24.0
torch --index-url https://download.pytorch.org/whl/cpu
transformers>=4.35.0
safetensors>=0.4.0
python-multipart==0.0.20
sentencepiece>=0.1.99
onnxruntime>=1.16.0
scipy>=1.11.0
"""
    # pip does not accept that torch line in requirements; write plain list
    req = """fastapi==0.115.6
uvicorn[standard]==0.34.0
numpy>=1.24.0
torch
transformers>=4.35.0
safetensors>=0.4.0
python-multipart==0.0.20
sentencepiece>=0.1.99
onnxruntime>=1.16.0
scipy>=1.11.0
"""

    with tarfile.open(dest, "w:gz") as tar:
        def add(path: Path, arc: str):
            tar.add(str(path), arcname=arc)

        add(ENGINE / "app", "app")
        add(model / "onnx" / "model_with_encoder.onnx", "models/muno459-fastconformer-quran/onnx/model_with_encoder.onnx")
        add(model / "tokenizer.model", "models/muno459-fastconformer-quran/tokenizer.model")
        add(model / "head" / "pronunciation_head.pt", "models/muno459-fastconformer-quran/head/pronunciation_head.pt")
        add(model / "tajweed", "models/muno459-fastconformer-quran/tajweed")
        if QURAN_JSON.is_file():
            add(QURAN_JSON, "data/quran_ayahs.json")

        req_path = dest.parent / "requirements-cpu.txt"
        req_path.write_text(req, encoding="utf-8")
        add(req_path, "requirements-cpu.txt")
        req_path.unlink(missing_ok=True)

        unit = """[Unit]
Description=Local Tarteel FastConformer (CPU)
After=network.target

[Service]
Type=simple
WorkingDirectory=/opt/local-tarteel-engine
Environment=QURAN_AYAHS_PATH=/opt/local-tarteel-engine/data/quran_ayahs.json
Environment=ORT_PROVIDERS=CPUExecutionProvider
ExecStart=/opt/local-tarteel-engine/.venv/bin/uvicorn app.main:app --host 0.0.0.0 --port 8002
Restart=always
RestartSec=5

[Install]
WantedBy=multi-user.target
"""
        unit_path = dest.parent / "local-tarteel.service"
        unit_path.write_text(unit, encoding="utf-8")
        add(unit_path, "local-tarteel.service")
        unit_path.unlink(missing_ok=True)


def run_cmd(ssh: paramiko.SSHClient, cmd: str, timeout: int = 600) -> None:
    print(">", cmd[:120] + ("…" if len(cmd) > 120 else ""))
    _stdin, stdout, stderr = ssh.exec_command(cmd, timeout=timeout)
    out = stdout.read().decode("utf-8", errors="replace")
    err = stderr.read().decode("utf-8", errors="replace")
    code = stdout.channel.recv_exit_status()
    if out.strip():
        print(out[-2000:])
    if err.strip():
        print(err[-1000:])
    if code != 0:
        raise SystemExit(f"Remote command failed ({code}): {cmd}")


def main() -> None:
    sys.stdout.reconfigure(encoding="utf-8", errors="replace")
    sys.stderr.reconfigure(encoding="utf-8", errors="replace")
    if not ENGINE.is_dir():
        raise SystemExit(f"Engine not found: {ENGINE}")
    password = load_password()
    print(f"Packaging from {ENGINE} ...", flush=True)
    tmp = Path(tempfile.mkdtemp(prefix="tarteel-vps-"))
    archive = tmp / "local-tarteel.tgz"
    build_archive(archive)
    size_mb = archive.stat().st_size / (1024 * 1024)
    print(f"Archive {size_mb:.1f} MB -> {HOST}:{REMOTE}")

    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    print("Connecting…")
    ssh.connect(HOST, username=USER, password=password, timeout=30)
    sftp = ssh.open_sftp()
    run_cmd(ssh, f"mkdir -p {REMOTE} /tmp")
    remote_tgz = "/tmp/local-tarteel.tgz"
    print("Uploading (this can take several minutes)…")
    sftp.put(str(archive), remote_tgz)
    sftp.close()

    run_cmd(
        ssh,
        f"systemctl stop local-tarteel 2>/dev/null || true; "
        f"mkdir -p {REMOTE} && tar -xzf {remote_tgz} -C {REMOTE} && rm -f {remote_tgz}",
    )
    run_cmd(ssh, "apt-get update -qq && DEBIAN_FRONTEND=noninteractive apt-get install -y -qq python3-venv python3-pip", timeout=900)
    run_cmd(
        ssh,
        f"cd {REMOTE} && python3 -m venv .venv && "
        f".venv/bin/pip install -U pip wheel && "
        f".venv/bin/pip install --extra-index-url https://download.pytorch.org/whl/cpu "
        f"-r requirements-cpu.txt",
        timeout=3600,
    )
    run_cmd(ssh, f"cp {REMOTE}/local-tarteel.service /etc/systemd/system/local-tarteel.service")
    run_cmd(ssh, "systemctl daemon-reload && systemctl enable local-tarteel && systemctl restart local-tarteel")
    time.sleep(4)
    run_cmd(ssh, "systemctl --no-pager --full status local-tarteel | head -30 || true")
    run_cmd(ssh, "curl -sS http://127.0.0.1:8002/health || true")
    # open firewall if ufw exists (:8001 already used by another app on this VPS)
    run_cmd(ssh, "ufw allow 8002/tcp 2>/dev/null || true; iptables -I INPUT -p tcp --dport 8002 -j ACCEPT 2>/dev/null || true")
    ssh.close()
    archive.unlink(missing_ok=True)
    print("Done. Health should show asr + final on :8002")


if __name__ == "__main__":
    main()
