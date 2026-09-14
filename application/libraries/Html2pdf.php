<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/third_party/mpdf/autoload.php';

class Html2pdf
{
	public $mpdf;
    public function __construct()
    {
        $tempDir = FCPATH . 'uploads/temp/mpdf';
        if (!is_dir($tempDir)) {
            @mkdir($tempDir, 0777, true);
        }
        $this->mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_left' => 2,
            'margin_right' => 2,
            'margin_top' => 2,
            'margin_bottom' => 2,
            'format' => 'A4',
            'tempDir' => $tempDir,
        ]);
    }
}