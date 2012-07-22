# XOOPS2 - Xwords 0.35
# Presented by WEBMASTER @ KANPYO.NET, 2005.

# Table structure for table `xwords_cat`

CREATE TABLE `xwords_cat` (	
	`categoryID` tinyint(4) NOT NULL auto_increment,
	`name` varchar(100) NOT NULL default '',
	`description` text NOT NULL,
	`total` int(11) NOT NULL default '0',
	`weight` int(11) NOT NULL default '1',
	PRIMARY KEY  (`categoryID`),
	UNIQUE KEY categoryID (`categoryID`)
) ENGINE=MyISAM COMMENT='Xwords by aiba';	


# --------------------------------------------------------

#
# Table structure for table `xwords_ent`
#

CREATE TABLE `xwords_ent` (	
	`entryID` int(8) NOT NULL auto_increment,
	`categoryID` tinyint(4) NOT NULL default '0',
	`term` varchar(255) NOT NULL default '0',
	`proc` varchar(255) NOT NULL default '0',
	`init` varchar(10) NOT NULL default '0',
	`definition` text NOT NULL,
	`ref` varchar(255) NOT NULL default '0',
	`url` varchar(255) NOT NULL default '0',
	`uid` int(6) default '1',
	`submit` int(1) NOT NULL default '0',
	`datesub` int(11) NOT NULL default '1033141070',
	`counter` int(8) unsigned NOT NULL default '0',
	`html` int(11) NOT NULL default '0',
	`smiley` int(11) NOT NULL default '0',
	`xcodes` int(11) NOT NULL default '0',
	`breaks` int(11) NOT NULL default '1',
	`block` int(11) NOT NULL default '0',
	`offline` int(11) NOT NULL default '0',
	`notifypub` int(11) NOT NULL default '0',
	`request` int(11) NOT NULL default '0',
	PRIMARY KEY  (`entryID`),
	UNIQUE KEY entryID (`entryID`),
	FULLTEXT KEY definition (`definition`)
) ENGINE=MyISAM COMMENT='Xwords by aiba';	

