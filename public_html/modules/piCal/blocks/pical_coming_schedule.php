<?php

// piCal xoops用ブロックモジュール
// pical_coming_schedule.php
// 今日以降のスケジュールをブロックに表示
// by GIJ=CHECKMATE (PEAK Corp. http://www.peak.ne.jp/)

if( ! defined( 'PICAL_BLOCK_COMING_SCHEDULE_INCLUDED' ) ) {

define( 'PICAL_BLOCK_COMING_SCHEDULE_INCLUDED' , 1 ) ;

function pical_coming_schedule_show_tpl( $options )
{
	global $xoopsConfig , $xoopsDB ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$maxitem = empty( $options[1] ) ? 10 : intval( $options[1] ) ;
	$now_cid = empty( $options[2] ) ? 0 : intval( $options[2] ) ;
	$untildays = empty( $options[4] ) ? 0 : intval( $options[4] ) ;

	// setting physical & virtual paths
	$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
	$mod_url = XOOPS_URL."/modules/$mydirname" ;

	// defining class of piCal
	if( ! class_exists( 'piCal_xoops' ) ) {
		require_once( "$mod_path/class/piCal.php" ) ;
		require_once( "$mod_path/class/piCal_xoops.php" ) ;
	}

	// creating an instance of piCal 
	$cal = new piCal_xoops( date( 'Y-n-j' ) , $xoopsConfig['language'] , true ) ;
	$cal->use_server_TZ = true ;

	// cid による絞り込み
	$cal->now_cid = $now_cid ;

	// setting properties of piCal
	$cal->conn = $xoopsDB->conn ;
	include( "$mod_path/include/read_configs.php" ) ;
	$cal->base_url = $mod_url ;
	$cal->base_path = $mod_path ;
	$cal->images_url = "$mod_url/images/$skin_folder" ;
	$cal->images_path = "$mod_path/images/$skin_folder" ;

	$block = $cal->get_blockarray_coming_event( "$mod_url/index.php" , $maxitem , true , $untildays ) ;
	return $block ;
}



function pical_coming_schedule_edit( $options )
{
	global $xoopsDB , $xoopsConfig ;

	$mydirname = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0] ;
	$maxitem = empty( $options[1] ) ? 10 : intval( $options[1] ) ;
	$now_cid = empty( $options[2] ) ? 0 : intval( $options[2] ) ;
	$untildays = empty( $options[4] ) ? 0 : intval( $options[4] ) ;

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

	// 表示個数
	$ret .= _MB_PICAL_MAXITEMS . ":" ;
	$ret .= "<input type='text' size='4' name='options[1]' value='$maxitem' style='text-align:right;' /><br />\n" ;

	// カテゴリー選択ボックスの生成
	$ret .= _MB_PICAL_CATSEL . ':' ;
	$ret .= "<select name='options[2]'>\n<option value='0'>"._ALL."</option>\n" ;
	foreach( $cal->categories as $cid => $cat ) {
		$selected = $now_cid == $cid ? "selected='selected'" : "" ;
		$depth_desc = str_repeat( '-' , intval( $cat->cat_depth ) ) ;
		$cat_title4show = $cal->text_sanitizer_for_show( $cat->cat_title ) ;
		$ret .= "\t<option value='$cid' $selected>$depth_desc $cat_title4show</option>\n" ;
	}
	$ret .= "</select><br />\n" ;

	// サブカテゴリー表示の実装はまだまだ先（一応予約だけしておく）
	$ret .= "<input type='hidden' name='options[3]' value='0' />\n" ;

	// 表示上限日数
	$ret .= sprintf( _MB_PICAL_UNTILDAYS , "<input type='text' size='4' name='options[4]' value='$untildays' style='text-align:right;' />" ) . "<br />\n" ;

	return $ret ;
}

}

?>