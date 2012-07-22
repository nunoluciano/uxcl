<?php

$constpref = '_MB_'.strtoupper($mydirname) ;

if(!defined($constpref.'_LOADED')){

define($constpref.'_LOADED', 1);

define($constpref.'_YEAR', '年');
define($constpref.'_MONTH', '月');
define($constpref.'_DAY', '日');

define($constpref.'_INDEX_INFO_MSG_0', 'あなたの管理コミュニティへの参加希望が%d件きています');
define($constpref.'_INDEX_INFO_MSG_1', 'コミュニティ管理者交代依頼が%d件きています');
define($constpref.'_INDEX_INFO_MSG_2', 'コミュニティ副管理者就任依頼が%d件きています');
define($constpref.'_INDEX_INFO_MSG_3', '友達リストへの登録希望が%d件きています');
define($constpref.'_INDEX_INFO_MSG_4', '友達リストの登録が%d件解除されました');

}

?>