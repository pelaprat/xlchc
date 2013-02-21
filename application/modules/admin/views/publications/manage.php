<?php $this->load->view('header'); 
?>

<div class="box">
<h1 ><a class="delete" href="/admin/publications/add">Add Publication</a></h1>
<br>

<table cellspacing="0" cellpadding="0">
<thead>
   <tr>
	<th>Year</th>
	<th>Title</th>
	<th>Author</th>
	<th>Journal Title</th>

	<th></th>
   </tr>
</thead>
<tbody>
   <?php  if( count( $publications ) > 0 ) {
   	     foreach( $publications as $publication ) {
	        $data = $publication['data'];
		$auth = $publication['auth'];
   ?>
<tr>
	<td><?php echo $data->journal_year; ?></td>
	<td><?php echo $data->title; ?></td>
	<td>
	<?php
	   foreach( $auth as $author ) {
	      echo $author['last'], ', ', $author['first'], '<br>';
	   }

	?>
	</td>
	<td><?php echo $data->journal_title; ?></td>
	<td>
		<a class="edit" href="/admin/publications/edit/<?php echo $data->publication_id; ?>">edit</a>
		<a class="delete" href="javascript:deletechecked('/admin/publications/delete/<?=$data->publication_id;?>')">delete</a>

	</td>
</tr>

	<?php
		}
	} ?>


	</tbody>
</table>
<script type="text/javascript">
function deletechecked(link)
{
    var answer = confirm('Delete item?')
    if (answer){
        window.location = link;
    }
    
    return false;  
}
</script>
</div>
<?php echo $this->pagination->create_links(); 

           $this->load->view('footer'); 

?>

