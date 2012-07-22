<?php
require_once '../../mainfile.php';
if (!defined('XOOPS_TRUST_PATH')) {die('set XOOPS_TRUST_PATH in mainfile.php');}

$mydirname = basename(dirname(__FILE__));
$mydirpath = dirname(__FILE__);
require $mydirpath . '/mytrustdirname.php'; // set $mytrustdirname
require_once XOOPS_TRUST_PATH . '/modules/' . $mytrustdirname . '/router.php';

$router_class = ucfirst(strtolower($mytrustdirname)) . '_Router';
$route = new $router_class();
$route->init(array(
                   'mydirname' => $mydirname,
                   'mytrustdirname' => $mytrustdirname,
                   'mydirpath' => $mydirpath,
                   )
             );
$route->execute();
