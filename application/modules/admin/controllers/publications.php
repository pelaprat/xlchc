<?php

class Publications extends Admin_Login_Controller {
	
	function __construct() {
		parent::__construct();

		$this->load->library('form_validation');		

		$this->load->model('Publication_model', '', TRUE);

	}	
	
	function index(){
		$this->manage();
	}

	function manage() {

		$data = array();

		// Libraries 
		$this->load->library('table');
		$this->load->library('pagination');

		// Configuration
		$this->load->helper('pagination_config');

		// Load publication model.
		$total = $this->Publication_model->count_publications();

		// Paging Initialize
		$config = configure_pagination_params( $this, 'admin/publications/manage/', $total );
		$this->pagination->initialize( $config );

		// Get publications.
		$pub_data			 = $this->Publication_model->get_publications_with_authors( $config['per_page'], $this->uri->segment(4) );
		$data['publications'] = $this->Publication_model->clean_publication_data( $pub_data );

		$this->load->view('publications/manage', $data );
	}

	function add() {

		// Validate POST data first.
		$this->load->library('form_validation');	

		// Load upload configuration
		$config['file_name']		= preg_replace('/\./', '', uniqid(time(), true));

		$this->load->library( 'upload', $config );

		// Load people model
		$this->load->model('People_model', '', TRUE);

		// Customize
		$this->form_validation->set_message('required',	'<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_error_delimiters('', '');

		if( $this->form_validation->run('publications') == false || ! $this->upload->do_upload() ) {

			$error = array('error' => $this->upload->display_errors());
			$data['custom_error'] = "<div class='error'><span>Error</span><p>There were validation errors. $error</p></div>";

		} else {

			// Load library
			$this->load->model( 'Media_model', '', TRUE );

			// Handle the media file first.
			$media_data	= $this->upload->data();

			$filedata = array(
				'uuid'			=> $media_data['file_name'],
				'mime_type'		=> $media_data['file_type'],
				'filename'		=> $this->input->post('filename'),
				'description'	=> $this->input->post('description')
			);

			// Make it a media item.
			$media_id = $this->Media_model->add( $filedata );

			// Publication data
			$data = array(
					'id'				=> set_value('id'),
					'title'				=> set_value('title'),
					'abstract'			=> set_value('abstract'),
					'project'			=> set_value('project'),
					'url'				=> set_value('url'),
					'doi'				=> set_value('doi'),
					'pii'				=> set_value('pii'),
					'identifier'		=> set_value('identifier'),
					'citekey'			=> set_value('citekey'),
					'journal_title'		=> set_value('journal_title'),
					'journal_year'		=> set_value('journal_year'),
					'journal_volume'	=> set_value('journal_volume'),
					'journal_issue'		=> set_value('journal_issue'),
					'journal_pages'		=> set_value('journal_pages')
			);

			$publication_id = $this->Publication_model->add_publication( $data );

			// Attach media to the publication
			$this->Media_model->add_media_to_element( $media_id, 'publications', $publication_id );

			// Put in the authors.
			$func = function($k) {
				if( preg_match('/^select-author_(\d+)/', $k ) ) {
					return $_POST[$k];
				}
			};

			$a = array_map( $func, array_keys($_POST) );
			$v = array_unique($a);
			unset( $v[0] );

			// Insert the new authors for this publication.
			foreach( $v as $pid ) {
				$d = array(	'publication_id'	=> $publication_id, 
							'person_id'			=> $pid,
							'id'				=> 'NULL'  );

				$this->db->insert( 'join_publications_people', $d );
			}

			redirect(base_url().'admin/publications/manage/');
		}

		////////////////////////////
		// Prepare the menu data. //
		$authors  = $this->People_model->get_people_alphabetically( true );
		$authormd = array();
		foreach( $authors->result() as $author ) {
			$a = array( 'id'	=> $author->person_id,
		   	 			'value' => $author->last . ', ' . $author->first );

			array_push( $authormd, $a );
		}

		$data['author_menu_data'] = $authormd;

		$this->load->view( 'header',			$data );
		$this->load->view( 'publications/add',	$data );   
		$this->load->view( 'footer',			$data );
	}	

	function edit() {

		// Validate POST data first.
		$this->load->library('form_validation');	

		// Load publication model.
		$this->load->model('Publication_model', '', TRUE);

		// Load People model
		$this->load->model('People_model', '', TRUE);
	
		// Customize
		$this->form_validation->set_message('required', '<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_error_delimiters('', '');
	
		$data['custom_error'] = '';
						
		// Run validation first.
		if( $this->form_validation->run('publications') == false ) {
			$data['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false);

		} else {

			$data = array(
					'id'				=> $this->input->post('id'),
					'title'				=> $this->input->post('title'),
					'abstract'			=> $this->input->post('abstract'),
					'project'			=> $this->input->post('project'),
					'url'				=> $this->input->post('url'),
					'doi'				=> $this->input->post('doi'),
					'pii'				=> $this->input->post('pii'),
					'identifier'		=> $this->input->post('identifier'),
					'citekey'			=> $this->input->post('citekey'),
					'journal_title'		=> $this->input->post('journal_title'),
					'journal_year'		=> $this->input->post('journal_year'),
					'journal_volume'	=> $this->input->post('journal_volume'),
					'journal_issue'		=> $this->input->post('journal_issue'),
					'journal_pages'		=> $this->input->post('journal_pages')
			);

			$this->Publication_model->update( $this->input->post('id'), $data );

			// Put in the authors.
			$func = function($k) {
				if( preg_match('/^select-author_(\d+)/', $k ) ) {
					return $_POST[$k];
				}
			};

			$a = array_map( $func, array_keys($_POST) );
			$v = array_unique($a);
			unset( $v[0] );

			// Delete the authors for this publication.
			$this->Publication_model->db->where('publication_id', $this->input->post('id'));
			$this->Publication_model->db->delete('join_publications_people');

			// Insert the new authors for this publication.
			foreach( $v as $pid ) {
				$d = array(	'publication_id'	=> $this->input->post('id'), 
							'person_id'			=> $pid,
							'id'				=> 'NULL'  );

				$this->Publication_model->db->insert( 'join_publications_people', $d );
			}
            
			redirect(base_url().'admin/publications/manage/');
		}

		//////////////////////////////////
		// Get this publication's data. //
		$p = $this->Publication_model->get_publication_by_id( $this->uri->segment(4) );
		$x = $this->Publication_model->clean_publication_data( $p );

		if( count( $x ) == 1 ) {
			$y = array_pop( $x );
			$data['data'] = $y['data'];
			$data['auth'] = $y['auth'];
		}

		////////////////////////////
		// Prepare the menu data. //
		$authors  = $this->People_model->get_people_alphabetically( true );
		$authormd = array();
		foreach( $authors->result() as $author ) {
			$a = array( 'id'	=> $author->person_id,
		   	 			'value' => $author->last . ', ' . $author->first );

			array_push( $authormd, $a );
		}

		$data['author_menu_data'] = $authormd;

		// Load views
		$this->load->view('header');
		$this->load->view('helpers/media_functions');
		$this->load->view('publications/edit', $data);
		$this->load->view('footer');
	}
	
	function delete(){
		$identifier =  $this->uri->segment(4);

		$this->Publication_model->delete( $identifier );

		redirect(base_url().'admin/publications/manage/');
	}
	
	function updatefile($publicationId, $mediaId){
		$this->load->model('media_model','',TRUE);
		$this->media_model->update_publication_join($mediaId, $publicationId);
		$this->load->view("text_message", array("message" => "Success: picture updated for publication_id=$publicationId"));
	}

}

/* End of file publications.php */
/* Location: ./system/application/controllers/publications.php */