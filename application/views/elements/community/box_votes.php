<div class='votes span-2'>
	<? if( $this->current_user != null ) { ?>
		<a href='/vote/up/<?= $votable_name ?>/<?= $votable_id; ?>'><?php if( $current_user_vote == 1 ) { ?><img src='assets/images/arrows/up_selected.png' border=0><?php } else {	?><img src='assets/images/arrows/up_unselected.png' border=0><?php } ?></a><br>
		<span class='number'><?php echo $votes; ?></span><br>
		<a href='/vote/down/<?= $votable_name ?>/<?= $votable_id; ?>'><?php if( $current_user_vote == -1 ) { ?><img src='assets/images/arrows/down_selected.png' border=0><?php } else {	?><img src='assets/images/arrows/down_unselected.png' border=0><?php } ?></a><br>
	<?php } else { ?>
		<img src='assets/images/arrows/up_unselected.png'><br>
		<span class='number'><?php echo $votes; ?></span><br>
		<img src='assets/images/arrows/down_unselected.png'><br>
	<?php } ?>
</div>