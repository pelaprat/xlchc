<div class="box">
<h1 ><a class="delete" href="/admin/symposia/add">Add Symposium</a></h1>
<br>
<?php echo $this->pagination->create_links() . "<br>"; ?>
<table cellspacing="0" cellpadding="0">
<thead>
	<tr>
		<th>Subject</th>
		<th></th>
		<th></th>
		<th>Action</th>
	</tr>
</thead>
<tbody>    
	<?php
	foreach($symposia->result() as $s) {
	?>
	<tr>
		<td><?=$s->subject;?></td>
		<td><a class="option1" href="/admin/symposia/chapter_add/<?=$s->id;?>">add chapter</a></td>
		<td><a class="option2" href="/admin/symposia/chapter_list/<?=$s->id;?>">edit chapter</a></td>
		<td>
			<a class="edit" href="/admin/symposia/edit/<?=$s->id;?>">edit</a>
			<a class="delete" href="javascript:deletechecked('/admin/symposia/delete/<?=$s->id;?>')">delete</a>
		</td>
	</tr>

	<?php
	}
	?>
    
</tbody>
</table>

<?php
	echo "<br>" . $this->pagination->create_links(); 
?>

</div>
<script type="text/javascript">
function deletechecked(link) {
    var answer = confirm('Delete this symposium, its chapters, and all its comments?');
    if ( answer ){
	    var answer2 = confirm('Are you really sure? All data will be deleted and not recoverable.');
	    if ( answer2 ){
        	window.location = link;
		}
    }
    
    return false;  
}
</script>