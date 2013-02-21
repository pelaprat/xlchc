<?php     

echo form_open(current_url()); ?>
<?php echo $custom_error; ?>
<?php echo form_hidden('id',$result->id) ?>

                                    <p><label for="title">Title<span class="required">*</span></label>                                
                                    <input id="title" type="text" name="title" value="<?php echo $result->title ?>"  />
                                    <?php echo form_error('title','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="filename">Filename<span class="required">*</span></label>                                
                                    <input id="filename" type="text" name="filename" value="<?php echo $result->filename ?>"  />
                                    <?php echo form_error('filename','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="abstract">Abstract<span class="required">*</span></label>                                
                                    <input id="abstract" type="text" name="abstract" value="<?php echo $result->abstract ?>"  />
                                    <?php echo form_error('abstract','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="project">Project<span class="required">*</span></label>                                
                                    <input id="project" type="text" name="project" value="<?php echo $result->project ?>"  />
                                    <?php echo form_error('project','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="url">Url<span class="required">*</span></label>                                
                                    <input id="url" type="text" name="url" value="<?php echo $result->url ?>"  />
                                    <?php echo form_error('url','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="doi">Doi<span class="required">*</span></label>                                
                                    <input id="doi" type="text" name="doi" value="<?php echo $result->doi ?>"  />
                                    <?php echo form_error('doi','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="pii">Pii<span class="required">*</span></label>                                
                                    <input id="pii" type="text" name="pii" value="<?php echo $result->pii ?>"  />
                                    <?php echo form_error('pii','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="identifier">Identifier<span class="required">*</span></label>                                
                                    <input id="identifier" type="text" name="identifier" value="<?php echo $result->identifier ?>"  />
                                    <?php echo form_error('identifier','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="citekey">Citekey<span class="required">*</span></label>                                
                                    <input id="citekey" type="text" name="citekey" value="<?php echo $result->citekey ?>"  />
                                    <?php echo form_error('citekey','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_title">Journal_title<span class="required">*</span></label>                                
                                    <input id="journal_title" type="text" name="journal_title" value="<?php echo $result->journal_title ?>"  />
                                    <?php echo form_error('journal_title','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_year">Journal_year<span class="required">*</span></label>                                
                                    <input id="journal_year" type="text" name="journal_year" value="<?php echo $result->journal_year ?>"  />
                                    <?php echo form_error('journal_year','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_volume">Journal_volume<span class="required">*</span></label>                                
                                    <input id="journal_volume" type="text" name="journal_volume" value="<?php echo $result->journal_volume ?>"  />
                                    <?php echo form_error('journal_volume','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_issue">Journal_issue<span class="required">*</span></label>                                
                                    <input id="journal_issue" type="text" name="journal_issue" value="<?php echo $result->journal_issue ?>"  />
                                    <?php echo form_error('journal_issue','<div>','</div>'); ?>
                                    </p>
                                    

                                    <p><label for="journal_pages">Journal_pages<span class="required">*</span></label>                                
                                    <input id="journal_pages" type="text" name="journal_pages" value="<?php echo $result->journal_pages ?>"  />
                                    <?php echo form_error('journal_pages','<div>','</div>'); ?>
                                    </p>
                                    
<p>
        <?php echo form_submit( 'submit', 'Submit'); ?>
</p>

<?php echo form_close(); ?>
