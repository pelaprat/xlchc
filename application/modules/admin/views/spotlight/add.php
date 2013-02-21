<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'spotlight_add_form'));
     ?>
    
    <fieldset id='form_add_spotlight'><legend>Add Spotlight</legend>
        
    <div class="input_field">
        <label for="title">Title<span class="required">*</span></label>                                
        <input class='bigfield' id="title" type="text" name="title" value="<?=set_value('title');?>" />
        <?=form_error('title','',''); ?>
    </div>
    
    <div class="input_field">
        <label for="meta_keywords">Description<span class="required">*</span></label>
        <textarea id="description" name="description"><?=set_value('description');?></textarea>
        <?=form_error('description','<div>','</div>'); ?>
    </div>
    
    <input class="submit" type="submit" value="Add Spotlight" />
    
    <?=form_close(); ?>

</div>
