<?php $this->load->view('elements/header'); ?>
<div class="article">
	<h2><?php echo htmlentities($page->title); ?></h2>

	<?php echo tabify($page->content); ?>
</div>

<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>
