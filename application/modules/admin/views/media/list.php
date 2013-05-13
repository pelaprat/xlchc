<div class="box">
<?php if( ! isset( $_GET['mode'] ) || $_GET['mode'] != 'browser' ) { ?>
	<h1><a class="delete" href="<?php echo 'admin/media/upload/' . (isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING']: ""); ?>">Upload Media</a></h1>
	<br>
<?php } ?>


<!-- Pagination -->
<table class='media-tools'>
	<tr>
		<td colspan=4>
			<?= $this->pagination->create_links() ?>
		</td>
	</tr>
	<tr>
		<td class='f_groups'>
			By media group:<br>
			<select id='groups' name='groups'>
				<option value=-1 selected>-</option>
			<?php
			foreach ( array_keys($groups) as $group_id ) {
?>
				<option value="<?= $group_id ?>"><?= $groups[$group_id] ?>
<?php		}
			?>
			</select>
			<br><div id='group_track'></div>
		</td>
 		<td class='f_elements'>
			By element it is attached to:<br>
			<select id='elements' name='elements'>
				<option value=-1 selected>-</option>
			<?php
			foreach ( $elements->result() as $element ) {
?>
				<option value="<?= $element->name ?>"><?= $element->name ?>
<?php		}
			?>
	    	</select>
			<br><div id='element_track'></div>
	    </td>

		<td class='f_elements'>
			Search:
			<?= form_open('admin/media/manage', array( 'method' => 'get')); ?>
			<input type='hidden'>
			<input type='hidden'	name='groups'	value='<?= $this->input->get('groups') ?>'>
			<input type='hidden'	name='elements'	value='<?= $this->input->get('elements') ?>'>
			<input type='hidden'	name='media'	value='<?= $this->input->get('media') ?>'>
			<input type='hidden'	name='mode'		value='<?= $this->input->get('mode') ?>'>
			<input type='text'		name='keywords' value="<?= $this->input->get('keywords') ?>" class='mediumfield' >
			<?= form_close() ?>
		</td>


		<?php if( ! isset( $_GET['mode'] ) || $_GET['mode'] != 'browser' ) { ?>
			<td class='m_groups'>
				<b>Modify Selected Data</b>
				<br>
				Set group:
				<select id='modify_groups' name='modify_groups'>
					<option value=-1 selected>-</option>
					<?php
				foreach ( array_keys($groups) as $group_id ) {
				?>
					<option value="<?= $group_id ?>"><?= $groups[$group_id] ?>
<?php			}
				?>
				</select>
			</td>
		<?php } ?>

	</tr>
</table>

<!-- Did we upload a file? -->
<?php
if( isset( $upload_data ) ) {
	$url = "/assets/media/" . $upload_data['file_name'];
?>
	<br>
	<div class='success'>
		<table>
			<tr>
				<td style='width: 60px; text-align: center'>
					<?php $params = array('url' => $url, 'mime' => $upload_data['file_type'], 'class' => 'uploaded_img'); ?>
					<?= display_media( $params ); ?>
				</td>
				<td style='font-size: 14px;'>
					<b>File upload successful:</b><br>
					url: <a href='<?= $url ?>'><?= $url ?></a><br>
					size: <?= $upload_data['file_size'] ?> KB
				</td>
			</tr>
		</table>
	</div>

<?php } ?>

<!-- Print notice if there is no media to display -->
<?php 
if( ! isset($media) ) { ?>
	<h1>No Data</h1>
<?php
	exit;
}
?>

<!-- Display the media items -->
<table class='media-table'>
	<tr>
		<?php if( ! isset( $_GET['mode'] ) || $_GET['mode'] != 'browser' ) { ?>
			<th class='checkbox'>&nbsp;</th>
		<?php } ?>

		<th class='media'>&nbsp;</th>
		<th class='timestamp'>Date</th>
		<th class='elements'>Meta Relations</th>
		<th class='groups'>Media Groups</th>
		<th class='icons'>&nbsp;</th>

		<?php if( ! isset( $_GET['mode'] ) || $_GET['mode'] != 'browser' ) { ?>
			<th class='icons'>&nbsp;</th>
		<?php } ?>
	</tr>

	<?php
		foreach( $media as $media_item ) {
			$url	= "/assets/media/" . $media_item['uuid'];
			$params	= array('url' => $url, 'mime' => $media_item['mime_type'], 'class' => 'uploaded_img' );
		?>
			<tr>
				<?php if( ! isset( $_GET['mode'] ) || $_GET['mode'] != 'browser' ) { ?>
					<td class='checkbox'><input class='media_item_checkbox' type='checkbox' value='<?= $media_item['media_id'] ?>'></td>
				<?php } ?>
				<td class='media'><?= display_media($params) ?></td>
				<td class='timestamp'><?= date('F t, o', strtotime($media_item['media_created_at'])) ?></td>

				<!-- Elements attached to this media item -->
				<td class='elements'>

<?php 				$media_item['generic_title'] = '';	?>

					<!--	For these, set a generic_title value in the case of browser mode
							so that something intelligible is read by the user when they select this media -->
					<?php
						if( count( $media_item['people'] ) > 0 ) {
							foreach( $media_item['people'] as $person ) {
								$media_item['generic_title'] = addslashes($person['first'] . ' ' . $person['last']); ?>
								<span class='person_relation'><?= $person['first'] ?> <?= $person['last'] ?></span><br>
					<?php 	}
						} elseif( count( $media_item['publications'] ) > 0 ) {
							foreach( $media_item['publications'] as $publication ) {
								$media_item['generic_title'] = addslashes($publication['title']);  ?>
								<span class='publication_relation'><?= $publication['title'] ?></span><br>
					<?php	}
						} else { ?>
							<?php $media_item['generic_title'] = $media_item['filename']; ?>
							<span class='other'><?= $media_item['filename'] ?></span>
<?php					} ?>

				</td>

				<!-- Groups attached to this media item -->
				<td class='groups'>
					<?php foreach( $media_item['groups'] as $group ) { ?>
						<?= $groups[$group['media_group_id']] ?><br>
					<?php } ?>
				</td>

				<?php
				$offset_param	=	"offset=$offset";
				$delete_url		=	"admin/media/delete/" . $media_item['media_id'] . 
									(isset($_SERVER['QUERY_STRING']) ? "?" . $_SERVER['QUERY_STRING'] . "&$offset_param": "?$offset_param");
				?>

	        	<td class='images'>
					<?php if( isset( $_GET['mode'] ) && $_GET['mode'] == 'browser' ) { 
							$media_item['media_id'] = str_replace("'", "\'", $media_item['media_id'] ); ?>
						<a class="edit" href="javascript:handle_select_media(<?= $media_item['media_id'] ?>, '<?= $media_item['generic_title'] ?>' );">select</a>
					<?php } else { ?>
						<a class="edit" href="javascript:handle_show_media('<?= $url ?>');">get url</a>
					<?php } ?>
				</td>

				<?php if( ! isset( $_GET['mode'] ) || $_GET['mode'] != 'browser' ) { ?>
					<td class='images'>
						<a class="delete" href="javascript:delete_checked('<?= $delete_url ?>');">delete</a>
					</td>
				<?php } ?>
			</tr>
	<?php } ?>
</table>

</div>


<script type="text/javascript">

	selected_media		= [];
	selected_groups		= [];
	selected_elements	= [];
	selected_keywords	= [];
	set_to_group		= '';

	group_labels		= [];
	global_params		= {};

	$(document).ready( function() {

		// Build the group lables
		$('#groups option').each( function() {
			if( $(this).val() > 0 ) {
				group_labels[$(this).val()] = $(this).html();
			}
		});

		// Get the passed in params
		global_params = get_vars();

		// Get the selected media built up
		if( global_params['media'] ) {
			media = global_params['media'].split(',');
			$('input.media_item_checkbox').each( function() {
				if( jQuery.inArray( $(this).val(), media ) >= 0 )  {
					selected_media.push( $(this).val() );
					$(this).attr("checked", true );
				}
			});
		}

		// Remove the action param
		delete global_params['action'];

		// Establish filter and modify callbacks
		establish_filter( 'group' );
		establish_filter( 'element' );

		establish_modify( 'group' );

		load_vars( 'keyword' );

		// Update the pagination links
		$("ul.paginator a").each( function() {
			$(this).attr( "href", this + get_current_param_string() );
		});
	});

	function establish_modify( meta ) {

		$("#modify_" + meta + "s").change( function( ) {
			var item = $(this).val();
				item = item.trim();

			if( "-" == item ) return;
			set_to_group = item;

			handle_meta_refresh( 'media' );
		});
	}

	function load_vars( meta ) {
		// First load what was passed in.
		var meta_params = global_params[meta + 's'];

		if( meta_params ) {
			meta_params.split(',').map( function( v ) {
				if( meta === 'group' ) {
					selected_groups.push( v );
				} else if( meta === 'element' ) {
					selected_elements.push( v );
				} else if( meta === 'keyword' ) {
					selected_keywords.push( v );
				}

				handle_meta_add( meta, v );
			});
		}
	}

	function establish_filter( meta ) {

		// Load existing filters first
		load_vars( meta );

		// Now set up the callback.
		$("#" + meta + "s").change( function( obj ) {
			var item = unescape($("#" + meta + "s option:selected").val());
				item = item.trim();

			if( "-" == item ) return;

			if( meta === 'element' ) {
				handle_element_selection( item );
			} else if( meta === 'group' ) {
				handle_group_selection( item );	
			}
		});
	}

	function handle_element_selection( element ) {
		if( -1 == $.inArray( element, selected_elements )) {
			selected_elements.push(element);
			handle_meta_refresh( 'element' );
		}
	}

	function handle_group_selection( group ) {
		if( -1 == $.inArray( group, selected_groups )) {
			selected_groups.push(group);
			handle_meta_refresh( 'group' );
		}
	}

	function handle_select_media( url, name ) {
		if( null == url || "" == url ) return;

		window.top.popup_callback(url, name);
		return;
	}

	function handle_show_media( url ) {
		if( null == url || "" == url ) return;

		url = "http://" + window.location.hostname + url;

		var img_url = "";
		if( url.match(/png|jpg|jpeg|gif/i) ) {
			img_url = url;

		} else {
			var type = url.split('.');
			type = type[type.length - 1];

			img_url = "assets/modules/admin/images/icon_" + type + "." + ("doc" == type ? "gif":"png");
		}

		var html = "<img src='" + img_url + "'><br><input size='90' type='text' value='" + url + "'>";
			html = "<table border='1' width='100%' height='100%'><tr><td valign='bottom'><center>" + html + "</center></td></tr></table>";

		Shadowbox.open({
			player:		'html',
			title:		'Media File',
			content:	html,
			height:		800,
			width:		800
		});
	}

	function handle_meta_add( meta, value ){

		parent = $("#" + meta + "_track");
		if(null == parent) return;

		if( meta + 's' === 'groups' ) {
			value   = group_labels[value];
		}

		var div = $("<div class='flag' id='" + value + "'><span class='x'>X</span> " + value + "</div>");
		parent.append(div);

		div.click( function( ) {
			if( meta === 'group' ) {
				selected_groups.splice(this.id - 1, 1);
			} else if( meta === 'element' ) {
				selected_elements.splice(this.id - 1, 1);				
			}

			handle_meta_refresh( meta );
		});
	}


	function handle_meta_refresh( param_name ) {
		document.location = window.location.pathname + get_current_param_string();
	}

	function get_current_param_string( ) {

		// Check the right items if params in
		selected_media = [];
		$('input.media_item_checkbox').each( function() {
			if($(this).attr( "checked" ) == true) {
				selected_media.push( $(this).val() );
			}
		});

		param_string =  '?';
		param_string += '&groups='		+ selected_groups.join(',');
		param_string += '&keywords='	+ selected_keywords.join(',');
		param_string += '&elements='	+ selected_elements.join(',');
		param_string += '&media='		+ selected_media.join(',');

		if( set_to_group != '' ) {
			param_string += '&set_to_group=' + set_to_group;
		}

		// Are we in browser mode mode?
		if( global_params['mode'] == 'browser' ) {
			param_string += '&mode=browser';
		}

		return param_string;
	}

	function delete_checked(link) {
		var answer = confirm('Delete item?')
		if (answer){
			window.location = link;
		}

		return false;  
	}

	function get_vars( ) {
	    var vars = {}, hash;
		if( window.location.href.indexOf('?') >= 0 ) {
	    	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	    	for( var i = 0; i < hashes.length; i++ ) {
	        	hash = hashes[i].split('=');
				if( hash[0] != '' ) {
//	        		vars.push(hash[0]);
	        		vars[hash[0]] = hash[1];
				}
	    	}
		}
	    return vars;
	}

</script>