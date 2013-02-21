<?php
// $this->load->view('header'); ?>

<div class="box">
					<?php echo $this->pagination->create_links(); ?>
     <h1 ><a class="delete" href="/admin/people/add">Add Person</a></h1>
     <br>
     <table cellspacing="0" cellpadding="0">
     <!-- Table -->
     	<thead>
     		<tr>
     			<th>Last Name</th>
     			<th>First Name</th>
     			<th>Email Address</th>
     			<th>Institution</th>
     			<th>Department</th>
     			<th>Action</th>
     		</tr>
     	</thead>
     	<tbody>


     	<?php  if( $people->num_rows() > 0 ) {
     	       	   foreach( $people->result() as $person ) {
     	?>
     			<tr>
     				<td><?php echo $person->last; ?></td>
     				<td><?php echo $person->first; ?></td>
     				<td><?php echo $person->email; ?></td>
     				<td><?php echo $person->institution; ?></td>
     				<td><?php echo $person->department; ?></td>
     				<td>
     					<a class="edit" href="/admin/people/edit/<?php echo $person->person_id; ?>">edit</a>
     					<a class="delete" href="javascript:deletechecked('/admin/people/delete/<?=$person->person_id;?>')">delete</a>
     					
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
