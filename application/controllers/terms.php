<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
		$this->load->vars( $this->user_reputation_points );
	}

	function index()
	{
		$c = array();
		$this->load->model('Page_model', '', TRUE);

		$c['page'] = $this->Page_model->get_page_by_uri($this->uri->uri_string()  );

		$this->load->view( strtolower( get_class($this) ).'/index', $c );
	}
}

/* End of file terms.php */
/* Location: ./application/controllers/terms.php */
