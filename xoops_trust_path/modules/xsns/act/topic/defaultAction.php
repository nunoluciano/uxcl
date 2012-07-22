<?php
class Xsns_Default_Action extends Xsns_Topic_Action
{

var $vars = array();

function dispatch()
{
	global $xoopsUser;
	$own_uid = is_object($xoopsUser)? $xoopsUser->getVar('uid') : 0;
	
	$limit = 20;
	$tid = $this->getIntRequest('tid', XSNS_REQUEST_GET);
	if(!isset($tid)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$start = $this->getIntRequest('s', XSNS_REQUEST_GET);
	
	$commu_handler =& XsnsCommunityHandler::getInstance();
	$topic_handler =& XsnsTopicHandler::getInstance();
	$user_handler =& XsnsUserHandler::getInstance();
	$image_handler =& XsnsImageHandler::getInstance();
	$file_handler =& XsnsFileHandler::getInstance();
	
	// トピックの取得
	$topic =& $topic_handler->get($tid);
	if(!is_object($topic)){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	$topic_uid = $topic->getVar('uid');
	
	// コミュニティの取得
	$cid = $topic->getVar('c_commu_id');
	$community =& $commu_handler->get($cid);
	if(!is_object($community) || ($community->getVar('public_flag')==3 && !$community->checkAuthority())){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$main_comment =& $topic->getCommentList(1, 0);
	if(!is_array($main_comment) || !isset($main_comment[0])){
		redirect_header(XOOPS_URL, 2, _NOPERM);
	}
	
	$comment_count_all = $topic->getCommentCount() - 1;
	if($comment_count_all > 1000){
		$comment_count_all = 1000;
	}
	
	if($comment_count_all > 0){
		if(!isset($start) || $start < 0 || $start > 1000){
			$start = $limit * floor(($comment_count_all-1)/$limit);
		}
		if($start >= 1000){
			$start = 1000 - $limit;
		}
	}
	else{
		$start = 0;
	}
	
	$comment_list_temp =& $topic->getCommentList($limit, $start+1);	// except No.0
	if(is_array($comment_list_temp)){
		$comment_list_temp = $main_comment + $comment_list_temp;
	}
	else{
		$comment_list_temp = $main_comment;
	}
	
	$sess_handler =& XsnsSessionHandler::getInstance();
	$comment_temp = $sess_handler->getVar('comment_body');
	$sess_handler->clearVars();
	$ts =& XsnsTextSanitizer::getInstance();
	
	$default = array(
		'comment' => !empty($comment_temp) ? $ts->makeTboxData4PreviewInForm($comment_temp) : '',
	);
	
	// 引用レスのポップアップウィンドウ生成 ----------------
	$res_ids_temp = array();
	$this->vars = array(
		'comment_list' => array(),
		'comment_checked' => array(),
		'res_depth' => 0,
	);
	$this->vars['comment_list'] =& $comment_list_temp;
	
	foreach($comment_list_temp as $comment){
		$this->vars['res_depth'] = 0;
		$res_ids_temp = $this->getResIds($tid, $comment['number'], $comment['body']);
	}
	
	if(is_array($this->vars['comment_checked'])){
		$res_ids = array_keys($this->vars['comment_checked']);
		$res_list =& $this->getResList($tid, $res_ids);
		$res_popup_list =& $this->getResPopupList($limit, $res_ids, $res_list);
	}
	else{
		$res_list = NULL;
	}
	//------------------------------------------------------
	
	$comment_list = array();
	$commu_auth = $community->getAuthority();
	
	foreach($comment_list_temp as $comment){
		$comment_ids[] = $comment['c_commu_topic_comment_id'];
	}
	$image_list =& $image_handler->getListByIds(2, $comment_ids);
	$file_list =& $file_handler->getListByIds(2, $comment_ids);
	$author_obj_list = array();
	
	foreach($comment_list_temp as $comment){
		$comment_uid = intval($comment['uid']);
		if($comment_uid > 0){
			$tcid = intval($comment['c_commu_topic_comment_id']);
			if(!isset($author_obj_list[$comment_uid])){
				$author_obj_list[$comment_uid] =& $user_handler->get($comment_uid);
			}
			
			if(is_object($author_obj_list[$comment_uid])){
				$author_info =& $author_obj_list[$comment_uid]->getInfo();
			}
			else{
				$author_info = array();
			}
			
			$id = intval($comment['c_commu_topic_comment_id']);
			$images = isset($image_list[$id]) ? $image_list[$id] : array();
			$files = isset($file_list[$id]) ? $file_list[$id] : array();
			
			$comment_list[] = array(
				'uid' => $comment_uid,
				'body' => $this->getResQuotedCommentBody($tid, $comment['number'], $res_list),
				'author' => $author_info,
				'time' => $comment['r_datetime'],
				'number' => $comment['number'],
				'images' => $images,
				'files' => $files,
				'show_edit' => $commu_auth>=XSNS_AUTH_SUB_ADMIN || ($commu_auth>=XSNS_AUTH_MEMBER && ($comment_uid==$own_uid || $topic_uid==$own_uid)),
				'show_res_add' => ($commu_auth>=XSNS_AUTH_MEMBER),
				'url_edit' => XSNS_URL_TOPIC.'&'.XSNS_ACTION_ARG.'=edit&tcid='.$tcid,
				'url_del' => XSNS_URL_TOPIC.'&'.XSNS_ACTION_ARG.'=del&tcid='.$tcid,
			);
		}
		else{
			// deleted topic/comment
			$comment_list[] = array(
				'uid' => 0,
				'body' => '',
				'time' => $comment['r_datetime'],
				'number' => $comment['number'],
			);
		}
	}
	
	$comment_count = count($comment_list) - 1;
	
	$pager = $this->getPageSelector(XSNS_URL_TOPIC.'&tid='.$tid, 
						$start, $limit, $comment_count, $comment_count_all);
	
	$image_handler->DeleteImageTemp();
	$file_handler->DeleteFileTemp();
	
	$commu_vars = array(
		'id' => $community->getVar('c_commu_id'),
		'name' => $community->getVar('name'),
		'auth_level' => $commu_auth,
	);
	
	$topic_vars = array(
		'id' => $tid,
		'name' => $topic->getVar('name'),
	);
	
	$this->context->setAttribute('commu', $commu_vars);
	$this->context->setAttribute('topic', $topic_vars);
	$this->context->setAttribute('comment_list', $comment_list);
	$this->context->setAttribute('comment_count', $comment_count);
	$this->context->setAttribute('comment_count_all', $comment_count_all);
	$this->context->setAttribute('pager', $pager);
	$this->context->setAttribute('res_popup_list', $res_popup_list);
	$this->context->setAttribute('default', array('body' => $default['comment']));
}
//------------------------------------------------------------------------------

function getResIds($tid, $comment_id, $comment_body)
{
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	
	if(!preg_match_all("/\[res\]([1-9]\\d*)\[\/res\]/", $comment_body, $matches)){
		return false;
	}
	if(++$this->vars['res_depth'] > 10){
		$this->vars['res_depth'] = 0;
		return false;
	}
	
	$res_ids = array();
	
	foreach($matches[1] as $id){
		if(isset($this->vars['comment_checked'][$id])){
			continue;
		}
		
		if(isset($this->vars['comment_list'][$id])){
			// 引用コードを再帰検索
			if($id < $comment_id && !empty($this->vars['comment_list'][$id]['body'])){
				$this->vars['comment_checked'][$id] = true;
				$res_ids[] = $this->getResIds($tid, $id, $this->vars['comment_list'][$id]['body']);
			}
		}
		else{
			// ページ範囲外のコメントを取得して、引用コードを再帰検索
			$res =& $comment_handler->getByNumber($tid, $id);
			if(is_object($res)){
				$this->vars['comment_checked'][$id] = true;
				$res_ids[] = $this->getResIds($tid, $id, $res->getVar('body'));
			}
		}
	}
	return $res_ids;
}
//------------------------------------------------------------------------------

function &getResPopupList($limit, $res_ids, $res_list)
{
	$ret = array();
	$user_handler =& XsnsUserHandler::getInstance();
	
	foreach($res_ids as $id){
		if(!isset($res_list[$id]) || $res_list[$id]['uid'] < 1){
			continue;
		}
		
		$author_obj =& $user_handler->get($res_list[$id]['uid']);
		if(!is_object($author_obj)){
			continue;
		}
		$author_info =& $author_obj->getInfo();
		
		$body = $res_list[$id]['body'];
		
		if(preg_match_all("/\[res\]([1-9]\\d*)\[\/res\]/", $body, $matches)){
			foreach($matches[1] as $m){
				if(isset($res_list[$m]) && $res_list[$m]['uid'] > 0){
					$s = floor(($m-1)/$limit) * $limit;
					$body = str_replace("[res]{$m}[/res]", "<a href=\"".XSNS_URL_TOPIC."&amp;tid={$res_list[$m]['c_commu_topic_id']}&amp;s={$s}#{$m}\" onmouseover=\"showResPopUp('res{$m}',event)\" onmouseout=\"hideResPopUp('res{$m}')\">&gt;&gt;{$m}</a>", $body);
				}
				else{
					$body = str_replace("[res]{$m}[/res]", "&gt;&gt;{$m}", $body);
				}
			}
		}
		
		$ret[] = array(
			'id' => $id,
			'uid' => $author_info['uid'],
			'uname' => $author_info['name'],
			'time' => $res_list[$id]['r_datetime'],
			'body' => $body,
		);
		unset($author_obj);
	}
	return $ret;
}
//------------------------------------------------------------------------------

function &getResList($tid, $res_ids)
{
	$comment_handler =& XsnsTopicCommentHandler::getInstance();
	return $comment_handler->getListByNumbers($tid, $res_ids);
}
//------------------------------------------------------------------------------

function getResQuotedCommentBody($tid, $num, $res_list)
{
	$body = $this->vars['comment_list'][$num]['body'];
	if(!preg_match_all("/\[res\]([1-9]\\d*)\[\/res\]/", $body, $matches)){
		return $body;
	}
	
	foreach($matches[1] as $id){
		if($id < $num && isset($res_list[$id])){
			$s = floor(($id-1)/20)*20;
			$body = str_replace("[res]{$id}[/res]", "<a href=\"".XSNS_URL_TOPIC."&amp;tid={$tid}&amp;s={$s}#{$id}\" onmouseover=\"showResPopUp('res{$id}',event)\" onmouseout=\"hideResPopUp('res{$id}')\">&gt;&gt;{$id}</a>", $body);
		}
		else{
			$body = str_replace("[res]{$id}[/res]", "&gt;&gt;{$id}", $body);
		}
	}
	return $body;
}
//------------------------------------------------------------------------------

}
?>
