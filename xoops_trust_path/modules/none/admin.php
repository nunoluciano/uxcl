<?php

$mytrustdirname = basename(dirname(__FILE__));
$mytrustdirpath = dirname(__FILE__);

// environment
require_once XOOPS_ROOT_PATH  .  '/class/template.php';
$module_handler =& xoops_gethandler('module');
$xoopsModule =& $module_handler->getByDirname($mydirname);
$config_handler =& xoops_gethandler('config');
$xoopsModuleConfig =& $config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

// check permission of 'module_admin' of this module
$moduleperm_handler =& xoops_gethandler('groupperm');
if (
    !is_object(@$xoopsUser)
    || !$moduleperm_handler->checkRight('module_admin', $xoopsModule->getVar('mid'), $xoopsUser->getGroups())
    ) die('only admin can access this area');

$xoopsOption['pagetype'] = 'admin';
require XOOPS_ROOT_PATH . '/include/cp_functions.php';

// initialize language manager
$langmanpath = XOOPS_TRUST_PATH . '/libs/altsys/class/D3LanguageManager.class.php';
if (!file_exists($langmanpath)) die('install the latest altsys');
require_once $langmanpath;
$langman =& D3LanguageManager::getInstance();


if (!empty($_GET['lib'])) {
    // common libs (eg.  altsys)
    $lib = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['lib']);
    $page = preg_replace('/[^a-zA-Z0-9_-]/', '', @$_GET['page']);

    // check the page can be accessed (make controllers.php just under the lib)
    $controllers = array();
    if (file_exists(XOOPS_TRUST_PATH . '/libs/' . $lib . '/controllers.php')) {
        require XOOPS_TRUST_PATH . '/libs/' . $lib . '/controllers.php';
        if (!in_array($page, $controllers)) $page = $controllers[0];
    }

    if (file_exists(XOOPS_TRUST_PATH . '/libs/' . $lib . '/' . $page . '.php')) {
        include XOOPS_TRUST_PATH . '/libs/' . $lib . '/' . $page . '.php';
    } else if (file_exists(XOOPS_TRUST_PATH . '/libs/' . $lib . '/index.php')) {
        include XOOPS_TRUST_PATH . '/libs/' . $lib . '/index.php';
    } else {
        die('wrong request');
    }
} else {
    // load language files (main.php & admin.php)
    $langman->read('admin.php', $mydirname, $mytrustdirname);
    $langman->read('main.php', $mydirname, $mytrustdirname);

    // fork each pages of this module
    $page = preg_replace('/[^a-zA-Z0-9_-]/', '', @$_GET['page']);

    xoops_cp_header();
    include dirname(__FILE__) . '/mymenu.php';

    $root =& XCube_Root::getSingleton();
    $root->mController->execute();

    $language = empty($GLOBALS['xoopsConfig']['language']) ? 'english' : $GLOBALS['xoopsConfig']['language'];
    $help = XOOPS_TRUST_PATH . "/modules/{$mytrustdirname}/language/{$language}/help/help.html";
    $ja_help = XOOPS_TRUST_PATH . "/modules/{$mytrustdirname}/language/ja_utf8/help/help.html";

    if (file_exists($help)) {
        readfile($help);
    } else if ($language === 'japanese') {
        $content = str_replace(array('UTF-8', 'utf-8'), _CHARSET, file_get_contents($ja_help));
        echo mb_convert_encoding($content, _CHARSET, 'UTF-8');
    } else {
        $root->mController->executeRedirect(XOOPS_URL . '/', null, 'help not found.');
    }

    xoops_cp_footer();
}
