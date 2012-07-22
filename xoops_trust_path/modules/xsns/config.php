<?php

define('XSNS_TRUST_PATH', dirname(__FILE__));

// モジュールのパス
define('XSNS_BASE_DIR', XOOPS_ROOT_PATH.'/modules/'.$mydirname);

// モジュールのURL
define('XSNS_BASE_URL', XOOPS_URL.'/modules/'.$mydirname);

// スタイルシートのURL
define('XSNS_CSS_URL', XSNS_BASE_URL.'/css.php?f=');

// JavaScriptのURL
define('XSNS_JS_URL', XSNS_BASE_URL.'/js.php?f=');

// フレームワークのディレクトリ
define('XSNS_FRAMEWORK_DIR', XSNS_TRUST_PATH.'/framework');
define('XSNS_FRAMEWORK_CLASS_DIR', XSNS_FRAMEWORK_DIR.'/class');

// ユーザー定義のクラスファイルのパス
define('XSNS_USERLIB_DIR', XSNS_TRUST_PATH.'/userlib');
define('XSNS_USERLIB_CLASS_DIR', XSNS_USERLIB_DIR.'/class');

// ページ切り替え用の引数名
define('XSNS_PAGE_ARG', 'p');

// Action, View 切り替え用の引数名
define('XSNS_ACTION_ARG', 'act');

// Action ファイルのディレクトリ
define('XSNS_ACTION_DIR', XSNS_TRUST_PATH.'/act/');

// デフォルトの Action 名
define('XSNS_DEFAULT_ACTION', 'default');

// デフォルトの Action ファイル
define('XSNS_DEFAULT_ACTION_FILE', XSNS_ACTION_DIR.XSNS_DEFAULT_ACTION.'Action.php');

// View ファイルがあるディレクトリ
define('XSNS_VIEW_DIR', XSNS_TRUST_PATH.'/act/');

// デフォルトの View 名
define('XSNS_DEFAULT_VIEW', 'default');

// デフォルトの View ファイル
define('XSNS_DEFAULT_VIEW_FILE', XSNS_VIEW_DIR.XSNS_DEFAULT_VIEW.'View.php');

define('XSNS_REQUEST_POST', 1);
define('XSNS_REQUEST_GET', 2);
define('XSNS_REQUEST_SESSION', 3);

?>
