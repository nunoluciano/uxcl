<?php
class Xsns_Request_View extends Xsns_Member_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_member_request.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	$member = $this->context->getAttribute('member');
	$mode = $this->context->getAttribute('mode');
	
	switch($mode){
		case 0:		// 強制退会
			$page = array(
				'lang_req_title' => _MD_XSNS_TITLE_MEMBER_REQUEST_LEAVE,
				'lang_req_desc' => _MD_XSNS_MEMBER_REQUEST_LEAVE_DESC,
				'target_act' => 'leave_exec',
			);
			break;
		case 1:		// 管理者交代
			$page = array(
				'lang_req_title' => _MD_XSNS_TITLE_MEMBER_REQUEST_ADMIN,
				'lang_req_desc' => _MD_XSNS_MEMBER_REQUEST_ADMIN_DESC,
				'target_act' => 'admin_exec',
			);
			break;
		case 2:	// 副管理者に指名
			$page = array(
				'lang_req_title' => _MD_XSNS_TITLE_MEMBER_REQUEST_SUB_ADMIN,
				'lang_req_desc' => _MD_XSNS_MEMBER_REQUEST_SUB_ADMIN_DESC,
				'target_act' => 'sub_admin_exec',
			);
			break;
	}
	
	$this->assignCommonVars();
	$this->assignStyleSheet('member.css');
	$this->assignFormHeader('form_request_submit', 'post', 'member', $page['target_act'], false, 
		array('cid'=>$commu['id'], 'uid'=>$member['uid']), 'MEMBER_EDIT');
	
	$lang = array(
		'title' => $page['lang_req_title'],
		'desc' => $page['lang_req_desc'],
	);
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => $page['lang_req_title']),
	);
	
	$this->tpl->assign(array(
		'lang' => $lang,
		'xoops_breadcrumbs' => $breadcrumbs,
	));
	
	$this->context->assignAttributes();
	
	require_once XOOPS_ROOT_PATH.'/footer.php';
}
}
?>
