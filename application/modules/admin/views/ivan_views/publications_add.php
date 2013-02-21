<?php     

echo form_open(current_url()); ?>
<?php echo $custom_error; ?>

                                    <p><label for="title">Title<span class="required">*</span></label>                                
                                    <input id="title" type="text" name="title" value="<?php echo set_value('title'); ?>"  />
                                    <?php echo form_error('title','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="filename">Filename<span class="required">*</span></label>                                
                                    <input id="filename" type="text" name="filename" value="<?php echo set_value('filename'); ?>"  />
                                    <?php echo form_error('filename','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="abstract">Abstract<span class="required">*</span></label>                                
                                    <input id="abstract" type="text" name="abstract" value="<?php echo set_value('abstract'); ?>"  />
                                    <?php echo form_error('abstract','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="project">Project<span class="required">*</span></label>                                
                                    <input id="project" type="text" name="project" value="<?php echo set_value('project'); ?>"  />
                                    <?php echo form_error('project','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="url">Url<span class="required">*</span></label>                                
                                    <input id="url" type="text" name="url" value="<?php echo set_value('url'); ?>"  />
                                    <?php echo form_error('url','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="doi">Doi<span class="required">*</span></label>                                
                                    <input id="doi" type="text" name="doi" value="<?php echo set_value('doi'); ?>"  />
                                    <?php echo form_error('doi','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="pii">Pii<span class="required">*</span></label>                                
                                    <input id="pii" type="text" name="pii" value="<?php echo set_value('pii'); ?>"  />
                                    <?php echo form_error('pii','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="identifier">Identifier<span class="required">*</span></label>                                
                                    <input id="identifier" type="text" name="identifier" value="<?php echo set_value('identifier'); ?>"  />
                                    <?php echo form_error('identifier','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="citekey">Citekey<span class="required">*</span></label>                                
                                    <input id="citekey" type="text" name="citekey" value="<?php echo set_value('citekey'); ?>"  />
                                    <?php echo form_error('citekey','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_title">Journal_title<span class="required">*</span></label>                                
                                    <input id="journal_title" type="text" name="journal_title" value="<?php echo set_value('journal_title'); ?>"  />
                                    <?php echo form_error('journal_title','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_year">Journal_year<span class="required">*</span></label>                                
                                    <input id="journal_year" type="text" name="journal_year" value="<?php echo set_value('journal_year'); ?>"  />
                                    <?php echo form_error('journal_year','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_volume">Journal_volume<span class="required">*</span></label>                                
                                    <input id="journal_volume" type="text" name="journal_volume" value="<?php echo set_value('journal_volume'); ?>"  />
                                    <?php echo form_error('journal_volume','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_issue">Journal_issue<span class="required">*</span></label>                                
                                    <input id="journal_issue" type="text" name="journal_issue" value="<?php echo set_value('journal_issue'); ?>"  />
                                    <?php echo form_error('journal_issue','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_pages">Journal_pages<span class="required">*</span></label>                                
                                    <input id="journal_pages" type="text" name="journal_pages" value="<?php echo set_value('journal_pages'); ?>"  />
                                    <?php echo form_error('journal_pages','<div>','</div>'); ?>
                                    </p>
                                    
<p>
        <?php echo form_submit( 'submit', 'Submit'); ?>
</p>

<?php echo form_close(); ?>
