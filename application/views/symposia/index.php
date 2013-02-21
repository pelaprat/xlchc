<?php $this->load->view('elements/header'); ?>

<div class="article community_index symposium">

	<h2><?php echo htmlentities($page->title); ?></h2>

	<p class='home'>Co-LCHC Symposia are video and comment based interactions on topical courses. They are intended to foster long-term discussion for a focused group of interlocutors interacting through multimedia.</p>

	<?php

	foreach( $symposia->result() as $symposium ) {

		$data['data'] = $symposium;
		if( isset( $tags[$symposium->symposium_id] )) {
			$data['tags'] = $tags[$symposium->symposium_id];
		} else {
			$data['tags'] = array();
		}

		$data['element_s']			= 'symposium';
		$data['element_id']			= $symposium->symposium_id;
		$data['comments_n']			= $symposium->comments_symposia_n;
		$data['element_created_at']	= $symposium->created_at;
		$data['url']				= 'symposia/detail';

		$this->load->view( 'elements/community/box_element', $data );

	?>
	<?php } ?>

	<br style="clear: both;">
</div>

<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>
