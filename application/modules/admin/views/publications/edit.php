<div class="box">

<?php echo form_open(current_url(), array('id'=>'publication_edit_form')); ?>

<?php echo $custom_error; ?>

<?php echo form_hidden( 'id',       $data->publication_id ) ?>

<fieldset id='form_publications'><legend>Publication Data for <?php echo $data->title?></legend>

<div class="input_field">
<label for="title">Title<span class="required">*</span></label>                                
<input class='bigfield' id="title" type="text" name="title" value='<?php echo addslashes($data->title); ?>' /><?php echo form_error('title','',''); ?>
</div>

	<!-- Authors -->
    <div id='author-template' style='display: none;'>
        <div class='author-item'>
          <a id='delete-::FIELD1::'>[ - ]</a>
          <?php

			$xx['select_name']  = 'select-::FIELD1::';
			$xx['option_name']  = '';
			$xx['id_field']		= 'id';
			$xx['menu_data']    = $author_menu_data;

    	     $this->load->view( 'helpers/generic_menu', $xx );
          ?>
       </div>
    </div>

    <div class='input_field'>
        <div class="input_field">
           <label for="title">Authors<span class="required">*</span></label>
    
           <div style='margin-left: 105px;'>
              <div id='authors' class='list'>    
              </div>
              <a id='add-author'>[ + ]</a>
           </div>
           <br>
        </div>
    </div>

<div class='input_field'>
    <div class="input_field">
        <label for="userfile">Publication File</label>
    </div>
    <input type='hidden' id="file_uuid" name="file_uuid" value="<?php echo $data->uuid; ?>"  />
    <div id='publication_file'>
        <center>
        <?php
            if( isset($data->uuid) ) {
                $url	= "/assets/media/" . $data->uuid;
                $params	= array('url' => $url, 'mime' => $data->mime_type);
                echo "<br>" . display_media($params);
            } else {
                echo "<br>No file uploaded.";
            }
        ?>
        <br>
        </center>
    </div>
    <center>
        <input type='button' onclick='updatePublicationFile(<?=$data->id;?>);' value='Update' ></input> |
        <input type='button' onclick='deletePublicationFile(<?=$data->media_id;?>);' value='Delete' ></input>
    </center>
</div>



<script type='text/javascript'><!--
    var global_media_id = <?=("" != $data->media_id ? $data->media_id:-1);?>;
    function updatePublicationFile(publicationId){

        var src = "admin/media/upload?mode=browser";
        src += "&message=" + escape("Choose an pdf or doc file, then upload.");
        var html = "<center>";
        html += '<iframe src="' + src + '" \
                            name="publication_file_upload" \
                            id="publication_file_upload" \
                            scrolling="auto" \
                            frameborder="no" \
                            align="center" \
                            height = "100px" \
                            width = "332px"></iframe></center>';
        $("#publication_file").html(html);
        $("#publication_file_upload").load(frameLoaded);
        
    }
    function deletePublicationFile(media_id)
    {
        if(null == media_id || '' == media_id) return;
        
        var answer = confirm('Are you sure you want to delete the associated file?')
        if (answer){
            sendDeleteCall(media_id, function(data){
                if(null != data && data.match(/Success/))
                {
                    $("#publication_file").html("<br><center>No file uploaded.</center><br>");
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
            var media_src = $(this).contents().find("#media_uuid").text().trim();
            var publicationId = $("#publication_edit_form input[name='id']");
            if(0 < publicationId.length)
            {
                sendDeleteCall(global_media_id);
                
                var url = "admin/publications/updatefile/" + publicationId.val() + "/" + media_id;
                $.get(url, function(data){
                    if(null != data && data.match(/Success/))
                    {
                        var html = "<br><center><a href='" + media_src + "'>";
                        var type = media_src.replace(/.*\./, '');
                        var picture_src = "";
                        if("doc" == type)
                        {
                            picture_src = "icon_doc.gif";
                        }
                        else if(type.match(/mov|mp3|mpeg|pdf/))
                        {
                            picture_src = "icon_" + type + ".png";
                        }
                        picture_src = 'assets/modules/admin/images/' + picture_src;
                        html += "<img src='" + picture_src + "'></a></center><br>";
                        $("#publication_file").html(html);
                        global_media_id = media_id;
                    }
                });

            }
        }
    }
--></script>
    




<div class="input_field">
<label for="abstract">Abstract</label>
<br>
<div class="input_field"><textarea name='abstract' class="textbox" cols="90" rows="6"><?php echo $data->abstract ?></textarea></div>
<?php echo form_error('abstract','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="project">Project<span class="required">*</span></label>                                
<input class='mediumfield' id="project" type="text" name="project" value="<?php echo $data->project ?>" /><?php echo form_error('project','',''); ?>
</div>

<div class="input_field">
<label for="url">Url<span class="required">*</span></label>
<input class='mediumfield' id="url" type="text" name="url" value="<?php echo $data->url ?>" /><?php echo form_error('url','',''); ?>
</div>

<div class="input_field">
<label for="doi">DOI</label>                                
<input class='mediumfield' id="doi" type="text" name="doi" value="<?php echo $data->doi ?>" />
<?php echo form_error('doi','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="pii">PII</label>                                
<input class='mediumfield' id="pii" type="text" name="pii" value="<?php echo $data->pii ?>"  />
<?php echo form_error('pii','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="identifier">Identifier</label>                                
<input class='mediumfield' id="identifier" type="text" name="identifier" value="<?php echo $data->identifier ?>"  />
<?php echo form_error('identifier','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="citekey">Citekey</label>                                
<input class='smallfield' id="citekey" type="text" name="citekey" value="<?php echo $data->citekey ?>"  />
<?php echo form_error('citekey','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="journal_title">Journal_Title</label>                                
<input class='bigfield' id="journal_title" type="text" name="journal_title" value="<?php echo addslashes($data->journal_title) ?>"  />
<?php echo form_error('journal_title','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="journal_year">Journal_Year</label>                                
<input class='smallfield' id="journal_year" type="text" name="journal_year" value="<?php echo $data->journal_year ?>"  />
<?php echo form_error('journal_year','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="journal_volume">Journal_Volume</label>                                
<input class='smallfield' id="journal_volume" type="text" name="journal_volume" value="<?php echo $data->journal_volume ?>"  />
<?php echo form_error('journal_volume','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="journal_issue">Journal_Issue</label>                                
<input class='smallfield' id="journal_issue" type="text" name="journal_issue" value="<?php echo $data->journal_issue ?>"  />
<?php echo form_error('journal_issue','<div>','</div>'); ?>
</div>

<div class="input_field">
<label for="journal_pages">Journal_Pages</label>                                
<input class='smallfield' id="journal_pages" type="text" name="journal_pages" value="<?php echo $data->journal_pages ?>"  />
<?php echo form_error('journal_pages','<div>','</div>'); ?>
</div>

<input class="submit" type="submit" value="Submit" />

<?php echo form_close(); ?>

</div>


<script type='text/javascript'>
	register_add_link( 'author', 'authors' );
<?php
	foreach( $auth as $author ) {  ?>
		AddNewGeneric( <?php echo $author['id']; ?>, 'author', 'authors' );
<?php }
?>
</script>