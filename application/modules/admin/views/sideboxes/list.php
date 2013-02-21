<div class="box">
<h1 ><a class="delete" href="/admin/sideboxes/add">Add Sidebox</a></h1>
<br>
<?php     echo $this->pagination->create_links() . "<br>"; ?>
<table cellspacing="0" cellpadding="0">
<thead>
   <tr>
     <th>Title</th>
     <th>Action</th>
   </tr>
</thead>
<tbody>    
    <?php
    foreach($sideboxes->result() as $s) {
    ?>
    <tr>
         <td width='686'><?=$s->title;?></td>
         <td align='right'>
              <a class="edit" href="/admin/sideboxes/edit/<?=$s->id;?>">edit</a>
              <a class="delete" href="javascript:deletechecked('/admin/sideboxes/delete/<?=$s->id;?>')">delete</a>
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