/*
SQLyog Enterprise v11.01 (32 bit)
MySQL - 5.5.28-log : Database - dlayer
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

/*Table structure for table `designer_color_palette_colors` */

DROP TABLE IF EXISTS `designer_color_palette_colors`;

CREATE TABLE `designer_color_palette_colors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `palette_id` int(11) unsigned NOT NULL,
  `color_type_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `r` smallint(3) NOT NULL DEFAULT '0',
  `g` smallint(3) NOT NULL DEFAULT '0',
  `b` smallint(3) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `palette_id` (`palette_id`),
  KEY `color_type_id` (`color_type_id`),
  CONSTRAINT `designer_color_palette_colors_ibfk_1` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palettes` (`id`),
  CONSTRAINT `designer_color_palette_colors_ibfk_2` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palette_colors` */

insert  into `designer_color_palette_colors`(`id`,`palette_id`,`color_type_id`,`name`,`hex`,`r`,`g`,`b`,`enabled`) values (1,1,1,'Black','#000000',0,0,0,1),(2,1,2,'Tan','#f3f1df',127,127,127,1),(3,1,3,'Dark grey','#666666',102,102,102,1),(4,2,1,'Blue','#336699',51,102,127,1),(5,2,2,'Dark grey','#666666',102,102,102,1),(6,2,3,'Grey','#999999',127,127,127,1),(7,3,1,'Blue','#003366',0,51,102,1),(8,3,2,'White','#FFFFFF',127,127,127,1),(9,3,3,'Orange','#FF6600',255,255,255,1);

/*Table structure for table `designer_color_palettes` */

DROP TABLE IF EXISTS `designer_color_palettes`;

CREATE TABLE `designer_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palettes` */

insert  into `designer_color_palettes`(`id`,`name`,`view_script`,`enabled`) values (1,'Palette 1','palette-1',1),(2,'Palette 2','palette-2',1),(3,'Palette 3','palette-3',1);

/*Table structure for table `designer_color_types` */

DROP TABLE IF EXISTS `designer_color_types`;

CREATE TABLE `designer_color_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_types` */

insert  into `designer_color_types`(`id`,`type`) values (1,'Primary'),(2,'Secondary'),(3,'Tertiary');

/*Table structure for table `designer_content_types` */

DROP TABLE IF EXISTS `designer_content_types`;

CREATE TABLE `designer_content_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_types` */

insert  into `designer_content_types`(`id`,`name`,`description`,`enabled`) values (1,'text','Text block',1);

/*Table structure for table `designer_css_border_styles` */

DROP TABLE IF EXISTS `designer_css_border_styles`;

CREATE TABLE `designer_css_border_styles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `style` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `style` (`style`),
  KEY `sort_order` (`sort_order`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Border styles that can be used within the designers';

/*Data for the table `designer_css_border_styles` */

insert  into `designer_css_border_styles`(`id`,`name`,`style`,`sort_order`,`enabled`) values (1,'Solid','solid',1,1),(2,'Dashed','dashed',2,1),(3,'No border','none',9,1);

/*Table structure for table `designer_css_text_decorations` */

DROP TABLE IF EXISTS `designer_css_text_decorations`;

CREATE TABLE `designer_css_text_decorations` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_decorations` */

insert  into `designer_css_text_decorations`(`id`,`name`,`css`,`sort_order`,`enabled`) values (1,'None','none',1,1),(2,'Underline','underline',2,1),(3,'Strike-through','line-through',3,1);

/*Table structure for table `designer_css_text_styles` */

DROP TABLE IF EXISTS `designer_css_text_styles`;

CREATE TABLE `designer_css_text_styles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_styles` */

insert  into `designer_css_text_styles`(`id`,`name`,`css`,`sort_order`,`enabled`) values (1,'Normal','normal',1,1),(2,'Italic','italic',2,1),(3,'Oblique','oblique',3,1);

/*Table structure for table `designer_css_text_weights` */

DROP TABLE IF EXISTS `designer_css_text_weights`;

CREATE TABLE `designer_css_text_weights` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_weights` */

insert  into `designer_css_text_weights`(`id`,`name`,`css`,`sort_order`,`enabled`) values (1,'Normal','400',1,1),(2,'Bold','700',2,1),(3,'Light','100',3,1);

/*Table structure for table `designer_html_headings` */

DROP TABLE IF EXISTS `designer_html_headings`;

CREATE TABLE `designer_html_headings` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_html_headings` */

insert  into `designer_html_headings`(`id`,`name`,`tag`,`sort_order`,`enabled`) values (1,'Page title','h1',1,1),(2,'Heading 1','h2',2,1),(3,'Heading 2','h3',3,1),(4,'Heading 3','h4',4,1),(5,'Heading 4','h5',5,1),(6,'Heading 5','h6',6,1),(7,'Heading 6','h7',7,1);

/*Table structure for table `dlayer_development_log` */

DROP TABLE IF EXISTS `dlayer_development_log`;

CREATE TABLE `dlayer_development_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `change` text COLLATE utf8_unicode_ci NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_development_log` */

insert  into `dlayer_development_log`(`id`,`change`,`added`,`enabled`) values (1,'Added a development log to Dlayer to show changes to the application, two reasons, one to spur on my development, two, to show the public what I am adding.','2013-04-05 00:38:16',1),(2,'Added a pagination view helper, update of my existing pagination view helper.','2013-04-05 00:38:52',1),(6,'Added a helper class to the library, couple of static helper functions','2013-04-08 01:20:22',1),(7,'Updated the pagination view helper, added the ability to define text to use for links and also updated the logic for \'of n\' text.','2013-04-08 02:03:42',1),(8,'Updated the default styling for tables, header row and table rows.','2013-04-08 02:19:22',1);

/*Table structure for table `dlayer_module_tool_tabs` */

DROP TABLE IF EXISTS `dlayer_module_tool_tabs`;

CREATE TABLE `dlayer_module_tool_tabs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(2) unsigned NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'View script for tool tab',
  `multi_use` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tool_tab` (`tool_id`,`view_script`),
  KEY `name` (`name`),
  KEY `sort_order` (`sort_order`),
  KEY `enabled` (`enabled`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `dlayer_module_tool_tabs_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`),
  CONSTRAINT `dlayer_module_tool_tabs_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tools` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tabs` */

insert  into `dlayer_module_tool_tabs`(`id`,`module_id`,`tool_id`,`name`,`view_script`,`multi_use`,`default`,`sort_order`,`enabled`) values (1,1,2,'Quick split','quick',0,1,1,1),(2,1,2,'Split with mouse','advanced',0,0,2,1),(3,1,2,'Help','help',0,0,3,1),(4,1,3,'Quick split','quick',0,1,1,1),(5,1,3,'Split with mouse','advanced',0,0,2,1),(6,1,3,'Help','help',0,0,3,1),(7,1,7,'Palette 1','palette-1',0,1,1,1),(8,1,7,'Palette 2','palette-2',0,0,2,1),(9,1,7,'Palette 3','palette-3',0,0,3,1),(10,1,7,'Set custom color','advanced',0,0,4,1),(11,1,7,'Help','help',0,0,5,1),(12,1,6,'Set custom size','advanced',1,0,4,1),(14,1,6,'Help','help',0,0,5,1),(15,1,6,'Expand','expand',1,1,1,1),(16,1,6,'Contract','contract',1,0,2,1),(17,1,6,'Adjust height','height',1,0,3,1),(20,1,8,'Set custom border','advanced',1,1,2,1),(21,1,8,'Help','help',0,0,3,1),(22,1,8,'Full border','full',0,0,1,1),(23,4,10,'Text','text',1,1,1,1),(24,4,11,'Header','header',1,1,1,1),(25,4,10,'Help','help',0,0,2,1),(26,4,11,'Help','help',0,0,2,1),(27,3,12,'Text field','text',0,1,1,1),(28,3,12,'Help','help',0,0,2,1);

/*Table structure for table `dlayer_module_tools` */

DROP TABLE IF EXISTS `dlayer_module_tools`;

CREATE TABLE `dlayer_module_tools` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tool` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tool name to use through code',
  `tool_model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tool process model',
  `folder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Folder for tool tab ciew scripts',
  `icon` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `base` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Can tool run on base div',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Group within toolbar',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Sort order within group',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tool` (`module_id`,`tool`),
  KEY `group_id` (`group_id`),
  KEY `sort_order` (`sort_order`),
  CONSTRAINT `dlayer_module_tools_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tools` */

insert  into `dlayer_module_tools`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`icon`,`base`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','cancel',NULL,'cancel','cancel.png',1,1,1,1),(2,1,'Split horizontal','split-horizontal','SplitHorizontal','split-horizontal','split-horizontal.png',1,2,1,1),(3,1,'Split vertical','split-vertical','SplitVertical','split-vertical','split-vertical.png',1,2,2,1),(6,1,'Resize','resize','Resize','resize','resize.png',0,3,3,1),(7,1,'Background color','background-color','BackgroundColor','background-color','background-color.png',1,4,1,1),(8,1,'Border','border','Border','border','border.png',0,4,2,1),(9,4,'Cancel','cancel',NULL,'cancel','cancel.png',1,1,1,1),(10,4,'Text','text','Text','text','text.png',0,2,1,1),(11,4,'Header','header','Header','header','header.png',0,2,2,1),(12,3,'Text','text','Text','text','text.png',0,2,1,1),(13,3,'Text area','textarea','TextArea','textarea','textarea.png',0,2,2,1),(14,3,'Cancel','cancel',NULL,'cancel','cancel.png',1,1,1,1);

/*Table structure for table `dlayer_modules` */

DROP TABLE IF EXISTS `dlayer_modules`;

CREATE TABLE `dlayer_modules` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_modules` */

insert  into `dlayer_modules`(`id`,`name`,`title`,`description`,`icon`,`sort_order`,`enabled`) values (1,'template','Template designer','Design templates define the basic structure for a webpage.','template.png',1,1),(2,'widget','Widget designer','Widgets are reusable fragments, if you have something that needs to appear on multiple pages it should probably be a widget.','widget.png',4,1),(3,'form','Forms builder','Create a form to capture user input.','form.png',3,1),(4,'content','Content manager','Create pages and add content to them, content can be anything, text, images, forms, widgets.','content.png',2,1),(5,'website','Website manager','Define the structure of your website by setting the relationship between web pages.','website.png',5,1);

/*Table structure for table `dlayer_sessions` */

DROP TABLE IF EXISTS `dlayer_sessions`;

CREATE TABLE `dlayer_sessions` (
  `session_id` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `save_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `session_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`session_id`,`save_path`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_sessions` */

insert  into `dlayer_sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('06pbc133olj5t60thfrf66dig7','','PHPSESSID',1365383709,1440,''),('0983eflidfj84ie6219h2b6bt2','','PHPSESSID',1365383607,1440,''),('0hggcf0b1rurl550a7bsut6o00','','PHPSESSID',1365383969,1440,''),('0ma986b1l6968fukiddn6t6i55','','PHPSESSID',1365383049,1440,''),('12br4m8dcl168lea2lnigtvha4','','PHPSESSID',1365383623,1440,''),('16se7pg5n89o9976fk91k4b414','','PHPSESSID',1365383709,1440,''),('1avt9bt7oq9q7i1ccsr84o4dt1','','PHPSESSID',1365383715,1440,''),('1c9mb94sid5vqd7oh70r2nrru1','','PHPSESSID',1365383749,1440,''),('1eeks4o3affhfupltripb3mar2','','PHPSESSID',1365383466,1440,''),('1futabrpe0r49v1559r6lacid3','','PHPSESSID',1365383522,1440,''),('1hn12smuqg1a2klq35ddne8qp2','','PHPSESSID',1365383769,1440,''),('1i5fvrmlm47uidlfvqj3jt99l3','','PHPSESSID',1365383243,1440,''),('1ovrc7n09a4338npurudi45gf4','','PHPSESSID',1365382939,1440,''),('1sqidijuphgsectcrfjbc01ph1','','PHPSESSID',1365383698,1440,''),('209n0deito9p3o4dhm2rvk4hu4','','PHPSESSID',1365382587,1440,''),('29p4fjelur0hakt39pqijig1i4','','PHPSESSID',1365383483,1440,''),('2h22p76fr88bsr37fbi14l9ad6','','PHPSESSID',1365383482,1440,''),('2l6i9poelfmfsmdqu7gvdguqt2','','PHPSESSID',1365383710,1440,''),('2qkjegtoe1dborv3k98rutp373','','PHPSESSID',1365383409,1440,''),('2u0n74mgg8l3incn415mkm57d7','','PHPSESSID',1365383867,1440,''),('326jbcaba7lu244gmle0eluc80','','PHPSESSID',1365382331,1440,''),('39mk03if41jg6ort1k3i8h38s4','','PHPSESSID',1365383459,1440,''),('3hcoq28hb3mcp579ivoikntps0','','PHPSESSID',1365382670,1440,''),('40ourhu9524vgcpt95m000j1u1','','PHPSESSID',1365383523,1440,''),('44702d6ts1d8a068j91q85r623','','PHPSESSID',1365383214,1440,''),('4b69g0rhd4j248ptptss8nsiu1','','PHPSESSID',1365383696,1440,''),('4jglsridljnrl6vfutrjb7d8t7','','PHPSESSID',1365383625,1440,''),('4jt7lpbjvlmq8f0rkplqkn9487','','PHPSESSID',1365383798,1440,''),('4klpto0jp5bf95sjopah5anf81','','PHPSESSID',1365383484,1440,''),('50ao5uqo711bi87s8fjdvcfn80','','PHPSESSID',1365382795,1440,''),('5294720ovpl2sv5hoc48pq7b16','','PHPSESSID',1365383872,1440,''),('57a0e6vlhfcavdtt2qqhfubag4','','PHPSESSID',1365383770,1440,''),('5aptscs18fphli3ohgk7no8p54','','PHPSESSID',1365383464,1440,''),('5bo4kme54aiaj0ed7r02shtbh5','','PHPSESSID',1365383750,1440,''),('5elcrbv608ikmbciovenk4og70','','PHPSESSID',1365382794,1440,''),('5jv598nl7u65nihvbklhc4sp02','','PHPSESSID',1365383899,1440,''),('5mvptejmge3b05t5am7skf5h24','','PHPSESSID',1365382883,1440,''),('5n04libte8kbtmahspicn9ct37','','PHPSESSID',1365382940,1440,''),('5s3vamh427isjp1aalg7cj0247','','PHPSESSID',1365383899,1440,''),('648sm1grn8mv3ji19ga561esd4','','PHPSESSID',1365383980,1440,''),('6886dpvjh06gqm8biqpp56m3j3','','PHPSESSID',1365383465,1440,''),('6ei7oi93ac26odkmir4vtvro53','','PHPSESSID',1365382887,1440,''),('6h50ssfecpjss7nbb67a2d5j76','','PHPSESSID',1365382943,1440,''),('6ja1qsp8m84955cbsbkane3ia6','','PHPSESSID',1365383064,1440,''),('6ke180j9cbkat5hbedo3isuvq6','','PHPSESSID',1365383769,1440,''),('6mnk665s803u17pp4n0pbjf205','','PHPSESSID',1365383405,1440,''),('6q13qlbn7576r63ehl1up65bv0','','PHPSESSID',1365383462,1440,''),('72ifvkcscsuqd55u92g2qvjdu4','','PHPSESSID',1365383977,1440,''),('7c32j5vgrp240kmnfh6cm5s3g3','','PHPSESSID',1365382874,1440,''),('896a3avld8iai6vg4iccptgev1','','PHPSESSID',1365382684,1440,''),('8b1u5h21cka77k0tnmij0jk565','','PHPSESSID',1365383063,1440,''),('8cs7qdde238l7h3fjp51eld6s0','','PHPSESSID',1365383541,1440,''),('8epfbfdulahu2k3dbrvsv7jgp4','','PHPSESSID',1365383740,1440,''),('8fvkue11tfm67vd7tqhsl4gm44','','PHPSESSID',1365383470,1440,''),('8mp3iqabrj97fphh2nfaatmse5','','PHPSESSID',1365382591,1440,''),('8ofkgl5lkipic1kojoa7gi8rl2','','PHPSESSID',1365383536,1440,''),('8uacbtqhv7h7sciqfgpodm3dh0','','PHPSESSID',1365382277,1440,''),('8v2tprlpaqi1m2j4954j7asu90','','PHPSESSID',1365383471,1440,''),('91mci8lfi1autll8kmdajk1tr2','','PHPSESSID',1365382796,1440,''),('9c16dtrktbpmmd5nn8dnfq1kq4','','PHPSESSID',1365382558,1440,''),('9en223lhjkt5kokhlb314i81p3','','PHPSESSID',1365383768,1440,''),('9m2l9c306ib9gsi5eblqejakv0','','PHPSESSID',1365383621,1440,''),('9rspcuts3ro3nsu0dnocj7ukv4','','PHPSESSID',1365383437,1440,''),('a386okhq8l4dhipt3nhktsjve0','','PHPSESSID',1365383047,1440,''),('ar4351esed87fep2uq0ohfhak6','','PHPSESSID',1365383982,1440,'dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"1\";}dlayer_session_template|a:3:{s:11:\"template_id\";i:1;s:4:\"tool\";N;s:15:\"selected_div_id\";N;}'),('b5nbeqjligqo9e6foe2ugvpq76','','PHPSESSID',1365383540,1440,''),('b7sqf2ohuppbvigtm535thhj25','','PHPSESSID',1365383407,1440,''),('ba0lhpr6o8vofk7ppu6jjk7pb1','','PHPSESSID',1365383799,1440,''),('bg4rehkofipsuhjj5i38en8cl1','','PHPSESSID',1365383408,1440,''),('bjmecuehqs6v93isgq8us3h624','','PHPSESSID',1365382560,1440,''),('bkljvihvpf5ueup0lb248l4h10','','PHPSESSID',1365383524,1440,''),('c2f9dgvvqc06nit2i435j6ebo7','','PHPSESSID',1365383535,1440,''),('c33072f49k5sm4uuuokgan60b5','','PHPSESSID',1365382944,1440,''),('c38b9ehjjl9fgvbslr12rn1qk0','','PHPSESSID',1365382977,1440,''),('c9aire08r7hvet3ij6446gh656','','PHPSESSID',1365383442,1440,''),('c9ms8ku7qr9nkgr3pkl197f4m2','','PHPSESSID',1365383345,1440,''),('d35feoe37521mrpu097fg9o1o2','','PHPSESSID',1365382662,1440,''),('d49vet9tcf2il7mpq6dm1e3920','','PHPSESSID',1365382588,1440,''),('dr97vkgprairm5b5stuprtcce0','','PHPSESSID',1365383484,1440,''),('dudgl0usnacq1quq81ulpbukq3','','PHPSESSID',1365383979,1440,''),('edlcrmj6bkqo4qegf6hj0882f3','','PHPSESSID',1365382788,1440,''),('efdt1b4tv2raoas16lm2jqc2n7','','PHPSESSID',1365383435,1440,''),('eqjglh4tl7me94a9s2hboqgch4','','PHPSESSID',1365383714,1440,''),('et9h6rt45iumc9mq2ribtq5g94','','PHPSESSID',1365383404,1440,''),('fed23tiu1od5aoukucl2v34fi4','','PHPSESSID',1365383521,1440,''),('fmbvcogbtstcolfq2r31sso367','','PHPSESSID',1365383534,1440,''),('g405jherni7nv9b356rkkb26v2','','PHPSESSID',1365382789,1440,''),('g5k5jol0u4h9muqic5a8m8klb5','','PHPSESSID',1365383695,1440,''),('gftff8okijbpiovrm991li4801','','PHPSESSID',1365383978,1440,''),('gkgg981afmlsnng2hmpa94tp41','','PHPSESSID',1365382589,1440,''),('go8u76b981tlknrfat9k3h8rs6','','PHPSESSID',1365383849,1440,''),('gtg0hh0on8qun2ltug1ij0l866','','PHPSESSID',1365383064,1440,''),('h4715dom1835r8dq9feeflgb83','','PHPSESSID',1365382562,1440,''),('h7jt4u5ff46ksucuslbuiqu151','','PHPSESSID',1365383750,1440,''),('hj4ql456uadkod1it1qtovjpp5','','PHPSESSID',1365382561,1440,''),('hpodkmta5nblpobrsm9l5adog0','','PHPSESSID',1365383434,1440,''),('hs8fq6qr11cfhcc30dleqomdh6','','PHPSESSID',1365383538,1440,''),('hulbt0i2c08rm1lb130jcltmc0','','PHPSESSID',1365383536,1440,''),('hv8h2k01g57ljobg4vfs7e7077','','PHPSESSID',1365383215,1440,''),('i90n82kfjc5vujtaq1hkan8t76','','PHPSESSID',1365383484,1440,''),('im8nu28qbql7fspr3gs27fgge7','','PHPSESSID',1365383697,1440,''),('irhlsrgehk969614nh7entq9q3','','PHPSESSID',1365383378,1440,''),('jb2tcf8101ccc417gfin5kqid4','','PHPSESSID',1365383403,1440,''),('jbhdaiav5mi00tvqavtj0q22i1','','PHPSESSID',1365382278,1440,''),('jeif2etnjo474756gdq0ga51g7','','PHPSESSID',1365383480,1440,''),('jlo17ev7g8j900r81even80q46','','PHPSESSID',1365382884,1440,''),('jqmmfrc8e3jq0omtt0nik0j4h2','','PHPSESSID',1365383968,1440,''),('jr78te9vpegtqctflda22c9632','','PHPSESSID',1365382795,1440,''),('jvcbnuiqif59qjm5aojhuvea03','','PHPSESSID',1365383469,1440,''),('k3qh5qcu6npc593u31tbf4icb6','','PHPSESSID',1365383380,1440,''),('k7f20sa8bdh8m4gpv7uqmv6hq6','','PHPSESSID',1365383380,1440,''),('k8a4alg1ova1ml8c5sni0nv854','','PHPSESSID',1365383064,1440,''),('kaeh27cl902lsr2koio59nkbl0','','PHPSESSID',1365383868,1440,''),('kip4t8p1t1bej3de40h9rjl0p3','','PHPSESSID',1365382690,1440,''),('kmb6e13of7fihummbeoa80qa34','','PHPSESSID',1365383444,1440,''),('kr6hao5t8pcroruujbpo3jlmc6','','PHPSESSID',1365383472,1440,''),('l3t814p9a2ms2j72fpgo6gda96','','PHPSESSID',1365383848,1440,''),('la9o9c8m5t0pdslfck1dqbiok6','','PHPSESSID',1365383481,1440,''),('lf7932rapa72aac8nf9d086ht7','','PHPSESSID',1365383463,1440,''),('lggrp1r8j54ol1rcap3klcb1k6','','PHPSESSID',1365382875,1440,''),('lh9i51c0tar3kgqdm3q85it0k7','','PHPSESSID',1365382662,1440,''),('lo47g3629bmc7g9foflgjl11s7','','PHPSESSID',1365383344,1440,''),('lvrri5e15rmgc42raiql7tauq2','','PHPSESSID',1365383483,1440,''),('m2r9a9hcj8fffpog06na1hkcl7','','PHPSESSID',1365383865,1440,''),('m5ot31mc5v82qsp6hnsfd0qrm3','','PHPSESSID',1365383485,1440,''),('m5q7pd422lfe4lh5vlkd5eih95','','PHPSESSID',1365383484,1440,''),('m6rauv3imcuf9mlasfe742ljf5','','PHPSESSID',1365383444,1440,''),('m73ernstkg4pg7pv0sqhrsves2','','PHPSESSID',1365382652,1440,''),('m83n5eoujl7bssburei9b51ep7','','PHPSESSID',1365383749,1440,''),('mv8f3metlpld00jad3ap3dvjg7','','PHPSESSID',1365383603,1440,''),('neeh27j93gtcsf2l1ksf8i21c2','','PHPSESSID',1365383540,1440,''),('nk8rkg46nq27qtocgqbd0k6do4','','PHPSESSID',1365383463,1440,''),('nlkgeasjdbn6bnearmk45ka637','','PHPSESSID',1365382559,1440,''),('ns9u22p0ckcqr2pheuj2qm45t2','','PHPSESSID',1365383344,1440,''),('o0sb6ei5ebrgg11u43n9elgek4','','PHPSESSID',1365383715,1440,''),('o6tfh485sdvdreerpc7dbbd692','','PHPSESSID',1365382592,1440,''),('oh8dcuqrp1h7gnpg97v6uk9cp5','','PHPSESSID',1365383982,1440,''),('ouf321kg0eav8p0v1saumthp57','','PHPSESSID',1365383520,1440,''),('p17g2l9tkr2md2k5t4lnj0tg30','','PHPSESSID',1365383468,1440,''),('pbl7i336r3tdb6v3sgbtreq510','','PHPSESSID',1365382941,1440,''),('pc7kgeq01uan9vijlifdqrj7h1','','PHPSESSID',1365383911,1440,''),('q80d5p07uelhqrukehpnldrdf1','','PHPSESSID',1365383466,1440,''),('q8b0k0lmhniruspuncoq3c98t3','','PHPSESSID',1365382280,1440,''),('qcbo8ls9j12ful07cs2h0eg0a7','','PHPSESSID',1365382279,1440,''),('qcjbfc8f4ohkreo9ppj461ul62','','PHPSESSID',1365383540,1440,''),('qojauvg3kh40s6bhar27cq4pk6','','PHPSESSID',1365383443,1440,''),('r08973aetknmn6vp8u9jvettd3','','PHPSESSID',1365383048,1440,''),('r23sknlhvqbpa36dcmunfvb4l0','','PHPSESSID',1365383468,1440,''),('r2q3jeih14b00u1pp4g9fc66p5','','PHPSESSID',1365383770,1440,''),('r3h4k3pbvp68g5qn227omegla6','','PHPSESSID',1365382794,1440,''),('rdpbumsrgu06cjrtkn4827h1o0','','PHPSESSID',1365383604,1440,''),('rnbup3tki18tin76er6nr3d541','','PHPSESSID',1365383799,1440,''),('romqcs3nnu00l41a0i10l0l2u7','','PHPSESSID',1365383460,1440,''),('rpdelqk1e75bn7r8fqtidoen52','','PHPSESSID',1365383214,1440,''),('rrdbo3764i7ivv96qccbl21pp6','','PHPSESSID',1365383606,1440,''),('rvu585i6oka8kt38pj7cdss336','','PHPSESSID',1365383485,1440,''),('s5vn6abvcjcsordjk4lsnmfun3','','PHPSESSID',1365383715,1440,''),('s6jc8c1m6oc38jb8h81dd6usa0','','PHPSESSID',1365383436,1440,''),('sa9ih5dvbs3a1nbr2qt954eho6','','PHPSESSID',1365383213,1440,''),('spt6l2i5m763d79uaoa5obl3t2','','PHPSESSID',1365382278,1440,''),('spvraojhmod9iqgu5g8056rck5','','PHPSESSID',1365383377,1440,''),('t0hjvdht46grb6qfp43d42svf7','','PHPSESSID',1365383708,1440,''),('td45tl9l68u3ue9d9qeovnmcj3','','PHPSESSID',1365383716,1440,''),('tmai1h52hoifp2chtmd0sip1i1','','PHPSESSID',1365383407,1440,''),('tqgqu59bmgdnif5k413i87upf2','','PHPSESSID',1365383461,1440,''),('ttp7aulp42t40a336k85d8h9u4','','PHPSESSID',1365382938,1440,''),('u92ttmtjff2naijv525mai20n7','','PHPSESSID',1365383215,1440,''),('ubr3r81fnj40ilm3siqnslfhq4','','PHPSESSID',1365383447,1440,''),('ug033u4uivftljl21p394130t1','','PHPSESSID',1365382330,1440,''),('uj1q2forsrscn47l3rsbmdm4b0','','PHPSESSID',1365383910,1440,''),('ujal57hmcjsskgbjqhdlho2774','','PHPSESSID',1365383448,1440,''),('vm0srfnsseerliatbgadbds6f1','','PHPSESSID',1365382885,1440,'');

/*Table structure for table `form_field_types` */

DROP TABLE IF EXISTS `form_field_types`;

CREATE TABLE `form_field_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `form_field_types` */

insert  into `form_field_types`(`id`,`name`,`description`,`enabled`) values (1,'Text','Allows a user to enter a single line, for example their name or email.',1),(2,'Textarea','Allows a user to enter multiple lines of text.',1);

/*Table structure for table `user_forms` */

DROP TABLE IF EXISTS `user_forms`;

CREATE TABLE `user_forms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_forms_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_forms` */

/*Table structure for table `user_settings_color_palette_colors` */

DROP TABLE IF EXISTS `user_settings_color_palette_colors`;

CREATE TABLE `user_settings_color_palette_colors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `palette_id` int(11) unsigned NOT NULL,
  `color_type_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `r` smallint(3) NOT NULL DEFAULT '0',
  `g` smallint(3) NOT NULL DEFAULT '0',
  `b` smallint(3) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `site_id` (`site_id`),
  KEY `palette_id` (`palette_id`),
  KEY `color_type_id` (`color_type_id`),
  CONSTRAINT `user_settings_color_palette_colors_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_settings_color_palette_colors_ibfk_2` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palettes` (`id`),
  CONSTRAINT `user_settings_color_palette_colors_ibfk_3` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_color_palette_colors` */

insert  into `user_settings_color_palette_colors`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`hex`,`r`,`g`,`b`,`enabled`) values (10,1,1,1,'Black','#000000',0,0,0,1),(11,1,1,2,'Tan','#f3f1df',127,127,127,1),(12,1,1,3,'Dark grey','#666666',102,102,102,1),(13,1,2,1,'Blue','#336699',51,102,127,1),(14,1,2,2,'Dark grey','#666666',102,102,102,1),(15,1,2,3,'Grey','#999999',127,127,127,1),(16,1,3,1,'Blue','#003366',0,51,102,1),(17,1,3,2,'White','#FFFFFF',127,127,127,1),(18,1,3,3,'Green','#000000',127,127,255,1);

/*Table structure for table `user_settings_color_palettes` */

DROP TABLE IF EXISTS `user_settings_color_palettes`;

CREATE TABLE `user_settings_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(2) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `site_id` (`site_id`),
  KEY `view_script` (`view_script`),
  CONSTRAINT `user_settings_color_palettes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_color_palettes` */

insert  into `user_settings_color_palettes`(`id`,`site_id`,`name`,`view_script`,`sort_order`,`enabled`) values (1,1,'Palette 1','palette-1',1,1),(2,1,'Palette 2','palette-2',2,1),(3,1,'Palette 3','palette-3',3,1);

/*Table structure for table `user_settings_headings` */

DROP TABLE IF EXISTS `user_settings_headings`;

CREATE TABLE `user_settings_headings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `heading_id` tinyint(3) unsigned NOT NULL,
  `style_id` tinyint(3) unsigned NOT NULL,
  `weight_id` tinyint(3) unsigned NOT NULL,
  `decoration_id` tinyint(3) unsigned NOT NULL,
  `size` tinyint(3) unsigned NOT NULL DEFAULT '12',
  `hex` char(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#000000',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `site_id` (`site_id`),
  KEY `style_id` (`style_id`),
  KEY `weight_id` (`weight_id`),
  KEY `decoration_id` (`decoration_id`),
  KEY `heading_id` (`heading_id`),
  CONSTRAINT `user_settings_headings_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_settings_headings_ibfk_3` FOREIGN KEY (`style_id`) REFERENCES `designer_css_text_styles` (`id`),
  CONSTRAINT `user_settings_headings_ibfk_4` FOREIGN KEY (`weight_id`) REFERENCES `designer_css_text_weights` (`id`),
  CONSTRAINT `user_settings_headings_ibfk_5` FOREIGN KEY (`decoration_id`) REFERENCES `designer_css_text_decorations` (`id`),
  CONSTRAINT `user_settings_headings_ibfk_6` FOREIGN KEY (`heading_id`) REFERENCES `designer_html_headings` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_headings` */

insert  into `user_settings_headings`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`hex`,`sort_order`,`enabled`) values (1,1,1,1,2,1,20,'#17365d',1,1),(2,1,2,1,2,1,18,'#366092',2,1),(3,1,3,1,2,1,16,'#366092',3,1),(4,1,4,1,2,1,14,'#366092',4,1),(5,1,5,2,2,1,14,'#366092',5,1),(6,1,6,1,1,1,12,'#366092',6,1),(7,1,7,2,1,1,12,'#366092',7,1);

/*Table structure for table `user_site_page_content` */

DROP TABLE IF EXISTS `user_site_page_content`;

CREATE TABLE `user_site_page_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `content_type` int(11) unsigned NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_type` (`content_type`),
  KEY `sort_order` (`sort_order`),
  KEY `template_id` (`template_id`),
  KEY `div_id` (`div_id`),
  CONSTRAINT `user_site_page_content_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_ibfk_3` FOREIGN KEY (`content_type`) REFERENCES `designer_content_types` (`id`),
  CONSTRAINT `user_site_page_content_ibfk_4` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_page_content_ibfk_5` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content` */

insert  into `user_site_page_content`(`id`,`page_id`,`template_id`,`div_id`,`content_type`,`sort_order`) values (1,1,1,159,1,1),(2,1,1,159,1,2);

/*Table structure for table `user_site_page_content_text` */

DROP TABLE IF EXISTS `user_site_page_content_text`;

CREATE TABLE `user_site_page_content_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `width` int(4) unsigned NOT NULL DEFAULT '0',
  `padding` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_title` tinyint(1) NOT NULL DEFAULT '0',
  `title_style_id` int(11) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `title_style_id` (`title_style_id`),
  CONSTRAINT `user_site_page_content_text_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_3` FOREIGN KEY (`title_style_id`) REFERENCES `user_settings_headings` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_text` */

insert  into `user_site_page_content_text`(`id`,`page_id`,`content_id`,`width`,`padding`,`title`,`show_title`,`title_style_id`,`content`) values (1,1,1,970,5,'Test content',1,1,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>'),(2,1,2,970,5,'Test content 2',1,5,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>');

/*Table structure for table `user_site_pages` */

DROP TABLE IF EXISTS `user_site_pages`;

CREATE TABLE `user_site_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `site_id` (`site_id`),
  KEY `user_site_pages_ibfk_2` (`template_id`),
  CONSTRAINT `user_site_pages_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_pages_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_pages` */

insert  into `user_site_pages`(`id`,`site_id`,`template_id`,`name`,`title`,`enabled`) values (1,1,2,'Home page','G3D Development Limited',1);

/*Table structure for table `user_site_template_div_background_colors` */

DROP TABLE IF EXISTS `user_site_template_div_background_colors`;

CREATE TABLE `user_site_template_div_background_colors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`),
  KEY `div_id` (`div_id`),
  CONSTRAINT `user_site_template_div_background_colors_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_template_div_background_colors_ibfk_2` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_background_colors` */

insert  into `user_site_template_div_background_colors`(`id`,`template_id`,`div_id`,`hex`) values (17,1,160,'#999999'),(19,1,159,'#f3f1df'),(20,1,162,'#336699');

/*Table structure for table `user_site_template_div_borders` */

DROP TABLE IF EXISTS `user_site_template_div_borders`;

CREATE TABLE `user_site_template_div_borders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `position` enum('top','right','bottom','left') COLLATE utf8_unicode_ci NOT NULL,
  `style` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `width` int(3) unsigned NOT NULL DEFAULT '1',
  `hex` char(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#000000',
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  KEY `template_id` (`template_id`),
  KEY `div_id` (`div_id`),
  KEY `style` (`style`),
  CONSTRAINT `user_site_template_div_borders_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_template_div_borders_ibfk_2` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  CONSTRAINT `user_site_template_div_borders_ibfk_3` FOREIGN KEY (`style`) REFERENCES `designer_css_border_styles` (`style`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_borders` */

insert  into `user_site_template_div_borders`(`id`,`template_id`,`div_id`,`position`,`style`,`width`,`hex`) values (1,1,161,'top','dashed',5,'#000000'),(2,1,161,'right','dashed',5,'#000000'),(3,1,161,'bottom','dashed',5,'#000000'),(4,1,161,'left','dashed',5,'#000000'),(5,1,163,'top','solid',1,'#000000'),(6,1,163,'right','solid',1,'#000000'),(7,1,163,'bottom','solid',1,'#000000'),(8,1,163,'left','solid',1,'#000000');

/*Table structure for table `user_site_template_div_sizes` */

DROP TABLE IF EXISTS `user_site_template_div_sizes`;

CREATE TABLE `user_site_template_div_sizes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `width` int(4) NOT NULL DEFAULT '0',
  `height` int(4) NOT NULL DEFAULT '0',
  `design_height` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`),
  KEY `div_id` (`div_id`),
  CONSTRAINT `user_site_template_div_sizes_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_template_div_sizes_ibfk_3` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_sizes` */

insert  into `user_site_template_div_sizes`(`id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (158,1,158,980,0,190),(159,1,159,980,0,380),(160,1,160,140,0,190),(161,1,161,830,0,180),(162,1,162,140,0,380),(163,1,163,838,0,378);

/*Table structure for table `user_site_template_divs` */

DROP TABLE IF EXISTS `user_site_template_divs`;

CREATE TABLE `user_site_template_divs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Parent, always set, base divs have a parent_id of 0',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Sort order within grouping',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `sort_order` (`sort_order`),
  KEY `site_id` (`site_id`),
  KEY `template_id` (`template_id`),
  CONSTRAINT `user_site_template_divs_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_template_divs_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_divs` */

insert  into `user_site_template_divs`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (158,1,1,0,1),(159,1,1,0,2),(160,1,1,158,1),(161,1,1,158,2),(162,1,1,159,1),(163,1,1,159,2);

/*Table structure for table `user_site_templates` */

DROP TABLE IF EXISTS `user_site_templates`;

CREATE TABLE `user_site_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_templates_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_templates` */

insert  into `user_site_templates`(`id`,`site_id`,`name`,`enabled`) values (1,1,'Template 1 site 1',1),(2,1,'Template 2 site 1',1);

/*Table structure for table `user_sites` */

DROP TABLE IF EXISTS `user_sites`;

CREATE TABLE `user_sites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_sites` */

insert  into `user_sites`(`id`,`name`,`enabled`) values (1,'Demo site 1',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
