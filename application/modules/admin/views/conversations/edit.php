<div class="box">

<?php echo form_open(current_url(), array('id'=>'user_profile_edit_form')); ?>
<?php echo $custom_error; ?>

<?php echo form_hidden('id',      $conversation->id) ?>

<fieldset><legend>Tag Data for <?php echo $conversation->subject ?></legend>

<div style='float:left;width:400px;'>

    <div class="input_field">
    <label for="subject">Subject<span class="required">*</span></label>                                
    <input class='mediumfield' id="subject" type="text" name="subject" value="<?php echo $conversation->subject ?>" /><?php echo form_error('subject','',''); ?>
    </div>

</div>

<p>
<br>
<br>
<br>
<input class="submit" type="submit" value="Submit" />

<?php echo form_close(); ?>

</div>