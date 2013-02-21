<div class="article">
 	<h2><?php echo htmlentities($page->title); ?></h2>

	<?php if( isset($custom_error)) { 
		echo $custom_error; 
	} ?>

    <?php echo form_open('login/reset_complete'); ?>
	<input type=hidden name='reset_key' value="<?= $reset_key ?>">
	<div class='box' id='reminder-form'>
		Your new password:
		<br>
		<?php echo form_password( 'password_1', ''); ?>
		<br>
		<?php echo form_password( 'password_2', ''); ?>
		<br>
		<?php echo form_submit('submit', 'Reset Password'); ?>
	</div>

	</form>
	<br style="clear: both;">
</div>

</div>
</div>