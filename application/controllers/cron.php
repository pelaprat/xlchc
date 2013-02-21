<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
		$this->load->vars( $this->user_reputation_points );
	}

	# wget -O - -q -t 1 http://www.example.com/cron/run
	function serve_digest_to_masses() {

		// Load some models
		$this->load->model('Conversation_model', '', TRUE);
		$this->load->model('People_model', '', TRUE);

		$data['page'] = (object) array(
			'meta_title'		=>	'Cron',
			'meta_description'	=>	'Run things on time.',
			'meta_keywords'		=>	'',
			'meta_language'		=>	'en-US',
			'meta_content_type'	=>	'text/html; charset=utf-8',
			'title'				=>	'Cron',
			'o_page_sideboxes'	=>	true
		);

		// Get the relevant new elements
		$conversations = $this->Conversation_model->get_conversation_by_last_24_hours();

		// Start the message
		$n_convos	=	count( $conversations );
		$g_convos   =	( $n_convos == 1 ) ? "is 1 new conversation" : "are $n_convos new conversations";
		$message	=	"Dear friend,\n\nThis is your CO-LCHC Digest for the day!\n\n" .
						"Today there $g_convos on Co-LCHC:";

		// Add the conversations
		foreach( $conversations->result() as $conversation ) {
			$message .=	"\n\n" . $conversation->subject . "\n"				.
						"--------------------------------------------\n"	.
						$conversation->summary . "\n"						.
						'http://dev.lchc.ucsd.edu/conversations/detail/' .
						$conversation->id;
		}

		// Finish message
		$message	.=	"\n\nAll the best,\nThe Co-Laboratory of Comparative Human Cognition";

		// Get the digestees, but only if there is something new
		if( count( $conversations ) >= 1 ) {
			$digestees = $this->People_model->get_people_subscribed_to_digest();

			foreach( $digestees->result() as $digestee ) {
				$this->send_digest( $digestee, $message );
			}

		}

		$this->load->view( 'cron/index', $data );
	}

	private

	function send_digest( $user, $message ) {

		$random	= mt_rand( 1, 9999999 );
		$this->load->library('email');

		$this->email->from( 'web@dev.lchc.ucsd.edu', 'The Co-Laboratory of Comparative Human Cognition');
		$this->email->to( $user->email );
		$this->email->subject( "Daily Digest [Co-LCHC: $random]" );
		$this->email->message( $message );
		$this->email->send();

		echo "Sent email to $user->email<br>";
	}
}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */
