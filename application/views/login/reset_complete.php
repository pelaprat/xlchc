<div class="article">
 	<h2><?php echo htmlentities($page->title); ?></h2>

	<?php if( isset($custom_error)) { 
		echo $custom_error;
	?>
		<div class='link-button'>
			<?= anchor( '/login/reset_key/' . $reset_key, 'Try again' ); ?>
		</div>

	<? } ?>

	<?php if( isset($custom_success)) { 
		echo $custom_success;
	} ?>

	<br style="clear: both;">
</div>

</div>
</div>