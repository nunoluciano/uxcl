<?php
require_once XOOPS_TRUST_PATH.'/modules/attachfile/class/AttachfilePluginAbstract.class.php' ;

// a class for attachfile plugin
class d3forumAttachfilePlugin extends AttachfilePluginAbstract{

//var $attachfile_dirname = '' ;
//var $attachfile_trustdirname = '' ;
//var $target_dirname = '' ;
//var $target_trustdirname = '' ;

function d3forumAttachfilePlugin( $parentObj )
{
	$this->parentObj = & $parentObj;
}

// ===========================================================================
// The permission file is necessary in each module.
// If target module is "D3 module", the permission file is necessary
// in each directory in XOOPS_TRUST_PATH (not XOOPS_ROOT_PATH).
//
// -- argument --
// 
// $target_id			: target mosule's contents id (target to attach)
// 
// -- return value --
// 
// true					: allow access
// false				: deny access
// ===========================================================================

function attachfile_check_upload_permission_plugin( $target_id )
{
	global $config_handler , $module_handler , $xoopsUser , $xoopsDB ;

	// emulate d3forum
	$mytrustdirname = $this->target_trustdirname ;
	$mytrustdirpath = XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname ;
	$mydirname = $this->target_dirname ;

	$xoopsModule =& $module_handler->getByDirname( $mydirname );
	if ($xoopsModule->getVar('hasconfig') == 1 || $xoopsModule->getVar('hascomments') == 1 || $xoopsModule->getVar( 'hasnotification' ) == 1) {
		$xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
	}

	include_once $mytrustdirpath.'/include/main_functions.php' ;

	// from include/common_prepend.php
	// GET $uid
	$uid = is_object( @$xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;
	$isadmin = $uid > 0 ? $xoopsUser->isAdmin() : false ;
	// get this user's permissions as perm array
	$category_permissions = d3forum_get_category_permissions_of_current_user( $mydirname ) ;
	$whr_read4cat = 'c.`cat_id` IN (' . implode( "," , array_keys( $category_permissions ) ) . ')' ;
	$forum_permissions = d3forum_get_forum_permissions_of_current_user( $mydirname ) ;
	$whr_read4forum = 'f.`forum_id` IN (' . implode( "," , array_keys( $forum_permissions ) ) . ')' ;

	// from main/edit.php
	$post_id = intval( $target_id ) ;
	// get this "post" from given $post_id
	$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_posts")." WHERE post_id=$post_id" ;
	if( ! $prs = $xoopsDB->query( $sql ) ) return false ;
	if( $xoopsDB->getRowsNum( $prs ) <= 0 ) return false ;
	$post_row = $xoopsDB->fetchArray( $prs ) ;
	$topic_id = intval( $post_row['topic_id'] ) ;

	// from include/process_this_topic.inc.php
	// get this "topic" from given $topic_id
	$sql = "SELECT t.*,u2t.u2t_time,u2t.u2t_marked,u2t.u2t_rsv,p.number_entity,p.special_entity FROM ".$xoopsDB->prefix($mydirname."_topics")." t LEFT JOIN ".$xoopsDB->prefix($mydirname."_users2topics")." u2t ON t.topic_id=u2t.topic_id AND u2t.uid=$uid LEFT JOIN ".$xoopsDB->prefix($mydirname."_posts")." p ON t.topic_first_post_id=p.post_id WHERE t.topic_id=$topic_id" ;
	if( ! $trs = $xoopsDB->query( $sql ) ) return false ;
	if( $xoopsDB->getRowsNum( $trs ) <= 0 ) return false ;
	$topic_row = $xoopsDB->fetchArray( $trs ) ;
	$forum_id = intval( $topic_row['forum_id'] ) ;
	$isadminormod = (boolean) @$forum_permissions[ $forum_id ]['is_moderator'] || $isadmin ;
	// TOPIC_INVISIBLE (check & make where)
	if( $isadminormod ) {
		$whr_topic_invisible = '1' ;
	} else {
		if( $topic_row['topic_invisible'] ) return false ;
		$whr_topic_invisible = '! topic_invisible' ;
	}
	
	// from include/process_this_forum.inc.php
	// get this "forum" from given $forum_id
	$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_forums")." f WHERE ($whr_read4forum) AND f.forum_id=$forum_id" ;
	if( ! $frs = $xoopsDB->query( $sql ) ) die( _MD_D3FORUM_ERR_SQL.__LINE__ ) ;
	if( $xoopsDB->getRowsNum( $frs ) <= 0 ) return false ;
	$forum_row = $xoopsDB->fetchArray( $frs ) ;
	$cat_id = intval( $forum_row['cat_id'] ) ;
	$isadminormod = (boolean)$forum_permissions[ $forum_id ]['is_moderator'] || $isadmin ;
	$can_post = (boolean)$forum_permissions[ $forum_id ]['can_post'] || $isadminormod ;
	$can_edit = (boolean)$forum_permissions[ $forum_id ]['can_edit'] || $isadminormod ;
	$can_delete = (boolean)$forum_permissions[ $forum_id ]['can_delete'] || $isadminormod ;
	$need_approve = ! (boolean)$forum_permissions[ $forum_id ]['post_auto_approved'] && ! $isadminormod ;

	// from include/process_this_category.inc.php
	// get this "category" from given $cat_id
	$sql = "SELECT * FROM ".$xoopsDB->prefix($mydirname."_categories")." c WHERE $whr_read4cat AND c.cat_id=$cat_id" ;
	if( ! $crs = $xoopsDB->query( $sql ) ) return false ;
	if( $xoopsDB->getRowsNum( $crs ) <= 0 ) return false ;
	$cat_row = $xoopsDB->fetchArray( $crs ) ;
	$isadminorcatmod = (boolean)$category_permissions[ $cat_id ]['is_moderator'] || $isadmin ;
	$can_makeforum = (boolean)$category_permissions[ $cat_id ]['can_makeforum'] ;

	// from main/edit.php
	// hidden_uid
	if( $uid == $post_row['uid_hidden'] ) $post_row['uid'] = $post_row['uid_hidden'] ;

	// from include/process_eachpost.inc.php
	// get this poster's object
	$user_handler =& xoops_gethandler( 'user' ) ;
	$poster_obj =& $user_handler->get( intval( $post_row['uid'] ) ) ;
	if( is_object( $poster_obj ) ) {
		// active user's post
		// permissions
		$can_reply = ( $topic_row['topic_locked'] || $post_row['invisible'] || ! $post_row['approval'] ) ? false : $can_post ;
		if( $isadminormod ) {
			$can_edit = true ;
			$can_delete = true ;
		} else if( $post_row['uid'] == $uid ) {
			$can_edit = $forum_permissions[ $forum_id ]['can_edit'] && time() < $post_row['post_time'] + $xoopsModuleConfig['selfeditlimit'] ? true : false ;
			$can_delete = $forum_permissions[ $forum_id ]['can_delete'] && time() < $post_row['post_time'] + $xoopsModuleConfig['selfdellimit'] ? true : false ;
		} else {
			$can_edit = false ;
			$can_delete = false ;
		}
	} else {
		// guest or quitted or hidden user's post
		// permissions
		$can_reply = ( $topic_row['topic_locked'] || $post_row['invisible'] || ! $post_row['approval'] ) ? false : $can_post ;
		if( $isadminormod ) {
			$can_edit = true ;
			$can_delete = true ;
		} else if( $post_row['uid_hidden'] && $post_row['uid_hidden'] == $uid  ) {
			$can_edit = $forum_permissions[ $forum_id ]['can_edit'] && time() < $post_row['post_time'] + $xoopsModuleConfig['selfeditlimit'] ? true : false ;
			$can_delete = $forum_permissions[ $forum_id ]['can_delete'] && time() < $post_row['post_time'] + $xoopsModuleConfig['selfdellimit'] ? true : false ;
		} else {
			$can_edit = false ;
			$can_delete = false ;
		}
	}

	// from main/edit.php
	// check edit permission
	if( empty( $can_edit ) ) return false ;

	// check edit permission
	if( ! $uid ) {
		// guest edit (TODO)
		return false ;
	} else if( $isadminormod ) {
		// admin edit
		// ok
	} else if( $uid == $post_row['uid'] && $xoopsModuleConfig['selfeditlimit'] > 0 ) {
		// self edit
		if( time() < $post_row['post_time'] + intval( $xoopsModuleConfig['selfeditlimit'] ) ) {
			// before time limit
			// all green for self edit
		} else {
			// after time limit
			return false ;
		}
	} else {
		// no perm
		return false ;
	}

	return true;
}


function attachfile_check_download_permission_plugin( $target_id )
{
	global $xoopsUser , $xoopsDB ;

	// emulate d3forum
	$mytrustdirname = $this->target_trustdirname ;
	$mytrustdirpath = XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname ;
	$mydirname = $this->target_dirname ;

	//include_once $mytrustdirpath.'/include/main_functions.php' ;

	// from include/common_prepend.php
	// GET $uid
	$uid = is_object( @$xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;
	$isadmin = $uid > 0 ? $xoopsUser->isAdmin() : false ;
	if( $isadmin ) {
		$whr_topic = "t.topic_id=p.topic_id";
	} else {
		$whr_topic = "(t.topic_id=p.topic_id AND ! t.topic_invisible )";
	}
	// get this user's permissions as perm array
	$forum_permissions = $this->attachfile_get_forums_can_read( $mydirname , $uid ) ;
	$whr_forum = 'f.forum_id IN (' . implode( "," , $forum_permissions ) . ')' ;

	// from include/viewpost.php
	$post_id = intval( $target_id ) ;

	    $sql = "SELECT p.post_id, t.topic_external_link_id, f.forum_external_link_format 
		FROM ".$xoopsDB->prefix($mydirname."_posts")." p 
		INNER JOIN ".$xoopsDB->prefix($mydirname."_topics")." t ON ".$whr_topic." 
		INNER JOIN ".$xoopsDB->prefix($mydirname."_forums")." f ON (f.forum_id=t.forum_id AND ".$whr_forum.") 
		WHERE p.post_id='".$post_id."'";

	$result = $xoopsDB->query($sql);

	if( $xoopsDB->getRowsNum( $result ) <= 0 ) { return false ; }
	
	// check comment integrated module's permission
	$dbdat = $xoopsDB->fetchArray( $result ) ;
	if( (int)$dbdat['topic_external_link_id'] > 0 && !empty($dbdat['forum_external_link_format'])) {

		// d3comment object
		$d3com_obj = & $this->d3forum_get_comment_object( $mydirname , $dbdat['forum_external_link_format'] ) ;

		if( is_object( $d3com_obj ) ) {
			$external_link_id = (int)$dbdat['topic_external_link_id'];
			if( ( $external_link_id = $d3com_obj->validate_id( $external_link_id ) ) === false ) {
				return false;
			}
		}
	}

	return true;
}

function attachfile_get_forums_can_read( $forum_dirname, $uid=0 )
{
	global $xoopsUser , $xoopsDB ;

	if( is_object( $xoopsUser ) ) {
		//$uid = intval( $xoopsUser->getVar('uid') ) ;
		$groups = $xoopsUser->getGroups() ;
		if( ! empty( $groups ) ) {
			$whr4forum = "fa.`uid`=$uid || fa.`groupid` IN (".implode(",",$groups).")" ;
			$whr4cat = "`uid`=$uid || `groupid` IN (".implode(",",$groups).")" ;
		} else {
			$whr4forum = "fa.`uid`=$uid" ;
			$whr4cat = "`uid`=$uid" ;
		}
	} else {
		$whr4forum = "fa.`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
		$whr4cat = "`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
	}

	// get categories
	$sql = "SELECT distinct cat_id FROM ".$xoopsDB->prefix($forum_dirname."_category_access")." WHERE ($whr4cat)" ;
	$result = $xoopsDB->query( $sql ) ;
	if( $result ) while( list( $cat_id ) = $xoopsDB->fetchRow( $result ) ) {
		$cat_ids[] = intval( $cat_id ) ;
	}
	if( empty( $cat_ids ) ) return array(0) ;

	// get forums
	$sql = "SELECT distinct f.forum_id 
	FROM ".$xoopsDB->prefix($forum_dirname."_forums")." f 
	LEFT JOIN ".$xoopsDB->prefix($forum_dirname."_forum_access")." fa 
	ON fa.forum_id=f.forum_id 
	WHERE ($whr4forum) AND f.cat_id IN (".implode(',',$cat_ids).')' ;
	
	$result = $xoopsDB->query( $sql ) ;
	if( $result ) while( list( $forum_id ) = $xoopsDB->fetchRow( $result ) ) {
		$forums[] = intval( $forum_id ) ;
	}

	if( empty( $forums ) ) return array(0) ;
	else return $forums ;
}

function &d3forum_get_comment_object( $forum_dirname, $external_link_format )
{
	$params['forum_dirname'] = $forum_dirname ;

	@list( $params['external_dirname'] , $params['classname'] , $params['external_trustdirname'] ) 
		= explode( '::' , $external_link_format ) ;

	$this->d3comObj =& D3commentObj::getInstance ( $params ) ;
	
	return $this->d3comObj->d3comObj ;
}
   
} // end class d3forumAttachfilePlugin

// a class for Attachfile plugin D3comment Authorization
if( ! class_exists( 'attachfileD3commentObj' ) ) {
class attachfileD3commentObj {

var $d3comObj = null ;

function attachfileD3commentObj($params )
//  $params['forum_dirname'] , $params['external_dirname'] , $params['classname'] , $params['external_trustdirname']
{
	//$this->mPlug = & $parentObj;
	$mytrustdirpath = XOOPS_TRUST_PATH.'/modules/'.$params['external_trustdirname'] ;

	if( empty( $params['classname'] ) ) {
		include_once $mytrustdirpath.'/class/D3commentAbstract.class.php' ;
		$this->d3comObj =& new D3commentAbstract( $forum_dirname , '' ) ;
	}

	// search the class file
	$class_bases = array(
		XOOPS_ROOT_PATH.'/modules/'.$params['external_dirname'].'/class' ,
		XOOPS_TRUST_PATH.'/modules/'.$params['external_trustdirname'].'/class' ,
		XOOPS_TRUST_PATH.'/modules/d3forum/class' ,
	) ;

	foreach( $class_bases as $class_base ) {
		if( file_exists( $class_base.'/'.$params['classname'].'.class.php' ) ) {
			require_once $class_base.'/'.$params['classname'].'.class.php' ;
			break ;
		}
	}

	// check the class
	if( ! $params['classname'] || ! class_exists( $params['classname'] ) ) {
		include_once $mytrustdirpath.'/class/D3commentAbstract.class.php' ;
		$this->d3comObj =& new attachfileD3commentAbstract( $params['forum_dirname'] , $params['external_dirname'] ) ;
	}

	$this->d3comObj =& new $params['classname']( $params['forum_dirname'] , 
			$params['external_dirname'] , $params['external_trustdirname'] ) ;
}

function & getInstance( $params )
{
	$external_dirname = $params['external_dirname'] ;

	static $instance ;
	if( ! isset( $instance[$external_dirname] ) ) {
		$instance[$external_dirname] = & new attachfileD3commentObj( $params ) ;
	}
	return $instance[$external_dirname] ;
}
} // end class D3commentAuth 
}

?>
