/*
SQLyog Enterprise v11.21 (32 bit)
MySQL - 5.6.13 : Database - dlayer
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

/*Table structure for table `designer_content_headings` */

DROP TABLE IF EXISTS `designer_content_headings`;

CREATE TABLE `designer_content_headings` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_headings` */

insert  into `designer_content_headings`(`id`,`name`,`tag`,`sort_order`,`enabled`) values (1,'Page title','h1',1,1),(2,'Heading 1','h2',2,1),(3,'Heading 2','h3',3,1),(4,'Heading 3','h4',4,1),(5,'Heading 4','h5',5,1),(6,'Heading 5','h6',6,1),(7,'Heading 6','h7',7,1);

/*Table structure for table `designer_content_types` */

DROP TABLE IF EXISTS `designer_content_types`;

CREATE TABLE `designer_content_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_types` */

insert  into `designer_content_types`(`id`,`name`,`description`,`enabled`) values (1,'text','Text block',1),(2,'heading','Heading',1);

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

/*Table structure for table `dlayer_development_log` */

DROP TABLE IF EXISTS `dlayer_development_log`;

CREATE TABLE `dlayer_development_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `change` text COLLATE utf8_unicode_ci NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_development_log` */

insert  into `dlayer_development_log`(`id`,`change`,`added`,`enabled`) values (1,'Added a development log to Dlayer to show changes to the application, two reasons, one to spur on my development, two, to show the public what I am adding.','2013-04-05 00:38:16',1),(2,'Added a pagination view helper, update of my existing pagination view helper.','2013-04-05 00:38:52',1),(6,'Added a helper class to the library, initially only a couple of static helper functions.','2013-04-08 01:20:22',1),(7,'Updated the pagination view helper, added the ability to define text to use for links and also updated the logic for \'of n\' text.','2013-04-08 02:03:42',1),(8,'Updated the default styling for tables, header rows and table rows.','2013-04-08 02:19:22',1),(9,'Added the form for the add text field tool in the forms builder.','2013-04-12 18:15:57',1),(10,'Updated the base forms class, addElementsToForm() method updated, now able to create multiple fieldsets within a form, one fieldset per method call','2013-04-14 18:18:04',1),(11,'Updated all the help text for the template designer, simpler language.','2013-04-16 18:19:34',1),(12,'Added the form for the add textarea tool in the forms builder.','2013-04-20 18:20:36',1),(13,'Updated the pagination view helper, can now show either \'item n-m of o\' or \'page n of m\' between the next and previous links.','2013-04-21 18:46:50',1),(14,'Added base tool process model for the form builder, working on the add text field process tool model.','2013-04-25 01:37:41',1),(16,'Text field can now be added to a form in the form builder, still need to add supporting for editing a field.','2013-05-04 22:44:24',1),(17,'Text area field can now be added to the form, edit mode still needs to be added.','2013-05-12 02:27:58',1),(18,'Form builder now supports and displayed text area fields which have been added to the form defintion.','2013-05-12 02:28:13',1),(19,'Added initial styling for the form builder forms.','2013-05-12 03:12:49',1),(20,'The add field forms in the form builder now add the attributes for the text and textarea field types.','2013-05-14 01:48:24',1),(21,'Field attributes are now saved to the database and then pulled in the form builder and attached to the inputs.','2013-05-15 01:43:55',1),(22,'Reworked the javascript, selector functions have been moved to the module javascript files rather than the base Dlayer object.','2013-05-21 01:49:48',1),(23,'Public set methods (div and form field) now check that the given id belongs to the currently set template/form and site.','2013-05-28 01:02:38',1),(24,'Form module ribbon forms now show existing values when in edit mode.','2013-06-01 01:26:25',1),(25,'Edit mode in place for form text fields and form textarea fields','2013-06-11 00:00:23',1),(26,'Updated the template module and template session class, updated names of some logic vars, names more clear, wasn\'t always obvious what a var referred to.','2013-06-12 00:43:42',1),(27,'Multi use tool setting was not being respected in the form builder when adding a new field, field id was not being stored in session.','2013-06-16 21:09:23',1),(28,'Form fields not being pulled from database in correct order.','2013-06-16 21:09:54',1),(29,'Fixed a bug with the expand and contact tabs of the resize tool in the template designer, border widths were not being added to div width meaning that the split positions were not being calculated correctly.','2013-06-19 01:25:20',1),(30,'Pagination view helper wasn\'t escaping all developer defined text.','2013-06-25 23:31:43',1),(31,'Template module tool process methods now double check that the tool posted matches the tool defined in the session.','2013-06-25 23:51:11',1),(32,'Wife had a baby, Jack James','2013-06-28 05:41:00',1),(33,'Added the forms for the content headings to the content settings page, initially it just allows the user to update the params for the headings, there is no live preview or formatting.','2013-08-16 02:42:41',1),(34,'Added initial styling for the heading setting forms and added initial styling for the heading previews.','2013-08-16 03:37:51',1),(35,'Added live preview to the content settings page (header styles) defaults to show saved styles and then on change updates the previews.','2013-08-20 17:10:04',1),(36,'Refactored the designer js, all modules, simplifed the base dlayer object and moved all the js that was sitting in view files. Structure of the scripts folder now matches images and styles folders.','2013-08-21 01:46:02',1),(37,'Upgraded to jquery-1.10.2, fixed a small jquery issue with chrome, multi-line comment at top of script.','2013-08-22 23:53:30',1),(38,'Moved all the jquery required for the initial content module settings into the Dlayer js object.','2013-08-23 23:14:30',1),(39,'Added tabs to the content manager settings page, going to be too many settings for one page and the new layout will allow more detail to be given to the user.','2013-08-24 23:15:15',1),(40,'Added some default styling to the app, a tags and list items.','2013-08-25 01:57:42',1),(41,'Updated static validation helper class, now calls the new colorHex validation class','2013-08-26 02:50:26',1);

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tabs` */

insert  into `dlayer_module_tool_tabs`(`id`,`module_id`,`tool_id`,`name`,`view_script`,`multi_use`,`default`,`sort_order`,`enabled`) values (1,1,2,'Quick split','quick',0,1,1,1),(2,1,2,'Split with mouse','advanced',0,0,2,1),(3,1,2,'Help','help',0,0,3,1),(4,1,3,'Quick split','quick',0,1,1,1),(5,1,3,'Split with mouse','advanced',0,0,2,1),(6,1,3,'Help','help',0,0,3,1),(7,1,7,'Palette 1','palette-1',0,1,1,1),(8,1,7,'Palette 2','palette-2',0,0,2,1),(9,1,7,'Palette 3','palette-3',0,0,3,1),(10,1,7,'Set custom color','advanced',0,0,4,1),(11,1,7,'Help','help',0,0,5,1),(12,1,6,'Set custom size','advanced',1,0,4,1),(14,1,6,'Help','help',0,0,5,1),(15,1,6,'Expand','expand',1,1,1,1),(16,1,6,'Contract','contract',1,0,2,1),(17,1,6,'Adjust height','height',1,0,3,1),(20,1,8,'Set custom border','advanced',1,1,2,1),(21,1,8,'Help','help',0,0,3,1),(22,1,8,'Full border','full',0,0,1,1),(23,4,10,'Text','text',1,1,1,1),(24,4,11,'Heading','heading',1,1,1,1),(25,4,10,'Help','help',0,0,2,1),(26,4,11,'Help','help',0,0,2,1),(27,3,12,'Text','text',0,1,1,1),(28,3,12,'Help','help',0,0,2,1),(29,3,13,'Text area','textarea',0,1,1,1),(30,3,13,'Help','help',0,0,2,1);

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

insert  into `dlayer_module_tools`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`icon`,`base`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','cancel',NULL,'cancel','cancel.png',1,1,1,1),(2,1,'Split horizontal','split-horizontal','SplitHorizontal','split-horizontal','split-horizontal.png',1,2,1,1),(3,1,'Split vertical','split-vertical','SplitVertical','split-vertical','split-vertical.png',1,2,2,1),(6,1,'Resize','resize','Resize','resize','resize.png',0,3,3,1),(7,1,'Background color','background-color','BackgroundColor','background-color','background-color.png',1,4,1,1),(8,1,'Border','border','Border','border','border.png',0,4,2,1),(9,4,'Cancel','cancel',NULL,'cancel','cancel.png',1,1,1,1),(10,4,'Text','text','Text','text','text.png',0,2,2,1),(11,4,'Heading','heading','Heading','Heading','heading.png',0,2,1,1),(12,3,'Text','text','Text','text','text.png',0,2,1,1),(13,3,'Text area','textarea','Textarea','textarea','textarea.png',0,2,2,1),(14,3,'Cancel','cancel',NULL,'cancel','cancel.png',1,1,1,1);

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

insert  into `dlayer_modules`(`id`,`name`,`title`,`description`,`icon`,`sort_order`,`enabled`) values (1,'template','Template designer','Design templates which define the basic structure for a webpage.','template.png',1,1),(2,'widget','Widget designer','Widgets are reusable fragments, if you have something that needs to appear on multiple pages it should probably be a widget.','widget.png',4,1),(3,'form','Forms builder','Create a form to capture user input.','form.png',3,1),(4,'content','Content manager','Create pages and add content to them, content can be anything, text, images, forms, widgets.','content.png',2,1),(5,'website','Website manager','Define the structure of your website by setting the relationship between web pages.','website.png',5,1);

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

insert  into `dlayer_sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('0263eaaj5p0qu4f2nleb6emd07','','PHPSESSID',1366564914,1440,''),('02jgorbeii33s7qobcn1j0cur3','','PHPSESSID',1367854397,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1367857997;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1367857997;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('05kdru9aq7ced6suu20dfqdpc7','','PHPSESSID',1369716797,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1369720397;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1369720396;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('05pkst5t4rfsqlhemjltpr8bm3','','PHPSESSID',1366075736,1440,''),('064ebj70os60t84qakoho8ck91','','PHPSESSID',1366074109,1440,''),('06se8t5v3t53hdpl52f06kflc6','','PHPSESSID',1366075855,1440,''),('08na5ouqa7365tm4bvimqe6ff0','','PHPSESSID',1366571006,1440,''),('0b4goo5hpge13ib0sjtirn4200','','PHPSESSID',1366072445,1440,''),('0cen56kc13s4ph49rblvull1p1','','PHPSESSID',1365905882,1440,''),('0f4sfpma5o9r10l1msutfkuko6','','PHPSESSID',1366076142,1440,''),('0i4npo7r4qgfmash2lpj5rbom3','','PHPSESSID',1366073074,1440,''),('0k55lih27sbmrch3e0s2siq6f3','','PHPSESSID',1370316294,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1370319894;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1370319893;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('0m7dt303912rarmcpc4pvr7uk6','','PHPSESSID',1366073141,1440,''),('0n199gpt749j44mi2qqh073ut5','','PHPSESSID',1366073846,1440,''),('0r9q65tq160f9d90bif7c1aj53','','PHPSESSID',1377135775,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1377139375;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1377139375;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('0up4mvv6ngm8r8hvu3bna5onu0','','PHPSESSID',1366677192,1440,''),('0v15d9a2o49r4or06k8ikatrf3','','PHPSESSID',1366567395,1440,''),('11jvoskks6a8t0arbjvnel5pm7','','PHPSESSID',1369199711,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1369203311;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1369203311;}}dlayer_session|a:1:{s:7:\"site_id\";N;}'),('1295p1n10p5m52j3u8tdmm5b61','','PHPSESSID',1365905327,1440,''),('14kl39vpgaegpdftl9r9t5m174','','PHPSESSID',1366564916,1440,''),('15b1s1p2vuvpqonmpls7vr44a3','','PHPSESSID',1365904267,1440,''),('1752calf5e620gfdeitug606j3','','PHPSESSID',1366072961,1440,''),('18cgpb09n00qa3596bp75h6v47','','PHPSESSID',1366072439,1440,''),('1au0e4f68eo5v4tlt24nc3pqi4','','PHPSESSID',1366073129,1440,''),('1ejaqipcbth6qtdfsf6crbkqd5','','PHPSESSID',1367705536,1440,''),('1rumhtkdc3ssfj0joluu3pt9g7','','PHPSESSID',1366848998,1440,''),('1umap9ntoi8rjsq8e3b62ovk21','','PHPSESSID',1367680831,1440,''),('1v69vc5gcehbvpb7lg3ck88g51','','PHPSESSID',1366074784,1440,''),('1vj42ai639oet2u67h1h39hq17','','PHPSESSID',1365904976,1440,''),('216h4b87qus34jlh7s322b9aa7','','PHPSESSID',1366678163,1440,''),('21njmsgql58rgke6unreiq5mi4','','PHPSESSID',1366073881,1440,''),('22tkghndrhjfv534ed3arbcbc6','','PHPSESSID',1367682348,1440,''),('23cq9qs9i5uub3jglhbrc6kml1','','PHPSESSID',1365905181,1440,''),('27a8op1rihk601k64a5na22ih5','','PHPSESSID',1366072443,1440,''),('27b0n579lscv94s35f8oj8cd62','','PHPSESSID',1366073169,1440,''),('28i7n2rcus4qiembh1sosur1h1','','PHPSESSID',1366073906,1440,''),('2at880m4q7h3v6j1mvkqf2jap0','','PHPSESSID',1366075916,1440,''),('2bl13kro0tfm6im9d5sj2tfti3','','PHPSESSID',1366073247,1440,''),('2d7f56m7vqk3hm5frrkk66pml2','','PHPSESSID',1366073189,1440,''),('2f2qdn2kksddbu2csces43mtd2','','PHPSESSID',1371601552,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1371605152;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1371605073;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"1\";}dlayer_session_template|a:5:{s:11:\"template_id\";i:1;s:4:\"tool\";s:6:\"resize\";s:6:\"div_id\";s:3:\"161\";s:10:\"tool_model\";s:6:\"Resize\";s:3:\"tab\";s:6:\"expand\";}'),('2g2dvcheu54ctil8o81u7apup6','','PHPSESSID',1366566142,1440,''),('2gsab1v2i9siogqbe4ggqgobp3','','PHPSESSID',1367680081,1440,''),('2jlspcmua5o6g3in2dr0r6g994','','PHPSESSID',1366072841,1440,''),('2ju2n89q5nrltji2sf7g4m0sr0','','PHPSESSID',1366075740,1440,''),('2mrg2v5ghtp7f139gqp3k8f0t6','','PHPSESSID',1366564382,1440,''),('2p0890oiscbulujbg1u9dlvj71','','PHPSESSID',1366666037,1440,''),('2pv3cdo7u2v0inh9tsl1od8ea1','','PHPSESSID',1377213608,1440,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1377217208;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1377217058;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1377217208;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"4\";}dlayer_session_template|a:5:{s:11:\"template_id\";i:1;s:4:\"tool\";N;s:6:\"div_id\";s:3:\"163\";s:10:\"tool_model\";s:15:\"SplitHorizontal\";s:3:\"tab\";N;}dlayer_session_content|a:7:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";s:3:\"164\";s:19:\"selected_content_id\";N;s:4:\"tool\";s:6:\"header\";s:10:\"tool_model\";s:6:\"Header\";s:3:\"tab\";s:4:\"help\";}'),('2rn46ek31bvdljs6ujhnvicob7','','PHPSESSID',1366420382,1440,''),('2skaom1q0ivg4pv6tglubg6ba7','','PHPSESSID',1366075819,1440,''),('2tm3psdd0h0em896go50qtjmh2','','PHPSESSID',1366566253,1440,''),('2tr15f78jurk5kl5j2b7rusti6','','PHPSESSID',1367684601,1440,''),('2ul2arsvp6f7fdk36fn8vg05p7','','PHPSESSID',1367700409,1440,''),('2v84kvjbjrfmssbhf094563772','','PHPSESSID',1366074831,1440,''),('2vbn286vfjc1ratf0iurae2h94','','PHPSESSID',1366072946,1440,''),('3083uve1e38js84t28115o3l03','','PHPSESSID',1365905309,1440,''),('308dfr651rc9oi0tg2vqfetnt1','','PHPSESSID',1366565608,1440,''),('30arop12589q1p9r717ghtm4a6','','PHPSESSID',1366666035,1440,''),('31vbjbgdctrqgi8fb4o4cdmce5','','PHPSESSID',1366565632,1440,''),('32jjfvren65tus5cau16p412g5','','PHPSESSID',1376619272,1440,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1376622872;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('32rqjp28885rd9ia1o685jrq06','','PHPSESSID',1366419082,1440,''),('338muhmo8htdf7spc7hkpufel4','','PHPSESSID',1366073408,1440,''),('33u2t1mfdqqq4d531em4miu7r7','','PHPSESSID',1365906383,1440,''),('387ec4cbqhfpn66ktr9csn8rq7','','PHPSESSID',1366073248,1440,''),('3agprruf1777tit17slogsetl5','','PHPSESSID',1366848979,1440,''),('3c2rasns6ob0s81rpivdpgblv2','','PHPSESSID',1365904754,1440,''),('3do7n2sra0va4ji1evbrqof6e3','','PHPSESSID',1366073604,1440,''),('3egh36vqitt2r37rq12oo3gk60','','PHPSESSID',1366677189,1440,''),('3g88d3nh2l8ovavfjl64fv1kg5','','PHPSESSID',1372742269,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1372745869;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1372745864;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('3jcn45mmvdo06mq54u7n6usbh6','','PHPSESSID',1366073690,1440,''),('3lobj6abgc1k1pur7ab3d2b347','','PHPSESSID',1366072713,1440,''),('3mkmj6up58j8qomsdlrfefheq7','','PHPSESSID',1366420377,1440,''),('3r9500bg6h35ed2uqgte6vb2o4','','PHPSESSID',1366074928,1440,''),('3t0cc96bbqlfifbnt021mspet0','','PHPSESSID',1367680992,1440,''),('3uqake3gmijor3261q8lc7upv5','','PHPSESSID',1366075958,1440,''),('3vb093sjrp32bbfc9fupk63ge2','','PHPSESSID',1366419170,1440,''),('412603dkrfhao9ckgd8utlq7i0','','PHPSESSID',1366072741,1440,''),('41f0n2j2qs10vg8ae4m4t4s3f4','','PHPSESSID',1365904268,1440,''),('41ksaf0hld3f8qnnk0olppphs4','','PHPSESSID',1366565800,1440,''),('42g9ptpr10vv9osloanp0gd8h5','','PHPSESSID',1367700407,1440,''),('43dsaehf1uug9cjdr4nkcgna07','','PHPSESSID',1365904740,1440,''),('44ar5d09lee4jpncn1bggq3kl2','','PHPSESSID',1366706647,1440,'dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('45pjkukj6duu14nkk6jddctgl0','','PHPSESSID',1366848985,1440,''),('46qammib63gv1oaamqv0b4hjq4','','PHPSESSID',1366072960,1440,''),('4723mtc1jg5p7giek7vuo52do1','','PHPSESSID',1365905215,1440,''),('47388rl2cg76kg4epqqtdksku1','','PHPSESSID',1365905460,1440,''),('49dhom9eq5oo9tkua86qq4gpk5','','PHPSESSID',1365905884,1440,''),('4avir12j358m1k29c9mcsh31t7','','PHPSESSID',1365905256,1440,''),('4c1cadk0ns5mlfn0t3eadbu3v0','','PHPSESSID',1366117055,1440,''),('4dq2tqhqsc9jcfolukvpqkrts4','','PHPSESSID',1366076074,1440,''),('4gmq32k0c036t222uo1hmeg1o1','','PHPSESSID',1366072571,1440,''),('4hdd7u5eem76nfutuoeh0ooaj0','','PHPSESSID',1366676814,1440,''),('4i6q3po4ka9knt71ml6svslu07','','PHPSESSID',1366072857,1440,''),('4k4vbnqdku8aag868vbe22ldi5','','PHPSESSID',1365905448,1440,''),('4o4i32ld4iat7ca6sj1phkgc01','','PHPSESSID',1365904977,1440,''),('4ok93f4nj69elshkj2b83ar060','','PHPSESSID',1365905834,1440,''),('4prr16rnt10bf863hbk1og7vi5','','PHPSESSID',1377568280,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1377571880;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1377571880;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"1\";}dlayer_session_template|a:4:{s:11:\"template_id\";i:1;s:4:\"tool\";N;s:6:\"div_id\";N;s:3:\"tab\";N;}'),('4qdfd5g1df1iq015147afosbo5','','PHPSESSID',1366074096,1440,''),('4sqcee3nu3hah9hk2fqlco01h4','','PHPSESSID',1367703411,1440,''),('4tlr3el8pvm6iba56531ep6kp6','','PHPSESSID',1366075399,1440,''),('4vj7q7g5p2tosd2repapo86hk5','','PHPSESSID',1366566261,1440,''),('4vrdgj7nulqcf2gq656ffa5710','','PHPSESSID',1366566263,1440,''),('50b59blfj62uln300en8ebqr07','','PHPSESSID',1367689333,1440,''),('517j7ha3e8sksu8d8pcbar9bl1','','PHPSESSID',1366075960,1440,''),('53bs2h0n8moijhsa10s7f28vs4','','PHPSESSID',1376045039,1440,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1376048639;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1376048611;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1376048635;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"3\";}dlayer_session_template|a:1:{s:11:\"template_id\";i:1;}dlayer_session_form|a:3:{s:7:\"form_id\";i:1;s:4:\"tool\";N;s:8:\"field_id\";N;}'),('5507bc3i3a3q1rr62eugueejn3','','PHPSESSID',1366566324,1440,''),('58v9fo2vpi1910qro7d107faa7','','PHPSESSID',1367703562,1440,''),('5a7aqd3629amds2o7d8hckg8v3','','PHPSESSID',1366072171,1440,''),('5bbouvf9kl0ftvmuged6724c76','','PHPSESSID',1366075696,1440,''),('5br39s41ioko415u7mi7hvt6s0','','PHPSESSID',1365905509,1440,''),('5f9an6vd1mnkggn151mhdahha7','','PHPSESSID',1366072691,1440,''),('5fmvhdf5rjnfotgtkfl9cfu3j4','','PHPSESSID',1367679353,1440,''),('5g7ofuqpioplbpe0kf2gv6kko2','','PHPSESSID',1366566328,1440,''),('5hdcvqe3dnfap1t6ha59ht2p40','','PHPSESSID',1366073472,1440,''),('5hqe89h843g0lt8b8t131msa71','','PHPSESSID',1366566316,1440,''),('5kq3ht2dk3iqi92hjoevn7tg72','','PHPSESSID',1367681424,1440,''),('5l141kqk69fvkt149c0ui1qh72','','PHPSESSID',1367689349,1440,''),('5m07o6d3tmfm50udve3h6a7h91','','PHPSESSID',1365905838,1440,''),('5p5afc890g9796jfoi404ugls6','','PHPSESSID',1366419167,1440,''),('5pk17slaas5utl69i3e6hb1ip4','','PHPSESSID',1365906117,1440,''),('5q407oqi87coa4ho897v52rgm5','','PHPSESSID',1366073674,1440,''),('5ql3i29t2sqn5nc32dkruts7l5','','PHPSESSID',1367679354,1440,''),('5vak0v3g9ig0u2cp514uffeka1','','PHPSESSID',1366073247,1440,''),('5vj0fa0fvr4llfs90nl1co2m51','','PHPSESSID',1366075694,1440,''),('605m2d7o5p05586l2g6c0u41k4','','PHPSESSID',1366565788,1440,''),('6afqukjr9takn67thvke0ptqm1','','PHPSESSID',1366565608,1440,''),('6f2g94c64bus9fidpkqkd0gtn1','','PHPSESSID',1366071808,1440,''),('6gf23q62op45s190nn6enhehh4','','PHPSESSID',1366072534,1440,''),('6ggtm7phmm8mt4rf0m2rhdnat6','','PHPSESSID',1366073022,1440,''),('6gjql11d9favs76rhenjv95fl2','','PHPSESSID',1366072944,1440,''),('6h1jvujhm9jum9akqas86t9tp1','','PHPSESSID',1366074829,1440,''),('6h3apsb12ud6e8u7use51ak121','','PHPSESSID',1366072743,1440,''),('6hkltbmf0ai1fb4b7vju10kfs4','','PHPSESSID',1366075956,1440,''),('6in14lugtcjpkjcavjbp0i0o74','','PHPSESSID',1366073409,1440,''),('6kmugeme72hpcj1ieisp9jj0a6','','PHPSESSID',1366072358,1440,''),('6n6808a0b0cihgdaf7g7uq9ie6','','PHPSESSID',1366566312,1440,''),('6nggpmk9r93pqpb7iegmp8sl76','','PHPSESSID',1366072960,1440,''),('6ppcna7539ha431nnquerplb43','','PHPSESSID',1366072350,1440,''),('6q7amg02n7t7b0kim9mqqprfb6','','PHPSESSID',1366566141,1440,''),('6qoms491aoerrb6311be6ujqr0','','PHPSESSID',1367700449,1440,''),('6rbn3vphra4ggmdg3fbr0ocqt2','','PHPSESSID',1367846202,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1367849802;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1367849802;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"3\";}dlayer_session_form|a:2:{s:7:\"form_id\";i:1;s:4:\"tool\";N;}'),('6rhnc94n2krg2tiq2udi4n65k3','','PHPSESSID',1365905459,1440,''),('6rqhge9v8964kdj7185jhlatr5','','PHPSESSID',1366073389,1440,''),('6tjkf9bni1esha7io4chtvd137','','PHPSESSID',1366678196,1440,'dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"3\";}dlayer_session_form|a:5:{s:7:\"form_id\";i:1;s:4:\"tool\";s:4:\"text\";s:10:\"tool_model\";s:4:\"Text\";s:3:\"tab\";s:4:\"text\";s:11:\"selected_id\";N;}'),('6vtu6iiatdgtneho31504ku1h5','','PHPSESSID',1366565633,1440,''),('7388bcq8tbrpf11mrhb2gi6ba7','','PHPSESSID',1367703301,1440,''),('73ukgv526rq5csbfoatr246t17','','PHPSESSID',1366666039,1440,''),('76048sp5eqdjsefbpfnmncsq42','','PHPSESSID',1366071958,1440,''),('76nf6ug526ovibsbbj4bm1hfb7','','PHPSESSID',1366564906,1440,''),('7c5oniie70o773vs4cmln42ql5','','PHPSESSID',1366678171,1440,''),('7hhbfars7bolqlidan4221r5g3','','PHPSESSID',1367702333,1440,''),('7i6t61rnrfrka50tgmmh7ujhk3','','PHPSESSID',1365906223,1440,''),('7kfde6uaifgjh9mlt17hjda5f0','','PHPSESSID',1366076061,1440,''),('7lima9mf3ema3lv2utrbdb0gv7','','PHPSESSID',1366565629,1440,''),('7oouqeh9o4sh40stmo2km2jjt5','','PHPSESSID',1367680271,1440,''),('7p91utn92fvieknu58h4h639q1','','PHPSESSID',1366419085,1440,''),('7pm76taonk68ligusgftfgg017','','PHPSESSID',1368577647,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1368581247;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1368581247;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"3\";}dlayer_session_form|a:2:{s:7:\"form_id\";i:1;s:4:\"tool\";N;}'),('7rdsvfvf2o9osn4vuvdmvg3or3','','PHPSESSID',1366567400,1440,''),('7t10nbcmfada9kgv1gn836uhv1','','PHPSESSID',1365904255,1440,''),('81m22ovfvqiot925v5sb89pi62','','PHPSESSID',1367681244,1440,''),('83m8p5b0dmfkpg6qei5d7pt0v6','','PHPSESSID',1365906272,1440,''),('86gvm6i6mtpc9cns1hmvqvpc40','','PHPSESSID',1366678184,1440,''),('86jlua954m1ar73lom4cg029d4','','PHPSESSID',1366566252,1440,''),('8ac87ovvhfjhf0s6li0p2cl6h0','','PHPSESSID',1367703271,1440,''),('8b37djmagb9sbe7jmhhc2md9v3','','PHPSESSID',1366706647,1440,''),('8dukjr3h9souisomcb024cv0v0','','PHPSESSID',1366565778,1440,''),('8ef8hgqt9adq07cqn33tdv99e4','','PHPSESSID',1365904738,1440,''),('8gs0mt1tm05jruvmcq3j9p9ku5','','PHPSESSID',1366566246,1440,''),('8i5a0lsdjtp8m47s7ebe5fej95','','PHPSESSID',1366073691,1440,''),('8itct8iv0rb7m0v9fkkaovig41','','PHPSESSID',1366073167,1440,''),('8m0i6r8ilfk1u3mvo85mbjqvs6','','PHPSESSID',1367703496,1440,''),('8mpubp8md8mm19vffs6sr26k33','','PHPSESSID',1366076196,1440,''),('8q43u9326eus2j3a56vvhet9d3','','PHPSESSID',1366075675,1440,''),('8tcpspncfplvie80esnnkl78g1','','PHPSESSID',1365906270,1440,''),('8uirfa948s4blsooequfnu1e75','','PHPSESSID',1365905879,1440,''),('8ulnul59gcremuk1cvf7f2ihd5','','PHPSESSID',1366071927,1440,''),('92ddkqhiasc25k3b89036s07e5','','PHPSESSID',1366419048,1440,''),('92lffh14s96g9sl41s0pjmqmu0','','PHPSESSID',1366565788,1440,''),('96593ok1njlbikt3oqdv4a6fr1','','PHPSESSID',1366075955,1440,''),('989qubfqmf8iqv5mvoe4o08ti4','','PHPSESSID',1366074097,1440,''),('98f8tg16d59camdu4hseutivv3','','PHPSESSID',1366071890,1440,''),('99utn1v6k9hfa8nt66lql99u40','','PHPSESSID',1366074591,1440,''),('9a1kht68o0rdijf16p11js5bq4','','PHPSESSID',1366074786,1440,''),('9hb5fvmjhkhfit5n2uinqup6m3','','PHPSESSID',1365904012,1440,''),('9ivsf1n0343cc601ct4aob4a01','','PHPSESSID',1366072446,1440,''),('9jttiloh1ajsm3756jdr56ojm5','','PHPSESSID',1366072170,1440,''),('9kc6o4caph3i516b9eqelcmuu5','','PHPSESSID',1367681425,1440,''),('9koef6tithqhkuu8vnu2bdip57','','PHPSESSID',1366072348,1440,''),('9m0n76au3op2qalt28co37dlt0','','PHPSESSID',1366566259,1440,''),('9pgeea6c90srt08o8nntufgh50','','PHPSESSID',1366564389,1440,''),('9q7h6ljveetv9l9cii2tjivd27','','PHPSESSID',1366420388,1440,''),('9qpaepqgfp5rrsemjlv1r7o2f4','','PHPSESSID',1366075339,1440,''),('9s32r2le1h2261snjtiif6h5i5','','PHPSESSID',1367703331,1440,''),('9smanlltode7k9j1mpgq7k7gm7','','PHPSESSID',1366423989,1440,'dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('9stqjat7el4p127th2d0go6bc7','','PHPSESSID',1368492386,1440,'__ZF|a:3:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1368495986;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1368495986;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1368493657;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"3\";}dlayer_session_form|a:5:{s:7:\"form_id\";i:1;s:4:\"tool\";N;s:10:\"tool_model\";s:8:\"Textarea\";s:3:\"tab\";N;s:11:\"selected_id\";N;}dlayer_session_content|a:2:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;}'),('9tdhqlai98juhrj26vn5nol460','','PHPSESSID',1371010113,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1371013713;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1371013708;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('9ti29rvqmrd3jfvj5senppmob3','','PHPSESSID',1366073410,1440,''),('a0nt0jqsumcc2aecct49k2cp71','','PHPSESSID',1366075677,1440,''),('a1ed7i09ktdg7gcadravckjv60','','PHPSESSID',1366072633,1440,''),('a1ilv51rdttfnh560ib1gef8f0','','PHPSESSID',1366073390,1440,''),('a5vteovksb1f99vs07r6rghm36','','PHPSESSID',1366418974,1440,''),('a6magifj97pb34ohhlkk9lqqd3','','PHPSESSID',1366567335,1440,''),('ad102qi60desg8iara50fhvq33','','PHPSESSID',1365905216,1440,''),('ae8q5eq07g9bap5q198ak3c173','','PHPSESSID',1366418632,1440,''),('afahevsisfif5jrkpp5d0kjab1','','PHPSESSID',1366074738,1440,''),('agj8gav8in6nssrdnn3ltj1d90','','PHPSESSID',1365904269,1440,''),('agni50c6pamgnscdf62f9u7r32','','PHPSESSID',1367681419,1440,''),('aj1gpcrl82go1ti99mp56cb4b0','','PHPSESSID',1367702335,1440,''),('ak18s50scrvf0ulvcgue993v74','','PHPSESSID',1366567337,1440,''),('ak2kqil8b7am085fhaa7cgbf34','','PHPSESSID',1366565717,1440,''),('aovc6fdsg98s53errai3vll626','','PHPSESSID',1366072872,1440,''),('arnbu7r5skhfdgc210pk02tsr4','','PHPSESSID',1366072117,1440,''),('ato3s8rp609o3m23jnl09o1im1','','PHPSESSID',1366074068,1440,''),('au8dr2097rk0fb4s558634o4h2','','PHPSESSID',1366072118,1440,''),('b00v6g7qbbs8kc85uv9nap4s32','','PHPSESSID',1366418635,1440,''),('b0cph0q3cce3dnam5h3ob4uad0','','PHPSESSID',1366073680,1440,''),('b3j2r681didc7tkg81a77ltq71','','PHPSESSID',1366565789,1440,''),('b3qe7jvkja4mst6t6crt3pbs64','','PHPSESSID',1366073188,1440,''),('b40m2tsfblog5ib90j02lebi67','','PHPSESSID',1366678196,1440,''),('b4684s2hjo6ig2e6helhgo4up7','','PHPSESSID',1366567342,1440,''),('bd6guejkjmclkmnhkful47emi3','','PHPSESSID',1366565717,1440,''),('bdoejc3o37u4va367oqs96hs75','','PHPSESSID',1366566262,1440,''),('bh7ot345vs9cpr4jlgsticm1m5','','PHPSESSID',1366074508,1440,''),('bhmh7qfh9m97rm1rr3rij5rte2','','PHPSESSID',1367700408,1440,''),('bhp544lnqjnqoj5i3sv4k444q1','','PHPSESSID',1366419057,1440,''),('bisaq4rfe1klb5hsu6qmf5o6k2','','PHPSESSID',1366677143,1440,''),('bjd7040cflcp8d8146ksdm9440','','PHPSESSID',1366418633,1440,''),('bkd40364ia1f35b2nadj5m4og7','','PHPSESSID',1366074838,1440,''),('bmefg0vv7gmfjj01gu5m898887','','PHPSESSID',1367681555,1440,''),('bpokg6dh5bcactavolb7hdin04','','PHPSESSID',1367703373,1440,''),('bqicc150imcurgl68gh8qvll63','','PHPSESSID',1366564863,1440,''),('brmlh0nah9c7rfqi8j9fh9q125','','PHPSESSID',1366073991,1440,''),('bs81giaiie2ecricsrlq0bibv6','','PHPSESSID',1366072662,1440,''),('bu2c77rfkr67it3g3a85s0m1r4','','PHPSESSID',1366678188,1440,''),('bv37ktsg8voj9cta5oa1nta1t7','','PHPSESSID',1366075792,1440,''),('bvank91qdi25k6pg1jpv3hr4e0','','PHPSESSID',1366564383,1440,''),('bvuevl0d1i4ui0497bi17apom3','','PHPSESSID',1366074531,1440,''),('c0csaf7eoqp86dtmjeq29jvu12','','PHPSESSID',1366420385,1440,''),('c0nqg8mpqsor6fv8ukp41uarb2','','PHPSESSID',1366073045,1440,''),('c5gap8iujjmkm6bgi32f12rnk0','','PHPSESSID',1366566314,1440,''),('c61ttkefvvq55619e95nfce2h5','','PHPSESSID',1366075542,1440,''),('c78p5rmrv7ptikil3gok8u55h0','','PHPSESSID',1365906121,1440,''),('c7grkv22svihs8gv8ah6pcrgd3','','PHPSESSID',1366071862,1440,''),('c995do244u7o5pmmmdg194oh42','','PHPSESSID',1367681446,1440,''),('cahpndj68me5i7n27o6teehuq3','','PHPSESSID',1365905684,1440,''),('cb36rs9bpjebk0gua5v6nf2q06','','PHPSESSID',1366071608,1440,''),('cbnrhec5un1v94fatnu8tbd124','','PHPSESSID',1370046289,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1370049889;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1370049889;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"3\";}dlayer_session_form|a:5:{s:7:\"form_id\";i:1;s:4:\"tool\";s:4:\"text\";s:11:\"selected_id\";s:1:\"1\";s:10:\"tool_model\";s:4:\"Text\";s:3:\"tab\";s:4:\"text\";}'),('cbr0bvolbek47jks216em8ej21','','PHPSESSID',1366073142,1440,''),('cchmmuqbr1n4c9c96f4053ute2','','PHPSESSID',1366071607,1440,''),('cduhqhrhq0u4kfs80vg0lhkki7','','PHPSESSID',1366420386,1440,''),('cedsi023m7tkjr2fhu19g1v3j6','','PHPSESSID',1367700412,1440,''),('cel5deal65uj5adqaldj54n3t3','','PHPSESSID',1366072632,1440,''),('cg49qhij7ei75itu7vt91vmlq5','','PHPSESSID',1366677086,1440,''),('ch002f6o56hb6c0np96qqs4qt5','','PHPSESSID',1366072533,1440,''),('ch15g93oj620qbn5s6uei64206','','PHPSESSID',1366073603,1440,''),('ci9odhk4eaialo2hpj6fs3rot1','','PHPSESSID',1366075313,1440,''),('cjkpq76aavrs03opkk8q51hk67','','PHPSESSID',1365904049,1440,''),('cm7khqarp7q5vlf91dlvf3ugr4','','PHPSESSID',1366419123,1440,''),('cn55lbs332al5i4tmg5192bhv7','','PHPSESSID',1367689351,1440,''),('cnm0etjbkh8uvaeh3v4jrqlkr1','','PHPSESSID',1366075735,1440,''),('con06cok4sdauh0blrj3qu0944','','PHPSESSID',1366564404,1440,''),('coub9vic7gq56o9jjk29k1qed5','','PHPSESSID',1366072349,1440,''),('cq0itu87ts91khj3qdv4lp3lc3','','PHPSESSID',1365905180,1440,''),('cqcdo7mj1igrdusco1duaulud5','','PHPSESSID',1367680898,1440,''),('cthhaltm3p1iclh6qftsdrrd75','','PHPSESSID',1368322797,1440,''),('ctkl7e4jahmibpkj5ninrr8vn6','','PHPSESSID',1366567340,1440,''),('d176nk1nvl7ien50888b20o1f5','','PHPSESSID',1367707364,1440,''),('d1r4s547rf75nbalgevqeucal3','','PHPSESSID',1366072238,1440,''),('d7nkb15i9c9if5627047jfjh57','','PHPSESSID',1366075317,1440,''),('d8hc7ti6umcaif8vv51ej9r2n7','','PHPSESSID',1365906274,1440,''),('d9frt6ck86lvamu03ootb43gu2','','PHPSESSID',1365904308,1440,''),('db96e65nc82l1j8u0ojnqrefb0','','PHPSESSID',1365906221,1440,''),('dcedbrl46sr8tp3vv9e20q2md3','','PHPSESSID',1377443593,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1377447193;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1377447193;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"4\";}dlayer_session_content|a:7:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";s:3:\"161\";s:19:\"selected_content_id\";N;s:4:\"tool\";s:7:\"heading\";s:10:\"tool_model\";s:7:\"Heading\";s:3:\"tab\";s:4:\"help\";}'),('deekofsso3s6cbjacolujvdg85','','PHPSESSID',1365908492,1440,''),('dhcg3prs8fop7r98fub319rbq7','','PHPSESSID',1366074104,1440,''),('dhl1pp9djqtup8fn2lroevic24','','PHPSESSID',1366677103,1440,''),('dij9mvk422gmh16gl4s40f2qk6','','PHPSESSID',1367707366,1440,''),('djc2sq36udhkcgimnpqa72ds85','','PHPSESSID',1366419058,1440,''),('djlsvm7ajt2pjumsdr23mb5mh2','','PHPSESSID',1366848983,1440,''),('dnqscs9i8fj04vvvpkpb7bg2l4','','PHPSESSID',1366071891,1440,''),('dpvluknct0hqnku6o5oj45mc70','','PHPSESSID',1366072002,1440,''),('dtdf3alah6e7l2fdjlbfs42ie4','','PHPSESSID',1366075676,1440,''),('dtlgboo8878prntbtvmho8ogf6','','PHPSESSID',1366677145,1440,''),('dv6i1042gsn6inq5hlmf9ilv71','','PHPSESSID',1367679906,1440,''),('e05a42h9c9ignk5816s8a77f13','','PHPSESSID',1366566251,1440,''),('e0cj5at0aa6gaen64rdb5k9596','','PHPSESSID',1365905276,1440,''),('e3j3r7qmpb6sukb7ndm5lqejv4','','PHPSESSID',1366564900,1440,''),('e5im7vjbeslf5eajek5gen3at5','','PHPSESSID',1365905277,1440,''),('e5k5e59gbvvlvdfbohv0qdae44','','PHPSESSID',1366564917,1440,''),('e636kp64p3gfj40nehvaqpeef1','','PHPSESSID',1366419103,1440,''),('e6flafr3lp28394sc42vv7o0i6','','PHPSESSID',1366075064,1440,''),('e79kiq2bgd4t2u3v1p4jf8h3j2','','PHPSESSID',1366676812,1440,''),('e81l2vfiqeg6dd27vn4k2enfg5','','PHPSESSID',1366073844,1440,''),('e99ss5kmmqbee8pjcv449jb693','','PHPSESSID',1366072824,1440,''),('e9tfqki4po4vtt2sdfa1hlrp87','','PHPSESSID',1366677196,1440,''),('ejemj332e48vkp6m0e0ekbulc6','','PHPSESSID',1366076076,1440,''),('ek19b5j1q471vp3mi29t3p6mh3','','PHPSESSID',1366076195,1440,''),('en408u89bubl8gddfhkn950nh0','','PHPSESSID',1366075957,1440,''),('enagrq57ivmvk9f8n19vfcolf4','','PHPSESSID',1366565607,1440,''),('endu5a4fpnc8jl0b0567hotef2','','PHPSESSID',1366848982,1440,''),('eot8kbv142jel63915rlkvuc17','','PHPSESSID',1367689336,1440,''),('epob219o13071je8fevc5ntsk4','','PHPSESSID',1367700446,1440,''),('eqhkia2obrkp3jmsmr01vfvhp5','','PHPSESSID',1366566119,1440,''),('eqo7dflool647msq2qtth9t2l5','','PHPSESSID',1367681417,1440,''),('err65jm8tqupi39p98n0mkp7t7','','PHPSESSID',1366567403,1440,''),('etm3lgua532ie00kpo7avb9o90','','PHPSESSID',1366076060,1440,''),('euh0aqs4im8o4rge7qj10cn4j3','','PHPSESSID',1366566327,1440,''),('euufi831gn2nrfib1enmkvj415','','PHPSESSID',1366564913,1440,''),('f05mol99euk6jbja0sh9b7bup1','','PHPSESSID',1366073043,1440,''),('f0772gs4jhamf7fvlnris0s3f4','','PHPSESSID',1366565607,1440,''),('f1atl23btmee0pjgnc3tqttjs6','','PHPSESSID',1366076085,1440,''),('f3drc9pnct22r136l6rbdkhfe3','','PHPSESSID',1366419060,1440,''),('f3hldko77kon63elec6d8ae5d7','','PHPSESSID',1366564387,1440,''),('f6ddg92rpg6su3bnbpih8jpro2','','PHPSESSID',1367703544,1440,''),('f6iomoi114oaabnhj3ldvkklu3','','PHPSESSID',1369687001,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1369690601;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1369690600;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('f7gjkat7v34vp5r70q20i7aib5','','PHPSESSID',1366420374,1440,''),('f806o5h8df1p0tn1f3g9pij496','','PHPSESSID',1365904242,1440,''),('fffsj677lca88sb2bdpq3lsdk6','','PHPSESSID',1366073234,1440,''),('fhd25ami8fl9e06j49sakrjb20','','PHPSESSID',1366565716,1440,''),('fhgku0na56b4sqttbir60psoe0','','PHPSESSID',1366567397,1440,''),('fi07v78ch8flkrprajj2pd82f6','','PHPSESSID',1366072407,1440,''),('fkbudvdkuisk5pcp7np6vvtk34','','PHPSESSID',1366073580,1440,''),('fkhvnutkg2nt581sj89g5pn1s3','','PHPSESSID',1376476087,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1376479687;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1376479683;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('fns0me63c1p6jgk37oq3se5pv2','','PHPSESSID',1367703425,1440,''),('fop19bu29m9nj5vg1jcd688d74','','PHPSESSID',1368607371,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1368610971;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1368610971;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('fsk9ar3g3ssruh01aum97o6ia4','','PHPSESSID',1366076002,1440,''),('fsuj1uqsajtac3iog6fmu5run5','','PHPSESSID',1366567338,1440,''),('ftld118cc3abu44g3ij3g8ouo1','','PHPSESSID',1376620607,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1376624206;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1376624206;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"4\";}dlayer_session_content|a:2:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;}'),('fu9t0i95blcqnip1vqfmfmqhb1','','PHPSESSID',1366072088,1440,''),('fudfhjnij9doprqkd0ip51hbs1','','PHPSESSID',1366420375,1440,''),('g2f2jn50t6doklq3o1h9j3vc64','','PHPSESSID',1366677083,1440,''),('g30u4ufs2sl33u1pgtv9l30kt0','','PHPSESSID',1367689337,1440,''),('g5bqsslt6spk65j8kdsin3pjh4','','PHPSESSID',1365906118,1440,''),('g5bvpitaa0hjes0btvabg50kt3','','PHPSESSID',1373295571,1440,'__ZF|a:4:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1373299171;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1373299163;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1373299167;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1373299171;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"4\";}dlayer_session_template|a:1:{s:11:\"template_id\";i:1;}dlayer_session_form|a:5:{s:7:\"form_id\";i:1;s:4:\"tool\";s:4:\"text\";s:8:\"field_id\";s:1:\"1\";s:10:\"tool_model\";s:4:\"Text\";s:3:\"tab\";s:4:\"text\";}dlayer_session_content|a:7:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";N;s:19:\"selected_content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:10:\"tool_model\";s:4:\"Text\";}'),('g73769rls98dutl1l3anbqiob7','','PHPSESSID',1366075953,1440,''),('g8ramns2b6sc49k3r9gd8dcgr2','','PHPSESSID',1366074828,1440,''),('ga07uio4mlqid4itgdgr5fkb01','','PHPSESSID',1366075097,1440,''),('gaema6ur6sjnd4im50ochbrn52','','PHPSESSID',1366075994,1440,''),('gal48idutedt4k9ee31gum5rp6','','PHPSESSID',1366587110,1440,''),('gckd2b8du14l7fu5c2vlse6k35','','PHPSESSID',1365906220,1440,''),('gdjdqjb8q8ftoq92uisphqk8q7','','PHPSESSID',1366075000,1440,''),('gfinr90hljgmt6d6g7c65ngnq2','','PHPSESSID',1366072287,1440,''),('gkric3nrp572qvk69k0n8datk5','','PHPSESSID',1365904710,1440,''),('gl3ed8v0o40up84g4spobn8eh0','','PHPSESSID',1366072077,1440,''),('gnv7t33c7nc379hog4sh59odj2','','PHPSESSID',1365905836,1440,''),('goqinu7q6i644juq972n168l74','','PHPSESSID',1365906000,1440,''),('gpihefq6m7gt0b6emp77chvvi6','','PHPSESSID',1376189107,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1376192707;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1376192707;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"4\";}dlayer_session_content|a:2:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;}'),('gu6iqstjqi63ebcshcf24gb8k1','','PHPSESSID',1367681613,1440,''),('guv0r8dgmpds3u5modnue5ch10','','PHPSESSID',1366072742,1440,''),('gvggq0fp20j92gnf9grijpcjt4','','PHPSESSID',1366075951,1440,''),('h0kj14a020pio22sip4nqhf9m1','','PHPSESSID',1366566327,1440,''),('h1acbijdi0iusgop8asc8j05p0','','PHPSESSID',1366072856,1440,''),('h42tohsorek4bfq2oid8hpvu05','','PHPSESSID',1367681440,1440,''),('h4ft7m65iedst3o9vslj0p6ta2','','PHPSESSID',1365904714,1440,''),('h83ogenprt6l0c4ed09p1tg150','','PHPSESSID',1367679355,1440,''),('h94lhkid22mn2nqha8q3fns3b5','','PHPSESSID',1367681655,1440,''),('hf9nshuiu5p1ja4of721chmst6','','PHPSESSID',1367681558,1440,''),('hibtbekrh5j6n8190o8dr8pjs1','','PHPSESSID',1365905870,1440,''),('hitdj4dttdspp592crm8mbmbb2','','PHPSESSID',1365904004,1440,''),('hjke04n7drg2asvce9t92fg2u0','','PHPSESSID',1366565790,1440,''),('hpedsks4rta43ul59fqi7g4r62','','PHPSESSID',1366419050,1440,''),('hppkr3qgh2jrdkcn8pqqmk4la4','','PHPSESSID',1367707368,1440,''),('hqdeii2c074vk1tqj2pe4p7mq7','','PHPSESSID',1366076144,1440,''),('hrlhrojd8ablru7invmks35vj4','','PHPSESSID',1366072945,1440,''),('hsndp7rrf9ojv6fa7lutre3ln2','','PHPSESSID',1365904042,1440,''),('huafp28a77iat1qbhih7nj1ns1','','PHPSESSID',1367680326,1440,''),('huspascku2m40k4cqfbdfagk47','','PHPSESSID',1366072442,1440,''),('i147a5ce38m8fkemqd6mqorlu1','','PHPSESSID',1366076277,1440,''),('i6nd8mo10n3trhpqi8obk96h37','','PHPSESSID',1365904688,1440,''),('iaeln23akdm1aoaalavkn3bhn6','','PHPSESSID',1366073313,1440,''),('iafufq9guagsnjt2v68muc9oh3','','PHPSESSID',1365904050,1440,''),('iahgdo27e8ft5ttcsg9tc9lh86','','PHPSESSID',1367704805,1440,''),('ieg2nsvfdea7sglveqa2f1ovn6','','PHPSESSID',1366074833,1440,''),('if1t5cqobr99484l0i7k7r1me5','','PHPSESSID',1366072823,1440,''),('if5mrjdv108rkp15qc1cbqab82','','PHPSESSID',1365906045,1440,''),('if951t9111bku3og85mds5qdf5','','PHPSESSID',1366073473,1440,''),('ifglhlgcirm44al0715q7arnt1','','PHPSESSID',1367698606,1440,''),('ig6ig04s9qldvvvhpjoro6ltk7','','PHPSESSID',1366850330,1440,'dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"3\";}dlayer_session_form|a:5:{s:7:\"form_id\";i:1;s:4:\"tool\";s:4:\"text\";s:10:\"tool_model\";s:4:\"Text\";s:3:\"tab\";s:4:\"text\";s:11:\"selected_id\";N;}'),('igdkp4k27f88l1l4c8iqeb91c1','','PHPSESSID',1370904838,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1370908438;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1370908438;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"3\";}dlayer_session_form|a:5:{s:7:\"form_id\";i:1;s:4:\"tool\";N;s:14:\"selected_field\";N;s:10:\"tool_model\";s:8:\"Textarea\";s:3:\"tab\";N;}'),('igtcf5n4qnups01dj98adncpk4','','PHPSESSID',1365905520,1440,''),('ih0lidsipq7n7h2rog2pclcrq4','','PHPSESSID',1366566252,1440,''),('ih7cq8qjhnceah7p7e65eercv6','','PHPSESSID',1366072078,1440,''),('ilq31hgamva1fr92qqs83kk3j3','','PHPSESSID',1366071597,1440,''),('imtan6cv8c2puqg885of2mh8f5','','PHPSESSID',1365903951,1440,''),('imu1umsl004so35h8u8ttkv634','','PHPSESSID',1367679352,1440,''),('infd6qcgfn3oo6f5pnm703uf15','','PHPSESSID',1366076001,1440,''),('inp8sdlvl6q8p5dvvegoqinoh4','','PHPSESSID',1366072696,1440,''),('iog350ra87gmru4hp712arr157','','PHPSESSID',1365906276,1440,''),('is40d3va0eki81mihisrtsfra6','','PHPSESSID',1365905705,1440,''),('is91738383vb27qiq0fr547qt1','','PHPSESSID',1366072089,1440,''),('iva33o558isje0dne56h2duv44','','PHPSESSID',1366418703,1440,''),('ival5fcdf3d2v7ft85q4kav4l5','','PHPSESSID',1366073845,1440,''),('j0mter9ae9junbqrt1nt6r10h6','','PHPSESSID',1367700532,1440,''),('j4mpm1mfjr42l5ema60evqcn91','','PHPSESSID',1365905683,1440,''),('j61r7vll97h8itccpg1ut8q517','','PHPSESSID',1366565474,1440,''),('j69hrt3k7ljp2iccc57uor0fu3','','PHPSESSID',1365904266,1440,''),('j7tr9m3df9in7l1rvi7cfk97b0','','PHPSESSID',1366565791,1440,''),('j89nfuf1ovv16ib2k5ss04esk2','','PHPSESSID',1366419055,1440,''),('j9kuvs6jgltfva5qkd0ku31jl7','','PHPSESSID',1366074837,1440,''),('jaou7p9ajkme75utfv2l4l3op7','','PHPSESSID',1366566311,1440,''),('jc11i3tqhd2tpfmckq5d9vqdm2','','PHPSESSID',1365908490,1440,''),('je5083eh0rfl6v9gbt0qp1iat7','','PHPSESSID',1365905319,1440,''),('jf4k424iug6cf4pfg44vf3gak7','','PHPSESSID',1366073581,1440,''),('jfivocnfjggdr0rtet62eq3cb1','','PHPSESSID',1365905255,1440,''),('jh3bol960nr635u10kv62hhiu5','','PHPSESSID',1366072190,1440,''),('jhtq5k25m39hliaet10ialc4t0','','PHPSESSID',1366072661,1440,''),('jqvlaip0jv4q5b4kl9v1e76466','','PHPSESSID',1366678195,1440,''),('jrlg0ht2rlucu598f71ds4ocb4','','PHPSESSID',1366566245,1440,''),('ju0s5lg3dkgig4q5v7eo2rlue5','','PHPSESSID',1366419237,1440,''),('jve7trgl3f8rbrr8kptn5opav6','','PHPSESSID',1366071599,1440,''),('k04gtfcd4c40c61m5jn3nrm0n1','','PHPSESSID',1365904807,1440,''),('k2f3tv7lt52e15mm5a5d0sssp1','','PHPSESSID',1366587110,1440,'dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('k4nvo7l64g3pk31ocvehcg6lv7','','PHPSESSID',1365904689,1440,''),('k6931fds3l8cjqu7pf4bhn3np0','','PHPSESSID',1366073577,1440,''),('k69glke8qhiraitp52i2a0ic93','','PHPSESSID',1366565403,1440,''),('k7a77q8vg0pepmasbc8d249u07','','PHPSESSID',1366564906,1440,''),('k7v1nq12tk9s1474656uc4gd07','','PHPSESSID',1366073044,1440,''),('k7vu1prbt6qsu5fr9gie039231','','PHPSESSID',1365904802,1440,''),('k9hf0seg99gvf0kh1cvc5mtav1','','PHPSESSID',1365904707,1440,''),('ka7bs2tq9fqu16hpfjm7rugg57','','PHPSESSID',1366071601,1440,''),('kao4o1p8b5lk5u23ur6ubur8n0','','PHPSESSID',1366075484,1440,''),('kau7b7b2g1k68845jnh4h60mu2','','PHPSESSID',1366420378,1440,''),('kgck4cffh4vd0b4or96qrt3hk7','','PHPSESSID',1366075693,1440,''),('kgrdjjnegt9f5ca8tqanon12n2','','PHPSESSID',1367679350,1440,''),('kljt39oi84rmmfvq2nei5bh3d2','','PHPSESSID',1366073168,1440,''),('krp87gl4a210q97anopmo18kf0','','PHPSESSID',1366076270,1440,''),('kvc2jaqqs8jkh4t6gamq697145','','PHPSESSID',1367702336,1440,''),('l58621gpfiq7tqn5pp3vla6og7','','PHPSESSID',1366072800,1440,''),('l5ncptf4kpncv68f3kdj1grkp2','','PHPSESSID',1365903950,1440,''),('l5th749hm4iltlakv9tauunam7','','PHPSESSID',1366677144,1440,''),('l7besuau0ka9b248r30i4me463','','PHPSESSID',1365905308,1440,''),('l814o65vi4c39emfjcmeb0en34','','PHPSESSID',1366073023,1440,''),('l8rqgva2cc5jj15tt5iqci2r75','','PHPSESSID',1366565403,1440,''),('l9pqaqd3jffpmchnk7k9tvcrs4','','PHPSESSID',1376619280,1440,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1376622880;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('larjkloi2r75cpd3rads6hgk82','','PHPSESSID',1367681236,1440,''),('lbi9sdkemb50f11fjcs92ikai2','','PHPSESSID',1366567365,1440,''),('lcltj5p6891bntsrv6196f7eq4','','PHPSESSID',1366564401,1440,''),('ld1ip6oip99jlgahibn0l459v7','','PHPSESSID',1366072712,1440,''),('ld81s5fm4k7hshbjsbb5fqk8n3','','PHPSESSID',1366072301,1440,''),('le3c4o9erejduu0ro8m3lnvsa3','','PHPSESSID',1366566316,1440,''),('le5sjntcg8dkdd6ejk4re989l4','','PHPSESSID',1365904254,1440,''),('lf51gf27bqpfjilqtqdaamqmm3','','PHPSESSID',1366567349,1440,''),('lfcquqh6d8k0tv40oknli4ie86','','PHPSESSID',1367689396,1440,''),('liceekng42jjk54surdjl216f3','','PHPSESSID',1366678067,1440,''),('liog7jhcpefv5t66pgen9v9cu4','','PHPSESSID',1366566330,1440,''),('liqmnuleu198k41rh5jlfh9rj2','','PHPSESSID',1365904712,1440,''),('llj7kavokihct68557p4s3b891','','PHPSESSID',1365904706,1440,''),('lo1ak427bqing7t6vba9r2e8b0','','PHPSESSID',1366072693,1440,''),('lsbgjldqkm17lpob5bfo7qcps1','','PHPSESSID',1366566298,1440,''),('lsbsr5q5j3ce3f9ga2p5l83c36','','PHPSESSID',1366423989,1440,''),('lsipa3s06sp6n08ojcit1dm7k2','','PHPSESSID',1366419471,1440,''),('lsntai891vjucmjjb5bc3j4pb3','','PHPSESSID',1365906109,1440,''),('m2sulj19flkqhtp7lk3epimbp5','','PHPSESSID',1366071595,1440,''),('m36qltna61n48mrpbk5q6og375','','PHPSESSID',1366076245,1440,''),('m5a924e8u82kivtbr755nt0n53','','PHPSESSID',1366566259,1440,''),('m896uam4acak7cjj40jgrlh7i0','','PHPSESSID',1366418932,1440,''),('m8r4ras12d9op8omojbtd2ic05','','PHPSESSID',1366566162,1440,''),('m9qcaoir6itd7920q2vp9blto1','','PHPSESSID',1365904809,1440,''),('mc916o0blfor96hp0rj9tmv8j5','','PHPSESSID',1367703538,1440,''),('mf6iknnhu78aaiqn3gsf14idn5','','PHPSESSID',1366072841,1440,''),('mhggft94umpldhblslo907qfv7','','PHPSESSID',1365906119,1440,''),('mjrlrnr1pmp34272pr39vo1tk6','','PHPSESSID',1366072334,1440,''),('mkonncf5ah5uklb1omlnv857l2','','PHPSESSID',1366418953,1440,''),('ml65t5id9q0ln55lt0pa1tasv0','','PHPSESSID',1365904706,1440,''),('mm8kh4a7m7c45334ctho3fd1p1','','PHPSESSID',1367689331,1440,''),('mnl9o2erc6tq2hrrj3pivagvt0','','PHPSESSID',1366074105,1440,''),('mphnpu45v7m58pk40dpenbma11','','PHPSESSID',1366566260,1440,''),('mrbt0k7rcaal7fokkabp52rhp5','','PHPSESSID',1366074687,1440,''),('ms81cafai2i6eqptlnhfq84dt3','','PHPSESSID',1366071957,1440,''),('mvgsber9qhjb5j2cepbibh45i4','','PHPSESSID',1366074997,1440,''),('n0gvp46q65bium032f5ob1i605','','PHPSESSID',1366072335,1440,''),('n24gac294od8qlo7atou7adet3','','PHPSESSID',1372201902,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1372205502;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1372205502;}}dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"3\";}dlayer_session_form|a:5:{s:7:\"form_id\";i:1;s:4:\"tool\";s:4:\"text\";s:8:\"field_id\";i:1;s:10:\"tool_model\";s:4:\"Text\";s:3:\"tab\";s:4:\"text\";}'),('n2j6cfeql76dda9dbelio8ttm1','','PHPSESSID',1366565718,1440,''),('n311loqqj3h56jqnnk5vjifrh1','','PHPSESSID',1366074529,1440,''),('n8237td8pf88kvb9bcopfsol25','','PHPSESSID',1366677106,1440,''),('n82ncnui30sqa935eb2pm5j1l5','','PHPSESSID',1365903970,1440,''),('n84kt7ddgghmfbcnvpuor1ts84','','PHPSESSID',1366677099,1440,''),('n8vueho6q5co0k4dpea32fgej3','','PHPSESSID',1366565608,1440,''),('na4kfdsdq5n4d8ckgs1s9f2l31','','PHPSESSID',1365904812,1440,''),('nal7l51vs5ft7bo6un4vf2u351','','PHPSESSID',1366677108,1440,''),('ni1dgt0623jtj12heepa0oohk5','','PHPSESSID',1366072151,1440,''),('nl044juk8t8qu4k8a6v7qp6rq5','','PHPSESSID',1366566323,1440,''),('nms839u9bk18i3127vo7sn0j54','','PHPSESSID',1366071679,1440,''),('nqg0mhq2hbg0bkp79rdhegr526','','PHPSESSID',1366418640,1440,''),('nukauo6se86eoi6f91pm3k5606','','PHPSESSID',1366072001,1440,''),('nvccj3pa0gpn8nndqs30c7il54','','PHPSESSID',1365904740,1440,''),('o0vddd06v0eoojibs8ij59v3f1','','PHPSESSID',1366073578,1440,''),('o1fnqufa1sgplv3hkegdd8pil3','','PHPSESSID',1366565631,1440,''),('o4ljmo93ta13lak5jd6quf5cr1','','PHPSESSID',1365904041,1440,''),('o57fbjnov2otc6qp9aic0f3ag5','','PHPSESSID',1366075993,1440,''),('oek27och4nvj53hks5n09metl7','','PHPSESSID',1366075717,1440,''),('oevtav8ocpa93gjuc00h0isbg4','','PHPSESSID',1366565401,1440,''),('og4c2t78uoasbnuf0ga5e9ueu1','','PHPSESSID',1367703108,1440,''),('ogc2npj1cel0ct1egmdjj8dsg1','','PHPSESSID',1366074271,1440,''),('ohi426pglug2rq0qo15d8mf0h0','','PHPSESSID',1366418638,1440,''),('oleo9b3tl4ciii81qva3n3bvn6','','PHPSESSID',1366676849,1440,''),('onc3megps641mo0t0993hl8ck5','','PHPSESSID',1366420369,1440,''),('onnpsvc19026e4rf76l7i5m0p1','','PHPSESSID',1366076276,1440,''),('oo6de06p43n5m7ofacmvamara5','','PHPSESSID',1366072695,1440,''),('ot4mr4i4oqutrarcddlguv7qi5','','PHPSESSID',1366848988,1440,''),('ott3m75th5e1t9u01tposvknm7','','PHPSESSID',1367679830,1440,''),('p0d4sionu8ria6kcvv8naus9f7','','PHPSESSID',1366677193,1440,''),('p23l107mgc6t0trge9rkg3gqu3','','PHPSESSID',1366567404,1440,''),('p24cs1pjoj2lk520uuvvr4cff2','','PHPSESSID',1365904240,1440,''),('p42sgikkue9a7jbcg0fgr8dtp1','','PHPSESSID',1365904307,1440,''),('p7mu5imvqnanbthvn8i4rkor56','','PHPSESSID',1365903969,1440,''),('pa1imvku295vh2aacdr5g53ek7','','PHPSESSID',1365906267,1440,''),('pakv5de6fet5qlip5dr3n9fvv2','','PHPSESSID',1367689343,1440,''),('pberm0pn6f1sv8ra9v5k895f46','','PHPSESSID',1366072885,1440,''),('pdqadkksb5l4rfeocdgc1hdnv3','','PHPSESSID',1366117054,1440,'dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('peo6rns2o4cstgdhscdfd5les4','','PHPSESSID',1367681411,1440,''),('pg59gdnfoa61bqlifr6orfes75','','PHPSESSID',1366075917,1440,''),('pikai9q2bpvnc1tb1p8sjh4f70','','PHPSESSID',1366418968,1440,''),('pjejq5fknsrjsbeljub6k4j3a6','','PHPSESSID',1366073901,1440,''),('pmdenh2qldngvihllts45mlie6','','PHPSESSID',1367679349,1440,''),('pt7j20krierum4f3er9uvukal0','','PHPSESSID',1366566162,1440,''),('pucvuk8g73rsr2q6sspt6qebs5','','PHPSESSID',1366849003,1440,''),('q43vfe7tvjt6jkgdrnml0ucv96','','PHPSESSID',1367700411,1440,''),('q4e6b4l287hu9v5enaorkedd22','','PHPSESSID',1365906001,1440,''),('q4q4jg5va3qg2sdqh5dgd23rn2','','PHPSESSID',1366075398,1440,''),('q53p0tpj8f6i1pt1mqgjfv3m82','','PHPSESSID',1366418951,1440,''),('q5n1kkbc6le529bcu9er1ihil0','','PHPSESSID',1365905275,1440,''),('qamau4i6ikpdipubi5g062hrc4','','PHPSESSID',1367700533,1440,''),('qcj2g3q8of891hvk9fd8qjkuc1','','PHPSESSID',1366566330,1440,''),('qd1ait5i72erv32lku1pdp9kt0','','PHPSESSID',1365904689,1440,''),('qd4n8a0neoo85fjdj1m5mrgqr2','','PHPSESSID',1365912106,1440,'dlayer_session|a:1:{s:7:\"site_id\";N;}'),('qdcabfpoqb4jvbn6mfq0pp4d33','','PHPSESSID',1366072714,1440,''),('qdd5es3el2mfr10m10c9682l60','','PHPSESSID',1367700460,1440,''),('qeps5iga68gnq6n8uads95g456','','PHPSESSID',1366676815,1440,''),('qgrjfqcuk7qd926369lctv4555','','PHPSESSID',1366071594,1440,''),('qjh84j7pn40qqndcbv284qi7i1','','PHPSESSID',1365904043,1440,''),('ql12o7utjf722t5535j6la1017','','PHPSESSID',1365905852,1440,''),('ql9j24veqtrq3eb8d0ahvlusd0','','PHPSESSID',1367680323,1440,''),('qlm0trfdmh566c1ib6l6b035d3','','PHPSESSID',1366418949,1440,''),('qn6tedn28dtqir1pq7rdonnkh6','','PHPSESSID',1367700458,1440,''),('qnih2u4l2631mmm4j666ol74g4','','PHPSESSID',1365904759,1440,''),('qnjpiqa5gejshsp8f8o4t9dhg0','','PHPSESSID',1365905887,1440,''),('qol5kq209r3ul9j6u6l9cj2fk7','','PHPSESSID',1366564916,1440,''),('qp6angef9dvn8u37eqc5801uv2','','PHPSESSID',1365904802,1440,''),('qqcl0f1d9shdpufemdrihadsu2','','PHPSESSID',1365904978,1440,''),('qqgjh6vdegqqdggu5mkm65jl11','','PHPSESSID',1365906392,1440,''),('qrspat8l0on9rge324trkrph34','','PHPSESSID',1366072364,1440,''),('quic7rlm7k19vhmih4davmfl73','','PHPSESSID',1366564904,1440,''),('qv449hkpg5lpmkkq66o5g7qf16','','PHPSESSID',1366565777,1440,''),('r2kif22o6rreb1bjatq0lena95','','PHPSESSID',1366075352,1440,''),('r3bvirqop42v5f5boo2p81jfi6','','PHPSESSID',1366566342,1440,''),('r3fq0o2c27fn6iqltrs8tvnsp3','','PHPSESSID',1366073934,1440,''),('r3it2s6hvbte8efl3pd3ks4h47','','PHPSESSID',1367680080,1440,''),('r3uq1dpme6bdrvdbs01vsl2th5','','PHPSESSID',1366849005,1440,''),('refp86t7h9mqnu1ucb25rehpa3','','PHPSESSID',1367700452,1440,''),('rfhjitnses8nakfpngjm8rhor5','','PHPSESSID',1366073235,1440,''),('rfqtc1j2aft21leoiq66j0ti46','','PHPSESSID',1366418637,1440,''),('rgirq975onmdaospf72tm41br2','','PHPSESSID',1365905449,1440,''),('rgq8o07goa0hgcge6q4rb2bfg4','','PHPSESSID',1365904241,1440,''),('rl9orbvs8og3acl16aim3nb9o2','','PHPSESSID',1365908488,1440,''),('rnrl8hrqkbno5c2atab8opq0s5','','PHPSESSID',1365905274,1440,''),('rp1vui73j0i0gniqodi8lf0994','','PHPSESSID',1366419052,1440,''),('rqkt54cm7r17aq3ep5dtikp3g2','','PHPSESSID',1367689330,1440,''),('s3210q6r5m00kuqqj83qvrtck0','','PHPSESSID',1366677191,1440,''),('s6lal6klpv6bvbiu4uiuujinm3','','PHPSESSID',1366677149,1440,''),('s7ofg5r38l79t2bism0cflgfh6','','PHPSESSID',1366075954,1440,''),('s82itrcn2tsm841jdai8b30732','','PHPSESSID',1366073140,1440,''),('s8laak2658qu84q3go5q3s0i66','','PHPSESSID',1366074590,1440,''),('s8r602lgmfe13qhs9amhlt8j53','','PHPSESSID',1366072302,1440,''),('s9jiev9h238t0i28s0b6oiof97','','PHPSESSID',1366071926,1440,''),('sadkna8dkhlb6t3qbtpg5ttge0','','PHPSESSID',1366565717,1440,''),('sb802oaj2ska6g2r79rrj7lmn6','','PHPSESSID',1367681562,1440,''),('sbpqt604704l5aijt1c5h7gqm2','','PHPSESSID',1367689339,1440,''),('sbq14v72ougm1ak7t6htmkge37','','PHPSESSID',1366677151,1440,''),('sc4328jufj4mdqs5eq56rfre63','','PHPSESSID',1367689513,1440,''),('seov071nvg49n9kpbta34vopg6','','PHPSESSID',1365906227,1440,''),('si2cf4uagslefmvh44ha5aqf94','','PHPSESSID',1366072555,1440,''),('sirdmo7jq2uia48m013k5s9fn6','','PHPSESSID',1366073678,1440,''),('sjn4q9p1a2frll1tnsqq0sonb2','','PHPSESSID',1365905217,1440,''),('skui927c4hhh3tqforn9idtv41','','PHPSESSID',1366850330,1440,''),('sl6brlmtkvqs3p7hkiqd0ql2d4','','PHPSESSID',1366677148,1440,''),('smsc8eq3df0n3mfmnbuf44hlf7','','PHPSESSID',1365903968,1440,''),('snc7d708phsul9q6vgak4p1421','','PHPSESSID',1366073073,1440,''),('snffhpubh871u21qh6r15hgno0','','PHPSESSID',1366072303,1440,''),('soo6h634os6trh8ses7n0fj221','','PHPSESSID',1365905999,1440,''),('spoj75bmsacb8rqjhg4u5rh9c5','','PHPSESSID',1366076274,1440,''),('ssitg2lgoq3cqe64ml219hopa4','','PHPSESSID',1366075716,1440,''),('st7u97l9ork7l98t8kaih2fkn3','','PHPSESSID',1366072359,1440,''),('su3kk5ei3j0ae6bd4pgv7i33j0','','PHPSESSID',1366073071,1440,''),('sv6dmbkohg36cm0aoesbqef8e0','','PHPSESSID',1366566329,1440,''),('t3s569fvlblu70r0uhqr7mlis5','','PHPSESSID',1366074079,1440,''),('t47v00ih1aelbv9mvbe9sc7h03','','PHPSESSID',1366565473,1440,''),('t7dsf20a7ekk6s56p9u0tvfrv2','','PHPSESSID',1366072662,1440,''),('t7jonmvleeoru490qu7colhcj3','','PHPSESSID',1365906382,1440,''),('t96iu0ro1a6iq1ro1i49lgnnv7','','PHPSESSID',1366073167,1440,''),('tarrcef00aivkiauo30lcgqck7','','PHPSESSID',1366073675,1440,''),('td6v4igm2g9h46as4iqs2kksl5','','PHPSESSID',1365904801,1440,''),('tfh53c8e2l57lvj83trc071h17','','PHPSESSID',1366418704,1440,''),('tg7qdsmvcf1dpmaqbr9i6lask3','','PHPSESSID',1366677100,1440,''),('tgbg5b6fap17hffuou29e4ju96','','PHPSESSID',1367684605,1440,''),('thd4vl32uavbn5k21ss9bevo74','','PHPSESSID',1367679915,1440,''),('toeb35rsul1of3o880ccfmqpr4','','PHPSESSID',1366678077,1440,''),('tr386gke2jcs7oira7unvo3jq1','','PHPSESSID',1366677063,1440,''),('tua4jq9udrgn2la3nu9uc0k0q3','','PHPSESSID',1366677110,1440,''),('u13fi3n98emaa7hkcl48bd6ni4','','PHPSESSID',1366420380,1440,''),('u4hfah9rqfjfr44vu029a0n590','','PHPSESSID',1366073843,1440,''),('u4l43dojhjd9uvmpaf0uv2u8l0','','PHPSESSID',1366073962,1440,''),('ue0qh14sgcfcmg2bm0j1du5el3','','PHPSESSID',1365905510,1440,''),('ug7n1svm6ujdbgg1bv3bqoev97','','PHPSESSID',1366072571,1440,''),('ugcd4a0hpk820u0sr6okmmd232','','PHPSESSID',1366566417,1440,''),('uh0namq9nsa7ho80fuleoiqkd6','','PHPSESSID',1366072801,1440,''),('uj4ov9sveafrgofvh2so32ra00','','PHPSESSID',1366567401,1440,''),('ukh71sp2q3vaihtv7jc0rkevj6','','PHPSESSID',1366075095,1440,''),('uki0eidqte3q95vu2sri94hng7','','PHPSESSID',1366071959,1440,''),('umibmmtuelfipiv3p3ubv19bk7','','PHPSESSID',1366074823,1440,''),('uovof5edflr7vg8c1d3ohjt4v0','','PHPSESSID',1366073142,1440,''),('uqmhmvqfctsk9a69aoedia1sj0','','PHPSESSID',1366072406,1440,''),('urf7615jakgn6ikjec4taek565','','PHPSESSID',1366419121,1440,''),('ut9acegdt7gt1vrkpq6hevofo0','','PHPSESSID',1366564902,1440,''),('v0pqru2kbmvlfpqptdlh824t26','','PHPSESSID',1366678186,1440,''),('v1e53b1vgequd3l79riikn7hu0','','PHPSESSID',1366073882,1440,''),('v3d8dg4jeug9cbjk1km03i0sg3','','PHPSESSID',1366076272,1440,''),('v52orh4v6phe3uialu5k82ki06','','PHPSESSID',1366565630,1440,''),('v82sot38pmtgeco3t3aq9kc6j1','','PHPSESSID',1366566325,1440,''),('v84418ge1sofhe5hi3e083p7t3','','PHPSESSID',1366677102,1440,''),('v87g743qpausjh8pdavj70uii3','','PHPSESSID',1369127403,1440,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1369131003;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1369131003;}}dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('ve291mlb54tq188h36nqhni5k0','','PHPSESSID',1366072690,1440,''),('vh0g02hsasuml350v3inuq3oe6','','PHPSESSID',1366848978,1440,''),('vjupf4lsehdsn87ac3pr1rti61','','PHPSESSID',1366419055,1440,''),('vkt2ha6o61s7m5h3cm8hph08t1','','PHPSESSID',1365905549,1440,''),('vl06fmsbc715cvato474i5jcl3','','PHPSESSID',1367681659,1440,''),('vl6jfcr197utr4uma5be7fba22','','PHPSESSID',1366075959,1440,''),('vnh18fr55kupjbl3d4b9uve9d1','','PHPSESSID',1366075854,1440,''),('vrecd8ho13fjpvsfqrj80j8vo0','','PHPSESSID',1366076277,1440,''),('vse3pvd53eihnh1t048sqh4rk0','','PHPSESSID',1366073495,1440,''),('vv6bohel9bg73oafbffaueeq37','','PHPSESSID',1366075479,1440,'');

/*Table structure for table `form_field_attribute_types` */

DROP TABLE IF EXISTS `form_field_attribute_types`;

CREATE TABLE `form_field_attribute_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `form_field_attribute_types` */

insert  into `form_field_attribute_types`(`id`,`name`,`type`) values (1,'Integer','integer'),(2,'String','string');

/*Table structure for table `form_field_attributes` */

DROP TABLE IF EXISTS `form_field_attributes`;

CREATE TABLE `form_field_attributes` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attribute_type_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_type_id` (`field_type_id`),
  KEY `attribute_type_id` (`attribute_type_id`),
  CONSTRAINT `form_field_attributes_ibfk_1` FOREIGN KEY (`field_type_id`) REFERENCES `form_field_types` (`id`),
  CONSTRAINT `form_field_attributes_ibfk_2` FOREIGN KEY (`attribute_type_id`) REFERENCES `form_field_attribute_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `form_field_attributes` */

insert  into `form_field_attributes`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (1,1,'Size','size',1),(2,1,'Max length','maxlength',1),(3,2,'Columns','cols',1),(4,2,'Rows','rows',1);

/*Table structure for table `form_field_types` */

DROP TABLE IF EXISTS `form_field_types`;

CREATE TABLE `form_field_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `form_field_types` */

insert  into `form_field_types`(`id`,`name`,`type`,`description`,`enabled`) values (1,'Text field','text','A single line form input',1),(2,'Textarea field','textarea','A multiple line for input',1);

/*Table structure for table `user_form_field_attributes` */

DROP TABLE IF EXISTS `user_form_field_attributes`;

CREATE TABLE `user_form_field_attributes` (
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
  CONSTRAINT `user_form_field_attributes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_form_field_attributes_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_forms` (`id`),
  CONSTRAINT `user_form_field_attributes_ibfk_3` FOREIGN KEY (`field_id`) REFERENCES `user_form_fields` (`id`),
  CONSTRAINT `user_form_field_attributes_ibfk_4` FOREIGN KEY (`attribute_id`) REFERENCES `form_field_attributes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_form_field_attributes` */

insert  into `user_form_field_attributes`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (1,1,1,1,1,'40'),(2,1,1,1,2,'255'),(3,1,1,2,1,'40'),(4,1,1,2,2,'255'),(5,1,1,3,3,'40'),(6,1,1,3,4,'2'),(7,1,1,5,3,'50'),(8,1,1,5,4,'3'),(9,1,1,6,1,'40'),(10,1,1,6,2,'255');

/*Table structure for table `user_form_fields` */

DROP TABLE IF EXISTS `user_form_fields`;

CREATE TABLE `user_form_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  KEY `field_type_id` (`field_type_id`),
  KEY `enabled` (`enabled`),
  CONSTRAINT `user_form_fields_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_form_fields_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_forms` (`id`),
  CONSTRAINT `user_form_fields_ibfk_3` FOREIGN KEY (`field_type_id`) REFERENCES `form_field_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_form_fields` */

insert  into `user_form_fields`(`id`,`site_id`,`form_id`,`field_type_id`,`label`,`description`,`enabled`) values (1,1,1,1,'Name','Please enter your name',1),(2,1,1,1,'Email','Please enter your email address',1),(3,1,1,2,'Comment','Please enter your comment',1),(5,1,1,2,'Test field','Test field description',1),(6,1,1,1,'Testing text field - Edit','Testing the see if the text field is added - Edit',1);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_forms` */

insert  into `user_forms`(`id`,`site_id`,`name`,`enabled`) values (1,1,'Test form',1);

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
  `margin_top` tinyint(2) unsigned NOT NULL DEFAULT '12',
  `margin_bottom` tinyint(2) unsigned NOT NULL DEFAULT '12',
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
  CONSTRAINT `user_settings_headings_ibfk_6` FOREIGN KEY (`heading_id`) REFERENCES `designer_content_headings` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_headings` */

insert  into `user_settings_headings`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`hex`,`margin_top`,`margin_bottom`,`sort_order`,`enabled`) values (1,1,1,1,3,1,22,'#366092',12,12,1,1),(2,1,2,1,2,1,18,'#366092',12,12,2,1),(3,1,3,1,2,1,16,'#366092',12,12,3,1),(4,1,4,1,2,1,14,'#366092',12,12,4,1),(5,1,5,2,2,1,14,'#366092',12,12,5,1),(6,1,6,1,1,1,12,'#366092',12,12,6,1),(7,1,7,2,1,1,12,'#000000',12,12,7,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content` */

insert  into `user_site_page_content`(`id`,`page_id`,`template_id`,`div_id`,`content_type`,`sort_order`) values (1,1,1,163,1,2),(2,1,1,163,1,3),(3,1,1,163,2,1);

/*Table structure for table `user_site_page_content_text` */

DROP TABLE IF EXISTS `user_site_page_content_text`;

CREATE TABLE `user_site_page_content_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `width` int(4) unsigned NOT NULL DEFAULT '0',
  `padding` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `user_site_page_content_text_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_text` */

insert  into `user_site_page_content_text`(`id`,`page_id`,`content_id`,`width`,`padding`,`content`) values (1,1,1,826,5,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>'),(2,1,2,826,5,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>');

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_background_colors` */

insert  into `user_site_template_div_background_colors`(`id`,`template_id`,`div_id`,`hex`) values (17,1,160,'#999999'),(19,1,159,'#f3f1df'),(20,1,162,'#336699'),(21,1,163,'#f3f1df');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_borders` */

insert  into `user_site_template_div_borders`(`id`,`template_id`,`div_id`,`position`,`style`,`width`,`hex`) values (1,1,161,'top','dashed',5,'#000000'),(2,1,161,'right','dashed',5,'#000000'),(3,1,161,'bottom','dashed',5,'#000000'),(4,1,161,'left','dashed',5,'#000000'),(13,1,163,'top','solid',2,'#000000'),(14,1,163,'right','solid',2,'#000000'),(15,1,163,'bottom','solid',2,'#000000'),(16,1,163,'left','solid',2,'#000000');

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
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_sizes` */

insert  into `user_site_template_div_sizes`(`id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (158,1,158,980,0,190),(159,1,159,980,0,380),(160,1,160,140,0,190),(161,1,161,830,0,180),(162,1,162,140,0,380),(163,1,163,836,0,376),(164,1,164,140,0,95),(165,1,165,140,0,95);

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
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_divs` */

insert  into `user_site_template_divs`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (158,1,1,0,1),(159,1,1,0,2),(160,1,1,158,1),(161,1,1,158,2),(162,1,1,159,1),(163,1,1,159,2),(164,1,1,160,1),(165,1,1,160,2);

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
