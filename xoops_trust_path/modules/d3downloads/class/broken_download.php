<?php

// for broken_data

if( ! class_exists( 'broken_download' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class broken_download extends MyDownload
	{
		var $db;
		var $table;
		var $reportid;
		var $lid;
		var $sender;
		var $ip;
		var $status;
		var $message;
		var $name;
		var $mail;
		var $date;
		var $cid;
		var $title;
		var $url;
		var $filename;
		var $ext;
		var $file2 ;
		var $filename2 ;
		var $submitter;
		var $updated;

		function broken_download( $mydirname )
		{
			global $xoopsUser ;
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->db =& Database::getInstance() ;
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->broken_table = $this->db->prefix( "{$mydirname}_broken" ) ;
			$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->mydirname = $mydirname ;
			$this->mod_url = XOOPS_URL.'/modules/'.$mydirname ;
			$this->columns = 'b.lid, b.status, d.cid, d.title, d.url, d.filename, d.ext, d.file2, d.filename2, d.submitter, d.date AS updated';
			$this->columns4list = implode( ',' , $GLOBALS['d3download_tables']['broken'] ) ;
		}

		function get_broken_data()
		{
			global $xoopsConfig ;

			$i = 0 ;
			$ret = array() ;

			$sql = "SELECT $this->columns FROM ".$this->broken_table." b LEFT JOIN ".$this->table." d ON b.lid=d.lid GROUP BY b.lid DESC";
			$result = $this->db->query( $sql ) ;
			if ( $this->db->getRowsNum( $result ) == 0 ) {
				return array() ;
			}
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$lid       = $this->return_lid() ;
				$cid       = $this->return_cid() ;
				$submitter = $this->return_submitter() ;
				$url       = $this->return_url('Show') ;
				$filename  = $this->return_filename('Show') ;
				$ext       = $this->return_ext('Show') ;
				$file_info = $this->file_link( $lid, $cid, '', $url, $filename, $ext, 1 ) ;
				$file2     = $this->return_file2('Show') ;
				$filename2 = $this->return_filename2('Show') ;
				$status    = $this->return_status() ;
				$ret['file'][$i] = array(
					'id'             => intval( $this->reportid ) ,
					'lid'            => $lid ,
					'cid'            => $cid ,
					'title'          => $this->return_title('Show') ,
					'url'            => $url ,
					'filename'       => $filename ,
					'filename2'      => $filename2 ,
					'filelink'       => $file_info['filelink'] ,
					'filename_link'  => $this->filename_link( $lid, $cid, $url, $filename, $status )  ,
					'filename_link2' => $this->filename_link( $lid, $cid, $file2, $filename2, $status, 1 )  ,
					'broken_link'    => $file_info['broken_link'] ,
					'filename'       => $filename ,
					'ext'            => $ext ,
					'submitter'      => $submitter ,
					'postname'       => $this->getlink_for_postname( $submitter ) ,
					'updated'        => formatTimestamp( $this->updated, 'l', $xoopsConfig['default_TZ'] ) ,
				) ;
				$report_list = $this->Broken_of_Currentlid( $lid ) ;
				$ret['file'][$i]['report'] = $report_list['broken'] ;
				$i++ ;
			}
			return $ret ;
		}

		function Broken_of_Currentlid( $lid )
		{
			global $xoopsConfig ;

			$sql = "SELECT $this->columns4list FROM ".$this->broken_table." WHERE lid = '".$lid."' ORDER BY date DESC" ;
			$result = $this->db->query( $sql ) ;
			$count = $this->db->getRowsNum( $result ) ;
			if ( $count == 0 ) return array(
				'totalbroken'         => '' ,
				'total_broken4assign' => '' ,
				'broken'              => '' ,
			) ;
			$totalbroken = intval( $count ) ;
			$total_broken4assign = sprintf( _MD_D3DOWNLOADS_TOTAL_BROKEN , $totalbroken ) ;
			while( $array = $this->db->fetchArray( $result ) ) {
				foreach ( $array as $key=>$value ){
					$this->$key = $value;
				}
				$sender = $this->return_sender() ;
				$broken[] = array(
					'id'         => intval( $this->reportid ) ,
					'sendername' => $this->getlink_for_sender( $sender ) ,
					'ip'         => $this->return_ip() ,
					'message'    => $this->return_message() ,
					'mail_link'  => $this->mail_link( $sender ) ,
					'date'       => formatTimestamp( intval( $this->date ), 'l', $xoopsConfig['default_TZ'] ) ,
				) ;
			}
			return array(
				'totalbroken'         => $totalbroken ,
				'total_broken4assign' => $total_broken4assign ,
				'broken'              => $broken ,
			) ;
		}

		function Total_Num()
		{
			$sql = "SELECT COUNT( reportid ) FROM ".$this->broken_table."";
			$result = $this->db->query( $sql ) ;
			list( $count ) = $this->db->fetchRow( $result ) ;
			return intval( $count ) ;
		}

		function Broken_Num()
		{
			$broken_num = $this->Total_Num() ;
			return array(
				'num' => $broken_num ,
				'link' => '<a href="'.$this->mod_url.'/admin/index.php?page=brokenmanager">'.sprintf( _MD_D3DOWNLOADS_BROKEN_NUM , $broken_num ).'</a>' ,
			) ;
		}

		function return_sender()
		{
			return intval( $this->sender ) ;
		}

		function return_ip()
		{
			return ( ! empty( $this->ip ) ) ? htmlspecialchars( $this->ip , ENT_QUOTES ) : '-------' ;
		}

		function return_status()
		{
			return $this->myts->makeTboxData4Show( $this->status ) ;
		}

		function return_message()
		{
			return $this->myts->displayTarea( $this->message , 0, 1, 1, 1, 1 ) ;
		}

		function return_name()
		{
			return $this->myts->makeTboxData4Show( $this->name ) ;
		}

		function return_email()
		{
			return $this->myts->makeTboxData4Show( $this->email ) ;
		}

		function getlink_for_sender( $sender )
		{
			$sender_name = ( ! empty( $this->name ) ) ? $this->return_name() : $this->get_postname( $sender ) ;
			if ( $sender > 0 && $sender_name != 'No User' ){
				return '<a href="'.$this->return_user_url( $sender ).'">'.$sender_name.'</a>';
			} else {
				return $sender_name ;
			}
		}

		function mail_link( $sender )
		{
			require_once dirname( dirname(__FILE__) ).'/class/post_check.php' ;
			$post_check = new Post_Check() ;

			$email = $this->get_sender_email( $sender ) ;

			switch( true ) {
				case ( empty( $email ) ) :
					return '' ;
				case ( ! $post_check->mailCheck( $email ) ) :
					return '' ;
				default :
					return '<input type="button" style="color: #808080;background: #FFFFFF;border: 1px solid #999999;" value="Email" onclick="location.href=\'mailto:'.$email.'\'">';
			}
		}

		function get_sender_email( $sender )
		{
			switch( ! empty( $this->email ) ) {
				case true :
					return $this->return_email() ;
				case false :
					return ( $sender > 0 ) ? $this->get_user_email( $sender ) : '' ;
			}
		}

		function filename_link( $id, $cid, $url, $filename, $status, $second=0 )
		{
			$filenamelink = '';
			$link = $this->mod_url.'/index.php?page=visit_url&cid='.$cid.'&lid='.$id ;
			if ( ! preg_match("`^(https?|ftp)://`i", $url ) ) {
				if( ! $this->check_file( $url ) ){
					$filenamelink = '<span style="font-size: small; color: #CC0000;">'.$filename.'</span>';
				} else {
					if( empty( $second ) ){
						$filenamelink = '<a href="'.$link.'"><span style="font-size: small;">'.$filename.'</span></a>';
					} else {
						$filenamelink = '<a href="'.$link.'&second=1"><span style="font-size: small;">'.$filename.'</span></a>';
					}
				}
			} elseif ( preg_match("`^https?://`i", $url ) ) {
				$filenamelink = ( ! empty( $status ) ) ? '<span style="font-size: small; color: #CC0000;">'.$status.'</span>' : '' ;
			}
			return $filenamelink ;
		}
	}
}

// for broken_report

if( ! class_exists( 'broken_report' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/my_http.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class broken_report extends MyDownload
	{
		var $db;
		var $table;
		var $reportid;
		var $lid;
		var $sender;
		var $ip;
		var $status;
		var $message;
		var $name;
		var $mail;
		var $date;
		var $check_mode = false ;
		var $cron_mode = false ;
		var $check_result = false ;
		var $Insertdata = array( 'lid' , 'sender' , 'ip' , 'status' , 'message'  , 'name'  , 'email'  , 'date' ) ;
		var $report_txt = array( 'message'  , 'name'  , 'email' ) ;
		var $name_length = 50 ;
		var $email_length = 60 ;
		var $cron_param_array = array( 'pass' , 'limit' , 'offset' ) ;

		function broken_report( $mydirname )
		{
			global $xoopsUser ;
			include_once dirname( dirname(__FILE__) ).'/include/mytable.php' ;

			$this->mydirname = $mydirname ;
			$this->db =& Database::getInstance() ;
			$this->myts =& d3downloadsTextSanitizer::getInstance() ;
			$this->check_config = $this->get_option_config( 'broken_check_config' ) ;
			$this->http = $this->My_HTTP() ;
			$this->broken_table = $this->db->prefix( "{$mydirname}_broken" ) ;
			$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
			$this->unapproval_table = $this->db->prefix( "{$mydirname}_unapproval" ) ;
			$this->history_table = $this->db->prefix( "{$mydirname}_downloads_history" ) ;
			$this->uploads_dir = XOOPS_TRUST_PATH.'/uploads/'.$this->mydirname ;
			$module_handler =& xoops_gethandler('module') ;
			$config_handler =& xoops_gethandler('config') ;
			$module =& $module_handler->getByDirname( $mydirname ) ;
			$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) ) ;
			$this->mod_config = $mod_config ;
			$this->site_salt = substr( md5( XOOPS_URL ) , -4 ) ;
			if( is_object( $xoopsUser ) ) {
				$this->sender = $xoopsUser->getVar('uid') ;
			} else {
				$this->sender = 0 ;
			}
			$this->ip   = getenv( "REMOTE_ADDR" ) ? getenv( "REMOTE_ADDR" ) : '' ;
			$this->pass = $this->cron_pass() ;
			$this->limit = $this->Total_Num() ;
			$this->offset = 0 ;
	 		foreach( $this->report_txt as $key ) {
				$this->$key =  '' ;
			}
		}

		function getReport()
		{
			$_POST = $this->myts->Delete_Nullbyte( $_POST ) ;

			if( extension_loaded( 'mbstring' ) ) {
				$this->myts->Encoding_Check( $_POST ) ;
			}

			foreach( $this->report_txt as $key ) {
				$this->$key = ( ! empty( $_POST[ $key ] ) ) ? $this->myts->MystripSlashesGPC( @$_POST[ $key ] ) : '' ;
			}
		}

		function geteditData()
		{
			return array(
				'message' => $this->myts->makeTareaData4Edit( $this->message ) ,
				'name'    => $this->myts->makeTboxData4Edit( $this->name ) ,
				'email'   => $this->myts->makeTboxData4Edit( $this->email ) ,
			) ;
		}

		function execute( $lid, $title )
		{
			if ( $this->sender != 0 ) {
				// Check if REG user is trying to report twice.
				$result = $this->db->query( "SELECT COUNT( * ) FROM ".$this->broken_table." WHERE lid='".$lid."' AND sender='".$this->sender."'" ) ;
			} else {
				// Check if the sender is trying to report more than once.
				$result = $this->db->query( "SELECT COUNT( * ) FROM ".$this->broken_table." WHERE lid='".$lid."' AND ip ='".$this->ip."'" ) ;
			}

			list ( $count ) = $this->db->fetchRow( $result ) ;
			if ( $count > 0 ) {
				$this->redirect_message( _MD_D3DOWNLOADS_ALREADYREPORTED ) ;
				exit() ;
			}
			$this->Insert_DB( $lid ) ;
			$this->set_trigger_event( $title ) ;
			$this->redirect_message( _MD_D3DOWNLOADS_ALREADYREPORTED ) ;
			exit() ;
		}

		function Insert_DB( $lid )
		{
			$this->getInsertData( $lid ) ;

			$newid = $this->db->genId( $this->broken_table."_reportid_seq" ) ;

			$set4sql = "reportid='".$newid."'" ;
			foreach( $this->Insertdata as $key ) {
				$set4sql .= ",$key='".$this->$key."'" ;
			}

			$sql = "INSERT INTO ".$this->broken_table." SET $set4sql" ;
			switch( $this->cron_mode ) {
				case false :
					$this->db->query( $sql ) ;
					break ;
				case true :
					$this->db->queryF( $sql ) ;
					break ;
			}

			$new_id = $this->db->getInsertId() ;
			return $new_id ;
		}

		function getInsertData( $lid )
		{
			$this->lid  = $lid ;
			$this->date = time() ;

			switch( $this->check_mode ) {
				case false :
					foreach( $this->report_txt as $key ) {
						$this->$key = ( ! empty( $this->$key ) ) ? addslashes( $this->$key ) : '' ;
					}
					break ;
				case true :
					$this->status  = ( ! empty( $this->status ) )  ? addslashes( $this->status )  : '' ;
					$this->message = ( ! empty( $this->message ) ) ? addslashes( $this->message ) : '' ;
					break ;
			}
		}

		function broken_check( $limit_option=0, $offset_option=0 )
		{
			$errors = array() ;

			$this->check_mode = true ;
			$limit  = ( ! empty( $limit_option ) )  ? intval( $limit_option )  : $this->limit ;
			$offset = ( ! empty( $offset_option ) ) ? intval( $offset_option ) : $this->offset ;

			$errors = $this->check( $limit, $offset ) ;

			redirect_header( XOOPS_URL."/modules/$this->mydirname/admin/index.php?page=brokenmanager" , 2 , $errors ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , implode( ',' , $errors ) ) : _MD_D3DOWNLOADS_LABEL_BROKENCHECKDONE ) ;
			exit() ;
		}

		function broken_check_by_cron()
		{
			$this->check_mode = $this->cron_mode = true ;

			$param = $this->get_array_argv() ;
			$pass  = ( ! empty( $param['pass'] ) ) ? $param['pass'] : '' ;

			if( ! $this->is_sameValue( $pass, $this->pass ) ) die( 'Invaild password' ) ;

			$limit  = ( ! empty( $param['limit'] ) )  ? intval( $param['limit'] )  : $this->limit ;
			$offset = ( ! empty( $param['offset'] ) ) ? intval( $param['offset'] ) : $this->offset ;

			$this->check( $limit, $offset ) ;
		}

		function check( $limit, $offset )
		{
			$this->Nolink_Delete() ;
			$errors = array() ;

			$sql = "SELECT lid, title, url, file2 FROM ".$this->table." WHERE ".$this->whr_append( 'Single' )." ORDER BY lid" ;
			$crs = $this->db->query( $sql, $limit, $offset ) ;
			while( $array = $this->db->fetchArray( $crs ) ) {
				foreach ( $array as $key=>$value ){
					$$key = $value;
				}
				$result = $this->get_check_result( $lid, $title, $url, $file2 ) ;
				if( ! empty( $result ) ) $errors[] = $result ;
			}
			return $errors ;
		}

		function get_check_result( $id, $title, $url, $file2 )
		{
			$error = 0 ;
			$lid = intval( $id ) ;

			$error = $this->check_execution( $lid, $title, $url ) ;

			if ( ! empty( $file2 ) ) $error = $this->check_execution( $lid, $title, $file2 ) ;

			return $error ;
		}

		function check_execution( $lid, $title, $url )
		{
			$error = 0 ;

			$this->check_by_kind( $url ) ;

			if( ! $this->check_result ){
				if( ! $this->check_Insert_DB( $lid, $title ) ) $error = $lid ;
			}
			return $error ;
		}

		function check_by_kind( $value )
		{
			$value = $this->Real_path( $value ) ;

			switch( true ) {
				case ( preg_match("`^https?://`i", $value ) ) :
					$this->check_url( $value ) ;
					break ;
				case ( preg_match("`^ftp://`i", $value ) ) :
					$this->check_result = true ;
					break ;
				default :
					$this->check_file( $value ) ;
			}
		}

		function check_url( $url )
		{
			list( $status_code, $response_code, $redirect_url ) = $this->get_http_status( $url ) ;

			switch( substr( $status_code, 0, 1 ) ) {
				case 1 : // Status Code 1xx
					$this->check_result = true ;
					break ;
				case 2 : // Status Code 2xx
					$this->check_result = true ;
					break ;
				default :
					$this->check_result = false ;
			}

			$this->status  = $response_code ;
			$this->message = ( ! empty( $redirect_url ) ) ? '[url='.$redirect_url.']Redirect url[/url]' : '' ;
		}

		function get_http_status( $url )
		{
			switch( $this->http->execute( $url ) ) {
				case true :
					$redirect_url = ( ! empty( $this->http->redirect_url ) ) ? $this->http->redirect_url : '' ;
					return array( $this->http->status, $this->http->response_code, $redirect_url ) ;
				case false :
					return array( 0, $this->http->error, '' ) ;
			}
		}

		function My_HTTP()
		{
			$http = new My_HTTP() ;

			$int_array = array( 'maxredirect' , 'read_timeout' , 'proxy_port' ) ;

			$default = array(
				'proxy_host'   => '' ,
				'proxy_port'   => '' ,
				'proxy_user'   => '' ,
				'proxy_pass'   => '' ,
				'maxredirect'  =>  0 ,
				'read_timeout' => 20 ,
				'fp_timeout'   => 20 ,
				'cookies'      => array( 'PHPSESSID' => session_id() ) ,
			) ;

			foreach( $default as $key=>$value ){
				$my_config =  ( $this->check_config === '' || empty( $this->check_config[ $key ] ) ) ? '' :
							  ( ( in_array( $key, $int_array ) ) ? intval( $this->check_config[ $key ] ) :
							   $this->check_config[ $key ] ) ;
				
				$http->$key = ( ! empty( $my_config ) ) ? $my_config : $value ;
			}

			return $http ;
		}

		function check_file( $file )
		{
			$this->check_result = ( ! is_file( $file ) || filesize( $file ) == 0 ) ? false : true ;
			$this->status       = ( ! $this->check_result ) ? 'broken file' : '' ;
		}

		function check_Insert_DB( $lid, $title='' )
		{
			$result = true ;

			$crs = $this->db->query( "SELECT COUNT( * ) FROM ".$this->broken_table." WHERE lid='".$lid."'" ) ;
			list ( $count ) = $this->db->fetchRow( $crs ) ;
			if ( empty( $count ) ) {
				$new_id = $this->Insert_DB( $lid ) ;
				if ( empty( $new_id ) ) $result = false ;
				if ( ! empty( $this->cron_mode ) ) $this->set_trigger_event( $title ) ;
			} 
			return $result ;
		}

		function get_array_argv()
		{
			if ( $_SERVER['argc'] <= 1 ) return array() ;

			$array = $argvs = array() ;
			$argvs = $this->myts->Delete_Nullbyte( $_SERVER['argv'] ) ;
			array_shift( $argvs ) ;

			foreach ( $argvs as $arg ) {
				if( strpos ( $arg , '=' ) === false ) continue ;
				list( $key, $value ) = array_map( 'strtolower' , explode( '=', $arg , 2 ) ) ;
				if( in_array( $key, $this->cron_param_array ) ) $array[ $key ] = $value ;
			}
			return $array ;
		}

		function cron_pass()
		{
			return htmlspecialchars( strtolower( $this->mod_config['cron_pass']  ) , ENT_QUOTES ) ;
		}

		function message_option()
		{
			return ( $this->option_config( 'broken_message_from_sender' ) ) ? true : false ;
		}

		function set_trigger_event( $title )
		{
			require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
			$tags = array(
				'POST_TITLE' => $this->myts->makeTboxData4Show( $title ) ,
				'BROKENREPORTS_URL' => XOOPS_URL . '/modules/'.$this->mydirname.'/admin/index.php?page=brokenmanager' ,
			) ;
			d3download_main_trigger_event( $this->mydirname , 'global' , 0 , 'broken' , $tags, 0 ) ;
		}

		function Nolink_Delete()
		{
			if( $handler = @opendir( $this->uploads_dir . '/' ) ) {
				while( ( $file = readdir( $handler ) ) !== false ) {
					$fcount = 0 ;
					$target_file = 'XOOPS_TRUST_PATH/uploads/'. $this->mydirname . '/' . $file ;
					$file_path = $this->uploads_dir . '/' . $file ;
					if( is_file( $file_path ) && strstr( $file_path , $this->site_salt ) ){
						$fcount = $this->Link_Check( $target_file ) ;
						if( empty( $fcount ) ) @unlink( $file_path ) or die("File delete error ". $file ) ;
					}
				}
			}
			closedir( $handler ) ;
		}

		function Link_Check( $file_path )
		{
			$count = 0 ;
			$count += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->table." WHERE ( url='".$file_path."' OR file2='".$file_path."' )" ) ) ;
			$count += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->unapproval_table." WHERE ( url='".$file_path."' OR file2='".$file_path."' )" ) ) ;
			$count += $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->history_table." WHERE ( url='".$file_path."' OR file2='".$file_path."' )" ) ) ;
			return $count ;
		}

		function File_Count()
		{
			$total = $link = $nolink = 0 ;
			if( $handler = @opendir( $this->uploads_dir . '/' ) ) {
				while( ( $file = readdir( $handler ) ) !== false ) {
					$fcount = 0 ;
					$target_file = 'XOOPS_TRUST_PATH/uploads/'. $this->mydirname . '/' . $file ;
					$file_path = $this->uploads_dir . '/' . $file ;
					if( is_file( $file_path ) && strstr( $file_path , $this->site_salt ) ){
						$total++ ;
						$fcount = $this->Link_Check( $target_file ) ;
						if( ! empty( $fcount ) ) $link++ ;
						else $nolink++ ;
					}
				}
			}
			closedir( $handler ) ;
			return array(
				'total'  => $total ,
				'link'   => $link ,
				'nolink' => $nolink ,
			) ;
		}

		function Delete_Report_by_select_lid( $lid )
		{
			$error = 0 ;
			$res = $this->db->query( "SELECT reportid FROM ".$this->broken_table." WHERE lid='".$lid."'" ) ;
			while( list( $id ) = $this->db->fetchRow( $res ) ) {
				$result = $this->Delete_Report( intval( $id ) ) ;
				if( ! empty( $result ) ) $error = $lid ;
			}
			return $error ;
		}

		function Delete_Report( $id )
		{
			$error = 0 ;
			$result = $this->db->query( "DELETE FROM ".$this->broken_table." WHERE reportid='".$id."'" ) ;
			if( ! $result ) $error = $id ;
			return $error ;
		}
	}
}

?>