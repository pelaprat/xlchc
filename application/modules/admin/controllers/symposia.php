<?php

class Symposia extends Admin_Login_Controller {
    
    function __construct() {

        parent::__construct();

		// Load models and libraries
		$this->load->model('Symposium_model', '', TRUE);
		$this->load->model('People_model',    '', TRUE );
        $this->load->library('form_validation');        
    }    
    
    function index(){
        $this->manage();
    }

    function add(){

		$data['custom_error'] = '';

		if ($this->form_validation->run('symposia') == false) {
			$data['custom_error'] = (validation_errors() ? '<div class="error">'.validation_errors().'</div>' : false);

		} else {

            $subject	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('subject'))	: $this->input->post('subject'));
            $summary	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('summary'))	: $this->input->post('summary'));
            $url_video	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('url_video'))	: $this->input->post('url_video'));

            $values  = array( 
								'subject'		=> $subject,
								'summary'		=> $summary,
								'url_video'		=> $url_video,
								'created_at'	=> datetime_now(),
								'updated_at'	=> datetime_now()
							);

			// Add the symposium
			$symposium_id = $this->Symposium_model->add( $values );

			// Set the instructors
			$this->set_instructors_for_symposium( $symposium_id );

			// Set the members
			$this->set_members_for_symposium( $symposium_id );

			// Set the media
			$this->set_media_for_symposium( $symposium_id );

			redirect( base_url().'admin/symposia/manage/' );
		}

		$data['instructor_menu_data']	= $this->generate_menu_data( $this->People_model->get_people_by_xgroup( 3 ) );
		$data['member_menu_data']		= $this->generate_menu_data( $this->People_model->get_people_by_xgroup( 4 ) );

        $this->load->view('header');
        $this->load->view('symposia/add', $data);   
        $this->load->view('footer'); 
    }

	function chapter_add( $identifier ) {

		$data['custom_error'] = '';

		if ($this->form_validation->run('symposia_chapters') == false) {
			$data['custom_error'] = (validation_errors() ? '<div class="error">'.validation_errors().'</div>' : false);

		} else {

            $subject	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('subject'))	: $this->input->post('subject'));
            $summary	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('summary'))	: $this->input->post('summary'));
            $url_video	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('url_video'))	: $this->input->post('url_video'));

            $values  = array( 
								'symposium_id'	=> $this->input->post('symposium_id'),
								'person_id'		=> $this->input->post('person_id'),
								'subject'		=> $subject,
								'summary'		=> $summary,
								'url_video'		=> $url_video,
								'created_at'	=> datetime_now(),
								'updated_at'	=> datetime_now()
							);

			$symposium_chapter_id = $this->Symposium_model->add_chapter( $values );

			// Set the media
			$this->set_media_for_symposium_chapter( $symposium_chapter_id );

			redirect( base_url().'admin/symposia/manage/' );
		}

		$data['instructor_menu_data']	= $this->generate_menu_data( $this->People_model->get_people_by_xgroup( 3 ) );
		$data['symposium_id']			= $identifier;

        $this->load->view('header');
        $this->load->view('symposia/chapter_add', $data);   
        $this->load->view('footer');	
	}

	function chapter_list( $identifier ) {
		$data = array();

		// Get Symposia.
		$data['symposia_chapters'] = $this->Symposium_model->get_symposium_chapters_by_id( $identifier );

		$this->load->view('header');
		$this->load->view('symposia/chapter_list', $data); 
		$this->load->view('footer');
	}

    function chapter_edit( $identifier ){        

    	$data = array();

        $data['custom_error'] = '';

		// Run validation
        if( $this->form_validation->run('symposia_chapters') == false ) {
             $data['custom_error'] =
				( validation_errors() ? '<div class="error">'.validation_errors().'</div>' : false );

        } else {

			$subject	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('subject'))	: $this->input->post('subject'));
			$summary	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('summary'))	: $this->input->post('summary'));
			$url_video	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('url_video'))	: $this->input->post('url_video'));

            $values  = array( 
								'person_id'		=> $this->input->post('person_id'),
								'subject'		=> $subject,
								'summary'		=> $summary,
								'url_video'		=> $url_video,
								'updated_at'	=> datetime_now()
							);

			$this->Symposium_model->update_chapter( $this->input->post('id'), $values );

			// Set the media
			$this->set_media_for_symposium_chapter( $identifier );

			// Give success message.
			$data['custom_error'] = "<div class='success'>Update successful.</div>";
        }

        $data['symposium_chapter']			= $this->Symposium_model->get_symposium_chapter_by_id( $identifier );
		$data['symposia_chapters_media']	= $this->Symposium_model->get_symposia_chapters_media( $identifier );
		$data['instructor_menu_data']		= $this->generate_menu_data( $this->People_model->get_people_by_xgroup( 3 ));

        $this->load->view('header');
        $this->load->view('symposia/chapter_edit', $data );
        $this->load->view('footer');
    }

    function chapter_delete( $identifier ) {

		$this->Symposium_model->delete_symposium_chapter( $identifier );
        redirect( base_url().'admin/symposia/manage/' );
    }

	/*************************/
	/** Symposium Functions **/
    function delete( $identifier ) {
		$this->Symposium_model->delete_symposium( $identifier );
        redirect( base_url().'admin/symposia/manage/' );
    }

    function edit( $identifier ){        

    	$data = array();

        $data['custom_error'] = '';

		// Run validation
        if( $this->form_validation->run('symposia') == false ) {
             $data['custom_error'] =
				( validation_errors() ? '<div class="error">'.validation_errors().'</div>' : false );

        } else {

			$subject	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('subject'))	: $this->input->post('subject'));
			$summary	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('summary'))	: $this->input->post('summary'));
			$url_video	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('url_video'))	: $this->input->post('url_video'));

            $values  = array( 
								'subject'		=> $subject,
								'summary'		=> $summary,
								'url_video'		=> $url_video,
								'updated_at'	=> datetime_now(),
								'f_private'		=> $this->input->post('f_private')
							);

			// Update the symposium data
			$this->Symposium_model->update( $this->input->post('id'), $values );

			// Set the instructors
			$this->set_instructors_for_symposium( $this->input->post('id') );

			// Set the members
			$this->set_members_for_symposium( $this->input->post('id') );

			// Set the media
			$this->set_media_for_symposium( $this->input->post('id') );

			// Give success message.
			$data['custom_error'] = "<div class='success'>Update successful.</div>";
        }

        $data['symposium']				= $this->Symposium_model->get_symposium_by_id( $identifier );
		$data['symposia_instructors']	= $this->Symposium_model->get_symposia_instructors( $identifier );
		$data['symposia_members']		= $this->Symposium_model->get_symposia_members( $identifier );
		$data['symposia_media']			= $this->Symposium_model->get_symposia_media( $identifier );

		$data['instructor_menu_data']	= $this->generate_menu_data( $this->People_model->get_people_by_xgroup( 3 ));
		$data['member_menu_data']		= $this->generate_menu_data( $this->People_model->get_people_by_xgroup( 4 ));

        $this->load->view('header');
        $this->load->view('symposia/edit', $data );
        $this->load->view('footer');
    }

    function manage(){

		$data = array();

		// Libraries
		$this->load->library('pagination');

		// Configuration
		$this->load->helper('pagination_config');

		// Load Symposium model.
		$total = $this->Symposium_model->num_symposia();

		// Paging Initialize
		$config = configure_pagination_params( $this, 'admin/symposia/manage/', $total );
		$this->pagination->initialize( $config );

		// Get Symposia.
		$data['symposia'] = $this->Symposium_model->get_all();

		$this->load->view('header');
		$this->load->view('symposia/list', $data); 
		$this->load->view('footer');
    }

	private

	function generate_menu_data( $people ) {
		$x = array();

		foreach( $people->result() as $person ) {
			$a = array(	'person_id' => $person->person_id,
						'value'		=> $person->first . ' ' . $person->last );

			array_push( $x, $a );
		}

		return $x;
	}

	function set_instructors_for_symposium( $symposium_id ) {

		$func = function($k) {
					if( preg_match('/^select-instructor_(\d+)/', $k ) ) {
						return $_POST[$k];
					}
				};

		$a = array_map( $func, array_keys($_POST) );
		$v = array_unique($a);
		unset( $v[0] );

		$this->Symposium_model->set_instructors( $symposium_id, $v );
	}

	function set_members_for_symposium( $symposium_id ) {

		$func = function($k) {
					if( preg_match('/^select-member_(\d+)/', $k ) ) {
						return $_POST[$k];
					}
				};

		$a = array_map( $func, array_keys($_POST) );
		$v = array_unique($a);
		unset( $v[0] );

		$this->Symposium_model->set_members( $symposium_id, $v );
	}

	function set_media_for_symposium( $symposium_id ) {

		$func = function($k) {
					if( preg_match('/^select-media-file_(\d+)-media_id/', $k ) ) {
						return $_POST[$k];
					}
				};

		$a = array_map( $func, array_keys($_POST) );
		$v = array_unique($a);
		unset( $v[0] );

		$this->Symposium_model->set_media_for_symposium( $symposium_id, $v );
	}

	function set_media_for_symposium_chapter( $symposium_chapter_id ) {

		$func = function($k) {
					if( preg_match('/^select-media-file_(\d+)-media_id/', $k ) ) {
						return $_POST[$k];
					}
				};

		$a = array_map( $func, array_keys($_POST) );
		$v = array_unique($a);
		unset( $v[0] );

		$this->Symposium_model->set_media_for_symposium_chapter( $symposium_chapter_id, $v );
	}
}







