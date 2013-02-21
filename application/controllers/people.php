<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class People extends CI_Controller {

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
		$this->load->model('People_model', '', TRUE);

		// Generic get-page code.
		$data['page'] = $this->Page_model->get_page_by_uri( $this->uri->uri_string() );
		$data['page']->styles = array( (object) array('href' => 'assets/styles/'.strtolower( get_class($this) ).'.css') );

		// Get groups.
		$data['faculty']    = $this->People_model->get_people_by_xgroup( 3 );
		$data['associated'] = $this->People_model->get_people_by_xgroup( 5 );
		$data['graduate']   = $this->People_model->get_people_by_xgroup( 6 );
		$data['affiliated'] = $this->People_model->get_people_by_xgroup( 7 );
		$data['visitors']   = $this->People_model->get_people_by_xgroup( 8 );

		$this->load->view( strtolower( get_class($this) ).'/index', $data );
	}

	function detail( $identifier ) {

		// Models
		$data = array();
		$this->load->model('People_model', '', TRUE);
		$this->load->model('Publication_model', '', TRUE );

		// Libraries.
		$this->load->library('form_validation');	

		// Customize and Update Person if Necessary
		$this->form_validation->set_message( 'required',	'<span class="validate_error">Validation failed!</span>' );
		$this->form_validation->set_message( 'valid_email',	'<span class="validate_error">Must have a correct email address!</span>' );
		$this->form_validation->set_error_delimiters('', '');

		$data['custom_error'] = '';

		if( $this->form_validation->run('people/update') == true ) {
			$data = array(
						'institution'  					 	=> $this->input->post('institution'),
						'department'   					 	=> $this->input->post('department'),
						'email'		   					 	=> $this->input->post('email'),
						'website'	   					 	=> $this->input->post('website'),
						'research'	   					 	=> $this->input->post('research'),
						'bio'		   					 	=> $this->input->post('bio'),
						'pref_notify_on_comment_reply'		=> $this->input->post('pref_notify_on_comment_reply'),
						'pref_notify_on_conversation_reply'	=> $this->input->post('pref_notify_on_conversation_reply'),
						'pref_notify_on_symposium_reply'	=> $this->input->post('pref_notify_on_symposium_reply'),
						'pref_notify_conversation_digest'	=> $this->input->post('pref_notify_conversation_digest')
			   );

			$this->db->where(  'id', $this->input->post( 'id' ));
			$this->db->update( 'people', $data );

			// Update cached user-info data in the session
			$this->People_model->reload_cached_user_info();

			// Finally reload into current variables
			// (since this data is likely already loaded by a controller)
			$this->current_user = userdata_load();

			// Set success message
			$data['custom_success'] = '<div class="success"><span>Success</span><p>Your information and preferences have successfully changed.</p></div>';

		} elseif( $this->input->post( 'id' ) > 0 ) {
			$data['custom_error'] = ( validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false);
		}

		// Load person information
		if( is_numeric( $identifier ) ){
			$data['people'] = $this->People_model->get_people_by_id($identifier);
		} else{
			$data['people'] = $this->People_model->get_people_by_slug($identifier);
		}

		if( count($data['people']) == 0 ){
			show_404();

		} else{
			$data['page'] = (object) array(
				'meta_title'		=>	$data['people']->first.' '.$data['people']->last,
				'meta_description'	=>	'A page outlining details about '.$data['people']->first.' '.$data['people']->last.
						      			' and their relationship to the LCHC.',
				'meta_keywords'		=>	'',
				'meta_language'		=>	'en-US',
				'meta_content_type'	=>	'text/html; charset=utf-8',
				'title'				=>	$data['people']->first.' '.$data['people']->last
			);

			// First publications for this author, by id
			$list = array();
			$data['publications']	= $this->Publication_model->get_publication_by_author( $identifier );
			foreach( $data['publications']->result() as $publication ) {
				array_push( $list, $publication->publication_id );
			}

			// Then get the other authors for these publications
			$data['authors'] = array();
			if( $data['publications']->num_rows() > 0 ) {
				$authors = $this->Publication_model->get_group_of_publication_authors( $list );

				foreach( $authors->result() as $author ) {
					if( isset( $data['authors'][$author->publication_id] )) {
						array_push( $data['authors'][$author->publication_id], $author );
					} else {
						$data['authors'][$author->publication_id] = array( $author );
					}
				}
			}

			$data['o_page_sideboxes']	= true;

			if( $this->current_user->id != $data['people']->id ) {
				$this->load->view( strtolower( get_class($this) ).'/detail', $data );
			} else {
				$this->load->view( strtolower( get_class($this) ).'/edit', $data );
			}
		}
	}

	function subscribe_conversation( $conversation ) {

		// Models
		$data = array();
		$this->load->model('People_model', '', TRUE);

		if( $this->current_user ) {
			$this->People_model->add_person_to_conversation( $this->current_user->id, $conversation );

			redirect( "/conversations/detail/$conversation" );

		} else {
			redirect( base_url() );	
		}
	}

	function unsubscribe_conversation( $conversation ) {

		// Models
		$data = array();
		$this->load->model('People_model', '', TRUE);

		if( $this->current_user ) {
			$this->People_model->remove_person_from_conversation( $this->current_user->id, $conversation );

			redirect( "/conversations/detail/$conversation" );

		} else {
			redirect( base_url() );	
		}
	}
}

/* End of file people.php */
/* Location: ./application/controllers/people.php */
