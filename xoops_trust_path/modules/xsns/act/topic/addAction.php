<?php
class Xsns_Add_Action extends Xsns_Topic_Action
{
function dispatch()
{
	if($this->isGuest()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$cid = $this->getIntRequest('cid', XSNS_REQUEST_GET);
	if(!isset($cid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// コミュニティの取得
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || !$community->checkAuthority()){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	// 画像・ファイルのキャッシュを削除
	$image_handler =& XsnsImageHandler::getInstance();
	$image_handler->deleteImageTemp();
	$file_handler =& XsnsFileHandler::getInstance();
	$file_handler->deleteFileTemp();
	
	$sess_handler =& XsnsSessionHandler::getInstance();
	$topic_temp = $sess_handler->getVar('topic');
	$sess_handler->clearVars();
	$ts =& XsnsTextSanitizer::getInstance();
	
	$default = array(
		'name' => isset($topic_temp['name']) ? $ts->makeTboxData4PreviewInForm($topic_temp['name']) : '',
		'body' => isset($topic_temp['body']) ? $ts->makeTareaData4PreviewInForm($topic_temp['body']) : '',
	);
	
	$commu_info = array('id' => $cid, 'name' => $community->getVar('name'));
	$this->context->setAttribute('commu', $commu_info);
	$this->context->setAttribute('default', $default);
}

}
?>
