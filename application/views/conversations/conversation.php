<?php $this->load->view('elements/header'); ?>

<div class="article community">

	<!-- Title and Respond link -->
	<div class='span-15 last'>
		<div class='span-15 last title'>
			<?php echo $conversation->subject; ?>
		</div>
	</div>

	<!-- Error notification -->
	<div class='span-15 last'>
		<?php
			if( isset($custom_error) ) { 
				echo $custom_error; ?>
    			<br style="clear: both;">
<?			}
		?>

	</div>

	<!-- Error notification -->
	<div class='span-15 last'>
		<?php
		if( isset($custom_error) ) { 
			echo $custom_error;
		?>
    	<br style="clear: both;">
		<?php
		}
		?>
	</div>

	<!-- Conversation -->
	<div class='conversation span-15 last'>

		<?php
			$data = array();
			$data['current_user_vote']	= $current_user_vote_conversation;
			$data['votable_name']		= 'conversation';
			$data['votable_id']			= $conversation->conversation_id;
			$data['votes']				= $conversation->votes;

			$this->load->view( 'elements/community/box_votes', $data );
		?>

		<div class='content span-12 last'>
			<p><?php echo $conversation->summary; ?></p>

			<? if( $this->current_user != null ) { ?>
				<div class='response-link last'>
					<a href='/conversations/detail/<?= $conversation->conversation_id ?>#post_response'>Respond</a>
				</div>
			<?php } ?>
		</div>

		<!-- Video URL -->
		<?php $this->load->view( 'elements/community/box_video', array( 'url' => $conversation->url_video )); ?>

		<div class='span-15 last prepend-top'>
			<div class='tags span-2 prepend-top'>&nbsp;</div>

			<?php
				$x['f_add_only']	= 0;
				$x['f_auto_submit'] = 1;
				$x['width']			= 8;
				$x['tags'] 			= $tags;
				$x['all_tags']		= $all_tags;
				$x['tagable_id']	= $conversation->conversation_id;
				$x['tagable_s']		= 'conversation';
				$x['tagable_p']		= 'conversations';
				$this->load->view( 'elements/community/box_tag', $x );
			?>


			<?php $this->load->view(	'elements/community/box_byline',
										array(	'created_at'	=> $conversation->created_at, 
												'element_s'		=> 'conversation',
												'data'			=> $conversation )); ?>
		</div>
	</div>

	<!-- Comments -->
	<div class='span-15 last'>
    	<br>
		<?php
		if( isset( $comments_conversations ) && $comments_conversations != null ) {
			foreach( $comments_conversations->result() as $comment_conversation ) { ?>
				<hr>
		<?php
				$data['data']						= $comment_conversation;
				$data['commentable_s']				= 'conversation';
				$data['comment_id']					= $comment_conversation->comment_conversation_id;
				$data['created_at']					= $comment_conversation->comment_conversation_created_at;
				$data['current_user_vote_comment']	= 0;

				// Get the attachments for this comment
				$data['attachments'] = array();
				if( isset( $attachments[$comment_conversation->comment_conversation_id] )) {
					$data['attachments'] = $attachments[$comment_conversation->comment_conversation_id];
				}

				if( isset($current_user_votes_comments_conversations[$comment_conversation->comment_conversation_id]) ) {
					$data['current_user_vote_comment'] = $current_user_votes_comments_conversations[$comment_conversation->comment_conversation_id];
				}

				$this->load->view( 'elements/community/box_comment', $data );
 			}
 		}
		?>
	</div>

	<!-- Post Comment -->
	<?
		if( $this->current_user != null ) {
			$data = array();
			$data['commentable_s']	= 'conversation';
			$data['commentable_id']	= $conversation->conversation_id;

			$this->load->view( 'elements/community/post_comment', $data );
		}
	?>
</div>

<?php
	$x['conversation_sidebars']	= true;
	$x['conversation_id']		= $conversation->conversation_id;

	$this->load->view( 'elements/sidebar', $x );
?>




<?php  $this->load->view('elements/footer'); ?>