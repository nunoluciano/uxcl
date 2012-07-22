<?php


// アバターの表示サイズ
define('XSNS_AVATAR_MAX_WIDTH',	75);
define('XSNS_AVATAR_MAX_HEIGHT', 75);


// 画像・ファイル読み込み用スクリプト
define('XSNS_IMAGE_URL', XSNS_BASE_URL.'/image.php');
define('XSNS_FILE_URL',  XSNS_BASE_URL.'/file.php');


// サムネイルのサイズ定数
define('XSNS_IMAGE_SIZE_S', 1);
define('XSNS_IMAGE_SIZE_M', 2);
define('XSNS_IMAGE_SIZE_L', 3);


// コミュニティに関する権限
define('XSNS_AUTH_XOOPS_ADMIN',	32);	// XOOPS管理者
define('XSNS_AUTH_ADMIN',		16);	// コミュニティ管理者
define('XSNS_AUTH_SUB_ADMIN',	 8);	// コミュニティ副管理者
define('XSNS_AUTH_MEMBER',		 4);	// コミュニティメンバー
define('XSNS_AUTH_NON_MEMBER',	 2);	// 非コミュニティメンバー
define('XSNS_AUTH_GUEST',		 1);	// ゲスト


// ページURL定数
define('XSNS_URL_COMMU',		XSNS_BASE_URL.'/');
define('XSNS_URL_ADMIN',		XSNS_BASE_URL.'/admin/index.php');
define('XSNS_URL_TOPIC',		XSNS_BASE_URL.'/?'.XSNS_PAGE_ARG.'=topic');
define('XSNS_URL_MEMBER',	XSNS_BASE_URL.'/?'.XSNS_PAGE_ARG.'=member');
define('XSNS_URL_FILE',		XSNS_BASE_URL.'/?'.XSNS_PAGE_ARG.'=file');

define('XSNS_URL_MYPAGE',			XSNS_BASE_URL.'/?'.XSNS_PAGE_ARG.'=mypage');
define('XSNS_URL_MYPAGE_FRIEND',		XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=friend_list');
define('XSNS_URL_MYPAGE_CONFIRM',	XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=confirm');
define('XSNS_URL_MYPAGE_NEWS',		XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=news');
define('XSNS_URL_MYPAGE_FOOTPRINT',	XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=footprint');
define('XSNS_URL_MYPAGE_INTRO',		XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=intro_list');
define('XSNS_URL_MYPAGE_CONFIG',		XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=config');
define('XSNS_URL_MYPAGE_PROFILE',	XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=profile');
define('XSNS_URL_MYPAGE_COMMU',		XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=commu_list');

?>
