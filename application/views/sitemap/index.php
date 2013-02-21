<?php $this->load->view('elements/header'); ?>
	<div class="article">
		<h2><?php echo htmlentities($page->title); ?></h2>
		<?php echo tabify($page->content); ?>

		<ul>
		<?php foreach( $this->config->item('navigation') as $text => $href ){ ?>
			<li><a href="<?php echo $href; ?>"><?php echo $text; ?></a></li>
		<?php } ?>
			<li><a href="search">Search</a></li>
			<li><a href="terms">Terms</a></li>
			<li><a href="sitemap">Site Map</a></li>
			<li><a href="contact">Contact</a></li>
		</ul>
	</div>
<?php $this->load->view('elements/footer'); ?>
