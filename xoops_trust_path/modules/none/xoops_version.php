<?php
$langmanpath = XOOPS_TRUST_PATH . '/libs/altsys/class/D3LanguageManager.class.php';
if (!file_exists($langmanpath)) {
    die('install the latest altsys');
}
require_once $langmanpath;
$langman =& D3LanguageManager::getInstance();
$langman->read('modinfo.php', $mydirname, $mytrustdirname, false);

$constpref = '_MI_' . strtoupper($mydirname);
$modinfo_name = constant($constpref . '_NAME');
if (empty($modinfo_name)) {
    $modinfo_name = $mydirname;
}
$modinfo_desc = constant($constpref . '_DESC');
if (empty($modinfo_desc)) {
    $modinfo_desc = $mydirname;
}
$modversion['name'] = $modinfo_name;
$modversion['version'] = '1.12';
$modversion['description'] = $modinfo_desc;
$modversion['license'] = 'GPL see LICENSE';
$modversion['image']    = 'none.gif';
$modversion['credits'] = 'office@ryus.co.jp';
$modversion['author'] = 'naoto';
$modversion['help'] = null; // -> altsys menu "help"
$modversion['cube_style'] = true;
$modversion['official'] = 0;
$modversion['dirname']  = $mydirname;

// Any tables can't be touched by modulesadmin.
$modversion['sqlfile'] = false;
$modversion['tables'] = array();

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/admin_menu.php';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'search.php';
$modversion['search']['func'] = $mydirname . '_global_search';

// Notification
$modversion['hasNotification'] = 0;

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'id';
$modversion['comments']['pageName'] = 'index.php';
// Comment callback functions
$modversion['comments']['callbackFile'] = 'comment.php';
$modversion['comments']['callback']['approve'] = $mydirname . '_comments_approve';
$modversion['comments']['callback']['update'] = $mydirname . '_comments_update';

// Menu
$modversion['hasMain'] = 1;
// $modversion['sub'][1]['name'] = constant($constpref . '_NAME');
// $modversion['sub'][1]['url'] = 'index.php';

// onInstall, onUpdate, onUninstall
$modversion['onInstall'] = 'oninstall.php';
$modversion['onUpdate'] = 'onupdate.php';
$modversion['onUninstall'] = 'onuninstall.php';

// Templates
$modversion['templates'] = array();

// Preference
$modversion['config'] =
    array(
          array(
                'name' => 'user_1',
                'title' => $constpref . '_PREF_USER_1',
                'description' => $constpref . '_PREF_USER_DESC',
                'formtype' => 'textbox',
                'valuetype' => 'text',
                'default' => '',
                'options' => array()
                ),
          array(
                'name' => 'user_2',
                'title' => $constpref . '_PREF_USER_2',
                'description' => '',
                'formtype' => 'textbox',
                'valuetype' => 'text',
                'default' => '',
                'options' => array()
                ),
          array(
                'name' => 'user_3',
                'title' => $constpref . '_PREF_USER_3',
                'description' => '',
                'formtype' => 'textbox',
                'valuetype' => 'text',
                'default' => '',
                'options' => array()
                ),
          array(
                'name' => 'user_4',
                'title' => $constpref . '_PREF_USER_4',
                'description' => '',
                'formtype' => 'textbox',
                'valuetype' => 'text',
                'default' => '',
                'options' => array()
                ),
          array(
                'name' => 'user_5',
                'title' => $constpref . '_PREF_USER_5',
                'description' => '',
                'formtype' => 'textbox',
                'valuetype' => 'text',
                'default' => '',
                'options' => array()
                ),
          array(
                'name' => 'user_6',
                'title' => $constpref . '_PREF_USER_6',
                'description' => '',
                'formtype' => 'textarea',
                'valuetype' => 'text',
                'default' => '',
                ),
          array(
                'name' => 'user_7',
                'title' => $constpref . '_PREF_USER_7',
                'description' => '',
                'formtype' => 'textarea',
                'valuetype' => 'text',
                'default' => '',
                ),
          array(
                'name' => 'user_8',
                'title' => $constpref . '_PREF_USER_8',
                'description' => '',
                'formtype' => 'yesno',
                'valuetype' => 'int',
                'default' => 1
                ),
          array(
                'name' => 'user_9',
                'title' => $constpref . '_PREF_USER_9',
                'description' => '',
                'formtype' => 'yesno',
                'valuetype' => 'int',
                'default' => 1
                ),
          array(
                'name' => 'search_comment',
                'title' => $constpref . '_SEARCH_COMMENT',
                'description' => '',
                'formtype' => 'yesno',
                'valuetype' => 'int',
                'default' => 0
                ),
          array(
                'name' => 'comment_dirname',
                'title' => $constpref . '_COM_DIRNAME',
                'description' => '',
                'formtype' => 'textbox',
                'valuetype' => 'text',
                'default' => 'd3forum',
                'options' => array()
                ),
          array(
                'name' => 'comment_forum_id',
                'title' => $constpref . '_COM_FORUM_ID',
                'description' => '',
                'formtype' => 'textbox',
                'valuetype' => 'int',
                'default' => '0',
                'options' => array()
                ),
          array(
                'name' => 'comment_view',
                'title' => $constpref . '_COM_VIEW',
                'description' => '',
                'formtype' => 'select',
                'valuetype' => 'text',
                'default' => 'listposts_flat',
                'options' => array(
                                   '_FLAT' => 'listposts_flat',
                                   '_THREADED' => 'listtopics'
                                   )
                ),
          );

//Blocks
$modversion['blocks'] =
    array(
          array(
                'file' => 'blocks.php',
                'name' => constant($constpref . '_BLOCK'),
                'description' => constant($constpref . '_BLOCK_DESC'),
                'show_func' => 'b_none_show',
                'edit_func' => 'b_none_edit',
                'template' => '',
                'options' => $mydirname,
                'can_clone' => true
                )
          );

// keep block's options
if (
    !defined('XOOPS_CUBE_LEGACY')
    && substr(XOOPS_VERSION, 6, 3) < 2.1
    && !empty($_POST['fct']) && $_POST['fct'] == 'modulesadmin'
    && !empty($_POST['op']) && $_POST['op'] == 'update_ok'
    && $_POST['dirname'] == $mydirname
    ) {
    include dirname(__FILE__) . '/x20_keepblockoptions.inc.php';
}
