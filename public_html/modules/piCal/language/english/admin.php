<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'PICAL_AM_LOADED' ) ) {

define( 'PICAL_AM_LOADED' , 1 ) ;


// titles
define("_AM_ADMISSION","Admitting Events");
define("_AM_MENU_EVENTS","Events Manager");
define("_AM_MENU_CATEGORIES","Categories Manager");
define("_AM_MENU_CAT2GROUP","Category's Permission");
define("_AM_ICALENDAR_IMPORT","Importing iCalendar");
define("_AM_GROUPPERM","Global Permissions");
define("_AM_TABLEMAINTAIN","Table Maintenance (Upgrade)");
define("_AM_MYBLOCKSADMIN","piCal's Block&Group admin");

// forms
define("_AM_BUTTON_EXTRACT","Extract");
define("_AM_BUTTON_ADMIT","Admit");
define("_AM_BUTTON_MOVE","Move");
define("_AM_BUTTON_COPY","Copy");
define("_AM_CONFIRM_DELETE","Delete event(s) OK?");
define("_AM_CONFIRM_MOVE","Remove a link to the old category and Add a link to the specified category OK?");
define("_AM_CONFIRM_COPY","Add a link to specified category OK?");
define("_AM_OPT_PAST","Past");
define("_AM_OPT_FUTURE","Future");
define("_AM_OPT_PASTANDFUTURE","Past & Future");

// format
define("_AM_DTFMT_LIST_ALLDAY",'y-m-d');
define("_AM_DTFMT_LIST_NORMAL",'y-m-d<\b\r />H:i');

// timezones
define("_AM_TZOPT_SERVER","As server timezone");
define("_AM_TZOPT_GMT","As GMT");
define("_AM_TZOPT_USER","As user's timezone");

// admission
define("_AM_LABEL_ADMIT","Checked events are: to be admitted");
define("_AM_MES_ADMITTED","Event(s) has been admitted");
define("_AM_ADMIT_TH0","User");
define("_AM_ADMIT_TH1","Start datetime");
define("_AM_ADMIT_TH2","Finish datetime");
define("_AM_ADMIT_TH3","Title");
define("_AM_ADMIT_TH4","Rrule");

// events manager & importing iCalendar

define("_AM_LABEL_IMPORTFROMWEB","Import iCalendar data from web (Input URI started from 'http://' or 'webcal://')");
define("_AM_LABEL_UPLOADFROMFILE","Upload iCalendar data (Select a file from your local machine)");
define("_AM_LABEL_IO_CHECKEDITEMS","Checked events are:");
define("_AM_LABEL_IO_OUTPUT","to be exported in iCalendar");
define("_AM_LABEL_IO_DELETE","to be deleted");
define("_AM_MES_EVENTLINKTOCAT","event(s) has been linked to this category");
define("_AM_MES_EVENTUNLINKED","event(s) link has been removed to the old category");
define("_AM_FMT_IMPORTED","event(s) has been imported from '%s'");
define("_AM_MES_DELETED","event(s) has been deleted");
define("_AM_IO_TH0","User");
define("_AM_IO_TH1","Start datetime");
define("_AM_IO_TH2","Finish datetime");
define("_AM_IO_TH3","Title");
define("_AM_IO_TH4","Rrule");
define("_AM_IO_TH5","Admission");

// Group's Permissions
define( '_AM_GPERM_G_INSERTABLE' , "Can add" ) ;
define( '_AM_GPERM_G_SUPERINSERT' , "Super add" ) ;
define( '_AM_GPERM_G_EDITABLE' , "Can edit" ) ;
define( '_AM_GPERM_G_SUPEREDIT' , "Super edit" ) ;
define( '_AM_GPERM_G_DELETABLE' , "Can delete" ) ;
define( '_AM_GPERM_G_SUPERDELETE' , "Super delete" ) ;
define( '_AM_GPERM_G_TOUCHOTHERS' , "Can touch others" ) ;
define( '_AM_CAT2GROUPDESC' , "Check categories which you allow to access" ) ;
define( '_AM_GROUPPERMDESC' , "Select permissions that each group is allowed to do<br />If you need this feature, set 'Authorities of users' to Specified in Group's permissions first.<br />The settings of two groups of Administrator and Guest will be ignored." ) ;

// Table Maintenance
define( '_AM_MB_SUCCESSUPDATETABLE' , "Updating table(s) has succeeded" ) ;
define( '_AM_MB_FAILUPDATETABLE' , "Updating table(s) has failed" ) ;
define( '_AM_NOTICE_NOERRORS' , "There is no error with tables or records." ) ;
define( '_AM_ALRT_CATTABLENOTEXIST' , "The categories table does not exist.<br />\nDo you wish to create the table ?" ) ;
define( '_AM_ALRT_OLDTABLE' , "The structure of events table is old.<br />\nDo you wish to upgrade the table ?" ) ;
define( '_AM_ALRT_TOOOLDTABLE' , "Table error occured.<br />\nPerhaps you used piCal 0.3x or earlier.<br />\nFirst, update into 0.4x or 0.5x." ) ;
define( '_AM_FMT_SERVER_TZ_ALL' , "Timezone of the server (winter): %+2.1f<br />Timezone of the server (summer): %+2.1f<br />Zonename of the server: %s<br />The value of XOOPS config: %+2.1f<br />The value of piCal using: %+2.1f<br />" ) ;
define( '_AM_TH_SERVER_TZ_COUNT' , "Events" ) ;
define( '_AM_TH_SERVER_TZ_VALUE' , "Timezone" ) ;
define( '_AM_TH_SERVER_TZ_VALUE_TO' , "Changes (-14.0¡Á14.0)" ) ;
define( '_AM_JSALRT_SERVER_TZ' , "Don't forget backing-up events table before this operation" ) ;
define( '_AM_NOTICE_SERVER_TZ' , "If your server set the timezone area with summer time (=Day Light Saving) and some events were registerd in piCal 0.6x or 0.7x, dont't push this button.<br />eg) It is natural to display both -5.0 and -4.0 in EDT" ) ;
define( '_AM_MB_SUCCESSTZUPDATE' , "Events are modified with the timezone(s)." ) ;

// Categories
define( '_AM_CAT_TH_TITLE' , 'Title' ) ;
define( '_AM_CAT_TH_DESC' , 'Description' ) ;
define( '_AM_CAT_TH_PARENT' , 'Parent Category' ) ;
define( '_AM_CAT_TH_OPTIONS' , 'Options' ) ;
define( '_AM_CAT_TH_LASTMODIFY' , 'Last Modified' ) ;
define( '_AM_CAT_TH_OPERATION' , 'Operation' ) ;
define( '_AM_CAT_TH_ENABLED' , 'Enable' ) ;
define( '_AM_CAT_TH_WEIGHT' , 'Weight' ) ;
define( '_AM_CAT_TH_SUBMENU' , 'register in SubMenu' ) ;
define( '_AM_BTN_UPDATE' , 'UPDATE' ) ;
define( '_AM_MENU_CAT_EDIT' , 'Editing a Category' ) ;
define( '_AM_MENU_CAT_NEW' , 'Create a new Category' ) ;
define( '_AM_MB_MAKESUBCAT' , 'SubCategory' ) ;
define( '_AM_MB_MAKETOPCAT' , 'Create a category in a top level' ) ;
define( '_AM_MB_CAT_INSERTED' , 'New Category created' ) ;
define( '_AM_MB_CAT_UPDATED' , 'Category updated' ) ;
define( '_AM_FMT_CAT_DELETED' , '%s Categories deleted' ) ;
define( '_AM_FMT_CAT_BATCHUPDATED' , '%s Categories updated' ) ;
define( '_AM_FMT_CATDELCONFIRM' , 'Do you want to delete category %s ?' ) ;

// Plugins
define( '_AM_PI_UPDATED' , 'Plugins are updated' ) ;
define( '_AM_PI_TH_TYPE' , 'Type' ) ;
define( '_AM_PI_TH_OPTIONS' , 'Options (usually blank)' ) ;
define( '_AM_PI_TH_TITLE' , 'Title' ) ;
define( '_AM_PI_TH_DIRNAME' , 'Module\'s dirname' ) ;
define( '_AM_PI_TH_FILE' , 'Plugin file' ) ;
define( '_AM_PI_TH_DOTGIF' , 'Dot GIF' ) ;
define( '_AM_PI_TH_OPERATION' , 'Operation' ) ;
define( '_AM_PI_ENABLED' , 'Enabled' ) ;
define( '_AM_PI_DELETE' , 'Delete' ) ;
define( '_AM_PI_NEW' , 'New' ) ;
define( '_AM_PI_VIEWYEARLY' , 'Yearly View' ) ;
define( '_AM_PI_VIEWMONTHLY' , 'Monthly View' ) ;
define( '_AM_PI_VIEWWEEKLY' , 'Weekly View' ) ;
define( '_AM_PI_VIEWDAILY' , 'Daily View' ) ;

// groupperm
define('_AM_PICAL_DBUPDATED','Database Updated Successfully!');
define('_AM_PICAL_PERMADDNG', 'Could not add %s permission to %s for group %s');
define('_AM_PICAL_PERMADDOK','Added %s permission to %s for group %s');
define('_AM_PICAL_PERMRESETNG','Could not reset group permission for module %s');
define('_AM_PICAL_PERMADDNGP', 'All parent items must be selected.');

}

?>