<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'sideboxes_add_form'));
     ?>
    
    <fieldset id='form_add_sideboxes'><legend>Add Sideboxes</legend>
            
    <div class="input_field">
        <label for="meta_keywords">Title<span class="required">*</span></label>
        <input class='bigfield' id="title" type="text" name="title" value="<?= set_value('title') ; ?>" />
        <?=form_error('title','<div>','</div>'); ?>
    </div>

    <div class="input_field">
        <label for="content">Content<span class="required">*</span></label>
        <textarea id="content" style='height: 260px; width:400px' name="content"><?= set_value('content'); ?></textarea>
        <?=form_error('content','',''); ?>
    </div>

    <input class="submit" type="submit" value="Add Sideboxes" />
    
    <?=form_close(); ?>

</div>
