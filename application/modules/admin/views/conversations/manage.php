<?php
// $this->load->view('header'); ?>

<div class="box">

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

     	<?php  if( $conversations->num_rows() > 0 ) {
     	       	   foreach( $conversations->result() as $conversation ) {
     	?>
     			<tr>
     				<td><?php echo $conversation->id; ?></td>
     				<td><?php echo $conversation->subject; ?></td>
     				<td>
     					<a class="edit" href="/admin/conversations/edit/<?php echo $conversation->id; ?>">edit</a>
     					<a class="delete" href="javascript:deletechecked('/admin/conversations/delete/<?=$conversation->id;?>')">delete</a>
     					
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
