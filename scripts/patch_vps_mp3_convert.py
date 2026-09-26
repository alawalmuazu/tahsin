# -*- coding: utf-8 -*-
"""Install ffmpeg + patch local-tarteel with /v1/media/to-mp3."""
import re
import time
from pathlib import Path

import paramiko

PASS = re.search(
    r"PASS\s*=\s*'([^']+)'",
    Path(r"C:\Users\OMEN\Documents\NYSC\deploy.py").read_text(encoding="utf-8"),
).group(1)

CONVERT_SNIPPET = r'''
@app.post("/v1/media/to-mp3")
async def media_to_mp3(request: Request):
    """Convert a public WAV/WebM URL (or raw body) to MP3 for WhatsApp."""
    import subprocess
    import tempfile
    from pathlib import Path as P
    from fastapi.responses import Response

    ctype = (request.headers.get("content-type") or "").lower()
    src_bytes = b""
    if "application/json" in ctype:
        data = await request.json()
        url = (data or {}).get("url") or ""
        if not url:
            return {"ok": False, "error": "url required"}
        import urllib.request
        with urllib.request.urlopen(url, timeout=60) as resp:
            src_bytes = resp.read()
    else:
        src_bytes = await request.body()
    if len(src_bytes) < 64:
        return {"ok": False, "error": "empty audio"}

    with tempfile.TemporaryDirectory(prefix="wa-mp3-") as td:
        src = P(td) / "in.bin"
        out = P(td) / "out.mp3"
        src.write_bytes(src_bytes)
        cmd = [
            "ffmpeg", "-y", "-i", str(src),
            "-vn", "-ar", "44100", "-ac", "1", "-b:a", "64k", str(out),
        ]
        proc = await asyncio.to_thread(
            subprocess.run, cmd, capture_output=True, text=True, timeout=120
        )
        if proc.returncode != 0 or not out.is_file() or out.stat().st_size < 100:
            err = (proc.stderr or proc.stdout or "ffmpeg failed")[-500:]
            return {"ok": False, "error": err}
        return Response(
            content=out.read_bytes(),
            media_type="audio/mpeg",
            headers={"X-Convert": "ok"},
        )
'''

def run(ssh, cmd, timeout=600):
    print(">", cmd[:100])
    _, o, e = ssh.exec_command(cmd, timeout=timeout)
    out = o.read().decode("utf-8", "replace")
    err = e.read().decode("utf-8", "replace")
    code = o.channel.recv_exit_status()
    if out.strip():
        print(out[-1500:])
    if err.strip() and code:
        print(err[-800:])
    if code:
        raise SystemExit(f"fail {code}: {cmd}")
    return out

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect("72.62.232.120", username="root", password=PASS, timeout=30)
    run(ssh, "DEBIAN_FRONTEND=noninteractive apt-get install -y -qq ffmpeg", timeout=900)
    run(ssh, "ffmpeg -version | head -1")

    # Append convert endpoint if missing
    remote = "/opt/local-tarteel-engine/app/main.py"
    sftp = ssh.open_sftp()
    with sftp.file(remote, "r") as f:
        text = f.read().decode("utf-8")
    if "/v1/media/to-mp3" not in text:
        # insert after recite_final function block — after health final line area
        marker = '@app.post("/v1/recite/final")'
        if marker not in text:
            raise SystemExit("marker missing")
        # find end of recite_final — next @app. or async def startup
        idx = text.find(marker)
        # find next decorator after this function
        rest = text[idx + len(marker):]
        next_at = rest.find("\n@app.")
        if next_at < 0:
            next_at = rest.find("\n@app.on_event")
        if next_at < 0:
            raise SystemExit("cannot find insert point")
        insert_at = idx + len(marker) + next_at
        text = text[:insert_at] + "\n" + CONVERT_SNIPPET + "\n" + text[insert_at:]
        with sftp.file(remote, "w") as f:
            f.write(text)
        print("patched main.py")
    else:
        print("to-mp3 already present")
    sftp.close()

    run(ssh, "systemctl restart local-tarteel")
    time.sleep(5)
    run(ssh, "curl -sS http://127.0.0.1:8002/health")
    # smoke convert from live wav
    run(
        ssh,
        "curl -sS -o /tmp/t.mp3 -w '%{http_code} %{size_download}\\n' "
        "-H 'Content-Type: application/json' "
        "-d '{\"url\":\"https://tahsinacademy.ng/uploads/academy_tahfiz/rec_20260925200320_e0eb7d1b.wav\"}' "
        "http://127.0.0.1:8002/v1/media/to-mp3",
        timeout=180,
    )
    run(ssh, "file /tmp/t.mp3; ls -la /tmp/t.mp3")
    ssh.close()
    print("OK")

if __name__ == "__main__":
    main()
