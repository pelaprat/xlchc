<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public

	function search_symposia( $keywords ) {
		$this->db->select( 'symposia.*, symposia.id as symposium_id, tags.name as tag_name' );
		$this->db->from( 'symposia' );
		$this->db->join( 'tags_symposia',	'symposia.id = tags_symposia.symposium_id', 'left outer');
		$this->db->join( 'tags',			'tags_symposia.tag_id = tags.id', 'left outer');

		foreach( $keywords as $keyword ) {
			$this->db->or_like( 'subject',		$keyword );
			$this->db->or_like( 'summary', 		$keyword );
			$this->db->or_like( 'tags.name',	$keyword );
		}

		$this->db->order_by( 'votes desc' );

		$symposia	= array();
		$results	= $this->db->get();
		foreach( $results->result() as $result ) {

			// Check this symposium
			if( isset( $symposia[$result->symposium_id] )) {
				if( isset( $result->tag_name ) && $this->in_arrayi( $result->tag_name, $keywords )) {
					$symposia[$result->symposium_id]['score'] += 10;
				} else {
					$symposia[$result->symposium_id]['score']++;
				}
			} else {
				$symposia[$result->symposium_id]['score']	= 1;
				$symposia[$result->symposium_id]['data']	= $result;

				// Get the comments for these symposia
				//  that match our search criteria
				$this->db->select(	'comments_symposia.*, comments_symposia.id as comments_symposia_id, people.*, people.id as person_id' );
				$this->db->from(	'comments_symposia' );
				$this->db->join( 	'people', 		'comments_symposia.person_id = people.id');
				$this->db->where(	'symposium_id',	$result->symposium_id );
				$this->db->like( 	'comment',		$keyword );
				$this->db->order_by( 'comments_symposia.created_at desc' );

				$symposia[$result->symposium_id]['comments'] = $this->db->get();
			}
		}

	    function score_sort( $a,$b ) {
	         return $a['score'] > $b['score'];
		}

		usort( $symposia, "score_sort" );

		return $symposia;
	}


	function search_conversations( $keywords ) {
		$this->db->select( 'conversations.*, conversations.id as conversation_id, tags.name as tag_name' );
		$this->db->from( 'conversations' );
		$this->db->join( 'tags_conversations',	'conversations.id = tags_conversations.conversation_id', 'left outer');
		$this->db->join( 'tags',			'tags_conversations.tag_id = tags.id', 'left outer');

		foreach( $keywords as $keyword ) {
			$this->db->or_like( 'subject',		$keyword );
			$this->db->or_like( 'summary', 		$keyword );
			$this->db->or_like( 'tags.name',	$keyword );
		}

		$this->db->order_by( 'votes desc' );

		$conversations	= array();
		$results	= $this->db->get();
		foreach( $results->result() as $result ) {

			// Check this conversation
			if( isset( $conversations[$result->conversation_id] )) {
				if( isset( $result->tag_name ) && $this->in_arrayi( $result->tag_name, $keywords )) {
					$conversations[$result->conversation_id]['score'] += 10;
				} else {
					$conversations[$result->conversation_id]['score']++;
				}
			} else {
				$conversations[$result->conversation_id]['score']	= 1;
				$conversations[$result->conversation_id]['data']	= $result;

				// Get the comments for these conversations
				//  that match our search criteria
				$this->db->select(	'comments_conversations.*, comments_conversations.id as comments_conversations_id, people.*, people.id as person_id' );
				$this->db->from(	'comments_conversations' );
				$this->db->join( 	'people', 			'comments_conversations.person_id = people.id');
				$this->db->where(	'conversation_id',	$result->conversation_id );
				$this->db->like( 	'comment',			$keyword );
				$this->db->order_by( 'comments_conversations.created_at desc' );

				$conversations[$result->conversation_id]['comments'] = $this->db->get();
			}
		}

		usort( $conversations, "score_sort" );

		return $conversations;
	}

	private

	function in_arrayi( $needle, $haystack ) {
		for($h = 0 ; $h < count($haystack) ; $h++) {
			$haystack[$h] = strtolower($haystack[$h]);
		}
		return in_array(strtolower($needle),$haystack);
	}
}