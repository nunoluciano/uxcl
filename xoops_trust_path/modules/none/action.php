<?php
/**
 *
 * @file
 * @package ryus_none
 * @version $Id: action.php 257 2009-06-05 05:27:44Z naoto $
 *
 */

class None_Action
{
    protected $mRoot = null;
    protected $mMyDirname = null;

    public function index()
    {
        $this->mRoot->mController->executeHeader();

        $mymodulename = basename(dirname(dirname(__FILE__)));
        $chandler =& xoops_gethandler('config');
        $config =& $chandler->getConfigsByDirname($this->mMyDirname);
        $config['dirname'] = $this->mMyDirname;
        if (isset($this->mRoot->mContext->mModule)) {
            $config['dirname'] = $this->mRoot->mContext->mModule->mXoopsModule->get('dirname');
        }

        $render =& $this->mRoot->mContext->mModule->getRenderTarget();
        $render->setTemplateName($this->mMyDirname . '_index.tpl');
        $render->setAttribute('config', $config);
        $breadcrumbs = null;
        if (!empty($breadcrumbs)) {
            $render->setAttribute('xoops_breadcrumbs', $this->getBreadcrumbs($breadcrumbs));
        }
        $this->mRoot->mController->executeView();
    }

    public function __construct($mydirname)
    {
        $this->mRoot =& XCube_Root::getSingleton();
        $this->mMyDirname = $mydirname;
    }

    public function isRegisteredUser()
    {
        return $this->mRoot->mContext->mUser->isInRole('Site.RegisteredUser');
    }

    public function getUid()
    {
        if ($this->isRegisteredUser()) {
            return $this->mRoot->mContext->mXoopsUser->uid();
        } else {
            return null;
        }
    }

    public function getBreadcrumbs($text, $url = null)
    {
        $breadcrumbs[] = array(
                               'url' => $url,
                               'name' => htmlspecialchars($text ,ENT_QUOTES, _CHARSET)
                               );
        return $breadcrumbs;
    }
}
