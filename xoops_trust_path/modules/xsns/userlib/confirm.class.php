<?php

require_once 'root.class.php';

//******************************************************************************

class XsnsConfirm extends XsnsRoot
{
	
	//--------------------------------------------------------------------------
	
	function XsnsConfirm()
	{
		// $key, $data_type, $default, $required, $size
		$this->initVar('c_commu_confirm_id', XOBJ_DTYPE_INT);
		$this->initVar('c_commu_id', XOBJ_DTYPE_INT);
		$this->initVar('uid_from', XOBJ_DTYPE_INT);
		$this->initVar('uid_to', XOBJ_DTYPE_INT);
		$this->initVar('mode', XOBJ_DTYPE_INT);
		$this->initVar('r_datetime', XOBJ_DTYPE_DATETIME);
		$this->initVar('message', XOBJ_DTYPE_TXTAREA);
		
		$this->doXcode = false;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

class XsnsConfirmHandler extends XsnsRootHandler
{
	
	//--------------------------------------------------------------------------
	
	function XsnsConfirmHandler()
	{
		parent::XsnsRootHandler();
		$this->obj_class = "XsnsConfirm";
		$this->table_name = "c_commu_confirm";
		$this->primary_key = "c_commu_confirm_id";
	}
	
	//--------------------------------------------------------------------------
	
	function &getInstance()
	{
		static $instance = NULL;
		if(is_null($instance)){
			$instance = new XsnsConfirmHandler();
		}
		return $instance;
	}
	
	//--------------------------------------------------------------------------
	
	function &getOne($cid, $uid_from, $uid_to, $mode)
	{
		$ret = false;
		$criteria = new CriteriaCompo(new Criteria('c_commu_id', $cid));
		$criteria->add(new Criteria('uid_from', $uid_from));
		$criteria->add(new Criteria('uid_to', $uid_to));
		$criteria->add(new Criteria('mode', $mode));
		
		$confirm =& $this->getObjects($criteria);
		if(is_array($confirm) && isset($confirm[0]) && is_object($confirm[0])){
			$ret =& $confirm[0];
		}
		return $ret;
	}
	
	//--------------------------------------------------------------------------
	
}

//******************************************************************************

?>
