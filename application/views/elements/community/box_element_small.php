<!-- 
	$data->votes;
-->
<div class='element-box-small append-bottom'>
	<a name='<?= $element_s ?>-<?= $element_id ?>'></a>

	<div class='main span-11'>
		<span class='subject'><a href='/<?= $url ?>/<?php echo $data->id; ?>'><?php echo $data->subject; ?></a></span>
		<span class='comments'>(<?php echo $comments_n; ?>)</span>
		<br>
		<?php $custom_date = new BetterDateTime( $element_created_at ); ?>
		<span class='byline'>Started <?= $custom_date; ?></b> by <a href='/people/detail/<?= $data->person_id ?>'><?= $data->first ?> <?= $data->last ?></a></span>
		<div style='padding-top: 6px'>
		<?php foreach( $tags as $tag_array ) { ?>
			<span class='flag-tag'><?= $tag_array[1] ?></span>
		<?php } ?>
		</div>
	</div>

	<div class='last span-4' style='padding-top: 8px'>
		<?php
			if( isset( $last_comments[$element_id] )) {
				$last = $last_comments[$element_id];
		?>
		
			Last updated by<br>
			<a href='/people/detail/<?= $last[3] ?>'><?= $last[1] ?> <?= $last[2] ?></a><br>
			<?php $custom_last_date = new BetterDateTime( $last[0] ); ?>
			<span class='date'><?= $custom_last_date; ?></span>

		<?php
			}
		?>
	</div>
	
	<br style="clear: both;">
</div>
