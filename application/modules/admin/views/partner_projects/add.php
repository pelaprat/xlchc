<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'partner_add_form'));
     ?>
    
    <fieldset id='form_add_partner'><legend>Add Partner Project</legend>
        
    <div class="input_field">
        <label for="title">Name<span class="required">*</span></label>                                
        <input class='bigfield' id="name" type="text" name="name" value="<?=set_value('name'); ?>" />
        <?=form_error('name','',''); ?>
    </div>
    
    <div class="input_field">
        <label for="meta_title">Address<span class="required">*</span></label>
        <input class='bigfield' id="address" type="text" name="address" value="<?=set_value('address'); ?>"  />
        <?=form_error('address','<div>','</div>'); ?>
    </div>

    <div class="input_field">
        <label for="meta_title">Country<span class="required">*</span></label>
        <input class='bigfield' id="country" type="text" name="country" value="<?=set_value('country'); ?>"  />
        <?=form_error('country','<div>','</div>'); ?>
    </div>
    
    <!-- javascript:void(prompt('',gApplication.getMap().getCenter())); -->
    
    <div class="input_field">
        <label for="title">Latitude<span class="required">*</span></label>                                
        <input class='smallfield' id="latitude" type="text" name="latitude" value="<?=set_value('latitude'); ?>" />
        <?=form_error('latitude','',''); ?>
    </div>
    
    <div class="input_field">
        <label for="title">Longitude<span class="required">*</span></label>                                
        <input class='smallfield' id="longitude" type="text" name="longitude" value="<?=set_value('longitude'); ?>" />
        <?=form_error('longitude','',''); ?>
    </div>
    
    <div class="input_field">
        <label for="meta_keywords">Description<span class="required">*</span></label>
        <textarea id="description" name="description"><?=set_value('description'); ?></textarea>
        <?=form_error('description','<div>','</div>'); ?>
    </div>
    
    <input class="submit" type="submit" value="Add Partner Project" />
    
    <?=form_close(); ?>

</div>