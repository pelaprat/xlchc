<!-- 
	$data->votes;
	$data->views;
	$data->comments_n;
-->
<div class='element-box append-bottom'>
	<a name='<?= $element_s ?>-<?= $element_id ?>'></a>

	<div class='main span-15'>
		<span class='subject'><a href='/<?= $url ?>/<?php echo $data->id; ?>'><?php echo $data->subject; ?></a></span>
		<span class='comments'>(<?php echo $comments_n; ?>)</span>
		<br>
		<?php $custom_date = new BetterDateTime( $element_created_at ); ?>
		<span class='byline'>Started <?= $custom_date; ?></b></span><br>

		<div style='padding: 2px'></div>

		<span class='content'><?php echo substr( $data->summary, 0, 600 ); ?> ...</span>

		<div style='padding-top: 12px; padding-bottom: 6px'>
		<?php foreach( $tags as $tag_array ) { ?>
			<span class='flag-tag'><?= $tag_array[1] ?></span>
		<?php } ?>
		</div>
	</div>


	 <br style="clear: both;">
</div>