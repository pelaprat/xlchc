<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
		$this->load->vars( $this->user_reputation_points );

		$this->load->model( 'Search_model', '', TRUE );
	}

	function index() {
		$data = array();
	}

	function results() {

		// If the query was empty, redirect to the search section's index page:
		if( $this->input->post('query') === FALSE || $this->input->post('query') === '' ) {
			redirect( 'search' );
		}

		// Grab search criteria
		$keywords = explode( '\s', $this->input->post('query') );

		// Symposia
		$data['symposia'] = $this->Search_model->search_symposia( $keywords );

		// Conversations
		$data['conversations'] = $this->Search_model->search_conversations( $keywords );

		$page = (object) array(
			'meta_title'		=> 'Search Results',
			'meta_description'	=> 'co-lchc search results',
			'meta_keywords'		=> 'co-lchc search results',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8',
			'title'				=> 'Search Results',
			'content'			=> '',
		);

		$data['page'] = $page;

		$this->load->view( 'search/results', $data );
	}
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
