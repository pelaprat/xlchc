<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<title><?php echo $page->meta_title; ?></title>

		<base href="<?php echo $this->config->item('base_url'); ?>">

		<meta http-equiv="Content-Type" content="<?php echo htmlentities($page->meta_content_type); ?>">
		<meta name="language" content="<?php echo htmlentities($page->meta_language); ?>">
		<meta name="description" content="<?php echo htmlentities($page->meta_description); ?>">
		<meta name="keywords" content="<?php echo htmlentities($page->meta_keywords); ?>">

		<!-- Font Kits: -->
		<link rel="stylesheet" href="assets/fonts/museo300/stylesheet.css" type="text/css" media="screen, projection">

		<!-- Blueprint CSS Framework 1.0: -->
		<link rel="stylesheet" href="assets/styles/blueprint/screen.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/blueprint/print.css" type="text/css" media="print">
		<link rel="stylesheet" href="assets/styles/blueprint/global.css" type="text/css" media="screen, projection">
		<!--[if lt IE 8]><link rel="stylesheet" href="styles/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->

		<!-- Co-LCHC CSS Framework 1.0 -->
		<link rel="stylesheet" href="assets/styles/lchc/blog.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/lchc/community.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/lchc/contact.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/lchc/home.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/lchc/lchc.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/lchc/login.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/lchc/meta.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/lchc/people.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/lchc/publications.css" type="text/css" media="screen, projection">
		<link rel="stylesheet" href="assets/styles/lchc/search.css" type="text/css" media="screen, projection">

		<!-- Styles:
		<?php if( isset($page->styles) && count($page->styles) ){ foreach($page->styles as $style){ ?>
			<link rel="stylesheet" href="<?php echo $style->href; ?>" type="text/css" media="<?php echo ( empty($style->media) ) ? 'screen, projection' : $style->media ; ?>">
		<?php } } ?>
		-->

		<!-- Co-LCHC Javascripts -->
		<script type="text/javascript" src="/assets/scripts/add-generic.js"></script>
		<script type="text/javascript" src="/assets/scripts/meta-add-generic.js"></script>
		<script type="text/javascript" src="/assets/scripts/response-text.js"></script>

		<!-- jQuery 1.4.2 and jQuery UI 1.8.1: -->
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"></script>
		<!-- <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css" type="text/css" media="screen, projection"> -->

		<!-- Scripts: -->
		<script type="text/javascript" src="assets/scripts/global.js"></script>
		<?php if( isset($page->scripts) && count($page->scripts) ) {
			foreach($page->scripts as $script) { ?>
				<script type="text/javascript" src="<?php echo $script->href; ?>"></script>
			<?php } 
		} ?>

        <!-- Shadowbox -->
        <link rel="stylesheet" href="assets/shadowbox-3.0.3/shadowbox.css" type="text/css" />        
        <script type="text/javascript" src="assets/shadowbox-3.0.3/shadowbox.js"></script>
        <script type="text/javascript">
            Shadowbox.init();
        </script>

		<!-- Google Analytics: -->
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-21644156-1']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</head>

    <body>
		<div class="container">
			<div class="span-11" id="header">
				<h1><a href="home"><span class="split">the <span class='colab'>co-laboratory</span> of </span>Comparative Human Cognition</a></h1>
			</div>

			<?php if( $this->current_user == null ) { ?>

			<?php } else { ?>
				<div class='span-4 prepend-top'>
					<span class='toolbar-button'><a href='/login/logout'>Logout</a>
					<span class='toolbar-button'><a href='/people/detail/<?= $this->current_user->id ?>'>Set Preferences</a>
				</div>
			<?php } ?>

			<div class="span-24 last" id="navigation">
				<div class="span-16 menu">
					<ul>
                    	<?php
							foreach( $this->config->item('navigation') as $text => $href ) {
								if( is_array( $href )) { ?>
									<li><a href="<?= $href[0]; ?>"<?php echo ($this->uri->segment(1) === $href[0]) ? ' class="current"' : '' ; ?>><?= $text; ?></a>
										<ul>

											<?php
												foreach( $href[1] as $a => $b ) { ?>
													<li><a href="<?= $b; ?>"<?php echo ($this->uri->segment(1) === $b) ? ' class="current"' : '' ; ?>><?= $a; ?></a></li>
												<?php } ?>
										</ul>
									</li>
								<?php } else { ?>
									<li><a href="<?php echo $href; ?>"<?php echo ($this->uri->segment(1) === $href) ? ' class="current"' : '' ; ?>><?php echo $text; ?></a></li>
								<?php } ?>
							<?php 
							} 
						?>
					</ul>
				</div>

				<div class="span-8 search last">
					<form method="post" action="search/results">
						<p>
							<label for="query">Search:</label>

							<input type="text" name="query" id="query" maxlength="255" value="<?php echo htmlentities($this->input->post('query')); ?>">
							<input type="image" src="assets/images/search.png" value="Go">
						</p>
					</form>
				</div>
			</div>

			<div class="span-24 last" id="body">

				<?php if(	(	isset( $page->sideboxes  ) && count( $page->sideboxes	) > 0	)   ||
							(	isset( $o_page_sideboxes ) && $o_page_sideboxes == true	)		) {  ?>
					<div class="span-16 content">
				<?php } else { ?>
					<div class="span-24 content">
				<?php } ?>

