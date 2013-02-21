<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xmca_model extends CI_Model {

	private static $static_xmca_ref = null;

	function __construct()
	{
		parent::__construct();
		self::$static_xmca_ref = $this;
		
		$this->xmca = $this->load->database('xmca', TRUE);
		$this->xmca->query('SET SESSION group_concat_max_len = 131072');
		$this->xmca->query('SET character_set_results = "utf8";');
	} 

	function get_recent( $count = 3 )
	{
		$query = 'SELECT y.id, y.name, y.updated_at, y.person_id, p.first, p.last FROM yarns as y, people as p WHERE p.id = y.person_id ORDER BY updated_at DESC LIMIT 0, '.intval($count);
		return $this->xmca->query($query);
	}
	
	function getRecentThreadActivity( $start = 0, $count = 20 ){
		$this->xmca->select("yarns.created_at,
							 yarns.updated_at,
							 CONCAT_WS( ' ', people.first, people.last ) auth_name,
							 yarns.person_id pID,
							 yarns.id yID,
							 yarns.items, 
							 yarns.name");
		$this->xmca->from('yarns');
		$this->xmca->join('people', 'yarns.person_id = people.id', 'left');
		$this->xmca->order_by('yarns.updated_at', 'DESC');
		$this->xmca->limit($count, $start);
		return  $this->xmca->get()->result();
	}
	
	function getTotalThreadActivityResults(){
	
		$query	=	"  SELECT COUNT(pID) count FROM 									" .
					"( SELECT  `yarns`.*, people.id pID, people.first, people.last FROM " .
					" `yarns` LEFT JOIN people ON yarns.person_id = people.id 			" .
					" ORDER BY updated_at desc ) curr_count								";

		return  $this->xmca->query($query)->row()->count;

		//echo '<h1>' . $this->xmca->last_query() . '</h1>';
	}
	
	function getThreadMessages($threadId){

		$this->xmca->select('messages.id');
		$this->xmca->from('messages');
		$this->xmca->where('messages.yarn_id', $threadId);
		$this->xmca->order_by("messages.created_at", "ASC");
		return $this->xmca->get()->result();
		
	}

	function getThread($threadId){
		$this->xmca->select('*');
		$this->xmca->from('yarns');
		$this->xmca->where('id', $threadId);
		return $this->xmca->get()->row();		
	}

	function getMessage($id){	

		$this->xmca->select('people.first, people.last, messages.created_at m_created_at, bodies.message_id, messages.yarn_id, yarns.name, yarns.items, yarns.updated_at, GROUP_CONCAT(bodies.original order by bodies.id asc separator "\n") body');
		$this->xmca->from('bodies');
		$this->xmca->join('messages', 'messages.id = bodies.message_id', 'left');
		$this->xmca->join('yarns', 'messages.yarn_id = yarns.id', 'left');
		$this->xmca->join('people', 'messages.person_id = people.id', 'left');
		$this->xmca->where('messages.id', $id);
		$this->xmca->group_by(array('people.first', 'people.last', 'm_created_at', 'message_id', 'yarn_id', 'name', 'items', 'updated_at'));
		return $this->xmca->get()->row();
		
		//echo '<h1>' . $this->xmca->last_query() . '</h1>';

	}

	function getThreadsTimelineJSON($threadIds = null){
		$this->xmca->select("yarns.created_at start, yarns.name title, yarns.id description");
		$this->xmca->from('yarns');
		$this->xmca->join('messages', 'messages.yarn_id = yarns.id', 'left');
		$this->xmca->where('yarns.created_at IS NOT NULL', null, false);
		$this->xmca->where('yarns.updated_at IS NOT NULL', null, false);
		if(null != $threadIds) $this->xmca->where_in("messages.id", $threadIds);
		$this->xmca->order_by("yarns.created_at", "ASC");
		return  $this->xmca->get()->result();
	}

	public static function staticGetMessage($id){
		if(isset(self::$static_xmca_ref)){
			return self::$static_xmca_ref->getMessage($id);
		}
		return null;
	}

	public static function staticGetTotalThreadActivityResults(){
		if(isset(self::$static_xmca_ref)){
			return self::$static_xmca_ref->getTotalThreadActivityResults();
		}
		return null;
	}

	public static function staticGetThreadMessages($threadId){
		if(isset(self::$static_xmca_ref)){
			return self::$static_xmca_ref->getThreadMessages($threadId);
		}
		return null;
	}

}


/*
STORED FUNCTIONS USED BY THIS MODEL

DELIMITER //
DROP FUNCTION IF EXISTS  getTotalThreadCount;

CREATE FUNCTION getTotalThreadCount(numSeconds INT)
RETURNS INT
BEGIN
	DECLARE lastAccess INT;
	DECLARE threadCount INT;
	
	SET lastAccess = 0 + (SELECT val from private_procedure_key_val WHERE key_name = 'xmca_thread_count_last_access');
	IF (unix_timestamp(now()) - lastAccess > numSeconds) THEN
		BEGIN
			SET threadCount = 0 + (SELECT COUNT(created_at) FROM ( SELECT MAX(messages.created_at) created_at, 
																   CONCAT_WS( ' ',  people.first, people.last ) auth_name,  
																   yarns.items,	 
																   yarns.name	
								   FROM yarns LEFT JOIN messages ON messages.yarn_id = yarns.id 
											  LEFT JOIN people ON messages.person_id = people.id	
								   GROUP BY auth_name, items, name ORDER BY created_at) curr_threads);
											  
			INSERT INTO private_procedure_key_val VALUES ('xmca_thread_count_total', threadCount) ON DUPLICATE KEY UPDATE val = threadCount;
			INSERT INTO private_procedure_key_val VALUES ('xmca_thread_count_last_access', unix_timestamp(now())) ON DUPLICATE KEY UPDATE val = unix_timestamp(now());
		END;
	END IF;
	RETURN 0 + (SELECT val from private_procedure_key_val WHERE key_name = 'xmca_thread_count_total');
END//
DELIMITER ;

*/

/* End of file xmca_model.php */
/* Location: ./application/models/xmca_model.php */
