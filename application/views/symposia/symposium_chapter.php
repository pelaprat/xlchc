<?php $this->load->view('elements/header'); ?>

<div class="article community">

	<!-- Title and Respond link -->
	<div class='span-15 last'>
		<div class='span-15 last title'>
			<?php echo $symposium_chapter->subject; ?>
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

	<!-- Symposium Chapter -->
	<div class='symposium_chapter span-15 last'>

		<?php
			$data = array();
			$data['current_user_vote']	= $current_user_vote_symposium_chapter;
			$data['votable_name']		= 'symposium_chapter';
			$data['votable_id']			= $symposium_chapter->symposium_chapter_id;
			$data['votes']				= $symposium_chapter->votes;

			$this->load->view( 'elements/community/box_votes', $data );
		?>

		<div class='content span-12 last'>
			<p><?php echo $symposium_chapter->summary; ?></p>

			<? if( $this->current_user != null ) { ?>
				<div class='response-link last'>
					<a href='/symposia/chapter/<?= $symposium_chapter->symposium_chapter_id ?>#post_response'>Respond</a>
				</div>
			<?php } ?>
		</div>

		<!-- Video URL -->
		<?php $this->load->view( 'elements/community/box_video', array( 'url' =>  $symposium_chapter->url_video )); ?>

		<div class='span-15 last prepend-top'>
			<div class='tags span-2 prepend-top'>&nbsp;</div>

			<?php
				$data = array();
				$data['f_add_only']		= 0;
				$data['f_auto_submit']	= 1;
				$data['width']			= 8;
				$data['tags'] 			= $tags;
				$data['all_tags']		= $all_tags;
				$data['tagable_id']		= $symposium_chapter->symposium_chapter_id;
				$data['tagable_s']		= 'symposium_chapter';
				$data['tagable_p']		= 'symposia_chapters';

				$this->load->view( 'elements/community/box_tag', $data );
			?>

			<?php $this->load->view( 'elements/community/box_byline', array(	'data'			=> $symposium_chapter,
																				'element_s' 	=> 'symposium_chapter',
																				'created_at'	=> $symposium->created_at )); ?>
		</div>

	</div>

	<!-- Comments -->
	<div class='span-15 last'>
    	<br>
		<?php
		if( isset( $comments_symposia_chapters ) && $comments_symposia_chapters != null ) {
			foreach( $comments_symposia_chapters->result() as $comment_symposium_chapter ) { ?>
				<hr>
		<?php
				$data['data']						= $comment_symposium_chapter;
				$data['commentable_s']				= 'symposium_chapter';
				$data['comment_id']					= $comment_symposium_chapter->comment_symposium_chapter_id;
				$data['created_at']					= $comment_symposium_chapter->comment_symposium_chapter_created_at;
				$data['current_user_vote_comment']	= 0;

				// Get the attachments for this comment
				$data['attachments'] = array();
				if( isset( $comments_symposia_chapters_attachments[$comment_symposium_chapter->comment_symposium_chapter_id] )) {
					$data['attachments'] = $comments_symposia_chapters_attachments[$comment_symposium_chapter->comment_symposium_chapter_id];
				}

				if( isset($current_user_votes_comments_symposia_chapters[$comment_symposium_chapter->comment_symposium_chapter_id]) ) {
					$data['current_user_vote_comment']	= $current_user_votes_comments_symposia_chapters[$comment_symposium_chapter->comment_symposium_chapter_id];
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
			$data['commentable_s']	= 'symposium_chapter';
			$data['commentable_id']	= $symposium_chapter->symposium_chapter_id;

			$this->load->view( 'elements/community/post_comment', $data );
		}
	?>
</div>

<?php

	$x['symposia_sidebars'] 		= true;
	$x['symposium']					= $symposium;
	$x['symposia_chapters'] 		= $symposia_chapters;
	$x['symposium_chapter']			= $symposium_chapter;
	$x['symposium_chapter_media']	= $symposium_chapter_media;

	$this->load->view( 'elements/sidebar', $x );

?>

<?php  $this->load->view('elements/footer'); ?>