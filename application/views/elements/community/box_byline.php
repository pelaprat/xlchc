<!-- Byline -->
<div class= 'byline'>
	<?php $custom_date = new BetterDateTime( $created_at ); ?>
	<?php if( $element_s != 'symposium' ) { ?>
		By <a href='/people/detail/<?= $data->person_id ?>'><?= $data->first ?> <?= $data->last ?></a>, <b><?= $custom_date; ?></b><br>
	<?php } ?>
</div>