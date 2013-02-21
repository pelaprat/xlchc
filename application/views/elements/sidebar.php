
	<!-- This closing div closes the "content" div -->
	</div>

<!-- Now the sidebar begins -->
<div class="toolbox span-8 last">

	<!-- Conversation Related Sideboxes  -->
	<?php
		if( isset( $conversation_sidebars ) && $conversation_sidebars ) {
			if( isset( $current_user_subscribed_conversation )) {
				if( $current_user_subscribed_conversation == 1 ) {
	?>
					<div class="box box-conversation-unsubscribe">
					<h3>You are currently<br>subscribed to this conversation.</h3>
					[ <a href='/people/unsubscribe_conversation/<?= $conversation->conversation_id ?>'>unsubscribe</a> ]
					</div>
	<?
				} else {
	?>
					<div class="box box-conversation-subscribe">
					<h3>You are <b>not</b> currently<br>subscribed to this conversation.</h3>
					[ <a href='/people/subscribe_conversation/<?= $conversation->conversation_id ?>'>subscribe</a> ]
					</div>
	<?
				}
			}
		}
	?>


	<!-- Symposia Chapters? -->
	<?php
		if( isset( $symposia_sidebars ) && $symposia_sidebars ) {
	?>
			<div class='box box-symposia-chapters'>
				<div class='header'>
					<span class='for'>chapters for</span>
					<br>
					<span class='name'><?= $symposium->subject ?></span>
				</div>
				<br>

				<?php
					$c = 1;
					foreach( $symposia_chapters->result() as $local_symposium_chapter ) {
?>
						<p class='sidebar-symposium-chapter <?= (isset( $symposium_chapter ) && $symposium_chapter->symposium_chapter_id == $local_symposium_chapter->symposium_chapter_id ) ? 'selected' : '' ?>'>
							<span class='num'> <?= $c . '. ' ?> </span>
							<span class='link'><a href='/symposia/chapter/<?= $local_symposium_chapter->symposium_chapter_id ?>'><?= $local_symposium_chapter->subject ?></a></span>
							(<?= date(  "M d", strtotime( $local_symposium_chapter->symposium_chapter_created_at ) ) ?>)
							<br>
						</p>
				<?php	$c++;
					}
				?>
			</div>


			<!-- Are there media to this element? -->
			<?php
				if( isset( $symposium_media ) || isset( $symposium_chapter_media )) {
			?>
				<div class='box box-symposia-media'>
					<div class='header'>
						<span class='for'>files for</span>
						<br>
						<span class='name'><?php
							if( isset( $symposium_media )  ) {
								echo $symposium->subject;
							} elseif( isset( $symposium_chapter_media ) ) {
								echo $symposium_chapter->subject;
							}
						?></span>
					</div>
					<br>

					<div class='content'>
					<?php
						$symposia_media_to_display = array();
						if( isset( $symposium_media )  ) {
							$symposia_media_to_display = $symposium_media;
						} elseif( isset( $symposium_chapter_media )) {
							$symposia_media_to_display = $symposium_chapter_media;
							
						}

						foreach( $symposia_media_to_display as $media ) {?>
							<span class='icon'><?= display_media( array( 'url' => "/assets/media/$media->uuid", 'mime' => $media->mime_type )); ?></span>
							<div class='link'><a href='/assets/media/<?= $media->uuid; ?>' <?php echo $media->mime_type == 'text/html' ? 'rel="shadowbox"' : '' ?>><?
							if( isset( $media->publication_id ) && $media->publication_id > 0 ) {
								echo $media->title;
							} else {
								echo $media->filename;
							}?></a></div><br>
<?php					} ?>
					</div>
				</div>
			<?php
				}
			?>
	<?php
		}
	?>




	<!-- User-Related Sideboxes -->
	<?php if( $this->current_user == null ) { ?>
		<div class="box">
			<h3>Join our Community</h3>
			<p>Do you wish to discover how <a href='/about/community'>how this web site works</a>? To get the most out of this web site and participate in its community exchange, it is best to <a href='/login/signup'>create an account with us</a>. If you are a member of <a href='http://xmca.ucsd.edu'>XMCA</a>, or if you have ever posted to <a href='http://xmca.ucsd.edu'>XMCA</a>, then your email address is already in our system. However, you will need to <a href='/login/reset_password'>reset your password.</a></p>
		</div>
		<div class="box" id='login-form'>
			<?= form_open('login/validate_credentials'); ?>
			<div>
				<div class='span-2'>Email:</div>
				<div class=''><?= form_input( 'email', '') ?></div>
			</div>
			<div>
				<div class='span-2'>Password:</div>
				<div class=''><?= form_password( 'password', '') ?></div>
			</div>

			<?php
				if( $this->input->get('error') == 'login' ) {
					echo "<span style='color: red; font-style: italic'>Error logging in. Wrong username or password.</span>";
					echo "<br><br>";
				}

				echo form_submit('submit', 'Login');
				echo anchor('login/signup', 'Create Account');

				if( $this->input->get('error') == 'login' ) {
					echo anchor('login/reset_password', 'Reset Password');
				}
				?>
		</div>

	<?php } else { ?>
		<div class="box">
			<h3>Community Information</h3>
			<p>Welcome back,
			<a href='/people/<?= $this->current_user->id ?>'><?= $this->current_user->first . ' ' . $this->current_user->last ?></a>.
			Your community reputation is <span class='reputation-amount'><?= $this->current_user->reputation; ?></span>
			You have <span class='points-amount'><?= $this->current_user->points; ?></span> community points available.
			<span class='toolbar-button'><a href='/about/community'>How do these points work?</a></span>
			<br><br>
			You must be a member of a particular symposium to view it if it is <img src='/assets/images/lock.png' width=16> locked.
		</div>

	<?php } ?>


	<!-- Advertise the Digest? -->
	<?php
	if( $this->current_user != null && $this->current_user->pref_notify_conversation_digest == 0 ) { ?>
		<div class="box">
			<h3>Daily Digest</h3>
			<p>	Hey there! Do you know that you can subscribe for a daily digest of what's new on Co-LCHC?
				It's easy: change your <a href='/people/detail/<?= $this->current_user->id ?>'>notification preferences</a>.</p>
		</div>
	<?php } ?>


	<!-- Hot Conversations? -->
	<div class="box">
		<h3>Hot Conversations</h3>
		<?php
			$hc = lchc_hot_conversations( $this );
			foreach( $hc->result() as $conversation ) {
				
			?>
				<span class='conversation-indicator'>&#187;</span>
				<span class='sidebox-bigger'><a href='/conversations/detail/<?= $conversation->conversation_id ?>'><?= $conversation->subject ?></a></span>
				(<?= date(  "M d", strtotime( $conversation->conversation_created_at ) ) ?>)
				<br>
			<?
			}
		?>
	</div>

	<!-- Current Symposia -->
	<div class="box">
		<h3>Ongoing Symposia</h3>
		<?php
			$symposia = $this->Symposium_model->get_all( 5 );
			foreach( $symposia->result() as $symposium_item ) {
				
			?>
				<span class='symposium-indicator'>&#187;</span>
				<span class='sidebox-bigger'><a href='/symposia/detail/<?= $symposium_item->symposium_id?>'><?= $symposium_item->subject ?></a></span>
				(<?= date(  "M d", strtotime( $symposium_item->symposium_created_at ) ) ?>)
				<br>
			<?
			}
		?>
	</div>

	<!-- Programmed Sideboxes -->
	<?php if( isset($page->sideboxes) && count($page->sideboxes) > 0 ) { ?>
		<?php foreach($page->sideboxes as $entry) { ?>
      		<div class="box">
         		<h3><?php echo htmlentities($entry->title); ?></h3>

         		<?php echo tabify( $entry->content ); ?>
      		</div>
   		<?php } ?>
	<?php } ?>
</div>
<!-- Sidebar ends-->
