<?php

if ( ! function_exists('d3download_submit_execution') ) {
	function d3download_submit_execution( $mydirname, $mode, $myparams )
	{
		require_once dirname( dirname(__FILE__) ).'/class/submit_validate.php' ;
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
		include_once dirname( dirname(__FILE__) ).'/include/upload_functions.php' ;

		$db =& Database::getInstance() ;
		global $xoopsUser , $xoopsModuleConfig ;

		// Initialization
		$ispreview = $preview_title = $preview_body = $iserror = $error_message = $downdata = '' ;
		foreach ( $myparams as $key=>$value ){ $$key = $value; }

		// GET POST
		$submit_validate = new Submit_Validate( $mydirname, $mode ) ;

		// requests_01
		$requests_01 = $submit_validate->get_requests_01() ;
		$html = $requests_01['html'];
		$smiley = $requests_01['smiley'];
		$br = $requests_01['br'];
		$xcode = $requests_01['xcode'];
		$createable = empty( $_POST['createable'] ) ? 0 : 1 ;

		// requests_int
		$requests_int = $submit_validate->get_requests_int() ;
		$requestid = intval( @$_POST['requestid'] ) ;
		$cid = $requests_int['cid'];
		$submitter = $requests_int['submitter'];
		$lid = $requests_int['lid'];
		$post_size = $requests_int['size'];

		$date = $requests_int['createdtime'] ;
		$expired = $requests_int['expiredtime'] ;

		// requests_text
		$requests_text = $submit_validate->get_requests_text( $html , $smiley , $xcode , $br ) ;
		$title = $requests_text['title'];
		$post_url = $requests_text['url'];
		if ( preg_match("`^(https?|ftp)://|^XOOPS_URL/`i", $post_url ) && $post_url != 'http://' ) {
			$access_url = str_replace( 'XOOPS_URL' , XOOPS_URL , $post_url ) ;
			$filelink = '[<a href="'.$access_url.'" target="_blank">'._MD_D3DOWNLOADS_SUBMIT_ACCESS_URL.'</a>]' ;
		} else {
			$filelink  = is_array( $downdata ) ? $downdata['downdata']['filelink'] :'' ;
		}
		$post_filename = $requests_text['filename'];
		$post_ext = $requests_text['ext'];
		$post_file2 = $requests_text['file2'];
		$post_filename2 = $requests_text['filename2'];
		$post_ext2 = $requests_text['ext2'];
		$file2_del = empty( $_POST['file2_del'] ) ? 0 : 1 ;
		$body = $requests_text['description'];

		// requests_filters
		$requests_filters = $submit_validate->get_requests_filters() ;

		// requests_admin
		$requests_admin = $submit_validate->get_requests_admin() ;
		$visible = $requests_admin['visible'];
		$notify = empty( $_POST['notify'] ) ? 0 : 1 ;
		$modify = empty( $_POST['modify'] ) ? 0 : 1 ;

		// requests_upload
		if( $mode != 'approval' ) $request4upload  = isset( $_FILES['file_upload'] ) ? @$_FILES['file_upload'] :'' ;

		// postname
		$postname = d3download_postname( $mydirname , $submitter );

		// for after preview edit
		$download4assign = array(
			'requestid' => $requestid ,
			'lid' => $lid ,
			'cid' => $cid ,
			'category' => $category ,
			'title' => $requests_text['title4edit'] ,
			'url' => $requests_text['url4edit'] ,
			'filename' => $requests_text['filename4edit'] ,
			'ext' => $requests_text['ext4edit'] ,
			'file2' => $requests_text['file24edit'] ,
			'filename2' => $requests_text['filename24edit'] ,
			'ext2' => $requests_text['ext24edit'] ,
			'filelink' => $filelink ,
			'filenamelink' => is_array( $downdata ) ? $downdata['downdata']['filenamelink'] :'' ,
			'filenamelink2' => is_array( $downdata ) ? $downdata['downdata']['filenamelink2'] :'' ,
			'file2_del' => $file2_del ,
			'homepage' => $requests_text['homepage4edit'] ,
			'homepagetitle' => $requests_text['homepagetitle4edit'] ,
			'version' => $requests_text['version4edit'] ,
			'size' => $post_size ,
			'platform' => $requests_text['platform4edit'] ,
			'license' => $requests_text['license4edit'] ,
			'logourl' => $requests_text['logourl4edit'] ,
			'shots_link' => ( empty( $requests_text['logourl4edit'] ) ) ? '' : d3download_shots_link_for_post( $mydirname, $cid, $requests_text['logourl4edit'] ) ,
			'description' => $requests_text['description4edit'] ,
			'submitter' => $submitter ,
			'postname' => d3download_getlink_for_postname( $mydirname, $submitter ) ,
			'html' => $html ,
			'smiley' => $smiley ,
			'br' => $br ,
			'xcode' => $xcode ,
			'filters' => d3download_get_myfilter( $mydirname, $requests_filters['filters'] ) ,
			'extra' => $requests_text['extra4edit'] ,
			'visible' => $visible ,
			'cancomment' => $requests_admin['cancomment'] ,
			'createable' => $createable ,
			'expiredable' => empty( $_POST['expiredable'] ) ? 0 : 1 ,
			'date' =>  empty( $createable ) && is_array( $downdata ) ? $downdata['downdata']['date'] : $requests_int['createdtime']  ,
			'expired' => $expired ,
			'notify' => $notify ,
			'modify' => $modify ,
		) ;

		if( $mode != 'approval' ){
			if( ! empty( $html ) && ! $submit_validate->xoops_isadmin ) $submit_validate->Validate_for_html( $cid ) ;
			if( is_array( $request4upload ) && ! $submit_validate->xoops_isadmin ) $submit_validate->Validate_for_upload( $cid ) ;

			if( $mode == 'submit' ) {
				if( ! empty( $auto_approved ) ) $submit_id = $db->genId($db->prefix( $mydirname."_downloads" )."_lid_seq") ;
				else $submit_id = $db->genId($db->prefix( $mydirname."_unapproval" )."_requestid_seq") ;
			}
		
			// requests_upload
	 		if( isset( $_POST['makedownload_post'] ) && is_array( $request4upload ) && $canupload ){
				switch( $mode ) {
					case 'submit' :
						$upload_result = d3download_file_upload( $mydirname, $request4upload, $upload_max_filesize, $submit_id, $submitter ) ;
						break ;
					case 'modfile' :
						$upload_result = d3download_file_upload( $mydirname, $request4upload, $upload_max_filesize, $lid, $submitter ) ;
						break ;
				}
			}

			$url = ! empty( $upload_result[0]['url'] ) ? $upload_result[0]['url'] : $post_url ;
			if( preg_match( '`^(https?|ftp)?://.+\..+|^XOOPS_URL/([^\s]*)+$`i' , $url ) ) {
				$filename = "" ;
				$ext = "" ;
			} else {
				$filename = ! empty( $upload_result[0]['file_name'] ) ? $upload_result[0]['file_name'] : $post_filename ;
				$ext = ! empty( $upload_result[0]['ext'] ) ? $upload_result[0]['ext'] : $post_ext ;
			}
			$size = ! empty( $upload_result[0]['size'] ) ? $upload_result[0]['size'] : $post_size ;

			if( empty( $file2_del ) ){
				$file2 = ! empty( $upload_result[1]['url'] ) ? $upload_result[1]['url'] : $post_file2 ;
				$filename2 = ! empty( $upload_result[1]['file_name'] ) ? $upload_result[1]['file_name'] : $post_filename2 ;
				$ext2 = ! empty( $upload_result[1]['ext'] ) ? $upload_result[1]['ext'] : $post_ext2 ;
			} else {
				$file2 = '' ;
				$filename2 = '' ;
				$ext2 = '' ;
			}

			// “o˜^Ï‚ÌƒŠƒ“ƒN“o˜^‚ð‚¨’f‚è
			if( ! empty( $check_url ) ){
				switch( $mode ) {
					case 'submit' :
						$check_url_result = $submit_validate->Validate_check_url( $url ) ;
						break ;
					case 'modfile' :
						$check_url_result = $submit_validate->Validate_check_url( $url, $lid ) ;
						break ;
				}
				if( ! empty( $check_url_result ) ) $error_message .= $check_url_result . '<br />' ;
			}

			// ³”F‘Ò‚¿‚ÌÄ“o˜^‚Í‚¨’f‚è
			switch( $mode ) {
				case 'submit' :
					$check_unapproval_result =  $submit_validate->Validate_check_unapproval( $url ) ;
					break ;
				case 'modfile' :
					$check_unapproval_result =  $submit_validate->Validate_check_unapproval( $url, $lid ) ;
					break ;
			}
			if( ! empty( $check_unapproval_result ) ) $error_message .= $check_unapproval_result . '<br />' ;
		} 

		// LiveValidation‚É‚æ‚éValidation ‚ª—LŒø‚É‚È‚ç‚È‚¢ŠÂ‹«‚ðl—¶‚µA‚±‚±‚Å‚à“ü—Íƒ`ƒFƒbƒN
		if( $mode != 'approval' ) $validate_result = $submit_validate->Validate( $url, $filename, $file2, $filename2 ) ;
		else $validate_result = $submit_validate->Validate( $post_url, $post_filename, $post_file2, $post_filename2, 1 ) ;
		if( $mode != 'approval' ){
			if( ! empty( $upload_result[0]['error'] ) ) $error_message .= $upload_result[0]['error'] . '( ' .$upload_result[0]['file_name']. ' )<br />' ;
			if( ! empty( $upload_result[1]['error'] ) ) $error_message .= $upload_result[1]['error'] . '( ' .$upload_result[1]['file_name']. ' )<br />' ;
		}
		if( ! empty( $validate_result ) ) $error_message .= implode( '<br />' , $validate_result['message'] ) ;
		if( ! empty( $error_message ) ) $iserror = true;

		if( isset( $_POST['makedownload_preview'] ) ) $ispreview = true;

		if( ! empty( $iserror ) || ! empty( $ispreview ) ){
			return array(
				'iserror' => $iserror ,
				'error_message' => $error_message ,
				'download4assign' => $download4assign ,
				'preview_title' => $requests_text['title4preview'] ,
				'preview_body' => $requests_text['description4preview'] ,
			) ;
		}

		if( isset( $_POST['makedownload_post'] ) && empty( $iserror ) ){
			// set4sql
			$set4sql = "lid='".$lid."'" ;
			$set4sql .= $requests_01['set4sql'] ;
			$set4sql .= $requests_int['set4sql'] ;
			$set4sql .= $requests_text['set4sql'] ;
			$set4sql .= $requests_filters['set4sql'] ;
			$set4sql .= $requests_admin['set4sql'] ;
			if( $mode == 'submit' ) $set4sql .= ",submitter='".$submitter."'" ;
			if( $mode != 'approval' ){
				$set4sql .= ",size='".$size."'" ;
				$Insertdata = array( 'url' ,'filename' , 'ext', 'file2', 'filename2', 'ext2' ) ;
				foreach( $Insertdata as $key ) { $set4sql .= ",$key='".addslashes( $$key )."'" ; }
			}

			switch( $mode ) {
				case 'submit' :
					$params_array = array( 'cid' , 'submit_id' , 'auto_approved' , 'submitter' , 'url' , 'file2' , 'postname' , 'title' , 'body' , 'set4sql' , 'notify' , 'visible' , 'date' , 'expired' ) ;
					break ;
				case 'modfile' :
					$params_array = array( 'cid' , 'lid' , 'auto_approved' , 'postname' , 'title' , 'body' , 'set4sql' , 'notify' , 'visible' , 'date' , 'expired' ) ;
					break ;
				case 'approval' :
					$params_array = array( 'cid' , 'requestid' , 'lid' , 'submitter' , 'post_url' , 'post_file2' , 'postname' , 'title' , 'body' , 'set4sql' , 'notify' , 'modify' ) ;
					break ;
			}

			foreach( $params_array as $key ) { $params[$key] = $$key ; }

			switch( $mode ) {
				case 'submit' :
					d3download_submit_insertdb( $mydirname, $params ) ;
					break ;
				case 'modfile' :
					d3download_modfile_insertdb( $mydirname, $params ) ;
					break ;
				case 'approval' :
					d3download_approval_insertdb( $mydirname, $params ) ;
					break ;
			}
		}
	}
}

if ( ! function_exists('d3download_submit_insertdb') ) {
	function d3download_submit_insertdb( $mydirname, $myparams )
	{
		require_once dirname( dirname(__FILE__) ).'/class/db_download.php' ;
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
		include_once dirname( dirname(__FILE__) ).'/include/upload_functions.php' ;

		$db =& Database::getInstance() ;
		global $xoopsUser , $xoopsModuleConfig ;

		// Initialization
		$error = 0 ;
		foreach ( $myparams as $key=>$value ){ $$key = $value; }

		if( ! empty( $auto_approved ) ) {
			// MAKE LINK SQL
			$make_link = new db_download( $db->prefix( $mydirname."_downloads" ) , "lid", $submit_id ) ;
			$newid = $make_link->db_insert( $set4sql );
			if( empty( $newid ) ) $error = true ;
			d3download_convert_for_newid( $mydirname, $newid, $url, $file2, $submitter );
			d3download_delete_cache_of_categories( $mydirname ) ;
		} else {
			// MAKE UNAPPROVAL LINK SQL
			$set4sql .= ",requestid='".$submit_id."'" ;
			$set4sql .= ",notify='".$notify."'" ;
			$unapproval_link = new db_download( $db->prefix( $mydirname."_unapproval" ) , "requestid", $submit_id ) ;
			$newid = $unapproval_link->db_insert( $set4sql );
			if( empty( $newid ) ) $error = true ;
			d3download_convert_for_unapproval( $mydirname, $newid, $url, $file2, $submitter );
		}

		// Category title
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		$ctitle = $mycategory->return_title() ;

		// Define tags for notification message
		$tags = array();
		$tags = array(
			'POSTER_UNAME' => $postname ,
			'POST_TITLE' => $title ,
			'POST_BODY' => $body ,
			'POST_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?page=singlefile&cid=' . $cid . '&lid=' . $newid,
			'CAT_TITLE' => $ctitle ,
			'CAT_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?cid=' . $cid ,
			'WAITING_URL' => XOOPS_URL . '/modules/' . $mydirname . '/admin/index.php?page=approvalmanager' ,
		) ;
		if( ! empty( $auto_approved ) ) {
			d3download_main_trigger_event( $mydirname , 'global' , 0 , 'newpost' , $tags, 0 ) ;
			d3download_main_trigger_event( $mydirname , 'category' , $cid , 'newpost' , $tags, 0 ) ;
			d3download_main_trigger_event( $mydirname , 'category' , $cid , 'newpostfull' , $tags, 0 ) ;

			// Increment Post
			if( is_object( $xoopsUser ) && ! empty( $xoopsModuleConfig['plus_posts'] ) ) $xoopsUser->incrementPost() ;

			if( ! empty( $error ) ){
				redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , _MD_D3DOWNLOADS_ERROR_MESSEAGE_NOID ) ;
			} elseif( ! empty( $visible ) && $date <= time() && ( $expired == 0 || $expired >=  time() ) ) {
				redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=singlefile&amp;cid=$cid&amp;lid=$newid" , 2 , _MD_D3DOWNLOADS_THANKSSUBMIT ) ;
			} else {
				redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , _MD_D3DOWNLOADS_THANKSSUBMIT ) ;
			}
			exit();
		} else {
			d3download_main_trigger_event( $mydirname , 'global' , 0 , 'waiting' , $tags , 0 ) ;
			if ( ! empty( $notify ) ) {
				include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
				$notification_handler =& xoops_gethandler('notification');
				$notification_handler->subscribe('global', $newid, 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
			}
			if( ! empty( $error ) ){
				redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , _MD_D3DOWNLOADS_ERROR_MESSEAGE_NOID ) ;
			} else {
				redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , _MD_D3DOWNLOADS_THANKSFORINFO ) ;
			}
			exit();
		}
	}
}

if ( ! function_exists('d3download_modfile_insertdb') ) {
	function d3download_modfile_insertdb( $mydirname, $myparams )
	{
		require_once dirname( dirname(__FILE__) ).'/class/db_download.php' ;
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

		$db =& Database::getInstance() ;

		// Initialization
		$error = 0 ;
		foreach ( $myparams as $key=>$value ){ $$key = $value; }

		// LID‚ðŽæ“¾‚Å‚«‚È‚©‚Á‚½ê‡‚Í‚¨’f‚è
		if( empty( $lid ) ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/index.php" , 2 , _MD_D3DOWNLOADS_ERROR_MESSEAGE_NOID ) ;
			exit();
		} elseif ( ! empty( $lid ) && ! empty( $auto_approved ) ) {
			// DOES THE LINK ALREADY EXIST? -- UPDATE SQL
			$make_link = new db_download( $db->prefix( $mydirname."_downloads" ) , "lid", $lid ) ;
			$count = $make_link->db_getrowsnum( $lid );
			if( $count > 0 ){
				require_once dirname( dirname(__FILE__) ).'/class/history_download.php' ;
				$history = new history_download( $mydirname ) ;
				$history->history_Insert_DB( $lid ) ;
				$result = $make_link->db_update( $set4sql, $lid );
				if( ! $result ) $error = $lid ;
				$history->history_Delete( $lid ) ;
				d3download_delete_cache_of_categories( $mydirname ) ;
				if( ! empty( $visible ) && $date <= time() && ( $expired == 0 || $expired >=  time() ) ) {
					redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=singlefile&amp;cid=$cid&amp;lid=$lid" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_THANKSSUBMIT ) ;
				} else {
					redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_THANKSSUBMIT ) ;
				}
				exit();
			}
		} else {
			// MAKE UNAPPROVAL LINK SQL
			$requestid = $db->genId($db->prefix( $mydirname."_unapproval" )."_requestid_seq");
			$set4sql .= ",requestid='".$requestid."'" ;
			$set4sql .= ",notify='".$notify."'" ;
			$unapproval_link = new db_download( $db->prefix( $mydirname."_unapproval" ) , "requestid", $lid ) ;
			$newid = $unapproval_link->db_insert( $set4sql );
			if( empty( $newid ) ) $error = true ;
			// Define tags for notification message
			$tags = array();
			$tags = array(
				'POSTER_UNAME' => $postname ,
				'POST_TITLE' => $title ,
				'POST_BODY' => $body ,
				'WAITING_URL' => XOOPS_URL . '/modules/' . $mydirname . '/admin/index.php?page=approvalmanager' ,
			) ;
			d3download_main_trigger_event( $mydirname , 'global' , 0 , 'waiting' , $tags , 0 ) ;
			if ( ! empty( $notify ) ) {
				include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
				$notification_handler =& xoops_gethandler('notification');
				$notification_handler->subscribe('global', $lid, 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
			}
			if( ! empty( $visible ) && $date <= time() && ( $expired == 0 || $expired >=  time() ) ) {
				redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=singlefile&amp;cid=$cid&amp;lid=$lid" , 2 , $error ? _MD_D3DOWNLOADS_ERROR_MESSEAGE_NOID : _MD_D3DOWNLOADS_THANKSFORINFO ) ;
			} else {
				redirect_header(  XOOPS_URL."/modules/$mydirname/" , 2 , $error ? _MD_D3DOWNLOADS_ERROR_MESSEAGE_NOID : _MD_D3DOWNLOADS_THANKSFORINFO ) ;
			}
			exit();
		}
	}
}

if ( ! function_exists('d3download_approval_insertdb') ) {
	function d3download_approval_insertdb( $mydirname, $myparams )
	{
		require_once dirname( dirname(__FILE__) ).'/class/db_download.php' ;
		require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;
		include_once dirname( dirname(__FILE__) ).'/include/upload_functions.php' ;

		$db =& Database::getInstance() ;
		global $xoopsUser , $xoopsModuleConfig ;

		// Initialization
		$error = 0 ;
		foreach ( $myparams as $key=>$value ){ $$key = $value; }

		// MAKE LINK SQL
		if( ! empty( $requestid ) && empty( $modify ) && empty( $lid ) ) {
			$new_lid = $db->genId($db->prefix( $mydirname."_downloads" )."_lid_seq");
			$make_link = new db_download( $db->prefix( $mydirname."_downloads" ) , "lid", $new_lid ) ;
			$newid = $make_link->db_insert( $set4sql );
			if( empty( $newid ) ) $error = $requestid ;
			d3download_convert_for_newid( $mydirname, $newid, $post_url, $post_file2, $submitter );

			// Category title
			include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
			$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
			$ctitle = $mycategory->return_title() ;

			// Define tags for notification message
			$tags = array();
			$tags = array(
				'POSTER_UNAME' => $postname ,
				'POST_TITLE' => $title ,
				'POST_BODY' => $body ,
				'POST_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?page=singlefile&cid=' . $cid . '&lid=' . $newid,
				'CAT_TITLE' => $ctitle ,
				'CAT_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?cid=' . $cid ,
			) ;
			d3download_main_trigger_event( $mydirname , 'global' , 0 , 'newpost' , $tags, 0 ) ;
			d3download_main_trigger_event( $mydirname , 'category' , $cid , 'newpost' , $tags, 0 ) ;
			d3download_main_trigger_event( $mydirname , 'category' , $cid , 'newpostfull' , $tags, 0 ) ;
			if( ! empty( $notify ) ){
				d3download_main_trigger_event( $mydirname , 'global' , $requestid , 'approve' , $tags, 0 ) ;
			}

			// Increment Post
			if( $submitter > 0 && ! empty( $xoopsModuleConfig['plus_posts'] ) ) {
				$user = new XoopsUser( $submitter ) ;
				$user->incrementPost() ;
			}
		} elseif( ! empty( $requestid ) && ! empty( $modify ) && ! empty( $lid ) ) {
			// UPDATE SQL
			$make_link = new db_download( $db->prefix( $mydirname."_downloads" ) , "lid", $lid ) ;
			$count = $make_link->db_getrowsnum( $lid );
			if( $count > 0 ){
				require_once dirname( dirname(__FILE__) ).'/class/history_download.php' ;
				$history = new history_download( $mydirname ) ;
				$history->history_Insert_DB( $lid ) ;
				$result = $make_link->db_update( $set4sql, $lid );
				if( ! $result ) $error = $lid ;
				$history->history_Delete( $lid ) ;
				if( ! empty( $notify ) ){
					// Define tags for notification message
					$tags = array();
					$tags = array(
						'POST_TITLE' => $title ,
						'POST_URL' => XOOPS_URL . '/modules/' . $mydirname . '/index.php?page=singlefile&cid=' . $cid . '&lid=' . $lid,
					) ;
					d3download_main_trigger_event( $mydirname , 'global' , $lid , 'approve' , $tags, 0 ) ;
				}
			}
		}
		$sql = "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_unapproval" )." WHERE requestid='".$requestid."'";
		list( $count ) = $db->fetchRow( $db->query( $sql ) );
		if( $count > 0 ){
			$sql = "DELETE FROM ".$db->prefix($mydirname."_unapproval")." WHERE requestid = ".$requestid;
			$result = $db->query($sql);
			if( ! $result ) $error = $requestid ;
		}
		d3download_delete_cache_of_categories( $mydirname ) ;
		redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=approvalmanager" , 2 , $error ? sprintf( _MD_D3DOWNLOADS_ERROR_MESSEAGE , $error ) : _MD_D3DOWNLOADS_SUBMIT_APPROVED ) ;
		exit();
	}
}

if ( ! function_exists('d3download_file_manager_data_update') ) {
	function d3download_file_manager_data_update( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		$_POST = $myts->Delete_Nullbyte( $_POST );
		$errors = array() ;
		$array4sql = array( 'title' , 'visible' , 'cancomment' ) ;

		foreach( $_POST['title'] as $id => $value ) {
			if( empty( $_POST['title'][$id] ) ){
				$errors[] = $id ;
			} else {
				$lid = intval( $id ) ;
				$title = mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['title'][$id] ) ) ;
				$visible = empty( $_POST['visible'][$id] ) ? 0 : 1 ;
				$cancomment = empty( $_POST['comment'][$id] ) ? 0 : 1 ;
				$set4sql = "lid='".$lid."'" ;
				foreach( $array4sql as $key ) {
					$set4sql .= ",$key='".$$key."'" ;
				}
				$sql="UPDATE ".$db->prefix( $mydirname."_downloads" )." SET $set4sql WHERE lid='".$lid."'";
				$result = $db->query( $sql );
				if( ! $result ) $errors[] = $lid ;
			}
		}
		return $errors ;
	}
}

if ( ! function_exists('d3download_file_manager_move_action') ) {
	function d3download_file_manager_move_action( $mydirname, $cid )
	{
		$db =& Database::getInstance() ;

		$errors = array() ;
		foreach( $_POST['action_selects'] as $id => $value ) {
			$lid = intval( $id ) ;
			$res = $db->query( "SELECT * FROM ".$db->prefix( $mydirname."_downloads" )." WHERE lid='".$lid."' AND cid='".$cid."'" ) ;
			$checksum = $db->getRowsNum( $res ) ;
			if( empty( $checksum ) ){
				$result = $db->query( "UPDATE ".$db->prefix( $mydirname."_downloads" )." SET cid='".$cid."' WHERE lid='".$lid."'" ) ;
				if( ! $result ) $errors[] = $lid ;
			}
		}
		return $errors ;
	}
}

if ( ! function_exists('d3download_categorymanager_data_update') ) {
	function d3download_categorymanager_data_update( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;
		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$db =& Database::getInstance() ;

		// DELETE NULLBYTE
		$_POST = $myts->Delete_Nullbyte( $_POST );

		$errors = array() ;
		$array4sql = array( 'title' , 'cat_weight' ) ;

		foreach( $_POST['weights'] as $id => $weights ) {
			if( empty( $_POST['title'][$id] ) ){
				$errors[] = $id ;
			} else {
				$cid = intval( $id ) ;
				$title = mysql_real_escape_string( $myts->stripSlashesGPC( @$_POST['title'][$id] ) ) ;
				$cat_weight = intval( $weights ) ;
				$set4sql = "cid='".$cid."'" ;
				foreach( $array4sql as $key ) {
					$set4sql .= ",$key='".$$key."'" ;
				}
				$sql="UPDATE ".$db->prefix( $mydirname."_cat" )." SET $set4sql WHERE cid='".$cid."'";
				$result = $db->query( $sql );
				if( ! $result ) $errors[] = $lid ;
			}
		}
		return $errors ;
	}
}

if ( ! function_exists('d3download_submit_message') ) {
	function d3download_submit_message( $mydirname, $cid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		$submit_message = $mycategory->return_submit_message() ;
		if( ! empty( $submit_message ) ){
			return $submit_message ;
		} else {
			return '' ;
		}
	}
}

if ( ! function_exists('d3download_can_useshots') ) {
	function d3download_can_useshots( $mydirname )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname ) ;
		return $mydownload->can_useshots() ;
	}
}

if ( ! function_exists('d3download_shots_dir') ) {
	function d3download_shots_dir( $mydirname, $cid )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
		$mycategory = new MyCategory( $mydirname, 'Show', $cid ) ;
		$cate_shotsdir = $mycategory->return_shotsdir() ;
		if( ! empty( $cate_shotsdir ) && file_exists( XOOPS_ROOT_PATH.'/'.$cate_shotsdir ) ){
			$shots_dir = XOOPS_ROOT_PATH.'/'.$cate_shotsdir;
		} else {
			$shots_dir = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/images/shots/';
		}
		return $shots_dir ;
	}
}

if ( ! function_exists('d3download_shots_link_for_post') ) {
	function d3download_shots_link_for_post( $mydirname, $cid, $logourl )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname ) ;
		return $mydownload->shots_link_for_post( $cid, $logourl ) ;
	}
}

if ( ! function_exists('d3download_get_myfilter') ) {
	function d3download_get_myfilter( $mydirname, $currentdata ='' )
	{
		include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname ) ;
		return $mydownload->get_MyFilter( $currentdata ) ;
	}
}

if ( ! function_exists('d3download_get_broken_data') ) {
	function d3download_get_broken_data( $mydirname, $lid )
	{
		require_once dirname( dirname(__FILE__) ).'/class/broken_download.php' ;
		$broken_download = new broken_download( $mydirname ) ;
		return $broken_download->Broken_of_Currentlid( $lid ) ;
	}
}

if ( ! function_exists('d3download_get_user_vote') ) {
	function d3download_get_user_vote( $mydirname, $lid )
	{
		require_once dirname( dirname(__FILE__) ).'/class/rate_download.php' ;
		$rate_download = new rate_download( $mydirname ) ;
		return $rate_download->Get_User_vote( $lid ) ;
	}
}

if ( ! function_exists('d3download_get_guest_vote') ) {
	function d3download_get_guest_vote( $mydirname, $lid )
	{
		require_once dirname( dirname(__FILE__) ).'/class/rate_download.php' ;
		$rate_download = new rate_download( $mydirname ) ;
		return $rate_download->Get_Guest_vote( $lid ) ;
	}
}

if ( ! function_exists('d3download_dbmoduleheader_for_livevalidation') ) {
	function d3download_dbmoduleheader_for_livevalidation( $mydirname, $add_array=array() )
	{
		include_once dirname( dirname(__FILE__) ).'/include/module_header.php' ;

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );

		$css_uri = ( empty( $mod_config['live_uri'] ) ) ? '{mod_url}/index.php?page=module_header&src=livevalidation.css' : htmlspecialchars( @$mod_config['live_uri'] , ENT_QUOTES ) ;

		$array = array_merge( array( $css_uri , 'livevalidation.js' , 'jquery.js' , 'jquery.textarearesizer.js' , 'seekAttention.jquery.js' , 'd3downloads.js' ) , $add_array ) ;
		return d3download_add_moduleheader( $mydirname, $array ) ;
	}
}

if ( ! function_exists('d3download_delete_livevalidation') ) {
	function d3download_delete_livevalidation()
	{
		$js_path = XOOPS_ROOT_PATH.'/cache/livevalidation.js' ;
		if ( file_exists( $js_path ) ){
			@unlink( $js_path );
		}
	}
}

?>