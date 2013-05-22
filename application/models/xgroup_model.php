<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xgroup_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function get_xgroups( $limit = NULL, $offset = NULL )
    {
        $this->db->select('xgroups.*');
        $this->db->order_by('id asc, name asc');
        $this->db->limit( $limit, $offset );
        $query = $this->db->get('xgroups');

        return $query;
    }

    function get_xgroups_by_name( $name, $limit = NULL, $offset = NULL )
    {
        $this->db->select('xgroups.*');
        $this->db->order_by('name asc');

		if( $limit != NULL && $offset != NULL )
		{
	        $this->db->limit( $limit, $offset );
		}

		$query = $this->db->get_where('xgroups', array('name' => $name)); 

        return $query;
    }

    function get_xgroups_by_id( $id, $limit = NULL, $offset = NULL )
    {
        $this->db->select('xgroups.*');
        $this->db->order_by('id asc');
		if( $limit != NULL && $offset != NULL )
		{
	        $this->db->limit( $limit, $offset );
		}

		$query = $this->db->get_where('xgroups', array('id' => $id)); 

	return $query->first_row();
    }

    function count()
    {
        return $this->db->query("select count(id) as numrows from xgroups")->row()->numrows;
    }
    
    function add($uuid, $mime_type){

    }
    
    function delete($id){
        $this->db->delete('join_xgroups_people', array('xgroup_id' => $id)); 
        $this->db->delete('xgroups', array('id' => $id)); 
    }

    function update_person_join($xgroup_id, $person_id){
        $data = array(
            'xgroup_id' =>  $xgroup_id,
            'person_id' => $persond_id
        );
        
        $this->db->insert('join_xgroups_people', $data); 
    }
}