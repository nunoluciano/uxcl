
CREATE TABLE pical0_event (
  id int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  uid mediumint(8) unsigned zerofill NOT NULL default 0,
  groupid smallint(5) unsigned zerofill NOT NULL default 0,
  summary VARCHAR(255) NOT NULL DEFAULT '' ,
  location VARCHAR(255) NOT NULL DEFAULT '' ,
  organizer VARCHAR(255) NOT NULL DEFAULT '',
  sequence VARCHAR(255) NOT NULL DEFAULT '',
  contact VARCHAR(255) NOT NULL DEFAULT '',
  tzid VARCHAR(255) NOT NULL DEFAULT 'GMT',
  description text NOT NULL,
  dtstamp TIMESTAMP,
  categories VARCHAR(255) NOT NULL DEFAULT '',
  transp TINYINT NOT NULL DEFAULT 1,
  priority TINYINT NOT NULL DEFAULT 0,
  admission TINYINT NOT NULL DEFAULT 0,
  class VARCHAR(255) NOT NULL DEFAULT 'PUBLIC',
  rrule VARCHAR(255) NOT NULL DEFAULT '',
  rrule_pid int(8) unsigned zerofill NOT NULL DEFAULT 0,
  unique_id VARCHAR(255) NOT NULL DEFAULT '',
  allday TINYINT NOT NULL DEFAULT 0,
  start INT(10) unsigned NOT NULL DEFAULT 0,
  end INT(10) unsigned NOT NULL DEFAULT 0,

  start_date date,
  end_date date,
  cid smallint(5) unsigned zerofill NOT NULL default '0',
  comments mediumint(8) unsigned NOT NULL default '0',
  event_tz float(3,1) NOT NULL default 0.0,
  server_tz float(3,1) NOT NULL default 0.0,
  poster_tz float(3,1) NOT NULL default 0.0,

  extkey0 INT(10) unsigned zerofill NOT NULL DEFAULT 0,
  extkey1 INT(10) unsigned zerofill NOT NULL DEFAULT 0,

  KEY (admission),
  KEY (allday),
  KEY (start),
  KEY (end),
  KEY (start_date),
  KEY (end_date),
  KEY (dtstamp),
  KEY (unique_id),
  KEY (cid),
  KEY (event_tz),
  KEY (server_tz),
  KEY (poster_tz),
  KEY (uid),
  KEY (groupid),
  KEY (class),
  KEY (rrule_pid),
  KEY (categories),

  PRIMARY KEY (id)
) ENGINE=MyISAM;


CREATE TABLE pical0_cat (
  cid smallint(5) unsigned zerofill NOT NULL auto_increment,
  pid smallint(5) unsigned zerofill NOT NULL default '0',
  weight smallint(5) NOT NULL default 0,
  exportable tinyint NOT NULL default 1,
  autocreated tinyint NOT NULL default 0,
  ismenuitem tinyint NOT NULL default 0,
  enabled tinyint NOT NULL default 1,
  cat_title varchar(255) NOT NULL default '',
  cat_desc text NOT NULL,
  dtstamp TIMESTAMP(14) NOT NULL,
  cat_extkey0 INT(10) unsigned zerofill NOT NULL DEFAULT 0,
  cat_depth TINYINT unsigned NOT NULL DEFAULT 0,
  cat_style varchar(255) NOT NULL default '',
  KEY (pid),
  KEY (weight),
  KEY (cat_depth),
  PRIMARY KEY (cid)
) ENGINE=MyISAM;


CREATE TABLE pical0_plugins (
  pi_id smallint(5) unsigned zerofill NOT NULL auto_increment,
  pi_title varchar(255) NOT NULL default '',
  pi_type varchar(8) NOT NULL default '',
  pi_dirname varchar(50) NOT NULL default '',
  pi_file varchar(50) NOT NULL default '',
  pi_dotgif varchar(255) NOT NULL default '',
  pi_options varchar(255) NOT NULL default '',
  pi_enabled tinyint NOT NULL default 0,
  pi_weight smallint(5) unsigned NOT NULL default 0,
  last_modified timestamp ,

  KEY (pi_weight),
  KEY (pi_type),
  KEY (pi_dirname),
  KEY (pi_file),
  KEY (pi_options),
  KEY (pi_enabled),
  PRIMARY KEY (pi_id)
) ENGINE=MyISAM;
