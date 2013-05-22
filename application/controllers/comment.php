<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model( 'People_model' );
		$this->load->model( 'Comment_model' );
		$this->load->model( 'Media_model' );

		// Set config for uploads
		$config['file_name']		= preg_replace('/\./', '', uniqid(time(), true));
		$config['upload_path']		= "/Volumes/RAID/web_sites/org.xlchc/www/assets/media/";
		$config['allowed_types']	= 'doc|html|pdf|png|gif|jpg|png|jpeg|flv|mp3|mov|mpeg|mpg|zip';
		$config['max_size']			= '' . (1024 * 20) /*20 megabyte upload limit*/;

		// Load upload library with config
		$this->load->library( 'upload', $config );
		$this->load->library('betterdatetime');

		$this->current_user = userdata_load();
		$this->load->vars( $this->current_user );

		$this->user_reputation_points = $this->config->item('user_reputation_points');
	}

	function add( $commentable_s ) {

		// First handle replying to an element
		// and actually add the comment.
		$element_data = -1;
		if( $commentable_s == 'conversation' ) {
			$commentable_id		= $this->input->post( 'conversation_id' );
			$commentable_p		= 'conversations';
			$element_data		= $this->Conversation_model->get_conversation_by_id( $commentable_id );
			$url				= base_url() . 'conversations/detail/' . $commentable_id;

		} elseif( $commentable_s == 'symposium' ) {
			$commentable_id		= $this->input->post( 'symposium_id' );
			$commentable_p		= 'symposia';
			$element_data		= $this->Symposium_model->get_symposium_by_id( $commentable_id );
			$url				= base_url() . 'symposia/detail/' . $commentable_id;

		} elseif( $commentable_s == 'symposium_chapter' ) {
			$commentable_id		= $this->input->post( 'symposium_chapter_id' );
			$commentable_p		= 'symposia_chapters';
			$element_data		= $this->Symposium_model->get_symposium_chapter_by_id( $commentable_id );
			$url				= base_url() . 'symposia/chapter/' . $commentable_id;

		}

		// Die if we failed this far.
		if( ! isset( $element_data )) { return "Ruined.\n\n"; }

		// Only get person_id if we are commenting
		//  on elements authored by a person_id
		if(	$commentable_s == 'conversation' ||
			$commentable_s == 'symposium_chapter' ) {
				$element_person_id	= $element_data->person_id;
		}

		// Now insert the comment
		$added_comment_id	= $this->commentable_add( $commentable_s, $commentable_p, $commentable_id );

		// Update the URL of the new comment
		$url .= '#comment_' . $commentable_s . '-' . $added_comment_id;

		/////////////////
		// ATTACHMENTS //
		foreach( $_FILES as $key => $value ) {
			if( preg_match( '/file-upload-comment-file_\d+$/', $key )) {
				$this->handle_attachment( $commentable_s, $added_comment_id, $key );
			}
		}

		///////////////////
		// NOTIFICATIONS //
		$already_sent = array();

		/////////////////////////////////////////////////////////////////////
		// Are we replying to a comment?
		if(	$this->input->post('replied_comment_person_id') &&
			$this->input->post('replied_comment_person_id') > 0 ) {

			$comment_person_id = $this->input->post('replied_comment_person_id');
			$person = $this->People_model->get_people_by_id( $comment_person_id );

			// Is the comment we're replying to a third party,
			// neither the element person or the user posting
			// the comment? If so, then we notify this person.
			if(	$comment_person_id > 0							&&
				$comment_person_id != $element_person_id 		&& 
				$comment_person_id != $this->current_user->id	&&
				$person->pref_notify_on_comment_reply == 1		) {

				$message	= "Dear $person->first $person->last,\n\n" .
							  "Someone has responded to a comment you posted. The following URL will get you there.\n\n" .
							  "$url\n\n".
							   "All the best,\nThe Co-Laboratory of Comparative Human Cognition";

				$this->notify_person_of_reply( $person, $commentable_s, $commentable_id, $added_comment_id, $message );

				array_push( $already_sent, $person->person_id );
			}
		}

		/////////////////////////////////////////////////////////////////////
		// If we have a symposium then email all of the members.
		if( $commentable_s == 'symposium' || $commentable_s == 'symposium_chapter' ) {

			// Get the members
			$members = $this->Symposium_model->get_symposia_members( $element_data->symposium_id );

			// Iterate through them
			foreach( $members->result() as $member ) {

				// Make sure member allows notification
				if(	$member->person_id != $this->current_user->id && 
					$member->pref_notify_on_symposium_reply 	== 1 ) {

					$message	= "Dear $member->first $member->last,\n\n" .
								  "Someone has posted a comment to a symposium in which you are a member. The following URL will get you there.\n\n" .
								  "$url\n\n".
								   "All the best,\nThe Co-Laboratory of Comparative Human Cognition";

					$this->notify_person_of_reply( $member, $commentable_s, $commentable_id, $added_comment_id, $message );

					array_push( $already_sent, $member->person_id );
				}
			}
		}

		/////////////////////////////////////////////////////////////////////
		// If we have a conversation it's more straightforward
		if( $commentable_s		== 'conversation' 			&&
			$element_person_id	!= $this->current_user->id	) {

			$person = $this->People_model->get_people_by_id( $element_person_id );
			if( $person->pref_notify_on_conversation_reply == 1  ) {

				$message	= "Dear $person->first $person->last,\n\n" .
							  "Someone has responded to a conversation you started. The following URL will get you there.\n\n" .
							  "$url\n\n".
							   "All the best,\nThe Co-Laboratory of Comparative Human Cognition";

				$this->notify_person_of_reply( $person, $commentable_s, $commentable_id, $added_comment_id, $message );

				array_push( $already_sent, $person->person_id );
			}
		}

		/////////////////////////////////////////////////////////////////////
		// Send an email to all the people subscribed to this conversation
		if( $commentable_s == 'conversation' ) {

			// Get the subscribers
			$subscribers = $this->Conversation_model->get_people_subscribed( $commentable_id );
			foreach( $subscribers->result() as $subscriber ) {

				$message	= "Dear $subscriber->first $subscriber->last,\n\n" .
							  "Someone has posted a comment to a conversation you are subscribed to. The following URL will get you there.\n\n" .
							  "$url\n\n".
							   "All the best,\nThe Co-Laboratory of Comparative Human Cognition";

				if(	$subscriber->person_id != $this->current_user->id &&
					! in_array( $subscriber->person_id, $already_sent )) {

					echo $subscriber->email;
					$this->notify_person_of_reply( $subscriber, $commentable_s, $commentable_id, $added_comment_id, $message );
				}
			}
		}

		// Return appropriately.
		if( $commentable_s == 'conversation' ) {
			return $this->conversation_action( $added_comment_id, $commentable_id );
		} elseif( $commentable_s == 'symposium' ) {
			return $this->symposium_action( $added_comment_id, $commentable_id );
		} elseif( $commentable_s == 'symposium_chapter' ) {
			return $this->symposium_chapter_action( $added_comment_id, $commentable_id );
		}
	}

	/*********************/
	/** PRIVATE METHODS **/
	/*********************/

	private

	function conversation_action( $r, $id ) {
		$r	? redirect( base_url() . '/conversations/detail/' . $id )
			: redirect( base_url() . '/conversations' );
	}

	function symposium_action( $r, $id ) {
		$r	? redirect( base_url() . '/symposia/detail/' . $id )
			: redirect( base_url() . '/symposia' );
	}

	function symposium_chapter_action( $r, $id ) {
		$r	? redirect( base_url() . '/symposia/chapter/' . $id )
			: redirect( base_url() . '/symposia' );
	}

	/*********************/
	/** Central Methods **/
	/*********************/
	function handle_attachment( $commentable_s, $comment_id, $filename ) {

		$media_id = -1;

		// First insert the media into our media table
		if( ! $this->upload->do_upload( $filename )) {
			if( $this->upload->display_errors("") ) {
				$data['error'] = $this->upload->display_errors("");
			}

			// Presumably do some notification.

		} else {

			// Write the new file on the local machine
			$uploaded_data = $this->upload->data();

			$filedata = array(
				'uuid'			=> $uploaded_data['file_name'],
				'mime_type'		=> $uploaded_data['file_type'],
				'filename'		=> $_FILES[$filename]['name'],
				'description'	=> ''
			);

			// Make it a media item.
			$media_id = $this->Media_model->add( $filedata );

			// Wrap the media item as a comment attachment
			$comment_data = array(	'comment_type'	=> $commentable_s,
									'comment_id'	=> $comment_id,
									'filename'		=> $_FILES[$filename]['name'],
									'media_id'		=> $media_id );

			// Insert the new attachment
			$attachment_id = $this->Comment_model->attach_media_to_comment( $comment_data );

			// Link this media item to the attachment
			$this->Media_model->add_media_to_element( $media_id, "attachment", $attachment_id );
		}

		return $media_id;
	}

	function notify_person_of_reply( $user, $commentable_s, $commentable_id, $comment_id, $message ) {

		if( $user && isset( $user->email )) {
			$random	= mt_rand( 1, 9999999 );
			$this->load->library('email');

			$this->email->from( 'web@' . $config['base_domain'], 'The Co-Laboratory of Comparative Human Cognition');
			$this->email->to( $user->email );
			$this->email->subject( "A new comment has been posted [Co-LCHC: $random]" );
			$this->email->message( $message );
			$this->email->send();
		}
	}

	function commentable_add( $commentable_s, $commentable_p, $commentable_id ) {

		// Load library
		$this->load->library('form_validation');    

		// Add the comment
		$comment_id    = '';
        $comment_field = 'response-form-comment_' . $commentable_s;

		$comment	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post( $comment_field ))	: $this->input->post( $comment_field ));
		$url_video	= ( get_magic_quotes_gpc() ? stripslashes($this->input->post('url_video'))		: $this->input->post('url_video'));

		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro,$t) );

		$values  = array(	$commentable_s . '_id'	=> $commentable_id,
							'person_id'				=> $this->current_user->id,
							'url_video'				=> $url_video,
							'comment'				=> $comment,
							'created_at'			=> $d->format("Y-m-d H:i:s.u"),
							'updated_at'			=> $d->format("Y-m-d H:i:s.u")
							);

		$comment_id = $this->Comment_model->add( $commentable_s, $commentable_p, $values );

		return $comment_id;
	}
}
/* End of file comment.php */
/* Location: ./application/controllers/comment.php */
