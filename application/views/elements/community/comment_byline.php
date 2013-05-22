<div class='byline span-13 last'>
	<?php $custom_date = new BetterDateTime( $created_at ); ?>
	<a href='/people/detail/<?= $data->person_id ?>'><?= $data->first ?> <?= $data->last ?></a>, <b><?= $custom_date; ?></b><br>
	<br>
</div>
