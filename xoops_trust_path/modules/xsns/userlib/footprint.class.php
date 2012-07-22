<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsFootprint extends XsnsRoot
{
	
	//--------------------------------------------------------------------------
	
	function XsnsFootprint()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_footprint_id', XOBJ_DTYPE_INT);
		$this->initVar('uid_to', XOBJ_DTYPE_INT);
		$this->initVar('uid_from', XOBJ_DTYPE_INT);
		$this->initVar('r_datetime', XOBJ_DTYPE_DATETIME);
		$this->initVar('r_date', XOBJ_DTYPE_DATE);
	}
	
	//--------------------------------------------------------------------------
	
}

class XsnsFootprintHandler extends XsnsRootHandler
{
	
	//--------------------------------------------------------------------------
	
	function XsnsFootprintHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsFootprint";
		$this->table_name = "c_mypage_footprint";
		$this->primary_key = "c_footprint_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsFootprintHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function add($uid_to, $uid_from)
	{
		if($uid_to == $uid_from){
			return false;
		}
		$wait = 3600;	// update interval [sec.]
		
		$criteria = new CriteriaCompo(new Criteria('uid_to', $uid_to));
		$criteria->add(new Criteria('uid_from', $uid_from));
		$criteria->add(new Criteria('r_datetime', date('Y-m-d H:i:s', time()-$wait), '>'));
		$obj_list =& $this->getObjects($criteria);
		if(is_array($obj_list) && count($obj_list)>0){
			return false;
		}
		
		$obj =& $this->create();
		$obj->setVars(array(
			'uid_to' => $uid_to,
			'uid_from' => $uid_from,
			'r_datetime' => date('Y-m-d H:i:s'),
			'r_date' => date('Y-m-d'),
		));
		return $this->insert($obj, true);	// queryF
	}
	
	//--------------------------------------------------------------------------
	
	function &getListForUser($uid_to, $limit=0, $start=0)
	{
		$ret = array();
		
		$sql = "SELECT uid_from,MAX(r_datetime) as max_r_datetime".
				" FROM ".$this->prefix('c_mypage_footprint').
				" WHERE uid_to='".intval($uid_to)."'".
				" GROUP BY uid_from,r_date".
				" ORDER BY max_r_datetime DESC";
		if($limit > 0){
			if($start > 0){
				$sql.= " LIMIT ".$start.",".$limit;
			}
			else{
				$sql.= " LIMIT ".$limit;
			}
		}
		
		if($rs = $this->db->query($sql)){
			while($row = $this->db->fetchArray($rs)){
				$ret[] = array(
					'uid_from' => $row['uid_from'],
					'time' => XsnsUtils::getUserTimestamp($row['max_r_datetime']),
				);
			}
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
	function getCountForUser($uid_to)
	{
		return $this->getCount(new Criteria('uid_to', $uid_to));
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

?>
