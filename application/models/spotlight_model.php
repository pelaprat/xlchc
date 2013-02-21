<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
mysql> describe spotlight;
+-------------+--------------+------+-----+---------+----------------+
| Field       | Type         | Null | Key | Default | Extra          |
+-------------+--------------+------+-----+---------+----------------+
| id          | int(32)      | NO   | PRI | NULL    | auto_increment |
| title       | varchar(128) | YES  |     | NULL    |                |
| description | text         | YES  |     | NULL    |                |
+-------------+--------------+------+-----+---------+----------------+

*/

class Spotlight_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function getRandomSpotlight(){
        $this->db->select('*');
        $this->db->order_by("RAND()"); // Order by
        $this->db->limit(1);
        return $this->db->get('spotlight')->row();
    }
    
    function getAllSpotlights(){
        return $this->db->get('spotlight')->result();
    }
    
    function getSpotlight($id){
        return $this->db->get_where('spotlight', array('id' => $id))->row();
    }
    
    
    function updateById($id, $fieldValues)
    {
        $this->db->where('id', $id);
        $this->db->update('spotlight', $fieldValues);
    }

    
    function add($fieldValues)
    {
        $this->db->insert('spotlight', $fieldValues);
    }

	function get_spotlights()
	{
		$query = $this->db->get('spotlight');

		return $query;
	}


	function count_spotlights( $spam = NULL )
	{
		return $this->get_spotlights( TRUE )->num_rows();
	}
    
}