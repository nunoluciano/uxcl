<?php

require_once( '../../../include/cp_header.php' ) ;
require_once( '../class/piCal.php' ) ;
require_once( '../class/piCal_xoops.php' ) ;


// for "Duplicatable"
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

require_once( XOOPS_ROOT_PATH."/modules/$mydirname/include/gtickets.php" ) ;

// fetch & sanitize from POST & GET
$action = empty( $_POST[ 'action' ] ) ? '' : preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_POST[ 'type' ] ) ;
$type = empty( $_GET[ 'type' ] ) ? 'monthly' : preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET[ 'type' ] ) ;

$limit_type = preg_replace( '/([^0-9A-Za-z_.-]+)/' , '' , @$_GET['limit_type'] ) ;
$limit_dirname = preg_replace( '/([^0-9A-Za-z_.-]+)/' , '' , @$_GET['limit_dirname'] ) ;
$limit_file = preg_replace( '/([^0-9A-Za-z_.-]+)/' , '' , @$_GET['limit_file'] ) ;

// connection to MySQL
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

// get block instances of minicalex
$mcx_blocks = array() ;
if( substr( XOOPS_VERSION , 6 , 3 ) == '2.0' ) {
	// block instance of XOOPS 2.2
	$mcx_rs = $xoopsDB->query( "SELECT i.instanceid,i.title FROM ".$xoopsDB->prefix("block_instance")." i LEFT JOIN ".$xoopsDB->prefix("newblocks")." b ON i.bid=b.bid WHERE b.mid='".$xoopsModule->getVar('mid')."' AND b.show_func='pical_minical_ex_show'" ) ;
} else {
	// newblocks of XOOPS 2.0.x
	$mcx_rs = $xoopsDB->query( "SELECT bid,title FROM ".$xoopsDB->prefix("newblocks")." WHERE mid='".$xoopsModule->getVar('mid')."' AND show_func='pical_minical_ex_show'" ) ;
}
while( list( $bid , $title ) = $xoopsDB->fetchRow( $mcx_rs ) ) {
	$mcx_blocks[ $bid ] = $title ;
}


// データベース更新などがからむ処理
if( ! empty( $_POST['update'] ) ) {

	// Ticket Check
	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}

	// new
	if( ! empty( $_POST['pi_types'][0] ) ) {
		if( $_POST['pi_types'][0] == 'all' ) {
			$types = array( 'monthly' , 'weekly' , 'daily' ) ;
			foreach( $mcx_blocks as $bid => $title ) {
				$types[] = "mcx{$bid}" ;
			}
		} else {
			$types = array( addslashes( $_POST['pi_types'][0] ) ) ;
		}

		$pi_options4sql = addslashes( $_POST['pi_options'][0] ) ;
		$pi_weight4sql = intval( $_POST['pi_weight'][0] ) ;
		$pi_title4sql = addslashes( $_POST['pi_titles'][0] ) ;
		$pi_dirname4sql = addslashes( $_POST['pi_dirnames'][0] ) ;
		$pi_file4sql = addslashes( $_POST['pi_files'][0] ) ;
		$pi_dotgif4sql = addslashes( $_POST['pi_dotgifs'][0] ) ;

		foreach( $types as $type ) {
			$type4sql = addslashes( $type ) ;
			if( ! mysql_query( "INSERT INTO $cal->plugin_table SET pi_type='$type4sql', pi_options='$pi_options4sql', pi_weight='$pi_weight4sql', pi_title='$pi_title4sql', pi_dirname='$pi_dirname4sql', pi_file='$pi_file4sql', pi_dotgif='$pi_dotgif4sql', pi_enabled='1'" , $conn ) ) die( mysql_error() ) ;
		}
	}

	// バッチアップデート
	foreach( array_keys( $_POST['pi_titles'] ) as $pi_id ) {
		if( $pi_id <= 0 ) continue ;
		if( ! empty( $_POST['deletes'][$pi_id] ) ) {
			if( ! mysql_query( "DELETE FROM $cal->plugin_table WHERE pi_id=$pi_id" , $conn ) ) die( mysql_error() ) ;
		} else {
			$pi_type4sql = addslashes( $_POST['pi_types'][$pi_id] ) ;
			$pi_options4sql = addslashes( $_POST['pi_options'][$pi_id] ) ;
			$pi_weight4sql = intval( $_POST['pi_weight'][$pi_id] ) ;
			$pi_title4sql = addslashes( $_POST['pi_titles'][$pi_id] ) ;
			$pi_title4sql = addslashes( $_POST['pi_titles'][$pi_id] ) ;
			$pi_dirname4sql = addslashes( $_POST['pi_dirnames'][$pi_id] ) ;
			$pi_file4sql = addslashes( $_POST['pi_files'][$pi_id] ) ;
			$pi_dotgif4sql = addslashes( $_POST['pi_dotgifs'][$pi_id] ) ;
			$pi_enabled4sql = ! empty( $_POST['pi_enableds'][$pi_id] ) ? 1 : 0 ;
	
			if( ! mysql_query( "UPDATE $cal->plugin_table SET pi_type='$pi_type4sql', pi_options='$pi_options4sql', pi_weight='$pi_weight4sql', pi_title='$pi_title4sql', pi_dirname='$pi_dirname4sql', pi_file='$pi_file4sql', pi_dotgif='$pi_dotgif4sql', pi_enabled='$pi_enabled4sql' WHERE pi_id=$pi_id" , $conn ) ) die( mysql_error() ) ;
		}
	}

	// remove cache of piCal minical_ex
	if( $handler = opendir( XOOPS_CACHE_PATH . '/' ) ) {
		while( ( $file = readdir( $handler ) ) !== false ) {
			if( substr( $file , 0 , 16 ) == 'piCal_minical_ex' ) {
				@unlink( XOOPS_CACHE_PATH . '/' . $file ) ;
			}
		}
	}

	$mes = urlencode( sprintf( _AM_PI_UPDATED ) ) ;
	$redirect_str4header = strtr( "Location: $cal->connection://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?mes=$mes&limit_type=$limit_type&limit_dirname=$limit_dirname&limit_file=$limit_file" , "\r\n\0" , "   " ) ;

	header( $redirect_str4header ) ;
	exit ;

}


// メイン出力部
xoops_cp_header();
include( './mymenu.php' ) ;

	echo "<h4>"._MI_PICAL_ADMENU_PLUGINS."</h4>\n" ;

	if( ! empty( $_GET['mes'] ) ) echo "<p><font color='blue'>".htmlspecialchars($_GET['mes'],ENT_QUOTES)."</font></p>" ;

	// mains (monthly, weekly, daily)
	$type_options = "<option value='monthly'>"._AM_PI_VIEWMONTHLY."</option>\n" ;
	$type_options .= "<option value='weekly'>"._AM_PI_VIEWWEEKLY."</option>\n" ;
	$type_options .= "<option value='daily'>"._AM_PI_VIEWDAILY."</option>\n" ;
	// blocks - minicalex (mcx . $bid)
	foreach( $mcx_blocks as $bid => $title ) {
		$type_options .= "<option value='mcx{$bid}'>".$myts->makeTboxData4Show($title)."</option>\n" ;
	}
	$type_options4new = "<option value=''>----</option>\n<option value='all'>"._ALL."</option>\n" . $type_options ;
	$type_options = "<option value=''>----</option>\n" . $type_options ;

	// dirname options
	$dirname_options = "<option value=''>----</option>\n" ;
	$dn_rs = $xoopsDB->query( "SELECT dirname FROM ".$xoopsDB->prefix("modules") ) ;
	while( list( $dirname ) = $xoopsDB->fetchRow( $dn_rs ) ) {
		$dirname_options .= "<option value='$dirname'>$dirname</option>\n" ;
	}

	// plugin file options
	$file_options = "<option value=''>----</option>\n" ;
	$plugins_dir = $cal->base_path . '/' . $cal->plugins_path_monthly ;
	$dir_handle = opendir( $plugins_dir ) ;
	$valid_files = array() ;
	while( ( $file = readdir( $dir_handle ) ) !== false ) {
		if( is_file( "$plugins_dir/$file" ) ) {
			list( $node , $ext ) = explode( '.' , $file ) ;
			if( $ext != 'php' ) continue ;
			$valid_files[] = $file ;
		}
	}
	closedir( $dir_handle ) ;
	sort( $valid_files ) ;
	foreach( $valid_files as $file ) {
		$file4disp = htmlspecialchars( $file , ENT_QUOTES ) ;
		$file_options .= "<option value='$file4disp'>$file4disp</option>\n" ;
	}

	// dotgif options
	$dotgif_options = '' ;
	$dir_handle = opendir( $cal->images_path ) ;
	$valid_images = array() ;
	while( ( $file = readdir( $dir_handle ) ) !== false ) {
		if( is_file( "$cal->images_path/$file" ) ) {
			list( $node , $ext ) = explode( '.' , $file ) ;
			if( $ext != 'gif' && $ext != 'png' && $ext != 'jpg' ) continue ;
			if( substr( $node , 0 , 3 ) != 'dot' ) continue ;
			$valid_images[] = $file ;
		}
	}
	closedir( $dir_handle ) ;
	sort( $valid_images ) ;
	foreach( $valid_images as $file ) {
		$file4disp = htmlspecialchars( $file , ENT_QUOTES ) ;
		$dotgif_options .= "<option value='$file4disp'>$file4disp</option>\n" ;
	}

	// ordering the records of plugins
	$columns = array( 'pi_id' , 'pi_title' , 'pi_type' , 'pi_dirname' , 'pi_file' , 'pi_dotgif' , 'pi_options' , 'pi_enabled' , 'pi_weight' ) ;
	$order = in_array( @$_GET['order'] , $columns ) ? $_GET['order'] : 'pi_type' ;
	// type limitation
	if( ! empty( $limit_type ) ) {
		$whr_type = "pi_type='".addslashes($limit_type)."'" ;
	} else {
		$whr_type = '1' ;
	}

	// dirname limitation
	if( ! empty( $limit_dirname ) ) {
		$whr_dirname = "pi_dirname='".addslashes($limit_dirname)."'" ;
	} else {
		$whr_dirname = '1' ;
	}

	// file limitation
	if( ! empty( $limit_file ) ) {
		$whr_file = "pi_file='".addslashes($limit_file)."'" ;
	} else {
		$whr_file = '1' ;
	}

	// select forms for extracting
	echo "
	<form name='extraction' action='' method='get' style='margin:0px;'>
		<select name='limit_type'>".make_selected($type_options,$limit_type)."</select>
		<select name='limit_dirname'>".make_selected($dirname_options,$limit_dirname)."</select>
		<select name='limit_file'>".make_selected($file_options,$limit_file)."</select>
		<input type='submit' value='"._AM_BUTTON_EXTRACT."' />
	</form>
	" ;


	// プラグインデータ取得
	$prs = $xoopsDB->query( "SELECT * FROM $cal->plugin_table WHERE ($whr_type) AND ($whr_dirname) AND ($whr_file) ORDER BY $order, pi_weight" ) ;

	// TH Part
	echo "
	<form name='MainForm' action='?limit_type=$limit_type&amp;limit_dirname=$limit_dirname&amp;limit_file=$limit_file' method='post' style='margin:0px;'>
	".$xoopsGTicket->getTicketHtml( __LINE__ )."
	<table width='100%' class='outer' cellpadding='4' cellspacing='1'>
	  <tr valign='middle'>
	    <th><a href='?order=pi_type' style='color:white;'>"._AM_PI_TH_TYPE."</a></th>
	    <th><a href='?order=pi_dirname' style='color:white;'>"._AM_PI_TH_DIRNAME."</a></th>
	    <th><a href='?order=pi_file' style='color:white;'>"._AM_PI_TH_FILE."</a></th>
	    <th><a href='?order=pi_title' style='color:white;'>"._AM_PI_TH_TITLE."</a></th>
	    <th><a href='?order=pi_dotgif' style='color:white;'>"._AM_PI_TH_DOTGIF."</a></th>
	    <th><a href='?order=pi_options' style='color:white;'>"._AM_PI_TH_OPTIONS."</a></th>
	    <th>&lt;-&gt;</th>
	    <th>"._AM_PI_ENABLED."</th>
	    <th>"._AM_PI_DELETE."</th>
	  </tr>
	" ;

	// リスト出力部
	$oddeven = 'odd' ;
	while( $plugin = mysql_fetch_object( $prs ) ) {
		$oddeven = ( $oddeven == 'odd' ? 'even' : 'odd' ) ;

		$pi_id = intval( $plugin->pi_id ) ;
		$enable_checked = $plugin->pi_enabled ? "checked='checked'" : "" ;
		$pi_title = $myts->makeTBoxData4Edit( $plugin->pi_title ) ;
		$del_confirm = 'confirm("' . sprintf( _AM_FMT_CATDELCONFIRM , $pi_title ) . '")' ;
		$pi_options4disp = htmlspecialchars( $plugin->pi_options , ENT_QUOTES ) ;
		echo "
	  <tr>
	    <td class='$oddeven'>
	      <select name='pi_types[$pi_id]'>
	        ".make_selected($type_options,$plugin->pi_type)."
	      </select>
	    </td>
	    <td class='$oddeven'>
	      <select name='pi_dirnames[$pi_id]'>
	        ".make_selected($dirname_options,$plugin->pi_dirname)."
	      </select>
	    </td>
	    <td class='$oddeven'>
	      <select name='pi_files[$pi_id]'>
	        ".make_selected($file_options,$plugin->pi_file)."
	      </select>
	    </td>
	    <td class='$oddeven'>
	      <input type='text' name='pi_titles[$pi_id]' value='$pi_title' size='8' />
	    </td>
	    <td class='$oddeven'>
	      <select name='pi_dotgifs[$pi_id]'>
	        ".make_selected($dotgif_options,$plugin->pi_dotgif)."
	      </select>
	    </td>
	    <td class='$oddeven'>
	      <input type='text' name='pi_options[$pi_id]' value='$pi_options4disp' size='10' />
	    </td>
	    <td class='$oddeven'>
	      <input type='text' name='pi_weight[$pi_id]' value='$plugin->pi_weight' size='2' style='text-align:right;' />
	    </td>
	    <td class='$oddeven'>
	      <input type='checkbox' value='1' name='pi_enableds[$pi_id]' $enable_checked />
	    </td>
	    <td class='$oddeven'>
	      <input type='checkbox' value='1' name='deletes[$pi_id]' />
	    </td>
	  </tr>
		\n" ;
	}

	// 新規入力部
	echo "
	  <tr>
	    <td colspan='9'><br /></td>
	  </tr>
	  <tr>
	    <td class='$oddeven' style='background-color:#FFCCCC;'>
	      <select name='pi_types[0]'>$type_options4new</select>
	    </td>
	    <td class='$oddeven' style='background-color:#FFCCCC;'>
	      <select name='pi_dirnames[0]'>$dirname_options</select>
	    </td>
	    <td class='$oddeven' style='background-color:#FFCCCC;'>
	      <select name='pi_files[0]'>
	        ".make_selected($file_options,"piCal.php")."
	      </select>
	    </td>
	    <td class='$oddeven' style='background-color:#FFCCCC;'>
	      <input type='text' name='pi_titles[0]' value='' size='8' />
	    </td>
	    <td class='$oddeven' style='background-color:#FFCCCC;'>
	      <select name='pi_dotgifs[0]'>
	        ".make_selected($dotgif_options,"dot8x8blue.gif")."
	      </select>
	    </td>
	    <td class='$oddeven' style='background-color:#FFCCCC;'>
	      <input type='text' name='pi_options[0]' value='' size='10' />
	    </td>
	    <td class='$oddeven' style='background-color:#FFCCCC;'>
	      <input type='text' name='pi_weight[0]' value='0' size='2' style='text-align:right;' />
	    </td>
	    <td class='$oddeven' colspan='2' style='background-color:#FFCCCC;'>
	      "._AM_PI_NEW."
	    </td>
	  </tr>
		\n" ;

	// テーブルフッタ部
	echo "
	  <tr>
	    <td colspan='9' align='right' class='head'><input type='submit' name='update' value='"._AM_BTN_UPDATE."' /></td>
	  </tr>
	  <tr>
	    <td colspan='9' align='right' valign='bottom' height='50'>".PICAL_COPYRIGHT."</td>
	  </tr>
	</table>
	</form>
	" ;

xoops_cp_footer();


function make_selected( $options , $current )
{
	return str_replace( "value='{$current}'>" , "value='{$current}' selected='selected'>" , $options ) ;

}


?>
