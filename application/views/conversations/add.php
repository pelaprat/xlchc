<?php $this->load->view('elements/header'); ?>

<div class="article">
	<h2>Contribute to the Conversation</h2>

	<?php
		if( isset($custom_error) ) { 
			echo $custom_error;
		}
	?>

	<? if(	$this->current_user				!= null                                                && 
			$this->current_user->reputation	>= $this->user_reputation_points['can_post_conversation'] ) { ?>
		<div class='conversation-form-add span-16 last append-bottom '>
			<form method='post' action='conversations/add'>
				<div class='span-16'>
					Subject: <input type=text size=36 name='subject'><br>
					<textarea rows=30 cols=15 name='summary'></textarea>
				</div>

				<?php
					$x['f_add_only']	= 1;
					$x['f_auto_submit'] = 0;
					$x['width']			= 10;
					$x['tags'] 			= array();
					$x['all_tags']		= $all_tags;
					$x['tagable_id']	= -1;
					$x['tagable_s']		= 'conversation';
					$x['tagable_p']		= 'conversations';

					$this->load->view( 'elements/community/box_tag', $x );
				?>

				<div class='advice span-4 last'>
					Be economical in your tag selection. The fewer, the better.
				</div>

				<div class='span-16 prepend-top'>
					<input type='submit' value='Post Conversation'>
				</div>
			</form>
		</div>
	<? } elseif( $this->current_user				!= null ) { ?>
		<div class='no_reputation span-16 last append-bottom '>
			You do not yet have the reputation necessary <br> to contribute a new conversation.<br><br>
			(You have <?= $this->current_user->reputation; ?> and you need <?= $this->user_reputation_points['reputation_can_post_conversation']; ?>)
		</div>
	<? } else  { ?>
		<div class='span-16 last append-bottom '>
			To add to the conversation,
			<br>
			you must first <a href='/'>log in to Co-LCHC.</a>
		</div>
	<? } ?>

	<br style="clear: both;">
</div>

<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>
