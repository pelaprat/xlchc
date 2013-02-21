<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
		$this->load->vars( $this->user_reputation_points );
	}

	function index() {
		$c = array();
		$this->load->model('Page_model', '', TRUE);

		$c['page'] = $this->Page_model->get_page_by_uri( $this->uri->uri_string() );

		$this->load->view( strtolower( get_class($this) ).'/index', $c );
	}

	function community() {
		$data['page'] = (object) array(
			'meta_title'		=> 'Community Information',
			'meta_description'	=> 'co-lchc community',
			'meta_keywords'		=> 'co-lchc community',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8'
		);

		$data['o_page_sideboxes']	= true;

        $this->load->view( 'about/community', $data );		
	}
}

/* End of file about.php */
/* Location: ./application/controllers/about.php */
