<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conversations extends CI_Controller {

	var $current_user;
	var $user_reputation_points;

	function __construct() {
		parent::__construct();

		// Load models we always use
		$this->load->model('Tag_model', '', TRUE);

		$this->load->library('form_validation');

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
	}

	function index() {

		$data = array();

		$this->load->model('Page_model', '', TRUE);

		$data['page']			= $this->Page_model->get_page_by_uri( $this->uri->uri_string() );
		$data['conversations']	= $this->Conversation_model->get_all( true );

		////////////////////////////////////////
		// Now get the tags for these conversations.
		$conversation_ids = array();
		foreach( $data['conversations']->result() as $conversation ) {
			array_push( $conversation_ids, $conversation->conversation_id );
		}

		$tags	= array();
		$rows	= $this->Tag_model->get_tags_for_conversations( $conversation_ids );

		foreach( $rows->result() as $tag ) {
			if( isset( $tags[$tag->conversation_id] ) && $tags[$tag->conversation_id] >= 1 ) {
				array_push( $tags[$tag->conversation_id], array( $tag->tag_id, $tag->name ));
			} else {
				$tags[$tag->conversation_id] = array( array( $tag->tag_id, $tag->name ));
			}
		}

		///////////////////////////////////////
		// Get the last person to contribute
		$last_comments	= array();
		$rows			= $this->Conversation_model->get_last_conversation_comments( );
		foreach( $rows->result() as $comment ) {
			if( isset( $last_comments[$comment->conversation_id] ) && $last_comments[$comment->conversation_id] >= 1 ) {
				$last_comments[$comment->conversation_id] =
					array( $comment->created_at, $comment->first, $comment->last, $comment->person_id );
			} else {
				$last_comments[$comment->conversation_id] = array( $comment->created_at, $comment->first, $comment->last, $comment->person_id );
			}
		}

		////////////////
		// Set up data
		$data['tags'] 				= $tags;
		$data['last_comments']		= $last_comments;
		$data['o_page_sideboxes']	= true;

		$this->load->view( strtolower( get_class($this) ).'/index', $data );
	}

    function add() {

		$data = array();

		if( $this->form_validation->run('conversations/add') == false ) {

			$data['custom_error'] =
				( validation_errors() ? '<div class="error">'.validation_errors().'</div>' : false );

		} elseif( $this->current_user != null ) {

			///////////////////////////////////////
			// Clean the data and add the conversation.
			$subject = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('subject')) : $this->input->post('subject'));
			$summary = ( get_magic_quotes_gpc() ? stripslashes($this->input->post('summary')) : $this->input->post('summary'));

			$conversation  = array(	'person_id'		=> $this->current_user->id,
									'votes'			=> 0,
									'subject'		=> $subject,
									'summary'		=> $summary,
									'created_at'	=> datetime_now(),
									'updated_at'	=> datetime_now() );

			$conversation_id = $this->Conversation_model->add( $conversation );

			//////////////////////////////////////////////////
			// Now add the tag associations if there are some.
			$tag_data = $this->input->post('tag');

			if( $tag_data != null ) {
				foreach( $tag_data as $tag => $id ) {
					if( preg_match( '/tag_\d+$/', $tag ) && 
						! $this->Tag_model->tag_association_exists( 'conversation', 'conversations', $conversation_id, $id )) {
						$this->Tag_model->tag_association_add( 'conversation', 'conversations', $conversation_id, $id );
					}
				}
			}

			redirect( base_url() . 'conversations/detail/' . $conversation_id );
		}

		// Get our tags.
		$data['all_tags']	= $this->Tag_model->get_all();

		$data['o_page_sideboxes']	= true;
		$data['page'] = (object) array(
			'meta_title'		=> 'Add a Conversation!',
			'meta_description'	=> 'co-lchc conversations',
			'meta_keywords'		=> 'co-lchc conversations',
			'meta_language'		=> 'en-US',
			'meta_content_type'	=> 'text/html; charset=utf-8'
		);

		$this->load->view( 'conversations/add', $data );
	}

	function detail($identifier) {

		$data = array();

		$this->load->model('Vote_model', '', TRUE );
		$this->load->model('Comment_model', '', TRUE );
		$this->load->model('People_model', '', TRUE );

		if( is_numeric( $identifier ) ){
			$data['conversation']			= $this->Conversation_model->get_conversation_by_id($identifier);
			$data['comments_conversations']	= $this->Comment_model->get_comments_conversations_by_id($identifier);

		} else {

		}

		if( count($data['conversation']) == 0 ){
			show_404();

		} else {

			/////////////////////////
			// Does the person have a
			// vote on this conversation
			// and / or its comments?
			if( $this->current_user != null ) {

				// Get the conversation vote
				$data['current_user_vote_conversation'] =
					$this->Vote_model->exists_vote_on_conversation( $this->current_user->id, $identifier );

				// Get the comment votes
				$current_user_votes_comments_conversations = array();
				$votes = $this->Vote_model->get_votes_on_comments_conversations( $this->current_user->id, $identifier );

				foreach( $votes->result() as $row ) {
					$current_user_votes_comments_conversations[$row->comment_conversation_id] = $row->vote;
				}

				$data['current_user_votes_comments_conversations'] =
					$current_user_votes_comments_conversations;

			} else {

				// No user, so these are empty.
				$data['current_user_vote_conversation']				= 0;
				$data['current_user_votes_comments_conversations']	= array();
			}


			///////////////////////////////////////////////////
			// Is the person subscribed to this conversation?
			if( $this->current_user != null ) {

				$data['current_user_subscribed_conversation'] = 0;

				if( $this->People_model->is_person_subscribed_to_conversation( $this->current_user->id, $identifier )) {
					$data['current_user_subscribed_conversation'] = 1;
				}
			}

			//////////////////////////////////
			// Get the tags for this conversation.
			$data['tags']       = $this->Tag_model->get_tags_for_conversation( $identifier );
			$data['all_tags']	= $this->Tag_model->get_all();

			/////////////////////////////////////////
			// Get the attachments for the comments.
			$comments = array();
			foreach( $data['comments_conversations']->result() as $comment ) {
				array_push( $comments, $comment->comment_conversation_id );
			}

			if( ! empty( $comments )) {
				$attachments			= $this->Comment_model->get_attachments_for_comments( 'conversation', $comments );
				$data['attachments']	= post_process_comment_data( $attachments );
			} else { 
				$data['attachments']	= array();
			}

			//////////////////////
			// Upview the conversation
			$this->Conversation_model->up_view( $identifier );
			
			$page = (object) array(
				'meta_title'		=> $data['conversation']->subject,
				'meta_description'	=> 'something',
				'meta_keywords'		=> 'something',
				'meta_language'		=> 'en-US',
				'meta_content_type'	=> 'text/html; charset=utf-8',
				'title'				=> $data['conversation']->subject,
				'content'			=> '',
			);

			$data['page']				= $page;
			$data['o_page_sideboxes']	= true;

			if( $this->input->get('tfp') == true ) {
				$data['custom_error'] = "<div class='error'>Sorry, but you have too few points to perform this action.</div>";
			}

			$this->load->view( 'conversations/conversation', $data );
		}
	}



}

/* End of file conversations.php */
/* Location: ./application/controllers/conversations.php */
