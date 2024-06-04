<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/admin/forms/MailjobAdminSendForm.class.php';

class User_MailjobSendAction extends User_Action
{
    public $mMailjob = null;
    public $mActionForm = null;
    
    public function prepare(&$controller, &$xoopsUser, $moduleConfig)
    {
        $id = (int)xoops_getrequest('mailjob_id');
        
        $handler =& xoops_getmodulehandler('mailjob');
        
        $this->mMailjob =& $handler->get($id);

        if (is_object($this->mMailjob)) {
            $this->mActionForm =new User_MailjobAdminSendForm();
            $this->mActionForm->prepare();
            $this->mActionForm->load($this->mMailjob);
        }
    }

    public function getDefaultView(&$controller, &$xoopsUser)
    {
        if (!is_object($this->mMailjob)) {
            return USER_FRAME_VIEW_ERROR;
        }

        //
        // lazy load
        //
        $this->mMailjob->loadUser();
        
        return USER_FRAME_VIEW_INPUT;
    }

    public function execute(&$controller, &$xoopsUser)
    {
        if (!is_object($this->mMailjob)) {
            return USER_FRAME_VIEW_ERROR;
        }
        
        if (null != xoops_getrequest('_form_control_cancel')) {
            return USER_FRAME_VIEW_CANCEL;
        }
        
        $this->mActionForm->fetch();
        $this->mActionForm->validate();
        
        if ($this->mActionForm->hasError()) {
            return USER_FRAME_VIEW_INPUT;
        }

        $root =& XCube_Root::getSingleton();
        if ($this->mMailjob->get('is_pm')) {
            $this->mMailjob->mSend->add([&$this, 'sendPM']);
        }

        if ($this->mMailjob->get('is_mail')) {
            $this->mMailjob->mSend->add([&$this, 'sendMail']);
        }

        $this->mMailjob->send($xoopsUser);
        
        $this->mMailjob->loadUserCount();
        
        return ($this->mMailjob->mUserCount > 0) ? USER_FRAME_VIEW_INPUT : USER_FRAME_VIEW_SUCCESS;
    }

    public function executeViewSuccess(&$controller, &$xoopsUser, &$render)
    {
        $controller->executeForward('./index.php?action=MailjobList');
    }

    public function executeViewError(&$controller, &$xoopsUser, &$render)
    {
        $controller->executeRedirect('./index.php?action=MailjobList', 1, _AD_USER_ERROR_MAILJOB_SEND_FAIL);
    }

    public function executeViewInput(&$controller, &$xoopsUser, &$render)
    {
        $render->setTemplateName('mailjob_send.html');
        $render->setAttribute('object', $this->mMailjob);
        $render->setAttribute('actionForm', $this->mActionForm);
    }
    
    public function executeViewCancel(&$controller, &$xoopsUser, &$render)
    {
        $controller->executeForward('./index.php?action=MailjobList');
    }

    /**
     * [Notice]
     * Until private message will come to implement Service, we use pm object
     * directly.
     * @param $link
     * @param $mailjob
     * @param $to_user
     * @param $from_user
     */
    public function sendPM(&$link, &$mailjob, &$to_user, &$from_user)
    {
        $handler =& xoops_gethandler('privmessage');
        
        $pm =& $handler->create();
        
        $pm->set('subject', $mailjob->getReplaceTitle($to_user, $from_user));
        $pm->set('msg_text', $mailjob->getReplaceBody($to_user, $from_user));
        $pm->set('from_userid', $from_user->get('uid'));
        $pm->set('to_userid', $to_user->get('uid'));
        
        if (!$handler->insert($pm)) {
            $link->set('message', $link->get('message') . 'Cound not send PM.');
        }
    }

    public function sendMail(&$link, &$mailjob, $to_user, $from_user)
    {
        $xoopsMailer =& getMailer();
        $xoopsMailer->useMail();

        //
        // Set To
        //		
        $xoopsMailer->setToUsers($to_user);
        
        //
        // Set From
        //
        $xoopsMailer->setFromEmail($mailjob->get('from_email'));
        $xoopsMailer->setFromName($mailjob->get('from_name'));

        $xoopsMailer->setSubject($mailjob->getReplaceTitle($to_user, $from_user));
        $xoopsMailer->setBody($mailjob->getReplaceBody($to_user, $from_user));

        if (!$xoopsMailer->send(true)) {
            if ('' == $link->get('message') && '' == $xoopsMailer->multimailer->ErrorInfo) {
                $link->set('message', 'Could not send mail. ');
            } else {
                $link->set('message', $link->get('message') . ' / ' . $xoopsMailer->multimailer->ErrorInfo);
            }
        }
    }
}
