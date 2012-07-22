<?php
/**
 * $Id: menu.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Soapbox
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
// XOOPS2 - Xwords 0.28
// Presented by WEBMASTER @ KANPYO.NET, 2005.

$MYDIRNAME = strtoupper(basename(dirname(dirname(__FILE__))));

$adminmenu[0]['title'] = constant("_MI_{$MYDIRNAME}_ADMENU6");
$adminmenu[0]['link'] = "index.php";
$adminmenu[1]['title'] = constant("_MI_{$MYDIRNAME}_ADMENU1");
$adminmenu[1]['link'] = "admin/index.php";
$adminmenu[2]['title'] = constant("_MI_{$MYDIRNAME}_ADMENU2");
$adminmenu[2]['link'] = "admin/category.php";
$adminmenu[3]['title'] = constant("_MI_{$MYDIRNAME}_ADMENU3");
$adminmenu[3]['link'] = "admin/entry.php";
$adminmenu[4]['title'] = constant("_MI_{$MYDIRNAME}_ADMENU4");
$adminmenu[4]['link'] = "admin/myblocksadmin.php";
$adminmenu[5]['title'] = constant("_MI_{$MYDIRNAME}_ADMENU5");
$adminmenu[5]['link'] = "admin/submissions.php";
?>