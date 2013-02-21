<?php

class Sideboxes extends Admin_Login_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');        
        $this->load->helper(array('form','url','codegen_helper'));
        $this->load->model('codegen_model','',TRUE);
    }    
    
    function index(){
        $this->manage();
    }

    function manage(){
    
        $data = array();

    	// Libraries
        $this->load->library('pagination');

	// Configuration
	$this->load->helper('pagination_config');

        // Load people model.
        $this->load->model('Sidebox_model', '', TRUE);
        $total = $this->Sidebox_model->count_sideboxes();

        // Paging Initialize
	$config = configure_pagination_params( $this, 'admin/sideboxes/manage/', $total );
        $this->pagination->initialize( $config );

        // Get Sideboxes.
        $data['sideboxes'] = $this->Sidebox_model->get_sideboxes();
        
        $this->load->view('header');
        $this->load->view('sideboxes/list', $data); 
        $this->load->view('footer');
    }

    function add(){        
        $this->load->library('form_validation');    
        $data['custom_error'] = '';
        
        if ($this->form_validation->run('sideboxes') == false) {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else {

            $title   = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('title'))   : $this->input->post('title'));
            $content = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('content')) : $this->input->post('content'));

            $update  = array( 
                             'title'   => $title,
	  		     'content' => $content
                            );
                           
            $this->load->model('Sidebox_model', '', TRUE);
            $this->Sidebox_model->add($update);
            
            redirect(base_url().'admin/sideboxes/manage/');
        }           
        $this->load->view('header');
        $this->load->view('sideboxes/add', $data);   
        $this->load->view('footer'); 
    }    
    
    function edit(){        
        $this->load->library('form_validation');    
        $data['custom_error'] = '';
        
        if ($this->form_validation->run('sideboxes') == false) {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else {

            $title   = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('title'))   : $this->input->post('title'));
            $content = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('content')) : $this->input->post('content'));

            $update  = array( 
                              'title'   => $title,
			      'content' => $content
                            );

            $this->load->model('Sidebox_model', '', TRUE);
            $this->Sidebox_model->updateById($this->input->post('id'), $update);
        }

        $data['sideboxes'] = $this->codegen_model->get('sideboxes',
                                                       'id,title,content',
                                                       'id = '.$this->uri->segment(4),
                                                       NULL,
                                                       NULL,
                                                       true);
        $this->load->view('header');
        $this->load->view('sideboxes/edit', $data);
        $this->load->view('footer');
    }
    
    function delete(){
        $ID =  $this->uri->segment(4);
        $this->codegen_model->delete('sideboxes','id',$ID);             
        redirect(base_url().'admin/sideboxes/manage/');
    }
}