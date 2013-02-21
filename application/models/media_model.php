<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*

mysql> desc media;
+------------+--------------+------+-----+-------------------+----------------+
| Field      | Type         | Null | Key | Default           | Extra          |
+------------+--------------+------+-----+-------------------+----------------+
| id         | int(11)      | NO   | PRI | NULL              | auto_increment |
| uuid       | varchar(100) | YES  |     | NULL              |                |
| mime_type  | varchar(50)  | YES  |     | NULL              |                |
| created_at | timestamp    | NO   |     | CURRENT_TIMESTAMP |                |
+------------+--------------+------+-----+-------------------+----------------+
4 rows in set (0.00 sec)

mysql> desc join_media_groups;
+----------------+---------+------+-----+---------+----------------+
| Field          | Type    | Null | Key | Default | Extra          |
+----------------+---------+------+-----+---------+----------------+
| id             | int(11) | NO   | PRI | NULL    | auto_increment |
| media_id       | int(11) | NO   |     | NULL    |                |
| media_group_id | int(11) | NO   |     | NULL    |                |
+----------------+---------+------+-----+---------+----------------+
3 rows in set (0.01 sec)

mysql> desc media_groups;
+-------+--------------+------+-----+---------+----------------+
| Field | Type         | Null | Key | Default | Extra          |
+-------+--------------+------+-----+---------+----------------+
| id    | int(11)      | NO   | PRI | NULL    | auto_increment |
| name  | varchar(255) | NO   | MUL | NULL    |                |
+-------+--------------+------+-----+---------+----------------+
2 rows in set (0.00 sec)

mysql> desc join_media_anything;
+----------------------+--------------+------+-----+---------+----------------+
| Field                | Type         | Null | Key | Default | Extra          |
+----------------------+--------------+------+-----+---------+----------------+
| id                   | int(11)      | NO   | PRI | NULL    | auto_increment |
| media_id             | int(11)      | NO   |     | NULL    |                |
| foreign_join_table   | varchar(100) | NO   |     | NULL    |                |
| foreign_table_row_id | int(11)      | NO   |     | NULL    |                |
+----------------------+--------------+------+-----+---------+----------------+
4 rows in set (0.01 sec)

*/

class Media_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	/*********************/
	/**** GET METHODS ****/
	function get_all( $start = 0, $count = 20 ){
		$this->db->select( 'media.*' );
		$this->db->from( 'media' );
		$this->db->order_by( 'id asc' );
		return $this->db->get();
	}

	/* This will return a lot of nulls. It must be post-processed. */
	function get_all_with_meta_and_keywords( $keywords = array(), $elements = array(), $groups = array(), $start = 0, $count = 20, $unique = false ) {

		$this->db->select( 'media.id as media_id, media.created_at as media_created_at, media.*' );

		$this->db->select( 'join_media_anything.foreign_join_table, join_media_anything.foreign_table_row_id' );
		$this->db->select( 'people.id as person_id, people.* ' );
		$this->db->select( 'publications.id as publication_id, , publications.*');
		$this->db->select( 'join_media_groups.media_group_id' );

		$this->db->from( 'media' );

		$this->db->join( 'join_media_anything',	'join_media_anything.media_id = media.id', 						'left outer' );
		$this->db->join( 'people', 				'join_media_anything.foreign_table_row_id = people.id',			'left outer' );
		$this->db->join( 'publications',		'join_media_anything.foreign_table_row_id = publications.id',	'left outer' );
		$this->db->join( 'join_media_groups',	'join_media_anything.media_id = join_media_groups.media_id',	'left outer' );

		// Conditions
		if( isset( $elements ) && count( $elements ) > 0 ) {
			$this->db->where_in( 'join_media_anything.foreign_join_table', $elements );
		}

		if( isset( $groups ) && count( $groups ) > 0 ) {
			$this->db->where_in( 'join_media_groups.media_group_id', $groups );
		}

		if( isset( $keywords ) && count( $keywords ) > 0 ) {
			foreach( $keywords as $keyword ) {
				$keyword = addslashes( $keyword );
				$this->db->where( "(filename like \"%$keyword%\" or description like \"%$keyword%\" or last like \"%$keyword%\" or title like \"%$keyword%\" )" );
			}
		}

		// Are we just doing unique rows (typically for counting)
		if( $unique ) {
			$this->db->group_by( 'media.id' );
		}

		$this->db->order_by( 'join_media_anything.id asc' );
		if( isset( $start) && isset( $count ) && $count > 0 ) {
			$this->db->limit( $count, $start );
		}

		return $this->db->get();
	}

	function get_by_id( $id ) {
		$this->db->select('*');
		$this->db->from("media");
		$this->db->where(array("id" => $id));
		return $this->db->get()->row();
	}

	function get_by_uuid( $uuid )
	{
		$this->db->select('*');
		$this->db->from("media");
		$this->db->where(array("uuid" => $uuid));
		return $this->db->get()->row();
	}

	function get_media_groups( $start = 0, $count = 20 ){
		$this->db->select( 'media_groups.*, media_groups.id as group_id' );
		$this->db->from( 'media_groups' );
		$this->db->order_by( 'name asc' );

		return $this->db->get();
	}

	function get_media_group_by_id( $id ){
		$this->db->select( '*' );
		$this->db->from( 'media_groups' );
		$this->db->where(array("id" => $id));

		return $this->db->get()->row();
		}

	function get_media_elements(){
		$this->db->select( 'foreign_join_table, foreign_join_table as name' );
		$this->db->from( 'join_media_anything' );
		$this->db->group_by( 'foreign_join_table' );
		$this->db->order_by( 'foreign_join_table asc' );

		return $this->db->get();
	}

	function count_media() {
		return $this->db->query("select count(id) as numrows from media")->row()->numrows;
	}

	function count_media_groups() {
		return $this->db->query("select count(id) as numrows from media_groups")->row()->numrows;
	}

	function count_media_with_meta_and_keywords( $keywords = array(), $elements = array(), $groups = array(), $start = 0, $count = 20 ){
		return $this->get_all_with_meta_and_keywords( $keywords, $elements, $groups, 0, 0, true )->num_rows();
	}

	function numItemsByJoinTables( $join_tables ) {

		$where_clause = "";
		if(null != $join_tables){
			$where_clause = "where ";
			$join_tables = "'" . implode("','", explode(",", $join_tables)) . "'";
			$where_clause = " WHERE join_media_anything.foreign_join_table IN ($join_tables) ";
		}

		$sql = "SELECT count(`media`.id) as numrows 
				FROM (`media`) 
				LEFT JOIN `join_media_anything` ON `media`.`id` = `join_media_anything`.`media_id`
				$where_clause";

		return $this->db->query($sql)->row()->numrows;
	}

	/**************/
	/**** CRUD ****/
	function add( $data ) {
		$this->db->insert( 'media', $data );
		return $this->db->insert_id();
	}

	function add_media_group( $data ) {
		$this->db->insert( 'media_groups', $data );
		return $this->db->insert_id();
	}

	function add_media_to_group( $media, $group ) {

		foreach( $media as $id ) {
			$this->db->delete( 'join_media_groups', array( 'media_id' => $id, 'media_group_id' => $group ));
			$this->db->insert( 'join_media_groups', array( 'media_id' => $id, 'media_group_id' => $group ));
		}
	}

	function add_media_to_element( $media_id, $element, $element_id ) {

		if(	isset( $media_id ) && isset( $element ) && isset( $element_id )) {
			$this->db->delete( 'join_media_anything',
				array( 'media_id' => $media_id, 'foreign_join_table' => $element, 'foreign_table_row_id' => $element_id ));

			$this->db->insert('join_media_anything',
				array( 'media_id' => $media_id, 'foreign_join_table' => $element, 'foreign_table_row_id' => $element_id ));
		}
	}

	function update( $id, $values ) {
		$this->db->where(	'id', 		$id );
		$this->db->update(	'media',	$values );

		return TRUE;
	}

	function update_media_group( $id, $values ) {
		$this->db->where(	'id', 			$id );
		$this->db->update(	'media_groups',	$values );

		return TRUE;
	}

	function delete($id){
		$this->db->delete('join_media_groups',		array('media_id' => $id));
		$this->db->delete('join_media_anything',	array('media_id' => $id));
		$this->db->delete('media',					array('id' 		 => $id)); 
	}

	function delete_media_group( $id ){
		$this->db->delete('join_media_groups',		array('media_group_id' => $id));
		$this->db->delete('media_groups',			array('id' 		 => $id)); 
	}

	function update_people_join($mediaId, $persondId){
		$this->update_anything_join($mediaId, 'person', $persondId);
	}

	function update_publication_join($mediaId, $publicationId){
		$this->update_anything_join($mediaId, 'publications', $publicationId);
	}

	function update_anything_join( $mediaId, $foreign_join_table, $foreign_table_row_id ){
		$data = array(
			'media_id' =>  $mediaId,
			'foreign_join_table' => $foreign_join_table,
			'foreign_table_row_id' => $foreign_table_row_id
		);

		$this->db->insert('join_media_anything', $data);
	}



}