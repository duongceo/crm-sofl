<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
//class Pdf extends TCPDF
//{
//    function __construct()
//    {
//        parent::__construct();
//    }
//}

class pdf {

    function pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }

    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/mpdf/mpdf.php';

        $param = "'','', 0, '', 0, 0, 0, 0, 0, 0";

        return new mPDF($param);

//        $mpdf = new mPDF(['mode' => 'utf-8']);
//
//        return $mpdf;
    }
}