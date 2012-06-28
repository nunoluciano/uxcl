<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'dbcss' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","Theme Editor");

// A brief description of this module
define($constpref."_DESC","A module enables you to edit your theme in admin area");

// admin menus
define($constpref.'_ADMENU_CSSADMIN','CSS Management') ;
define($constpref.'_ADMENU_CSSEXPORT','CSS import/export') ;
define($constpref.'_ADMENU_METAHEAD','META Tag') ;
define($constpref.'_ADMENU_SCRIPTHEAD','External Script') ;
define($constpref.'_ADMENU_MYLANGADMIN','Languages') ;
define($constpref.'_ADMENU_MYTPLSADMIN','Templates') ;
define($constpref.'_ADMENU_MYBLOCKSADMIN','Blocks') ;
define($constpref.'_ADMENU_MYPREFERENCES','Preferences') ;

// blocks
define($constpref.'_BNAME_CSSHOOK' , 'CSS hook block' ) ;
define($constpref.'_BNAME_DBCSSHOOK','DBCSS hook block') ;
define($constpref.'_BNAME_METAHOOK','META tag hook block') ;
define($constpref.'_BNAME_SCRIPTHOOK','SCRIPT tag hook block') ;

// configs
define($constpref.'_CSS_TEMPLATE','default template');
define($constpref.'_CSS_TEMPLATEDSC','can be set default template. default: common.css');
define($constpref.'_CSS_URI','URI of CSS file for this module');
define($constpref.'_CSS_URIDSC','relative or absolute path can be set. default: <{$xoops_url}>/common/css/common.css');
define($constpref.'_CSSCACHETIME','CSS cache time for browser (sec)') ;
define($constpref.'_CSSEXPORT_DIR','Directory CSS export ahead') ;
define($constpref.'_CSSEXPORT_DIRDSC','The directory is specified by passing at the installation destination of XOOPS the export "CSS export" function ahead. Moreover, please use it after writing and setting Zoc to this directory. 
<br />Setting example: common/css/(It is the first / unnecessary, and  the last / necessary. )') ;
define($constpref.'_METADATA_CASHE','The data of the META tag is saved to a file in cache. ') ;
define($constpref.'_METADATA_CASHEDSC','The data edited by "META tag management" is saved by the file cash when turning it on. XOOPS_TRUST_PATH/cache/directory is made, and when the file in cache is saved, it writes and it is necessary to set Zoc.') ;
define($constpref.'_SCRIPTDATA_CASHE','The data of an external script is saved to a file in cache. ') ;
define($constpref.'_SCRIPTDATA_CASHEDSC','The data edited by "External script management" is saved in XOOPS_TRUST_PATH/cache/by the file cash when turning it on. When XOOPS_TRUST_PATH/cache/cannot be made outside DocumentRoot, we will recommend this function to be turned off.') ;

}

?>