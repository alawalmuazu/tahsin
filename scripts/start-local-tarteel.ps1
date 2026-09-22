# Start local Tarteel FastConformer engine on :8001 (Auto-mode fallback).
$ErrorActionPreference = 'Stop'
$engine = 'C:\Users\OMEN\Documents\ProjectFlow\projectflow\local-tarteel-engine'
$py = 'C:\Users\OMEN\AppData\Local\Programs\Python\Python310\python.exe'

if (-not (Test-Path $py)) {
  Write-Error "Python 3.10 not found at $py"
}
if (-not (Test-Path $engine)) {
  Write-Error "Local engine not found at $engine"
}

try {
  $health = Invoke-WebRequest -Uri 'http://127.0.0.1:8001/health' -UseBasicParsing -TimeoutSec 2
  Write-Host "Already running: $($health.Content)"
  exit 0
} catch {
  Write-Host 'Starting local Tarteel engine on http://127.0.0.1:8001 ...'
}

Set-Location $engine
& $py -m uvicorn app.main:app --host 127.0.0.1 --port 8001
