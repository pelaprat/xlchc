<?php $this->load->view('elements/header'); ?>
	<div class="article">
		<h2><?php echo htmlentities($page->title); ?></h2>
	
		<?php echo tabify($page->content); ?>
	
		<form method="post" action="search/results">
			<p>
				<label for="query">Search:</label>
	
				<input type="text" name="query" id="query" maxlength="255" value="<?php echo htmlentities($this->input->post('query')); ?>">
				<input type="submit" value="submit" />
			</p>
		</form>
	</div>
<?php $this->load->view('elements/footer'); ?>
