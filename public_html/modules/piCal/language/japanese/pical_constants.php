<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_CNST_LOADED' ) ) {

define( 'PICAL_CNST_LOADED' , 1 ) ;

// the language file for jscalendar "DHTML Date/Time Selector"
define('_PICAL_JS_CALENDAR','calendar-jp.js') ;

// format for jscalendar. see common/jscalendar/doc/html/reference.html
define('_PICAL_JSFMT_YMDN','%Y年 %B %d日 (%A)') ;

// format for date()  see http://jp.php.net/date
define('_PICAL_DTFMT_MINUTE','i分') ;

// orders of formatted elements   Y:year  M:month  W:week  D:day  O:operand
define('_PICAL_FMT_MD','%1$s%2$s') ;
define('_PICAL_FMT_YMD','%1$s年 %2$s %3$s') ;
define('_PICAL_FMT_YMDN','%1$s年 %2$s %3$s (%4$s)') ;
define('_PICAL_FMT_YMDO','%1$s%2$s%3$s%4$s') ;
define('_PICAL_FMT_YMW','%1$s年 %2$s %3$s') ;
define('_PICAL_FMT_YW','%1$s年 第%2$s週') ;
define('_PICAL_FMT_DHI','%1$s %2$s%3$s') ;
define('_PICAL_FMT_HI','%1$s%2$s') ;

// formats for sprintf()
define('_PICAL_FMT_YEAR_MONTH','%1$s年 %2$s') ;
define('_PICAL_FMT_YEAR','%s年') ;
define('_PICAL_FMT_WEEKNO','第%s週') ;

define('_PICAL_ICON_LIST','予定一覧表示') ;
define('_PICAL_ICON_DAILY','一日表示') ;
define('_PICAL_ICON_WEEKLY','週表示') ;
define('_PICAL_ICON_MONTHLY','月表示') ;
define('_PICAL_ICON_YEARLY','年間表示') ;

define('_PICAL_MB_SHOWALLCAT','全カテゴリー表示') ;

define('_PICAL_MB_LINKTODAY','＜今日＞') ;
define('_PICAL_MB_NOSUBJECT','（件名なし）') ;

define('_PICAL_MB_PREV_DATE','昨日') ;
define('_PICAL_MB_NEXT_DATE','明日') ;
define('_PICAL_MB_PREV_WEEK','先週') ;
define('_PICAL_MB_NEXT_WEEK','次週') ;
define('_PICAL_MB_PREV_MONTH','前月') ;
define('_PICAL_MB_NEXT_MONTH','翌月') ;
define('_PICAL_MB_PREV_YEAR','去年') ;
define('_PICAL_MB_NEXT_YEAR','来年') ;

define('_PICAL_MB_NOEVENT','予定なし') ;
define('_PICAL_MB_ADDEVENT','予定の追加') ;
define('_PICAL_MB_CONTINUING','（継続中）') ;
define('_PICAL_MB_RESTEVENT_PRE','他') ;
define('_PICAL_MB_RESTEVENT_SUF','件') ;
define('_PICAL_MB_TIMESEPARATOR','〜') ;

define('_PICAL_MB_ALLDAY_EVENT','全日イベント') ;
define('_PICAL_MB_LONG_EVENT','長期イベント') ;
define('_PICAL_MB_LONG_SPECIALDAY','記念日・祝日等') ;

define('_PICAL_MB_PUBLIC','公開');
define('_PICAL_MB_PRIVATE','非公開');
define('_PICAL_MB_PRIVATETARGET',' 公開先 %s');

define('_PICAL_MB_LINK_TO_RRULE1ST','最初の予定 ') ;
define('_PICAL_MB_RRULE1ST','初回分') ;

define('_PICAL_MB_EVENT_NOTREGISTER','未登録') ;
define('_PICAL_MB_EVENT_ADMITTED','承認済') ;
define('_PICAL_MB_EVENT_NEEDADMIT','未承認') ;

define('_PICAL_MB_TITLE_EVENTINFO','予定表') ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL','詳細情報') ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT','編集') ;

define('_PICAL_MB_HOUR_SUF','時') ;
define('_PICAL_MB_MINUTE_SUF','分') ;

define('_PICAL_MB_ORDER_ASC','昇順') ;
define('_PICAL_MB_ORDER_DESC','降順') ;
define('_PICAL_MB_SORTBY','並び替え:') ;
define('_PICAL_MB_CURSORTEDBY','現在の並び方:') ;

define("_PICAL_MB_LABEL_CHECKEDITEMS","チェックした予定を:");
define("_PICAL_MB_LABEL_OUTPUTICS","iCalendarで出力する");

define("_PICAL_MB_ICALSELECTPLATFORM","出力対象を選択して下さい");

define('_PICAL_TH_SUMMARY','件名') ;
define('_PICAL_TH_TIMEZONE','タイムゾーン') ;
define('_PICAL_TH_STARTDATETIME','開始日時') ;
define('_PICAL_TH_ENDDATETIME','終了日時') ;
define('_PICAL_TH_ALLDAYOPTIONS','全日オプション') ;
define('_PICAL_TH_LOCATION','場所') ;
define('_PICAL_TH_CONTACT','連絡先') ;
define('_PICAL_TH_CATEGORIES','カテゴリー') ;
define('_PICAL_TH_SUBMITTER','投稿者');
define('_PICAL_TH_CLASS','レコード表示');
define('_PICAL_TH_DESCRIPTION','詳細') ;
define('_PICAL_TH_RRULE','繰り返し') ;
define('_PICAL_TH_ADMISSIONSTATUS','状態') ;
define('_PICAL_TH_LASTMODIFIED','最終更新日') ;

define('_PICAL_NTC_MONTHLYBYMONTHDAY','(日付指定)') ;
define('_PICAL_NTC_EXTRACTLIMIT','※展開上限 %s 件') ;
define('_PICAL_NTC_NUMBEROFNEEDADMIT','(未承認 %s 件)') ;

define('_PICAL_OPT_PRIVATEMYSELF','自分のみ');
define('_PICAL_OPT_PRIVATEGROUP','%s グループ');
define('_PICAL_OPT_PRIVATEINVALID','(無効なグループ)');

define('_PICAL_MB_OP_AFTER','以降の予定') ;
define('_PICAL_MB_OP_BEFORE','以前の予定') ;
define('_PICAL_MB_OP_ON','にかかる予定') ;
define('_PICAL_MB_OP_ALL','日付指定無効') ;

define('_PICAL_CNFM_SAVEAS_YN','別件として登録しますか') ;
define('_PICAL_CNFM_DELETE_YN','削除してよろしいですか') ;

define('_PICAL_ERR_INVALID_EVENT_ID','Error: 該当する予定はありません') ;
define('_PICAL_ERR_NOPERM_TO_SHOW','Error: 表示できません') ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS','Error: iCalendar出力操作は許可されていません') ;
define('_PICAL_ERR_LACKINDISPITEM','%s が未入力です<br />ブラウザのボタンで戻ってください') ;

define('_PICAL_BTN_JUMP','Jump') ;
define('_PICAL_BTN_NEWINSERTED','新規登録') ;
define('_PICAL_BTN_SUBMITCHANGES','　変　更　') ;
define('_PICAL_BTN_SAVEAS','別件登録') ;
define('_PICAL_BTN_DELETE','削除') ;
define('_PICAL_BTN_DELETE_ONE','一件削除') ;
define('_PICAL_BTN_EDITEVENT','編集') ;
define('_PICAL_BTN_RESET','リセット') ;
define('_PICAL_BTN_OUTPUTICS_WIN','iCalendar(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','iCalendar(Mac)') ;
define('_PICAL_BTN_PRINT','印刷') ;
define("_PICAL_BTN_IMPORT","インポート実行");
define("_PICAL_BTN_UPLOAD","アップロード実行");
define("_PICAL_BTN_EXPORT","出力");
define("_PICAL_BTN_EXTRACT","抽出");
define("_PICAL_BTN_ADMIT","承認");
define("_PICAL_BTN_MOVE","移動");
define("_PICAL_BTN_COPY","コピー");

define('_PICAL_RR_EVERYDAY','毎日') ;
define('_PICAL_RR_EVERYWEEK','毎週') ;
define('_PICAL_RR_EVERYMONTH','毎月') ;
define('_PICAL_RR_EVERYYEAR','毎年') ;
define('_PICAL_RR_FREQDAILY','日付単位') ;
define('_PICAL_RR_FREQWEEKLY','週単位') ;
define('_PICAL_RR_FREQMONTHLY','月単位') ;
define('_PICAL_RR_FREQYEARLY','年単位') ;
define('_PICAL_RR_FREQDAILY_PRE','') ;
define('_PICAL_RR_FREQWEEKLY_PRE','') ;
define('_PICAL_RR_FREQMONTHLY_PRE','') ;
define('_PICAL_RR_FREQYEARLY_PRE','') ;
define('_PICAL_RR_FREQDAILY_SUF','日ごとに') ;
define('_PICAL_RR_FREQWEEKLY_SUF','週ごとに') ;
define('_PICAL_RR_FREQMONTHLY_SUF','ヶ月ごとに') ;
define('_PICAL_RR_FREQYEARLY_SUF','年ごとに') ;
define('_PICAL_RR_PERDAY','%s 日おきに') ;
define('_PICAL_RR_PERWEEK','%s 週おきに') ;
define('_PICAL_RR_PERMONTH','%s 月おきに') ;
define('_PICAL_RR_PERYEAR','%s 年おきに') ;
define('_PICAL_RR_COUNT','<br />%s 回') ;
define('_PICAL_RR_UNTIL','<br />%s まで') ;
define('_PICAL_RR_R_NORRULE','繰り返し無し') ;
define('_PICAL_RR_R_YESRRULE','繰り返しする') ;
define('_PICAL_RR_OR','または') ;
define('_PICAL_RR_S_NOTSELECTED','-未選択-') ;
define('_PICAL_RR_S_SAMEASBDATE','開始日と同日') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','終了条件無し') ;
define('_PICAL_RR_R_USECOUNT_PRE','回数指定') ;
define('_PICAL_RR_R_USECOUNT_SUF','回') ;
define('_PICAL_RR_R_USEUNTIL','終了日による指定') ;


}

?>