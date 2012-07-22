<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_AM_LOADED' ) ) {






// Appended by Xoops Language Checker -GIJOE- in 2007-02-04 05:11:47
define('_AM_PICAL_DBUPDATED','Database Updated Successfully!');
define('_AM_PICAL_PERMADDNG','Could not add %s permission to %s for group %s');
define('_AM_PICAL_PERMADDOK','Added %s permission to %s for group %s');
define('_AM_PICAL_PERMRESETNG','Could not reset group permission for module %s');
define('_AM_PICAL_PERMADDNGP','All parent items must be selected.');

// Appended by Xoops Language Checker -GIJOE- in 2005-06-29 17:19:29
define('_AM_PI_TH_OPTIONS','Options (usually blank)');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-24 19:05:05
define('_AM_TZOPT_SERVER','As server timezone');
define('_AM_TZOPT_GMT','As GMT');
define('_AM_TZOPT_USER','As user\'s timezone');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-06 18:04:00
define('_AM_FMT_SERVER_TZ_ALL','Timezone of the server (winter): %+2.1f<br />Timezone of the server (summer): %+2.1f<br />Zonename of the server: %s<br />The value of XOOPS config: %+2.1f<br />The value of piCal using: %+2.1f<br />');

// Appended by Xoops Language Checker -GIJOE- in 2005-05-03 05:31:13
define('_AM_FMT_SERVER_TZ_SYSTEM','Timezone in winter: %+2.1f');
define('_AM_TH_SERVER_TZ_COUNT','Events');
define('_AM_TH_SERVER_TZ_VALUE','Timezone');
define('_AM_TH_SERVER_TZ_VALUE_TO','Changes (-14.0¡Á14.0)');
define('_AM_JSALRT_SERVER_TZ','Don\'t forget backing-up events table before this operation');
define('_AM_NOTICE_SERVER_TZ','If your server set the timezone area with summer time (=Day Light Saving) and some events were registerd in piCal 0.6x or 0.7x, dont\'t push this button.<br />eg) It is natural to display both -5.0 and -4.0 in EDT');
define('_AM_MB_SUCCESSTZUPDATE','Events are modified with the timezone(s).');
define('_AM_PI_UPDATED','Plugins are updated');
define('_AM_PI_TH_TYPE','Type');
define('_AM_PI_TH_TITLE','Title');
define('_AM_PI_TH_DIRNAME','Module\'s dirname');
define('_AM_PI_TH_FILE','Plugin file');
define('_AM_PI_TH_DOTGIF','Dot GIF');
define('_AM_PI_TH_OPERATION','Operation');
define('_AM_PI_ENABLED','Enabled');
define('_AM_PI_DELETE','Delete');
define('_AM_PI_NEW','New');
define('_AM_PI_VIEWYEARLY','Yearly View');
define('_AM_PI_VIEWMONTHLY','Monthly View');
define('_AM_PI_VIEWWEEKLY','Weekly View');
define('_AM_PI_VIEWDAILY','Daily View');

define( 'PICAL_AM_LOADED' , 1 ) ;


// titles

// Appended by Xoops Language Checker -GIJOE- in 2004-06-22 18:39:03
define('_AM_OPT_PAST','Past');
define('_AM_OPT_FUTURE','Future');
define('_AM_OPT_PASTANDFUTURE','Past&Future');

define("_AM_CONFIG","piCal-configuratie");
define("_AM_GENERALCONF","Instellingen");
define("_AM_ADMISSION","Activiteitsvrijgave");
define("_AM_ICALENDAR_IO","iCalendar I/O");
define("_AM_ICALENDAR_IMPORT","Import iCalendar");
define("_AM_ICALENDAR_EXPORT","Export iCalendar");
define("_AM_GROUPPERM","Groepsrechten");

// forms
define("_AM_BUTTON_EXTRACT","Filteren");
define("_AM_BUTTON_ADMIT","Vrijgeven");
define("_AM_CONFIRM_DELETE","Verwijderen OK?");

// admission
define("_AM_LABEL_ADMIT","Geselecteerde activiteit: ");
define("_AM_MES_ADMITTED","Activiteit wordt vrijgegeven");
define("_AM_ADMIT_TH0","Gebruiker");
define("_AM_ADMIT_TH1","Begin");
define("_AM_ADMIT_TH2","Eind");
define("_AM_ADMIT_TH3","Titel");
define("_AM_ADMIT_TH4","Terugkeerpatroon");

// iCalendar I/O

define("_AM_LABEL_IMPORTFROMWEB","iCalendar Data vanuit het web importeren (URL begint met 'http://' of 'webcal://')");
define("_AM_LABEL_UPLOADFROMFILE","iCalendar Data uploaden (lokaal bestand)");
define("_AM_BUTTON_IMPORT","Importeren");
define("_AM_BUTTON_UPLOAD","Uploaden");
define("_AM_LABEL_IO_CHECKEDITEMS","Geselecteerde activiteiten:");
define("_AM_LABEL_IO_OUTPUT","worden naar iCalendar geexporteerd");
define("_AM_LABEL_IO_SELECTPLATFORM","Platform selecteren");
define("_AM_LABEL_IO_DELETE","worden verwijderd");
define("_AM_MES_DELETED","Activiteiten worden verwijderd");
define("_AM_IO_TH0","Gebruiker");
define("_AM_IO_TH1","Begin");
define("_AM_IO_TH2","Eind");
define("_AM_IO_TH3","Titel");
define("_AM_IO_TH4","Terugkeerpatroon");
define("_AM_IO_TH5","Vrijgeven");

// Group's Permissions
define( '_AM_GPERM_G_INSERTABLE' , "mogen toevoegen" ) ;
define( '_AM_GPERM_G_SUPERINSERT' , "mogen toevoegen (superinsert!)" ) ;
define( '_AM_GPERM_G_EDITABLE' , "mogen editeren" ) ;
define( '_AM_GPERM_G_SUPEREDIT' , "mogen editeren (superedit!)" ) ;
define( '_AM_GPERM_G_DELETABLE' , "mogen verwijderen") ;
define( '_AM_GPERM_G_SUPERDELETE' , "mogen verwijderen (superdelete!)" ) ;
define( '_AM_GPERM_G_TOUCHOTHERS' , "mogen ingaves van anderen wijzigen" ) ;
define( '_AM_GROUPPERMDESC' , "Hier kunnen de rechten van elke gebruikersgroep apart ingesteld worden.<br />Om deze functie te activeren, moet u eerst onder 'Instellingen -> Rechten voor gebruikers' de optie 'Vastgelegd door groepsrechten' selecteren. <br />Opmerking: de instellingen voor de groepen, 'Webmasters' en 'Anonymous Users' worden genegeerd.<br/>" ) ;


// Appended by Xoops Language Checker -GIJOE- in 2003-11-14 16:47:58
define('_AM_DTFMT_LIST_ALLDAY','y-m-d');
define('_AM_DTFMT_LIST_NORMAL','y-m-d<\b\r />H:i');

// Appended by Xoops Language Checker -GIJOE- in 2003-12-05 14:18:43
define('_AM_MYBLOCKSADMIN','piCal\'s Block&Group admin');

// Appended by Xoops Language Checker -GIJOE- in 2004-01-14 18:31:01
define('_AM_MENU_EVENTS','Events Manager');
define('_AM_MENU_CATEGORIES','Categories Manager');
define('_AM_MENU_CAT2GROUP','Category\'s Permission');
define('_AM_TABLEMAINTAIN','Table Maintenance (Upgrade)');
define('_AM_BUTTON_MOVE','Move');
define('_AM_BUTTON_COPY','Copy');
define('_AM_CONFIRM_MOVE','Remove a link to the old category and Add a link to the specified category OK?');
define('_AM_CONFIRM_COPY','Add a link to specified category OK?');
define('_AM_BUTTON_EXPORT','Export!');
define('_AM_MES_EVENTLINKTOCAT','event(s) has been linked to this category');
define('_AM_MES_EVENTUNLINKED','event(s) has been removed a link to the old category');
define('_AM_FMT_IMPORTED','event(s) has been imported from \'%s\'');
define('_AM_CAT2GROUPDESC','Check categories which you allow to access');
define('_AM_MB_SUCCESSUPDATETABLE','Updating table(s) is succeeded');
define('_AM_MB_FAILUPDATETABLE','Updating table(s) is failed');
define('_AM_NOTICE_NOERRORS','There is no error with tables or records.');
define('_AM_ALRT_CATTABLENOTEXIST','The categories table does not exist.<br />
Do you create the table ?');
define('_AM_ALRT_OLDTABLE','The structure of events table is old.<br />
Do you upgrade the table ?');
define('_AM_ALRT_TOOOLDTABLE','Table error occured.<br />
Perhaps you used piCal 0.3x or earlier.<br />
At first, update into 0.4x or 0.5x.');
define('_AM_FMT_WRONGSTZ','There are %s event(s) which is recorded with wrong timezone.<br />Do you repair them ?');
define('_AM_CAT_TH_TITLE','Title');
define('_AM_CAT_TH_DESC','Description');
define('_AM_CAT_TH_PARENT','Parent Category');
define('_AM_CAT_TH_OPTIONS','Options');
define('_AM_CAT_TH_LASTMODIFY','Last Modified');
define('_AM_CAT_TH_OPERATION','Operation');
define('_AM_CAT_TH_ENABLED','Enable');
define('_AM_CAT_TH_WEIGHT','Weight');
define('_AM_CAT_TH_SUBMENU','register in SubMenu');
define('_AM_BTN_UPDATE','UPDATE');
define('_AM_MENU_CAT_EDIT','Editing a Category');
define('_AM_MENU_CAT_NEW','Create a new Category');
define('_AM_MB_MAKESUBCAT','SubCategory');
define('_AM_MB_MAKETOPCAT','Create a category in a top level');
define('_AM_MB_CAT_INSERTED','New Category created');
define('_AM_MB_CAT_UPDATED','Category updated');
define('_AM_FMT_CAT_DELETED','%s Categories deleted');
define('_AM_FMT_CAT_BATCHUPDATED','%s Categories updated');
define('_AM_FMT_CATDELCONFIRM','Do you want to delete category %s ?');

}

?>