<?php

require_once( '../../../include/cp_header.php' ) ;
require_once( '../class/piCal.php' ) ;
require_once( '../class/piCal_xoops.php' ) ;
require_once( XOOPS_ROOT_PATH."/class/xoopstree.php" ) ;

// for "Duplicatable"
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

require_once( XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php" ) ;

// SERVER, GET 変数の取得
$tz = isset( $_GET[ 'tz' ] ) ? preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET[ 'tz' ] ) : "y" ;
$pos = isset( $_GET[ 'pos' ] ) ? intval( $_GET[ 'pos' ] ) : 0 ;
$num = isset( $_GET[ 'num' ] ) ? intval( $_GET[ 'num' ] ) : 20 ;
$cid = isset( $_GET[ 'cid' ] ) ? intval( $_GET[ 'cid' ] ) : 0 ;
$txt = isset( $_GET[ 'txt' ] ) ? trim( $_GET[ 'txt' ] ) : '' ;
$done = isset( $_GET[ 'done' ] ) ? $_GET[ 'done' ] : '' ;

// MySQLへの接続
$conn = $xoopsDB->conn ;

// setting physical & virtual paths
$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
$mod_url = XOOPS_URL."/modules/$mydirname" ;

// creating an instance of piCal 
$cal = new piCal_xoops( "" , $xoopsConfig['language'] , true ) ;

// setting properties of piCal
$cal->conn = $conn ;
include( '../include/read_configs.php' ) ;
$cal->base_url = $mod_url ;
$cal->base_path = $mod_path ;
$cal->images_url = "$mod_url/images/$skin_folder" ;
$cal->images_path = "$mod_path/images/$skin_folder" ;


// 過去・未来による絞り込み（デフォルトは未来）
$pf_options = "
	<option value='future'>"._AM_OPT_FUTURE."</option>
	<option value='past'>"._AM_OPT_PAST."</option>
	<option value='pandf'>"._AM_OPT_PASTANDFUTURE."</option>\n" ;
$pf = empty( $_GET['pf'] ) ? 'future' : preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET['pf'] ) ;
switch( $pf ) {
	case 'past' :
		$pf_options = str_replace( "'past'>" , "'past' selected='selected'>" , $pf_options ) ;
		$whr_pf = "start<'".time()."'" ;
		break ;
	case 'pandf' :
		$pf_options = str_replace( "'pandf'>" , "'pandf' selected='selected'>" , $pf_options ) ;
		$whr_pf = '1' ;
		break ;
	default :
		$pf = 'future' ;
	case 'future' :
		$pf_options = str_replace( "'future'>" , "'future' selected='selected'>" , $pf_options ) ;
		$whr_pf = "end>'".time()."'" ;
		break ;
}

// カテゴリー一覧の処理
$cattree = new XoopsTree( $cal->cat_table , "cid" , "pid" ) ;
ob_start() ;
$cattree->makeMySelBox( "cat_title" , "weight" , $cid , true , 'cid' , '' ) ;
$cat_selbox = ob_get_contents() ;
ob_end_clean() ;
$cat_selbox4extract = str_replace( "<option value='0'>" , "<option value='0'>"._ALL."</option>\n<option value='-1'".($cid==-1?"selected":"").">" , $cat_selbox ) ;

// Timezone の処理
$serverTZ = $cal->server_TZ ;
$userTZ = $xoopsUser->timezone() ;
$tzoptions = "
	<option value='s'>"._AM_TZOPT_SERVER."</option>
	<option value='g'>"._AM_TZOPT_GMT."</option>
	<option value='y'>"._AM_TZOPT_USER."</option>\n" ;
switch( $tz ) {
	case 's' :
		$tzoffset = 0 ;
		$tzdisp = ( $serverTZ >= 0 ? "+" : "-" ) . sprintf( "%02d:%02d" , abs( $serverTZ ) , abs( $serverTZ ) * 60 % 60 ) ;
		$tzoptions = str_replace( "'s'>" , "'s' selected='selected'>" , $tzoptions ) ;
		break ;
	case 'g' :
		$tzoffset = - $serverTZ * 3600 ;
		$tzdisp = "GMT" ;
		$tzoptions = str_replace( "'g'>" , "'g' selected='selected'>" , $tzoptions ) ;
		break ;
	default :
	case 'y' :
		$tzoffset = ( $userTZ - $serverTZ ) * 3600 ;
		$tzdisp = ( $userTZ >= 0 ? "+" : "-" ) . sprintf( "%02d:%02d" , abs( $userTZ ) , abs( $userTZ ) * 60 % 60 ) ;
		$tzoptions = str_replace( "'y'>" , "'y' selected='selected'>" , $tzoptions ) ;
		break ;
}


// データベース更新などがからむ処理
if( isset( $_POST[ 'delete' ] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// レコードの削除
	if( isset( $_POST[ 'ids' ] ) && is_array( $_POST[ 'ids' ] ) ) {
		$whr = "" ;
		foreach( $_POST[ 'ids' ] as $id ) {
			$whr .= "id=$id OR rrule_pid=$id OR " ;
			xoops_comment_delete( $xoopsModule->mid() , $id ) ;
		}
		$sql = "DELETE FROM $cal->table WHERE ($whr 0) AND (rrule_pid=0 OR rrule_pid=id)" ;
		mysql_query( $sql , $conn ) ;
		$records = mysql_affected_rows( $conn ) ;
		$sql = "DELETE FROM $cal->table WHERE $whr 0 " ;
		if( ! mysql_query( $sql , $conn ) ) echo mysql_error() ;
		else $mes = urlencode( "$records "._AM_MES_DELETED ) ;
	} else {
		$mes = "" ;
	}
	$cal->redirect( "cid=$cid&num=$num&tz=$tz&done=deleted&mes=$mes" ) ;
	exit ;

} else if( isset( $_POST[ 'addlink' ] ) && isset( $_POST[ 'ids' ] ) && is_array( $_POST[ 'ids' ] ) && $_POST[ 'cid' ] > 0 ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// カテゴリーへのリンク追加
	$cid = intval( $_POST['cid'] ) ;
	$cid4sql = sprintf( "%05d," , $cid ) ;
	$whr = "" ;
	foreach( $_POST[ 'ids' ] as $id ) {
		$whr .= "id=$id OR rrule_pid=$id OR " ;
	}
	$sql = "UPDATE $cal->table SET categories=CONCAT(categories,'$cid4sql') WHERE ($whr 0) AND categories NOT LIKE '%$cid4sql%'" ;
	if( ! mysql_query( $sql , $conn ) ) echo mysql_error() ;
	$records = mysql_affected_rows( $conn ) ;
	$mes = urlencode( "$records "._AM_MES_EVENTLINKTOCAT ) ;
	$cal->redirect( "cid=$cid&num=$num&tz=$tz&done=copied&mes=$mes" ) ;
	exit ;

} else if( isset( $_POST[ 'movelink' ] ) && isset( $_POST[ 'ids' ] ) && is_array( $_POST[ 'ids' ] ) && isset( $_POST[ 'cid' ] ) && $_POST[ 'old_cid' ] > 0 ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// カテゴリーへのリンク移動または削除
	$cid = intval( $_POST['cid'] ) ;
	$cid4sql = $cid > 0 ? sprintf( "%05d," , $cid ) : '' ;
	$old_cid = intval( $_POST['old_cid'] ) ;
	$old_cid4sql = sprintf( "%05d," , $old_cid ) ;
	$whr = "" ;
	foreach( $_POST[ 'ids' ] as $id ) {
		$whr .= "id=$id OR rrule_pid=$id OR " ;
	}
	$sql = "UPDATE $cal->table SET categories=REPLACE(categories,'$old_cid4sql','$cid4sql') WHERE ($whr 0)" ;
	if( ! mysql_query( $sql , $conn ) ) echo mysql_error() ;
	$records = mysql_affected_rows( $conn ) ;
	if( $cid > 0 ) $mes = urlencode( "$records "._AM_MES_EVENTLINKTOCAT ) ;
	else $mes = urlencode( "$records "._AM_MES_EVENTUNLINKED ) ;
	$cal->redirect( "cid=$old_cid&num=$num&tz=$tz&done=moved&mes=$mes" ) ;
	exit ;

} else if( isset( $_POST[ 'output_ics_confirm' ] ) && ! empty( $_POST[ 'ids' ] ) && is_array( $_POST[ 'ids' ] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// iCalendarバッチ出力プラットフォーム確認
	xoops_cp_header();
	include( './mymenu.php' ) ;
	echo $cal->output_ics_confirm( "$mod_url/" , '_blank' ) ;
	xoops_cp_footer();
	exit ;

}


// カテゴリー指定
if( $cid > 0 ) {
	$cid4sql = sprintf( "%05d," , $cid ) ;
	$whr_cid = "categories like '%$cid4sql%'" ;
} else if( $cid == -1 ) {
	$whr_cid = "categories=''" ;
} else {
	$whr_cid = '1' ;
}

// フリーワード検索
if( $txt != "" ) {
	$whr_txt = '' ;
	if( get_magic_quotes_gpc() ) $txt = stripslashes( $txt ) ;
	$keywords = explode( " " , $cal->mb_convert_kana( $txt , "s" ) ) ;
	foreach( $keywords as $keyword ) {
		$whr_txt .= "(CONCAT( summary , description , location , contact ) LIKE '%" . addslashes( $keyword ) . "%') AND " ;
	}
	$whr_txt = substr( $whr_txt , 0 , -4 ) ;
} else {
	$whr_txt = '1' ;
}

// Pre query for rrule events
$prs = mysql_query( "SELECT distinct rrule_pid FROM $cal->table WHERE $whr_cid AND $whr_txt AND $whr_pf AND rrule_pid>0" , $conn ) ;
$pids = array() ;
while( list( $pid ) = mysql_fetch_row( $prs ) ) {
	$pids[] = $pid ;
}

// UNION "not recur events" and "recur events"
$whr = "$whr_cid AND $whr_txt AND $whr_pf AND rrule_pid=0" ;
if( ! empty( $pids ) ) $whr .= " OR id IN (".implode(",",$pids).")" ;

// Main query
$rs = mysql_query( "SELECT COUNT(id) FROM $cal->table WHERE $whr" , $conn ) ;
$numrows = mysql_result( $rs , 0 , 0 ) ;
$rs = mysql_query( "SELECT * FROM $cal->table WHERE $whr ORDER BY start,end LIMIT $pos,$num" , $conn ) ;

// Page Navigation
include XOOPS_ROOT_PATH.'/class/pagenav.php';
$nav = new XoopsPageNav( $numrows , $num , $pos , 'pos' , "cid=$cid&amp;tz=$tz&amp;num=$num&amp;pf=$pf&amp;txt=" . urlencode($txt) ) ;
$nav_html = $nav->renderNav( 10 ) ;
if( $numrows <= 0 ) $nav_num_info = _NONE ;
else if( $pos + $num > $numrows ) $nav_num_info = ($pos+1)."-$numrows/$numrows" ;
else $nav_num_info = ($pos+1).'-'.($pos+$num).'/'.$numrows ;

// メイン出力部
xoops_cp_header();
include( './mymenu.php' ) ;

echo "
<h4>"._AM_MENU_EVENTS."</h4>
<p><font color='blue'>".(isset($_GET['mes'])?htmlspecialchars($_GET['mes'],ENT_QUOTES):"")."</font></p>\n"
. ( isset( $confirm_html ) ? $confirm_html : "" ) ."
<form action='' method='get' style='margin-bottom:0px;text-align:left'>
  <select name='tz' onChange='submit();'>$tzoptions</select>
  <input type='hidden' name='cid' value='$cid' />
  <input type='hidden' name='num' value='$num' />
  <input type='hidden' name='txt' value='".htmlspecialchars($txt,ENT_QUOTES)."' />
</form>
<table width='100%' cellpadding='0' cellspacing='0' border='0'>
  <tr>
    <td align='left'>
      $nav_num_info
    </td>
    <td>
      <form action='' method='get' style='margin-bottom:0px;text-align:right'>
        <select name='pf'>
          $pf_options
        </select>
        $cat_selbox4extract
        <input type='text' name='txt' value='".htmlspecialchars($txt,ENT_QUOTES)."' />
        <input type='submit' value='"._AM_BUTTON_EXTRACT."' /> &nbsp; 
        $nav_html &nbsp; 
        <input type='hidden' name='num' value='$num' />
        <input type='hidden' name='tz' value='$tz' />
      </form>
    </td>
  </tr>
</table>
<form name='MainForm' action='?tz=$tz&amp;num=$num&amp;cid=$cid' method='post' style='margin-top:0px;'>
".$xoopsGTicket->getTicketHtml( __LINE__ )."
<table width='100%' class='outer' cellpadding='4' cellspacing='1'>
  <tr valign='middle'>
    <th>"._AM_IO_TH0."</th>
    <th>"._AM_IO_TH1."<br />($tzdisp)</th>
    <th>"._AM_IO_TH2."<br />($tzdisp)</th>
    <th>"._AM_IO_TH3."</th>
    <th>"._AM_IO_TH4."</th>
    <th>"._AM_IO_TH5."</th>
    <th></th>
    <th><input type='checkbox' name='dummy' onclick=\"with(document.MainForm){for(i=0;i<length;i++){if(elements[i].type=='checkbox'){elements[i].checked=this.checked;}}}\" /></th>
  </tr>
" ;

// リスト出力部
$myts = MyTextSanitizer::getInstance() ;
$oddeven = 'odd' ;
while( $event = mysql_fetch_object( $rs ) ) {
	$oddeven = ( $oddeven == 'odd' ? 'even' : 'odd' ) ;
	if( $event->allday ) {
		$start_desc = date( _AM_DTFMT_LIST_ALLDAY , $event->start ) . '<br />(' . _PICAL_MB_ALLDAY_EVENT . ')' ;
		$end_desc = date( _AM_DTFMT_LIST_ALLDAY , $event->end - 300 ) . '<br />(' . _PICAL_MB_ALLDAY_EVENT . ')' ;
	} else {
		$start_desc = date( _AM_DTFMT_LIST_NORMAL , $event->start + $tzoffset ) ;
		$end_desc = date( _AM_DTFMT_LIST_NORMAL , $event->end + $tzoffset ) ;
	}
	$summary4disp = $myts->makeTBoxData4Show( $event->summary ) ;
	echo "
  <tr>
    <td class='$oddeven'>".$xoopsUser->getUnameFromId($event->uid)."</td>
    <td class='$oddeven' nowrap='nowrap'>$start_desc</td>
    <td class='$oddeven' nowrap='nowrap'>$end_desc</td>
    <td class='$oddeven'><a href='$mod_url/index.php?action=View&amp;event_id=$event->id'>$summary4disp</a></td>
    <td class='$oddeven'>".$cal->rrule_to_human_language($event->rrule)."</td>
    <td class='$oddeven'>".($event->admission?_YES:_NO)."</td>
    <td class='$oddeven' align='right'><a href='$mod_url/index.php?action=Edit&amp;event_id=$event->id' target='_blank'><img src='$cal->images_url/addevent.gif' border='0' width='14' height='12' /></a></td>
    <td class='$oddeven' align='right'><input type='checkbox' name='ids[]' value='$event->id' /></td>
  </tr>\n" ;
}

echo "
  <tr>
    <td colspan='8' align='right' class='head'>
      "._AM_LABEL_IO_CHECKEDITEMS." &nbsp; "._AM_LABEL_IO_OUTPUT."<input type='submit' name='output_ics_confirm' value='"._PICAL_BTN_EXPORT."' /> &nbsp; "._AM_LABEL_IO_DELETE."<input type='submit' name='delete' value='"._DELETE."' onclick='return confirm(\""._AM_CONFIRM_DELETE."\")' /><br />
      <br />
      $cat_selbox <input type='submit' name='movelink' value='"._AM_BUTTON_MOVE."' onclick='return confirm(\""._AM_CONFIRM_MOVE."\")' ".($cid<=0?"disabled='disabled'":"")." /> <input type='submit' name='addlink' value='"._AM_BUTTON_COPY."' onclick='return confirm(\""._AM_CONFIRM_COPY."\")' />
      <input type='hidden' name='old_cid' value='$cid' />
    </td>
  </tr>
  <tr>
    <td colspan='8' align='right' valign='bottom' height='50'>".PICAL_COPYRIGHT."</td>
  </tr>
</table>
</form>
" ;


xoops_cp_footer();
?>
