<!-- Byline -->
<div class= 'byline'>
	<?php $custom_date = humanTiming( $created_at ); ?>
	<?php if( $element_s != 'symposium' ) { ?>
		By <a href='/people/detail/<?= $data->person_id ?>'><?= $data->first ?> <?= $data->last ?></a>, <b><?= $custom_date; ?> ago</b><br>
	<?php } ?>
</div>