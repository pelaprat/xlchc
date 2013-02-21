<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('readablesize') )
{
	function readablesize($size, $max = null, $system = 'si', $retstring = '%01.2f%s')
	{
		// Pick units
		$systems['si']['prefix'] = array('B', 'K', 'MB', 'GB', 'TB', 'PB');
		$systems['si']['size']   = 1000;
		$systems['bi']['prefix'] = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
		$systems['bi']['size']   = 1024;
		$sys = isset($systems[$system]) ? $systems[$system] : $systems['si'];

		// Max unit to display
		$depth = count($sys['prefix']) - 1;
		if ($max && false !== $d = array_search($max, $sys['prefix']))
		{
			$depth = $d;
		}

		// Loop
		$i = 0;
		while ($size >= $sys['size'] && $i < $depth)
		{
			$size /= $sys['size'];
			$i++;
		}

		return sprintf($retstring, $size, $sys['prefix'][$i]);
	}

}

/* End of file readablesize_helper.php */
/* Location: ./application/helpers/readablesize_helper.php */
