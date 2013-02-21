<div class="box">
<h1 ><a class="delete" href="/admin/slides/add">Add Slide</a></h1>
<br>
<?php     echo $this->pagination->create_links() . "<br>"; ?>
<table cellspacing="0" cellpadding="0">
<thead>
   <tr>
     <th>Caption</th>
     <th>Action</th>
   </tr>
</thead>
<tbody>    
    <?php
    foreach($slides->result() as $s) {
    ?>
    <tr>
         <td width='686'><?=$s->caption;?></td>
         <td align='right'>
              <a class="edit" href="/admin/slides/edit/<?=$s->id;?>">edit</a>
              <a class="delete" href="javascript:deletechecked('/admin/slides/delete/<?=$s->id;?>')">delete</a>
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