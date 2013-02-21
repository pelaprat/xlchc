<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'page_add_form'));
    ?>
    
    <fieldset id='form_add_page'><legend>Add Page</legend>
    
    <div class="input_field">
        <label for="title">Title<span class="required">*</span></label>                                
        <input class='bigfield' id="title" type="text" name="title" value="<?=set_value('title'); ?>" />
        <?=form_error('title','',''); ?>
    </div>
    <div class="input_field">
        <label for="uri">Uri<span class="required">*</span></label>
        <input class='bigfield' id="uri" type="text" name="uri" value="<?=set_value('uri'); ?>"  />
        <?=form_error('uri','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_title">Meta_title<span class="required">*</span></label>
        <input class='bigfield' id="meta_title" type="text" name="meta_title" value="<?=set_value('meta_title'); ?>"  />
        <?=form_error('meta_title','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_language">Meta_language<span class="required">*</span></label>
        <input class='bigfield' id="meta_language" type="text" name="meta_language" value="<?=set_value('meta_language', 'en-US'); ?>"  />
        <?=form_error('meta_language','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_content_type">Meta_content_type<span class="required">*</span></label>
        <input class='bigfield' id="meta_content_type" type="text" name="meta_content_type" value="<?=set_value('meta_content_type', 'text/html; charset=utf-8'); ?>"  />
        <?=form_error('meta_content_type','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_description">Meta_description<span class="required">*</span></label>
        <textarea id="meta_description" name="meta_description"><?=set_value('meta_description'); ?></textarea>
        <?=form_error('meta_description','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="meta_keywords">Meta_keywords<span class="required">*</span></label>
        <textarea id="meta_keywords" name="meta_keywords"><?=set_value('meta_keywords'); ?></textarea>
        <?=form_error('meta_keywords','<div>','</div>'); ?>
    </div>
    <div class="input_field">
        <label for="content">Content<span class="required">*</span></label>
        <textarea id="content" name="content"><?=set_value('content'); ?></textarea>
        <?=form_error('content','<div>','</div>'); ?>
    </div>
    
    
    <input class="submit" type="submit" value="Add Page" />
    
    <?=form_close(); ?>

</div>
