<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Symposium_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

	/**********/
	/** CRUD **/
	function add( $values ) {
		$this->db->insert( 'symposia', $values );
		return $this->db->insert_id();

	}

    function delete_symposium( $symposium_id ){

		// Load Comment model
		$this->load->model('Comment_model', '', TRUE);

		// Get all the chapters for this symposium
		//  and then delete them.
		$chapters = $this->get_symposium_chapters_by_id( $symposium_id );
		foreach( $chapters->result() as $chapter ) {
			$this->delete_symposium_chapter( $chapter->symposium_chapter_id );
		}

		// Get symposia comments;
		$comments = $this->Comment_model->get_comments_symposia_by_id( $symposium_id );
		foreach( $comments->result() as $comment ) {

			// Delete the comments votes
			$this->db->delete( 'vote_comments_symposia', array( 'comment_symposium_id' => $comment->comment_symposium_id ));			
		}

		// Delete symposia instructors
        $this->db->delete( 'symposia_instructors', array( 'symposium_id' => $symposium_id ));		

		// Delete symposia members
        $this->db->delete( 'symposia_members', array( 'symposium_id' => $symposium_id ));		

		// Delete symposia media
        $this->db->delete( 'join_media_anything',
			array(	'foreign_join_table'	=> 'symposium',
			 		'foreign_table_row_id'	=> $symposium_id ));

		// Delete comments, votes, and tags
        $this->db->delete( 'comments_symposia',	array( 'symposium_id' => $symposium_id ));
        $this->db->delete( 'vote_symposia',		array( 'symposium_id' => $symposium_id ));
		$this->db->delete( 'tags_symposia', 	array( 'symposium_id' => $symposium_id ));

		// Delete the symposium
        $this->db->delete( 'symposia', array( 'id' => $symposium_id ));
    }

	function update( $id, $values ) {
		$this->db->where( 'id', $id );
        $this->db->update( 'symposia', $values );
	}

	function set_instructors( $id, $instructors ) {

		// Delete existing instructors
		$this->db->where(  'symposium_id', $id );
		$this->db->delete( 'symposia_instructors' );

		// Now add the new ones
		foreach( $instructors as $instructor ) {

			$values = array(	'symposium_id'	=> $id,
								'person_id'		=> $instructor );

			$this->db->insert( 'symposia_instructors', $values );
		}

		return true;
	}

	function set_members( $id, $members ) {

		// Delete existing members
		$this->db->where(  'symposium_id', $id );
		$this->db->delete( 'symposia_members' );

		// Now add the new ones
		foreach( $members as $member ) {

			$values = array(	'symposium_id'	=> $id,
								'person_id'		=> $member );

			$this->db->insert( 'symposia_members', $values );
		}

		return true;
	}

	function set_media_for_symposium( $id, $media ) {

		$this->db->where( array(	'foreign_join_table' 	=> 'symposium',
									'foreign_table_row_id'	=> $id ));

		$this->db->delete( 'join_media_anything' );

		// Now add the new ones
		foreach( $media as $item ) {
			$values = array(	'media_id'				=> $item,
								'foreign_join_table'	=> 'symposium',
								'foreign_table_row_id'	=> $id );

			$this->db->insert( 'join_media_anything', $values );
		}

		return true;
	}

	function set_media_for_symposium_chapter( $id, $media ) {

		$this->db->where( array(	'foreign_join_table' 	=> 'symposium_chapter',
									'foreign_table_row_id'	=> $id ));

		$this->db->delete( 'join_media_anything' );

		// Now add the new ones
		foreach( $media as $item ) {
			$values = array(	'media_id'				=> $item,
								'foreign_join_table'	=> 'symposium_chapter',
								'foreign_table_row_id'	=> $id );

			$this->db->insert( 'join_media_anything', $values );
		}

		return true;
	}

	/*******************/
	/** Get Functions **/
    function get_all( $limit = NULL, $offset = NULL ){

        $this->db->select(	'symposia.*, symposia.id as symposium_id, symposia.created_at as symposium_created_at,               ' .
							'count(symposia_chapters.id) as symposia_chapters, count(comments_symposia.id) as comments_symposia_n' );
        $this->db->from("symposia");
		$this->db->join('symposia_chapters', 'symposia.id = symposia_chapters.symposium_id', 'left');
		$this->db->join('comments_symposia', 'symposia.id = comments_symposia.symposium_id', 'left');
		$this->db->group_by( 'symposia.id');
		$this->db->order_by('symposia.created_at asc');
		if( $limit != NULL && $offset != NULL )
		{
	        $this->db->limit( $limit, $offset );
		}

        return $this->db->get();
    }
    
    function get_symposium_by_id($id)
    {
        $this->db->select('symposia.*, symposia.id as symposium_id');
        $this->db->from("symposia");
        $this->db->where(array("symposia.id" => $id));
        return $this->db->get()->row();
    }
    
    function num_symposia() {
        return $this->db->query("select count(id) as numrows from symposia")->row()->numrows;
    }

	function get_symposia_instructors( $id ) {
		$this->db->select( "symposia_instructors.id as symposium_id, people.*, people.id as person_id" );
		$this->db->from('symposia_instructors');
		$this->db->join( 'people', 'symposia_instructors.person_id = people.id' );
		$this->db->where( array( 'symposia_instructors.symposium_id' => $id ) );
		$this->db->order_by( 'last asc' );
		return $this->db->get( );
	}

	function get_symposia_members( $id ) {
		$this->db->select( "symposia_members.id as symposium_id, people.*, people.id as person_id" );
		$this->db->from('symposia_members');
		$this->db->join( 'people', 'symposia_members.person_id = people.id' );
		$this->db->where( array( 'symposia_members.symposium_id' => $id ) );
		$this->db->order_by( 'last asc' );
		return $this->db->get( );
	}

	function get_symposia_media( $id ) {

		$media = array();

		// Get a query limiting the media id to what belongs to the symposium
		$this->db->select( 'media_id' );
		$this->db->from( 'join_media_anything' );
		$this->db->join( 'media', 'join_media_anything.media_id = media.id' );
		$this->db->where( array( 'foreign_join_table' => "'symposium'", 'foreign_table_row_id' => $id ), NULL, FALSE );
		$sub_query = $this->db->get_compiled_select();
		$this->db->_reset_select();

		// Now get the publications
		$this->db->select( 'join_media_anything.*, media.*, publications.*, publications.id as publication_id ');
		$this->db->from( 'join_media_anything' );
		$this->db->join( 'media', 'join_media_anything.media_id = media.id' );
		$this->db->join( 'publications', 'join_media_anything.foreign_table_row_id = publications.id', 'left outer' );
		$this->db->where( 'foreign_join_table', 'publications' );
		$this->db->where( "media_id in ($sub_query)", NULL, FALSE );

		// Go through each media item and put it in our array
		$publication_media_ids	= array();
		$publications			= $this->db->get( );
		foreach( $publications->result() as $publication ) {
			if( isset( $media[$publication->media_id] ) === false ) {
				$media[$publication->media_id] = $publication;
				array_push( $publication_media_ids, $publication->media_id );
			}
		}

		// Now get the non-publications for this symposia
		$this->db->select( 'join_media_anything.*, media.*' );
		$this->db->from( 'join_media_anything' );
		$this->db->join( 'media', 'join_media_anything.media_id = media.id' );
		$this->db->where( "media_id in ($sub_query)", NULL, FALSE );
		if( count( $publication_media_ids ) > 0 ) {
			$this->db->where_not_in( 'media_id', $publication_media_ids );
		}

		// Get those media items
		$other = $this->db->get( );
		foreach( $other->result() as $item ) {
			if( isset( $media[$item->media_id] ) === false ) {
				$media[$item->media_id] = $item;
			}
		}
	
		return $media;
	}

	function get_symposia_chapters_media( $id ) {

		$media = array();

		// Get a query limiting the media id to what belongs to the symposium chapter
		$this->db->select( 'media_id' );
		$this->db->from( 'join_media_anything' );
		$this->db->join( 'media', 'join_media_anything.media_id = media.id' );
		$this->db->where( array( 'foreign_join_table' => "'symposium_chapter'", 'foreign_table_row_id' => $id ), NULL, FALSE );
		$sub_query = $this->db->get_compiled_select();
		$this->db->_reset_select();

		// Now get the publications
		$this->db->select( 'join_media_anything.*, media.*, publications.*, publications.id as publication_id ');
		$this->db->from( 'join_media_anything' );
		$this->db->join( 'media', 'join_media_anything.media_id = media.id' );
		$this->db->join( 'publications', 'join_media_anything.foreign_table_row_id = publications.id', 'left outer' );
		$this->db->where( 'foreign_join_table', 'publications' );
		$this->db->where( "media_id in ($sub_query)", NULL, FALSE );

		// Go through each media item and put it in our array
		$publication_media_ids	= array();
		$publications			= $this->db->get( );
		foreach( $publications->result() as $publication ) {
			if( isset( $media[$publication->media_id] ) === false ) {
				$media[$publication->media_id] = $publication;
				array_push( $publication_media_ids, $publication->media_id );
			}
		}

		// Now get the non-publications for this symposia
		$this->db->select( 'join_media_anything.*, media.*' );
		$this->db->from( 'join_media_anything' );
		$this->db->join( 'media', 'join_media_anything.media_id = media.id' );
		$this->db->where( "media_id in ($sub_query)", NULL, FALSE );

		if( count( $publication_media_ids ) > 0 ) {
			$this->db->where_not_in( 'media_id', $publication_media_ids );
		}

		// Get those media items
		$other = $this->db->get( );
		foreach( $other->result() as $item ) {
			if( isset( $media[$item->media_id] ) === false ) {
				$media[$item->media_id] = $item;
			}
		}
	
		return $media;
	}

	function is_person_member_of_symposium( $person_id, $symposium_id ) {
		$this->db->select('id');
		$this->db->from('symposia_members');
		$this->db->where( array( 'person_id' => $person_id, 'symposium_id' => $symposium_id ));
		$result = $this->db->get();

		if( $result->num_rows() > 0 ) {
			return true;
		}

		return false;
	}

	/***********************/
	/** Chapter Functions **/
	function add_chapter( $values ) {
		$this->db->insert( 'symposia_chapters', $values );
		return $this->db->insert_id();
	}

	function update_chapter( $id, $values ) {
		$this->db->where( 'id', $id );
        $this->db->update( 'symposia_chapters', $values );
	}

	function delete_symposium_chapter( $symposium_chapter_id ) {

		// Load Comment model
		$this->load->model('Comment_model', '', TRUE);

		// Get chapter comments;
		$comments = $this->Comment_model->get_comments_symposia_chapters_by_id( $symposium_chapter_id );
		foreach( $comments->result() as $comment ) {

			// Delete the chapter comments votes
			$this->db->delete( 'vote_comments_symposia_chapters', array( 'comment_symposium_chapter_id' => $comment->comment_symposium_chapter_id ));			
		}

		// Delete chapter comments
		$this->db->delete( 'comments_symposia_chapters', array( 'symposium_chapter_id' => $symposium_chapter_id ));			

		// Delete chapter votes
		$this->db->delete( 'vote_symposia_chapters', array( 'symposium_chapter_id' => $symposium_chapter_id ));

		// Delete chapter tags
		$this->db->delete( 'tags_symposia_chapters', array( 'symposium_chapter_id' => $symposium_chapter_id ));

		// Delete the chapter
		$this->db->delete( 'symposia_chapters', array( 'id' => $symposium_chapter_id ));
	}

	function get_symposium_chapter_by_id( $symposium_chapter_id = -1 ) {
		$this->db->select( 'symposia_chapters.*, symposia_chapters.id as symposium_chapter_id, symposia_chapters.created_at as symposium_chapter_created_at, people.*, people.id as person_id' );
		$this->db->from( 'symposia_chapters' );
		$this->db->join( 'people', 'symposia_chapters.person_id = people.id', 'inner join' );
		$this->db->where( 'symposia_chapters.id', $symposium_chapter_id );

        return $this->db->get()->row();
	}

	function get_symposium_chapters_by_id( $symposium_id = -1 ) {
		$this->db->select('*, symposia_chapters.id as symposium_chapter_id, people.id as person_id, symposia_chapters.created_at as symposium_chapter_created_at');
		$this->db->from( 'symposia_chapters' );
		$this->db->join( 'people', 'symposia_chapters.person_id = people.id', 'inner join' );
		$this->db->where( 'symposium_id', $symposium_id );
		$this->db->order_by( 'symposia_chapters.created_at asc');

        return $this->db->get();
	}

	/***********/
	/** View  **/
	function up_view( $id ) {
		$sql = "UPDATE symposia set views = views + 1 where id = $id";
        $this->db->query($sql);

		if( $this->db->affected_rows() >= 0 ) {
			return TRUE;
		}

		return FALSE;
	}

}