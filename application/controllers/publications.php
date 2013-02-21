<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publications extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
		$this->load->vars( $this->user_reputation_points );
	}

	function index() {
		$data = array();
		$this->load->model('Page_model', '', TRUE);
		$this->load->model('Publication_model', '', TRUE);

		$publication_d	= $this->Publication_model->get_publications_with_authors( );
		$publications	= array();
		$authors		= array();
		foreach( $publication_d->result() as $publication ) {

			// Set publication data if none there
			isset( $publications[$publication->publication_id] ) ? 1 :
				$publications[$publication->publication_id] = $publication;

			if( isset( $authors[$publication->publication_id] )) {
				if( ! isset( $authors[$publication->publication_id][$publication->person_id] )) {
					// add author
					array_push( $authors[$publication->publication_id], $publication );
				}
			} else {
					$authors[$publication->publication_id] =
						array( $publication );
			}
		}

		$data['authors']		= $authors;
		$data['publications']	= $publications;
		$data['page']			= $this->Page_model->get_page_by_uri( $this->uri->uri_string()  );

		$data['o_page_sideboxes']	= true;
		$this->load->view( 'publications/index', $data );		
	}
}

/* End of file publications.php */
/* Location: ./application/controllers/publications.php */
