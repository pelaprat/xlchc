<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'sideboxes_edit_form'));
        echo form_hidden('id', $sideboxes->id);
     ?>
    
    <fieldset id='form_edit_sideboxes'><legend>Sideboxes Data for &quot;<?=$sideboxes->id;?>&quot;</legend>
        
    <div class="input_field">
        <label for="meta_keywords">Title<span class="required">*</span></label>
        <input class='bigfield' id="title" type="text" name="title" value="<?=$sideboxes->title; ?>" />
        <?=form_error('title','<div>','</div>'); ?>
    </div>
    
    <div class="input_field">
        <label for="content">Content<span class="required">*</span></label>
        <textarea id="content" style='height: 260px; width:400px' name="content"><?=$sideboxes->content; ?></textarea>
        <?=form_error('content','',''); ?>
    </div>

    <input class="submit" type="submit" value="Update" />
    
    <?=form_close(); ?>

</div>
