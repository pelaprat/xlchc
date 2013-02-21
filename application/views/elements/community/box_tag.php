<div class='tag-build span-<?= $width ?>'>

	<div class='header span-<?= $width ?>'>
 		<div class='span-<?= $width - 1 ?>'>Tags</div>
		<div class="span-1 add-link last">
			<?php if( $this->current_user != null && $this->current_user->reputation > $this->user_reputation_points['can_add_tag_association'] ) { ?>
      			<a id="add-<?= $tagable_s ?>-<?= $tagable_id ?>-tag">[ + ]</a>
			<?php } else { ?>
				&nbsp;
			<?php } ?>
		</div>
	</div>


	<?php if(	$f_add_only != 1 ) { ?>
		<form id='<?= $tagable_s ?>-<?= $tagable_id ?>-tag-form' method='post' action='tags/add/<?= $tagable_s ?>'>
			<input type='hidden' name='<?= $tagable_s ?>_id' value='<?= $tagable_id ?>'>
	<?php } ?>

			<div id='<?= $tagable_s ?>-<?= $tagable_id ?>-tag-template'>
				<div id='<?= $tagable_s ?>-<?= $tagable_id ?>-tag-item'>
					<a id='delete-::FIELD1::'>
						[ - ]
					</a>
					<select id='tag_select-::FIELD1::' name='tag[select-::FIELD1::]'>
						<option value='-1'>-</option>
						<?php foreach( $all_tags->result() as $tag ) { ?>
							<option value="<?= $tag->id ?>"><?= $tag->name ?></option>
						<?php } ?>
					</select>
				</div>
				<?php if( $f_auto_submit == 1 ) { ?>
					<input type='submit' class='hide-me' id='submit-button'>
				<?php } ?>
			</div>
	
			<div id='<?= $tagable_s ?>-<?= $tagable_id ?>-tags' class='list span-<?= $width ?>'>
				<?php
					if( $tags != null ) {
						foreach( $tags->result() as $tag ) { ?>
							<?php if( $this->current_user != null && $this->current_user->reputation > $this->user_reputation_points['can_delete_tag_association'] ) { ?>
								<div class='flag' id='<?= $tagable_s ?>_tag-<?= $tag->join_id ?>'>
									<div class='flag-link'><?= $tag->name ?></div><div class='flag-delete'><a class='x' href='/tags/delete/<?= $tagable_s ?>/<?= $tag->join_id ?>'>X</a></div>
								</div>
							<?php } else { ?>
								<div class='flag' id='<?= $tagable_s ?>_tag-<?= $tag->join_id ?>'><?= $tag->name ?></div>
							<?php } ?>
						<?php } ?>
				<?php } ?>
			</div>

	<?php if(	$f_add_only != 1 ) { ?>
		</form>
	<?php } ?>

	<?php if(	$f_add_only != 1			&&
				$this->current_user != null	&&
				$this->current_user->reputation > $this->user_reputation_points['can_create_tag'] ) { ?>
		<form class='new-tag-form' method='post' action='tags/create/<?= $tagable_s ?>'>
			<input type='hidden' name='<?= $tagable_s ?>_id' value='<?= $tagable_id ?>'>
			<input type='text'   name='name' class='span-<?= $width ?>' id='<?= $tagable_s ?>-<?= $tagable_id ?>-tag-new'>
		</form>
	<?php } ?>

	<script type='text/javascript'>
		meta_register_add_link( '<?= $tagable_s ?>-<?= $tagable_id ?>-tag', '<?= $tagable_s ?>-<?= $tagable_id ?>-tags', <?= $f_auto_submit ?> );
	</script>
</div>
