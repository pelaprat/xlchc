<?php

class Partner_projects extends Admin_Login_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');        
        $this->load->helper(array('form','url','codegen_helper'));
        $this->load->model('codegen_model','',TRUE);
    }

    function index() {
        $this->manage();
    }

    function manage(){

    	// Libraries 
        $this->load->library('pagination');

	// Configuration
	$this->load->helper('pagination_config');

        // Load partner_projects model.
        $this->load->model('Partner_projects_model', '', TRUE);
        $projects = $this->Partner_projects_model->get_partner_projects();

        // Paging Initialize
	$config = configure_pagination_params( $this, 'admin/partner_projects/manage/', $projects->num_rows() );
        $this->pagination->initialize( $config );

	// Set values.
        $data['projects'] = $projects;

        $this->load->view('header');
        $this->load->view('partner_projects/list', $data); 
        $this->load->view('footer');
    }
    
    function add() {

        $this->load->library('form_validation');    
        $data['custom_error'] = '';
        
        if ($this->form_validation->run('partner_projects') == false)
        {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } 
        else
        {                            
        
            $description = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('description')) : $this->input->post('description'));
            $description = html_entity_decode($description);
            
            $update = array(
                            'name' => $this->input->post('name'),
                            'description' => $description, 
                            'address' => $this->input->post('address'),
                            'country' => $this->input->post('country'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                            );
           
            if ($this->codegen_model->add('partner_projects',$update) == TRUE)
            {
                redirect(base_url().'admin/partner_projects/manage/');
            }
            else
            {
                $data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

            }
        }           
        
        $this->load->view('header');
        $this->load->view('partner_projects/add', $data);
        $this->load->view('footer');
    }    
    
    function edit(){        
        $this->load->library('form_validation');    
        $data['custom_error'] = '';
        
        if ($this->form_validation->run('partner_projects') == false)
        {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } 
        else
        {                           
        
            $description = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('description')) : $this->input->post('description'));
            $description = html_entity_decode($description);
            
            $update = array(
                            'name' => $this->input->post('name'),
                            'description' => $description, 
                            'address' => $this->input->post('address'),
                            'country' => $this->input->post('country'),
                            'latitude' => $this->input->post('latitude'),
                            'longitude' => $this->input->post('longitude')
                            );
           
            if ($this->codegen_model->edit('partner_projects',$update,'id',$this->input->post('id')) == TRUE)
            {
                redirect(base_url().'admin/partner_projects/manage/');
            }
            else
            {
                $data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

            }
        }

        $data['partner'] = $this->codegen_model->get('partner_projects',
                                                     'id,name,description,address,country,latitude,longitude',
                                                     'id = '. $this->uri->segment(4),
                                                     NULL,
                                                     NULL,
                                                     true);
        $this->load->view('header');
        $this->load->view('partner_projects/edit', $data);        
        $this->load->view('footer');
    }
    
    function delete(){
        $ID =  $this->uri->segment(4);
        $this->codegen_model->delete('partner_projects','id',$ID);             
        redirect(base_url().'admin/partner_projects/manage/');
    }
}