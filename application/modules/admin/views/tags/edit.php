<div class="box">

<?php echo form_open(current_url(), array('id'=>'user_profile_edit_form')); ?>
<?php echo $custom_error; ?>

<?php echo form_hidden('id',      $tag->id) ?>

<fieldset><legend>Tag Data for <?php echo $tag->name ?></legend>

<div style='float:left;width:400px;'>

    <div class="input_field">
    <label for="name">Name<span class="required">*</span></label>                                
    <input class='mediumfield' id="name" type="text" name="name" value="<?php echo $tag->name ?>" /><?php echo form_error('name','',''); ?>
    </div>

</div>

<p>
<br>
<br>
<br>
<input class="submit" type="submit" value="Submit" />

<?php echo form_close(); ?>

</div>