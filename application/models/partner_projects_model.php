<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

mysql> describe partner_projects;
+-------------+--------------+------+-----+---------+----------------+
| Field       | Type         | Null | Key | Default | Extra          |
+-------------+--------------+------+-----+---------+----------------+
| id          | int(11)      | NO   | PRI | NULL    | auto_increment |
| name        | varchar(255) | YES  |     | NULL    |                |
| description | text         | YES  |     | NULL    |                |
| address     | varchar(255) | YES  |     | NULL    |                |
| country     | varchar(255) | YES  |     | NULL    |                |
| latitude    | varchar(16)  | YES  |     | NULL    |                |
| longitude   | varchar(16)  | YES  |     | NULL    |                |
+-------------+--------------+------+-----+---------+----------------+


*/

class Partner_projects_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function get_partner_projects( $limit = NULL, $offset = NULL )
    {
        $this->db->select('*');
        $this->db->order_by('name asc');
        $this->db->limit( $limit, $offset );
        $query = $this->db->get('partner_projects');

        return $query;
    }

    function getProjects(){
        $this->db->select('*');
        return $this->db->get('partner_projects');
    }
    
    function getProjectsSimple(){

        $this->db->select("id, name, address, country, latitude, longitude");
        return $this->db->get('partner_projects');
    }
    
    function getProjectData($id){
    
        $this->db->select("*");
        return $this->db->get_where('partner_projects', array('id' => $id));
    }

    function count_partner_projects( )
    {
        return $this->get_partner_projects( TRUE )->num_rows();
    }

}