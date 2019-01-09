<?php

// The RFC2445 class   === piCal ===
// piCal.php
// by GIJ=CHECKMATE (PEAK Corp. http://www.peak.ne.jp/)


if( ! class_exists( 'piCal' ) ) {

define( 'PICAL_COPYRIGHT' , "<a href='http://xoops.peak.ne.jp/' target='_blank'>piCal-0.93</a>, <a href='https://github.com/XoopsX/piCal' target='_blank'>piCal > 0.93</a>" ) ;
define( 'PICAL_EVENT_TABLE' , 'pical_event' ) ;
define( 'PICAL_CAT_TABLE' , 'pical_cat' ) ;
define( 'PICAL_ERR_REPORTING_LEVEL' , version_compare( PHP_VERSION, '5.4.0', '>=' )? ( E_ALL ^ E_STRICT ^ E_NOTICE ) : ( E_ALL ^ E_NOTICE ) );


class piCal
{
	// SKELTON (they will be defined in language files)
	var $holidays = array() ;
	var $date_short_names = array() ;
	var $date_long_names = array() ;
	var $week_numbers = array() ;
	var $week_short_names = array() ;
	var $week_middle_names = array() ;
	var $week_long_names = array() ;
	var $month_short_names = array() ;
	var $month_middle_names = array() ;
	var $month_long_names = array() ;
	var $byday2langday_w = array() ;
	var $byday2langday_m = array() ;

	// LOCALES
	var $locale = '' ;			// locale for piCal original
	var $locale4system = '' ;	// locale for UNIX systems (deprecated)

	// COLORS/STYLES  public
	var $holiday_color = '#CC0000' ;
	var $holiday_bgcolor = '#FFEEEE' ;
	var $sunday_color = '#CC0000' ;
	var $sunday_bgcolor = '#FFEEEE' ;
	var $saturday_color = '#0000FF' ;
	var $saturday_bgcolor = '#EEF7FF' ;
	var $weekday_color = '#000099' ;
	var $weekday_bgcolor = '#FFFFFF' ;
	var $targetday_bgcolor = '#CCFF99' ;
	var $calhead_color = '#009900' ;
	var $calhead_bgcolor = '#CCFFCC' ;
	var $frame_css = '' ;

	// TIMEZONES
	var $server_TZ = 9 ;			// Server's  Timezone Offset (hour)
	var $user_TZ = 9 ;				// User's Timezone Offset (hour)
	var $use_server_TZ = false ;	// if 'caldate' is generated in Server's time

	// AUTHORITIES
	var $insertable = true ;		// can insert a new event
	var $editable = true ;			// can update an event he posted
	var $deletable = true ;			// can delete an event he posted
	var $user_id = -1 ;				// User's ID
	var $isadmin = false ;			// Is admin or not

	// ANOTHER public properties
	var $db ;					// xoopsDB object
	var $conn ;					// MySQLとの接続ハンドル (予定取得をする時セット)
	var $table = 'pical_event' ;		// table name for events
	var $cat_table = 'pical_cat' ;		// table name for categories
	var $plugin_table = 'pical_plugin' ;	// table name for plugins
	var $base_url = '' ;
	var $base_path = '' ;
	var $images_url = '/include/piCal/images' ;	// このフォルダに spacer.gif, arrow*.gif 等を置いておく
	var $images_path = 'include/piCal/images' ;
	var $jscalendar = 'jscalendar' ; // DHTML Date/Time Selector
	var $jscalendar_lang_file = 'calendar-jp.js' ; // language file of the jscalh
	var $can_output_ics = true ;	// icsファイル出力を許可するかどうか
	var $connection = 'http' ;		// http か https か
	var $max_rrule_extract = 100 ;	// rrule の展開の上限数(COUNT)
	var $week_start = 0 ;			// 週の開始曜日 0が日曜 1が月曜
	var $week_numbering = 0 ;		// 週の数え方 0なら月ごと 1なら年間通算
	var $day_start = 0 ;			// 日付の境界線（秒単位）
	var $use24 = true ;				// 24時間制ならtrue、12時間制ならfalse
	var $now_cid = 0 ;				// カテゴリ指定
	var $categories = array() ;		// アクセス可能なカテゴリオブジェクト連想配列
	var $groups = array() ;			// PRIVATE時に選択可能なグループの連想配列
	var $nameoruname = 'name' ;		// 投稿者の表示（ログイン名かハンドル名か）
	var $proxysettings = '' ;		// Proxy setting
	var $last_summary = '' ;		// 外部から件名を参照するためのプロパティ
	var $plugins_path_monthly = 'plugins/monthly' ;
	var $plugins_path_weekly = 'plugins/weekly' ;
	var $plugins_path_daily = 'plugins/daily' ;

	// Ver 0.97
	public $whatday_plugins = '';   // 有効にする whatday プラグイン名 モジュール設定から引用される
	
	// private members
	var $year ;
	var $month ;
	var $date ;
	var $day ;			// 0:Sunday ... 6:Saturday
	var $daytype ;		// 0:weekdays 1:saturday 2:sunday 3:holiday
	var $caldate ;		// everytime 'Y-n-j' formatted
	var $unixtime ;
	var $long_event_legends = array() ;
	var $language = "japanese" ;

	// 条件付き参照用メンバ
	var $original_id ;	// $_GET['event_id']を処理した直後に参照可能

	var $event = null ;	// event for meta discription //naao
	
	// whatday プラグインのオブジェクト保持用（オブジェクト保持時は array）
	private $whatday = null;
	
/*******************************************************************/
/*        CONSTRUCTOR etc.                                         */
/*******************************************************************/

// Constructor
public function __construct( $target_date = "" , $language = "japanese" , $reload = false )
{
	$this->db = XoopsDatabaseFactory::getDatabaseConnection();
	// 日付のセット
	if( $target_date ) {
		$this->set_date( $target_date ) ;
	} else if( isset( $_GET[ 'caldate' ] ) ) {
		$this->set_date( $_GET[ 'caldate' ] ) ;
	} else if( isset( $_POST[ 'pical_jumpcaldate' ] ) && isset( $_POST[ 'pical_year' ] ) ) {
		if( empty( $_POST[ 'pical_month' ] ) ) {
			// 年のみがPOSTされた場合
			$month = 1 ;
			$date = 1 ;
		} else if( empty( $_POST[ 'pical_date' ] ) ) {
			// 年・月がPOSTされた場合
			$month = intval( $_POST[ 'pical_month' ] ) ;
			$date = 1 ;
		} else {
			// 年・月・日がPOSTされた場合
			$month = intval( $_POST[ 'pical_month' ] ) ;
			$date = intval( $_POST[ 'pical_date' ] ) ;
		}
		$year = intval( $_POST[ 'pical_year' ] ) ;
		$this->set_date( "$year-$month-$date" ) ;
		$caldate_posted = true ;
	} else {
		$this->set_date( date( 'Y-n-j' ) ) ;
		$this->use_server_TZ = true ;
	}

	// SSLの有無を、$_SERVER['HTTPS'] にて判断
	if( defined( 'XOOPS_URL' ) ) {
		$this->connection = substr( XOOPS_URL , 0 , 8 ) == 'https://' ? 'https' : 'http' ;
	} else if( ! empty( $_SERVER['HTTPS'] ) ) {
		$this->connection = 'https' ;
	} else {
		$this->connection = 'http' ;
	}

	// カテゴリー指定の取得
	$this->now_cid = ! empty( $_GET['cid'] ) ? intval( $_GET['cid'] ) : 0 ;

	// POSTでバラバラに日付を送信された場合、指定があればリロードを行う
	if( ! empty( $caldate_posted ) && $reload && ! headers_sent() ) {
		$reload_str = "Location: $this->connection://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?caldate=$this->caldate&{$_SERVER['QUERY_STRING']}" ;
		$needed_post_vars = array( 'op' , 'order' , 'cid' , 'num' , 'txt' ) ;
		foreach( $needed_post_vars as $post ) {
			if( isset( $_POST[ $post ] ) ) $reload_str .= "&$post=".urlencode( $_POST[ $post ] ) ;
		}
		$reload_str4header = strtr( $reload_str , "\r\n\0" , "   " ) ;
		header( $reload_str4header ) ;
		exit ;
	}

	// piCal.php ファイルの存在するディレクトリの一つ上をベースとする
	$this->base_path = dirname( dirname( __FILE__ ) ) ;

	// 言語ファイルの読み込み
	if ( file_exists( "$this->base_path/language/$language/pical_vars.phtml" ) ) {
		include "$this->base_path/language/$language/pical_vars.phtml" ;
		include_once "$this->base_path/language/$language/pical_constants.php" ;
		$this->language = $language ;
		$this->jscalendar_lang_file = _PICAL_JS_CALENDAR ;
	} else if( file_exists( "$this->base_path/language/english/pical_vars.phtml") ) {
		include "$this->base_path/language/english/pical_vars.phtml" ;
		include_once "$this->base_path/language/english/pical_constants.php" ;
		$this->language = "english" ;
		$this->jscalendar_lang_file = 'calendar-en.js' ;
	}

	// ロケールファイルの読込
	if( ! empty( $this->locale ) ) $this->read_locale() ;
	
}


// piCal専用ロケールファイルを読み込む
function read_locale()
{
	if( file_exists( "$this->base_path/locales/{$this->locale}.php" ) ) {
		include "$this->base_path/locales/{$this->locale}.php" ;
	}
}


// year,month,day,caldate,unixtime をセットする
function set_date( $setdate )
{
//HACK by domifara for php5.3+
//	if( ! ( ereg( "^([0-9][0-9]+)[-./]?([0-1]?[0-9])[-./]?([0-3]?[0-9])$" , $setdate , $regs ) && checkdate( $regs[2] , $regs[3] , $regs[1] ) ) ) {
//		ereg( "^([0-9]{4})-([0-9]{2})-([0-9]{2})$" , date( 'Y-m-d' ) , $regs ) ;
	if( ! ( preg_match( "/^([0-9][0-9]+)[-\.\/]?([0-1]?[0-9])[-\.\/]?([0-3]?[0-9])$/" , $setdate , $regs ) && checkdate( $regs[2] , $regs[3] , $regs[1] ) ) ) {
		preg_match( "/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/" , date( 'Y-m-d' ) , $regs ) ;
		$this->use_server_TZ = true ;
	}
	$this->year = $year = intval( $regs[1] ) ;
	$this->month = $month = intval( $regs[2] ) ;
	$this->date = $date = intval( $regs[3] ) ;
	$this->caldate = "$year-$month-$date" ;
	$this->unixtime = mktime(0,0,0,$month,$date,$year) ;

	// 曜日と日付タイプのセット
	// ツェラーの公式
	if( $month <= 2 ) {
		$year -- ;
		$month += 12 ;
	}
	$day = ( $year + floor( $year / 4 ) - floor( $year / 100 ) + floor( $year / 400 ) + floor( 2.6 * $month + 1.6 ) + $date ) % 7 ;

	$this->day = $day ;
	if( $day == 0 ) $this->daytype = 2 ;
	else if( $day == 6 ) $this->daytype = 1 ;
	else $this->daytype = 0 ;

	if( isset( $this->holidays[ $this->caldate ] ) ) $this->daytype = 3 ;
}



// 曜日・祝日の種類から背景色・文字色を得る
function daytype_to_colors( $daytype )
{
	switch( $daytype ) {
		case 3 :
			//	Holiday
			return array( $this->holiday_bgcolor , $this->holiday_color ) ;
		case 2 :
			//	Sunday
			return array( $this->sunday_bgcolor , $this->sunday_color ) ;
		case 1 :
			//	Saturday
			return array( $this->saturday_bgcolor , $this->saturday_color ) ;
		case 0 :
		default :
			// Weekday
			return array( $this->weekday_bgcolor , $this->weekday_color ) ;
	}
}



// SQL形式の日付から、曜日・祝日の種類を求めるクラス関数
function get_daytype( $date )
{
//HACK by domifara for php5.3+
//	ereg( "^([0-9][0-9]+)[-./]?([0-1]?[0-9])[-./]?([0-3]?[0-9])$" , $date , $regs ) ;
	preg_match( "/^([0-9][0-9]+)[-\.\/]?([0-1]?[0-9])[-\.\/]?([0-3]?[0-9])$/" , $date , $regs ) ;
	$year = intval( $regs[1] ) ;
	$month = intval( $regs[2] ) ;
	$date = intval( $regs[3] ) ;

	// 祝日は3
	if( isset( $this->holidays[ "$year-$month-$date" ] ) ) return 3 ;

	// ツェラーの公式
	if ($month <= 2) {
		$year -- ;
		$month += 12;
	}
	$day = ( $year + floor( $year / 4 ) - floor( $year / 100 ) + floor( $year / 400 )+ floor( 2.6 * $month + 1.6 ) + $date ) % 7 ;

	if( $day == 0 ) return 2 ;
	else if( $day == 6 ) return 1 ;
	else return 0 ;
}



/*******************************************************************/
/*        ブロック用表示関数                                       */
/*******************************************************************/

// $this->caldate日の予定 を返す
function get_date_schedule( $get_target = '' )
{
	// if( $get_target == '' ) $get_target = $_SERVER['SCRIPT_NAME'] ;

	$ret = '' ;

	// 時差を計算しつつ、WHERE節の期間に関する条件生成
	$tzoffset = ( $this->user_TZ - $this->server_TZ ) * 3600 ;
	if( $tzoffset == 0 ) {
		// 時差がない場合 （MySQLに負荷をかけさせないため、ここで条件分けしとく)
		$whr_term = "start<'".($this->unixtime + 86400)."' AND end>'$this->unixtime'" ;
	} else {
		// 時差がある場合は、alldayによって場合分け
		$whr_term = "( allday AND start<='$this->unixtime' AND end>'$this->unixtime') OR ( ! allday AND start<'".($this->unixtime + 86400 - $tzoffset )."' AND end>'".($this->unixtime - $tzoffset )."')" ;
	}

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// 当日のスケジュール取得
	$yrs = $this->db->query( "SELECT start,end,summary,id,allday FROM $this->table WHERE admission>0 AND ($whr_term) AND ($whr_categories) AND ($whr_class) ORDER BY start,end" ) ;
	$num_rows = $this->db->getRowsNum( $yrs ) ;

	if( $num_rows == 0 ) $ret .= _PICAL_MB_NOEVENT."\n" ;
	else while( $event = $this->db->fetchArray( $yrs ) ) {
		$event = (object)$event;
		$summary = $this->text_sanitizer_for_show( $event->summary ) ;

		if( $event->allday ) {
			// 全日イベント
			$ret .= "
	       <table>
	         <tr>
	           <td><img border='0' src='$this->images_url/dot_allday.gif' /> &nbsp; </td>
	           <td><a href='$get_target?cid=$this->now_cid&amp;smode=Daily&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='calsummary_allday'>$summary</a></td>
	         </tr>
	       </table>\n" ;
		} else {
			// 通常イベント
			$event->start += $tzoffset ;
			$event->end += $tzoffset ;
			$ret .= "
	       <dl>
	         <dt>
	           ".$this->get_todays_time_description( $event->start , $event->end , $this->caldate , false , true )."
	         </dt>
	         <dd>
	           <a href='$get_target?cid=$this->now_cid&amp;smode=Daily&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='calsummary'>$summary</a>
	         </dd>
	       </dl>\n" ;
		}
	}

	// 予定の追加（鉛筆アイコン）
	if( $this->insertable ) $ret .= "
	       <dl>
	         <dt>
	           &nbsp; <a class='no-print' href='$get_target?smode=Daily&amp;action=Edit&amp;caldate=$this->caldate'><img src='$this->images_url/addevent.gif' border='0' width='14' height='12' />"._PICAL_MB_ADDEVENT."</a>
	         </dt>
	       </dl>\n" ;

	return $ret ;
}



// $this->caldate以降の予定 を最大 $num 件返す
function get_coming_schedule( $get_target = '' , $num = 5 )
{
	// if( $get_target == '' ) $get_target = $_SERVER['SCRIPT_NAME'] ;

	$ret = '' ;

	// 時差を計算しつつ、WHERE節の期間に関する条件生成
	$tzoffset = ( $this->user_TZ - $this->server_TZ ) * 3600 ;
	if( $tzoffset == 0 ) {
		// 時差がない場合 （MySQLに負荷をかけさせないため、ここで条件分けしとく)
		$whr_term = "end>'$this->unixtime'" ;
	} else {
		// 時差がある場合は、alldayによって場合分け
		$whr_term = "(allday AND end>'$this->unixtime') OR ( ! allday AND end>'".($this->unixtime - $tzoffset )."')" ;
	}

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// 当日以降のスケジュール取得
	$yrs = $this->db->query( "SELECT start,end,summary,id,allday FROM $this->table WHERE admission>0 AND ($whr_term) AND ($whr_categories) AND ($whr_class) ORDER BY start" ) ;
	$num_rows = $this->db->getRowsNum( $yrs ) ;

	if( $num_rows == 0 ) $ret .= "
	  <dl class='no_border'><dt></dt><dd> "
		._PICAL_MB_NOEVENT.
		"</dd></dl>\n" ;
	else for( $i = 0 ; $i < $num ; $i ++ ) {
		$event = (object)$this->db->fetchArray( $yrs ) ;
		if( $event == false ) break ;
		$summary = $this->text_sanitizer_for_show( $event->summary ) ;

		if( $event->allday ) {
			// 全日イベント
			$ret .= "
	       <dl>
	         <dt>
	           <img border='0' src='$this->images_url/dot_allday.gif' /> ".$this->get_middle_md( $event->start )."
	         </dt>
	         <dd>
	           <a href='$get_target?cid=$this->now_cid&amp;smode=Daily&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='calsummary_allday'>$summary</a>
	         </dd>
	       </dl>\n" ;
		} else {
			// 通常イベント
			$event->start += $tzoffset ;
			$event->end += $tzoffset ;
			$ret .= "
	       <dl>
	         <dt>
	           ".$this->get_coming_time_description( $event->start , $this->unixtime )."
	         </dt>
	         <dd>
	           <a href='$get_target?cid=$this->now_cid&amp;smode=Daily&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='calsummary'>$summary</a>
	         </dd>
	       </dl>\n" ;
		}
	}

	// 残り件数の表示
	if( $num_rows > $num ) $ret .= "
           <table>
            <tr>
             <td align='right'><small>"._PICAL_MB_RESTEVENT_PRE.($num_rows-$num)._PICAL_MB_RESTEVENT_SUF."</small></td>
            </tr>
           </table>\n" ;

	// 予定の追加（鉛筆アイコン）
	if( $this->insertable ) $ret .= "
	       <dl>
	         <dt>
	           &nbsp; <a href='$get_target?smode=Daily&amp;action=Edit&amp;caldate=$this->caldate'><img src='$this->images_url/addevent.gif' border='0' width='14' height='12' />"._PICAL_MB_ADDEVENT."</a>
	         </dt>
	       </dl>\n" ;

	return $ret ;
}



// ミニカレンダー用イベント取得関数
function get_flags_date_has_events( $range_start_s , $range_end_s )
{
	// あらかじめ配列を生成しておく
	/* for( $time = $start ; $time < $end ; $time += 86400 ) {
		$ret[ date( 'j' , $time ) ] = 0 ;
	} */
	for( $i = 0 ; $i <= 31 ; $i ++ ) {
		$ret[ $i ] = 0 ;
	}

	// add margin -86400 and +86400
	$range_start_s -= 86400 ;
	$range_end_s += 86400 ;

	// 時差計算
	$tzoffset_s2u = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
	//$gmtoffset = intval( $this->server_TZ * 3600 ) ;

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

/*	$yrs = $this->db->query( "SELECT start,end,allday FROM $this->table WHERE admission > 0 AND start < ".($end + 86400)." AND end > ".($start - 86400)." AND ($whr_categories) AND ($whr_class)" ) ;
	while( $event = $this->db->fetchArray( $yrs ) ) {
		$event = (object)$event;
		$time = $event->start > $start ? $event->start : $start ;
		if( ! $event->allday ) {
			$time += $tzoffset ;
			$event->end += $tzoffset ;
		}
		$time -= ( $time + $gmtoffset ) % 86400 ;
		while( $time < $end && $time < $event->end ) {
			$ret[ date( 'j' , $time ) ] = 1 ;
			$time += 86400 ;
		}
	}*/



	// 全日イベント以外の処理
	$result = $this->db->query( "SELECT summary,id,start FROM $this->table WHERE admission > 0 AND start >= $range_start_s AND start < $range_end_s AND ($whr_categories) AND ($whr_class) AND allday <= 0" ) ;

	while( list( $title , $id , $server_time ) = $this->db->fetchRow( $result ) ) {
		$user_time = $server_time + $tzoffset_s2u ;
		if( date( 'n' , $user_time ) != $this->month ) continue ;
		$ret[ date('j',$user_time) ] = 1 ;
	}

	// 全日イベント専用の処理
	$result = $this->db->query( "SELECT summary,id,start,end FROM $this->table WHERE admission > 0 AND start >= $range_start_s AND start < $range_end_s AND ($whr_categories) AND ($whr_class) AND allday > 0" ) ;

	while( list( $title , $id , $start_s , $end_s ) = $this->db->fetchRow( $result ) ) {
		if( $start_s < $range_start_s ) $start_s = $range_start_s ;
		if( $end_s > $range_end_s ) $end_s = $range_end_s ;

		while( $start_s < $end_s ) {
			$user_time = $start_s + $tzoffset_s2u ;
			if( date( 'n' , $user_time ) == $this->month ) {
				$ret[ date('j',$user_time) ] = 1 ;
			}
			$start_s += 86400 ;
		}
	}

	return $ret ;
}



// ミニカレンダー表示用文字列を返す
function get_mini_calendar_html( $get_target = '' , $query_string = '' , $mode = '' )
{
	// 実行時間計測スタート
	// list( $usec , $sec ) = explode( " " , microtime() ) ;
	// $picalstarttime = $sec + $usec ;

	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;
	// if( $get_target == '' ) $get_target = $PHP_SELF ;

	$original_level = error_reporting( PICAL_ERR_REPORTING_LEVEL ) ;
	require_once( "$this->base_path/include/patTemplate.php" ) ;
	$tmpl = new PatTemplate() ;
	//$tmpl->setBasedir( "$this->images_path" ) ;

	// 表示モードに応じて、テンプレートファイルを振り分け
	switch( $mode ) {
		case 'NO_YEAR' :
			// 年間表示用
			//$tmpl->readTemplatesFromFile( "minical_for_yearly.tmpl.html" ) ;
			$this->set_patTemplate( $tmpl , 'minical_for_yearly.tmpl.html' ) ;
			$target_highlight_flag = false ;
			break ;
		case 'NO_NAVIGATE' :
			// 月間の下部参照用
			//$tmpl->readTemplatesFromFile( "minical_for_monthly.tmpl.html" ) ;
			$this->set_patTemplate( $tmpl , 'minical_for_monthly.tmpl.html' ) ;
			$target_highlight_flag = false ;
			break ;
		default :
			// 通常のミニカレンダーブロック用
			//$tmpl->readTemplatesFromFile( "minical.tmpl.html" ) ;
			$this->set_patTemplate( $tmpl , 'minical.tmpl.html' ) ;
			$target_highlight_flag = true ;
			break ;
	}

	// 当月の各日がイベントを持っているかどうかを取得
	$event_dates = $this->get_flags_date_has_events( mktime(0,0,0,$this->month,1,$this->year) , mktime(0,0,0,$this->month+1,1,$this->year) ) ;

	// 前月は月末、翌月は月初とする
	$prev_month = date("Y-n-j", mktime(0,0,0,$this->month,0,$this->year));
	$next_month = date("Y-n-j", mktime(0,0,0,$this->month+1,1,$this->year));

	// $tmpl->addVar( "WholeBoard" , "PHP_SELF" , '' ) ;
	$tmpl->addVar( "WholeBoard" , "GET_TARGET" , $get_target ) ;
	$tmpl->addVar( "WholeBoard" , "QUERY_STRING" , $query_string ) ;

	$tmpl->addVar( "WholeBoard" , "MB_PREV_MONTH" , _PICAL_MB_PREV_MONTH ) ;
	$tmpl->addVar( "WholeBoard" , "MB_NEXT_MONTH" , _PICAL_MB_NEXT_MONTH ) ;
	$tmpl->addVar( "WholeBoard" , "MB_LINKTODAY" , _PICAL_MB_LINKTODAY ) ;

	$tmpl->addVar( "WholeBoard" , "SKINPATH" , $this->images_url ) ;
	$tmpl->addVar( "WholeBoard" , "FRAME_CSS" , $this->frame_css ) ;
//	$tmpl->addVar( "WholeBoard" , "YEAR" , $this->year ) ;
//	$tmpl->addVar( "WholeBoard" , "MONTH" , $this->month ) ;
	$tmpl->addVar( "WholeBoard" , "MONTH_NAME" , $this->month_middle_names[ $this->month ] ) ;
	$tmpl->addVar( "WholeBoard" , "YEAR_MONTH_TITLE" , sprintf( _PICAL_FMT_YEAR_MONTH , $this->year , $this->month_middle_names[ $this->month ] ) ) ;
	$tmpl->addVar( "WholeBoard" , "PREV_MONTH" , $prev_month ) ;
	$tmpl->addVar( "WholeBoard" , "NEXT_MONTH" , $next_month ) ;

	$tmpl->addVar( "WholeBoard" , "CALHEAD_BGCOLOR" , $this->calhead_bgcolor ) ;
	$tmpl->addVar( "WholeBoard" , "CALHEAD_COLOR" , $this->calhead_color ) ;


	$first_date = getdate(mktime(0,0,0,$this->month,1,$this->year));
	$date = ( - $first_date['wday'] + $this->week_start - 7 ) % 7 ;
	$wday_end = 7 + $this->week_start ;

	// 曜日名ループ
	$rows = array() ;
	for( $wday = $this->week_start ; $wday < $wday_end ; $wday ++ ) {
		if( $wday % 7 == 0 ) {
			//	Sunday
			$bgcolor = $this->sunday_bgcolor ;
			$color = $this->sunday_color ;
		} elseif( $wday == 6 ) {
			//	Saturday
			$bgcolor = $this->saturday_bgcolor ;
			$color = $this->saturday_color ;
		} else {
			// Weekday
			$bgcolor = $this->weekday_bgcolor ;
			$color = $this->weekday_color ;
		}

		// テンプレート用配列へのデータセット
		array_push( $rows , array(
			"BGCOLOR" => $bgcolor ,
			"COLOR" => $color ,
			"DAYNAME" => $this->week_short_names[ $wday % 7 ] ,
		) ) ;
	}

	// テンプレートにデータを埋め込む
	$tmpl->addRows( "DayNameLoop" , $rows ) ;
	$tmpl->parseTemplate( "DayNameLoop" , 'w' ) ;

	// 週 (row) ループ
	for( $week = 0 ; $week < 6 ; $week ++ ) {

		$rows = array() ;

		// 日 (col) ループ
		for( $wday = $this->week_start ; $wday < $wday_end ; $wday ++ ) {
			$date ++ ;
			if( ! checkdate($this->month,$date,$this->year) ) {
				// 月の範囲外
				array_push( $rows , array(
					"GET_TARGET" => $get_target ,
					"QUERY_STRING" => $query_string ,
					"SKINPATH" => $this->images_url ,
					"DATE" => date( 'j' , mktime( 0 , 0 , 0 , $this->month , $date , $this->year ) ) ,
					"DATE_TYPE" => 0
				) ) ;
				continue ;
			}

			$link = "$this->year-$this->month-$date" ;

			// 曜日タイプによる描画色振り分け
			if( isset( $this->holidays[$link] ) ) {
				//	Holiday
				$bgcolor = $this->holiday_bgcolor ;
				$color = $this->holiday_color ;
			} elseif( $wday % 7 == 0 ) {
				//	Sunday
				$bgcolor = $this->sunday_bgcolor ;
				$color = $this->sunday_color ;
			} elseif( $wday == 6 ) {
				//	Saturday
				$bgcolor = $this->saturday_bgcolor ;
				$color = $this->saturday_color ;
			} else {
				// Weekday
				$bgcolor = $this->weekday_bgcolor ;
				$color = $this->weekday_color ;
			}

			// 選択日の背景色ハイライト処理
			if( $date == $this->date && $target_highlight_flag ) $bgcolor = $this->targetday_bgcolor ;

			// テンプレート用配列へのデータセット
			array_push( $rows , array(
				"GET_TARGET" => $get_target ,
				"QUERY_STRING" => $query_string ,

				"BGCOLOR" => $bgcolor ,
				"COLOR" => $color ,
				"LINK" => $link ,
				"DATE" => $date ,
				"DATE_TYPE" => $event_dates[ $date ] + 1
			) ) ;
		}
		// テンプレートにデータを埋め込む
		$tmpl->addRows( "DailyLoop" , $rows ) ;
		$tmpl->parseTemplate( "DailyLoop" , 'w' ) ;
		$tmpl->parseTemplate( "WeekLoop" , 'a' ) ;
	}

	$ret = $tmpl->getParsedTemplate() ;

	error_reporting( $original_level ) ;

	// 実行時間記録
	// list( $usec , $sec ) = explode( " " , microtime() ) ;
	// error_log( "MiniCalendar " . ( $sec + $usec - $picalstarttime ) . "sec." , 0 ) ;

	return $ret ;
}



/*******************************************************************/
/*        メイン部表示関数                                         */
/*******************************************************************/

// 年間カレンダー全体の表示（patTemplate使用)
function get_yearly( $get_target = '' , $query_string = '' , $for_print = false )
{
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;
	// if( $get_target == '' ) $get_target = $PHP_SELF ;

	$original_level = error_reporting( PICAL_ERR_REPORTING_LEVEL ) ;
	require_once( "$this->base_path/include/patTemplate.php" ) ;
	$tmpl = new PatTemplate() ;
	//$tmpl->readTemplatesFromFile( "$this->images_path/yearly.tmpl.html" ) ;
	$this->set_patTemplate( $tmpl , 'yearly.tmpl.html' ) ;

	// setting skin folder
	$tmpl->addVar( "WholeBoard" , "SKINPATH" , $this->images_url ) ;

	// Static parameter for the request
	$tmpl->addVar( "WholeBoard" , "GET_TARGET" , $get_target ) ;
	$tmpl->addVar( "WholeBoard" , "QUERY_STRING" , $query_string ) ;
	$tmpl->addVar( "WholeBoard" , "PRINT_LINK" , "$this->base_url/print.php?cid=$this->now_cid&amp;smode=Yearly&amp;caldate=$this->caldate" ) ;
	$tmpl->addVar( "WholeBoard" , "LANG_PRINT" , _PICAL_BTN_PRINT ) ;
	if( $for_print ) $tmpl->addVar( "WholeBoard" , "PRINT_ATTRIB" , "width='0' height='0'" ) ;

	// カテゴリー選択ボックス
	$tmpl->addVar( "WholeBoard" , "CATEGORIES_SELFORM" , $this->get_categories_selform( $get_target ) ) ;
	$tmpl->addVar( "WholeBoard" , "CID" , $this->now_cid ) ;

	// Category description
	$tmpl->addVar( "CategoryDescription" , "DESCRIPTION" , $this->now_cid? $this->textarea_sanitizer_for_show($this->categories[ $this->now_cid ]->cat_desc) : '' );
	
	// Variables required in header part etc.
	$tmpl->addVars( "WholeBoard" , $this->get_calendar_information( 'Y' ) ) ;

	$tmpl->addVar( "WholeBoard" , "LANG_JUMP" , _PICAL_BTN_JUMP ) ;

	// 各月のミニカレンダー
	// $this->caldate のバックアップ
	$backuped_caldate = $this->caldate ;

	// 12ヶ月分のミニカレンダー取得ループ
	for( $m = 1 ; $m <= 12 ; $m ++ ) {
		$this->set_date( date("Y-n-j", mktime(0,0,0,$m,1,$this->year)) ) ;
		$tmpl->addVar( "WholeBoard" , "MINICAL$m" , $this->get_mini_calendar_html( $get_target , $query_string , "NO_YEAR" ) ) ;
	}

	// $this->caldate のリストア
	$this->set_date( $backuped_caldate ) ;

	// content generated from patTemplate
	$ret = $tmpl->getParsedTemplate( "WholeBoard" ) ;

	error_reporting( $original_level ) ;

	return $ret ;
}



// 月間カレンダー全体の表示（patTemplate使用)
function get_monthly( $get_target = '' , $query_string = '' , $for_print = false )
{
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;
	// if( $get_target == '' ) $get_target = $PHP_SELF ;

	$original_level = error_reporting( PICAL_ERR_REPORTING_LEVEL ) ;
	require_once( "$this->base_path/include/patTemplate.php" ) ;
	$tmpl = new PatTemplate() ;
	//$tmpl->readTemplatesFromFile( "$this->images_path/monthly.tmpl.html" ) ;
	$this->set_patTemplate( $tmpl , 'monthly.tmpl.html' ) ;

	// setting skin folder
	$tmpl->addVar( "WholeBoard" , "SKINPATH" , $this->images_url ) ;

	// Static parameter for the request
	$tmpl->addVar( "WholeBoard" , "GET_TARGET" , $get_target ) ;
	$tmpl->addVar( "WholeBoard" , "QUERY_STRING" , $query_string ) ;
	$tmpl->addVar( "WholeBoard" , "YEAR_MONTH_TITLE" , sprintf( _PICAL_FMT_YEAR_MONTH , $this->year , $this->month_middle_names[ $this->month ] ) ) ;
	$tmpl->addVar( "WholeBoard" , "PRINT_LINK" , "$this->base_url/print.php?cid=$this->now_cid&amp;smode=Monthly&amp;caldate=$this->caldate" ) ;
	$tmpl->addVar( "WholeBoard" , "LANG_PRINT" , _PICAL_BTN_PRINT ) ;
	if( $for_print ) $tmpl->addVar( "WholeBoard" , "PRINT_ATTRIB" , "width='0' height='0'" ) ;

	// カテゴリー選択ボックス
	$tmpl->addVar( "WholeBoard" , "CATEGORIES_SELFORM" , $this->get_categories_selform( $get_target ) ) ;
	$tmpl->addVar( "WholeBoard" , "CID" , $this->now_cid ) ;
	
	// Category description
	$tmpl->addVar( "CategoryDescription" , "DESCRIPTION" , $this->now_cid? $this->textarea_sanitizer_for_show($this->categories[ $this->now_cid ]->cat_desc) : '' );

	// Variables required in header part etc.
	$tmpl->addVars( "WholeBoard" , $this->get_calendar_information( 'M' ) ) ;

	$tmpl->addVar( "WholeBoard" , "LANG_JUMP" , _PICAL_BTN_JUMP ) ;

	// BODY of the calendar
	$tmpl->addVar( "WholeBoard" , "CALENDAR_BODY" , $this->get_monthly_html( $get_target , $query_string ) ) ;

	// legends of long events
	foreach( $this->long_event_legends as $bit => $legend ) {
		$tmpl->addVar( "LongEventLegends" , "BIT_MASK" , 1 << ( $bit - 1 ) ) ;
		$tmpl->addVar( "LongEventLegends" , "LEGEND_ALT" , _PICAL_MB_ALLDAY_EVENT . " $bit" ) ;
		$tmpl->addVar( "LongEventLegends" , "LEGEND" , $legend ) ;
		$tmpl->addVar( "LongEventLegends" , "SKINPATH" , $this->images_url ) ;
		$tmpl->parseTemplate( "LongEventLegends" , "a" ) ;
	}

	// 先月・翌月のミニカレンダー
	// $this->caldate のバックアップ
	$backuped_caldate = $this->caldate ;
	// 前月末の日付をセットし、前月のミニカレンダーをセット
	$this->set_date( date("Y-n-j", mktime(0,0,0,$this->month,0,$this->year)) ) ;
	$tmpl->addVar( "WholeBoard" , "PREV_MINICAL" , $this->get_mini_calendar_html( $get_target , $query_string , "NO_NAVIGATE" ) ) ;
	// 翌月始の日付をセットし、ミニカレンダーを表示
	$this->set_date( date("Y-n-j", mktime(0,0,0,$this->month+2,1,$this->year)) ) ;
	$tmpl->addVar( "WholeBoard" , "NEXT_MINICAL" , $this->get_mini_calendar_html( $get_target , $query_string , "NO_NAVIGATE" ) ) ;
	// $this->caldate のリストア
	$this->set_date( $backuped_caldate ) ;

	// content generated from patTemplate
	$ret = $tmpl->getParsedTemplate( "WholeBoard" ) ;

	error_reporting( $original_level ) ;

	return $ret ;
}



// 週間カレンダー全体の表示（patTemplate使用)
function get_weekly( $get_target = '' , $query_string = '' , $for_print = false )
{
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;
	// if( $get_target == '' ) $get_target = $PHP_SELF ;

	$original_level = error_reporting( PICAL_ERR_REPORTING_LEVEL ) ;
	require_once( "$this->base_path/include/patTemplate.php" ) ;
	$tmpl = new PatTemplate() ;
	//$tmpl->readTemplatesFromFile( "$this->images_path/weekly.tmpl.html" ) ;
	$this->set_patTemplate( $tmpl , 'weekly.tmpl.html' ) ;

	// setting skin folder
	$tmpl->addVar( "WholeBoard" , "SKINPATH" , $this->images_url ) ;

	// Static parameter for the request
	$tmpl->addVar( "WholeBoard" , "GET_TARGET" , $get_target ) ;
	$tmpl->addVar( "WholeBoard" , "QUERY_STRING" , $query_string ) ;
	$tmpl->addVar( "WholeBoard" , "PRINT_LINK" , "$this->base_url/print.php?cid=$this->now_cid&amp;smode=Weekly&amp;caldate=$this->caldate" ) ;
	$tmpl->addVar( "WholeBoard" , "LANG_PRINT" , _PICAL_BTN_PRINT ) ;
	if( $for_print ) $tmpl->addVar( "WholeBoard" , "PRINT_ATTRIB" , "width='0' height='0'" ) ;

	// カテゴリー選択ボックス
	$tmpl->addVar( "WholeBoard" , "CATEGORIES_SELFORM" , $this->get_categories_selform( $get_target ) ) ;
	$tmpl->addVar( "WholeBoard" , "CID" , $this->now_cid ) ;

	// Category description
	$tmpl->addVar( "CategoryDescription" , "DESCRIPTION" , $this->now_cid? $this->textarea_sanitizer_for_show($this->categories[ $this->now_cid ]->cat_desc) : '' );

	// Variables required in header part etc.
	$tmpl->addVars( "WholeBoard" , $this->get_calendar_information( 'W' ) ) ;

	$tmpl->addVar( "WholeBoard" , "LANG_JUMP" , _PICAL_BTN_JUMP ) ;

	// BODY of the calendar
	$tmpl->addVar( "WholeBoard" , "CALENDAR_BODY" , $this->get_weekly_html( $get_target , $query_string ) ) ;

	// content generated from patTemplate
	$ret = $tmpl->getParsedTemplate( "WholeBoard" ) ;

	error_reporting( $original_level ) ;

	return $ret ;
}



// 一日カレンダー全体の表示（patTemplate使用)
function get_daily( $get_target = '' , $query_string = '' , $for_print = false )
{
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;
	// if( $get_target == '' ) $get_target = $PHP_SELF ;

	$original_level = error_reporting( PICAL_ERR_REPORTING_LEVEL ) ;
	require_once( "$this->base_path/include/patTemplate.php" ) ;
	$tmpl = new PatTemplate() ;
	//$tmpl->readTemplatesFromFile( "$this->images_path/daily.tmpl.html" ) ;
	$this->set_patTemplate( $tmpl , 'daily.tmpl.html' ) ;

	// setting skin folder
	$tmpl->addVar( "WholeBoard" , "SKINPATH" , $this->images_url ) ;

	// Static parameter for the request
	$tmpl->addVar( "WholeBoard" , "GET_TARGET" , $get_target ) ;
	$tmpl->addVar( "WholeBoard" , "QUERY_STRING" , $query_string ) ;
	$tmpl->addVar( "WholeBoard" , "PRINT_LINK" , "$this->base_url/print.php?cid=$this->now_cid&amp;smode=Daily&amp;caldate=$this->caldate" ) ;
	$tmpl->addVar( "WholeBoard" , "LANG_PRINT" , _PICAL_BTN_PRINT ) ;
	if( $for_print ) $tmpl->addVar( "WholeBoard" , "PRINT_ATTRIB" , "width='0' height='0'" ) ;

	// カテゴリー選択ボックス
	$tmpl->addVar( "WholeBoard" , "CATEGORIES_SELFORM" , $this->get_categories_selform( $get_target ) ) ;
	$tmpl->addVar( "WholeBoard" , "CID" , $this->now_cid ) ;

	// Category description
	$tmpl->addVar( "CategoryDescription" , "DESCRIPTION" , $this->now_cid? $this->textarea_sanitizer_for_show($this->categories[ $this->now_cid ]->cat_desc) : '' );

	// Variables required in header part etc.
	$tmpl->addVars( "WholeBoard" , $this->get_calendar_information( 'D' ) ) ;

	$tmpl->addVar( "WholeBoard" , "LANG_JUMP" , _PICAL_BTN_JUMP ) ;

	// BODY of the calendar
	$tmpl->addVar( "WholeBoard" , "CALENDAR_BODY" , $this->get_daily_html( $get_target , $query_string ) ) ;

	// content generated from patTemplate
	$ret = $tmpl->getParsedTemplate( "WholeBoard" ) ;

	error_reporting( $original_level ) ;

	return $ret ;
}



// カレンダーのヘッダ部等に必要な情報を連想配列で返す（月間・週間・１日共通）
function get_calendar_information( $mode = 'M' )
{
	$ret = array() ;

	// 基本情報
	$ret[ 'TODAY' ] = date( "Y-n-j" ) ;		// GIJ TODO 要手直し（使わない？）
	$ret[ 'CALDATE' ] = $this->caldate ;
	$ret[ 'DISP_YEAR' ] = sprintf( _PICAL_FMT_YEAR , $this->year ) ;
	$ret[ 'DISP_MONTH' ] = $this->month_middle_names[ $this->month ] ;
	$ret[ 'DISP_DATE' ] = $this->date_long_names[ $this->date ] ;
	$ret[ 'DISP_DAY' ] = "({$this->week_middle_names[ $this->day ]})" ;
	list( $bgcolor , $color ) =  $this->daytype_to_colors( $this->daytype ) ;
	$ret[ 'DISP_DAY_COLOR' ] = $color ;
	$ret[ 'COPYRIGHT' ] = PICAL_COPYRIGHT ;

	// ヘッダー部のカラー
	$ret[ 'CALHEAD_BGCOLOR' ]  =  $this->calhead_bgcolor ;
	$ret[ 'CALHEAD_COLOR' ] = $this->calhead_color ;

	// アイコンのalt(title)
	$ret[ 'ICON_LIST' ] = _PICAL_ICON_LIST ;
	$ret[ 'ICON_DAILY' ] = _PICAL_ICON_DAILY ;
	$ret[ 'ICON_WEEKLY' ] = _PICAL_ICON_WEEKLY ;
	$ret[ 'ICON_MONTHLY' ] = _PICAL_ICON_MONTHLY ;
	$ret[ 'ICON_YEARLY' ] = _PICAL_ICON_YEARLY ;

	// メッセージブロック
	$ret[ 'MB_PREV_YEAR' ] = _PICAL_MB_PREV_YEAR ;
	$ret[ 'MB_NEXT_YEAR' ] = _PICAL_MB_NEXT_YEAR ;
	$ret[ 'MB_PREV_MONTH' ] = _PICAL_MB_PREV_MONTH ;
	$ret[ 'MB_NEXT_MONTH' ] = _PICAL_MB_NEXT_MONTH ;
	$ret[ 'MB_PREV_WEEK' ] = _PICAL_MB_PREV_WEEK ;
	$ret[ 'MB_NEXT_WEEK' ] = _PICAL_MB_NEXT_WEEK ;
	$ret[ 'MB_PREV_DATE' ] = _PICAL_MB_PREV_DATE ;
	$ret[ 'MB_NEXT_DATE' ] = _PICAL_MB_NEXT_DATE ;
	$ret[ 'MB_LINKTODAY' ] = _PICAL_MB_LINKTODAY ;

	// 前や後へのリンク
	$ret[ 'PREV_YEAR' ] = date("Y-n-j", mktime(0,0,0,$this->month,$this->date,$this->year-1));
	$ret[ 'NEXT_YEAR' ] = date("Y-n-j", mktime(0,0,0,$this->month,$this->date,$this->year+1));
	$ret[ 'PREV_MONTH' ] = date("Y-n-j", mktime(0,0,0,$this->month,0,$this->year));
	$ret[ 'NEXT_MONTH' ] = date("Y-n-j", mktime(0,0,0,$this->month+1,1,$this->year));
	$ret[ 'PREV_WEEK' ] = date("Y-n-j", mktime(0,0,0,$this->month,$this->date-7,$this->year)) ;
	$ret[ 'NEXT_WEEK' ] = date("Y-n-j", mktime(0,0,0,$this->month,$this->date+7,$this->year)) ;
	$ret[ 'PREV_DATE' ] = date("Y-n-j", mktime(0,0,0,$this->month,$this->date-1,$this->year)) ;
	$ret[ 'NEXT_DATE' ] = date("Y-n-j", mktime(0,0,0,$this->month,$this->date+1,$this->year)) ;

	// 日付ジャンプ用フォームの各コントロール
	// 年月選択肢の初期値
	if( empty( $_POST[ 'pical_year' ] ) ) $year = $this->year ;
	else  $year = intval( $_POST[ 'pical_year' ] ) ;
	if( empty( $_POST[ 'pical_month' ] ) ) $month = $this->month ;
	else $month = intval( $_POST[ 'pical_month' ] ) ;
	if( empty( $_POST[ 'pical_date' ] ) ) $date = $this->date ;
	else $date = intval( $_POST[ 'pical_date' ] ) ;

	// 年の選択肢(現在から前後の20年間とする)
	$year_options = "" ;
	for( $y = date('Y') - 9 ; $y <= date('Y') + 10 ; $y ++ ) {
		if( $y == $year ) {
			$year_options .= "\t\t\t<option value='$y' selected='selected'>".sprintf(strip_tags(_PICAL_FMT_YEAR),$y)."</option>\n" ;
		} else {
			$year_options .= "\t\t\t<option value='$y'>".sprintf(strip_tags(_PICAL_FMT_YEAR),$y)."</option>\n" ;
		}
	}
	$ret[ 'YEAR_OPTIONS' ] = $year_options ;

	// 月の選択肢
	$month_options = "" ;
	for( $m = 1 ; $m <= 12 ; $m ++ ) {
		if( $m == $month ) {
			$month_options .= "\t\t\t<option value='$m' selected='selected'>{$this->month_short_names[$m]}</option>\n" ;
		} else {
			$month_options .= "\t\t\t<option value='$m'>{$this->month_short_names[$m]}</option>\n" ;
		}
	}
	$ret[ 'MONTH_OPTIONS' ] = $month_options ;

	// 日の選択肢
	if( $mode == 'W' || $mode == 'D' ) {
		$date_options = "" ;
		for( $d = 1 ; $d <= 31 ; $d ++ ) {
			if( $d == $date ) {
				$date_options .= "\t\t\t<option value='$d' selected='selected'>{$this->date_short_names[$d]}</option>\n" ;
			} else {
				$date_options .= "\t\t\t<option value='$d'>{$this->date_short_names[$d]}</option>\n" ;
			}
		}

		$ret[ 'YMD_SELECTS' ] = sprintf( _PICAL_FMT_YMD , "<select name='pical_year'>{$ret['YEAR_OPTIONS']}</select>" , "<select name='pical_month'>{$ret['MONTH_OPTIONS']}</select> " , "<select name='pical_date'>$date_options</select>" ) ;
		if( $this->week_numbering ) {
			if( $this->day == 0 && ! $this->week_start ) $weekno = date( 'W' , $this->unixtime + 86400 ) ;
			else $weekno = date( 'W' , $this->unixtime ) ;
			$ret[ 'YMW_TITLE' ] = sprintf( _PICAL_FMT_YW , $this->year , $weekno ) ;
		} else {
			$week_number = floor( ( $this->date - ( $this->day - $this->week_start + 7 ) % 7 + 12 ) / 7 ) ;
			$ret[ 'YMW_TITLE' ] = sprintf( _PICAL_FMT_YMW , $this->year , $this->month_middle_names[ $this->month ] , $this->week_numbers[ $week_number ] ) ;
		}
		$ret[ 'YMD_TITLE' ] = sprintf( _PICAL_FMT_YMD , $this->year , $this->month_middle_names[ $this->month ] , $this->date_long_names[$date] ) ;
	}

	return $ret ;
}



// カレンダーの本体を返す（１ヶ月分）
function get_monthly_html( $get_target = '' , $query_string = '' )
{
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;
	// if( $get_target == '' ) $get_target = $PHP_SELF ;
	
	$this->load_whatday_plugins();

	// get the result of plugins
	$plugin_returns = array() ;
	if( strtolower( get_class( $this ) ) == 'pical_xoops' ) {
		$db =& Database::getInstance() ;
		(method_exists('MyTextSanitizer', 'sGetInstance') and $myts =& MyTextSanitizer::sGetInstance()) || $myts =& MyTextSanitizer::getInstance() ;
		$now = time() ;
		$just1gif = 0 ;

		$tzoffset_s2u = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
		$plugins = $this->get_plugins( "monthly" ) ;
		foreach( $plugins as $plugin ) {
			$plugin_fullpath = $this->base_path . '/' . $this->plugins_path_monthly . '/' . $plugin['file'] ;
			if( file_exists( $plugin_fullpath ) ) {
				include $plugin_fullpath ;
			}
		}
	}

	// 開始曜日が月曜日のための処理（なんとも場当たり的だが）
	$sunday_th = "<th class='sunday'>{$this->week_middle_names[0]}</th>\n" ;
	if( $this->week_start ) {
		$week_top_th = "" ;
		$week_end_th = $sunday_th ;
	} else {
		$week_top_th = $sunday_th ;
		$week_end_th = "" ;
	}

	$ret = "
	 <table id='calbody'>
	 <!-- week names -->
	 <tr class='week_header'>
	   $week_top_th
	   <th class='calweekname'>{$this->week_middle_names[1]}</th>
	   <th class='calweekname'>{$this->week_middle_names[2]}</th>
	   <th class='calweekname'>{$this->week_middle_names[3]}</th>
	   <th class='calweekname'>{$this->week_middle_names[4]}</th>
	   <th class='calweekname'>{$this->week_middle_names[5]}</th>
	   <th class='saturday'>{$this->week_middle_names[6]}</th>
	   $week_end_th
	 </tr>\n";

	$mtop_unixtime = mktime(0,0,0,$this->month,1,$this->year) ;
	$mtop_weekno = date( 'W' , $mtop_unixtime ) ;
	if( $mtop_weekno >= 52 ) $mtop_weekno = 1 ;
	$first_date = getdate( $mtop_unixtime ) ;
	$date = ( - $first_date['wday'] + $this->week_start - 7 ) % 7 ;
	$wday_end = 7 + $this->week_start ;
	$last_date = date( 't' , $this->unixtime ) ;
	$mlast_unixtime = mktime(0,0,0,$this->month+1,1,$this->year) ;

	// 時差を計算しつつ、WHERE節の期間に関する条件生成
	$tzoffset = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
	if( $tzoffset == 0 ) {
		// 時差がない場合 （MySQLに負荷をかけさせないため、ここで条件分けしとく)
		$whr_term = "start<='$mlast_unixtime' AND end>'$mtop_unixtime'" ;
	} else {
		// 時差がある場合は、alldayによって場合分け
		$whr_term = "(allday AND start<='$mlast_unixtime' AND end>'$mtop_unixtime') OR ( ! allday AND start<='".( $mlast_unixtime - $tzoffset )."' AND end>'".( $mtop_unixtime - $tzoffset )."')" ;
	}

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// 長期イベントのUnique-IDを最大4件、取得しておく
	$rs = $this->db->query( "SELECT DISTINCT unique_id FROM $this->table WHERE ($whr_term) AND ($whr_categories) AND ($whr_class) AND (allday & 2) LIMIT 4" ) ;
	$long_event_ids = array() ;
	$bit = 1 ;
	while( $event = $this->db->fetchArray( $rs ) ) {
		$long_event_ids[ $bit ] = $event['unique_id'] ;
		$bit ++ ;
	}

	// 一ヶ月分のスケジュールをまとめて取得しておく
	$yrs = $this->db->query( "SELECT start,end,summary,id,allday,admission,uid,unique_id,categories FROM $this->table WHERE ($whr_term) AND ($whr_categories) AND ($whr_class) ORDER BY start" ) ;
	$numrows_yrs = $this->db->getRowsNum( $yrs ) ;

	// カレンダーBODY部表示
	for( $week = 0 ; $week < 6 ; $week ++ ) {

		// 週表示のインデックス
		if( $date < $last_date ) {
			$alt_week = $this->week_numbering ? sprintf( _PICAL_FMT_WEEKNO , $week + $mtop_weekno ) : $this->week_numbers[$week+1] ;
			$week_index = "<div class='week_index'><a class='week_index' href='$get_target?cid=$this->now_cid&amp;smode=Weekly&amp;caldate="
			.date('Y-n-j',mktime(0,0,0,$this->month,$date+1,$this->year))
			."'><img src='$this->images_url/week_index.gif' alt='$alt_week' title='$alt_week' /></a></div>\n" ;
		} else {
			break ;
		}
		
		$ret .= "<tr>\n";

		for( $wday = $this->week_start ; $wday < $wday_end ; $wday ++ ) {
			$date ++;

			// 対象月の範囲外にある日の処理
			if( ! checkdate($this->month,$date,$this->year) ) {
				$ret .= "<td>$week_index</td>\n" ;
				$week_index="";
				continue ;
			}

			$now_unixtime = mktime(0,0,0,$this->month,$date,$this->year) ;
			$toptime_of_day = $now_unixtime + $this->day_start - $tzoffset ;
			$bottomtime_of_day = $toptime_of_day + 86400 ;
			$link = "$this->year-$this->month-$date" ;

			// スケジュールデータの表示ループ
			$waitings = 0 ;
			$event_str = "" ;
			$long_event = 0 ;
			if( $numrows_yrs > 0 ) $this->sql_data_seek( $yrs , 0 ) ;
			while( $event = $this->db->fetchArray( $yrs ) ) {
				$event = (object)$event;
				// 対象イベントがこの日にかかっているかどうかのチェック
				if( $event->allday ) {
					if( $event->start >= $now_unixtime + 86400 || $event->end <= $now_unixtime ) continue ;
				} else {
					if( $event->start >= $bottomtime_of_day || $event->start != $toptime_of_day && $event->end <= $toptime_of_day ) continue ;
					// ついでに開始当日・終了当日のチェックも
					// $event->is_start_date = $event->start >= $toptime_of_day ;
					// $event->is_end_date = $event->end <= $bottomtime_of_day ;
				}

				if( $event->admission ) {

					// サニタイズ
					$event->summary = $this->text_sanitizer_for_show( $event->summary ) ;
					// categories
					$catname = $this->text_sanitizer_for_show( $this->categories[ intval( $event->categories ) ]->cat_title ) ;
					// とりあえず半角33字を上限としておく
					$summary = mb_strcut( $event->summary , 0 , 33 ) ;
					if( $summary != $event->summary ) $summary .= ".." ;
					//$event_str_tmp = "&bull;&nbsp;<a href='$get_target?smode=Monthly&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' style='font-size:10px;font-weight:normal;text-decoration:none;' class='$catname'>$summary</a>" ;	//orginal 
					// データをリスト構造で出力させる。カテゴリ名をclassに挿入していたが、日本語利用の場合変になるので削除
					$event_str_tmp = "<li class='$catname'><a href='$get_target?smode=Monthly&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='$catname'>$summary</a></li>" ;	// marine mod 20130822 

					$bit = array_search( $event->unique_id , $long_event_ids ) ;
					// 本来は !== false とすべきだが、どうせ1〜4しか取らないので
					if( $bit > 0 && $bit <= 4 ) {
						// 長期イベント配列にあれば該当ビットを立て、legends配列に登録
						$long_event |= 1 << ( $bit - 1 ) ;
						$this->long_event_legends[ $bit ] = $event_str_tmp ;
					} else if( $event->allday & 4 ) {
						// 記念日フラグが立っていたら、$holiday_colorにして、一番上に持ってくる
						$event_str_tmp = str_replace( " style='" , " style='color:$this->holiday_color;" , $event_str_tmp ) ;
						$event_str = "$event_str_tmp<br />\n$event_str" ;
					} else {
						// なければ、日付マス内に描画
						$event_str .= $event_str_tmp  ;
					}
				} else {
					// 未承認スケジュールのカウントアップ
					if( $this->isadmin || ( $this->user_id > 0 AND $this->user_id == $event->uid ) ) $waitings ++ ;
				}
			}

			// 未承認スケジュールは総数だけ表示
			if( $waitings > 0 ) $event_str .= "<li><span style='color:#00FF00;font-size:10px;font-weight:normal;'>".sprintf( _PICAL_NTC_NUMBEROFNEEDADMIT , $waitings )."</span></li>\n" ;

			// drawing the result of plugins
			if( ! empty( $plugin_returns[ $date ] ) ) {
				foreach( $plugin_returns[ $date ] as $item ) {
					$event_str .= "<li><a href='{$item['link']}' class='event' style='background-image:url($this->images_url/{$item['dotgif']})'>{$item['title']}</a></li>\n" ;
				}
			}
			$event_str = "<ul class='event_info'>{$event_str}</ul>";


			// 曜日タイプによる描画色振り分け
			$date_part_append = '' ;
			if( isset( $this->holidays[$link] ) ) {
				//	Holiday
				$colorClass = "calday calday_holyday";
				$bgcolor = $this->holiday_bgcolor ;
				$color = $this->holiday_color ;
				if( $this->holidays[ $link ] != 1 ) {
					$date_part_append = "<p class='holiday'>{$this->holidays[ $link ]}</p>\n" ;
				}
			} elseif( $wday % 7 == 0 ) {
				//	Sunday
				$colorClass = "calday calday_sunday";
				$bgcolor = $this->sunday_bgcolor ;
				$color = $this->sunday_color ;
			} elseif( $wday == 6 ) {
				//	Saturday
				$colorClass = "calday calday_saturday";
				$bgcolor = $this->saturday_bgcolor ;
				$color = $this->saturday_color ;
			} else {
				// Weekday
				$colorClass = "calday calday_weekday";
				$bgcolor = $this->weekday_bgcolor ;
				$color = $this->weekday_color ;
			}

			// What Day
			if (is_array($this->whatday)) {
				foreach ($this->whatday as $_obj) {
					if ($whatday = $_obj->get_what_day($link)) {
						$class = $_obj->get_css_class('whatday');
						$date_part_append .= "<p class='{$class}'>{$whatday}</p>\n" ;
					}
				} 
			}

			// 選択日の背景色ハイライト処理
			if( $date == $this->date ) $bgcolor = $this->targetday_bgcolor ;

			// 長期イベントの描画（背景）
			if( $long_event ) {
				$background = "background:url($this->images_url/monthbar_0".dechex($long_event).".gif) top repeat-x $bgcolor;" ;
			} else
				$background = "background-color:$bgcolor;" ;

			// 予定の追加（鉛筆アイコン）
			if( $this->insertable )
				$insert_link = "<a href='$get_target?cid=$this->now_cid&amp;smode=Monthly&amp;action=Edit&amp;caldate=$link' class='stencil'>
				<img src='$this->images_url/addevent.gif' border='0' width='14' height='12' alt='"
				._PICAL_MB_ADDEVENT."' /></a>" ;
			else
				$insert_link = "<a href='$get_target?cid=$this->now_cid&amp;smode=Monthly&amp;caldate=$link' class='stencil'>
				<img src='$this->images_url/spacer.gif' alt='' border='0' width='14' height='12' /></a>" ;

			$ret .= "<td style='$background'>"
			.$week_index
			."<a href='$get_target?cid=$this->now_cid&amp;smode=Daily&amp;caldate=$link' class='$colorClass'>$date</a>"
			.$insert_link
			.$date_part_append
			.$event_str
			."</td>\n" ;
			$week_index="";
		}
		$ret .= "</tr>\n";
	}

	$ret .= "</table>\n";

	return $ret ;
}



// カレンダーの本体を返す（１週間分）
function get_weekly_html( )
{
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;
	$this->load_whatday_plugins();

	$ret = "
	 <table width='100%'>
	 \n" ;

	$wtop_date = $this->date - ( $this->day - $this->week_start + 7 ) % 7 ;
	$wtop_unixtime = mktime(0,0,0,$this->month,$wtop_date,$this->year) ;
	$wlast_unixtime = mktime(0,0,0,$this->month,$wtop_date+7,$this->year) ;

	// get the result of plugins
	$plugin_returns = array() ;
	if( strtolower( get_class( $this ) ) == 'pical_xoops' ) {
		$db =& Database::getInstance() ;
		(method_exists('MyTextSanitizer', 'sGetInstance') and $myts =& MyTextSanitizer::sGetInstance()) || $myts =& MyTextSanitizer::getInstance() ;
		$now = time() ;
		$just1gif = 0 ;

		$tzoffset_s2u = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
		$plugins = $this->get_plugins( "weekly" ) ;
		foreach( $plugins as $plugin ) {
			$include_ret = @include( $this->base_path . '/' . $this->plugins_path_weekly . '/' . $plugin['file'] ) ;
			if( $include_ret === false ) {
				// weekly emulator by monthly plugin
				$wtop_month = date( 'n' , $wtop_unixtime ) ;
				$wlast_month = date( 'n' , $wlast_unixtime - 86400 ) ;
				$year_backup = $this->year ;
				$month_backup = $this->month ;
				if( $wtop_month == $wlast_month ) {
					@include( $this->base_path . '/' . $this->plugins_path_monthly . '/' . $plugin['file'] ) ;
				} else {
					$plugin_returns_backup = $plugin_returns ;
					$this->year = date( 'Y' , $wtop_unixtime ) ;
					$this->month = $wtop_month ;
					@include( $this->base_path . '/' . $this->plugins_path_monthly . '/' . $plugin['file'] ) ;
					for( $d = 1 ; $d < 21 ; $d ++ ) {
						$plugin_returns[ $d ] = @$plugin_returns_backup[ $d ] ;
					}
					$plugin_returns_backup = $plugin_returns ;
					$this->year = date( 'Y' , $wlast_unixtime ) ;
					$this->month = $wlast_month ;
					@include( $this->base_path . '/' . $this->plugins_path_monthly . '/' . $plugin['file'] ) ;
					for( $d = 8 ; $d < 32 ; $d ++ ) {
						$plugin_returns[ $d ] = @$plugin_returns_backup[ $d ] ;
					}
					$this->year = $year_backup ;
					$this->month = $month_backup ;
				}
			}
		}
	}

	// 時差を計算しつつ、WHERE節の期間に関する条件生成
	$tzoffset = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
	if( $tzoffset == 0 ) {
		// 時差がない場合 （MySQLに負荷をかけさせないため、ここで条件分けしとく)
		$whr_term = "start<='$wlast_unixtime' AND end>'$wtop_unixtime'" ;
	} else {
		// 時差がある場合は、alldayによって場合分け
		$whr_term = "(allday AND start<='$wlast_unixtime' AND end>'$wtop_unixtime') OR ( ! allday AND start<='".( $wlast_unixtime - $tzoffset )."' AND end>'".( $wtop_unixtime - $tzoffset )."')" ;
	}

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// 一週間分のスケジュールをまとめて取得しておく
	$ars = $this->db->query( "SELECT start,end,summary,id,allday,admission,uid FROM $this->table WHERE admission>0 AND ($whr_term) AND ($whr_categories) AND ($whr_class) ORDER BY start" ) ;
	$numrows_ars = $this->db->getRowsNum( $ars ) ;
	$wrs = $this->db->query( "SELECT start,end,summary,id,allday,admission,uid FROM $this->table WHERE admission=0 AND ($whr_term) AND ($whr_categories) AND ($whr_class) ORDER BY start" ) ;
	$numrows_wrs = $this->db->getRowsNum( $wrs ) ;

	// カレンダーBODY部表示
	$now_date = $wtop_date ;
	$wday_end = 7 + $this->week_start ;
	for( $wday = $this->week_start ; $wday < $wday_end ; $wday ++ , $now_date ++ ) {

		$now_unixtime = mktime( 0 , 0 , 0 , $this->month , $now_date , $this->year ) ;
		$toptime_of_day = $now_unixtime + $this->day_start - $tzoffset ;
		$bottomtime_of_day = $toptime_of_day + 86400 ;
		$link = date( "Y-n-j" , $now_unixtime ) ;
		$date = date( "j" , $now_unixtime ) ;
		$disp = $this->get_middle_md( $now_unixtime ) ;
		$disp .= "<br />({$this->week_middle_names[$wday]})" ;
		$date_part_append = '' ;
		// スケジュール表示部のテーブル開始
		$event_str = "
				<ul class='data_detail'>
		\n" ;
/*
					} else if( $event->allday & 4 ) {
						// 記念日フラグが立っていたら、$holiday_colorにして、一番上に持ってくる
						$event_str_tmp = str_replace( " style='" , " style='color:$this->holiday_color;" , $event_str_tmp ) ;
						$event_str = "$event_str_tmp<br />\n$event_str" ;
*/


		// 承認済みスケジュールデータの表示ループ
		if( $numrows_ars > 0 ) $this->sql_data_seek( $ars , 0 ) ;
		while( $event = $this->db->fetchArray( $ars ) ) {
			$event = (object)$event;
			// 対象イベントがこの日にかかっているかどうかのチェック
			if( $event->allday ) {
				if( $event->start >= $now_unixtime + 86400 || $event->end <= $now_unixtime ) continue ;
			} else {
				if( $event->start >= $bottomtime_of_day || $event->start != $toptime_of_day && $event->end <= $toptime_of_day ) continue ;
				// ついでに開始当日・終了当日のチェックも
				$event->is_start_date = $event->start >= $toptime_of_day ;
				$event->is_end_date = $event->end <= $bottomtime_of_day ;
			}

			// サニタイズ
			$summary = $this->text_sanitizer_for_show( $event->summary ) ;

			if( $event->allday ) {
				if( $event->allday & 4 ) {
					// 記念日フラグの立っているもの
					$date_part_append .= "<p class='specialday'><a href='?cid=$this->now_cid&amp;smode=Weekly&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='cal_summary_specialday'><font color='$this->holiday_color'>$summary</font></a></p>\n" ;
					continue ;
				} else {
					// 通常の全日イベント
					$time_part = "             <img border='0' src='$this->images_url/dot_allday.gif' />" ;
					$summary_class = "calsummary_allday" ;
				}
			} else {
				// 通常イベント（時差計算あり）
				$time_part = $this->get_time_desc_for_a_day( $event , $tzoffset , $bottomtime_of_day - $this->day_start , true , true ) ;
				$summary_class = "calsummary" ;
			}

			$event_str .= "
				    <li><dl><dt>
				      $time_part
				    </dt>
				    <dd>
				      <a href='?cid=$this->now_cid&amp;smode=Weekly&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='$summary_class'>$summary</a>
				    </dd></dl></li>
			\n" ;
		}

		// 未承認スケジュールの表示ループ（uidが一致するゲスト以外のレコードのみ）
		if( $this->isadmin || $this->user_id > 0 ) {

			if( $numrows_wrs > 0 ) $this->sql_data_seek( $wrs , 0 ) ;
			while( $event = $this->db->fetchArray( $wrs ) ) {
				$event = (object)$event;
				// 対象イベントがこの日にかかっているかどうかのチェック
				if( $event->allday ) {
					if( $event->start >= $now_unixtime + 86400 || $event->end <= $now_unixtime ) continue ;
				} else {
					if( $event->start >= $bottomtime_of_day || $event->start != $toptime_of_day && $event->end <= $toptime_of_day ) continue ;
					// ついでに開始当日・終了当日のチェックも
					$event->is_start_date = $event->start >= $toptime_of_day ;
					$event->is_end_date = $event->end <= $bottomtime_of_day ;
				}

				// サニタイズ
				$summary = $this->text_sanitizer_for_show( $event->summary ) ;

				if( $event->allday ) {
					// 全日イベント（全日フラグがついていても、通常扱い）
					$time_part = "             <img border='0' src='$this->images_url/dot_notadmit.gif' />" ;
					$summary_class = "calsummary_allday" ;
				} else {
					// 通常イベント
					$time_part = $this->get_time_desc_for_a_day( $event , $tzoffset , $bottomtime_of_day - $this->day_start , true , false ) ;
					$summary_class = "calsummary" ;
				}

				$event_str .= "
					    <li><dl><dt>
					      $time_part
					    </dt>
					    <dd>
					      <a href='?cid=$this->now_cid&amp;smode=Weekly&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='$summary_class'><font color='#00FF00'>$summary ("._PICAL_MB_EVENT_NEEDADMIT.")</font></a>
					    </dd></dl></li>
				\n" ;
			}
		}

		// drawing the result of plugins
		if( ! empty( $plugin_returns[ $date ] ) ) {
			foreach( $plugin_returns[ $date ] as $item ) {
				$event_str .= "
				    <li><dl><dt></dt>
				    <dd><a href='{$item['link']}' class='$summary_class'><img src='$this->images_url/{$item['dotgif']}' alt='{$item['title']}>' />{$item['title']}</a>
				    </dd></dl></li>
				  \n" ;
			}
		}

		// 予定の追加（鉛筆アイコン）
		if( $this->insertable ) $event_str .= "
				    <li style='border:none;'>
				    <p  class='m_right s80' >
				      &nbsp; <a href='?cid=$this->now_cid&amp;smode=Weekly&amp;action=Edit&amp;caldate=$link'><img src='$this->images_url/addevent.gif' border='0' width='14' height='12' />"._PICAL_MB_ADDEVENT."</a>
				    </p>
				    </li>
		\n" ;

		// スケジュール表示部のテーブル終了
		$event_str .= "\t\t\t\t</ul>\n" ;

		// 曜日タイプによる描画色振り分け
		if( isset( $this->holidays[ $link ] ) ) {
			//	Holiday
			$bgcolor = $this->holiday_bgcolor ;
			$color = $this->holiday_color ;
			if( $this->holidays[ $link ] != 1 ) {
				$date_part_append .= "<p class='holiday'>{$this->holidays[ $link ]}</p>\n" ;
			}
		} elseif( $wday % 7 == 0 ) {
			//	Sunday
			$bgcolor = $this->sunday_bgcolor ;
			$color = $this->sunday_color ;
		} elseif( $wday == 6 ) {
			//	Saturday
			$bgcolor = $this->saturday_bgcolor ;
			$color = $this->saturday_color ;
		} else {
			// Weekday
			$bgcolor = $this->weekday_bgcolor ;
			$color = $this->weekday_color ;
		}

		// What Day
		if (is_array($this->whatday)) {
			foreach ($this->whatday as $_obj) {
				if ($whatday = $_obj->get_what_day($link)) {
					$class = $_obj->get_css_class('whatday');
					$date_part_append .= "<p class='{$class}'>{$whatday}</p>\n" ;
				}
			}
		}

		// 選択日の背景色ハイライト処理
		if( $link == $this->caldate ) $body_bgcolor = $this->targetday_bgcolor ;
		else $body_bgcolor = $bgcolor ;

		$ret .= "
	 <tr>
	   <td  class='data_week' bgcolor='$bgcolor' valign='middle' style='vertical-align:middle;text-align:center;$this->frame_css;background-color:$bgcolor'>
	     <a href='?cid=$this->now_cid&amp;smode=Daily&amp;caldate=$link' class='calbody'><font class='size3' color='$color'><b><span class='calbody'>$disp</span></b></font></a><br />
	     $date_part_append
	   </td>
	   <td  class='data_week_data' bgcolor='$body_bgcolor' style='$this->frame_css;background-color:$body_bgcolor'>
	     $event_str
	   </td>
	 </tr>\n" ;
	}

	$ret .= "\t </table>\n";

	return $ret ;
}



// カレンダーの本体を返す（１日分）
function get_daily_html( )
{
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;

	// get the result of plugins
	$plugin_returns = array() ;
	if( strtolower( get_class( $this ) ) == 'pical_xoops' ) {
		$db =& Database::getInstance() ;
		(method_exists('MyTextSanitizer', 'sGetInstance') and $myts =& MyTextSanitizer::sGetInstance()) || $myts =& MyTextSanitizer::getInstance() ;
		$now = time() ;
		$just1gif = 0 ;

		$tzoffset_s2u = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
		$plugins = $this->get_plugins( "daily" ) ;
		foreach( $plugins as $plugin ) {
			$include_ret = @include( $this->base_path . '/' . $this->plugins_path_daily . '/' . $plugin['file'] ) ;
			if( $include_ret === false ) {
				// daily emulator by monthly plugin
				@include( $this->base_path . '/' . $this->plugins_path_monthly . '/' . $plugin['file'] ) ;
			}
		}
	}

	list( $bgcolor , $color ) =  $this->daytype_to_colors( $this->daytype ) ;

	$ret = '';

	// 時差を計算しつつ、WHERE節の期間に関する条件生成
	$tzoffset = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
	$toptime_of_day = $this->unixtime + $this->day_start - $tzoffset ;
	$bottomtime_of_day = $toptime_of_day + 86400 ;
	$whr_term = "(allday AND start<='$this->unixtime' AND end>'$this->unixtime') OR ( ! allday AND start<'$bottomtime_of_day' AND (start='$toptime_of_day' OR end>'$toptime_of_day'))" ;

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// 当日のスケジュール取得・表示
	$yrs = $this->db->query( "SELECT start,end,summary,id,allday,admission,uid,description,(start>='$toptime_of_day') AS is_start_date,(end<='$bottomtime_of_day') AS is_end_date FROM $this->table WHERE admission>0 AND ($whr_term) AND ($whr_categories) AND ($whr_class) ORDER BY start,end" ) ;
	$num_rows = $this->db->getRowsNum( $yrs ) ;

	if( $num_rows == 0 ) $ret .= "<table><tr><td></td><td>"._PICAL_MB_NOEVENT."</td></tr>\n" ;
	else while( $event = $this->db->fetchArray( $yrs ) ) {
		$event = (object)$event;
		if( $event->allday ) {
			// 全日イベント（時差計算なし）
			$time_part = "             <img border='0' src='$this->images_url/dot_allday.gif' />" ;
		} else {
			// 通常イベント（時差計算あり）
			$time_part = $this->get_time_desc_for_a_day( $event , $tzoffset , $bottomtime_of_day - $this->day_start , true , true ) ;
		}

		// サニタイズ
		$description = $this->textarea_sanitizer_for_show( $event->description ) ;
		$summary = $this->text_sanitizer_for_show( $event->summary ) ;

		$summary_class = $event->allday ? "calsummary_allday" : "calsummary" ;

		$ret .= "
	       <table class='data_weekly'><tr>
	         <td class='data_time' valign='top'>
	           $time_part
	         </td>
	         <td vlalign='top'>
	           <h3 class='data_h3'><a href='?cid=$this->now_cid&amp;smode=Daily&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='$summary_class'>$summary</a></h3>
	           $description<br />
	           &nbsp;
	         </td>
	       </tr>\n" ;
	}

	// 未承認スケジュール取得・表示（uidが一致するゲスト以外のレコードのみ）
	if( $this->isadmin || $this->user_id > 0 ) {
	  $whr_uid = $this->isadmin ? "1" : "uid=$this->user_id " ;
	  $yrs = $this->db->query( "SELECT start,end,summary,id,allday,admission,uid,description,(start>='$toptime_of_day') AS is_start_date,(end<='$bottomtime_of_day') AS is_end_date FROM $this->table WHERE admission=0 AND $whr_uid AND ($whr_term) AND ($whr_categories) AND ($whr_class) ORDER BY start,end" ) ;

	  while( $event = $this->db->fetchArray( $yrs ) ) {
	  	$event = (object)$event;
		if( $event->allday ) {
			// 全日イベント
			$time_part = "             <img border='0' src='$this->images_url/dot_notadmit.gif' />" ;
		} else {
			// 通常イベント
			$time_part = $this->get_time_desc_for_a_day( $event , $tzoffset , $bottomtime_of_day - $this->day_start , true , false ) ;
		}

		// サニタイズ
		$summary = $this->text_sanitizer_for_show( $event->summary ) ;

		$summary_class = $event->allday ? "calsummary_allday" : "calsummary" ;

		$ret .= "
	       <tr>
	         <td class='data_time' valign='top'>
	           $time_part
	         </td>
	         <td vlalign='top'>
	           <h3 class='data_h3'><a href='?cid=$this->now_cid&amp;smode=Daily&amp;action=View&amp;event_id=$event->id&amp;caldate=$this->caldate' class='$summary_class'><font color='#00FF00'>$summary ("._PICAL_MB_EVENT_NEEDADMIT.")</font></a></h3>
	         </td>
	       </tr>\n" ;
	  }
	}

	// drawing the result of plugins
	if( ! empty( $plugin_returns[ $this->date ] ) ) {
		foreach( $plugin_returns[ $this->date ] as $item ) {
			$ret .= "
	       <tr>
	         <td></td>
	         <td valign='top'>
	           <h3 class='data_h3'><a href='{$item['link']}' class='$summary_class'><img src='$this->images_url/{$item['dotgif']}' alt='{$item['title']}>' />{$item['title']}</a></font></h3>
	           {$item['description']}<br />
	           &nbsp;
	         </td>
	       </tr>\n" ;
		}
	}

	// 予定の追加（鉛筆アイコン）
	if( $this->insertable ) {
		$ret .= "
	</table>
	<p class='m_right'> &nbsp; <a href='?cid=$this->now_cid&amp;smode=Daily&amp;action=Edit&amp;caldate=$this->caldate'><img src='$this->images_url/addevent.gif' border='0' width='14' height='12' />"._PICAL_MB_ADDEVENT."</a></p>\n";
	} else {
		$ret .= "
	</table>\n";
	}
	
	return $ret ;
}



/*******************************************************************/
/*        メイン部 （個別データ操作）                              */
/*******************************************************************/

// スケジュール詳細画面表示用文字列を返す
function get_schedule_view_html( $for_print = false )
{
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;
	$smode = empty( $_GET['smode'] ) ? 'Monthly' : preg_replace('/[^a-zA-Z0-9_-]/','',$_GET['smode']) ;
	$editable = $this->editable ;
	$deletable = $this->deletable ;

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// 予定データの取得
	if( empty( $_GET['event_id'] ) ) die( _PICAL_ERR_INVALID_EVENT_ID ) ;
	$this->original_id = $event_id = intval( $_GET['event_id'] ) ;
	$yrs = $this->db->query( "SELECT *,UNIX_TIMESTAMP(dtstamp) AS udtstamp FROM $this->table WHERE id='$event_id' AND ($whr_categories) AND ($whr_class)" ) ;
	if( $this->db->getRowsNum( $yrs ) < 1 ) die( _PICAL_ERR_INVALID_EVENT_ID ) ;
	$event = (object)$this->db->fetchArray( $yrs ) ;

	$this->event = $event ; // naao

	// rruleによって展開されたデータであれば、初回(親)のデータを取得
	if( trim( $event->rrule ) != '' ) {
		if( $event->rrule_pid != $event->id ) {
			$event->id = $event->rrule_pid ;
			$yrs = $this->db->query( "SELECT id,start,start_date FROM $this->table WHERE id='$event->rrule_pid' AND ($whr_categories) AND ($whr_class)" ) ;
			if( $this->db->getRowsNum( $yrs ) >= 1 ) {
				$event->id = $event->rrule_pid ;
				$parent_event = (object)$this->db->fetchArray( $yrs ) ;
				$this->original_id = $parent_event->id ;
				$is_extracted_record = true ;
			} else {
				$parent_event =& $event ;
			}
		}
		$rrule = $this->rrule_to_human_language( $event->rrule ) ;
	} else {
		$rrule = '' ;
	}

	// もともと編集可能の設定でも、閲覧中のuidとレコードのuidが
	// 一致せず、かつ、Adminモードでない時は、編集・削除不可とする
	if( $event->uid != $this->user_id && ! $this->isadmin ) {
		$editable = false ;
		$deletable = false ;
	}

	// 未承認レコードは、$editableでなければ、表示しない
	if( ! $event->admission && ! $editable ) die( _PICAL_ERR_NOPERM_TO_SHOW ) ;

	// 編集ボタン
	if( $editable && ! $for_print ) {
		$edit_button = "
			<form method='get' action='index.php' style='margin:0px;'>
				<input type='hidden' name='smode' value='$smode' />
				<input type='hidden' name='action' value='Edit' />
				<input type='hidden' name='event_id' value='$event->id' />
				<input type='hidden' name='caldate' value='$this->caldate' />
				<input class='btn' type='submit' value='"._PICAL_BTN_EDITEVENT."' />
			</form>\n" ;
	} else $edit_button = "" ;

	// 削除ボタン
	if( $deletable && ! $for_print ) {
		$delete_button = "
			<form method='post' action='index.php' name='MainForm' style='margin:0px;'>
				<input type='hidden' name='smode' value='$smode' />
				<input type='hidden' name='last_smode' value='$smode' />
				<input type='hidden' name='event_id' value='$event->id' />
				<input type='hidden' name='subevent_id' value='$event_id' />
				<input type='hidden' name='caldate' value='$this->caldate' />
				<input type='hidden' name='last_caldate' value='$this->caldate' />
				<input class='btn' type='submit' name='delete' value='"._PICAL_BTN_DELETE."' onclick='return confirm(\""._PICAL_CNFM_DELETE_YN."\")' />
				".( ! empty( $is_extracted_record ) ? "<input type='submit' name='delete_one' value='"._PICAL_BTN_DELETE_ONE."' onclick='return confirm(\""._PICAL_CNFM_DELETE_YN."\")' />" : "" )."
				".$GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ )."
			</form>\n" ;
	} else $delete_button = "" ;

	// iCalendar 出力ボタン
	if( $this->can_output_ics && ! $for_print ) {
		$php_self4disp = strtr( @$_SERVER['PHP_SELF'] , '<>\'"' , '    ' ) ;
		$ics_output_button = "
			<a href='?fmt=single&amp;event_id=$event->id&amp;output_ics=1' target='_blank'><img border='0' src='$this->images_url/output_ics_win.gif' alt='"._PICAL_BTN_OUTPUTICS_WIN."' title='"._PICAL_BTN_OUTPUTICS_WIN."' /></a>
			<a href='webcal://{$_SERVER['HTTP_HOST']}$php_self4disp?fmt=single&amp;event_id=$event->id&amp;output_ics=1' target='_blank'><img border='0' src='$this->images_url/output_ics_mac.gif' alt='"._PICAL_BTN_OUTPUTICS_MAC."' title='"._PICAL_BTN_OUTPUTICS_MAC."' /></a>\n" ;
	} else $ics_output_button = "" ;

	// 日付・時間表示の処理
	if( $event->allday ) {
		// 全日イベント（時差計算なし）
		$tzoffset = 0 ;
		$event->end -= 300 ;
		$start_time_str = "("._PICAL_MB_ALLDAY_EVENT.")" ;
		$end_time_str = "" ;
	} else {
		// 通常イベント（ユーザ時間への時差計算あり）
		$tzoffset = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
		$disp_user_tz = $this->get_tz_for_display( $this->user_TZ ) ;
		$start_time_str = $this->get_middle_hi( $event->start + $tzoffset ) . " $disp_user_tz" ;
		$end_time_str = $this->get_middle_hi( $event->end + $tzoffset ) . " $disp_user_tz" ;
		if( $this->user_TZ != $event->event_tz ) {
			$tzoffset_s2e = intval( ( $event->event_tz - $this->server_TZ ) * 3600 ) ;
			$disp_event_tz = $this->get_tz_for_display( $event->event_tz ) ;
			$start_time_str .= " &nbsp; &nbsp; <small>" . $this->get_middle_dhi( $event->start + $tzoffset_s2e ) . " $disp_event_tz</small>" ;
			$end_time_str .= " &nbsp; &nbsp; <small>" . $this->get_middle_dhi( $event->end + $tzoffset_s2e ) . " $disp_event_tz</small>" ;
		}
	}

	if( isset( $event->start_date ) ) {
		// out of unixtimestamp
		$start_date_str = $event->start_date ; // GIJ TODO
	} else {
		// inside unixtimestamp
		$start_date_str = $this->get_long_ymdn( $event->start + $tzoffset ) ;
	}
	if( isset( $event->end_date ) ) {
		// out of unixtimestamp
		$end_date_str = $event->end_date ; // GIJ TODO
	} else {
		// inside unixtimestamp
		$end_date_str = $this->get_long_ymdn( $event->end + $tzoffset ) ;
	}

	$start_datetime_str = "$start_date_str &nbsp; $start_time_str" ;
	$end_datetime_str = "$end_date_str &nbsp; $end_time_str" ;

	// 繰り返しで、かつ、初回(親)でないデータは、親へのリンクを作る
	if( trim( $event->rrule ) != '' ) {
		if( isset( $parent_event ) && $parent_event != $event ) {
			if( isset( $parent_event->start_date ) ) {
				$parent_date_str = $parent_event->start_date ; // GIJ TODO
			} else {
				$parent_date_str = $this->get_long_ymdn( $parent_event->start + $tzoffset ) ;
			}
			$rrule .= "<br /><a href='?action=View&amp;event_id=$parent_event->id' target='_blank'>"._PICAL_MB_LINK_TO_RRULE1ST. " $parent_date_str</a>" ;
		} else {
			$rrule .= '<br /> '._PICAL_MB_RRULE1ST ;
		}
	}

	// カテゴリーの表示
	$cat_titles4show = '' ;
	$cids = explode( "," , $event->categories ) ;
	foreach( $cids as $cid ) {
		$cid = intval( $cid ) ;
		if( isset( $this->categories[ $cid ] ) ) $cat_titles4show .= $this->text_sanitizer_for_show( $this->categories[ $cid ]->cat_title ) . "," ;
	}
	if( $cat_titles4show != '' ) $cat_titles4show = substr( $cat_titles4show , 0 , -1 ) ;

	// 投稿者の表示
	$submitter_info = $this->get_submitter_info( $event->uid ) ;

	// 公開・非公開およびその対象の前処理
	if( $event->class == 'PRIVATE' ) {
		$groupid = intval( $event->groupid ) ;
		if( $groupid == 0 ) $group = _PICAL_OPT_PRIVATEMYSELF ;
		else if( isset( $this->groups[ $groupid ] ) ) $group = sprintf( _PICAL_OPT_PRIVATEGROUP , $this->groups[ $groupid ] ) ;
		else $group = _PICAL_OPT_PRIVATEINVALID ;
		$class_status = _PICAL_MB_PRIVATE . sprintf( _PICAL_MB_PRIVATETARGET , $group ) ;
	} else {
		$class_status = _PICAL_MB_PUBLIC ;
	}

	// その他、表示用前処理
	$admission_status = $event->admission ? _PICAL_MB_EVENT_ADMITTED : _PICAL_MB_EVENT_NEEDADMIT ;
	$last_modified = $this->get_long_ymdn( $event->udtstamp - intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ) ;
	$description = $this->textarea_sanitizer_for_show( $event->description ) ;
	$summary = $this->text_sanitizer_for_show( $event->summary ) ;
	$location = $this->text_sanitizer_for_show( $event->location ) ;
	$contact = $this->text_sanitizer_for_show( $event->contact ) ;

	// 再利用用
	$this->last_summary = $summary ;

	// 表示部
	$ret = "
<div id='piCal_page'>
<h2>"._PICAL_MB_TITLE_EVENTINFO." <small>-"._PICAL_MB_SUBTITLE_EVENTDETAIL."-</small></h2>
	<table id='details' >
	<tr>
		<td class='head'>"._PICAL_TH_SUMMARY."</td>
		<td class='even'>$summary</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_STARTDATETIME."</td>
		<td class='even'>$start_datetime_str</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_ENDDATETIME."</td>
		<td class='even'>$end_datetime_str</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_LOCATION."</td>
		<td class='even'>$location</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_CONTACT."</td>
		<td class='even'>$contact</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_DESCRIPTION."</td>
		<td class='even'>$description</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_CATEGORIES."</td>
		<td class='even'>$cat_titles4show</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_SUBMITTER."</td>
		<td class='even'>$submitter_info</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_CLASS."</td>
		<td class='even'>$class_status</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_RRULE."</td>
		<td class='even'>$rrule</td>
	</tr>
	".($this->isadmin?"<tr>
		<td class='head'>"._PICAL_TH_ADMISSIONSTATUS."</td>
		<td class='even'>$admission_status</td>
	</tr>":"")."
	<tr>
		<td class='head'>"._PICAL_TH_LASTMODIFIED."</td>
		<td class='even'>$last_modified</td>
	</tr>
	</table>
			<div style='float:left; margin: 2px;'>$edit_button</div>
			<div style='float:left; margin: 2px;'>$delete_button</div>
			<div style='float:left; margin: 2px;'>$ics_output_button</div>
	</div>\n" ;

	// for meta discription // naao
	$this->event->start_datetime_str = $start_datetime_str ;
	$this->event->end_datetime_str = $end_datetime_str ;

	return $ret ;
}



// スケジュール編集用画面表示用文字列を返す
function get_schedule_edit_html( )
{
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;
	$editable = $this->editable ;
	$deletable = $this->deletable ;
	$smode = empty( $_GET['smode'] ) ? 'Monthly' : preg_replace('/[^a-zA-Z0-9_-]/','',$_GET['smode']) ;

	// 変更の場合、登録済スケジュール情報取得
	if( ! empty( $_GET[ 'event_id' ] ) ) {

		if( ! $this->editable ) die( "Not allowed" ) ;

		$event_id = intval( $_GET[ 'event_id' ] ) ;
		$yrs = $this->db->query( "SELECT * FROM $this->table WHERE id='$event_id'" ) ;
		if( $this->db->getRowsNum( $yrs ) < 1 ) die( _PICAL_ERR_INVALID_EVENT_ID ) ;
		$event = (object)$this->db->fetchArray( $yrs ) ;

		// もともと編集・削除可能の設定でも、閲覧中のuidとレコードのuidが
		// 一致せず、かつ、Adminモードでない時は、編集・削除不可とする
		if( $event->uid != $this->user_id && ! $this->isadmin ) {
			$editable = false ;
			$deletable = false ;
		}

		$description = $this->textarea_sanitizer_for_edit( $event->description ) ;
		$summary = $this->text_sanitizer_for_edit( $event->summary ) ;
		$location = $this->text_sanitizer_for_edit( $event->location ) ;
		$contact = $this->text_sanitizer_for_edit( $event->contact ) ;
		$categories = $event->categories ;
		if( $event->class == 'PRIVATE' ) {
			$class_private = "checked='checked'" ;
			$class_public = '' ;
			$select_private_disabled = '' ;
		} else {
			$class_private = '' ;
			$class_public = "checked='checked'" ;
			$select_private_disabled = "disabled='disabled'" ;
		}
		$groupid = $event->groupid ;
		$rrule = $event->rrule ;
		$admission_status = $event->admission ? _PICAL_MB_EVENT_ADMITTED : _PICAL_MB_EVENT_NEEDADMIT ;
		$update_button = $editable ? "<input class='btn' name='update' type='submit' value='"._PICAL_BTN_SUBMITCHANGES."' />" : "" ;
		$insert_button = "<input class='btn' name='saveas' type='submit' value='"._PICAL_BTN_SAVEAS."' onclick='return confirm(\""._PICAL_CNFM_SAVEAS_YN."\")' />" ;
		$delete_button = $deletable ? "<input class='btn' name='delete' type='submit' value='"._PICAL_BTN_DELETE."' onclick='return confirm(\""._PICAL_CNFM_DELETE_YN."\")' />" : "" ;
		$tz_options = $this->get_tz_options( $event->event_tz ) ;
		$poster_tz = $event->poster_tz ;

		// 日付・時間表示の処理
		if( $event->allday ) {
			// 全日イベント（時差計算なし）
			$select_timezone_disabled = "disabled='disabled'" ;
			$allday_checkbox = "checked='checked'" ;
			$allday_select = "disabled='disabled'" ;
			$allday_bit1 = ( $event->allday & 2 ) ? "checked='checked'" : "" ;
			$allday_bit2 = ( $event->allday & 4 ) ? "checked='checked'" : "" ;
			$allday_bit3 = ( $event->allday & 8 ) ? "checked='checked'" : "" ;
			$allday_bit4 = ( $event->allday & 16 ) ? "checked='checked'" : "" ;
			if( isset( $event->start_date ) ) {
				$start_ymd = $start_long_ymdn = $event->start_date ;
			} else {
				$start_ymd = date( "Y-m-d" , $event->start ) ;
				$start_long_ymdn = $this->get_long_ymdn( $event->start ) ;
			}
			$start_hour = 0 ;
			$start_min = 0 ;
			if( isset( $event->end_date ) ) {
				$end_ymd = $end_long_ymdn = $event->end_date ;
			} else {
				$end_ymd = date( "Y-m-d" , $event->end - 300 ) ;
				$end_long_ymdn = $this->get_long_ymdn( $event->end - 300 ) ;
			}
			$end_hour = 23 ;
			$end_min = 55 ;
		} else {
			// 通常イベント（event_tz での時間表示）
			$select_timezone_disabled = "" ;
			$tzoffset_s2e = intval( ( $event->event_tz - $this->server_TZ ) * 3600 ) ;
			$event->start += $tzoffset_s2e ;
			$event->end += $tzoffset_s2e ;
			$allday_checkbox = "" ;
			$allday_select = "" ;
			$allday_bit1 = $allday_bit2 = $allday_bit3 = $allday_bit4 = "" ;
			$start_ymd = date( "Y-m-d" , $event->start ) ;
			$start_long_ymdn = $this->get_long_ymdn( $event->start ) ;
			$start_hour = date( "H" , $event->start ) ;
			$start_min = date( "i" , $event->start ) ;
			$end_ymd = date( "Y-m-d" , $event->end ) ;
			$end_long_ymdn = $this->get_long_ymdn( $event->end ) ;
			$end_hour = date( "H" , $event->end ) ;
			$end_min = date( "i" , $event->end ) ;
		}

	// 新規登録の場合
	} else {

		if( ! $this->insertable ) die( "Not allowed" ) ;

		$event_id = 0 ;

		$editable = true ;
		$summary = '' ;
		$select_timezone_disabled = "" ;
		$location = '' ;
		$contact = '' ;
		$class_private = '' ;
		$class_public = "checked='checked'" ;
		$select_private_disabled = "disabled='disabled'" ;
		$groupid = 0 ;
		$rrule = '' ;
		$description = '' ;
		$categories = $this->now_cid > 0 ? sprintf( "%05d," , $this->now_cid ) : '' ;
		$start_ymd = $end_ymd = $this->caldate ;
		$start_long_ymdn = $end_long_ymdn = $this->get_long_ymdn( $this->unixtime ) ;
		$start_hour = 9 ;
		$start_min = 0 ;
		$end_hour = 17 ;
		$end_min = 0 ;
		$admission_status = _PICAL_MB_EVENT_NOTREGISTER ;
		$update_button = '' ;
		$insert_button = "<input class='btn' name='insert' type='submit' value='"._PICAL_BTN_NEWINSERTED."' />" ;
		$delete_button = '' ;
		$allday_checkbox = $allday_select = "" ;
		$allday_bit1 = $allday_bit2 = $allday_bit3 = $allday_bit4 = "" ;
		$tz_options = $this->get_tz_options( $this->user_TZ ) ;
		$poster_tz = $this->user_TZ ;
	}

	// Start Date
	$textbox_start_date = $this->get_formtextdateselect( 'StartDate' , $start_ymd , $start_long_ymdn ) ;

	// Start Hour
	$select_start_hour = "<select name='StartHour' $allday_select>\n" ;
	$select_start_hour .= $this->get_options_for_hour( $start_hour ) ;
	$select_start_hour .= "</select>" ;

	// Start Minutes
	$select_start_min = "<select name='StartMin' $allday_select>\n" ;
	for( $m = 0 ; $m < 60 ; $m += 5 ) {
		if( $m == $start_min ) $select_start_min .= "<option value='$m' selected='selected'>" . sprintf( "%02d" , $m ) . "</option>\n" ;
		else $select_start_min .= "<option value='$m'>" . sprintf( "%02d" , $m ) . "</option>\n" ;
	}
	$select_start_min .= "</select>" ;

	// End Date
	$textbox_end_date = $this->get_formtextdateselect( 'EndDate' , $end_ymd , $end_long_ymdn ) ;

	// End Hour
	$select_end_hour = "<select name='EndHour' $allday_select>\n" ;
	$select_end_hour .= $this->get_options_for_hour( $end_hour ) ;
	$select_end_hour .= "</select>" ;

	// End Minutes
	$select_end_min = "<select name='EndMin' $allday_select>\n" ;
	for( $m = 0 ; $m < 60 ; $m += 5 ) {
		if( $m == $end_min ) $select_end_min .= "<option value='$m' selected='selected'>" . sprintf( "%02d" , $m ) . "</option>\n" ;
		else $select_end_min .= "<option value='$m'>" . sprintf( "%02d" , $m ) . "</option>\n" ;
	}
	$select_end_min .= "</select>" ;

	// Checkbox for selecting Categories
	$category_checkboxes = '' ;
	foreach( $this->categories as $cid => $cat ) {
		$cid4sql = sprintf( "%05d," , $cid ) ;
		$cat_title4show = $this->text_sanitizer_for_show( $cat->cat_title ) ;
		if( $cat->cat_depth < 2 ) {
			$category_checkboxes .= "<div style='float:left; margin:2px;'>\n" ;
		}
		$category_checkboxes .= str_repeat( '-' , $cat->cat_depth - 1 ) . "<input type='checkbox' name='cids[]' value='$cid' ".(strstr($categories,$cid4sql)?"checked='checked'":"")." />$cat_title4show<br />\n" ;
	}
	$category_checkboxes = substr( str_replace( '<div' , '</div><div' , $category_checkboxes ) , 6 ) . "</div>\n" ;

	// target for "class = PRIVATE"
	$select_private = "<select name='groupid' $select_private_disabled>\n<option value='0'>"._PICAL_OPT_PRIVATEMYSELF."</option>\n" ;
	foreach( $this->groups as $sys_gid => $gname ) {
		$option_desc = sprintf( _PICAL_OPT_PRIVATEGROUP , $gname ) ;
		if( $sys_gid == $groupid ) $select_private .= "<option value='$sys_gid' selected='selected'>$option_desc</option>\n" ;
		else $select_private .= "<option value='$sys_gid'>$option_desc</option>\n" ;
	}
	$select_private .= "</select>" ;

	// XOOPS用かどうかでの処理分け
	if( defined( 'XOOPS_ROOT_PATH' ) ) {

		// DHTMLテキストエリアの処理
		if ( defined('LEGACY_BASE_VERSION') && version_compare(LEGACY_BASE_VERSION, '2.2.2.1', '>=') ) {
			include_once XOOPS_ROOT_PATH . '/class/xoopsform/formelement.php';
			include_once XOOPS_ROOT_PATH . '/class/xoopsform/formdhtmltextarea.php';
			$ele = new XoopsFormDhtmlTextArea('', 'description_text', $description, 6, 50);
			$ele->setEditor('BBCode');
			$description_textarea = $ele->render();
		} else {
			include_once( XOOPS_ROOT_PATH . "/include/xoopscodes.php" ) ;
			ob_start();
			$GLOBALS["description_text"] = $description;
			xoopsCodeTarea("description_text",50,6);
			$description_textarea = ob_get_contents();
			ob_end_clean();
		}

	} else {
		// XOOPS以外では、単なるプレーンtextare
		$description_textarea = "<textarea name='description' cols='50' rows='6' wrap='soft'>$description</textarea>" ;
	}

	// FORM DISPLAY
	$ret = "
<h2>"._PICAL_MB_TITLE_EVENTINFO." <small>-"._PICAL_MB_SUBTITLE_EVENTEDIT."-</small></h2>
<form action='index.php' method='post' name='MainForm'>
	".$GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ )."
	<input type='hidden' name='caldate' value='$this->caldate' />
	<input type='hidden' name='event_id' value='$event_id' />
	<input type='hidden' name='last_smode' value='$smode' />
	<input type='hidden' name='last_caldate' value='$this->caldate' />
	<input type='hidden' name='poster_tz' value='$poster_tz' />
	<table class='piCal_input'>
	<tr>
		<td class='head'>"._PICAL_TH_SUMMARY."</td>
		<td class='even pi_text'><input type='text' name='summary' size='60' maxlength='250' value='$summary' /></td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_STARTDATETIME."</td>
		<td class='even pi_st'>
			$textbox_start_date &nbsp;
			{$select_start_hour} {$select_start_min}"._PICAL_MB_MINUTE_SUF."
</select>
		</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_ENDDATETIME."</td>
		<td class='even pi_et'>
			$textbox_end_date &nbsp;
			{$select_end_hour} {$select_end_min}"._PICAL_MB_MINUTE_SUF."
		</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_ALLDAYOPTIONS."</td>
		<td class='even pi_op'>
			<fieldset>
				<legend class='blockTitle'><input type='checkbox' name='allday' value='1' $allday_checkbox onClick='document.MainForm.StartHour.disabled=document.MainForm.StartMin.disabled=document.MainForm.EndHour.disabled=document.MainForm.EndMin.disabled=this.checked' />"._PICAL_MB_ALLDAY_EVENT."</legend>
				<input type='checkbox' name='allday_bits[]' id='allday_bits_1' value='1' {$allday_bit1} onClick='document.MainForm.allday.checked=(this.checked||document.MainForm.allday_bits_2.checked)' />"._PICAL_MB_LONG_EVENT." &nbsp;  <input type='checkbox' name='allday_bits[]' id='allday_bits_2' value='2' {$allday_bit2} onClick='document.MainForm.allday.checked=(this.checked||document.MainForm.allday_bits_1.checked)' />"._PICAL_MB_LONG_SPECIALDAY." &nbsp;  <!-- <input type='checkbox' name='allday_bits[]' value='3' {$allday_bit3} onClick='document.MainForm.allday.checked=this.checked' />rsv3 &nbsp;  <input type='checkbox' name='allday_bits[]' value='4' {$allday_bit4} onClick='document.MainForm.allday.checked=this.checked' />rsv4 -->
			</fieldset>
		</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_LOCATION."</td>
		<td class='even pi_location'><input type='text' name='location' size='40' maxlength='250' value='$location' /></td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_CONTACT."</td>
		<td class='even pi_contact'><input type='text' name='contact' size='50' maxlength='250' value='$contact' /></td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_DESCRIPTION."</td>
		<td class='even pi_description'>$description_textarea</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_CATEGORIES."</td>
		<td class='even pi_cat'>$category_checkboxes</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_CLASS."</td>
		<td class='even pi_th'><input type='radio' name='class' value='PUBLIC' $class_public onClick='document.MainForm.groupid.disabled=true' />"._PICAL_MB_PUBLIC." &nbsp;  &nbsp; <input type='radio' name='class' value='PRIVATE' $class_private onClick='document.MainForm.groupid.disabled=false' />"._PICAL_MB_PRIVATE.sprintf( _PICAL_MB_PRIVATETARGET , $select_private )."</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_RRULE."</td>
		<td class='even pi_rule'>" . $this->rrule_to_form( $rrule , $end_ymd ) . "</td>
	</tr>
	<tr>
		<td class='head'>"._PICAL_TH_ADMISSIONSTATUS."</td>
		<td class='even pi_ad'>$admission_status</td>
	</tr>\n" ;

	if( $editable ) {
	$ret .= "
	<tr>
		<td style='text-align:center' colspan='2'>
			<input class='btn' name='reset' type='reset' value='"._PICAL_BTN_RESET."' />
			$update_button
			$insert_button
			$delete_button
		</td>
	</tr>\n" ;
	}

	$ret .= "
	<tr>
		<td><img src='$this->images_url/spacer.gif' alt='' width='150' height='4' /></td>		<td width='100%'></td>
	</tr>
	</table>
</form>
\n" ;

	return $ret ;
}




// スケジュールの更新および新規登録
function update_schedule( $set_sql_append = '' , $whr_sql_append = '' , $notify_callback = null )
{
	// debugモードで Location が効かなくなるのを防ぐ
//	error_reporting( 0 ) ;

	// $_SERVER 変数の取得
	// $PHP_SELF = $_SERVER['SCRIPT_NAME'] ;

	// summaryのチェック（未記入ならその旨を追加）
	if( $_POST[ 'summary' ] == "" ) $_POST[ 'summary' ] = _PICAL_MB_NOSUBJECT ;

	// 日付の前処理（無効な日付ならcaldateにセット）
	list( $start , $start_date , $use_default ) = $this->parse_posted_date( $this->mb_convert_kana( $_POST[ 'StartDate' ] , "a" ) , $this->unixtime ) ;
	list( $end , $end_date , $use_default ) = $this->parse_posted_date( $this->mb_convert_kana( $_POST[ 'EndDate' ] , "a" ) , $this->unixtime ) ;

	// allday 属性のビットを立てる
	$allday = 1 ;
	if( isset( $_POST[ 'allday_bits' ] ) ) {
		$_POST[ 'allday' ] = 1;
		$bits = $_POST[ 'allday_bits' ] ;
		if( is_array( $bits ) ) foreach( $bits as $bit ) {
			if( $bit > 0 && $bit < 8 ) {
				$allday += pow( 2 , intval( $bit ) ) ;
			}
		}
	}

	if( $start_date || $end_date ) {
		// 1970以前、2038年以降の日付がからんだ特殊な全日イベント
		if( $start_date ) $date_append = ", start_date='$start_date'" ;
		else $date_append = ", start_date=null" ;
		if( $end_date ) $date_append .= ", end_date='$end_date'" ;
		else {
			$date_append .= ", end_date=null" ;
			$end += 86400 ;
		}
		$set_sql_date = "start='$start', end='$end', allday='$allday' $date_append" ;
		$allday_flag = true ;
	} else if( ! empty( $_POST[ 'allday' ] ) ) {
		// 全日イベント（時差計算なし）
		if( $start > $end ) list( $start , $end ) = array( $end , $start ) ;
		$end += 86400 ;		// 終了時間は、終了した翌日0:00を指す
		$set_sql_date = "start='$start', end='$end', allday='$allday', start_date=null, end_date=null" ;
		$allday_flag = true ;
	} else {
		// 通常イベント（時差計算あり）

		// Timezone の処理（ここのみ、イベント時間からサーバ時間への変換）
		if( ! isset( $_POST['event_tz'] ) ) $_POST['event_tz'] = $this->user_TZ ;
		$tzoffset_e2s = intval( ( $this->server_TZ - $_POST['event_tz'] ) * 3600 ) ;
		//$tzoffset_e2s = intval( date( 'Z' , $start ) - $_POST['event_tz'] * 3600 ) ;

		$start += $_POST[ 'StartHour' ] * 3600 + $_POST[ 'StartMin' ] * 60 + $tzoffset_e2s ;
		$end += $_POST[ 'EndHour' ] * 3600 + $_POST[ 'EndMin' ] * 60 + $tzoffset_e2s ;
		if( $start > $end ) list( $start , $end ) = array( $end , $start ) ;
		$set_sql_date = "start='$start', end='$end', allday=0, start_date=null, end_date=null" ;
		$allday_flag = false ;
	}

	// サーバTZを記録
	$set_sql_date .= ",server_tz='$this->server_TZ'" ;

	// description のXOOPS用前処理 (露骨なツギハギで、あまり格好良くないけど……)
	if( ! isset( $_POST[ 'description' ] ) && isset( $_POST[ 'description_text' ] ) ) {
		$_POST[ 'description' ] = $_POST[ 'description_text' ] ;
	}

	// カテゴリーの処理
	$_POST[ 'categories' ] = '' ;
	$cids = is_array( @$_POST['cids'] ) ? $_POST['cids'] : array() ;
	foreach( $cids as $cid ) {
		$cid = intval( $cid ) ;
		while( isset( $this->categories[ $cid ] ) ) {
			$cid4sql = sprintf( "%05d," , $cid ) ;
			if( stristr( $_POST[ 'categories' ] , $cid4sql ) === false ) {
				$_POST[ 'categories' ] .= sprintf( "%05d," , $cid ) ;
			}
			$cid = intval( $this->categories[ $cid ]->pid ) ;
		}
	}

	// RRULEの取得
	$rrule = $this->rrule_from_post( $start , $allday_flag ) ;

	// 更新対象カラム設定
	$cols = array( "summary" => "255:J:1" , "location" => "255:J:0" , "contact" => "255:J:0" , "description" => "A:J:0" , "categories" => "255:E:0" , "class" => "255:E:0" , "groupid" => "I:N:0" , "poster_tz" => "F:N:0" , "event_tz" => "F:N:0" ) ;

	$set_str = $this->get_sql_set( $cols ) . ", $set_sql_date $set_sql_append" ;

	// event_idをPOSTから取得して、有効そうならUPDATE、無効ならINSERTを試みる
	$event_id = intval( $_POST[ 'event_id' ] ) ;
	if( $event_id > 0 ) {
		// 更新処理

		// まずは、rrule_pidを取得し、有効なidなら、同じrrule_pidを持つ
		// 他レコードを削除
		$rs = $this->db->query( "SELECT rrule_pid FROM $this->table WHERE id='$event_id' $whr_sql_append" ) ;
		if( ! ( $event = (object)$this->db->fetchArray( $rs ) ) ) die( "Record Not Exists." ) ;
		if( $event->rrule_pid > 0 ) {
			if( ! $this->db->query( "DELETE FROM $this->table WHERE rrule_pid='$event->rrule_pid' AND id<>'$event_id'" ) ) echo $this->db->error() ;
		}

		// 対象レコードのUPDATE処理
		if( $rrule != '' ) $set_str .= ", rrule_pid=id" ;
		$sql = "UPDATE $this->table SET $set_str , rrule='$rrule' , sequence=sequence+1 WHERE id='$event_id' $whr_sql_append" ;
		if( ! $this->db->query( $sql ) ) echo $this->db->error() ;

		// RRULEから、子レコードを展開
		if( $rrule != '' ) {
			$this->rrule_extract( $event_id ) ;
		}

		// すべてを更新後、新しい日付のカレンダーをリロード
		$last_smode = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_POST['last_smode'] ) ;
		//$last_caldate = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_POST['last_caldate'] ) ;
		$new_caldate = $start_date ? $start_date : date( 'Y-n-j' , $start ) ;
		$this->redirect( "smode=$last_smode&caldate=$new_caldate" ) ;

	} else {
		// 新規登録処理

		// 初回(親)レコードのINSERT処理
		$sql = "INSERT INTO $this->table SET $set_str , rrule='$rrule' , sequence=0" ;
		if( ! $this->db->query( $sql ) ) echo $this->db->error() ;
		// 親レコードへ unique_id,rrule_pid の計算と登録
		$event_id = $this->db->getInsertId() ;
		$unique_id = 'pical060-' . md5( "{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}$event_id") ;
		$rrule_pid = $rrule ? $event_id : 0 ;
		$this->db->query( "UPDATE $this->table SET unique_id='$unique_id',rrule_pid='$rrule_pid' WHERE id='$event_id'" ) ;

		// RRULEから、子レコードを展開
		if( $rrule != '' ) {
			$this->rrule_extract( $event_id ) ;
		}

		if( isset( $notify_callback ) ) $this->$notify_callback( $event_id ) ;

		// すべてを登録後、start日 のカレンダーをリロード
		$last_smode = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_POST['last_smode'] ) ;
		$last_caldate = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_POST['last_caldate'] ) ;
		$this->redirect( "smode=$last_smode&caldate=$last_caldate" ) ;

	}
}



// スケジュールの削除（RRULE付きなら親からすべて）
function delete_schedule( $whr_sql_append = '' , $eval_after = null )
{
	// debugモードで Location が効かなくなるのを防ぐ
	// error_reporting( 0 ) ;

	if( ! empty( $_POST[ 'event_id' ] ) ) {

		$event_id = intval( $_POST[ 'event_id' ] ) ;

		// まずは、rrule_pidを取得し、有効なidなら、同じrrule_pidを持つ
		// 全レコードを削除
		$rs = $this->db->query( "SELECT rrule_pid FROM $this->table WHERE id='$event_id' $whr_sql_append" ) ;
		if( ! ( $event = (object)$this->db->fetchArray( $rs ) ) ) die( "Record Not Exists." ) ;
		if( $event->rrule_pid > 0 ) {
			if( ! $this->db->query( "DELETE FROM $this->table WHERE rrule_pid='$event->rrule_pid' $whr_sql_append" ) ) echo $this->db->error() ;
			// 削除成功後の追加処理をevalで受ける (XOOPSでは、コメントの削除）
			if( $this->db->getAffectedRows() > 0 && isset( $eval_after ) ) {
				$id = $event->rrule_pid ;
				eval( $eval_after ) ;
			}
		} else {
			if( ! $this->db->query( "DELETE FROM $this->table WHERE id='$event_id' $whr_sql_append" ) ) echo $this->db->error() ;
			// 削除成功後の追加処理をevalで受ける (XOOPSでは、コメントの削除）
			if( $this->db->getAffectedRows() == 1 && isset( $eval_after ) ) {
				$id = $event_id ;
				eval( $eval_after ) ;
			}
		}

	}
	$last_smode = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_POST['last_smode'] ) ;
	$last_caldate = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_POST['last_caldate'] ) ;
	$this->redirect( "smode=$last_smode&caldate=$last_caldate" ) ;
}



// スケジュールの一件削除（RRULEの子供レコード）
function delete_schedule_one( $whr_sql_append = '' )
{
	if( ! empty( $_POST[ 'subevent_id' ] ) ) {

		$event_id = intval( $_POST[ 'subevent_id' ] ) ;

		if( ! $this->db->query( "DELETE FROM $this->table WHERE id='$event_id' AND rrule_pid <> id $whr_sql_append" ) ) echo $this->db->error() ;

	}
	$last_smode = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_POST['last_smode'] ) ;
	$last_caldate = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_POST['last_caldate'] ) ;
	$this->redirect( "smode=$last_smode&caldate=$last_caldate" ) ;
}



/*******************************************************************/
/*        小物関数                                                 */
/*******************************************************************/

// リダイレクトする
function redirect( $query )
{
	// character white list and black list against 'javascript'
	if( ! preg_match( '/^[a-z0-9=&_-]*$/i' , $query )  || stristr( $query , 'javascript' ) ) {
		header( strtr( "Location: $this->connection://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}" , "\r\n\0" , "   " ) ) ;
		exit ;
	}

	if( headers_sent() ) {
		echo "
			<html>
			<head>
			<title>redirection</title>
			<meta http-equiv='Refresh' content='0; url=?$query' />
			</head>
			<body>
			<p>
				<a href='?$query'>push here if not redirected</a>
			</p>
			</body>
			</html>";
	} else {
		header( strtr( "Location: $this->connection://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?$query" , "\r\n\0" , "   " ) ) ;
	}
	exit ;
}


// -12.0〜12.0までの値を受けて、(GMT+HH:MM) という文字列を返す
//function get_tz_for_display( $offset )
//{
//	return "(GMT" . ( $offset >= 0 ? "+" : "-" ) . sprintf( "%02d:%02d" , abs( $offset ) , abs( $offset ) * 60 % 60 ) . ")" ;
//}
function get_tz_for_display( $offset )
{
	return "" ;
}


// -12.0〜12.0までのTimzone SELECTボックス用Option文字列を返す
function get_tz_options( $selected = 0 )
{
	$tzs = array( '-12','-11','-10','-9','-8','-7','-6',
		'-5','-4','-3.5','-3','-2','-1',
		'0','1','2','3','3.5','4','4.5','5','5.5',
		'6','7','8','9','9.5','10','11','12') ;

	$ret = '' ;
	foreach( $tzs as $tz ) {
		if( $tz == $selected ) $ret .= "\t<option value='$tz' selected='selected'>".$this->get_tz_for_display( $tz )."</option>\n" ;
		else $ret .= "\t<option value='$tz'>".$this->get_tz_for_display( $tz )."</option>\n" ;
	}

	return $ret ;
}


// -12.0〜12.0までの値を受けて、array(TZOFFSET,TZID)を返す
function get_timezone_desc( $tz )
{
	if( $tz == 0 ) {
		$tzoffset = "+0000" ;
		$tzid = "GMT" ;
	} else if( $tz > 0 ) {
		$tzoffset = sprintf( "+%02d%02d" , $tz , $tz * 60 % 60 ) ;
		$tzid = "Etc/GMT-" . sprintf( "%d" , $tz ) ;
	} else {
		$tz = abs( $tz ) ;
		$tzoffset = sprintf( "-%02d%02d" , $tz , $tz * 60 % 60 ) ;
		$tzid = "Etc/GMT+" . sprintf( "%d" , $tz ) ;
	}

	return array( $tzoffset , $tzid ) ;
}


// カテゴリー選択文字ボックスをフォームごと作成する
function get_categories_selform( $get_target = '' , $smode = null )
{
	if( empty( $this->categories ) ) return '' ;

	if( empty( $smode ) ) $smode = isset( $_GET['smode'] ) ? $_GET['smode'] : '' ;
	$smode = preg_replace('/[^a-zA-Z0-9_-]/','',$smode) ;

	$op = empty( $_GET['op'] ) ? '' : preg_replace('/[^a-zA-Z0-9_-]/','',$_GET['op']) ;

	$ret = "<form action='$get_target' method='GET'>\n" ;
	$ret .= "<input type='hidden' name='caldate' value='$this->caldate' />\n" ;
	$ret .= "<input type='hidden' name='smode' value='$smode' />\n" ;
	$ret .= "<input type='hidden' name='op' value='$op' />\n" ;
	$ret .= "<select name='cid' onchange='submit();'>\n" ;
	$ret .= "\t<option value='0'>"._PICAL_MB_SHOWALLCAT."</option>\n" ;
	foreach( $this->categories as $cid => $cat ) {
		$selected = $this->now_cid == $cid ? "selected='selected'" : "" ;
		$depth_desc = str_repeat( '-' , intval( $cat->cat_depth ) ) ;
		$cat_title4show = $this->text_sanitizer_for_show( $cat->cat_title ) ;
		$ret .= "\t<option value='$cid' $selected>$depth_desc $cat_title4show</option>\n" ;
	}
	$ret .= "</select>\n</form>\n" ;

	return $ret ;
}


// 年月日のテキストボックス入力を受けて、UnixTimestampを返す
function parse_posted_date( $date_desc , $default_unixtime )
{
//HACK by domifara for php5.3+
//	if( ! ereg( "^([0-9][0-9]+)[-./]?([0-1]?[0-9])[-./]?([0-3]?[0-9])$" , $date_desc , $regs ) ) {
	if( ! preg_match( "/^([0-9][0-9]+)[-\.\/]?([0-1]?[0-9])[-\.\/]?([0-3]?[0-9])$/" , $date_desc , $regs ) ) {
		$unixtime = $default_unixtime ;
		$use_default = true ;
		$iso_date = '' ;
	} else if( $regs[1] >= 2038 ) {
		// 2038年以降の場合 2038/1/1 にセット
		$unixtime = mktime( 0 , 0 , 0 , 1 , 1 , 2038 ) ;
		$use_default = false ;
		$iso_date = "{$regs[1]}-{$regs[2]}-{$regs[3]}" ;
	} else if( $regs[1] <= 1970 ) {
		// 1970年以前の場合 1970/12/31にセット
		$unixtime = mktime( 0 , 0 , 0 , 12 , 31 , 1970 ) ;
		$use_default = false ;
		$iso_date = "{$regs[1]}-{$regs[2]}-{$regs[3]}" ;
	} else if( ! checkdate( $regs[2] , $regs[3] , $regs[1] ) ) {
		$unixtime = $default_unixtime ;
		$use_default = true ;
		$iso_date = '' ;
	} else {
		$unixtime = mktime( 0 , 0 , 0 , $regs[2] , $regs[3] , $regs[1] ) ;
		$use_default = false ;
		$iso_date = '' ;
	}

	return array( $unixtime , $iso_date , $use_default ) ;
}


// timezone配列を受けて、RFC2445のVTIMEZONE用文字列を返す
function get_vtimezones_str( $timezones )
{
	if( empty( $timezones ) ) {

		return
"BEGIN:VTIMEZONE\r
TZID:GMT\r
BEGIN:STANDARD\r
DTSTART:19390101T000000\r
TZOFFSETFROM:+0000\r
TZOFFSETTO:+0000\r
TZNAME:GMT\r
END:STANDARD\r
END:VTIMEZONE\r\n" ;

	} else {

		$ret = "" ;
		foreach( $timezones as $tz => $dummy ) {

			list( $for_tzoffset , $for_tzid ) = $this->get_timezone_desc( $tz ) ;

			$ret .=
"BEGIN:VTIMEZONE\r
TZID:$for_tzid\r
BEGIN:STANDARD\r
DTSTART:19390101T000000\r
TZOFFSETFROM:$for_tzoffset\r
TZOFFSETTO:$for_tzoffset\r
TZNAME:$for_tzid\r
END:STANDARD\r
END:VTIMEZONE\r\n" ;

		}
		return $ret ;
	}
}


// 連想配列を引数に取り、$_POSTからINSERT,UPDATE用のSET文を生成するクラス関数
function get_sql_set( $cols )
{
	$ret = "" ;

	foreach( $cols as $col => $types ) {

		list( $field , $lang , $essential ) = explode( ':' , $types ) ;

		// 未定義なら''と見なす
		if( ! isset( $_POST[ $col ] ) ) $data = '' ;
		else if( get_magic_quotes_gpc() ) $data = stripslashes( $_POST[ $col ] ) ;
		else $data = $_POST[ $col ] ;

		// 必須フィールドのチェック
		if( $essential && $data === '' ) {
			die( sprintf( _PICAL_ERR_LACKINDISPITEM , $col ) ) ;
		}

		// 言語・数字などの別による処理
		switch( $lang ) {
			case 'N' :	// 数値 (桁取りの , を取る)
				$data = intval( str_replace( "," , "" , $data ) ) ;
				break ;
			case 'J' :	// 日本語テキスト (半角カナ→全角かな)
				$data = $this->mb_convert_kana( $data , "KV" ) ;
				break ;
			case 'E' :	// 半角英数字のみ
				$data = $this->mb_convert_kana( $data , "as" ) ;
				break ;
		}

		// フィールドの型による処理
		switch( $field ) {
			case 'A' :	// textarea
				$ret .= "$col='".addslashes($data)."'," ;
				break ;
			case 'I' :	// integer
				$data = intval( $data ) ;
				$ret .= "$col='$data'," ;
				break ;
			case 'F' :	// float
				$data = doubleval( $data ) ;
				$ret .= "$col='$data'," ;
				break ;
			default :	// varchar(デフォルト)は数値による文字数指定
				if( $field < 1 ) $field = 255 ;
				$data = mb_strcut( $data , 0 , $field ) ;
				$ret .= "$col='".addslashes($data)."'," ;
		}
	}

	// 最後の , を削除
	$ret = substr( $ret , 0 , -1 ) ;

	return $ret ;
}



// unixtimestampから、現在の言語で表現された長い表記の YMDN を得る
function get_long_ymdn( $time )
{
	return sprintf(
		_PICAL_FMT_YMDN , // format
		date( 'Y' , $time ) , // Y
		$this->month_long_names[ date( 'n' , $time ) ] , // M
		$this->date_long_names[ date( 'j' , $time ) ] , // D
		$this->week_long_names[ date( 'w' , $time ) ] // N
	) ;
}



// unixtimestampから、現在の言語で表現された標準長表記の MD を得る
function get_middle_md( $time )
{
	return sprintf(
		_PICAL_FMT_MD , // format
		$this->month_middle_names[ date( 'n' , $time ) ] , // M
		$this->date_short_names[ date( 'j' , $time ) ] // D
	) ;
}



// unixtimestampから、現在の言語で表現された DHI を得る
function get_middle_dhi( $time , $is_over24 = false )
{
	$hour_offset = $is_over24 ? 24 : 0 ;

	$hour4disp = $this->use24 ? $this->hour_names_24[ date( 'G' , $time ) + $hour_offset ] : $this->hour_names_12[ date( 'G' , $time ) + $hour_offset ] ;

	return sprintf(
		_PICAL_FMT_DHI ,
		$this->date_short_names[ date( 'j' , $time ) ] , // D
		$hour4disp , // H
		date( _PICAL_DTFMT_MINUTE , $time ) // I
	) ;
}



// unixtimestampから、現在の言語で表現された HI を得る
function get_middle_hi( $time , $is_over24 = false )
{
	$hour_offset = $is_over24 ? 24 : 0 ;

	$hour4disp = $this->use24 ? $this->hour_names_24[ date( 'G' , $time ) + $hour_offset ] : $this->hour_names_12[ date( 'G' , $time ) + $hour_offset ] ;

	return sprintf(
		_PICAL_FMT_HI ,
		$hour4disp , // H
		date( _PICAL_DTFMT_MINUTE , $time ) // I
	) ;
}



// Make <option>s for selecting "HOUR" (default_hour must be 0-23)
function get_options_for_hour( $default_hour = 0 )
{
	$ret = '' ;
	for( $h = 0 ; $h < 24 ; $h ++ ) {
		$ret .= $h == $default_hour ? "<option value='$h' selected='selected'>" : "<option value='$h'>" ;
		$ret .= $this->use24 ? $this->hour_names_24[ $h ] : $this->hour_names_12[ $h ] ;
		$ret .= "</option>\n" ;
	}
	return $ret ;
}



// unixtimestampから、ある時間(timestamp形式)以降の予定日時の文字列を得る
function get_coming_time_description( $start , $now , $admission = true )
{
	// 承認の有無によってドットGIFを替える
	if( $admission ) $dot = "" ;
	else $dot = "<img border='0' src='$this->images_url/dot_notadmit.gif' />" ;

	if( $start >= $now && $start - $now < 86400 ) {
		// 24時間以内のイベント
		if( ! $dot ) $dot = "<img border='0' src='$this->images_url/dot_today.gif' />" ;
		$ret = "$dot <b>" . $this->get_middle_hi( $start ) . "</b>"._PICAL_MB_TIMESEPARATOR ;
	} else if( $start < $now ) {
		// すでに開始されたイベント
		if( ! $dot ) $dot = "<img border='0' src='$this->images_url/dot_started.gif' />" ;
		$ret = "$dot "._PICAL_MB_CONTINUING ;
	} else {
		// 翌日以降に開始になるイベント
		if( ! $dot ) $dot = "<img border='0' src='$this->images_url/dot_future.gif' />" ;
//		$ret = "$dot " . date( "n/j H:i" , $start ) . _PICAL_MB_TIMESEPARATOR ;
		$ret = "$dot " . $this->get_middle_md( $start ) . " " . $this->get_middle_hi( $start ) . _PICAL_MB_TIMESEPARATOR ;
	}

	return $ret ;
}



// ２つのunixtimestampから、ある日(Y-n-j形式)の予定時間の文字列を得る（既にゴミ）
function get_todays_time_description( $start , $end , $ynj , $justify = true , $admission = true , $is_start_date = null , $is_end_date = null , $border_for_2400 = null )
{
	if( ! isset( $is_start_date ) ) $is_start_date = ( date( "Y-n-j" , $start ) == $ynj ) ;
	if( ! isset( $is_end_date ) ) $is_end_date = ( date( "Y-n-j" , $end ) == $ynj ) ;
	if( ! isset( $border_for_2400 ) ) $this->unixtime - intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) + 86400 ;

	// $day_start 指定がある時の、24:00以降の処理
	if( $is_start_date && $start > $border_for_2400 ) {
		$start_desc = $this->get_middle_hi( $start , true ) ;
	} else $start_desc = $this->get_middle_hi( $start ) ;

	if( $is_end_date && $end > $border_for_2400 ) {
		$end_desc = $this->get_middle_hi( $end , true ) ;
	} else $end_desc = $this->get_middle_hi( $end ) ;

	$stuffing = $justify ? '     ' : '' ;

	// 予定時間指定の有無・承認の有無によってドットGIFを替える
	if( $admission ) {
		if( $is_start_date ) $dot = "<img border='0' src='$this->images_url/dot_startday.gif' />" ;
		else if( $is_end_date ) $dot = "<img border='0' src='$this->images_url/dot_endday.gif' />" ;
		else $dot = "<img border='0' src='$this->images_url/dot_interimday.gif' />" ;
	} else $dot = "<img border='0' src='$this->images_url/dot_notadmit.gif' />" ;

	if( $is_start_date ) {
		if( $is_end_date ) $ret = "$dot {$start_desc}"._PICAL_MB_TIMESEPARATOR."{$end_desc}" ;
		else $ret = "$dot {$start_desc}"._PICAL_MB_TIMESEPARATOR."{$stuffing}" ;
	} else {
		if( $is_end_date ) $ret = "$dot {$stuffing}"._PICAL_MB_TIMESEPARATOR."{$end_desc}" ;
		else $ret = "$dot "._PICAL_MB_CONTINUING ;
	}

	return $ret ;
}


// $eventクエリ結果から、ある日の予定時間の文字列を得る（通常イベントのみ）
function get_time_desc_for_a_day( $event , $tzoffset , $border_for_2400 , $justify = true , $admission = true )
{
	$start = $event->start + $tzoffset ;
	$end = $event->end + $tzoffset ;

	// $day_start 指定がある時の、24:00以降の処理
	if( $event->is_start_date && $event->start >= $border_for_2400 ) {
		$start_desc = $this->get_middle_hi( $start , true ) ;
	} else $start_desc = $this->get_middle_hi( $start ) ;

	if( $event->is_end_date && $event->end >= $border_for_2400 ) {
		$end_desc = $this->get_middle_hi( $end , true ) ;
	} else $end_desc = $this->get_middle_hi( $end ) ;

	$stuffing = $justify ? '     ' : '' ;

	// 予定時間指定の有無・承認の有無によってドットGIFを替える
	if( $admission ) {
		if( $event->is_start_date ) $dot = "<img border='0' src='$this->images_url/dot_startday.gif' />" ;
		else if( $event->is_end_date ) $dot = "<img border='0' src='$this->images_url/dot_endday.gif' />" ;
		else $dot = "<img border='0' src='$this->images_url/dot_interimday.gif' />" ;
	} else $dot = "<img border='0' src='$this->images_url/dot_notadmit.gif' />" ;

	if( $event->is_start_date ) {
		if( $event->is_end_date ) $ret = "$dot {$start_desc}"._PICAL_MB_TIMESEPARATOR."{$end_desc}" ;
		else $ret = "$dot {$start_desc}"._PICAL_MB_TIMESEPARATOR."{$stuffing}" ;
	} else {
		if( $event->is_end_date ) $ret = "$dot {$stuffing}"._PICAL_MB_TIMESEPARATOR."{$end_desc}" ;
		else $ret = "$dot "._PICAL_MB_CONTINUING ;
	}

	return $ret ;
}


// 日付入力ボックスの関数 (JavaScriptで入力する際のOverride対象)

function get_formtextdateselect( $name , $value )
{
	return "<input type='text' name='$name' size='12' value='$value' style='ime-mode:disabled' />" ;
}



// $this->images_url下にあるstyle.cssを読み込み、サニタイズして引き渡す
function get_embed_css( )
{
	$css_filename = "$this->images_path/style.css" ;
	if( ! is_readable( $css_filename ) ) return "" ;
	else return strip_tags( join( "" , file( $css_filename ) ) ) ;
}



// 投稿者の表示文字列を返す (Override対象)
function get_submitter_info( $uid )
{
	return '' ;
}



// カテゴリ関係のWHERE用条件を生成
function get_where_about_categories()
{
	if( $this->isadmin ) {
		if( empty( $this->now_cid ) ) {
			// 閲覧者が管理者で$cid指定がなければ常にTrue
			return "1" ;
		} else {
			// 閲覧者が管理者で$cid指定があれば、そこだけLIKE指定
			return "categories LIKE '%".sprintf("%05d,",$this->now_cid)."%'" ;
		}
	} else {
		if( empty( $this->now_cid ) ) {
			// 閲覧者が管理者以外で$cid指定がなければ、CAT2GROUPによる制限
			$limit_from_perm = "categories='' OR " ;
			foreach( $this->categories as $cid => $cat ) {
				$limit_from_perm .= "categories LIKE '%".sprintf("%05d,",$cid)."%' OR " ;
			}
			$limit_from_perm = substr( $limit_from_perm , 0 , -3 ) ;
			return $limit_from_perm ;
		} else {
			// 閲覧者が管理者以外で$cid指定があれば、権限チェックして$cid指定
			if( isset( $this->categories[ $this->now_cid ] ) ) {
				return "categories LIKE '%".sprintf("%05d,",$this->now_cid)."%'" ;
			} else {
				// 指定されたcidが権限にない
				return '0' ;
			}
		}
	}
}



// CLASS(公開・非公開)関係のWHERE用条件を生成
function get_where_about_class()
{
	if( $this->isadmin ) {
		// 閲覧者が管理者なら常にTrue
		return "1" ;
	} else if( $this->user_id <= 0 ) {
		// 閲覧者がゲストなら公開(PUBLIC)レコードのみ
		return "class='PUBLIC'" ;
	} else {
		// 通常ユーザなら、PUBLICレコードか、ユーザIDが一致するレコード、または、所属しているグループIDのうちの一つがレコードのグループIDと一致するレコード
		$ids = ' ' ;
		foreach( $this->groups as $id => $name ) {
			$ids .= "$id," ;
		}
		$ids = substr( $ids , 0 , -1 ) ;
		if( intval( $ids ) == 0 ) $group_section = '' ;
		else $group_section = "OR groupid IN ($ids)" ;
		return "(class='PUBLIC' OR uid=$this->user_id $group_section)" ;
	}
}



// mb_convert_kanaの処理
function mb_convert_kana( $str , $option )
{
	// convert_kana の処理は、日本語でのみ行う
	if( $this->language != 'japanese' || ! function_exists( 'mb_convert_kana' ) ) {
		return $str ;
	} else {
		return mb_convert_kana( $str , $option ) ;
	}
}



/*******************************************************************/
/*   サニタイズ関連の関数 (サブクラスを作成する時のOverride対象)   */
/*******************************************************************/

function textarea_sanitizer_for_show( $data )
{
	return nl2br( htmlspecialchars( $data , ENT_QUOTES ) ) ;
}

function text_sanitizer_for_show( $data )
{
	return htmlspecialchars( $data , ENT_QUOTES ) ;
}

function textarea_sanitizer_for_edit( $data )
{
	return htmlspecialchars( $data , ENT_QUOTES ) ;
}

function text_sanitizer_for_edit( $data )
{
	return htmlspecialchars( $data , ENT_QUOTES ) ;
}

function textarea_sanitizer_for_export_ics( $data )
{
	return $data ;
}


/*******************************************************************/
/*        iCalendar 処理関数                                       */
/*******************************************************************/

// iCalendar形式でのバッチ出力プラットフォーム選択用フォームを返す
// $_POST['ids']で指定
function output_ics_confirm( $post_target , $target = '_self' )
{
	// POSTで受け取ったid配列を、event_ids配列としてPOSTする
	$hiddens = "" ;
	foreach( $_POST[ 'ids' ] as $id ) {
		$id = intval( $id ) ;
		$hiddens .= "<input type='hidden' name='event_ids[]' value='$id' />\n" ;
	}
	// webcalリンク生成
	$webcal_url = str_replace( 'http://' , 'webcal://' , $post_target ) ;
	// 確認フォームを返す
	return "
	<div>&nbsp;<br /><b>"._PICAL_MB_ICALSELECTPLATFORM."</b><br />&nbsp;</div>
	<table>
	<tr>
	<td align='right' width='50%'>
	<form action='$post_target?output_ics=1' method='post' target='$target'>
		$hiddens
		<input type='submit' name='do_output' value='"._PICAL_BTN_OUTPUTICS_WIN."' />
	</form>
	</td>
	<td align='left' width='50%'>
	<form action='$webcal_url?output_ics=1' method='post' target='$target'>
		$hiddens
		<input type='submit' name='do_output' value='"._PICAL_BTN_OUTPUTICS_MAC."' />
	</form>
	</td>
	</tr>
	</table><br /><br />\n" ;
}


// iCalendar形式での出力 (mbstring必須)
// 出力が一件のみの場合は$_GET['event_id']、配列の場合は$_POST['event_ids']
function output_ics( )
{
	// $event_id が指定されていなければ終了
	if( empty( $_GET[ 'event_id' ] ) && empty( $_POST[ 'event_ids' ] ) ) die( _PICAL_ERR_INVALID_EVENT_ID ) ;

	// iCalendar出力許可がなければ終了
	if( ! $this->can_output_ics ) die( _PICAL_ERR_NOPERM_TO_OUTPUTICS ) ;
	if( isset( $_GET[ 'event_id' ] ) ) {
		// $_GET[ 'event_id' ] による一件だけの指定の場合
		$event_id = intval( $_GET['event_id'] ) ;
		$event_ids = array( $event_id ) ;
		$rs = $this->db->query( "SELECT summary AS udtstmp FROM $this->table WHERE id='$event_id'" ) ;
		if( $this->db->getRowsNum( $rs ) < 1 ) die( _PICAL_ERR_INVALID_EVENT_ID ) ;
		$summary = mysql_result( $rs , 0 , 0 ) ;
		// 件名 を X-WR-CALNAME とする
		$x_wr_calname = $summary ;
		// ファイル名に使えなさそうな文字は削る
		if( function_exists( "mb_ereg_replace" ) ) {
			$summary = mb_ereg_replace( '[<>|"?*,:;\\/]' , '' , $summary ) ;
		} else {
//HACK by domifara for php5.3+
//			$summary = ereg_replace( '[<>|"?*,:;\\/]' , '' , $summary ) ;
			$summary = preg_replace( '/[<>|"?*,:;\\/]/' , '' , $summary ) ;
		}
		// 禁止文字を削った件名.ics をファイル名とする (要SJIS変換)
		$output_filename = mb_convert_encoding( $summary , "SJIS" ) . '.ics' ;
	} else if( is_array( $_POST[ 'event_ids' ] ) ) {
		// $_POST[ 'event_ids' ] による配列による指定の場合
		$event_ids = array_unique( $_POST[ 'event_ids' ] ) ;
		// events-生成日時(GMT) を X-WR-CALNAME とする
		$x_wr_calname = 'events-' . gmdate( 'Ymd\THis\Z' ) ;
		// events-生成日時.ics をファイル名とする
		$output_filename = $x_wr_calname . '.ics' ;
	} else die( _PICAL_ERR_INVALID_EVENT_ID ) ;

	// HTTPヘッダ出力
	header("Content-type: text/calendar");
	header("Content-Disposition: attachment; filename=$output_filename" );
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
	header("Pragma: public");

	// iCalendarヘッダ
	$ical_header = "BEGIN:VCALENDAR\r
CALSCALE:GREGORIAN\r
X-WR-TIMEZONE;VALUE=TEXT:GMT\r
PRODID:PEAK Corporation - piCal -\r
X-WR-CALNAME;VALUE=TEXT:$x_wr_calname\r
VERSION:2.0\r
METHOD:PUBLISH\r\n" ;

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// イベント毎のループ
	$vevents_str = "" ;
	$timezones = array() ;
	foreach( $event_ids as $event_id ) {

		$event_id = intval( $event_id ) ;
		$sql = "SELECT *,UNIX_TIMESTAMP(dtstamp) AS udtstmp,DATE_ADD(end_date,INTERVAL 1 DAY) AS end_date_offseted FROM $this->table WHERE id='$event_id' AND ($whr_categories) AND ($whr_class)" ;
		if( ! $rs = $this->db->query( $sql ) ) echo $this->db->error() ;
		$event = (object)$this->db->fetchArray( $rs ) ;
		if( ! $event ) continue ;

		if( isset( $event->start_date ) ) {
			// 1970以前、2038年以降の日付がからんだ特殊な全日イベント
			$dtstart = str_replace( '-' , '' , $event->start_date ) ;
			if( isset( $event->end_date_offseted ) ) {
				$dtend = str_replace( '-' , '' , $event->end_date_offseted ) ;
			} else {
				$dtend = date( 'Ymd' , $event->end ) ;
			}
			$dtstart_opt = $dtend_opt = ";VALUE=DATE" ;
		} else if( $event->allday ) {
			// 全日イベント（時差処理なし）
			$dtstart = date( 'Ymd' , $event->start ) ;
			if( isset( $event->end_date_offseted ) ) {
				$dtend = str_replace( '-' , '' , $event->end_date_offseted ) ;
			} else {
				$dtend = date( 'Ymd' , $event->end ) ;
			}
			// 開始と終了が同日の場合は、終了を１日後ろにずらす
			if( $dtstart == $dtend ) $dtend = date( 'Ymd' , $event->end + 86400 ) ;
			$dtstart_opt = $dtend_opt = ";VALUE=DATE" ;
		} else {
			if( $event->rrule ) {
				// 通常イベントでRRULEがあれば、イベントTZで出力
				$tzoffset = intval( ( $this->server_TZ - $event->event_tz ) * 3600 ) ;
				list( , $tzid ) = $this->get_timezone_desc( $event->event_tz ) ;
				$dtstart = date( 'Ymd\THis' , $event->start - $tzoffset ) ;
				$dtend = date( 'Ymd\THis' , $event->end - $tzoffset ) ;
				$dtstart_opt = $dtend_opt = ";TZID=$tzid" ;
				// さらに、そのVTIMEZONEも出力
				$timezones[$event->event_tz] = 1 ;
			} else {
				// 通常イベントでRRULEが無ければ、サーバの時差処理だけしてGMT表現
				$tzoffset = $this->server_TZ * 3600 ;
				$dtstart = date( 'Ymd\THis\Z' , $event->start - $tzoffset ) ;
				$dtend = date( 'Ymd\THis\Z' , $event->end - $tzoffset ) ;
				$dtstart_opt = $dtend_opt = "" ;
			}
		}

		// DTSTAMPは常にGMT
		$dtstamp = date( 'Ymd\THis\Z' , $event->udtstmp - $this->server_TZ * 3600 ) ;

		// DESCRIPTIONの folding , \r削除 および \n -> \\n 変換, サニタイズ
		// (folding 未実装) TODO
		$description = str_replace( "\r" , '' , $event->description ) ;
		$description = str_replace( "\n" , '\n' , $description ) ;
		$description = $this->textarea_sanitizer_for_export_ics( $description ) ;

		// カテゴリーの表示
		$categories = '' ;
		$cids = explode( "," , $event->categories ) ;
		foreach( $cids as $cid ) {
			$cid = intval( $cid ) ;
			if( isset( $this->categories[ $cid ] ) ) $categories .= $this->categories[ $cid ]->cat_title . "," ;
		}
		if( $categories != '' ) $categories = substr( $categories , 0 , -1 ) ;

		// RRULE行は、RRULEの中身がある時だけ出力
		$rrule_line = $event->rrule ? "RRULE:{$event->rrule}\r\n" : "" ;

		// イベントデータの出力
		$vevents_str .= "BEGIN:VEVENT\r
DTSTART{$dtstart_opt}:{$dtstart}\r
DTEND{$dtend_opt}:{$dtend}\r
LOCATION:{$event->location}\r
TRANSP:OPAQUE\r
SEQUENCE:{$event->sequence}\r
UID:{$event->unique_id}\r
DTSTAMP:{$dtstamp}\r
CATEGORIES:{$categories}\r
DESCRIPTION:{$description}\r
SUMMARY:{$event->summary}\r
{$rrule_line}PRIORITY:{$event->priority}\r
CLASS:{$event->class}\r
END:VEVENT\r\n" ;

	}

	// VTIMEZONE
	$vtimezones_str = $this->get_vtimezones_str( $timezones ) ;

	// iCalendarフッタ
	$ical_footer = "END:VCALENDAR\r\n" ;

	$ical_data = "$ical_header$vtimezones_str$vevents_str$ical_footer" ;

	// mbstring がある場合のみ、UTF-8 への変換
	if( extension_loaded( 'mbstring' ) ) {
		mb_http_output( "pass" ) ;
		$ical_data = mb_convert_encoding( $ical_data , "UTF-8" ) ;
	}

	echo $ical_data ;

	exit ;
}



function import_ics_via_fopen( $uri , $force_http = true , $user_uri = '' )
{
	if( strlen( $uri ) < 5 ) return "-1:" ;
	$user_uri = empty( $user_uri ) ? '' : $uri ;
	// webcal://* も connection未指定も、すべて http://* に統一
	$uri = str_replace( "webcal://" , "http://" , $uri ) ;

	if( $force_http ) {
		if( substr( $uri , 0 , 7 ) != 'http://' ) $uri = "http://" . $uri ;
	}

	// iCal parser による処理
	include_once "$this->base_path/class/iCal_parser.php" ;
	$ical = new iCal_parser() ;
	$ical->language = $this->language ;
	$ical->timezone = ( $this->server_TZ >= 0 ? "+" : "-" ) . sprintf( "%02d%02d" , abs( $this->server_TZ ) , abs( $this->server_TZ ) * 60 % 60 ) ;
	list( $ret_code , $message , $filename ) = explode( ":" , $ical->parse( $uri , $user_uri ) , 3 ) ;
	if( $ret_code != 0 ) {
		// パース失敗なら-1とエラーメッセージを返す
		return "-1: $message : $filename" ;
	}
	$setsqls = $ical->output_setsqls() ;

	$count = 0 ;
	foreach( $setsqls as $setsql ) {
		$sql = "INSERT INTO $this->table SET $setsql,admission=1,uid=$this->user_id,poster_tz='$this->user_TZ',server_tz='$this->server_TZ'" ;

		if( ! $this->db->query( $sql ) ) die( $this->db->error() ) ;
		$this->update_record_after_import( $this->db->getInsertId() ) ;

		$count ++ ;
	}

	return "$count: $message:" ;
}



function import_ics_via_upload( $userfile )
{
	// icsファイルをクライアントマシンからアップロードして読込み
	include_once "$this->base_path/class/iCal_parser.php" ;
	$ical = new iCal_parser() ;
	$ical->language = $this->language ;
	$ical->timezone = ( $this->server_TZ >= 0 ? "+" : "-" ) . sprintf( "%02d%02d" , abs( $this->server_TZ ) , abs( $this->server_TZ ) * 60 % 60 ) ;
	list( $ret_code , $message , $filename ) = explode( ":" , $ical->parse( $_FILES[ $userfile ][ 'tmp_name' ] , $_FILES[ $userfile ][ 'name' ] ) , 3 ) ;
	if( $ret_code != 0 ) {
		// パース失敗なら-1とエラーメッセージを返す
		return "-1: $message : $filename" ;
	}
	$setsqls = $ical->output_setsqls() ;

	$count = 0 ;
	foreach( $setsqls as $setsql ) {
		$sql = "INSERT INTO $this->table SET $setsql,admission=1,uid=$this->user_id,poster_tz='$this->user_TZ',server_tz='$this->server_TZ'" ;

		if( ! $this->db->query( $sql ) ) die( $this->db->error() ) ;
		$this->update_record_after_import( $this->db->getInsertId() ) ;

		$count ++ ;
	}

	return "$count: $message :" ;
}



// １レコードを読み込み後に行う処理 （rruleの展開、categoriesのcid化など）
function update_record_after_import( $event_id )
{
	$rs = $this->db->query( "SELECT categories,rrule FROM $this->table WHERE id='$event_id'" ) ;
	$event = (object)$this->db->fetchArray( $rs ) ;

	// categories の cid化 ( '\,' -> ',' はOutlook対策)
	$event->categories = str_replace( '\,' , ',' , $event->categories ) ;
	$cat_names = explode( ',' , $event->categories ) ;
	for( $i = 0 ; $i < sizeof( $cat_names ) ; $i ++ ) {
		$cat_names[ $i ] = trim( $cat_names[ $i ] ) ;
	}
	$categories = '' ;
	foreach( $this->categories as $cid => $cat ) {
		if( in_array( $cat->cat_title , $cat_names ) ) {
			$categories .= sprintf( "%05d," , $cid ) ;
		}
	}

	// rrule_pid の処理
	$rrule_pid = $event->rrule ? $event_id : 0 ;

	// レコード更新
	$this->db->query( "UPDATE $this->table SET categories='$categories',rrule_pid='$rrule_pid' WHERE id='$event_id'" ) ;

	// RRULEから、子レコードを展開
	if( $event->rrule != '' ) {
		$this->rrule_extract( $event_id ) ;
	}

	// GIJ TODO category の自動登録 class,groupid の処理
}


/*******************************************************************/
/*        RRULE 処理関数                                           */
/*******************************************************************/

// rruleを自然言語に翻訳するクラス関数
function rrule_to_human_language( $rrule )
{
	$rrule = trim( $rrule ) ;
	if( $rrule == '' ) return '' ;

	// rrule の各要素を変数に展開
	$rrule = strtoupper( $rrule ) ;
//HACK by domifara for php5.3+
//	$rules = split( ';' , $rrule ) ;
	$rules = explode( ';' , $rrule ) ;
	foreach( $rules as $rule ) {
		list( $key , $val ) = explode( '=' , $rule , 2 ) ;
		$key = trim( $key ) ;
		$$key = trim( $val ) ;
	}

	if( empty( $FREQ ) ) $FREQ = 'DAILY' ;
	if( empty( $INTERVAL ) || $INTERVAL <= 0 ) $INTERVAL = 1 ;

	// 頻度条件解析
	$ret_freq = '' ;
	$ret_day = '' ;
	switch( $FREQ ) {
		case 'DAILY' :
			if( $INTERVAL == 1 ) $ret_freq = _PICAL_RR_EVERYDAY ;
			else $ret_freq = sprintf( _PICAL_RR_PERDAY , $INTERVAL ) ;
			break ;
		case 'WEEKLY' :
			if( empty( $BYDAY ) ) break ;	// BYDAY 必須
			$ret_day = strtr( $BYDAY , $this->byday2langday_w ) ;
			if( $INTERVAL == 1 ) $ret_freq = _PICAL_RR_EVERYWEEK ;
			else $ret_freq = sprintf( _PICAL_RR_PERWEEK , $INTERVAL ) ;
			break ;
		case 'MONTHLY' :
			if( isset( $BYMONTHDAY ) ) {
				$ret_day = "" ;
				$monthdays = explode( ',' , $BYMONTHDAY ) ;
				foreach( $monthdays as $monthday ) {
					$ret_day .= $this->date_long_names[ $monthday ] . "," ;
				}
				$ret_day = substr( $ret_day , 0 , -1 ) ;
			} else if( isset( $BYDAY ) ) {
				$ret_day = strtr( $BYDAY , $this->byday2langday_m ) ;
			} else {
				break ;		// BYDAY または BYMONTHDAY 必須
			}
			if( $INTERVAL == 1 ) $ret_freq = _PICAL_RR_EVERYMONTH ;
			else $ret_freq = sprintf( _PICAL_RR_PERMONTH , $INTERVAL ) ;
			break ;
		case 'YEARLY' :
			$ret_day = "" ;
			if( ! empty( $BYMONTH ) ) {
				$months = explode( ',' , $BYMONTH ) ;
				foreach( $months as $month ) {
					$ret_day .= $this->month_long_names[ $month ] . "," ;
				}
				$ret_day = substr( $ret_day , 0 , -1 ) ;
			}
			if( isset( $BYDAY ) ) {
				$ret_day .= ' ' . strtr( $BYDAY , $this->byday2langday_m ) ;
			}
			if( $INTERVAL == 1 ) $ret_freq = _PICAL_RR_EVERYYEAR ;
			else $ret_freq = sprintf( _PICAL_RR_PERYEAR , $INTERVAL ) ;
			break ;
	}

	// 終了条件解析
	$ret_terminator = '' ;
	// UNTIL と COUNT の両方がある時は COUNT 優先
	if( isset( $COUNT ) && $COUNT > 0 ) {
		$ret_terminator = sprintf( _PICAL_RR_COUNT , $COUNT ) ;
	} else if( isset( $UNTIL ) ) {
		// UNTIL は、全日条件であると無条件で見なす
		$year = substr( $UNTIL , 0 , 4 ) ;
		$month = substr( $UNTIL , 4 , 2 ) ;
		$date = substr( $UNTIL , 6 , 2 ) ;
		$ret_terminator = sprintf( _PICAL_RR_UNTIL , "$year-$month-$date" ) ;
	}

	return "$ret_freq $ret_day $ret_terminator" ;
}



// rruleを編集用フォームに展開するクラス関数
function rrule_to_form( $rrule , $until_init )
{
	// 各初期値の設定
	$norrule_checked = '' ;
	$daily_checked = '' ;
	$weekly_checked = '' ;
	$monthly_checked = '' ;
	$yearly_checked = '' ;
	$norrule_checked = '' ;
	$noterm_checked = '' ;
	$count_checked = '' ;
	$until_checked = '' ;
	$daily_interval_init = 1 ;
	$weekly_interval_init = 1 ;
	$monthly_interval_init = 1 ;
	$yearly_interval_init = 1 ;
	$count_init = 1 ;
	$wdays_checked = array( 'SU'=>'' , 'MO'=>'' , 'TU'=>'' , 'WE'=>'' , 'TH'=>'' , 'FR'=>'' , 'SA'=>'' ) ;
	$byday_m_init = '' ;
	$bymonthday_init = '' ;
	$bymonths_checked = array( 1=>'' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' , '' ) ;

	if( trim( $rrule ) == '' ) {
		$norrule_checked = "checked='checked'" ;
	} else {

		// rrule の各要素を変数に展開
		$rrule = strtoupper( $rrule ) ;
//HACK by domifara for php5.3+
//		$rules = split( ';' , $rrule ) ;
		$rules = explode( ';' , $rrule ) ;
		foreach( $rules as $rule ) {
			list( $key , $val ) = explode( '=' , $rule , 2 ) ;
			$key = trim( $key ) ;
			$$key = trim( $val ) ;
		}

		if( empty( $FREQ ) ) $FREQ = 'DAILY' ;
		if( empty( $INTERVAL ) || $INTERVAL <= 0 ) $INTERVAL = 1 ;

		// 頻度条件解析
		switch( $FREQ ) {
			case 'DAILY' :
				$daily_interval_init = $INTERVAL ;
				$daily_checked = "checked='checked'" ;
				break ;
			case 'WEEKLY' :
				if( empty( $BYDAY ) ) break ;	// BYDAY 必須
				$weekly_interval_init = $INTERVAL ;
				$weekly_checked = "checked='checked'" ;
				$wdays = explode( ',' , $BYDAY , 7 ) ;
				foreach( $wdays as $wday ) {
					if( isset( $wdays_checked[ $wday ] ) ) $wdays_checked[ $wday ] = "checked='checked'" ;
				}
				break ;
			case 'MONTHLY' :
				if( isset( $BYDAY ) ) {
					$byday_m_init = $BYDAY ;
				} else if( isset( $BYMONTHDAY ) ) {
					$bymonthday_init = $BYMONTHDAY ;
				} else {
					break ;	// BYDAY または BYMONTHDAY 必須
				}
				$monthly_interval_init = $INTERVAL ;
				$monthly_checked = "checked='checked'" ;
				break ;
			case 'YEARLY' :
				if( empty( $BYMONTH ) ) $BYMONTH = '' ;
				if( isset( $BYDAY ) ) $byday_m_init = $BYDAY ;
				$yearly_interval_init = $INTERVAL ;
				$yearly_checked = "checked='checked'" ;
				$months = explode( ',' , $BYMONTH , 12 ) ;
				foreach( $months as $month ) {
					$month = intval( $month ) ;
					if( $month > 0 && $month <= 12 ) $bymonths_checked[ $month ] = "checked='checked'" ;
				}
				break ;
		}

		// 終了条件解析
		// UNTIL と COUNT の両方がある時は COUNT 優先
		if( isset( $COUNT ) && $COUNT > 0 ) {
			$count_init = $COUNT ;
			$count_checked = "checked='checked'" ;
		} else if( isset( $UNTIL ) ) {
			// UNTIL は、全日データであると無条件で見なす
			$year = substr( $UNTIL , 0 , 4 ) ;
			$month = substr( $UNTIL , 4 , 2 ) ;
			$date = substr( $UNTIL , 6 , 2 ) ;
			$until_init = "$year-$month-$date" ;
			$until_checked = "checked='checked'" ;
		} else {
			// 両者とも指定がなければ、終了条件なし
			$noterm_checked = "checked='checked'" ;
		}

	}

	// UNTIL を指定するためのボックス
	$textbox_until = $this->get_formtextdateselect( 'rrule_until' , $until_init ) ;

	// 曜日選択チェックボックスの展開
	$wdays_checkbox = '' ;
	foreach( $this->byday2langday_w as $key => $val ) {
		$wdays_checkbox .= "<input type='checkbox' name='rrule_weekly_bydays[]' value='$key' {$wdays_checked[$key]} />$val &nbsp; \n" ;
	}

	// 月選択チェックボックスの展開
	$bymonth_checkbox = "<table><tr>\n" ;
	foreach( $bymonths_checked as $key => $val ) {
		$bymonth_checkbox .= "<td><input type='checkbox' name='rrule_bymonths[]' value='$key' $val />{$this->month_short_names[$key]}</td>\n" ;
		if( $key == 6 ) $bymonth_checkbox .= "</tr>\n<tr>\n" ;
	}
	$bymonth_checkbox .= "</tr></table>\n" ;

	// 第N曜日選択OPTIONの展開
	$byday_m_options = '' ;
	foreach( $this->byday2langday_m as $key => $val ) {
		if( $byday_m_init == $key ) {
			$byday_m_options .= "<option value='$key' selected='selected'>$val</option>\n" ;
		} else {
			$byday_m_options .= "<option value='$key'>$val</option>\n" ;
		}
	}

	return "
			<input type='radio' name='rrule_freq' value='none' $norrule_checked />"._PICAL_RR_R_NORRULE."<br />
			<br />
			<fieldset>
				<legend class='blockTitle'>"._PICAL_RR_R_YESRRULE."</legend>
				<fieldset>
					<legend class='blockTitle'><input type='radio' name='rrule_freq' value='daily' $daily_checked />"._PICAL_RR_FREQDAILY."</legend>
					"._PICAL_RR_FREQDAILY_PRE." <input type='text' size='2' name='rrule_daily_interval' value='$daily_interval_init' /> "._PICAL_RR_FREQDAILY_SUF."
				</fieldset>
				<br />
				<fieldset>
					<legend class='blockTitle'><input type='radio' name='rrule_freq' value='weekly' $weekly_checked />"._PICAL_RR_FREQWEEKLY."</legend>
					"._PICAL_RR_FREQWEEKLY_PRE."<input type='text' size='2' name='rrule_weekly_interval' value='$weekly_interval_init' /> "._PICAL_RR_FREQWEEKLY_SUF." <br />
					$wdays_checkbox
				</fieldset>
				<br />
				<fieldset>
					<legend class='blockTitle'><input type='radio' name='rrule_freq' value='monthly' $monthly_checked />"._PICAL_RR_FREQMONTHLY."</legend>
					"._PICAL_RR_FREQMONTHLY_PRE."<input type='text' size='2' name='rrule_monthly_interval' value='$monthly_interval_init' /> "._PICAL_RR_FREQMONTHLY_SUF." &nbsp;
					<select name='rrule_monthly_byday'>
						<option value=''>"._PICAL_RR_S_NOTSELECTED."</option>
						$byday_m_options
					</select> &nbsp; "._PICAL_RR_OR." &nbsp;
					<input type='text' size='10' name='rrule_bymonthday' value='$bymonthday_init' />"._PICAL_NTC_MONTHLYBYMONTHDAY."
				</fieldset>
				<br />
				<fieldset>
					<legend class='blockTitle'><input type='radio' name='rrule_freq' value='yearly' $yearly_checked />"._PICAL_RR_FREQYEARLY."</legend>
					"._PICAL_RR_FREQYEARLY_PRE."<input type='text' size='2' name='rrule_yearly_interval' value='$yearly_interval_init' /> "._PICAL_RR_FREQYEARLY_SUF." <br />
					$bymonth_checkbox <br />
					<select id='rrule_yearly_byday' name='rrule_yearly_byday'>
						<option value=''>"._PICAL_RR_S_SAMEASBDATE."</option>
						$byday_m_options
					</select>
				</fieldset>
				<br />
				<input type='radio' name='rrule_terminator' value='noterm' $noterm_checked onClick='document.MainForm.rrule_until.disabled=true;document.MainForm.rrule_count.disabled=true;' />"._PICAL_RR_R_NOCOUNTUNTIL." &nbsp; ".sprintf( _PICAL_NTC_EXTRACTLIMIT , $this->max_rrule_extract )."  <br />
				<input type='radio' name='rrule_terminator' value='count' $count_checked onClick='document.MainForm.rrule_until.disabled=true;document.MainForm.rrule_count.disabled=false;' />"._PICAL_RR_R_USECOUNT_PRE." <input type='text' size='3' name='rrule_count' value='$count_init' /> "._PICAL_RR_R_USECOUNT_SUF."<br />
				<input type='radio' name='rrule_terminator' value='until' $until_checked onClick='document.MainForm.rrule_until.disabled=false;document.MainForm.rrule_count.disabled=true;' />"._PICAL_RR_R_USEUNTIL." $textbox_until
			</fieldset>
  \n" ;
}



// POSTされたrrule関連の設定値を、RRULE文字列に組み上げるクラス関数
function rrule_from_post( $start , $allday_flag )
{
	// 繰り返し無しなら、無条件で空文字列を返す
	if( $_POST['rrule_freq'] == 'none' ) return '' ;

	// 頻度条件
	switch( strtoupper( $_POST['rrule_freq'] ) ) {
		case 'DAILY' :
			$ret_freq = "FREQ=DAILY;INTERVAL=" . abs( intval( $_POST['rrule_daily_interval'] ) ) ;
			break ;
		case 'WEEKLY' :
			$ret_freq = "FREQ=WEEKLY;INTERVAL=" . abs( intval( $_POST['rrule_weekly_interval'] ) ) ;
			if( empty( $_POST['rrule_weekly_bydays'] ) ) {
				// 曜日の指定が一つもなければ、開始日と同じ曜日にする
				$bydays = array_keys( $this->byday2langday_w ) ;
				$byday = $bydays[ date( 'w' , $start ) ] ;
			} else {
				$byday = '' ;
				foreach( $_POST['rrule_weekly_bydays'] as $wday ) {
					if( preg_match( '/[^\w]+/' , $wday ) ) die( "Some injection was tried" ) ;
					$byday .= substr( $wday , 0 , 2 ) . ',' ;
				}
				$byday = substr( $byday , 0 , -1 ) ;
			}
			$ret_freq .= ";BYDAY=$byday" ;
			break ;
		case 'MONTHLY' :
			$ret_freq = "FREQ=MONTHLY;INTERVAL=" . abs( intval( $_POST['rrule_monthly_interval'] ) ) ;
			if( $_POST['rrule_monthly_byday'] != '' ) {
				// 第N曜日による指定
				$byday = substr( trim( $_POST['rrule_monthly_byday'] ) , 0 , 4 ) ;				if( preg_match( '/[^\w-]+/' , $byday ) ) die( "Some injection was tried" ) ;
				$ret_freq .= ";BYDAY=$byday" ;
			} else if( $_POST['rrule_bymonthday'] != '' ) {
				// 日付による指定
				$bymonthday = preg_replace( '/[^0-9,]+/' , '' , $_POST['rrule_bymonthday'] ) ;
				$ret_freq .= ";BYMONTHDAY=$bymonthday" ;
			} else {
				// 第N曜日や日付の指定がなければ、開始日と同じ日付とする
				$ret_freq .= ";BYMONTHDAY=" . date( 'j' , $start ) ;
			}
			break ;
		case 'YEARLY' :
			$ret_freq = "FREQ=YEARLY;INTERVAL=" . abs( intval( $_POST['rrule_yearly_interval'] ) ) ;
			if( empty( $_POST['rrule_bymonths'] ) ) {
				// 月の指定が一つもなければ、開始日と同じ月にする
				$bymonth = date( 'n' , $start ) ;
			} else {
				$bymonth = '' ;
				foreach( $_POST['rrule_bymonths'] as $month ) {
					$bymonth .= intval( $month ) . ',' ;
				}
				$bymonth = substr( $bymonth , 0 , -1 ) ;
			}
			if( $_POST['rrule_yearly_byday'] != '' ) {
				// 第N曜日による指定
				$byday = substr( trim( $_POST['rrule_yearly_byday'] ) , 0 , 4 ) ;
				if( preg_match( '/[^\w-]+/' , $byday ) ) die( "Some injection was tried" ) ;
				$ret_freq .= ";BYDAY=$byday" ;
			}
			$ret_freq .= ";BYMONTH=$bymonth" ;
			break ;
		default :
			return '' ;
	}

	// 終了条件
	if( empty( $_POST['rrule_terminator'] ) ) $_POST['rrule_terminator'] = '' ;
	switch( strtoupper( $_POST['rrule_terminator'] ) ) {
		case 'COUNT' :
			$ret_term = ';COUNT=' . abs( intval( $_POST['rrule_count'] ) ) ;
			break ;
		case 'UNTIL' :
			// UNTILのUnixtime化
			list( $until , $until_date , $use_default ) = $this->parse_posted_date( $this->mb_convert_kana( $_POST[ 'rrule_until' ] , "a" ) , $this->unixtime ) ;
			// 1970以前・2038年以降なら、UNTIL無効
			if( $until_date ) {
				$ret_term = '' ;
			} else {
				if( ! $allday_flag ) {
					// 全日イベントでなければ同日の23:59:59を終了時刻と見なして、 UTC へ時差計算する
					$event_tz = isset( $_POST['event_tz'] ) ? $_POST['event_tz'] : $this->user_TZ ;
					$until = $until - intval( $event_tz * 3600 ) + 86400 - 1 ;
				}
				$ret_term = ';UNTIL=' . date( 'Ymd\THis\Z' , $until ) ;
			}
			break ;
		case 'NOTERM' :
		default :
			$ret_term = '' ;
			break ;
	}

	// WKSTは、自動で入れる
	$ret_wkst = $this->week_start ? ';WKST=MO' : ';WKST=SU' ;

	return $ret_freq . $ret_term . $ret_wkst ;
}


// 渡されたevent_idを初回(親)として、RRULEを展開してデータベースに反映
function rrule_extract( $event_id )
{
	$yrs = $this->db->query( "SELECT *,TO_DAYS(end_date)-TO_DAYS(start_date) AS date_diff FROM $this->table WHERE id='$event_id'" ) ;
	if( $this->db->getRowsNum( $yrs ) < 1 ) return ;
	$event = (object)$this->db->fetchArray( $yrs ) ;

	if( $event->rrule == '' ) return ;

	// rrule の各要素を変数に展開
	$rrule = strtoupper( $event->rrule ) ;
//HACK by domifara for php5.3+
//	$rules = split( ';' , $rrule ) ;
	$rules = explode( ';' , $rrule ) ;
	foreach( $rules as $rule ) {
		list( $key , $val ) = explode( '=' , $rule , 2 ) ;
		$key = trim( $key ) ;
		$$key = trim( $val ) ;
	}

	// 時差によって、RRULEの日付指定がどう置き換わるかの計算
	if( $event->allday ) {
		$tzoffset_date = 0 ;
	} else {
		// イベント自身のTZで展開する
		$tzoffset_s2e = intval( ( $event->event_tz - $this->server_TZ ) * 3600 ) ;
		$tzoffset_date = date( 'z' , $event->start + $tzoffset_s2e ) - date( 'z' , $event->start ) ;
		if( $tzoffset_date > 1 ) $tzoffset_date = -1 ;
		else if( $tzoffset_date < -1 ) $tzoffset_date = 1 ;
	}

	if( empty( $FREQ ) ) $FREQ = 'DAILY' ;
	if( empty( $INTERVAL ) || $INTERVAL <= 0 ) $INTERVAL = 1 ;

	// ベースとなるSQL文
	$base_sql = "INSERT INTO $this->table SET uid='$event->uid',groupid='$event->groupid',summary='".addslashes($event->summary)."',location='".addslashes($event->location)."',organizer='".addslashes($event->organizer)."',sequence='$event->sequence',contact='".addslashes($event->contact)."',tzid='$event->tzid',description='".addslashes($event->description)."',dtstamp='$event->dtstamp',categories='".addslashes($event->categories)."',transp='$event->transp',priority='$event->priority',admission='$event->admission',class='$event->class',rrule='".addslashes($event->rrule)."',unique_id='$event->unique_id',allday='$event->allday',start_date=null,end_date=null,cid='$event->cid',event_tz='$event->event_tz',server_tz='$event->server_tz',poster_tz='$event->poster_tz',extkey0='$event->extkey0',extkey1='$event->extkey1',rrule_pid='$event_id'" ;

	// 終了条件解析
	// カウント
	$count = $this->max_rrule_extract ;
	if( isset( $COUNT ) && $COUNT > 0 && $COUNT < $count ) {
		$count = $COUNT ;
	}
	// 展開終了日
	if( isset( $UNTIL ) ) {
		// UNTIL は、全日条件であると無条件で見なす
		$year = substr( $UNTIL , 0 , 4 ) ;
		$month = substr( $UNTIL , 4 , 2 ) ;
		$date = substr( $UNTIL , 6 , 2 ) ;
		if( ! checkdate( $month , $date , $year ) ) $until = 0x7FFFFFFF ;
		else {
			$until = gmmktime( 23 , 59 , 59 , $month , $date , $year , 0 ) ;
			if( ! $event->allday ) {
				// サーバ時間とイベント時間で日付が異なる場合にはUNTILもずらす
				$until -= intval( $tzoffset_date * 86400 ) ;
				// UTC -> server_TZ の時差計算は行わない
				// $until -= intval( $this->server_TZ * 3600 ) ;
			}
		}
	} else $until = 0x7FFFFFFF ;

	// WKST
	if( empty( $WKST ) ) $WKST = 'MO' ;

	// UnixTimestamp範囲外の処理
	if( isset( $event->start_date ) ) {
		// 開始や終了が2038年以降なら展開しない
		if( date( 'Y' , $event->start ) >= 2038 ) return ;
		if( date( 'Y' , $event->end ) >= 2038 ) return ;

		// 1971年の同月同日を展開ベースのstartとする
		$event->start = mktime( 0 , 0 , 0 , substr( $event->start_date , 5 , 2 ) , substr( $event->start_date , 8 , 2 ) , 1970 + 1 ) ;

		// endも1970以前なら、差をとって反映。そうでない場合はとりあえず放置 TODO
		if( isset( $event->end_date ) ) {
			$event->end = $event->start + ( $event->date_diff + 1 ) * 86400 ;
		}
	}

	// 頻度条件解析
	$sqls = array() ;
	switch( $FREQ ) {
		case 'DAILY' :
			$gmstart = $event->start + date( "Z" , $event->start ) ;
			$gmend = $event->end + date( "Z" , $event->end ) ;
			for( $c = 1 ; $c < $count ; $c ++ ) {
				$gmstart += $INTERVAL * 86400 ;
				$gmend += $INTERVAL * 86400 ;
				if( $gmstart > $until ) break ;
				$sqls[] = $base_sql . ",start=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmstart)."'),end=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmend)."')";
			}
			break ;

		case 'WEEKLY' :
			$gmstart = $event->start + date( "Z" , $event->start ) ;
			$gmstartbase = $gmstart ;
			$gmend = $event->end + date( "Z" , $event->end ) ;
			$duration = $gmend - $gmstart ;
			$wtop_date = gmdate( 'j' , $gmstart ) - gmdate( 'w' , $gmstart ) ;
			if( $WKST != 'SU' ) $wtop_date = $wtop_date == 7 ? 1 : $wtop_date + 1 ;
			$secondofday = $gmstart % 86400 ;
			$month = gmdate( 'm' , $gmstart ) ;
			$year = gmdate( 'Y' , $gmstart ) ;
			$week_top = gmmktime( 0 , 0 , 0 , $month , $wtop_date , $year ) ;
			$c = 1 ;
			// 数値化曜日配列の作成
			$temp_dates = explode( ',' , $BYDAY ) ;
			$wdays = array_keys( $this->byday2langday_w ) ;
			if( $WKST != 'SU' ) {
				// rotate wdays for creating array starting with Monday
				$sun_date = array_shift( $wdays ) ;
				array_push( $wdays , $sun_date ) ;
			}
			$dates = array() ;
			foreach( $temp_dates as $date ) {
				// measure for bug of PHP<4.2.0
				if( in_array( $date , $wdays ) ) {
					$dates[] = array_search( $date , $wdays ) ;
				}
			}
			sort( $dates ) ;
			$dates = array_unique( $dates ) ;
			if( ! count( $dates ) ) return ;
			while( 1 ) {
				foreach( $dates as $date ) {
					// サーバ時間とイベント時間で曜日が異なる場合の処理追加
					$gmstart = $week_top + ( $date - $tzoffset_date ) * 86400 + $secondofday ;
					if( $gmstart <= $gmstartbase ) continue ;
					$gmend = $gmstart + $duration ;
					if( $gmstart > $until ) break 2 ;
					if( ++ $c > $count ) break 2 ;
					$sqls[] = $base_sql . ",start=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmstart)."'),end=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmend)."')";
				}
				$week_top += $INTERVAL * 86400 * 7 ;
			}
			break ;

		case 'MONTHLY' :
			$gmstart = $event->start + date( "Z" , $event->start ) ;
			$gmstartbase = $gmstart ;
			$gmend = $event->end + date( "Z" , $event->end ) ;
			$duration = $gmend - $gmstart ;
			$secondofday = $gmstart % 86400 ;
			$month = gmdate( 'm' , $gmstart ) ;
			$year = gmdate( 'Y' , $gmstart ) ;
			$c = 1 ;
//HACK by domifara for php5.3+
//			if( isset( $BYDAY ) && ereg( '^(-1|[1-4])(SU|MO|TU|WE|TH|FR|SA)' , $BYDAY , $regs ) ) {
			if( isset( $BYDAY ) && preg_match( '/^(-1|[1-4])(SU|MO|TU|WE|TH|FR|SA)/i' , $BYDAY , $regs ) ) {
				// 第N曜日指定(BYDAY)の場合（複数不可）
				// 目的の曜日番号を取得
				$wdays = array_keys( $this->byday2langday_w ) ;
				$wday = array_search( $regs[2] , $wdays ) ;
				$first_ymw = gmdate( 'Ym' , $gmstart ) . intval( ( gmdate( 'j' , $gmstart ) - 1 ) / 7 ) ;
				if( $regs[1] == -1 ) {
					// 最終週指定の場合のループ
					$monthday_bottom = gmmktime( 0 , 0 , 0 , $month , 0 , $year ) ;
					while( 1 ) {
						for( $i = 0 ; $i < $INTERVAL ; $i ++ ) {
							$monthday_bottom += gmdate( 't' , $monthday_bottom + 86400 ) * 86400 ;
						}
						// 最終日の曜日を調べる
						$last_monthdays_wday = gmdate( 'w' , $monthday_bottom ) ;
						$date_back = $wday - $last_monthdays_wday ;
						if( $date_back > 0 ) $date_back -= 7 ;
						// サーバ時間とイベント時間で曜日が異なる場合の処理追加
						$gmstart = $monthday_bottom + ( $date_back - $tzoffset_date ) * 86400 + $secondofday ;
						if( $gmstart <= $gmstartbase ) continue ;
						$gmend = $gmstart + $duration ;
						if( $gmstart > $until ) break ;
						if( ++ $c > $count ) break ;
						$sqls[] = $base_sql . ",start=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmstart)."'),end=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmend)."')";
					}
				} else {
					// 第N週指定の場合のループ
					$monthday_top = gmmktime( 0 , 0 , 0 , $month , 1 , $year ) ;
					$week_number_offset = ( $regs[1] - 1 ) * 7 * 86400 ;
					while( 1 ) {
						for( $i = 0 ; $i < $INTERVAL ; $i ++ ) {
							$monthday_top += gmdate( 't' , $monthday_top ) * 86400 ;
						}
						// 第N週初日の曜日を調べる
						$week_numbers_top_wday = gmdate( 'w' , $monthday_top + $week_number_offset ) ;
						$date_ahead = $wday - $week_numbers_top_wday ;
						if( $date_ahead < 0 ) $date_ahead += 7 ;
						// サーバ時間とイベント時間で曜日が異なる場合の処理追加
						$gmstart = $monthday_top + $week_number_offset + ( $date_ahead - $tzoffset_date ) * 86400 + $secondofday ;
						if( $gmstart <= $gmstartbase ) continue ;
						$gmend = $gmstart + $duration ;
						if( $gmstart > $until ) break ;
						if( ++ $c > $count ) break ;
						$sqls[] = $base_sql . ",start=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmstart)."'),end=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmend)."')";
					}
				}
			} else if( isset( $BYMONTHDAY ) ) {
				// 日付指定(BYMONTHDAY)の場合（複数可）
				$monthday_top = gmmktime( 0 , 0 , 0 , $month , 1 , $year ) ;
				// BYMONTHDAY を前処理して、$dates配列にする
				$temp_dates = explode( ',' , $BYMONTHDAY ) ;
				$dates = array() ;
				foreach( $temp_dates as $date ) {
					if( $date > 0 && $date <= 31 ) $dates[] = intval( $date ) ;
				}
				sort( $dates ) ;
				$dates = array_unique( $dates ) ;
				if( ! count( $dates ) ) return ;
				while( 1 ) {
					$months_day = gmdate( 't' , $monthday_top ) ;
					foreach( $dates as $date ) {
						// 月の最終日フローチェック
						if( $date > $months_day ) $date = $months_day ;
						// サーバ時間とイベント時間で日付が異なる場合の処理追加
						$gmstart = $monthday_top + ( $date - 1 - $tzoffset_date ) * 86400 + $secondofday ;
						if( $gmstart <= $gmstartbase ) continue ;
						$gmend = $gmstart + $duration ;
						if( $gmstart > $until ) break 2 ;
						if( ++ $c > $count ) break 2 ;
						$sqls[] = $base_sql . ",start=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmstart)."'),end=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmend)."')";
					}
					for( $i = 0 ; $i < $INTERVAL ; $i ++ ) {
						$monthday_top += gmdate( 't' , $monthday_top ) * 86400 ;
					}
				}
			} else {
				// 有効な$BYDAYも$BYMONTHDAYも無ければ、繰り返し処理しない
				return ;
			}
			break ;

		case 'YEARLY' :
			$gmstart = $event->start + date( "Z" , $event->start ) ;
			$gmstartbase = $gmstart ;
			$gmend = $event->end + date( "Z" , $event->end ) ;
			$duration = $gmend - $gmstart ;
			$secondofday = $gmstart % 86400 ;
			$gmmonth = gmdate( 'n' , $gmstart ) ;

			// empty BYMONTH
			if( empty( $BYMONTH ) ) $BYMONTH = $gmmonth ;

			// BYMONTH を前処理して、$months配列にする（BYMONTHは複数可）
			$temp_months = explode( ',' , $BYMONTH ) ;
			$months = array() ;
			foreach( $temp_months as $month ) {
				if( $month > 0 && $month <= 12 ) $months[] = intval( $month ) ;
			}
			sort( $months ) ;
			$months = array_unique( $months ) ;
			if( ! count( $months ) ) return ;

//HACK by domifara for php5.3+
//			if( isset( $BYDAY ) && ereg( '^(-1|[1-4])(SU|MO|TU|WE|TH|FR|SA)' , $BYDAY , $regs ) ) {
			if( isset( $BYDAY ) && preg_match( '/^(-1|[1-4])(SU|MO|TU|WE|TH|FR|SA)/i' , $BYDAY , $regs ) ) {
				// 第N曜日指定の場合（複数不可）
				// 目的の曜日番号を取得
				$wdays = array_keys( $this->byday2langday_w ) ;
				$wday = array_search( $regs[2] , $wdays ) ;
				$first_ym = gmdate( 'Ym' , $gmstart ) ;
				$year = gmdate( 'Y' , $gmstart ) ;
				$c = 1 ;
				if( $regs[1] == -1 ) {
					// 最終週指定の場合のループ
					while( 1 ) {
						foreach( $months as $month ) {
							// 最終日の曜日を調べる
							$last_monthdays_wday = gmdate( 'w' , gmmktime( 0 , 0 , 0 , $month + 1 , 0 , $year ) ) ;
							$date_back = $wday - $last_monthdays_wday ;
							if( $date_back > 0 ) $date_back -= 7 ;
							$gmstart = gmmktime( 0 , 0 , 0 , $month + 1 , $date_back - $tzoffset_date , $year ) + $secondofday ;
							// 初回と同じ月以前かどうかチェック
							if( gmdate( 'Ym' , $gmstart ) <= $first_ym ) continue ;
							$gmend = $gmstart + $duration ;
							if( $gmstart > $until ) break 2 ;
							if( ++ $c > $count ) break 2 ;
							$sqls[] = $base_sql . ",start=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmstart)."'),end=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmend)."')";
						}
						$year += $INTERVAL ;
						if( $year >= 2038 ) break ;
					}
				} else {
					// 第N週指定の場合のループ
					$week_numbers_top_date = 1 + ( $regs[1] - 1 ) * 7 ;
					while( 1 ) {
						foreach( $months as $month ) {
							// 第N週初日の曜日を調べる
							$week_numbers_top_wday = gmdate( 'w' , gmmktime( 0 , 0 , 0 , $month , $week_numbers_top_date , $year ) ) ;
							$date_ahead = $wday - $week_numbers_top_wday ;
							if( $date_ahead < 0 ) $date_ahead += 7 ;
							$gmstart = gmmktime( 0 , 0 , 0 , $month , $week_numbers_top_date + $date_ahead - $tzoffset_date , $year ) + $secondofday ;
							// 初回と同じ月以前かどうかチェック
							if( gmdate( 'Ym' , $gmstart ) <= $first_ym ) continue ;
							$gmend = $gmstart + $duration ;
							if( $gmstart > $until ) break 2 ;
							if( ++ $c > $count ) break 2 ;
							$sqls[] = $base_sql . ",start=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmstart)."'),end=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmend)."')";
						}
						$year += $INTERVAL ;
						if( $year >= 2038 ) break ;
					}
				}
			} else {
				// 日付指定の場合のループ（複数不可）
				$first_date = gmdate( 'j' , $gmstart ) ;
				$year = gmdate( 'Y' , $gmstart ) ;
				$c = 1 ;
				while( 1 ) {
					foreach( $months as $month ) {
						$date = $first_date ;
						// 月の最終日フローチェック
						while( ! checkdate( $month , $date , $year ) && $date > 0 ) $date -- ;
						// $date を gmdate('j') から得ているため、$tzoffset_date の処理は不要
						$gmstart = gmmktime( 0 , 0 , 0 , $month , $date , $year ) + $secondofday ;
						if( $gmstart <= $gmstartbase ) continue ;
						$gmend = $gmstart + $duration ;
						if( $gmstart > $until ) break 2 ;
						if( ++ $c > $count ) break 2 ;
						$sqls[] = $base_sql . ",start=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmstart)."'),end=UNIX_TIMESTAMP('".gmdate("Y-m-d H:i:s", $gmend)."')";
					}
					$year += $INTERVAL ;
					if( $year >= 2038 ) break ;
				}
			}
			break ;

		default :
			return ;
	}

	// echo "<pre>" ; var_dump( $sqls ) ; echo "</pre>" ; exit ;
	foreach( $sqls as $sql ) {
		$this->db->query( $sql ) ;
	}
}

public function set_patTemplate( &$tmpl , $file )
{
	if (! $target = $this->get_template( $file )) {
		$target = $this->images_path . '/' . $file ;
	}
	$tmpl->readTemplatesFromFile( $target ) ;
}

private function get_template($tpl_name)
{
	static $cache = array();
	static $theme = null;
	static $theme_default = null;
	static $entries = null;
	static $themeD3 = '';
	static $themeDefaultD3 = '';
	static $mydir_prefix;
	
	global $xoopsConfig;
	
	// 1st, check the cache
	if (isset($cache[$tpl_name])) {
		return $cache[$tpl_name];
	}
	
	$mytrustdirname = 'piCal';
	
	if (is_null($theme)) {
		$theme = isset($xoopsConfig['theme_set']) ? $xoopsConfig['theme_set'] : 'default';
	
		if (($_pos = strpos($theme, '_')) && substr($theme, $_pos) !== '_default') {
			$theme_default = XOOPS_THEME_PATH . '/' . substr($theme, 0, $_pos) . '_default/templates/';
		} else {
			$theme_default = '';
		}
		
		$theme = XOOPS_THEME_PATH . '/' . $theme . '/templates/';
		
		if (defined('XOOPS_CUBE_LEGACY')) {
			$root = XCube_Root::getSingleton();
			$resourceDiscoveryOrder = $root->getSiteConfig('Smarty', 'ResourceDiscoveryOrder');
		} else {
			$resourceDiscoveryOrder = null;
		}
		if (! $resourceDiscoveryOrder) {
			$resourceDiscoveryOrder = 'Theme,ThemeD3,ThemeDefault,ThemeDefaultD3';
		}
		$entries = array_map('strtoupper', array_map('trim', explode(',', $resourceDiscoveryOrder)));
		if (in_array('THEMED3', $entries)) {
			$themeD3 = $theme . $mytrustdirname ;
			is_dir($themeD3) || $themeD3 = '';
		}
		if (in_array('THEMEDEFAULTD3', $entries)) {
			$themeDefaultD3 = $theme_default . $mytrustdirname ;
			is_dir($themeDefaultD3) || $themeDefaultD3 = '';
		}
		$mydir_prefix = basename($this->base_path) . '_';
	}
	
	
	foreach($entries as $entry) {
		switch($entry) {
			case 'THEME':
				// check templates under themes/(theme)/templates/ (file template)
				$filepath = $theme . $mydir_prefix . $tpl_name ;
				if (is_file($filepath)) {
					return $cache[$tpl_name] = $filepath ;
				}
				break;
	
			case 'THEMED3':
				// check templates under themes/(theme)/templates/(trust based template)
				if($themeD3 && $mytrustdirname) {
					$filepath = $theme . $mytrustdirname . '/' . $tpl_name ;
					if (is_file($filepath)) {
						return $cache[$tpl_name] = $filepath ;
					}
				}
				break;
	
			case 'THEMEDEFAULT':
				// check templates under themes/(theme prefix)_default/templates/ (file template)
				if ($theme_default) {
					$filepath = $theme_default . $mydir_prefix . $tpl_name ;
					if (is_file($filepath)) {
						return $cache[$tpl_name] = $filepath ;
					}
				}
				break;
	
			case 'THEMEDEFAULTD3':
				// check templates under themes/(theme prefix)_default/templates/(trust based template)
				if($themeDefaultD3 && $theme_default && $mytrustdirname) {
					$filepath = $theme_default . $mytrustdirname . '/' . $tpl_name ;
					if (is_file($filepath)) {
						return $cache[$tpl_name] = $filepath ;
					}
				}
				break;
	
			case 'DBTPLSET':
			DEFAULT:
		}
	}
	
	isset($cache[$tpl_name]) || $cache[$tpl_name] = '' ;
	
	return $cache[$tpl_name];
}

public function get_CSS_link_tag()
{
	static $done = false;
	if (!$done) {
		$done = true;
		$css = array();
		$css[] = '<link rel="stylesheet" href="' . $this->images_url . '/style.css"  media="all" type="text/css" />';
		if ($target = $this->get_template('style.css')) {
			$css[] = '<link rel="stylesheet" href="' . str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $target) . '"  media="all" type="text/css" />';
		}
		return join("\n", $css)."\n";
	}
	return '';
}

private function load_whatday_plugins() {
	if (is_null($this->whatday)) {
		include_once $this->base_path.'/class/piCal_whatday_abstract.php';
		$this->whatday = array();
		$plugins = explode(',', $this->whatday_plugins);
		$plugins = array_map('trim', $plugins);
		foreach($plugins as $plugin) {
			if (@include_once($this->base_path.'/plugins/whatday/'.$plugin.'/'.$plugin.'.php')) {
				$class = 'piCal_whatday_'.$plugin;
				if (class_exists($class, false)) {
					$this->whatday[$plugin] = new $class($this);
				}
			}
		}
	}
}

function sql_data_seek( $result , $offset ) {
	if (is_object($this->db->conn)) {
		switch (get_class($this->db->conn)) {
			case 'mysqli':
				return mysqli_data_seek($result, $offset);
			default:
				return false;
		}
	} else {
		return mysql_data_seek($result, $offset);
	}
}

// The End of Class
}

}
?>