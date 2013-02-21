<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Login_Controller extends MY_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->library('session');
        $this->load->helper('url');

        if( isset($_GET['logout']) ){
            $this->session->sess_destroy();
            redirect("admin/login", "location");
            return;
        }

        if($this->session->userdata('admin-user-info')) return;

        $errors = array();
        $email = isset($_POST['email']) ? trim($_POST['email']) : "";
        $password = isset($_POST['password']) ? trim($_POST['password']) : "";
        
        if("" === $email) array_push($errors, "noe");
        if("" === $password) array_push($errors, "nop");
        
        if("" != $email){    
            $this->load->model('People_model', '', TRUE);
            //$p = $this->People_model->get_people_by_email($email);
            $p = $this->People_model->get_people_table_only_by_email($email);
            
            if(null == $p){
                array_push($errors, "bademail");
            }
            else if("" != $password){
                $pwHash = sha1($p->pw_salt . $_POST['password']);
    
                if($pwHash !== $p->pw_hash){
                    array_push($errors, "nomatch");
                }
                else{
                    $p->pw_salt = ""; $p->pw_hash = "";
                    $this->session->set_userdata('admin-user-info', $p);
                    return;
                }
            }
        }
        
        $redirectURL = "admin/login?from=" . str_replace('admin/', '', uri_string()) . 
                       "&errors=" . implode(",", $errors) .
                       "&email=" . urlencode($email);
                       
        redirect($redirectURL, "location");
    }
}

?>