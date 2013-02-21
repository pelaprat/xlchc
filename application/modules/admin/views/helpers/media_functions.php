<?php

/*
	prepareImageHTML:	  
*/

function nbsp($num = 0){
	$ret = "";
	for($i = 0; $i < $num; ++$i) $ret .= "&nbsp;";
	return $ret;
}
