<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote extends CI_Controller {

	var $current_user;
	var $user_reputation_points;

	function __construct() {
		parent::__construct();

		// Load Vote model
		$this->load->model('Vote_model', '', TRUE );
		$this->load->model('People_model', '', TRUE );
		$this->load->model('Comment_model', '', TRUE );

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
	}

	// Upvoting
	function up( $votable, $identifier ) {

		$this->load_appropriate_models( $votable );

		if( $votable == 'conversation' ) {
			$y = $this->Conversation_model->get_conversation_by_id( $identifier );
			$x = $this->votable_upvote( 'conversation', 'conversations', $y->person_id, $identifier );
			return $this->conversation_action( $x, $identifier );			

		} elseif( $votable == 'comment_conversation' ) {
			$y = $this->Comment_model->get_comment_conversation_by_id( $identifier );
			$x = $this->votable_upvote( 'comment_conversation', 'comments_conversations', $y->person_id, $identifier );
			return $this->comment_conversation_action( $x, $y->conversation_id, $identifier );	

		} elseif( $votable == 'symposium' ) {
			$y = $this->Symposium_model->get_symposium_by_id( $identifier );
			$x = $this->votable_upvote( 'symposium', 'symposia', $y->person_id, $identifier );
			return $this->symposium_action( $x, $identifier );			

		} elseif( $votable == 'comment_symposium' ) {
			$y = $this->Comment_model->get_comment_symposium_by_id( $identifier );
			$x = $this->votable_upvote( 'comment_symposium', 'comments_symposia', $y->person_id, $identifier );
			return $this->comment_symposium_action( $x, $y->symposium_id, $identifier );			

		} elseif( $votable == 'symposium_chapter' ) {
			$y = $this->Symposium_model->get_symposium_chapter_by_id( $identifier );
			$x = $this->votable_upvote( 'symposium_chapter', 'symposia_chapters', $y->person_id, $identifier );
			return $this->symposium_chapter_action( $x, $identifier );			

		} elseif( $votable == 'comment_symposium_chapter' ) {
			$y = $this->Comment_model->get_comment_symposium_chapter_by_id( $identifier );
			$x = $this->votable_upvote( 'comment_symposium_chapter', 'comments_symposia_chapters', $y->person_id, $identifier );
			return $this->comment_symposium_chapter_action( $x, $y->symposium_chapter_id, $identifier );			

		} else {
			redirect( base_url() );
		}
	}

	// Downvoting
	function down( $votable, $identifier ) {

		$this->load_appropriate_models( $votable );

		if( $votable == 'conversation' ) {
			$y = $this->Conversation_model->get_conversation_by_id( $identifier );
			$x = $this->votable_downvote( 'conversation', 'conversations', $y->person_id, $identifier );
			return $this->conversation_action( $x, $identifier );			

		} else	if( $votable == 'comment_conversation' ) {
			$y = $this->Comment_model->get_comment_conversation_by_id( $identifier );
			$x = $this->votable_downvote( 'comment_conversation', 'comments_conversations', $y->person_id, $identifier );
			return $this->comment_conversation_action( $x, $y->conversation_id, $identifier );			

		} elseif( $votable == 'symposium' ) {
			$y = $this->Symposium_model->get_symposium_by_id( $identifier );
			$x = $this->votable_downvote( 'symposium', 'symposia', $y->person_id, $identifier );
			return $this->symposium_action( $x, $identifier );			

		} elseif( $votable == 'comment_symposium' ) {
			$y = $this->Comment_model->get_comment_symposium_by_id( $identifier );
			$x = $this->votable_downvote( 'comment_symposium', 'comments_symposia', $y->person_id, $identifier );
			return $this->comment_symposium_action( $x, $y->symposium_id, $identifier );			

		} elseif( $votable == 'symposium_chapter' ) {
			$y = $this->Symposium_model->get_symposium_chapter_by_id( $identifier );
			$x = $this->votable_downvote( 'symposium_chapter', 'symposia_chapters', $y->person_id, $identifier );
			return $this->symposium_chapter_action( $x, $identifier );			

		} elseif( $votable == 'comment_symposium_chapter' ) {
			$y = $this->Comment_model->get_comment_symposium_chapter_by_id( $identifier );
			$x = $this->votable_downvote( 'comment_symposium_chapter', 'comments_symposia_chapters', $y->person_id, $identifier );
			return $this->comment_symposium_chapter_action( $x, $y->symposium_chapter_id, $identifier );			

		} else {
			redirect( base_url() );
		}
	}



	/*********************/
	/** PRIVATE METHODS **/
	/*********************/

	private

	function load_appropriate_models( $x ) {

		if( $x == 'conversation' || $x == 'comment_conversation') {
			// Conversation model already loaded by default

		} elseif(	$x == 'symposium'		  || $x == 'comment_symposium' || 
					$x == 'symposium_chapter' || $x == 'comment_symposium_chapter' ) {
			// Symposuum Model already loaded by default
		}
	}

	function conversation_action( $r, $id ) {
		$r	? redirect( base_url() . '/conversations/detail/' . $id )
			: redirect( base_url() . '/conversations/detail/' . $id . '?tfp=true' );
	}

	function comment_conversation_action( $r, $conversation_id, $comment_conversation_id ) {
		$r	? redirect( base_url() . '/conversations/detail/' . $conversation_id . '#comment_conversation-' . $comment_conversation_id )
			: redirect( base_url() . '/conversations/detail/' . $conversation_id . '?tfp=true' );
	}

	function symposium_action( $r, $id ) {
		$r	? redirect( base_url() . '/symposia/detail/' . $id )
			: redirect( base_url() . '/symposia/detail/' . $id  . '?tfp=true' );
	}

	function comment_symposium_action( $r, $symposium_id, $comment_symposium_id ) {
		$r	? redirect( base_url() . '/symposia/detail/' . $symposium_id . '#comment_symposium-' . $comment_symposium_id )
		 	: redirect( base_url() . '/symposia/detail/' . $symposium_id . '?tfp=true' );
	}

	function symposium_chapter_action( $r, $id ) {
		$r	? redirect( base_url() . '/symposia/chapter/' . $id )
			: redirect( base_url() . '/symposia/chapter/' . $id . '?tfp=true' );
	}

	function comment_symposium_chapter_action( $r, $symposium_chapter_id, $comment_symposium_chapter_id ) {
		$r	? redirect( base_url() . '/symposia/chapter/' . $symposium_chapter_id . '#comment_symposium_chapter-' . $comment_symposium_chapter_id )
		 	: redirect( base_url() . '/symposia/chapter/' . $symposium_chapter_id . '?tfp=true' );
	}


	/*********************/
	/** Central Methods **/
	/*********************/

	function check_up_or_down_vote( $votable_s, $votable_p, $identifier ) {

		if( is_numeric( $identifier )) {

			if( $votable_s == 'conversation' ) {
				$votable = $this->Conversation_model->get_conversation_by_id($identifier);

			} elseif( $votable_s == 'comment_conversation' ) {
				$votable = $this->Comment_model->get_comment_conversation_by_id($identifier);

			} elseif( $votable_s == 'symposium' ) {
				$votable = $this->Symposium_model->get_symposium_by_id($identifier);

			} elseif( $votable_s == 'comment_symposium' ) {
				$votable = $this->Comment_model->get_comment_symposium_by_id($identifier);

			} elseif( $votable_s == 'symposium_chapter' ) {
				$votable = $this->Symposium_model->get_symposium_chapter_by_id($identifier);

			} elseif( $votable_s == 'comment_symposium_chapter' ) {
				$votable = $this->Comment_model->get_comment_symposium_chapter_by_id($identifier);
			}
		}

		if( count( $votable ) <= 0 ) {
			return false;
		}

		return true;
	}

	function votable_db_upvote( $votable_p, $identifier ) {
		$sql = "UPDATE $votable_p set `votes` = `votes` + 1 where `id` = $identifier";
        $this->db->query($sql);

		if( $this->db->affected_rows() >= 0 ) {
			return TRUE;
		}
		
		return FALSE;	
	}

	function votable_db_downvote( $votable_p, $identifier ) {
		$sql = "UPDATE $votable_p set `votes` = `votes` - 1 where `id` = $identifier";
        $this->db->query($sql);

		if( $this->db->affected_rows() >= 0 ) {
			return TRUE;
		}

		return FALSE;
	}

	function votable_upvote( $votable_s, $votable_p, $votable_a, $identifier ) {

		$qm = $this->check_up_or_down_vote( $votable_s, $votable_p, $identifier );
		if( $qm == false ) { return false; }

		/////////////////////////////////////
		// Does the voter already have an up 
		// vote placed on this votable? If so,
		// we need to remove the vote. Otherwise,
		// we add the vote.
		$existing_vote = $this->Vote_model->exists_vote_on_votable( $this->current_user->id, $votable_s, $votable_p, $identifier );
		if( $existing_vote == 0  && $this->current_user->points > 0 ) {

			// Upvote the votable
			$this->votable_db_upvote( $votable_p, $identifier );

			// Update voting person's data.
			$this->People_model->down_point( $this->current_user->id, 1 );
			userdata_down_points( $this, 1 );

			// Update the author's reputation
			$this->People_model->earn_reputation( $votable_a, $this->current_user->id, 1 );

			// Record vote for this votable.
			$this->Vote_model->set_vote_on_votable( $this->current_user->id, $votable_s, $votable_p, $identifier, 1 );

		} elseif( $existing_vote == 1 ) {

			// Downvote the votable to a no-vote
			$this->votable_db_downvote( $votable_p, $identifier );

			// Person gets a point back.
			$this->People_model->up_point( $this->current_user->id, 1 );
			userdata_up_points( $this, 1 );

			// Update the author's reputation
			$this->People_model->lose_reputation( $votable_a, $this->current_user->id, 1 );

			// Record vote for this votable.
			$this->Vote_model->set_vote_on_votable( $this->current_user->id, $votable_s, $votable_p, $identifier, 0 );

		} elseif( $existing_vote == -1 && $this->current_user->points >= 0 ) {

			// Upvote the votable twice.
			$this->votable_db_upvote( $votable_p, $identifier );
			$this->votable_db_upvote( $votable_p, $identifier );

			// Update the author's reputation
			$this->People_model->earn_reputation( $votable_a, $this->current_user->id, 2 );

			// User gets no points back.
			// Record vote for this votable.
			$this->Vote_model->set_vote_on_votable( $this->current_user->id, $votable_s, $votable_p, $identifier, 1 );

		} else {
			return FALSE;
		}

		return TRUE;
	}
	
	function votable_downvote( $votable_s, $votable_p, $votable_a, $identifier ) {

		$qm = $this->check_up_or_down_vote( $votable_s, $votable_p, $identifier );
		if( $qm == false ) { return false; }

		/////////////////////////////////////
		// Does the voter already have a down
		// vote placed on this votable? If so,
		// we need to remove the vote. Otherwise,
		// we add the vote.
		$existing_vote = $this->Vote_model->exists_vote_on_votable( $this->current_user->id, $votable_s, $votable_p, $identifier );
		if( $existing_vote == 0 && $this->current_user->points >= 1 ) {

			// Upvote the votable
			$this->votable_db_downvote( $votable_p, $identifier );

			// Update voting person's data.
			$this->People_model->down_point( $this->current_user->id, 1 );
			userdata_down_points( $this, 1 );

			// Update the author's reputation
			$this->People_model->lose_reputation( $votable_a, $this->current_user->id, 1 );

			// Record vote for this votable.
			$this->Vote_model->set_vote_on_votable( $this->current_user->id, $votable_s, $votable_p, $identifier, -1 );

		} elseif( $existing_vote == 1 && $this->current_user->points >= 0 ) {

			// Downvote the votable twice.
			$this->votable_db_downvote( $votable_p, $identifier );
			$this->votable_db_downvote( $votable_p, $identifier );

			// Update the author's reputation
			$this->People_model->lose_reputation( $votable_a, $this->current_user->id, 2 );

			// User gets no points back.
			// Record vote for this votable.
			$this->Vote_model->set_vote_on_votable( $this->current_user->id, $votable_s, $votable_p, $identifier, -1 );

		} elseif( $existing_vote == -1 ) {

			// Upvote the votable to a no-vote
			$this->votable_db_upvote( $votable_p, $identifier );

			// Person gets a point back.
			$this->People_model->up_point( $this->current_user->id, 1 );
			userdata_up_points( $this, 1 );

			// Update the author's reputation
			$this->People_model->earn_reputation( $votable_a, $this->current_user->id, 1 );

			// Record vote for this votable.
			$this->Vote_model->set_vote_on_votable( $this->current_user->id, $votable_s, $votable_p, $identifier, 0 );
		} else {
			return FALSE;
		}

		return TRUE;
	}
}

/* End of file tags.php */
/* Location: ./application/controllers/tags.php */
