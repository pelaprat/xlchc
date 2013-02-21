<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller{

    function __construct(){
    
        parent::__construct();
        $this->load->helper('url');
        
    }
    
    function _remap($method){
            
        $method = $this->uri->segment(1) != "site" ? $this->uri->segment(1) : $method;
        $method = "" == $method ? "index" : $method;
        
        $data = array();        
        
        switch($method){
            case "index":
                $data['body_content_class'] = 'index_content';
            case "about":
            case "people":
            case "publications":
            case "research":
            case "resources":
            case "insta_crud_lchc":
            
                ///set container CSS id and class values
                $data['body_id'] = $method;
                if(!isset($data['body_content_class'])) $data['body_content_class'] = 'inside_content';
                
                ///call individual methods corresponding to get URI for custom data handling
                eval('$this->' . $method . '($data);');
                
                break;
                
            default:
                $data['body_id'] = "page_not_found";
                $data['body_content_class'] = 'inside_content';
                $method = "page_not_found";
                
        }

        $this->load->view("view_header", $data);
        $this->load->view("view_$method", $data);
        $this->load->view("view_footer", $data);
        
    }


    function about(&$data){
        $this->load->model('Page_model', '', TRUE);
        $data['page'] = $this->Page_model->get_page_by_uri($this->uri->uri_string());
    }
    function research(&$data){
        $this->load->model('Page_model', '', TRUE);
        $data['page'] = $this->Page_model->get_page_by_uri($this->uri->uri_string());
    }
    function resources(&$data){
        $this->load->model('Page_model', '', TRUE);
        $data['page'] = $this->Page_model->get_page_by_uri($this->uri->uri_string());
    }
    function insta_crud_lchc(&$data){}


    function index(&$data){
    
        $this->load->model('Xmca_model', '', TRUE);
        $this->load->model('Spotlight_model', '', TRUE);
        $this->load->model('Xmca_model', '', TRUE);

        $data['discussions'] = $this->Xmca_model->getRecentThreadActivity();
        $data['rand_spotlight'] = $this->Spotlight_model->getRandomSpotlight();
        $data['all_spotlights'] = $this->Spotlight_model->getAllSpotlights();
                
    }
    
    function people(&$data){
            
        $this->load->model('People_model', '', TRUE);
        $data['people'] = $this->People_model->get_people();
        
    }
    
    function publications(&$data){

        $this->load->model('Publication_model', '', TRUE);
        $data['publications'] = $this->Publication_model->get_publications();
        
    }
    
}
?>