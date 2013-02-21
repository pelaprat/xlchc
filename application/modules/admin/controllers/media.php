<?php

class Media  extends Admin_Login_Controller {

	function __construct() {
		parent::__construct();

		$this->load->helper('url');

		$this->load->model('Media_model','',TRUE);

		// Configuration
		$this->load->library('pagination');
		$this->load->helper('pagination_config');
	}

	function index() {
		$this->manage();
	}

	function manage( $data = array() ) {

		$media_per_page = 20;

		//   /admin/media/manage/20 will cause this function to be called with $data = '20'
		//   set $offset to this value and redefine $data to array
		$offset = 0;
		if( ! is_array($data) ) {
			$offset = $data;
			$data = array();
		}

		// Delete finishes by calling manage.
		// In this case $offset should be zero.
		$offset = ( "delete" === $this->uri->segment(3) ? 0 : $this->uri->segment(4));
		$data['offset'] = $offset;

		// Do we need to make any group  
		// changes to the selected media?
		if(	$this->input->get('set_to_group') && $this->input->get('media') &&
			$this->input->get('set_to_group') > 0 ) {

			$selected_media = explode( ',', $this->input->get('media'));
			$this->Media_model->add_media_to_group( $selected_media, $this->input->get('set_to_group') );
		}

		//////////////////////////////////////////
		// Get the params for groups & elements //
		$this->input->get('keywords')	!= '' ? $param_keywords	= explode( ',', $this->input->get('keywords') )	: $param_keywords	= array();
		$this->input->get('elements')	!= '' ? $param_elements	= explode( ',', $this->input->get('elements') )	: $param_elements	= array();
		$this->input->get('groups')		!= '' ? $param_groups	= explode( ',', $this->input->get('groups') )	: $param_groups		= array();

		/////////////////////////////////////
		// Get all the media for this page //
		//  and then post-process it.      //
		$media		= array();
		$media_data	= $this->Media_model->get_all_with_meta_and_keywords( $param_keywords, $param_elements, $param_groups, $offset, $media_per_page );


		foreach( $media_data->result() as $item_data ) {

			// Set up the sub-array if we have no
			//  entry for this media item

			if( isset( $media[$item_data->media_id] ) == false ) {
				$media[$item_data->media_id] = array(	'elements'		=> array(),
				 										'groups'		=> array(),
														'people'		=> array(),
														'publications'	=> array() );
			}

			// Basic media data
			$media[$item_data->media_id]['media_id']			= $item_data->media_id;
			$media[$item_data->media_id]['uuid']				= $item_data->uuid;
			$media[$item_data->media_id]['filename']			= $item_data->filename;
			$media[$item_data->media_id]['description']			= $item_data->description;
			$media[$item_data->media_id]['mime_type']			= $item_data->mime_type;
			$media[$item_data->media_id]['media_created_at']	= $item_data->media_created_at;

			// Is media attached to people?
			if(	isset( $item_data->foreign_join_table )	&& $item_data->foreign_join_table == 'person' &&
				isset( $item_data->person_id )			&& $item_data->person_id > 0 ) {

				// Only do this if person is not already there
				if( isset( $media[$item_data->media_id]['people'][$item_data->person_id] ) == false ) {
					$media[$item_data->media_id]['people'][$item_data->person_id] =
						array( 'first' => $item_data->first, 'last' => $item_data->last );
				}
			}

			// Is media attached to a publication?
			if(	isset( $item_data->foreign_join_table )	&& $item_data->foreign_join_table == 'publications' &&
				isset( $item_data->publication_id )		&& $item_data->publication_id > 0 ) {

				// Only do this if publication is not already there
				if( isset( $media[$item_data->media_id]['publications'][$item_data->publication_id] ) == false ) {
					$media[$item_data->media_id]['publications'][$item_data->publication_id] =
						array( 'title' => $item_data->title );
				}
			}

			// Linked to a group?
			if( isset( $item_data->media_group_id)	&& $item_data->media_group_id > 0 ) {
				array_push( $media[$item_data->media_id]['groups'], $item_data->media_group_id );
			}
		}

		// Now set it for $data
		$data['media'] = $media;

		// Get number of media
		$data['total']   = $this->Media_model->count_media_with_meta_and_keywords( $param_keywords, $param_elements, $param_groups, $offset, $media_per_page );

		// Get the groups and elements for the available media
		$group_a	= array();
		$groups		= $this->Media_model->get_media_groups();
		foreach( $groups->result() as $group ) {
			$group_a[$group->group_id] = $group->name;
		}
		$data['groups']		= $group_a;
		$data['elements']	= $this->Media_model->get_media_elements();

		///////////////////////////////
		// Pagination Initialization //
		$config = configure_pagination_params( $this, 'admin/media/manage/', $data['total'], $media_per_page );
		$this->pagination->initialize( $config );
		$data['config'] = $config;

		// Views n' such.
		if( isset( $_GET['mode'] ) && $_GET['mode'] == 'browser' ) {
			$this->load->view('simple_header');
		} else {
			$this->load->view('header');
		}
		
		$this->load->view('helpers/media_functions', $data);
		$this->load->view('media/top', $data);
		$this->load->view('media/list', $data);

		if( isset( $_GET['mode'] ) && $_GET['mode'] == 'browser' ) {
			$this->load->view('simple_footer');
		} else {
			$this->load->view('footer');
		}
	}

	function upload() {
		$data	= array();

		// Validate POST data first.
		$this->load->library('form_validation');	

		// Load upload configuration
		$config['upload_path']		= "/Volumes/RAID/web_sites/org.xlchc/www/assets/media/";
		$config['allowed_types']	= 'doc|html|pdf|png|gif|jpg|png|jpeg|flv|mp3|mov|mpeg|mpg|zip';
		$config['max_size']			= '' . (1024 * 20) /*20 megabyte upload limit*/;
		$config['file_name']		= preg_replace('/\./', '', uniqid(time(), true));

		$this->load->library( 'upload', $config );

		// Customize
		$this->form_validation->set_message('required',	'<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_error_delimiters('', '');

		// Try to upload
		$try_upload = $this->upload->do_upload();

		$data['custom_error'] = '';
		if( $this->form_validation->run('media/upload') == false || ! $try_upload ) {

			$error = $this->upload->display_errors();
			$data['custom_error'] = "<div class='error'><span>Error</span><p>There were validation errors. $error</p></div>";

		} elseif( $this->form_validation->run('media/upload') && $try_upload ) {

			// Get the uploaded file data
			$upload_data = $this->upload->data();

			$filedata = array(
				'uuid'			=> $upload_data['file_name'],
				'mime_type'		=> $upload_data['file_type'],
				'filename'		=> $this->input->post('filename'),
				'description'	=> $this->input->post('description')
			);

			$media_id = $this->Media_model->add( $filedata );

			// Put in the media-groups.
			$func = function($k) {
				if( preg_match('/^select-media-group_(\d+)/', $k ) ) {
					return $_POST[$k];
				}
			};

			$a = array_map( $func, array_keys($_POST) );
			$v = array_unique($a);
			unset( $v[0] );

			foreach( $v as $g ) { 
				$this->Media_model->add_media_to_group( array($media_id), $g );
			}

			// Was it a zip file that needs to be
			//  opened up through an archive as an
			//  HTML archive?
			if( $filedata['mime_type'] == 'application/zip' ) {

				// Make a new zip object
				$zip = new ZipArchive;

				// Path to the existing, uploaded zip file
				$file = $upload_data['full_path'];
				chmod( $file, 0777 );

				// Path to the new asset directory,
				//  which we also make
				$uuid	= preg_replace( '/\.[^\.]+$/', '', $filedata['uuid'] );
				$dir	= $config['upload_path'] . '/' . $uuid;
				mkdir( $dir, 0777 );

				// If this file can be opened...
				if( $zip->open( $file ) === TRUE ) {

					// ... extract it
					$zip->extractTo( $dir );
					$zip->close();
				}

				// Set the files new mime type
				$this->Media_model->update( $media_id,
					array(	'uuid'		=> $uuid,
							'mime_type'	=> 'text/html' ));

				// Delete the file
				unlink( $file );
			}

			// Notification
			$data['custom_error'] = "<div class='success'><span>Success</span><p>The file is now in the media library.</p></div>";

		}

		$groupsmd	= array();
		$groups		= $this->Media_model->get_media_groups();
		foreach( $groups->result() as $group ) {
			$a = array( 'id'	=> $group->group_id,
		   	 			'value' => $group->name );

			array_push( $groupsmd, $a );
		}
		$data['media_group_menu_data'] = $groupsmd;
	
		$this->load->view('header');
		$this->load->view('media/top', $data);
		$this->load->view('media/upload', $data);
		$this->load->view('footer'); 

		return;
	}
	
	function delete( $id ) {
		if( is_int(0 + $id) ) {

			$media = $this->Media_model->get_by_id($id);

			if( $media ) {
				$file = $config['upload_path'] . '/' . $media->uuid;
				try {
					unlink($file);
				}

				catch(Exception $e) {
					error_log("Could not delete $file"); 
				}
				$this->Media_model->delete($id);
			}
		}

		if( isset( $_GET['mode'] ) && $_GET['mode'] == 'browser' ) {
			$this->load->view("text_message", array("message" => "Success: media_id=$id deleted."));
			return;
		}
		
		$offset = isset($_GET['offset'])? $_GET['offset'] : 0;
		redirect("/admin/media/manage/$offset");
	}
	
	function browse(){
		$this->load->view('media/browse');
	}
}