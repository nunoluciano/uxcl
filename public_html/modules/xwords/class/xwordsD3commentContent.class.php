<?php

require_once XOOPS_TRUST_PATH.'/modules/d3forum/class/D3commentAbstract.class.php' ;

// a class for d3forum comment integration
class xwordsD3commentContent extends D3commentAbstract {

function fetchSummary( $external_link_id )
{
	$db =& Database::getInstance() ;
	$myts =& MyTextSanitizer::getInstance();
	
	$module_handler =& xoops_gethandler( 'module' ) ;
	$module =& $module_handler->getByDirname( $this->mydirname ) ;
	
	$entryID = intval( $external_link_id ) ;
	$mydirname = $this->mydirname ;
	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

	$content_row = $db->fetchArray( $db->query( "SELECT * FROM ".$db->prefix($mydirname."_ent")." WHERE entryID =$entryID" ) ) ;
	if( empty( $content_row ) ) return '' ;

	$categoryID = $content_row['categoryID'];
	$definition = $content_row['definition'];
	$_html = $content_row['html'];
	$_smiley = $content_row['smiley'];
	$_xcodes = $content_row['xcodes'];
	$_breaks = $content_row['breaks'];
	
	$str = strip_tags($myts->displayTarea($content_row['definition'],$_html,$_smiley,$_xcodes,$_breaks));
	$summary = xoops_substr( $str , 0 , 255 );

	$uri = XOOPS_URL.'/modules/'.$mydirname.'/entry.php?&entryID='.$entryID.'&categoryID='.$categoryID;

	return array(
		'dirname' => $mydirname ,
		'module_name' => $module->getVar( 'name' ) ,
		'subject' => $myts->makeTboxData4Show( $content_row['term'] ) ,
		'uri' => $uri,
		'summary' => $summary,
	) ;
}

function validate_id( $link_id )
{
	$entryID = intval( $link_id ) ;
	$mydirname = $this->mydirname ;

	$db =& Database::getInstance() ;

	list( $count ) = $db->fetchRow( $db->query( "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_ent")." WHERE entryID=$entryID" ) ) ;
	if( $count <= 0 ) return false ;
	else return $entryID ;
}

// set forum_dirname from config.com_agent
function setD3forumDirname( $d3forum_dirname = '' )
{
	if( ! empty($this->mod_config['comment_dirname'] ) ) {
    		$this->d3forum_dirname = $this->mod_config['comment_dirname'] ;
	} elseif( ! empty( $params['comment_dirname'] ) ) {
		$this->d3forum_dirname = $params['comment_dirname'] ;
	} else {
		$this->d3forum_dirname = 'd3forum' ;
	}
}

// get forum_id from config.com_agent_forumid
function getForumId( $params )
{
    	if( ! empty( $this->mod_config['comment_forum_id'] ) ) {
    		return $this->mod_config['comment_forum_id'] ;
    	} else if( ! empty( $params['forum_id'] ) ) {
		return intval( $params['forum_id'] ) ;
	} else if( ! empty( $this->mod_config['comment_forum_id'] ) ) {
		return $this->mod_config['comment_forum_id'] ;
	} else {
		return 1 ;
	}
}

}

?>