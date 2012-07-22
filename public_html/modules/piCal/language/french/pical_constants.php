<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_CNST_LOADED' ) ) {

define( 'PICAL_CNST_LOADED' , 1 ) ;

// the language file for jscalendar "DHTML Date/Time Selector"
define('_PICAL_JS_CALENDAR','calendar-en.js');

// format for jscalendar. see common/jscalendar/doc/html/reference.html
define('_PICAL_JSFMT_YMDN','%d %B %Y (%A)');

// format for date()  see http://jp.php.net/date
define('_PICAL_DTFMT_MINUTE','i');

// definition of orders     Y:year  M:month  W:week  D:day  N:dayname  O:operand
define('_PICAL_FMT_MD','%1$s %2$s') ;
define('_PICAL_FMT_YMD','%1$s %2$s %3$s') ;
define('_PICAL_FMT_YMDN','%3$s %2$s %1$s %4$s');
define('_PICAL_FMT_YMDO','%4$s%3$s%2$s%1$s');
define('_PICAL_FMT_YMW','%1$s %2$s %3$s') ;
define('_PICAL_FMT_YW','SEMAINE%2$s %1$s');
define('_PICAL_FMT_DHI','%1$s %2$s:%3$s');
define('_PICAL_FMT_HI','%1$s:%2$s');

// formats for sprintf()
define('_PICAL_FMT_YEAR_MONTH','%1$s %2$s') ;
define('_PICAL_FMT_YEAR','<font size="-1">ANNEE </font>%s') ;
define('_PICAL_FMT_WEEKNO','SEMAINE %s');

define('_PICAL_ICON_LIST','Vue Liste');
define('_PICAL_ICON_DAILY','Vue Journali&egrave;re') ;
define('_PICAL_ICON_WEEKLY','Vue Hebdomadaire') ;
define('_PICAL_ICON_MONTHLY','Vue Mensuelle') ;
define('_PICAL_ICON_YEARLY','Vue Annuelle') ;

define('_PICAL_MB_SHOWALLCAT','Toutes les cat&eacute;gories');

define("_PICAL_MB_LINKTODAY","Aujourd'hui") ;
define('_PICAL_MB_NOSUBJECT','(Pas de Sujet)') ;
define('_PICAL_MB_PREV_DATE','Hier') ;
define('_PICAL_MB_NEXT_DATE','Demain') ;
define('_PICAL_MB_PREV_WEEK','Semaine pr&eacute;c&eacute;dente') ;
define('_PICAL_MB_NEXT_WEEK','Semaine suivante') ;
define('_PICAL_MB_PREV_MONTH','Mois pr&eacute;c&eacute;dent') ;
define('_PICAL_MB_NEXT_MONTH','Mois suivant') ;
define('_PICAL_MB_PREV_YEAR','Ann&eacute;e pr&eacute;c&eacute;dente') ;
define('_PICAL_MB_NEXT_YEAR','Ann&eacute;e suivante') ;

define("_PICAL_MB_NOEVENT","Pas d'&eacute;v&egrave;nements") ;
define('_PICAL_MB_ADDEVENT','Ajouter un &eacute;v&egrave;nement') ;
define('_PICAL_MB_CONTINUING','(continuer)') ;
define('_PICAL_MB_RESTEVENT_PRE','plus') ;
define('_PICAL_MB_RESTEVENT_SUF','plus d\'&eacute;l&eacute;ment(s)') ;
define('_PICAL_MB_TIMESEPARATOR','--') ;

define('_PICAL_MB_ALLDAY_EVENT','Journ&eacute;e Enti&egrave;re') ;
define('_PICAL_MB_LONG_EVENT','Afficher via une barre') ;
define('_PICAL_MB_LONG_SPECIALDAY','Afficher comme un Jour Sp&eacute;cial (Anniv. par exemple)') ;

define('_PICAL_MB_PUBLIC','Public') ;
define('_PICAL_MB_PRIVATE','Priv&eacute;') ;
define('_PICAL_MB_PRIVATETARGET',' parmi %s') ;

define("_PICAL_MB_LINK_TO_RRULE1ST","Sauter jusqu'au premier &eacute;v&egrave;nement ") ;
define("_PICAL_MB_RRULE1ST","C'est le premier &eacute;v&egrave;nement") ;

define('_PICAL_MB_EVENT_NOTREGISTER','Non enregistr&eacute;') ;
define('_PICAL_MB_EVENT_ADMITTED','Approuv&eacute;') ;
define("_PICAL_MB_EVENT_NEEDADMIT","En attente d'approbation") ;

define('_PICAL_MB_TITLE_EVENTINFO',"Informations sur l'&eacute;v&egrave;nement") ;
define('_PICAL_MB_SUBTITLE_EVENTDETAIL',"D&eacute;tails de l'&eacute;v&egrave;nement") ;
define('_PICAL_MB_SUBTITLE_EVENTEDIT',"Editer l'&eacute;v&egrave;nement") ;

define('_PICAL_MB_HOUR_SUF',':') ;
define('_PICAL_MB_MINUTE_SUF','') ;

define('_PICAL_MB_ORDER_ASC','Croissant');
define('_PICAL_MB_ORDER_DESC','D&eacute;croissant');
define('_PICAL_MB_SORTBY','Tri&eacute; par:');
define('_PICAL_MB_CURSORTEDBY','Ev&egrave;nements actuellement tri&eacute;s par:');

define('_PICAL_MB_LABEL_CHECKEDITEMS','Les &eacute;v&eacute;nements coch&eacute;s sont:');
define('_PICAL_MB_LABEL_OUTPUTICS','Exporter dans iCalendar');

define('_PICAL_MB_ICALSELECTPLATFORM','S&eacute;lectionner la plateforme');


define('_PICAL_TH_SUMMARY','Intitul&eacute;') ;
define('_PICAL_TH_TIMEZONE','Fuseau Horaire') ;
define('_PICAL_TH_STARTDATETIME','Date/Heure de d&eacute;but') ;
define('_PICAL_TH_ENDDATETIME','Date/Heure de fin') ;
define('_PICAL_TH_ALLDAYOPTIONS','Option Journ&eacute;e Enti&egrave;re') ;
define('_PICAL_TH_LOCATION','Lieu') ;
define('_PICAL_TH_CONTACT','Contact') ;
define('_PICAL_TH_CATEGORIES','Cat&eacute;gories');
define('_PICAL_TH_SUBMITTER','Auteur');
define('_PICAL_TH_CLASS','Type') ;
define('_PICAL_TH_DESCRIPTION','Description') ;
define('_PICAL_TH_RRULE','P&eacute;riodicit&eacute;') ;
define('_PICAL_TH_ADMISSIONSTATUS','Statut') ;
define('_PICAL_TH_LASTMODIFIED','Derni&egrave;re modification');

define("_PICAL_NTC_MONTHLYBYMONTHDAY","(Num&eacute;ro d'entr&eacute;e)") ;
define('_PICAL_NTC_EXTRACTLIMIT','** Seulement %s &eacute;v&egrave;nements au maximum sont g&eacute;n&eacute;r&eacute;s.') ;
define("_PICAL_NTC_NUMBEROFNEEDADMIT","(%s &eacute;l&eacute;ments n&eacute;cessitent une approbation)") ;

define('_PICAL_OPT_PRIVATEMYSELF','seulement moi') ;
define('_PICAL_OPT_PRIVATEGROUP','groupe %s') ;
define('_PICAL_OPT_PRIVATEINVALID','(groupe invalide)') ;

define('_PICAL_MB_OP_AFTER','Apr&egrave;s');
define('_PICAL_MB_OP_BEFORE','Avant');
define('_PICAL_MB_OP_ON','Sur');
define('_PICAL_MB_OP_ALL','Tout');

define("_PICAL_CNFM_SAVEAS_YN","Etes-vous d'accord pour sauvegarder ceci comme nouvel enregistrement ?") ;
define("_PICAL_CNFM_DELETE_YN","Etes-vous d'accord pour supprimer cet enregistrement ?") ;

define('_PICAL_ERR_INVALID_EVENT_ID','Erreur: EventID non trouv&eacute;') ;
define('_PICAL_ERR_NOPERM_TO_SHOW',"Erreur: Vous n'avez pas la permission de voir") ;
define('_PICAL_ERR_NOPERM_TO_OUTPUTICS',"Erreur: Vous n'avez pas la permission d'extraire iCalendar") ;
define("_PICAL_ERR_LACKINDISPITEM","L'&eacute;l&eacute;ment %s est vide.<br />Retournez en cliquant sur le bouton Pr&eacute;c&eacute;dent de notre navigateur web") ;

define('_PICAL_BTN_JUMP','Saut') ;
define('_PICAL_BTN_NEWINSERTED','Nouvelle insertion') ;
define('_PICAL_BTN_SUBMITCHANGES',' Modifier! ') ;
define('_PICAL_BTN_SAVEAS','Sauvegarder sous') ;
define('_PICAL_BTN_DELETE','Effacer') ;
define('_PICAL_BTN_DELETE_ONE','Supprimer seulement un seul enregistrement');
define('_PICAL_BTN_EDITEVENT','Editer') ;
define('_PICAL_BTN_RESET','R&eacute;initialiser') ;
define('_PICAL_BTN_OUTPUTICS_WIN','iCalendar(Win)') ;
define('_PICAL_BTN_OUTPUTICS_MAC','iCalendar(Mac)') ;
define('_PICAL_BTN_PRINT','Imprimer');
define('_PICAL_BTN_IMPORT','Importer!');
define('_PICAL_BTN_UPLOAD','Uploader!');
define('_PICAL_BTN_EXPORT','Exporter!');
define('_PICAL_BTN_EXTRACT','Extraire');
define('_PICAL_BTN_ADMIT','Accepter');
define('_PICAL_BTN_MOVE','D&eacute;placer');
define('_PICAL_BTN_COPY','Copier');

define('_PICAL_RR_EVERYDAY','Chaque jour') ;
define('_PICAL_RR_EVERYWEEK','Chaque semaine') ;
define('_PICAL_RR_EVERYMONTH','Chaque mois') ;
define('_PICAL_RR_EVERYYEAR','Chaque ann&eacute;e') ;
define('_PICAL_RR_FREQDAILY','Journalier') ;
define('_PICAL_RR_FREQWEEKLY','Hebdomadaire') ;
define('_PICAL_RR_FREQMONTHLY','Mensuel') ;
define('_PICAL_RR_FREQYEARLY','Annuel') ;
define('_PICAL_RR_FREQDAILY_PRE','Pendant ') ;
define('_PICAL_RR_FREQWEEKLY_PRE','Pendant ') ;
define('_PICAL_RR_FREQMONTHLY_PRE','Pendant ') ;
define('_PICAL_RR_FREQYEARLY_PRE','Pendant ') ;
define('_PICAL_RR_FREQDAILY_SUF','jour(s)') ;
define('_PICAL_RR_FREQWEEKLY_SUF','semaine(s)') ;
define('_PICAL_RR_FREQMONTHLY_SUF','mois') ;
define('_PICAL_RR_FREQYEARLY_SUF','ann&eacute;e(s)') ;
define('_PICAL_RR_PERDAY','tous les %s jours') ;
define('_PICAL_RR_PERWEEK','toutes les %s semaines') ;
define('_PICAL_RR_PERMONTH','tous les %s mois') ;
define('_PICAL_RR_PERYEAR','tous les %s ans') ;
define('_PICAL_RR_COUNT','<br />%s fois') ;
define("_PICAL_RR_UNTIL","<br />jusqu'&agrave; %s") ;
define('_PICAL_RR_R_NORRULE','R&eacute;currence Non') ;
define('_PICAL_RR_R_YESRRULE','R&eacute;currence Oui') ;
define('_PICAL_RR_OR','ou') ;
define('_PICAL_RR_S_NOTSELECTED','- non s&eacute;lectionn&eacute; -') ;
define('_PICAL_RR_S_SAMEASBDATE','Identique &agrave; la date de d&eacute;but') ;
define('_PICAL_RR_R_NOCOUNTUNTIL','Pas de conditions de fin') ;
define('_PICAL_RR_R_USECOUNT_PRE','r&eacute;p&eacute;ter') ;
define('_PICAL_RR_R_USECOUNT_SUF','fois') ;
define("_PICAL_RR_R_USEUNTIL","jusqu'&agrave;") ;

}

?>