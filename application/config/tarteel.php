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
 * Set auth_token / user_id on each environment (do not commit real tokens).
 * Start local fallback:  powershell -File scripts/start-local-tarteel.ps1
 * Health check:          http://127.0.0.1:8001/health
 */
$config['tarteel'] = array(
    'engine' => 'auto',
    'ws_url' => 'wss://voice-v2.tarteel.io',
    'auth_token' => '',
    'user_id' => '',
    'app_version' => '5.32.0',
    'local_ws' => 'ws://127.0.0.1:8001/v1/recite/stream',
    'local_health' => 'http://127.0.0.1:8001/health',
    'is_dual_model' => true,
    'is_diacritized' => true,
    'debug' => false,
);
