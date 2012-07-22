<?php
require_once '../../mainfile.php';
require_once 'config.php';

$page_name = isset($_REQUEST[XSNS_PAGE_ARG]) ? preg_replace('/[^0-9a-zA-Z_]/', '', $_REQUEST[XSNS_PAGE_ARG]) : 'index';
require_once XSNS_FRAMEWORK_DIR.'/loader.php';
require_once XSNS_TRUST_PATH.'/include/language.php';
xsns_load_language('main.php');
XsnsController::execute($page_name);

?>
