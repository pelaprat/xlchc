<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slides_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_slides()
	{
		$query = $this->db->get('slides');

		return $query;
	}

	function get_slide_by_id($id)
	{
		$query = $this->db->get_where('slides', array('id' => $id));

		return $query->first_row();
	}


	function updateById($id, $fieldValues)
    	{
		$this->db->where('id', $id);
        	$this->db->update('slides', $fieldValues);
    	}

    
	function add($fieldValues)
    	{
		$this->db->insert('slides', $fieldValues);
    	}

	function count_slides( $spam = NULL )
	{
		return $this->get_slides( TRUE )->num_rows();
	}

}

/* End of file slide_model.php */
/* Location: ./application/models/slide_model.php */
