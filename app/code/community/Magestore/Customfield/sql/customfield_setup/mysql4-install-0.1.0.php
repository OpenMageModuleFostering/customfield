<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('customfield_attribute')};
CREATE TABLE {$this->getTable('customfield_attribute')} (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(50) default NULL,
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

DROP TABLE IF EXISTS {$this->getTable('customfield_block')};
CREATE TABLE {$this->getTable('customfield_block')} (
  `id` int(11) NOT NULL auto_increment,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `customfield_block` VALUES (1, '');


");

$installer->endSetup(); 