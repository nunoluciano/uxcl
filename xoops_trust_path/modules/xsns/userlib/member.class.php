<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsMember extends XsnsRoot
{
	var $handler = NULL;
	
	//--------------------------------------------------------------------------
	
	function XsnsMember()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_commu_member_id', XOBJ_DTYPE_INT);
		$this->initVar('uid', XOBJ_DTYPE_INT);
		$this->initVar('c_commu_id', XOBJ_DTYPE_INT);
		$this->initVar('r_datetime', XOBJ_DTYPE_DATETIME);
		
		$this->handler = array(
			'user' => XsnsUserHandler::getInstance(),
		);
	}
	
	//--------------------------------------------------------------------------
	
	function &getInfo()
	{
		$ret = NULL;
		$user =& $this->handler['user']->get($this->getVar('uid'));
		if(!is_object($user)){
			return $ret;
		}
		$ret =& $user->getInfo();
		$ret['time'] = $this->getVar('r_datetime');
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsMemberHandler extends XsnsRootHandler
{
	
	//--------------------------------------------------------------------------
	
	function XsnsMemberHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsMember";
		$this->table_name = "c_commu_member";
		$this->primary_key = "c_commu_member_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsMemberHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getOne($cid, $uid)
	{
		$ret = false;
		$criteria = new CriteriaCompo(new Criteria('cm.c_commu_id', $cid));
		$criteria->add(new Criteria('cm.uid', $uid));
		$users =& $this->getObjects($criteria);
		if(is_array($users) && isset($users[0]) && is_object($users[0])){
			$ret =& $users[0];
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getObjects($criteria = NULL, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = "SELECT cm.* FROM ".
				$this->prefix($this->table_name)." cm,".
				$this->db->prefix('users')." u,".
				$this->prefix('c_commu')." c";
		if (!isset($criteria) || !is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= " WHERE cm.uid=u.uid AND cm.c_commu_id=c.c_commu_id";
		}
		else{
			if($criteria->renderWhere() != ''){
				$sql .= " ".$criteria->renderWhere(). " AND cm.uid=u.uid AND cm.c_commu_id=c.c_commu_id";
			}
			if ($criteria->getSort() != '') {
				$sql .= " ORDER BY ".$criteria->getSort()." ".$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($row = $this->db->fetchArray($result)) {
			$obj = new $this->obj_class();
			$obj->assignVars($row);
			if (!$id_as_key) {
				$ret[] = $obj;
			}
			else {
				$ret[$row[$this->primary_key]] = $obj;
			}
			unset($obj);
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getCount($criteria = NULL)
	{
		$sql = "SELECT COUNT(*) FROM ".
				$this->prefix($this->table_name)." cm,".
				$this->db->prefix('users')." u,".
				$this->prefix('c_commu')." c";
		if (!isset($criteria) || !is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= " WHERE cm.uid=u.uid AND cm.c_commu_id=c.c_commu_id";
		}
		elseif($criteria->renderWhere() != ''){
			$sql .= " ".$criteria->renderWhere(). " AND cm.uid=u.uid AND cm.c_commu_id=c.c_commu_id";
		}
		
		$result = $this->db->query($sql);
		if ($result) {
			$row = $this->db->fetchRow($result);
			return $row[0];
		}
		return 0;
	}
	
	//--------------------------------------------------------------------------
	
	function getUserInfo($cid, $uid)
	{
		$c_member =& $this->getOne($cid, $uid);
		if(is_object($c_member)){
			return $c_member->getInfo();
		}
		else{
			// removed user's info
			$ret = array(
				'uid' => 0,
				'name' => "",
				'page_url' => "",
				'avatar_url' => "",
				'avatar_width' => 0,
				'avatar_height' => 0,
				'last_login' => "",
			);
			return $ret;
		}
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

?>
