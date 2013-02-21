<div class="box">

<table cellspacing="0" cellpadding="0">
<thead>
	<tr>
		<th>Instructor</th>
		<th>Subject</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>    
	<?php
	foreach($symposia_chapters->result() as $symposium_chapter) {
	?>
	<tr>
		<td><?=$symposium_chapter->first;?> <?=$symposium_chapter->last;?></td>
		<td><?=$symposium_chapter->subject;?></td>
		<td>
			<a class="edit" href="/admin/symposia/chapter_edit/<?=$symposium_chapter->symposium_chapter_id;?>">edit</a>
			<a class="delete" href="javascript:deletechecked('/admin/symposia/chapter_delete/<?=$symposium_chapter->symposium_chapter_id;?>')">delete</a>
		</td>
	</tr>

	<?php
	}
	?>
    
</tbody>
</table>

</div>
<script type="text/javascript">
function deletechecked(link) {
    var answer = confirm('Delete this symposium chapter and all its comments?');
    if ( answer ){
	    var answer2 = confirm('Are you really sure? All data will be deleted and not recoverable.');
	    if ( answer2 ){
        	window.location = link;
		}
    }
    
    return false;  
}
</script>
