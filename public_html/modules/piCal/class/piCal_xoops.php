<?php

// piCal's inherited class for XOOPS
// piCal_xoops.php
// by GIJ=CHECKMATE (PEAK Corp. http://www.peak.ne.jp/)


if( ! class_exists( 'piCal_xoops' ) ) {

class piCal_xoops extends piCal {

function textarea_sanitizer_for_show( $data )
{
	$myts =& MyTextSanitizer::getInstance();
	return $myts->displayTarea($data,0,1,1,1,1);
}

function textarea_sanitizer_for_edit( $data )
{
	$myts =& MyTextSanitizer::getInstance();
	return $myts->makeTareaData4Edit($data);
}

function textarea_sanitizer_for_export_ics( $data )
{
	$myts =& MyTextSanitizer::getInstance();
	return $myts->displayTarea($data,0,1,1,1,1);
}

function text_sanitizer_for_show( $data )
{
	$myts =& MyTextSanitizer::getInstance();
	return $myts->makeTboxData4Show( $data ) ;
}

function text_sanitizer_for_edit( $data )
{
	$myts =& MyTextSanitizer::getInstance();
	return $myts->makeTboxData4Edit( $data ) ;
}

function get_formtextdateselect( $name , $ymd , $long_ymdn = '' )
{
	// day of week starting
	$first_day = $this->week_start ? 1 : 0 ;

	if( $this->jscalendar == 'xoops' ) {

		$jstime = formatTimestamp( $this->unixtime , 'F j Y, H:i:s' ) ;
	
		if( $this->week_start ) $js_cal_week_start = 'true' ;	// Monday
		else $js_cal_week_start = 'false' ;						// Sunday
	
	
		// <input type='reset' value='...' onclick='
	
		return "
			<input type='text' name='$name' id='$name' size='15' maxlength='15' value='$ymd' />
			<input type='image' src='$this->images_url/button_date_selecting.gif' onclick='
	
		  var el = xoopsGetElementById(\"$name\");
		  if (calendar != null) {
		    calendar.hide();
		    calendar.parseDate(el.value);
		  } else {
		    var cal = new Calendar($js_cal_week_start, new Date(\"$jstime\"), selected, closeHandler);
		    calendar = cal;
		    cal.setRange(2000, 2015); // GIJ TODO
		    calendar.create();
		    calendar.parseDate(el.value);
		  }
		  calendar.sel = el;
		  calendar.showAtElement(el);
		  Calendar.addEvent(document, \"mousedown\", checkCalendar);
		  return false;

		' />
		" ;
	} else {
		return "
		<input type='text' name='$name' id='$name' size='12' maxlength='12' value='$ymd' />
		<img src='$this->images_url/button_date_selecting.gif' id='trigger_{$name}' style='cursor: pointer; vertical-align:bottom;' title='Date selector' />
		<span id='display_{$name}'>$long_ymdn</span>

		<script type='text/javascript'>
		Calendar.setup({
			inputField : '$name',
			button : 'trigger_{$name}',
			displayArea : 'display_{$name}',
			daFormat : '"._PICAL_JSFMT_YMDN."' ,
			ifFormat : '%Y-%m-%d',
			showsTime : false,
			align :'Br',
			step : 1 ,
			firstDay : $first_day ,
			singleClick : false
		});
		</script>
		" ;
	}
}

function get_submitter_info( $uid )
{
	if( $uid <= 0 ) return _GUESTS ;

	$poster = new XoopsUser( $uid ) ;

	// check if invalid uid
	if( $poster->uname() == '' ) return '' ;

	if( $this->nameoruname == 'uname' ) {
		$name = $poster->uname() ;
	} else {
		$name = trim( $poster->name() ) ;
		if( $name == "" ) $name = $poster->uname() ;
	}

	return "<a href='".XOOPS_URL."/userinfo.php?uid=$uid'>$name</a>" ;
}


// XOOPSグローバル検索結果
function get_xoops_search_result( $keywords , $andor , $limit , $offset , $uid )
{
	// 時差計算
	$tzoffset = ( $this->user_TZ - $this->server_TZ ) * 3600 ;

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// 文字列指定
	if( ! empty( $keywords ) ) {
		switch( strtolower( $andor ) ) {
			case 'and' :
				$whr_text = '' ;
				foreach( $keywords as $keyword ) {
					$whr_text .= "CONCAT(summary,' ',description) LIKE '%$keyword%' AND " ;
				}
				$whr_text = substr( $whr_text , 0 , -5 ) ;
				break ;
			case 'or' :
				$whr_text = '' ;
				foreach( $keywords as $keyword ) {
					$whr_text .= "CONCAT(summary,' ',description) LIKE '%$keyword%' OR " ;
				}
				$whr_text = substr( $whr_text , 0 , -4 ) ;
				break ;
			default :
				$whr_text = "CONCAT(summary,'  ',description) LIKE '%{$keywords[0]}%'" ;
				break ;
		}
	} else {
		$whr_text = '1' ;
	}

	// ユーザID指定
	if( $uid > 0 ) $whr_uid = "uid=$uid" ;
	else $whr_uid = '1' ;

	// XOOPS Search module
	$showcontext = empty( $_GET['showcontext'] ) ? 0 : 1 ;
	$select4con = $showcontext ? "description" : "'' AS description" ;

	// SQL文生成
	$sql = "SELECT id,uid,summary,UNIX_TIMESTAMP(dtstamp) AS udtstamp, start, end, allday, start_date, end_date, $select4con FROM $this->table WHERE admission>0 AND (rrule_pid=0 OR rrule_pid=id) AND ($whr_categories) AND ($whr_class) AND ($whr_text) AND ($whr_uid) ORDER BY dtstamp DESC LIMIT $offset,$limit" ;

	// クエリ
	$rs = mysql_query( $sql , $this->conn ) ;

	$ret = array() ;
	$context = '' ;
	$myts =& MyTextSanitizer::getInstance();
	while( $event = mysql_fetch_object( $rs ) ) {

		if( isset( $event->start_date ) ) $start_str = $event->start_date ;
		else if( $event->allday ) $start_str = $this->get_long_ymdn( $event->start ) ;
		else $start_str = $this->get_long_ymdn( $event->start + $tzoffset ) ;

		if( isset( $event->end_date ) ) $end_str = $event->end_date ;
		else if( $event->allday ) $end_str = $this->get_long_ymdn( $event->end - 300 ) ;
		else $end_str = $this->get_long_ymdn( $event->end + $tzoffset ) ;

		$date_desc = ( $start_str == $end_str ) ? $start_str : "$start_str - $end_str" ;

		// get context for module "search"
		if( function_exists( 'search_make_context' ) && $showcontext ) {
			$full_context = strip_tags( $myts->displayTarea( $event->description , 1 , 1 , 1 , 1 , 1 ) ) ;
			if( function_exists( 'easiestml' ) ) $full_context = easiestml( $full_context ) ;
			$context = search_make_context( $full_context , $keywords ) ;
		}

		$ret[] = array( 
			'image' => "images/pical.gif" ,
			'link' => "index.php?action=View&amp;event_id=$event->id" ,
			'title' => "[$date_desc] $event->summary" ,
			'time' => $event->udtstamp ,
			'uid' => $uid ,
			"context" => $context
		) ;
	}

	return $ret ;
}


// Notifications
// triggerEvent で渡すURIは、& で区切る (&amp; ではない)
function notify_new_event( $event_id )
{
	$rs = mysql_query( "SELECT summary,admission,categories,class,uid,groupid FROM $this->table WHERE id='$event_id'" , $this->conn ) ;
	$event = mysql_fetch_object( $rs ) ;

	// No notification if not admitted yet
	if( ! $event->admission ) return false ;

	// Private events
	if( $event->class == 'PRIVATE' ) {
		if( $event->groupid > 0 ) {
			$member_handler =& xoops_gethandler('member');
			$user_list = $member_handler->getUsersByGroup( $event->groupid ) ;
		} else {
			$user_list = array( $event->uid ) ;
		}
	} else {
		$user_list = array() ;
	}

	$notification_handler =& xoops_gethandler('notification');

	// 新イベントの登録（全カテゴリー）のトリガー
	$notification_handler->triggerEvent('global', 0, 'new_event', array('EVENT_SUMMARY' => $event->summary , 'EVENT_URI' => "$this->base_url/index.php?action=View&event_id=$event_id" ) , $user_list , null , 0 ) ;

	// 新イベントの登録（カテゴリー毎）のトリガー
	$cids = explode( "," , $event->categories ) ;
	foreach( $cids as $cid ) {
		$cid = intval( $cid ) ;
		if( isset( $this->categories[ $cid ] ) ) $notification_handler->triggerEvent('category', $cid, 'new_event', array('EVENT_SUMMARY' => $event->summary , 'CATEGORY_TITLE' => $this->text_sanitizer_for_show( $this->categories[ $cid ]->cat_title ) , 'EVENT_URI' => "$this->base_url/index.php?smode=List&cid=$cid" ) , $user_list , null , 0 ) ;
	}

	return true ;
}


// $this->caldate日の予定ブロック配列を返す
function get_blockarray_date_event( $get_target = '' )
{
	// if( $get_target == '' ) $get_target = $_SERVER['SCRIPT_NAME'] ;

	// 時差を計算しつつ、WHERE節の期間に関する条件生成
	$tzoffset = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
	$toptime_of_day = $this->unixtime + $this->day_start - $tzoffset ;
	$bottomtime_of_day = $toptime_of_day + 86400 ;
	$whr_term = "(allday AND start<='$this->unixtime' AND end>'$this->unixtime') OR ( ! allday AND start<'$bottomtime_of_day' AND (start='$toptime_of_day' OR end>'$toptime_of_day'))" ;

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// 当日のスケジュール取得
	$yrs = mysql_query( "SELECT start,end,summary,id,uid,allday,location,contact,description,(start>='$toptime_of_day') AS is_start_date,(end<='$bottomtime_of_day') AS is_end_date FROM $this->table WHERE admission>0 AND ($whr_term) AND ($whr_categories) AND ($whr_class) ORDER BY start,end" , $this->conn ) ;
	$num_rows = mysql_num_rows( $yrs ) ;

	$block = array(
		'insertable' => $this->insertable ,
		'num_rows' => $num_rows ,
		'get_target' => $get_target ,
		'images_url' => $this->images_url ,
		'caldate' => $this->caldate ,
		'lang_PICAL_MB_CONTINUING' => _PICAL_MB_CONTINUING ,
		'lang_PICAL_MB_NOEVENT' => _PICAL_MB_NOEVENT ,
		'lang_PICAL_MB_ADDEVENT' => _PICAL_MB_ADDEVENT ,
		'lang_PICAL_MB_ALLDAY_EVENT' => _PICAL_MB_ALLDAY_EVENT
	) ;

	while( $event = mysql_fetch_object( $yrs ) ) {

		if( ! $event->allday ) {
			// 通常イベント
			// $event->start,end はサーバ時間  $start,$end はユーザ時間
			$start = $event->start + $tzoffset ;
			$end = $event->end + $tzoffset ;

			// 当日に開始や終了するかでドットGIFを替える
			if( $event->is_start_date ) $dot = "dot_startday.gif" ;
			else if( $event->is_end_date ) $dot = "dot_endday.gif" ;
			else $dot = "dot_interimday.gif" ;

			// $day_start 指定がある時の、24:00以降の処理
			if( $event->is_start_date && $bottomtime_of_day - $event->start <= $this->day_start ) $start_desc = $this->get_middle_hi( $start , true ) ;
			else $start_desc = $this->get_middle_hi( $start ) ;

			if( $event->is_end_date ) {
				// $day_start 指定がある時の、24:00以降の処理
				if( $bottomtime_of_day - $event->end <= $this->day_start ) $end_desc = $this->get_middle_hi( $end , true ) ;
				else $end_desc = $this->get_middle_hi( $end ) ;
			} else {
				$end_desc = $this->get_middle_md( $end ) ;
			}

			// 通常イベントの配列セット
			$block['events'][] = array( 
				'summary' => $this->text_sanitizer_for_show( $event->summary ) ,
				'location' => $this->text_sanitizer_for_show( $event->location ) ,
				'contact' => $this->text_sanitizer_for_show( $event->contact ) ,
				'description' => $this->textarea_sanitizer_for_show( $event->description ) ,
				'allday' => $event->allday ,
				'start' => $start ,
				'start_desc' => $start_desc ,
				'end' => $end ,
				'end_desc' => $end_desc ,
				'id' => $event->id ,
				'uid' => $event->uid ,
				'dot_gif' => $dot ,
				'is_start_date' => $event->is_start_date ,
				'is_end_date' => $event->is_end_date
			) ;
		} else {
			// 全日イベントの配列セット
			$block['events'][] = array( 
				'summary' => $this->text_sanitizer_for_show( $event->summary ) ,
				'location' => $this->text_sanitizer_for_show( $event->location ) ,
				'contact' => $this->text_sanitizer_for_show( $event->contact ) ,
				'description' => $this->textarea_sanitizer_for_show( $event->description ) ,
				'allday' => $event->allday ,
				'start' => $event->start ,
				'end' => $event->end ,
				'id' => $event->id ,
				'uid' => $event->uid ,
				'dot_gif' => "dot_allday.gif" ,
				'is_start_date' => $event->is_start_date ,
				'is_end_date' => $event->is_end_date
			) ;
		}
	}

	return $block ;
}



// $this->caldate以降の予定ブロック配列を返す
function get_blockarray_coming_event( $get_target = '' , $num = 5 , $for_coming = false , $untildays = 0 )
{
	// if( $get_target == '' ) $get_target = $_SERVER['SCRIPT_NAME'] ;
	$now = $for_coming ? time() : $this->unixtime + $this->day_start ;

	// 時差を計算しておく
	$tzoffset = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;

	if( $for_coming ) {
		// 「今後の予定」のみ、比較対象は日付境界ではなく、今現在 (thx Chado)
		$whr_term = "end>'$now'" ;
	} else if( $tzoffset == 0 ) {
		$whr_term = "end>'$now'" ;
	} else {
		// 時差がある場合は、alldayによって場合分け
		$whr_term = "(allday AND end>'$now') OR ( ! allday AND ( start >= '$now' OR end>'".($now - $tzoffset )."'))" ;
	}

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// untildays
	if( $untildays > 0 ) {
		$until = $this->unixtime + $untildays * 86400 ;
		$whr_until = "start < $until" ;
	} else {
		$whr_until = '1' ;
	}

	// 件数の取得
	$yrs = mysql_query( "SELECT COUNT(*) FROM $this->table WHERE admission>0 AND ($whr_term) AND ($whr_categories) AND ($whr_class) AND ($whr_until)" , $this->conn ) ;
	$num_rows = mysql_result( $yrs , 0 , 0 ) ;

	// 本クエリ
	$yrs = mysql_query( "SELECT start,end,summary,id,uid,allday,location,contact,description FROM $this->table WHERE admission>0 AND ($whr_term) AND ($whr_categories) AND ($whr_class) AND ($whr_until) ORDER BY start LIMIT $num" , $this->conn ) ;

	$block = array(
		'insertable' => $this->insertable ,
		'num_rows' => $num_rows ,
		'get_target' => $get_target ,
		'images_url' => $this->images_url ,
		'caldate' => $this->caldate ,
		'lang_PICAL_MB_CONTINUING' => _PICAL_MB_CONTINUING ,
		'lang_PICAL_MB_NOEVENT' => _PICAL_MB_NOEVENT ,
		'lang_PICAL_MB_ADDEVENT' => _PICAL_MB_ADDEVENT ,
		'lang_PICAL_MB_RESTEVENT_PRE' => _PICAL_MB_RESTEVENT_PRE ,
		'lang_PICAL_MB_RESTEVENT_SUF' => _PICAL_MB_RESTEVENT_SUF ,
		'lang_PICAL_MB_ALLDAY_EVENT' => _PICAL_MB_ALLDAY_EVENT
	) ;

	while( $event = mysql_fetch_object( $yrs ) ) {

		// $event->start,end はサーバ時間  $start,$end はユーザ時間
		if( $event->allday ) {
			$can_time_disp = false ;
			$start_for_time = $start_for_date = $event->start ;
			$end_for_time = $end_for_date = $event->end - 300 ;
		} else {
			$can_time_disp = $for_coming ;
			$start_for_time = $event->start + $tzoffset ;
			$start_for_date = $event->start + $tzoffset - $this->day_start ;
			$end_for_time = $event->end + $tzoffset ;
			$end_for_date = $event->end + $tzoffset - $this->day_start ;
		}

		if( $event->start < $now ) { // TODO zer0fill  $now + $tzoffset だろうか?
			// already started
			$distance = 0 ;
			$dot = "dot_started.gif" ;
			$start_desc = '' ;
			if( $event->end - $now < 86400 && $can_time_disp ) {
				if( date( "G" , $end_for_time ) * 3600 <= $this->day_start ) $end_desc = $this->get_middle_hi( $end_for_time , true ) ;
				else $end_desc = $this->get_middle_hi( $end_for_time ) ;
			} else {
				$end_desc = $this->get_middle_md( $end_for_date ) ;
			}
		} else if( $event->start - $now < 86400 ) {
			// near event (24hour)
			$dot = "dot_today.gif" ;
			if( $can_time_disp ) {
				if( date( "G" , $start_for_time ) * 3600 < $this->day_start ) $start_desc = $this->get_middle_hi( $start_for_time , true ) ;
				else $start_desc = $this->get_middle_hi( $start_for_time ) ;
			} else {
				$start_desc = $this->get_middle_md( $start_for_date ) ;
			}
			if( $event->end - $now < 86400 && $can_time_disp ) {
				if( date( "G" , $end_for_time ) * 3600 <= $this->day_start ) $end_desc = $this->get_middle_hi( $end_for_time , true ) ;
				else $end_desc = $this->get_middle_hi( $end_for_time ) ;
				$distance = 1 ;
			} else {
				$end_desc = $this->get_middle_md( $end_for_date ) ;
				$distance = 2 ;
			}
		} else {
			// far event (>1day)
			$distance = 3 ;
			$dot = "dot_future.gif" ;
			$start_desc = $this->get_middle_md( $start_for_date ) ;
			$end_desc = $this->get_middle_md( $end_for_date ) ;
		}

		$block['events'][] = array( 
			'summary' => $this->text_sanitizer_for_show( $event->summary ) ,
			'location' => $this->text_sanitizer_for_show( $event->location ) ,
			'contact' => $this->text_sanitizer_for_show( $event->contact ) ,
			'description' => $this->textarea_sanitizer_for_show( $event->description ) ,
			'allday' => $event->allday ,
			'start' => $start_for_time ,
			'start_desc' => $start_desc ,
			'end' => $end_for_time ,
			'end_desc' => $end_desc ,
			'id' => $event->id ,
			'uid' => $event->uid ,
			'dot_gif' => $dot ,
			'distance' => $distance
		) ;

	}

	$block['num_rows_rest'] = $num_rows - $num ;

	return $block ;
}


// 新規に登録された予定ブロック配列を返す
function get_blockarray_new_event( $get_target = '' , $num = 5 )
{
	// if( $get_target == '' ) $get_target = $_SERVER['SCRIPT_NAME'] ;

	// tzoffset
	$tzoffset = ( $this->user_TZ - $this->server_TZ ) * 3600 ;

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// 新しい順にスケジュール取得
	$yrs = mysql_query( "SELECT id,uid,summary,UNIX_TIMESTAMP(dtstamp) AS udtstamp , start, end, allday, start_date, end_date FROM $this->table WHERE admission>0 AND ($whr_categories) AND ($whr_class) AND (rrule_pid=0 OR rrule_pid=id) ORDER BY dtstamp DESC" , $this->conn ) ;

	$num_rows = mysql_num_rows( $yrs ) ;

	$block = array(
		'insertable' => $this->insertable ,
		'num_rows' => $num_rows ,
		'get_target' => $get_target ,
		'images_url' => $this->images_url ,
		'caldate' => $this->caldate ,
		'lang_PICAL_MB_CONTINUING' => _PICAL_MB_CONTINUING ,
		'lang_PICAL_MB_NOEVENT' => _PICAL_MB_NOEVENT ,
		'lang_PICAL_MB_ADDEVENT' => _PICAL_MB_ADDEVENT ,
		'lang_PICAL_MB_RESTEVENT_PRE' => _PICAL_MB_RESTEVENT_PRE ,
		'lang_PICAL_MB_RESTEVENT_SUF' => _PICAL_MB_RESTEVENT_SUF ,
		'lang_PICAL_MB_ALLDAY_EVENT' => _PICAL_MB_ALLDAY_EVENT
	) ;

	$count = 0 ;
	while( $event = mysql_fetch_object( $yrs ) ) {

		if( ++ $count > $num ) break ;

		if( isset( $event->start_date ) ) $start_str = $event->start_date ;
		else if( $event->allday ) $start_str = $this->get_long_ymdn( $event->start ) ;
		else $start_str = $this->get_long_ymdn( $event->start + $tzoffset ) ;

		if( isset( $event->end_date ) ) $end_str = $event->end_date ;
		else if( $event->allday ) $end_str = $this->get_long_ymdn( $event->end - 300 ) ;
		else $end_str = $this->get_long_ymdn( $event->end + $tzoffset ) ;

		$date_desc = ( $start_str == $end_str ) ? $start_str : "$start_str - $end_str" ;
		$block['events'][] = array( 
			'summary' => $this->text_sanitizer_for_show( $event->summary ) ,
			'allday' => $event->allday ,
			'start' => $event->start ,
			'start_desc' => $start_str ,
			'end' => $event->end ,
			'end_desc' => $end_str ,
			'date_desc' => $date_desc ,
			'post_date' => formatTimestamp( $event->udtstamp ) ,
			'uid' => $event->uid ,
			'id' => $event->id
		) ;
	}

	$block['num_rows_rest'] = $num_rows - $count ;

	return $block ;
}



// XOOPSテンプレートに、イベントのリスト表示をアサインする
function assign_event_list( &$tpl , $get_target = '' )
{
	// if( $get_target == '' ) $get_target = $_SERVER['SCRIPT_NAME'] ;
	$pos = isset( $_GET[ 'pos' ] ) ? intval( $_GET[ 'pos' ] ) : 0 ;
	$num = isset( $_GET[ 'num' ] ) ? intval( $_GET[ 'num' ] ) : 20 ;

	// ソート順
	$orders = array(
		'summary' => _PICAL_TH_SUMMARY . ' ' . _PICAL_MB_ORDER_ASC ,
		'summary DESC' => _PICAL_TH_SUMMARY . ' ' . _PICAL_MB_ORDER_DESC ,
		'start' => _PICAL_TH_STARTDATETIME . ' ' . _PICAL_MB_ORDER_ASC ,
		'start DESC' => _PICAL_TH_STARTDATETIME . ' ' . _PICAL_MB_ORDER_DESC  ,
		'dtstamp' => _PICAL_TH_LASTMODIFIED . ' ' . _PICAL_MB_ORDER_ASC ,
		'dtstamp DESC' => _PICAL_TH_LASTMODIFIED . ' ' . _PICAL_MB_ORDER_DESC  ,
		'uid' => _PICAL_TH_SUBMITTER . ' ' . _PICAL_MB_ORDER_ASC ,
		'uid DESC' => _PICAL_TH_SUBMITTER . ' ' . _PICAL_MB_ORDER_DESC 
	) ;
	if( isset( $_GET['order'] ) && isset( $orders[ $_GET['order'] ] ) ) $order = $_GET['order'] ;
	else $order = "start" ;

	// tzoffset
	$tzoffset = ( $this->user_TZ - $this->server_TZ ) * 3600 ;

	// カテゴリー説明文
	$cat_desc = ! empty( $this->now_cid ) && ! empty( $this->categories[ $this->now_cid ] ) ? $this->textarea_sanitizer_for_show( $this->categories[ $this->now_cid ]->cat_desc ) : '' ;

	// カテゴリー関連のWHERE条件取得
	$whr_categories = $this->get_where_about_categories() ;

	// CLASS関連のWHERE条件取得
	$whr_class = $this->get_where_about_class() ;

	// カテゴリー選択フォーム
	$categories_selform = $this->get_categories_selform( $get_target ) ;

	// 日付演算子
	$ops = array(
		'after' => _PICAL_MB_OP_AFTER ,
		'on' => _PICAL_MB_OP_ON ,
		'before' => _PICAL_MB_OP_BEFORE ,
		'all' => _PICAL_MB_OP_ALL
	) ;

	// 時差を計算しつつ、WHERE節の期間に関する条件生成
	$op = empty( $_GET['op'] ) ? '' : preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET['op'] ) ;
	$tzoffset = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
	$toptime_of_day = $this->unixtime + $this->day_start ;
	switch( $op ) {
		case 'all' :
			$whr_term = '1' ;
			break ;
		case 'before' :
			$whr_term = "(allday AND start<='$this->unixtime') OR ( ! allday AND start<='".( $toptime_of_day + 86400 - $tzoffset )."')" ;
			//$whr_term = "start<$this->unixtime" ;
			break ;
		default :
		case 'after' :
			$op = 'after' ;
			$whr_term = "(allday AND end>'$this->unixtime') OR ( ! allday AND end>'".( $toptime_of_day - $tzoffset )."')" ;
			//$whr_term = "end>$this->unixtime" ;
			break ;
		case 'on' :
			$whr_term = "(allday AND start<='$this->unixtime' AND end>'$this->unixtime') OR ( ! allday AND start<='".( $toptime_of_day + 86400 - $tzoffset )."' AND end>'".( $toptime_of_day - $tzoffset )."')" ;
			break ;
	}

	// 日付演算子の選択肢作成
	$op_options = '' ;
	foreach( $ops as $op_id => $op_title ) {
		if( $op_id == $op ) {
			$op_options .= "\t\t\t<option value='$op_id' selected='selected'>$op_title</option>\n" ;
		} else {
			$op_options .= "\t\t\t<option value='$op_id'>$op_title</option>\n" ;
		}
	}

	// 年の選択肢(2001〜2020 とする)
	$year_options = "" ;
	for( $y = 2001 ; $y <= 2020 ; $y ++ ) {
		if( $y == $this->year ) {
			$year_options .= "\t\t\t<option value='$y' selected='selected'>".sprintf(strip_tags(_PICAL_FMT_YEAR),$y)."</option>\n" ;
		} else {
			$year_options .= "\t\t\t<option value='$y'>".sprintf(strip_tags(_PICAL_FMT_YEAR),$y)."</option>\n" ;
		}
	}

	// 月の選択肢
	$month_options = "" ;
	for( $m = 1 ; $m <= 12 ; $m ++ ) {
		if( $m == $this->month ) {
			$month_options .= "\t\t\t<option value='$m' selected='selected'>{$this->month_short_names[$m]}</option>\n" ;
		} else {
			$month_options .= "\t\t\t<option value='$m'>{$this->month_short_names[$m]}</option>\n" ;
		}
	}

	// 日の選択肢
	$date_options = "" ;
	for( $d = 1 ; $d <= 31 ; $d ++ ) {
		if( $d == $this->date ) {
			$date_options .= "\t\t\t<option value='$d' selected='selected'>{$this->date_short_names[$d]}</option>\n" ;
		} else {
			$date_options .= "\t\t\t<option value='$d'>{$this->date_short_names[$d]}</option>\n" ;
		}
	}

	$ymdo_selects = sprintf( _PICAL_FMT_YMDO , "<select name='pical_year'>$year_options</select>" , "<select name='pical_month'>$month_options</select>" , "<select name='pical_date'>$date_options</select>" , "<select name='op'>$op_options</select>" ) ;

	// レコード数の取得
	$whr = "($whr_term) AND ($whr_categories) AND ($whr_class)" ;
	$yrs = mysql_query( "SELECT *,UNIX_TIMESTAMP(dtstamp) AS udtstamp , start, end, allday, start_date, end_date FROM $this->table WHERE $whr" , $this->conn ) ;
	$num_rows = mysql_num_rows( $yrs ) ;

	// 本クエリ
	$yrs = mysql_query( "SELECT *,UNIX_TIMESTAMP(dtstamp) AS udtstamp , start, end, allday, start_date, end_date FROM $this->table WHERE $whr ORDER BY $order LIMIT $pos,$num" , $this->conn ) ;

	// ページ分割処理
	include_once( XOOPS_ROOT_PATH.'/class/pagenav.php' ) ;
	$nav = new XoopsPageNav( $num_rows , $num , $pos , 'pos' , "smode=List&amp;cid=$this->now_cid&amp;num=$num&amp;order=$order&amp;op=$op&amp;caldate=$this->caldate" ) ;
	$nav_html = $nav->renderNav( 10 ) ;
	if( $num_rows <= 0 ) $nav_num_info = _NONE ;
	else if( $pos + $num > $num_rows ) $nav_num_info = ($pos+1)."-$num_rows/$num_rows" ;
	else $nav_num_info = ($pos+1).'-'.($pos+$num).'/'.$num_rows ;

	// 全体変数のアサイン
	$tpl->assign(
		array(
		'page_nav' => $nav_html ,
		'page_nav_info' => $nav_num_info ,
		'categories_selform' => $categories_selform ,
		'cat_desc' => $cat_desc ,
		'insertable' => $this->insertable ,
		'get_target' => $get_target ,
		'num' => $num ,
		'now_cid' => $this->now_cid ,
		'num_rows' => $num_rows ,
		'images_url' => $this->images_url ,
		'mod_url' => $this->base_url ,
		'caldate' => $this->caldate ,
		'op' => $op ,
		'order' => $order ,
		'user_can_output_ics' => $this->can_output_ics ,
		'print_link' => "$this->base_url/print.php?cid=$this->now_cid&amp;smode=List&amp;num=$num&amp;pos=$pos&amp;order=".urlencode($order)."&amp;caldate=$this->caldate" ,
		'pical_copyright' => PICAL_COPYRIGHT ,
		'ymdo_selects' => $ymdo_selects ,
		'calhead_bgcolor' => $this->calhead_bgcolor ,
		'calhead_color' => $this->calhead_color ,
		'alt_list' => _PICAL_ICON_LIST ,
		'alt_daily' => _PICAL_ICON_DAILY ,
		'alt_weekly' => _PICAL_ICON_WEEKLY ,
		'alt_monthly' => _PICAL_ICON_MONTHLY ,
		'alt_yearly' => _PICAL_ICON_YEARLY ,
		'alt_print' => _PICAL_BTN_PRINT ,
		'lang_checkeditems' => _PICAL_MB_LABEL_CHECKEDITEMS ,
		'lang_icalendar_output' => _PICAL_MB_LABEL_OUTPUTICS ,
		'lang_button_export' => _PICAL_BTN_EXPORT ,
		'lang_button_jump' => _PICAL_BTN_JUMP ,
		'lang_order' => $orders[ $order ] ,
		'lang_summary' => _PICAL_TH_SUMMARY ,
		'lang_startdatetime' => _PICAL_TH_STARTDATETIME ,
		'lang_enddatetime' => _PICAL_TH_ENDDATETIME ,
		'lang_location' => _PICAL_TH_LOCATION ,
		'lang_contact' => _PICAL_TH_CONTACT ,
		'lang_description' => _PICAL_TH_DESCRIPTION ,
		'lang_categories' => _PICAL_TH_CATEGORIES ,
		'lang_submitter' => _PICAL_TH_SUBMITTER ,
		'lang_class' => _PICAL_TH_CLASS ,
		'lang_rrule' => _PICAL_TH_RRULE ,
		'lang_admissionstatus' => _PICAL_TH_ADMISSIONSTATUS ,
		'lang_lastmodified' => _PICAL_TH_LASTMODIFIED ,
		'lang_cursortedby' => _PICAL_MB_CURSORTEDBY ,
		'lang_sortby' => _PICAL_MB_SORTBY )
	) ;

	// イベントアサインループ
	$count = 0 ;
	$events = array() ;
	while( $event = mysql_fetch_object( $yrs ) ) {

		if( ++ $count > $num ) break ;

		// 編集可能かどうか
		$editable = ( $this->isadmin || $event->uid == $this->user_id && $this->editable ) ;
		// 編集可能でない未承認レコードは表示しない
		if( ! $editable && $event->admission == 0 ) continue ;

		// 開始時間
		if( isset( $event->start_date ) ) {
			$start_date_desc = $event->start_date ;
			$start_time_desc = '' ;
			$start = 0 ;
		} else if( $event->allday ) {
			$start_date_desc = $this->get_long_ymdn( $event->start ) ;
			$start_time_desc = '' ;
			$start = $event->start ;
		} else {
			$start = $event->start + $tzoffset ;
			$start_date_desc = $this->get_long_ymdn( $start ) ;
			$start_time_desc = $this->get_middle_hi( $start ) ;
		}

		// 終了時間
		if( isset( $event->end_date ) ) {
			$end_date_desc = $event->end_date ;
			$end_time_desc = '' ;
			$end = 0x7fffffff ;
		} else if( $event->allday ) {
			$end_date_desc = $this->get_long_ymdn( $event->end - 300 ) ;
			$end_time_desc = '' ;
			$end = $event->end ;
		} else {
			$end = $event->end + $tzoffset ;
			$end_date_desc = $this->get_long_ymdn( $end ) ;
			$end_time_desc = $this->get_middle_hi( $end ) ;
		}

		// その他、表示用前処理
		$admission_status = $event->admission ? _PICAL_MB_EVENT_ADMITTED : _PICAL_MB_EVENT_NEEDADMIT ;
		$last_modified = $this->get_long_ymdn( $event->udtstamp - intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ) ;
		$description = $this->textarea_sanitizer_for_show( $event->description ) ;
		$summary = $this->text_sanitizer_for_show( $event->summary ) ;
		$location = $this->text_sanitizer_for_show( $event->location ) ;
		$contact = $this->text_sanitizer_for_show( $event->contact ) ;

		$events[] = array(
			'count' => $count ,
			'oddeven' => ( $count & 1 == 1 ? 'odd' : 'even' ) ,
			'summary' => $summary ,
			'location' => $location ,
			'contact' => $contact ,
			'description' => $description ,
			'admission' => $admission_status ,
			'editable' => $editable ,
			'allday' => $event->allday ,
			'start' => $start ,
			'start_date_desc' => $start_date_desc ,
			'start_time_desc' => $start_time_desc ,
			'end' => $end ,
			'end_date_desc' => $end_date_desc ,
			'end_time_desc' => $end_time_desc ,
			'post_date' => $last_modified ,
			'rrule' => $this->rrule_to_human_language( $event->rrule ) ,
			'uid' => $event->uid ,
			'submitter_info' => $this->get_submitter_info( $event->uid ) ,
			'id' => $event->id ,
			'target_id' => ( $event->rrule_pid > 0 ) ? $event->rrule_pid : $event->id
		) ;
	}
	$tpl->assign( 'events' , $events ) ;

	return true ;
}



// get public ICS via snoopy
function import_ics_via_fopen( $uri , $force_http = true , $user_uri = '' )
{
	$user_uri = empty( $user_uri ) ? '' : $uri ;
	// changing webcal://* to http://*
	$uri = str_replace( "webcal://" , "http://" , $uri ) ;

	if( $force_http ) {
		if( substr( $uri , 0 , 7 ) != 'http://' ) $uri = "http://" . $uri ;
	}

	// temporary file for store ics via http
	$ics_cache_file = XOOPS_CACHE_PATH . '/pical_getics_' . uniqid('') ;

	// http get via Snoopy
	$error_level_stored = error_reporting() ;
	error_reporting( $error_level_stored & ~ E_NOTICE ) ;
	// includes Snoopy class for remote file access
	require_once(XOOPS_ROOT_PATH."/class/snoopy.php");
	$snoopy = new Snoopy;
	// TIMEOUT from config
	// $snoopy->read_timeout = $config['snoopy_timeout'] ;
	$snoopy->read_timeout = 10 ;
	// Set proxy if needed
	if( trim( $this->proxysettings ) ) {
		list( $proxy_host , $proxy_port , $proxy_user , $proxy_pass ) = explode( ':' , $this->proxysettings ) ;
		$snoopy->proxy_host = $proxy_host ;
		$snoopy->proxy_port = $proxy_port > 0 ? intval( $proxy_port ) : 8080 ;
		$snoopy->proxy_user = $proxy_user ;
		$snoopy->proxy_pass = $proxy_pass ;
	}
	//URL fetch
	if( ! $snoopy->fetch( $uri ) || ! $snoopy->results ) {
		return "-1:Could not open uri: $uri" ;
	}

	$data = $snoopy->results ;
	error_reporting( $error_level_stored ) ;

	$fp = fopen( $ics_cache_file , "w" ) ;
	fwrite( $fp , $data ) ;
	fclose( $fp ) ;

	$ret = parent::import_ics_via_fopen( $ics_cache_file , false , $uri ) ;
	list( $records , $calname , $tmpname ) = explode( ":" , $ret , 3 ) ;
	@unlink( $ics_cache_file ) ;

	if( $records < 1 ) return "$records:$calname:$uri" ;
	else return $ret ;
}



// returns assigned array for extensible mini calendar block
function get_minical_ex( $gifaday = 2 , $just1gif = 0 , $plugins = array() )
{
	$db =& Database::getInstance() ;
	$myts =& MyTextSanitizer::getInstance() ;

	$tzoffset_s2u = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
	$now = time() ;
	$user_now_Ynj = date( 'Y-n-j' , $now + $tzoffset_s2u ) ;

	// prev_month points the tail, next_month points the head
	$prev_month = date("Y-n-j", mktime(0,0,0,$this->month,0,$this->year));
	$next_month = date("Y-n-j", mktime(0,0,0,$this->month+1,1,$this->year));

	$block = array(
		"xoops_url" => XOOPS_URL ,
		"mod_url" => $this->base_url ,
		"root_url" => '' ,

		"skinpath" => $this->images_url ,
		"frame_css" => $this->frame_css ,
		"month_name" => $this->month_middle_names[ $this->month ] ,
		"year_month_title" => sprintf( _PICAL_FMT_YEAR_MONTH , $this->year , $this->month_middle_names[ $this->month ] ) ,
		"prev_month" => $prev_month ,
		"next_month" => $next_month ,
		"lang_prev_month" => _PICAL_MB_PREV_MONTH ,
		"lang_next_month" => _PICAL_MB_NEXT_MONTH ,

		"calhead_bgcolor" => $this->calhead_bgcolor ,
		"calhead_color" => $this->calhead_color ,
	) ;

	$first_date = getdate(mktime(0,0,0,$this->month,1,$this->year));
	$date = ( - $first_date['wday'] + $this->week_start - 7 ) % 7 ;
	$wday_end = 7 + $this->week_start ;

	// Loop of weeknames
	$daynames = array() ;
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

		// assigning weeknames
		$daynames[] = array(
			"bgcolor" => $bgcolor ,
			"color" => $color ,
			"dayname" => $this->week_short_names[ $wday % 7 ] ,
		) ;
	}
	$block['daynames'] = $daynames ;

	// get the result of plugins
	$plugin_returns = array() ;
	$tzoffset_s2u = intval( ( $this->user_TZ - $this->server_TZ ) * 3600 ) ;
	$block['plugins'] = $plugins ;
	foreach( $plugins as $plugin ) {
		$plugin_fullpath = $this->base_path . '/' . $this->plugins_path_monthly . '/' . $plugin['file'] ;
		if( file_exists( $plugin_fullpath ) ) {
			include $plugin_fullpath ;
		}
	}

	// Loop of week (row)
	$weeks = array() ;
	for( $week = 0 ; $week < 6 ; $week ++ ) {
		$days = array() ;
		// Loop of day (col)
		for( $wday = $this->week_start ; $wday < $wday_end ; $wday ++ ) {
			$date ++ ;

			$time = mktime( 0 , 0 , 0 , $this->month , $date , $this->year ) ;

			// Out of the month
			if( ! checkdate( $this->month , $date , $this->year ) ) {
				$days[] = array(
					"date" => date( 'j' , $time ) ,
					"type" => 0
				) ;
				continue ;
			}

			$link = "$this->year-$this->month-$date" ;

			// COLORS of days
			if( isset( $this->holidays[$link] ) ) {
				// Holiday
				$bgcolor = $this->holiday_bgcolor ;
				$color = $this->holiday_color ;
			} elseif( $wday % 7 == 0 ) { 
				// Sunday
				$bgcolor = $this->sunday_bgcolor ;
				$color = $this->sunday_color ;
			} elseif( $wday == 6 ) { 
				// Saturday
				$bgcolor = $this->saturday_bgcolor ;
				$color = $this->saturday_color ;
			} else { 
				// Weekday
				$bgcolor = $this->weekday_bgcolor ;
				$color = $this->weekday_color ;
			}

			// Hi-Lighting the SELECTED DATE
			if( $link == $user_now_Ynj ) $bgcolor = $this->targetday_bgcolor ;

			// Preparing the returns from plugins
			$ex = empty( $plugin_returns[ $date ] ) ? array() : array_slice( $plugin_returns[ $date ] , 0 , $gifaday ) ;
			// if( ! empty( $ex ) ) var_dump( $ex ) ;

			// Assigning attribs of the day
			$days[] = array(
				"bgcolor" => $bgcolor ,
				"color" => $color ,
				"link" => $link ,
				"date" => $date ,
				"type" => 1 ,
				"ex" => $ex
			) ;
		}
		$weeks[] = $days ;
	}
	$block['weeks'] = $weeks ;

	return $block ;
}



// 指定されたtypeのプラグイン配列を返す
function get_plugins( $type )
{
	global $xoopsDB , $xoopsUser ;

	// MyTextSanitizer
	$myts =& MyTextSanitizer::getInstance();

	// allowed modules
	$moduleperm_handler =& xoops_gethandler('groupperm');
	$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
	$allowed_mids = $moduleperm_handler->getItemIds('module_read', $groups);

	// plugins
	$plugins = array() ;
	$prs = $xoopsDB->query( "SELECT pi_title,pi_dirname AS dirname,pi_file AS file,pi_dotgif AS dotgif,pi_options AS options FROM $this->plugin_table WHERE pi_type='".addslashes($type)."' AND pi_enabled ORDER BY pi_weight" ) ;
	while( $plugin = $xoopsDB->fetchArray( $prs ) ) {
		$dirname4sql = addslashes( $plugin['dirname'] ) ;
		$mrs = $xoopsDB->query( "SELECT mid,name FROM ".$xoopsDB->prefix("modules")." WHERE dirname='$dirname4sql'" ) ;
		if( $mrs && $xoopsDB->getRowsNum( $mrs ) ) {
			list( $mid , $name ) = $xoopsDB->fetchRow( $mrs ) ;
			if( ! in_array( $mid , $allowed_mids ) ) continue ;
			$plugin['pi_title'] = $myts->makeTboxData4Show( $plugin['pi_title'] ) ;
			$plugin['name'] = $myts->makeTboxData4Show( $name ) ;
			$plugin['mid'] = $mid ;
			$plugins[] = $plugin ;
		}
	}

	return $plugins ;
}



// The End of Class
}

}

?>