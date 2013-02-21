<?php     

echo form_open(current_url()); ?>
<?php echo $custom_error; ?>
<?php echo form_hidden('userID',$result->userID) ?>

                                    <p><label for="username">Username<span class="required">*</span></label>                                
                                    <input id="username" type="text" name="username" value="<?php echo $result->username ?>"  />
                                    <?php echo form_error('username','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="password">Password<span class="required">*</span></label>                                
                                    <input id="password" type="password" name="password" value="<?php echo $result->password ?>"  />
                                    <?php echo form_error('password','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="name">Name<span class="required">*</span></label>                                
                                    <input id="name" type="text" name="name" value="<?php echo $result->name ?>"  />
                                    <?php echo form_error('name','<div>','</div>'); ?>
                                    </p>
                                    
<p>
        <?php echo form_submit( 'submit', 'Submit'); ?>
</p>

<?php echo form_close(); ?>
