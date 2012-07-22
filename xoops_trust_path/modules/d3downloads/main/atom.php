<?php

error_reporting(0);

require_once dirname( dirname(__FILE__) ).'/include/make_rss.inc.php';

d3download_common_make_feed( $mydirname, 'atom' );

?>