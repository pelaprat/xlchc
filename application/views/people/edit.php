<?php $this->load->view('elements/header'); ?>

<div class="article people">
	<h2><?php echo $page->title; ?></h2>

	<?php
		if( isset( $custom_error ) ) {
			echo $custom_error;
		} elseif( isset( $custom_success ) ) {
			echo $custom_success;
		}
	?>

	<div class='form'>

		<?php
			echo form_open( current_url() );
			echo form_hidden('id',       $people->person_id);
		?>

		<div class='label span-3'>
			&nbsp;
		</div>
		<div class='value append-bottom notifications span-10 last'>
			<b>Notification Preferences</b><br>
			<?php
				if( isset( $people->pref_notify_on_comment_reply ) && $people->pref_notify_on_comment_reply == 1 ) {
					echo form_checkbox( 'pref_notify_on_comment_reply', '1', true );
				} else {
					echo form_checkbox( 'pref_notify_on_comment_reply', '1', false );
				}
			?>
			Notify me when someone replies to my Comments<br>

			<?php
				if( isset( $people->pref_notify_on_conversation_reply ) && $people->pref_notify_on_conversation_reply == 1 ) {
					echo form_checkbox( 'pref_notify_on_conversation_reply', '1', true );
				} else {
					echo form_checkbox( 'pref_notify_on_conversation_reply', '1', false );
				}
			?>
			Notify me when someone replies to my Conversations<br>

			<?php
				if( isset( $people->pref_notify_on_symposium_reply ) && $people->pref_notify_on_symposium_reply == 1 ) {
					echo form_checkbox( 'pref_notify_on_symposium_reply', '1', true );
				} else {
					echo form_checkbox( 'pref_notify_on_symposium_reply', '1', false );
				}
			?>
			Notify me when someone replies to the Symposia I made or am in.<br>

			<?php
				if( isset( $people->pref_notify_conversation_digest ) && $people->pref_notify_conversation_digest == 1 ) {
					echo form_checkbox( 'pref_notify_conversation_digest', '1', true );
				} else {
					echo form_checkbox( 'pref_notify_conversation_digest', '1', false );
				}
			?>
			Send me a digest every day of the new happenings on the CO-LCHC.<br>
		</div>

		<hr>

		<div class='label span-3'>
			Email<span class="required">*</span>
		</div>
		<div class='value span-10 last'>
			<input type="text" name="email" value="<?= $people->email; ?>" />
		</div>
	
		<div class='label span-3'>
			Website
		</div>
		<div class='value span-10 last'>
			<input type="text" name="website" value="<?= $people->website; ?>" />
		</div>
	
		<div class='label span-3'>
			Institution
		</div>
		<div class='value span-10 last'>
			<input type="text" name="institution" value="<?= $people->institution; ?>" />
		</div>
	
		<div class='label span-3'>
			Department
		</div>
		<div class='value span-10 last'>
			<input type="text" name="department" value="<?= $people->department; ?>" />
		</div>

		<div class='label span-3'>
			Research
		</div>
		<div class='value span-10 last'>
			<textarea name="research"><?= $people->research; ?></textarea>
		</div>

		<div class='label span-3'>
			Biography
		</div>
		<div class='value span-10 last'>
			<textarea name="bio"><?= $people->bio; ?></textarea>
		</div>

		<div class='label span-3'>
			&nbsp;
		</div>
		<div class='value span-10 last'>
			<input class="submit" type="submit" value="Update my Information and Preferences" />
		</div>


		<?=form_close(); ?>

	</div>
</div>

<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>

