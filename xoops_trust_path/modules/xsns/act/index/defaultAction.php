<?php
class Xsns_Default_Action extends Xsns_Index_Action
{

function dispatch()
{
	$limit = 10;
	
	$sess_handler =& XsnsSessionHandler::getInstance();
	$sess_handler->clearVars();
	
	$cid = $this->getIntRequest('cid', XSNS_REQUEST_GET);
	
	if($cid > 0){
		$commu_detail = $this->getCommunityDetail($cid);
		$this->context->setAttribute('commu', $commu_detail);
		
		return "detail";
	}
	
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	if(!isset($start) || $start<0){
		$start = 0;
	}
	
	$cat_id = $this->getIntRequest('cat_id', XSNS_REQUEST_GET);
	$keyword = $this->getTextRequest('keyword', XSNS_REQUEST_GET);
	$sort_method = $this->getTextRequest('sort', XSNS_REQUEST_GET);
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	
	$criteria = new CriteriaCompo();
	$criteria->setLimit($limit);
	$criteria->setStart($start);
	
	if($cat_id > 0){
		$criteria->add(new Criteria('c_commu_category_id', $cat_id));
	}
	if($keyword != ''){
		$kw_criteria = new CriteriaCompo(new Criteria('name', '%'.$keyword.'%', 'LIKE'));
		$kw_criteria->add(new Criteria('info', '%'.$keyword.'%', 'LIKE'), 'OR');
		$criteria->add($kw_criteria);
	}
	
	switch($sort_method){
		case 'date':
		default:
			$criteria->setSort('cc.r_datetime');
			$criteria->setOrder('DESC');
			break;
		
		case 'member':
			$criteria->setSort('member_count');
			$criteria->setOrder('DESC');
			break;
		
		case 'pop':
			$criteria->setSort('cc.popularity');
			$criteria->setOrder('DESC');
			break;
		
		case 'up':
			$criteria->setSort('cc.update_freq');
			$criteria->setOrder('DESC');
			break;
	}
	$commu_list =& $commu_handler->getList($criteria);
	$commu_total = $commu_handler->getCount($criteria);
	
	$base_url = XSNS_URL_COMMU.'?';
	if($cat_id > 0){
		$base_url .= "&cat_id=".$cat_id;
	}
	if($keyword != ''){
		$base_url .= "&keyword=".rawurlencode($keyword);
	}
	
	if($sort_method=='member' || $sort_method=='date' || $sort_method=='pop' || $sort_method=='up'){
		$base_url .= '&sort='.$sort_method;
	}
	
	$category_handler =& XsnsCategoryHandler::getInstance();
	$category_parent_handler =& XsnsCategoryParentHandler::getInstance();
	$category_selector = $category_handler->getSelectorHtml('cat_id', 0, _MD_XSNS_INDEX_CATEGORY_NO);
	$category_list =& $category_parent_handler->getList();
	
	$pager = $this->getPageSelector($base_url, 
				$start, $limit, count($commu_list), $commu_total);
	
	if(count($commu_list)==0){
		$pager['description'] = _MD_XSNS_INDEX_COMMU_COUNT0;
	}
	
	$keyword_option = empty($keyword)? '' : '&keyword='.rawurlencode($keyword);
	$cat_id_option = empty($cat_id)? '' : '&cat_id='.$cat_id;
	
	$url = array(
		'sort_member' => XSNS_URL_COMMU.'?sort=member'. $keyword_option. $cat_id_option,
		'sort_date' => XSNS_URL_COMMU.'?sort=date'. $keyword_option. $cat_id_option,
		'sort_pop' => XSNS_URL_COMMU.'?sort=pop'. $keyword_option. $cat_id_option,
		'sort_up' => XSNS_URL_COMMU.'?sort=up'. $keyword_option. $cat_id_option,
	);
	
	$this->context->setAttribute('is_guest', $this->isGuest());
	$this->context->setAttribute('keyword', $keyword);
	$this->context->setAttribute('url', $url);
	$this->context->setAttribute('category_selector', $category_selector);
	$this->context->setAttribute('category_list', $category_list);
	$this->context->setAttribute('pager', $pager);
	$this->context->setAttribute('commu_list', $commu_list);
}
//------------------------------------------------------------------------------

function getCommunityDetail($cid)
{
	global $xoopsUser;
	$topic_limit = 10;
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$c_member_handler =& XsnsMemberHandler::getInstance();
	$user_handler =& XsnsUserHandler::getInstance();
	$image_handler =& XsnsImageHandler::getInstance();
	$topic_handler =& XsnsTopicHandler::getInstance();
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	
	// コミュニティの取得
	$community =& $commu_handler->get($cid);
	if(!is_object($community)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$community->setStatistics();
	
	// コミュニティメンバー一覧の取得
	$c_member_obj_list =& $community->getMemberObjects(9, 0, true);
	$c_member_list = array();
	foreach($c_member_obj_list as $c_member_obj){
		$c_member_list[] =& $c_member_obj->getInfo();
	}
	
	$c_member_count = count($c_member_obj_list);
	if($c_member_count < 9){
		for($i=0; $i<9-$c_member_count; $i++){
			$c_member_list[] = array();
		}
	}
	
	$uid_admin = $community->getVar('uid_admin');
	$own_uid = ($this->isXoopsUser()) ? $xoopsUser->getVar('uid') : 0;
	
	if($c_member_handler->getOne($cid, $own_uid)){
		$is_member = true;
		$is_admin = ($own_uid == $uid_admin)? true : false;
	}
	else{
		$is_member = $is_admin = false;
	}
	
	$commu_auth = $community->getAuthority();
	$public_flag = $community->getVar('public_flag');
	
	$admin_obj =& $user_handler->get($uid_admin);
	$admin_name = is_object($admin_obj) ? $admin_obj->getVar('uname') : "";
	
	$public_flag_desc = array(
		1 => _MD_XSNS_INDEX_DETAIL_PUBLIC_L1,
		2 => _MD_XSNS_INDEX_DETAIL_PUBLIC_L2,
		3 => _MD_XSNS_INDEX_DETAIL_PUBLIC_L3,
	);
	
	$ret = array(
		'id' => $cid,
		'name' => $community->getVar('name'),
		'info' => $community->getVar('info'),
		'time' => $community->getVar('r_datetime'),
		'image' => $community->getImage(XSNS_IMAGE_SIZE_L),
		'category' => $community->getCategoryName(),
		'public' => $public_flag_desc[$public_flag],
		'admin_name' => $admin_name,
		'admin_url' => XSNS_URL_MYPAGE.'&uid='.$uid_admin,
		'statistics' => $community->getStatistics(),
		'member_list' => $c_member_list,
		'member_count' => $community->getMemberCount(),
		'topic_list' => $community->getTopicList($topic_limit),
		'topic_count' => $community->getTopicCount(),
		
		'show_commu_join' => (!$is_member && $commu_auth > XSNS_AUTH_GUEST) ? true : false,
		'show_commu_leave' => ($is_member && !$is_admin) ? true : false,
		'show_commu_notify' => ($is_member) ? true : false,
		'show_commu_config' => ($commu_auth >= XSNS_AUTH_ADMIN) ? true : false,
		'show_topic_list' => ($public_flag!=3 || $commu_auth>=XSNS_AUTH_MEMBER) ? true : false,
		'show_topic_add' => ($commu_auth >= XSNS_AUTH_MEMBER) ? true : false,
		'show_send_message' => ($commu_auth >= XSNS_AUTH_MEMBER) ? true : false,
		'show_member_config' => ($commu_auth >= XSNS_AUTH_ADMIN) ? true : false,
	);
	return $ret;
}
//------------------------------------------------------------------------------

}

?>