# phpMyAdmin MySQL-Dump
# Hosts: http://www.tomsys.net/
# laiks: 0305.2003 00:08
# --------------------------------------------------------

CREATE TABLE relacione (
  recid int(10) NOT NULL auto_increment,
  urid int(10) NOT NULL default '0',
  modid tinyint(5) NOT NULL default '0',
  topicid smallint(4) NOT NULL default '0',
  storyid int(8) NOT NULL default '0',
  storypageid smallint(4) NOT NULL default '0',
  downloadcatid int(5) NOT NULL default '0',
  downloadlid int(10) NOT NULL default '0',
  visible tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (recid),
  KEY modid (modid),
  KEY topicid (topicid),
  KEY storyid (storyid),
  KEY downloadcatid (downloadcatid),
  KEY urid (urid)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE relacione_tmpuri (
  recid int(10) NOT NULL auto_increment,
  modid smallint(5) NOT NULL default '0',
  url varchar(255) NOT NULL default '',
  urid int(10) NOT NULL default '0',
  title varchar(120) NOT NULL default '',
  PRIMARY KEY  (recid),
  KEY modid (modid),
  KEY urid (urid)
) TYPE=MyISAM;
# --------------------------------------------------------

CREATE TABLE relacione_uri (
  urid int(10) NOT NULL auto_increment,
  title varchar(120) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  home_url varchar(255) NOT NULL default '',
  PRIMARY KEY  (urid),
  KEY title (title),
  KEY url (url)
) TYPE=MyISAM;