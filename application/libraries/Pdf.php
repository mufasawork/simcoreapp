<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf {
  function __construct(){
    include_once BASEURL.'vendor/autoload.php';
  }
  function pdf(){
    $CI = & get_instance();
    log_message('Debug', 'mPDF class is loaded.');
 }
  function load($param=[]){
    return new \Mpdf\Mpdf($param);
  }
}
