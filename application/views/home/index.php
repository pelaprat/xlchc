<?php $this->load->view('elements/header'); ?>

<div class="article">
	<h2>Welcome to the <span class='colab'>Co-Laboratory</span> of Comparative Human Cognition</h2>

	<p class='front-page-text'>We are a community of interdisciplinary scholars who share an interest in the study of human mind in its cultural and historical contexts. We seek to resolve  methodological problems associated with the analysis of human and theoretical approaches that place culture and activity at the center of attempts to understand human nature. Our participants come from a variety of disciplines, including anthropology, cognitive science, education, linguistics, psychology and sociology.</p>

	<? if( $this->current_user == null ) { ?>
		<h2>Are you new to Co-LCHC?</h2>
		<p class='front-page-text'>Welcome! This web site is designed to <b>facilitate interaction, exchange, and communication</b> between the members of our intellectual community. This web site draws on many contemporary web features to provide a space for sharing and exchange lectures and symposia as well as supporting the flexible, intelligent exchange of ideas. We also maintain repositories of papers, high quality video, images, audio, and other media which we share through the web. Finally, our community is peer-maintained and leverages <b>community knowledge-building</b> through the use of tagging, keywords, focused searching, and peer-reviewed voting.</p>
		<p class='front-page-text'>Are you intrigued? Check out a few of <a href='/conversations'>the conversations that are going on right now</a>, or perhaps listen in on <a href='/symposia'>the symposia we are currently supporting</a>. If you are interested in participating more actively, <a href='/about/community'>find out more about how this web site works</a>. And when you are ready, <a href='/login/signup'>create an account and join us!</a></p>

		<h2>XMCA Users!</h2>
		<p class='front-page-text'>Are you subscribed to XCMA? If so, chances are you already have an account with us. In this case, it might be faster for you to join us by <a href='/login/reset_password'>resetting your password</a>.
	<? } ?>

	<hr>

	<div class='blog-post span-15 last append-bottom'>
		<div class='blog-date span-15 last'>
			<span class='symposium-indicator'>&#187;</span> December 13, 2011: Web site meeting on Thursday (the 15th)
		</div>
		Don't forget: the web development group will be meeting this Thursday. We will be discussing all of the new features of the site as well as how to curate, manage, and develop its contents in a communal, peer-reviewed way.
	</div>

	<div class='blog-post span-15 last append-bottom'>
		<div class='blog-date span-15 last'>
			<span class='symposium-indicator'>&#187;</span> December 12, 2011: Upcoming Symposium
		</div>
		Mike Cole and Martin Packer will be curating a new symposium this Winter which connects Mike seminar in San Diego with Martin's seminar in Bogota, Columbia. <a href='/conversations/detail/20'>There is more information here at this conversation!</a>
	</div>

	<div class='blog-post span-15 last append-bottom'>
		<div class='blog-date span-15 last'>
			<span class='symposium-indicator'>&#187;</span> December 10, 2011: Web Site Infrastructure
		</div>
		We are making progress in the technical development of the site. To aid in the deployment of the development version of this site, however, I have <a href='conversations/detail/19'>made a conversation where we can generally talk</a> about what we wish to see, what we think is working, and so forth.
	</div>


	<div class='blog-post span-15 last'>
		<div class='blog-date span-15 last'>
			<span class='symposium-indicator'>&#187;</span> December 9, 2011: The blog
		</div>
		This is a fake blog post! In the future, community members who have achieved a particular level of reputation will be able to make blog posts like this to contribute to the news of the web site. Someone, for example, could announce a new symposium, or they could ask whether there is interest for a new symposium and then link that to a Conversation which asks the question (and also uses the voting mechanism to gauge this interest).
	</div>

    <br style="clear: both;">
</div>

<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>
