<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tabify') )
{
	function tabify($text, $tabs = 6)
	{
		$insert = '';

		for($i = 0; $i < $tabs; $i++)
		{
			$insert .= "\t";
		}

		return (string) str_replace( array("\r\n", "\r", "\n"), "\n".$insert, $text );
	}
}

/* End of file tabify.php */
/* Location: ./application/helpers/tabify.php */
