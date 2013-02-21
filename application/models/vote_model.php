<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

	/**********************/
	/** Exists Functions **/
	/**********************/
	function exists_vote_on_votable( $person, $votable_s, $votable_p, $votable ) {
		$this->db->select( 'vote' );
		$query = $this->db->get_where((	'vote_' . $votable_p ),
										array(	  'person_id'			=> $person,
												( $votable_s. '_id')	=> $votable ));

		if( $row = $query->first_row() ) {
			return $row->vote;
		}

		return 0;
	}

	function exists_vote_on_conversation( $person, $conversation ) {
		return $this->exists_vote_on_votable( $person, 'conversation', 'conversations', $conversation );
	}

	function exists_vote_on_comment_conversation( $person, $comment_conversation ) {
		return $this->exists_vote_on_votable( $person, 'comment_conversation', 'comments_conversations', $answer );
	}

	function exists_vote_on_symposium( $person, $symposium ) {
		return $this->exists_vote_on_votable( $person, 'symposium', 'symposia', $symposium );
	}

	function exists_vote_on_symposium_chapter( $person, $symposium_chapter ) {
		return $this->exists_vote_on_votable( $person, 'symposium_chapter', 'symposia_chapters', $symposium_chapter );
	}

	/*******************/
	/** Get Functions **/
	/*******************/
	function get_votes_on_votable_by_id( $person_id, $votable_s, $votable_p, $parent_field, $parent_id ) {
		$this->db->select( 'vote_' . $votable_p . '.' . $votable_s . '_id, ' . 'vote_' . $votable_p. '.vote' );
		$this->db->from( 'vote_' . $votable_p );
		$this->db->join( $votable_p, $votable_p . '.id = ' . 'vote_' . $votable_p. '.' . $votable_s . '_id', 'left inner');
		$this->db->where( array(	'vote_' . $votable_p . '.person_id'	=> $person_id,
									$parent_field 						=> $parent_id ));

		return $this->db->get();
	}

	function get_votes_on_votable( $person, $votable_s, $votable_p, $votable ) {
		$this->db->select( 'vote_' . $votable_p . '.' . $votable_s . '_id, ' . 'vote_' . $votable_p. '.vote' );
		$this->db->from( 'vote_' . $votable_p );
		$this->db->join( $votable_p, $votable_p . '.id = ' . 'vote_' . $votable_p. '.' . $votable_s . '_id', 'left inner');
		$this->db->where( array(	'vote_' . $votable_p . '.person_id'		=> $person_id,
									$votable_p . '.' . $votable_s . '_id'	=>  $votable ));

		return $this->db->get();
	}

	function get_votes_on_comments_conversations( $person, $conversation_id ) {
		return $this->get_votes_on_votable_by_id( $person, 'comment_conversation', 'comments_conversations', 'conversation_id', $conversation_id );
	}

	function get_votes_on_comments_symposia( $person, $symposium_id ) {
		return $this->get_votes_on_votable_by_id( $person, 'comment_symposium', 'comments_symposia', 'symposium_id', $symposium_id );
	}

	function get_votes_on_comments_symposia_chapters( $person, $symposium__chapter_id ) {
		return $this->get_votes_on_votable_by_id( $person, 'comment_symposium_chapter', 'comments_symposia_chapters', 'symposium_chapter_id', $symposium__chapter_id );
	}

	/*******************/
	/** Set Functions **/
	/*******************/
	function set_vote_on_votable( $person, $votable_s, $votable_p, $votable, $vote ) {

		// Delete an existing record.
		$this->db->where( array( 'person_id' => $person, ($votable_s . '_id') => $votable ));
		$this->db->delete( 'vote_' . $votable_p );

		// Insert the new record
		$this->db->set( array( 'person_id' => $person, ($votable_s . '_id') => $votable, 'vote' => $vote ));
		$this->db->insert( 'vote_' . $votable_p );

		return 0;		
	}

	function set_vote_on_comment_conversation( $person, $comment_conversation, $vote ) {
		return $this->set_vote_on_votable( $person, 'comment_conversation', 'comments_conversations', $comment_conversation, $vote );
	}

	function set_vote_on_conversation( $person, $conversation, $vote ) {
		return $this->set_vote_on_votable( $person, 'conversation', 'conversations', $conversation, $vote );
	}

	function set_vote_on_symposium( $person, $symposium, $vote ) {
		return $this->set_vote_on_votable( $person, 'symposium', 'symposia', $symposium, $vote );
	}

	function set_vote_on_comment_symposium( $person, $comment_symposium, $vote ) {
		return $this->set_vote_on_votable( $person, 'comment_symposium', 'comments_symposia', $symposium, $vote );
	}

	function set_vote_on_symposium_chapter( $person, $symposium_chapter, $vote ) {
		return $this->set_vote_on_votable( $person, 'symposium_chapter', 'symposia_chapters', $symposium_chapter, $vote );
	}

	function set_vote_on_comment_symposium_chapter( $person, $comment_symposium_chapter, $vote ) {
		return $this->set_vote_on_votable( $person, 'comment_symposium_chapter', 'comments_symposia_chapters', $comment_symposium_chapter, $vote );
	}
}
