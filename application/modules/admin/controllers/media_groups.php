<?php

class Media_groups extends Admin_Login_Controller {

	function __construct() {
		parent::__construct();

		$this->load->library('form_validation');		

		// Load media_groups model.
		$this->load->model('Media_model', '', TRUE);

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

		// Load Media_group model.
		$total = $this->Media_model->count_media_groups();

		// Paging Initialize
		$config = configure_pagination_params( $this, 'admin/media_groups/manage/', $total );
		$this->pagination->initialize( $config );

		// Get Media_groups
		$data['media_groups'] = $this->Media_model->get_media_groups( $config['per_page'], $this->uri->segment(4) );

		$this->load->view('header');
		$this->load->view('media_groups/manage', $data); 
		$this->load->view('footer');	   
	}
	
	function add() {

		$data['custom_error'] = '';

		// Customize
		$this->form_validation->set_message('required',	'<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_error_delimiters('', '');

		if( $this->form_validation->run('media_group') == false ) {
			$data['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false );

		} else {
			$data = array(
				'name' => set_value('name')
			);

			if( $this->Media_model->add_media_group( $data ) == TRUE ) {
				redirect(base_url().'admin/media_groups/manage/');

			} else {
				$data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}		   

		$this->load->view('header');
		$this->load->view('media_groups/add', $data);   
		$this->load->view('footer');
	}	
	

	function edit() {

		// Customize
		$this->form_validation->set_message('required',	'<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_error_delimiters('', '');
	
		$data['custom_error'] = '';

		// Run validation first.
		if( $this->form_validation->run( 'media_group' ) == false ) {
			$data['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false);
	
		} else {
			$data = array(
				  'name' => $this->input->post('name')
			   );

			if( $this->Media_model->update_media_group( $this->input->post('id'), $data ) == TRUE ) {
				redirect( base_url().'admin/media_groups/manage/' );

			} else {
				$data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';			
			}

			print $this->db->last_query();
		}

		$data['media_group'] = $this->Media_model->get_media_group_by_id( $this->uri->segment(4) );

		// Load views
		$this->load->view( 'header' );
		$this->load->view( 'media_groups/edit', $data );
		$this->load->view( 'footer' );
	}
	
	function delete( ) {
		$id = $this->uri->segment(4);
		$this->Media_model->delete_media_group( $id );

		redirect(base_url().'admin/media_groups/manage/');
	}
}

/* End of file Media_group.php */
/* Location: ./system/application/controllers/Media_group.php */