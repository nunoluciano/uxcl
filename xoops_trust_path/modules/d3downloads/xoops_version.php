<?php

// language file (modinfo.php)
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname , false ) ;

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$modversion['name'] = $mydirname ;
$modversion['version'] = 1.48 ;
$modversion['description'] = constant($constpref.'_DESC') ;
$modversion['credits'] = "Xoops X(ten) Team and photosite";
$modversion['author'] = "Xoops X(ten) Team based by photosite(http://www.photositelinks.com/)" ;
$modversion['help'] = "" ;
$modversion['license'] = "GPL" ;
$modversion['official'] = 0 ;
$modversion['image'] = file_exists( $mydirpath.'/module_icon.png' ) ? 'module_icon.png' : 'module_icon.php' ;
$modversion['dirname'] = $mydirname ;

// Any tables can't be touched by modulesadmin.
$modversion['sqlfile'] = false ;
$modversion['tables'] = array() ;

// Admin things
$modversion['hasAdmin'] = 1 ;
$modversion['adminindex'] = 'admin/index.php' ;
$modversion['adminmenu'] = 'admin/admin_menu.php' ;

// Search
$modversion['hasSearch'] = 1 ;
$modversion['search']['file'] = 'search.php' ;
$modversion['search']['func'] = $mydirname.'_global_search' ;

// Menu
$modversion['hasMain'] = 1 ;

// Submenu (just for mainmenu)
require_once dirname(__FILE__).'/include/common_functions.php' ;
$i= 1 ;

$submenu_option = d3download_get_submenu_option( $mydirname ) ;

if( is_object( @$GLOBALS['xoopsModule'] ) && $GLOBALS['xoopsModule']->getVar('dirname') == $mydirname ) {
	$submenu = d3download_submenu( $mydirname, $submenu_option ) ;
	if( ! empty( $submenu ) ) foreach( $submenu as $categories ) {
		$modversion['sub'][$i]['name'] = $categories['name'];
		$modversion['sub'][$i]['url']  = $categories['url'];
		$i++;
	}
}

if( d3download_submenu_option( $submenu_option, 'topten_hit' ) ){
	$modversion['sub'][$i]['name'] = constant($constpref.'_SMNAME1');
	$modversion['sub'][$i]['url']  = 'index.php?page=topten&amp;hit=1';
	$i++;
}

if( d3download_submenu_option( $submenu_option, 'topten_rate' ) ){
	$modversion['sub'][$i]['name'] = constant($constpref.'_SMNAME2');
	$modversion['sub'][$i]['url']  = 'index.php?page=topten&amp;rate=1';
	$i++;
}

if( d3download_submenu_option( $submenu_option, 'filelist' ) ){
	$modversion['sub'][$i]['name'] = constant($constpref.'_SMNAME3');
	$modversion['sub'][$i]['url']  = 'index.php?page=filelist';
}

// All Templates can't be touched by modulesadmin.
$modversion['templates'] = array() ;

// Blocks
$modversion['blocks'] = array() ;
$modversion['blocks'][1] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_RECENT') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_recent_show' ,
	'edit_func'		=> 'b_d3downloads_recent_edit' ,
	'options'		=> "$mydirname|10|25|Y/m/d|1|" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][2] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_TOPRANK') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_toprank_show' ,
	'edit_func'		=> 'b_d3downloads_toprank_edit' ,
	'options'		=> "$mydirname||d.hits DESC|10|25|Y/m/d|1||0" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][3] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_DOWNLOAD') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_download_show' ,
	'edit_func'		=> 'b_d3downloads_download_edit' ,
	'options'		=> "$mydirname||" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][4] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_LIST') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_list_show' ,
	'edit_func'		=> 'b_d3downloads_list_edit' ,
	'options'		=> "$mydirname||d.date DESC|10|Y/m/d|0|||0" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][5] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_MYLINK') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_mylink_show' ,
	'edit_func'		=> 'b_d3downloads_mylink_edit' ,
	'options'		=> "$mydirname||0|d.date DESC|10|25|Y/m/d|1|" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][6] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_PICKUP') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_pickup_show' ,
	'edit_func'		=> 'b_d3downloads_pickup_edit' ,
	'options'		=> "$mydirname||d.date DESC|10|25|Y/m/d|1|" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

$modversion['blocks'][7] = array(
	'file'			=> 'blocks.php' ,
	'name'			=> constant($constpref.'_BNAME_CATEGORY') ,
	'description'	=> '' ,
	'show_func'		=> 'b_d3downloads_category_show' ,
	'edit_func'		=> 'b_d3downloads_category_edit' ,
	'options'		=> "$mydirname|0|1|" ,
	'template'		=> '' , // use "module" template instead
	'can_clone'		=> true ,
) ;

// Comments
$modversion['hasComments'] = 0 ;

// Configs
$modversion['config'][1] = array(
	'name'			=> 'popular' ,
	'title'			=> $constpref.'_POPULAR' ,
	'description'	=> $constpref.'_POPULARDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '100' ,
	'options'		=> array('5' => 5, '10' => 10, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000)
) ;
$modversion['config'][] = array(
	'name'			=> 'newdownloads' ,
	'title'			=> $constpref.'_NEWDLS' ,
	'description'	=> $constpref.'_NEWDLSDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '10' ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50)
) ;
$modversion['config'][] = array(
	'name'			=> 'newmark' ,
	'title'			=> $constpref.'_NEWMARK' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '10' ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50)
) ;
$modversion['config'][] = array(
	'name'			=> 'perpage' ,
	'title'			=> $constpref.'_PERPAGE' ,
	'description'	=> $constpref.'_PERPAGEDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> '10' ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50)
) ;
$modversion['config'][] = array(
	'name'			=> 'order' ,
	'title'			=> $constpref.'_ORDER' ,
	'description'	=> $constpref.'_ORDERSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'd.title ASC' ,
	'options' 		=> array(constant($constpref. '_POPULARITYLTOM') => 'd.hits ASC' ,
    						 constant($constpref. '_POPULARITYMTOL') => 'd.hits DESC' ,
     						 constant($constpref. '_TITLEATOZ') => 'd.title ASC',
     						 constant($constpref. '_TITLEZTOA') => 'd.title DESC',
     						 constant($constpref. '_DATEOLD') => 'd.date ASC' ,
      						 constant($constpref. '_DATENEW') => 'd.date DESC',
    						 constant($constpref. '_RATINGLTOH') => 'd.rating ASC' ,
    						 constant($constpref. '_RATINGHTOL') => 'd.rating DESC'
						 )
) ;
$modversion['config'][] = array(
	'name'			=> 'top_message' ,
	'title'			=> $constpref.'_TOP_MESSAGE' ,
	'description'	=> '' ,
	'formtype'		=> 'textarea' ,
	'valuetype'		=> 'text' ,
	'default'		=> constant($constpref.'_TOP_MESSAGEDEFAULT') ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'show_breadcrumbs' ,
	'title'			=> $constpref.'_BREADCRUMBS' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'show_postname' ,
	'title'			=> $constpref.'_POSTNAME' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'show_mypost' ,
	'title'			=> $constpref.'_MYPOST' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'useshots' ,
	'title'			=> $constpref.'_USESHOTS' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'usealbum' ,
	'title'			=> $constpref.'_USEALBUM' ,
	'description'	=> $constpref.'_USEALBUMDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'album_module_select' ,
	'title'			=> $constpref.'_MODULESELECT' ,
	'description'	=> $constpref.'_ALBUMMODULEDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'myAlbum-P' ,
	'options'		=> array( 'myAlbum-P' => 'myAlbum-P' , 'GnaviD3' => 'GnaviD3', 'webphoto' => 'webphoto' )
) ;
$modversion['config'][] = array(
	'name'			=> 'albumselect' ,
	'title'			=> $constpref.'_ALBUMSELECT' ,
	'description'	=> $constpref.'_ALBUMSELECTDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'txt' ,
	'default'		=>  '' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'shotselect' ,
	'title'			=> $constpref.'_SHOTSSELECT' ,
	'description'	=> $constpref.'_SHOTSSELECTDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'shotwidth' ,
	'title'			=> $constpref.'_SHOTWIDTH' ,
	'description'	=> $constpref.'_SHOTWIDTHDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> 128 ,
	'options'		=> array('256' => 256,'128' => 128, '90' => 90, '60' => 60)
) ;
$modversion['config'][] = array(
	'name'			=> 'plus_posts' ,
	'title'			=> $constpref.'_PLUSPOSTS' ,
	'description'	=> $constpref.'_PLUSPOSTSDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'check_url' ,
	'title'			=> $constpref.'_CHECKURL' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'check_host' ,
	'title'			=> $constpref.'_CHECKHOST' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$xoops_url = parse_url(XOOPS_URL);
$modversion['config'][] = array(
	'name'			=> 'referers' ,
	'title'			=> $constpref.'_REFERERS' ,
	'description'	=> $constpref.'_REFERERSDSC' ,
	'formtype'		=> 'textarea' ,
	'valuetype'		=> 'array' ,
	'default'		=> array($xoops_url['host']) ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'allow_extension' ,
	'title'			=> $constpref.'_EXTENSION' ,
	'description'	=> $constpref.'_EXTENSIONDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'zip|tgz|lzh|cab|bz2|xls|doc|pdf' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'maxfilesize' ,
	'title'			=> $constpref.'_MAXFILESIZE' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1000' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'check_multiple_dot' ,
	'title'			=> $constpref.'_MULTIDOT' ,
	'description'	=> $constpref.'_MULTIDOTDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'validate_of_head' ,
	'title'			=> $constpref.'_CHECKHEAD' ,
	'description'	=> $constpref.'_CHECKHEADDSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'css_uri' ,
	'title'			=> $constpref.'_CSS_URI' ,
	'description'	=> $constpref.'_CSS_URIDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '{mod_url}/index.php?page=module_header&src=main.css' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'live_uri' ,
	'title'			=> $constpref.'_LIVE_URI' ,
	'description'	=> $constpref.'_LIVE_URIDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '{mod_url}/index.php?page=module_header&src=livevalidation.css' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'body_editor' ,
	'title'			=> $constpref.'_EDITOR' ,
	'description'	=> $constpref.'_EDITORDSC' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'xoopsdhtml' ,
	'options'		=> array( 'xoopsdhtml' => 'xoopsdhtml' , 'common/fckeditor' => 'common_fckeditor' )
) ;
$modversion['config'][] = array(
	'name'			=> 'use_htmlpurifier' ,
	'title'			=> $constpref.'_HTMLPR_EXCEPT' ,
	'description'	=> $constpref.'_HTMLPR_EXCEPTDSC' ,
	'formtype'		=> 'group_multi' ,
	'valuetype'		=> 'array' ,
	'default'		=> array() ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'select_platform' ,
	'title'			=> $constpref.'_PLATFORM' ,
	'description'	=> $constpref.'_PLATFORMDSC' ,
	'formtype'		=> 'textarea' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'Windows|Unix|Mac|Xoops 2.0x|XOOPS Cube Legacy 2.1x' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'use_license' ,
	'title'			=> $constpref.'_USELICENSE' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 1 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'select_license' ,
	'title'			=> $constpref.'_LICENSE' ,
	'description'	=> $constpref.'_LICENSEDSC' ,
	'formtype'		=> 'textarea' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'BSD License|Common Public License|GPL v. 1.0|GPL v. 2.0|LGPL v. 2.1|LGPL v. 2.0' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'use_tell_a_frined' ,
	'title'			=> $constpref.'_TELLAFRINED' ,
	'description'	=> '' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> 0 ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'per_rss' ,
	'title'			=> $constpref.'_PER_RSS' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> 10 ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50)
) ;
$modversion['config'][] = array(
	'name'			=> 'history' ,
	'title'			=> $constpref.'_PER_HISTORY' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'int' ,
	'default'		=> 10 ,
	'options'		=> array('5' => 5, '10' => 10, '15' => 15, '20' => 20)
) ;
$modversion['config'][] = array(
	'name'			=> 'comment_dirname' ,
	'title'			=> $constpref.'_COM_DIRNAME' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'comment_forum_id' ,
	'title'			=> $constpref.'_COM_FORUM_ID' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '0' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'comment_view' ,
	'title'			=> $constpref.'_COM_VIEW' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'listposts_flat' ,
	'options'		=> array( '_FLAT' => 'listposts_flat' , '_THREADED' => 'listtopics' )
) ;
$modversion['config'][] = array(
	'name'			=> 'comment_order' ,
	'title'			=> $constpref.'_COM_ORDER' ,
	'description'	=> '' ,
	'formtype'		=> 'select' ,
	'valuetype'		=> 'text' ,
	'default'		=> 'desc' ,
	'options'		=> array( '_OLDESTFIRST' => 'asc' , '_NEWESTFIRST' => 'desc' )
) ;
$modversion['config'][] = array(
	'name'			=> 'comment_posts_num' ,
	'title'			=> $constpref.'_COM_POSTSNUM' ,
	'description'	=> '' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'int' ,
	'default'		=> '10' ,
	'options'		=> array()
) ;
$cron_pass = substr( md5( XOOPS_URL ) , -6 ) ;
$modversion['config'][] = array(
	'name'			=> 'cron_pass' ,
	'title'			=> $constpref.'_CRON_PASS' ,
	'description'	=> $constpref.'_CRONPASSDSC' ,
	'formtype'		=> 'textbox' ,
	'valuetype'		=> 'text' ,
	'default'		=> $cron_pass ,
	'options'		=> array()
) ;


// Notification
$modversion['hasNotification'] = 1;
$modversion['notification'] = array(
	'lookup_file' => 'notification.php' ,
	'lookup_func' => "{$mydirname}_notify_iteminfo" ,
	'category' => array(
		array(
			'name' => 'category' ,
			'title' => constant($constpref.'_NOTCAT_CAT') ,
			'description' => constant($constpref.'_NOTCAT_CATDSC') ,
			'subscribe_from' => 'index.php' ,
			'item_name' => 'cid' ,
			'allow_bookmark' => 1 ,
		) ,
		array(
			'name' => 'file' ,
			'title' => constant($constpref.'_NOTCAT_FILE') ,
			'description' => constant($constpref.'_NOTCAT_FILEDSC') ,
			'subscribe_from' => array('index.php', 'singlefile.php') ,
			//'subscribe_from' => 'index.php' ,
			'item_name' => 'lid' ,
		) ,
		array(
			'name' => 'global' ,
			'title' => constant($constpref.'_NOTCAT_GLOBAL') ,
			'description' => constant($constpref.'_NOTCAT_GLOBALDSC') ,
			'subscribe_from' => 'index.php' ,
		) ,
	) ,
	'event' => array(
		array(
			'name' => 'newpost' ,
			'category' => 'category' ,
			'title' => constant($constpref.'_NOTIFY_CAT_NEWPOST') ,
			'caption' => constant($constpref.'_NOTIFY_CAT_NEWPOSTCAP') ,
			'description' => constant($constpref.'_NOTIFY_CAT_NEWPOSTCAP') ,
			'mail_template' => 'category_newpost' ,
			'mail_subject' => constant($constpref.'_NOTIFY_CAT_NEWPOSTSBJ') ,
		) ,
		array(
			'name' => 'newpostfull' ,
			'category' => 'category' ,
			'title' => constant($constpref.'_NOTIFY_CAT_NEWPOSTFULL') ,
			'caption' => constant($constpref.'_NOTIFY_CAT_NEWPOSTFULLCAP') ,
			'description' => constant($constpref.'_NOTIFY_CAT_NEWPOSTFULLCAP') ,
			'mail_template' => 'category_newpostfull' ,
			'mail_subject' => constant($constpref.'_NOTIFY_CATL_NEWPOSTFULLSBJ') ,
		) ,
		array(
			'name' => 'newpost' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_NEWPOST') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP') ,
			'mail_template' => 'global_newpost' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ') ,
		) ,
		array(
			'name' => 'newcategory' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_NEWCATEGORY') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYCAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYCAP') ,
			'mail_template' => 'global_newcategory' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYSBJ') ,
		) ,
		array(
			'name' => 'waiting' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_WAITING') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_WAITINGCAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_WAITINGCAP') ,
			'mail_template' => 'global_waiting' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ') ,
			'admin_only' => 1 ,
		) ,
		array(
			'name' => 'broken' ,
			'category' => 'global' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_BROKEN') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_BROKENCAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_BROKENCAP') ,
			'mail_template' => 'global_broken' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_BROKENSBJ') ,
			'admin_only' => 1 ,
		) ,
		array(
			'name' => 'approve' ,
			'category' => 'global' ,
			'invisible' => '1' ,
			'title' => constant($constpref.'_NOTIFY_GLOBAL_APPROVE') ,
			'caption' => constant($constpref.'_NOTIFY_GLOBAL_APPROVECAP') ,
			'description' => constant($constpref.'_NOTIFY_GLOBAL_APPROVECAP') ,
			'mail_template' => 'global_approve' ,
			'mail_subject' => constant($constpref.'_NOTIFY_GLOBAL_APPROVECAPSBJ') ,
		) ,
		array(
			'name' => 'comment' ,
			'category' => 'file' ,
			'title' => constant($constpref.'_NOTIFY_FILE_COMMENT') ,
			'caption' => constant($constpref.'_NOTIFY_FILE_COMMENTCAP') ,
			'description' => constant($constpref.'_NOTIFY_FILE_COMMENTCAP') ,
			'mail_template' => 'file_comment' ,
			'mail_subject' => constant($constpref.'_NOTIFY_FILE_COMMENTSBJ') ,
		) ,
	) ,
) ;

$modversion['onInstall'] = 'oninstall.php' ;
$modversion['onUpdate'] = 'onupdate.php' ;
$modversion['onUninstall'] = 'onuninstall.php' ;

// keep block's options
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) < 2.1 && ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] ) {
	include dirname(__FILE__).'/include/x20_keepblockoptions.inc.php' ;
}

?>