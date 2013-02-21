<?php $this->load->view('elements/header'); ?>
	<div class="article">
		<h2>Search results for <i>"<?= $this->input->post( 'query' ) ?>"</i></h2>

		<!-- Symposia -->
		<?php if( isset( $symposia ) && count( $symposia ) > 0 ) { ?>
			<div class='search_box'>
				<div class='search_header'>Symposia</div>
<?php			foreach( $symposia as $symposium ) { 
					$data		= $symposium['data']; 
					$comments	= $symposium['comments']; ?>
					<div class='search_result'>
						&gt;&gt; <a href='/symposia/detail/<?= $data->symposium_id ?>'><?= $data->subject ?></a>
					</div>

					<?php if( isset( $comments ) ) {
						foreach( $comments->result() as $comment ) { ?>
							<div class='search_indented_result'>
								<a href='/symposia/detail/<?= $data->symposium_id ?>#comment_symposium-<?= $comment->comments_symposia_id ?>'>Comment by <?= $comment->first . ' ' . $comment->last ?></a>
							</div>
<?php					}
					} ?>

<?php			} ?>
			</div>
<?php	} ?>


		<!-- Conversations -->
		<?php if( isset( $conversations ) && count( $conversations ) > 0 ) { ?>
			<div class='search_box'>
				<div class='search_header'>Conversations</div>
<?php			foreach( $conversations as $conversation ) { 
					$data		= $conversation['data']; 
					$comments	= $conversation['comments']; ?>
					<div class='search_result'>
						&gt;&gt; <a href='/conversations/detail/<?= $data->conversation_id ?>'><?= $data->subject ?></a>
					</div>

					<?php if( isset( $comments ) ) {
						foreach( $comments->result() as $comment ) { ?>
							<div class='search_indented_result'>
								<a href='/conversations/detail/<?= $data->conversation_id ?>#comment_conversation-<?= $comment->comments_conversations_id ?>'>Comment by <?= $comment->first . ' ' . $comment->last ?></a>
							</div>
<?php					}
					} ?>

<?php			} ?>
			</div>
<?php	} ?>
	</div>

<?php $this->load->view('elements/footer'); ?>
