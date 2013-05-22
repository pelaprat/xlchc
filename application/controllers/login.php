<?php

class Login extends CI_Controller {

	var $current_user;
	var $user_reputation_points;

	function __construct() {
		parent::__construct();

		// Load models we always use
		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
	}

	function index() {

		$data['page'] = (object) array(
			'meta_title'		=> 'Search Results',
			'meta_description'	=> 'PLACEHOLDER',
			'meta_keywords'		=> 'PLACEHOLDER',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8',
			'content'			=> '',
		);

    	$this->load->view( "elements/header",	$data );
		$this->load->view( 'login/form',		$data );
    	$this->load->view( "elements/footer",	$data );
	}

	function validate_credentials() {
		$this->load->model('People_model',   '', TRUE);
		$query = $this->People_model->validate();

		if( $query ) {
			if( $this->input->server( 'HTTP_REFERER' ) != null ) {
				redirect( $this->input->server( 'HTTP_REFERER' ));
			} else {
				redirect('/home');
			}

		} else {
			redirect('/home?error=login');
		}
	}

	function logout() {
		$this->session->sess_destroy();
		redirect('/');
	}

	function signup() {

		$data['page'] = (object) array(
			'meta_title'		=> 'Search Results',
			'meta_description'	=> 'PLACEHOLDER',
			'meta_keywords'		=> 'PLACEHOLDER',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8',
			'title'				=> 'Join the Co-Laboratory',
			'content'			=> '',
		);

		$data['recaptcha'] = $this->load_captcha();

    	$this->load->view( "elements/header",	$data );
		$this->load->view( 'login/signup',		$data );
    	$this->load->view( "elements/footer",	$data );
	}

	function create() {
		$data = array();
	
		$this->load->library('form_validation');

		// Customize Validation
		$this->form_validation->set_message('required',    '<div class="validate_error">Validation failed!</div>');
		$this->form_validation->set_message('valid_email', '<span class="validate_error">Must have a correct email address!</span>');
		$this->form_validation->set_error_delimiters('', '');

		////////////////////////////////////////////
		// If form elements are present and valid. 
		if( $this->input->post('submit') && $this->form_validation->run('login/create') == false ) {
			$data['custom_error'] = '<div class="error">It looks like you forgot some required information below.</p></div>';

		} elseif( strcmp( $this->input->post('password_1'), $this->input->post('password_2')) != 0 ) {
			$data['custom_error'] = '<div class="error">The passwords you submitted do not match.</p></div>';

		} elseif( $this->input->post('submit') ) {
	
			/////////////////////////////////////////
			// Check for the person in the database.
			$this->load->model('People_model', '', TRUE);

			///////////////////////////
			// Try to find the person.
			$result = $this->People_model->get_people_by_email( $this->input->post('email') );
//			if( $result->num_rows() <= 0 ) {
//				$result = $this->People_model->get_people_by_name( $this->input->post('last'), $this->input->post('first'));
//			}

			////////////////////////////
			// Did we find him or her?
			if( $result->num_rows() == 1 ) {
				$data['custom_error'] = "<div class='success'>It looks like you're already a member of the Co-Laboratory! ".
										"<br>If you feel this is in error, please contact us.</div>                       ";

			} elseif( $result->num_rows() > 1 ) {
				$data['custom_error'] = '<div class="error">There is an important error associated with your account.<br>              '.
										'Please contact us so that we may personally help you with your account.</div>                 ';
	
			} else {

				// Put this person in the database.
				// And subscribe them to XMCA.
				$salt = rand( 1, 1000000000000 );
				$now  = date('Y-m-j h:i:s');
				$data = array(
					'slug'            => '',
					'first'           => $this->input->post('first'),
					'middle'          => '',
					'last'            => $this->input->post('last'),
					'email'           => $this->input->post('email'),
					'website'         => $this->input->post('website'),
					'gender'          => $this->input->post('gender'),
					'ethnicity'       => $this->input->post('ethnicity'),
					'research'        => $this->input->post('research'),
					'institution'     => $this->input->post('institution'),
					'department'      => $this->input->post('department'),
					'image'           => '',
					'bio'             => $this->input->post('bio'),
					'pw_salt'         => $salt,
					'pw_hash'         => sha1( $salt . $this->input->post('password_1') ),
					'created_at'	  => $now,
					'updated_at'      => $now
				);

				$person_id = $this->People_model->add_person( $data );

				if( $person_id > 0 ) {
					$data['custom_error'] = "<div class='success'>Congratulations!                                 ".
											"<br>You will soon receive an email confirming your membership.</div>  ";
				} else {
					$data['custom_error'] = '<div class="error">We tried to create your account, but there was an error.<br>'.
											'Please contact us so that we can resolve this issue.</div>                     ';
				}
			}
		} else {
			$data['custom_error'] = '';
		}

		$data['recaptcha'] = $this->load_captcha();
		$data['page'] = (object) array(
			'meta_title'		=> 'Search Results',
			'meta_description'	=> 'PLACEHOLDER',
			'meta_keywords'		=> 'PLACEHOLDER',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8',
			'title'				=> 'Join the Co-Laboratory',
			'content'			=> '',
		);

    	$this->load->view( "elements/header",	$data );
		$this->load->view( 'login/signup',		$data );
    	$this->load->view( "elements/footer",	$data );
	}

	function reset_password() {

		$this->load->model('People_model', '', TRUE);
		$this->load->library('form_validation');

		$this->form_validation->set_message('valid_email', '<span class="validate_error">Must have a correct email address!</span>');

		////////////////////////////////////////////
		// If form elements are present and valid. 
		if( $this->input->post('submit') && $this->form_validation->run('login/reset_password') == false ) {
			$data['custom_error'] = '<div class="error">It looks like you forgot some required information below.</p></div>';

		} elseif( $this->input->post('submit') ) {

			// Get the person
			$p = $this->People_model->get_people_table_only_by_email( $this->input->post('email') );

			if( $p == null ) {
				$data['custom_error'] = '<div class="error">This email address is not in our system.</p></div>';

			} else {
				$this->reset_request( $p);
				return;				
			}
		}

		$data['page'] = (object) array(
			'meta_title'		=> 'Reset your password',
			'meta_description'	=> 'PLACEHOLDER',
			'meta_keywords'		=> 'PLACEHOLDER',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8',
			'title'				=> 'Reset your password',
			'content'			=> '',
		);

		$this->load->view( "elements/header",		$data );
		$this->load->view( 'login/reset_password',	$data );
		$this->load->view( "elements/footer",		$data );
	}

	function reset_request( $user ) {

		$this->load->library('email');

		$reset_key	= mt_rand( 1000000000, 2147483647 );
		$user_data  = array( 'reset_key' => $reset_key, 'person_id' => $user->id );

		while( $this->db->insert( 'reset_key', $user_data ) == false ) {
			$reset_key	= mt_rand( 1000000000, 2147483647 );
			$user_data  = array( 'reset_key' => $reset_key, 'person_id' => $user->id );
		}

		$message	= "Dear $user->first $user->last,\n\n" .
					  "Please click on the following link to complete your password reset.\n\n" .
					  $config['base_url'] . "/login/reset_key/$reset_key\n\n".
					   "All the best,\nThe Co-Laboratory of Comparative Human Cognition";

		$this->email->from( 'web@' . $config['base_domain'], 'The Co-Laboratory of Comparative Human Cognition');
		$this->email->to( $user->email );
		$this->email->subject( 'Password Reset' );
		$this->email->message( $message );
		$this->email->send();

		$data = array();
		$data['custom_error']	=	'<div class="success">An email was sent to you about reseting your password.<br>' .
									' Please click the link in that email to complete your password reset.</p></div>';

		$data['message']		= $message;

		$data['page'] = (object) array(
			'meta_title'		=> 'Reset request sent',
			'meta_description'	=> 'PLACEHOLDER',
			'meta_keywords'		=> 'PLACEHOLDER',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8',
			'title'				=> 'Reset request sent',
			'content'			=> '',
		);

		$this->load->view( "elements/header",	$data );
		$this->load->view( 'login/reset_request',	$data );
		$this->load->view( "elements/footer",	$data );
	}

	function reset_key( $identifier ) {
		$data = array();

		// Get the complete code
		$this->db->select('*');
		$query	= $this->db->get_where('reset_key', array( 'reset_key' => $identifier ));
		$row	= $query->first_row();

		if( ! $row ) {
			redirect('/');
		} else {
			$data['reset_key'] = $row->reset_key;
		}

		$data['page'] = (object) array(
			'meta_title'		=> 'Reset password',
			'meta_description'	=> 'PLACEHOLDER',
			'meta_keywords'		=> 'PLACEHOLDER',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8',
			'title'				=> 'Reset password',
			'content'			=> '',
		);

		$this->load->view( "elements/header",	$data );
		$this->load->view( 'login/reset_key',	$data );
		$this->load->view( "elements/footer",	$data );
	}

	function reset_complete( ) {
		$data = array();

		$this->load->library('form_validation');
		$this->load->model('People_model', '', TRUE);

		$this->form_validation->set_message('valid_email', '<span class="validate_error">Must have a correct email address!</span>');

		////////////////////////////////////////////
		// If form elements are present and valid. 
		if( $this->input->post('submit') && $this->form_validation->run('login/reset_complete') == false ) {
			$data['custom_error'] = '<div class="error">It looks like you forgot some required information below.</p></div>';

		} elseif( strcmp( $this->input->post('password_1'), $this->input->post('password_2')) != 0 ) {
			$data['custom_error']	= '<div class="error">The passwords you submitted do not match.</p></div>';
			$data['reset_key']	= $this->input->post('reset_key');

		} elseif( $this->input->post('submit') ) {

			// Get the complete code
			$this->db->select('*');
			$query	= $this->db->get_where('reset_key', array( 'reset_key' => $this->input->post('reset_key') ));
			$row	= $query->first_row();

			// Get the person
			$result = $this->People_model->get_people_by_id( $row->person_id );
			$salt	= $result->pw_salt;
			$hash	= sha1( $salt . $this->input->post('password_1') );

			// Update the person
			$this->db->where(  'id',		$row->person_id );
			$this->db->update( 'people',	array( 'pw_hash' => $hash ));

			// Close the code
			$this->db->where(  'reset_key', $this->input->post('reset_key') );
			$this->db->delete( 'reset_key' );

			$data['custom_success'] = '<div class="success">Congratulations, your password has been reset!</p></div>';
		}

		$data['page'] = (object) array(
			'meta_title'		=> 'Reset password',
			'meta_description'	=> 'PLACEHOLDER',
			'meta_keywords'		=> 'PLACEHOLDER',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8',
			'title'				=> 'Reset password',
			'content'			=> ''
		);


		$this->load->view( 'elements/header',		$data );
		$this->load->view( 'login/reset_complete',	$data );
    		$this->load->view( "elements/footer",		$data );
	}

	/*******************************************************************************************************/
	/*******************************************************************************************************/

	private

	function load_captcha() {
		$this->load->library('recaptcha');
		$this->lang->load('recaptcha');

		return $this->recaptcha->get_html();
	}

	function check_captcha( $val ) {
		$this->load->library('recaptcha');
		$this->lang->load('recaptcha');

		if(	$this->recaptcha->check_answer( $this->input->ip_address(), 
			$this->input->post('recaptcha_challenge_field'), $val )) {
			return TRUE;
		} else {

			$this->form_validation->set_message( 'check_captcha', $this->lang->line('recaptcha_incorrect_response') );
			return FALSE;
		}
	}

	/*******************************************************************************************************/
	/*******************************************************************************************************/

	function xmca_member_logic() {
		///////////////////////////////
		// Are they an XMCA member?  //
		$member = FALSE;
		$groups = $this->xmca_member->get_person_groups( $row[0]->id );
		foreach( $groups->result() as $group ) {
			if( $group->id == 10 ) {
				$member = true;
			}
		}

			$this->subscribe_email( $row[0]->email );
			$this->xmca_member->add_person_to_group( $row[0]->id, 10 );

			$data['custom_error'] =	"<div class='success'>Congratulations, you're now subscribed to the XMCA mailing list. ".
									"You will shortly receive an email confirming your subscription.</div>                 ";

	}
}

?>