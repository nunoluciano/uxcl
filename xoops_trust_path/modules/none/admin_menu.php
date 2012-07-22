<?php

$constpref = '_MI_' . strtoupper($mydirname);

$adminmenu = array();

$adminmenu4altsys =
    array(
          array(
                'title' => _MI_ALTSYS_MENU_MYBLOCKSADMIN,
                'link' => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin',
                ),
          array(
                'title' => _MI_ALTSYS_MENU_MYTPLSADMIN,
                'link' => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin',
                ),
          array(
                'title' =>  _MI_ALTSYS_MENU_MYLANGADMIN,
                'link' => 'admin/index.php?mode=admin&lib=altsys&page=mylangadmin',
                ),
          array(
                'title' => _PREFERENCES,
                'link' => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences',
                ),
          array(
                'title' => _HELP,
                'link' => 'admin/index.php?mode=admin&page=help',
                ),
          );
