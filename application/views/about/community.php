<?php $this->load->view('elements/header'); ?>

<div class="article">
	<h2>The Co-LCHC Community</h2>
	<p>This web site is designed to facilitate communication, interaction, and exchange for a world-wide network of professional academics who draw on cultural psychology, cultural-historical theory, activity theory, the philosophy of mind, and other related areas of thought, research, and practice. To that end, this web site offers a set of functions to its members, and members only, to augment our interactions and generate a community of common interest, research, and thought. What are these functions, how does it work, and why is it beneficial to join?</p>
	<h2>Community points and reputation</h2>
	<p>Interactions on Co-LCHC can take many forms: participating in conversations, contributing to symposia, sharing your publications with others, voting and discussing target articles, etc. In each of these areas of participating, your peers can show their appreciation for your contributions by spending their <span class='points-amount'>community points</span> to upvote your contribution. The more your peers appreciate your contributions, and the more your <span class='reputation-amount'>community reputation</span> increases, the <a href='/about/community#privileges'>more privileges you have on the web site</a>. For example, if a peer on Co-LCHC favorably votes on a comment you post in reply to a conversation, you earn community reputation and also community points which you can use, in turn, to appreciate the contributions of your peers.</a>.

	<h2>Community Reputation:<br>Voting, Commenting, and Tagging</h2>
	<p>Many community-related items such as symposia, conversation questions, symposia and their chapters can be voted on, tagged, and of course commented on. Generally speaking, all members of Co-LCHC can perform these functions when they are logged in. However, there are some restrictions based on your community reputation -- for example, you cannot alter the tags for a conversation or symposium until you have reached <span class='reputation-amount'><?= $this->user_reputation_points['can_add_tag_association'] ?></span> community reputation. There several reasons why we feel it is important to establish community reputation thresholds in order to distribute privileges:
		
		<ul>
			<li>Reputation requirements to alter meta data, for example, help prevent abuse of the system.</li>
			<li>Earning reputation through the recognition of your contributions by your peers helps foster a sense of community and responsibility.</li>
			<li>Reputation grants social privileges to direct the goals of the website -- a privilege which should be reserved for community members who emerge as leaders.</li> 
		</ul>
	</p>

	<h2>Tagging</h2>
	<p>Tagging is a function which attributes categories, concepts, or terms to various entities in our community (comments, symposia, etc). Tags, which can be thought of as keywords, are useful in many respects. They are extremely useful in generating a community knowledge-base which aids during searching and retrieval -- if you search for "development" for example, you not only retrieve text items which match for this term, but you also receive items which your peers have determined belongs in the category or concept of "development." Tagging is also useful for finding help on specific topics, saving you time and energy and, more generally, focusing the attention of the community and sustaining longer time periods of interaction.</p>

	<a name='privileges'></a>
	<h2>Community Privileges</h2>
	<p>At what community reputation level are you granted various privileges? Here are the numbers:</p>

	<div class='span-12' style='padding-left: 20px'>
		<div class='span-12 last'>
			<div class='span-2'  style='text-align: right;'><span class='reputation-amount'><?= $this->user_reputation_points['can_post_comment'] ?></span></div>
			<div class='span-10' style='padding-left: 10px;'><b>The member can post a comment.</b></div>
		</div>

		<div class='span-12 last'>
			<div class='span-2'  style='text-align: right;'><span class='reputation-amount'><?= $this->user_reputation_points['can_post_conversation'] ?></span></div>
			<div class='span-10' style='padding-left: 10px;'><b>The member can post a new conversation topic.</b></div>
		</div>

		<div class='span-12 last'>
			<div class='span-2'  style='text-align: right;'><span class='reputation-amount'><?= $this->user_reputation_points['can_post_upvote'] ?></span></div>
			<div class='span-10' style='padding-left: 10px;'><b>The member can upvote their peers' contributions.</b></div>
		</div>

		<div class='span-12 last'>
			<div class='span-2'  style='text-align: right;'><span class='reputation-amount'><?= $this->user_reputation_points['can_post_downvote'] ?></span></div>
			<div class='span-10' style='padding-left: 10px;'><b>The member can downvote their peers' contributions.</b></div>
		</div>

		<div class='span-12 last'>
			<div class='span-2'  style='text-align: right;'><span class='reputation-amount'><?= $this->user_reputation_points['can_add_tag_association'] ?></span></div>
			<div class='span-10' style='padding-left: 10px;'><b>The member can add new tag associations.</b></div>
		</div>

		<div class='span-12 last'>
			<div class='span-2'  style='text-align: right;'><span class='reputation-amount'><?= $this->user_reputation_points['can_delete_tag_association'] ?></span></div>
			<div class='span-10' style='padding-left: 10px;'><b>The member can delete tag associations.</b></div>
		</div>

		<div class='span-12 last'>
			<div class='span-2'  style='text-align: right;'><span class='reputation-amount'><?= $this->user_reputation_points['can_create_tag'] ?></span></div>
			<div class='span-10' style='padding-left: 10px;'><b>The member can create new community tags.</b></div>
		</div>
	</div>

    <br style="clear: both;">
</div>

<?php  $this->load->view('elements/sidebar'); ?>
<?php  $this->load->view('elements/footer'); ?>
