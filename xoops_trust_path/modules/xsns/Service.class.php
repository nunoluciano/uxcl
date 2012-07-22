<?php

if(!class_exists('Xsns_Service_Base')){

class Xsns_Service_Base extends XCube_Service
{
	function prepare()
	{
		$this->addFunction(S_PUBLIC_FUNC('int isMyFriend(int uid_to)'));
		$this->addFunction(S_PUBLIC_FUNC('int isFriend(int uid_from, int uid_to)'));
	}
	
	function isMyFriend()
	{
		$root =& XCube_Root::getSingleton();
		
		if(is_object($root) && is_object($root->mContext->mXoopsUser)){
			$uid_from = $root->mContext->mXoopsUser->getVar('uid');
			$uid_to = $root->mContext->mRequest->getRequest('uid_to');
			return $this->_isFriend($uid_from, $uid_to);
		}
		return 0;
	}
	
	function isFriend()
	{
		$root =& XCube_Root::getSingleton();
		
		if(is_object($root) && is_object($root->mContext->mXoopsUser)){
			$uid_from = $root->mContext->mRequest->getRequest('uid_from');
			$uid_to = $root->mContext->mRequest->getRequest('uid_to');
			return $this->_isFriend($uid_from, $uid_to);
		}
		return 0;
	}
	
	function _isFriend($uid_from, $uid_to)
	{
		if($uid_from > 0 && $uid_to > 0 && $uid_from != $uid_to){
			require_once dirname(__FILE__).'/userlib/friend.class.php';
			$friend_handler =& XsnsFriendHandler::getInstance();
			$friend_obj =& $friend_handler->getOne($uid_from, $uid_to);
			return is_object($friend_obj) ? 1 : 0;
		}
		return 0;
	}
}

}


if(!class_exists(ucfirst($mydirname).'_Service')){

eval('

class '.ucfirst($mydirname).'_Service extends Xsns_Service_Base
{
	var $mServiceName = "'.ucfirst($mydirname).'_Service";
	var $mNameSpace = "'.ucfirst($mydirname).'";
	var $mClassName = "'.ucfirst($mydirname).'_Service";
}

');

}

?>