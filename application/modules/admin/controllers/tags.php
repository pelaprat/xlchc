<?php

class Tags extends Admin_Login_Controller {

	function __construct() {
		parent::__construct();

		$this->load->library('form_validation');		

		// Load tags model.
		$this->load->model('Tag_model', '', TRUE);

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

		// Load Tag model.
		$this->load->model('Tag_model', '', TRUE);
		$total = $this->Tag_model->num_tags();

		// Paging Initialize
		$dataonfig = configure_pagination_params( $this, 'admin/tags/manage/', $total );
		$this->pagination->initialize( $dataonfig );

		// Get Tags
		$data['tags'] = $this->Tag_model->get_all( $dataonfig['per_page'], $this->uri->segment(4) );

		$this->load->view('header');
		$this->load->view('tags/manage', $data); 
		$this->load->view('footer');	   
	}
	
	function add() {

		$data['custom_error'] = '';

		// Customize
		$this->form_validation->set_message('required',	'<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_error_delimiters('', '');

		if( $this->form_validation->run('tags') == false ) {
			$data['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false );

		} else {
			$data = array(
				'name' => set_value('name')
			);

			if( $this->Tag_model->add( $data ) == TRUE ) {
				redirect(base_url().'admin/tags/manage/');

			} else {
				$data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}		   

		$this->load->view('header');
		$this->load->view('tags/add', $data);   
		$this->load->view('footer');
	}	
	

	function edit() {

		// Customize
		$this->form_validation->set_message('required',	'<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_error_delimiters('', '');
	
		$data['custom_error'] = '';

		// Run validation first.
		if( $this->form_validation->run( 'tags' ) == false ) {
			$data['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false);
	
		} else {
			$data = array(
				  'name' => $this->input->post('name')
			   );

			if( $this->Tag_model->update( $this->input->post('id'), $data ) == TRUE ) {
				redirect( base_url().'admin/tags/manage/' );

			} else {
				$data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';			
			}
		}

		$data['tag'] = $this->Tag_model->get_tag_by_id( $this->uri->segment(4) );

		// Load views
		$this->load->view( 'header' );
		$this->load->view( 'tags/edit', $data );
		$this->load->view( 'footer' );
	}
	
	function delete( ) {
		$id = $this->uri->segment(4);
		$this->Tag_model->delete_all( $id );

		redirect(base_url().'admin/tags/manage/');
	}
}

/* End of file Tag.php */
/* Location: ./system/application/controllers/Tag.php */