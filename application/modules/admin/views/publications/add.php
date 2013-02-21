<div class="box">

	<?php echo $custom_error; ?>

	<?php echo form_open_multipart(current_url()); ?>

	<fieldset id='form_publications'><legend>Add a Publication</legend>

		<div class="input_field">
			<label for="title">Title<span class="required">*</span></label>
			<input class='bigfield' id="title" type="text" name="title" value="<?php echo set_value('title'); ?>" />
			<?php echo form_error('title','',''); ?>
		</div>

		<div class="input_field">
			<label for="project">File</label>                                
			<input id="userfile" type="file" name="userfile" value="" />
			<?php echo form_error('upload','',''); ?>
		</div>

		<!-- Authors -->
    	<div id='author-template' style='display: none;'>
        	<div class='author-item'>
          		<a id='delete-::FIELD1::'>[ - ]</a>
          		<?php
             		$xx['select_name']  = 'select-::FIELD1::';
	     			$xx['option_name']  = '';
	     			$xx['menu_data']    = $author_menu_data;
					$xx['id_field']		= 'id';

    	     		$this->load->view( 'helpers/generic_menu', $xx );
          		?>
       		</div>
    	</div>

    	<div class='input_field'>
        	<div class="input_field">
           		<label for="title">Authors<span class="required">*</span></label>

           		<div style='margin-left: 105px;'>
              		<div id='authors' class='list'></div>
					<a id='add-author'>[ + ]</a>
				</div>
				<br>
			</div>
		</div>

		<script type='text/javascript'>
	    	register_add_link( 'author', 'authors' );
		</script>

		<div class="input_field">
			<label for="abstract">Abstract</label>
			<br>
			<div class="input_field"><textarea name='abstract' class="textbox" cols="90" rows="6"><?php echo set_value('abstract'); ?></textarea></div>
			</div>

			<div class="input_field">
			<label for="project">Project</label>                                
			<input class='mediumfield' id="project" type="text" name="project" value="<?php echo set_value('project'); ?>" />
			</div>

			<div class="input_field">
			<label for="url">Url</label>
			<input class='bigfield' id="url" type="text" name="url" value="<?php echo set_value('url'); ?>" />
			</div>

			<div class="input_field">
			<label for="doi">DOI</label>                                
			<input class='bigfield' id="doi" type="text" name="doi" value="<?php echo set_value('doi'); ?>" />
			</div>

			<div class="input_field">
			<label for="pii">PII</label>                                
			<input class='bigfield' id="pii" type="text" name="pii" value="<?php echo set_value('pii'); ?>"  />
			</div>

			<div class="input_field">
			<label for="identifier">Identifier</label>                                
			<input class='mediumfield' id="identifier" type="text" name="identifier" value="<?php echo set_value('identifier'); ?>"  />
			</div>

			<div class="input_field">
			<label for="citekey">Citekey</label>                                
			<input class='bigfield' id="citekey" type="text" name="citekey" value="<?php echo set_value('citekey'); ?>"  />
			</div>

			<div class="input_field">
			<label for="journal_title">Journal_Title</label>                                
			<input class='bigfield' id="journal_title" type="text" name="journal_title" value="<?php echo set_value('journal_title'); ?>"  />
			</div>

			<div class="input_field">
			<label for="journal_year">Journal_Year</label>                                
			<input class='smallfield' id="journal_year" type="text" name="journal_year" value="<?php echo set_value('journal_year'); ?>"  />
			</div>

			<div class="input_field">
			<label for="journal_volume">Journal_Volume</label>                                
			<input class='smallfield' id="journal_volume" type="text" name="journal_volume" value="<?php echo set_value('journal_volume'); ?>"  />
			</div>

			<div class="input_field">
			<label for="journal_issue">Journal_Issue</label>                                
			<input class='smallfield' id="journal_issue" type="text" name="journal_issue" value="<?php echo set_value('journal_issue'); ?>"  />
			</div>

			<div class="input_field">
			<label for="journal_pages">Journal_Pages</label>                                
			<input class='mediumfield' id="journal_pages" type="text" name="journal_pages" value="<?php echo set_value('journal_pages'); ?>"  />
			</div>

			<input class="submit" type="submit" value="Submit" />

			<?php echo form_close(); ?>
		</div>
	</fieldset>


