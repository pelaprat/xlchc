<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class People_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function validate() {

        $errors		= array();
        $email		= isset( $_POST['email'] )		? trim( $_POST['email'] )		: "";
        $password	= isset( $_POST['password'] )	? trim( $_POST['password'] )	: "";
        
        if( "" === $email)		array_push( $errors, "noe" );
        if( "" === $password)	array_push( $errors, "nop" );
        
        if( "" != $email ) {

			$this->load->model('People_model', '', TRUE);

			$p = $this->People_model->get_people_table_only_by_email( $email );

			if( null == $p ){
				array_push( $errors, "bademail" );

			} else if( "" != $password ) {
				$pw_hash = sha1( $p->pw_salt . $this->input->post('password') );

				if( $pw_hash !== $p->pw_hash ){
					array_push( $errors, "nomatch" );

				} else {
					$p->pw_salt = ""; $p->pw_hash =  $p->biography = "";
					$this->session->set_userdata( 'user-info', $p );

					return true;
				}
			}
		}

		return false;
	}

	function reload_cached_user_info( ) {
		if( $this->current_user != null && $this->current_user->id > 0 ) {

			// Get the data
			$p = $this->People_model->get_people_table_only_by_email( $this->current_user->email );

			// Protect critical information
			$p->pw_salt = ""; $p->pw_hash =  $p->biography = "";

			// Enter into the session
			$this->session->set_userdata( 'user-info', $p );

			return true;
		} else {
			return false;
		}
	}

	function count_people( $spam = NULL ) {
		return $this->get_people( TRUE )->num_rows();
	}

	/*************************************/
	/** Reputation and Points Functions **/
	/*************************************/
	function down_point( $id, $amount ) {
        $query = $this->db->query("	UPDATE `people` SET `points` = `points` - $amount
									WHERE `id` = '$id'");
	}

	function down_reputation( $id, $amount ) {
        $query = $this->db->query("	UPDATE `people` SET `reputation` = `reputation` - $amount
									WHERE `id` = '$id'");
	}

	function up_point( $id, $amount ) {
        $query = $this->db->query("	UPDATE `people` SET `points` = `points` + $amount
									WHERE `id` = '$id'");
	}

	function up_reputation( $id, $amount ) {
        $query = $this->db->query("	UPDATE `people` SET `reputation` = `reputation` + $amount
									WHERE `id` = '$id'");
	}

	function earn_reputation( $for, $from, $amount ) {
		if( $for != $from ) {
			$this->up_reputation( $for, $amount );
		}
	}

	function lose_reputation( $for, $from, $amount ) {
		if( $for != $from ) {
			$this->down_reputation( $for, $amount );
		}
	}

	/*******************/
	/** Add Functions **/
	/*******************/

	function add_person( $data ) {
		$this->db->insert('people', $data );
		return $this->db->insert_id();
	}

	function add_person_to_group( $person, $group ) {

		// Drop old shiz.
		$this->db->where( array(	'person_id' => $person,
				  	 				'xgroup_id' => $group ));
		$this->db->delete( 'join_xgroups_people' );

		// Insert new shiz.
		$this->db->insert(	'join_xgroups_people', array( 'person_id' => $person,
							'xgroup_id' => $group ));
	}

	function add_person_to_conversation( $person, $conversation ) {

		// Drop old shiz.
		$this->remove_person_from_conversation( $person, $conversation );

		// Insert new shiz.
		$this->db->insert(	'join_conversations_people',
							array(	'person_id'			=> $person,
									'conversation_id'	=> $conversation ));
	}

	/**********************/
	/** Remove Functions **/
	/**********************/

	function remove_person_from_conversation( $person, $conversation ) {

		// Drop old shiz.
		$this->db->where( array(	'person_id'			=> $person,
				  	 				'conversation_id'	=> $conversation ));
		$this->db->delete( 'join_conversations_people' );

	}
	/*******************/
	/** Get Functions **/
	/*******************/

	function get_people_alphabetically( $spam = NULL, $limit = NULL, $offset = NULL ) {
		$this->db->select('*, people.id as person_id ');
		$this->db->join('join_xgroups_people', 'join_xgroups_people.person_id = people.id', 'left outer');

		if( isset($spam) && ( $spam == 1 || $spam == TRUE )) {
		   $this->db->where(	array( 'join_xgroups_people.xgroup_id !=' => 1 ));
		   $this->db->or_where( array( 'join_xgroups_people.xgroup_id' => NULL ));
		   $this->db->group_by('people.id');
		}

		$this->db->order_by('last asc, first asc');
		if( $limit != NULL && $offset != NULL )
		{
	        $this->db->limit( $limit, $offset );
		}

		$query = $this->db->get('people');

		return $query;
	}

	function get_people( $spam = NULL, $limit = NULL, $offset = NULL ) {

		$this->db->select('*');
		$this->db->join('join_xgroups_people', 'join_xgroups_people.person_id = people.id', 'left outer');

		if( isset($spam) && ( $spam == 1 || $spam == TRUE )) {
		   $this->db->where(	array( 'join_xgroups_people.xgroup_id !=' => 9 ));
		   $this->db->or_where( array( 'join_xgroups_people.xgroup_id' => NULL ));
		   $this->db->group_by('people.id');
		}

		$this->db->order_by('last asc, first asc');
		if( $limit != NULL && $offset != NULL )
		{
	        $this->db->limit( $limit, $offset );
		}
		$query = $this->db->get('people');

		return $query;
	}

	function get_people_subscribed_to_digest( ) {

		$this->db->select('id as person_id, first, last, email');
		$query = $this->db->get_where('people', array( 'pref_notify_conversation_digest' => 1 ));

		return $query;
	}

	function get_people_by_slug($slug) {

		$this->db->select('*');
		$this->db->join('join_xgroups_people', 'join_xgroups_people.person_id = people.id', 'left outer');
		$this->db->order_by('last asc, first asc');
		$query = $this->db->get_where('people', array('slug' => $slug));

		return $query->first_row();
	}

	function get_people_by_id($id) {

        /*
		$this->db->select('people.*, media.id as media_id, media.uuid, media.mime_type');
		$this->db->join('join_xgroups_people', 'join_xgroups_people.person_id = people.id', 'left outer');
		$this->db->join('join_media_people', 'join_media_people.person_id = people.id', 'left');
		$this->db->join('media', 'media.id = join_media_people.media_id', 'left');
		$this->db->order_by('last asc, first asc');
		$query = $this->db->get_where('people', array('people.id' => $id));
        */

		$this->db->select('people.*, people.id as person_id, media.id as media_id, media.uuid, media.mime_type');
		$this->db->join('join_xgroups_people', 'join_xgroups_people.person_id = people.id', 'left outer');
		$this->db->join('join_media_anything', 'join_media_anything.foreign_table_row_id = people.id', 'left outer');
		$this->db->join('media', 'media.id = join_media_anything.media_id', 'left outer'); 
		$this->db->order_by('last asc, first asc');

		$query = $this->db->get_where('people', array( 'people.id' => $id ));

/*		                                              'join_media_anything.foreign_join_table' => 'person')); */

		return $query->first_row();
	}

	function get_people_by_xgroup( $group ) {

		$this->db->select('*, people.id as person_id');
		$this->db->join('join_xgroups_people', 'join_xgroups_people.person_id = people.id', 'left');
		$this->db->join('xgroups', 'xgroups.id = join_xgroups_people.xgroup_id', 'left');
		$this->db->order_by('last asc, first asc');
		$query = $this->db->get_where('people', array('xgroups.id' => $group ));

		return $query;
	}

	function get_people_by_email($email) {

		$this->db->select('*');
		$this->db->order_by('last asc, first asc');
		$query = $this->db->get_where('people', array('email' => $email));

		return $query;
	}

	function get_people_by_name( $last, $first ) {

		$this->db->select('*');
		$this->db->order_by('last asc, first asc');
		$query = $this->db->get_where('people', array('first' => $first,
			   	 			      'last'  => $last ));

		return $query;
	}
	
	function get_people_table_only_by_email($email) {

		$this->db->select('*');
		$query = $this->db->get_where('people', array('email' => $email));

		return $query->first_row();
	}

	function get_person_groups( $id ) {

		 $this->db->select('join_xgroups_people.xgroup_id as id');
		 $this->db->order_by('xgroup_id asc');
		 $query = $this->db->get_where('join_xgroups_people', array( 'person_id' => $id ));

		 return $query;
	}

	function set_person_pw_hash( $id, $new_hash ) {
		$this->db->where('id', $id);
		$this->db->update('people', array('pw_hash' => $new_hash));
	}

	/******************/
	/** Is Functions **/
	/******************/
	function is_person_subscribed_to_conversation( $id, $conversation ) {

		$this->db->where(array( 'person_id' => $id, 'conversation_id' => $conversation ));
		$query = $this->db->get('join_conversations_people');
		if ($query->num_rows() > 0){
			return true;
		}
		else {
			return false;
		}
	}

}

/* End of file people_model.php */
/* Location: ./application/models/people_model.php */
