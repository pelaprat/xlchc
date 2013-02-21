<!-- User Comment -->
<div class='comment_form span-14 append-bottom last'>
	<a name="post_response"></a>
	<span class='sub-title'>Respond</span>
	<form method='post' action='/comment/add/<?= $commentable_s ?>' accept-charset="utf-8" enctype="multipart/form-data">

		<!-- Upload form template -->
		<div class='upload hide' id='upload-comment-file-template'>
			<a id='delete-::FIELD1::'>[ - ]</a>
			File attachment:
			<?= form_upload("file-::FIELD1::"); ?>
		</div>

		<input type=hidden id='replied_comment_person_id' name='replied_comment_person_id'>
		<input type=hidden name='<?= $commentable_s ?>_id'	value='<?php echo $commentable_id; ?>'>
		<input type=hidden name='person_id' 	value='<?php $this->current_user->id ?>'>
		<textarea id='response-form-comment_<?= $commentable_s ?>' cols=45 rows=20 name='response-form-comment_<?= $commentable_s ?>'></textarea>
		<br>
		Video URL: <input type='text' name='url_video'>
		<div class='caveat'>
			(This is optional. We currently only accept videos from Vimeo.)
		</div>

		<a id="add-upload-comment-file">[ + ]</a> Add file attachment (allowed types: gif, png, jpg, jpeg, doc, pdf, mov, mp3, mpeg)
		<div id='upload-comment-files'></div>
		<br>

		<input type=submit name='contribute' value='Post your response!'>
	</form>
</div>

<script type='text/javascript'>
	register_add_link( 'upload-comment-file', 'upload-comment-files' );
</script>