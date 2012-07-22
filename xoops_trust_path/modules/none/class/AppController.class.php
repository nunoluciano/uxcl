<?php
/**
 *
 * @file
 * @package ryus
 * @version $Id:$
 *
 */

class AppController
{
    protected $mRoot = null;
    protected $mMyDirname = null;
    protected $mErrors = array();

    public function index()
    {
        $this->commonView();
    }

    public function __construct($mydirname = '', $controllerName = '')
    {
        $this->mMyDirname = $mydirname;
        $this->mControllerName = $controllerName;
    }

    public function prepare($viewName = 'index')
    {
        $this->mRoot =& XCube_Root::getSingleton();
        $this->mRender =& $this->mRoot->mContext->mModule->getRenderTarget();
        $this->mRoot->mController->executeHeader();

        $this->mViewName = $viewName;
        if (empty($this->mControllerName)) {
            $this->mRender->setTemplateName("{$this->mMyDirname}_{$viewName}.tpl");
        } else {
            $this->mRender->setTemplateName("{$this->mMyDirname}_{$this->mControllerName}_{$viewName}.tpl");
        }

        $config =& $this->mRoot->mContext->mModuleConfig;
        $config['dirname'] = $this->mMyDirname;
        if (isset($this->mRoot->mContext->mModule)) {
            $config['dirname'] = $this->mRoot->mContext->mModule->mXoopsModule->get('dirname');
        }
        $this->mRender->setAttribute('config', $config);
    }

    public function postView()
    {
        if (!empty($this->mErrors)) {
            $this->mRender->setAttribute('messages', $this->mErrors);
        }
        if (empty($this->mErrors) && !empty($this->mMessages)) {
            $this->mRender->setAttribute('messages', $this->mMessages);
        }
        $this->mRoot->mController->executeView();
    }

    public function commonView($uid = null)
    {
        if (!is_numeric($uid)) {
            $uid = $this->getUid();
        }
        if (is_numeric($uid)) {
            $userHandler =& xoops_getmodulehandler('users', 'user');
            $user = $userHandler->get($uid);
            if (is_object($user)) {
                $this->mRender->setAttribute('user', $user);
            }
        }
    }

    public function redirect($url, $message)
    {
        $this->mRoot->mController->executeRedirect($url, 1, $message);
    }

    public function getRequest($key)
    {
        return $this->mRoot->mContext->mRequest->getRequest($key);
    }

    public function siteHeader()
    {
        $this->mRoot->mController->executeHeader();
    }

    public function siteFooter()
    {
        $this->mRoot->mController->executeView();
    }

    public function getBreadcrumbs($text, $url = null)
    {
        $breadcrumbs[] = array(
                               'url' => $url,
                               'name' => htmlspecialchars($text ,ENT_QUOTES, _CHARSET)
                               );
        return $breadcrumbs;
    }

    public function getUid()
    {
        if ($this->isRegisteredUser()) {
            return $this->mRoot->mContext->mXoopsUser->uid();
        } else {
            return null;
        }
    }

    public function isRegisteredUser()
    {
        return $this->mRoot->mContext->mUser->isInRole('Site.RegisteredUser');
    }

    public function isSiteOwner()
    {
        return $this->mRoot->mContext->mUser->isInRole('Site.Owner');
    }

    public function isInRange($num, $min = 0, $max = null)
    {
        if (empty($max)) {
            return ($min <= $num);
        } else if ($max < $min) {
            return null;
        }
        return (($min <= $num) and ($num <= $max));
    }

}
