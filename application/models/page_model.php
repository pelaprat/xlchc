<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {

    function __construct() {
        parent::__construct();
        
        $this->db->query('SET character_set_results = "utf8";');
    }

    function get_pages( $limit = NULL, $offset = NULL ) {
        $this->db->select('*');
        $this->db->order_by('uri asc');
        $this->db->limit( $limit, $offset );
        $query = $this->db->get('pages');

        return $query;
    }

    function count_pages( ) {
        return $this->get_pages( TRUE )->num_rows();
    }

    function get_page_by_id($id) {
        $query = $this->db->get_where('pages', array('id' => $id));

        return $query->first_row();
    }

    function get_page_by_uri($uri) {
        $result = false;

        $sql = 'SELECT * FROM pages WHERE uri = ?';
        $query = $this->db->query($sql, array($uri));

        if( $query->num_rows() == 1 ) {
            $result = $query->row();
	    $query = $this->get_page_sideboxes( $result->id );

            if( $query->num_rows() > 0 ) {
                $result->sideboxes = $query->result();
            }
        }

        return $result;
    }

    function get_page_sideboxes( $id ) {
	$this->db->select('join_pages_sideboxes.*, sideboxes.title, sideboxes.content ');
	$this->db->join('sideboxes', 'join_pages_sideboxes.sidebox_id = sideboxes.id', 'left inner');

	$this->db->order_by('join_pages_sideboxes.id asc');
	$query = $this->db->get_where('join_pages_sideboxes', array( 'join_pages_sideboxes.page_id' => $id ));

	return $query;
    }

    function updateById($id, $fieldValues)
    {
        $this->db->where('id', $id);
        $this->db->update('pages', $fieldValues);
    }
    
    function add($fieldValues)
    {
        $this->db->insert('pages', $fieldValues);
    }
}

/* End of file page_model.php */
/* Location: ./application/models/page_model.php */
