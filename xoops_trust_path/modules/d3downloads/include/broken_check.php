<?php

require_once dirname( dirname(__FILE__) ).'/class/broken_download.php' ;

$broken_report = new broken_report( $mydirname ) ;
$broken_report->broken_check_by_cron() ;

?>