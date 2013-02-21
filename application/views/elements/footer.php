
				<div class="span-24 last" id="footer">
					<hr>
					<div class="associations span-16">
						<p>
							<a class="lchc" href="home" title="Co-Laboratory of Comparative Human Cognition">Co-Laboratory of Comparative Human Cognition</a>
							<a class="ucsd" href="http://www.ucsd.edu/" title="University of California, San Diego">University of California, San Diego</a>
						</p>
					</div>
					<div class="meta span-8 last">
						<p>
							&copy; <?php echo date('Y'); ?> Co-Laboratory of Comparative Human Cognition
							<br>
							<a href="about"<?php echo ($this->uri->segment(1) === 'about') ? ' class="current"' : '' ; ?>>About</a> |
							<a href="terms"<?php echo ($this->uri->segment(1) === 'terms') ? ' class="current"' : '' ; ?>>Terms &amp; Conditions</a> |
							<a href="sitemap"<?php echo ($this->uri->segment(1) === 'sitemap') ? ' class="current"' : '' ; ?>>Site Map</a> |
							<a href="contact"<?php echo ($this->uri->segment(1) === 'contact') ? ' class="current"' : '' ; ?>>Contact</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
