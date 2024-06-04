<?php
/**
 * @package user
 * @author  Kazuhisa Minato aka minahito, Core developer
 * @version $Id: MailjobAdminEditForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/admin/forms/MailjobAdminEditForm.class.php';

class User_MailjobServiceEditForm extends User_MailjobAdminEditForm
{
    public function _validateToken()
    {
    }
}
