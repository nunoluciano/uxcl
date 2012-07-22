<?php

if ( ! function_exists( 'd3download_download' ) ) {
	function d3download_download( $url, $filename='', $ext='', $novisit=0 )
	{

		if ( ! preg_match("`^(https?|ftp)://`i", $url ) ) {
			include_once dirname( dirname(__FILE__) ).'/class/upload_validate.php' ;

			if ( ! ini_get( 'safe_mode' ) ) { @set_time_limit(0); }
			if( empty( $filename ) ){
				$f_info   = pathinfo( $url );
				$filename = ( ! empty( $f_info['basename'] ) ) ? $f_info['basename'] : '' ;
				$ext      = ( ! empty( $f_info['extension'] ) ) ? strtolower( $f_info['extension'] ) : '' ;
			}
			$upload_validate = new Upload_Validate ;
			$mtype_arr = $upload_validate->return_mtype();
			$mtype = $mtype_arr[$ext];
			$size= @filesize( $url );
			if( headers_sent() ) die( 'headers are already sent' ) ;
			if ( ! empty( $mtype ) ) {
				header('Content-Type: '.$mtype.'');
			} else {
				header('Content-Type: application/force-download');
			}

			$ua_type = d3download_get_ua_type();
			$current_name = d3download_get_download_name( $filename, $ua_type );

			header('Content-Disposition: attachment; filename="'.$current_name.'"');
			header('Content-Description: File Transfer');
			header('Content-Length: '.$size.'' );
			if ( $ua_type == 'IE' ) {
    			header('Pragma: public');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			} else {
    			header('Pragma: no-cache');
			}
			if( isset( $mtype ) && strstr( $mtype, 'text/' ) ){
				$fp = fopen( $url, 'r' );
			} else {
				$fp = fopen( $url, 'rb' );
			}
			if ( $size > 1024*1024*2 ) {
				while ( ob_get_level() > 0 ) { ob_end_flush(); }
				while( ! feof( $fp ) ) { print fgets( $fp ); }
				fclose( $fp );
			} else {
				fpassthru( $fp );
			}
			exit();
		} else {
			if ( ! preg_match( "/^ed2k*:\/\//i", $url ) ) { Header("Location: $url"); }
			echo "<html><head><meta http-equiv=\"Refresh\" content=\"0; URL=".$url."\"></meta></head><body></body></html>";
			exit();
		}
	}
}

if ( ! function_exists( 'd3download_get_download_name' ) ) {
	function d3download_get_download_name( $filename, $ua )
	{
		if ( $ua == 'Chrome' ) $filename = d3download_chrome_filename( $filename ) ;
		$str = str_replace( ' ', '_', $filename ) ;
		if( XOOPS_USE_MULTIBYTES == 1 ) {
			if( function_exists( 'mb_internal_encoding' ) ) {
				$from_encoding = mb_internal_encoding();
			} else {
				$from_encoding =  _CHARSET;
			}
			switch( $ua ){
				case 'MOZILLA':
					$to_encoding = 'UTF-8';
					break;
				case 'IE':
					$to_encoding = 'SJIS';
					break;
				case 'Opera':
					$to_encoding = 'UTF-8';
					break;
				case 'SAFARI':
					$to_encoding = 'UTF-8';
					break;
				case 'Chrome':
					$to_encoding = 'SJIS';
					break;
				default:
					$to_encoding = 'UTF-8';
					break;
			}
			if ( ! extension_loaded( 'mbstring' ) && ! class_exists( 'HypMBString' ) ) {
				require_once dirname( dirname( __FILE__ ) ).'/class/mbemulator/mb-emulator.php' ;
			}
			return mb_convert_encoding( $str, $to_encoding, $from_encoding );
		} else {
			return $str;
		}
	}
}

if ( ! function_exists( 'd3download_get_ua_type' ) ) {
	function d3download_get_ua_type()
	{
		if ( stristr( $_SERVER['HTTP_USER_AGENT'] , 'Opera' ) ) {
			$ua_type = 'Opera';
		} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'] , 'MSIE' ) ) {
			$ua_type = 'IE';
		} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'] , 'Mozilla' ) && stristr( $_SERVER['HTTP_USER_AGENT'] , 'Chrome' ) ) {
			$ua_type = 'Chrome';
		} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'] , 'Mozilla' ) && stristr( $_SERVER['HTTP_USER_AGENT'] , 'Safari' ) ) {
			$ua_type = 'SAFARI';
		} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'] , 'Mozilla' ) ) {
			$ua_type = 'MOZILLA';
		} else {
			$ua_type = 'OTHER';
		}
		return $ua_type;
	}
}

if ( ! function_exists('d3download_chrome_filename') ) {
	function d3download_chrome_filename( $filename )
	{
		$pos = strrpos( $filename, '.' ) ;
		return ( $pos !== false ) ?  substr( $filename, 0, $pos + 1 ) : $filename ;
	}
}

?>