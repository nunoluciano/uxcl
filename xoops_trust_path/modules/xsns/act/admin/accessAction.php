<?php
class Xsns_Access_Action extends Xsns_Admin_Action
{
//------------------------------------------------------------------------------

function dispatch()
{
	$err = $this->checkPermission();
	if(!is_array($err) || count($err) > 0){
		$this->context->setAttribute('perm_error', $err);
		return "default";
	}
	
	$log_handler =& XsnsAccessLogHandler::getInstance();
	
	$limit = 50;
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!isset($start) || $start<0){
		$start = 0;
	}
	$cid = $this->getIntRequest('cid', XSNS_REQUEST_GET);
	$uid = $this->getIntRequest('uid', XSNS_REQUEST_GET);
	
	$access_log =& $log_handler->getList($cid, $uid, $limit, $start);
	$access_log_count = $log_handler->getListCount($cid, $uid);
	
	$cid_url = ($cid>0)? '&cid='.$cid : '';
	$uid_url = ($uid>0)? '&uid='.$uid : '';
	
	$pager = $this->getPageSelector('index.php?'.XSNS_ACTION_ARG.'=access'.$cid_url.$uid_url, 
						$start, $limit, count($access_log), $access_log_count, "#FFCCCC");
	$this->context->setAttribute('access_log', $access_log);
	$this->context->setAttribute('pager', $pager);
}
//------------------------------------------------------------------------------

}
?>
