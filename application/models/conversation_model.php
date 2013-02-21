<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conversation_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function get_all( $scored = FALSE, $limit = NULL, $offset = NULL ){

		$this->db->select(	'conversations.*, conversations.id as conversation_id, conversations.created_at as conversation_created_at, ' .
							'people.id as person_id, people.first, people.last,		 ' .
							'count(comments_conversations.id) as comments_conversations ');

		if( $scored == TRUE ) {
			$this->db->select(	'(0.5)  / greatest( 1, least( 31, datediff( now(), conversations.created_at ))) + ' .
								'(0.25) * greatest( 1, least( 100, reputation )) / 100 +						  ' .
								'(0.25) * greatest( 1, least( 100, conversations.votes )) / 100 as score		  ');
		}

		$this->db->from("conversations");

		$this->db->join('people',  'conversations.person_id = people.id', 'left inner');
		$this->db->join('comments_conversations', 'conversations.id = comments_conversations.conversation_id', 'left');

		$this->db->group_by( 'conversations.id');

		if( $scored == TRUE ) {
			$this->db->order_by( "score desc" );
		} else {
			$this->db->order_by('conversations.created_at asc');
		}

		$this->db->limit( $limit, $offset );

		return $this->db->get();
	}
	
	function get_conversation_by_id($id)
	{
		$this->db->select('people.*, people.id as person_id, conversations.*, conversations.id as conversation_id');
		$this->db->from("conversations");
		$this->db->join( 'people', 'conversations.person_id = people.id', 'inner join');
		$this->db->where(array("conversations.id" => $id));
		return $this->db->get()->row();
	}

	function get_people_subscribed( $id ) {

		$this->db->select(	'people.id as person_id, people.first, people.last, people.email' );
		$this->db->from(	'join_conversations_people' );
		$this->db->join(	'people', 'join_conversations_people.person_id = people.id', 'inner join');
		$this->db->where(	'join_conversations_people.conversation_id', $id );
		return $this->db->get();
	}

	function get_conversation_by_last_24_hours( ) {

		$this->db->select(	'*' );
		$this->db->from(	'conversations' );
		$this->db->where(	'created_at > now() - INTERVAL 24 hour' );

		return $this->db->get();
	}

	function get_last_conversation_comments( ) {

		$this->db->select( 'cc.id, cc.person_id, cc.conversation_id, cc.created_at, p.first, p.last, p.id as person_id');
		$this->db->from("(select conversation_id, max(created_at) as max_created_at from comments_conversations group by conversation_id) as x");
		$this->db->join( 'comments_conversations as cc', 'cc.conversation_id = x.conversation_id and cc.created_at = x.max_created_at', 'inner join');
		$this->db->join( 'people p', 'cc.person_id = p.id', 'inner join');

		return $this->db->get();
	}

	function num_conversations() {
		return $this->db->query("select count(id) as numrows from conversations")->row()->numrows;
	}

	/**********/
	/** CRUD **/
	function add( $values ) {
		$this->db->insert( 'conversations', $values );
		return $this->db->insert_id();

	}

	function delete( $id ) {

		// Delete all the votes for the comments for a conversation
		// Which means we need to get all the comments first.
		$this->db->select(	'comments_conversations.id' );
		$this->db->from(	'comments_conversations'	);
		$this->db->where(	'conversation_id', $id 		);
		$results = $this->db->get();
		$comment_ids = array();
		foreach( $results->result() as $result ) {
			array_push( $comment_ids, $result->id );
		}

		// Now delete the votes and attachments for these comments
		if( count( $comment_ids ) > 0 ) {

			// Votes
			$this->db->where_in( 'comment_conversation_id', $comment_ids );
			$this->db->delete( 'vote_comments_conversations' );

			// Attachments
			$this->db->where(		'comment_type', 	'conversation' );
			$this->db->where_in(	'comment_id',		$comment_ids );
			$this->db->delete(		'comments_attachments' );
		}


		// Now do the rest
		$this->db->delete( 'comments_conversations',	array( 'conversation_id'	=> $id)); 
		$this->db->delete( 'vote_conversations',		array( 'conversation_id'	=> $id)); 
		$this->db->delete( 'tags_conversations',		array( 'conversation_id'	=> $id)); 
		$this->db->delete( 'conversations',				array( 'id'					=> $id)); 
	}

	function update( $id, $values ) {
		$this->db->where(	'id',				$id);
		$this->db->update(	'conversations',	$values );

		return TRUE;
	}

	/***********/
	/** OTHER **/
	function up_view( $id ) {
		$sql = "UPDATE conversations set views = views + 1 where id = $id";
		$this->db->query($sql);

		if( $this->db->affected_rows() >= 0 ) {
			return TRUE;
		}

		return FALSE;
	}

}