<?php $this->load->view('elements/header'); ?>

<div class="article community_index conversation">

	<div class='span-15 last'>
		<div class='span-10'>
			<h2><?php echo htmlentities($page->title); ?></h2>
		</div>
		<div class='span-5 last' style='padding-top: 5px; text-align: right'>
			<?php
				if( $this->current_user != null && 
					$this->current_user->reputation >= $this->user_reputation_points['can_post_conversation'] ) {
			?>
					<div class='link-button'><a href='/conversations/add'>Post new conversation</a></div>
			<?php
				}
			?>
		</div>
	</div>

	<p class='home'>Free-flowing conversations, topics, conversations, and more! Before posting a conversation, we encourage you to search the existing conversation database to make sure that your conversation, or conversations related to it, have no already been posted (and could be continued by you).



	</p>

	<?php

	foreach( $conversations->result() as $conversation ) {

		$data['data'] = $conversation;
		if( isset( $tags[$conversation->conversation_id] )) {
			$data['tags'] = $tags[$conversation->conversation_id];
		} else {
			$data['tags'] = array();
		}

		$data['element_s']			= 'conversation';
		$data['element_id']			= $conversation->conversation_id;
		$data['comments_n']			= $conversation->comments_conversations;
		$data['element_created_at']	= $conversation->created_at;
		$data['url']				= 'conversations/detail';

		$this->load->view( 'elements/community/box_element_small', $data );

	} ?>
	
	<br style="clear: both;">
</div>


<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>
