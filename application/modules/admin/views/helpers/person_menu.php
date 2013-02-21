<select name="<?php echo $select_name; ?>">

<?php

foreach( $person_list->result() as $person ) { ?>
   <option name="<?php echo $option_name; ?>" value='<?php echo $person->id; ?>'
   <?php
	 if( isset($selected) && $person->id == $selected ) {
   	     echo ' selected';
	 }
   ?>
   >
   <?php echo $person->last, ', ', $person->first; ?>
   </option>
<?php } ?>

</select>