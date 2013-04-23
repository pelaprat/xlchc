<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Symposia extends CI_Controller {

	var $current_user;
	var $user_reputation_points;

	function __construct() {
		parent::__construct();

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
	}

	function index() {

		$data = array();

		$this->load->model('Tag_model', '', TRUE);
		$this->load->model('Page_model', '', TRUE);

		$data['page']		= $this->Page_model->get_page_by_uri( $this->uri->uri_string() );
		$data['symposia']	= $this->Symposium_model->get_all();

		///////////////////////
		// Now get the keywords 
		// for these symposia.
		$symposia_ids = array();
		foreach( $data['symposia']->result() as $symposium ) {
			array_push( $symposia_ids, $symposium->symposium_id );
		}

		$tags		= array();
		$tag_rows	= $this->Tag_model->get_tags_for_symposia( $symposia_ids );
		foreach( $tag_rows->result() as $tag ) {
			if( isset( $tags[$tag->symposium_id] )) {
				array_push( $tags[$tag->symposium_id], array( $tag->tag_id, $tag->name ));
			} else {
				$tags[$tag->symposium_id] = array( array( $tag->tag_id, $tag->name ));
			}
		}

		$data['tags'] = $tags;
		$data['o_page_sideboxes']	= true;

		$this->load->view( strtolower( get_class($this) ).'/index', $data );
	}

	function detail($identifier) {

		$data = array();

		$this->load->model('Comment_model', '', TRUE);

		if( is_numeric($identifier) ){
			$data['symposium']			= $this->Symposium_model->get_symposium_by_id($identifier);
			$data['symposium_media']	= $this->Symposium_model->get_symposia_media( $identifier );
			$data['symposia_chapters']	= $this->Symposium_model->get_symposium_chapters_by_id( $identifier );
			$data['comments_symposia']	= $this->Comment_model->get_comments_symposia_by_id( $identifier );
		}

		if( count($data['symposium']) == 0 ){
			show_404();

		} elseif(	$data['symposium']->f_private == 1	&&
					(	! isset($this->current_user)	||
						$this->Symposium_model->is_person_member_of_symposium( $this->current_user->id , $identifier ) == false )) {

			redirect('home');
		} else {

			////////////////////
			// Load People Model
			$this->load->model('Tag_model', '', TRUE );
			$this->load->model('Vote_model', '', TRUE );

			/////////////////////////
			// Does the person have a
			// vote on this symposium
			// and / or its answers?
			if( $this->current_user != null ) {

				// Get the symposium vote
				$data['current_user_vote_symposium'] =
					$this->Vote_model->exists_vote_on_symposium( $this->current_user->id, $identifier );

				// Get the symposium comments
				$current_user_votes_comments_symposia = array();
				$votes = $this->Vote_model->get_votes_on_comments_symposia( $this->current_user->id, $identifier );

				foreach( $votes->result() as $row ) {
					$current_user_votes_comments_symposia[$row->comment_symposium_id] = $row->vote;
				}

				$data['current_user_votes_comments_symposia'] =
					$current_user_votes_comments_symposia;

			} else {

				// No user, so these are empty.
				$data['current_user_vote_symposium']			= 0;
				$data['current_user_votes_comments_symposia']	= array();
			}

			///////////////////////////////////
			// Get the tags for this symposium.
			$data['tags'] 		= $this->Tag_model->get_tags_for_symposium( $identifier );
			$data['all_tags']	= $this->Tag_model->get_all();

			/////////////////////////////////////////
			// Get the attachments for the comments.
			$comments = array();
			foreach( $data['comments_symposia']->result() as $comment ) {
				array_push( $comments, $comment->comment_symposium_id );
			}

			if( ! empty( $comments )) {
				$attachments							= $this->Comment_model->get_attachments_for_comments( 'symposium', $comments );
				$data['comments_symposia_attachments']	= post_process_comment_data( $attachments );
			} else { 
				$data['comments_symposia_attachments']	= array();
			}

			///////////////////////
			// Upview the symposium
			$this->Symposium_model->up_view( $identifier );

			$page = (object) array(
				'meta_title'		=> $data['symposium']->subject,
				'meta_description'	=> $data['symposium']->summary,
				'meta_keywords'		=> $data['symposium']->subject,
				'meta_language'		=> 'en-US',
				'meta_content_type'	=> 'text/html; charset=utf-8',
				'title'				=> $data['symposium']->subject,
				'content'			=> ''
			);

			$data['page']				= $page;
			$data['o_page_sideboxes']	= true;

			if( $this->input->get('tfp') == true ) {
				$data['custom_error'] = "<div class='error'>Sorry, but you have too few points to perform this action.</div>";
			}

			$this->load->view( 'symposia/symposium', $data );
		}
	}	

	/***********************/
	/** Chapter functions **/
	function chapter( $identifier ) {
		
		$data = array();

		$this->load->model('Comment_model', '', TRUE);

		if( is_numeric($identifier) ){
			$data['symposium_chapter']			= $this->Symposium_model->get_symposium_chapter_by_id( $identifier );
			$data['symposium_chapter_media']	= $this->Symposium_model->get_symposia_chapters_media( $identifier );
			$data['symposia_chapters']			= $this->Symposium_model->get_symposium_chapters_by_id( $data['symposium_chapter']->symposium_id );
			$data['symposium']					= $this->Symposium_model->get_symposium_by_id( $data['symposium_chapter']->symposium_id );
			$data['comments_symposia_chapters']	= $this->Comment_model->get_comments_symposia_chapters_by_id( $identifier );
		}

		if( count($data['symposium_chapter']) == 0 ){
			show_404();

		} else {

			////////////////////
			// Load People Model
			$this->load->model('Tag_model', '', TRUE );
			$this->load->model('Vote_model', '', TRUE );

			/////////////////////////
			// Does the person have a
			// vote on this symposium
			// and / or its answers?
			if( $this->current_user != null ) {

				// Get the symposium vote
				$data['current_user_vote_symposium_chapter'] =
					$this->Vote_model->exists_vote_on_symposium_chapter( $this->current_user->id, $identifier );

				// Get the symposium chapter comments
				$current_user_votes_comments_symposia_chapters = array();
				$votes = $this->Vote_model->get_votes_on_comments_symposia_chapters( $this->current_user->id, $identifier );

				foreach( $votes->result() as $row ) {
					$current_user_votes_comments_symposia_chapters[$row->comment_symposium_chapter_id] = $row->vote;
				}

				$data['current_user_votes_comments_symposia_chapters'] =
					$current_user_votes_comments_symposia_chapters;

			} else {

				// No user, so these are empty.
				$data['current_user_vote_symposium_chapter']			= 0;
				$data['current_user_votes_comments_symposia_chapters']	= array();
			}

			//////////////////////////////////////////
			// Get the tags for this symposium chapter
			$data['tags'] 		= $this->Tag_model->get_tags_for_symposium_chapter( $identifier );
			$data['all_tags']	= $this->Tag_model->get_all();

			/////////////////////////////////////////
			// Get the attachments for the comments.
			$comments = array();
			foreach( $data['comments_symposia_chapters']->result() as $comment ) {
				array_push( $comments, $comment->comment_symposium_chapter_id );
			}

			if( ! empty( $comments )) {
				$attachments									= $this->Comment_model->get_attachments_for_comments( 'symposium_chapter', $comments );
				$data['comments_symposia_chapters_attachments']	= post_process_comment_data( $attachments );
			} else { 
				$data['comments_symposia_chapters_attachments']	= array();
			}

			///////////////////////
			// Upview the symposium
			$this->Symposium_model->up_view( $identifier );

			$page = (object) array(
				'meta_title'		=> $data['symposium_chapter']->subject,
				'meta_description'	=> $data['symposium_chapter']->summary,
				'meta_keywords'		=> $data['symposium_chapter']->subject,
				'meta_language'		=> 'en-US',
				'meta_content_type'	=> 'text/html; charset=utf-8',
				'title'				=> $data['symposium_chapter']->subject,
				'content'			=> ''
			);
	
			$data['page']				= $page;
			$data['o_page_sideboxes']	= true;

			if( $this->input->get('tfp') == true ) {
				$data['custom_error'] = "<div class='error'>Sorry, but you have too few points to perform this action.</div>";
			}

			$this->load->view( 'symposia/symposium_chapter', $data );
		}
	}
}

/* End of file symposia.php */
/* Location: ./application/controllers/symposia.php */







