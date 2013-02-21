<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'page_edit_form'));
        echo form_hidden('id',       $page->id);
    ?>
    
    <fieldset id='form_edit_publication'><legend>Page Data for &quot;<?=$page->title;?>&quot;</legend>
    
    <div class="input_field">
        <label for="title">Title<span class="required">*</span></label>                                
        <input class='bigfield' id="title" type="text" name="title" value="<?php echo $page->title ?>" />
        <?php echo form_error('title','',''); ?>
    </div>
    <div class="input_field">
        <label for="uri">Uri<span class="required">*</span></label>
        <input class='bigfield' id="uri" type="text" name="uri" value="<?php echo $page->uri ?>"  />
        <?php echo form_error('uri','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_title">Title<span class="required">*</span></label>
        <input class='bigfield' id="meta_title" type="text" name="meta_title" value="<?php echo $page->meta_title ?>"  />
        <?php echo form_error('meta_title','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_language">Language<span class="required">*</span></label>
        <input class='bigfield' id="meta_language" type="text" name="meta_language" value="<?php echo $page->meta_language ?>"  />
        <?php echo form_error('meta_language','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_content_type">Content Type<span class="required">*</span></label>
        <input class='bigfield' id="meta_content_type" type="text" name="meta_content_type" value="<?php echo $page->meta_content_type ?>"  />
        <?php echo form_error('meta_content_type','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_description">Description<span class="required">*</span></label>
        <input class='bigfield' id="meta_description" type="text" name="meta_description" value="<?php echo $page->meta_description ?>"  />
        <?php echo form_error('meta_description','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_keywords">Keywords<span class="required">*</span></label>
        <input class='bigfield' id="meta_keywords" type="text" name="meta_keywords" value="<?php echo $page->meta_keywords ?>"  />
        <?php echo form_error('meta_keywords','<div>','</div>'); ?>
    </div>


    <!-------------------------------->
    <!--- ADD / REMOVE SIDEBOXES ----->
    <div id='sidebox-template' style='display: none;'>
        <div class='sidebox-item'>
          <a id='delete-::FIELD1::'>[ - ]</a>
          <?php

             $xx['select_name']  = 'select-::FIELD1::';
	     $xx['option_name']  = '';
	     $xx['menu_data']    = $sidebox_menu_data;

    	     $this->load->view( 'helpers/generic_menu', $xx );
          ?>
       </div>
    </div>

    <div class='input_field'>
        <div class="input_field">
           <label for="title">Sideboxes<span class="required">*</span></label>
    
           <div style='margin-left: 105px;'>
              <div id='sideboxes' class='list'>    
              </div>
              <a id='add-sidebox'>[ + ]</a>
           </div>
           <br>
        </div>
    </div>
    <!--- /// ADD / REMOVE SIDEBOXES ----->
    <!------------------------------------>


    <p>
    <div class="input_field">
        <label for="content">Content<span class="required">*</span></label>
        <textarea id="content" name="content"><?php echo $page->content ?></textarea>
        <?php echo form_error('content','<div>','</div>'); ?>
    </div>
        
    <input class="submit" type="submit" value="Edit" />
    
    <?php echo form_close(); ?>

</div>

<!--- This bit of script registers the ----!>
<!---  link above that adds menu items ----!>
<script type='text/javascript'>
	register_add_link( 'sidebox', 'sideboxes' );

<?php
   foreach( $sideboxes->result() as $sidebox ) {  ?>
      AddNewGeneric( <?php echo $sidebox->sidebox_id; ?>, 'sidebox', 'sideboxes' );
<?php }
?>
</script>



