<?php
/**
 *
 * @package Legacy
 * @version $Id: formtoken.php,v 1.3 2008/09/25 15:12:46 kilica Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://xoopscube.sourceforge.net/license/GPL_V2.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class XoopsFormToken extends XoopsFormHidden {
    /**
     * Constructor
     *
     * @param object    $token  XoopsToken instance
    */
    function XoopsFormToken($token)
    {
        if(is_object($token)) {
            parent::XoopsFormHidden($token->getTokenName(), $token->getTokenValue());
        }
        else {
            parent::XoopsFormHidden('','');
        }
    }
}
?>
