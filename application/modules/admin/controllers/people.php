<?php

class People extends Admin_Login_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('codegen_model','',TRUE);

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

		// Load people model.
		$this->load->model('People_model', '', TRUE);
		$total = $this->People_model->count_people();

		// Paging Initialize
		$config = configure_pagination_params( $this, 'admin/people/manage/', $total );
		$this->pagination->initialize( $config );

		// Get People.
		$data['people'] = $this->People_model->get_people_alphabetically( TRUE, $config['per_page'], $this->uri->segment(4) );

		$this->load->view('header');
		$this->load->view('people/manage', $data ); // $this->data); 
		$this->load->view('footer');
	}
	
	function add(){		

		// Libraries
		$this->load->library('form_validation');	

		// Load people model.
		$this->load->model('People_model', '', TRUE);
		$this->load->model('Xgroup_model', '', TRUE);

		// Customize
		$this->form_validation->set_message('required',	'<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_message('valid_email', '<span class="validate_error">Must have a correct email address!</span>');
		$this->form_validation->set_error_delimiters('', '');

		// Errors?
		$data['custom_error'] = '';

		if( $this->form_validation->run('people') == false ) {
			 $data['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false);

		} else {							
			$data = array(
					'relationship_id'	=> set_value('relationship_id'),
					'slug'				=> set_value('slug'),
					'first'				=> set_value('first'),
					'last'				=> set_value('last'),
					'institution'		=> set_value('institution'),
					'department'		=> set_value('department'),
					'email'				=> set_value('email'),
					'website'			=> set_value('website'),
					'gender'			=> set_value('gender'),
					'ethnicity'			=> set_value('ethnicity'),
					'research'			=> set_value('research'),
					'image'				=> set_value('image'),
					'bio'				=> set_value('bio'),
					'pw_salt'			=> set_value('pw_salt'),
					'pw_hash'			=> set_value('pw_hash')
			);
		   
			if ($this->codegen_model->add('people',$data) == TRUE) {
				redirect(base_url().'admin/people/manage/');

			} else {
				$data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
			}
		}		   

		////////////////////////////
		// Prepare the menu data. //
		$xgroups  = $this->Xgroup_model->get_xgroups();
		$xgroupmd = array();
		foreach( $xgroups->result() as $xgroup ) {
			$a = array(	'id'	=> $xgroup->id,
						'value' => $xgroup->name );

			array_push( $xgroupmd, $a );
		}

		$data['xgroup_menu_data'] = $xgroupmd;

		$this->load->view('header');
		$this->load->view('people/add', $data);   
		$this->load->view('footer');
	}	

	function edit() {

		// Libraries.
		$this->load->library('form_validation');	

		// Load people model.
		$this->load->model('People_model', '', TRUE);
		$this->load->model('Xgroup_model', '', TRUE);

		// Customize
		$this->form_validation->set_message('required',	'<span class="validate_error">Validation failed!</span>');
		$this->form_validation->set_message('valid_email', '<span class="validate_error">Must have a correct email address!</span>');
		$this->form_validation->set_error_delimiters('', '');

		$data['custom_error'] = '';


		// Run validation first.
		if( $this->form_validation->run('people') == false || isset($data['new_password_error'])) {
			$data['custom_error'] = (validation_errors() ? '<div class="error"><span>Error</span><p>There were validation errors.</p></div>' : false);

		} else {							
			$data = array(
				  'relationship_id'	=> $this->input->post('relationship_id'),
				  'slug'			=> $this->input->post('slug'),
				  'first'			=> $this->input->post('first'),
				  'last'			=> $this->input->post('last'),
				  'institution'		=> $this->input->post('institution'),
				  'department'		=> $this->input->post('department'),
				  'email'			=> $this->input->post('email'),
				  'website'			=> $this->input->post('website'),
				  'gender'			=> $this->input->post('gender'),
				  'ethnicity'		=> $this->input->post('ethnicity'),
				  'research'		=> $this->input->post('research'),
				  'image'			=> $this->input->post('image'),
				  'bio'				=> $this->input->post('bio')
			   );

			if( $this->codegen_model->edit('people',$data,'id',$this->input->post('id')) == TRUE ) {

				// Set the groups
				$this->set_groups_for_person( $this->input->post('id') );
				redirect(base_url().'admin/people/manage/');
			
			} else {
				$data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';
			
			}
		}
		
		$data['person']  = $this->People_model->get_people_by_id( $this->uri->segment(4) );
		$data['groups']  = $this->People_model->get_person_groups( $this->uri->segment(4) );

		////////////////////////////
		// Prepare the menu data. //
		$xgroups  = $this->Xgroup_model->get_xgroups();
		$xgroupmd = array();
		foreach( $xgroups->result() as $xgroup ) {
			$a = array( 'id'	=> $xgroup->id,
			   	 	'value' => $xgroup->name );

			array_push( $xgroupmd, $a );
		}

		$data['xgroup_menu_data'] = $xgroupmd;

		// Load views
		$this->load->view('header');
		$this->load->view('people/edit', $data);
		$this->load->view('footer');
	}

	function delete(){
		$ID =  $this->uri->segment(4);
		$this->codegen_model->delete('people','id',$ID);			 
		redirect(base_url().'admin/people/manage/');
	}
	
	function updatepicture($personId, $mediaId){
		$this->load->model('media_model','',TRUE);
		$this->media_model->update_people_join($mediaId, $personId);
		$this->load->view("text_message", array("message" => "Success: picture updated for person_id=$personId"));
	}

	private

	function set_groups_for_person( $person_id ) {
		////////////////////////////
		// Function get the groups
		// From the $_POST
		$func = function($k) {
					if( preg_match('/^select-xgroup_(\d+)/', $k ) ) {
						return $_POST[$k];
					}
				};

		$a = array_map( $func, array_keys($_POST) );
		$v = array_unique($a);
		unset( $v[0] );

		////////////////////////////////////////
		// Delete the xgroups for this person. 
		$this->People_model->db->where('person_id', $person_id );
		$this->People_model->db->delete('join_xgroups_people');

		///////////////////////////////////////////
		// Insert the new groups for this person.
		foreach( $v as $gid ) {
			$d = array(	'xgroup_id'	=> $gid,
						'person_id'	=> $this->input->post('id'),
						'id' 		=> 'NULL'  );

			$this->People_model->db->insert( 'join_xgroups_people', $d );
		}
	}

}

/* End of file People.php */
/* Location: ./system/application/controllers/People.php */