<div class="box">

<?php echo form_open(current_url(), array('id'=>'user_profile_edit_form')); ?>
<?php echo $custom_error; ?>
<?php echo form_hidden( 'id', $media_group->id ) ?>

<fieldset><legend>Media Group Data for <?php echo $media_group->name ?></legend>

<div style='float:left;width:400px;'>

    <div class="input_field">
    <label for="name">Name<span class="required">*</span></label>                                
    <input class='mediumfield' id="name" type="text" name="name" value="<?php echo $media_group->name ?>" /><?php echo form_error('name','',''); ?>
    </div>

</div>

<p>
<br>
<br>
<br>
<input class="submit" type="submit" value="Submit" />

<?php echo form_close(); ?>

</div>