<?php
//  ------------------------------------------------------------------------ //
// $Id: modinfo.php 0003 12:32 2008/04/09 avtx30 $
//  ------------------------------------------------------------------------ //
if( defined( 'FOR_XOOPS_LANG_CHECKER' ) ) $mydirname = 'd3downloads' ;
$constpref = '_MI_' . strtoupper( $mydirname ) ;

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( $constpref.'_LOADED' ) ) {

define( $constpref.'_LOADED' , 1 ) ;

// The name of this module
define($constpref."_NAME","Duplicatable V3 (D3) downloads module");

// A brief description of this module
define($constpref."_DESC","Creates a downloads section where users can download/submit/rate various files.");

// admin menus
define($constpref.'_ADMENU_FILEMANAGER',"Downloads") ;
define($constpref.'_ADMENU_APPROVALMANAGER',"Approvals") ;
define($constpref.'_ADMENU_CATEGORYMANAGER',"Categories") ;
define($constpref.'_ADMENU_USER_ACCES','Category Permissions') ;
define($constpref.'_ADMENU_IMPORT',"Import/Update") ;
define($constpref.'_ADMENU_CONFIG_CHECK',"Environment Check") ;
define($constpref.'_ADMENU_MYLANGADMIN',"Languages") ;
define($constpref.'_ADMENU_MYTPLSADMIN',"Templates") ;
define($constpref.'_ADMENU_MYBLOCKSADMIN',"Blocks/Permissions") ;
define($constpref.'_ADMENU_MYPREFERENCES',"Preferences") ;

// blocks
define($constpref.'_BNAME_RECENT',"Recent Downloads") ;
define($constpref.'_BNAME_TOPRANK',"Top Downloads") ;
define($constpref.'_BNAME_DOWNLOAD',"Download info") ;
define($constpref.'_BNAME_LIST',"Download list") ;
define($constpref.'_BNAME_PICKUP',"Pickup Downloads") ;
define($constpref.'_BNAME_CATEGORY','Categories') ;

// Sub menu titles
define($constpref.'_SMNAME1',"Popular");
define($constpref.'_SMNAME2',"Highly Rated");
define($constpref.'_SMNAME3','File List');
define($constpref.'_MYPOST_VIEW','My Post');

// Title of config items
define($constpref.'_POPULAR',"Number of hits for a download to be marked as popular");
define($constpref.'_NEWDLS',"Maximum number of new downloads to be displayed on top page");
define($constpref.'_NEWMARK',"Number of days to show 'New' icons");
define($constpref.'_PERPAGE',"Download Listing Count");
define($constpref.'_ORDER','Default download Order');
define($constpref.'_ORDERSC','Select the default order for the download listings.');
define($constpref.'_POPULARITYLTOM','Popularity (Lowest to Highest Hits)');
define($constpref.'_POPULARITYMTOL','Popularity (Highest to Lowest Hits)');
define($constpref.'_TITLEATOZ','Title (A to Z)');
define($constpref.'_TITLEZTOA','Title (Z to A)');
define($constpref.'_DATEOLD','Date (Older Files Listed First)');
define($constpref.'_DATENEW','Date (Newest Files Listed First)');
define($constpref.'_RATINGLTOH','Rating (Lowest Score to Highest Score)');
define($constpref.'_RATINGHTOL','Rating (Highest Score to Lowest Score)');
define($constpref.'_POSTNAME','Display Submitter name in the download listings');
define($constpref.'_MYPOST','Show My Photos in submenu');
define($constpref.'_USESHOTS',"Display Screenshot Images");
define($constpref.'_USEALBUM',"Use image management module's uploaded images for screenshot images");
define($constpref.'_USEALBUMDSC',"When 'Display Screenshot Images' is set to yes, image management module's uploaded images can be used for screenshot images.");
define($constpref.'_ALBUMSELECT',"Dirname of related myAlbum-P");
define($constpref.'_ALBUMSELECTDSC',"Please enter directory name of image management module (e.g. myalbum)");
define($constpref.'_SHOTSSELECT',"Use thumbnail web service to create screenshot images");
define($constpref.'_SHOTSSELECTDSC',"If 'Display Screenshot Images' is selected and there are no screenshot images, use thumbnail web service to create alternative images.");
define($constpref.'_SHOTWIDTH',"Image Display Width");
define($constpref.'_CHECKURL',"Disallow downloads from the same URL");
define($constpref.'_CHECKHOST',"Disallow direct download linking (leeching)");
define($constpref.'_REFERERS',"Sites that can directly link to your files <br />Separate with | ");
define($constpref.'_PER_HISTORY',"Number of generations for history");
define($constpref.'_EXTENSION',"Allowed extension");
define($constpref.'_EXTENSIONDSC',"List allowed extentions separated by |. Small leters without spaces or dot. php or html will be ignored.");
define($constpref.'_MAXFILESIZE',"Max size of file for uploading (in bytes)");
define($constpref.'_MULTIDOT',"Check multi-dot when uploading");
define($constpref.'_MULTIDOTDSC',"Set upload permission to multiple dot file name (file name with 2 or more dots). At default multiple dot file will be dropped because of security reason.");
define($constpref.'_CHECKHEAD',"Check file header when uploading");
define($constpref.'_PURIFIER',"Remove fraud tags when HTML is enable");
define($constpref.'_PURIFIERDSC',"When HTML is enable, HTML Filter will be valid by default to remove some fraud tags. Posters are limitted to trusty users. Please select 'Yes' in most cases except HTML Filter causes some side-effects.");
define($constpref.'_PLATFORM',"Platform");
define($constpref.'_PLATFORMDSC',"List platform (OS, application, etc), separage with | . These will be displayed in the select box of the submit form.");
define($constpref.'_TELLAFRINED',"Use module 'Tell A Friend'");
define($constpref.'_PER_RSS',"Number of RSS items");
define($constpref.'_COM_DIRNAME',"Comment-integration: dirname of d3forum");
define($constpref.'_COM_FORUM_ID',"Comment-integration: forum ID");
define($constpref.'_COM_VIEW',"Comment-integration View Mode");
define($constpref.'_COM_ORDER','Order of comment-integration');
define($constpref.'_COM_POSTSNUM','Max posts displayed in comment-integration');
define($constpref.'_CRON_PASS','The password of a file broken / broken link check command for cron');
define($constpref.'_CRONPASSDSC','When use a check function running out of file broken / link in the command-line, please use the password set here. Being usable for a password only as for the alphanumeric character. Please do not put the blank.');

define($constpref.'_POPULARDSC',"The number of hits before a Download status will be considered as popular.");
define($constpref.'_NEWDLSDSC',"Please set number of downloads to show at top page's Recent Downloads");
define($constpref.'_PERPAGEDSC',"Number of Downloads to display in each category listing.");
define($constpref.'_SHOTWIDTHDSC',"Type in the maximum width (in pixels) of screenshot images");
define($constpref.'_REFERERSDSC',"Please list sites which can directly link to your files");

// Notify Categories
define($constpref.'_NOTCAT_CAT',"Available Categories");
define($constpref.'_NOTCAT_CATDSC',"Notifications settings for available categories");
define($constpref.'_NOTCAT_GLOBAL',"Entire module");
define($constpref.'_NOTCAT_GLOBALDSC',"Notification settings for global this module");
define($constpref.'_NOTCAT_FILE', 'Current page');
define($constpref.'_NOTCAT_FILEDSC', 'Notification options that apply to the current page.');

// Each Notifications
define($constpref.'_NOTIFY_CAT_NEWPOST',"Category New Post");
define($constpref.'_NOTIFY_CAT_NEWPOSTCAP',"Notify me if there are new posts under this category.");
define($constpref.'_NOTIFY_CAT_NEWPOSTSBJ',"[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} new post");

define($constpref.'_NOTIFY_CAT_NEWPOSTFULL',"Full post under category");
define($constpref.'_NOTIFY_CAT_NEWPOSTFULLCAP',"Notify me with full post if there is a new post under this category.");
define($constpref.'_NOTIFY_CATL_NEWPOSTFULLSBJ',"[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} full post");

define($constpref.'_NOTIFY_CAT_NEWFORUM',"New forum under category");
define($constpref.'_NOTIFY_CAT_NEWFORUMCAP',"Notify me if there is a new forum under this category.");
define($constpref.'_NOTIFY_CAT_NEWFORUMSBJ',"[{X_SITENAME}] {X_MODULE}:{CAT_TITLE} new forum");

define($constpref.'_NOTIFY_GLOBAL_NEWPOST',"New Post");
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTCAP',"Notify me if there is a new post under this module.");
define($constpref.'_NOTIFY_GLOBAL_NEWPOSTSBJ',"[{X_SITENAME}] {X_MODULE}: new post");

define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORY',"Entire Module");
define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYCAP',"Notify me if there is a new category under this module.");
define($constpref.'_NOTIFY_GLOBAL_NEWCATEGORYSBJ',"[{X_SITENAME}] {X_MODULE}: new category");

define($constpref.'_NOTIFY_GLOBAL_WAITING',"waiting for approval");
define($constpref.'_NOTIFY_GLOBAL_WAITINGCAP',"Notify me if there is submited/edited download waiting for approval.");
define($constpref.'_NOTIFY_GLOBAL_WAITINGSBJ',"[{X_SITENAME}] {X_MODULE}: waiting");

define($constpref.'_NOTIFY_GLOBAL_BROKEN',"Broken file report");
define($constpref.'_NOTIFY_GLOBAL_BROKENCAP',"Notify me if there is broken report. (For webmasters only)");
define($constpref.'_NOTIFY_GLOBAL_BROKENSBJ',"[{X_SITENAME}] {X_MODULE}: broken download report");

define($constpref.'_NOTIFY_GLOBAL_APPROVE',"Download approval");
define($constpref.'_NOTIFY_GLOBAL_APPROVECAP',"Notify me if this download is approved.");
define($constpref.'_NOTIFY_GLOBAL_APPROVECAPSBJ',"[{X_SITENAME}] {X_MODULE}: file approved");

// add photosite
define($constpref.'_CHECKHEADDSC','At default when uploading in the first part of the file is checked.') ;
define($constpref.'_ADMENU_BROKENMANAGER','Broken reports') ;
define($constpref.'_TOP_MESSAGE','Description of TOP category');
define($constpref.'_TOP_MESSAGEDEFAULT','');
define($constpref.'_BREADCRUMBS','Display breadcrumbs');
define($constpref.'_EDITOR','Body Editor');
define($constpref.'_EDITORDSC','fckeditor will be enabled under only category allowing HTML. With category escaping HTML specialchars, xoopsdhtml will be displayed automatically.');
define($constpref.'_USELICENSE','Display License');
define($constpref.'_LICENSE','License');
define($constpref.'_LICENSEDSC','List license, separage with | . These will be displayed in the select box of the submit form.');
define($constpref."_PLUSPOSTS","Reflect posts to user's post count");
define($constpref."_PLUSPOSTSDSC", "When downloads is newly published, user's 'Posts' will be increased.");
define($constpref.'_BNAME_MYLINK','My Link List') ;
define($constpref.'_MYLINK','My Link');
define($constpref.'_MODULESELECT','The image management module jointly used is selected. ');
define($constpref.'_ALBUMMODULEDSC','It corresponds to myAlbum-P, GnaviD3, and webphoto now.');
define($constpref.'_NOTIFY_FILE_COMMENT', 'new comment');
define($constpref.'_NOTIFY_FILE_COMMENTCAP', 'Notify if a new comment is posted.');
define($constpref.'_NOTIFY_FILE_COMMENTSBJ', '[{X_SITENAME}] {X_MODULE} : a new comment');
define($constpref.'_CSS_URI','URI of CSS file for this module');
define($constpref.'_CSS_URIDSC','relative or absolute path can be set. default: {mod_url}/index.php?page=module_header&src=main.css');
define($constpref.'_LIVE_URI','URI of CSS file for livevalidation');
define($constpref.'_LIVE_URIDSC','relative or absolute path can be set. default: {mod_url}/index.php?page=module_header&src=livevalidation.css');
define($constpref.'_HTMLPR_EXCEPT','Groups can avoid purification by HTML Filter');
define($constpref.'_HTMLPR_EXCEPTDSC','Post from users who are not belonged these groups will be forced to purified as sanitized HTML by HTML Filter');

}
?>
