CREATE TABLE `c_commu`
(
  `c_commu_id` int(11) unsigned NOT NULL auto_increment,
  `name` text NOT NULL,
  `uid_admin` int(11) unsigned NOT NULL DEFAULT '0',
  `uid_sub_admin` int(11) unsigned NOT NULL DEFAULT '0',
  `info` text NOT NULL,
  `c_commu_category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `r_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `r_date` date NOT NULL DEFAULT '0000-00-00',
  `public_flag` int(3) unsigned NOT NULL DEFAULT '1',
  `access_count` int(11) unsigned NOT NULL DEFAULT '0',
  `update_freq` float NOT NULL DEFAULT '0',
  `popularity` float NOT NULL DEFAULT '0',
  `up_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  PRIMARY KEY  (`c_commu_id`),
  KEY `c_commu_category_id` (`c_commu_category_id`),
  KEY `uid_admin` (`uid_admin`),
  KEY `r_datetime` (`r_datetime`)

) TYPE=MyISAM;


CREATE TABLE `c_commu_category`
(
  `c_commu_category_id` int(11) unsigned NOT NULL auto_increment,
  `name` text NOT NULL,
  `sort_order` int(11) unsigned NOT NULL DEFAULT '0',
  `c_commu_category_parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`c_commu_category_id`),
  KEY `c_commu_category_parent_id` (`c_commu_category_parent_id`)

) TYPE=MyISAM;


CREATE TABLE `c_commu_category_parent`
(
  `c_commu_category_parent_id` int(11) unsigned NOT NULL auto_increment,
  `name` text NOT NULL,
  `sort_order` int(11) unsigned NOT NULL DEFAULT '0',
  `selector` text NOT NULL,
  PRIMARY KEY  (`c_commu_category_parent_id`),
  KEY `sort_order` (`sort_order`)

) TYPE=MyISAM;


CREATE TABLE `c_commu_topic`
(
  `c_commu_topic_id` int(11) unsigned NOT NULL auto_increment,
  `c_commu_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `r_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `r_date` date NOT NULL DEFAULT '0000-00-00',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`c_commu_topic_id`),
  KEY `uid` (`uid`),
  KEY `c_commu_id` (`c_commu_id`)

) TYPE=MyISAM;


CREATE TABLE `c_commu_topic_comment`
(
  `c_commu_topic_comment_id` int(11) unsigned NOT NULL auto_increment,
  `c_commu_id` int(11) unsigned NOT NULL DEFAULT '0',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `body` text NOT NULL,
  `r_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `r_date` date NOT NULL DEFAULT '0000-00-00',
  `number` int(11) unsigned NOT NULL DEFAULT '0',
  `c_commu_topic_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`c_commu_topic_comment_id`),
  KEY `c_commu_id` (`c_commu_id`),
  KEY `uid` (`uid`),
  UNIQUE KEY (`c_commu_topic_id`,`number`)

) TYPE=MyISAM;


CREATE TABLE `c_commu_member`
(
  `c_commu_member_id` int(11) unsigned NOT NULL auto_increment,
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `c_commu_id` int(11) unsigned NOT NULL DEFAULT '0',
  `r_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`c_commu_member_id`),
  KEY `c_commu_id_r_datetime` (`c_commu_id`,`r_datetime`),
  UNIQUE KEY (`uid`,`c_commu_id`)

) TYPE=MyISAM;


CREATE TABLE `c_image`
(
  `c_image_id` int(11) unsigned NOT NULL auto_increment,
  `filename` text NOT NULL,
  `target` int(2) unsigned NOT NULL DEFAULT '1',
  `target_id` int(11) unsigned NOT NULL DEFAULT '0',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`c_image_id`)

) TYPE=MyISAM;


CREATE TABLE `c_file`
(
  `c_file_id` int(11) unsigned NOT NULL auto_increment,
  `filename` text NOT NULL,
  `org_filename` text NOT NULL,
  `target` int(2) unsigned NOT NULL DEFAULT '1',
  `target_id` int(11) unsigned NOT NULL DEFAULT '0',
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`c_file_id`)

) TYPE=MyISAM;


CREATE TABLE `c_commu_confirm`
(
  `c_commu_confirm_id` int(11) unsigned NOT NULL auto_increment,
  `c_commu_id` int(11) unsigned NOT NULL DEFAULT '0',
  `uid_from` int(11) unsigned NOT NULL DEFAULT '0',
  `uid_to` int(11) unsigned NOT NULL DEFAULT '0',
  `mode` int(3) unsigned NOT NULL DEFAULT '0',
  `r_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text NOT NULL,
  PRIMARY KEY  (`c_commu_confirm_id`),
  KEY `uid_to` (`uid_to`),
  UNIQUE KEY (`c_commu_id`,`uid_from`,`uid_to`,`mode`)

) TYPE=MyISAM;


CREATE TABLE `c_friend`
(
  `c_friend_id` int(11) unsigned NOT NULL auto_increment,
  `uid_from` int(11) unsigned NOT NULL DEFAULT '0',
  `uid_to` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY  (`c_friend_id`),
  UNIQUE KEY (`uid_from`,`uid_to`)

) TYPE=MyISAM;


CREATE TABLE `c_mypage_config`
(
  `config_id` int(11) unsigned NOT NULL auto_increment,
  `uid` int(11) unsigned NOT NULL,
  `config_values` text NOT NULL,
  PRIMARY KEY  (`config_id`)

) TYPE=MyISAM;


CREATE TABLE `c_commu_access_log`
(
  `c_access_log_id` int(11) unsigned NOT NULL auto_increment,
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `c_commu_id` int(11) unsigned NOT NULL DEFAULT '0',
  `r_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`c_access_log_id`)

) TYPE=MyISAM;


CREATE TABLE `c_mypage_footprint`
(
	`c_footprint_id` int(11) unsigned NOT NULL auto_increment, 
	`uid_to` int(11) unsigned NOT NULL DEFAULT '0', 
	`uid_from` int(11) unsigned NOT NULL DEFAULT '0', 
	`r_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`r_date` date NOT NULL DEFAULT '0000-00-00',
	PRIMARY KEY (`c_footprint_id`)

) TYPE=MyISAM;


CREATE TABLE `c_mypage_introduction`
(
	`c_intro_id` int(11) unsigned NOT NULL auto_increment, 
	`uid_to` int(11) unsigned NOT NULL DEFAULT '0', 
	`uid_from` int(11) unsigned NOT NULL DEFAULT '0', 
	`body` text NOT NULL,
	`r_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`c_intro_id`)

) TYPE=MyISAM;


