<?php

function display_edit_form( $cat , $form_title , $action )
{
	global $cattree ;

	// Beggining of XoopsForm
	$form = new XoopsThemeForm( $form_title , 'MainForm' , '' ) ;

	// Hidden
	$form->addElement( new XoopsFormHidden( 'action' , htmlspecialchars( $action , ENT_QUOTES ) ) ) ;
	$form->addElement( new XoopsFormHidden( 'cid' , intval( $cat->cid ) ) ) ;

	// Subject
	$form->addElement( new XoopsFormText( _AM_CAT_TH_TITLE , 'cat_title' , 60 , 128 , htmlspecialchars( $cat->cat_title , ENT_QUOTES ) ) , true ) ;

	// Description
	$tarea_tray =  new XoopsFormElementTray( _AM_CAT_TH_DESC , '<br />' ) ;
	$tarea_tray->addElement( new XoopsFormDhtmlTextArea( '' , 'cat_desc' , htmlspecialchars( $cat->cat_desc , ENT_QUOTES ) , 15 , 60 ) ) ;
	$form->addElement( $tarea_tray ) ;

	// Parent Category
	ob_start() ;
	$cattree->makeMySelBox( "cat_title" , "weight" , $cat->pid , 1 , 'pid' ) ;
	$cat_selbox = ob_get_contents() ;
	ob_end_clean() ;
	$form->addElement( new XoopsFormLabel( _AM_CAT_TH_PARENT , $cat_selbox ) ) ;

	// Weight
	$form->addElement( new XoopsFormText( _AM_CAT_TH_WEIGHT , 'weight', 6 , 6 , intval( $cat->weight ) ) , true ) ;

	// Options
	$checkbox_tray =  new XoopsFormElementTray( _AM_CAT_TH_OPTIONS , '<br />' ) ;
	$ismenuitem_checkbox =  new XoopsFormCheckBox( '' , 'ismenuitem' , intval( $cat->ismenuitem ) ) ;
	$ismenuitem_checkbox->addOption( 1 , _AM_CAT_TH_SUBMENU ) ;
	$checkbox_tray->addElement( $ismenuitem_checkbox ) ;
	$form->addElement( $checkbox_tray ) ;

	// Last Modified
	$form->addElement( new XoopsFormLabel( _AM_CAT_TH_LASTMODIFY , formatTimestamp( $cat->udtstamp ) ) ) ;

	// Buttons
	$button_tray = new XoopsFormElementTray( '' , '&nbsp;' ) ;
	$button_tray->addElement( new XoopsFormButton( '' , 'submit' , _SUBMIT, 'submit' ) ) ;
	$button_tray->addElement( new XoopsFormButton( '' , 'reset' , _CANCEL, 'reset' ) ) ;
	$form->addElement( $button_tray ) ;

	// Ticket
	$GLOBALS['xoopsGTicket']->addTicketXoopsFormElement( $form , __LINE__ ) ;

	// End of XoopsForm
	$form->display();
}


// ツリー順になるように、weightを再計算し、ツリーの深さも測っておく
function rebuild_cat_tree( $cat_table )
{
	global $conn ;

	$rs = mysql_query( "SELECT cid,pid FROM $cat_table ORDER BY pid ASC,weight DESC" , $conn ) ;
	$cats[0] = array( 'cid' => 0 , 'pid' => -1 , 'next_key' => -1 , 'depth' => 0 ) ;
	$key = 1 ;
	while( $cat = mysql_fetch_object( $rs ) ) {
		$cats[ $key ] = array( 'cid' => intval( $cat->cid ) , 'pid' => intval( $cat->pid ) , 'next_key' => $key + 1 , 'depth' => 0 ) ;
		$key ++ ;
	}
	$sizeofcats = $key ;

	$loop_check_for_key = 1024 ;
	for( $key = 1 ; $key < $sizeofcats ; $key ++ ) {
		$cat =& $cats[ $key ] ;
		$target =& $cats[ 0 ] ;
		if( -- $loop_check_for_key < 0 ) $loop_check = -1 ;
		else $loop_check = 4096 ;

		while( 1 ) {
			if( $cat['pid'] == $target['cid'] ) {
				$cat['depth'] = $target['depth'] + 1 ;
				$cat['next_key'] = $target['next_key'] ;
				$target['next_key'] = $key ;
				break ;
			} else if( -- $loop_check < 0 ) {
				mysql_query( "UPDATE $cat_table SET pid='0' WHERE cid={$cat['cid']}" , $conn ) ;
				$cat['depth'] = 1 ;
				$cat['next_key'] = $target['next_key'] ;
				$target['next_key'] = $key ;
				break ;
			} else if( $target['next_key'] < 0 ) {
				$cat_backup = $cat ;
				array_splice( $cats , $key , 1 ) ;
				array_push( $cats , $cat_backup ) ;
				-- $key ;
				break ;
			}
			$target =& $cats[ $target['next_key'] ] ;
		}
	}

	$cat =& $cats[ 0 ]  ;
	for( $weight = 1 ; $weight < $sizeofcats ; $weight ++ ) {
		$cat =& $cats[ $cat['next_key'] ] ;
		mysql_query( "UPDATE $cat_table SET weight=".($weight*10).",cat_depth={$cat['depth']} WHERE cid={$cat['cid']}" , $conn ) ;
	}
}


require_once( '../../../include/cp_header.php' ) ;
require_once( '../class/piCal.php' ) ;
require_once( '../class/piCal_xoops.php' ) ;

require_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
require_once XOOPS_ROOT_PATH."/class/xoopslists.php";
require_once( XOOPS_ROOT_PATH."/class/xoopstree.php" ) ;

// for "Duplicatable"
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

require_once( XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php" ) ;

// SERVER, GET 変数の取得
$action = isset( $_POST[ 'action' ] ) ? preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_POST[ 'action' ] ) : '' ;
$done = isset( $_GET[ 'done' ] ) ? preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET[ 'done' ] ) : '' ;
$disp = isset( $_GET[ 'disp' ] ) ? preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET[ 'disp' ] ) : '' ;
$cid = isset( $_GET[ 'cid' ] ) ? intval( $_GET[ 'cid' ] ) : 0 ;


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


// XOOPS関連の初期化
$myts =& MyTextSanitizer::getInstance();
$cattree = new XoopsTree( $cal->cat_table , "cid" , "pid" ) ;
$gperm_handler =& xoops_gethandler('groupperm');


// データベース更新などがからむ処理
if( $action == "insert" ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// 新規登録
	$sql = "INSERT INTO $cal->cat_table SET " ;
	$cols = array( "weight" => "I:N:0" ,"ismenuitem" => "I:N:0" ,"cat_title" => "255:J:1" , "cat_desc" => "A:J:0" , "pid" => "I:N:0" ) ;
	$sql .= $cal->get_sql_set( $cols ) ;
	if( ! mysql_query( $sql , $conn ) ) die( mysql_error() ) ;
	rebuild_cat_tree( $cal->cat_table ) ;
	$mes = urlencode( _AM_MB_CAT_INSERTED ) ;
	$cal->redirect( "done=inserted&mes=$mes" ) ;
	exit ;

} else if( $action == "update" && $_POST['cid'] > 0 ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// 更新
	$cid = intval( $_POST['cid'] ) ;
	$sql = "UPDATE $cal->cat_table SET " ;
	$cols = array( "weight" => "I:N:0" ,"ismenuitem" => "I:N:0" ,"cat_title" => "255:J:1" , "cat_desc" => "A:J:0" , "pid" => "I:N:0" ) ;
	$sql .= $cal->get_sql_set( $cols ) . "WHERE cid='$cid'" ;
	if( ! mysql_query( $sql , $conn ) ) die( mysql_error() ) ;
	rebuild_cat_tree( $cal->cat_table ) ;
	$mes = urlencode( _AM_MB_CAT_UPDATED ) ;
	$cal->redirect( "done=updated&mes=$mes" ) ;
	exit ;

} else if( ! empty( $_POST['delcat'] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// Delete
	$cid = intval( $_POST['delcat'] ) ;

	// Category2Group permission の削除 (2.0.3 以前でもうまく動くように)
	// xoops_groupperm_deletebymoditem( $xoopsModule->mid() , 'pical_cat' , $cid ) ;
	$criteria = new CriteriaCompo( new Criteria( 'gperm_modid' , $xoopsModule->mid() ) ) ;
	$criteria->add( new Criteria( 'gperm_name' , 'pical_cat' ) ) ;
	$criteria->add( new Criteria( 'gperm_itemid' , intval( $cid ) ) ) ;
	$gperm_handler->deleteAll( $criteria ) ;

	// Category Notify の削除
	// (必要であれば該当イベント削除の機能も)

	// 対象カテゴリーの子供をWHERE節に追加し、Cat2Group Permissionを削除
	$children = $cattree->getAllChildId( $cid ) ;
	$whr = "cid IN (" ;
	foreach( $children as $child ) {
		// WHERE節への追加
		$whr .= "$child," ;
		// Category2Group permission の削除 (2.0.3 以前でもうまく動くように)
		// xoops_groupperm_deletebymoditem( $xoopsModule->mid() , 'pical_cat' , $child ) ;
		$criteria = new CriteriaCompo( new Criteria( 'gperm_modid' , $xoopsModule->mid() ) ) ;
		$criteria->add( new Criteria( 'gperm_name' , 'pical_cat' ) ) ;
		$criteria->add( new Criteria( 'gperm_itemid' , intval( $child ) ) ) ;
		$gperm_handler->deleteAll( $criteria ) ;
	}
	$whr .= "$cid)" ;

	// catテーブルからの削除
	if( ! mysql_query( "DELETE FROM $cal->cat_table WHERE $whr" , $conn ) ) die( mysql_error() ) ;
	rebuild_cat_tree( $cal->cat_table ) ;
	$mes = urlencode( sprintf( _AM_FMT_CAT_DELETED , mysql_affected_rows() ) ) ;
	$cal->redirect( "done=deleted&mes=$mes" ) ;
	exit ;

} else if( ! empty( $_POST['batch_update'] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// バッチアップデート
	$affected = 0 ;
	foreach( $_POST['weights'] as $cid => $weight ) {
		$weight = intval( $weight ) ;
		$cid = intval( $cid ) ;
		$enabled = ! empty( $_POST['enabled'][$cid] ) ? 1 : 0 ;
		if( ! mysql_query( "UPDATE $cal->cat_table SET weight='$weight', enabled='$enabled' WHERE cid=$cid" , $conn ) ) die( mysql_error() ) ;
		$affected += mysql_affected_rows() ;
	}
	if( $affected > 0 ) rebuild_cat_tree( $cal->cat_table ) ;
	$mes = urlencode( sprintf( _AM_FMT_CAT_BATCHUPDATED , $affected ) ) ;
	$cal->redirect( "done=batch_updated&mes=$mes" ) ;
	exit ;

}



// メイン出力部
xoops_cp_header();
include( './mymenu.php' ) ;

// 表示処理の振り分け
if( $disp == "edit" && $cid > 0 ) {

	// 操作対象カテゴリーデータの取得
	$sql = "SELECT *,UNIX_TIMESTAMP(dtstamp) AS udtstamp FROM $cal->cat_table WHERE cid='$cid'" ;
	$crs = mysql_query( $sql , $conn ) ;
	$cat = mysql_fetch_object( $crs ) ;
	display_edit_form( $cat , _AM_MENU_CAT_EDIT , 'update' ) ;

} else if( $disp == "new" ) {

	// 更新時と同じ形のオブジェクトを用意
	class Dummy { var $cid = 0 ; var $pid = 0 ; var $cat_title = '' ; var $cat_desc = '' ; var $weight = 0 ; var $ismenuitem = 0 ; var $udtstamp = 0 ; }
	$cat = new Dummy() ;
	$cat->pid = $cid ;
	$cat->udtstamp = time() ;
	display_edit_form( $cat , _AM_MENU_CAT_NEW , 'insert' ) ;

} else {

	echo "<h4>"._AM_MENU_CATEGORIES."</h4>\n" ;

	if( ! empty( $_GET['mes'] ) ) echo "<p><font color='blue'>".htmlspecialchars($_GET['mes'],ENT_QUOTES)."</font></p>" ;

	echo "<p><a href='?disp=new&cid=0'>"._AM_MB_MAKETOPCAT."<img src='../images/cat_add.gif' width='18' height='15' alt='' /></a></p>\n" ;

	// カテゴリーデータ取得
	$cat_tree_array = $cattree->getChildTreeArray( 0 , 'weight ASC,cat_title' ) ;

	// TH Part
	echo "
	<form name='MainForm' action='' method='post' style='margin:10px;'>
	".$xoopsGTicket->getTicketHtml( __LINE__ )."
	<input type='hidden' name='delcat' value='' />
	<table width='75%' class='outer' cellpadding='4' cellspacing='1'>
	  <tr valign='middle'>
	    <th>"._AM_CAT_TH_TITLE."</th>
	    <th>"._AM_CAT_TH_OPERATION."</th>
	    <th>"._AM_CAT_TH_ENABLED."</th>
	    <th>"._AM_CAT_TH_WEIGHT."</th>
	  </tr>
	" ;

	// リスト出力部
	$oddeven = 'odd' ;
	foreach( $cat_tree_array as $cat_node ) {
		$oddeven = ( $oddeven == 'odd' ? 'even' : 'odd' ) ;
		extract( $cat_node ) ;

		$prefix = str_replace( '.' , '&nbsp;--' , substr( $prefix , 1 ) ) ;
		$enable_checked = $enabled ? "checked='checked'" : "" ;
		$cid = intval( $cid ) ;
		$cat_title = $myts->makeTBoxData4Show( $cat_title ) ;
		$del_confirm = 'confirm("' . sprintf( _AM_FMT_CATDELCONFIRM , $cat_title ) . '")' ;
		echo "
	  <tr>
	    <td class='$oddeven' width='100%'><a href='?disp=edit&amp;cid=$cid'>$prefix&nbsp;$cat_title</a></td>
	    <td class='$oddeven' align='center' nowrap='nowrap'>
	      <a href='$mod_url/index.php?action=Edit&amp;cid=$cid' target='_blank'><img src='$cal->images_url/addevent.gif' border='0' width='14' height='12' /></a>
	      &nbsp;
	      <a href='?disp=edit&amp;cid=$cid'><img src='../images/cat_edit.gif' width='18' height='15' alt='"._AM_MENU_CAT_EDIT."' title='"._AM_MENU_CAT_EDIT."' /></a>
	      &nbsp;
	      <a href='?disp=new&amp;cid=$cid'><img src='../images/cat_add.gif' width='18' height='15' alt='"._AM_MENU_CAT_NEW."' title='"._AM_MENU_CAT_NEW."' /></a>
	      &nbsp;
	      <input type='button' value='"._DELETE."'  onclick='if($del_confirm){document.MainForm.delcat.value=\"$cid\"; submit();}' />
	    </td>
	    <td class='$oddeven' align='center'><input type='checkbox' name='enabled[$cid]' value='1' $enable_checked /></td>
	    <td class='$oddeven' align='right'><input type='text' name='weights[$cid]' size='4' maxlength='6' value='$weight' /></td>
	  </tr>\n" ;
	}

	// テーブルフッタ部
	echo "
	  <tr>
	    <td colspan='4' align='right' class='head'><input type='submit' name='batch_update' value='"._AM_BTN_UPDATE."' /></td>
	  </tr>
	  <tr>
	    <td colspan='8' align='right' valign='bottom' height='50'>".PICAL_COPYRIGHT."</td>
	  </tr>
	</table>
	</form>
	" ;
}


xoops_cp_footer();
?>
