<?php

class Pages extends Admin_Login_Controller {
    
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

    	// Libraries 
        $this->load->library('table');
        $this->load->library('pagination');

	// Configuration
	$this->load->helper('pagination_config');

        // Load page model.
        $this->load->model('Page_model', '', TRUE);
        $total = $this->Page_model->count_pages();

        // Paging Initialize
	$config = configure_pagination_params( $this, 'admin/pages/manage/', $total );
        $this->pagination->initialize( $config );

        // Get Pages.
        $data['pages'] = $this->Page_model->get_pages( $config['per_page'], $this->uri->segment(4) );

        $this->load->view('header');
        $this->load->view('pages/list', $data); 
        $this->load->view('footer');
    }
    
    function add() {

        // Libraries
        $this->load->library('form_validation');    

	// Config
    	$config['compress_output'] = FALSE;
        $data['custom_error']      = '';

        if ($this->form_validation->run('pages') == false) {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

	} else {
            $content = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('content')) : $this->input->post('content'));

            $update  = array( 'uri' => $this->input->post('uri'),
                              'meta_title' => $this->input->post('meta_title'),
                              'meta_description' => $this->input->post('meta_description'),
                              'meta_keywords' => $this->input->post('meta_keywords'),
                              'meta_language' => $this->input->post('meta_language'),
                              'meta_content_type' => $this->input->post('meta_content_type'),
                              'title' => $this->input->post('title'),
                              'content' => $content 
                           );
                           
            $this->load->model('Page_model', '', TRUE);
            $this->Page_model->add($update);
            
            redirect(base_url().'admin/pages/manage/');
        }           

        $this->load->view('header');
        $this->load->view('pages/add', $data);
        $this->load->view('footer');

    }    
    
    function edit() {

        // Libraries
        $this->load->library('form_validation');    

        // Load people model.
        $this->load->model('Sidebox_model', '', TRUE);
        $this->load->model('Page_model', '', TRUE);

        $data['custom_error'] = '';

        if ($this->form_validation->run('pages') == false) {
             $data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else {

            $content = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('content')) : $this->input->post('content'));
            $update  = array( 'uri' => $this->input->post('uri'),
                              'meta_title' => $this->input->post('meta_title'),
                              'meta_description' => $this->input->post('meta_description'),
                              'meta_keywords' => $this->input->post('meta_keywords'),
                              'meta_language' => $this->input->post('meta_language'),
                              'meta_content_type' => $this->input->post('meta_content_type'),
                              'title' => $this->input->post('title'),
                              'content' => $content 
                           );

            $this->Page_model->updateById($this->input->post('id'), $update);

	     ////////////////////////////
	     // Function get the groups
	     // From the $_POST
	     $func = function($k) {
	             	  if( preg_match('/^select-sidebox_(\d+)/', $k ) ) {
			        return $_POST[$k];
			  }
		       };

	     $a = array_map( $func, array_keys($_POST) );
	     $v = array_unique($a);
	     unset( $v[0] );

	     ////////////////////////////////////////
	     // Delete the sidebox for this person. 
	     $this->Page_model->db->where('page_id', $this->input->post('id'));
	     $this->Page_model->db->delete('join_pages_sideboxes');

	     ///////////////////////////////////////////
	     // Insert the new groups for this person.
	     foreach( $v as $gid ) {
   	        $d = array( 'sidebox_id' => $gid,
	             	    'page_id'    => $this->input->post('id'),
			    'id'         => 'NULL'  );

	       	$this->Page_model->db->insert( 'join_pages_sideboxes', $d );
	     }
        }

	////////////////////////////////////
	// Get the page data for this page.
        $data['page'] = $this->codegen_model->get('pages',
                                                  'id,uri,meta_title,meta_description,meta_keywords,meta_language,meta_content_type,title,content',
                                                  'id = '. $this->uri->segment(4) ,
                                                  NULL,
                                                  NULL,
                                                  true);

	////////////////////////////
	// Prepare the menu data. //
	$sideboxes = $this->Sidebox_model->get_sideboxes();
	$sideboxmd = array();
	foreach( $sideboxes->result() as $sidebox ) {
	    $a = array( 'id'    => $sidebox->id,
	       	 	'value' => $sidebox->title );
	    array_push( $sideboxmd, $a );
	}

	$data['sidebox_menu_data'] = $sideboxmd;

	/////////////////////////////
	// Get this page's sideboxes
	$data['sideboxes'] = $this->Page_model->get_page_sideboxes( $this->uri->segment(4) );

        $this->load->view('header');
        $this->load->view('pages/edit', $data);
        $this->load->view('footer');
    }
    
    function delete(){
        $ID =  $this->uri->segment(4);
        $this->codegen_model->delete('pages','id',$ID);             
        redirect(base_url().'admin/pages/manage/');
    }
}
