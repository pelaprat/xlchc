<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function num_comments() {
		return $this->db->query("select count(id) as numrows from comments")->row()->numrows;
	}

	/**********/
	/** CRUD **/
	function add( $commentable_s, $commentable_p, $values ) {

		$this->db->insert( 'comments_' . $commentable_p, $values );

		return $this->db->insert_id();
	}


	/*******************/
	/** Get Functions **/
	/*******************/

	function get_commentable_comment_by_id( $commentable_s, $commentable_p, $comment_id = -1 ) {

		$this->db->select(	'comments_' . $commentable_p . '.*,' .
							'comments_' . $commentable_p . '.id as ' . 'comment_' . $commentable_s . '_id, '. 
							'people.*, people.id as person_id' );

		$this->db->from( 'comments_' . $commentable_p );
		$this->db->join( 'people', 'comments_' . $commentable_p . '.person_id = people.id', 'inner join' );
		$this->db->where( 'comments_' . $commentable_p . '.id', $comment_id );

        return $this->db->get()->row();
	}

	function get_commentable_comments_by_id( $commentable_s, $commentable_p, $commentable_id = -1 ) {

		$this->db->select(	'*, ' .
							'comments_' . $commentable_p . '.id as comment_' . $commentable_s . '_id, ' .
							'people.id as person_id, ' . 
							'comments_' . $commentable_p . '.created_at as ' . 'comment_' . $commentable_s . '_created_at' );

		$this->db->from( 'comments_' . $commentable_p );

		$this->db->join( 'people', 'comments_' . $commentable_p . '.person_id = people.id', 'inner join' );
		$this->db->where( $commentable_s . '_id', $commentable_id );
		$this->db->order_by( 'comments_' . $commentable_p . '.created_at asc');

        return $this->db->get();
	}

	function get_comments_conversations_by_id( $conversation_id = -1 ) {
		return $this->get_commentable_comments_by_id( 'conversation', 'conversations', $conversation_id );
	}

	function get_comment_conversation_by_id( $comment_conversation_id = -1 ) {
		return $this->get_commentable_comment_by_id( 'conversation', 'conversations', $comment_conversation_id );
	}

	function get_comments_symposia_by_id( $symposium_id = -1 ) {
		return $this->get_commentable_comments_by_id( 'symposium', 'symposia', $symposium_id );
	}

	function get_comments_symposia_chapters_by_id( $symposium_chapter_id = -1 ) {
		return $this->get_commentable_comments_by_id( 'symposium_chapter', 'symposia_chapters', $symposium_chapter_id );
	}

	function get_comment_symposium_by_id( $comment_symposium_id = -1 ) {
		return $this->get_commentable_comment_by_id( 'symposium', 'symposia', $comment_symposium_id );
	}

	function get_comment_symposium_chapter_by_id( $comment_symposium_chapter_id = -1 ) {
		return $this->get_commentable_comment_by_id( 'symposium_chapter', 'symposia_chapters', $comment_symposium_chapter_id );
	}


	/**************************/
	/** Attachment Functions **/
	function attach_media_to_comment( $data ) {
		if(	! isset( $data['comment_type'] ) || ! isset( $data['comment_id'] ) ||
			! isset( $data['filename']     ) || ! isset( $data['media_id']   )) {

			return false;
		} else {

			// Delete this attachment first if there.
			$this->db->delete( 'comments_attachments',
				array(	'media_id'		=> $data['media_id'],
				 		'comment_type'	=> $data['comment_type'],
						'comment_id'	=> $data['comment_id'] ));

			// Now insert the new attachment
			$this->db->insert( 'comments_attachments', $data );
			return $this->db->insert_id();
		}
	}

	function get_attachments_for_comments( $commentable_s, $comments ) {

		// Make this an array
		if( ! is_array( $comments )) {
			$comments = array( $comments );
		}

		$this->db->select(	"comments_attachments.*, media.*" );
		$this->db->from(	'comments_attachments' );
		$this->db->join(	'media', 'comments_attachments.media_id = media.id' );
		$this->db->where(	'comment_type', $commentable_s );
		$this->db->where_in('comment_id', $comments );
		return $this->db->get();
	}


}
