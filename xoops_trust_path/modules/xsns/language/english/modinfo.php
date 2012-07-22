<?php

$constpref = '_MI_'.strtoupper($mydirname);

if(!defined($constpref.'_LOADED')){

define($constpref.'_LOADED', 1);

define($constpref.'_MODULE_DESC', 'The module which can begin SNS(Social Networking Service) inside XOOPS.');

define($constpref.'_MENU_MYPAGE', 'My Page');

define($constpref.'_BLOCK_RECENT_TOPIC', 'LATEST TOPICS');
define($constpref.'_BLOCK_INFORMATION', 'INFORMATION');

define($constpref.'_AD_MENU_CATEGORY', 'Group Category Manager');
define($constpref.'_AD_MENU_IMAGE', 'Image Manager');
define($constpref.'_AD_MENU_FILE', 'File Manager');
define($constpref.'_AD_MENU_ACCESS', 'Access Logs');
define($constpref.'_AD_MENU_MYTPLSADMIN', 'Templates Management');
define($constpref.'_AD_MENU_MYBLOCKSADMIN', 'Blocks Management/Access authority');
define($constpref.'_AD_MENU_MYLANGADMIN', 'Language Constant Management');
define($constpref.'_AD_MENU_MYPREFERENCES', 'Preferences');


define($constpref.'_COMMU_NOTIFY', 'Displayed Groups');
define($constpref.'_COMMU_NOTIFY_DSC', 'The notification option of the displayed group');

define($constpref.'_TOPIC_CREATE_NOTIFY', 'Create a New Topic');
define($constpref.'_TOPIC_CREATE_NOTIFY_CAP', 'When the new topic was created, it notifies.');
define($constpref.'_TOPIC_CREATE_NOTIFY_DSC', 'When the new topic was created, it notifies.');
define($constpref.'_TOPIC_CREATE_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE}: The topic was created.');

define($constpref.'_TOPIC_POST_NOTIFY', 'Post a New Comment');
define($constpref.'_TOPIC_POST_NOTIFY_CAP', 'When comment was posted, it notifies.');
define($constpref.'_TOPIC_POST_NOTIFY_DSC', 'When comment was posted, it notifies.');
define($constpref.'_TOPIC_POST_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE}: The comment was created.');

define($constpref.'_FPATH', 'Upload directory of image/file');
define($constpref.'_FPATHDSC', 'The uploaded the image/file is saved all here.<br><span style="color:#ff0000;">* For security, please indicate the place outside the open directory of the server.</span>');

define($constpref.'_FSIZE', 'Maximum image/file size (bytes)');
define($constpref.'_FSIZEDSC', 'Please indicate the maximum size of the image/file.');

define($constpref.'_FMIME', 'MIME type of file which permits upload');
define($constpref.'_FMIMEDSC', 'Please input the MIME type of file which permits upload. <br />And, please separate each MIME type with a pipe. <br /> [ ex) text/plain|application/msword ]');

define($constpref.'_IMGW', 'Maximum width (pixels)');
define($constpref.'_IMGWDSC', '');

define($constpref.'_IMGH', 'Maximum height (pixels)');
define($constpref.'_IMGHDSC', '');

define($constpref.'_ILIMIT', 'Restriction of the frequency of upload images.');
define($constpref.'_ILIMITDSC', 'Maximum amount of the attachment images for one contribution is indicated. (0 = cannot upload image)');

define($constpref.'_FLIMIT', 'Restriction of the frequency of upload Files.');
define($constpref.'_FLIMITDSC', 'Maximum amount of the attachment files for one contribution is indicated.  (0 = cannot upload file)');

define($constpref.'_BLOG', 'Selection of the Blog Module');
define($constpref.'_BLOGDSC', 'Please select the Blog Module which it utilizes from summary.<br>When module is not installed, it cannot utilize.');
define($constpref.'_BLOG0', "Don't utilize.");
define($constpref.'_BLOG1', 'Weblog');
define($constpref.'_BLOG2', 'WeblodD3');
define($constpref.'_BLOG3', 'WordPress ME (for XOOPS2)');
define($constpref.'_BLOG4', 'd3blog');

define($constpref.'_BLOGDIR', 'Directory name of the blog module');
define($constpref.'_BLOGDIRDSC', 'When directory name of the blog module has been modified, please input the value.<br>In case of blank it becomes directory name of default.');

define($constpref.'_MYPAGE', 'The account information page is replaced to the my page.');
define($constpref.'_MYPAGEDSC', 'It is possible to replace the account information page of XOOPS standard, to the my page of this module.<br><br>In case of XOOPS 2.0 type, when [Yes] is selected, contents of the file below are modified. When we would like to reset to the origin, please select [No].<br>&nbsp;'.XOOPS_ROOT_PATH.'/userinfo.php<br>&nbsp;'.XOOPS_ROOT_PATH.'/edituser.php');

define($constpref.'_MYPAGEG', 'The my page is released to the guest.');
define($constpref.'_MYPAGEGDSC', 'When this module is not released to the guest, without relationship in this setting the my page is not released.');

define($constpref.'_POPMAX', 'Ranking setting of the popularity stakes');
define($constpref.'_POPMAXDSC', 'When the popularity stakes exceeds this value, it becomes 5 stars (the highest ranking). <br>Please modify according to the scale of the number of users.<br><br><span style="color:#0000ff;">* The popularity stakes: Mean value of frequency of access to the target group. (past within 30th)</span>');

define($constpref.'_FREQMAX', 'Ranking setting of the Update frequency');
define($constpref.'_FREQMAXDSC', 'When the update frequency exceeds this value, it becomes 5 stars (the highest ranking).<br>Please modify according to the scale of the number of users.<br><br><span style="color:#0000ff;">* The update frequency: Mean value of the number of topics and the comments which are contributed to the target group. (past within 30th)</span>');

define($constpref.'_FOOT', 'Enable the access log function of the my page');
define($constpref.'_FOOTDSC', 'It indicates whether or not you use the access log function for the my page.');

define($constpref.'_XBC', 'Enable The Bread Crumbs');
define($constpref.'_XBCDSC', 'When the bread crumbs is indicated with theme, please set to [No].');

define($constpref.'_INSTERR', '<span style="color:#ff0000;"><b>The upper limit of the number of letters of directory name of module is 15 letters.<br />After uninstalling the module, it modifies in directory name within 15 letters. And, please install once more.<br /></b></span>');

define($constpref.'_CATEGORY', 'Category');
define($constpref.'_CATEGORY_1', 'Hobbies');
define($constpref.'_CATEGORY_2', 'Life');
define($constpref.'_CATEGORY_3', 'Events');
define($constpref.'_CATEGORY_4', 'Other');

}

?>
