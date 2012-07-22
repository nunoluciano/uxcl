<?php

// piCal xoops用ブロックモジュール
// pical_thedays_schedule.php
// caldateで指定された一日のスケジュールをブロックに表示
// by GIJ=CHECKMATE (PEAK Corp. http://www.peak.ne.jp/)

if( ! defined( 'PICAL_BLOCK_THEDAYS_SCHEDULE_INCLUDED' ) ) {

define( 'PICAL_BLOCK_THEDAYS_SCHEDULE_INCLUDED' , 1 ) ;

// XOOPS 2.2
if( ! defined( 'XOOPS_CUBE_LEGACY' ) && substr( XOOPS_VERSION , 6 , 3 ) == '2.0' ) {
	$GLOBALS['pical_blockinstance_object'] =& $this ;
}

function pical_thedays_schedule_show_tpl( $options )
{
	global $xoopsConfig , $xoopsDB ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$now_cid = empty( $options[1] ) ? 0 : intval( $options[1] ) ;

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

	// cid による絞り込み
	$cal->now_cid = $now_cid ;

	// setting properties of piCal
	$cal->conn = $xoopsDB->conn ;
	include( "$mod_path/include/read_configs.php" ) ;
	$cal->base_url = $mod_url ;
	$cal->base_path = $mod_path ;
	$cal->images_url = "$mod_url/images/$skin_folder" ;
	$cal->images_path = "$mod_path/images/$skin_folder" ;

	// ブロック配列の自分自身を書き換える title に %s を含めること
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
		$GLOBALS['pical_thedays_schedule_title_parameter']  = sprintf( _PICAL_FMT_MD , $cal->month_short_names[ date( 'n' , $cal->unixtime ) ] , $cal->date_short_names[ date( 'j' , $cal->unixtime ) ] ) ;
	} else if( substr( XOOPS_VERSION , 6 , 3 ) == '2.2' ) {
		$title_fmt = $GLOBALS['pical_blockinstance_object']->getVar('title') ;
		$GLOBALS['pical_blockinstance_object']->setVar('title',sprintf( $title_fmt , sprintf( _PICAL_FMT_MD , $cal->month_short_names[ date( 'n' , $cal->unixtime ) ] , $cal->date_short_names[ date( 'j' , $cal->unixtime ) ] ) ) ) ;
	} else {
		global $block_arr , $i ;
		if( is_object( $block_arr[$i] ) ) {
			$title_fmt = $block_arr[$i]->getVar( 'title' ) ;
			$title = sprintf( $title_fmt , sprintf( _PICAL_FMT_MD , $cal->month_short_names[ date( 'n' , $cal->unixtime ) ] , $cal->date_short_names[ date( 'j' , $cal->unixtime ) ] ) ) ;
			$block_arr[$i]->setVar( 'title' , $title ) ;
		}
	}

	$block = $cal->get_blockarray_date_event( "$mod_url/index.php" ) ;
	return $block ;
}



function pical_thedays_schedule_edit( $options )
{
	global $xoopsDB , $xoopsConfig ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$now_cid = empty( $options[1] ) ? 0 : intval( $options[1] ) ;

	// setting physical & virtual paths
	$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
	$mod_url = XOOPS_URL."/modules/$mydirname" ;

	// defining class of piCal
	require_once( "$mod_path/class/piCal.php" ) ;
	require_once( "$mod_path/class/piCal_xoops.php" ) ;

	// creating an instance of piCal 
	$cal = new piCal_xoops( date( 'Y-n-j' ) , $xoopsConfig['language'] , true ) ;
	$cal->use_server_TZ = true ;

	// setting properties of piCal
	$cal->conn = $xoopsDB->conn ;
	include( "$mod_path/include/read_configs.php" ) ;
	$cal->base_url = $mod_url ;
	$cal->base_path = $mod_path ;
	$cal->images_url = "$mod_url/images/$skin_folder" ;
	$cal->images_path = "$mod_path/images/$skin_folder" ;

	$ret = "<input type='hidden' name='options[0]' value='$mydirname' />\n" ;

	// カテゴリー選択ボックスの生成
	$ret .= _MB_PICAL_CATSEL . ':' ;
	$ret .= "<select name='options[1]'>\n<option value='0'>"._ALL."</option>\n" ;
	foreach( $cal->categories as $cid => $cat ) {
		$selected = $now_cid == $cid ? "selected='selected'" : "" ;
		$depth_desc = str_repeat( '-' , intval( $cat->cat_depth ) ) ;
		$cat_title4show = $cal->text_sanitizer_for_show( $cat->cat_title ) ;
		$ret .= "\t<option value='$cid' $selected>$depth_desc $cat_title4show</option>\n" ;
	}
	$ret .= "</select>\n" ;
	return $ret ;
}

}

?>