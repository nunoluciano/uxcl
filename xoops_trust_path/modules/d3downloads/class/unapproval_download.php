<?php

// for unapproval_data edit

if( ! class_exists( 'unapproval_download' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class unapproval_download extends MyDownload
	{
		var $db;
		var $table;
		var $requestid;
		var $lid ;
		var $cid ;
		var $title ;
		var $url ;
		var $filename ;
		var $ext ;
		var $file2 ;
		var $filename2 ;
		var $ext2 ;
		var $homepage ;
		var $homepagetitle ;
		var $version ;
		var $size ;
		var $platform ;
		var $license ;
		var $logourl ;
		var $description ;
		var $html ;
		var $smiley ;
		var $br ;
		var $xcode ;
		var $filters ;
		var $extra ;
		var $submitter ;
		var $date ;
		var $expired ;
		var $visible ;
		var $cancomment ;
		var $notify ;
		var $category;
		var $downdata=array();

		function unapproval_download( $mydirname, $id= 0 )
		{
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance();
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->table = $this->db->prefix( "{$mydirname}_unapproval" ) ;
			$this->cat_table = $this->db->prefix( "{$mydirname}_cat" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$columns = implode( ',' , $GLOBALS['d3download_tables']['unapproval'] ) ;
			$this->columns = $columns ;
			$columns4list = 'u.'.implode( ',u.' , $GLOBALS['d3download_tables']['unapproval'] ) ;
			$columns4list .= ', c.title AS category';
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
			$sql = "SELECT $this->columns  FROM ".$this->table."  WHERE requestid='".$id."'";
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result );
		}

		function get_unapprovaldata( $requestid, $category )
		{
			$result = $this->db->query("SELECT $this->columns  FROM ".$this->table." WHERE requestid='".$requestid."'");
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return '';
			}
			$this->getData( $result ) ;
			$requestid  = $this->return_requestid() ;
			$cid        = $this->return_cid() ;
			$modify     = ! empty( $this->lid ) ? true : false ;
			$aprovalid  = $this->return_lid() ;
			$submitter  = $this->return_submitter() ;
			$url        = $this->return_url('Edit') ;
			$filename   = $this->return_filename('Edit') ;
			$ext        = $this->return_ext('Edit') ;
			$file_info  = $this->file_link_for_post( $requestid, $cid, $this->return_url('Show'), $filename ) ;
			$file2      = $this->return_file2('Edit') ;
			$filename2  = $this->return_filename2('Edit') ;
			$ext2       = $this->return_ext2('Edit') ;
			$file_info2 = $this->file_link_for_post( $requestid, $cid, $this->return_file2('Show'), $filename2, 1 ) ;
			$logourl    = $this->return_logourl('Edit') ;

			$downdata = array(
				'requestid'     => $requestid ,
				'lid'           => $aprovalid ,
				'cid'           => $cid ,
				'category'      => $category ,
				'title'         => $this->return_title('Edit') ,
				'url'           => $url ,
				'filelink'      => $file_info['filelink'] ,
				'filename'      => $filename ,
				'ext'           => $this->return_ext('Edit') ,
				'filelink'      => $file_info['filelink'] ,
				'filenamelink'  => $file_info['filenamelink'] ,
				'file2'         => $file2 ,
				'filename2'     => $filename2 ,
				'ext2'          => $ext2 ,
				'filelink2'     => $file_info2['filelink'] ,
				'filenamelink2' => $file_info2['filenamelink'] ,
				'homepage'      => $this->return_homepage('Edit') ,
				'homepagetitle' => $this->return_homepagetitle('Edit') ,
				'version'       => $this->return_version('Edit') ,
				'size'          => $this->return_size() ,
				'platform'      => $this->return_platform('Edit') ,
				'license'       => $this->return_license('Edit') ,
				'logourl'       => $logourl ,
				'shots_link'    => ( empty( $logourl ) ) ? '' : $this->shots_link_for_post( $cid, $logourl ) ,
				'submitter'     => $submitter ,
				'postname'      => $this->getlink_for_postname( $submitter ) ,
				'description'   => $this->return_description('Edit') ,
				'html'          => $this->return_html() ,
				'smiley'        => $this->return_smiley() ,
				'br'            => $this->return_br() ,
				'xcode'         => $this->return_xcode() ,
				'filters'       => $this->get_MyFilter( $this->filters ) ,
				'extra'         => $this->return_extra('Edit') ,
				'createable'    => $this->return_createable() ,
				'date'          => $this->return_date() ,
				'expired'       => $this->return_expired() ,
				'expiredable'   => $this->return_expiredable() ,
				'modify'        => $modify ,
				'visible'       => $this->return_visible() ,
				'cancomment'    => $this->return_cancomment() ,
				'notify'        => $this->return_notify() ,
			) ;
			return array(
				'cid'       => $cid ,
				'aprovalid' => $aprovalid ,
				'postname'  => $this->get_postname( $submitter ) ,
				'downdata'  => $downdata ,
			) ;
		}

		function get_unapproval_list( $mode )
		{
			global $xoopsConfig ;

			$sql = "SELECT $this->columns4list FROM ".$this->table." u LEFT JOIN ".$this->cat_table." c ON u.cid = c.cid" ;
			switch( $mode ) {
				case 'NewFile' :
					$sql .= " WHERE u.lid='0'";
					break ;
				case 'ModFile' :
					$sql .= " WHERE u.lid > '0'";
					break ;
			}
			$sql .= " ORDER BY u.requestid";
			$result = $this->db->query( $sql );
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return array();
			}
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$submitter = $this->return_submitter() ;
				$downdata[] = array(
					'requestid' => $this->return_requestid() ,
					'cid'       => $this->return_cid() ,
					'title'     => $this->return_title('Show') ,
					'date'      => formatTimestamp( $this->return_date(), 'l', $xoopsConfig['default_TZ'] ) ,
					'ctitle'    => $this->return_category('Show') ,
					'postname'  => $this->getlink_for_postname( $submitter ) ,
				) ;
			}
			return $downdata ;
		}

		function Total_Num( $mode='' )
		{
			$sql = "SELECT COUNT( requestid ) FROM ".$this->table."";
			switch( $mode ) {
				case 'NewFile' :
					$sql .= " WHERE lid='0'";
					break ;
				case 'ModFile' :
					$sql .= " WHERE lid > '0'";
					break ;
			}
			$result = $this->db->query( $sql );
			list( $num ) = $this->db->fetchRow( $result ) ;
			return intval( $num );
		}

		function Unapproval_Num()
		{
			$unapproval_num = $this->Total_Num() ;
			return array(
				'num' => $unapproval_num ,
				'link' => '<a href="'.$this->mod_url.'/admin/index.php?page=approvalmanager">'.sprintf( _MD_D3DOWNLOADS_UNAPPROVAL_NUM , $unapproval_num ).'</a>' ,
			) ;
		}

		function return_requestid()
		{
			return intval( $this->requestid ) ;
		}

		function return_notify()
		{
			return $this->notify ? 1 : 0 ;
		}

		function file_link_for_post( $id, $cid, $url, $filename, $second = 0 )
		{
			$filelink = $filenamelink = '';
			$exception = '\.'.implode( '|\.',$this->Exception_extension() );
			$link = $this->mod_url.'/index.php?page=visit_url&unapproval=1&cid='.$cid.'&id='.$id ;
			if ( ! preg_match("`^(https?|ftp)://`i", $url ) ) {
				if( ! $this->check_file( $url ) ){
					$filelink     = '( <span style="color: #CC0000;font-weight: bold;">broken file !!</span> )';
					$filenamelink = $filename.'&nbsp;&nbsp;( <span style="color: #CC0000;font-weight: bold;">broken file !!</span> )';
				} else {
					if( empty( $second ) ){
						$filelink     = '[<a href="'.$link.'">'._MD_D3DOWNLOADS_SUBMIT_DOWNLOAD.'</a>]' ;
						$filenamelink = '<a href="'.$link.'">'.$filename.'</a>';
					} else {
						$filelink     = '[<a href="'.$link.'&second=1">'._MD_D3DOWNLOADS_SUBMIT_DOWNLOAD.'</a>]' ;
						$filenamelink = '<a href="'.$link.'&second=1">'.$filename.'</a>';
					}
				}
			} elseif ( preg_match('/('.$exception.')$/i', $url ) ) {
				$filelink = '[<a href="'.$link.'">'._MD_D3DOWNLOADS_SUBMIT_ACCESS_URL.'</a>]' ;
			} else {
				$filelink = '[<a href="'.$link.'" target="_blank">'._MD_D3DOWNLOADS_SUBMIT_ACCESS_URL.'</a>]' ;
			}
			return array(
				'filelink'     => $filelink ,
				'filenamelink' => $filenamelink ,
			) ;
		}

		function Delete_Unapproval( $id )
		{
			$error = 0 ;
			$sql = "SELECT COUNT(*) FROM ".$this->table." WHERE requestid ='".$id."'";
			list( $count ) = $this->db->fetchRow( $this->db->query( $sql ) );
			if( $count > 0 ){
				$this->Delete_Unapproval_Files( $id );
				$sql = "DELETE FROM ".$this->table." WHERE requestid ='".$id."'";
				$result = $this->db->query( $sql );
				if( ! $result ) $error = $id ;
			}
			return $error ;
		}

		function Delete_Unapproval_Files( $id )
		{
			$frs = $this->db->query("SELECT url, filename, file2 FROM ".$this->table."  WHERE requestid='".$id."'");
			while( list( $ur, $fename, $fil2 ) = $this->db->fetchRow( $frs ) ) {
				$url = $this->myts->makeTboxData4URLShow( $ur );
				$filename = $this->myts->MyhtmlSpecialChars( $fename );
				$file2 = $this->myts->MyhtmlSpecialChars( $fil2 );
				$linkcheck = $this->Link_Check( $url, $file2 ) ;
				if ( empty( $linkcheck['fcount'] ) ){
					$filepath = $this->Real_path( $url ) ;
					if ( ! empty( $filename ) && file_exists( $filepath ) ) @unlink( $filepath ) or die("File delete error ". $url );
				}
				if ( empty( $linkcheck['fcount2'] ) ){
					$filepath2 = $this->Real_path( $file2 ) ;
					if ( file_exists( $filepath2 ) ) @unlink( $filepath2 ) or die("File delete error ". $file2 );
				}
			}
		}

		function Link_Check( $url, $file2 )
		{
			$fcount = $fcount2 = 0 ;
			$fcount  += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->db->prefix( $this->mydirname."_downloads" )." WHERE url='".$url."'" ) );
			$fcount  += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->db->prefix( $this->mydirname."_downloads_history" )." WHERE url='".$url."'" ) );
			$fcount2 += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->db->prefix( $this->mydirname."_downloads" )." WHERE file2='".$file2."'" ) );
			$fcount2 += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->db->prefix( $this->mydirname."_downloads_history" )." WHERE file2='".$file2."'" ) );
			return array(
				'fcount' => $fcount ,
				'fcount2' => $fcount2 ,
			) ;
		}
	}
}

?>