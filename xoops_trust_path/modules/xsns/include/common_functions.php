<?php

if(!defined('XSNS_COMMON_FUNC_LOADED')){

define('XSNS_COMMON_FUNC_LOADED', true);

//------------------------------------------------------------------------------

function xsns_is_community_member($mydirname, $cid, $uid)
{
	if(empty($mydirname) || empty($cid) || empty($uid)){
		return false;
	}
	
	$db =& Database::getInstance();
	
	$sql = "SELECT c_commu_member_id FROM ". $db->prefix($mydirname.'_c_commu_member').
			" WHERE c_commu_id='".intval($cid)."' AND uid='".intval($uid)."'";
	if(($rs=$db->query($sql)) && $db->getRowsNum($rs)==1){
		return true;
	}
	return false;
}

//------------------------------------------------------------------------------

function xsns_is_friend($mydirname, $uid_from, $uid_to)
{
	if(empty($mydirname) || empty($uid_from) || empty($uid_to)){
		return false;
	}
	
	$db =& Database::getInstance();
	
	$sql = "SELECT c_friend_id FROM ". $db->prefix($mydirname.'_c_friend').
			" WHERE uid_from='".intval($uid_from)."' AND uid_to='".intval($uid_to)."'";
	if(($rs=$db->query($sql)) && $db->getRowsNum($rs)==1){
		return true;
	}
	return false;
}

//------------------------------------------------------------------------------

}

?>
