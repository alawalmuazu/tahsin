<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Tarteel Voice Engine — mirrors ProjectFlow tarteelEngine.ts
 *
 * Cloud:  wss://voice-v2.tarteel.io  (NeMo → Riva ASR + dual-model tajweed)
 * Local:  ws://127.0.0.1:8001/v1/recite/stream  (Muno459 FastConformer ONNX)
 *
 * engine: auto | cloud | local
 *   auto  = try cloud WS, else local :8001
 *   cloud = force Tarteel cloud (needs valid auth_token)
 *   local = force local sidecar (no Tarteel token)
 *
 * Rotate auth_token / user_id when the cloud session expires
 * (same defaults as ProjectFlow TARTEEL_DEFAULT_*).
 *
 * Start local fallback:  powershell -File scripts/start-local-tarteel.ps1
 * Health check:          http://127.0.0.1:8001/health
 *
 * Full-clip final pass runs on the Hostinger VPS (CPU ONNX). Browsers never call
 * the VPS directly (HTTPS mixed-content); academy_students/tarteel_final proxies.
 * On localhost, the proxy targets 127.0.0.1:8001 instead.
 */
$config['tarteel'] = array(
    'engine' => 'auto',
    'ws_url' => 'wss://voice-v2.tarteel.io',
    'auth_token' => '906523fd5634c7177dd6cd346ae7457286e3d50f',
    'user_id' => '16687612',
    'app_version' => '5.32.0',
    'local_ws' => 'ws://127.0.0.1:8001/v1/recite/stream',
    'local_health' => 'http://127.0.0.1:8001/health',
    // Server-side only — used by Academy_students::tarteel_final on production hosts
    // VPS :8001 is another app; FastConformer listens on :8002
    'local_final_upstream' => 'http://72.62.232.120:8002/v1/recite/final',
    'is_dual_model' => true,
    'is_diacritized' => true,
    'debug' => true,
);
