<?php $this->load->view('elements/header'); ?>

	<div class="article">
		<h2><?php echo $page->title; ?></h2>
<?php if( !empty($people->image) ){ ?>
		<img class="photo" src="images/people/<?php echo $people->image; ?>" alt="A photograph of <?php echo $people->first, ' ', $people->last; ?>.">
<?php } ?>
		<ul>
<?php if( !empty($people->email) ){ ?>
			<li>
<strong>Email:</strong>
<a href="mailto:<?php echo $people->email; ?>"><?php echo $people->email; ?></a>
			</li>
<?php } ?>
<?php if( !empty($people->website) ){ ?>
			<li>
<strong>Website:</strong>
<a href="<?php echo $people->website; ?>"><?php echo $people->website; ?></a>
			</li>
<?php } ?>
<?php if( !empty($people->institution) ){ ?>
			<li>
<strong>Institutional Affiliation:</strong>
<?php echo $people->institution; ?>
			</li>
<?php } ?>
<?php if( !empty($people->department) ){ ?>
			<li>
<strong>Departmental Affiliation:</strong>
<?php echo $people->department; ?>
	</li>
<?php } ?>
</ul>

<?php if( !empty($people->bio) ){ ?>

<div id="bio">
	<h3>About</h3>
	<?php echo tabify($people->bio, 7); ?>

</div>
<?php } ?>

<p>

<?php if( !empty($people->research) ){ ?>

<div id="research">
	<h3>Research</h3>
	<?php echo tabify($people->research, 7); ?>

</div>
<?php } ?>

<p>

<div id="publications">
	<h3>Publications</h3>

<?php if($publications->num_rows() <= 0 ) { ?> 
	<p>There are currently no publications in our archives associated with <?php echo $people->first; ?> <?php echo $people->last; ?>.</p>
<?php 
} else {
	foreach( $publications->result() as $publication ) {
		$this->load->view('helpers/publication', array( 'item' => $publication, 'authors' => $authors[$publication->publication_id] ));
?>

<?php
      }
}
?>

	</div>
</div>

<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>

