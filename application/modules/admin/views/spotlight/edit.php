<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'spotlight_edit_form'));
        echo form_hidden('id',       $spotlight->id);
     ?>
    
    <fieldset id='form_edit_spotlight'><legend>Spotlight Data for &quot;<?=$spotlight->title;?>&quot;</legend>
        
    <div class="input_field">
        <label for="title">Title<span class="required">*</span></label>                                
        <input class='bigfield' id="title" type="text" name="title" value="<?=$spotlight->title; ?>" />
        <?=form_error('title','',''); ?>
    </div>
    
    <div class="input_field">
        <label for="meta_keywords">Description<span class="required">*</span></label>
        <textarea id="description" name="description"><?=$spotlight->description; ?></textarea>
        <?=form_error('description','<div>','</div>'); ?>
    </div>
    
    <input class="submit" type="submit" value="Update" />
    
    <?=form_close(); ?>

</div>
