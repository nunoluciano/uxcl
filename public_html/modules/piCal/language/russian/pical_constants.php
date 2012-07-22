<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_CNST_LOADED' ) ) {

define( 'PICAL_CNST_LOADED' , 1 ) ;

// the language file for jscalendar "DHTML Date/Time Selector"
define('_PICAL_JS_CALENDAR','calendar-ru_win_.js');

// format for jscalendar. see common/jscalendar/doc/html/reference.html
define('_PICAL_JSFMT_YMDN','%e %B %Y %A') ;

// format for date()  see http://jp.php.net/date
define('_PICAL_DTFMT_MINUTE','i') ;

// definition of orders     Y:year  M:month  W:week  D:day  N:dayname  O:operand
define('_PICAL_FMT_MD','%2$s %1$s') ;
define('_PICAL_FMT_YMD','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YMDN','%3$s %2$s %1$s %4$s') ;
define('_PICAL_FMT_YMDO','%4$s%3$s%2$s%1$s') ;
define('_PICAL_FMT_YMW','%3$s %2$s %1$s') ;
define('_PICAL_FMT_YW','%2$s Неделя %1$s') ;
define('_PICAL_FMT_DHI','%1$s %2$s:%3$s') ;
define('_PICAL_FMT_HI','%1$s:%2$s') ;

// formats for sprintf()
define('_PICAL_FMT_YEAR_MONTH','%2$s %1$s') ;
define('_PICAL_FMT_YEAR','Год %s') ;
define('_PICAL_FMT_WEEKNO','Неделя %s') ;

define('_PICAL_ICON_LIST','Список событий') ;
define('_PICAL_ICON_DAILY','День') ;
define('_PICAL_ICON_WEEKLY','Неделя') ;
define('_PICAL_ICON_MONTHLY','Месяц') ;
define('_PICAL_ICON_YEARLY','Год') ;

define('_PICAL_MB_SHOWALLCAT','Все категории') ;

define('_PICAL_MB_LINKTODAY','Сегодня') ;
define('_PICAL_MB_NOSUBJECT','(Нет названия)') ;

define('_PICAL_MB_PREV_DATE','Вчера') ;
define('_PICAL_MB_NEXT_DATE','Завтра') ;
define('_PICAL_MB_PREV_WEEK','Предыдущая неделя') ;
define('_PICAL_MB_NEXT_WEEK','Следующая неделя') ;
define('_PICAL_MB_PREV_MONTH','Предыдущий месяц') ;
define('_PICAL_MB_NEXT_MONTH','Следующий месяц') ;
define('_PICAL_MB_PREV_YEAR','Предыдущий год') ;
define('_PICAL_MB_NEXT_YEAR','Следующий год') ;

define('_PICAL_MB_NOEVENT','Нет событий') ;
define('_PICAL_MB_ADDEVENT','Добавить событие') ;
define('_PICAL_MB_CONTINUING','(идет)') ;
define('_PICAL_MB_RESTEVENT_PRE','еще') ;
define('_PICAL_MB_RESTEVENT_SUF','событий') ;
define('_PICAL_MB_TIMESEPARATOR','--') ;

define('_PICAL_MB_ALLDAY_EVENT','Целый день') ;
define('_PICAL_MB_LONG_EVENT','Показывать линией') ;
define('_PICAL_MB_LONG_SPECIALDAY','Празднование и т.д.') ;

define('_PICAL_MB_PUBLIC','Для всех') ;
define('_PICAL_MB_PRIVATE','Приватное') ;
define('_PICAL_MB_PRIVATETARGET',' для %s') ;

define('_PICAL_MB_LINK_TO_RRULE1ST','Перейти к 1-му событию ') ;
define('_PICAL_MB_RRULE1ST','Первое событие') ;

define('_PICAL_MB_EVENT_NOTREGISTER','Не зарегистрировано') ;
define('_PICAL_MB_EVENT_ADMITTED','Подтверждено') ;
define('_PICAL_MB_EVENT_NEEDADMIT','В ожидании подтверждения') ;

define('_PICAL_MB_TITLE_EVENTINFO','Событие') ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL','Детальный просмотр') ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT','Редактирование') ;

define('_PICAL_MB_HOUR_SUF',':') ;
define('_PICAL_MB_MINUTE_SUF','') ;

define('_PICAL_MB_ORDER_ASC','по возрастанию') ;
define('_PICAL_MB_ORDER_DESC','по убыванию') ;
define('_PICAL_MB_SORTBY','Сортировать:') ;
define('_PICAL_MB_CURSORTEDBY','События сортируются:') ;

define("_PICAL_MB_LABEL_CHECKEDITEMS","Выбранные события:");
define("_PICAL_MB_LABEL_OUTPUTICS","");

define("_PICAL_MB_ICALSELECTPLATFORM","Выберите платформу");

define('_PICAL_TH_SUMMARY','Название') ;
define('_PICAL_TH_TIMEZONE','Часовой пояс') ;
define('_PICAL_TH_STARTDATETIME','Дата начала') ;
define('_PICAL_TH_ENDDATETIME','Дата окончания') ;
define('_PICAL_TH_ALLDAYOPTIONS','Событие длится целый день?') ;
define('_PICAL_TH_LOCATION','Место') ;
define('_PICAL_TH_CONTACT','Контакты') ;
define('_PICAL_TH_CATEGORIES','Категории') ;
define('_PICAL_TH_SUBMITTER','Автор') ;
define('_PICAL_TH_CLASS','Уровень') ;
define('_PICAL_TH_DESCRIPTION','Описание') ;
define('_PICAL_TH_RRULE','Правило повтора') ;
define('_PICAL_TH_ADMISSIONSTATUS','Статус') ;
define('_PICAL_TH_LASTMODIFIED','Дата последнего изменения') ;

define('_PICAL_NTC_MONTHLYBYMONTHDAY','день месяца') ;
define('_PICAL_NTC_EXTRACTLIMIT','** Только %s событий если max.') ;
define('_PICAL_NTC_NUMBEROFNEEDADMIT','(%s необходимо подтвердить)') ;

define('_PICAL_OPT_PRIVATEMYSELF','себя') ;
define('_PICAL_OPT_PRIVATEGROUP','группы %s') ;
define('_PICAL_OPT_PRIVATEINVALID','(неправильная группа)') ;

define('_PICAL_MB_OP_AFTER','После') ;
define('_PICAL_MB_OP_BEFORE','До') ;
define('_PICAL_MB_OP_ON','В') ;
define('_PICAL_MB_OP_ALL','Все') ;

define('_PICAL_CNFM_SAVEAS_YN','Вы хотите сохранить как отдельную запись?') ;
define('_PICAL_CNFM_DELETE_YN','Вы хотите удалить запись?') ;

define('_PICAL_ERR_INVALID_EVENT_ID','Ошибка: Событие не найдено') ;
define('_PICAL_ERR_NOPERM_TO_SHOW',"Ошибка: У вас нет прав на просмотр") ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS',"Ошибка: У вас нет прав экспорта в iCalendar") ;
define('_PICAL_ERR_LACKINDISPITEM','Пункт %s пуст.<br />Нажмите кнопку Назад') ;

define('_PICAL_BTN_JUMP','Перейти') ;
define('_PICAL_BTN_NEWINSERTED','Создать') ;
define('_PICAL_BTN_SUBMITCHANGES',' Изменить! ') ;
define('_PICAL_BTN_SAVEAS','Сохранить как') ;
define('_PICAL_BTN_DELETE','Удалить всю серию') ;
define('_PICAL_BTN_DELETE_ONE','Удалить это событие') ;
define('_PICAL_BTN_EDITEVENT','Редактировать') ;
define('_PICAL_BTN_RESET','Очистить') ;
define('_PICAL_BTN_OUTPUTICS_WIN','iCalendar(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','iCalendar(Mac)') ;
define('_PICAL_BTN_PRINT','Печать') ;
define("_PICAL_BTN_IMPORT","Импортировать!");
define("_PICAL_BTN_UPLOAD","Загрузить!");
define("_PICAL_BTN_EXPORT","Зкспортировать!");
define("_PICAL_BTN_EXTRACT","Вырезать");
define("_PICAL_BTN_ADMIT","Одобрить");
define("_PICAL_BTN_MOVE","Переместить");
define("_PICAL_BTN_COPY","Копировать");

define('_PICAL_RR_EVERYDAY','Ежедневно') ;
define('_PICAL_RR_EVERYWEEK','Еженедельно') ;
define('_PICAL_RR_EVERYMONTH','Ежемесячно') ;
define('_PICAL_RR_EVERYYEAR','Ежегодно') ;
define('_PICAL_RR_FREQDAILY','Ежедневно') ;
define('_PICAL_RR_FREQWEEKLY','Еженедельно') ;
define('_PICAL_RR_FREQMONTHLY','Ежемесячно') ;
define('_PICAL_RR_FREQYEARLY','Ежегодно') ;
define('_PICAL_RR_FREQDAILY_PRE','Каждый') ;
define('_PICAL_RR_FREQWEEKLY_PRE','Каждую') ;
define('_PICAL_RR_FREQMONTHLY_PRE','Каждый') ;
define('_PICAL_RR_FREQYEARLY_PRE','Каждый') ;
define('_PICAL_RR_FREQDAILY_SUF','день') ;
define('_PICAL_RR_FREQWEEKLY_SUF','неделю') ;
define('_PICAL_RR_FREQMONTHLY_SUF','месяц') ;
define('_PICAL_RR_FREQYEARLY_SUF','год') ;
define('_PICAL_RR_PERDAY','каждые %s дней') ;
define('_PICAL_RR_PERWEEK','каждые %s недели') ;
define('_PICAL_RR_PERMONTH','каждые %s месяцев') ;
define('_PICAL_RR_PERYEAR','каждый %s лет') ;
define('_PICAL_RR_COUNT','<br />%s раз') ;
define('_PICAL_RR_UNTIL','<br />до %s') ;
define('_PICAL_RR_R_NORRULE','Не повторяемое') ;
define('_PICAL_RR_R_YESRRULE','Повторяемое') ;
define('_PICAL_RR_OR','или') ;
define('_PICAL_RR_S_NOTSELECTED','---') ;
define('_PICAL_RR_S_SAMEASBDATE','Тот же день') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','Нет условий окончания') ;
define('_PICAL_RR_R_USECOUNT_PRE','повторов') ;
define('_PICAL_RR_R_USECOUNT_SUF','раз') ;
define('_PICAL_RR_R_USEUNTIL','до') ;


}

?>