<?php

if ( ! function_exists('d3download_get_module_header_request') ) {
	function d3download_get_module_header_request( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$template = $file_path = $type = '' ;

		$_GET = $myts->Delete_Nullbyte( $_GET ) ;
		$my_file = preg_replace( '/[^0-9a-zA-Z_.-]/' , '' , @$_GET['src'] ) ;
		$mytrustdirpath = dirname( dirname( __FILE__ ) ) ;

		if ( preg_match("/^(.+)\.([^.]+)$/", $my_file, $match ) ) {
			$file = $match[1] ;
			$type = $match[2] ;

			switch( $type ) {
				case 'css' :
					$array = array( 'main' , 'livevalidation' ) ;
					if( in_array( $file, $array ) ) switch( $file ) {
						case 'main' :			
							$template  = $mydirname.'_main.css' ;
						break 2 ;
						case 'livevalidation' :			
							$template  = $mydirname.'_livevalidation.css' ;
						break 2 ;
					}
					break ;
				case 'js' :
					$array = array( 'livevalidation' , 'lightbox_plus' , 'spica' , 'jquery' , 'jquery.textarearesizer' , 'seekAttention.jquery' , 'd3downloads' ) ;
					if( in_array( $file, $array ) ) switch( true ) {
						case ( $file === 'lightbox_plus' ) :
							$file_path = d3download_make_cashe_for_lightbox( $mydirname, 'lightbox_plus' ) ;
						break 2 ;
						case ( $file === 'spica' ) :		
							$file_path = $mytrustdirpath.'/include/js/lightbox/js/'. $my_file ;
						break 2 ;
						case ( $file === 'jquery' || $file === 'jquery.textarearesizer' || $file === 'seekAttention.jquery' ) :
							$file_path = $mytrustdirpath.'/include/js/lib/'. $my_file ;
						break 2 ;
						default :	
							$file_path = $mytrustdirpath.'/include/js/'. $my_file ;
					}
					break ;
				case 'gif' :
					$array = array( 'prepage' ,'nextpage' , 'blank' ,'loading' , 'expand' , 'shrink' , 'prev' , 'next' , 'zzoop' , 'close'  ) ;
					if( in_array( $file, $array ) ) switch( true ) {
						case ( $file === 'prepage' || $file === 'nextpage' ) :
							$file_path = $mytrustdirpath.'/include/images/'. $my_file ;
						break 2 ;
						default :	
							$file_path = $mytrustdirpath.'/include/js/lightbox/images/'. $my_file ;
					}
					break ;
				case 'png' :
					$array = array( 'overlay' , 'grippie' ) ;
					if( in_array( $file, $array ) ) switch( true ) {
						case ( $file === 'overlay' ) :
							$file_path = $mytrustdirpath.'/include/js/lightbox/images/'. $my_file ;
						break 2 ;
						default :	
							$file_path = $mytrustdirpath.'/include/js/lib/image/'. $my_file ;
					}
					break ;
			}
		}
		return array(
			'type'      => $type ,
			'template'  => $template ,
			'file_path' => $file_path ,
		) ;
	}
}

if ( ! function_exists('d3download_send_header') ) {
	function d3download_send_header( $type, $file_path )
	{
		$cache_limit = 3600 ; // default 3600sec == 1hour

		// send header
		switch( $type ) {
			case 'css' :
				session_cache_limiter('public') ;
				header( 'Expires: '.date( 'r',intval( time()/$cache_limit )*$cache_limit+$cache_limit ) ) ;
				header( 'Cache-Control: public, max-age='.$cache_limit ) ;
				header( 'Last-Modified: '.date( 'r',intval( time()/$cache_limit )*$cache_limit ) ) ;
				header( 'Content-Type: text/css' ) ;
				break ;
			case 'js' :
				session_cache_limiter('public') ;
				header( 'Expires: '.date('r',intval( time()/$cache_limit )*$cache_limit+$cache_limit ) ) ;
				header( 'Cache-Control: public, max-age='.$cache_limit ) ;
				header( 'Last-Modified: '.date( 'r',intval( time()/$cache_limit )*$cache_limit ) ) ;
				header( 'Content-length: '.filesize( $file_path ) ) ;
				header( 'Vary: Accept-Encoding' ) ;
				header( 'Content-Type: application/x-javascript' ) ;
				break ;
			case 'gif' :
				session_cache_limiter('public') ;
				header( 'Expires: '.date('r',intval(time()/$cache_limit )*$cache_limit+$cache_limit ) ) ;
				header( 'Cache-Control: public, max-age='.$cache_limit ) ;
				header( 'Last-Modified: '.date( 'r',intval( time()/$cache_limit)*$cache_limit ) ) ;
				header( 'Content-type: image/gif') ;
				break ;
			case 'png' :
				session_cache_limiter('public') ;
				header( 'Expires: '.date('r',intval(time()/$cache_limit )*$cache_limit+$cache_limit ) ) ;
				header( 'Cache-Control: public, max-age='.$cache_limit ) ;
				header( 'Last-Modified: '.date( 'r',intval( time()/$cache_limit)*$cache_limit ) ) ;
				header( 'Content-type: image/png' ) ;
			break ;
		}
	}
}

if ( ! function_exists('d3download_make_data_for_lightbox') ) {
	function d3download_make_data_for_lightbox( $mydirname )
	{
		$mod_url = XOOPS_URL.'/modules/'.$mydirname ;
		$mytrustdirpath = dirname( dirname( __FILE__ ) ) ;
		$file_path = $mytrustdirpath.'/include/js/lightbox/js/lightbox_plus.js' ;

		if ( is_file( $file_path ) ){
			return str_replace( 'mod_url' , $mod_url , file_get_contents( $file_path ) ) ;
		} else {
			return '' ;
		}
	}
}

if ( ! function_exists('d3download_make_cashe_for_lightbox') ) {
	function d3download_make_cashe_for_lightbox( $mydirname, $name )
	{
 		$file = XOOPS_ROOT_PATH.'/cache/'.$mydirname.'_'.substr( md5( $name ) , -6 ).'.html' ;
 		if ( ! file_exists( $file ) ){
			$data = d3download_make_data_for_lightbox( $mydirname ) ;
			if ( $fp = @fopen( $file, 'wb' ) ) {
				fputs( $fp, $data ) ;
				fclose( $fp ) ;
			}
		}
		return $file ;
	}
}

if ( ! function_exists('d3download_make_module_header') ) {
	function d3download_make_module_header( $mydirname, $name, $type )
	{
		switch( $type ) {
			case 'css' :
				return '<link rel="stylesheet" type="text/css" media="all" href="'.d3download_replace_css_uri( $mydirname, $name ).'" />' ;
			case 'js' :
				return '<script type="text/javascript" src="'.XOOPS_URL.'/modules/'.$mydirname.'/index.php?page=module_header&src='.$name.'"></script>';
		}
	}
}

if ( ! function_exists('d3download_replace_css_uri') ) {
	function d3download_replace_css_uri( $mydirname, $uri )
	{
		$searches = array( '{mod_url}' , '&lt;{$mod_url}&gt;' , '&lt;{$mydirname}&gt;' , '{X_SITEURL}' , '&lt;{$xoops_url}&gt;', '&amp;' ) ;
		$replacements = array( XOOPS_URL.'/modules/'.$mydirname , XOOPS_URL.'/modules/'.$mydirname , $mydirname , XOOPS_URL.'/' , XOOPS_URL, '&' ) ;
	
		return str_replace( $searches , $replacements , $uri ) ;
	}
}

if ( ! function_exists('d3download_add_moduleheader') ) {
	function d3download_add_moduleheader( $mydirname,  $add_array=array() )
	{
		$i = 0 ;
		$header = '' ;
		$count = count( $add_array ) ;
		if( $count > 0 ) foreach ( $add_array as $filename ) {
			 $pos = strrpos( $filename, '.' ) ;
			 if ( $pos !== false ) {
				 $i++ ;
				 $header .= d3download_make_module_header( $mydirname, $filename, strtolower( substr( $filename, $pos + 1 ) ) ) ;
				 if ( $i < $count ) $header .= "\n" ;
			 }
		}

		return $header ;
	}
}

if ( ! function_exists('d3download_ajax_load') ) {
	function d3download_ajax_load( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/d3downloads.textsanitizer.php' ;

		$myts =& d3downloadsTextSanitizer::getInstance() ;
		$_GET = $myts->Delete_Nullbyte( $_GET ) ;

		$array = array( 'is_file' , 'check_url' , 'check_unapproval' , 'ratefile_check' , 'category_form_validate' , 'logourl_load' , 'str_load' , 'cansel' , 'change_editor' , 'is_fckeditor' ) ;
		$type = ( in_array( $_GET['type'], $array ) ) ? @$_GET['type'] : '' ;

		if( empty( $type ) ) exit ;

		switch( $type ) {
			case 'is_file' :
				d3download_is_file_check( $mydirname ) ;
				break ;
			case 'check_url' :
				d3download_check_url( $mydirname ) ;
				break ;
			case 'check_unapproval' :
				d3download_check_unapproval( $mydirname ) ;
				break ;
			case 'ratefile_check' :
				d3download_ratefile_check( $mydirname ) ;
				break ;
			case 'category_form_validate' :
				d3download_category_form_validate() ;
				break ;
			case 'logourl_load' :
				d3download_logourl_load( $mydirname ) ;
				break ;
			case 'str_load' :
				d3download_str_load( $mydirname ) ;
				break ;
			case 'cansel' :
				d3download_cansel_load( $mydirname ) ;
				break ;
			case 'change_editor' :
				d3download_change_editor() ;
				break ;
			case 'is_fckeditor' :
				d3download_is_fckeditor() ;
				break ;
		}
	}
}

if ( ! function_exists('d3download_is_file_check') ) {
	function d3download_is_file_check( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
		$mydownload = new MyDownload( $mydirname ) ;

		$result = '' ;
		$url    = ( ! empty( $_GET['value'] ) ) ? $mydownload->Real_path( @$_GET['value'] ) : '' ;

		if ( ! preg_match("`^(https?|ftp)://`i", $url ) ) {
			$result = ( ! is_file( $url ) ) ? 'invalid' : '' ;
		}
		echo $result ;
	}
}

if ( ! function_exists('d3download_check_url') ) {
	function d3download_check_url( $mydirname )
	{
		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname( $mydirname );
		$mod_config =& $config_handler->getConfigsByCat( 0, $module->getVar( 'mid' ) );

		if ( empty( $mod_config['check_url'] ) ) {
			echo '' ;
			exit ;
		}

		require_once dirname( dirname(__FILE__) ).'/class/submit_validate.php' ;
		$submit_validate = new Submit_Validate( $mydirname ) ;

		$check_result = '' ;
		$url = ( ! empty( $_GET['url'] ) ) ? @$_GET['url']  : '' ;
		$lid = intval( $_GET['lid'] ) ;

		if ( preg_match("`^(https?|ftp)://`i", $url ) ) {
			$check_result = $submit_validate->Validate_check_url( $url, $lid ) ;
		}
		echo $check_result ;
	}
}

if ( ! function_exists('d3download_check_unapproval') ) {
	function d3download_check_unapproval( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/submit_validate.php' ;
		$submit_validate = new Submit_Validate( $mydirname ) ;

		$url = ( ! empty( $_GET['url'] ) ) ? @$_GET['url']  : '' ;
		$lid = intval( $_GET['lid'] ) ;

		echo $submit_validate->Validate_check_unapproval( $url, $lid ) ;
	}
}

if ( ! function_exists('d3download_ratefile_check') ) {
	function d3download_ratefile_check( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/rate_download.php' ;
		$rate_download = new rate_download( $mydirname, 'Rate' ) ;
		$lid = intval( $_GET['lid'] ) ;
		if( ! empty( $lid ) ) {
			$check_result = $rate_download->Ratefile_check( $lid ) ;
			echo ( ! empty( $check_result ) ) ? str_replace( '<br />', '', $check_result ) : '' ;
		}
	}
}

if ( ! function_exists('d3download_category_form_validate') ) {
	function d3download_category_form_validate()
	{
		$result   = '' ;
		$imgurl   = ( ! empty( $_GET['imgurl'] ) ) ?   @$_GET['imgurl']   : '' ;
		$shotsdir = ( ! empty( $_GET['shotsdir'] ) ) ? @$_GET['shotsdir'] : '' ;

		require_once dirname( dirname(__FILE__) ).'/class/post_check.php' ;
		$post_check = new Post_Check() ;

		switch( true ) {
			case ( ! empty( $imgurl ) ) :
				if( $imgurl != 'http://' ) {
					if ( ! $post_check->imgurlCheck( $imgurl ) ) $result = 'invalid' ;
				}
				break ;
			case ( ! empty( $shotsdir ) ) :
				$cate_shotsdir = XOOPS_ROOT_PATH.'/'.$shotsdir ;
				if ( ! $post_check->fileexistsCheck( $cate_shotsdir ) ) $result = 'invalid' ;
				break ;
		}
		echo $result ;
	}
}

if ( ! function_exists('d3download_logourl_load') ) {
	function d3download_logourl_load( $mydirname )
	{
		$id = preg_replace( '/[^0-9_]/' , '' , @$_GET['id'] ) ;
		if( ! empty( $id ) ) {
			require_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
			$mydownload = new MyDownload( $mydirname ) ;
			header( 'Content-type: text/xml' ) ;
			echo $mydownload->get_album_link_for_ajax( $id ) ;
		}
	}
}

if ( ! function_exists('d3download_str_load') ) {
	function d3download_str_load( $mydirname )
	{
		require_once dirname( dirname(__FILE__) ).'/class/spam_check.php' ;
		$spam_check = new spam_check( $mydirname ) ;
		$spam_check->random_str() ;
		echo $spam_check->select_value() ;
	}
}

if ( ! function_exists('d3download_cansel_load') ) {
	function d3download_cansel_load( $mydirname )
	{
		if( ! empty( $_SESSION["{$mydirname}_uri4return"] ) ) {
			echo $_SESSION["{$mydirname}_uri4return"] ;
			unset( $_SESSION["{$mydirname}_uri4return"] ) ;
		} else {
			echo XOOPS_URL."/modules/$mydirname/" ;
		}
	}
}

if ( ! function_exists('d3download_change_editor') ) {
	function d3download_change_editor()
	{
		$value  = ( ! empty( $_GET['value'] ) ) ? @$_GET['value'] : '' ;
		$id     = ( $_GET['id'] === 'desc' || $_GET['id'] === 'description' ) ?  @$_GET['id']    : '' ;
		$height = ( ! empty( $_GET['height'] ) ) ? @$_GET['height'] : 500 ;

		if( $value == 'fckeditor' && ! empty( $id ) && file_exists( XOOPS_ROOT_PATH.'/common/fckeditor/' ) ) {
			$html = '
				<script type="text/javascript" src="'.XOOPS_URL.'/common/fckeditor/fckeditor.js"></script>
				<script type="text/javascript"><!--
					function fckeditor_exec() {
						var oFCKeditor = new FCKeditor( "'.$id.'" , "100%" , "'.$height.'" , "Default" ) ;
						oFCKeditor.BasePath = "'.XOOPS_URL.'/common/fckeditor/" ;
						oFCKeditor.ReplaceTextarea() ;
					}
					var FCKobj ;
					function FCKeditor_OnComplete( editorInstance ) {
						FCKobj = editorInstance ;
						if ( $j.support.noCloneEvent ) fckeditor_sethtml() ;
					}
					fckeditor_exec() ;
				// --></script>
			' ;
		} else {
			$html = '' ;
		}
		echo $html ;
	}
}

if ( ! function_exists('d3download_is_fckeditor') ) {
	function d3download_is_fckeditor()
	{
		echo ( file_exists( XOOPS_ROOT_PATH.'/common/fckeditor/' ) ) ? 1 : 0 ;
	}
}

?>