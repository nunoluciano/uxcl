<?php
class Xsns_File_Action extends Xsns_Admin_Action
{
function dispatch()
{
	global $xoopsModuleConfig;
	
	$err = $this->checkPermission();
	if(!is_array($err) || count($err) > 0){
		$this->context->setAttribute('perm_error', $err);
		return "default";
	}
	
	$limit = 10;
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!isset($start) || $start<0){
		$start = 0;
	}
	
	$criteria = new CriteriaCompo(NULL);
	$criteria->setLimit($limit);
	$criteria->setStart($start);
	$criteria->setSort('c_file_id');
	$criteria->setOrder('DESC');
	
	$file_handler =& XsnsFileHandler::getInstance();
	$file_obj_list =& $file_handler->getObjects($criteria);
	$file_list = array();
	
	$user_handler =& xoops_gethandler('user');
	
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	$comment = array();
	
	foreach($file_obj_list as $file_obj){
		$file_id = $file_obj->getVar('c_file_id');
		$filename = $file_obj->getVar('filename');
		
		$file_path = $xoopsModuleConfig['file_upload_path']. '/'. $filename;
		$file_info = @stat($file_path);
		$author_obj =& $user_handler->get($file_obj->getVar('uid'));
		$author_name = is_object($author_obj) ? $author_obj->getVar('uname') : "";
		
		$page_url = "";
		
		$target = $file_obj->getVar('target');
		$target_id = $file_obj->getVar('target_id');
		
		if($target==1){
			$page_url = XSNS_URL_COMMU.'?cid='.$target_id;
		}
		elseif($target==2){
			if(!isset($comment[$target_id])){
				$comment[$target_id] =& $comment_handler->get($target_id);
			}
			if(is_object($comment[$target_id])){
				$page_url = XSNS_URL_TOPIC.'&tid='.$comment[$target_id]->getVar('c_commu_topic_id');
			}
		}
		
		$file_list[$file_id] = array(
			'id' => $file_id,
			'url' => XSNS_FILE_URL."?id=".$file_id,
			'ref_link' => empty($page_url) ? "-" : "<a href='".$page_url."' target='_blank'>URL</a>",
			'filename' => rawurldecode($file_obj->getVar('org_filename')),
			'author' => $author_name,
			'size' => number_format($file_info['size']),
			'time' => str_replace(" ", "<br>", date('Y-m-d H:i:s', $file_info['mtime'])),
			'active' => "checked",
		);
		unset($author_obj);
	}
	
	$pager = $this->getPageSelector('index.php?'.XSNS_ACTION_ARG.'=file', 
						$start, $limit, count($file_list), $file_handler->getCount(), "#FFCCCC");
	
	$this->context->setAttribute('file_list', $file_list);
	$this->context->setAttribute('pager', $pager);
}
//------------------------------------------------------------------------------

}
?>
