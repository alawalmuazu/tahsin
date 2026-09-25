<?php
/**
 * WhatsApp Cloud API – Comprehensive Test & Status Dashboard
 * Visit in browser: http://localhost/tahsin/test_whatsapp.php
 * Or run via CLI:   php test_whatsapp.php
 * ⚠ DELETE after testing.
 */
define('ENVIRONMENT', 'development');
define('BASEPATH', __DIR__ . '/system/');
define('APPPATH',  __DIR__ . '/application/');
define('FCPATH',   __DIR__ . '/');
define('SYSDIR',   'system');
define('VIEWPATH', APPPATH . 'views/');
$_SERVER['REQUEST_URI']  = '/';
$_SERVER['SCRIPT_NAME']  = '/index.php';
$_SERVER['PATH_INFO']    = '/';

ob_start();
require_once BASEPATH . 'core/CodeIgniter.php';
ob_end_clean();

$CI =& get_instance();
$CI->load->library('whatsapp_cloud');

$isCli = (php_sapi_name() === 'cli');

// Fetch DB config
$cfgRow = $CI->db->get_where('whatsapp_cloud_config', ['branch_id' => 1])->row_array();
$wabaId      = isset($cfgRow['waba_id']) ? $cfgRow['waba_id'] : '';
$accessToken = isset($cfgRow['access_token']) ? $cfgRow['access_token'] : '';
$phoneId     = isset($cfgRow['phone_number_id']) ? $cfgRow['phone_number_id'] : '';
$tplName     = isset($cfgRow['template_name']) ? $cfgRow['template_name'] : 'tahsin_sealed_digest';
$tplLang     = isset($cfgRow['template_lang']) ? $cfgRow['template_lang'] : 'en';

// Handle quick token update
if (!empty($_POST['new_access_token'])) {
    $newToken = trim($_POST['new_access_token']);
    if ($newToken !== '') {
        $CI->db->update('whatsapp_cloud_config', ['access_token' => $newToken], ['branch_id' => 1]);
        header('Location: test_whatsapp.php?token_updated=1');
        exit;
    }
}

// Query Meta Graph API for template status
$templates = [];
$metaApiError = null;
if ($wabaId && $accessToken) {
    $ch = curl_init("https://graph.facebook.com/v21.0/{$wabaId}/message_templates");
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $accessToken],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 15
    ]);
    $resp = curl_exec($ch);
    $data = json_decode($resp, true);
    if (isset($data['data']) && is_array($data['data'])) {
        $templates = $data['data'];
    } elseif (isset($data['error'])) {
        $metaApiError = isset($data['error']['message']) ? $data['error']['message'] : 'Unknown Meta API error';
        if (!empty($data['error']['code']) && (int) $data['error']['code'] === 190) {
            $metaApiError = 'Meta Access Token Expired: The 24-hour developer test session has ended.';
        }
    }
}

$recipient = '2348021211053';
$action = isset($_GET['action']) ? $_GET['action'] : (isset($argv[1]) ? $argv[1] : null);
$sendResult = null;

if ($action === 'hello') {
    $sendResult = $CI->whatsapp_cloud->sendTemplate($recipient, [], 'hello_world', 'en_US');
    $sendResult['template_used'] = 'hello_world (en_US)';
} elseif ($action === 'digest') {
    $sampleParams = [
        'Ahmad',
        'Ustadh Yusuf',
        'Hifz Fauq - Al-Mulk (Ayah 1-5)',
        'Sealed by the director',
    ];
    $sendResult = $CI->whatsapp_cloud->sendTemplate($recipient, $sampleParams);
    $sendResult['template_used'] = $tplName . ' (' . $tplLang . ')';
}

if ($isCli) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "=== WhatsApp Cloud API Diagnostics ===\n\n";
    echo "Status:     " . $CI->whatsapp_cloud->statusLabel() . "\n";
    echo "Enabled:    " . ($CI->whatsapp_cloud->isEnabled() ? 'YES' : 'NO') . "\n";
    echo "Configured: " . ($CI->whatsapp_cloud->isConfigured() ? 'YES' : 'NO') . "\n";
    echo "Phone ID:   " . $phoneId . "\n";
    echo "WABA ID:    " . $wabaId . "\n\n";
    echo "Templates:\n";
    if ($metaApiError) {
        echo "  ⚠️ " . $metaApiError . "\n";
    } else {
        foreach ($templates as $t) {
            echo sprintf("  - %-25s [%-5s] : %s\n", $t['name'], $t['language'], $t['status']);
        }
    }
    if ($sendResult) {
        echo "\nSend Result for {$sendResult['template_used']}:\n";
        echo "OK: " . (!empty($sendResult['ok']) ? 'YES' : 'NO') . "\n";
        if (!empty($sendResult['wamid'])) echo "WAMID: " . $sendResult['wamid'] . "\n";
        if (!empty($sendResult['error'])) echo "Error: " . $sendResult['error'] . "\n";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WhatsApp Cloud API — Tahsin Diagnostics</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background: #0f172a; color: #f8fafc; padding: 2rem 1rem; line-height: 1.5; }
  .container { max-width: 820px; margin: 0 auto; }
  .card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.25rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.3); }
  h1 { font-size: 1.5rem; font-weight: 700; color: #38bdf8; margin-bottom: .35rem; display: flex; align-items: center; gap: .5rem; }
  p.sub { color: #94a3b8; font-size: .9rem; margin-bottom: 1.25rem; }
  .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: .85rem; margin-bottom: 1rem; }
  .metric { background: #0f172a; border: 1px solid #334155; border-radius: 8px; padding: .85rem; text-align: center; }
  .metric .val { font-size: 1.25rem; font-weight: 700; color: #10b981; }
  .metric .lbl { font-size: .75rem; text-transform: uppercase; color: #64748b; letter-spacing: .05em; margin-top: .25rem; }
  table { width: 100%; border-collapse: collapse; margin-top: .5rem; font-size: .88rem; }
  th, td { text-align: left; padding: .65rem .75rem; border-bottom: 1px solid #334155; }
  th { color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: .72rem; letter-spacing: .04em; }
  .badge { display: inline-block; padding: .25rem .55rem; border-radius: 9999px; font-size: .72rem; font-weight: 700; text-transform: uppercase; }
  .badge-approved { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); }
  .badge-pending { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); }
  .btn-group { display: flex; gap: .65rem; flex-wrap: wrap; margin-top: 1rem; }
  .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .6rem 1.1rem; border-radius: 8px; font-size: .85rem; font-weight: 600; text-decoration: none; cursor: pointer; border: none; transition: 0.15s ease-in-out; }
  .btn-primary { background: #2563eb; color: #fff; }
  .btn-primary:hover { background: #1d4ed8; }
  .btn-success { background: #16a34a; color: #fff; }
  .btn-success:hover { background: #15803d; }
  .btn-default { background: #334155; color: #f8fafc; }
  .btn-default:hover { background: #475569; }
  .alert { padding: 1rem; border-radius: 8px; margin-top: 1rem; font-size: .88rem; }
  .alert-success { background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; }
  .alert-warning { background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); color: #fbbf24; }
  .alert-error { background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; }
  pre { background: #0f172a; padding: .65rem; border-radius: 6px; font-size: .8rem; overflow-x: auto; margin-top: .5rem; }
</style>
</head>
<body>
<div class="container">
  <div class="card">
    <h1>📱 Tahsin WhatsApp Cloud API Diagnostics</h1>
    <p class="sub">Meta WhatsApp Business Platform &bull; WABA ID: <code><?= htmlspecialchars($wabaId); ?></code></p>

    <div class="grid">
      <div class="metric">
        <div class="val"><?= $CI->whatsapp_cloud->statusLabel(); ?></div>
        <div class="lbl">API Status</div>
      </div>
      <div class="metric">
        <div class="val"><?= $CI->whatsapp_cloud->isEnabled() ? 'Active' : 'Disabled'; ?></div>
        <div class="lbl">DB Config</div>
      </div>
      <div class="metric">
        <div class="val">+<?= htmlspecialchars($recipient); ?></div>
        <div class="lbl">Test Phone</div>
      </div>
    </div>

    <div class="btn-group">
      <a href="test_whatsapp.php?action=hello" class="btn btn-success">🚀 Test 'hello_world' Send (Instant)</a>
      <a href="test_whatsapp.php?action=digest" class="btn btn-primary">📊 Test 'tahsin_sealed_digest' Send</a>
      <a href="test_whatsapp.php" class="btn btn-default">🔄 Refresh Status</a>
      <a href="academy_broadcast" class="btn btn-default" target="_blank">🌐 Open Academy Broadcast</a>
    </div>

    <?php if ($metaApiError): ?>
      <div class="alert alert-error" style="margin-top:1rem;">
        <strong>⚠️ Meta Connection Notice:</strong> <?= htmlspecialchars($metaApiError); ?><br>
        <span style="font-size:.83rem;color:#cbd5e1;display:inline-block;margin-top:.25rem;">Temporary test tokens expire after 24 hours. Copy a fresh token from <a href="https://developers.facebook.com/apps/3354361148081931/use_cases/customize/api-testing-v2/" target="_blank" style="color:#38bdf8;text-decoration:underline;">Meta Developer Console</a> and paste it below:</span>
        <form method="POST" action="test_whatsapp.php" style="display:flex;gap:.5rem;margin-top:.75rem;">
          <input type="text" name="new_access_token" placeholder="Paste new EAAvqxhCu... access token here" style="flex:1;background:#0f172a;border:1px solid #475569;border-radius:6px;padding:.55rem .75rem;color:#fff;font-size:.82rem;" required>
          <button type="submit" class="btn btn-primary" style="padding:.55rem 1.1rem;">Update Token</button>
        </form>
      </div>
    <?php elseif (isset($_GET['token_updated'])): ?>
      <div class="alert alert-success" style="margin-top:1rem;">
        ✅ <strong>Access Token Updated!</strong> The new token has been saved to your database and is active.
      </div>
    <?php endif; ?>

    <?php if ($sendResult): ?>
      <?php if (!empty($sendResult['ok'])): ?>
        <div class="alert alert-success">
          <strong>🎉 Message Sent Successfully!</strong><br>
          Template: <code><?= htmlspecialchars($sendResult['template_used']); ?></code><br>
          Recipient: <code>+<?= htmlspecialchars($recipient); ?></code><br>
          Message ID (wamid): <code><?= htmlspecialchars($sendResult['wamid']); ?></code><br>
          <small>Check WhatsApp on your phone now!</small>
        </div>
      <?php else: ?>
        <div class="alert alert-warning">
          <strong>Send Result:</strong><br>
          <?= htmlspecialchars(isset($sendResult['error']) ? $sendResult['error'] : 'Error'); ?><br>
          <?php if (strpos(isset($sendResult['error']) ? $sendResult['error'] : '', '132001') !== false): ?>
            <p style="margin-top:.4rem;font-size:.82rem;">
              ⏳ <strong>Meta In-Review Notice:</strong> <code>tahsin_sealed_digest</code> (en) is the sealed-sentence template. It cannot be sent until Meta marks it APPROVED. The older <code>tahsin_daily_digest</code> body is the drill-count wording.<br>
              In the meantime, click <strong>"🚀 Test 'hello_world' Send"</strong> above to verify your live API connection.
            </p>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <div class="card">
    <h3 style="font-size:1.1rem;margin-bottom:.5rem;">📋 Meta Message Templates</h3>
    <p class="sub" style="margin-bottom:.75rem;">Live template status fetched directly from Meta Graph API:</p>
    <table>
      <thead>
        <tr>
          <th>Template Name</th>
          <th>Category</th>
          <th>Language</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($metaApiError)): ?>
          <tr><td colspan="4" style="text-align:center;color:#f87171;padding:1.5rem;">⚠️ <?= htmlspecialchars($metaApiError); ?></td></tr>
        <?php elseif (empty($templates)): ?>
          <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:1.5rem;">No templates found or could not reach Meta API.</td></tr>
        <?php else: ?>
          <?php foreach ($templates as $t): ?>
            <tr>
              <td><strong><?= htmlspecialchars($t['name']); ?></strong></td>
              <td><?= htmlspecialchars(isset($t['category']) ? $t['category'] : '—'); ?></td>
              <td><code><?= htmlspecialchars($t['language']); ?></code></td>
              <td>
                <?php if ($t['status'] === 'APPROVED'): ?>
                  <span class="badge badge-approved">Approved</span>
                <?php else: ?>
                  <span class="badge badge-pending"><?= htmlspecialchars($t['status']); ?></span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
