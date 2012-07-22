<?php

if ( ! function_exists('d3download_import_errordie') ) {
	function d3download_import_errordie( $mydirname )
	{
		include_once dirname( dirname(__FILE__) ).'/class/file_manager.php' ;
		$file_manager = new file_manager( $mydirname ) ;
		$file_manager->errordie() ;
	}
}

if ( ! function_exists('d3download_import_from_mydownloads') ) {
	function d3download_import_from_mydownloads( $mydirname , $import_mid )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;
		$import_mid = intval( $import_mid ) ;

		// get name of `contents` table 
		$module_handler =& xoops_gethandler( 'module' ) ;
		$module =& $module_handler->get( $import_mid ) ;
		//if( sizeof( $from_tables ) != 5 ) d3download_import_errordie( $mydirname ) ;
		$target_dirname = $module->getVar('dirname') ;

		// broken 
		$from_table = $db->prefix( $target_dirname.'_broken' ) ;
		$to_table = $db->prefix( $mydirname.'_broken' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		$irs = $db->query( "INSERT INTO `$to_table` (reportid,lid,sender,ip) SELECT reportid,lid,sender,ip FROM `$from_table`" ) ;
		if( ! $irs ) d3download_import_errordie( $mydirname ) ;

		// cat 
		$from_table = $db->prefix( $target_dirname.'_cat' ) ;
		$to_table = $db->prefix( $mydirname.'_cat' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		$irs = $db->query( "INSERT INTO `$to_table` (cid,pid,title,imgurl,cat_weight) SELECT cid,pid,title,imgurl,'0' FROM `$from_table`" ) ;
		if( ! $irs ) d3download_import_errordie( $mydirname ) ;

		// user_access 
		$to_table = $db->prefix( $mydirname.'_user_access' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		d3download_default_user_access( $mydirname );

		// downloads_history 
		$to_table = $db->prefix( $mydirname.'_downloads_history' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;

		// downloads 
		$from_table = $db->prefix( $target_dirname.'_downloads' ) ;
		$to_table = $db->prefix( $mydirname.'_downloads' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		$irs = $db->query( "INSERT INTO `$to_table` (lid,cid,title,url,homepage,version,size,platform,logourl,description, html, smiley, br, xcode,submitter,mail,date,hits,rating,votes,visible,cancomment,comments,kanrisya) SELECT lid,cid,title,url,homepage,version,size,platform,logourl,'','0','1','1','1',submitter,'',date,hits,rating,votes,'1','1',comments,'' FROM `$from_table`" ) ;
		if( ! $irs ) d3download_import_errordie( $mydirname ) ;

		// txt 
		$result = $db->query("SELECT lid, description FROM ".$db->prefix( $target_dirname."_text" )."");
		while( list( $id, $description ) = $db->fetchRow( $result ) ) {
			$lid = intval( $id );
			$body = addslashes( $description );
			$irs = $db->query( "UPDATE ".$db->prefix($mydirname."_downloads")." SET description = '".$body."' WHERE lid = '".$lid."'");
		}
		if( ! $irs ) d3download_import_errordie( $mydirname ) ;

		// votedata 
		$from_table = $db->prefix( $target_dirname.'_votedata' ) ;
		$to_table = $db->prefix( $mydirname.'_votedata' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		$irs = $db->query( "INSERT INTO `$to_table` (lid,ratinguser,rating,ratinghostname,ratingtimestamp) SELECT lid,ratinguser,rating,ratinghostname,ratingtimestamp FROM `$from_table`" ) ;
		if( ! $irs ) d3download_import_errordie( $mydirname ) ;

		// upload files delete
		d3download_delete_uploadfiles_for_import( $mydirname );
		// make serialize data
		include_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
		d3download_make_serialize_data( $mydirname );
		// cache files delete
		d3download_delete_cache_of_categories( $mydirname ) ;
	}
}

if ( ! function_exists('d3download_import_from_wfdownloads') ) {
	function d3download_import_from_wfdownloads( $mydirname , $import_mid )
	{
		$db =& Database::getInstance() ;
		$import_mid = intval( $import_mid ) ;

		// get name of `contents` table 
		$module_handler =& xoops_gethandler( 'module' ) ;
		$module =& $module_handler->get( $import_mid ) ;
		//if( sizeof( $from_tables ) != 5 ) d3download_import_errordie( $mydirname ) ;
		$target_dirname = $module->getVar('dirname') ;

		// broken 
		$from_table = $db->prefix( $target_dirname.'_broken' ) ;
		$to_table = $db->prefix( $mydirname.'_broken' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		$irs = $db->query( "INSERT INTO `$to_table` ( reportid,lid,sender,ip,date ) SELECT reportid,lid,sender,ip,date FROM `$from_table`" ) ;
		if( ! $irs ) d3download_import_errordie( $mydirname ) ;

		// cat 
		$from_table = $db->prefix( $target_dirname.'_cat' ) ;
		$to_table = $db->prefix( $mydirname.'_cat' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		$irs = $db->query( "INSERT INTO `$to_table` (cid,pid,title,imgurl,description,cat_weight) SELECT cid,pid,title,imgurl,description,weight FROM `$from_table`" ) ;
		if( ! $irs ) d3download_import_errordie( $mydirname ) ;

		// user_access 
		$to_table = $db->prefix( $mydirname.'_user_access' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		d3download_default_user_access( $mydirname );

		// downloads_history 
		$to_table = $db->prefix( $mydirname.'_downloads_history' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;

		// downloads 
		$from_table = $db->prefix( $target_dirname.'_downloads' ) ;
		$to_table = $db->prefix( $mydirname.'_downloads' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		$irs = $db->query( "INSERT INTO `$to_table` (lid,cid,title,url,filename,homepage,homepagetitle,version,size,platform,license,logourl,description, html, smiley, br, xcode,submitter,mail,date,expired,hits,rating,votes,visible,cancomment,comments,kanrisya) SELECT lid,cid,title,url,'',homepage,homepagetitle,version,size,'','',screenshot,description,'0','1','1','1',submitter,'',published,expired,hits,rating,votes,'1','1',comments,'' FROM `$from_table`" ) ;
		if( ! $irs ) d3download_import_errordie( $mydirname ) ;

		// convert data from wfdownloads
		d3download_convert_from_wfdownloads( $mydirname, $target_dirname );

		// votedata 
		$from_table = $db->prefix( $target_dirname.'_votedata' ) ;
		$to_table = $db->prefix( $mydirname.'_votedata' ) ;
		$db->query( "DELETE FROM `$to_table`" ) ;
		$irs = $db->query( "INSERT INTO `$to_table` (lid,ratinguser,rating,ratinghostname,ratingtimestamp) SELECT lid,ratinguser,rating,ratinghostname,ratingtimestamp FROM `$from_table`" ) ;
		if( ! $irs ) d3download_import_errordie( $mydirname ) ;

		// upload files delete
		d3download_delete_uploadfiles_for_import( $mydirname );
		// make serialize data
		include_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
		d3download_make_serialize_data( $mydirname );
		// cache files delete
		d3download_delete_cache_of_categories( $mydirname ) ;
	}
}

if ( ! function_exists('d3download_import_from_d3download') ) {
	function d3download_import_from_d3download( $mydirname , $import_mid, $uploads_dir_error )
	{
		$db =& Database::getInstance() ;

		include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

		if( ! empty( $uploads_dir_error ) ){
			redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import" , 10 , _MD_D3DOWNLOADS_FILE_CONFIGERROR ) ;
			exit ;
		} else {
			$module_handler = & xoops_gethandler( 'module' ) ;
			$from_module =& $module_handler->get( $import_mid ) ;
			$from_dirname = $from_module->getVar('dirname') ;
			foreach( $GLOBALS['d3download_tables'] as $table_name => $columns ) {
				$to_table = $db->prefix( $mydirname.'_'.$table_name ) ;
				$from_table = $db->prefix( $from_dirname.'_'.$table_name ) ;
				$columns4sql = implode( ',' , $columns ) ;
				$db->query( "DELETE FROM `$to_table`" ) ;
				$irs = $db->query( "INSERT INTO `$to_table` ( $columns4sql ) SELECT $columns4sql FROM `$from_table`" ) ;
				if( ! $irs ) d3download_import_errordie( $mydirname ) ;
			}
			// upload files delete
			d3download_delete_uploadfiles_for_import( $mydirname );
			// upload files copy
			d3download_copy_uploadfiles_for_import( $mydirname, $from_dirname );
			// convert url
			d3download_copy_converturl_for_import( $mydirname, $from_dirname );
			// make serialize data
			include_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
			d3download_make_serialize_data( $mydirname );
			// cache files delete
			d3download_delete_cache_of_categories( $mydirname ) ;
		}
	}
}

if (! function_exists('d3download_default_user_access')) {
	function d3download_default_user_access( $mydirname )
	{
		include_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
		$error = d3download_set_default_user_access( $mydirname ) ;
		if( $error ) d3download_import_errordie( $mydirname ) ;
	}
}

if ( ! function_exists('d3download_delete_uploadfiles_for_import') ) {
	function d3download_delete_uploadfiles_for_import( $mydirname )
	{
		$uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname ;
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		if( $handler = @opendir( $uploads_dir . '/' ) ) {
			while( ( $file = readdir( $handler ) ) !== false ) {
				$file_path = $uploads_dir . '/' . $file ;
				if ( is_file( $file_path ) && strstr( $file , $site_salt ) ){
					@unlink( $file_path ) or die("File delete error ". $file );
				}
			}
		}
		closedir( $handler ) ;
	}
}

if ( ! function_exists('d3download_copy_uploadfiles_for_import') ) {
	function d3download_copy_uploadfiles_for_import( $mydirname, $from_dirname )
	{
		$from_dir = XOOPS_TRUST_PATH.'/uploads/'.$from_dirname ;
		$uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname ;
		d3download_uploads_dir_check_for_import( $mydirname, $uploads_dir ) ;
		$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
		if( $handler = @opendir( $from_dir . '/' ) ) {
			while( ( $file = readdir( $handler ) ) !== false ) {
				$from_file = $from_dir . '/' . $file ;
				$new_file = $uploads_dir . '/' . $file ;
				if ( strstr( $from_file , $site_salt ) ){
					if ( ! copy( $from_file, $new_file ) ) {
						redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import" , 3 , _MD_D3DOWNLOADS_FILE_NO_IMPORT ) ;
						exit ;
					}
				}
			}
		}
		closedir( $handler ) ;
	}
}

if ( ! function_exists('d3download_copy_converturl_for_import') ) {
	function d3download_copy_converturl_for_import( $mydirname, $from_dirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$result = $db->query("SELECT lid, url, file2 FROM ".$db->prefix( $mydirname."_downloads" )."");
		while( list( $id, $url, $file2 ) = $db->fetchRow( $result ) ) {
			$lid = intval( $id );
			$new_url = d3download_convert_uploaddir( $mydirname, $from_dirname, $url ) ;
			$new_url4sql = addslashes( $new_url );
			$new_file2 = d3download_convert_uploaddir( $mydirname, $from_dirname, $file2 ) ;
			$new_file24sql = addslashes( $new_file2 );
			$irs = $db->query( "UPDATE ".$db->prefix($mydirname."_downloads")." SET url = '".$new_url4sql."',file2 = '".$new_file24sql."' WHERE lid = '".$lid."'");
			if( ! $irs ) d3download_import_errordie( $mydirname ) ;
		}

		$result = $db->query("SELECT lid, url, file2 FROM ".$db->prefix( $mydirname."_downloads_history" )."");
		while( list( $id, $url, $file2 ) = $db->fetchRow( $result ) ) {
			$lid = intval( $id );
			$new_url = d3download_convert_uploaddir( $mydirname, $from_dirname, $url ) ;
			$new_url4sql = addslashes( $new_url );
			$new_file2 = d3download_convert_uploaddir( $mydirname, $from_dirname, $file2 ) ;
			$new_file24sql = addslashes( $new_file2 );
			$irs = $db->query( "UPDATE ".$db->prefix($mydirname."_downloads_history")." SET url = '".$new_url4sql."',file2 = '".$new_file24sql."' WHERE lid = '".$lid."'");
			if( ! $irs ) d3download_import_errordie( $mydirname ) ;
		}

		$result = $db->query("SELECT lid, url, file2 FROM ".$db->prefix( $mydirname."_unapproval" )."");
		while( list( $id, $url, $file2 ) = $db->fetchRow( $result ) ) {
			$lid = intval( $id );
			$new_url = d3download_convert_uploaddir( $mydirname, $from_dirname, $url ) ;
			$new_url4sql = addslashes( $new_url );
			$new_file2 = d3download_convert_uploaddir( $mydirname, $from_dirname, $file2 ) ;
			$new_file24sql = addslashes( $new_file2 );
			$irs = $db->query( "UPDATE ".$db->prefix($mydirname."_unapproval")." SET url = '".$new_url4sql."',file2 = '".$new_file24sql."' WHERE lid = '".$lid."'");
			if( ! $irs ) d3download_import_errordie( $mydirname ) ;
		}
	}
}

if ( ! function_exists('d3download_convert_uploaddir') ) {
	function d3download_convert_uploaddir( $mydirname, $from_dirname, $text )
	{
		$searches = 'XOOPS_TRUST_PATH/uploads/'.$from_dirname ;
		$replacements = 'XOOPS_TRUST_PATH/uploads/'.$mydirname ;
		if ( strstr ( $text , 'XOOPS_TRUST_PATH/uploads/'.$from_dirname ) ){
			$text = str_replace( $searches , $replacements , $text ) ;
		}
		return $text ;
	}
}

if (! function_exists('d3download_convert_from_wfdownloads')) {
	function d3download_convert_from_wfdownloads( $mydirname, $target_dirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $target_dirname );
		$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));

		if( empty( $mod_config['uploaddir'] ) ){
			$uploads_dir = XOOPS_ROOT_PATH.'/uploads';
		} else {
			$uploads_dir = htmlspecialchars( $mod_config['uploaddir'] , ENT_QUOTES );
		}
		$platform_array = $mod_config['platform'];
		$license_array = $mod_config['license'];
		$drs = $db->query("SELECT lid, url, filename, platform, license, offline FROM ".$db->prefix( $target_dirname."_downloads" )."");
		while( list( $id, $url, $fname, $platform, $license, $offline ) = $db->fetchRow( $drs ) ) {
			$filename = '';
			$f_ext = '';
			$lid = intval( $id );
			if( ! empty( $fname ) ){
				$file = htmlspecialchars( $fname , ENT_QUOTES );
		        $tempname = strrev( $file );
				$filename = strtolower( strrev( substr( $tempname, 0 , strpos( $tempname, "--" ) ) ) );
				$file_path = $uploads_dir.'/'.$file ;
				if ( file_exists( $file_path ) ){
					$f_info = pathinfo( $file_path );
					$f_ext = ( ! empty( $f_info['extension'] ) ) ? strtolower( $f_info['extension'] ) : '' ;
					$new_url4sql = $file_path;
				} else {
					$new_url4sql = addslashes( $url );
				}
			} else {
				$new_url4sql = addslashes( $url );
			}
			$from_platform = intval( $platform );
			$new_platform = $platform_array[$from_platform] ;
			$from_license = intval( $license );
			$new_license = $license_array[$from_license] ;
			if( ! empty( $offline ) ){
				$visible = 0;
			} else {
				$visible = 1;
			}
			$irs = $db->query( "UPDATE ".$db->prefix( $mydirname."_downloads" )." SET url = '".$new_url4sql."',filename = '".$filename."',ext = '".$f_ext."',platform = '".$new_platform."',license = '".$new_license."',visible = '".$visible."' WHERE lid = '".$lid."'");
			if( ! $irs ) d3download_import_errordie( $mydirname ) ;
		}
	}
}

if ( ! function_exists('d3download_uploads_dir_check_for_import') ) {
	function d3download_uploads_dir_check_for_import( $mydirname, $uploads_dir )
	{
		$safe_mode = ini_get( "safe_mode" ) ;
		if( ! is_dir( $uploads_dir ) ) {
			if( $safe_mode ) {
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import" , 3 , _MD_D3DOWNLOADS_FILE_NO_IMPORT ) ;
				exit ;
			}
			$mrs = mkdir( $uploads_dir , 0777 ) ;
			if( ! $mrs ) {
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import" , 3 , _MD_D3DOWNLOADS_FILE_NO_IMPORT ) ;
				exit ;
			} else @chmod( $uploads_dir , 0777 ) ;
		}
		if( ! is_writable( $uploads_dir ) || ! is_readable( $uploads_dir ) ) {
			$mrs = chmod( $uploads_dir , 0777 ) ;
			if( ! $mrs ) {
				redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import" , 3 , _MD_D3DOWNLOADS_FILE_NO_IMPORT ) ;
				exit ;
			}
		}
	}
}

?>