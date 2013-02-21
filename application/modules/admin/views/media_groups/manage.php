<?php
// $this->load->view('header'); ?>

<div class="box">
     <h1 ><a class="delete" href="/admin/media_groups/add">Add Media Group</a></h1>
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

     	<?php  if( $media_groups->num_rows() > 0 ) {
     	       	   foreach( $media_groups->result() as $media_group ) {
     	?>
     			<tr>
     				<td><?php echo $media_group->id; ?></td>
     				<td><?php echo $media_group->name; ?></td>
     				<td>
     					<a class="edit" href="/admin/media_groups/edit/<?php echo $media_group->id; ?>">edit</a>
     					<a class="delete" href="javascript:deletechecked('/admin/media_groups/delete/<?=$media_group->id;?>')">delete</a>
     					
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
