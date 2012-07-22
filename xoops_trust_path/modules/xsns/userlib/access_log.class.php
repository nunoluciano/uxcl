<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsAccessLog extends XsnsRoot
{
	
	//--------------------------------------------------------------------------
	
	function XsnsAccessLog()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_access_log_id', XOBJ_DTYPE_INT);
		$this->initVar('uid', XOBJ_DTYPE_INT);
		$this->initVar('c_commu_id', XOBJ_DTYPE_INT);
		$this->initVar('r_datetime', XOBJ_DTYPE_DATETIME);
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsAccessLogHandler extends XsnsRootHandler
{
	var $handler = NULL;
	
	//--------------------------------------------------------------------------
	
	function XsnsAccessLogHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsAccessLog";
		$this->table_name = "c_commu_access_log";
		$this->primary_key = "c_access_log_id";
		
		$this->handler = array(
			'community' => XsnsCommunityHandler::getInstance(),
			'user' => XsnsUserHandler::getInstance(),
		);
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsAccessLogHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getList($cid, $uid, $limit, $start)
	{
		$ret = array();
		
		$cid_sql = ($cid > 0)? " AND a.c_commu_id='".intval($cid)."'" : "";
		$uid_sql = ($uid > 0)? " AND a.uid='".intval($uid)."'" : "";
		
		$sql = "SELECT a.* FROM ".
				$this->prefix($this->table_name). " a,".
				$this->prefix('c_commu'). " c".
				" WHERE a.c_commu_id=c.c_commu_id".
				$cid_sql.
				$uid_sql.
				" ORDER BY a.r_datetime DESC";
		
		if($rs = $this->db->query($sql, $limit, $start)){
			while($row = $this->db->fetchArray($rs)){
				$community =& $this->handler['community']->get(intval($row['c_commu_id']));
				$user =& $this->handler['user']->get(intval($row['uid']));
				if(is_object($community)){
					$ret[] = array(
						'member_id' => intval($row['uid']),
						'member_name' => is_object($user) ? $user->getVar('uname') : '-',
						'commu_id' => intval($row['c_commu_id']),
						'commu_name' => $community->getVar('name'),
						'time' => XsnsUtils::getUserTimestamp($row['r_datetime']),
					);
				}
				unset($community, $user);
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getListCount($cid, $uid)
	{
		$cid_sql = ($cid > 0)? " AND a.c_commu_id='".intval($cid)."'" : "";
		$uid_sql = ($uid > 0)? " AND a.uid='".intval($uid)."'" : "";
		
		$sql = "SELECT a.* FROM ".
				$this->prefix($this->table_name). " a,".
				$this->prefix('c_commu'). " c".
				" WHERE a.c_commu_id=c.c_commu_id".
				$cid_sql.
				$uid_sql;
		
		if($rs = $this->db->query($sql)){
			return $this->db->getRowsNum($rs);
		}
		return 0;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

?>
