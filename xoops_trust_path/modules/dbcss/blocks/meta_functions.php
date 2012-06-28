<?php

if (! function_exists('b_dbcss_metahook_show')) {
	function b_dbcss_metahook_show( $options )
	{
		require_once dirname(dirname(__FILE__)).'/include/main_functions.php' ;
		$mydirname = empty( $options[0] ) ? 'dbcss' : $options[0] ;
		global $xoopsModule;

		if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

		$dirname = is_object( @$xoopsModule ) ? $xoopsModule->getVar('dirname') : '' ;

		if( ! empty( $dirname ) ){
			$module_handler =& xoops_gethandler('module');
			$xoopsModule =& $module_handler->getByDirname( $dirname );
			$mid =& $xoopsModule->getVar('mid');

			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname($mydirname);
			$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );
			$meta_data_cashe = intval( @$mod_config['meta_data_cashe'] ) ;

			if( ! empty( $meta_data_cashe ) ){
				$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
				$metalink_cache = XOOPS_TRUST_PATH.'/cache/'.$mydirname.'_metalink_'.$mid.'_'.$site_salt.'.php' ;
			}

			if( ! empty( $meta_data_cashe ) && file_exists( $metalink_cache ) ){
				@include $metalink_cache ;
				$metakey = $metakey ? dbcss_toShow( $metakey ) : 0 ;
				$metadesc = $metadesc ? dbcss_toShow( $metadesc ) : 0 ;
				$robots = $robots ? dbcss_toShow( $robots ) : 0 ;
				$rating = $rating ? dbcss_toShow( $rating ) : 0 ;
				$author = $author ? dbcss_toShow( $author ) : 0 ;
			} else {
				$db =& Database::getInstance();
				$sql = "SELECT metakey, metadesc, robots, rating, author FROM ".$db->prefix( $mydirname."_metalink" )." WHERE lid = $mid";
				$result = $db->query( $sql );
				while( list( $key, $des, $rob, $rat, $aut ) = $db->fetchRow( $result ) ) {
					$metakey = dbcss_toShow( $key ) ;
					$metadesc = dbcss_toShow( $des ) ;
					$robots = dbcss_toShow( $rob ) ;
					$rating = dbcss_toShow( $rat ) ;
					$author = dbcss_toShow( $aut ) ;
				}
			}
			global $xoopsTpl;

			if( ! empty( $metakey )){
				$xoops_meta_keywords = $metakey;
				$xoopsTpl->assign('xoops_meta_keywords', $xoops_meta_keywords);
			}

			if( ! empty( $metadesc )){
				$xoops_meta_description = $metadesc;
				$xoopsTpl->assign('xoops_meta_description', $xoops_meta_description);
			}

			if( ! empty( $robots )){
				$xoops_meta_robots = $robots;
				$xoopsTpl->assign('xoops_meta_robots', $xoops_meta_robots);
			}

			if( ! empty( $rating )){
				$xoops_meta_rating = $rating;
				$xoopsTpl->assign('xoops_meta_rating', $xoops_meta_rating);
			}

			if( ! empty( $author )){
				$xoops_meta_author = $author;
				$xoopsTpl->assign('xoops_meta_author', $xoops_meta_author);
			}
		}
	}
}

