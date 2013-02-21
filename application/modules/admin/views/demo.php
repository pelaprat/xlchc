<?php $this->load->view('header'); ?>
					<div class="box">
						<h2>Dashboard</h2>

						<p>Lorem ipsum dolor sit amet, <code>this is the test of code within paragraph</code> consectetuer adipiscing elit. Dapibus velit. Nunc id purus. Proin lacus. Pellentesque mollis risus. Donec pulvinar ut, lobortis elit. Ut pretium. Vestibulum tempus. Pellentesque habitant morbi tristique senectus et metus feugiat ultrices ut, ligula. Sed sit amet dui. Morbi accumsan sit amet, ante. Sed ultricies dolor massa imperdiet id, adipiscing mauris. Nam tempor scelerisque,</p>

						<table cellspacing="0" cellpadding="0"><!-- Table -->
							<thead>
								<tr>
									<th>Title</th>
									<th>Author</th>
									<th>Description</th>
									<th>Views</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Lorem Ipsum</td>
									<td>Username</td>
									<td>Lorem ipsum dolor sit amet,</td>
									<td>13</td>
									<td>true</td>
									<td>
										<a class="edit" href="#">edit</a>
										<a class="delete" href="#">delete</a>
									</td>
								</tr>
								<tr class="alt">
									<td>Lorem Ipsum</td>
									<td>Username</td>
									<td>Lorem ipsum dolor sit amet,</td>
									<td>13</td>
									<td>true</td>
									<td>
										<a class="edit" href="#">edit</a>
										<a class="delete" href="#">delete</a>
									</td>
								</tr>
								<tr>
									<td>Lorem Ipsum</td>
									<td>Username</td>
									<td>Lorem ipsum dolor sit amet,</td>
									<td>13</td>
									<td>true</td>
									<td>
										<a class="edit" href="#">edit</a>
										<a class="delete" href="#">delete</a>
									</td>
								</tr>
								<tr class="alt">
									<td>Lorem Ipsum</td>
									<td>Username</td>
									<td>Lorem ipsum dolor sit amet,</td>
									<td>13</td>
									<td>true</td>
									<td>
										<a class="edit" href="#">edit</a>
										<a class="delete" href="#">delete</a>
									</td>
								</tr>
								<tr>
									<td>Lorem Ipsum</td>
									<td>Username</td>
									<td>Lorem ipsum dolor sit amet,</td>
									<td>13</td>
									<td>true</td>
									<td>
										<a class="edit" href="#">edit</a>
										<a class="delete" href="#">delete</a>
									</td>
								</tr>
							</tbody>
						</table>

						<pre>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Dapibus velit. Nunc id purus. Proin lacus. Pellentesque mollis risus.</pre>

						<blockquote><p>Lorem ipsum dolor sit amet, this is the test of code within paragraph consectetuer adipiscing elit. Dapibus velit. Nunc id purus. Proin lacus. Pellentesque mollis risus. Donec pulvinar ut, lobortis elit. Ut pretium. Vestibulum tempus. Pellentesque habitant morbi tristique senectus et metus feugiat ultrices ut, ligula. Sed sit amet dui. Morbi accumsan sit amet, ante. Sed ultricies dolor massa imperdiet id, adipiscing mauris. Nam tempor scelerisque,</p></blockquote>
					</div>

					<div class="box">
						<form method="post" action="#">
							<fieldset><legend>Lorem Ipsum dolor sit</legend>
								<div class="input_field">
									<label for="a">Small Field</label>
									<input class="smallfield" name="a" id="a" type="text" value="" />
									<span class="field_desc">Field description</span>
								</div>

								<div class="input_field">
									<label for="b">Medium Field</label>
									<input class="mediumfield" name="b" id="b" type="text" value="" /> <span class="validate_success">Validation successful!</span>
								</div>

								<div class="input_field">
									<label for="c">Medium Field</label>
									<input class="mediumfield" name="c" id="c" type="text" value="" /> <span class="validate_error">Validation failed!</span>
								</div>

								<div class="input_field">
									<label for="d">Big Field</label>
									<input class="bigfield" name="d" id="d" type="text" value="" />
								</div>

								<div class="input_field">
									<textarea class="textbox" cols="90" rows="6"></textarea>
								</div>

								<input class="submit" type="submit" value="Submit" />
								<a href="#" class="button">Button Test</a>
							</fieldset>
						</form>
					</div>

					<div class="box">
						<div class="success"><span>Success</span><p>This is a success...</p></div>
						<div class="error"><span>Error</span><p>This is an error...</p></div>
						<div class="notice"><span>Notice</span><p>This is a notice...</p></div>
					</div>

					<div class="box">
						<ul class="paginator">
							<li><a href="#">&laquo;</a></li>
							<li class="current"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li><a href="#">&raquo;</a></li>
						</ul>
					</div>
<?php $this->load->view('footer'); ?>
