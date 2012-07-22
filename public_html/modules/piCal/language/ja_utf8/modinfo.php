<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_MI_LOADED' ) ) {

define( 'PICAL_MI_LOADED' , 1 ) ;

// Module Info

// The name of this module
define("_MI_PICAL_NAME","piCal");

// A brief description of this module
define("_MI_PICAL_DESC","スケジューラ付カレンダー");

// Default Locale
define("_MI_PICAL_DEFAULTLOCALE","utf8_japan");

// Names of blocks for this module (Not all module has blocks)
define("_MI_PICAL_BNAME_MINICAL","ミニカレンダー");
define("_MI_PICAL_BNAME_MINICAL_DESC","小さなカレンダーの表示");
define("_MI_PICAL_BNAME_MINICALEX","拡張ミニカレンダー");
define("_MI_PICAL_BNAME_MINICALEX_DESC","プラグイン拡張が可能なミニカレンダーの表示");
define("_MI_PICAL_BNAME_MONTHCAL","月別フルサイズカレンダー");
define("_MI_PICAL_BNAME_MONTHCAL_DESC","月別フルサイズカレンダーの表示");
define("_MI_PICAL_BNAME_TODAYS","今日の予定");
define("_MI_PICAL_BNAME_TODAYS_DESC","今日の予定の表示");
define("_MI_PICAL_BNAME_THEDAYS","%s の予定");
define("_MI_PICAL_BNAME_THEDAYS_DESC","カレンダーで指定された日の予定の表示");
define("_MI_PICAL_BNAME_COMING","今後の予定");
define("_MI_PICAL_BNAME_COMING_DESC","今日以降の予定の表示");
define("_MI_PICAL_BNAME_AFTER","%s 以降の予定");
define("_MI_PICAL_BNAME_AFTER_DESC","カレンダーで指定された日以降の予定の表示");
define("_MI_PICAL_BNAME_NEW","新たな予定");
define("_MI_PICAL_BNAME_NEW_DESC","新規に登録された予定の表示");

// Names of submenu
define("_MI_PICAL_SM_SUBMIT","新規登録");

//define("_MI_PICAL_ADMENU1","");

// Title of config items
define("_MI_USERS_AUTHORITY", "一般ユーザの権限");
define("_MI_GUESTS_AUTHORITY", "ゲストの権限");
define("_MI_DEFAULT_VIEW", "デフォルトのカレンダー表示画面");
define("_MI_MINICAL_TARGET", "ミニカレンダーで日付をクリックした時の動作");
define("_MI_COMING_NUMROWS", "今後の予定ブロックでの表示予定件数");
define("_MI_SKINFOLDER", "スキンフォルダ名");
define("_MI_PICAL_LOCALE", "地域設定ファイル (locales/*.php)");
define("_MI_SUNDAYCOLOR", "日曜日の文字色");
define("_MI_WEEKDAYCOLOR", "平日の文字色");
define("_MI_SATURDAYCOLOR", "土曜日の文字色");
define("_MI_HOLIDAYCOLOR", "祝日の文字色");
define("_MI_TARGETDAYCOLOR", "対象日の文字色");
define("_MI_SUNDAYBGCOLOR", "日曜日の背景色");
define("_MI_WEEKDAYBGCOLOR", "平日の背景色");
define("_MI_SATURDAYBGCOLOR", "土曜日の背景色");
define("_MI_HOLIDAYBGCOLOR", "祝日の背景色");
define("_MI_TARGETDAYBGCOLOR", "対象日の背景色");
define("_MI_CALHEADCOLOR", "ヘッダ部文字色");
define("_MI_CALHEADBGCOLOR", "ヘッダ部背景色");
define("_MI_CALFRAMECSS", "カレンダーフレームのスタイル");
define("_MI_CANOUTPUTICS", "icsファイル出力の許可・不許可");
define("_MI_MAXRRULEEXTRACT", "繰り返し条件の展開上限数 (COUNT)");
define("_MI_WEEKSTARTFROM", "週の開始曜日");
define("_MI_WEEKNUMBERING", "週の数え方");
define("_MI_DAYSTARTFROM", "一日を区切る時間");
define("_MI_TIMEZONE_USING", "サーバのタイムゾーン指定");
define("_MI_USE24HOUR", "24時間制とする（いいえなら、12時間制）");
define("_MI_NAMEORUNAME" , "投稿者名の表示" ) ;
define("_MI_DESCNAMEORUNAME" , "ログイン名かハンドル名か選択して下さい" ) ;
define("_MI_PROXYSETTINGS" , "プロキシ設定(host:port:user:pass)" ) ;

// Description of each config items
define("_MI_EDITBYGUESTDSC", "ゲストが予定を追加できるかどうか");

// Options of each config items
define("_MI_OPT_AUTH_NONE", "登録不可");
define("_MI_OPT_AUTH_WAIT", "登録可・要承認");
define("_MI_OPT_AUTH_POST", "登録可・承認不要");
define("_MI_OPT_AUTH_BYGROUP", "グループ毎に設定する");
define("_MI_OPT_MINI_PHPSELF", "現在のページをそのまま表示");
define("_MI_OPT_MINI_MONTHLY", "月毎のカレンダーをメインに表示");
define("_MI_OPT_MINI_WEEKLY", "週毎のカレンダーをメインに表示");
define("_MI_OPT_MINI_DAILY", "一日だけのカレンダーをメインに表示");
define("_MI_OPT_MINI_LIST", "予定一覧画面");
define("_MI_OPT_CANNOTOUTPUTICS", "出力禁止");
define("_MI_OPT_CANOUTPUTICS", "出力許可");
define("_MI_OPT_STARTFROMSUN", "日曜日");
define("_MI_OPT_STARTFROMMON", "月曜日");
define("_MI_OPT_WEEKNOEACHMONTH", "月ごと");
define("_MI_OPT_WEEKNOWHOLEYEAR", "年間通算");
define("_MI_OPT_USENAME" , "ハンドル名" ) ;
define("_MI_OPT_USEUNAME" , "ログイン名" ) ;
define("_MI_OPT_TZ_USEXOOPS" , "XOOPSでの設定値" ) ;
define("_MI_OPT_TZ_USEWINTER" , "サーバから得られた冬時間（推奨）" ) ;
define("_MI_OPT_TZ_USESUMMER" , "サーバから得られた夏時間" ) ;


// Admin Menus
define("_MI_PICAL_ADMENU0","スケジュールの承認");
define("_MI_PICAL_ADMENU1","予定管理");
define("_MI_PICAL_ADMENU_CAT","カテゴリー管理");
define("_MI_PICAL_ADMENU_CAT2GROUP","カテゴリーのアクセス権限");
define("_MI_PICAL_ADMENU2","グループの全体的な権限");
define("_MI_PICAL_ADMENU_TM","テーブルメンテナンス");
define("_MI_PICAL_ADMENU_PLUGINS","プラグイン管理");
define("_MI_PICAL_ADMENU_ICAL","iCalendarのインポート");
define('_MI_PICAL_ADMENU_MYTPLSADMIN','テンプレート管理');
define('_MI_PICAL_ADMENU_MYBLOCKSADMIN','ブロック・グループ管理');

// Text for notifications
define('_MI_PICAL_GLOBAL_NOTIFY', 'モジュール全体');
define('_MI_PICAL_GLOBAL_NOTIFYDSC', 'piCalモジュール全体における通知オプション');
define('_MI_PICAL_CATEGORY_NOTIFY', 'カテゴリー');
define('_MI_PICAL_CATEGORY_NOTIFYDSC', '選択中のカテゴリーに対する通知オプション');
define('_MI_PICAL_EVENT_NOTIFY', '予定');
define('_MI_PICAL_EVENT_NOTIFYDSC', '表示中の予定に対する通知オプション');

define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFY', '新規予定登録');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYCAP', '新規に予定が登録された時に通知する');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYDSC', '新規に予定が登録された時に通知する');
define('_MI_PICAL_GLOBAL_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: 新たに予定が登録されました');

define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFY', 'カテゴリ毎の新予定登録');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYCAP', 'このカテゴリに新予定が登録された時に通知する');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYDSC', 'このカテゴリに新予定が登録された時に通知する');
define('_MI_PICAL_CATEGORY_NEWEVENT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: 新たに予定が登録されました');

//d3comment integration
define("_MI_COM_DIRNAME","コメント統合するd3forumのdirname");
define("_MI_COM_DIRNAMEDSC","d3forumのコメント統合機能を使用する場合は<br/>フォーラムのhtml側ディレクトリ名を指定します。<br/>xoopsコメントを使用する場合やコメント機能を無効にする場合は空欄です。");
define("_MI_COM_FORUM_ID","コメント統合するフォーラムの番号");
define("_MI_COM_FORUM_IDDSC","コメント統合を選択した場合、forum_idを必ず指定してください。");
define("_MI_COM_ORDER","コメント統合の表示順序");
define("_MI_COM_ORDERDSC","コメント統合を選択した場合の、コメントの新しい順／古い順を指定できます。");
define("_MI_COM_VIEW","コメント統合の表示方法");
define("_MI_COM_VIEWDSC","フラット表示かスレッド表示かを選択します。");
define("_MI_COM_POSTSNUM","コメント統合のフラット表示における最大表示件数");

}

?>
