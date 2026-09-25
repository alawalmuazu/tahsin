<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * WhatsApp Business Cloud API (Meta Graph)
 *
 * Prefer School Settings → WhatsApp → “WhatsApp Business Cloud API”
 * (table whatsapp_cloud_config). This file is only a fallback when no DB row exists.
 *
 * Template tahsin_sealed_digest (en), body variables:
 *   {{1}} student name
 *   {{2}} teacher name
 *   {{3}} portion (category and ayah range)
 *   {{4}} Sealed by the director
 * Audio is a follow-up media message, not a body variable.
 * Meta will not edit a template while it is PENDING, so the old
 * tahsin_daily_digest body was left in review and this new name was submitted.
 */
$config['whatsapp'] = array(
    'enabled' => false,
    'access_token' => '',
    'phone_number_id' => '',
    'waba_id' => '',
    'api_version' => 'v21.0',
    'graph_base' => 'https://graph.facebook.com',
    'template_name' => 'tahsin_sealed_digest',
    'template_lang' => 'en',
    'send_media_after_template' => true,
    'media_max_per_student' => 3,
    'request_timeout' => 45,
);
