# CREATE TABLE `tablename` will be queried as
# CREATE TABLE `prefix_dirname_tablename`

CREATE TABLE metalink (
  lid int(10) NOT NULL default '0',
  metakey text NOT NULL,
  metadesc text NOT NULL,
  robots varchar(100) NOT NULL default '',
  rating varchar(100) NOT NULL default '',
  author varchar(255) NOT NULL default '',
  UNIQUE KEY lid (lid)
) TYPE=MyISAM;

CREATE TABLE scriptbody (
  lid mediumint(5) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  created int(10) NOT NULL default '0',
  body text NOT NULL,
  css text NOT NULL,
  UNIQUE KEY lid (lid)
) TYPE=MyISAM;

CREATE TABLE cssexport (
  lid int(10) NOT NULL default '0',
  exportdir varchar(255) NOT NULL default '',
  UNIQUE KEY lid (lid)
) TYPE=MyISAM;
