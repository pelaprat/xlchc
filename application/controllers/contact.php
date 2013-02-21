<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

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

		$c['page'] = $this->Page_model->get_page_by_uri( 'contact' );
		$c['page']->styles = array(
			(object) array('href' => 'assets/styles/contact.css')
		);
		$c['page']->scripts = array(
			(object) array('href' => 'assets/scripts/jquery.defaultText.js'),
			(object) array('href' => 'assets/scripts/contact.js')
		);

		$this->load->view( 'contact/index', $c );
	}

	function success()
	{
		$c = array();
		$this->load->model('Page_model', '', TRUE);

		$c['page'] = $this->Page_model->get_page_by_uri( 'contact' );

		$this->load->view( 'contact/success', $c );
	}

	function failure()
	{
		$c = array();
		$this->load->model('Page_model', '', TRUE);

		$c['page'] = $this->Page_model->get_page_by_uri( 'contact' );

		$this->load->view( 'contact/failure', $c );
	}

	function form_submission()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('first', 'First Name', 'trim|max_length[32]');
		$this->form_validation->set_rules('last', 'Last Name', 'trim|max_length[32]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('website', 'Website', 'trim');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|min_length[2]');
		$this->form_validation->set_rules('captcha', 'CAPTCHA', 'trim|required|max_length[2]|matches[answer]');

		if ($this->form_validation->run() == FALSE)
		{
			$this->index();
		}
		else
		{
			if( $this->_process() ){
				redirect('contact/success');
			} else{
				redirect('contact/failure');
			}
		}
	}

	function _process()
	{
		$this->load->library('email');

		$from = 'Anonymous Visitor';
		$message = '';

		if( $this->input->post('first') || $this->input->post('last') )
		{
			if( $this->input->post('first') )
			{
				$from = $this->input->post('first').' '.$this->input->post('last');
			} else{
				$from = $this->input->post('last');
			}
		}

		$this->email->from('noreply@lchc.ucsd.edu', 'LCHC');
		$this->email->reply_to($this->input->post('email'), $from);
		$this->email->to('djmccormick@gmail.com');

		$this->email->subject('Contact Form Submission from '.$from.' (Submitted '.date('F j, Y \a\t g:iA T').')');
		$message .= 'Name: '.$this->input->post('first').' '.$this->input->post('last')."\n";
		$message .= 'Email: '.$this->input->post('email')."\n";
		$message .= 'Website: '.$this->input->post('website')."\n";
		$message .= 'Submitted: '.date('F j, Y \a\t g:iA T')."\n";
		$message .= 'IP Address: '.$this->input->ip_address()."\n";
		$message .= 'Message: '."\n";
		$message .= "\n\n".$this->input->post('message')."\n";
		$this->email->message($message);

		return $this->email->send();
	}
}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */
