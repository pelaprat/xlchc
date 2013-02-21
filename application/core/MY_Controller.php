<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  MY_Controller  extends  CI_Controller  {
    function __construct(){
        parent::__construct();
    }
}

include APPPATH . 'core/Admin_Login_Controller.php';