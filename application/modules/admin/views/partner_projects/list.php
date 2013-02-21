<div class="box">
<h1 ><a class="delete" href="/admin/partner_projects/add">Add Partner Project</a></h1>
<br>
<?php     echo $this->pagination->create_links() . "<br>"; ?>
<table cellspacing="0" cellpadding="0">
<thead>
   <tr>
     <th>Name</th>
     <th>Address</th>
     <th>Country</th>
     <th>Action</th>
   </tr>
</thead>
<tbody>
    
    <?php
    foreach($projects->result() as $p) {
    ?>
    <tr>
         <td><?=$p->name;?></td>
         <td><?=$p->address;?></td>
         <td><?=$p->country;?></td>
         <td>
              <a class="edit" href="/admin/partner_projects/edit/<?=$p->id;?>">edit</a>
              <a class="delete" href="javascript:deletechecked('/admin/partner_projects/delete/<?=$p->id;?>')">delete</a>
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
function deletechecked(link)
{
    var answer = confirm('Delete item?')
    if (answer){
        window.location = link;
    }
    
    return false;  
}
</script>