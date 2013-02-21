<div class="box">
    
    <?php 
        echo $custom_error;
        
        echo form_open(current_url(), array('id'=>'partner_edit_form'));
        echo form_hidden('id',       $partner->id);
     ?>
    
    <fieldset id='form_edit_partner'><legend>Partner Project Data for &quot;<?=$partner->name;?>&quot;</legend>
        
    <div class="input_field">
        <label for="title">Name<span class="required">*</span></label>                                
        <input class='bigfield' id="name" type="text" name="name" value="<?=$partner->name; ?>" />
        <?=form_error('name','',''); ?>
    </div>
    
    <div class="input_field">
        <label for="meta_title">Address<span class="required">*</span></label>
        <input class='bigfield' id="address" type="text" name="address" value="<?=$partner->address; ?>"  />
        <?=form_error('address','<div>','</div>'); ?>
    </div>

    <div class="input_field">
        <label for="meta_title">Country<span class="required">*</span></label>
        <input class='bigfield' id="country" type="text" name="country" value="<?=$partner->country; ?>"  />
        <?=form_error('country','<div>','</div>'); ?>
    </div>
    
    <!-- javascript:void(prompt('',gApplication.getMap().getCenter())); -->
    
    <div class="input_field">
        <label for="title">Latitude<span class="required">*</span></label>                                
        <input class='smallfield' id="latitude" type="text" name="latitude" value="<?=$partner->latitude; ?>" />
        <?=form_error('latitude','',''); ?>
    </div>
    
    <div class="input_field">
        <label for="title">Longitude<span class="required">*</span></label>                                
        <input class='smallfield' id="longitude" type="text" name="longitude" value="<?=$partner->longitude; ?>" />
        <?=form_error('longitude','',''); ?>
    </div>
    
    <div class="input_field">
        <label for="meta_keywords">Description<span class="required">*</span></label>
        <textarea id="description" name="description"><?=$partner->description; ?></textarea>
        <?=form_error('description','<div>','</div>'); ?>
    </div>
    
    <input class="submit" type="submit" value="Edit" />
    
    <?=form_close(); ?>

</div>
