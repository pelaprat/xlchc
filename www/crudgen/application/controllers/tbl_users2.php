<?php

class Tbl_users2 extends CI_Controller {
    
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
        $config['base_url'] = base_url().'index.php/tbl_users2/manage/';
        $config['total_rows'] = $this->codegen_model->count('tbl_users2');
        $config['per_page'] = 3;	
        $this->pagination->initialize($config); 	
        // make sure to put the primarykey first when selecting , 
		//eg. 'userID,name as Name , lastname as Last_Name' , Name and Last_Name will be use as table header.
		// Last_Name will be converted into Last Name using humanize() function, under inflector helper of the CI core.
		$this->data['results'] = $this->codegen_model->get('tbl_users2','userID,username,password,name','',$config['per_page'],$this->uri->segment(3));
       
	   $this->load->view('tbl_users2_list', $this->data); 
       //$this->template->load('content', 'tbl_users2_list', $this->data); // if have template library , http://maestric.com/doc/php/codeigniter_template
		
    }
	
    function add(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('tbl_users2') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'username' => set_value('username'),
					'password' => set_value('password'),
					'name' => set_value('name')
            );
           
			if ($this->codegen_model->add('tbl_users2',$data) == TRUE)
			{
				//$this->data['custom_error'] = '<div class="form_ok"><p>Added</p></div>';
				// or redirect
				redirect(base_url().'index.php/tbl_users2/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

			}
		}		   
		$this->load->view('tbl_users2_add', $this->data);   
        //$this->template->load('content', 'tbl_users2_add', $this->data);
    }	
    
    function edit(){        
        $this->load->library('form_validation');    
		$this->data['custom_error'] = '';
		
        if ($this->form_validation->run('tbl_users2') == false)
        {
             $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">'.validation_errors().'</div>' : false);

        } else
        {                            
            $data = array(
                    'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
					'name' => $this->input->post('name')
            );
           
			if ($this->codegen_model->edit('tbl_users2',$data,'userID',$this->input->post('userID')) == TRUE)
			{
				redirect(base_url().'index.php/tbl_users2/manage/');
			}
			else
			{
				$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';

			}
		}

		$this->data['result'] = $this->codegen_model->get('tbl_users2','userID,username,password,name','userID = '.$this->uri->segment(3),NULL,NULL,true);
		
		$this->load->view('tbl_users2_edit', $this->data);		
        //$this->template->load('content', 'tbl_users2_edit', $this->data);
    }
	
    function delete(){
            $ID =  $this->uri->segment(3);
            $this->codegen_model->delete('tbl_users2','userID',$ID);             
            redirect(base_url().'index.php/tbl_users2/manage/');
    }
}

/* End of file tbl_users2.php */
/* Location: ./system/application/controllers/tbl_users2.php */