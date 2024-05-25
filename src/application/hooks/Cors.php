<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cors {
  public function enableCors() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token");

    $CI =& get_instance();

    $method = $CI->input->server('REQUEST_METHOD');
    
    if ($method == "OPTIONS") {
      die();
    }
  }
}
