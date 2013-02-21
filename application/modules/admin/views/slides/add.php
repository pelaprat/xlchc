<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'slides_add_form'));
     ?>
    
    <fieldset id='form_add_slides'><legend>Add Slide</legend>
        
    <div class="input_field">
        <label for="caption">Caption<span class="required">*</span></label>
        <textarea id="caption" style='height: 60px; width:400px' name="caption"><?= set_value('caption'); ?></textarea>
        <?=form_error('caption','',''); ?>
    </div>
    
    <div class="input_field">
        <label for="meta_keywords">URL<span class="required">*</span></label>
        <input class='bigfield' id="url" type="text" name="url" value="<?= set_value('url') ; ?>" />
        <?=form_error('url','<div>','</div>'); ?>
    </div>
    
    <input class="submit" type="submit" value="Add Slide" />
    
    <?=form_close(); ?>

</div>
