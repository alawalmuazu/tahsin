<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * WhatsApp Business Cloud API (Meta Graph)
 *
 * Prefer School Settings → WhatsApp → “WhatsApp Business Cloud API”
 * (table whatsapp_cloud_config). This file is only a fallback when no DB row exists.
 *
 * Template body variables (order must match your Meta-approved template):
 *   {{1}} student name
 *   {{2}} date
 *   {{3}} short summary (drills / tahfiz)
 *   {{4}} first media URL (or "—" if none)
 */
$config['whatsapp'] = array(
    'enabled' => false,
    'access_token' => '',
    'phone_number_id' => '',
    'waba_id' => '',
    'api_version' => 'v21.0',
    'graph_base' => 'https://graph.facebook.com',
    'template_name' => 'tahsin_daily_digest',
    'template_lang' => 'en',
    'send_media_after_template' => true,
    'media_max_per_student' => 3,
    'request_timeout' => 45,
);
