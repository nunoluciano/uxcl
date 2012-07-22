<?php
	include '../../mainfile.php';
	if (function_exists('mb_http_output')) {
		mb_http_output('pass');
	}
	header ('Content-Type:text/xml; charset=utf-8');

	// for "Duplicatable"
	$mydirname = basename( dirname( __FILE__ ) ) ;
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	// setting physical & virtual paths
	$mod_path = XOOPS_ROOT_PATH."/modules/$mydirname" ;
	$mod_url = XOOPS_URL."/modules/$mydirname" ;

	// defining class of piCal
	require_once( "$mod_path/class/piCal.php" ) ;
	require_once( "$mod_path/class/piCal_xoops.php" ) ;

	// creating an instance of piCal 
	$cal = new piCal_xoops( date( 'Y-n-j' ) , $xoopsConfig['language'] , true ) ;
	$cal->use_server_TZ = true ;

	// ignoring cid from GET
	// $cal->now_cid = 0 ;

	// setting properties of piCal
	$cal->conn = $xoopsDB->conn ;
	include( "$mod_path/include/read_configs.php" ) ;
	$cal->base_url = $mod_url ;
	$cal->base_path = $mod_path ;
	$cal->images_url = "$mod_url/images/$skin_folder" ;
	$cal->images_path = "$mod_path/images/$skin_folder" ;

	$block = $cal->get_blockarray_date_event( "$mod_url/index.php" ) ;


//mb_http_output( 'UTF-8' ) ;
//ob_start( 'mb_output_handler' ) ;
ob_start( 'xoops_utf8_encode' ) ;

echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<rss version=\"2.0\">
  <channel>
    <title>".$xoopsModule->getVar('name').' - '.htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)."</title>
    <link>$mod_url/</link>
    <description>".htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)."</description>
    <lastBuildDate>".formatTimestamp(time(),'r')."</lastBuildDate>
    <webMaster>".$xoopsConfig['adminmail']."</webMaster>
    <editor>".$xoopsConfig['adminmail']."</editor>
    <category>Calendar</category>
    <generator>piCal for XOOPS</generator>
    <language>"._LANGCODE."</language>\n" ;

foreach( $block['events'] as $event ) {

	$start = date( "n/j G:i" , $event['start'] ) ;
	$summary = pical_get_escaped4xml( $event['summary'] ) ;
	$description = pical_get_escaped4xml( $event['description'] ) ;

	echo "
    <item>
      <title>$start $summary</title>
      <link>$mod_url/?event_id={$event['id']}</link>
      <description>$description</description>
    </item>\n" ;

//      <pubDate>".formatTimestamp($event['start'],'r')."</pubDate>

}

echo "
  </channel>
</rss>\n" ;

function pical_get_escaped4xml( $text )
{
	return htmlspecialchars( str_replace( array( '&#039;' , '&quot;' , '&lt;' , '&gt;' ) , array( "'" , '"' , '<' , '>' ) , $text ) , ENT_QUOTES ) ;
}


?>