<?php
/**
 * @package user
 * @author  Kazuhisa Minato aka minahito, Core developer
 * @version $Id: UserAdminDeleteForm.class.php,v 1.2 2007/06/07 05:27:37 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';

class User_UserAdminDeleteForm extends XCube_ActionForm
{
    public function getTokenName()
    {
        return 'module.user.UserAdminDeleteForm.TOKEN' . $this->get('uid');
    }

    public function prepare()
    {
        //
        // Set form properties
        //
        $this->mFormProperties['uid'] =new XCube_IntProperty('uid');

        //
        // Set field properties
        //
        $this->mFieldProperties['uid'] =new XCube_FieldProperty($this);
        $this->mFieldProperties['uid']->setDependsByArray(['required']);
        $this->mFieldProperties['uid']->addMessage('required', _MD_USER_ERROR_REQUIRED, _MD_USER_LANG_UID);
    }

    public function load(&$obj)
    {
        $this->set('uid', $obj->get('uid'));
    }

    public function update(&$obj)
    {
        $obj->setVar('uid', $this->get('uid'));
    }
}
