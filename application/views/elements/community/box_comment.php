<div class='comment span-15 append-bottom last'>
	<a name='comment_<?= $commentable_s ?>-<?= $comment_id ?>'></a>

	<!-- Box for Votes -->
	<?php
		$votes = array();
		$votes['current_user_vote']	= $current_user_vote_comment;
		$votes['votable_name']		= 'comment_' . $commentable_s;
		$votes['votable_id']		= $comment_id;
		$votes['votes']				= $data->votes;

		$this->load->view( 'elements/community/box_votes', $votes );
	?>

	<div class='span-13 last'>
		<!-- Byline -->
		<?php $this->load->view( 'elements/community/comment_byline', array( 'data' =>  $data )); ?>

		<!-- Comment text -->
		<div id='comment_<?= $commentable_s ?>-<?= $comment_id ?>-text' class='content span-13 last'>
			<?php echo text_to_html( $data->comment ); ?>
		</div>

		<!-- Video -->
		<?php $this->load->view( 'elements/community/box_video', array( 'url' => $data->url_video )); ?>

		<!-- Attachments -->
		<?php if( isset( $attachments )) { ?>
			<?php foreach( $attachments as $attachment ) { ?>
				<div class='span-13 attachment'>
					<span class='icon'>
						<?= display_media( array( 'mime' => $attachment->mime_type, 'url' => "/assets/media/$attachment->uuid" )); ?>
					</span>
					<span class='link'>
						<a target="_new" href='/assets/media/<?= $attachment->uuid; ?>'><?= $attachment->filename ?></a>
					</span>
				</div>
			<?php } ?>
		<?php } ?>


		<div class='span-13 prepend-top'>
			<div class='span-13'>
				<div class='reply' onclick="quoted_reply( '<?= '#comment_' . $commentable_s . '-' . $comment_id . '-text' ?>', '#response-form-comment_<?= $commentable_s ?>', <?= $data->person_id ?> ); return false;">reply</div>
			</div>

		</div>


	</div>
</div>