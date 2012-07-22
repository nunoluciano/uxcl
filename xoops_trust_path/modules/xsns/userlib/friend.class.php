<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsFriend extends XsnsRoot
{
	
	//--------------------------------------------------------------------------
	
	function XsnsFriend()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_friend_id', XOBJ_DTYPE_INT);
		$this->initVar('uid_from', XOBJ_DTYPE_INT);
		$this->initVar('uid_to', XOBJ_DTYPE_INT);
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsFriendHandler extends XsnsRootHandler
{
	
	//--------------------------------------------------------------------------
	
	function XsnsFriendHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsFriend";
		$this->table_name = "c_friend";
		$this->primary_key = "c_friend_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsFriendHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getOne($uid_from, $uid_to)
	{
		$ret = false;
		$criteria = new CriteriaCompo(new Criteria('f.uid_from', $uid_from));
		$criteria->add(new Criteria('f.uid_to', $uid_to));
		
		$obj_list =& $this->getObjects($criteria);
		if(is_array($obj_list) && count($obj_list)==1){
			$ret =& $obj_list[0];
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getObjects($criteria = NULL, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = "SELECT f.* FROM ".$this->prefix($this->table_name)." f,".
				$this->db->prefix('users')." u";
		if (!isset($criteria) || !is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= " WHERE f.uid_to=u.uid";
		}
		else{
			if($criteria->renderWhere() != ''){
				$sql .= " ".$criteria->renderWhere(). " AND f.uid_to=u.uid";
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
		$sql = "SELECT f.* FROM ".
				$this->prefix($this->table_name)." f,".
				$this->db->prefix('users')." u";
		if (!isset($criteria) || !is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= " WHERE f.uid_to=u.uid";
		}
		elseif($criteria->renderWhere() != ''){
			$sql .= " ".$criteria->renderWhere(). " AND f.uid_to=u.uid";
		}
		
		$result = $this->db->query($sql);
		if ($result) {
			return $this->db->getRowsNum($result);
		}
		return 0;
	}
	
	//--------------------------------------------------------------------------
}

//******************************************************************************

?>
