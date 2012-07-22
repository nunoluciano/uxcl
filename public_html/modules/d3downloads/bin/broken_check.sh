#!/usr/local/bin/php
<?php

//---------------------------------------------------------------------------------------------------
// php -q -f home/***/html/modules/(dirname)/bin/broken_check.sh pass=password [ limit=0 offset=0 ]
//---------------------------------------------------------------------------------------------------

if( ! empty( $_SERVER['HTTP_HOST'] ) ) die( 'This script cannot be accessed via httpd' ) ;

$mydirname = basename( dirname(  dirname( __FILE__ ) ) ) ;

// dummy variables
$_SERVER['REMOTE_ADDR'] = '192.168.0.1' ;
$_SERVER['REQUEST_URI'] = '/modules/'.$mydirname.'/' ;
$_SERVER['REQUEST_METHOD'] = 'GET' ;

require dirname( dirname( dirname( dirname(__FILE__) ) ) ).'/mainfile.php' ;
if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' ) ;

$mydirpath = dirname( dirname( __FILE__ ) ) ;
require $mydirpath.'/mytrustdirname.php' ; // set $mytrustdirname

require XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/include/broken_check.php' ;

?>