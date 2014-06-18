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
  `type` enum('Primary','Secondary','Tertiary') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `r` tinyint(3) NOT NULL DEFAULT '0',
  `g` tinyint(3) NOT NULL DEFAULT '0',
  `b` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `color_palette_colors` */

insert  into `color_palette_colors`(`id`,`palette_id`,`type`,`name`,`hex`,`r`,`g`,`b`) values (1,1,'Primary','Black','#000000',0,0,0),(2,1,'Secondary','Tan','#f3f1df',127,127,127),(3,1,'Tertiary','Dark grey','#666666',102,102,102),(4,2,'Primary','Blue','#336699',51,102,127),(5,2,'Secondary','Dark grey','#666666',102,102,102),(6,2,'Tertiary','Grey','#999999',127,127,127),(7,3,'Primary','Blue','#003366',0,51,102),(8,3,'Secondary','White','#FFFFFF',127,127,127),(9,3,'Tertiary','Orange','#FF6600',127,102,0);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ribbon_tabs` */

insert  into `ribbon_tabs`(`id`,`module_id`,`tool_id`,`name`,`script_name`,`default`,`sort_order`) values (1,1,2,'Quick split','quick',1,1),(2,1,2,'Advanced split','advanced',0,2),(3,1,2,'Help','help',0,3),(4,1,3,'Quick split','quick',1,1),(5,1,3,'Advanced split','advanced',0,2),(6,1,3,'Help','help',0,3),(7,1,7,'Palette 1','palette-1',1,1),(8,1,7,'Palette 2','palette-2',0,2),(9,1,7,'Palette 3','palette-3',0,3),(10,1,7,'Advanced','advanced',0,4),(11,1,7,'Help','help',0,5);

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

insert  into `sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('c9muobup2u0p82li4n9r37gtk3','','PHPSESSID',1350951827,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";s:1:\"3\";s:4:\"tool\";s:1:\"7\";s:10:\"ribbon_tab\";s:1:\"7\";}'),('i99olgct70msb35ical1fi67q5','','PHPSESSID',1351037884,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";s:1:\"3\";s:4:\"tool\";s:1:\"7\";s:10:\"ribbon_tab\";s:1:\"7\";}'),('rpim0icasrnj6c8o0o479r92a7','','PHPSESSID',1350864687,1440,'dlayer_session|a:2:{s:4:\"site\";i:1;s:8:\"template\";i:1;}dlayer_session_template|a:3:{s:16:\"selected_element\";s:1:\"3\";s:4:\"tool\";s:1:\"7\";s:10:\"ribbon_tab\";s:1:\"7\";}');

/*Table structure for table `sites` */

DROP TABLE IF EXISTS `sites`;

CREATE TABLE `sites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sites` */

insert  into `sites`(`id`,`name`) values (1,'Demo site 1');

/*Table structure for table `template_color_palettes` */

DROP TABLE IF EXISTS `template_color_palettes`;

CREATE TABLE `template_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL,
  `palette_id` int(11) unsigned NOT NULL,
  `sort_order` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `template_color_palettes` */

insert  into `template_color_palettes`(`id`,`template_id`,`palette_id`,`sort_order`) values (1,1,1,1),(2,1,2,2),(3,1,3,3);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `template_div_sizes` */

insert  into `template_div_sizes`(`id`,`template_div_id`,`width`,`height`,`design_height`,`fixed_height`) values (1,1,980,0,250,0),(2,2,980,0,250,0),(3,3,328,250,250,0),(4,4,326,250,250,0),(5,5,326,0,250,0),(6,6,980,0,125,0),(7,7,980,125,125,0),(8,8,490,125,125,0),(9,9,490,125,125,0),(10,10,326,123,123,0),(11,11,326,127,127,0);

/*Table structure for table `template_divs` */

DROP TABLE IF EXISTS `template_divs`;

CREATE TABLE `template_divs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Parent, always set, base divs have a parent_id of 0',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Sort order within grouping',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `template_divs` */

insert  into `template_divs`(`id`,`template_id`,`parent_id`,`sort_order`) values (1,1,0,1),(2,1,0,1),(3,1,1,1),(4,1,1,1),(5,1,1,1),(6,1,2,1),(7,1,2,1),(8,1,6,1),(9,1,6,1),(10,1,5,1),(11,1,5,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tools` */

insert  into `tools`(`id`,`module_id`,`name`,`process_model`,`script`,`icon`,`auto`,`group_id`,`sort_order`) values (1,1,'Cancel','','cancel','cancel.png',1,1,1),(2,1,'Split horizontal','SplitHorizontal','split-horizontal','split-horizontal.png',0,2,1),(3,1,'Split vertical','SplitVertical','split-vertical','split-vertical.png',0,2,2),(4,1,'Resize width','','resize-width','resize-width.png',0,3,1),(5,1,'Resize height','','resize-height','resize-height.png',0,3,2),(6,1,'Resize','','resize','resize.png',0,3,3),(7,1,'Background color','BackgroundColor','background-color','background-color.png',0,4,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
