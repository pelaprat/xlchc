<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Login_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data = array();

        $this->load->view( 'index', $data );
    }

    function demo(){
        $data = array();

        $this->load->view( 'demo', $data );
    }

}