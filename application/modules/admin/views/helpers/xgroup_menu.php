<select name="<?php echo $select_name; ?>">

<?php

foreach( $xgroups_list->result() as $xgroup ) { ?>
   <option name="<?php echo $option_name; ?>" value='<?php echo $xgroup->id; ?>'
   <?php
	 if( isset($selected) && $xgroup->id == $selected ) {
   	     echo ' selected';
	 }
   ?>
   >
   <?php echo $xgroup->name; ?>
   </option>
<?php } ?>

</select>