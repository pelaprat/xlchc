<?php
// $this->load->view('header'); ?>

<div class="box">
     <h1 ><a class="delete" href="/admin/xgroups/add">Add Xgroup</a></h1>
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

     	<?php  if( $xgroups->num_rows() > 0 ) {
     	       	   foreach( $xgroups->result() as $xgroup ) {
     	?>
     			<tr>
     				<td><?php echo $xgroup->id; ?></td>
     				<td><?php echo $xgroup->name; ?></td>
     				<td>
     					<a class="edit" href="/admin/xgroups/edit/<?php echo $xgroup->id; ?>">edit</a>
     					<a class="delete" href="javascript:deletechecked('/admin/xgroups/delete/<?=$xgroup->id;?>')">delete</a>
     					
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
