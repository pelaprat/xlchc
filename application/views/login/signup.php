<div class="article">
 	<h2><?php echo htmlentities($page->title); ?></h2>

	<?php if( isset($custom_error)) { 
		echo $custom_error; 
	} ?>

    <?php echo form_open('login/create'); ?>
	<table style="border: 2px solid #666666;">
	<tr>
	  <td class='table-label'>First Name*</td>
	  <td><input class='table-text-input' type=text name='first' value="<?php echo set_value('first'); ?>" size=50><?php echo form_error('first','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Last Name*</td>
	  <td><input class='table-text-input' type=text name='last' value="<?php echo set_value('last'); ?>" size=50><?php echo form_error('last','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Email Address*</td>
	  <td><input class='table-text-input' type=text name='email' value="<?php echo set_value('email'); ?>" size=50><?php echo form_error('email','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Password*</td>
	  <td><input class='table-text-input' type=password name='password_1' value="" size=50><?php echo form_error('password_1','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Verify Password*</td>
	  <td><input class='table-text-input' type=password name='password_2' value="" size=50><?php echo form_error('password_2','',''); ?></td>
	</tr>

	<tr>
	  <td class='table-label'>Institution</td>
	  <td><input class='table-text-input' type=text name='institution' value="<?php echo set_value('institution'); ?>" size=50><?php echo form_error('institution','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Department</td>
	  <td><input class='table-text-input' type=text name='department' value="<?php echo set_value('department'); ?>" size=50><?php echo form_error('department','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Web Address</td>
	  <td><input class='table-text-input' type=text name='website' value="<?php echo set_value('website'); ?>" size=50><?php echo form_error('website','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Gender</td>
	  <td><input class='table-text-input' type=text name='gender' value="<?php echo set_value('gender'); ?>" size=50><?php echo form_error('gender','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Ethnicity</td>
	  <td><input class='table-text-input' type=text name='ethnicity' value="<?php echo set_value('ethnicity'); ?>" size=50><?php echo form_error('ethnicity','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Research Interests</td>
	  <td><textarea class='table-textarea-input' name='research'><?php echo set_value('research'); ?></textarea><?php echo form_error('research','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'>Biographical Note</td>
	  <td><textarea class='table-textarea-input' name='bio'><?php echo set_value('bio'); ?></textarea><?php echo form_error('bio','',''); ?></td>
	</tr>
	<tr>
	  <td class='table-label'></td>
	  <td><?= $recaptcha ?>
	      <?php echo form_error('recaptcha_challenge_field','',''); ?>
	  </td>
	</tr>
	<tr>
	  <td class='table-label'></td>
	  <td><input class='table-submit' type='submit' name='submit' value='Signup'></td>
	</tr>
	</table>
	</form>

        <br style="clear: both;">
      </div>
    </div>
</div>