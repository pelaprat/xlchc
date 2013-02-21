<?php $this->load->view('elements/header'); ?>

<div class="article community">

	<!-- Title and Respond link -->
	<div class='span-15 last'>
		<div class='span-15 last title'>
			<?php echo $symposium->subject; ?>
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

	<!-- Symposium -->
	<div class='symposium span-15 last'>

		<?php
			$data = array();
			$data['current_user_vote']	= $current_user_vote_symposium;
			$data['votable_name']		= 'symposium';
			$data['votable_id']			= $symposium->symposium_id;
			$data['votes']				= $symposium->votes;

			$this->load->view( 'elements/community/box_votes', $data );
		?>

		<div class='content span-12 last'>
			<p><?php echo $symposium->summary; ?></p>

			<? if( $this->current_user != null ) { ?>
				<div class='response-link last'>
					<a href='/symposia/detail/<?= $symposium->symposium_id ?>#post_response'>Respond</a>
				</div>
			<?php } ?>
		</div>

		<!-- Video URL -->
		<?php $this->load->view( 'elements/community/box_video', array( 'url' =>  $symposium->url_video )); ?>

		<div class='span-15 prepend-top'>
			<div class='tags span-2 prepend-top'>&nbsp;</div>

			<?php
				$x['f_add_only']	= 0;
				$x['f_auto_submit'] = 1;
				$x['width']			= 8;
				$x['tags'] 			= $tags;
				$x['all_tags']		= $all_tags;
				$x['tagable_id']	= $symposium->symposium_id;
				$x['tagable_s']		= 'symposium';
				$x['tagable_p']		= 'symposia';
	
				$this->load->view( 'elements/community/box_tag', $x );
			?>

			<?php $this->load->view( 'elements/community/box_byline', array(	'data'			=>  $data,
																				'element_s' 	=> 'symposium',
																				'created_at'	=> $symposium->created_at )); ?>
		</div>
	</div>

	<!-- Comments -->
	<div class='span-15 last'>
    	<br>
		<?php
		if( isset( $comments_symposia ) && $comments_symposia != null ) {
			foreach( $comments_symposia->result() as $comment_symposium ) { ?>
				<hr>
		<?php
				$data['data']						= $comment_symposium;
				$data['commentable_s']				= 'symposium';
				$data['comment_id']					= $comment_symposium->comment_symposium_id;
				$data['created_at']					= $comment_symposium->comment_symposium_created_at;
				$data['current_user_vote_comment']	= 0;

				// Get the attachments for this comment
				$data['attachments'] = array();
				if( isset( $comments_symposia_attachments[$comment_symposium->comment_symposium_id] )) {
					$data['attachments'] = $comments_symposia_attachments[$comment_symposium->comment_symposium_id];
				}

				if( isset($current_user_votes_comments_symposia[$comment_symposium->comment_symposium_id]) ) {
					$data['current_user_vote_comment']	= $current_user_votes_comments_symposia[$comment_symposium->comment_symposium_id];
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
			$data['commentable_s']	= 'symposium';
			$data['commentable_id']	= $symposium->symposium_id;

			$this->load->view( 'elements/community/post_comment', $data );
		}
	?>
</div>

<?php
	$x['symposia_sidebars'] = true;
	$x['symposium']			= $symposium;
	$x['symposium_media']	= $symposium_media;
	$x['symposia_chapters'] = $symposia_chapters;
	$x['symposium_chapter']	= null;

	$this->load->view( 'elements/sidebar', $x );
?>

<?php  $this->load->view('elements/footer'); ?>