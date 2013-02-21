<?php

class Spotlight extends Admin_Login_Controller {
    
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
        $this->load->model('Spotlight_model', '', TRUE);
        $total = $this->Spotlight_model->count_spotlights();

        // Paging Initialize
	$config = configure_pagination_params( $this, 'admin/spotlight/manage/', $total );
        $this->pagination->initialize( $config );

        // Get Spotlights.
        $data['spotlights'] = $this->Spotlight_model->get_spotlights();
        
        $this->load->view('header');
        $this->load->view('spotlight/list', $data); 
        $this->load->view('footer');
    }
    
    function add(){        
        $this->load->library('form_validation');    
        $data['custom_error'] = '';
        
        if ($this->form_validation->run('spotlight') == false)
        {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } 
        else
        {                            

            $description = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('description')) : $this->input->post('description'));

            $update = array( 
                            'title' => $this->input->post('title'),
                            'description' => $description
                           );
                           
            $this->load->model('Spotlight_model', '', TRUE);
            $this->Spotlight_model->add($update);
            
            redirect(base_url().'admin/spotlight/manage/');
        }           
        $this->load->view('header');
        $this->load->view('spotlight/add', $data);   
        $this->load->view('footer'); 
    }    
    
    function edit(){        
        $this->load->library('form_validation');    
        $data['custom_error'] = '';
        
        if ($this->form_validation->run('spotlight') == false)
        {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } 
        else
        {                            
            $description = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('description')) : $this->input->post('description'));

            $update = array( 
                            'title' => $this->input->post('title'),
                            'description' => $description
                           );
                           
            $this->load->model('Spotlight_model', '', TRUE);
            $this->Spotlight_model->updateById($this->input->post('id'), $update);
        }

        $data['spotlight'] = $this->codegen_model->get('spotlight',
                                                       'id,title,description',
                                                       'id = '.$this->uri->segment(4),
                                                       NULL,
                                                       NULL,
                                                       true);
        $this->load->view('header');
        $this->load->view('spotlight/edit', $data);
        $this->load->view('footer');
    }
    
    function delete(){
        $ID =  $this->uri->segment(4);
        $this->codegen_model->delete('spotlight','id',$ID);             
        redirect(base_url().'admin/spotlight/manage/');
    }
}