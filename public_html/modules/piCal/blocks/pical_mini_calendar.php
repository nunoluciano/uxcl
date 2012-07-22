<?php

// piCal xoops用ブロックモジュール
// pical_mini_calendar.php
// ミニカレンダーの表示
// by GIJ=CHECKMATE (PEAK Corp. http://www.peak.ne.jp/)

if( ! defined( 'PICAL_BLOCK_MINI_CALENDAR_INCLUDED' ) ) {

define( 'PICAL_BLOCK_MINI_CALENDAR_INCLUDED' , 1 ) ;

function pical_mini_calendar_show( $options )
{
	global $xoopsConfig , $xoopsDB , $xoopsUser ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;

	// caldate や日付ジャンプの指定が無く（当月のデフォルトミニカレンダー表示）
	// かつ、ユーザのTimezoneがdefaultTZと一緒（一番多そうなシチュエーション）の
	// 場合には、キャッシュを使う
	if( empty( $_GET[ 'caldate' ] ) && empty( $_POST[ 'pical_jumpcaldate' ] ) && ( ! is_object( $xoopsUser ) || $xoopsUser->timezone() == $xoopsConfig['default_TZ'] ) ) {
		$use_cache = true ;
		$cachefile = XOOPS_CACHE_PATH . "/{$mydirname}_minical_cache_{$xoopsConfig['language']}.html" ;
		// 5 minutes
		if( file_exists( $cachefile ) && filemtime( $cachefile ) > time() - 300 ) {
			if( false !== $fp = fopen( $cachefile, 'r' ) ) {
				$block['content'] = '' ;
				while( ! feof( $fp ) ) {
					$block['content'] .= fgets( $fp , 4096 ) ;
				}
				fclose( $fp ) ;
				return $block ;
			}
		}
	} else {
		$use_cache = false ;
	}

	// setting physical & virtual paths
	$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
	$mod_url = XOOPS_URL."/modules/$mydirname" ;

	// defining class of piCal
	if( ! class_exists( 'piCal_xoops' ) ) {
		require_once( "$mod_path/class/piCal.php" ) ;
		require_once( "$mod_path/class/piCal_xoops.php" ) ;
	}

	// creating an instance of piCal 
	$cal = new piCal_xoops( "" , $xoopsConfig['language'] , true ) ;

	// ignoring cid from GET
	$cal->now_cid = 0 ;

	// setting properties of piCal
	$cal->conn = $xoopsDB->conn ;
	include( "$mod_path/include/read_configs.php" ) ;
	$cal->base_url = $mod_url ;
	$cal->base_path = $mod_path ;
	$cal->images_url = "$mod_url/images/$skin_folder" ;
	$cal->images_path = "$mod_path/images/$skin_folder" ;

	switch( $mini_calendar_target ) {
		case 'MONTHLY' :
			$get_target = "$mod_url/index.php" ;
			$query_string = "smode=Monthly" ;
			break ;
		case 'WEEKLY' :
			$get_target = "$mod_url/index.php" ;
			$query_string = "smode=Weekly" ;
			break ;
		case 'DAILY' :
			$get_target = "$mod_url/index.php" ;
			$query_string = "smode=Daily" ;
			break ;
		case 'LIST' :
			$get_target = "$mod_url/index.php" ;
			$query_string = "smode=List" ;
			break ;
		default :
		case 'PHP_SELF' :
			$get_target = '' ;
			$query_string = "" ;
			break ;
	}

	$block = array() ;
	$block['content'] = $cal->get_mini_calendar_html( $get_target , $query_string ) ;

	// キャッシュの書き出し
	if( $use_cache && $mini_calendar_target != 'PHP_SELF' ) {
		if( false !== $fp = fopen( $cachefile, 'w' ) ) {
			fwrite( $fp , $block['content'] ) ;
			fclose( $fp ) ;
		}
	}

	return $block ;
}



function pical_mini_calendar_edit( $options )
{
	return '' ;
}

}

?>