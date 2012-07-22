<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'attachfile' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","ファイル添付");

// A brief description of this module
define($constpref."_DESC","XOOPSファイル添付モジュール");

// admin menus
define($constpref.'_ADMENU_LIST','添付ファイル一覧');

// configurations
define($constpref.'_LINK_ENC','画面表示時のタイトルエンコーディング');
define($constpref.'_LINK_ENCDSC','画面表示時のファイル名のエンコーディング');
define($constpref.'_TTL_ENC_IE','ダウンロード時のタイトルエンコーディング（MSIE）');
define($constpref.'_TTL_ENC_IEDSC','ダウンロード時にクライアントに渡すファイル名のエンコーディング');
define($constpref.'_TTL_ENC_OTH','ダウンロード時のタイトルエンコーディング（MSIE以外）');
define($constpref.'_TTL_ENC_OTHDSC','ダウンロード時にクライアントに渡すファイル名のエンコーディング');
define($constpref.'_MAX_SIZE','添付ファイル最大サイズ(KB)');
define($constpref.'_MAX_SIZEDSC','ひとつの添付ファイルの最大サイズ');
define($constpref.'_MIMEM','アップロードMIME-Type制限モード');
define($constpref.'_MIMEMDSC','なし : 無制限, 拒否 : アップロードMIME-Typeリストのものを拒否, 許可 : アップロードMIME-Typeリストのもののみ許可');
define($constpref.'_MIMET','アップロードMIME-Typeリスト');
define($constpref.'_MIMETDSC','"|"で区切ってください。例："text/plain|image/gif|image/jpeg"');
define($constpref.'_F_PRE','実ファイル名プレフィクス');
define($constpref.'_F_PREDSC','XOOPS_TRUST_PATH内のファイルのプレフィクス(既にファイルが存在している状態でこの値を変更した場合、手動で既存のファイル名を変更する必要があります(DBに格納されたファイル名を変更する必要はありません))');

define($constpref.'_MIMEM_NON_N','なし');					// 0
define($constpref.'_MIMEM_DNY_N','拒否');					// 1
define($constpref.'_MIMEM_ALW_N','許可');					// 2
define($constpref.'_F_PRE_NON_N','なし');					// 0
define($constpref.'_F_PRE_DBP_N','XOOPS_DB_PREFIXと同じ');	// 1
define($constpref.'_F_PRE_DBN_N','XOOPS_DB_NAMEと同じ');	// 2

}

?>