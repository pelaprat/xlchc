<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

	/*******************/
	/** Get Functions **/
    function get_all( $limit = NULL, $offset = NULL ) {
		$this->db->select('*');
		$this->db->from('tags');
		$this->db->order_by( 'name asc' );
        $this->db->limit( $limit, $offset );
        
        return $this->db->get();
    }

	function get_tag_by_id( $id ) {
		$this->db->select('*');
		$this->db->from("tags");
		$this->db->where(array("id" => $id));
		return $this->db->get()->row();
	}

	function get_tag_by_name( $name ) {
		$this->db->select('*');
		$this->db->from("tags");
		$this->db->where( array( "name" => $name ));
		return $this->db->get()->row();
	}

	function num_tags() {
		$this->db->select('count(id) as numrows');
		$this->db->from('tags');

		return $this->db->get()->row()->numrows;
	}

	/**********/
	/** CRUD **/
	function add( $values ) {
		$this->db->insert( 'tags', $values );
		return $this->db->insert_id();
	}

	function update( $id, $values ) {
		$this->db->where(	'id',	$id);
		$this->db->update(	'tags',	$values );

		return TRUE;
	}

    function delete_all( $id ){

        $this->db->delete('tags',					array(	'id'		=> $id ));
        $this->db->delete('tags_people',			array(	'tag_id'	=> $id ));
        $this->db->delete('tags_conversations',		array(	'tag_id'	=> $id ));
        $this->db->delete('tags_symposia',			array(	'tag_id'	=> $id ));
        $this->db->delete('tags_symposia_chapters',	array(	'tag_id'	=> $id ));

		return true;
    }

	/*****************/
	/** Get methods **/
	function get_tags_for_tagable( $tagable_s, $tagable_p, $tagable ) {
		$this->db->select( 'tags_' . $tagable_p . '.id as join_id, ' . $tagable_s . '_id, tags.*, tags.id as tag_id ');
		$this->db->from(   'tags_' . $tagable_p );
		$this->db->join(   'tags', 'tags_' . $tagable_p . '.tag_id = tags.id', 'left inner');
		$this->db->order_by( 'name asc');

		if( is_array( $tagable )) {
			$this->db->where_in( $tagable_s . '_id', $tagable);
		} else {
			$this->db->where( array( $tagable_s . '_id' => $tagable ));
		}

		return $this->db->get();
	}

	function get_tags_for_conversation( $conversation ) {
		return $this->get_tags_for_tagable( 'conversation', 'conversations', $conversation );
	}

	function get_tags_for_conversations( $conversations ) {
		return $this->get_tags_for_tagable( 'conversation', 'conversations', $conversations );
	}

	function get_tags_for_symposium( $symposium ) {
		return $this->get_tags_for_tagable( 'symposium', 'symposia', $symposium );
	}

	function get_tags_for_symposia( $symposia ) {
		return $this->get_tags_for_tagable( 'symposium', 'symposia', $symposia );
	}

	function get_tags_for_symposium_chapter( $symposium_chapter ) {
		return $this->get_tags_for_tagable( 'symposium_chapter', 'symposia_chapters', $symposium_chapter );
	}

	function get_tags_for_symposia_chapters( $symposia_chapters ) {
		return $this->get_tags_for_tagable( 'symposium_chapter', 'symposia_chapters', $symposia_chapters );
	}

	/*************************/
	/** Association Methods **/
	function tag_association_add( $tagable_s, $tagable_p, $tagable_id, $tag_id ) {
		$values = array(	$tagable_s . '_id'	=>	$tagable_id,
							'tag_id'			=>	$tag_id );

		$this->db->insert( 'tags_' . $tagable_p, $values );
	}

	function tag_association_data( $tagable_s, $tagable_p, $join_id ) {
		$this->db->select( 'tags_' . $tagable_p . '.*' );
		$this->db->from(   'tags_' . $tagable_p );
		$this->db->where(  'id', $join_id );

		return $this->db->get()->row();
	}

	function tag_association_delete( $tagable_s, $tagable_p, $join_id ) {
		$this->db->delete( 'tags_' . $tagable_p, array( 'id' => $join_id ));
	}

	function tag_association_exists( $tagable_s, $tagable_p, $tagable_id, $tag_id ) {
		$this->db->select('count(id) as n');
		$this->db->from( 'tags_' . $tagable_p );
		$this->db->where(
				array(	$tagable_s . '_id'	=> $tagable_id,
						'tag_id' 			=> $tag_id  ));

		if( $this->db->get()->row()->n > 0 ) {
			return true;
		}

		return false;
	}
}













