<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'slides_edit_form'));
        echo form_hidden('id',       $slides->id);
     ?>
    
    <fieldset id='form_edit_slides'><legend>Slides Data for &quot;<?=$slides->id;?>&quot;</legend>
        
    <div class="input_field">
        <label for="caption">Caption<span class="required">*</span></label>
        <textarea id="caption" style='height: 60px; width:400px' name="caption"><?=$slides->caption; ?></textarea>
        <?=form_error('caption','',''); ?>
    </div>

    <div class="input_field">
        <label for="meta_keywords">URL<span class="required">*</span></label>
        <input class='bigfield' id="url" type="text" name="url" value="<?=$slides->url; ?>" />
        <?=form_error('url','<div>','</div>'); ?>
    </div>
    
    <input class="submit" type="submit" value="Update" />
    
    <?=form_close(); ?>

</div>
