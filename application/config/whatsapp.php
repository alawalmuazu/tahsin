<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * WhatsApp Business Cloud API (Meta Graph)
 *
 * Prefer School Settings → WhatsApp → “WhatsApp Business Cloud API”
 * (table whatsapp_cloud_config). This file is only a fallback when no DB row exists.
 *
 * Template tahsin_sealed_digest (en) — match Meta labels:
 *   {{1}} Student
 *   {{2}} Date
 *   {{3}} Recitation / portion
 *   {{4}} Media note (teacher + audio follows)
 * Audio is a follow-up media message, not a body variable.
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
    // DOCUMENT-header utility template (in-chat clip). Falls back to body URL if PENDING.
    'template_with_media' => 'tahsin_digest_with_audio',
    'request_timeout' => 45,
    // Hostinger Cloud PHP often lacks ffmpeg — convert WAV via VPS then upload MP3 to Meta
    'media_convert_url' => 'http://72.62.232.120:8002/v1/media/to-mp3',
);
