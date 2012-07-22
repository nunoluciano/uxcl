<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'attachfile' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","Attach file");

// A brief description of this module
define($constpref."_DESC","Attach file module for XOOPS");

// admin menus
define($constpref.'_ADMENU_LIST','Attachfile list');

// configurations
define($constpref.'_LINK_ENC','Tile encoding for display');
define($constpref.'_LINK_ENCDSC','');
define($constpref.'_TTL_ENC_IE','Tile encoding for download (MSIE)');
define($constpref.'_TTL_ENC_IEDSC','');
define($constpref.'_TTL_ENC_OTH','Tile encoding for download (non MSIE)');
define($constpref.'_TTL_ENC_OTHDSC','');
define($constpref.'_MAX_SIZE','Max size per one file (KB)');
define($constpref.'_MAX_SIZEDSC','');
define($constpref.'_MIMEM','Upload MIME-Type limit mode');
define($constpref.'_MIMEMDSC','None : Unlimit, Deny : Deny listed MIME-Types, Allow : Allow listed MIME-Types only');
define($constpref.'_MIMET','Upload MIME-Type list');
define($constpref.'_MIMETDSC','Delimit by "|". Ex. "text/plain|image/gif|image/jpeg"');
define($constpref.'_F_PRE','Real filename prefix');
define($constpref.'_F_PREDSC','Prefix of files in XOOPS_TRUST_PATH (If you change this selection, you need to change filename manually.)');

define($constpref.'_MIMEM_NON_N','None');					// 0
define($constpref.'_MIMEM_DNY_N','Deny');					// 1
define($constpref.'_MIMEM_ALW_N','Allow');					// 2
define($constpref.'_F_PRE_NON_N','None');					// 0
define($constpref.'_F_PRE_DBP_N','Same XOOPS_DB_PREFIX');	// 1
define($constpref.'_F_PRE_DBN_N','Same XOOPS_DB_NAME');		// 2

}

?>