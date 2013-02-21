<div class="box">

<?php echo form_open(current_url()); ?>
<?php echo $custom_error; ?>

<fieldset><legend>Add Person</legend>

<div class="input_field">
<label for="first">First Name<span class="required">*</span></label>                                
<input class='mediumfield' id="first" type="text" name="first" value="<?php echo set_value('first'); ?>" /><?php echo form_error('first','',''); ?>
</div>

<div class="input_field">
<label for="last">Last Name<span class="required">*</span></label>                                
<input class='mediumfield' id="last" type="text" name="last" value="<?php echo set_value('last'); ?>" /><?php echo form_error('last','',''); ?>
</div>

<div class="input_field">
<label for="email">Email<span class="required">*</span></label>
<input class='mediumfield' id="email" type="text" name="email" value="<?php echo set_value('email') ?>" /><?php echo form_error('email','',''); ?>
</div>


<div id='xgroup-template' style='display: none;'>
	<div class='xgroup-item'>
		<a id='delete-::FIELD1::'>[ - ]</a>
		<?php

			$xx['select_name']  = 'select-::FIELD1::';
			$xx['option_name']  = '';
			$xx['id_field']		= 'id';
			$xx['menu_data']    = $xgroup_menu_data;

			$this->load->view( 'helpers/generic_menu', $xx );
		?>
	</div>
</div>

<div class='input_field'>
	<div class="input_field">
		<label for="title">Groups<span class="required">*</span></label>

		<div style='margin-left: 105px;'>
			<div id='xgroups' class='list'>    
			</div>
			<a id='add-xgroup'>[ + ]</a>
		</div>
		<br>
	</div>
</div>


<div class="input_field">
<label for="institution">Institution</label>
<input class='mediumfield' id="institution" type="text" name="institution" value="<?php echo set_value('institution'); ?>" />
<?php echo form_error('institution','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="department">Department</label>
<input class='mediumfield' id="department" type="text" name="department" value="<?php echo set_value('department'); ?>"  />
<?php echo form_error('department','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="website">Website</label>                                
<input class='mediumfield' id="website" type="text" name="website" value="<?php echo set_value('website'); ?>"  />
<?php echo form_error('website','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="gender">Gender</label>                                
<input class='smallfield' id="gender" type="text" name="gender" value="<?php echo set_value('gender'); ?>"  />
<?php echo form_error('gender','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="ethnicity">Ethnicity</label>                                
<input class='smallfield' id="ethnicity" type="text" name="ethnicity" value="<?php echo set_value('ethnicity') ?>"  />
<?php echo form_error('ethnicity','<div>','</div>'); ?>
</div>

<div class="input_field">
<p><label for="research">Research Interests</label>                                
<textarea id="research" name="research" cols="90" rows="6"><?php echo set_value('research'); ?></textarea>
<?php echo form_error('research','<div>','</div>'); ?>
</div>

<div class="input_field">
<p><label for="bio">Bio</label>                                
<textarea id="bio" name="bio" cols="90" rows="6"><?php echo set_value('bio'); ?></textarea>
<?php echo form_error('bio','<div>','</div>'); ?>
</div>


<input class="submit" type="submit" value="Submit" />

<?php echo form_close(); ?>

</div>

<!--- This bit of script registers the ----!>
<!---  link above that adds menu items ----!>
<!---  and populates the groups.       ----!>
<script type='text/javascript'>
    register_add_link( 'xgroup', 'xgroups' );
</script>