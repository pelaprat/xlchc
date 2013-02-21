<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sidebox_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_sideboxes()
	{
		$query = $this->db->get('sideboxes');

		return $query;
	}

	function get_sidebox_by_id($id)
	{
		$query = $this->db->get_where('sideboxes', array('id' => $id));

		return $query->first_row();
	}


	function updateById($id, $fieldValues)
    	{
		$this->db->where('id', $id);
        	$this->db->update('sideboxes', $fieldValues);
    	}

    
	function add($fieldValues)
    	{
		$this->db->insert('sideboxes', $fieldValues);
    	}

	function count_sideboxes( $spam = NULL )
	{
		return $this->get_sideboxes( TRUE )->num_rows();
	}
}

/* End of file sidebox_model.php */
/* Location: ./application/models/sidebox_model.php */
