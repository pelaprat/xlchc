
<div class="box">

<?= $custom_error; ?>

<?= form_open_multipart('admin/media/upload'); ?>

<fieldset id='form_publications'><legend>Add a Media Item</legend>

<div style='font-size: 13px; width: 500px; background: #eef; padding: 5px;'>Hey, do you want to upload PowerPoint presentations into XLCHC? <a rel='shadowbox' href='http://player.vimeo.com/video/34735491'>Watch this video!</a></div>
<p>
<div class="input_field">
<label for="userfile">File<span class="required">*</span></label>                                
<?= form_upload("userfile"); ?>
</div>

<div class="input_field">
	<label for="filename">Filename<span class="required">*</span></label>                                
	<div style='margin-left: 105px;'>
		<input class='bigfield' id="filename" type="text" name="filename" value='<?php echo set_value('filename'); ?>' /><?php echo form_error('filename','',''); ?>
		<br>
		This does not have to be an actually file name. It asks, how do you want to call this file? Think of what might be useful to see in the media browser.
	</div>
</div>


<!-- Media Groups -->
<div id='media-group-template' style='display: none;'>
	<div class='media-group-item'>
  		<a id='delete-::FIELD1::'>[ - ]</a>
  		<?php
     		$xx['select_name']  = 'select-::FIELD1::';
 			$xx['option_name']  = '';
 			$xx['menu_data']    = $media_group_menu_data;
			$xx['id_field']		= 'id';

     		$this->load->view( 'helpers/generic_menu', $xx );
  		?>
	</div>
</div>

<div class='input_field'>
	<label for="title">Media Group<span class="required">*</span></label>

   	<div style='margin-left: 105px;'>
   		<div id='media-groups' class='list'></div>
		<a id='add-media-group'>[ + ]</a>
	</div>
	<br>
</div>

<script type='text/javascript'>
	register_add_link( 'media-group', 'media-groups' );
</script>

<div class="input_field">
	<label for="html_archive"></label>                                
	<div style='margin-left: 105px;'>
		<input type='checkbox' name='html_archive' value='true'> Unzip this HTML archive.
	</div>
</div>

<div class='input_field'>
	<label for="description">Description</label>

   	<div style='margin-left: 105px;'>
		<textarea name='description' class="textbox" cols="90" rows="6"><?php echo set_value('description'); ?></textarea>
		<br>
		This description is useful for searching and retrieving media in the media browser.
	</div>
</div>

<input class="submit" type="submit" value="Submit" />

<?php echo form_close(); ?>

</div>