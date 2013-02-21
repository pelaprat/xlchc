<?php

class Xgroups extends Admin_Login_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');        
        $this->load->helper(array('form','url','codegen_helper'));
        $this->load->model('codegen_model','',TRUE);
    }    
    
    function index(){
        $this->manage();
    }

    function manage() {

        $data = array();

    	// Libraries
	$this->load->library('table');
        $this->load->library('pagination');

	// Configuration
	$this->load->helper('pagination_config');

        // Load Xgroup model.
        $this->load->model('Xgroup_model', '', TRUE);
        $total = $this->Xgroup_model->count();

        // Paging Initialize
	$config = configure_pagination_params( $this, 'admin/xgroups/manage/', $total );
        $this->pagination->initialize( $config );

        // Get Xgroups
        $data['xgroups'] = $this->Xgroup_model->get_xgroups( $config['per_page'], $this->uri->segment(4));

        $this->load->view('header');
        $this->load->view('xgroups/manage', $data); 
        $this->load->view('footer');       
    }
    
    function add() {

        $this->load->library('form_validation');    
        $c['custom_error'] = '';

        // Customize
        $this->form_validation->set_message('required',    '<span class="validate_error">Validation failed!</span>');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run('xgroups') == false)
        {
             $c['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false);

        } else {                            
            $data = array(
                    'name' => set_value('name')
            );
           
            if ($this->codegen_model->add('xgroups',$data) == TRUE)
            {
                //$c['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
                // or redirect
                redirect(base_url().'admin/xgroups/manage/');
            }
            else
            {
                $c['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

            }
        }           

        $this->load->view('header');
        $this->load->view('xgroups/add', $c);   
        $this->load->view('footer');
    }    
    

    function edit() {

        $this->load->library('form_validation');    

        // Load xgroups model.
        $this->load->model('Xgroup_model', '', TRUE);
    
        // Customize
        $this->form_validation->set_message('required',    '<span class="validate_error">Validation failed!</span>');
        $this->form_validation->set_error_delimiters('', '');
    
        $c['custom_error'] = '';

        // Run validation first.
        if( $this->form_validation->run('xgroups') == false )
        {
            $c['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false);
    
        } else {                            

            $data = array(
                  'name' => $this->input->post('name')
               );
               
            if ($this->codegen_model->edit('xgroups',$data,'id',$this->input->post('id')) == TRUE) {
                redirect(base_url().'admin/xgroups/manage/');
            
            } else {
                $c['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';
            
            }
        }

        $c['xgroup'] = $this->Xgroup_model->get_xgroups_by_id( $this->uri->segment(4) );
        
        // Load views
        $this->load->view('header');
        $this->load->view('xgroups/edit', $c);
        $this->load->view('footer');
    }
    
    function delete(){
        $ID =  $this->uri->segment(4);
        $this->codegen_model->delete('xgroups','id',$ID);             
        redirect(base_url().'admin/xgroups/manage/');
    }
    
}

/* End of file Xgroup.php */
/* Location: ./system/application/controllers/Xgroup.php */