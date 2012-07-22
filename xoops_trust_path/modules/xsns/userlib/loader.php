<?php

$_requires = array(
	XSNS_USERLIB_DIR.'/config.php',
	XSNS_USERLIB_DIR.'/textsanitizer.php',
	XSNS_USERLIB_DIR.'/session.php',
	XSNS_USERLIB_DIR.'/utils.php',
	XSNS_USERLIB_DIR.'/root.class.php',
	XSNS_USERLIB_DIR.'/user.class.php',
	XSNS_USERLIB_DIR.'/community.class.php',
	XSNS_USERLIB_DIR.'/member.class.php',
	XSNS_USERLIB_DIR.'/topic.class.php',
	XSNS_USERLIB_DIR.'/topic_comment.class.php',
	XSNS_USERLIB_DIR.'/friend.class.php',
	XSNS_USERLIB_DIR.'/image.class.php',
	XSNS_USERLIB_DIR.'/file.class.php',
	XSNS_USERLIB_DIR.'/confirm.class.php',
	XSNS_USERLIB_DIR.'/category.class.php',
	XSNS_USERLIB_DIR.'/category_parent.class.php',
	XSNS_USERLIB_DIR.'/access_log.class.php',
	XSNS_USERLIB_DIR.'/footprint.class.php',
	XSNS_USERLIB_DIR.'/introduction.class.php',
	XSNS_USERLIB_DIR.'/module_config.class.php',
);

foreach ($_requires as $_require) {
	if (is_readable($_require) && is_file($_require)) {
		require_once($_require);
	} else {
		if($GLOBAL['xoopsUserIsAdmin']){
			die("ERROR: {$_require} NOT FOUND.");
		}
		else{
			exit();
		}
	}
}

?>