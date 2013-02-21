<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['navigation'] = array(
	'Conversations'	=>	'conversations',
	'Symposia'		=>	'symposia',
	'Research'		=>	'research',
	'Media'			=>	array(	'/publications',
							array(	'XLCHC Archives'				=> '/publications/archives',
									'Mind, Culture, and Actvivity'	=> '/publications/mca' )),
	'XMCA'			=>	array(	'/xmca',
							array(	'Mailing List'			=> 'http://xmca.ucsd.edu',
									'Subscribe'				=> '/xmca/subscribe' ))
);

/* End of file navigation.php */
/* Location: ./application/config/navigation.php */
