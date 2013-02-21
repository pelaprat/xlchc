<?php     

echo form_open(current_url()); ?>
<?php echo $custom_error; ?>

                                    <p><label for="relationship_id">Relationship_id<span class="required">*</span></label>                                
                                    <input id="relationship_id" type="text" name="relationship_id" value="<?php echo set_value('relationship_id'); ?>"  />
                                    <?php echo form_error('relationship_id','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="slug">Slug<span class="required">*</span></label>                                
                                    <input id="slug" type="text" name="slug" value="<?php echo set_value('slug'); ?>"  />
                                    <?php echo form_error('slug','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="first_name">First_name<span class="required">*</span></label>                                
                                    <input id="first_name" type="text" name="first_name" value="<?php echo set_value('first_name'); ?>"  />
                                    <?php echo form_error('first_name','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="last_name">Last_name<span class="required">*</span></label>                                
                                    <input id="last_name" type="text" name="last_name" value="<?php echo set_value('last_name'); ?>"  />
                                    <?php echo form_error('last_name','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="institutional_affiliation">Institutional_affiliation<span class="required">*</span></label>                                
                                    <input id="institutional_affiliation" type="text" name="institutional_affiliation" value="<?php echo set_value('institutional_affiliation'); ?>"  />
                                    <?php echo form_error('institutional_affiliation','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="departmental_affiliation">Departmental_affiliation<span class="required">*</span></label>                                
                                    <input id="departmental_affiliation" type="text" name="departmental_affiliation" value="<?php echo set_value('departmental_affiliation'); ?>"  />
                                    <?php echo form_error('departmental_affiliation','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="email">Email<span class="required">*</span></label>                                
                                    <input id="email" type="text" name="email" value="<?php echo set_value('email'); ?>"  />
                                    <?php echo form_error('email','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="website">Website<span class="required">*</span></label>                                
                                    <input id="website" type="text" name="website" value="<?php echo set_value('website'); ?>"  />
                                    <?php echo form_error('website','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="gender">Gender<span class="required">*</span></label>                                
                                    <input id="gender" type="text" name="gender" value="<?php echo set_value('gender'); ?>"  />
                                    <?php echo form_error('gender','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="ethnicity">Ethnicity<span class="required">*</span></label>                                
                                    <input id="ethnicity" type="text" name="ethnicity" value="<?php echo set_value('ethnicity'); ?>"  />
                                    <?php echo form_error('ethnicity','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="research_interests">Research_interests<span class="required">*</span></label>                                
                                    <textarea id="research_interests" name="research_interests"><?php echo set_value('research_interests'); ?></textarea>
                                    <?php echo form_error('research_interests','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="image">Image<span class="required">*</span></label>                                
                                    <input id="image" type="text" name="image" value="<?php echo set_value('image'); ?>"  />
                                    <?php echo form_error('image','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="bio">Bio<span class="required">*</span></label>                                
                                    <textarea id="bio" name="bio"><?php echo set_value('bio'); ?></textarea>
                                    <?php echo form_error('bio','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="pw_salt">Pw_salt</label>                                
                                    <input id="pw_salt" type="text" name="pw_salt" value="<?php echo set_value('pw_salt'); ?>"  />
                                    <?php echo form_error('pw_salt','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="pw_hash">Pw_hash</label>                                
                                    <input id="pw_hash" type="text" name="pw_hash" value="<?php echo set_value('pw_hash'); ?>"  />
                                    <?php echo form_error('pw_hash','<div>','</div>'); ?>
                                    </p>
                                    
<p>
        <?php echo form_submit( 'submit', 'Submit'); ?>
</p>

<?php echo form_close(); ?>
