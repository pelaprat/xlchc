<div class="article">
 	<h2><?php echo htmlentities($page->title); ?></h2>

	<?php if( isset($custom_error)) { 
		echo $custom_error; 
	} ?>

    <?php echo form_open('login/reset_password'); ?>
	<div class='box' id='reminder-form'>
		Your email address:
		<br>
		<?php echo form_input( 'email', ''); ?>
		<br>
		<?php echo form_submit('submit', 'Remind me'); ?>
	</div>

	</form>
	<br style="clear: both;">
</div>

</div>
</div>