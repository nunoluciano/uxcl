<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_AM_LOADED' ) ) {

define( 'PICAL_AM_LOADED' , 1 ) ;


// titles
define("_AM_ADMISSION","スケジュールの承認");
define("_AM_MENU_EVENTS","予定管理");
define("_AM_MENU_CATEGORIES","カテゴリー管理");
define("_AM_MENU_CAT2GROUP","カテゴリーのアクセス権限");
define("_AM_ICALENDAR_IMPORT","iCalendar インポート");
define("_AM_GROUPPERM","グループの全体的な権限");
define("_AM_TABLEMAINTAIN","テーブルメンテナンス（アップグレード）");
define("_AM_MYBLOCKSADMIN","piCalブロック・グループ管理");

// forms
define("_AM_BUTTON_EXTRACT","抽出");
define("_AM_BUTTON_ADMIT","承認");
define("_AM_BUTTON_MOVE","移動");
define("_AM_BUTTON_COPY","コピー");
define("_AM_CONFIRM_DELETE","削除してよろしいですか");
define("_AM_CONFIRM_MOVE","旧カテゴリー属性を削除して、指定されたカテゴリー属性を付与します。よろしいですか？");
define("_AM_CONFIRM_COPY","指定されたカテゴリー属性を付与します。よろしいですか？");
define("_AM_OPT_PAST","過去のみ");
define("_AM_OPT_FUTURE","未来のみ");
define("_AM_OPT_PASTANDFUTURE","期日指定なし");

// format
define("_AM_DTFMT_LIST_ALLDAY",'y-m-d');
define("_AM_DTFMT_LIST_NORMAL",'y-m-d<\b\r />H:i');

// timezones
define("_AM_TZOPT_SERVER",'サーバ時間での表現');
define("_AM_TZOPT_GMT",'GMTでの表現');
define("_AM_TZOPT_USER",'ユーザ時間での表現');

// admission
define("_AM_LABEL_ADMIT","チェックした予定を承認する");
define("_AM_MES_ADMITTED","承認しました");
define("_AM_ADMIT_TH0","User");
define("_AM_ADMIT_TH1","開始日時");
define("_AM_ADMIT_TH2","終了日時");
define("_AM_ADMIT_TH3","件名");
define("_AM_ADMIT_TH4","繰り返し条件");

// iCalendar I/O

define("_AM_LABEL_IMPORTFROMWEB","iCalendarデータのWeb経由インポート （http:// または webcal:// から始まるURIを記述）");
define("_AM_LABEL_UPLOADFROMFILE","iCalendarデータのアップロード （ローカルファイルを指定）");
define("_AM_LABEL_IO_CHECKEDITEMS","チェックした予定を");
define("_AM_LABEL_IO_OUTPUT","iCalendar形式で出力する");
define("_AM_LABEL_IO_DELETE","削除する");
define("_AM_MES_EVENTLINKTOCAT","個の予定が、カテゴリに登録されました");
define("_AM_MES_EVENTUNLINKED","個の予定が、旧カテゴリ属性を削除されました");
define("_AM_FMT_IMPORTED","個の予定が %s からインポートされました");
define("_AM_MES_DELETED","個の予定を削除しました");
define("_AM_IO_TH0","User");
define("_AM_IO_TH1","開始日時");
define("_AM_IO_TH2","終了日時");
define("_AM_IO_TH3","件名");
define("_AM_IO_TH4","繰り返し条件");
define("_AM_IO_TH5","承認済");

// Group's Permissions
define( '_AM_GPERM_G_INSERTABLE' , "新規登録" ) ;
define( '_AM_GPERM_G_SUPERINSERT' , "登録の承認不要" ) ;
define( '_AM_GPERM_G_EDITABLE' , "変更" ) ;
define( '_AM_GPERM_G_SUPEREDIT' , "変更の承認不要" ) ;
define( '_AM_GPERM_G_DELETABLE' , "削除" ) ;
define( '_AM_GPERM_G_SUPERDELETE' , "承認不要の削除" ) ;
define( '_AM_GPERM_G_TOUCHOTHERS' , "他人のレコードの変更・削除" ) ;
define( '_AM_CAT2GROUPDESC' , "各グループについて、アクセス可能なカテゴリーへチェックを入れて下さい" ) ;
define( '_AM_GROUPPERMDESC' , "グループ毎にスケジュールについての権限を設定できます<br />この機能を利用するためには、一般設定において、ユーザー権限を、「グループ毎に設定する」を選択する必要があります<br />なお、ゲストグループおよび管理者グループの権限をここで設定しても意味がありません" ) ;

// Table Maintenance
define( '_AM_MB_SUCCESSUPDATETABLE' , "テーブル構造のアップグレードに成功しました" ) ;
define( '_AM_MB_FAILUPDATETABLE' , "テーブル構造のアップグレードに失敗しました" ) ;
define( '_AM_NOTICE_NOERRORS' , "0.6形式にアップグレード済。エラーもありません。" ) ;
define( '_AM_ALRT_CATTABLENOTEXIST' , "カテゴリーテーブルが存在しません。<br />\nこのテーブルを作成してよろしいですか？" ) ;
define( '_AM_ALRT_OLDTABLE' , "予定テーブルの構造が古いようです。<br />\nいますぐアップグレードしますか？" ) ;
define( '_AM_ALRT_TOOOLDTABLE' , "テーブルエラーです。<br />\nおそらく、piCal 0.3以前のテーブルだと思われます。<br />\nまずは、0.4か0.5にアップグレードしてください。" ) ;
define( '_AM_FMT_SERVER_TZ_ALL' , "このサーバの冬季タイムゾーン: %+2.1f<br />このサーバの夏季タイムゾーン: %+2.1f<br />サーバのタイムゾーン名: %s<br />XOOPSでの設定値: %+2.1f<br />piCalでの採用値: %+2.1f<br />" ) ;
define( '_AM_TH_SERVER_TZ_COUNT' , "予定個数" ) ;
define( '_AM_TH_SERVER_TZ_VALUE' , "タイムゾーン" ) ;
define( '_AM_TH_SERVER_TZ_VALUE_TO' , "変更値(-14.0～14.0)" ) ;
define( '_AM_JSALRT_SERVER_TZ' , "この操作を行う前にデータのバックアップを推奨します" ) ;
define( '_AM_NOTICE_SERVER_TZ' , "お使いのサーバが、サマータイム(Day Light Saving)の存在する地域としてセットアップされている場合、0.8未満のバージョンで登録した季節により、１時間前後のタイムゾーンのずれが発生していることがあります。その場合は決してこのボタンを押さないでください" ) ;
define( '_AM_MB_SUCCESSTZUPDATE' , "各イベントについて、このサーバのタイムゾーンに合わせました" ) ;

// Categories
define( '_AM_CAT_TH_TITLE' , 'カテゴリ名' ) ;
define( '_AM_CAT_TH_DESC' , 'カテゴリの説明' ) ;
define( '_AM_CAT_TH_PARENT' , '親カテゴリ' ) ;
define( '_AM_CAT_TH_OPTIONS' , 'オプション' ) ;
define( '_AM_CAT_TH_LASTMODIFY' , '最終更新日' ) ;
define( '_AM_CAT_TH_OPERATION' , '操作' ) ;
define( '_AM_CAT_TH_ENABLED' , '有効' ) ;
define( '_AM_CAT_TH_WEIGHT' , '表示順' ) ;
define( '_AM_CAT_TH_SUBMENU' , 'サブメニューへの表示' ) ;
define( '_AM_BTN_UPDATE' , '更新' ) ;
define( '_AM_MENU_CAT_EDIT' , 'カテゴリーの修正' ) ;
define( '_AM_MENU_CAT_NEW' , '新カテゴリーの登録' ) ;
define( '_AM_MB_MAKESUBCAT' , 'サブカテゴリー' ) ;
define( '_AM_MB_MAKETOPCAT' , 'トップレベルにカテゴリーを新規作成' ) ;
define( '_AM_MB_CAT_INSERTED' , '新カテゴリーが登録されました' ) ;
define( '_AM_MB_CAT_UPDATED' , 'カテゴリーが更新されました' ) ;
define( '_AM_FMT_CAT_DELETED' , '%s 個のカテゴリーが削除されました' ) ;
define( '_AM_FMT_CAT_BATCHUPDATED' , '%s このカテゴリーが更新されました' ) ;
define( '_AM_FMT_CATDELCONFIRM' , 'カテゴリー名 %s を削除してよろしいですか？' ) ;
// Plugins
define( '_AM_PI_UPDATED' , '更新されました' ) ;
define( '_AM_PI_TH_TYPE' , '適用先' ) ;
define( '_AM_PI_TH_OPTIONS' , 'オプション(通常は空欄)' ) ;
define( '_AM_PI_TH_TITLE' , '表示名' ) ;
define( '_AM_PI_TH_DIRNAME' , '対象モジュール' ) ;
define( '_AM_PI_TH_FILE' , '利用プラグイン' ) ;
define( '_AM_PI_TH_DOTGIF' , 'ドット画像' ) ;
define( '_AM_PI_TH_OPERATION' , '操作' ) ;
define( '_AM_PI_ENABLED' , '有効' ) ;
define( '_AM_PI_DELETE' , '削除' ) ;
define( '_AM_PI_NEW' , '新規' ) ;
define( '_AM_PI_VIEWYEARLY' , '年間ビュー' ) ;
define( '_AM_PI_VIEWMONTHLY' , '月間ビュー' ) ;
define( '_AM_PI_VIEWWEEKLY' , '週間ビュー' ) ;
define( '_AM_PI_VIEWDAILY' , '日毎ビュー' ) ;

// groupperm
//define("_MD_AM_DBUPDATED","データベースを更新しました");
//define('_MD_AM_PERMADDNG', 'グループ・パーミッションの追加に失敗しました（パーミッション名：%s 対象アイテム：%s 対象グループ：%s）');
//define('_MD_AM_PERMADDOK','グループ・パーミッションを追加しました（パーミッション名：%s 対象アイテム：%s 対象グループ：%s）');
//define('_MD_AM_PERMRESETNG','「%s」モジュールのグループ・パーミッション設定の初期化に失敗しました');
//define('_MD_AM_PERMADDNGP', 'このアイテムの上位アイテム全てにパーミッションを与える必要があります');
// Appended by Xoops Language Checker -GIJOE- in 2007-02-04 05:11:48
define('_AM_PICAL_DBUPDATED','データベースを更新しました');
define('_AM_PICAL_PERMADDNG','グループ・パーミッションの追加に失敗しました（パーミッション名：%s 対象アイテム：%s 対象グループ：%s）');
define('_AM_PICAL_PERMADDOK','グループ・パーミッションを追加しました（パーミッション名：%s 対象アイテム：%s 対象グループ：%s）');
define('_AM_PICAL_PERMRESETNG','「%s」モジュールのグループ・パーミッション設定の初期化に失敗しました');
define('_AM_PICAL_PERMADDNGP','このアイテムの上位アイテム全てにパーミッションを与える必要があります');


}

?>