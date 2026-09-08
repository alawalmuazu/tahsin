<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// In production: hide all DB/SQL details — show branded friendly page only
$is_production = (defined('ENVIRONMENT') && ENVIRONMENT === 'production');

// Build base URL for assets
$base_url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://')
          . $_SERVER['HTTP_HOST']
          . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Unavailable — Tahsin Academy</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendor/bootstrap/css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a6b3c 0%, #0d4726 50%, #1a3a2a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .error-card {
            background: #fff;
            border-radius: 16px;
            max-width: 520px;
            width: 100%;
            padding: 48px 40px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            text-align: center;
        }
        .error-icon {
            width: 72px;
            height: 72px;
            background: #fff5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 32px;
        }
        .error-code {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #1a6b3c;
            margin-bottom: 12px;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 12px;
        }
        p.lead {
            color: #6b7280;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 32px;
        }
        .actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn-back {
            display: inline-block;
            padding: 11px 28px;
            background: #1a6b3c;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-back:hover { background: #145530; color: #fff; text-decoration: none; }
        .btn-reload {
            display: inline-block;
            padding: 11px 28px;
            background: #f3f4f6;
            color: #374151;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: background 0.2s;
        }
        .btn-reload:hover { background: #e5e7eb; }
        .ref-code {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
            font-size: 12px;
            color: #9ca3af;
        }

        /* Dev mode: show technical details in a collapsible block */
        .dev-details {
            margin-top: 24px;
            text-align: left;
            background: #1e1e2e;
            border-radius: 8px;
            padding: 16px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #a6e3a1;
            overflow-x: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }
        .dev-badge {
            display: inline-block;
            background: #f59e0b;
            color: #1a1a1a;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">⚠️</div>
        <div class="error-code">Tahsin Academy · System Error</div>
        <h1>Something went wrong</h1>
        <p class="lead">
            We couldn't complete your request due to a temporary system issue.
            Your data is safe — please try again in a moment or contact support
            if the problem persists.
        </p>
        <div class="actions">
            <button class="btn-reload" onclick="window.history.back()">← Go Back</button>
            <a href="<?php echo $base_url; ?>dashboard" class="btn-back">Dashboard</a>
        </div>



        <div class="ref-code">
            Reference: <?php echo date('Ymd-His'); ?> ·
            <a href="mailto:support@smartschool.edu.ng" style="color:#1a6b3c">Contact Support</a>
        </div>
    </div>
</body>
</html>