<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School_fee_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function tableReady()
    {
        return $this->db->table_exists('school_fee_settings');
    }

    public function hasPwdDimension()
    {
        return $this->tableReady() && $this->db->field_exists('pwd_category_id', 'school_fee_settings');
    }

    public function hasOnlineAmount()
    {
        return $this->tableReady() && $this->db->field_exists('online_amount', 'school_fee_settings');
    }

    public function defaultFallback()
    {
        return defined('SCHOOL_FEE_AMOUNT') ? (float) SCHOOL_FEE_AMOUNT : 2500000.0;
    }

    /**
     * Resolve fee by Section × Programme Category × Student Category (PWD).
     * category_id = programme (With/Without Technical Skills).
     * pwd_category_id = Physically Fit / ALL / impairments.
     * $mode online uses the single online amount, not the campus matrix.
     */
    public function resolveAmount($branch_id, $section_id = 0, $category_id = 0, $pwd_category_id = 0, $mode = 'campus')
    {
        $branch_id = (int) $branch_id;
        $section_id = (int) $section_id;
        $category_id = (int) $category_id;
        $pwd_category_id = (int) $pwd_category_id;

        if ($mode === 'online') {
            return 0.0;
        }

        if (!$this->tableReady() || $branch_id <= 0) {
            return $this->defaultFallback();
        }

        if ($this->hasPwdDimension()) {
            $candidates = array(
                array($section_id, $category_id, $pwd_category_id),
                array($section_id, $category_id, 0),
                array($section_id, 0, $pwd_category_id),
                array($section_id, 0, 0),
                array(0, 0, 0),
            );
            foreach ($candidates as $pair) {
                $row = $this->db->get_where('school_fee_settings', array(
                    'branch_id' => $branch_id,
                    'section_id' => $pair[0],
                    'category_id' => $pair[1],
                    'pwd_category_id' => $pair[2],
                ))->row();
                if ($row && (float) $row->amount > 0) {
                    return (float) $row->amount;
                }
            }
            return $this->defaultFallback();
        }

        // Legacy 2D (section × category only)
        $candidates = array(
            array($section_id, $category_id),
            array($section_id, 0),
            array(0, $category_id),
            array(0, 0),
        );
        foreach ($candidates as $pair) {
            $row = $this->db->get_where('school_fee_settings', array(
                'branch_id' => $branch_id,
                'section_id' => $pair[0],
                'category_id' => $pair[1],
            ))->row();
            if ($row && (float) $row->amount > 0) {
                return (float) $row->amount;
            }
        }
        return $this->defaultFallback();
    }

    /**
     * Map: [pwd_category_id][section_id][programme_category_id] => amount
     */
    public function getMap($branch_id)
    {
        $map = array();
        if (!$this->tableReady()) {
            return $map;
        }
        $rows = $this->db->where('branch_id', (int) $branch_id)->get('school_fee_settings')->result();
        foreach ($rows as $row) {
            $pwd = $this->hasPwdDimension() ? (int) $row->pwd_category_id : 0;
            $map[$pwd][(int) $row->section_id][(int) $row->category_id] = (float) $row->amount;
        }
        return $map;
    }

    public function getDefaultAmount($branch_id)
    {
        return $this->resolveAmount($branch_id, 0, 0, 0);
    }

    public function onlineAmount($branch_id)
    {
        if (!$this->hasOnlineAmount() || (int) $branch_id <= 0) {
            return 0.0;
        }
        $row = $this->db->get_where('school_fee_settings', $this->defaultWhere($branch_id))->row();
        if (!$row || !isset($row->online_amount)) {
            return 0.0;
        }
        return (float) $row->online_amount;
    }

    public function saveOnlineAmount($branch_id, $amount)
    {
        $branch_id = (int) $branch_id;
        if (!$this->hasOnlineAmount() || $branch_id <= 0) {
            return false;
        }
        $amount = (float) $amount;
        if ($amount < 0) {
            $amount = 0;
        }
        $where = $this->defaultWhere($branch_id);
        $existing = $this->db->get_where('school_fee_settings', $where)->row();
        if ($existing) {
            $this->db->where('id', $existing->id)->update('school_fee_settings', array('online_amount' => $amount));
            return true;
        }
        $insert = $where;
        $insert['amount'] = $this->getDefaultAmount($branch_id);
        $insert['online_amount'] = $amount;
        $this->db->insert('school_fee_settings', $insert);
        return true;
    }

    protected function defaultWhere($branch_id)
    {
        $where = array(
            'branch_id' => (int) $branch_id,
            'section_id' => 0,
            'category_id' => 0,
        );
        if ($this->hasPwdDimension()) {
            $where['pwd_category_id'] = 0;
        }
        return $where;
    }

    /**
     * $matrix[pwd_category_id][section_id][programme_category_id] = amount
     */
    public function saveMatrix($branch_id, $default_amount, $matrix)
    {
        $branch_id = (int) $branch_id;
        if (!$this->tableReady() || $branch_id <= 0) {
            return false;
        }

        $this->upsert($branch_id, 0, 0, 0, $default_amount);

        if (!is_array($matrix)) {
            return true;
        }
        foreach ($matrix as $pwd_id => $sections) {
            if (!is_array($sections)) {
                continue;
            }
            foreach ($sections as $section_id => $cats) {
                if (!is_array($cats)) {
                    continue;
                }
                foreach ($cats as $category_id => $amount) {
                    $section_id = (int) $section_id;
                    $category_id = (int) $category_id;
                    $pwd_id = (int) $pwd_id;
                    if ($section_id <= 0 || $category_id <= 0 || $pwd_id <= 0) {
                        continue;
                    }
                    $this->upsert($branch_id, $section_id, $category_id, $pwd_id, $amount);
                }
            }
        }
        return true;
    }

    protected function upsert($branch_id, $section_id, $category_id, $pwd_category_id, $amount)
    {
        $amount = (float) $amount;
        if ($amount < 0) {
            $amount = 0;
        }
        $where = array(
            'branch_id' => (int) $branch_id,
            'section_id' => (int) $section_id,
            'category_id' => (int) $category_id,
        );
        if ($this->hasPwdDimension()) {
            $where['pwd_category_id'] = (int) $pwd_category_id;
        }
        $existing = $this->db->get_where('school_fee_settings', $where)->row();
        if ($existing) {
            $this->db->where('id', $existing->id)->update('school_fee_settings', array('amount' => $amount));
            return;
        }
        $insert = $where;
        $insert['amount'] = $amount;
        if (!$this->hasPwdDimension()) {
            unset($insert['pwd_category_id']);
        }
        $this->db->insert('school_fee_settings', $insert);
    }

    public function pricesReady()
    {
        return $this->db->table_exists('online_fee_price');
    }

    public function currencies()
    {
        return array(
            'NGN' => 'Nigeria (Abuja and other online)',
            'USD' => 'United States',
            'GBP' => 'United Kingdom',
            'EUR' => 'Europe',
            'AED' => 'Gulf',
            'CAD' => 'Canada',
        );
    }

    public function currencyFor($country, $timezone)
    {
        $place = strtolower(trim((string) $country));
        $place = preg_replace('/[^a-z ]/', ' ', $place);
        $place = trim(preg_replace('/\s+/', ' ', $place));
        $phrases = array(
            'united kingdom' => 'GBP',
            'great britain' => 'GBP',
            'england' => 'GBP',
            'scotland' => 'GBP',
            'wales' => 'GBP',
            'london' => 'GBP',
            'united states' => 'USD',
            'america' => 'USD',
            'canada' => 'CAD',
            'united arab emirates' => 'AED',
            'emirates' => 'AED',
            'dubai' => 'AED',
            'saudi' => 'AED',
            'qatar' => 'AED',
            'kuwait' => 'AED',
            'bahrain' => 'AED',
            'oman' => 'AED',
            'gulf' => 'AED',
            'nigeria' => 'NGN',
            'abuja' => 'NGN',
            'kano' => 'NGN',
            'lagos' => 'NGN',
            'germany' => 'EUR',
            'france' => 'EUR',
            'spain' => 'EUR',
            'italy' => 'EUR',
            'netherlands' => 'EUR',
            'belgium' => 'EUR',
            'austria' => 'EUR',
            'portugal' => 'EUR',
            'ireland' => 'EUR',
            'europe' => 'EUR',
        );
        $exact = array(
            'uk' => 'GBP',
            'usa' => 'USD',
            'us' => 'USD',
            'uae' => 'AED',
        );
        if (isset($exact[$place])) {
            return $exact[$place];
        }
        foreach ($phrases as $needle => $code) {
            if ($place === $needle || strpos($place, $needle) !== false) {
                return $code;
            }
        }
        $zones = array(
            'Africa/Lagos' => 'NGN',
            'Europe/London' => 'GBP',
            'Europe/Paris' => 'EUR',
            'Europe/Berlin' => 'EUR',
            'America/New_York' => 'USD',
            'America/Chicago' => 'USD',
            'America/Denver' => 'USD',
            'America/Los_Angeles' => 'USD',
            'Asia/Dubai' => 'AED',
        );
        if (isset($zones[$timezone])) {
            return $zones[$timezone];
        }
        return 'USD';
    }

    public function getPrices($branch_id)
    {
        $out = array();
        foreach ($this->currencies() as $code => $label) {
            $out[$code] = 0.0;
        }
        if (!$this->pricesReady() || (int) $branch_id <= 0) {
            return $out;
        }
        $rows = $this->db->get_where('online_fee_price', array('branch_id' => (int) $branch_id))->result();
        foreach ($rows as $row) {
            $code = strtoupper($row->currency);
            if (isset($out[$code])) {
                $out[$code] = (float) $row->amount;
            }
        }
        return $out;
    }

    public function savePrices($branch_id, $amounts)
    {
        $branch_id = (int) $branch_id;
        if (!$this->pricesReady() || $branch_id <= 0 || !is_array($amounts)) {
            return false;
        }
        foreach ($this->currencies() as $code => $label) {
            $amount = isset($amounts[$code]) ? (float) $amounts[$code] : 0;
            if ($amount < 0) {
                $amount = 0;
            }
            $existing = $this->db->get_where('online_fee_price', array(
                'branch_id' => $branch_id,
                'currency' => $code,
            ))->row();
            if ($existing) {
                $this->db->where('id', $existing->id)->update('online_fee_price', array('amount' => $amount));
            } else {
                $this->db->insert('online_fee_price', array(
                    'branch_id' => $branch_id,
                    'currency' => $code,
                    'amount' => $amount,
                ));
            }
        }
        return true;
    }

    public function quoteOnline($branch_id, $country, $timezone)
    {
        $currency = $this->currencyFor($country, $timezone);
        $names = $this->currencies();
        $label = isset($names[$currency]) ? $names[$currency] : $currency;
        $foreign = 0.0;
        if ($this->pricesReady()) {
            $prices = $this->getPrices($branch_id);
            $foreign = isset($prices[$currency]) ? (float) $prices[$currency] : 0.0;
        }
        $rate = ($foreign > 0) ? $this->nairaPerUnit($currency) : 0.0;
        $naira = ($foreign > 0 && $rate > 0) ? round($foreign * $rate, 2) : 0.0;
        $error = '';
        $text = '';
        if (!$this->pricesReady()) {
            $error = 'Run application/migrations/online_fee_currency.sql before admitting an online student.';
        } elseif ($foreign <= 0) {
            $error = 'Set the ' . $currency . ' online fee under Settings, School Fees.';
        } elseif ($rate <= 0) {
            $error = 'The current ' . $currency . ' rate to naira could not be loaded. Try again.';
        } else {
            $text = $currency . ' ' . number_format($foreign, 2, '.', ',') . ' × ' . number_format($rate, 2, '.', ',') . ' (' . $label . ', current rate to naira)';
        }
        return array(
            'currency' => $currency,
            'foreign' => $foreign,
            'rate' => $rate,
            'naira' => $naira,
            'text' => $text,
            'error' => $error,
            'label' => $label,
        );
    }

    public function rateBoard()
    {
        $fx = $this->fxRates();
        $when = 0;
        $path = APPPATH . 'cache/fx_usd.json';
        if (is_file($path)) {
            $decoded = json_decode((string) @file_get_contents($path), true);
            if (is_array($decoded) && isset($decoded['fetched_at'])) {
                $when = (int) $decoded['fetched_at'];
            }
        }
        $rates = array();
        foreach ($this->currencies() as $code => $label) {
            if ($code === 'NGN') {
                $rates[$code] = 1.0;
                continue;
            }
            if (empty($fx['NGN']) || empty($fx[$code]) || (float) $fx[$code] <= 0) {
                $rates[$code] = 0.0;
                continue;
            }
            $rates[$code] = (float) $fx['NGN'] / (float) $fx[$code];
        }
        return array(
            'rates' => $rates,
            'fetched_at' => $when,
            'ok' => !empty($fx['NGN']),
        );
    }

    public function nairaPerUnit($currency)
    {
        $currency = strtoupper(trim((string) $currency));
        if ($currency === 'NGN') {
            return 1.0;
        }
        $rates = $this->fxRates();
        if (empty($rates['NGN']) || empty($rates[$currency]) || (float) $rates[$currency] <= 0) {
            return 0.0;
        }
        return (float) $rates['NGN'] / (float) $rates[$currency];
    }

    protected function fxRates()
    {
        $path = APPPATH . 'cache/fx_usd.json';
        $cached = array();
        if (is_file($path)) {
            $decoded = json_decode((string) file_get_contents($path), true);
            if (is_array($decoded) && !empty($decoded['rates'])) {
                $cached = $decoded;
                $age = time() - (int) (isset($decoded['fetched_at']) ? $decoded['fetched_at'] : 0);
                if ($age >= 0 && $age < 6 * 3600) {
                    return $decoded['rates'];
                }
            }
        }
        $body = $this->httpGet('https://open.er-api.com/v6/latest/USD');
        $json = $body ? json_decode($body, true) : null;
        if (is_array($json) && !empty($json['rates']['NGN'])) {
            $payload = array('fetched_at' => time(), 'rates' => $json['rates']);
            @file_put_contents($path, json_encode($payload));
            return $json['rates'];
        }
        return !empty($cached['rates']) ? $cached['rates'] : array();
    }

    protected function httpGet($url)
    {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 8,
                CURLOPT_CONNECTTIMEOUT => 5,
            ));
            $body = curl_exec($ch);
            curl_close($ch);
            return is_string($body) ? $body : '';
        }
        $context = stream_context_create(array('http' => array('timeout' => 8)));
        $body = @file_get_contents($url, false, $context);
        return is_string($body) ? $body : '';
    }
}
