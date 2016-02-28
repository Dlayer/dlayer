/*
SQLyog Enterprise v12.2.0 (64 bit)
MySQL - 5.6.25 : Database - dlayer
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `designer_color_palette` */

CREATE TABLE `designer_color_palette` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palette` */

insert  into `designer_color_palette`(`id`,`name`,`view_script`) values (1,'Palette 1','palette-1');
insert  into `designer_color_palette`(`id`,`name`,`view_script`) values (2,'Palette 2','palette-2');

/*Table structure for table `designer_color_palette_color` */

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

insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (1,1,1,'Black','#000000');
insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (2,1,2,'Dark grey','#333333');
insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (3,1,3,'Grey','#555555');
insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (4,1,4,'Light grey','#777777');
insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (5,1,5,'Off white','#EEEEEE');
insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (6,2,1,'Blue','#337ab7');
insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (7,2,2,'Green','#5cb85c');
insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (8,2,3,'Light blue','#5bc0de');
insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (9,2,4,'Amber','#f0ad4e');
insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (10,2,5,'Red','#d9534f');

/*Table structure for table `designer_color_type` */

CREATE TABLE `designer_color_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_type` */

insert  into `designer_color_type`(`id`,`type`) values (1,'Primary');
insert  into `designer_color_type`(`id`,`type`) values (2,'Secondary');
insert  into `designer_color_type`(`id`,`type`) values (3,'Tertiary');
insert  into `designer_color_type`(`id`,`type`) values (4,'Quaternary');
insert  into `designer_color_type`(`id`,`type`) values (5,'Quinary');

/*Table structure for table `designer_content_heading` */

CREATE TABLE `designer_content_heading` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_heading` */

insert  into `designer_content_heading`(`id`,`name`,`tag`,`sort_order`) values (1,'Page title','h1',1);
insert  into `designer_content_heading`(`id`,`name`,`tag`,`sort_order`) values (2,'Content heading 1','h2',2);
insert  into `designer_content_heading`(`id`,`name`,`tag`,`sort_order`) values (3,'Content heading 2','h3',3);
insert  into `designer_content_heading`(`id`,`name`,`tag`,`sort_order`) values (4,'Content heading 3','h4',4);
insert  into `designer_content_heading`(`id`,`name`,`tag`,`sort_order`) values (5,'Content heading 4','h5',5);
insert  into `designer_content_heading`(`id`,`name`,`tag`,`sort_order`) values (6,'Content heading 5','h6',6);

/*Table structure for table `designer_content_type` */

CREATE TABLE `designer_content_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tool_id` (`tool_id`),
  CONSTRAINT `designer_content_type_ibfk_1` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_type` */

insert  into `designer_content_type`(`id`,`name`,`description`,`tool_id`) values (1,'text','Text block',10);
insert  into `designer_content_type`(`id`,`name`,`description`,`tool_id`) values (2,'heading','Heading',11);
insert  into `designer_content_type`(`id`,`name`,`description`,`tool_id`) values (3,'form','Form',16);
insert  into `designer_content_type`(`id`,`name`,`description`,`tool_id`) values (4,'jumbotron','Jumbotron',34);
insert  into `designer_content_type`(`id`,`name`,`description`,`tool_id`) values (5,'image','Image',39);

/*Table structure for table `designer_css_border_style` */

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

insert  into `designer_css_border_style`(`id`,`name`,`style`,`sort_order`) values (1,'Solid','solid',2);
insert  into `designer_css_border_style`(`id`,`name`,`style`,`sort_order`) values (2,'Dashed','dashed',3);
insert  into `designer_css_border_style`(`id`,`name`,`style`,`sort_order`) values (3,'No border','none',1);

/*Table structure for table `designer_css_font_family` */

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

insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values (1,'Helvetica','Helvetica Neue, Helvetica, Arial','\"Helvetica Neue\", Helvetica, Arial, sans-serif',1);
insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values (2,'Lucida Grande','Lucida Grande, Lucida Sans Unicode, Bitstream Vera Sans','\"Lucida Grande\", \"Lucida Sans Unicode\", \"Bitstream Vera Sans\", sans-serif',2);
insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values (3,'Georgia','Georgia, URW Bookman L','Georgia, \"URW Bookman L\", serif',3);
insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values (4,'Corbel','Corbel, Arial, Helvetica, Nimbus Sans L, Liberation Sans','Corbel, Arial, Helvetica, \"Nimbus Sans L\", \"Liberation Sans\", sans-serif',4);
insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values (5,'Code','Consolas, Bitstream Vera Sans Mono, Andale Mono, Monaco, Lucida Console','Consolas, \"Bitstream Vera Sans Mono\", \"Andale Mono\", Monaco, \"Lucida Console\", monospace',5);
insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values (6,'Verdana','Verdana, Geneva','Verdana, Geneva, sans-serif',6);
insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values (7,'Tahoma','Tahoma, Geneva','Tahoma, Geneva, sans-serif',7);
insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values (8,'Segoe','Segoe UI, Helvetica, Arial, Sans-Serif;','\"Segoe UI\", Helvetica, Arial, \"Sans-Serif\"',8);

/*Table structure for table `designer_css_text_decoration` */

CREATE TABLE `designer_css_text_decoration` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_decoration` */

insert  into `designer_css_text_decoration`(`id`,`name`,`css`,`sort_order`) values (1,'None','none',1);
insert  into `designer_css_text_decoration`(`id`,`name`,`css`,`sort_order`) values (2,'Underline','underline',2);
insert  into `designer_css_text_decoration`(`id`,`name`,`css`,`sort_order`) values (3,'Strike-through','line-through',3);

/*Table structure for table `designer_css_text_style` */

CREATE TABLE `designer_css_text_style` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_style` */

insert  into `designer_css_text_style`(`id`,`name`,`css`,`sort_order`) values (1,'Normal','normal',1);
insert  into `designer_css_text_style`(`id`,`name`,`css`,`sort_order`) values (2,'Italic','italic',2);
insert  into `designer_css_text_style`(`id`,`name`,`css`,`sort_order`) values (3,'Oblique','oblique',3);

/*Table structure for table `designer_css_text_weight` */

CREATE TABLE `designer_css_text_weight` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_weight` */

insert  into `designer_css_text_weight`(`id`,`name`,`css`,`sort_order`) values (1,'Normal','400',1);
insert  into `designer_css_text_weight`(`id`,`name`,`css`,`sort_order`) values (2,'Bold','700',3);
insert  into `designer_css_text_weight`(`id`,`name`,`css`,`sort_order`) values (3,'Light','100',4);
insert  into `designer_css_text_weight`(`id`,`name`,`css`,`sort_order`) values (4,'Light bold','500',2);

/*Table structure for table `designer_form_field_attribute` */

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

insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (1,1,'Size','size',1);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (2,1,'Max length','maxlength',1);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (3,2,'Columns','cols',1);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (4,2,'Rows','rows',1);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (5,3,'Size','size',1);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (6,3,'Max length','maxlength',1);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (7,1,'Placeholder','placeholder',2);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (8,2,'Placeholder','placeholder',2);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (9,3,'Placeholder','placeholder',2);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (10,4,'Size','size',1);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (11,4,'Max length','maxlength',1);
insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (12,4,'Placeholder','placeholder',2);

/*Table structure for table `designer_form_field_attribute_type` */

CREATE TABLE `designer_form_field_attribute_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_attribute_type` */

insert  into `designer_form_field_attribute_type`(`id`,`name`,`type`) values (1,'Integer','integer');
insert  into `designer_form_field_attribute_type`(`id`,`name`,`type`) values (2,'String','string');

/*Table structure for table `designer_form_field_param_preview` */

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

insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (1,1,1,3);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (2,1,2,3);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (3,1,7,1);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (4,2,3,3);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (5,2,4,3);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (6,2,8,1);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (7,3,5,3);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (8,3,6,3);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (9,3,9,1);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (10,4,10,3);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (11,4,11,3);
insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (12,4,12,1);

/*Table structure for table `designer_form_field_type` */

CREATE TABLE `designer_form_field_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_type` */

insert  into `designer_form_field_type`(`id`,`name`,`type`,`description`) values (1,'Text','text','A single line field');
insert  into `designer_form_field_type`(`id`,`name`,`type`,`description`) values (2,'Textarea','textarea','A multiple line field');
insert  into `designer_form_field_type`(`id`,`name`,`type`,`description`) values (3,'Password','password','A password field');
insert  into `designer_form_field_type`(`id`,`name`,`type`,`description`) values (4,'Email','email','Email field');

/*Table structure for table `designer_form_layout` */

CREATE TABLE `designer_form_layout` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `layout` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_layout` */

insert  into `designer_form_layout`(`id`,`layout`,`class`) values (1,'Standard','form');
insert  into `designer_form_layout`(`id`,`layout`,`class`) values (2,'Inline','form-inline');
insert  into `designer_form_layout`(`id`,`layout`,`class`) values (3,'Horizontal','form-horizontal');

/*Table structure for table `designer_form_preview_method` */

CREATE TABLE `designer_form_preview_method` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_preview_method` */

insert  into `designer_form_preview_method`(`id`,`method`) values (1,'field_attribute_string');
insert  into `designer_form_preview_method`(`id`,`method`) values (2,'row_attribute');
insert  into `designer_form_preview_method`(`id`,`method`) values (3,'field_attribute_integer');

/*Table structure for table `dlayer_glyphicon` */

CREATE TABLE `dlayer_glyphicon` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `glyphicon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `dlayer_glyphicon` */

insert  into `dlayer_glyphicon`(`id`,`name`,`glyphicon`) values (1,'None','');
insert  into `dlayer_glyphicon`(`id`,`name`,`glyphicon`) values (2,'Add/Edit','glyphicon glyphicon-pencil');
insert  into `dlayer_glyphicon`(`id`,`name`,`glyphicon`) values (3,'Size and position','glyphicon glyphicon-resize-horizontal');
insert  into `dlayer_glyphicon`(`id`,`name`,`glyphicon`) values (4,'Styles','glyphicon glyphicon-adjust');
insert  into `dlayer_glyphicon`(`id`,`name`,`glyphicon`) values (5,'Help','glyphicon glyphicon-question-sign');
insert  into `dlayer_glyphicon`(`id`,`name`,`glyphicon`) values (6,'Go to designer','glyphicon glyphicon-new-window');
insert  into `dlayer_glyphicon`(`id`,`name`,`glyphicon`) values (7,'Move','glyphicon glyphicon-move');
insert  into `dlayer_glyphicon`(`id`,`name`,`glyphicon`) values (8,'Select','glyphicon glyphicon-hand-up');
insert  into `dlayer_glyphicon`(`id`,`name`,`glyphicon`) values (9,'Information','glyphicon glyphicon-info-sign');

/*Table structure for table `dlayer_identity` */

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

insert  into `dlayer_identity`(`id`,`identity`,`credentials`,`logged_in`,`last_login`,`last_action`,`enabled`) values (1,'user-1@dlayer.com','$6$rounds=5000$jks453yuyt55d$CZJCjaieFQghQ6MwQ1OUI5nVKDy/Fi2YXk7MyW2hcex9AdJ/jvZA8ulvjzK1lo3rRVFfmd10lgjqAbDQM4ehR1',0,'2016-02-28 14:17:47','2016-02-28 14:19:36',1);
insert  into `dlayer_identity`(`id`,`identity`,`credentials`,`logged_in`,`last_login`,`last_action`,`enabled`) values (2,'user-2@dlayer.com','$6$rounds=5000$jks453yuyt55d$ZVEJgs2kNjxOxNEayqqoh2oJUiGbmxIKRqOTxVM05MP2YRcAjE9adCZfQBWCc.qe1nDjEM9.ioivNz3c/qyZ80',0,'2015-05-29 15:57:54','2015-05-29 15:58:47',1);
insert  into `dlayer_identity`(`id`,`identity`,`credentials`,`logged_in`,`last_login`,`last_action`,`enabled`) values (3,'user-3@dlayer.com','$6$rounds=5000$jks453yuyt55d$NYF6yCvxXplefx7nr8vDe4cUGBEFtd3G5vuJ2utfqvPwEf3dSgNXNTcGbFO6WrJSn21CXHgZwNOQHy691E/Rm.',0,'2015-05-29 15:59:10','2015-05-29 16:25:10',1);

/*Table structure for table `dlayer_module` */

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

insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (1,'template','Template designer','The Template designer lets you create page templates',7,0);
insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (2,'widget','Widget designer','The Widget designer lets you to develop reusable content items',4,0);
insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (3,'form','Form builder','The Form builder lets you build web forms',2,0);
insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (4,'content','Content manager','The Content manager lets you create and manage all your site content',1,0);
insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (5,'website','Web site manager','The Web site manager lets you manage the relationships between all your site pages and data',5,0);
insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (6,'question','Question manager','Create quizzes, tests and polls. <span class=\"label label-default\">Planning</span>',99,0);
insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (7,'dlayer','Dlayer','Home',0,1);
insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (8,'image','Image library','Your Image and Media library',6,1);
insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (9,'data','Data manager','The Data manager lets you design datasets and then manage your data',3,0);

/*Table structure for table `dlayer_module_tool` */

CREATE TABLE `dlayer_module_tool` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tool` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tool name to use through code',
  `tool_model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tool process model',
  `folder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Folder for tool tab ciew scripts',
  `base` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Can tool run on base div',
  `destructive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Group within toolbar',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Sort order within group',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tool` (`module_id`,`tool`),
  KEY `group_id` (`group_id`),
  KEY `sort_order` (`sort_order`),
  KEY `destructive` (`destructive`),
  CONSTRAINT `dlayer_module_tool_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool` */

insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','cancel',NULL,'cancel',1,0,1,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (2,1,'Create rows','split-horizontal','SplitHorizontal','split-horizontal',1,1,2,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (3,1,'Split vertical','split-vertical','SplitVertical','split-vertical',1,1,2,2,0);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (6,1,'Resize','resize','Resize','resize',0,1,2,3,0);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (7,1,'Background colour','background-color','BackgroundColor','background-color',1,0,3,1,0);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (8,1,'Border','border','Border','border',1,0,3,2,0);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (9,4,'Cancel','cancel',NULL,'cancel',2,0,1,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (10,4,'Text','text','Text','text',0,0,3,2,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (11,4,'Heading','heading','Heading','heading',0,0,3,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (12,3,'Text','text','Text','text',0,0,4,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (13,3,'Text area','textarea','Textarea','textarea',0,0,4,2,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (14,3,'Cancel','cancel',NULL,'cancel',2,0,1,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (15,3,'Password','password','Password','password',0,0,4,4,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (16,4,'Form','import-form','ImportForm','import-form',0,0,3,4,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (17,5,'Cancel','cancel',NULL,'cancel',0,0,1,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (18,5,'New page','new-page','NewPage','new-page',0,0,2,2,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (19,5,'Move page','move-page','MovePage','move-page',0,0,2,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (20,3,'Email','preset-email','Email','preset-email',0,0,3,2,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (21,3,'Name','preset-name','Text','preset-name',0,0,3,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (22,4,'Text','import-text','ImportText','import-text',0,0,4,2,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (23,4,'Heading','import-heading','ImportHeading','import-heading',0,0,4,3,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (25,8,'Add to library','add','Add','add',1,0,2,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (26,8,'Cancel / Back to library','cancel',NULL,'cancel',0,0,1,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (27,8,'Category','category','Category','category',1,0,3,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (28,8,'Sub category','subcategory','Subcategory','subcategory',1,0,3,2,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (29,8,'Clone','copy','Copy','copy',0,0,4,3,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (30,8,'Crop','crop','Crop','crop',0,0,4,2,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (31,8,'Edit','edit','Edit','edit',0,0,4,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (32,4,'Add content row(s)','add-content-row','AddContentRow','add-content-row',1,0,2,3,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (34,4,'Jumbotron','jumbotron','Jumbotron','jumbotron',0,0,3,3,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (35,4,'Jumbotron','import-jumbotron','ImportJumbotron','import-jumbotron',0,0,4,4,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (36,4,'Move row','move-row','MoveRow','move-row',1,0,2,5,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (37,4,'Move item','move-item','MoveItem','move-item',1,0,2,6,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (38,4,'Content row','content-row','ContentRow','content-row',1,0,2,4,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (39,4,'Image','image','Image','image',0,0,3,5,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (40,4,'Carousel','carousel','ImageCarousel','carousel',0,0,3,6,0);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (41,4,'Select parent','select','Select','select',1,0,2,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (42,3,'Layout','form-layout','FormLayout','form-layout',1,0,2,1,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (43,3,'Actions','form-actions','formActions','form-actions',1,0,2,2,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (44,3,'Settings','form-settings','FormSettings','form-settings',1,0,2,3,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (45,3,'Email','email','Email','email',0,0,4,3,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (46,4,'Content area','content-area','ContentArea','content-area',1,0,2,2,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (47,3,'Comment','preset-comment','Textarea','preset-comment',0,0,3,3,1);
insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (48,3,'Password','preset-password','Password','preset-password',0,0,3,4,1);

/*Table structure for table `dlayer_module_tool_tab` */

CREATE TABLE `dlayer_module_tool_tab` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(2) unsigned NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `glyphicon_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `view_script` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_tool_model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multi_use` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `edit_mode` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tool_tab` (`tool_id`,`view_script`),
  KEY `name` (`name`),
  KEY `sort_order` (`sort_order`),
  KEY `enabled` (`enabled`),
  KEY `module_id` (`module_id`),
  KEY `glyphicon_id` (`glyphicon_id`),
  CONSTRAINT `dlayer_module_tool_tab_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`),
  CONSTRAINT `dlayer_module_tool_tab_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`),
  CONSTRAINT `dlayer_module_tool_tab_ibfk_3` FOREIGN KEY (`glyphicon_id`) REFERENCES `dlayer_glyphicon` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tab` */

insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (1,1,2,'Quick',1,'quick',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (2,1,2,'Custom',1,'advanced',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (3,1,2,'?',1,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (4,1,3,'Quick',1,'quick',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (5,1,3,'Mouse',1,'advanced',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (6,1,3,'?',1,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (7,1,7,'#1',1,'palette-1',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (8,1,7,'#2',1,'palette-2',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (9,1,7,'#3',1,'palette-3',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (10,1,7,'Custom',1,'advanced',NULL,0,0,0,4,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (11,1,7,'?',1,'help',NULL,0,0,0,5,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (12,1,6,'Custom',1,'advanced',NULL,0,0,0,4,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (14,1,6,'?',1,'help',NULL,0,0,0,5,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (15,1,6,'Push',1,'expand',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (16,1,6,'Pull',1,'contract',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (17,1,6,'Height',1,'height',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (20,1,8,'Custom',1,'advanced',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (21,1,8,'?',1,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (22,1,8,'Full border',1,'full',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (23,4,10,'Text',2,'text',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (24,4,11,'Heading',2,'heading',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (25,4,10,'Help',5,'help',NULL,0,0,0,4,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (26,4,11,'Help',5,'help',NULL,0,0,0,4,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (27,3,12,'Text field',2,'text',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (28,3,12,'Help',5,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (29,3,13,'Text area field',2,'textarea',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (30,3,13,'Help',5,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (31,3,15,'Password field',2,'password',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (32,3,15,'Help',5,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (33,4,16,'Form',2,'import-form',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (34,4,16,'Help',5,'help',NULL,0,0,0,5,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (35,5,18,'Page',1,'new-page',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (36,5,18,'?',1,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (37,5,19,'Page',1,'move-page',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (38,5,19,'?',1,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (39,4,10,'Styles',4,'styling','Styling_Text',1,1,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (40,4,11,'Styles',4,'styling','Styling_Heading',1,1,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (41,4,16,'Styles',4,'styling','Styling_ImportForm',1,1,0,4,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (42,3,20,'Email field',2,'preset-email',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (43,3,20,'Help',5,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (44,3,21,'Name field',2,'preset-name',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (45,3,21,'Help',5,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (46,4,16,'Size & position',3,'position','Position_ImportForm',1,1,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (47,4,10,'Size & position',3,'position','Position_Text',1,1,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (48,4,11,'Size & position',3,'position','Position_Heading',1,1,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (49,3,12,'Styling',4,'styling','Styling_Text',1,1,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (50,3,13,'Styling',4,'styling','Styling_Textarea',1,1,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (51,3,15,'Styling',4,'styling','Styling_Password',1,1,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (54,4,16,'Edit in Form builder',6,'edit',NULL,0,1,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (55,4,22,'Import',2,'import-text',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (56,4,22,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (57,4,23,'Import',2,'import-heading',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (58,4,23,'Help',5,'help',NULL,0,0,2,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (61,8,25,'Image',1,'add',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (62,8,25,'?',1,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (63,8,27,'Category',1,'category',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (64,8,27,'?',1,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (65,8,28,'Sub category',1,'subcategory',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (66,8,28,'?',1,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (67,8,29,'Clone',1,'copy',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (68,8,29,'?',1,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (69,8,30,'?',1,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (70,8,31,'Edit',1,'edit',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (71,8,31,'?',1,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (72,8,30,'Crop',1,'crop',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (73,4,32,'Row',2,'add-content-row',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (74,4,32,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (77,4,34,'Jumbotron',2,'jumbotron',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (78,4,34,'Help',5,'help',NULL,0,0,0,4,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (79,4,34,'Styles',4,'styling','Styling_Jumbotron',1,1,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (80,4,34,'Size & position',3,'position','Position_Jumbotron',1,1,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (81,4,35,'Import',2,'import-jumbotron',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (82,4,35,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (83,4,36,'Move',7,'move-row',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (84,4,36,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (85,4,37,'Move',7,'move-item',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (86,4,37,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (87,4,38,'Row',9,'content-row',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (88,4,38,'Styles',4,'styling','Styling_ContentRow',0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (89,4,39,'Image',2,'image',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (90,4,39,'Help',5,'help',NULL,0,0,0,4,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (91,4,40,'Carousel',2,'carousel',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (92,4,40,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (93,4,39,'Size & position',3,'position','Position_Image',1,1,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (94,4,39,'Styles',4,'styling','Styling_Image',1,1,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (95,4,41,'Select',8,'select',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (96,4,41,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (97,3,42,'Form layout',2,'form-layout',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (98,3,42,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (99,3,45,'Email field',2,'email',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (100,3,45,'Help',5,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (101,3,45,'Styling',4,'styling','Styling_Email',1,1,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (102,3,43,'Form actions',2,'form-actions',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (103,3,43,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (104,3,44,'Form settings',2,'form-settings',NULL,1,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (105,3,44,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (106,4,38,'Help',5,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (107,4,46,'Area',9,'content-area',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (108,4,46,'Styles',4,'styling','Styling_ContentArea',0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (109,4,46,'Help',5,'help',NULL,0,0,0,3,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (110,3,47,'Comment field',2,'preset-comment',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (111,3,47,'Help',5,'help',NULL,0,0,0,2,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (112,3,48,'Password field',2,'preset-password',NULL,0,0,1,1,1);
insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`glyphicon_id`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (113,3,48,'Help',5,'help',NULL,0,0,0,2,1);

/*Table structure for table `dlayer_session` */

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

insert  into `dlayer_session`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('2tqusggf8qrdkuc31ddk53lfh2','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1456166034,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1456169633;}}');
insert  into `dlayer_session`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('365ou07mlgs4v4ap0scdap0i40','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1456669179,3601,'__ZF|a:6:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1456672779;}s:20:\"dlayer_session_image\";a:1:{s:3:\"ENT\";i:1456672779;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1456672779;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1456672779;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1456672779;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1456672779;}}dlayer_session_image|a:6:{s:9:\"edit_mode\";i:0;s:9:\"image_ids\";a:0:{}s:4:\"sort\";N;s:10:\"sort_order\";N;s:4:\"tool\";N;s:3:\"tab\";N;}dlayer_session_template|a:4:{s:6:\"div_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";N;}dlayer_session_form|a:5:{s:8:\"field_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:7:\"form_id\";N;s:6:\"return\";N;}dlayer_session_content|a:7:{s:6:\"div_id\";N;s:14:\"content_row_id\";N;s:10:\"content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:7:\"page_id\";N;s:11:\"template_id\";N;}dlayer_session_designer|a:4:{s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}');
insert  into `dlayer_session`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('3tffubd2j5e2gg5doq80fe47r7','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1455899083,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1455902682;}}');
insert  into `dlayer_session`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('e39tbbesr0m3vk2i860rh6e3q6','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1455670986,3601,'__ZF|a:6:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1455674586;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1455674586;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1455673798;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1455673798;}s:20:\"dlayer_session_image\";a:1:{s:3:\"ENT\";i:1455673798;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1455673798;}}dlayer_session_content|a:7:{s:7:\"page_id\";i:1;s:6:\"div_id\";N;s:14:\"content_row_id\";N;s:10:\"content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";i:1;}dlayer_session_template|a:4:{s:11:\"template_id\";N;s:6:\"div_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;}dlayer_session_form|a:5:{s:8:\"field_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:7:\"form_id\";N;s:6:\"return\";N;}dlayer_session_designer|a:4:{s:24:\"image_picker_category_id\";N;s:28:\"image_picker_sub_category_id\";N;s:21:\"image_picker_image_id\";N;s:23:\"image_picker_version_id\";N;}dlayer_session_image|a:3:{s:4:\"tool\";N;s:3:\"tab\";N;s:9:\"image_ids\";a:0:{}}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:7:\"content\";}');
insert  into `dlayer_session`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('m5b0mrg77fpv7han07nrg25vg4','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1456100903,3601,'__ZF|a:6:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1456104503;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1456104100;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1456103074;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1456103758;}s:20:\"dlayer_session_image\";a:1:{s:3:\"ENT\";i:1456104122;}s:23:\"dlayer_session_designer\";a:1:{s:3:\"ENT\";i:1456104100;}}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:5:\"image\";}dlayer_session_content|a:7:{s:7:\"page_id\";i:1;s:6:\"div_id\";N;s:14:\"content_row_id\";N;s:10:\"content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";i:1;}dlayer_session_form|a:1:{s:7:\"form_id\";N;}dlayer_session_template|a:3:{s:11:\"template_id\";i:1;s:4:\"tool\";N;s:6:\"div_id\";N;}dlayer_session_image|a:6:{s:9:\"edit_mode\";i:0;s:9:\"image_ids\";a:2:{s:8:\"category\";i:1;s:12:\"sub_category\";i:1;}s:4:\"sort\";N;s:10:\"sort_order\";N;s:4:\"tool\";N;s:3:\"tab\";N;}');
insert  into `dlayer_session`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('rpt7kpb696ha0bkfhd4mtkrbu1','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1455497570,3601,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1455501170;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1455501170;}}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:7:\"content\";}dlayer_session_content|a:1:{s:7:\"page_id\";N;}');
insert  into `dlayer_session`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('t9ppvsfr3sn3j4aunhnri82tc1','C:\\Users\\g3d\\Documents\\Xampp\\tmp','PHPSESSID',1456189561,3601,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1456193161;}s:20:\"dlayer_session_image\";a:1:{s:3:\"ENT\";i:1456193161;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1456191012;}}dlayer_session|a:3:{s:11:\"identity_id\";i:1;s:7:\"site_id\";i:1;s:6:\"module\";s:5:\"image\";}dlayer_session_image|a:8:{s:9:\"edit_mode\";i:0;s:9:\"image_ids\";a:2:{s:8:\"category\";i:1;s:12:\"sub_category\";i:1;}s:4:\"sort\";s:8:\"uploaded\";s:10:\"sort_order\";s:4:\"desc\";s:4:\"tool\";s:3:\"add\";s:3:\"tab\";s:3:\"add\";s:10:\"tool_model\";s:3:\"Add\";s:16:\"tool_destructive\";s:1:\"0\";}dlayer_session_form|a:6:{s:7:\"form_id\";i:1;s:8:\"field_id\";i:3;s:4:\"tool\";s:8:\"textarea\";s:3:\"tab\";s:8:\"textarea\";s:6:\"return\";N;s:10:\"tool_model\";s:8:\"Textarea\";}');

/*Table structure for table `dlayer_setting` */

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

insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (1,1,'Colour palettes','Colour palettes','<p>You can define three colour palettes for each of your web sites, the colours you define here will be shown anytime you need a tool that requires you to choose a colour.</p>\r\n\r\n<p>You will always be able to choose a colour that is not in one of your three palettes, think of these as quick access.</p>','/dlayer/settings/palettes',1,'All colour pickers',2,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (2,3,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the content manager, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/content/settings/base-font-family',2,'Content module, all text',2,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (3,3,'Heading styles','Set the styles for the six heading types','<p>Define the styles for the page title and the five sub headings, H2 through H6.</p>\r\n\r\n<p>Anywhere you need to choose one of the heading types the styles defined here will be used.</p>','/content/settings/headings',3,'Heading tool',3,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (4,4,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the form builder, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/form/settings/base-font-family',2,'Forms module, all text',2,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (5,1,'Overview','Overview','<p>Settings overview.</p>','/dlayer/settings/index',1,NULL,1,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (6,2,'Overview','Overview','<p>Template designer settings overview.</p>','/template/settings/index',2,NULL,1,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (7,3,'Overview','Overview','<p>Content manager settings overview.</p>','/content/settings/index',2,NULL,1,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (8,4,'Overview','Overview','<p>Form builder settings overview.</p>','/form/settings/index',2,NULL,1,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (9,8,'Overview','Overview','<p>Image library settings overview.</p>','/image/settings/index',2,NULL,1,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (10,6,'Overview','Overview','<p>Web site manager settings overview.</p>','/website/settings/index',2,NULL,1,1);
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (11,5,'Overview','Overview','<p>Widget designer settings overview</p>','/widget/settings/index',2,NULL,1,1);

/*Table structure for table `dlayer_setting_group` */

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

insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values (1,'App',7,'Dlayer settings','Dlayer','/dlayer/settings/index',1,1);
insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values (2,'Template',1,'Template designer settings','Template designer','/template/settings/index',2,1);
insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values (3,'Content',4,'Content designer settings','Content manager','/content/settings/index',3,1);
insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values (4,'Form',3,'Form builder settings','Form builder','/form/settings/index',4,1);
insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values (5,'Widget',2,'Widget designer settings','Widget designer','/widget/settings/index',5,1);
insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values (6,'Web site',5,'Web site designer settings','Web site manager','/website/settings/index',7,1);
insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values (7,'Question',6,'Question manager settings','Question manager','/question/settings/index',6,1);
insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values (8,'Image',8,'Image library settings','Image library','/image/settings/index',8,1);

/*Table structure for table `dlayer_setting_scope` */

CREATE TABLE `dlayer_setting_scope` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_setting_scope` */

insert  into `dlayer_setting_scope`(`id`,`scope`) values (1,'App');
insert  into `dlayer_setting_scope`(`id`,`scope`) values (2,'Module');
insert  into `dlayer_setting_scope`(`id`,`scope`) values (3,'Tool');

/*Table structure for table `user_setting_color_history` */

CREATE TABLE `user_setting_color_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_setting_color_history_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_color_history` */

insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (1,1,'#337ab7');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (2,1,'#5cb85c');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (3,1,'#555555');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (4,1,'#EEEEEE');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (5,1,'#f0ad4e');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (6,2,'#337ab7');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (7,2,'#5cb85c');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (8,2,'#555555');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (9,2,'#EEEEEE');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (10,2,'#f0ad4e');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (13,3,'#337ab7');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (14,3,'#5cb85c');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (15,3,'#555555');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (16,3,'#EEEEEE');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (17,3,'#f0ad4e');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (25,1,'#f0ad4e');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (26,1,'#337ab7');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (27,1,'#777777');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (28,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (29,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (30,2,'#5bc0de');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (31,2,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (32,3,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (33,1,'#777777');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (34,1,'#777777');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (35,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (36,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (37,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (38,1,'#337ab7');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (39,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (40,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (41,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (42,1,'#f0ad4e');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (43,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (44,1,'#f0ad4e');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (45,1,'#5cb85c');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (46,1,'#5cb85c');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (47,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (48,1,'#5cb85c');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (49,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (50,1,'#337ab7');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (51,1,'#555555');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (52,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (53,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (54,1,'#777777');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (55,1,'#777777');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (56,1,'#f0ad4e');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (57,1,'#777777');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (58,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (59,1,'#777777');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (60,1,'#5cb85c');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (61,1,'#777777');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (62,1,'#777777');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (63,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (64,1,'#5cb85c');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (65,1,'#337ab7');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (66,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (67,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (68,1,'#337ab7');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (69,1,'#eeeeee');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (70,1,'#d9534f');
insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (71,1,'#eeeeee');

/*Table structure for table `user_setting_color_palette` */

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_color_palette` */

insert  into `user_setting_color_palette`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values (1,1,'Palette 1','palette-1',1);
insert  into `user_setting_color_palette`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values (2,1,'Palette 2','palette-2',2);
insert  into `user_setting_color_palette`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values (3,2,'Palette 1','palette-1',1);
insert  into `user_setting_color_palette`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values (4,2,'Palette 2','palette-2',2);
insert  into `user_setting_color_palette`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values (5,3,'Palette 1','palette-1',1);
insert  into `user_setting_color_palette`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values (6,3,'Palette 2','palette-2',2);

/*Table structure for table `user_setting_color_palette_color` */

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_color_palette_color` */

insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (1,1,1,1,'Black','#000000');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (2,1,1,2,'Dark grey','#333333');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (3,1,1,3,'Grey','#555555');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (4,1,1,4,'Light grey','#777777');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (5,1,1,5,'Off white','#EEEEEE');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (6,1,2,1,'Blue','#337ab7');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (7,1,2,2,'Green','#5cb85c');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (8,1,2,3,'Light blue','#5bc0de');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (9,1,2,4,'Amber','#f0ad4e');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (10,1,2,5,'Red','#d9534f');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (11,2,3,1,'Black','#000000');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (12,2,3,2,'Dark grey','#333333');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (13,2,3,3,'Grey','#555555');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (14,2,3,4,'Light grey','#777777');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (15,2,3,5,'Off white','#EEEEEE');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (18,2,4,1,'Blue','#337ab7');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (19,2,4,2,'Green','#5cb85c');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (20,2,4,3,'Light blue','#5bc0de');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (21,2,4,4,'Amber','#f0ad4e');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (22,2,4,5,'Red','#d9534f');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (25,3,5,1,'Black','#000000');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (26,3,5,2,'Dark grey','#333333');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (27,3,5,3,'Grey','#555555');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (28,3,5,4,'Light grey','#777777');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (29,3,5,5,'Off white','#EEEEEE');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (34,3,6,3,'Light blue','#5bc0de');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (35,3,6,4,'Amber','#f0ad4e');
insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (36,3,6,5,'Red','#d9534f');

/*Table structure for table `user_setting_font_family` */

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_font_family` */

insert  into `user_setting_font_family`(`id`,`site_id`,`module_id`,`font_family_id`) values (1,1,3,8);
insert  into `user_setting_font_family`(`id`,`site_id`,`module_id`,`font_family_id`) values (2,1,4,1);
insert  into `user_setting_font_family`(`id`,`site_id`,`module_id`,`font_family_id`) values (3,2,3,1);
insert  into `user_setting_font_family`(`id`,`site_id`,`module_id`,`font_family_id`) values (4,2,4,1);
insert  into `user_setting_font_family`(`id`,`site_id`,`module_id`,`font_family_id`) values (5,3,3,1);
insert  into `user_setting_font_family`(`id`,`site_id`,`module_id`,`font_family_id`) values (6,3,4,1);

/*Table structure for table `user_setting_heading` */

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_heading` */

insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (1,1,1,1,4,1,36,'#000000',1);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (2,1,2,1,4,1,30,'#000000',2);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (3,1,3,1,4,1,24,'#000000',3);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (4,1,4,1,4,1,18,'#000000',4);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (5,1,5,1,4,1,14,'#000000',5);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (6,1,6,1,4,1,12,'#000000',6);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (7,2,1,1,4,1,36,'#000000',1);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (8,2,2,1,4,1,30,'#000000',2);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (9,2,3,1,4,1,24,'#000000',3);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (10,2,4,1,4,1,18,'#000000',4);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (11,2,5,1,4,1,14,'#000000',5);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (12,2,6,1,4,1,12,'#000000',6);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (13,3,1,1,4,1,36,'#000000',1);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (14,3,2,1,4,1,30,'#000000',2);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (15,3,3,1,4,1,24,'#000000',3);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (16,3,4,1,4,1,18,'#000000',4);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (17,3,5,1,4,1,14,'#000000',5);
insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (18,3,6,1,4,1,12,'#000000',6);

/*Table structure for table `user_site` */

CREATE TABLE `user_site` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `identity_id` (`identity_id`),
  CONSTRAINT `user_site_ibfk_1` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identity` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site` */

insert  into `user_site`(`id`,`identity_id`,`name`) values (1,1,'Sample site 1');
insert  into `user_site`(`id`,`identity_id`,`name`) values (2,2,'Sample site 1');
insert  into `user_site`(`id`,`identity_id`,`name`) values (3,3,'Sample site 1');

/*Table structure for table `user_site_content_heading` */

CREATE TABLE `user_site_content_heading` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name to identity content',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_content_heading_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_heading` */

insert  into `user_site_content_heading`(`id`,`site_id`,`name`,`content`) values (1,1,'Intro content title','This is a content title-:-Sub title for content title');
insert  into `user_site_content_heading`(`id`,`site_id`,`name`,`content`) values (2,2,'Intro content title','Content title-:-Content sub title');
insert  into `user_site_content_heading`(`id`,`site_id`,`name`,`content`) values (3,3,'Intro content title','Content title-:-Content sub title');

/*Table structure for table `user_site_content_jumbotron` */

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

insert  into `user_site_content_jumbotron`(`id`,`site_id`,`name`,`content`) values (1,1,'Page masthead','Welcome to my site-:-Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est.');
insert  into `user_site_content_jumbotron`(`id`,`site_id`,`name`,`content`) values (2,2,'Page masthead','Welcome to my site-:-Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est.');
insert  into `user_site_content_jumbotron`(`id`,`site_id`,`name`,`content`) values (3,3,'Page masthead','Welcome to my site-:-Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus.');

/*Table structure for table `user_site_content_text` */

CREATE TABLE `user_site_content_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name so user can identity content',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_content_text_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_text` */

insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (1,1,'Page intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum.');
insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (2,1,'Page text one','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum. Maecenas a nisl sollicitudin, ullamcorper arcu et, iaculis erat. Nulla et sapien ut elit sodales blandit. Donec ut turpis mattis, tempor ipsum eu, vehicula diam. Quisque eleifend rhoncus molestie. Suspendisse interdum ante vitae justo rutrum, in ullamcorper magna maximus. Mauris ut erat dolor. In non lobortis tellus. Etiam laoreet at mauris eget facilisis. In eu tortor vitae augue porttitor tincidunt porttitor pretium ex. Cras eu ex neque.');
insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (3,1,'Page text two','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum. Maecenas a nisl sollicitudin, ullamcorper arcu et, iaculis erat. Nulla et sapien ut elit sodales blandit. Donec ut turpis mattis, tempor ipsum eu, vehicula diam. Quisque eleifend rhoncus molestie. Suspendisse interdum ante vitae justo rutrum, in ullamcorper magna maximus. Mauris ut erat dolor. In non lobortis tellus. Etiam laoreet at mauris eget facilisis. In eu tortor vitae augue porttitor tincidunt porttitor pretium ex. Cras eu ex neque.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum. Maecenas a nisl sollicitudin, ullamcorper arcu et, iaculis erat. Nulla et sapien ut elit sodales blandit. Donec ut turpis mattis, tempor ipsum eu, vehicula diam. Quisque eleifend rhoncus molestie. Suspendisse interdum ante vitae justo rutrum, in ullamcorper magna maximus. Mauris ut erat dolor. In non lobortis tellus. Etiam laoreet at mauris eget facilisis. In eu tortor vitae augue porttitor tincidunt porttitor pretium ex. Cras eu ex neque.');
insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (4,2,'Intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat');
insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (5,2,'Page text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat. Integer viverra, arcu nec condimentum elementum, justo ipsum gravida eros, nec efficitur nulla quam vel massa. Nulla faucibus lorem purus, at commodo dolor ultrices luctus. Cras dapibus eget sapien a mollis. Curabitur vulputate pulvinar sapien, ac tristique mi mattis id.\r\n\r\nPellentesque at finibus felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut a mauris id nisl placerat pretium. Maecenas quam urna, rhoncus quis ipsum id, pharetra molestie odio. Praesent malesuada ornare nunc, at egestas nulla porttitor eget. Vestibulum in purus in nisi consectetur vulputate imperdiet at urna. Pellentesque consectetur hendrerit urna quis accumsan. Etiam tempus nisl ac nisi sollicitudin, at lacinia eros blandit. Nulla porttitor mauris a nisl pretium, sit amet hendrerit nisi suscipit. Proin egestas, eros id tempus pulvinar, nunc libero finibus magna, eget egestas lorem mi non quam.');
insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (6,3,'Intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat.');
insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (7,3,'Page text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat. Integer viverra, arcu nec condimentum elementum, justo ipsum gravida eros, nec efficitur nulla quam vel massa. Nulla faucibus lorem purus, at commodo dolor ultrices luctus. Cras dapibus eget sapien a mollis. Curabitur vulputate pulvinar sapien, ac tristique mi mattis id.\r\n\r\nPellentesque at finibus felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut a mauris id nisl placerat pretium. Maecenas quam urna, rhoncus quis ipsum id, pharetra molestie odio. Praesent malesuada ornare nunc, at egestas nulla porttitor eget. Vestibulum in purus in nisi consectetur vulputate imperdiet at urna. Pellentesque consectetur hendrerit urna quis accumsan. Etiam tempus nisl ac nisi sollicitudin, at lacinia eros blandit. Nulla porttitor mauris a nisl pretium, sit amet hendrerit nisi suscipit. Proin egestas, eros id tempus pulvinar, nunc libero finibus magna, eget egestas lorem mi non quam.');
insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (8,1,'Page intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum.');
insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (9,2,'Intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien.');
insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (10,3,'Intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris.');

/*Table structure for table `user_site_form` */

CREATE TABLE `user_site_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form` */

insert  into `user_site_form`(`id`,`site_id`,`name`,`email`) values (1,1,'Contact form','email@email.com');
insert  into `user_site_form`(`id`,`site_id`,`name`,`email`) values (2,1,'Subscribe','email@email.com');
insert  into `user_site_form`(`id`,`site_id`,`name`,`email`) values (3,2,'Contact form','email@email.com');
insert  into `user_site_form`(`id`,`site_id`,`name`,`email`) values (4,2,'Subscribe','email@email.com');
insert  into `user_site_form`(`id`,`site_id`,`name`,`email`) values (5,3,'Contact form','email@email.com');
insert  into `user_site_form`(`id`,`site_id`,`name`,`email`) values (6,3,'Subscribe','email@email.com');

/*Table structure for table `user_site_form_field` */

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field` */

insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (1,1,1,1,12,'Your name','Please enter your name',2);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (2,1,1,4,45,'Your email','Please enter your email address',1);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (3,1,1,2,13,'Comment','Please enter your comment',3);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (4,1,2,1,12,'Your name','Please enter your name',1);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (5,1,2,4,45,'Your email','Please enter your email address',2);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (6,2,3,1,12,'Your name','Please enter your name',1);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (7,2,3,4,45,'Your email','Please enter your email address',2);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (8,2,3,2,13,'Comment','Please enter your comment',3);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (9,2,4,1,12,'Your name','Please enter your name',1);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (10,2,4,4,45,'Your email','Please enter your email address',2);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (11,3,5,1,12,'Your name','Please enter your name',1);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (12,3,5,4,45,'Your email','Please enter your email address',2);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (13,3,5,2,13,'Comment','Please enter your comment',3);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (14,3,6,1,12,'Your name','Please enter your name',1);
insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (15,3,6,4,45,'Your email','Please enter your email address',2);

/*Table structure for table `user_site_form_field_attribute` */

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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field_attribute` */

insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (1,1,1,1,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (2,1,1,1,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (3,1,1,1,7,'Enter your name');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (4,1,1,2,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (5,1,1,2,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (6,1,1,2,7,'Enter your email');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (7,1,1,3,3,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (8,1,1,3,4,'3');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (9,1,1,3,8,'Dlayer is starting to look interesting');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (10,1,2,4,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (11,1,2,4,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (12,1,2,4,7,'Enter your name');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (13,1,2,5,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (14,1,2,5,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (15,1,2,5,7,'Enter your email');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (16,2,3,6,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (17,2,3,6,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (18,2,3,6,7,'Enter your name');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (19,2,3,7,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (20,2,3,7,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (21,2,3,7,7,'Enter your email');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (22,2,3,8,3,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (23,2,3,8,4,'3');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (24,2,3,8,8,'Dlayer is starting to look interesting');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (25,2,4,9,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (26,2,4,9,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (27,2,4,9,7,'Enter your name');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (28,2,4,10,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (29,2,4,10,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (30,2,4,10,7,'Enter your email');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (31,3,5,11,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (32,3,5,11,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (33,3,5,11,7,'Enter your name');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (34,3,5,12,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (35,3,5,12,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (36,3,5,12,7,'Enter your email');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (37,3,5,13,3,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (38,3,5,13,4,'3');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (39,3,5,13,8,'Dlayer is starting to look interesting');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (40,3,6,14,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (41,3,6,14,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (42,3,6,14,7,'Enter your name');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (43,3,6,15,1,'40');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (44,3,6,15,2,'255');
insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (45,3,6,15,7,'Enter your email');

/*Table structure for table `user_site_form_field_row_background_color` */

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field_row_background_color` */

insert  into `user_site_form_field_row_background_color`(`id`,`site_id`,`form_id`,`field_id`,`color_hex`) values (2,1,1,2,'#eeeeee');
insert  into `user_site_form_field_row_background_color`(`id`,`site_id`,`form_id`,`field_id`,`color_hex`) values (4,1,2,4,'#eeeeee');

/*Table structure for table `user_site_form_layout` */

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_layout` */

insert  into `user_site_form_layout`(`id`,`site_id`,`form_id`,`title`,`sub_title`,`submit_label`,`reset_label`,`layout_id`,`horizontal_width_label`,`horizontal_width_field`) values (1,1,2,'Subscribe','Enter your details to be added to the subscription list','Subscribe','',3,2,10);
insert  into `user_site_form_layout`(`id`,`site_id`,`form_id`,`title`,`sub_title`,`submit_label`,`reset_label`,`layout_id`,`horizontal_width_label`,`horizontal_width_field`) values (2,1,1,'Contact','Complete the form to contact us','Send','Reset',1,2,10);
insert  into `user_site_form_layout`(`id`,`site_id`,`form_id`,`title`,`sub_title`,`submit_label`,`reset_label`,`layout_id`,`horizontal_width_label`,`horizontal_width_field`) values (3,2,4,'Subscribe','Subscribe to our newsletter','Subscribe','',3,2,10);
insert  into `user_site_form_layout`(`id`,`site_id`,`form_id`,`title`,`sub_title`,`submit_label`,`reset_label`,`layout_id`,`horizontal_width_label`,`horizontal_width_field`) values (4,2,3,'Contact','Complete the form to contact us','Send','Reset',1,2,10);
insert  into `user_site_form_layout`(`id`,`site_id`,`form_id`,`title`,`sub_title`,`submit_label`,`reset_label`,`layout_id`,`horizontal_width_label`,`horizontal_width_field`) values (5,3,6,'Subscribe','Subscribe to our newsletter','Subscribe','',3,2,10);
insert  into `user_site_form_layout`(`id`,`site_id`,`form_id`,`title`,`sub_title`,`submit_label`,`reset_label`,`layout_id`,`horizontal_width_label`,`horizontal_width_field`) values (6,3,5,'Contact','Complete the form to contact us','Send','Reset',1,2,10);

/*Table structure for table `user_site_form_setting` */

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_setting` */

insert  into `user_site_form_setting`(`id`,`site_id`,`form_id`,`width`,`legend`,`button`) values (1,1,1,500,'Contact me','Save');
insert  into `user_site_form_setting`(`id`,`site_id`,`form_id`,`width`,`legend`,`button`) values (2,1,2,600,'Subscribe to my newlestter','Subscribe');
insert  into `user_site_form_setting`(`id`,`site_id`,`form_id`,`width`,`legend`,`button`) values (3,2,3,600,'My form','Save');
insert  into `user_site_form_setting`(`id`,`site_id`,`form_id`,`width`,`legend`,`button`) values (4,2,4,600,'Subscribe to my newlestter','Subscribe');
insert  into `user_site_form_setting`(`id`,`site_id`,`form_id`,`width`,`legend`,`button`) values (5,3,5,600,'My form','Save');
insert  into `user_site_form_setting`(`id`,`site_id`,`form_id`,`width`,`legend`,`button`) values (6,3,6,600,'Subscribe to my newlestter','Subscribe');

/*Table structure for table `user_site_history` */

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

insert  into `user_site_history`(`id`,`identity_id`,`site_id`) values (1,1,1);
insert  into `user_site_history`(`id`,`identity_id`,`site_id`) values (2,2,2);
insert  into `user_site_history`(`id`,`identity_id`,`site_id`) values (3,3,3);

/*Table structure for table `user_site_image_library` */

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

insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (1,1,'Autumn path','Public domain image.',1,1);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (2,1,'Downtown Boston','Public domain image.',1,1);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (3,1,'Horses','Public domain image.',4,4);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (4,1,'Old lantern and brush','Public domain image.',1,1);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (5,1,'Robin','Public domain image.',4,4);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (6,1,'Signs','Public domain image.',1,1);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (7,1,'Spring coffee','Public domain image.',1,1);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (8,3,'Autumn path','Public domain image.',3,3);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (9,3,'Downtown Boston','Public domain image.',3,3);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (10,3,'Horses','Public domain image.',3,3);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (11,3,'Old lantern and brush','Public domain image.',3,3);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (12,3,'Robin','Public domain image.',3,3);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (13,3,'Signs','Public domain image.',3,3);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (14,3,'Spring coffee','Public domain image.',3,3);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (15,2,'Autumn path','Public domain image.',2,2);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (16,2,'Downtown Boston','Public domain image.',2,2);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (17,2,'Horses','Public domain image.',2,2);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (18,2,'Old lantern and brush','Public domain image.',2,2);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (19,2,'Robin','Public domain image.',2,2);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (20,2,'Signs','Public domain image.',2,2);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (21,2,'Spring coffee','Public domain image.',2,2);
insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (22,1,'Autumn path - Clone','Clone or original image.',1,1);

/*Table structure for table `user_site_image_library_category` */

CREATE TABLE `user_site_image_library_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_image_library_category_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_category` */

insert  into `user_site_image_library_category`(`id`,`site_id`,`name`) values (1,1,'Uncategorised');
insert  into `user_site_image_library_category`(`id`,`site_id`,`name`) values (2,2,'Uncategorised');
insert  into `user_site_image_library_category`(`id`,`site_id`,`name`) values (3,3,'Uncategorised');
insert  into `user_site_image_library_category`(`id`,`site_id`,`name`) values (4,1,'Animals');

/*Table structure for table `user_site_image_library_link` */

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

insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (1,1,1,1);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (2,1,2,2);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (3,1,3,3);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (4,1,4,4);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (5,1,5,5);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (6,1,6,6);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (7,1,7,23);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (8,3,8,8);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (9,3,9,9);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (10,3,10,10);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (11,3,11,11);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (12,3,12,12);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (13,3,13,13);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (14,3,14,14);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (15,2,15,15);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (16,2,16,16);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (17,2,17,17);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (18,2,18,18);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (19,2,19,19);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (20,2,20,20);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (21,2,21,21);
insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (22,1,22,22);

/*Table structure for table `user_site_image_library_sub_category` */

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

insert  into `user_site_image_library_sub_category`(`id`,`site_id`,`category_id`,`name`) values (1,1,1,'Misc.');
insert  into `user_site_image_library_sub_category`(`id`,`site_id`,`category_id`,`name`) values (2,2,2,'Misc.');
insert  into `user_site_image_library_sub_category`(`id`,`site_id`,`category_id`,`name`) values (3,3,3,'Misc.');
insert  into `user_site_image_library_sub_category`(`id`,`site_id`,`category_id`,`name`) values (4,1,4,'Misc.');

/*Table structure for table `user_site_image_library_version` */

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

insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (1,1,1,'2015-04-22 12:21:09',25,1);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (2,1,2,'2015-04-22 12:21:45',25,1);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (3,1,3,'2015-04-22 12:22:06',25,1);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (4,1,4,'2015-04-22 12:22:28',25,1);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (5,1,5,'2015-04-22 12:22:54',25,1);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (6,1,6,'2015-04-22 12:23:17',25,1);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (7,1,7,'2015-04-22 12:23:39',25,1);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (8,3,8,'2015-04-22 12:29:00',25,3);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (9,3,9,'2015-04-22 12:29:18',25,3);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (10,3,10,'2015-04-22 12:29:31',25,3);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (11,3,11,'2015-04-22 12:29:41',25,3);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (12,3,12,'2015-04-22 12:29:53',25,3);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (13,3,13,'2015-04-22 12:30:08',25,3);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (14,3,14,'2015-04-22 12:30:24',25,3);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (15,2,15,'2015-04-22 12:30:55',25,2);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (16,2,16,'2015-04-22 12:31:08',25,2);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (17,2,17,'2015-04-22 12:31:22',25,2);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (18,2,18,'2015-04-22 12:31:35',25,2);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (19,2,19,'2015-04-22 12:31:50',25,2);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (20,2,20,'2015-04-22 12:32:02',25,2);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (21,2,21,'2015-04-22 12:32:15',25,2);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (22,1,22,'2015-04-22 12:39:27',29,1);
insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (23,1,7,'2015-04-22 12:47:14',30,1);

/*Table structure for table `user_site_image_library_version_meta` */

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

insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (1,1,1,1,'.jpg','image/jpeg',615,453,173442);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (2,1,2,2,'.jpg','image/jpeg',615,461,124479);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (3,1,3,3,'.jpg','image/jpeg',615,389,42910);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (4,1,4,4,'.jpg','image/jpeg',615,410,51533);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (5,1,5,5,'.jpg','image/jpeg',615,407,32763);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (6,1,6,6,'.jpg','image/jpeg',615,461,49367);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (7,1,7,7,'.jpg','image/jpeg',615,410,47362);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (8,3,8,8,'.jpg','image/jpeg',615,453,173442);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (9,3,9,9,'.jpg','image/jpeg',615,461,124479);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (10,3,10,10,'.jpg','image/jpeg',615,389,42910);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (11,3,11,11,'.jpg','image/jpeg',615,410,51533);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (12,3,12,12,'.jpg','image/jpeg',615,407,32763);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (13,3,13,13,'.jpg','image/jpeg',615,461,49367);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (14,3,14,14,'.jpg','image/jpeg',615,410,47362);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (15,2,15,15,'.jpg','image/jpeg',615,453,173442);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (16,2,16,16,'.jpg','image/jpeg',615,461,124479);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (17,2,17,17,'.jpg','image/jpeg',615,389,42910);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (18,2,18,18,'.jpg','image/jpeg',615,410,51533);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (19,2,19,19,'.jpg','image/jpeg',615,407,32763);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (20,2,20,20,'.jpg','image/jpeg',615,461,49367);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (21,2,21,21,'.jpg','image/jpeg',615,410,47362);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (22,1,22,22,'.jpg','image/jpeg',615,453,173442);
insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (23,1,7,23,'.jpg','image/jpeg',561,367,42624);

/*Table structure for table `user_site_page` */

CREATE TABLE `user_site_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_site_pages_ibfk_2` (`template_id`),
  CONSTRAINT `user_site_page_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_template` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page` */

insert  into `user_site_page`(`id`,`site_id`,`template_id`,`name`,`title`,`description`) values (1,1,1,'Doodling','Showcasing content items','Displays all the current content items');
insert  into `user_site_page`(`id`,`site_id`,`template_id`,`name`,`title`,`description`) values (2,2,2,'Doodling','Showcasing content items','Displays all the current content items');
insert  into `user_site_page`(`id`,`site_id`,`template_id`,`name`,`title`,`description`) values (3,3,3,'Doodling','Showcasing content items','Displays all current content items');

/*Table structure for table `user_site_page_content_item` */

CREATE TABLE `user_site_page_content_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_row_id` int(11) unsigned NOT NULL,
  `content_type` int(11) unsigned NOT NULL,
  `sort_order` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_type` (`content_type`),
  KEY `sort_order` (`sort_order`),
  KEY `div_id` (`content_row_id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_page_content_item_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_setting_heading` (`id`),
  CONSTRAINT `user_site_page_content_item_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page_content_item` (`id`),
  CONSTRAINT `user_site_page_content_item_ibfk_3` FOREIGN KEY (`content_row_id`) REFERENCES `user_site_page_content_rows` (`id`),
  CONSTRAINT `user_site_page_content_item_ibfk_4` FOREIGN KEY (`content_type`) REFERENCES `designer_content_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item` */

insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (1,1,1,1,4,1);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (2,1,1,2,2,1);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (3,1,1,2,1,2);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (4,1,1,3,1,1);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (5,1,1,3,3,2);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (6,2,2,5,4,1);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (7,2,2,6,2,1);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (8,2,2,6,1,3);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (9,2,2,7,1,1);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (10,2,2,7,3,2);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (11,3,3,9,4,1);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (12,3,3,10,2,1);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (13,3,3,10,1,2);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (14,3,3,11,1,1);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (15,3,3,11,3,2);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (16,1,1,2,5,3);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (17,2,2,6,5,2);
insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (18,3,3,10,5,3);

/*Table structure for table `user_site_page_content_item_form` */

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
  CONSTRAINT `user_site_page_content_item_form_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`),
  CONSTRAINT `user_site_page_content_item_form_ibfk_4` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_form` */

insert  into `user_site_page_content_item_form`(`id`,`site_id`,`page_id`,`content_id`,`form_id`) values (1,1,1,5,1);
insert  into `user_site_page_content_item_form`(`id`,`site_id`,`page_id`,`content_id`,`form_id`) values (2,2,2,10,3);
insert  into `user_site_page_content_item_form`(`id`,`site_id`,`page_id`,`content_id`,`form_id`) values (3,3,3,15,5);

/*Table structure for table `user_site_page_content_item_heading` */

CREATE TABLE `user_site_page_content_item_heading` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `heading_id` tinyint(3) unsigned NOT NULL,
  `data_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `site_id` (`site_id`),
  KEY `heading_id` (`heading_id`),
  KEY `data_id` (`data_id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_4` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_heading` (`id`),
  CONSTRAINT `user_site_page_content_item_heading_ibfk_5` FOREIGN KEY (`heading_id`) REFERENCES `designer_content_heading` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_heading` */

insert  into `user_site_page_content_item_heading`(`id`,`site_id`,`page_id`,`content_id`,`heading_id`,`data_id`) values (1,1,1,2,2,1);
insert  into `user_site_page_content_item_heading`(`id`,`site_id`,`page_id`,`content_id`,`heading_id`,`data_id`) values (2,2,2,7,2,2);
insert  into `user_site_page_content_item_heading`(`id`,`site_id`,`page_id`,`content_id`,`heading_id`,`data_id`) values (3,3,3,12,2,3);

/*Table structure for table `user_site_page_content_item_image` */

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
  KEY `content_id` (`content_id`),
  KEY `version_id` (`version_id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_4` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_version` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_image` */

insert  into `user_site_page_content_item_image`(`id`,`site_id`,`page_id`,`content_id`,`version_id`,`expand`,`caption`) values (1,1,1,16,23,1,'Caption for this image.');
insert  into `user_site_page_content_item_image`(`id`,`site_id`,`page_id`,`content_id`,`version_id`,`expand`,`caption`) values (2,2,2,17,15,1,'Caption for this image.');
insert  into `user_site_page_content_item_image`(`id`,`site_id`,`page_id`,`content_id`,`version_id`,`expand`,`caption`) values (3,3,3,18,11,1,'Caption for this image.');

/*Table structure for table `user_site_page_content_item_jumbotron` */

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
  CONSTRAINT `user_site_page_content_item_jumbotron_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`),
  CONSTRAINT `user_site_page_content_item_jumbotron_ibfk_4` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_jumbotron` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_jumbotron` */

insert  into `user_site_page_content_item_jumbotron`(`id`,`site_id`,`page_id`,`content_id`,`data_id`,`button_label`) values (1,1,1,1,1,'Useless button');
insert  into `user_site_page_content_item_jumbotron`(`id`,`site_id`,`page_id`,`content_id`,`data_id`,`button_label`) values (2,2,2,6,2,'Useless button');
insert  into `user_site_page_content_item_jumbotron`(`id`,`site_id`,`page_id`,`content_id`,`data_id`,`button_label`) values (3,3,3,11,3,'Useless button');

/*Table structure for table `user_site_page_content_item_size` */

CREATE TABLE `user_site_page_content_item_size` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `size` tinyint(3) unsigned NOT NULL DEFAULT '12',
  `offset` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `user_site_page_content_item_size_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_size_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_size_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_size` */

insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (1,1,1,4,6,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (2,1,1,5,6,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (3,2,2,9,6,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (4,2,2,10,6,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (5,3,3,14,6,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (6,3,3,15,6,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (7,1,1,1,12,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (8,1,1,3,9,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (9,1,1,2,12,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (10,2,2,8,9,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (11,3,3,13,9,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (12,1,1,16,3,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (13,2,2,17,3,0);
insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (14,3,3,18,3,0);

/*Table structure for table `user_site_page_content_item_text` */

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
  CONSTRAINT `user_site_page_content_item_text_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`),
  CONSTRAINT `user_site_page_content_item_text_ibfk_4` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_text` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_text` */

insert  into `user_site_page_content_item_text`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values (1,1,1,3,8);
insert  into `user_site_page_content_item_text`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values (2,1,1,4,3);
insert  into `user_site_page_content_item_text`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values (3,2,2,8,9);
insert  into `user_site_page_content_item_text`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values (4,2,2,9,5);
insert  into `user_site_page_content_item_text`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values (5,3,3,13,10);
insert  into `user_site_page_content_item_text`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values (6,3,3,14,7);

/*Table structure for table `user_site_page_content_rows` */

CREATE TABLE `user_site_page_content_rows` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `sort_order` int(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `div_id` (`div_id`),
  CONSTRAINT `user_site_page_content_rows_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_rows_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_rows_ibfk_3` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_div` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_rows` */

insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (1,1,1,2,1);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (2,1,1,3,1);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (3,1,1,3,2);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (4,1,1,3,3);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (5,2,2,6,1);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (6,2,2,7,1);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (7,2,2,7,2);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (8,2,2,7,3);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (9,3,3,10,1);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (10,3,3,11,1);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (11,3,3,11,2);
insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (12,3,3,11,3);

/*Table structure for table `user_site_page_styles_area_background_color` */

CREATE TABLE `user_site_page_styles_area_background_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_area_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_area_id` (`content_area_id`),
  CONSTRAINT `user_site_page_styles_area_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_styles_area_background_color_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_styles_area_background_color_ibfk_3` FOREIGN KEY (`content_area_id`) REFERENCES `user_site_template_div` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styles_area_background_color` */

/*Table structure for table `user_site_page_styles_container_background_color` */

CREATE TABLE `user_site_page_styles_container_background_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `user_site_page_styles_container_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_styles_container_background_color_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_styles_container_background_color_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styles_container_background_color` */

insert  into `user_site_page_styles_container_background_color`(`id`,`site_id`,`page_id`,`content_id`,`color_hex`) values (2,1,1,3,'#eeeeee');
insert  into `user_site_page_styles_container_background_color`(`id`,`site_id`,`page_id`,`content_id`,`color_hex`) values (3,2,2,8,'#eeeeee');
insert  into `user_site_page_styles_container_background_color`(`id`,`site_id`,`page_id`,`content_id`,`color_hex`) values (4,3,3,13,'#eeeeee');

/*Table structure for table `user_site_page_styles_item_background_color` */

CREATE TABLE `user_site_page_styles_item_background_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `user_site_page_styles_item_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_styles_item_background_color_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_styles_item_background_color_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styles_item_background_color` */

insert  into `user_site_page_styles_item_background_color`(`id`,`site_id`,`page_id`,`content_id`,`color_hex`) values (1,1,1,1,'#eeeeee');

/*Table structure for table `user_site_page_styles_row_background_color` */

CREATE TABLE `user_site_page_styles_row_background_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_row_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_row_id` (`content_row_id`),
  CONSTRAINT `user_site_page_styles_row_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_styles_row_background_color_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_styles_row_background_color_ibfk_3` FOREIGN KEY (`content_row_id`) REFERENCES `user_site_page_content_rows` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styles_row_background_color` */

/*Table structure for table `user_site_template` */

CREATE TABLE `user_site_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_template_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template` */

insert  into `user_site_template`(`id`,`site_id`,`name`) values (1,1,'Sample template');
insert  into `user_site_template`(`id`,`site_id`,`name`) values (2,2,'Sample template');
insert  into `user_site_template`(`id`,`site_id`,`name`) values (3,3,'Sample template');

/*Table structure for table `user_site_template_div` */

CREATE TABLE `user_site_template_div` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Parent, always set, base divs have a parent_id of 0',
  `sort_order` int(11) unsigned NOT NULL DEFAULT '1' COMMENT 'Sort order within grouping',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `sort_order` (`sort_order`),
  KEY `site_id` (`site_id`),
  KEY `template_id` (`template_id`),
  CONSTRAINT `user_site_template_div_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_template_div_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_template` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div` */

insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (1,1,1,0,1);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (2,1,1,1,1);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (3,1,1,1,2);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (4,1,1,1,3);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (5,2,2,0,1);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (6,2,2,5,1);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (7,2,2,5,2);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (8,2,2,5,3);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (9,3,3,0,1);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (10,3,3,9,1);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (11,3,3,9,2);
insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (12,3,3,9,3);

/*Table structure for table `user_site_template_div_size` */

CREATE TABLE `user_site_template_div_size` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `width` int(4) NOT NULL DEFAULT '0',
  `height` int(4) NOT NULL DEFAULT '0',
  `design_height` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`),
  KEY `div_id` (`div_id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_template_div_size_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_template` (`id`),
  CONSTRAINT `user_site_template_div_size_ibfk_3` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_div` (`id`),
  CONSTRAINT `user_site_template_div_size_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_size` */

insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (1,1,1,1,996,0,0);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (2,1,1,2,996,0,150);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (3,1,1,3,996,0,400);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (4,1,1,4,996,0,150);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (5,2,2,5,996,0,0);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (6,2,2,6,996,0,150);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (7,2,2,7,996,0,400);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (8,2,2,8,996,0,150);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (9,3,3,9,996,0,0);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (10,3,3,10,996,0,150);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (11,3,3,11,996,0,400);
insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (12,3,3,12,996,0,150);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
