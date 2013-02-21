<div class="box">
<h1 ><a class="delete" href="/admin/pages/add">Add Page</a></h1>
<br>
<?php     echo $this->pagination->create_links() . "<br>"; ?>
<table cellspacing="0" cellpadding="0">
<thead>
   <tr>
     <th>URL</th>
     <th>Title</th>
     <th>Action</th>
   </tr>
</thead>
<tbody>
    
    <?php
    foreach($pages->result() as $p) {
    ?>
    <tr>
         <td><?=$p->uri;?></td>
         <td><?=$p->title;?></td>
         <td>
              <a class="edit" href="/admin/pages/edit/<?=$p->id;?>">edit</a>
              <a class="delete" href="javascript:deletechecked('/admin/pages/delete/<?=$p->id;?>')">delete</a>
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