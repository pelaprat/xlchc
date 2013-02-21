<div class="box">

<?php echo form_open(current_url(), array('id'=>'user_profile_edit_form')); ?>
<?php echo $custom_error; ?>

<?php echo form_hidden('id',      $person->id) ?>
<?php echo form_hidden('slug',    $person->slug) ?>
<?php echo form_hidden('image',   $person->image) ?>

<?php echo form_hidden('relationship_id',$person->relationship_id) ?>

<fieldset><legend>Person Data for <?php echo $person->first . ' ' . $person->last ?></legend>

<div style='float:left;width:400px;'>

    <div class="input_field">
    <label for="first">First Name<span class="required">*</span></label>                                
    <input class='mediumfield' id="first" type="text" name="first" value="<?php echo $person->first ?>" /><?php echo form_error('first','',''); ?>
    </div>
    
    <div class="input_field">
    <label for="last">Last Name<span class="required">*</span></label>                                
    <input class='mediumfield' id="last" type="text" name="last" value="<?php echo $person->last ?>" /><?php echo form_error('last','',''); ?>
    </div>
    
    <div class="input_field">
    <label for="email">Email<span class="required">*</span></label>
    <input class='mediumfield' id="email" type="text" name="email" value="<?php echo $person->email ?>" /><?php echo form_error('email','',''); ?>
    </div>
    
    <div class="input_field">
    <label for="institution">Institution</label>                                
    <input class='mediumfield' id="institution" type="text" name="institution" value="<?php echo $person->institution ?>" />
    <?php echo form_error('institution','<div>','</div>'); ?>
    </div>
    
    <div class="input_field">
    <label for="department">Department</label>                                
    <input class='mediumfield' id="department" type="text" name="department" value="<?php echo $person->department ?>"  />
    <?php echo form_error('department','<div>','</div>'); ?>
    </div>
    
    <div class="input_field">
    <label for="website">Website</label>                                
    <input class='mediumfield' id="website" type="text" name="website" value="<?php echo $person->website ?>"  />
    <?php echo form_error('website','<div>','</div>'); ?>
    </div>
    
    <div class="input_field">
    <label for="gender">Gender</label>                                
    <input class='smallfield' id="gender" type="text" name="gender" value="<?php echo $person->gender ?>"  />
    <?php echo form_error('gender','<div>','</div>'); ?>
    </div>
    
    <div class="input_field">
    <label for="ethnicity">Ethnicity</label>                                
    <input class='smallfield' id="ethnicity" type="text" name="ethnicity" value="<?php echo $person->ethnicity ?>"  />
    <?php echo form_error('ethnicity','<div>','</div>'); ?>
    </div>

</div>

<div style='width:415px;height:420px;margin:0px 0px 0px 5px;float:left;border:solid thin #aaaaaa;'>
    <div class="input_field">
        <label for="ethnicity">Profile Picture</label>
    </div>
    <input type='hidden' id="picture_uuid" name="picture_uuid" value="<?php echo $person->uuid; ?>"  />
    <div id='profile_picture' style='width:100%;height:375px;'>
        <?php
            $picture_src = ($person->uuid ? "assets/media/" . $person->uuid:"assets/images/empty_profile_picture.png");
        ?>
        <br>
        <center>
            <img src='<?=$picture_src;?>' width='355' height='350'><br>
        </center>
    </div>
    <center>
        <input type='button' onclick='updateProfilePicture();' value='Update' ></input> |
        <input type='button' onclick='deleteProfilePicture(<?=$person->media_id;?>);' value='Delete' ></input>
    </center>
</div>
<div style='clear:both' />

<script type='text/javascript'><!--
    var global_media_id = <?=("" != $person->media_id ? $person->media_id:-1);?>;
    function updateProfilePicture(){
        //$("#iFrame").contents().find("#someDiv").removeClass("hidden");
        var src = "admin/media/upload?mode=browser";
        src += "&message=" + escape("Choose an image file, then upload to set your profile picture.");
        var html = "<br><br><br><center>";
        html += '<iframe src="' + src + '" \
                            name="profile_image_upload" \
                            id="profile_image_upload" \
                            scrolling="auto" \
                            frameborder="no" \
                            align="center" \
                            height = "422px" \
                            width = "332px"></iframe></center>';
        $("#profile_picture").html(html);
        $("#profile_image_upload").load(frameLoaded);
        
    }
    function deleteProfilePicture(media_id)
    {
        if(null == media_id || '' == media_id) return;
        
        var answer = confirm('Are you sure you want to delete your profile picture?')
        if (answer){
            sendDeleteCall(media_id, function(data){
                if(null != data && data.match(/Success/))
                {
                    $("#profile_picture").html("<br><center><img src='assets/images/empty_profile_picture.png' width='355' height='350'></center><br>");
                }
            });
        }
    }
    
    function sendDeleteCall(media_id, callback)
    {
        if(-1 == media_id) return;
        
        $.get("admin/media/delete/" + media_id + "?&mode=browser", function(data){
            if(null != callback){
                callback(data);
            }
        });
    }
    
    function frameLoaded(){
        var media_id = $(this).contents().find("#media_id");
        if(0 < media_id.length)
        {
            media_id = media_id.text().trim();
            var pictureSrc = $(this).contents().find("#media_uuid").text().trim();
            var personId = $("#user_profile_edit_form input[name='id']");
            if(0 < personId.length)
            {
                sendDeleteCall(global_media_id);
                
                var url = "admin/people/updatepicture/" + personId.val() + "/" + media_id;
                $.get(url, function(data){
                    if(null != data && data.match(/Success/))
                    {
                        $("#profile_picture").html("<br><center><img src='" + pictureSrc + "' width='355' height='350'></center><br>");
                    }
                });

            }
        }
    }
--></script>


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

	<div>
		<div class="input_field">
		<label for="bio">Research</label>
		<br>
		<div class="input_field"><textarea name='research' class="textbox" cols="90" rows="6"><?php echo $person->research ?></textarea></div>
		<?php echo form_error('research','<div>','</div>'); ?>
		</div>

		<div class="input_field">
		<label for="bio">Biography</label>
		<br>
		<div class="input_field"><textarea name='bio' class="textbox" cols="90" rows="6"><?php echo $person->bio ?></textarea></div>
		<?php echo form_error('bio','<div>','</div>'); ?>
		</div>
	</div>

<input class="submit" type="submit" value="Submit" />

<?php echo form_close(); ?>

</div>

<script type='text/javascript'>
    register_add_link( 'xgroup', 'xgroups' );

<?php
   foreach( $groups->result() as $group ) {  ?>
      AddNewGeneric( <?php echo $group->id; ?>, 'xgroup', 'xgroups' );
<?php }
?>
</script>



