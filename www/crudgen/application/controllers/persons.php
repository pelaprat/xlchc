<?php

class Persons extends CI_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('codegen_model','',TRUE);
	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
        $this->load->library('table');
        $this->load->library('pagination');
        
        //paging
        $config['base_url'] = base_url().'index.php/persons/manage/';
        $config['total_rows'] = $this->codegen_model->count('persons');
        $config['per_page'] = 3;	
        $this->pagination->initialize($config); 	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->codegen_model->get('persons','id,relationship_id,slug,first_name,last_name,institutional_affiliation,departmental_affiliation,email,website,gender,ethnicity,research_interests,image,bio,pw_salt,pw_hash','',$config['per_page'],$this->uri->segment(3));
       
	   $this->load->view('persons_list', $this->data); 
       //$this->template->load('content', 'persons_list', $this->data); // if have template library , http://maestric.com/doc/php/codeigniter_template
		
    }
	
    function add(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('persons') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'relationship_id' => set_value('relationship_id'),
					'slug' => set_value('slug'),
					'first_name' => set_value('first_name'),
					'last_name' => set_value('last_name'),
					'institutional_affiliation' => set_value('institutional_affiliation'),
					'departmental_affiliation' => set_value('departmental_affiliation'),
					'email' => set_value('email'),
					'website' => set_value('website'),
					'gender' => set_value('gender'),
					'ethnicity' => set_value('ethnicity'),
					'research_interests' => set_value('research_interests'),
					'image' => set_value('image'),
					'bio' => set_value('bio'),
					'pw_salt' => set_value('pw_salt'),
					'pw_hash' => set_value('pw_hash')
            );
           
			if ($this->codegen_model->add('persons',$data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'index.php/persons/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

			}
		}		   
		$this->load->view('persons_add', $this->data);   
        //$this->template->load('content', 'persons_add', $this->data);
    }	
    
    function edit(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('persons') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'relationship_id' => $this->input->post('relationship_id'),
					'slug' => $this->input->post('slug'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'institutional_affiliation' => $this->input->post('institutional_affiliation'),
					'departmental_affiliation' => $this->input->post('departmental_affiliation'),
					'email' => $this->input->post('email'),
					'website' => $this->input->post('website'),
					'gender' => $this->input->post('gender'),
					'ethnicity' => $this->input->post('ethnicity'),
					'research_interests' => $this->input->post('research_interests'),
					'image' => $this->input->post('image'),
					'bio' => $this->input->post('bio'),
					'pw_salt' => $this->input->post('pw_salt'),
					'pw_hash' => $this->input->post('pw_hash')
            );
           
			if ($this->codegen_model->edit('persons',$data,'id',$this->input->post('id')) == TRUE)
			{
				redirect(base_url().'index.php/persons/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}

		$this->data['result'] = $this->codegen_model->get('persons','id,relationship_id,slug,first_name,last_name,institutional_affiliation,departmental_affiliation,email,website,gender,ethnicity,research_interests,image,bio,pw_salt,pw_hash','id = '.$this->uri->segment(3),NULL,NULL,true);
		
		$this->load->view('persons_edit', $this->data);		
        //$this->template->load('content', 'persons_edit', $this->data);
    }
	
    function delete(){
            $ID =  $this->uri->segment(3);
            $this->codegen_model->delete('persons','id',$ID);             
            redirect(base_url().'index.php/persons/manage/');
    }
}

/* End of file persons.php */
/* Location: ./system/application/controllers/persons.php */