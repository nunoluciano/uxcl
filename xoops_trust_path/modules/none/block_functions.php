<?php

function b_none_show($options)
{
    $mydirname = empty($options[0]) ? basename(dirname(__FILE__)) : $options[0];
    $mytrustdirname = basename(dirname(__FILE__));
    $this_template = empty($options[1]) ? 'db:' . $mydirname . '_block_none.tpl' : trim($options[1]);

    // prepare
    $root =& XCube_Root::getSingleton();
    $context =& $root->getContext();
    $textFilter =& $root->getTextFilter();
    $moduleHandler =& xoops_gethandler('module');
    $configHandler =& xoops_gethandler('config');
    $tpl = new Legacy_XoopsTpl();

    // setup block contents
    $myconfig =& $configHandler->getConfigsByDirname($mydirname);
    $myconfig['dirname'] = $mydirname;
    $block = array(
                   'mydirname' => $mydirname,
                   'mytrustdirname' => $mytrustdirname,
                   'mod_url' => XOOPS_URL . '/modules/' . $mydirname,
                   'config' => $myconfig,
                   'content' => ''
                   );
    $tpl->assign('block', $block);

    // assign like themes
    $tpl->assign(array('xoops_requesturi' => htmlspecialchars($GLOBALS['xoopsRequestUri'], ENT_QUOTES),));
    $tpl->assign('xoops_sitename', $textFilter->toShow($context->getAttribute('legacy_sitename')));
    $tpl->assign('xoops_pagetitle', $textFilter->toShow($context->getAttribute('legacy_pagetitle')));
    $tpl->assign('xoops_slogan', $textFilter->toShow($context->getAttribute('legacy_slogan')));

    // meta, etc...
    $legacyRender =& $moduleHandler->getByDirname('legacyRender');
    if (is_object($legacyRender)) {
        $configs =& $configHandler->getConfigsByCat(0, $legacyRender->get('mid'));
        $tpl->assign('xoops_meta_keywords', $textFilter->toShow($configs['meta_keywords']));
        $tpl->assign('xoops_meta_description', $textFilter->toShow($configs['meta_description']));
        $tpl->assign('xoops_meta_robots', $textFilter->toShow($configs['meta_robots']));
        $tpl->assign('xoops_meta_rating', $textFilter->toShow($configs['meta_rating']));
        $tpl->assign('xoops_meta_author', $textFilter->toShow($configs['meta_author']));
        $tpl->assign('xoops_meta_copyright', $textFilter->toShow($configs['meta_copyright']));
        $tpl->assign('xoops_footer', $configs['footer']); // footer may be raw HTML text.
        $tpl->assign('xoops_banner','&nbsp;');
    }

    // user
    $arr = null;
    if (is_object($context->mXoopsUser)) {
        $arr = array(
                     'xoops_isadmin' => $context->mUser->isInRole('Site.Administrator'),
                     'xoops_isuser' => true,
                     'xoops_userid' => $context->mXoopsUser->getShow('uid'),
                     'xoops_uname' => $context->mXoopsUser->getShow('uname')
                     );
    } else {
        $arr = array('xoops_isuser' => false);
    }
    $tpl->assign($arr);

    // theme
    $tpl->assign('xoops_theme', $context->mXoopsConfig['theme_set']);
    $tpl->assign('xoops_imageurl', XOOPS_THEME_URL . DIRECTORY_SEPARATOR . $context->mXoopsConfig['theme_set']);

    // legacy
    $tpl->assign('legacy_buffertype', 'block');

    $contextModule =& $root->mContext->mModule;
    if (!is_null($contextModule)) {
        $tpl->assign('legacy_module', $contextModule->mXoopsModule->get('dirname'));
        $tpl->assign('xoops_dirname', $contextModule->mXoopsModule->get('dirname'));
        $tpl->assign('xoops_modulename', $contextModule->mXoopsModule->get('name'));
    }

    // render and return
    $ret = array();
    $ret['content'] = $tpl->fetch($this_template);
    unset($tpl);
    return $ret;
}

function b_none_edit($options)
{
    $mydirname = empty($options[0]) ? 'none' : $options[0];
    $this_template = empty($options[1]) ? 'db:' . $mydirname . '_block_none.tpl' : trim($options[1]);
    $this_template = htmlspecialchars($this_template, ENT_QUOTES);
    if (preg_match('/[^0-9a-zA-Z_-]/', $mydirname)) {die( 'Invalid mydirname');}

    $form = <<<HTML_HERE
<input type="hidden" name="options[0]" value="{$mydirname}" />
<label for="this_template">template</label>&nbsp;
<input type="text" size="60" name="options[1]" id="this_template" value="{$this_template}" />
HTML_HERE;

    return $form;
}

function b_none_xcl_show($options)
{
    $mydirname = empty($options[0]) ? basename(dirname(__FILE__)) : $options[0];
    $chandler =& xoops_gethandler('config');
    $config =& $chandler->getConfigsByDirname($mydirname);
    $config['dirname'] = $mydirname;

    $block = array(
                   'mydirname' => $mydirname,
                   'mod_url' => XOOPS_URL . '/modules/' . $mydirname,
                   'config' => $config,
                   'content' => '',
                   );
    return array($block);
}
