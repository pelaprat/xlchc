<?php
// $this->load->view('header'); ?>

<div class="box">
     <h1 ><a class="delete" href="/admin/tags/add">Add Tag</a></h1>
     <br>

     <table cellspacing="0" cellpadding="0">
     <!-- Table -->
     	<thead>
     		<tr>
     			<th>ID</th>
     			<th>Name</th>
			<th>Action</th>
     		</tr>
     	</thead>
     	<tbody>

     	<?php  if( $tags->num_rows() > 0 ) {
     	       	   foreach( $tags->result() as $tag ) {
     	?>
     			<tr>
     				<td><?php echo $tag->id; ?></td>
     				<td><?php echo $tag->name; ?></td>
     				<td>
     					<a class="edit" href="/admin/tags/edit/<?php echo $tag->id; ?>">edit</a>
     					<a class="delete" href="javascript:deletechecked('/admin/tags/delete/<?=$tag->id;?>')">delete</a>
     					
     				</td>
     			</tr>

     	<?php
     		}
     	} ?>


     	</tbody>
     </table>

</div>
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

<?php echo $this->pagination->create_links(); ?>

<?php $this->load->view('footer'); ?>
