<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	var $current_user;
	var $user_reputation_points;

    function __construct()
    {
        parent::__construct();

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
		$this->load->vars( $this->user_reputation_points );

        // Default controller redirect:
        if( $this->uri->segment(1) === FALSE ) {
            redirect('home');
        }
    }

    function _remap($method) {
        $method = $this->uri->segment(1) != "home" ? $this->uri->segment(1) : $method;
        $method = "" == $method ? "index" : $method;

        if( $method == "index" ) {
            $this->index();       

        } else {

            $this->load->model('Page_model', '', TRUE);
            $page = $this->Page_model->get_page_by_uri(  $this->uri->uri_string() );

            if( $page ) {
                $data['page'] = $page;

                $this->load->view("elements/header",       $data);
                $this->load->view("elements/db_page_view", $data);
                $this->load->view("elements/footer",       $data);

            } else {
                $data['page'] = (object) array('meta_title'        => 'Page Not Found',
                                               'meta_content_type' => '', 
                                               'meta_language'     => '', 
                                               'meta_description'  => '', 
                                               'meta_keywords'     => '');

                $this->load->view("elements/header", 			$data);
                $this->load->view("elements/page_not_found",	$data);
                $this->load->view("elements/footer", 			$data);            
            }
        }        
    }

    function index(){
        $data = array();

        $this->load->model('Xmca_model',   '', TRUE);
        $data['discussions']  = $this->Xmca_model->get_recent();

        $this->load->model('Page_model',   '', TRUE);
        $this->load->model('Slides_model', '', TRUE);

        $data['page']         = $this->Page_model->get_page_by_uri( $this->uri->uri_string() );
		$data['slides']       = $this->Slides_model->get_slides();

        $data['page']->styles = array(
            (object) array('href' => 'assets/scripts/nivo-slider/nivo-slider.css'),
            (object) array('href' => 'assets/styles/'.strtolower( get_class($this) ).'.css')
        );

        $data['page']->scripts = array(
            (object) array('href' => 'assets/scripts/nivo-slider/jquery.nivo.slider.pack.js'),
            (object) array('href' => 'assets/scripts/'.strtolower( get_class($this) ).'.js')
        );

	$this->load->view( strtolower( get_class($this) ).'/index', $data );
    }


}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
