<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsIntroduction extends XsnsRoot
{
	
	//--------------------------------------------------------------------------
	
	function XsnsIntroduction()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_intro_id', XOBJ_DTYPE_INT);
		$this->initVar('uid_to', XOBJ_DTYPE_INT);
		$this->initVar('uid_from', XOBJ_DTYPE_INT);
		$this->initVar('body', XOBJ_DTYPE_TXTAREA);
		$this->initVar('r_datetime', XOBJ_DTYPE_DATETIME);
		
		$this->doXcode = false;
	}
	
	//--------------------------------------------------------------------------
	
}

class XsnsIntroductionHandler extends XsnsRootHandler
{
	
	//--------------------------------------------------------------------------
	
	function XsnsIntroductionHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsIntroduction";
		$this->table_name = "c_mypage_introduction";
		$this->primary_key = "c_intro_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getOne($uid_from, $uid_to)
	{
		$ret = false;
		$criteria = new CriteriaCompo(new Criteria('i.uid_from', $uid_from));
		$criteria->add(new Criteria('i.uid_to', $uid_to));
		
		$obj_list =& $this->getObjects($criteria);
		if(is_array($obj_list) && count($obj_list)==1){
			$ret =& $obj_list[0];
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsIntroductionHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getObjects($criteria = NULL, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = "SELECT i.* FROM ".
				$this->prefix($this->table_name)." i,".
				$this->db->prefix('users')." u";
		if (!isset($criteria) || !is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= " WHERE i.uid_from=u.uid";
		}
		else{
			if($criteria->renderWhere() != ''){
				$sql .= " ".$criteria->renderWhere(). " AND i.uid_from=u.uid";
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
		$sql = "SELECT i.* FROM ".
				$this->prefix($this->table_name)." i,".
				$this->db->prefix('users')." u";
		if (!isset($criteria) || !is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= " WHERE i.uid_from=u.uid";
		}
		elseif($criteria->renderWhere() != ''){
			$sql .= " ".$criteria->renderWhere(). " AND i.uid_from=u.uid";
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
