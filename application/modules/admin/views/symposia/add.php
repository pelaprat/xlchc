<div class="box">
	<?php 

	if( isset($custom_error) ) { 
		echo $custom_error;
	}

	echo form_open(current_url(), array('id'=>'symposium_add_form'));
	?>

	<!-- Instructor Template -->
	<div id='instructor-template' style='display: none;'>
		<div class='instructor-item'>
		  <a id='delete-::FIELD1::'>[ - ]</a>
		  <?php

			$xx['select_name']	= 'select-::FIELD1::';
			$xx['option_name']	= '';
			$xx['id_field']		= 'person_id';
			$xx['menu_data']	= $instructor_menu_data;

			$this->load->view( 'helpers/generic_menu', $xx );
		  ?>
	   </div>
	</div>

	<!-- Member Template -->
	<div id='member-template' style='display: none;'>
		<div class='member-item'>
		  <a id='delete-::FIELD1::'>[ - ]</a>
		  <?php

			$xx['select_name']	= 'select-::FIELD1::';
			$xx['option_name']	= '';
			$xx['id_field']		= 'person_id';
			$xx['menu_data']	= $member_menu_data;

			$this->load->view( 'helpers/generic_menu', $xx );
		  ?>
	   </div>
	</div>

	<fieldset id='form_add_symposium'>
		<legend>Add Symposium</legend>

		<!-- Instructors -->
		<div class="input_field">
		   <label for="instructors">Instructor<span class="required">*</span></label>

		   <div style='margin-left: 105px;'>
			  <div id='instructors' class='list'>	
			  </div>
			  <a id='add-instructor'>[ + ]</a>
		   </div>
		   <br>
		</div>

		<!-- Members -->
		<div class="input_field">
		   <label for="members">Members</label>

		   <div style='margin-left: 105px;'>
			  <div id='members' class='list'>	
			  </div>
			  <a id='add-member'>[ + ]</a>
		   </div>
		   <br>
		</div>

		<div class="input_field">
			<label for="meta_keywords">&nbsp;</label>
			<?php echo form_checkbox( 'f_private', '1', false ); ?>
			Private symposium
		</div>

		<div class="input_field">
			<label for="url">Subject<span class="required">*</span></label>
			<input class='mediumfield' id="subject" type="text" name="subject" value="<?php echo set_value('subject'); ?>" />
		</div>

		<div class="input_field">
			<label for="summary">Summary<span class="required">*</span></label>
			<textarea id="summary" style='height: 160px; width:400px' name="summary"><?php echo set_value('summary'); ?></textarea>
		</div>

		<div class="input_field">
			<label for="url">Video URL<span class="required">*</span></label>
			<input class='bigfield' id="url_video" type="text" name="url_video" value="<?php echo set_value('url_video'); ?>" />
		</div>


		<div id='media'>
			<div class="input_field">
				<label for="media">Media</label>
				<a id="add-media-file">[ + ]</a>
				<div id='media-files'></div>

				<!-- Upload form template -->
				<div class='hide' id='media-file-template'>
					<input id='select-::FIELD1::-media_id' type='hidden' name='select-::FIELD1::-media_id' value=''>

					<a id='delete-::FIELD1::'>[ - ]</a>
					<input class='bigfield' id="select-::FIELD1::" type="text" name="select-::FIELD1::" value=""/>
				</div>
			</div>
		</div>

	</fieldset>

	<br>
	<input class="submit" type="submit" value="Add Symposium" />

	<?=form_close(); ?>

</div>

<script type='text/javascript'>

	//////////////////////////////////////////////
	// Make a callback function for our media   //
	//  items so that when they are cloned we   //
	//  alter its properties to produce the     //
	//  media browser when the item is clicked. //
	//
	media_callback = function( clone ) { 
		clone.find('input[type=text]').mediaPopup( popupTracker );
	}

	// Produce the media-files instructors & members
	register_add_link( 'media-file', 'media-files', media_callback );
	register_add_link( 'instructor',	'instructors' );
	register_add_link( 'member', 		'members' );

	// Media pop up javascript
	var current_target = null;
	function popupTracker( target ) {
		current_target = target;
	}

	function popup_callback( media_id, name ) {
		// Current_target is the input field
		//  that was clicked on to produce the
		//  media browser. Now that an item is
		//  selected that input field will have
		//  its value set to "name." But what 
		//  we also want is to set a hidden field
		//  there to have the media id. So we first
		//  need to get the parent of the input field.

		// Get the hidden field and set its value
		parent = current_target.parent();
		parent.find('input[type=hidden]').val(media_id);

		// Change the value of the input field
		current_target.val(name);

		// Close shadowbox
		Shadowbox.close();
	}


</script>


