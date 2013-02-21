<?php $this->load->view('elements/header'); ?>

	<div class="article">
		<?php echo validation_errors('<p class="error"><strong>Error:</strong> ', '</p>'); ?>
		<h2><?php echo htmlentities($page->title); ?></h2>
	
		<iframe id="google_map" width="300" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=32.8807,-117.240139&amp;sll=32.88045,-117.2403&amp;sspn=0.00177,0.002301&amp;ie=UTF8&amp;z=14&amp;ll=32.880373,-117.240735&amp;output=embed"></iframe>
		<?php echo tabify($page->content); ?>
	
		<form class="standard" method="post" action="contact/form_submission">
			<fieldset>
				<legend>Send Us an Email</legend>
	
				<div class="field">
					<label for="first">First Name:</label>
					<input rel="First Name" type="text" name="first" id="first" value="<?php echo set_value('first'); ?>" />
				</div>
				<div class="field">
					<label for="last">Last Name:</label>
					<input rel="Last Name" type="text" name="last" id="last" value="<?php echo set_value('last'); ?>" />
				</div>
				<div class="field">
					<label for="email">Email:</label>
					<input rel="Email (required)" type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" />
				</div>
				<div class="field">
					<label for="website">Website:</label>
					<input rel="Website" type="text" name="website" id="website" value="<?php echo set_value('website'); ?>" />
				</div>
				<div class="field">
					<label for="message">Message:</label>
					<textarea rel="Message (required)" name="message" id="message"><?php echo set_value('message'); ?></textarea>
				</div>
				<div class="field">
					<label for="captcha">Are you human?:</label>
					<em>Please answer the following question designed to prevent abuse:</em><br>
					<?php $x = rand(1, 10); echo $x; ?> &#43; <?php $y = rand(1, 10); echo $y; ?> &#61;
					<input rel="?" type="text" name="captcha" id="captcha" />
					<input type="hidden" name="answer" id="answer" value="<?php echo $x + $y; ?>">
				</div>
				<div class="controls">
					<input type="submit" value="Send">
				</div>
			</fieldset>
		</form>
	</div>

<?php  $this->load->view('elements/footer'); ?>
