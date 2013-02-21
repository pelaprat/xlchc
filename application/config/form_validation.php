<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config =
	array(		         


		'conversations/add' =>
			array(
				array(	'field'	=> 'summary',
						'label' => 'Conversation starter',
						'rules' => 'required|trim|xss_clean' ),
				array(	'field' => 'subject',
						'label' => 'Subject',
						'rules' => 'required|trim|xss_clean' )
			),

		'login/create' =>
			array(
				array(	'field' => 'first',
						'label' => 'First Name',
						'rules' => 'required|trim|xss_clean' ),
				array(	'field' => 'last',
						'label' => 'Last Name',
						'rules' => 'required|trim|xss_clean' ),
				array(	'field' => 'email',
						'label' => 'Email',
						'rules' => 'required|valid_email|trim|xss_clean' ),
				array(	'field' => 'password_1',
						'label' => 'Password',
						'rules' => 'required|trim|xss_clean' ),
				array(	'field' => 'password_2',
						'label' => 'Verify Password',
						'rules' => 'required|trim|xss_clean' ),
				array(	'field' => 'institution',
						'label' => 'Institution',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'department',
						'label' => 'Department',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'website',
						'label' => 'Web Site',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'bio',
						'label' => 'Biography',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'ethnicity',
						'label' => 'Ethnicity',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'research',
						'label' => 'Research Interests',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'bio',
						'label' => 'Biographical Note',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'recaptcha_response_field',
						'label' => 'lang:recaptcha_field_name',
						'rules' => 'required|check_captcha' )
				),

		'login/reset_password' =>
			array(
				array(	'field' => 'email',
						'label' => 'Email',
						'rules' => 'required|valid_email|trim|xss_clean' )
				),

		'login/reset_complete' =>
			array(
				array( 'field' => 'reset_key',
					    'label' => 'Reset key',
				   'rules' => 'required|trim|xss_clean' ),
				array( 'field' => 'password_1',
					    'label' => 'Password',
				   'rules' => 'required|trim|xss_clean' ),
				array( 'field' => 'password_2',
					    'label' => 'Verify Password',
				   'rules' => 'required|trim|xss_clean' )
			),

		'people/update' =>
			array(
				array(	'field' => 'email',
						'label' => 'Email',
						'rules' => 'required|valid_email|trim|xss_clean' ),
				array(	'field' => 'website',
						'label' => 'Website',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'institution',
						'label' => 'Institution',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'department',
						'label' => 'Department',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'research',
						'label' => 'Research',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'bio',
						'label' => 'Biography',
						'rules' => 'trim|xss_clean' )
			),

		'symposia/add_comment' =>
			array(
				array(	'field' => 'comment',
						'label' => 'Comment',
						'rules' => 'required|trim|xss_clean' ),
				array(	'field' => 'url_video',
						'label' => 'Video URL',
						'rules' => 'trim|xss_clean' ),
				array(	'field' => 'commentable',
						'label' => 'Commentable',
						'rules' => 'required|trim|xss_clean' )
			)
	);
?>