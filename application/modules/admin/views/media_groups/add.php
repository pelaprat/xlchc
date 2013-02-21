<div class="box">

<?php echo form_open(current_url()); ?>
<?php echo $custom_error; ?>

<fieldset><legend>Add media_group</legend>

<div class="input_field">
<label for="name">Name<span class="required">*</span></label>                                
<input class='mediumfield' id="name" type="text" name="name" value="<?php echo set_value('name'); ?>" /><?php echo form_error('name','',''); ?>
</div>

<input class="submit" type="submit" value="Submit" />

<?php echo form_close(); ?>

</div>