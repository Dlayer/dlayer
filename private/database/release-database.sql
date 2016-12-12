/*
SQLyog Ultimate v12.3.1 (64 bit)
MySQL - 10.1.16-MariaDB : Database - dlayer
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

/*Table structure for table `designer_color_palette` */

DROP TABLE IF EXISTS `designer_color_palette`;

CREATE TABLE `designer_color_palette` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palette` */

insert  into `designer_color_palette`(`id`,`name`,`view_script`) values 
(1,'Palette 1','palette-1'),
(2,'Palette 2','palette-2');

/*Table structure for table `designer_color_palette_color` */

DROP TABLE IF EXISTS `designer_color_palette_color`;

CREATE TABLE `designer_color_palette_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `palette_id` int(11) unsigned NOT NULL,
  `color_type_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `palette_id` (`palette_id`),
  KEY `color_type_id` (`color_type_id`),
  CONSTRAINT `designer_color_palette_color_ibfk_1` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palette` (`id`),
  CONSTRAINT `designer_color_palette_color_ibfk_2` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palette_color` */

insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values 
(1,1,1,'Black','#000000'),
(2,1,2,'Dark grey','#333333'),
(3,1,3,'Grey','#555555'),
(4,1,4,'Light grey','#777777'),
(5,1,5,'Off white','#EEEEEE'),
(6,2,1,'Blue','#337ab7'),
(7,2,2,'Green','#5cb85c'),
(8,2,3,'Light blue','#5bc0de'),
(9,2,4,'Amber','#f0ad4e'),
(10,2,5,'Red','#d9534f');

/*Table structure for table `designer_color_type` */

DROP TABLE IF EXISTS `designer_color_type`;

CREATE TABLE `designer_color_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_type` */

insert  into `designer_color_type`(`id`,`type`) values 
(1,'Primary'),
(2,'Secondary'),
(3,'Tertiary'),
(4,'Quaternary'),
(5,'Quinary');

/*Table structure for table `designer_content_heading` */

DROP TABLE IF EXISTS `designer_content_heading`;

CREATE TABLE `designer_content_heading` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_heading` */

insert  into `designer_content_heading`(`id`,`name`,`tag`,`sort_order`) values 
(1,'Page title','h1',1),
(2,'Content heading 1','h2',2),
(3,'Content heading 2','h3',3),
(4,'Content heading 3','h4',4),
(5,'Content heading 4','h5',5),
(6,'Content heading 5','h6',6);

/*Table structure for table `designer_content_type` */

DROP TABLE IF EXISTS `designer_content_type`;

CREATE TABLE `designer_content_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tool_id` (`tool_id`),
  CONSTRAINT `designer_content_type_ibfk_1` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_type` */

insert  into `designer_content_type`(`id`,`name`,`description`,`tool_id`) values 
(1,'text','Text block',10),
(2,'heading','Heading',11),
(3,'form','Form',16),
(4,'jumbotron','Jumbotron',34),
(5,'image','Image',39),
(7,'html','Raw html',52);

/*Table structure for table `designer_css_border_style` */

DROP TABLE IF EXISTS `designer_css_border_style`;

CREATE TABLE `designer_css_border_style` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `style` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `style` (`style`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Border styles that can be used within the designers';

/*Data for the table `designer_css_border_style` */

insert  into `designer_css_border_style`(`id`,`name`,`style`,`sort_order`) values 
(1,'Solid','solid',2),
(2,'Dashed','dashed',3),
(3,'No border','none',1);

/*Table structure for table `designer_css_font_family` */

DROP TABLE IF EXISTS `designer_css_font_family`;

CREATE TABLE `designer_css_font_family` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_font_family` */

insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values 
(1,'Helvetica','Helvetica Neue, Helvetica, Arial','\"Helvetica Neue\", Helvetica, Arial, sans-serif',1),
(2,'Lucida Grande','Lucida Grande, Lucida Sans Unicode, Bitstream Vera Sans','\"Lucida Grande\", \"Lucida Sans Unicode\", \"Bitstream Vera Sans\", sans-serif',2),
(3,'Georgia','Georgia, URW Bookman L','Georgia, \"URW Bookman L\", serif',3),
(4,'Corbel','Corbel, Arial, Helvetica, Nimbus Sans L, Liberation Sans','Corbel, Arial, Helvetica, \"Nimbus Sans L\", \"Liberation Sans\", sans-serif',4),
(5,'Code','Consolas, Bitstream Vera Sans Mono, Andale Mono, Monaco, Lucida Console','Consolas, \"Bitstream Vera Sans Mono\", \"Andale Mono\", Monaco, \"Lucida Console\", monospace',5),
(6,'Verdana','Verdana, Geneva','Verdana, Geneva, sans-serif',6),
(7,'Tahoma','Tahoma, Geneva','Tahoma, Geneva, sans-serif',7),
(8,'Segoe','Segoe UI, Helvetica, Arial, Sans-Serif;','\"Segoe UI\", Helvetica, Arial, \"Sans-Serif\"',8);

/*Table structure for table `designer_css_text_decoration` */

DROP TABLE IF EXISTS `designer_css_text_decoration`;

CREATE TABLE `designer_css_text_decoration` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_decoration` */

insert  into `designer_css_text_decoration`(`id`,`name`,`css`,`sort_order`) values 
(1,'None','none',1),
(2,'Underline','underline',2),
(3,'Strike-through','line-through',3);

/*Table structure for table `designer_css_text_style` */

DROP TABLE IF EXISTS `designer_css_text_style`;

CREATE TABLE `designer_css_text_style` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_style` */

insert  into `designer_css_text_style`(`id`,`name`,`css`,`sort_order`) values 
(1,'Normal','normal',1),
(2,'Italic','italic',2),
(3,'Oblique','oblique',3);

/*Table structure for table `designer_css_text_weight` */

DROP TABLE IF EXISTS `designer_css_text_weight`;

CREATE TABLE `designer_css_text_weight` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_weight` */

insert  into `designer_css_text_weight`(`id`,`name`,`css`,`sort_order`) values 
(1,'Normal','400',1),
(2,'Bold','700',3),
(3,'Light','100',4),
(4,'Light bold','500',2);

/*Table structure for table `designer_form_field_attribute` */

DROP TABLE IF EXISTS `designer_form_field_attribute`;

CREATE TABLE `designer_form_field_attribute` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attribute_type_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_type_id` (`field_type_id`),
  KEY `attribute_type_id` (`attribute_type_id`),
  CONSTRAINT `designer_form_field_attribute_ibfk_1` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_type` (`id`),
  CONSTRAINT `designer_form_field_attribute_ibfk_2` FOREIGN KEY (`attribute_type_id`) REFERENCES `designer_form_field_attribute_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_attribute` */

insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values 
(1,1,'Size','size',1),
(2,1,'Max length','maxlength',1),
(3,2,'Columns','cols',1),
(4,2,'Rows','rows',1),
(5,3,'Size','size',1),
(6,3,'Max length','maxlength',1),
(7,1,'Placeholder','placeholder',2),
(8,2,'Placeholder','placeholder',2),
(9,3,'Placeholder','placeholder',2),
(10,4,'Size','size',1),
(11,4,'Max length','maxlength',1),
(12,4,'Placeholder','placeholder',2);

/*Table structure for table `designer_form_field_attribute_type` */

DROP TABLE IF EXISTS `designer_form_field_attribute_type`;

CREATE TABLE `designer_form_field_attribute_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_attribute_type` */

insert  into `designer_form_field_attribute_type`(`id`,`name`,`type`) values 
(1,'Integer','integer'),
(2,'String','string');

/*Table structure for table `designer_form_field_param_preview` */

DROP TABLE IF EXISTS `designer_form_field_param_preview`;

CREATE TABLE `designer_form_field_param_preview` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `field_attribute_id` tinyint(3) unsigned NOT NULL,
  `preview_method_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_attribute_id` (`field_attribute_id`),
  KEY `preview_method_id` (`preview_method_id`),
  KEY `designer_form_field_param_previews_ibfk_1` (`field_type_id`),
  CONSTRAINT `designer_form_field_param_preview_ibfk_1` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_type` (`id`),
  CONSTRAINT `designer_form_field_param_preview_ibfk_2` FOREIGN KEY (`field_attribute_id`) REFERENCES `designer_form_field_attribute` (`id`),
  CONSTRAINT `designer_form_field_param_preview_ibfk_3` FOREIGN KEY (`preview_method_id`) REFERENCES `designer_form_preview_method` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_param_preview` */

insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values 
(1,1,1,3),
(2,1,2,3),
(3,1,7,1),
(4,2,3,3),
(5,2,4,3),
(6,2,8,1),
(7,3,5,3),
(8,3,6,3),
(9,3,9,1),
(10,4,10,3),
(11,4,11,3),
(12,4,12,1);

/*Table structure for table `designer_form_field_type` */

DROP TABLE IF EXISTS `designer_form_field_type`;

CREATE TABLE `designer_form_field_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_type` */

insert  into `designer_form_field_type`(`id`,`name`,`type`,`description`) values 
(1,'Text','text','A single line field'),
(2,'Textarea','textarea','A multiple line field'),
(3,'Password','password','A password field'),
(4,'Email','email','Email field');

/*Table structure for table `designer_form_layout` */

DROP TABLE IF EXISTS `designer_form_layout`;

CREATE TABLE `designer_form_layout` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `layout` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_layout` */

insert  into `designer_form_layout`(`id`,`layout`,`class`) values 
(1,'Standard','form'),
(2,'Inline','form-inline'),
(3,'Horizontal','form-horizontal');

/*Table structure for table `designer_form_preview_method` */

DROP TABLE IF EXISTS `designer_form_preview_method`;

CREATE TABLE `designer_form_preview_method` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_preview_method` */

insert  into `designer_form_preview_method`(`id`,`method`) values 
(1,'elementAttributeString'),
(3,'elementAttributeInteger');

/*Table structure for table `dlayer_identity` */

DROP TABLE IF EXISTS `dlayer_identity`;

CREATE TABLE `dlayer_identity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `credentials` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logged_in` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_action` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`identity`),
  KEY `enabled` (`enabled`),
  KEY `logged_in` (`logged_in`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_identity` */

insert  into `dlayer_identity`(`id`,`identity`,`credentials`,`logged_in`,`last_login`,`last_action`,`enabled`) values 
(1,'user-1@dlayer.com','$6$rounds=5000$jks453yuyt55d$CZJCjaieFQghQ6MwQ1OUI5nVKDy/Fi2YXk7MyW2hcex9AdJ/jvZA8ulvjzK1lo3rRVFfmd10lgjqAbDQM4ehR1',0,'2016-12-11 23:48:51','2016-12-12 00:16:09',1),
(2,'user-2@dlayer.com','$6$rounds=5000$jks453yuyt55d$ZVEJgs2kNjxOxNEayqqoh2oJUiGbmxIKRqOTxVM05MP2YRcAjE9adCZfQBWCc.qe1nDjEM9.ioivNz3c/qyZ80',0,'2015-05-29 15:57:54','2015-05-29 15:58:47',1),
(3,'user-3@dlayer.com','$6$rounds=5000$jks453yuyt55d$NYF6yCvxXplefx7nr8vDe4cUGBEFtd3G5vuJ2utfqvPwEf3dSgNXNTcGbFO6WrJSn21CXHgZwNOQHy691E/Rm.',0,'2015-05-29 15:59:10','2015-05-29 16:25:10',1);

/*Table structure for table `dlayer_module` */

DROP TABLE IF EXISTS `dlayer_module`;

CREATE TABLE `dlayer_module` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module` */

insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values 
(1,'template','Template designer','The Template designer lets you create page templates',7,0),
(2,'widget','Widget designer','The Widget designer lets you to develop reusable content items',4,0),
(3,'form','Form builder','The Form builder lets you build web forms',2,0),
(4,'content','Content manager','The Content manager lets you create and manage all your site content',1,1),
(5,'website','Web site manager (Preview)','The Web site manager lets you manage the relationships between all your site pages and data',5,0),
(6,'question','Question manager','Create quizzes, tests and polls. <span class=\"label label-default\">Planning</span>',99,0),
(7,'dlayer','Dlayer','Home',0,1),
(8,'image','Image library','Your Image and Media library',6,0),
(9,'data','Data manager','The Data manager lets you design datasets and then manage your data',3,0);

/*Table structure for table `dlayer_module_tool` */

DROP TABLE IF EXISTS `dlayer_module_tool`;

CREATE TABLE `dlayer_module_tool` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `base` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `destructive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_id` (`module_id`,`model`),
  KEY `enabled` (`enabled`),
  CONSTRAINT `dlayer_module_tool_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool` */

insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`model`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values 
(1,1,'Cancel','Cancel',1,0,1,1,1),
(2,1,'Create rows','SplitHorizontal',1,1,2,1,1),
(3,1,'Split vertical','SplitVertical',1,1,2,2,0),
(6,1,'Resize','Resize',0,1,2,3,0),
(7,1,'Background colour','BackgroundColor',1,0,3,1,0),
(8,1,'Border','Border',1,0,3,2,0),
(9,4,'Cancel','Cancel',2,0,1,1,1),
(10,4,'Text','Text',0,0,4,2,1),
(11,4,'Heading','Heading',0,0,4,1,1),
(12,3,'Text','Text',0,0,4,1,1),
(13,3,'Text area','Textarea',0,0,4,2,1),
(14,3,'Cancel','Cancel',2,0,1,1,1),
(15,3,'Password','Password',0,0,4,4,1),
(16,4,'Form','Form',0,0,5,1,1),
(17,5,'Cancel','Cancel',0,0,1,1,1),
(18,5,'New page','NewPage',0,0,2,2,1),
(19,5,'Move page','MovePage',0,0,2,1,1),
(20,3,'Email','PresetEmail',0,0,3,2,1),
(21,3,'Name','PresetName',0,0,3,1,1),
(22,4,'Text','ImportText',0,0,99,2,0),
(23,4,'Heading','ImportHeading',0,0,99,3,0),
(25,8,'Add image to library','Add',1,0,2,1,1),
(26,8,'Cancel / Back to library','Cancel',0,0,1,1,1),
(27,8,'Categories','Category',1,0,3,1,1),
(28,8,'Sub categories','SubCategory',1,0,3,2,1),
(29,8,'Clone image','Copy',0,0,4,3,1),
(30,8,'Crop image','Crop',0,0,4,2,1),
(31,8,'Edit image','Edit',0,0,4,1,1),
(32,4,'Add row(s)','AddRow',1,0,3,2,1),
(34,4,'Jumbotron','Jumbotron',0,0,4,3,1),
(35,4,'Jumbotron','ImportJumbotron',0,0,99,4,0),
(36,4,'Move row','MoveRow',1,0,99,99,0),
(37,4,'Move item','MoveItem',1,0,99,99,0),
(38,4,'Row','Row',1,0,3,1,1),
(39,4,'Image','Image',0,0,5,2,1),
(40,4,'Carousel','ImageCarousel',0,0,99,6,0),
(41,4,'Select parent','Select',1,0,99,99,0),
(42,3,'Layout','FormLayout',1,0,2,1,1),
(43,3,'Actions','FormActions',1,0,2,2,1),
(44,3,'Options','FormSettings',1,0,2,3,1),
(45,3,'Email','Email',0,0,4,3,1),
(46,4,'Content area','ContentArea',1,0,99,99,0),
(47,3,'Comment','PresetComment',0,0,3,3,1),
(48,3,'Password','PresetPassword',0,0,3,4,1),
(49,4,'Page','Page',1,0,99,1,1),
(50,4,'Column','Column',1,0,3,3,1),
(51,4,'Add column(s)','AddColumn',1,0,3,4,1),
(52,4,'HTML','Html',0,0,4,4,1);

/*Table structure for table `dlayer_module_tool_tab` */

DROP TABLE IF EXISTS `dlayer_module_tool_tab`;

CREATE TABLE `dlayer_module_tool_tab` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(2) unsigned NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `script` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `glyph` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multi_use` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `edit_mode` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_id_2` (`module_id`,`tool_id`,`model`),
  KEY `enabled` (`enabled`),
  KEY `module_id` (`module_id`),
  KEY `tool_id` (`tool_id`),
  CONSTRAINT `dlayer_module_tool_tab_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`),
  CONSTRAINT `dlayer_module_tool_tab_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tab` */

insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`script`,`model`,`glyph`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values 
(1,1,2,'Quick','quick',NULL,NULL,0,0,1,1,1),
(2,1,2,'Custom','advanced',NULL,NULL,0,0,0,2,1),
(3,1,2,'?','help',NULL,NULL,0,0,0,3,1),
(4,1,3,'Quick','quick',NULL,NULL,0,0,1,1,1),
(5,1,3,'Mouse','advanced',NULL,NULL,0,0,0,2,1),
(6,1,3,'?','help',NULL,NULL,0,0,0,3,1),
(7,1,7,'#1','palette-1',NULL,NULL,0,0,1,1,1),
(8,1,7,'#2','palette-2',NULL,NULL,0,0,0,2,1),
(9,1,7,'#3','palette-3',NULL,NULL,0,0,0,3,1),
(10,1,7,'Custom','advanced',NULL,NULL,0,0,0,4,1),
(11,1,7,'?','help',NULL,NULL,0,0,0,5,1),
(12,1,6,'Custom','advanced',NULL,NULL,0,0,0,4,1),
(14,1,6,'?','help',NULL,NULL,0,0,0,5,1),
(15,1,6,'Push','expand',NULL,NULL,0,0,1,1,1),
(16,1,6,'Pull','contract',NULL,NULL,0,0,0,2,1),
(17,1,6,'Height','height',NULL,NULL,0,0,0,3,1),
(20,1,8,'Custom','advanced',NULL,NULL,0,0,0,2,1),
(21,1,8,'?','help',NULL,NULL,0,0,0,3,1),
(22,1,8,'Full border','full',NULL,NULL,0,0,1,1,1),
(23,4,10,'Text','text',NULL,'pencil',1,0,1,1,1),
(24,4,11,'Heading','heading',NULL,'pencil',1,0,1,1,1),
(25,4,10,'Help','help',NULL,'info-sign',0,0,0,4,1),
(26,4,11,'Help','help',NULL,'info-sign',0,0,0,3,1),
(27,3,12,'Field','text',NULL,'pencil',1,0,1,1,1),
(28,3,12,'Help','help',NULL,'info-sign',0,0,0,3,1),
(29,3,13,'Field','textarea',NULL,'pencil',1,0,1,1,1),
(30,3,13,'Help','help',NULL,'info-sign',0,0,0,3,1),
(31,3,15,'Field','password',NULL,'pencil',1,0,1,1,1),
(32,3,15,'Help','help',NULL,'info-sign',0,0,0,3,1),
(33,4,16,'Form','form',NULL,'pencil',1,0,1,1,1),
(34,4,16,'Help','help',NULL,'info-sign',0,0,0,3,1),
(35,5,18,'Page','new-page',NULL,'pencil',0,0,1,1,1),
(36,5,18,'Help','help',NULL,'info-sign',0,0,0,2,1),
(37,5,19,'Page','move-page',NULL,'transfer',0,0,1,1,1),
(38,5,19,'Help','help',NULL,'info-sign',0,0,0,2,1),
(39,4,10,'Styles','styling','Styling','tint',1,1,0,2,1),
(40,4,11,'Styles','styling','Styling_Heading',NULL,1,1,0,3,0),
(41,4,16,'Styles','styling','Styling_ImportForm',NULL,1,1,0,4,0),
(42,3,20,'Field','preset-email',NULL,'pencil',0,0,1,1,1),
(43,3,20,'Help','help',NULL,'info-sign',0,0,0,3,1),
(44,3,21,'Field','preset-name',NULL,'pencil',0,0,1,1,1),
(45,3,21,'Help','help',NULL,'info-sign',0,0,0,3,1),
(46,4,16,'Size & position','position','Position_ImportForm',NULL,1,1,0,3,0),
(47,4,10,'Typography','typography','Typography','font',1,1,0,3,1),
(48,4,11,'Size & position','position','Position_Heading',NULL,1,1,0,2,0),
(49,3,12,'Styling','styling','Styling','tint',1,1,0,2,1),
(50,3,13,'Styling','styling','Styling','tint',1,1,0,2,1),
(51,3,15,'Styling','styling','Styling','tint',1,1,0,2,1),
(54,4,16,'Edit in Form builder','edit',NULL,NULL,0,1,0,2,0),
(55,4,22,'Import','import-text',NULL,NULL,1,0,1,1,0),
(56,4,22,'Help','help',NULL,NULL,0,0,0,2,0),
(57,4,23,'Import','import-heading',NULL,NULL,1,0,1,1,0),
(58,4,23,'Help','help',NULL,NULL,0,0,2,2,0),
(61,8,25,'Image','add',NULL,'upload',0,0,1,1,1),
(62,8,25,'Help','help',NULL,'info-sign',0,0,0,2,1),
(63,8,27,'Category','category',NULL,'pencil',0,0,1,1,1),
(64,8,27,'Help','help',NULL,'info-sign',0,0,0,2,1),
(65,8,28,'Sub Category','sub-category',NULL,'pencil',0,0,1,1,1),
(66,8,28,'Help','help',NULL,'info-sign',0,0,0,2,1),
(67,8,29,'Clone image','clone',NULL,'copy',0,0,1,1,1),
(68,8,29,'Help','help',NULL,'info-sign',0,0,0,2,1),
(69,8,30,'Help','help',NULL,'info-sign',0,0,0,2,1),
(70,8,31,'Edit image','edit',NULL,'pencil',0,0,1,1,1),
(71,8,31,'Help','help',NULL,'info-sign',0,0,0,2,1),
(72,8,30,'Crop image','crop',NULL,'resize-small',0,0,1,1,1),
(73,4,32,'Row','add-row',NULL,'align-justify',0,0,1,1,1),
(74,4,32,'Help','help',NULL,'info-sign',0,0,0,2,1),
(77,4,34,'Jumbotron','jumbotron',NULL,'pencil',1,0,1,1,1),
(78,4,34,'Help','help',NULL,'info-sign',0,0,0,3,1),
(79,4,34,'Styles','styling','Styling_Jumbotron',NULL,1,1,0,3,0),
(80,4,34,'Size & position','position','Position_Jumbotron',NULL,1,1,0,2,0),
(81,4,35,'Import','import-jumbotron',NULL,NULL,1,0,1,1,0),
(82,4,35,'Help','help',NULL,NULL,0,0,0,3,0),
(83,4,36,'Move','move-row',NULL,NULL,1,0,1,1,0),
(84,4,36,'Help','help',NULL,NULL,0,0,0,2,0),
(85,4,37,'Move','move-item',NULL,NULL,1,0,1,1,0),
(86,4,37,'Help','help',NULL,NULL,0,0,0,2,0),
(87,4,38,'Row','row',NULL,'align-justify',0,0,1,1,1),
(88,4,38,'Styles','styling','Styling_ContentRow',NULL,0,0,0,2,0),
(89,4,39,'Image','image',NULL,'pencil',1,0,1,1,1),
(90,4,39,'Help','help',NULL,'info-sign',0,0,0,3,1),
(91,4,40,'Carousel','carousel',NULL,NULL,1,0,1,1,0),
(92,4,40,'Help','help',NULL,NULL,0,0,0,2,0),
(93,4,39,'Size & position','position','Position_Image',NULL,1,1,0,2,0),
(94,4,39,'Styles','styling','Styling_Image',NULL,1,1,0,3,0),
(95,4,41,'Select','select',NULL,NULL,0,0,1,1,0),
(96,4,41,'Help','help',NULL,NULL,0,0,0,2,0),
(97,3,42,'Layout','form-layout',NULL,'wrench',1,0,1,1,1),
(98,3,42,'Help','help',NULL,'info-sign',0,0,0,2,1),
(99,3,45,'Field','email',NULL,'pencil',1,0,1,1,1),
(100,3,45,'Help','help',NULL,'info-sign',0,0,0,3,1),
(101,3,45,'Styling','styling','Styling','tint',1,1,0,2,1),
(102,3,43,'Actions','form-actions',NULL,'wrench',1,0,1,1,1),
(103,3,43,'Help','help',NULL,'info-sign',0,0,0,2,1),
(104,3,44,'Options','form-settings',NULL,'wrench',1,0,1,1,1),
(105,3,44,'Help','help',NULL,'info-sign',0,0,0,2,1),
(106,4,38,'Help','help',NULL,'info-sign',0,0,0,3,1),
(107,4,46,'Area','content-area',NULL,NULL,0,0,1,1,0),
(108,4,46,'Styles','styling','Styling_ContentArea',NULL,0,0,0,2,0),
(109,4,46,'Help','help',NULL,NULL,0,0,0,3,0),
(110,3,47,'Field','preset-comment',NULL,'pencil',0,0,1,1,1),
(111,3,47,'Help','help',NULL,'info-sign',0,0,0,2,1),
(112,3,48,'Field','preset-password',NULL,'pencil',0,0,1,1,1),
(113,3,48,'Help','help',NULL,'info-sign',0,0,0,2,1),
(114,4,49,'Page','page',NULL,'file',0,0,1,1,1),
(115,4,49,'Help','help',NULL,'info-sign',0,0,0,3,1),
(116,4,50,'Column','column',NULL,'align-justify',0,0,1,1,1),
(118,4,50,'Help','help',NULL,'info-sign',0,0,0,3,1),
(119,4,51,'Add Column','add-column',NULL,'align-justify',0,0,1,1,1),
(120,4,51,'Help','help',NULL,'info-sign',0,0,0,2,1),
(121,4,11,'Styles','styling','Styling','tint',1,1,0,2,1),
(122,4,50,'Styles','styling','Styling','tint',1,0,0,2,1),
(123,4,38,'Styles','styling','Styling','tint',1,0,0,2,1),
(124,4,49,'Styles','styling','Styling','tint',1,0,0,2,1),
(125,4,16,'Styling','styling','Styling','tint',1,1,0,2,1),
(126,4,39,'Styling','styling','Styling','tint',1,1,0,2,1),
(127,4,34,'Styling','styling','Styling','tint',1,1,0,2,1),
(128,4,52,'HTML','html',NULL,'pencil',1,0,1,1,1),
(129,4,52,'Styles','styling','Styling','tint',1,1,0,2,1),
(130,4,52,'Help','help',NULL,'info-sign',0,0,0,3,1);

/*Table structure for table `dlayer_session` */

DROP TABLE IF EXISTS `dlayer_session`;

CREATE TABLE `dlayer_session` (
  `session_id` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `save_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `session_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`session_id`,`save_path`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_session` */

insert  into `dlayer_session`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values 
('11f5ll1vgiduvsodus7b4db1d2','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1480376664,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1480380264;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1480380264;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1480380264;}}dlayer_session_content|a:5:{s:7:\"page_id\";N;s:13:\"page_selected\";N;s:9:\"column_id\";N;s:6:\"row_id\";N;s:10:\"content_id\";N;}dlayer_session_designer|a:7:{s:4:\"tool\";a:1:{s:7:\"content\";N;}s:3:\"tab\";a:1:{s:7:\"content\";N;}s:8:\"sub_tool\";a:1:{s:7:\"content\";N;}s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}'),
('3mh37m0s21j73mdn0e0l349c53','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1481143252,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1481146851;}}'),
('56abovk90o5jvntvnlv51po8u4','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1480462897,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1480466497;}}'),
('7kkeuoqad6mbbvtpkjvga71vk1','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1480868764,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1480872363;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1480872363;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1480872363;}}dlayer_session_content|a:5:{s:7:\"page_id\";N;s:13:\"page_selected\";N;s:9:\"column_id\";N;s:6:\"row_id\";N;s:10:\"content_id\";N;}dlayer_session_designer|a:7:{s:4:\"tool\";a:1:{s:7:\"content\";N;}s:3:\"tab\";a:1:{s:7:\"content\";N;}s:8:\"sub_tool\";a:1:{s:7:\"content\";N;}s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}'),
('968c4aumno9eroq1u3pe5hlvv7','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1479683298,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1479686898;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1479686898;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1479686898;}}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:7:\"content\";}dlayer_session_content|a:5:{s:7:\"page_id\";i:1;s:13:\"page_selected\";N;s:9:\"column_id\";N;s:6:\"row_id\";N;s:10:\"content_id\";N;}dlayer_session_designer|a:7:{s:4:\"tool\";a:1:{s:7:\"content\";N;}s:3:\"tab\";a:1:{s:7:\"content\";N;}s:8:\"sub_tool\";a:1:{s:7:\"content\";N;}s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}'),
('c90pqpkkcu5bc7qeto02ogavf4','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1480466241,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1480469841;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1480469841;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1480469841;}}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:7:\"content\";}dlayer_session_content|a:5:{s:7:\"page_id\";i:2;s:13:\"page_selected\";b:1;s:9:\"column_id\";i:22;s:6:\"row_id\";i:12;s:10:\"content_id\";N;}dlayer_session_designer|a:7:{s:4:\"tool\";a:1:{s:7:\"content\";s:6:\"Column\";}s:3:\"tab\";a:1:{s:7:\"content\";s:6:\"column\";}s:8:\"sub_tool\";a:1:{s:7:\"content\";N;}s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}'),
('e8spf97jr0c5rgpdg41u46qcq6','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1479774174,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1479777774;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1479777774;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1479777774;}}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:7:\"content\";}dlayer_session_content|a:5:{s:7:\"page_id\";i:1;s:13:\"page_selected\";N;s:9:\"column_id\";N;s:6:\"row_id\";N;s:10:\"content_id\";N;}dlayer_session_designer|a:1:{s:4:\"tool\";N;}'),
('ilgmjfg241oqel9drsfrn3fq87','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1479765532,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1479769131;}}'),
('iuad71eoc9ko9ppr7t6eis1rm4','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1479935707,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1479939305;}}'),
('jus836no9luaa6rbuccj2brcv1','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1480542887,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1480546485;}}'),
('k0i8p00pj8irr6pg4io7orn8p1','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1481384761,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1481388361;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1481388361;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1481388361;}}dlayer_session_content|a:5:{s:7:\"page_id\";N;s:13:\"page_selected\";N;s:9:\"column_id\";N;s:6:\"row_id\";N;s:10:\"content_id\";N;}dlayer_session_designer|a:7:{s:4:\"tool\";a:1:{s:7:\"content\";N;}s:3:\"tab\";a:1:{s:7:\"content\";N;}s:8:\"sub_tool\";a:1:{s:7:\"content\";N;}s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}'),
('k0tcp8661opittcgqvlj4iag94','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1480865106,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1480868705;}}'),
('l64d863c2vrs0ducfpsu4hi4h3','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1479858206,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1479861805;}}'),
('oat8l3nv1l9heqdk75vt08n963','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1480781199,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1480784799;}}dlayer_session|a:2:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;}'),
('psu6lj9sffplveo7g3vknr28k1','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1481381832,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1481385431;}}'),
('q0vnt0i9pss54hm9o5vnsiroa5','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1481067025,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1481070624;}}'),
('stbugdcar25v9q2gdu4lgjc734','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1479862328,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1479865928;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1479865925;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1479865436;}}dlayer_session_content|a:5:{s:7:\"page_id\";i:2;s:13:\"page_selected\";N;s:9:\"column_id\";N;s:6:\"row_id\";N;s:10:\"content_id\";N;}dlayer_session_designer|a:7:{s:4:\"tool\";a:1:{s:7:\"content\";N;}s:3:\"tab\";a:1:{s:7:\"content\";N;}s:8:\"sub_tool\";a:1:{s:7:\"content\";N;}s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:7:\"content\";}'),
('ubvv8f467tnttibi0ji03b6u05','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1481501796,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1481505396;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1481505396;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1481505396;}}dlayer_session_content|a:5:{s:7:\"page_id\";N;s:13:\"page_selected\";N;s:9:\"column_id\";N;s:6:\"row_id\";N;s:10:\"content_id\";N;}dlayer_session_designer|a:7:{s:4:\"tool\";a:1:{s:7:\"content\";N;}s:3:\"tab\";a:1:{s:7:\"content\";N;}s:8:\"sub_tool\";a:1:{s:7:\"content\";N;}s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}dlayer_session|a:1:{s:7:\"site_id\";N;}'),
('ugns0ll377v3qg6kqblgrqulv7','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1481069511,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1481073111;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1481073111;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1481073111;}}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:7:\"content\";}dlayer_session_content|a:5:{s:7:\"page_id\";i:3;s:13:\"page_selected\";b:1;s:9:\"column_id\";i:24;s:6:\"row_id\";i:14;s:10:\"content_id\";i:29;}dlayer_session_designer|a:7:{s:4:\"tool\";a:1:{s:7:\"content\";s:4:\"Text\";}s:3:\"tab\";a:1:{s:7:\"content\";s:10:\"typography\";}s:8:\"sub_tool\";a:1:{s:7:\"content\";s:10:\"Typography\";}s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}'),
('v3k9uffauf3k6p55m9pbjgul85','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1481143904,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1481147504;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1481147504;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1481147504;}}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:7:\"content\";}dlayer_session_content|a:5:{s:7:\"page_id\";i:3;s:13:\"page_selected\";b:1;s:9:\"column_id\";i:23;s:6:\"row_id\";i:14;s:10:\"content_id\";i:28;}dlayer_session_designer|a:3:{s:4:\"tool\";a:1:{s:7:\"content\";s:4:\"Text\";}s:3:\"tab\";a:1:{s:7:\"content\";s:10:\"typography\";}s:8:\"sub_tool\";a:1:{s:7:\"content\";s:10:\"Typography\";}}');

/*Table structure for table `dlayer_setting` */

DROP TABLE IF EXISTS `dlayer_setting`;

CREATE TABLE `dlayer_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_group_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` tinyint(3) unsigned NOT NULL,
  `scope_details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_group_id` (`setting_group_id`,`name`),
  UNIQUE KEY `url` (`url`),
  KEY `sort_order` (`sort_order`),
  KEY `enabled` (`enabled`),
  KEY `scope_id` (`scope_id`),
  CONSTRAINT `dlayer_setting_ibfk_1` FOREIGN KEY (`setting_group_id`) REFERENCES `dlayer_setting_group` (`id`),
  CONSTRAINT `dlayer_setting_ibfk_2` FOREIGN KEY (`scope_id`) REFERENCES `dlayer_setting_scope` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_setting` */

insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values 
(1,1,'Colour palettes','Colour palettes','<p>You can define three colour palettes for each of your web sites, the colours you define here will be shown anytime you need a tool that requires you to choose a colour.</p>\r\n\r\n<p>You will always be able to choose a colour that is not in one of your three palettes, think of these as quick access.</p>','/dlayer/settings/palettes',1,'All colour pickers',2,1),
(2,3,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the content manager, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/content/settings/base-font-family',2,'Content module, all text',2,1),
(3,3,'Heading styles','Set the styles for the six heading types','<p>Define the styles for the page title and the five sub headings, H2 through H6.</p>\r\n\r\n<p>Anywhere you need to choose one of the heading types the styles defined here will be used.</p>','/content/settings/headings',3,'Heading tool',3,1),
(4,4,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the form builder, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/form/settings/base-font-family',2,'Forms module, all text',2,1),
(5,1,'Overview','Overview','<p>Settings overview.</p>','/dlayer/settings/index',1,NULL,1,1),
(6,2,'Overview','Overview','<p>Template designer settings overview.</p>','/template/settings/index',2,NULL,1,1),
(7,3,'Overview','Overview','<p>Content manager settings overview.</p>','/content/settings/index',2,NULL,1,1),
(8,4,'Overview','Overview','<p>Form builder settings overview.</p>','/form/settings/index',2,NULL,1,1),
(9,8,'Overview','Overview','<p>Image library settings overview.</p>','/image/settings/index',2,NULL,1,1),
(10,6,'Overview','Overview','<p>Web site manager settings overview.</p>','/website/settings/index',2,NULL,1,1),
(11,5,'Overview','Overview','<p>Widget designer settings overview</p>','/widget/settings/index',2,NULL,1,1);

/*Table structure for table `dlayer_setting_group` */

DROP TABLE IF EXISTS `dlayer_setting_group`;

CREATE TABLE `dlayer_setting_group` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tab_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `url` (`url`),
  KEY `sort_order` (`sort_order`),
  KEY `enabled` (`enabled`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `dlayer_setting_group_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_setting_group` */

insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values 
(1,'App',7,'Dlayer settings','Dlayer','/dlayer/settings/index',1,1),
(2,'Template',1,'Template designer settings','Template designer','/template/settings/index',2,1),
(3,'Content',4,'Content designer settings','Content manager','/content/settings/index',3,1),
(4,'Form',3,'Form builder settings','Form builder','/form/settings/index',4,1),
(5,'Widget',2,'Widget designer settings','Widget designer','/widget/settings/index',5,1),
(6,'Web site',5,'Web site designer settings','Web site manager','/website/settings/index',7,1),
(7,'Question',6,'Question manager settings','Question manager','/question/settings/index',6,1),
(8,'Image',8,'Image library settings','Image library','/image/settings/index',8,1);

/*Table structure for table `dlayer_setting_scope` */

DROP TABLE IF EXISTS `dlayer_setting_scope`;

CREATE TABLE `dlayer_setting_scope` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_setting_scope` */

insert  into `dlayer_setting_scope`(`id`,`scope`) values 
(1,'App'),
(2,'Module'),
(3,'Tool');

/*Table structure for table `user_setting_color_history` */

DROP TABLE IF EXISTS `user_setting_color_history`;

CREATE TABLE `user_setting_color_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_setting_color_history_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_color_history` */

insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values 
(1,1,'#337ab7'),
(2,1,'#5cb85c'),
(3,1,'#555555'),
(4,1,'#EEEEEE'),
(5,1,'#f0ad4e'),
(6,2,'#337ab7'),
(7,2,'#5cb85c'),
(8,2,'#555555'),
(9,2,'#EEEEEE'),
(10,2,'#f0ad4e'),
(13,3,'#337ab7'),
(14,3,'#5cb85c'),
(15,3,'#555555'),
(16,3,'#EEEEEE'),
(17,3,'#f0ad4e'),
(25,1,'#f0ad4e'),
(26,1,'#337ab7'),
(27,1,'#777777'),
(28,1,'#eeeeee'),
(29,1,'#eeeeee'),
(30,2,'#5bc0de'),
(31,2,'#eeeeee'),
(32,3,'#eeeeee'),
(33,1,'#777777'),
(34,1,'#777777'),
(35,1,'#eeeeee'),
(36,1,'#eeeeee'),
(37,1,'#eeeeee'),
(38,1,'#337ab7'),
(39,1,'#eeeeee'),
(40,1,'#eeeeee'),
(41,1,'#eeeeee'),
(42,1,'#f0ad4e'),
(43,1,'#eeeeee'),
(44,1,'#f0ad4e'),
(45,1,'#5cb85c'),
(46,1,'#5cb85c'),
(47,1,'#eeeeee'),
(48,1,'#5cb85c'),
(49,1,'#eeeeee'),
(50,1,'#337ab7'),
(51,1,'#555555'),
(52,1,'#eeeeee'),
(53,1,'#eeeeee'),
(54,1,'#777777'),
(55,1,'#777777'),
(56,1,'#f0ad4e'),
(57,1,'#777777'),
(58,1,'#eeeeee'),
(59,1,'#777777'),
(60,1,'#5cb85c'),
(61,1,'#777777'),
(62,1,'#777777'),
(63,1,'#eeeeee'),
(64,1,'#5cb85c'),
(65,1,'#337ab7'),
(66,1,'#eeeeee'),
(67,1,'#eeeeee'),
(68,1,'#337ab7'),
(69,1,'#eeeeee'),
(70,1,'#d9534f'),
(71,1,'#eeeeee'),
(72,1,'#5cb85c'),
(73,1,'#5cb85c'),
(74,1,'#5bc0de'),
(75,1,'#337ab7'),
(76,4,'#337ab7'),
(77,4,'#5cb85c'),
(78,4,'#555555'),
(79,4,'#EEEEEE'),
(80,4,'#f0ad4e'),
(81,1,'#5cb85c'),
(82,1,'#f0ad4e'),
(83,1,'#5cb85c'),
(84,1,'#5bc0de'),
(85,1,'#f0ad4e'),
(86,1,'#d9534f'),
(87,1,'#eeeeee'),
(88,1,'#eeeeee'),
(89,1,'#eeeeee'),
(90,1,'#eeeeee'),
(91,1,'#5cb85c'),
(92,1,'#5bc0de'),
(94,1,'#eeeeee'),
(95,1,'#eeeeee'),
(96,1,'#d9534f'),
(97,1,'#ca9c24'),
(98,1,'#ca9c24'),
(99,1,'#eeeeee'),
(100,1,'#f0ad4e'),
(101,1,'#eeeeee'),
(102,1,''),
(103,1,'#eeeeee'),
(104,1,'#f0ad4e');

/*Table structure for table `user_setting_color_palette` */

DROP TABLE IF EXISTS `user_setting_color_palette`;

CREATE TABLE `user_setting_color_palette` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `view_script` (`view_script`),
  CONSTRAINT `user_setting_color_palette_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_color_palette` */

insert  into `user_setting_color_palette`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values 
(1,1,'Palette 1','palette-1',1),
(2,1,'Palette 2','palette-2',2),
(3,2,'Palette 1','palette-1',1),
(4,2,'Palette 2','palette-2',2),
(5,3,'Palette 1','palette-1',1),
(6,3,'Palette 2','palette-2',2),
(7,4,'Palette 1','palette-1',1),
(8,4,'Palette 2','palette-2',2);

/*Table structure for table `user_setting_color_palette_color` */

DROP TABLE IF EXISTS `user_setting_color_palette_color`;

CREATE TABLE `user_setting_color_palette_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `palette_id` int(11) unsigned NOT NULL,
  `color_type_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `palette_id` (`palette_id`),
  KEY `color_type_id` (`color_type_id`),
  CONSTRAINT `user_setting_color_palette_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_setting_color_palette_color_ibfk_2` FOREIGN KEY (`palette_id`) REFERENCES `user_setting_color_palette` (`id`),
  CONSTRAINT `user_setting_color_palette_color_ibfk_3` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_color_palette_color` */

insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values 
(1,1,1,1,'Black','#000000'),
(2,1,1,2,'Dark grey','#333333'),
(3,1,1,3,'Grey','#555555'),
(4,1,1,4,'Light grey','#777777'),
(5,1,1,5,'Off white','#EEEEEE'),
(6,1,2,1,'Blue','#337ab7'),
(7,1,2,2,'Green','#5cb85c'),
(8,1,2,3,'Light blue','#5bc0de'),
(9,1,2,4,'Amber','#f0ad4e'),
(10,1,2,5,'Red','#d9534f'),
(11,2,3,1,'Black','#000000'),
(12,2,3,2,'Dark grey','#333333'),
(13,2,3,3,'Grey','#555555'),
(14,2,3,4,'Light grey','#777777'),
(15,2,3,5,'Off white','#EEEEEE'),
(18,2,4,1,'Blue','#337ab7'),
(19,2,4,2,'Green','#5cb85c'),
(20,2,4,3,'Light blue','#5bc0de'),
(21,2,4,4,'Amber','#f0ad4e'),
(22,2,4,5,'Red','#d9534f'),
(25,3,5,1,'Black','#000000'),
(26,3,5,2,'Dark grey','#333333'),
(27,3,5,3,'Grey','#555555'),
(28,3,5,4,'Light grey','#777777'),
(29,3,5,5,'Off white','#EEEEEE'),
(34,3,6,3,'Light blue','#5bc0de'),
(35,3,6,4,'Amber','#f0ad4e'),
(36,3,6,5,'Red','#d9534f'),
(37,4,7,1,'Black','#000000'),
(38,4,7,3,'Dark grey','#333333'),
(39,4,7,3,'Grey','#555555'),
(40,4,7,4,'Light grey','#777777'),
(41,4,7,5,'Off white','#EEEEEE'),
(42,4,8,1,'Blue','#337ab7'),
(43,4,8,3,'Green','#5cb85c'),
(44,4,8,3,'Light blue','#5bc0de'),
(45,4,8,4,'Amber','#f0ad4e'),
(46,4,8,5,'Red','#d9534f');

/*Table structure for table `user_setting_font_family` */

DROP TABLE IF EXISTS `user_setting_font_family`;

CREATE TABLE `user_setting_font_family` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `module_id` tinyint(3) unsigned NOT NULL,
  `font_family_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `module_id` (`module_id`),
  KEY `font_family_id` (`font_family_id`),
  CONSTRAINT `user_setting_font_family_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_setting_font_family_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`),
  CONSTRAINT `user_setting_font_family_ibfk_3` FOREIGN KEY (`font_family_id`) REFERENCES `designer_css_font_family` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_font_family` */

insert  into `user_setting_font_family`(`id`,`site_id`,`module_id`,`font_family_id`) values 
(1,1,3,8),
(2,1,4,1),
(3,2,3,1),
(4,2,4,1),
(5,3,3,1),
(6,3,4,1),
(7,4,3,1),
(8,4,4,1);

/*Table structure for table `user_setting_heading` */

DROP TABLE IF EXISTS `user_setting_heading`;

CREATE TABLE `user_setting_heading` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `heading_id` tinyint(3) unsigned NOT NULL,
  `style_id` tinyint(3) unsigned NOT NULL,
  `weight_id` tinyint(3) unsigned NOT NULL,
  `decoration_id` tinyint(3) unsigned NOT NULL,
  `size` tinyint(3) unsigned NOT NULL DEFAULT '12',
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#000000',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `style_id` (`style_id`),
  KEY `weight_id` (`weight_id`),
  KEY `decoration_id` (`decoration_id`),
  KEY `heading_id` (`heading_id`),
  CONSTRAINT `user_setting_heading_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_setting_heading_ibfk_3` FOREIGN KEY (`style_id`) REFERENCES `designer_css_text_style` (`id`),
  CONSTRAINT `user_setting_heading_ibfk_4` FOREIGN KEY (`weight_id`) REFERENCES `designer_css_text_weight` (`id`),
  CONSTRAINT `user_setting_heading_ibfk_5` FOREIGN KEY (`decoration_id`) REFERENCES `designer_css_text_decoration` (`id`),
  CONSTRAINT `user_setting_heading_ibfk_6` FOREIGN KEY (`heading_id`) REFERENCES `designer_content_heading` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_heading` */

insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values 
(1,1,1,1,4,1,36,'#000000',1),
(2,1,2,1,4,1,30,'#000000',2),
(3,1,3,1,4,1,24,'#000000',3),
(4,1,4,1,4,1,18,'#000000',4),
(5,1,5,1,4,1,14,'#000000',5),
(6,1,6,1,4,1,12,'#000000',6),
(7,2,1,1,4,1,36,'#000000',1),
(8,2,2,1,4,1,30,'#000000',2),
(9,2,3,1,4,1,24,'#000000',3),
(10,2,4,1,4,1,18,'#000000',4),
(11,2,5,1,4,1,14,'#000000',5),
(12,2,6,1,4,1,12,'#000000',6),
(13,3,1,1,4,1,36,'#000000',1),
(14,3,2,1,4,1,30,'#000000',2),
(15,3,3,1,4,1,24,'#000000',3),
(16,3,4,1,4,1,18,'#000000',4),
(17,3,5,1,4,1,14,'#000000',5),
(18,3,6,1,4,1,12,'#000000',6),
(19,4,1,1,2,1,22,'#000000',1),
(20,4,2,1,2,1,18,'#000000',2),
(21,4,3,1,2,1,16,'#000000',3),
(22,4,4,1,2,2,14,'#000000',4),
(23,4,5,2,2,1,14,'#000000',5),
(24,4,6,1,1,1,12,'#000000',6);

/*Table structure for table `user_site` */

DROP TABLE IF EXISTS `user_site`;

CREATE TABLE `user_site` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `identity_id` (`identity_id`),
  CONSTRAINT `user_site_ibfk_1` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identity` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site` */

insert  into `user_site`(`id`,`identity_id`,`name`) values 
(1,1,'Sample site 1'),
(2,2,'Sample site 1'),
(3,3,'Sample site 1'),
(4,1,'Test site');

/*Table structure for table `user_site_content_heading` */

DROP TABLE IF EXISTS `user_site_content_heading`;

CREATE TABLE `user_site_content_heading` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name to identity content',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_content_heading_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_heading` */

insert  into `user_site_content_heading`(`id`,`site_id`,`name`,`content`) values 
(1,1,'Simple heading','Simple heading'),
(2,1,'Sub heading','This is a heading-:-with a optional sub heading'),
(3,1,'Heading','A column heading-:-with a sub heading'),
(4,1,'Testing forms and images','Testing forms and images-:-Do they work?'),
(5,1,'Testing','Testing new tool location-:-:eek:'),
(6,1,'Typography','Testing typography-:-That means changing the font styles');

/*Table structure for table `user_site_content_html` */

DROP TABLE IF EXISTS `user_site_content_html`;

CREATE TABLE `user_site_content_html` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name so user can identity content',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_content_html_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_html` */

insert  into `user_site_content_html`(`id`,`site_id`,`name`,`content`) values 
(1,1,'Testing HTML','<h2>Testing the HTML snippet tool</h2>\r\n\r\n<p>The quick brown <strong>fox</strong> jumped <em>over</em> the...</p>\r\n\r\n<ul>\r\n<li>List item one</li>\r\n<li>List item two</li>\r\n</ul>');

/*Table structure for table `user_site_content_jumbotron` */

DROP TABLE IF EXISTS `user_site_content_jumbotron`;

CREATE TABLE `user_site_content_jumbotron` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_content_jumbotron_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_jumbotron` */

insert  into `user_site_content_jumbotron`(`id`,`site_id`,`name`,`content`) values 
(1,1,'Jumbotron','Hello, world!-:-This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.'),
(2,1,'Testing','Jumbotron-:-This is a jumbotron with an intro'),
(3,1,'Page masthead','Testing post tool updates-:-This is a small introduction');

/*Table structure for table `user_site_content_text` */

DROP TABLE IF EXISTS `user_site_content_text`;

CREATE TABLE `user_site_content_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name so user can identity content',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_content_text_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_text` */

insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values 
(2,1,'Lipsum 2','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed maximus scelerisque ex, ut dapibus turpis elementum id. Sed faucibus, purus placerat condimentum elementum, justo nisi volutpat nisl, nec porttitor elit mauris vitae risus. Vestibulum interdum risus et libero luctus, quis gravida ligula laoreet. Ut velit ante, aliquam at ultricies non, placerat non nibh. Mauris tempor velit justo, vel faucibus dui posuere quis. Nulla facilisi. Suspendisse et est consectetur enim ornare tempus nec eget nulla. Nam blandit vitae mauris vel consectetur. Vestibulum ante justo, posuere eget turpis quis, pharetra accumsan enim. Phasellus at tincidunt elit. \r\n\r\nPraesent ut dignissim purus. Nulla rhoncus metus et rhoncus commodo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus eget ex ac turpis dictum dictum. Pellentesque nulla purus, accumsan sit amet porttitor vel, venenatis eu mi. Etiam aliquam lorem at fermentum rhoncus. Suspendisse at metus sit amet est laoreet bibendum.'),
(3,1,'Test','a little bit of content...\r\n\r\n...little bit more...\r\n\r\n...just one more wafer thin slice.'),
(6,1,'Test','Lorem, lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed maximus scelerisque ex, ut dapibus turpis elementum id. Sed faucibus, purus placerat condimentum elementum, justo nisi volutpat nisl, nec porttitor elit mauris vitae risus. Vestibulum interdum risus et libero luctus, quis gravida ligula laoreet. Ut velit ante, aliquam at ultricies non, placerat non nibh. Mauris tempor velit justo, vel faucibus dui posuere quis. Nulla facilisi. Suspendisse et est consectetur enim ornare tempus nec eget nulla. Nam blandit vitae mauris vel consectetur. Vestibulum ante justo, posuere eget turpis quis, pharetra accumsan enim. Phasellus at tincidunt elit.'),
(7,1,'Testing','The quick brown fox did some stuff, it was apparently interesting.'),
(8,1,'Lipsum','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

/*Table structure for table `user_site_form` */

DROP TABLE IF EXISTS `user_site_form`;

CREATE TABLE `user_site_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form` */

insert  into `user_site_form`(`id`,`site_id`,`name`,`email`) values 
(1,1,'Contact form','email@email.com'),
(2,1,'Test form','email@email.com'),
(3,1,'Testing tools','spam@spam.com');

/*Table structure for table `user_site_form_field` */

DROP TABLE IF EXISTS `user_site_form_field`;

CREATE TABLE `user_site_form_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  KEY `field_type_id` (`field_type_id`),
  KEY `tool_id` (`tool_id`),
  CONSTRAINT `user_site_form_field_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_form_field_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`),
  CONSTRAINT `user_site_form_field_ibfk_3` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_type` (`id`),
  CONSTRAINT `user_site_form_field_ibfk_4` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field` */

insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values 
(1,1,1,1,12,'Your name!','Please enter your name!',1),
(2,1,1,4,45,'Your email','Please enter your email address',2),
(3,1,1,2,13,'Your comment','Please enter your comment',3),
(4,1,1,1,12,'Your name','Please enter your name',4),
(5,1,1,1,12,'Text field','Standard text field',5),
(6,1,1,3,15,'Your password','Please enter your password',6),
(7,1,2,1,12,'Your name','Please enter your name',1),
(8,1,2,4,45,'Your email','Please enter your email address',2),
(9,1,3,1,12,'Your name','Please enter your name',1),
(10,1,3,4,45,'Your email','Please enter your email address',2),
(11,1,3,2,13,'Your comment','Please enter your comment',3),
(12,1,3,3,15,'Your password','Please enter your password',4),
(13,1,3,1,12,'Text field','Testing',5),
(14,1,3,2,13,'Text area','Testing',6),
(15,1,3,4,45,'Email field','Testing',7),
(16,1,3,3,15,'Password field','Testing',8);

/*Table structure for table `user_site_form_field_attribute` */

DROP TABLE IF EXISTS `user_site_form_field_attribute`;

CREATE TABLE `user_site_form_field_attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `attribute_id` tinyint(3) unsigned NOT NULL,
  `attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  KEY `field_id` (`field_id`),
  KEY `attribute_id` (`attribute_id`),
  CONSTRAINT `user_site_form_field_attribute_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_form_field_attribute_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`),
  CONSTRAINT `user_site_form_field_attribute_ibfk_3` FOREIGN KEY (`field_id`) REFERENCES `user_site_form_field` (`id`),
  CONSTRAINT `user_site_form_field_attribute_ibfk_4` FOREIGN KEY (`attribute_id`) REFERENCES `designer_form_field_attribute` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field_attribute` */

insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values 
(1,1,1,1,1,'40'),
(2,1,1,1,2,'255'),
(3,1,1,1,7,'Enter your name!'),
(4,1,1,2,10,'40'),
(5,1,1,2,11,'255'),
(6,1,1,2,12,'Enter your email'),
(7,1,1,3,3,'40'),
(8,1,1,3,4,'3'),
(9,1,1,3,8,'I think that it would.....'),
(10,1,1,4,1,'40'),
(11,1,1,4,2,'255'),
(12,1,1,4,7,'Enter your name'),
(13,1,1,5,1,'40'),
(14,1,1,5,2,'255'),
(15,1,1,5,7,'Joe Bloggs'),
(16,1,1,6,5,'20'),
(17,1,1,6,6,'255'),
(18,1,1,6,9,'******'),
(19,1,2,7,1,'40'),
(20,1,2,7,2,'255'),
(21,1,2,7,7,'Enter your name'),
(22,1,2,8,10,'40'),
(23,1,2,8,11,'255'),
(24,1,2,8,12,'Enter your email'),
(25,1,3,9,1,'40'),
(26,1,3,9,2,'255'),
(27,1,3,9,7,'Enter your name'),
(28,1,3,10,10,'40'),
(29,1,3,10,11,'255'),
(30,1,3,10,12,'Enter your email'),
(31,1,3,11,3,'40'),
(32,1,3,11,4,'3'),
(33,1,3,11,8,'I think that it would.....'),
(34,1,3,12,5,'20'),
(35,1,3,12,6,'255'),
(36,1,3,12,9,'******'),
(37,1,3,13,1,'40'),
(38,1,3,13,2,'255'),
(39,1,3,13,7,'Testing'),
(40,1,3,14,3,'40'),
(41,1,3,14,4,'4'),
(42,1,3,14,8,'Testing'),
(43,1,3,15,10,'40'),
(44,1,3,15,11,'255'),
(45,1,3,15,12,'Testing'),
(46,1,3,16,5,'20'),
(47,1,3,16,6,'255'),
(48,1,3,16,9,'Testing');

/*Table structure for table `user_site_form_field_row_background_color` */

DROP TABLE IF EXISTS `user_site_form_field_row_background_color`;

CREATE TABLE `user_site_form_field_row_background_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  KEY `field_id` (`field_id`),
  CONSTRAINT `user_site_form_field_row_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_form_field_row_background_color_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`),
  CONSTRAINT `user_site_form_field_row_background_color_ibfk_3` FOREIGN KEY (`field_id`) REFERENCES `user_site_form_field` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field_row_background_color` */

insert  into `user_site_form_field_row_background_color`(`id`,`site_id`,`form_id`,`field_id`,`color_hex`) values 
(1,1,1,1,'#eeeeee'),
(2,1,3,9,'#eeeeee');

/*Table structure for table `user_site_form_layout` */

DROP TABLE IF EXISTS `user_site_form_layout`;

CREATE TABLE `user_site_form_layout` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submit_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reset_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `layout_id` tinyint(3) unsigned NOT NULL,
  `horizontal_width_label` tinyint(2) unsigned NOT NULL DEFAULT '2',
  `horizontal_width_field` tinyint(2) unsigned NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  KEY `layout_id` (`layout_id`),
  CONSTRAINT `user_site_form_layout_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_form_layout_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`),
  CONSTRAINT `user_site_form_layout_ibfk_3` FOREIGN KEY (`layout_id`) REFERENCES `designer_form_layout` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_layout` */

insert  into `user_site_form_layout`(`id`,`site_id`,`form_id`,`title`,`sub_title`,`submit_label`,`reset_label`,`layout_id`,`horizontal_width_label`,`horizontal_width_field`) values 
(1,1,1,'Contact us','Got a question?','Save','',1,3,9),
(2,1,2,'Testing form','So I can edit in the content manager','Save','',1,3,9),
(3,1,3,'Testing to see if tools work','Hopefully not too broken','Save','Reset me',1,3,9);

/*Table structure for table `user_site_form_setting` */

DROP TABLE IF EXISTS `user_site_form_setting`;

CREATE TABLE `user_site_form_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `width` int(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Minimum form display width',
  `legend` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Fieldset legend text for form',
  `button` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Text for the submit button',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  CONSTRAINT `user_site_form_setting_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_form_setting_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_setting` */

/*Table structure for table `user_site_history` */

DROP TABLE IF EXISTS `user_site_history`;

CREATE TABLE `user_site_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) unsigned NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `identity_id` (`identity_id`),
  CONSTRAINT `user_site_history_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_history_ibfk_2` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identity` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_history` */

insert  into `user_site_history`(`id`,`identity_id`,`site_id`) values 
(1,1,1),
(2,2,2),
(3,3,3);

/*Table structure for table `user_site_image_library` */

DROP TABLE IF EXISTS `user_site_image_library`;

CREATE TABLE `user_site_image_library` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `sub_category_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `category_id` (`category_id`),
  KEY `sub_category_id` (`sub_category_id`),
  CONSTRAINT `user_site_image_library_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_image_library_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `user_site_image_library_category` (`id`),
  CONSTRAINT `user_site_image_library_ibfk_3` FOREIGN KEY (`sub_category_id`) REFERENCES `user_site_image_library_sub_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library` */

insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values 
(1,1,'Autumn path','Public domain image.',1,1),
(2,1,'Downtown Boston','Public domain image.',1,1),
(3,1,'Horses','Public domain image.',4,4),
(4,1,'Old lantern and brush','Public domain image.',1,1),
(5,1,'Robin','Public domain image.',4,4),
(6,1,'Signs','Public domain image.',1,1),
(7,1,'Spring coffee','Public domain image.',1,1),
(8,3,'Autumn path','Public domain image.',3,3),
(9,3,'Downtown Boston','Public domain image.',3,3),
(10,3,'Horses','Public domain image.',3,3),
(11,3,'Old lantern and brush','Public domain image.',3,3),
(12,3,'Robin','Public domain image.',3,3),
(13,3,'Signs','Public domain image.',3,3),
(14,3,'Spring coffee','Public domain image.',3,3),
(15,2,'Autumn path','Public domain image.',2,2),
(16,2,'Downtown Boston','Public domain image.',2,2),
(17,2,'Horses','Public domain image.',2,2),
(18,2,'Old lantern and brush','Public domain image.',2,2),
(19,2,'Robin','Public domain image.',2,2),
(20,2,'Signs','Public domain image.',2,2),
(21,2,'Spring coffee','Public domain image.',2,2),
(22,1,'Autumn path - Clone','Clone or original image.',1,1);

/*Table structure for table `user_site_image_library_category` */

DROP TABLE IF EXISTS `user_site_image_library_category`;

CREATE TABLE `user_site_image_library_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_image_library_category_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_category` */

insert  into `user_site_image_library_category`(`id`,`site_id`,`name`) values 
(1,1,'Uncategorised'),
(2,2,'Uncategorised'),
(3,3,'Uncategorised'),
(4,1,'Animals');

/*Table structure for table `user_site_image_library_link` */

DROP TABLE IF EXISTS `user_site_image_library_link`;

CREATE TABLE `user_site_image_library_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `library_id` int(11) unsigned NOT NULL,
  `version_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `library_id` (`library_id`),
  KEY `version_id` (`version_id`),
  CONSTRAINT `user_site_image_library_link_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_image_library_link_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `user_site_image_library` (`id`),
  CONSTRAINT `user_site_image_library_link_ibfk_3` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_version` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_link` */

insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values 
(1,1,1,1),
(2,1,2,2),
(3,1,3,3),
(4,1,4,4),
(5,1,5,5),
(6,1,6,6),
(7,1,7,23),
(8,3,8,8),
(9,3,9,9),
(10,3,10,10),
(11,3,11,11),
(12,3,12,12),
(13,3,13,13),
(14,3,14,14),
(15,2,15,15),
(16,2,16,16),
(17,2,17,17),
(18,2,18,18),
(19,2,19,19),
(20,2,20,20),
(21,2,21,21),
(22,1,22,22);

/*Table structure for table `user_site_image_library_sub_category` */

DROP TABLE IF EXISTS `user_site_image_library_sub_category`;

CREATE TABLE `user_site_image_library_sub_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `user_site_image_library_sub_category_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_image_library_sub_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `user_site_image_library_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_sub_category` */

insert  into `user_site_image_library_sub_category`(`id`,`site_id`,`category_id`,`name`) values 
(1,1,1,'Misc.'),
(2,2,2,'Misc.'),
(3,3,3,'Misc.'),
(4,1,4,'Misc.');

/*Table structure for table `user_site_image_library_version` */

DROP TABLE IF EXISTS `user_site_image_library_version`;

CREATE TABLE `user_site_image_library_version` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `library_id` int(11) unsigned NOT NULL,
  `uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tool_id` int(11) unsigned NOT NULL DEFAULT '25' COMMENT 'Tool used to create version',
  `identity_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `identity_id` (`identity_id`),
  KEY `library_id` (`library_id`),
  KEY `tool_id` (`tool_id`),
  CONSTRAINT `user_site_image_library_version_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_image_library_version_ibfk_2` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identity` (`id`),
  CONSTRAINT `user_site_image_library_version_ibfk_3` FOREIGN KEY (`library_id`) REFERENCES `user_site_image_library` (`id`),
  CONSTRAINT `user_site_image_library_version_ibfk_4` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_version` */

insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values 
(1,1,1,'2015-04-22 12:21:09',25,1),
(2,1,2,'2015-04-22 12:21:45',25,1),
(3,1,3,'2015-04-22 12:22:06',25,1),
(4,1,4,'2015-04-22 12:22:28',25,1),
(5,1,5,'2015-04-22 12:22:54',25,1),
(6,1,6,'2015-04-22 12:23:17',25,1),
(7,1,7,'2015-04-22 12:23:39',25,1),
(8,3,8,'2015-04-22 12:29:00',25,3),
(9,3,9,'2015-04-22 12:29:18',25,3),
(10,3,10,'2015-04-22 12:29:31',25,3),
(11,3,11,'2015-04-22 12:29:41',25,3),
(12,3,12,'2015-04-22 12:29:53',25,3),
(13,3,13,'2015-04-22 12:30:08',25,3),
(14,3,14,'2015-04-22 12:30:24',25,3),
(15,2,15,'2015-04-22 12:30:55',25,2),
(16,2,16,'2015-04-22 12:31:08',25,2),
(17,2,17,'2015-04-22 12:31:22',25,2),
(18,2,18,'2015-04-22 12:31:35',25,2),
(19,2,19,'2015-04-22 12:31:50',25,2),
(20,2,20,'2015-04-22 12:32:02',25,2),
(21,2,21,'2015-04-22 12:32:15',25,2),
(22,1,22,'2015-04-22 12:39:27',29,1),
(23,1,7,'2015-04-22 12:47:14',30,1);

/*Table structure for table `user_site_image_library_version_meta` */

DROP TABLE IF EXISTS `user_site_image_library_version_meta`;

CREATE TABLE `user_site_image_library_version_meta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `library_id` int(11) unsigned NOT NULL,
  `version_id` int(11) unsigned NOT NULL,
  `extension` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '.jpg',
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `width` smallint(5) NOT NULL DEFAULT '1',
  `height` smallint(5) NOT NULL DEFAULT '1',
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `library_id` (`library_id`),
  KEY `version_id` (`version_id`),
  CONSTRAINT `user_site_image_library_version_meta_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_image_library_version_meta_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `user_site_image_library` (`id`),
  CONSTRAINT `user_site_image_library_version_meta_ibfk_3` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_version` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_version_meta` */

insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values 
(1,1,1,1,'.jpg','image/jpeg',615,453,173442),
(2,1,2,2,'.jpg','image/jpeg',615,461,124479),
(3,1,3,3,'.jpg','image/jpeg',615,389,42910),
(4,1,4,4,'.jpg','image/jpeg',615,410,51533),
(5,1,5,5,'.jpg','image/jpeg',615,407,32763),
(6,1,6,6,'.jpg','image/jpeg',615,461,49367),
(7,1,7,7,'.jpg','image/jpeg',615,410,47362),
(8,3,8,8,'.jpg','image/jpeg',615,453,173442),
(9,3,9,9,'.jpg','image/jpeg',615,461,124479),
(10,3,10,10,'.jpg','image/jpeg',615,389,42910),
(11,3,11,11,'.jpg','image/jpeg',615,410,51533),
(12,3,12,12,'.jpg','image/jpeg',615,407,32763),
(13,3,13,13,'.jpg','image/jpeg',615,461,49367),
(14,3,14,14,'.jpg','image/jpeg',615,410,47362),
(15,2,15,15,'.jpg','image/jpeg',615,453,173442),
(16,2,16,16,'.jpg','image/jpeg',615,461,124479),
(17,2,17,17,'.jpg','image/jpeg',615,389,42910),
(18,2,18,18,'.jpg','image/jpeg',615,410,51533),
(19,2,19,19,'.jpg','image/jpeg',615,407,32763),
(20,2,20,20,'.jpg','image/jpeg',615,461,49367),
(21,2,21,21,'.jpg','image/jpeg',615,410,47362),
(22,1,22,22,'.jpg','image/jpeg',615,453,173442),
(23,1,7,23,'.jpg','image/jpeg',561,367,42624);

/*Table structure for table `user_site_page` */

DROP TABLE IF EXISTS `user_site_page`;

CREATE TABLE `user_site_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_page_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page` */

insert  into `user_site_page`(`id`,`site_id`,`name`) values 
(1,1,'Sample page'),
(2,1,'Testing forms'),
(3,1,'Nesting support');

/*Table structure for table `user_site_page_content_item_form` */

DROP TABLE IF EXISTS `user_site_page_content_item_form`;

CREATE TABLE `user_site_page_content_item_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `form_id` (`form_id`),
  CONSTRAINT `user_site_page_content_item_form_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_form_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_form_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
  CONSTRAINT `user_site_page_content_item_form_ibfk_4` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_form` */

insert  into `user_site_page_content_item_form`(`id`,`site_id`,`page_id`,`content_id`,`form_id`) values 
(1,1,1,7,1),
(2,1,2,16,2),
(3,1,2,19,2),
(4,1,2,23,2),
(5,1,1,25,2);

/*Table structure for table `user_site_page_content_item_heading` */

DROP TABLE IF EXISTS `user_site_page_content_item_heading`;

CREATE TABLE `user_site_page_content_item_heading` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `heading_id` tinyint(3) unsigned NOT NULL,
  `data_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `heading_id` (`heading_id`),
  KEY `data_id` (`data_id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_4` FOREIGN KEY (`heading_id`) REFERENCES `designer_content_heading` (`id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_5` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_heading` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_heading` */

insert  into `user_site_page_content_item_heading`(`id`,`site_id`,`page_id`,`content_id`,`heading_id`,`data_id`) values 
(1,1,1,3,2,1),
(2,1,1,4,1,2),
(3,1,1,13,3,3),
(4,1,1,14,1,3),
(5,1,2,18,1,4),
(6,1,2,20,2,5),
(7,1,3,27,2,6);

/*Table structure for table `user_site_page_content_item_html` */

DROP TABLE IF EXISTS `user_site_page_content_item_html`;

CREATE TABLE `user_site_page_content_item_html` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `data_id` int(11) unsigned NOT NULL COMMENT 'Id of content in data table',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `site_id` (`site_id`),
  KEY `data_id` (`data_id`),
  CONSTRAINT `user_site_page_content_item_html_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_html_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_html_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
  CONSTRAINT `user_site_page_content_item_html_ibfk_4` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_html` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_html` */

insert  into `user_site_page_content_item_html`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values 
(1,1,2,26,1);

/*Table structure for table `user_site_page_content_item_image` */

DROP TABLE IF EXISTS `user_site_page_content_item_image`;

CREATE TABLE `user_site_page_content_item_image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `version_id` int(11) unsigned NOT NULL,
  `expand` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `caption` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `version_id` (`version_id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_3` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_version` (`id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_4` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_image` */

insert  into `user_site_page_content_item_image`(`id`,`site_id`,`page_id`,`content_id`,`version_id`,`expand`,`caption`) values 
(1,1,1,5,23,1,'This is a picture of a nice cup of coffee'),
(2,1,2,17,5,1,'A robin, having a little rest while it surveys the surroundings.'),
(3,1,2,24,23,0,'Coffee............'),
(4,1,3,31,5,1,'Nice picture of a Robin having a rest.');

/*Table structure for table `user_site_page_content_item_jumbotron` */

DROP TABLE IF EXISTS `user_site_page_content_item_jumbotron`;

CREATE TABLE `user_site_page_content_item_jumbotron` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `data_id` int(11) unsigned NOT NULL,
  `button_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `data_id` (`data_id`),
  CONSTRAINT `user_site_page_content_item_jumbotron_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_jumbotron_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_jumbotron_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
  CONSTRAINT `user_site_page_content_item_jumbotron_ibfk_4` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_jumbotron` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_jumbotron` */

insert  into `user_site_page_content_item_jumbotron`(`id`,`site_id`,`page_id`,`content_id`,`data_id`,`button_label`) values 
(1,1,1,6,1,'Learn more?'),
(2,1,1,15,2,'Ohh, a button'),
(3,1,2,22,3,'Learn more about chicken?');

/*Table structure for table `user_site_page_content_item_text` */

DROP TABLE IF EXISTS `user_site_page_content_item_text`;

CREATE TABLE `user_site_page_content_item_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `data_id` int(11) unsigned NOT NULL COMMENT 'Id of content in data table',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `site_id` (`site_id`),
  KEY `data_id` (`data_id`),
  CONSTRAINT `user_site_page_content_item_text_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_text_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_text_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
  CONSTRAINT `user_site_page_content_item_text_ibfk_4` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_text` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_text` */

insert  into `user_site_page_content_item_text`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values 
(2,1,1,1,6),
(3,1,1,2,2),
(4,1,1,8,3),
(5,1,1,9,3),
(6,1,2,21,7),
(7,1,3,28,8),
(8,1,3,29,8),
(9,1,3,30,8);

/*Table structure for table `user_site_page_meta` */

DROP TABLE IF EXISTS `user_site_page_meta`;

CREATE TABLE `user_site_page_meta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`,`page_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `user_site_page_meta_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_meta` */

insert  into `user_site_page_meta`(`id`,`page_id`,`title`,`description`) values 
(1,1,'Dlayer sample page','Shows all the content items that can be assigned to a content page.'),
(2,2,'Testing new import form tool','Shows a few import forms, hopefully?'),
(3,3,'Testing nesting support','Testing the nesting support');

/*Table structure for table `user_site_page_structure_column` */

DROP TABLE IF EXISTS `user_site_page_structure_column`;

CREATE TABLE `user_site_page_structure_column` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `row_id` int(11) unsigned DEFAULT NULL,
  `size` tinyint(2) unsigned NOT NULL DEFAULT '12',
  `column_type` enum('xs','sm','md','lg') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'md',
  `offset` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `sort_order` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `row_id` (`row_id`),
  KEY `sort_order` (`sort_order`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `user_site_page_structure_column_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_structure_column_ibfk_2` FOREIGN KEY (`row_id`) REFERENCES `user_site_page_structure_row` (`id`),
  CONSTRAINT `user_site_page_structure_column_ibfk_3` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_structure_column` */

insert  into `user_site_page_structure_column`(`id`,`site_id`,`page_id`,`row_id`,`size`,`column_type`,`offset`,`sort_order`) values 
(1,1,1,1,3,'md',0,1),
(2,1,1,1,9,'md',0,2),
(3,1,1,2,6,'md',0,1),
(4,1,1,2,6,'md',0,2),
(12,1,2,6,4,'md',0,1),
(13,1,2,6,4,'md',0,2),
(14,1,2,6,4,'md',0,3),
(15,1,2,7,12,'md',0,1),
(16,1,2,8,6,'md',0,1),
(17,1,2,8,6,'md',0,2),
(18,1,1,9,4,'md',0,1),
(19,1,1,9,4,'md',0,2),
(20,1,1,9,4,'md',0,3),
(21,1,2,12,6,'md',0,1),
(22,1,2,12,6,'md',0,2),
(23,1,3,14,4,'md',0,1),
(24,1,3,14,4,'md',0,2),
(25,1,3,14,4,'md',0,3),
(26,1,3,13,12,'md',0,1),
(27,1,3,15,6,'md',0,1),
(28,1,3,15,6,'md',0,2),
(29,1,2,8,12,'md',0,3);

/*Table structure for table `user_site_page_structure_content` */

DROP TABLE IF EXISTS `user_site_page_structure_content`;

CREATE TABLE `user_site_page_structure_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `column_id` int(11) unsigned NOT NULL,
  `content_type` int(11) unsigned NOT NULL,
  `sort_order` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_type` (`content_type`),
  KEY `column_id` (`column_id`),
  CONSTRAINT `user_site_page_structure_content_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_structure_content_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_structure_content_ibfk_4` FOREIGN KEY (`content_type`) REFERENCES `designer_content_type` (`id`),
  CONSTRAINT `user_site_page_structure_content_ibfk_5` FOREIGN KEY (`column_id`) REFERENCES `user_site_page_structure_column` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_structure_content` */

insert  into `user_site_page_structure_content`(`id`,`site_id`,`page_id`,`column_id`,`content_type`,`sort_order`) values 
(1,1,1,1,1,4),
(2,1,1,2,1,3),
(3,1,1,1,2,1),
(4,1,1,2,2,1),
(5,1,1,1,5,2),
(6,1,1,2,4,2),
(7,1,1,2,3,4),
(8,1,1,3,1,1),
(9,1,1,4,1,1),
(13,1,1,3,2,2),
(14,1,1,4,2,2),
(15,1,1,3,4,3),
(16,1,2,12,3,1),
(17,1,2,13,5,1),
(18,1,2,15,2,1),
(19,1,2,14,3,1),
(20,1,2,16,2,1),
(21,1,2,16,1,2),
(22,1,2,16,4,3),
(23,1,2,16,3,4),
(24,1,2,16,5,5),
(25,1,1,1,3,3),
(26,1,2,17,7,1),
(27,1,3,26,2,1),
(28,1,3,23,1,1),
(29,1,3,24,1,1),
(30,1,3,25,1,1),
(31,1,3,27,5,1);

/*Table structure for table `user_site_page_structure_row` */

DROP TABLE IF EXISTS `user_site_page_structure_row`;

CREATE TABLE `user_site_page_structure_row` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `column_id` int(11) DEFAULT NULL,
  `sort_order` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `column_id` (`column_id`),
  KEY `user_site_page_structure_row_ibfk_1` (`site_id`),
  KEY `sort_order` (`sort_order`),
  CONSTRAINT `user_site_page_structure_row_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_structure_row_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_structure_row` */

insert  into `user_site_page_structure_row`(`id`,`site_id`,`page_id`,`column_id`,`sort_order`) values 
(1,1,1,0,1),
(2,1,1,0,2),
(6,1,2,0,2),
(7,1,2,0,1),
(8,1,2,0,3),
(9,1,1,0,3),
(10,1,1,0,4),
(11,1,1,0,5),
(12,1,2,0,4),
(13,1,3,0,1),
(14,1,3,0,2),
(15,1,3,0,3);

/*Table structure for table `user_site_page_styling_column_background_color` */

DROP TABLE IF EXISTS `user_site_page_styling_column_background_color`;

CREATE TABLE `user_site_page_styling_column_background_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `column_id` int(11) unsigned NOT NULL,
  `background_color` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `column_id` (`column_id`),
  CONSTRAINT `user_site_page_styling_column_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_styling_column_background_color_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_styling_column_background_color_ibfk_3` FOREIGN KEY (`column_id`) REFERENCES `user_site_page_structure_column` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styling_column_background_color` */

insert  into `user_site_page_styling_column_background_color`(`id`,`site_id`,`page_id`,`column_id`,`background_color`) values 
(1,1,1,1,'#eeeeee'),
(2,1,1,2,'#b6b6b6'),
(3,1,2,17,'#5cb85c'),
(5,1,2,14,'#ca9c24'),
(6,1,2,29,'#f0ad4e');

/*Table structure for table `user_site_page_styling_content_item_background_color` */

DROP TABLE IF EXISTS `user_site_page_styling_content_item_background_color`;

CREATE TABLE `user_site_page_styling_content_item_background_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `background_color` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `user_site_page_styling_content_item_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_styling_content_item_background_color_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_styling_content_item_background_color_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styling_content_item_background_color` */

insert  into `user_site_page_styling_content_item_background_color`(`id`,`site_id`,`page_id`,`content_id`,`background_color`) values 
(2,1,1,2,'#f0ad4e'),
(3,1,1,4,'#5bc0de'),
(4,1,2,19,'#f0ad4e'),
(5,1,2,20,'#337ab7'),
(6,1,2,17,'#eeeeee'),
(7,1,2,22,'#5bc0de'),
(8,1,2,26,'#f0ad4e'),
(9,1,3,28,'');

/*Table structure for table `user_site_page_styling_content_item_typography` */

DROP TABLE IF EXISTS `user_site_page_styling_content_item_typography`;

CREATE TABLE `user_site_page_styling_content_item_typography` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `font_family_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `font_family_id` (`font_family_id`),
  CONSTRAINT `user_site_page_styling_content_item_typography_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_styling_content_item_typography_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_styling_content_item_typography_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
  CONSTRAINT `user_site_page_styling_content_item_typography_ibfk_4` FOREIGN KEY (`font_family_id`) REFERENCES `designer_css_font_family` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styling_content_item_typography` */

insert  into `user_site_page_styling_content_item_typography`(`id`,`site_id`,`page_id`,`content_id`,`font_family_id`) values 
(2,1,3,28,2);

/*Table structure for table `user_site_page_styling_page_background_color` */

DROP TABLE IF EXISTS `user_site_page_styling_page_background_color`;

CREATE TABLE `user_site_page_styling_page_background_color` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `background_color` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `user_site_page_styling_page_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_styling_page_background_color_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styling_page_background_color` */

insert  into `user_site_page_styling_page_background_color`(`id`,`site_id`,`page_id`,`background_color`) values 
(1,1,2,'#eeeeee'),
(2,1,3,'#eeeeee');

/*Table structure for table `user_site_page_styling_row_background_color` */

DROP TABLE IF EXISTS `user_site_page_styling_row_background_color`;

CREATE TABLE `user_site_page_styling_row_background_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `row_id` int(11) unsigned NOT NULL,
  `background_color` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `row_id` (`row_id`),
  CONSTRAINT `user_site_page_styling_row_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_styling_row_background_color_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_styling_row_background_color_ibfk_3` FOREIGN KEY (`row_id`) REFERENCES `user_site_page_structure_row` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styling_row_background_color` */

insert  into `user_site_page_styling_row_background_color`(`id`,`site_id`,`page_id`,`row_id`,`background_color`) values 
(1,1,2,7,'#d9534f'),
(2,1,2,8,'#eeeeee');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
