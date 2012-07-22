<?php

// for Get_Post , Submit_Validate , Set4sql etc.

if( ! class_exists( 'Submit_Validate' ) )
{
	include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/post_check.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
	require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

	class Submit_Validate extends MyDownload
	{
		var $mode = "" ;
		var $requests_01 = array( 'html', 'smiley' , 'br' , 'xcode' ) ;
		var $requests_int = array( 'lid' ,'cid' , 'size' , 'submitter' ) ;
		var $requests_text = array( 'title' , 'url' , 'filename' , 'ext' , 'file2' , 'filename2' , 'ext2' , 'homepage' , 'homepagetitle' , 'version', 'platform', 'license', 'logourl', 'description', 'extra' ) ;
		var $requests_admin = array( 'visible',  'cancomment' ) ;
		var $title_length = 100 ;
		var $url_length = 250 ;
		var $filename_length = 50 ;
		var $ext_length = 10 ;
		var $file2_length = 250 ;
		var $filename2_length = 50 ;
		var $ext2_length = 10 ;
		var $homepage_length = 100 ;
		var $homepagetitle_length = 255 ;
		var $version_length = 10 ;
		var $size_length = 10 ;
		var $platform_length = 50 ;
		var $license_length = 255 ;
		var $logourl_length = 60 ;
		var $html ;
		var $smiley ;
		var $br ;
		var $xcode ;
		var $filters ;
		var $lid ;
		var $cid ;
		var $size ;
		var $submitter ;
		var $created ;
		var $expired ;
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
		var $platform ;
		var $license ;
		var $logourl ;
		var $description ;
		var $extra ;
		var $visible ;
		var $cancomment ;

		function Submit_Validate( $mydirname="", $mode="" )
		{
			if( ! empty( $mydirname ) ) $this->mydirname = $mydirname ;
			if( ! empty( $mode ) ) $this->mode = $mode ;

			if( ! empty( $mydirname ) ) {
				global $xoopsUser ;

				$this->db =& Database::getInstance();
				$this->myts =& d3downloadsTextSanitizer::getInstance() ;
				$this->table = $this->db->prefix( "{$mydirname}_downloads" ) ;
				$this->post_check = new Post_Check() ;
				$this->user_access = new user_access( $mydirname ) ;
				if( isset( $_POST['myencode'] ) && extension_loaded( 'mbstring' ) ) {
					$this->encode = mb_detect_encoding( $_POST['myencode'] );
				} else {
					$this->encode = "";
				}
				$module_handler =& xoops_gethandler('module');
				$config_handler =& xoops_gethandler('config');
				$module =& $module_handler->getByDirname( $mydirname );
				$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );
				$this->mod_config = $mod_config ;
				if( is_object( $xoopsUser ) ) {
					$this->xoops_isuser = true ;
					$this->xoops_userid = $xoopsUser->getVar('uid') ;
					$mid = $module->getVar('mid') ;
					$this->xoops_isadmin = $xoopsUser->isAdmin( $mid ) ;
					$this->xoops_groups = $xoopsUser->getGroups() ;
				} else {
					$this->xoops_isuser = false ;
					$this->xoops_userid = 0 ;
					$this->xoops_isadmin = false ;
					$this->xoops_groups = intval( XOOPS_GROUP_ANONYMOUS ) ;
				}

				// Delete_Nullbyte
				$_POST = $this->myts->Delete_Nullbyte( $_POST ) ;

				// Encoding_Check
				if( extension_loaded( 'mbstring' ) ) {
					$this->myts->Encoding_Check( $_POST ) ;
				}
			}
		}

		function get_requests_01()
		{
			// requests_01 Initialization
			$html = $smiley = $br = $xcode = 0 ;

			// get 01
			foreach( $this->requests_01 as $key ) {
				$$key = empty( $_POST[ $key ] ) ? 0 : 1 ;
			}

			// set4sql
			$set4sql = "" ;
			foreach( $this->requests_01 as $key ) {
				$set4sql .= ",$key='".$$key."'" ;
			}

			return array(
				'html'    => $html ,
				'smiley'  => $smiley ,
				'br'      => $br ,
				'xcode'   => $xcode ,
				'set4sql' => $set4sql ,
			) ;
		}

		function get_requests_int()
		{
			// requests_int Initialization
			$lid = $cid = $size = $submitter = $created = $expired = 0 ;

			switch( $this->mode ) {
				case 'submit' :
					$current_requests_int = array_diff( $this->requests_int, array( 'lid' , 'size' , 'submitter' ) ) ;
					break ;
				case 'modfile' :
					$current_requests_int = array_diff( $this->requests_int, array( 'lid' , 'size' ) ) ;
					break ;
				case 'approval' :
					$current_requests_int = array_diff( $this->requests_int, array( 'lid' ) ) ;
					break ;
			}

			// intval
			foreach( $current_requests_int as $key ) {
				$$key = intval( @$_POST[ $key ] ) ;
			}

			$lid = intval( @$_POST['lid'] ) ;
			if( $this->mode == 'submit' ) $submitter = $this->xoops_userid ;
			$size = intval( @$_POST['size'] ) ;

			$createdtime = $this->return_createdtime() ;
			$expiredtime = $this->return_expiredtime() ;

			// set4sql
			$set4sql = "" ;
			foreach( $current_requests_int as $key ) {
				$set4sql .= ",$key='".$$key."'" ;
			}
			$set4sql .= ",date='".$createdtime."'" ;
			$set4sql .= ",expired='".$expiredtime."'" ;

			return array(
				'cid'         => $cid ,
				'submitter'   => $submitter ,
				'lid'         => $lid ,
				'size'        => $size ,
				'createdtime' => $createdtime ,
				'expiredtime' => $expiredtime ,
				'set4sql'     => $set4sql ,
			) ;
		}

		function get_requests_text( $html , $smiley , $xcode , $br )
		{
			// requests_text Initialization
			$title = $url = $filename = $ext = $file2 = $filename2 = $ext2 = $homepage = $homepagetitle = $version = $platform = $license = $logourl = $description =  $extra = "" ;

			switch( $this->mode ) {
				case 'approval' :
					$current_requests_text = array_diff( $this->requests_text, array( 'description' ) ) ;
					break ;
				default :
					$current_requests_text = array_diff( $this->requests_text, array( 'url' , 'description' ) ) ;
			}

			// stripSlashesGPC
			foreach( $current_requests_text as $key ) {
				$$key =  $this->myts->MystripSlashesGPC( @$_POST[ $key ] , $this->encode ) ;
			}
			$posturl = $this->myts->MystripSlashesGPC( @$_POST['url'], $this->encode ) ;
			$replacements = array() ;
			$searches = 'XOOPS_ROOT_PATH' ;
			$replacements = XOOPS_ROOT_PATH ;
			$url = str_replace( $searches , $replacements , $posturl ) ;
			if( $this->mode == 'approval' ) {
				$description = $this->replace_pagebreak( $this->myts->stripSlashesGPC( @$_POST['description'], $this->encode )  ) ;
			} else {
				$description = $this->replace_pagebreak( $this->myts->stripSlashesGPC( @$_POST['desc'], $this->encode )  ) ;
			}

			// Data4Edit
			$requests_text4edit = array_diff( $this->requests_text, array( 'url' , 'description' ) ) ;
			foreach( $requests_text4edit as $key ) {
				$data4edit[$key] = $this->myts->makeTboxData4Edit( $$key ) ;
			}
			$url4edit = $this->myts->makeTboxData4Edit( $posturl ) ;
			$description4edit = $this->myts->makeTareaData4Edit( $description ) ;

			// previewdata
			$title4preview = $this->myts->makeTboxData4Show( $title ) ;
			$use_htmlpurifierl = $this->use_htmlpurifierl() ;
			$filters = $this->return_filters() ;
			$str = $this->return_body_for_preview( $description, $use_htmlpurifierl, $html, $smiley, $xcode, $br, $filters ) ;
			$description4preview = $this->replace_for_preview( $str, $title , $filename, $filename2 ) ;
			if( ! empty( $extra ) ) $description4preview .= $this->return_extra_for_preview( $extra, $title , $filename, $filename2 ) ;

			// set4sql
			switch( $this->mode ) {
				case 'approval' :
					$requests_text4sql = array_diff( $this->requests_text, array( 'description' ) ) ;
					break ;
				default :
					$requests_text4sql = array_diff( $this->requests_text, array( 'url' , 'filename' , 'ext' , 'file2' , 'filename2' , 'ext2' , 'description' ) ) ;
			}

			$set4sql = "" ;
			foreach( $requests_text4sql as $key ) {
				$set4sql .= ",$key='".addslashes( $$key )."'" ;
			}
			if( ! empty( $html ) && ! empty( $use_htmlpurifierl ) ){
				$text = $this->myts->myFilter( $description ) ;
				$description4sql = addslashes( $text ) ;
			} else {
				$description4sql = addslashes( $description ) ;
			}
			$set4sql .= ",description='".$description4sql."'" ;

			return array(
				'title'               => $title ,
				'homepage'            => $homepage ,
				'homepagetitle'       => $homepagetitle ,
				'version'             => $version ,
				'platform'            => $platform ,
				'license'             => $license ,
				'logourl'             => $logourl ,
				'url'                 => $url ,
				'filename'            => $filename ,
				'ext'                 => $ext ,
				'file2'               => $file2 ,
				'filename2'           => $filename2 ,
				'ext2'                => $ext2 ,
				'description'         => $description ,
				'extra'               => $extra ,
				'title4edit'          => $data4edit['title'] ,
				'homepage4edit'       => $data4edit['homepage']  ,
				'homepagetitle4edit'  => $data4edit['homepagetitle'] ,
				'version4edit'        => $data4edit['version'] ,
				'platform4edit'       => $data4edit['platform'] ,
				'license4edit'        => $data4edit['license'] ,
				'logourl4edit'        => $data4edit['logourl'] ,
				'url4edit'            => $url4edit ,
				'filename4edit'       => $data4edit['filename'] ,
				'ext4edit'            => $data4edit['ext'] ,
				'file24edit'          => $data4edit['file2'] ,
				'filename24edit'      => $data4edit['filename2'] ,
				'ext24edit'           => $data4edit['ext2'] ,
				'description4edit'    => $description4edit ,
				'extra4edit'          => $data4edit['extra'] ,
				'title4preview'       => $title4preview ,
				'description4preview' => $description4preview ,
				'set4sql'             => $set4sql ,
			) ;
		}

		function get_requests_filters()
		{
			$filters = "" ;

			$filters = $this->return_filters() ;
			$set4sql = ",filters='".addslashes( $filters )."'" ;
			return array(
				'filters' => $filters ,
				'set4sql' => $set4sql ,
			) ;
		}

		function get_requests_admin()
		{
			// requests_admin Initialization
			$visible = $cancomment = 0 ;

			// get 01
			foreach( array_diff( $this->requests_admin, array( 'cancomment' ) ) as $key ) {
				$$key = empty( $_POST[ $key ] ) ? 0 : 1 ;
			}
			$cancomment = empty( $_POST['comment'] ) ? 0 : 1 ;

			// set4sql
			$set4sql = "" ;
			foreach( array_diff( $this->requests_admin, array( 'cancomment' ) ) as $key ) {
				$set4sql .= ",$key='".$$key."'" ;
			}
			$set4sql .= ",cancomment='".$cancomment."'" ;

			return array(
				'visible'    => $visible ,
				'cancomment' => $cancomment ,
				'set4sql'    => $set4sql ,
			) ;
		}

		function return_createdtime()
		{
			$createable = empty( $_POST['createable'] ) ? 0 : 1 ;
			if( $createable ) {
				$created = $_POST['created'];
				if( isset( $created ) && is_array( $created ) ) {
					return mktime( intval( $created['Time_Hour'] ), intval( $created['Time_Minute'] ), 0, intval( $created['Date_Month'] ), intval( $created['Date_Day'] ), intval( $created['Date_Year'] ) ) ;
				} else {
					return time() ;
				}
			} else {
				return time() ;
			}
		}

		function return_expiredtime()
		{
			$expiredable = empty( $_POST['expiredable'] ) ? 0 : 1 ;
			if( $expiredable ) {
				$expired = $_POST['expired'] ;
				if( isset( $expired ) && is_array( $expired ) ) {
					return mktime( intval( $expired['Time_Hour'] ), intval( $expired['Time_Minute'] ), 0, intval( $expired['Date_Month'] ), intval( $expired['Date_Day'] ), intval ($expired['Date_Year'] ) ) ;
				} else {
					return 0 ;
				}
			} else {
				return 0 ;
			}
		}

		function return_body_for_preview( $text, $use_htmlpurifierl, $html, $smiley, $xcode, $br, $filters )
		{
			if ( strstr ( $text , '[pagebreak]' ) ){
				$text = str_replace( '[pagebreak]','', $this->replace_pagebreak( $text  ) ) ;
			}
			if( ! empty( $use_htmlpurifierl ) && ! empty( $html ) ){
				$text = $this->myts->myFilter( $text );
			}
			return $this->myts->displayTarea( $text, $html, $smiley, $xcode, 1, $br, $filters ) ;
		}

		function replace_pagebreak( $text )
		{
			$searches     = array( '`<p>(.*)\[pagebreak]</p>`i' , '`<div>(.*)\[pagebreak]</div>`i' ) ;
			$replacements = array( '$1[pagebreak]' , '$1[pagebreak]' ) ;
			$text         = preg_replace( $searches , $replacements , $text ) ;

			return $text ;
		}

		function return_extra_for_preview( $extra, $title , $filename, $filename2 )
		{
			$array = $this->extra_array( $extra, 1, 0, 1 ) ;
			if( empty( $array ) ) return '' ;

			$html  = '<br /><br />' ;
			$html .= '<table style="margin-top: 0.2em;margin-bottom: 1em;border-collapse: collapse;border: solid 1px #999;font-size: 100%;">' ;
			foreach( $array as $info ){
				$html .= '<tbody><tr>' ;
				$html .= '<td style="text-align: center;vertical-align:middle;border: solid 1px #999;font-size: 110%;font-weight: bolder;" width="20%">' ;
				$html .= $info['title'] ;
				$html .= '</td>' ;
				$html .= '<td style="text-align: left;border: solid 1px #999;padding: 4px 6px;vertical-align:middle;" width="80%">' ;
				$html .= $this->replace_for_preview( $info['desc'], $title , $filename, $filename2 ) ;
				$html .= '</td></tr>' ;
			}
			$html .= '</tbody></table>' ;
			
			return $html ;
		}

		function replace_for_preview( $text, $title , $filename, $filename2 )
		{
			global $xoopsConfig ;

			$expired = ( $this->return_expiredtime() ) ? formatTimestamp( $this->return_expiredtime(), 'l', $xoopsConfig['default_TZ'] ) : '' ;

			$searches = array(
				'[title]' ,
				'[filename]' ,
				'[filename2]' ,
				'[expired]' ,
			) ;
			$replacements = array(
				$title ,
				$filename ,
				$filename2 ,
				$expired ,
			) ;
			return str_replace( $searches , $replacements , $text ) ;
		}

		function use_htmlpurifierl()
		{
			if( is_array( $this->mod_config['use_htmlpurifier'] ) ) {
				return $this->htmlpr_except() ;
			} else {
				return $this->htmlpr_on_off() ;
			}
		}

		function htmlpr_except()
		{
			if( $this->xoops_isuser ) {
				return ( count( array_intersect( $this->xoops_groups , @$this->mod_config['use_htmlpurifier'] ) ) > 0 ) ? false : true ;
			} else {
				return true ;
			}
		}

		function htmlpr_on_off()
		{
			if( $this->xoops_isuser ) {
				return ( empty( $this->mod_config['use_htmlpurifier'] ) ) ? false : true ;
			} else {
				return true ;
			}
		}

		function return_filters()
		{
			$filters = array() ;
			foreach( $_POST as $key => $val ) {
				if( substr( $key , 0 , 15 ) == 'filter_enabled_' && $val ) {
					$name = str_replace( '..' , '' , substr( $key , 15 ) ) ;
					$filter_path = dirname( dirname(__FILE__) ).'/filters/enabled/d3downloads_'.$name.'.php' ;
					if( ! file_exists( $filter_path ) ) continue ;
					$filters[$name] = $name;
				}
			}
			asort( $filters ) ;
			return implode( '|' , array_keys( $filters ) ) ;
		}

		function Validate( $url, $filename, $file2, $filename2, $no_file_delete=0 )
		{
			$void_check = $url_check = $file2_check = $homepage_check = $size_check = $max_check = array() ;

			// get post data
			$current_requests_text = array_diff( $this->requests_text, array( 'url' , 'filename', 'file2', 'filename2', 'description' ) ) ;
			foreach( $current_requests_text as $key ) {
				$this->$key = $this->myts->MystripSlashesGPC( @$_POST[ $key ] ) ;
			}
			$real_url = $this->Real_path( $url ) ;
			$real_file2 = $this->Real_path( $file2 ) ;
			if( $this->mode == 'approval' ) {
				$this->description = $this->myts->stripSlashesGPC( @$_POST['description'] ) ;
			} else {
				$this->description = $this->myts->stripSlashesGPC( @$_POST['desc'] ) ;
			}
			$this->size = @$_POST['size'] ;

			// Validate
			$void_check = array(
				array(
					'value'   => $this->title,
					'type'    => array('void'),
					'message' => _MD_D3DOWNLOADS_TITLE_NONE
				), 
				array(
					'value'   => $real_url,
					'type'    => array('void'),
					'message' => _MD_D3DOWNLOADS_URL_NONE
				), 
				array(
					'value'   => $this->description,
					'type'    => array('void'),
					'message' => _MD_D3DOWNLOADS_DESCRIPTION_NONE
				), 
			) ;

			if ( preg_match('/^'.preg_quote( XOOPS_TRUST_PATH, '/' ).'|^'.preg_quote( XOOPS_ROOT_PATH, '/' ).'/i', $real_url ) ) {
				$url_check = array(
					array(
						'value'   => $real_url,
						'type'    => array('is_file'),
						'message' => sprintf( _MD_D3DOWNLOADS_FILE_CHECK, $filename )
					), 
				);
			} else {
				$url_check = array(
					array(
						'value'   => $real_url,
						'type'    => array('url'),
						'message' => _MD_D3DOWNLOADS_URL_CHECK
					), 
				) ;
			}

			if( ! empty( $real_file2 ) ) $file2_check = array(
				array(
					'value'   => $real_file2,
					'type'    => array('is_file'),
					'message' => sprintf( _MD_D3DOWNLOADS_FILE_CHECK, $filename2 )
				), 
			) ;

			if( $this->homepage != "http://" && ! empty( $this->homepage ) ){
				$homepage_check = array(
					array(
						'value'   => $this->homepage,
						'type'    => array('url'),
						'message' => _MD_D3DOWNLOADS_HOMEPAGE_CHECK
					), 
				) ;
			}

			if( ! empty( $this->size ) ) $size_check = array(
				array(
					'value'   => array( $this->size, '/^[0-9]+$/' ),
					'type'    => array('format'),
					'message' => _MD_D3DOWNLOADS_SIZE_CHECK
				), 
			) ;

			$max_check = array(
				array(
					'value'   => array( $this->title, $this->title_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_TITLE_TOOLONG, $this->title_length )
				), 
				array(
					'value'   => array( $url, $this->url_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_URL_TOOLONG, $this->url_length )
				), 
				array(
					'value'   => array( $filename, $this->filename_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_FILENAME_TOOLONG, $this->filename_length )
				), 
				array(
					'value'   => array( $this->size, $this->size_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_SIZE_TOOLONG, $this->size_length )
				), 
				array(
					'value'   => array( $this->homepage, $this->homepage_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_HOMEPAGE_TOOLONG, $this->homepage_length )
				), 
				array(
					'value'   => array( $this->homepagetitle, $this->homepagetitle_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_HOMEPAGETITLE_TOOLONG, $this->homepagetitle_length )
				), 
				array(
					'value'   => array( $this->version, $this->version_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_VERSION_TOOLONG, $this->version_length )
				), 
				array(
					'value'   => array( $this->platform, $this->platform_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_PLATFORM_TOOLONG, $this->platform_length )
				), 
				array(
					'value'   => array( $this->license, $this->license_length ),
					'type'    => array('max'),
					'message' => sprintf( _MD_D3DOWNLOADS_LICENSE_TOOLONG, $this->license_length )
				), 
			) ;

			$params = array_merge( $void_check, $url_check, $file2_check, $homepage_check, $size_check, $max_check );
			$result = $this->post_check->check( $params );
			if( $this->post_check->getErrorCount() && empty( $no_file_delete ) ) $this->delete_file( $url, $file2, $real_url, $real_file2 ) ;
			return array(
				'error'   => $this->post_check->error_count ,
				'message' => $this->post_check->error_message ,
			) ;
		}

		function delete_file( $url, $file2, $real_url, $real_file2 )
		{
			$fsum = $f2sum = 0 ;
			if ( is_file( $real_url ) ){
				$fsum = $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->table." WHERE url='".$url."'" ) );
				if ( empty( $fsum ) ){
					@unlink( $real_url );
				}
			}
			if ( is_file( $real_file2 ) ){
				$f2sum = $this->db->getRowsNum( $this->db->query( "SELECT * FROM ".$this->table." WHERE file2='".$file2."'" ) );
				if ( empty( $f2sum ) ){
					@unlink( $real_file2 );
				}
			}
		}

		function Validate_for_html( $cid )
		{
			$canhtml = $this->user_access->can_html4cid( $cid ) ;
			if( ! $canhtml ) die( 'You cannot use html.' );
		}

		function Validate_for_upload( $cid )
		{
			$canupload = $this->user_access->can_upload4cid( $cid ) ;
			if( ! $canupload ) die( 'You cannot use upload.' ) ;
		}

		function Validate_for_delete( $cid, $lid )
		{
			$candelete = $this->user_access->can_delete4cid( $cid ) ;
			$submitter = $this->xoops_userid ;
			if( ! $candelete ) die( _MD_D3DOWNLOADS_NODELEPERM );
			$sql = "SELECT COUNT(*) FROM ".$this->table." WHERE submitter='".$submitter."' AND lid='".$lid."'" ;
			list( $count ) = $this->db->fetchRow( $this->db->query( $sql ) ) ;
			if( empty( $count ) ) die( _MD_D3DOWNLOADS_NODELEPERM ) ;
		}

		function Validate_check_url( $url, $lid= 0 )
		{
			$sql = "SELECT COUNT( lid ) FROM ".$this->table." WHERE url='".$url."'" ;
			if ( ! empty( $lid ) ) {
				$sql .= " AND lid NOT IN ( '".$lid."' )" ;
			}
			$res = $this->db->query( $sql ) ;
			list( $num ) = $this->db->fetchRow( $res ) ;
			if( ! empty( $num ) ){
				return  _MD_D3DOWNLOADS_URL_ONCE ;
			} else {
				return  '' ;
			}
		}

		function Validate_check_unapproval( $url, $lid= 0 )
		{
			$sql = "SELECT COUNT( requestid ) FROM ".$this->db->prefix( $this->mydirname."_unapproval" )." WHERE url='".$url."'" ;
			if ( ! empty( $lid ) ) {
				$sql .= " OR lid='".$lid."'" ;
			}
			$res = $this->db->query( $sql ) ;
			list( $num ) = $this->db->fetchRow( $res ) ;
			if( ! empty( $num ) && empty( $lid ) ){
				return  _MD_D3DOWNLOADS_UNAPPROVAL_ONCE ;
			} elseif( ! empty( $num ) && ! empty( $lid ) ){
				return  _MD_D3DOWNLOADS_MODFILE_ONCE ;
			} else {
				return  '' ;
			}
		}
	}
}

?>