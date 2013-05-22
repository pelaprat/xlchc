<div class='byline span-13 last'>
	<?php $custom_date = humanTiming( $created_at ); ?>
	<a href='/people/detail/<?= $data->person_id ?>'><?= $data->first ?> <?= $data->last ?></a>, <b><?= $custom_date; ?> ago</b><br>
	<br>
</div>
