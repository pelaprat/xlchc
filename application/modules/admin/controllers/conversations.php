<?php

class Conversations extends Admin_Login_Controller {

	function __construct() {
		parent::__construct();

		$this->load->library('form_validation');

		// Load conversations model.
		$this->load->model('Conversation_model', '', TRUE);

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

		// Load Conversation model.
		$this->load->model('Conversation_model', '', TRUE);
		$total = $this->Conversation_model->num_conversations();

		// Paging Initialize
		$config = configure_pagination_params( $this, 'admin/conversations/manage/', $total );
		$this->pagination->initialize( $config );

		// Get Conversations
		$data['conversations'] = $this->Conversation_model->get_all( FALSE, $config['per_page'], $this->uri->segment(4) );

		$this->load->view('header');
		$this->load->view('conversations/manage', $data); 
		$this->load->view('footer');	   
	}

	function edit() {

		// Customize
		$this->form_validation->set_message('required',	'<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_error_delimiters('', '');
	
		$data['custom_error'] = '';

		// Run validation first.
		if( $this->form_validation->run( 'conversations' ) == false ) {
			$data['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false);
	
		} else {
			$data = array(
				  'subject' => $this->input->post('subject')
			   );

			if( $this->Conversation_model->update( $this->input->post('id'), $data ) == TRUE ) {
				redirect( base_url().'admin/conversations/manage/' );

			} else {
				$data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';			
			}
		}

		$data['conversation'] = $this->Conversation_model->get_conversation_by_id( $this->uri->segment(4) );

		// Load views
		$this->load->view( 'header' );
		$this->load->view( 'conversations/edit', $data );
		$this->load->view( 'footer' );
	}
	
	function delete( ) {
		$id = $this->uri->segment(4);
		$this->Conversation_model->delete( $id );

		redirect(base_url().'admin/conversations/manage/');
	}
}

/* End of file Conversation.php */
/* Location: ./system/application/controllers/Conversation.php */