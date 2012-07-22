CREATE TABLE attach (
  attach_id int(10) unsigned NOT NULL auto_increment,
  module_dirname varchar(25) NOT NULL default '',
  target_id int(10) unsigned NOT NULL default 0,
  title varchar(255) NOT NULL default '',
  saved_name varchar(255) NOT NULL default '',
  file_size int(10) NOT NULL default 0,
  KEY (attach_id),
  KEY (module_dirname),
  KEY (target_id)
) ENGINE=MyISAM;
