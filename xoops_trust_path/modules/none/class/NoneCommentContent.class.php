<?php

// a class for d3forum comment integration
if (!class_exists('NoneCommentContent')) {
require_once XOOPS_TRUST_PATH . '/modules/d3forum/class/D3commentAbstract.class.php';

class NoneCommentContent extends D3commentAbstract
{
    function fetchSummary($external_link_id)
    {
        $module_handler =& xoops_gethandler('module');
        $module =& $module_handler->getByDirname($this->mydirname);
        if (preg_match('/[^0-9a-zA-Z_-]/', $this->mydirname)) {
            die('Invalid mydirname');
        }

        return array(
                     'uri' => XOOPS_URL . '/modules/' . $this->mydirname . '/',
                     'dirname' => $this->mydirname,
                     'module_name' => $module->getVar('name'),
                     'subject' => $module->getVar('name'),
                     'summary' => '',
                     );
    }

}
}
