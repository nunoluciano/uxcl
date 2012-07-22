<?php

// for history_data , history_list

if( ! class_exists( 'history_download' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class history_download extends MyDownload
	{
		var $db;
		var $table;
		var $id;
		var $lid;
		var $cid;
		var $title;
		var $url;
		var $filename;
		var $ext;
		var $file2;
		var $filename2;
		var $ext2;
		var $version;
		var $size;
		var $description;
		var $extra;
		var $date;
		var $category;
		var $history=array();
		var $history_int = array( 'lid' ,'cid' , 'date', 'size' ) ;
		var $history_txt =  array( 'title' , 'url' , 'filename' , 'ext' , 'file2' , 'filename2' , 'ext2' , 'version' , 'description' , 'extra' ) ;

		function history_download( $mydirname, $id= 0 )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;
			$this->db =& Database::getInstance();
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$this->table = $this->db->prefix( "{$mydirname}_downloads_history" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$this->downloads_table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$columns = 'h.'.implode( ',h.' , $GLOBALS['d3download_tables']['downloads_history'] ) ;
			$columns .= ', c.title AS category';
			$this->columns = $columns ;
			$columns4list = implode( ',' , $GLOBALS['d3download_tables']['downloads_history'] ) ;
			$this->columns4list = $columns4list ;
			$module_handler =& xoops_gethandler('module');
			$config_handler =& xoops_gethandler('config');
			$module =& $module_handler->getByDirname( $mydirname );
			$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );
			$this->mod_config = $mod_config ;
			if( ! empty( $id ) ) {
				$this->GetMyDownload( $id ) ;
			}
		}

		function GetMyDownload( $id )
		{
			$sql = "SELECT $this->columns FROM ".$this->table." h LEFT JOIN ".$this->cat_table." c ON h.cid=c.cid WHERE h.id='".$id."'";
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result );
		}

		function get_history_data( $history_id )
		{
			global $xoopsConfig ;

			$result = $this->db->query("SELECT $this->columns FROM ".$this->table." h LEFT JOIN ".$this->cat_table." c ON h.cid=c.cid WHERE h.id='".$history_id."'");
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result );
			$id        = intval( $this->id ) ;
			$lid       = $this->return_lid() ;
			$cid       = $this->return_cid() ;
			$url       = $this->return_url('Show') ;
			$filename  = $this->return_filename('Show') ;
			$ext       = $this->return_ext('Show') ;
			$file_info = $this->file_link( $id, $cid, $url, $filename, $ext );
			$file2     = $this->return_file2('Show') ;
			$filename2 = $this->return_filename2('Show') ;
			$history = array(
				'id'             => $id ,
				'lid'            => $lid ,
				'cid'            => $cid ,
				'title'          => $this->return_title('Show') ,
				'url'            => $url ,
				'filename'       => $filename ,
				'filename2'      => $filename2 ,
				'filelink'       => $file_info['filelink'] ,
				'filename_link'  => $this->filename_link( $id, $cid, $url, $filename )  ,
				'filename_link2' => $this->filename_link( $id, $cid, $file2, $filename2, 1 )  ,
				'broken_link'    => $file_info['broken_link'] ,
				'ext'            => $ext ,
				'version'        => $this->return_version('Show') ,
				'description'    => $this->myts->displayTarea( $this->description, 0, 1, 1, 1, 1 ) ,
				'extra'          => $this->return_extra('Show', 1 ) ,
				'date'           => formatTimestamp( intval( $this->date ), 'l', $xoopsConfig['default_TZ'] ) ,
				'ctitle'         => $this->return_category('Show') ,
			) ;
			return array(
				'lid'         => $lid ,
				'historydata' => $history ,
			) ;
		}

		function get_history_list( $lid, $id=0 )
		{
			global $xoopsConfig ;

			$sql = "SELECT $this->columns4list FROM ".$this->table." WHERE lid='".$lid."'" ;
			if ( ! empty( $id ) ){
				$sql .= " AND id NOT IN ('".$id."')" ;
			}
			$sql .= " ORDER BY id DESC" ;
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return array();
			}
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$history[] = array(
					'history_id'          => intval( $this->id ) ,
					'history_lid'         => $this->return_lid() ,
					'history_cid'         => $this->return_cid() ,
					'history_title'       => $this->return_title('Show') ,
					'history_url'         => $this->return_url('Show') ,
					'history_filename'    => $this->return_filename('Show') ,
					'history_ext'         => $this->return_ext('Show') ,
					'history_description' => $this->myts->displayTarea( $this->description, 0, 1, 1, 1, 1 ) ,
					'history_date'        => formatTimestamp( intval( $this->date ), 'l', $xoopsConfig['default_TZ'] ) ,
				) ;
			}
			return $history ;
		}

		function file_link( $id, $cid, $url, $filename, $ext )
		{
			$broken_link = 0 ;
			$filelink = '' ;
			$exception = '\.'.implode( '|\.',$this->Exception_extension() );
			$link = $this->mod_url.'/index.php?page=visit_url&history=1&cid='.$cid.'&id='.$id ;
			if ( ! preg_match("`^(https?|ftp)://`i", $url ) ) {
				if( ! $this->check_file( $url ) ){
					$broken_link = 1 ;
				} else {
					if( empty( $filename ) ){
						$f_info   = $this->get_filename( $url ) ;
						$filename = $f_info['filename'] ;
						$ext      = $f_info['extension'] ;
					}
					$filelink =  '<a href="'.$link.'">' ;
				}
			} elseif ( preg_match('/('.$exception.')$/i', $url ) ) {
				$filelink =  '<a href="'.$link.'">' ;
			} else {
				$filelink =  '<a href="'.$link.'" target="_blank">' ;
			}
			return array(
				'broken_link' => $broken_link ,
				'filelink'    => $filelink ,
			) ;
		}

		function filename_link( $id, $cid, $url, $filename, $second = 0 )
		{
			$filenamelink = '' ;
			$link = $this->mod_url.'/index.php?page=visit_url&history=1&cid='.$cid.'&id='.$id ;
			if ( ! preg_match("`^(https?|ftp)://`i", $url ) ) {
				if( ! $this->check_file( $url ) ){
					$filenamelink = $filename.'&nbsp;&nbsp;( <span style="color: #CC0000;font-weight: bold;">broken file !!</span> )';
				} else {
					if( empty( $second ) ){
						$filenamelink = '<a href="'.$link.'">'.$filename.'</a>';
					} else {
						$filenamelink = '<a href="'.$link.'&second=1">'.$filename.'</a>';
					}
				}
			}
			return $filenamelink ;
		}

		function history_Insert_DB( $lid )
		{
			$current_columns = implode( ',' , array_diff( $GLOBALS['d3download_tables']['downloads_history'] , array( 'id' ) ) ) ;
			$newid = $this->db->genId( $this->table."_id_seq" );
			$result = $this->db->query( "SELECT $current_columns FROM ".$this->downloads_table."  WHERE lid='".$lid."'" );
			$array = $this->db->fetchArray( $result );
			foreach ( $array as $key=>$value ){
				$$key = $value ;
			}
			$set4sql = "id='".$newid."'" ;
			foreach( $this->history_int as $key ) {
				$set4sql .= ",$key='".intval( $$key )."'" ;
			}
			foreach( $this->history_txt as $key ) {
				$set4sql .= ",$key='".addslashes( $$key )."'" ;
			}
			$sql = "INSERT INTO ".$this->table." SET $set4sql" ;
			$this->db->query( $sql ) or die( "DB error: INSERT downloads_history table." ) ;
			$new_id = $this->db->getInsertId();
			return $new_id;
		}

		function history_Restore( $id, $lid )
		{
			$current_columns = implode( ',' , array_diff( $GLOBALS['d3download_tables']['downloads_history'] , array( 'id' ,'lid' ) ) ) ;
			$current_int = array_diff( $this->history_int, array( 'lid', 'size' ) ) ;
			$current_txt = array_diff( $this->history_txt, array( 'version' ) ) ;
			$hrs = $this->db->query( "SELECT $current_columns FROM ".$this->table." WHERE id='".$id."'" );
			$array = $this->db->fetchArray( $hrs );
			foreach ( $array as $key=>$value ){
				$$key = $value ;
			}
			$set4sql = "lid='".$lid."'" ;
			foreach( $current_int as $key ) {
				$set4sql .= ",$key='".intval( $$key )."'" ;
			}
			if( $size > 0 ) $set4sql .= ",size='".intval( $size )."'" ;
			foreach( $current_txt as $key ) {
				$set4sql .= ",$key='".addslashes( $$key )."'" ;
			}
			if( ! empty( $version ) ) $set4sql .= ",version='".addslashes( $version )."'" ;
			$sql = "UPDATE ".$this->downloads_table." SET $set4sql WHERE lid='".$lid."'";
			$result = $this->db->query( $sql );
			return $result;
		}

		function history_Delete( $lid )
		{
			$num = $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->table." WHERE lid='".$lid."'" ) );
			if( $num > $this->mod_config['history'] ){
				$limit = $num - $this->mod_config['history'];
				$result = $this->db->query( "SELECT id, url, file2 FROM ".$this->table." WHERE lid='".$lid."' ORDER BY id", $limit, 0 );
				while( $array = $this->db->fetchArray( $result ) ) {
					foreach ( $array as $key=>$value ){
						$this->$key = $value;
					}
					$id = intval( $this->id ) ;
					$url = $this->return_url('Show', 1 ) ;
					$file2 = $this->return_file2('Show', 1 ) ;
					$this->Delete_Execution( $id, $url, $file2 ) ;
				}
			}
		}

		function Delete_Execution( $id, $url, $file2 )
		{
			$count = $count2 = 0 ;
			$count += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->downloads_table." WHERE url='".$url."'" ) );
			$count += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->table." WHERE id NOT IN ( '".$id."' ) AND url='".$url."'" ) );
			if( empty( $count ) ){
				$filepath = $this->Real_path( $url ) ;
				if ( ! preg_match("`^(https?|ftp)://`i", $filepath )  && is_file( $filepath ) ) {
					@unlink( $filepath ) or die("File delete error ". $url );
				}
			}
			$count2 += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->downloads_table." WHERE file2='".$file2."'" ) );
			$count2 += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->table." WHERE id NOT IN ( '".$id."' ) AND file2='".$file2."'" ) );
			if( empty( $count2 ) ){
				$filepath2 = $this->Real_path( $file2 ) ;
				if ( is_file( $filepath2 ) ) {
					@unlink( $filepath2 ) or die("File delete error ". $file2 );
				}
			}
			$this->db->query("DELETE FROM ".$this->table." WHERE id='".$id."'" ) or die( "DB error: DELETE downloads_history table." ) ;
		}
	}
}

?>