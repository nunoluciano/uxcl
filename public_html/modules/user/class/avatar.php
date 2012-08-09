<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class UserAvatarObject extends XoopsSimpleObject
{
	function UserAvatarObject()
	{
		static $initVars;
		if (isset($initVars)) {
			$this->mVars = $initVars;
			return;
		}
		$this->initVar('avatar_id', XOBJ_DTYPE_INT, 0, true);
		$this->initVar('avatar_file', XOBJ_DTYPE_STRING, '', true, 30);
		$this->initVar('avatar_name', XOBJ_DTYPE_STRING, '', true, 100);
		$this->initVar('avatar_mimetype', XOBJ_DTYPE_STRING, '', true, 30);
		$this->initVar('avatar_created', XOBJ_DTYPE_INT, time(), true);
		$this->initVar('avatar_display', XOBJ_DTYPE_BOOL, '1', true);
		$this->initVar('avatar_weight', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('avatar_type', XOBJ_DTYPE_STRING, 'S', true, 1);
		$initVars=$this->mVars;
	}
	
	function getUsingCount()
	{
		$handler =& xoops_getmodulehandler('avatar_user_link', 'user');
		$criteria =new Criteria('avatar_id', $this->get('avatar_id'));
		return $handler->getCount($criteria);
	}
}

class UserAvatarHandler extends XoopsObjectGenericHandler
{
	var $mTable = "avatar";
	var $mPrimary = "avatar_id";
	var $mClass = "UserAvatarObject";

	function &createNoavatar()
	{
		$ret = $this->create();
		$ret->set('avatar_id', 0);
		$ret->set('avatar_name', _DELETE);
		
		return $ret;
	}
	
	function delete(&$obj)
	{
		@unlink(XOOPS_UPLOAD_PATH . "/" . $obj->get('avatar_file'));
		if (parent::delete($obj)) {
			$linkHandler =& xoops_getmodulehandler('avatar_user_link', 'user');
			$criteria =new Criteria('avatar_id', $obj->get('avatar_id'));
			$linkHandler->deleteAll($criteria);
			
			return true;
		}
		else {
			return false;
		}
	}
}

?>
