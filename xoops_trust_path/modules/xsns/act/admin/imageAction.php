<?php
class Xsns_Image_Action extends Xsns_Admin_Action
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
	$criteria->setSort('c_image_id');
	$criteria->setOrder('DESC');
	
	$image_handler =& XsnsImageHandler::getInstance();
	$image_obj_list =& $image_handler->getObjects($criteria);
	$image_list = array();
	
	$user_handler =& xoops_gethandler('user');
	
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	$comment = array();
	
	foreach($image_obj_list as $image_obj){
		$image_id = $image_obj->getVar('c_image_id');
		$filename = $image_obj->getVar('filename');
		
		$image_path = $xoopsModuleConfig['file_upload_path']. '/'. $filename;
		
		$width = $height = 0;
		if($imagesize = @getimagesize($image_path)){
			$width = $imagesize[0];
			$height = $imagesize[1];
		}
		$file_info = @stat($image_path);
		
		$author_obj =& $user_handler->get($image_obj->getVar('uid'));
		$author_name = is_object($author_obj) ? $author_obj->getVar('uname') : "";
		
		$page_url = "";
		
		$target = $image_obj->getVar('target');
		$target_id = $image_obj->getVar('target_id');
		
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
		
		$image_list[$image_id] = array(
			'id' => $image_id,
			'author' => $author_name,
			'url' => XSNS_IMAGE_URL."?f=".$filename,
			'ref_link' => empty($page_url) ? "-" : "<a href='".$page_url."' target='_blank'>URL</a>",
			'link' => XSNS_IMAGE_URL."?f=".$filename."&t=1",
			'width' => $width,
			'height' => $height,
			'size' => number_format($file_info['size']),
			'time' => str_replace(" ", "<br><br>", date('Y-m-d H:i:s', $file_info['mtime'])),
			'active' => "checked",
		);
		unset($author_obj);
	}
	
	$pager = $this->getPageSelector('index.php?'.XSNS_ACTION_ARG.'=image', 
				$start, $limit, count($image_list), $image_handler->getCount(), "#FFCCCC");
	
	$this->context->setAttribute('image_list', $image_list);
	$this->context->setAttribute('pager', $pager);
}
//------------------------------------------------------------------------------

}
?>
