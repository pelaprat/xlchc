<?php

class Slides extends Admin_Login_Controller {
    
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
        $this->load->model('Slides_model', '', TRUE);
        $total = $this->Slides_model->count_slides();

        // Paging Initialize
	$config = configure_pagination_params( $this, 'admin/slides/manage/', $total );
        $this->pagination->initialize( $config );

        // Get Slides.
        $data['slides'] = $this->Slides_model->get_slides();
        
        $this->load->view('header');
        $this->load->view('slides/list', $data); 
        $this->load->view('footer');
    }

    function add(){        
        $this->load->library('form_validation');    
        $data['custom_error'] = '';
        
        if ($this->form_validation->run('slides') == false) {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else {

            $caption = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('caption')) : $this->input->post('caption'));
            $update  = array( 
                             'image'   => $this->input->post('image'),
                             'caption' => $caption,
	  		     'url'     => $this->input->post('url')
                            );
                           
            $this->load->model('Slides_model', '', TRUE);
            $this->Slides_model->add($update);
            
            redirect(base_url().'admin/slides/manage/');
        }           
        $this->load->view('header');
        $this->load->view('slides/add', $data);   
        $this->load->view('footer'); 
    }    
    

    function edit(){        
        $this->load->library('form_validation');    
        $data['custom_error'] = '';
        
        if ($this->form_validation->run('slides') == false) {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else {

            $caption = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('caption')) : $this->input->post('caption'));
            $update  = array( 
                              'image'   => $this->input->post('image'),
                              'caption' => $caption,
			      'url'     => $this->input->post('url')
                            );

            $this->load->model('Slides_model', '', TRUE);
            $this->Slides_model->updateById($this->input->post('id'), $update);
        }

        $data['slides'] = $this->codegen_model->get('slides',
                                                       'id,image,caption,url',
                                                       'id = '.$this->uri->segment(4),
                                                       NULL,
                                                       NULL,
                                                       true);
        $this->load->view('header');
        $this->load->view('slides/edit', $data);
        $this->load->view('footer');
    }
    
    function delete(){
        $ID =  $this->uri->segment(4);
        $this->codegen_model->delete('slides','id',$ID);             
        redirect(base_url().'admin/slides/manage/');
    }
}