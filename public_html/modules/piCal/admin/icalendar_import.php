<?php

require_once( '../../../include/cp_header.php' ) ;
require_once( '../class/piCal.php' ) ;
require_once( '../class/piCal_xoops.php' ) ;

// for "Duplicatable"
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

require_once( XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php" ) ;

// SERVER, GET 変数の取得
$tz = isset( $_GET[ 'tz' ] ) ? preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET[ 'tz' ] ) : "y" ;
$pos = isset( $_GET[ 'pos' ] ) ? intval( $_GET[ 'pos' ] ) : 0 ;
$num = isset( $_GET[ 'num' ] ) ? intval( $_GET[ 'num' ] ) : 20 ;
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
if( isset( $_POST[ 'http_import' ] ) && ! empty( $_POST[ 'import_uri' ] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// httpコネクション経由またはローカルファイルのiCalendarインポート
	list( $records , $calname , $tmpname ) = explode( ":" , $cal->import_ics_via_fopen( $_POST[ 'import_uri' ] , false ) , 3 ) ;
	if( $records <= 0 ) {
		$mes = urlencode( "$calname : $tmpname" ) ;
		$cal->redirect( "done=error&mes=$mes" ) ;
		exit ;
	} else {
		$mes = urlencode( sprintf( "$records "._AM_FMT_IMPORTED , $calname ) ) ;
		$cal->redirect( "done=imported&mes=$mes" ) ;
		exit ;
	}

} else if( isset( $_POST[ 'local_import' ] ) && isset( $_FILES[ 'user_ics' ][ 'tmp_name' ] ) && is_readable( $_FILES[ 'user_ics' ][ 'tmp_name' ] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// ファイルアップロードによるiCalendarインポート
	list( $records , $calname , $tmpname ) = explode( ":" , $cal->import_ics_via_upload( 'user_ics' ) , 3 ) ;
	if( $records <= 0 ) {
		$mes = urlencode( "$calname : " . $_FILES['user_ics']['name'] ) ;
		$cal->redirect( "done=error&mes=$mes" ) ;
		exit ;
	} else {
		$mes = urlencode( sprintf( "$records "._AM_FMT_IMPORTED , $calname ) ) ;
		$cal->redirect( "done=imported&mes=$mes" ) ;
		exit ;
	}

} else if( isset( $_POST[ 'delete' ] ) ) {

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
	$cal->redirect( "done=deleted&mes=$mes" ) ;
	exit ;
}

// インポートした直後のレコード数を、$mesから得る
if( $done == 'imported' && isset( $_GET['mes'] ) ) $new_imported = intval( $_GET['mes'] ) ;
else $new_imported = 0 ;

// クエリ（１時間以内のレコードだけを表示）
$older_limit = time() - 3600 ;
$whr = "UNIX_TIMESTAMP(dtstamp) > $older_limit AND (rrule_pid=0 OR rrule_pid=id)" ;
$rs = mysql_query( "SELECT COUNT(id) FROM $cal->table WHERE $whr" , $conn ) ;
$numrows = mysql_result( $rs , 0 , 0 ) ;
$rs = mysql_query( "SELECT * FROM $cal->table WHERE $whr ORDER BY dtstamp DESC LIMIT $pos,$num" , $conn ) ;

// ページ分割処理
include XOOPS_ROOT_PATH.'/class/pagenav.php';
$nav = new XoopsPageNav( $numrows , $num , $pos , 'pos' , "tz=$tz&amp;num=$num" ) ;
$nav_html = $nav->renderNav( 10 ) ;
if( $numrows <= 0 ) $nav_num_info = _NONE ;
else if( $pos + $num > $numrows ) $nav_num_info = ($pos+1)."-$numrows/$numrows" ;
else $nav_num_info = ($pos+1).'-'.($pos+$num).'/'.$numrows ;

// メイン出力部
xoops_cp_header();
include( './mymenu.php' ) ;

// 3つも表示されるのでクリアしておく
$xoopsGTicket->clear() ;

echo "
<h4>"._AM_ICALENDAR_IMPORT."</h4>
<p><font color='blue'>".(isset($_GET['mes'])?htmlspecialchars($_GET['mes'],ENT_QUOTES):"")."</font></p>
<form action='?tz=$tz&amp;num=$num' method='post'>
  "._AM_LABEL_IMPORTFROMWEB."<br />
  <input type='text' name='import_uri' size='80'>
  <input type='submit' name='http_import' value='"._PICAL_BTN_IMPORT."'>
  ".$xoopsGTicket->getTicketHtml( __LINE__ )."
</form>
<form action='?tz=$tz&amp;num=$num' method='post' enctype='multipart/form-data'>
  "._AM_LABEL_UPLOADFROMFILE."<br />
  <input type='hidden' name='MAX_FILE_SIZE' value='65536'>
  <input type='file' name='user_ics' size='72'>
  <input type='submit' name='local_import' value='"._PICAL_BTN_UPLOAD."'>
  ".$xoopsGTicket->getTicketHtml( __LINE__ )."
</form>
<form action='' method='get' style='margin-bottom:0px;text-align:left'>
  <select name='tz' onChange='submit();'>$tzoptions</select>
  <input type='hidden' name='num' value='$num' />
</form>
<table width='100%' cellpadding='0' cellspacing='0' border='0'>
  <tr>
    <td align='left'>
      $nav_num_info
    </td>
    <td>
      <form action='' method='get' style='margin-bottom:0px;text-align:right'>
        $nav_html &nbsp; 
        <input type='hidden' name='num' value='$num' />
        <input type='hidden' name='tz' value='$tz' />
      </form>
    </td>
  </tr>
</table>
<form name='MainForm' action='?tz=$tz&amp;num=$num' method='post' style='margin-top:0px;'>
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
$count = 0 ;
while( $event = mysql_fetch_object( $rs ) ) {
	$oddeven = ( $oddeven == 'odd' ? 'even' : 'odd' ) ;
	if( $count ++ < $new_imported ) $newer_style = "style='background-color:#FFFFCC;'" ;
	else $newer_style = '' ;
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
    <td class='$oddeven' $newer_style>".$xoopsUser->getUnameFromId($event->uid)."</td>
    <td class='$oddeven' nowrap='nowrap' $newer_style>$start_desc</td>
    <td class='$oddeven' nowrap='nowrap' $newer_style>$end_desc</td>
    <td class='$oddeven' $newer_style><a href='$mod_url/index.php?action=View&amp;event_id=$event->id'>$summary4disp</a></td>
    <td class='$oddeven' $newer_style>".$cal->rrule_to_human_language($event->rrule)."</td>
    <td class='$oddeven' $newer_style>".($event->admission?_YES:_NO)."</td>
    <td class='$oddeven' align='right' $newer_style><a href='$mod_url/index.php?action=Edit&amp;event_id=$event->id' target='_blank'><img src='$cal->images_url/addevent.gif' border='0' width='14' height='12' /></a></td>
    <td class='$oddeven' align='right' $newer_style><input type='checkbox' name='ids[]' value='$event->id' /></td>
  </tr>\n" ;
}

echo "
  <tr>
    <td colspan='8' align='right' class='head'>"._AM_LABEL_IO_CHECKEDITEMS." &nbsp; "._AM_LABEL_IO_DELETE."<input type='submit' name='delete' value='"._DELETE."' onclick='return confirm(\""._AM_CONFIRM_DELETE."\")' /></td>
  </tr>
  <tr>
    <td colspan='8' align='right' valign='bottom' height='50'>".PICAL_COPYRIGHT."</td>
  </tr>
</table>
</form>
" ;

xoops_cp_footer();
?>
