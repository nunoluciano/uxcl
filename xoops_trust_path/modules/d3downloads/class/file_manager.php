<?php

// for file_manager Data.d3downloads-to-d3downloads copy_execution

if( ! class_exists( 'file_manager' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class file_manager extends MyDownload
	{
		var $db ;
		var $table ;
		var $lid ;
		var $cid ;
		var $title ;
		var $submitter ;
		var $date ;
		var $comments ;
		var $visible ;
		var $cancomment ;
		var $hits ;
		var $rating ;
		var $votes ;

		function file_manager( $mydirname )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;
			$this->db =& Database::getInstance();
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$this->broken_table = $this->db->prefix( "{$mydirname}_broken" ) ;
			$this->vote_table = $this->db->prefix( "{$mydirname}_votedata" ) ;
			$this->history_table = $this->db->prefix( "{$mydirname}_downloads_history" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$columns = 'd.'.implode( ',d.' , $GLOBALS['d3download_tables']['downloads'] ) ;
			$columns .= ', c.title AS category';
			$this->columns = $columns ;
			$files = array() ;
			$broken = 0 ;
		}

		function get_files( $cid, $limit, $offset, $order, $invisible=0, $submitter=0, $mypost=0, $intree=0 )
		{
			global $xoopsConfig ;

			switch( $invisible ) {
				case false :
					$where = "( d.visible = '0' OR d.visible = '1' )";
					break ;
				case true :
					$where = "( d.visible = '0' OR d.date > ".time()." OR ( d.expired > 0 AND d.expired < ".time().") )" ;
					break ;
			}
			if( ! empty( $mypost ) ) $where .= " AND d.submitter IN ( '".$submitter."' )";
			$where .= " AND ( ".$this->get_whr_categories( $cid, $intree )." )";

			$sql = $this->default_sql() ." WHERE $where ORDER BY $order";
			$result = $this->db->query( $sql, $limit, $offset ) ;

			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return array() ;
			}

			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$lid = $this->return_lid() ;
				$brs = $this->db->query( "SELECT COUNT(*) FROM ".$this->broken_table." WHERE lid='".$lid."'" ) ;
				list( $count ) = $this->db->fetchRow( $brs ) ;
				$broken = ( empty( $count ) ) ? 0 : intval( $count ) ;
				$files[] = array(
					'lid'        => $lid ,
					'cid'        => $this->return_cid() ,
					'title'      => $this->return_title('Show') ,
					'date'       => formatTimestamp( $this->return_date(), 'l', $xoopsConfig['default_TZ'] ) ,
					'visible'    => $this->return_visible() ,
					'cancomment' => $this->return_cancomment() ,
					'ctitle'     => $this->return_category('Show') ,
					'broken'     => $broken ,
					'hits'       => $this->return_hits() ,
					'rating'     => $this->return_rating() ,
					'votes'      => $this->return_votes() ,
					'mylink'     => $this->return_mylink() ,
					'comments'   => $this->return_comments() ,
					'user_url'   => $this->getlink_for_postname( $this->return_submitter() ) ,
					'dateinfo'   => $this->Invisible_Info() ,
				) ;
			}
			return $files ;
		}

		function get_copy_target_modules()
		{
			$module_handler =& xoops_gethandler( 'module' ) ;
			$modules =& $module_handler->getObjects() ;
			$target_modules = array() ;
			$target_modules = array( 0 => '----' ) ;
			$i = 0 ;

			foreach( $modules as $module ) {
				$mid = $module->getVar('mid') ;
				$dirname = $module->getVar('dirname') ;
				$dirpath = XOOPS_ROOT_PATH.'/modules/'.$dirname ;
				$mytrustdirname = '' ;

				if( file_exists( $dirpath.'/mytrustdirname.php' ) ) {
					include $dirpath.'/mytrustdirname.php' ;
				}

				if( $mytrustdirname == 'd3downloads' && $dirname != $this->mydirname ) {
					$target_modules[$mid] = $module->getVar('name')." ( $dirname )" ;
					$category[$mid] = $this->get_copy_target_category( $dirname ) ;
					$i++ ;
				}
			}

			if( $i == 0 ) return array() ;
			else return array(
				'target_modules'           => $target_modules ,
				'category'                 => $category ,
				'category_select_showhide' => $this->make_category_select_showhide() ,
			) ;
		}

		function get_copy_target_category( $target_dirname )
		{
			require_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $target_dirname, 'Show' ) ;

			$category = "" ;
			$sql = "SELECT cid, title, child FROM ".$this->db->prefix( $target_dirname."_cat" )." WHERE pid='0' ORDER BY cat_weight ASC" ;

			$result = $this->db->query( $sql );
			while( list( $id, $name, $child_array ) = $this->db->fetchRow( $result ) ) {
				$cid = intval( $id );
				$category .= "<option value='$cid'>".$this->myts->makeTboxData4Show( $name )."</option>\n" ;

				$arr = $mycategory->unserialize_my_child( $cid, '', $child_array ) ;
				foreach ( $arr as $child ) {
					$child_id = intval( $child['cid'] ) ;
					$child['prefix'] = str_replace( ".","--", $child['prefix'] ) ;
					$category .= "<option value='$child_id'>".$child['prefix']."&nbsp;".$this->myts->makeTboxData4Show( $child['title'] )."</option>\n" ;
				}
			}

			return $category ;
		}

		function make_category_select_showhide()
		{
			$html  = '
			<script type="text/javascript">
			select_box_showhide( "copy_mid", "copy_category_id_" ) ;
			</script>
			' ;

			return $html ;
		}

		function copy_execution( $taget_mid, $taget_category , $id )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$module_handler =& xoops_gethandler( 'module' ) ;
			$to_module =& $module_handler->get( $taget_mid ) ;
			$to_dirname = $to_module->getVar('dirname') ;

			// downloads 
			$from_table = $this->table ;
			$to_table = $this->db->prefix( $to_module->getVar('dirname').'_downloads' ) ;
			$columns4sql = implode( ',' , array_diff( $GLOBALS['d3download_tables']['downloads'] , array( 'lid' , 'cid' ) ) ) ;
			$irs = $this->db->query( "INSERT INTO `$to_table` ($columns4sql,cid) SELECT $columns4sql,$taget_category FROM `$from_table` WHERE lid=".$id ) ;
			if( ! $irs ) $this->errordie() ;
			$new_id = $this->db->getInsertId() ;

			// votedata 
			$from_table = $this->vote_table ;
			$to_table = $this->db->prefix( $to_module->getVar('dirname').'_votedata' ) ;
			$columns4sql = implode( ',' , array_diff( $GLOBALS['d3download_tables']['votedata'] , array( 'ratingid' , 'lid' ) ) ) ;
			$irs = $this->db->query( "INSERT INTO `$to_table` ($columns4sql,lid) SELECT $columns4sql,$new_id FROM `$from_table` WHERE lid=".$id ) ;
			if( ! $irs ) $this->errordie() ;

			// downloads_history 
			$from_table = $this->history_table ;
			$to_table = $this->db->prefix( $to_module->getVar('dirname').'_downloads_history' ) ;
			$columns4sql = implode( ',' , array_diff( $GLOBALS['d3download_tables']['downloads_history'] , array( 'id' ,'lid' , 'cid' ) ) ) ;
			$irs = $this->db->query( "INSERT INTO `$to_table` ($columns4sql,lid,cid) SELECT $columns4sql,$new_id,$taget_category FROM `$from_table` WHERE lid=".$id ) ;
			if( ! $irs ) $this->errordie() ;

			// convert url
			$this->copy_converturl( $to_dirname, $id, $new_id ) ;

			return $to_dirname ;
		}

		function copy_converturl( $to_dirname, $id, $new_id )
		{
			// downloads 
			$result = $this->db->query( "SELECT url, file2 FROM ".$this->table." WHERE lid='".$id."'" ) ;
			list( $url, $file2 ) = $this->db->fetchRow( $result ) ;

			$new_url = $this->convert_uploaddir( $to_dirname, $id, $new_id, $url ) ;
			$new_url4sql = "'".addslashes( $new_url ) ."'" ;
			$new_file2 = $this->convert_uploaddir( $to_dirname, $id, $new_id, $file2 ) ;
			$new_file24sql = "'".addslashes( $new_file2 ) ."'" ;
			$this->files_import( $to_dirname, $url, $new_url ) ;
			$this->files_import( $to_dirname, $file2, $new_file2 ) ;
			$irs = $this->db->query( "UPDATE ".$this->db->prefix( $to_dirname."_downloads" )." SET url=$new_url4sql,file2=$new_file24sql WHERE lid = '".$new_id."'") ;
			if( ! $irs ) $this->errordie() ;

			// downloads_history 
			$result = $this->db->query( "SELECT url, file2 FROM ".$this->history_table." WHERE lid='".$id."'" ) ;
			while( list( $url, $file2 ) = $this->db->fetchRow( $result ) ) {
				$new_url = $this->convert_uploaddir( $to_dirname, $id, $new_id, $url ) ;
				$new_url4sql = "'".addslashes( $new_url ) ."'" ;
				$new_file2 = $this->convert_uploaddir( $to_dirname, $id, $new_id, $file2 ) ;
				$new_file24sql = "'".addslashes( $new_file2 ) ."'" ;
				$this->files_import( $to_dirname, $url, $new_url ) ;
				$this->files_import( $to_dirname, $file2, $new_file2 ) ;
				$irs = $this->db->query( "UPDATE ".$this->db->prefix( $to_dirname."_downloads_history" )." SET url=$new_url4sql,file2=$new_file24sql WHERE lid = '".$new_id."'") ;
				if( ! $irs ) $this->errordie() ;
			}
		}

		function convert_uploaddir( $to_dirname, $id, $new_id, $text )
		{
			$site_salt = substr( md5( XOOPS_URL ) , -4 ) ;

			$searches     = array( 'XOOPS_TRUST_PATH/uploads/'.$this->mydirname.'/' , $id.'_'.$site_salt ) ;
			$replacements = array( 'XOOPS_TRUST_PATH/uploads/'.$to_dirname.'/' , $new_id.'_'.$site_salt ) ;

			if ( strstr ( $text , 'XOOPS_TRUST_PATH/uploads/'.$this->mydirname ) ){
				$text = str_replace( $searches , $replacements , $text ) ;
			}

			return $text ;
		}

		function files_import( $to_dirname, $url, $to_url )
		{
			$from_dir = XOOPS_TRUST_PATH.'/uploads/'.$this->mydirname ;
			$to_uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$to_dirname ;
			$filepath = $this->Real_path( $url ) ;
			$to_filepath = $this->Real_path( $to_url ) ;

			if ( strstr( $filepath , $from_dir ) && file_exists( $filepath ) ){
				$this->uploads_dir_check( $to_uploads_dir ) ;
				copy( $filepath, $to_filepath ) or die("File copy error ". $to_filepath ) ;
			}
		}

		function uploads_dir_check( $uploads_dir )
		{
			$safe_mode = ini_get( "safe_mode" ) ;

			if( ! is_dir( $uploads_dir ) ) {
				if( $safe_mode ) $this->uploads_dir_errordie() ;
				$mrs = mkdir( $uploads_dir , 0777 ) ;
				if( ! $mrs ) $this->uploads_dir_errordie() ;
				else @chmod( $uploads_dir , 0777 ) ;
			}

			if( ! is_writable( $uploads_dir ) || ! is_readable( $uploads_dir ) ) {
				$mrs = chmod( $uploads_dir , 0777 ) ;
				if( ! $mrs ) $this->uploads_dir_errordie() ;
			}
		}

		function errordie()
		{
			echo _MD_D3DOWNLOADS_SQLONIMPORT ;
			echo $this->db->logger->dumpQueries() ;
			exit ;
		}

		function uploads_dir_errordie( $error )
		{
			echo _MD_D3DOWNLOADS_FILE_NO_IMPORT ;
			exit ;
		}
	}
}

?>