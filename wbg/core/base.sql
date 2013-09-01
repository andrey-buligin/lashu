
CREATE TABLE  `wbg_categories_permissions` (
  `group_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `permissions` varchar(100) default NULL COMMENT 'Permissions for child categories',
  `permissions_individual` varchar(100) default NULL COMMENT 'Permissii dlja dannoj kategorii',
  PRIMARY KEY  (`group_id`,`category_id`)
) ENGINE=MyISAM;


CREATE TABLE  `wbg_logs` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL default '0',
  `action` int(11) NOT NULL default '0',
  `_get` text,
  `_post` text NOT NULL,
  `_cookie` text,
  `target` varchar(255) NOT NULL default '',
  `ip` varchar(50) NOT NULL default '',
  `user` varchar(255) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `module` int(11) NOT NULL default '0',
  `category_id` int(11) default NULL,
  `url` varchar(255) default NULL,
  `referer` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM;



CREATE TABLE  `wbg_messages` (
  `id` int(10) unsigned NOT NULL default '0',
  `title` varchar(50) NOT NULL default '0',
  `content` text NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `language` tinyint(1) unsigned NOT NULL default '0'
) ENGINE=MyISAM;



CREATE TABLE  `wbg_mirrors` (
  `lang_1` int(10) unsigned NOT NULL,
  `lang_2` int(10) unsigned NOT NULL,
  `lang_3` int(10) unsigned NOT NULL
) ENGINE=MyISAM;



CREATE TABLE  `wbg_modules` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `file` varchar(150) NOT NULL,
  `type` int(10) unsigned NOT NULL default '1',
  `description` varchar(255) NOT NULL default '',
  `repository_id` varchar(20) default NULL,
  `category_id` int(10) unsigned NOT NULL,
  `repository_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM;



CREATE TABLE  `wbg_sets` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `input_module` mediumint(9) NOT NULL default '0',
  `output_module` mediumint(9) NOT NULL default '0',
  `property_template` mediumint(9) NOT NULL default '0',
  `output_template` mediumint(9) NOT NULL default '0',
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;



CREATE TABLE  `wbg_templates` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `file` varchar(50) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `description` varchar(255) default NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `file` (`file`)
) ENGINE=MyISAM;


CREATE TABLE  `wbg_tree_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `sort_id` tinyint(3) unsigned NOT NULL default '0',
  `level` tinyint(3) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `language` tinyint(3) unsigned NOT NULL default '0',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `dir` varchar(500) default NULL,
  `active` tinyint(1) unsigned NOT NULL default '0',
  `enabled` tinyint(1) unsigned NOT NULL default '0',
  `properties` text,
  `property_template` tinyint(3) unsigned NOT NULL default '0',
  `property_template2` tinyint(3) unsigned NOT NULL default '0',
  `output_template` tinyint(3) unsigned NOT NULL default '0',
  `input_module` tinyint(3) unsigned NOT NULL default '0',
  `output_module` tinyint(3) unsigned NOT NULL default '0',
  `access_level` tinyint(3) unsigned NOT NULL default '9',
  `permanent` tinyint(1) unsigned NOT NULL default '0',
  `other` varchar(50) default NULL,
  UNIQUE KEY `id` (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `dir` (`dir`(333))
) ENGINE=MyISAM;



CREATE TABLE  `wbg_tree_messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `sort_id` tinyint(3) unsigned NOT NULL default '0',
  `level` tinyint(3) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `permanent` tinyint(1) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM;


INSERT INTO `wbg_tree_messages` (`id`,`parent_id`,`sort_id`,`level`,`title`,`permanent`) VALUES 
 (1,0,1,0,'All messages',1);


CREATE TABLE  `wbg_tree_modules` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `sort_id` tinyint(3) unsigned NOT NULL default '0',
  `level` tinyint(3) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `permanent` tinyint(1) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM;



INSERT INTO `wbg_tree_modules` (`id`,`parent_id`,`sort_id`,`level`,`title`,`permanent`) VALUES 
 (1,0,1,0,'Input modules',1),
 (2,0,2,0,'Output modules',1),
 (3,0,3,0,'Standalone modules',1),
 (4,0,4,0,'Components',1),
 (5,0,5,0,'Libraries',1);


CREATE TABLE  `wbg_tree_templates` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `sort_id` tinyint(3) unsigned NOT NULL default '0',
  `level` tinyint(3) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `permanent` tinyint(1) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM;



INSERT INTO `wbg_tree_templates` (`id`,`parent_id`,`sort_id`,`level`,`title`,`permanent`) VALUES 
 (1,0,1,0,'Output templates',1),
 (2,0,3,0,'Property templates',1),
 (3,0,2,0,'User templates',1),
 (4,0,4,0,'Predefined templates',1);


CREATE TABLE  `wbg_tree_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `sort_id` tinyint(3) unsigned NOT NULL default '0',
  `level` tinyint(3) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `permissions` text,
  `permanent` tinyint(1) NOT NULL,
  UNIQUE KEY `id` (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM;


INSERT INTO `wbg_tree_users` (`id`,`parent_id`,`sort_id`,`level`,`title`,`permissions`,`permanent`) VALUES 
 (1,0,1,0,'Administrators',NULL,1),
 (2,0,2,0,'Content editors',NULL,1);


CREATE TABLE  `wbg_users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `login` varchar(50) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `category_id` int(11) NOT NULL,
  `I_name` varchar(50) NOT NULL default '',
  `I_surname` varchar(50) NOT NULL default '',
  `I_phone` varchar(50) NOT NULL default '',
  `interface_language` tinyint(4) default NULL,
  `active` tinyint(1) default NULL,
  `is_admin` tinyint(1) NOT NULL,
  `email` varchar(255) default NULL,
  `link_replace_from` varchar(45) NOT NULL COMMENT 'Na chto mi zamenim kusok linka',
  `link_replace_to` varchar(45) NOT NULL,
  `other` varchar(45) NOT NULL,
  `config_file` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM;
