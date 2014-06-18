/*
SQLyog Enterprise v10.3 
MySQL - 5.5.27 : Database - dlayer
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dlayer` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `dlayer`;

/*Table structure for table `color_palette_colors` */

DROP TABLE IF EXISTS `color_palette_colors`;

CREATE TABLE `color_palette_colors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `palette_id` int(11) unsigned NOT NULL,
  `type` enum('primary','secondary','tertiary') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `r` tinyint(3) NOT NULL DEFAULT '0',
  `g` tinyint(3) NOT NULL DEFAULT '0',
  `b` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `color_palette_colors` */

insert  into `color_palette_colors`(`id`,`palette_id`,`type`,`name`,`hex`,`r`,`g`,`b`) values (1,1,'primary','Black','#000000',0,0,0),(2,1,'secondary','Tan','#f3f1df',127,127,127),(3,1,'tertiary','Dark grey','#666666',102,102,102),(4,2,'primary','Blue','#336699',51,102,127),(5,2,'secondary','Dark grey','#666666',102,102,102),(6,2,'tertiary','Grey','#999999',127,127,127),(7,3,'primary','Blue','#003366',0,51,102),(8,3,'secondary','White','#FFFFFF',127,127,127),(9,3,'tertiary','Orange','#FF6600',127,102,0);

/*Table structure for table `color_palettes` */

DROP TABLE IF EXISTS `color_palettes`;

CREATE TABLE `color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `color_palettes` */

insert  into `color_palettes`(`id`,`name`) values (1,'Palette A'),(2,'Palette B'),(3,'Palette C');

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `modules` */

insert  into `modules`(`id`,`name`) values (1,'Template designer');

/*Table structure for table `ribbon_tabs` */

DROP TABLE IF EXISTS `ribbon_tabs`;

CREATE TABLE `ribbon_tabs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(2) unsigned NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `script_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tool_id` (`tool_id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ribbon_tabs` */

insert  into `ribbon_tabs`(`id`,`module_id`,`tool_id`,`name`,`script_name`,`default`,`sort_order`) values (1,1,2,'Quick split','quick',1,1),(2,1,2,'Advanced split','advanced',0,2),(3,1,2,'Help','help',0,3),(4,1,3,'Quick split','quick',1,1),(5,1,3,'Advanced split','advanced',0,2),(6,1,3,'Help','help',0,3);

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `session_id` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `save_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `session_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`session_id`,`save_path`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('05t2bkv50ukdn9ar46277qeko7','','PHPSESSID',1349310928,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";s:1:\"2\";s:4:\"tool\";s:1:\"2\";s:10:\"ribbon_tab\";s:1:\"1\";}'),('6fj2v3q9l28btmgks3otpqq9e7','','PHPSESSID',1350253557,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";N;s:4:\"tool\";N;s:10:\"ribbon_tab\";N;}'),('9mdtlefuu1bh9ojo8duamn0aa7','','PHPSESSID',1349832406,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";s:1:\"1\";s:4:\"tool\";N;s:10:\"ribbon_tab\";N;}'),('drd2ken83jn0bfnaasof7c4ok3','','PHPSESSID',1349656043,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}'),('e727q8cp8lsh0p5t98s6kmj6b6','','PHPSESSID',1349484185,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}'),('erphg56ssie9ak9h1qstj26td3','','PHPSESSID',1349225806,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";s:1:\"2\";s:4:\"tool\";s:1:\"2\";s:10:\"ribbon_tab\";s:1:\"1\";}'),('medjs2bvo65qipsfsr5glu7dj6','','PHPSESSID',1350827121,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";N;s:4:\"tool\";N;s:10:\"ribbon_tab\";N;}'),('o7i8bh5fqiedp5jm09o7cub4h4','','PHPSESSID',1350226393,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";N;s:4:\"tool\";N;s:10:\"ribbon_tab\";N;}'),('to659kq7m40jdsdlu09hgd9o46','','PHPSESSID',1349225679,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";s:1:\"1\";s:4:\"tool\";s:1:\"2\";s:10:\"ribbon_tab\";s:1:\"1\";}');

/*Table structure for table `sites` */

DROP TABLE IF EXISTS `sites`;

CREATE TABLE `sites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sites` */

insert  into `sites`(`id`,`name`) values (1,'Demo site 1');

/*Table structure for table `template_div_sizes` */

DROP TABLE IF EXISTS `template_div_sizes`;

CREATE TABLE `template_div_sizes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_div_id` int(11) unsigned NOT NULL,
  `width` int(4) NOT NULL DEFAULT '1',
  `height` int(4) NOT NULL DEFAULT '0',
  `design_height` int(4) NOT NULL DEFAULT '0',
  `fixed_height` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `template_div_id` (`template_div_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `template_div_sizes` */

insert  into `template_div_sizes`(`id`,`template_div_id`,`width`,`height`,`design_height`,`fixed_height`) values (1,1,328,500,500,0),(2,2,326,0,500,0),(3,3,326,500,500,0),(4,4,326,91,91,0),(5,5,326,409,409,0);

/*Table structure for table `template_divs` */

DROP TABLE IF EXISTS `template_divs`;

CREATE TABLE `template_divs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Parent, always set, base divs have a parent_id of 0',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Sort order within grouping',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `template_divs` */

insert  into `template_divs`(`id`,`template_id`,`parent_id`,`sort_order`) values (1,1,0,1),(2,1,0,1),(3,1,0,1),(4,1,2,1),(5,1,2,1);

/*Table structure for table `template_settings` */

DROP TABLE IF EXISTS `template_settings`;

CREATE TABLE `template_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL,
  `palette_1` int(11) NOT NULL,
  `palette_2` int(11) NOT NULL,
  `palette_3` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `template_settings` */

insert  into `template_settings`(`id`,`template_id`,`palette_1`,`palette_2`,`palette_3`) values (1,1,1,2,3);

/*Table structure for table `templates` */

DROP TABLE IF EXISTS `templates`;

CREATE TABLE `templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `templates` */

insert  into `templates`(`id`,`site_id`,`name`) values (1,1,'Template 1 site 1'),(2,1,'Template 2 site 1');

/*Table structure for table `tools` */

DROP TABLE IF EXISTS `tools`;

CREATE TABLE `tools` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `process_model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `script` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Script name in ribbon view folder',
  `icon` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `auto` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Automatic tool, no user input?',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Group within toolbar',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Sort order within group',
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`),
  KEY `group_id` (`group_id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tools` */

insert  into `tools`(`id`,`module_id`,`name`,`process_model`,`script`,`icon`,`auto`,`group_id`,`sort_order`) values (1,1,'Cancel','','cancel','cancel.png',1,1,1),(2,1,'Split horizontal','SplitHorizontal','split-horizontal','split-horizontal.png',0,2,1),(3,1,'Split vertical','SplitVertical','split-vertical','split-vertical.png',0,2,2),(4,1,'Resize width','','resize-width','resize-width.png',0,3,1),(5,1,'Resize height','','resize-height','resize-height.png',0,3,2),(6,1,'Resize','','resize','resize.png',0,3,3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
