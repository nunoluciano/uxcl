<?php

$constpref = '_MB_'.strtoupper($mydirname) ;

if(!defined($constpref.'_LOADED')){

define($constpref.'_LOADED', 1);

define($constpref.'_YEAR', '/');
define($constpref.'_MONTH', '/');
define($constpref.'_DAY', '');

define($constpref.'_INDEX_INFO_MSG_0', 'There is a participation demand to your group. (%d request(s)) ');
define($constpref.'_INDEX_INFO_MSG_1', 'An alternation demand of the group manager was received.(%d request(s))');
define($constpref.'_INDEX_INFO_MSG_2', 'There is an offer to become the submanager of the group.(%d request(s))');
define($constpref.'_INDEX_INFO_MSG_3', 'There is an additional request to your friends list.(%d request(s))');
define($constpref.'_INDEX_INFO_MSG_4', 'The registration of your friends list was canceled. (%d request(s)) ');

}

?>