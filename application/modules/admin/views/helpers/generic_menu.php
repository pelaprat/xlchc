<select name="<?php echo $select_name; ?>">

<?php

foreach( $menu_data as $menu_item ) { ?>
   <option name="<?php echo $option_name; ?>" value='<?php echo $menu_item[$id_field]; ?>'
   <?php
	 if( isset($selected) && $menu_item[$id_field] == $selected ) {
   	     echo ' selected';
	 }
   ?>
   >
   <?php echo $menu_item['value']; ?>
   </option>
<?php } ?>

</select>