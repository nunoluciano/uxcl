<?php

function xsns_main_trigger_event( $category , $item_id , $event , $extra_tags=array() , $user_list=array() , $omit_user_id=null )
{
	global $xoopsModule , $xoopsConfig , $mydirname , $mydirpath;

	$notification_handler =& xoops_gethandler('notification') ;

	$mid = $xoopsModule->getVar('mid') ;

	// language
	$language = empty($xoopsConfig['language']) ? 'japanese' : $xoopsConfig['language'] ;
	$trustdirpath = dirname(dirname(__FILE__));
	if( file_exists( "$mydirpath/language/$language/mail_template/" ) ) {
		$mail_template_dir = "$mydirpath/language/$language/mail_template/" ;
	}
	else if( file_exists( $trustdirpath."/language/$language/mail_template/" ) ) {
		$mail_template_dir = $trustdirpath."/language/$language/mail_template/";
	}
	else {
		$mail_template_dir = $trustdirpath."/language/japanese/mail_template/";
	}
	
	// Check if event is enabled
	$config_handler =& xoops_gethandler('config');
	$mod_config =& $config_handler->getConfigsByCat(0,$mid);
	if (empty($mod_config['notification_enabled'])) {
		return false;
	}
	$category_info =& notificationCategoryInfo ($category, $mid);
	$event_info =& notificationEventInfo ($category, $event, $mid);
	if (!in_array(notificationGenerateConfig($category_info,$event_info,'option_name'),$mod_config['notification_events']) && empty($event_info['invisible'])) {
		return false;
	}

	if (!isset($omit_user_id)) {
		global $xoopsUser;
		if (!empty($xoopsUser)) {
			$omit_user_id = $xoopsUser->getVar('uid');
		} else {
			$omit_user_id = 0;
		}
	}
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('not_modid', intval($mid)));
	$criteria->add(new Criteria('not_category', $category));
	$criteria->add(new Criteria('not_itemid', intval($item_id)));
	$criteria->add(new Criteria('not_event', $event));
	$mode_criteria = new CriteriaCompo();
	$mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDALWAYS), 'OR');
	$mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE), 'OR');
	$mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT), 'OR');
	$criteria->add($mode_criteria);
	if (!empty($user_list)) {
		$user_criteria = new CriteriaCompo();
		foreach ($user_list as $user) {
			$user_criteria->add (new Criteria('not_uid', $user), 'OR');
		}
		$criteria->add($user_criteria);
	}
	$notifications =& $notification_handler->getObjects($criteria);
	if (empty($notifications)) {
		return;
	}

	// Add some tag substitutions here
	$tags = array();
	// {X_ITEM_NAME} {X_ITEM_URL} {X_ITEM_TYPE} from lookup_func are disabled
	$tags['X_MODULE'] = $xoopsModule->getVar('name','n');
	$tags['X_MODULE_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/';
	$tags['X_NOTIFY_CATEGORY'] = $category;
	$tags['X_NOTIFY_EVENT'] = $event;

	$template = $event_info['mail_template'] . '.tpl';
	$subject = $event_info['mail_subject'];

	foreach ($notifications as $notification) {
		if (empty($omit_user_id) || $notification->getVar('not_uid') != $omit_user_id) {
			$tags['X_UNSUBSCRIBE_URL'] = XOOPS_URL . '/notifications.php';
			$tags = array_merge($tags, $extra_tags);
			
			$notification->notifyUser($mail_template_dir, $template, $subject, $tags);
		}
	}
}

?>
