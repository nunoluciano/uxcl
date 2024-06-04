<?php
/**
 * @package user
 * @author  Kazuhisa Minato aka minahito, Core developer
 * @version $Id: UserFilterForm.class.php,v 1.2 2007/06/07 05:27:37 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/class/AbstractFilterForm.class.php';

const USER_SORT_KEY_UID = 1;
const USER_SORT_KEY_NAME = 2;
const USER_SORT_KEY_UNAME = 3;
const USER_SORT_KEY_EMAIL = 4;
const USER_SORT_KEY_URL = 5;
const USER_SORT_KEY_USER_AVATAR = 6;
const USER_SORT_KEY_USER_REGDATE = 7;
const USER_SORT_KEY_USER_ICQ = 8;
const USER_SORT_KEY_USER_FROM = 9;
const USER_SORT_KEY_USER_SIG = 10;
const USER_SORT_KEY_USER_VIEWEMAIL = 11;
const USER_SORT_KEY_ACTKEY = 12;
const USER_SORT_KEY_USER_AIM = 13;
const USER_SORT_KEY_USER_YIM = 14;
const USER_SORT_KEY_USER_MSNM = 15;
const USER_SORT_KEY_PASS = 16;
const USER_SORT_KEY_POSTS = 17;
const USER_SORT_KEY_ATTACHSIG = 18;
const USER_SORT_KEY_RANK = 19;
const USER_SORT_KEY_LEVEL = 20;
const USER_SORT_KEY_THEME = 21;
const USER_SORT_KEY_TIMEZONE_OFFSET = 22;
const USER_SORT_KEY_LAST_LOGIN = 23;
const USER_SORT_KEY_UMODE = 24;
const USER_SORT_KEY_UORDER = 25;
const USER_SORT_KEY_NOTIFY_METHOD = 26;
const USER_SORT_KEY_NOTIFY_MODE = 27;
const USER_SORT_KEY_USER_OCC = 28;
const USER_SORT_KEY_BIO = 29;
const USER_SORT_KEY_USER_INTREST = 30;
const USER_SORT_KEY_USER_MAILOK = 31;
const USER_SORT_KEY_MAXVALUE = 31;
// DEFAULT
const USER_SORT_KEY_DEFAULT = USER_SORT_KEY_UID;

/***
 * @internal
 * [Notice]
 * We should have our policy about filtering items.
 */
class User_UserFilterForm extends User_AbstractFilterForm
{
    public $mSortKeys = [
        USER_SORT_KEY_UID => 'uid',
        USER_SORT_KEY_NAME => 'name',
        USER_SORT_KEY_UNAME => 'uname',
        USER_SORT_KEY_EMAIL => 'email',
        USER_SORT_KEY_URL => 'url',
        USER_SORT_KEY_USER_AVATAR => 'user_avatar',
        USER_SORT_KEY_USER_REGDATE => 'user_regdate',
        USER_SORT_KEY_USER_ICQ => 'user_icq',
        USER_SORT_KEY_USER_FROM => 'user_from',
        USER_SORT_KEY_USER_SIG => 'user_sig',
        USER_SORT_KEY_USER_VIEWEMAIL => 'user_viewemail',
        USER_SORT_KEY_ACTKEY => 'actkey',
        USER_SORT_KEY_USER_AIM => 'user_aim',
        USER_SORT_KEY_USER_YIM => 'user_yim',
        USER_SORT_KEY_USER_MSNM => 'user_msnm',
        USER_SORT_KEY_PASS => 'pass',
        USER_SORT_KEY_POSTS => 'posts',
        USER_SORT_KEY_ATTACHSIG => 'attachsig',
        USER_SORT_KEY_RANK => 'rank',
        USER_SORT_KEY_LEVEL => 'level',
        USER_SORT_KEY_THEME => 'theme',
        USER_SORT_KEY_TIMEZONE_OFFSET => 'timezone_offset',
        USER_SORT_KEY_LAST_LOGIN => 'last_login',
        USER_SORT_KEY_UMODE => 'umode',
        USER_SORT_KEY_UORDER => 'uorder',
        USER_SORT_KEY_NOTIFY_METHOD => 'notify_method',
        USER_SORT_KEY_NOTIFY_MODE => 'notify_mode',
        USER_SORT_KEY_USER_OCC => 'user_occ',
        USER_SORT_KEY_BIO => 'bio',
        USER_SORT_KEY_USER_INTREST => 'user_intrest',
        USER_SORT_KEY_USER_MAILOK => 'user_mailok'
    ];

    public $mKeyword = '';
    public $mOptionField = '';

    public function getDefaultSortKey()
    {
        return USER_SORT_KEY_DEFAULT;
    }
    
    public function fetch()
    {
        parent::fetch();
    
        $root =& XCube_Root::getSingleton();
        $uid = $root->mContext->mRequest->getRequest('uid');
        $email = $root->mContext->mRequest->getRequest('email');
        $attachsig = $root->mContext->mRequest->getRequest('attachsig');
        $rank = $root->mContext->mRequest->getRequest('rank');
        $level = $root->mContext->mRequest->getRequest('level');
        $timezone_offset = $root->mContext->mRequest->getRequest('timezone_offset');
        $user_mailok = $root->mContext->mRequest->getRequest('user_mailok');
        $option_field = $root->mContext->mRequest->getRequest('option_field');
        $search = $root->mContext->mRequest->getRequest('search');

        if (isset($uid)) {
            $this->mNavi->addExtra('uid', $uid);
            $this->_mCriteria->add(new Criteria('uid', $uid));
        }

        if (isset($email)) {
            $this->mNavi->addExtra('email', $email);
            $this->_mCriteria->add(new Criteria('email', $email));
        }
    
        if (isset($attachsig)) {
            $this->mNavi->addExtra('attachsig', $attachsig);
            $this->_mCriteria->add(new Criteria('attachsig', $attachsig));
        }
    
        if (isset($rank)) {
            $this->mNavi->addExtra('rank', $rank);
            $this->_mCriteria->add(new Criteria('rank', $rank));
        }
    
        if (isset($level)) {
            $this->mNavi->addExtra('level', $level);
            $this->_mCriteria->add(new Criteria('level', $level));
        }
    
        if (isset($timezone_offset)) {
            $this->mNavi->addExtra('timezone_offset', $timezone_offset);
            $this->_mCriteria->add(new Criteria('timezone_offset', $timezone_offset));
        }
    
        if (isset($user_mailok)) {
            $this->mNavi->addExtra('user_mailok', $user_mailok);
            $this->_mCriteria->add(new Criteria('user_mailok', $user_mailok));
        }

        //wanikoo
        if (isset($_REQUEST['option_field'])) {
            $this->mNavi->addExtra('option_field', xoops_getrequest('option_field'));
            $this->mOptionField = $option_field;

            if ('inactive' == $option_field) {
                //only inactive users
            $this->_mCriteria->add(new Criteria('level', '0'));
            } elseif ('active' == $option_field) {
                //only active users
            $this->_mCriteria->add(new Criteria('level', '0', '>'));
            } else {
                //all
            }
        }
        
        //
        if (!empty($search)) {
            $this->mKeyword = $search;
            $this->mNavi->addExtra('search', $this->mKeyword);
            $this->_mCriteria->add(new Criteria('uname', '%' . $this->mKeyword . '%', 'LIKE'));
        }

        $this->_mCriteria->addSort($this->getSort(), $this->getOrder());
    }
}
