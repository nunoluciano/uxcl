<?php
class Xsns_Default_View extends Xsns_Member_View
{
function dispatch()
{
	require XSNS_FRAMEWORK_DIR.'/global.php';
	$xoopsOption['template_main'] = $mydirname.'_member.html';
	require_once XOOPS_ROOT_PATH.'/header.php';
	
	$commu = $this->context->getAttribute('commu');
	
	$this->assignCommonVars();
	$this->assignStyleSheet('member.css');
	
	$lang = array(
		'member_list' => '['.$commu['name'].'] '._MD_XSNS_TITLE_MEMBER,
		'avatar' => _MD_XSNS_AVATAR,
		'member_name' => _MD_XSNS_USER_NAME,
		'reg_date' => _MD_XSNS_MEMBER_REG_DATE,
		'last_login' => _MD_XSNS_MEMBER_LAST_LOGIN,
	);
	
	$breadcrumbs = array(
		array('name' => $commu['name'], 'url' => XSNS_URL_COMMU.'?cid='.$commu['id']),
		array('name' => _MD_XSNS_TITLE_MEMBER),
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
