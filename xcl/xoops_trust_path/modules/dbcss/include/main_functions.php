<?php

// CSS PART
if (! function_exists('dbcss_dbmoduleheader')) {
	function dbcss_dbmoduleheader( $mydirname , $this_template , $selected_media )
	{
		if ( strstr ( $this_template , $mydirname.'_' )){
			$css_string = explode($mydirname.'_',$this_template, 2 ) ;
			$css_file = $css_string[1];
		} else {
			$css_file = $this_template;
		}

		$css_name = XOOPS_URL.'/modules/'.$mydirname.'/index.php?css='.$css_file ;
		$header = '<link rel="stylesheet" type="text/css" media="'.$selected_media.'" href="'.$css_name.'" />'."\n" ;

		return $header ;
	}
}

if (! function_exists('dbcss_moduleheader')) {
	function dbcss_moduleheader( $mydirname , $css_name , $selected_media )
	{
		if ( preg_match ("/([^\s]*)+\.css$/i", $css_name ) ) {
			$header = '<link rel="stylesheet" type="text/css" media="'.$selected_media.'" href="'.$css_name.'" />'."\n" ;
			$searches = array() ;
			$replacements = array() ;
			$searches = array( '{mod_url}' , '&lt;{$mod_url}&gt;' , '&lt;{$mydirname}&gt;' , '{X_SITEURL}' , '&lt;{$xoops_url}&gt;' ) ;
			$replacements = array( XOOPS_URL.'/modules/'.$mydirname , XOOPS_URL.'/modules/'.$mydirname , $mydirname , XOOPS_URL.'/' , XOOPS_URL ) ;

			return str_replace( $searches , $replacements , $header ) ;
		}
	}
}

if (! function_exists('dbcss_gettplname')) {
	function dbcss_gettplname( $mydirname )
	{
		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		$tplfile = array() ;
		$result = $db->query( "SELECT tpl_id, tpl_file, tpl_module FROM ".$db->prefix("tplfile")." WHERE tpl_file LIKE '%.css' AND tpl_module=\"".$mydirname."\" ORDER BY tpl_id DESC" ) ;
		while( list( $id, $sbj ) = $db->fetchRow( $result ) ) {
			$name_string = $myts->makeTboxData4Show( $sbj ) ;
			$name_string = explode($mydirname.'_',$name_string ,2 ) ;
			$tplfile[ $sbj ] = $name_string[1];
		}
		return $tplfile ;
	}
}

if (! function_exists('dbcss_getimport_tplsets')) {
	function dbcss_getimport_tplsets()
	{
		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		$import_tplsets = array() ;
		$import_tplsets = array( 0 => '--' ) ;
		$result = $db->query("SELECT tplset_id, tplset_name FROM ".$db->prefix( "tplset" )." WHERE tplset_name NOT IN( 'default' )");

		while( list( $id , $title ) = $db->fetchRow( $result ) ) {
			$import_tplsets[ $title ] = $myts->makeTboxData4Show( $title ) ;
		}
		return $import_tplsets ;
	}
}

if (! function_exists('dbcss_copy_tplsets')) {
	function dbcss_copy_tplsets()
	{
		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		$copy_tplsets = array() ;
		$copy_tplsets = array( 0 => '--' ) ;
		$result = $db->query("SELECT tplset_id, tplset_name FROM ".$db->prefix( "tplset" )."");

		while( list( $id , $title ) = $db->fetchRow( $result ) ) {
			$copy_tplsets[ $title ] = $myts->makeTboxData4Show( $title ) ;
		}
		return $copy_tplsets ;
	}
}

if (! function_exists('dbcss_getdelete_btn')) {
	function dbcss_getdelete_btn( $mydirname )
	{
		$db =& Database::getInstance();
		$sql = "SELECT COUNT(*) FROM ".$db->prefix("tplfile")." WHERE tpl_file LIKE '%.css' AND tpl_module='$mydirname' AND tpl_tplset NOT IN( 'default' )" ;
		list( $count ) = $db->fetchRow( $db->query( $sql ) );
		if( empty( $count ) ){
			$getdelete_btn = TRUE ;
		} else {
			$getdelete_btn = FALSE ;
		}
		return $getdelete_btn ;
	}
}

// META TAG PART

if (! function_exists('dbcss_getmodulelist')) {
	function dbcss_getmodulelist( $mydirname, $limit, $offset )
	{
		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();
		$module_list = array() ;

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname($mydirname);
		$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
		$meta_data_cashe = intval( @$mod_config['meta_data_cashe'] ) ;
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;

		$sql = "SELECT mid, name, dirname, isactive, hasmain FROM ".$db->prefix( "modules" )." WHERE isactive = 1 AND hasmain= 1 ORDER BY mid" ;
		$result = $db->query( $sql, $limit, $offset );
		while( list( $mid, $name, $dirname) = $db->fetchRow( $result ) ) {
			$cachetime = '';
			$metadata = '';
			$mid = intval( $mid ) ;
			if( ! empty( $meta_data_cashe ) ){
				$metalink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_metalink_'.$mid.'_'.$site_salt.'.php' ;

				if( file_exists( $metalink_cache ) ){
					$cachetime = date('Y.m.d H:i:s', filemtime( $metalink_cache ));
				}
			}
			$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_metalink")." WHERE lid='".$mid."'";
			list($count) = $db->fetchRow( $db->query( $sql ) );
			if( $count > 0 ){
				$metadata = true ;
			}

			$module_list[] = array(
				'mid' => $mid ,
				'name' => $myts->makeTboxData4Show( $name ) ,
				'dirname' => $myts->makeTboxData4Show( $dirname ) ,
				'metadata' => $metadata ,
				'cachetime' => $cachetime ,
			) ;
		}
		return $module_list ;
	}
}

if (! function_exists('dbcss_totalmodulelist')) {
	function dbcss_totalmodulelist()
	{
		$db =& Database::getInstance();
		$sql = "SELECT COUNT(*) FROM ".$db->prefix( "modules" )." WHERE isactive = 1 AND hasmain= 1";
		list($count) = $db->fetchRow( $db->query( $sql ) );

		return $count ;
	}
}

if (! function_exists('dbcss_items_perpage')) {
	function dbcss_items_perpage()
	{
		return array(
			'10' => '10' ,
			'20' => '20' ,
			'30' => '30' ,
			'40' => '40' ,
			'50' => '50' ,
		) ;
	}
}

if (! function_exists('dbcss_getmetadata')) {
	function dbcss_getmetadata( $mydirname , $meta_lid )
	{
		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$metalink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_metalink_'.$meta_lid.'_'.$site_salt.'.php' ;

		if( file_exists( $metalink_cache ) ){
			$cachetime = date('Y.m.d H:i:s', filemtime( $metalink_cache ));
		}

		$metadata4assign = array();
		$result = $db->query("SELECT metakey, metadesc, robots, rating, author FROM ".$db->prefix( $mydirname."_metalink" )." WHERE lid = $meta_lid");
		while( list( $metakey, $metadesc, $robots, $rating, $author) = $db->fetchRow( $result ) ) {
			$metadata4assign = array(
				'metakey' => $myts->makeTboxData4Edit( $metakey ) ,
				'metadesc' => $myts->makeTboxData4Edit( $metadesc ) ,
				'robots' => $myts->makeTboxData4Edit( $robots ) ,
				'rating' => $myts->makeTboxData4Edit( $rating ) ,
				'author' => $myts->makeTboxData4Edit( $author ) ,
				'cachetime' => $cachetime ,
			) ;
		}
		return $metadata4assign ;
	}
}

if (! function_exists('dbcss_list_robots')) {
	function dbcss_list_robots()
	{
		return array(
			'' => '----' ,
			'index,follow' => 'index,follow' ,
			'noindex,follow' => 'noindex,follow' ,
			'index,nofollow' => 'index,nofollow' ,
			'noindex,nofollow' => 'noindex,nofollow' ,
		) ;
	}
}

if (! function_exists('dbcss_list_rating')) {
	function dbcss_list_rating()
	{
		return array(
			'' => '----' ,
			'general' => 'general' ,
			'14 years' => '14 years' ,
			'restricted' => 'restricted' ,
			'mature' => 'mature' ,
		) ;
	}
}

if (! function_exists('dbcss_toShow')) {
	function dbcss_toShow($text, $x2comat=false) {
		if ($x2comat) {
			return preg_replace(array("/&amp;(#[0-9]+|#x[0-9a-f]+|[a-z]+[0-9]*);/i", "/&nbsp;/i"), array('&\\1;', '&amp;nbsp;'), htmlspecialchars($text, ENT_QUOTES));
		} else {
			return preg_replace("/&amp;(#[0-9]+|#x[0-9a-f]+|[a-z]+[0-9]*);/i", '&\\1;', htmlspecialchars($text, ENT_QUOTES));
		}
	}
}

// SCRIPT TAG PART

if (! function_exists('dbcss_getscriptlist')) {
	function dbcss_getscriptlist( $mydirname )
	{
		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		$scriptlist = array();
		$result = $db->query("SELECT * FROM ".$db->prefix( $mydirname."_scriptbody" )." ORDER BY lid");
		while( list( $lid, $title, $created ) = $db->fetchRow( $result ) ) {
			$cachetime = '';
			$lid = intval( $lid ) ;
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			$scriptlink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_scriptlink_'.$lid.'_'.$site_salt.'.php' ;
			if( file_exists( $scriptlink_cache ) ){
				$cachetime = date('Y.m.d H:i:s', filemtime( $scriptlink_cache ));
			} else {
				$cachetime = "";
			}

			$scriptlist[] = array(
				'lid' => $lid ,
				'title' => $myts->makeTboxData4Show( $title ) ,
				'created' => date( 'Y.m.d H:i:s', $created ),
				'cachetime' => $cachetime ,
			) ;
		}
		return $scriptlist ;
	}
}

if (! function_exists('dbcss_getscriptdata')) {
	function dbcss_getscriptdata( $mydirname , $script_lid )
	{
		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();

		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		$scriptlink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_scriptlink_'.$script_lid.'_'.$site_salt.'.php' ;

		if( file_exists( $scriptlink_cache ) ){
			$cachetime = date('Y.m.d H:i:s', filemtime( $scriptlink_cache ));
		} else {
			$cachetime = "";
		}

		$scriptlist = array();
		$result = $db->query("SELECT * FROM ".$db->prefix( $mydirname."_scriptbody" )." WHERE lid = $script_lid");
		
		while( list( $lid, $title, $created, $body, $css ) = $db->fetchRow( $result ) ) {
			$scriptlist = array(
				'lid' => intval( $lid ) ,
				'title' => $myts->makeTboxData4Edit( $title ) ,
				'created' => date('Y.m.d H:i:s', $created),
				'body' => $myts->makeTboxData4Edit( $body ) ,
				'css' => $myts->makeTboxData4Edit( $css ) ,
				'cachetime' => $cachetime ,
			) ;
		}
		return $scriptlist ;
	}
}

if (! function_exists('dbcss_scriptdatashow')) {
	function dbcss_scriptdatashow( $text )
	{
		$script_tag = array();
		$urls = preg_split( "/[\s]+/", $text );
		foreach( $urls as $svr ) {
			if( empty( $svr ) ) break ;
			// IT IS A BREAK IF THERE IS URL FOR SECURITY.
			if ( preg_match ("/(['\"]?)(http[s]?:\/\/[^\"'<>]*)/i", $svr ) ) {
				unset( $svr );
				break ;
			} elseif ( strstr ( $svr , '.js' ) ){
				$script_tag[] = '<script type="text/javascript" src="'.XOOPS_URL.'/'.$svr.'"></script>';
			} elseif ( strstr ( $svr , '.css' ) ){
				$script_tag[] = '<link rel="stylesheet" href="'.XOOPS_URL.'/'.$svr.'" type="text/css" media="screen" />';
			} else {
				unset( $svr );
				break ;
			}
		}
		return implode( "\n", $script_tag );
	}
}

?>