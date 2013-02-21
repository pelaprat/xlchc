<?php $this->load->view('elements/header'); ?>

<div class="article">
	<h2><?php echo htmlentities($page->title); ?></h2>

	<?php 
		foreach( $publications as $item ) {
			$authors_array = $authors[$item->publication_id];
			$this->load->view('helpers/publication', array( 'item' => $item, 'authors' => $authors_array ));
	?>
	 <br>
	<?php
		}
	?>
</div>

<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>
