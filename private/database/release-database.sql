/*
SQLyog Enterprise v11.51 (64 bit)
MySQL - 5.6.14-log : Database - dlayer
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
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `palette_id` (`palette_id`),
  KEY `color_type_id` (`color_type_id`),
  CONSTRAINT `designer_color_palette_colors_ibfk_1` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palettes` (`id`),
  CONSTRAINT `designer_color_palette_colors_ibfk_2` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palette_colors` */

LOCK TABLES `designer_color_palette_colors` WRITE;

insert  into `designer_color_palette_colors`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (1,1,1,'Black','#000000'),(2,1,2,'Tan','#f3f1df'),(3,1,3,'Dark grey','#666666'),(4,2,1,'Blue','#336699'),(5,2,2,'Dark grey','#666666'),(6,2,3,'Grey','#999999'),(7,3,1,'Blue','#003366'),(8,3,2,'White','#FFFFFF'),(9,3,3,'Orange','#FF6600');

UNLOCK TABLES;

/*Table structure for table `designer_color_palettes` */

DROP TABLE IF EXISTS `designer_color_palettes`;

CREATE TABLE `designer_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palettes` */

LOCK TABLES `designer_color_palettes` WRITE;

insert  into `designer_color_palettes`(`id`,`name`,`view_script`) values (1,'Palette 1','palette-1'),(2,'Palette 2','palette-2'),(3,'Palette 3','palette-3');

UNLOCK TABLES;

/*Table structure for table `designer_color_types` */

DROP TABLE IF EXISTS `designer_color_types`;

CREATE TABLE `designer_color_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_types` */

LOCK TABLES `designer_color_types` WRITE;

insert  into `designer_color_types`(`id`,`type`) values (1,'Primary'),(2,'Secondary'),(3,'Tertiary');

UNLOCK TABLES;

/*Table structure for table `designer_content_headings` */

DROP TABLE IF EXISTS `designer_content_headings`;

CREATE TABLE `designer_content_headings` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_headings` */

LOCK TABLES `designer_content_headings` WRITE;

insert  into `designer_content_headings`(`id`,`name`,`tag`,`sort_order`) values (1,'Page title','h1',1),(2,'Heading 1','h2',2),(3,'Heading 2','h3',3),(4,'Heading 3','h4',4),(5,'Heading 4','h5',5),(6,'Heading 5','h6',6);

UNLOCK TABLES;

/*Table structure for table `designer_content_types` */

DROP TABLE IF EXISTS `designer_content_types`;

CREATE TABLE `designer_content_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_types` */

LOCK TABLES `designer_content_types` WRITE;

insert  into `designer_content_types`(`id`,`name`,`description`) values (1,'text','Text block'),(2,'heading','Heading'),(3,'form','Form');

UNLOCK TABLES;

/*Table structure for table `designer_css_border_styles` */

DROP TABLE IF EXISTS `designer_css_border_styles`;

CREATE TABLE `designer_css_border_styles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `style` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `style` (`style`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Border styles that can be used within the designers';

/*Data for the table `designer_css_border_styles` */

LOCK TABLES `designer_css_border_styles` WRITE;

insert  into `designer_css_border_styles`(`id`,`name`,`style`,`sort_order`) values (1,'Solid','solid',2),(2,'Dashed','dashed',3),(3,'No border','none',1);

UNLOCK TABLES;

/*Table structure for table `designer_css_font_families` */

DROP TABLE IF EXISTS `designer_css_font_families`;

CREATE TABLE `designer_css_font_families` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_font_families` */

LOCK TABLES `designer_css_font_families` WRITE;

insert  into `designer_css_font_families`(`id`,`name`,`description`,`css`,`sort_order`) values (1,'Helvetica','Helvetica, Arial, Nimbus Sans L','Helvetica, Arial, \"Nimbus Sans L\", sans-serif',1),(2,'Lucida Grande','Lucida Grande, Lucida Sans Unicode, Bitstream Vera Sans','\"Lucida Grande\", \"Lucida Sans Unicode\", \"Bitstream Vera Sans\", sans-serif',2),(3,'Georgia','Georgia, URW Bookman L','Georgia, \"URW Bookman L\", serif',3),(4,'Corbel','Corbel, Arial, Helvetica, Nimbus Sans L, Liberation Sans','Corbel, Arial, Helvetica, \"Nimbus Sans L\", \"Liberation Sans\", sans-serif',4),(5,'Code','Consolas, Bitstream Vera Sans Mono, Andale Mono, Monaco, Lucida Console','Consolas, \"Bitstream Vera Sans Mono\", \"Andale Mono\", Monaco, \"Lucida Console\", monospace',5),(6,'Verdana','Verdana, Geneva','Verdana, Geneva, sans-serif',6),(7,'Tahoma','Tahoma, Geneva','Tahoma, Geneva, sans-serif',7),(8,'Segoe','Segoe UI, Helvetica, Arial, Sans-Serif;','\"Segoe UI\", Helvetica, Arial, \"Sans-Serif\"',8);

UNLOCK TABLES;

/*Table structure for table `designer_css_text_decorations` */

DROP TABLE IF EXISTS `designer_css_text_decorations`;

CREATE TABLE `designer_css_text_decorations` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_decorations` */

LOCK TABLES `designer_css_text_decorations` WRITE;

insert  into `designer_css_text_decorations`(`id`,`name`,`css`,`sort_order`) values (1,'None','none',1),(2,'Underline','underline',2),(3,'Strike-through','line-through',3);

UNLOCK TABLES;

/*Table structure for table `designer_css_text_styles` */

DROP TABLE IF EXISTS `designer_css_text_styles`;

CREATE TABLE `designer_css_text_styles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_styles` */

LOCK TABLES `designer_css_text_styles` WRITE;

insert  into `designer_css_text_styles`(`id`,`name`,`css`,`sort_order`) values (1,'Normal','normal',1),(2,'Italic','italic',2),(3,'Oblique','oblique',3);

UNLOCK TABLES;

/*Table structure for table `designer_css_text_weights` */

DROP TABLE IF EXISTS `designer_css_text_weights`;

CREATE TABLE `designer_css_text_weights` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_weights` */

LOCK TABLES `designer_css_text_weights` WRITE;

insert  into `designer_css_text_weights`(`id`,`name`,`css`,`sort_order`) values (1,'Normal','400',1),(2,'Bold','700',2),(3,'Light','100',3);

UNLOCK TABLES;

/*Table structure for table `designer_form_field_attribute_types` */

DROP TABLE IF EXISTS `designer_form_field_attribute_types`;

CREATE TABLE `designer_form_field_attribute_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_attribute_types` */

LOCK TABLES `designer_form_field_attribute_types` WRITE;

insert  into `designer_form_field_attribute_types`(`id`,`name`,`type`) values (1,'Integer','integer'),(2,'String','string');

UNLOCK TABLES;

/*Table structure for table `designer_form_field_attributes` */

DROP TABLE IF EXISTS `designer_form_field_attributes`;

CREATE TABLE `designer_form_field_attributes` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attribute_type_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_type_id` (`field_type_id`),
  KEY `attribute_type_id` (`attribute_type_id`),
  CONSTRAINT `designer_form_field_attributes_ibfk_1` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_types` (`id`),
  CONSTRAINT `designer_form_field_attributes_ibfk_2` FOREIGN KEY (`attribute_type_id`) REFERENCES `designer_form_field_attribute_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_attributes` */

LOCK TABLES `designer_form_field_attributes` WRITE;

insert  into `designer_form_field_attributes`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (1,1,'Size','size',1),(2,1,'Max length','maxlength',1),(3,2,'Columns','cols',1),(4,2,'Rows','rows',1),(5,3,'Size','size',1),(6,3,'Max length','maxlength',1),(7,1,'Placeholder','placeholder',2),(8,2,'Placeholder','placeholder',2),(9,3,'Placeholder','placeholder',2);

UNLOCK TABLES;

/*Table structure for table `designer_form_field_param_previews` */

DROP TABLE IF EXISTS `designer_form_field_param_previews`;

CREATE TABLE `designer_form_field_param_previews` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `field_attribute_id` tinyint(3) unsigned NOT NULL,
  `preview_method_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_attribute_id` (`field_attribute_id`),
  KEY `preview_method_id` (`preview_method_id`),
  KEY `designer_form_field_param_previews_ibfk_1` (`field_type_id`),
  CONSTRAINT `designer_form_field_param_previews_ibfk_1` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_types` (`id`),
  CONSTRAINT `designer_form_field_param_previews_ibfk_2` FOREIGN KEY (`field_attribute_id`) REFERENCES `designer_form_field_attributes` (`id`),
  CONSTRAINT `designer_form_field_param_previews_ibfk_3` FOREIGN KEY (`preview_method_id`) REFERENCES `designer_form_preview_methods` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_param_previews` */

LOCK TABLES `designer_form_field_param_previews` WRITE;

insert  into `designer_form_field_param_previews`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (1,1,1,3),(2,1,2,3),(3,1,7,1),(4,2,3,3),(5,2,4,3),(6,2,8,1),(7,3,5,3),(8,3,6,3),(9,3,9,1);

UNLOCK TABLES;

/*Table structure for table `designer_form_field_types` */

DROP TABLE IF EXISTS `designer_form_field_types`;

CREATE TABLE `designer_form_field_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_types` */

LOCK TABLES `designer_form_field_types` WRITE;

insert  into `designer_form_field_types`(`id`,`name`,`type`,`description`) values (1,'Text','text','A single line field'),(2,'Textarea','textarea','A multiple line field'),(3,'Password','password','A password field');

UNLOCK TABLES;

/*Table structure for table `designer_form_preview_methods` */

DROP TABLE IF EXISTS `designer_form_preview_methods`;

CREATE TABLE `designer_form_preview_methods` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_preview_methods` */

LOCK TABLES `designer_form_preview_methods` WRITE;

insert  into `designer_form_preview_methods`(`id`,`method`) values (1,'field_attribute_string'),(2,'row_attribute'),(3,'field_attribute_integer');

UNLOCK TABLES;

/*Table structure for table `dlayer_development_log` */

DROP TABLE IF EXISTS `dlayer_development_log`;

CREATE TABLE `dlayer_development_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `change` text COLLATE utf8_unicode_ci NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `release` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=386 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_development_log` */

LOCK TABLES `dlayer_development_log` WRITE;

insert  into `dlayer_development_log`(`id`,`change`,`added`,`release`,`enabled`) values (1,'Added a development log to Dlayer to show changes to the application, two reasons, one to spur on my development, two, to show the public what I am adding.','2013-04-05 00:38:16',0,1),(2,'Added a pagination view helper, update of my existing pagination view helper.','2013-04-05 00:38:52',0,1),(6,'Added a helper class to the library, initially only a couple of static helper functions.','2013-04-08 01:20:22',0,1),(7,'Updated the pagination view helper, added the ability to define text to use for links and also updated the logic for \'of n\' text.','2013-04-08 02:03:42',0,1),(8,'Updated the default styling for tables, header rows and table rows.','2013-04-08 02:19:22',0,1),(9,'Added the form for the add text field tool in the forms builder.','2013-04-12 18:15:57',0,1),(10,'Updated the base forms class, addElementsToForm() method updated, now able to create multiple fieldsets within a form, one fieldset per method call','2013-04-14 18:18:04',0,1),(11,'Updated all the help text for the template designer, simpler language.','2013-04-16 18:19:34',0,1),(12,'Added the form for the add textarea tool in the forms builder.','2013-04-20 18:20:36',0,1),(13,'Updated the pagination view helper, can now show either \'item n-m of o\' or \'page n of m\' between the next and previous links.','2013-04-21 18:46:50',0,1),(14,'Added base tool process model for the form builder, working on the add text field process tool model.','2013-04-25 01:37:41',0,1),(16,'Text field can now be added to a form in the form builder, still need to add supporting for editing a field.','2013-05-04 22:44:24',0,1),(17,'Text area field can now be added to the form, edit mode still needs to be added.','2013-05-12 02:27:58',0,1),(18,'Form builder now supports and displayed text area fields which have been added to the form defintion.','2013-05-12 02:28:13',0,1),(19,'Added initial styling for the form builder forms.','2013-05-12 03:12:49',0,1),(20,'The add field forms in the form builder now add the attributes for the text and textarea field types.','2013-05-14 01:48:24',0,1),(21,'Field attributes are now saved to the database and then pulled in the form builder and attached to the inputs.','2013-05-15 01:43:55',0,1),(22,'Reworked the javascript, selector functions have been moved to the module javascript files rather than the base Dlayer object.','2013-05-21 01:49:48',0,1),(23,'Public set methods (div and form field) now check that the given id belongs to the currently set template/form and site.','2013-05-28 01:02:38',0,1),(24,'Form module ribbon forms now show existing values when in edit mode.','2013-06-01 01:26:25',0,1),(25,'Edit mode in place for form text fields and form textarea fields','2013-06-11 00:00:23',0,1),(26,'Updated the template module and template session class, updated names of some logic vars, names more clear, wasn\'t always obvious what a var referred to.','2013-06-12 00:43:42',0,1),(27,'Multi use tool setting was not being respected in the form builder when adding a new field, field id was not being stored in session.','2013-06-16 21:09:23',0,1),(28,'Form fields not being pulled from database in correct order.','2013-06-16 21:09:54',0,1),(29,'Fixed a bug with the expand and contact tabs of the resize tool in the template designer, border widths were not being added to div width meaning that the split positions were not being calculated correctly.','2013-06-19 01:25:20',0,1),(30,'Pagination view helper wasn\'t escaping all developer defined text.','2013-06-25 23:31:43',0,1),(31,'Template module tool process methods now double check that the tool posted matches the tool defined in the session.','2013-06-25 23:51:11',0,1),(32,'Wife had a baby, Jack James','2013-06-28 05:41:00',1,1),(33,'Added the forms for the content headings to the content settings page, initially it just allows the user to update the params for the headings, there is no live preview or formatting.','2013-08-16 02:42:41',0,1),(34,'Added initial styling for the heading setting forms and added initial styling for the heading previews.','2013-08-16 03:37:51',0,1),(35,'Added live preview to the content settings page (header styles) defaults to show saved styles and then on change updates the previews.','2013-08-20 17:10:04',0,1),(36,'Refactored the designer js, all modules, simplifed the base dlayer object and moved all the js that was sitting in view files. Structure of the scripts folder now matches images and styles folders.','2013-08-21 01:46:02',0,1),(37,'Upgraded to jquery-1.10.2, fixed a small jquery issue with chrome, multi-line comment at top of script.','2013-08-22 23:53:30',0,1),(38,'Moved all the jquery required for the initial content module settings into the Dlayer js object.','2013-08-23 23:14:30',0,1),(39,'Added tabs to the content manager settings page, going to be too many settings for one page and the new layout will allow more detail to be given to the user.','2013-08-24 23:15:15',0,1),(40,'Added some default styling to the app, a tags and list items.','2013-08-25 01:57:42',0,1),(41,'Updated static validation helper class, now calls the new colorHex validation class','2013-08-26 02:50:26',0,1),(42,'Removed RGB entries for colours in the database, not required at the moment, going to just use hex values initially.','2013-08-28 00:47:24',0,1),(43,'Updated database and code, all fields relating to colour update to color_hex as that is currently what the field contains, later we can add a colour object is required with the RGB values and palette data, keeping things simple initially.','2013-08-28 00:48:48',0,1),(44,'Added the heading content type view helper to the content module, initially it adds all the header tag styles inline, this will be rectified later.','2013-08-29 02:37:13',0,1),(45,'Added a base font families table to the database and a corresponding font families settings table, allows the user to define the base font family per site/module, as in a base font family for the content manager and then the base font family for forms, support for the widget designer will be added later.','2013-08-29 19:54:42',0,1),(46,'Added the ability to define the base font family in the content module, the value is not currently being used by the designer, that support will be added shortly.','2013-09-06 16:44:18',0,1),(47,'Added a splash page to the app, this will be where the user logs in to get to their control panel.','2013-09-06 22:54:02',0,1),(48,'Re-skinned the app, new styling on the splash page, setting pages, base pages and development log.','2013-09-06 22:54:52',0,1),(49,'Re-skinned the designers, content manager, template designer and form builder','2013-09-09 00:42:34',0,1),(50,'Updated the tool bars in the three designers, tool icons are going to be larger.','2013-09-11 02:57:06',0,1),(51,'Added new tool icons for the template designer, setting the new style for the app, going for a sketchy look.','2013-09-11 15:23:44',0,1),(52,'Added new ribbon helper images for the split vertical and split horizontal tool, in the style of the new tool icons.','2013-09-12 01:34:09',0,1),(53,'Added new ribbon helper images for the resize tool and border tool','2013-09-12 18:30:43',0,1),(54,'Added a font size validator, PHP and JS. Added a hex regex for validation to the Dlayer JS object. Updated all the text in the app, now simpler and more consistent. Added custom titles to all pages. Updated for form formatting in the form builder, now appears against a white preview div.','2013-09-17 01:29:32',0,1),(55,'My standard development practice is to add enabled fields to most tables, the app takes the status fields into account and either processes, adds etc based on the status. Dlayer is an alpha level app at the moment, even though it is small, currently 36 tables, I don\'t need anything complicating the code, as such I have removed the enabled field from most tables. It still exists in a few base tables which control access to modules and access to tools but has been removed elsewhere. As parts of the app get more stable I will add back in the status fields as required.','2013-09-17 22:55:58',0,1),(56,'There was a layout file per module, because of the app design this wasn\'t needed, now use one layout file and the controller has an array of the css and js includes required for the controller actions.','2013-09-18 01:32:41',0,1),(57,'Site id was missing from 6 of the child layout tables, added site id, updated the models and simplified some of the layout queries that no longer need to do a join.','2013-09-19 17:50:13',0,1),(58,'Full app testing, fixed three minor bugs relating to the resize and border tools.','2013-09-20 02:53:29',0,1),(59,'Added a selected state to the toolbar buttons in the template designer, content manager and form builder.','2013-09-21 01:46:45',0,1),(60,'Reworked the template module ribbon data classes, now rely more on the base abstract class and there is less duplication, fixed a small bug when changing borders, incorrect id var was being used.','2013-09-23 15:07:29',0,1),(61,'Reworked the form module ribbon data classes, now rely more on the base abstract class and there is less duplication, system mirrors the more functional template designer.','2013-09-24 02:01:45',0,1),(62,'At the start of building this version of Dlayer I modified my development approach a little for this project. Typically I can plan the models and classes required to solve a problem fairly easily, with Dlayer because of the complexity I opted for a more procedural approach, this allowed me to put in place the structure for the first designer (template designer) which I then duplicated and modified for the form builder and content manager. \r\n\r\nAll three modules ended up with a very similar base, for the last week I’ve been refactoring the code adding core classes and models which handle the majority of the base functionality for each module, the ribbon, tool bars and tool processing code. \r\n','2013-10-01 18:25:30',0,1),(63,'Fixed a bug with the manual split tools, javascript wasn\'t taking the border of the parent element into account when drawing and calculating the split position and size of the new children.','2013-10-02 14:54:15',0,1),(64,'Split the content data methods out into their own models to match the rest of the system and as pre-planning for additional changes. Moved the margin settings for a heading, was defined in the heading styles settings, now defined per heading.','2013-10-02 17:45:30',0,1),(65,'Added new tool icons for the form builder and content manager and updated the cancel image for all three modules, didn\'t match the rest of the images.','2013-10-05 02:28:16',0,1),(66,'Initial content module ribbon development, ribbon classes and models.','2013-10-06 14:09:28',0,1),(67,'Ribbon forms in place for add heading and add text, now need to work on the tool processing code.','2013-10-06 23:35:12',0,1),(68,'Heading tool class now in place, heading can be added to the selected element, get positioned at the end of any existing content, obviously this will change with additional development.','2013-10-09 15:37:52',0,1),(69,'Simple text content block can now be added to the selected element.','2013-10-09 20:35:25',0,1),(70,'Render method on the base view helper was being called twice because of the way it was designer, removed the call to render() in toString() and now call render directly.','2013-10-09 21:09:55',0,1),(71,'Base content view helper, div_id was incorrectly commented as being the id of the div currently selected on the page, for adding content. Code and comments updated to make it clear that it actually refers to the id of the current div in the content data array. Added a method to set the id for the the currently selected div, if any.','2013-10-09 22:50:04',0,1),(72,'Modified the styling, switched to a light theme, going to work better for the alpha due to the limited number of tools in all the modules, darker theme can be added back in as an option later.','2013-10-12 01:03:44',0,1),(73,'Added the ability to edit both the heading and text content types. User chooses a div and then the content block, ribbon updates and they make the required changes.','2013-10-13 12:13:34',0,1),(74,'Set sensible values for text box width and padding, uses the containing div as a guide.','2013-10-13 12:20:32',0,1),(75,'Dlayer - Release 0.01 - Initial alpha release!','2013-10-14 01:39:45',1,1),(76,'There are two exit modes for a tool, multi-use where all session values remain and non multi-use when they are all cleared, for the content manager added a third mode to enable some vars to be kept.','2013-10-15 16:49:06',0,1),(77,'After adding or editing a text block the base content block remains selected, tool and content ids now cleared, better usability than previous set up.','2013-10-15 16:49:23',0,1),(78,'Fixed a small bug with heading tool, view script folder case incorrect, errored on case indifferent servers.','2013-10-23 02:07:17',0,1),(79,'List of sites now pulled from database on home page, adding a link to allow user to activate a site rather than default to the first.','2013-10-24 02:26:17',0,1),(80,'User is now able to choose a new site to work on from the sites list. On selecting the last accessed site is updated so that the next time the user accesses Dlayer the last accessed site is selected. As there is no authentication system yet site changes will affect all users.','2013-10-28 16:54:57',0,1),(81,'Added a validate site id view helper, checks site id exists in session and also a valid site id, later it will also check against the user/auth id.','2013-10-30 01:32:10',0,1),(82,'Added a validate template id view helper, checks template id is valid, as in exists in the database and belongs to the site id in the session.','2013-10-30 01:58:23',0,1),(83,'Added a validate form id view helper, checks form id is valid, as in exists in the database and belongs to the site id in the session.','2013-10-30 02:07:19',0,1),(84,'Added a validate content id view helper, checks content id is valid, as in exists in the database and belongs to the site id in the session.','2013-10-30 02:21:46',0,1),(85,'Template list, page list and form list now come from the database, not static text, design options only show for active item.','2013-11-01 02:38:21',0,1),(86,'Added an activate method to allow the user to switch the template, page or form they are working on with the site.','2013-11-01 23:24:34',0,1),(87,'A user can now create a new site, a site is currently just a unique name.','2013-11-06 01:52:52',0,1),(88,'Added the ability to edit a site, as per add site a site is currently just a unique name, this will develop later.','2013-11-07 01:56:41',0,1),(89,'Updated the formInputsData methods in forms, now checks the return type of model data and then acts accordingly, form elements now check to ensure data index exists before setting value.','2013-11-08 16:57:10',0,1),(90,'Added add and edit template, currently a template is just a unique name for the site.','2013-11-08 16:57:25',0,1),(91,'Added add and edit form, currently a form is just a unique name for the site.','2013-11-09 12:57:30',0,1),(92,'Add and edit new page in place, user needs to choose template to base page upon, enter a name and also the title to use for the page, as the system evolves more will need to be defined. Removed addDefaultElementDecorators() methods from site form classes, no need to override the default in the base form class as nothing was being changed. ','2013-11-10 13:00:52',0,1),(93,'Added my authentication system to Dlayer, because demo usernames and passwords are exposed an account can only login from one location, timeout on session is an hour so if a user exists without logging out the account will become available for another user after an hour. ','2013-11-13 13:01:44',0,1),(94,'Dlayer - Release 0.02 - Minor release, fixed heading tool and made some UX tweaks to tools','2013-10-23 16:38:09',1,1),(95,'Dlayer - Release 0.03 - Minor release, added the base creation tools, new site, template, form and page.','2013-11-10 16:38:53',1,1),(96,'Release messages highlighted in the development log.','2013-11-13 16:46:38',0,1),(97,'Started publically showing updates, SVN log extends much further back in history but I saw no need to transfer messages across.','2013-04-04 16:49:23',1,1),(98,'Site list now pulls sites based on identity. Updated site history table/code and action helper to check site id validity, now all use the current identity.','2013-11-14 01:43:18',0,1),(99,'No longer able to edit the name of the first sample site, used by the history tables and always defaulted if no other data in the system for identity.','2013-11-14 01:45:14',0,1),(100,'Notification next to username/password combinations if the account if currently logged in. Added a \"What is dlayer?\" page, it gives a brief overview of Dlayer and the history behind it.\r\n','2013-11-14 23:50:49',0,1),(101,'Updated database, added defaults for all settings for the three test sites.','2013-11-16 14:48:23',0,1),(102,'Fixed a bug with the activate methods, validate template id action helper was using the wrong session when in the content module.','2013-11-17 19:55:21',0,1),(103,'Added 1 sample site, 1 sample template and 1 sample page for each user, enough to allow people to play.','2013-11-17 19:55:44',0,1),(104,'Dlayer - Release 0.04 - Authentication system in place.','2013-11-17 20:56:23',1,1),(105,'Once you create a page from a template there need to be restrictions in place to either limit what tools can be used on an active template or extra code to manage structural  changes behind the scenes. Until I put some initial restrictions in place I have disabled the template designer, hoping to re-enable it within the next two weeks.','2013-11-17 20:03:54',0,1),(106,'Updated server to PHP 5.4, switched crypt() over to SHA_512, test identity credentials updated.','2013-11-19 01:34:16',0,1),(107,'In the template designer a tool can now be disabled if using it would be destructive. For example when a page is created from a template if the specified template div has content assigned to it on one or more pages, splitting the div would currently make the content appear to disappear. Logic needs to be added to gracefully handle these destructive changes, for now though the app just forbids access.','2013-11-19 17:20:07',0,1),(108,'Added new icons for disabled toolbar buttons, desaturated version of the icon.','2013-11-20 02:15:32',0,1),(109,'Updated the set tool action, when a tool has been disabled in the view the set tool action checks to ensure that the disabled URL can’t be called manually by the user.','2013-11-20 17:40:21',0,1),(110,'Added base font family settings to the form builder module, as per content manager module, value is not yet used in the designer.','2013-11-21 01:23:51',0,1),(111,'Xbox One and Forza 5 released.','2013-11-22 09:00:00',1,1),(112,'Updated the help text in form builder for text and textarea field tools, little more clear on what happens after a field has been added to their form.','2013-11-26 17:24:37',0,1),(113,'Added password tool to form builder, users can now add password fields to their forms.','2013-11-27 02:11:08',0,1),(114,'Temporarily added the resize tool in the template designer to the disabled tools list if template div has content on an active page. I need to develop a system that makes changes to pages in the background when a template is updated, because the resize tool affects more than the selected div I have for now disabled access until I develop the system which updates data between modules.','2013-11-27 15:18:25',0,1),(115,'History of Dlayer split out from the What is Dlayer? page.','2013-11-29 02:12:14',0,1),(116,'Base modifier system in place, this is called when there needs to be interaction between modules, if a user changes something in one module that affects data in another module modifiers can be sent requests to check to see if any changes are required and then make them if necessary.','2013-12-01 02:27:30',0,1),(117,'Border tool re-instated in the template designer when a user chooses to work on a template block which has content applied to it on a page based upon the current template. A change width modifier has been added, this modifier checks all the content items to see if the widths for the containers need to be updated (The width of a page div will change if a border is added, edited or removed on a  template block). ','2013-12-01 02:27:40',0,1),(118,'Dlayer - Release 0.05 - Modifier system, password tool in form builder, new settings for form builder, template designer tool restrictions and general tweaks.','2013-12-01 12:24:18',1,1),(119,'Abstract validate and autoValidate methods moved from base tool class down a level into the base module tool class, additional context data will be needed for validations and it will differ by module.','2013-12-02 17:09:17',0,1),(120,'Container for text content can now no be larger that the page block it is being added to.','2013-12-02 17:23:46',0,1),(121,'Base font family settings set for the content manager and form builder now used in the designers.','2013-12-04 02:14:51',0,1),(122,'Dlayer - Release 0.06 -  Minor release, validation, settings and general small fixes.','2013-12-04 02:15:23',1,1),(123,'Added width and left margin to heading content type, width and left padding when summed can be no larger than the containing page block.','2013-12-13 14:53:05',0,1),(124,'Added a container div around content items in the content designer, js hover and click events moved to the parent container item, this is so that the movement controls will only show for each content item on hover.','2013-12-18 16:22:43',0,1),(125,'Movement controls added to content items, not yet active.','2013-12-21 21:12:43',0,1),(126,'Content items in the content manager can now be moved around, the user needs to select the page block then as they hover over the content items up and down movement links appear.','2013-12-23 12:30:41',0,1),(127,'Dlayer - Release 0.07 - Minor release, content items can be moved and heading content item updated.','2013-12-23 12:32:08',1,1),(128,'Removed the mode switching buttons, don\'t really do anything yet, also, not sure where to add them in the new designer yet.','2014-01-12 11:10:16',0,1),(129,'Updated the styling in the template designer, matches the new design.','2014-01-14 11:31:16',0,1),(130,'Modified the base width of the app, now 1366 pixels, this will match the Windows 8 version of Dlayer when developed. All the base pages have been updated along with the setting sections.','2014-01-10 14:17:40',0,1),(131,'Expand and Contract options for resize tool now no longer shows the options that can\'t be used for the selected block, previously all options were shown and the form button was disabled if not relevant. The ribbon has been moved to the right hand side below the tool buttons, no longer pushes the design down.','2014-01-15 01:03:54',0,1),(132,'Updated the styling in the content manager, matches the new design.','2014-01-15 01:22:00',0,1),(133,'Updated the styling in the form builder, matches the new design.','2014-01-16 00:14:18',0,1),(134,'Fixed the content manager heading tool, the left margin value wasn\'t being passed through in the post data array, this was causing the validate method to return FALSE and the tool to never process correctly. The heading tool now checks the size of the page block it is being added, this is done so that sensible defaults can be calculated and to ensure that a user can\'t add a heading container which is larger than the page block.','2014-01-17 15:10:25',0,1),(135,'When I resized the designers I realised I had sinned, the width and heights were defaulted within the code, now corrected, there is no such thing as a value that won\'t need to be changed at some point during the projects life.','2014-01-17 15:24:09',0,1),(136,'Reworked the toolbar panels, now only show tools when relevant, the selected tool is clearer and styling has been updated. Tool options styling has been simplified, forms are now clearer.','2014-01-19 00:54:04',0,1),(137,'Top menu updated to show state.','2014-01-19 01:35:16',0,1),(138,'Add new site wasn\'t creating three default palettes for the user, later users will be able to define their own palettes during create site or modify the default palettes.','2014-01-19 16:18:05',0,1),(139,'Adding a new website now inserts initial values for the content manager heading styles, can be updated by the user in the settings.','2014-01-19 19:49:50',0,1),(140,'Adding a new website now inserts initial values for the base font family to use in the content manager and form builder.','2014-01-19 20:50:07',0,1),(141,'If there is no data for a new user a sample site is created, three colour palettes are created and default values are set for the heading styles and base font family settings. Pages, templates and forms are not created, when the designers are more functional there will be sample templates, forms and pages for the sampkle site.','2014-01-20 15:36:40',0,1),(142,'Dlayer - Release 0.08 - New release, new cleaner design for all the designers, bugs fixes and tweaks.','2014-01-20 15:37:34',1,1),(143,'Database work to support allowing a form to be imported as a content item.','2014-01-20 22:16:01',0,1),(144,'Updated \'What is Dlayer?\' page.','2014-01-21 01:20:54',0,1),(145,'Minor style and content changes.','2014-01-22 00:33:56',0,1),(146,'Additional base development to allow forms to be added a content item.','2014-01-24 00:34:24',0,1),(147,'Dlayer - Release 0.09 - Minor release, contains the base code which I will build to allow forms to be added as content items in the form builder.','2014-01-24 00:37:35',1,1),(148,'Custom option for background color now allows the user to choose a color using the HTML5 color picker.','2014-01-24 16:06:27',0,1),(149,'Upgraded the tool controls in the template design, now using HTML5 elements where appropriate.','2014-01-24 16:12:42',0,1),(150,'Upgraded the tool controls in the content manager and form builder, now also using HTML5 elements where appropriate.','2014-01-24 16:46:53',0,1),(151,'Updated the content manager heading style setting forms, now use HTML5 elements where appropriate.','2014-01-24 16:56:28',0,1),(152,'Dlayer - Release 0.10 - Minor release, added custom option for back colour in the template designer and switched a few form elements over to HTML5','2014-01-25 00:58:06',1,1),(153,'Dlayer - Release 0.11 - Minor release, housekeeping','2014-01-25 16:54:44',1,1),(154,'Added ability to define placeholder text for text, text area and password tools in the Form builder.','2014-01-25 22:12:15',0,1),(155,'Styling updates, also added another font family to the base font family settings.','2014-01-26 17:12:32',0,1),(156,'Reworked the settings pages, now possible to jump between modules without having the leave the settings section.','2014-01-27 01:30:01',0,1),(157,'Added a footer to the app, provides access to development log and development plan when in the designers.','2014-01-27 01:48:12',0,1),(158,'Import form tool added to tool bar and relevant entries added to database, data form not yet in place.','2014-01-27 02:15:14',0,1),(159,'Show identity (email) on menu bar to assist users that use more than one account.','2014-01-28 01:16:44',0,1),(160,'Inputs all displays for the import form tool.','2014-01-28 01:35:20',0,1),(161,'Updated the definition for the module session reset methods, wasn\'t completely clear about what would be cleared. Initial validation in place for import form tool, doesn\'t yet calculate and approximate width for a form and whether it will fit in the page block, that will be added later.','2014-01-29 16:32:05',0,1),(162,'Development plan now shows progress messages.','2014-01-29 16:45:21',0,1),(163,'Import form tool in content manager allows user to add form as a content item, not yet rendered in the designer or or editable.','2014-01-30 00:50:55',0,1),(164,'Content manager design view now shows the imported form, styling is not working correctly.','2014-01-30 21:29:25',0,1),(165,'Added ability to move form content items around in the content manager, same movement controls as text and heading content items.','2014-01-31 16:13:22',0,1),(166,'Updated select and move js, with earlier tools, content type and tool where the same, that changed with the import form tool.','2014-01-31 20:34:31',0,1),(167,'Updated process controller in content manager, needed to stop using tool for processing, no longer always going to match the content type so need separate vars.','2014-02-01 16:25:06',0,1),(168,'Added ability to edit the details for the selected form in the content manager.','2014-02-01 16:29:02',0,1),(169,'Updated container width modifier, now looks at form content items.','2014-02-01 22:19:27',0,1),(170,'Added a page for known bugs.','2014-02-01 22:32:53',0,1),(171,'Dlayer - Release 0.12 - Major milestone release, three modules are now communicating with each other, the Template designer, Form builder and Content manager. The import form tool is now in place, a form can be added as a content item. All forms retain their links with the Form builder so changes are shown immediately.','2014-02-01 22:56:51',1,1),(172,'Styling updates. Designer hover styling, text area font size and also the movement controls in the content manager.','2014-02-03 17:07:54',0,1),(173,'Moved model methods required by modifiers into their own model classes, need to keep separate from the general user processing code.','2014-02-04 01:05:32',0,1),(174,'Both setting menus, section and setting now come from the database, tied to the modules so settings groups and settings will only show if module, group and setting are active.','2014-02-07 15:43:05',0,1),(175,'Updated the currently disabled modules, been lots of base changes that hadn’t be carried across, now all consistent.','2014-02-08 11:01:48',0,1),(176,'Updated the content module tool and model classes, much clearer now because the content type will not always match the tool type, method names were not obvious.','2014-02-10 16:40:13',0,1),(177,'Added a mover view helper, generates the html for the movement controls in the content manager.','2014-02-11 17:14:13',0,1),(178,'Added movement controls view helper for form builder.','2014-02-12 17:00:35',0,1),(179,'Added ability to move form fields around on the form, same controls as content manager.','2014-02-14 00:56:56',0,1),(180,'Stopped showing the move up and move down controls for the first and last form fields respectively.','2014-02-14 01:52:37',0,1),(181,'Dlayer - Release 0.13 - Maintenance release, reworked some of the tools code and added ability to move assigned form fields around.','2014-02-14 14:44:20',1,1),(182,'Dlayer - Release 0.14 - Bug fix release, a couple of bugs appeared in the last version, now fixed, affected text modifier and add text tool.','2014-02-16 22:37:12',1,1),(183,'Updated the tools, removed fields and logic no longer required now that the tools are text buttons not images.','2014-02-17 11:08:21',0,1),(184,'Web site manager framework code in place, still working on the preview.','2014-02-18 23:05:17',0,1),(185,'Content update, A bug was listed in the development plan but really needed to also be in the bugs section. Added new sections to the development plan.','2014-02-19 17:04:23',0,1),(186,'Dlayer - Release 0.15 - Content release, new content and also includes base code required by the Website manager.','2014-02-19 17:09:11',1,1),(187,'Minor styling updates to tools and tool options/ribbon.','2014-02-24 01:02:52',0,1),(188,'Initial preview design for web site manager added, non functional, just shows initial tools and controls.','2014-02-24 17:09:24',0,1),(189,'Dlayer release 0.16 - Web site manager preview.','2014-02-24 17:17:17',1,1),(190,'Initial design for the colour picker in place, not yet functional.','2014-02-27 01:30:49',0,1),(191,'Colour picker shows the live data for the three palettes.','2014-03-02 16:48:15',0,1),(192,'Added a history table for used colours, colour picker now shows the last five used unique colours.','2014-03-03 00:30:10',0,1),(193,'Added colour picker to custom tab of background colour tool, allows user to choose colour from palettes, history and create a custom colour, history section not yet updated with new values.','2014-03-03 02:00:51',0,1),(194,'Moved all colour picker logic into a view helper, will be called multiple times within app, developer gets to define which of the three sections they want to include in the picker.','2014-03-04 02:21:44',0,1),(195,'Added colour picker to both tabs of the border tool. Switched colour picker to be a class rather than an id, javascript was failing with ajax caching issue, not all close.','2014-03-06 02:04:45',0,1),(196,'Dlayer - Release 0.17 - Colour picker in place in Template designer.','2014-03-06 09:20:17',1,1),(197,'Updated the help tabs for the three active tools in the Content manager, give a more detailed overview of the tool.','2014-03-06 11:00:37',0,1),(198,'Content manager tools updated, added the ability to allow tabs which only show in edit mode, for each tool this is currently a styling tab.','2014-03-06 16:28:34',0,1),(199,'Extended Zend forms, added a colour picker input, includes hidden element for value and the div invoke the picker.','2014-03-06 16:41:45',0,1),(200,'Updated the help tabs for the five active tools in the Template designer, give a much more detailed overview for each tool.','2014-03-06 17:04:04',0,1),(201,'Modifying the tool system in the Content manager to support sub tools.','2014-03-07 23:48:53',0,1),(202,'Added the forms and view data for the container styling tab of the text tool.','2014-03-07 23:50:24',0,1),(203,'Added ability to define whether a clear link should be added after the colour selector, with container styling it is valid that a user want to reset a colour.','2014-03-08 01:25:20',0,1),(204,'Modified the Content manager process controller to look to see if request should be sent to a sub tool rather than the base tool for the content item type.','2014-03-09 17:27:50',0,1),(205,'Sub tool in place which allows a user to define the background colour for a text content item, edit the colour and then clear the colour if they want to.','2014-03-11 02:47:09',0,1),(206,'Renamed style view helper classes, responsible only for templates so changing name accordingly to make way for content versions.','2014-03-12 16:00:15',0,1),(207,'Text content item containers now use the background colour defined in the tools styling tab.','2014-03-13 17:26:36',0,1),(208,'TitanFall released on PC.','2014-03-14 16:21:07',1,1),(209,'Edit mode Content manager, selecting a different tool wasn\'t clearing the content id, tabs which should only appear in edit mode were showing for other content tools.','2014-03-14 16:34:22',0,1),(210,'Mouse cursor now correctly switching when choosing a page block.','2014-03-14 16:37:15',0,1),(211,'Added a styling tab to the heading content item tool when in edit mode, allows user to define background colour for heading container.','2014-03-14 16:46:15',0,1),(212,'Content tools set to multi use, return user back to editor with tool still selected.','2014-03-16 16:51:59',0,1),(213,'Added ability to define a background colour for an imported form item, use styling tab.','2014-03-16 16:52:06',0,1),(214,'Dlayer - Release 0.18 - Added a styling tab to each of the Content manager tools.','2014-03-16 16:59:49',1,1),(215,'Updated all the Content manager tool forms, now all derive from a base form for the Content manager, this extends the base Dlayer form. Updated all the Content manager tool data classes, now all derive from a base tool data class for the Content manager, this extends the base tool class.','2014-04-02 16:51:29',0,1),(216,'Fixed a bug with Template designer, unable to select base block with a new template.','2014-04-07 15:58:21',0,1),(217,'Edit field forms in the Form builder not always behaving correctly, occasionally a new field was being added rather than the selected one being edited. Updated all the Form builder tool forms, now all derive from a base form for the Form builder, this extends the base Dlayer form.','2014-04-07 16:22:51',0,1),(218,'Fixed a bug with create site script, was attempting to create an extra heading that couldn\'t be referenced back to designer headings.','2014-04-07 16:30:59',0,1),(219,'Added a base form class for app level forms, updated all base level forms to extend new base class.','2014-04-10 17:22:05',0,1),(220,'Create site script now inserts initial values into the colour history table.','2014-04-12 16:40:47',0,1),(221,'Fixed a few minor bugs found during pre release testing.','2014-04-12 17:03:36',0,1),(222,'Minor styling updates to designers.','2014-04-13 01:10:03',0,1),(223,'Dlayer - Release 0.19 - Maintenance release, refactoring, tweaks and bug fixes.','2014-04-13 01:57:20',1,1),(224,'Added field type to Form builder tools, works in conjunction with tool value for when the tool and field type don\'t match, an example being the email field which is a text field.','2014-04-14 02:41:31',0,1),(225,'Styling issue with tool forms, some fields not displaying using the correct font families.','2014-04-15 01:27:44',0,1),(226,'Added a name and email tool to the form builder, these are quick versions of the text tool, values preset. Currently only the field values are preset, as the system evolves validation values and other attributes will be preset as well.','2014-04-15 16:15:33',0,1),(227,'Updated form builder in designer, wasn\'t selecting the correct tool when editing using a quick tool, name and email.','2014-04-15 16:44:32',0,1),(228,'Form builder now has field type and tool as properties, updated selectors and movers to take new params into account, new name and email fields where being selected as text fields, their base type.','2014-04-16 01:51:13',0,1),(229,'Updated maintenance page, text wasn\'t accurate.','2014-04-17 16:33:13',0,1),(230,'Dlayer - Release 0.20 - Added two quick tools to the Form builder, name and email, these add a pre populated text field, as the Form builder develops these tools will add the correct validation rules and set other options. ','2014-04-17 16:34:48',1,1),(231,'Added position tab to Import form tool, has inputs for top, right, bottom and left.','2014-04-22 01:46:26',0,1),(232,'Added position tab to heading and text content item tools, not yet functional.','2014-04-23 01:29:30',0,1),(233,'Updated margins container table in database, fields don\'t need margin_ prefixed, margin table so top, right, bottom and left is sufficient.','2014-04-25 16:51:38',0,1),(234,'Added position model, will be used by the Content manger sub tools.','2014-04-25 16:56:57',0,1),(235,'Styling tab of text content tool now adds the position values (margins) to the database, can be updated and deleted dependant on posted data.','2014-04-27 13:23:34',0,1),(236,'Content item view helper now uses defined margin values.','2014-04-28 01:57:05',0,1),(237,'Content text view helper now correctly sizes the selectable content item container if margin (position) values have been set.','2014-04-28 16:51:21',0,1),(238,'Edit text content item updated, validation now includes container position (margin) values when calculating if content item will be larger than the page container.','2014-04-28 17:21:33',0,1),(239,'Updated Container width modifier, now aware of position values (margin) for a text content item. margin values only used in calculations, not modified, this will change in a later development branch as the modifier system gets more smart, it should prioritise margin changes over content item width changes.','2014-04-29 02:21:38',0,1),(240,'Position tab disabled for Heading and Import form tools, will be enabled in next release.','2014-04-29 02:24:15',0,1),(241,'Updated the modifier system, now aware of margin values (position) on text content items, value taken into account when calculating how the width needs to be adjusted.','2014-04-30 16:03:20',0,1),(242,'Dlayer - Release 0.21 - Position tab added to text content item tool.','2014-04-30 17:21:52',1,1),(243,'Added heading position and import form position sub tools.','2014-05-01 16:15:07',0,1),(244,'Enabled position tabs for Heading and Import form tools.','2014-05-01 16:16:37',0,1),(245,'Updated the form and heading view helpers, now aware of container margins.','2014-05-01 16:35:11',0,1),(246,'Updated modifier system, now aware of margins applied to form and heading content containers.','2014-05-02 01:23:57',0,1),(247,'Updated login page, focus now goes straight to username.','2014-05-02 01:36:24',0,1),(248,'Dlayer - Release 0.22 - Position tab added to import form and heading tools.','2014-05-02 01:42:41',1,1),(249,'Removed the headings from the content sub tools tabs, duplicated tab text and pushed text/controls down.','2014-05-02 14:55:37',0,1),(250,'Added three preset links to the import form tool position tab, sets the margin values to left, right and center align the selected content item.','2014-05-02 16:46:53',0,1),(251,'Preset links added to the heading and text tools position tabs, same functionality as import form.','2014-05-02 16:48:40',0,1),(252,'Quick tools in Form builder (name and email) no longer show the form when the user is adding the field, only when they are editing the field.','2014-05-03 15:30:46',0,1),(253,'Dlayer - Release 0.24 - UX improvements.','2014-05-03 15:48:14',1,1),(254,'Added support for edit mode only tool tabs in the Form builder, same functionality as the Content manager.','2014-05-04 16:13:27',0,1),(255,'Updated Content manager process controller, now knows to look for sub tools.','2014-05-04 16:16:30',0,1),(256,'Added styling sub tool to Form builder text tool, shows control which will allow a background colour to be set for the row, not yet functional, just display at this point.','2014-05-04 23:08:13',0,1),(257,'Styling sub tool for text field now allows a user to define row background colour, update it and delete it.','2014-05-05 15:45:22',0,1),(258,'Form builder now displays the assigned styles in the designer view.','2014-05-09 16:09:28',0,1),(259,'Moved content view models, placement didn\'t fit with addition of content style view models.','2014-05-09 16:33:51',0,1),(260,'Defined background colours for form field rows now appear when in the Content manager.','2014-05-10 01:15:29',0,1),(261,'Added styling tab to textarea tool in Form builder, only shows when editing a field.','2014-05-10 01:40:49',0,1),(262,'Added styling tab to Name, Email and Password tools, as per other sub tools, only shows on edit.','2014-05-12 21:49:51',0,1),(263,'Fixed bug with select content item in Content manager, when a margin is applied content item not selectable when user clicks margin around item.','2014-05-12 22:21:18',0,1),(264,'Fixed bug in Form builder, after addition quick fields not remaining selected.','2014-05-12 22:21:33',0,1),(265,'Updated sample data for websites.','2014-05-12 22:26:20',0,1),(266,'Dlayer - Release 0.25 - Styling tab in Form builder.','2014-05-12 22:35:08',1,1),(267,'Fixed a bug with the manual split tools in template designer, occasionaly not sending request through.','2014-05-13 15:25:52',0,1),(268,'Added an information block in Content manager when both page container and tool selected, gives width of content container and its height.','2014-05-13 15:25:58',0,1),(269,'Added page container metrics blocks to Template designer, shows when a page container and tool are selected.','2014-05-19 11:44:17',0,1),(270,'Fixed a bug with the split tools, by default all newly creating blocks are now fixed height, converted to dynamic height automatically if children are added, another split. - Later the system will allow the user to override this and set the height manually, either pixels or dynamic.','2014-05-19 11:57:47',0,1),(271,'Page container metrics in Template designer and Content manager now hidden behind toggle.','2014-05-19 12:21:49',0,1),(272,'Dlayer - Release 0.26 - Added page container metrics blocks to Content manager and Template designer and fixed two bugs in the Template designer.','2014-05-19 15:44:38',1,1),(273,'Added the html and styling for the content item metrics section in the Content manager, also included the JS to toggle the metrics.','2014-05-24 17:09:37',0,1),(274,'Content manager now shows content item metrics for text content items.','2014-05-25 16:53:31',0,1),(275,'Content item metrics block now shows correct data for heading and form content types.','2014-05-26 01:09:57',0,1),(276,'All tools that use a colour now write to the colour history table, previously the colour palette was showing 5 static history colours.','2014-05-26 16:25:19',0,1),(277,'Updated site content.','2014-05-26 23:57:02',0,1),(278,'Refactoring.','2014-05-27 00:23:16',0,1),(279,'Dlayer.com - Release 0.27 - Content item metrics and colour picker history.','2014-05-27 12:24:14',1,1),(280,'Added in js to preview form field label changes, updates designer live, if the field is marked as required in the tool form clearing the value resets it to the initial value.','2014-05-27 15:36:21',0,1),(281,'Updated the live preview js, now two base methods, one that deals with html element values and one that handles form field attribute values.','2014-05-28 00:44:48',0,1),(282,'Message now displays when data needs to be saved, displays above form when any data is modified, called by the preview functions.','2014-05-28 00:59:03',0,1),(283,'Updated the preview methods for form field params, now aware of types, strings and integers, only process when values are valid. Added tables to manage links between preview methods and form field attributes base on attribute type.','2014-05-28 16:11:39',0,1),(284,'Preview js methods and data now pulled from the database for the selected field, currently limited to text fields.','2014-05-29 17:08:36',0,1),(285,'Form builder was not using correct builder method for name and email inputs, needs to use custom method so later specific validation rules and options can be set. Data changed method (form builder edit preview) firing sometimes when data hadn\'t changed. Updated the styling for the Data changed message, now can\'t be missed','2014-05-31 15:43:32',0,1),(286,'Edit previews now displays for all form builder field types.','2014-05-31 16:01:52',0,1),(287,'Created the js for the row background colour change preview. Modified the selected style, now includes a top and bottom border for when the user clears the row background colour, this way the selected item is still visible. Colour picker now triggers a change even on the hidden input used to store the colour.','2014-06-01 00:45:37',0,1),(288,'Existing data for row background colour now passed through to js preview methods. Updated the ribbon data classes, edit mode is now passed through to all data classes to reduce work in default tool mode.','2014-06-01 15:38:18',0,1),(289,'Dlayer.com - Release 0.28 - Form builder now has live previews when form data is being amended.','2014-06-01 15:53:20',1,1),(290,'Moved preview data for editing field data from controller to ribbon data classes as per styling preview data.','2014-06-02 14:38:10',0,1),(291,'Preview code to set original value if field empty was overriding changed values on keyup (tab)','2014-06-02 14:44:48',0,1),(292,'Clear link for row background colour now correctly clears the background colour in the picker and the form field row. Need to add a reset link to return the value to the original value if it existed.','2014-06-02 14:53:51',0,1),(293,'Added tab to import form tool in Content manager, include a link to jump directly to Form builder (non functional)','2014-06-02 15:14:09',0,1),(294,'Link now takes user directly to Form builder with form selected.','2014-06-02 15:46:58',0,1),(295,'Link now appears in Form builder when a user jumps to it from the Content manager, takes them back to exactly where they were.','2014-06-02 15:59:57',0,1),(296,'Dlayer - Release 0.29 - Preview system bug fixes and module jumping.','2014-06-03 01:03:44',1,1),(297,'Added data tables for text and heading content to database.','2014-06-03 12:21:27',0,1),(298,'Text and heading data now pulled from linked data tables, no longer static in the content container item tables.','2014-06-03 13:04:05',0,1),(299,'Heading and text tools forms updated, now pull data from the linked data tables. Add and edit not yet updated to write to new table and check for duplicate content.','2014-06-03 13:24:51',0,1),(300,'Added name to text and heading tool forms, will be used to identity text data items so they can easily be re-used.','2014-06-03 13:47:47',0,1),(301,'Updated heading and text tools, now aware of content data tables and either insert new content data item or fetch id of existing data item based on supplied content.','2014-06-04 16:29:14',0,1),(302,'Minor styling updates for all forms.','2014-06-05 01:05:58',0,1),(303,'Dlayer - Internal release 0.30 - Text and heading content tools reference based.','2014-06-09 16:39:51',1,1),(304,'Updated all ribbon data classes, edit mode boolean now passed in so it can be forwarded to forms.','2014-06-10 10:43:26',0,1),(305,'Edit mode status boolean made available to all ribbon forms.','2014-06-10 12:01:17',0,1),(306,'Instances select added to edit heading and text tools, when the content item data is being used by more than the selected content item the user now has a choice about whether to update the text data for all instances or just the selected content item - not yet functional, just displays option when appropriate.','2014-06-10 12:38:17',0,1),(307,'Heading and text tools correctly update data based on the instances option.','2014-06-10 23:40:59',0,1),(308,'Dlayer - Release 0.31 - Text data for text and heading tools now assigned by reference, not static, text data can be used by multiple items.','2014-06-12 10:39:26',1,1),(309,'Import text tool added, currently not functional, forms and tool classes created.','2014-06-13 15:19:33',0,1),(310,'Initial AJAX in place to populate the textarea when the user chooses to text to import.','2014-06-14 00:49:30',0,1),(311,'Import tool now functional, allows used to choose existing text to import into a new content container.','2014-06-14 23:08:24',0,1),(312,'Updated form class, added a view mode param, in view mode ids are not added to form field rows.','2014-06-14 23:54:45',0,1),(313,'Updated settings, when base level is selected, user now directed to first setting within group.','2014-06-15 00:12:57',0,1),(314,'Dlayer - Release 0.32 - Added import text tool.','2014-06-15 00:19:56',1,1),(315,'Updated the help text for the import text tool.','2014-06-15 14:51:59',0,1),(316,'Added import heading tool, same functionality as import text tool.','2014-06-16 01:21:48',0,1),(317,'Dlayer - Release 0.33 - Added import heading tool.','2014-06-16 01:30:59',1,1),(318,'Added highlight effect to form field preview changes in form builder. Slightly modified tool controls styling.','2014-06-16 13:34:35',0,1),(319,'Added live edit preview for set content container background colour in Content manager.','2014-06-16 23:51:24',0,1),(320,'Added live edit preview for container container position updates.','2014-06-17 00:36:27',0,1),(321,'Moved all js back into a single file, Dlayer object being split over multiple files was causing issues with code completion, will split later in development.','2014-06-17 15:11:05',0,1),(322,'Created base js functions which will update the width and padding for a content container taking into account all the other attributes that affect the total width of an item.','2014-06-17 17:03:01',0,1),(323,'Created base js functions which will alter individual padding values, both top and bottom which don’t affect container width and left and right which do.','2014-06-17 17:26:52',0,1),(324,'Created base js functions which will alter content item content.','2014-06-18 01:00:58',0,1),(325,'Moved everything to GitHub after Codespaces.com collapsed.','2014-06-18 17:01:05',1,1),(326,'Tested preview functions for heading tool, text tool and import form tool, all function correctly.','2014-06-19 00:34:41',0,1),(327,'Data for previews now passed from ribbon data class to view.','2014-06-19 11:41:50',0,1),(328,'Dlayer - Release 0.35 - Live previews in Content manager. (Release 0.34 was to test git release management)','2014-06-19 13:06:56',1,1),(329,'Removed all the old js files now that the entire Dlayer object is within a single file. Updated environment settings, couple of minor issues after initial release from github.','2014-06-19 16:41:53',0,1),(330,'Tool tab switch now looks at the preview state properties, if there are unsaved changes the designer does a window.replace after switching the tab, this resets the designer view.','2014-06-20 02:00:29',0,1),(331,'Moved all preview state vars and methods above module properties.','2014-06-20 02:10:01',0,1),(332,'Updated base font styling for Dlayer. Modified the layout and styling for the setting pages.','2014-06-20 15:29:39',0,1),(333,'Updated margin (position) preview methods, weren\'t taking into account other attributes which affect container width.','2014-06-21 01:04:52',0,1),(334,'Preset position quick links now trigger the margin preview methods.','2014-06-21 01:08:07',0,1),(335,'Dlayer - Release 0.36 - Fixed live preview and other minor tweaks.','2014-06-21 15:06:43',1,1),(336,'Styling updates for notices and development messages. Now unable to import form if not forms exist for site. Create new page form no longer shows if no templates exist for site. Content updates.','2014-06-23 01:55:07',0,1),(337,'The base div for a template is now a real div, as such all the Template designer tools can now be used on it increasing design options.','2014-06-23 01:56:15',0,1),(338,'Dlayer - Release 0.37 - Initial template div now a \'real\' div.','2014-06-23 02:04:52',1,1),(339,'Content updates: Updated the default tool bar text in Form builder and development plan.','2014-06-24 13:10:21',0,1),(340,'Added ability to define the minimum width for a form in the Form builder, first of many settings.','2014-06-24 15:24:41',0,1),(341,'Form builder now shows the form at the requested minimum width, defaults to 600 pixels.','2014-06-24 16:29:51',0,1),(342,'Import form tool updated, on add the tool checks to ensure submitted width is not smaller than the minimum form width, on edit the width field is updated with a min attribute.\r\n','2014-06-24 17:04:30',0,1),(343,'Add new form now inserts a default value for minimum width, for now the value is defined as 600.','2014-06-24 17:19:29',0,1),(344,'Dlayer - Release 0.38 - First form option added, minimum width, also partly resolved one of the known bugs.','2014-06-24 17:23:30',1,1),(345,'Added ability to define form legend to form settings tool.','2014-06-25 01:19:49',0,1),(346,'Updated Form builder and Content manager, legend now show on all user created and imported forms.','2014-06-25 01:33:48',0,1),(347,'Added description for pages, on both add and edit page forms.','2014-06-25 02:08:58',0,1),(348,'Updated top menu, designer menu item is now a drop down that includes links to the other designers.','2014-06-25 15:01:31',0,1),(349,'Updated form settings tool, can now define the submit button text.','2014-06-25 16:26:31',0,1),(350,'Dlayer - Release 0.39 - More form settings.','2014-06-25 16:30:09',1,1),(351,'Design colours were not consistent across entire site, now are.','2014-06-26 15:22:27',0,1),(352,'Initial module code in place for Image library, need to work on layout.','2014-06-30 14:50:03',0,1),(353,'Image library ribbon data classes in place, differ to other ribbon data classes because three ids can exist, image, category and sub category.','2014-07-01 22:56:03',0,1),(354,'Preview of add category tool in place in Image library.','2014-07-02 00:11:30',0,1),(355,'Additional improvements to form styling.','2014-07-03 16:44:10',0,1),(356,'Preview of add sub category tool in place in Image library.','2014-07-03 16:57:15',0,1),(357,'Preview of add to library tool in place in Image library.','2014-07-04 00:48:18',0,1),(358,'Preview of filter form for Image library.','2014-07-07 16:03:41',0,1),(359,'Dlayer - Release 0.40 - Image library preview.','2014-07-07 16:04:13',1,1),(360,'Edit mode status now passed into the form builder ribbon forms.','2014-07-08 14:44:42',0,1),(361,'Updated Content manager tools, multi use param now passed from database to tool forms through tool data classes.','2014-07-08 23:28:15',0,1),(362,'Updated the Form builder, multi use param now passed down from database to Tool forms, not manually set.','2014-07-08 23:58:14',0,1),(363,'Updated Image library preview, multi use param now passed from database to Image library tool forms.','2014-07-09 00:09:19',0,1),(364,'Updated import form tool, submit button now disabled by default until valid selection made in form select.','2014-07-09 16:12:18',0,1),(365,'Updated the import form tool, now won\'t allow the user to import a a form into a page container that is too small for the form, if the form is too small a clear message is show above the form.','2014-07-09 16:24:22',0,1),(366,'Content manager tools now multi use, div, content item and tool tab remain selected after processing if request valid.','2014-07-09 17:20:01',0,1),(367,'Updated Form builder, set some tool tabs to multi use, tool, and tab remain selected after valid submission.','2014-07-09 17:27:24',0,1),(368,'Dlayer - Release 0.41 - Bug fixes and house keeping tasks.','2014-07-09 17:30:06',1,1),(369,'Initial database layout for Image library and categories in place, includes versioning tables.','2014-07-10 17:12:16',0,1),(370,'Updated the image library session class, now has methods for setting and fetching the sort and order values, initially limited to name, uploaded and size in ascending and descending order.','2014-07-11 17:07:48',0,1),(371,'Thumbnails are now displaying using data from the database, not a static preview.','2014-07-12 02:17:18',0,1),(372,'Default category and sub category set and/or created when user browses to Image library.','2014-07-12 17:26:24',0,1),(373,'Filter form in place, shows categories and sub categories, AJAX to update sub categories select and submission sets new session values.','2014-07-13 01:44:17',0,1),(374,'Reworked the image library tools, ids are now passed into the validate methods ready for later use, used to be the process methods, tools are starting to require environment ids for validation, other modules need to be updated in the same manner.','2014-07-13 14:00:17',0,1),(375,'Added the ability to create a category in the Image library, automatically creates the initial sub category.','2014-07-14 17:30:04',0,1),(376,'Added the ability to create a sub category in the Image library.','2014-07-15 00:14:13',0,1),(377,'Added ability to edit categories and sub categories in Image library, user is not allowed to edit initial category of auto created sub categories.','2014-07-15 14:30:06',0,1),(378,'Dlayer - Release 0.42 - Image library preview updated.','2014-07-15 14:55:55',1,1),(379,'Added version to image session, user needs to be able to select a specific version of an Image library image.','2014-07-15 16:37:52',0,1),(380,'Updated tools in Image library, version id now passed in along with other environment params.','2014-07-15 16:52:29',0,1),(381,'Added ability to select image and get directed to detail page (empty), selected tool is cancelled as it won\'t relate to the newly selected image.','2014-07-15 17:14:42',0,1),(382,'Preview of image detail page in place, not functional.','2014-07-16 00:42:01',0,1),(383,'Filter hidden on the image detail page as it is not relevant.','2014-07-16 00:50:06',0,1),(384,'Dlayer - Release 0.43 - Preview of image detail page and tool updates.','2014-07-16 00:50:45',1,1),(385,'Dlayer - Release 0.43.1 - Fixed bug with Image session class.','2014-07-16 15:30:37',1,1);

UNLOCK TABLES;

/*Table structure for table `dlayer_identities` */

DROP TABLE IF EXISTS `dlayer_identities`;

CREATE TABLE `dlayer_identities` (
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

/*Data for the table `dlayer_identities` */

LOCK TABLES `dlayer_identities` WRITE;

insert  into `dlayer_identities`(`id`,`identity`,`credentials`,`logged_in`,`last_login`,`last_action`,`enabled`) values (1,'user-1@dlayer.com','$6$rounds=5000$jks453yuyt55d$CZJCjaieFQghQ6MwQ1OUI5nVKDy/Fi2YXk7MyW2hcex9AdJ/jvZA8ulvjzK1lo3rRVFfmd10lgjqAbDQM4ehR1',0,'2014-07-16 15:14:03','2014-07-16 15:29:48',1),(2,'user-2@dlayer.com','$6$rounds=5000$jks453yuyt55d$ZVEJgs2kNjxOxNEayqqoh2oJUiGbmxIKRqOTxVM05MP2YRcAjE9adCZfQBWCc.qe1nDjEM9.ioivNz3c/qyZ80',0,'2014-06-25 16:23:58','2014-06-25 16:25:03',1),(3,'user-3@dlayer.com','$6$rounds=5000$jks453yuyt55d$NYF6yCvxXplefx7nr8vDe4cUGBEFtd3G5vuJ2utfqvPwEf3dSgNXNTcGbFO6WrJSn21CXHgZwNOQHy691E/Rm.',0,'2014-07-12 16:32:09','2014-07-12 16:32:28',1);

UNLOCK TABLES;

/*Table structure for table `dlayer_module_tool_tabs` */

DROP TABLE IF EXISTS `dlayer_module_tool_tabs`;

CREATE TABLE `dlayer_module_tool_tabs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(2) unsigned NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'View script for tool tab',
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
  CONSTRAINT `dlayer_module_tool_tabs_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`),
  CONSTRAINT `dlayer_module_tool_tabs_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tools` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tabs` */

LOCK TABLES `dlayer_module_tool_tabs` WRITE;

insert  into `dlayer_module_tool_tabs`(`id`,`module_id`,`tool_id`,`name`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (1,1,2,'Quick','quick',NULL,0,0,1,1,1),(2,1,2,'Mouse','advanced',NULL,0,0,0,2,1),(3,1,2,'?','help',NULL,0,0,0,3,1),(4,1,3,'Quick','quick',NULL,0,0,1,1,1),(5,1,3,'Mouse','advanced',NULL,0,0,0,2,1),(6,1,3,'?','help',NULL,0,0,0,3,1),(7,1,7,'#1','palette-1',NULL,0,0,1,1,1),(8,1,7,'#2','palette-2',NULL,0,0,0,2,1),(9,1,7,'#3','palette-3',NULL,0,0,0,3,1),(10,1,7,'Custom','advanced',NULL,0,0,0,4,1),(11,1,7,'?','help',NULL,0,0,0,5,1),(12,1,6,'Custom','advanced',NULL,0,0,0,4,1),(14,1,6,'?','help',NULL,0,0,0,5,1),(15,1,6,'Push','expand',NULL,0,0,1,1,1),(16,1,6,'Pull','contract',NULL,0,0,0,2,1),(17,1,6,'Height','height',NULL,0,0,0,3,1),(20,1,8,'Custom','advanced',NULL,0,0,0,2,1),(21,1,8,'?','help',NULL,0,0,0,3,1),(22,1,8,'Full border','full',NULL,0,0,1,1,1),(23,4,10,'[+]','text',NULL,1,0,1,1,1),(24,4,11,'[+]','heading',NULL,1,0,1,1,1),(25,4,10,'?','help',NULL,0,0,0,4,1),(26,4,11,'?','help',NULL,0,0,0,4,1),(27,3,12,'[+]','text',NULL,0,0,1,1,1),(28,3,12,'?','help',NULL,0,0,0,3,1),(29,3,13,'[+]','textarea',NULL,0,0,1,1,1),(30,3,13,'?','help',NULL,0,0,0,3,1),(31,3,15,'[+]','password',NULL,0,0,1,1,1),(32,3,15,'?','help',NULL,0,0,0,3,1),(33,4,16,'[+]','import-form',NULL,1,0,1,1,1),(34,4,16,'?','help',NULL,0,0,0,5,1),(35,5,18,'New page','new-page',NULL,0,0,1,1,1),(36,5,18,'?','help',NULL,0,0,0,2,1),(37,5,19,'Move page','move-page',NULL,0,0,1,1,1),(38,5,19,'?','help',NULL,0,0,0,2,1),(39,4,10,'Styling','styling','Styling_Text',1,1,0,2,1),(40,4,11,'Styling','styling','Styling_Heading',1,1,0,2,1),(41,4,16,'Styling','styling','Styling_ImportForm',1,1,0,3,1),(42,3,20,'[+]','email',NULL,0,0,1,1,1),(43,3,20,'?','help',NULL,0,0,0,3,1),(44,3,21,'[+]','name',NULL,0,0,1,1,1),(45,3,21,'?','help',NULL,0,0,0,3,1),(46,4,16,'Position','position','Position_ImportForm',1,1,0,4,1),(47,4,10,'Position','position','Position_Text',1,1,0,3,1),(48,4,11,'Position','position','Position_Heading',1,1,0,3,1),(49,3,12,'Styling','styling','Styling_Text',1,1,0,2,1),(50,3,13,'Styling','styling','Styling_Textarea',1,1,0,2,1),(51,3,15,'Styling','styling','Styling_Password',1,1,0,2,1),(52,3,20,'Styling','styling','Styling_Email',1,1,0,2,1),(53,3,21,'Styling','styling','Styling_Name',1,1,0,2,1),(54,4,16,'Edit','edit',NULL,0,1,0,2,1),(55,4,22,'[+]','import-text',NULL,1,0,1,1,1),(56,4,22,'?','help',NULL,0,0,0,2,1),(57,4,23,'[+]','import-heading',NULL,1,0,1,1,1),(58,4,23,'?','help',NULL,0,0,2,2,1),(59,3,24,'Settings','form-settings',NULL,1,0,1,1,1),(60,3,24,'?','add',NULL,0,0,0,2,1),(61,8,25,'[+]','add',NULL,0,0,1,1,1),(62,8,25,'?','help',NULL,0,0,0,2,1),(63,8,27,'[+]','category',NULL,0,0,1,1,1),(64,8,27,'?','help',NULL,0,0,0,2,1),(65,8,28,'[+]','subcategory',NULL,0,0,1,1,1),(66,8,28,'?','help',NULL,0,0,0,2,1);

UNLOCK TABLES;

/*Table structure for table `dlayer_module_tools` */

DROP TABLE IF EXISTS `dlayer_module_tools`;

CREATE TABLE `dlayer_module_tools` (
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
  CONSTRAINT `dlayer_module_tools_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tools` */

LOCK TABLES `dlayer_module_tools` WRITE;

insert  into `dlayer_module_tools`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','cancel',NULL,'cancel',1,0,1,1,1),(2,1,'Split horizontal','split-horizontal','SplitHorizontal','split-horizontal',1,1,2,1,1),(3,1,'Split vertical','split-vertical','SplitVertical','split-vertical',1,1,2,2,1),(6,1,'Resize','resize','Resize','resize',0,1,2,3,1),(7,1,'Background colour','background-color','BackgroundColor','background-color',1,0,3,1,1),(8,1,'Border','border','Border','border',1,0,3,2,1),(9,4,'Cancel','cancel',NULL,'cancel',1,0,1,1,1),(10,4,'Text','text','Text','text',0,0,2,2,1),(11,4,'Heading','heading','Heading','heading',0,0,2,1,1),(12,3,'Text','text','Text','text',0,0,4,1,1),(13,3,'Text area','textarea','Textarea','textarea',0,0,4,2,1),(14,3,'Cancel','cancel',NULL,'cancel',0,0,1,1,1),(15,3,'Password','password','Password','password',0,0,4,3,1),(16,4,'Import form','import-form','ImportForm','import-form',0,0,4,1,1),(17,5,'Cancel','cancel',NULL,'cancel',0,0,1,1,1),(18,5,'New page','new-page','NewPage','new-page',0,0,2,2,1),(19,5,'Move page','move-page','MovePage','move-page',0,0,2,1,1),(20,3,'Email','email','Email','email',0,0,3,2,1),(21,3,'Name','name','Name','name',0,0,3,1,1),(22,4,'Import text','import-text','ImportText','import-text',0,0,2,4,1),(23,4,'Import heading','import-heading','ImportHeading','import-heading',0,0,2,3,1),(24,3,'Form settings','form-settings','FormSettings','form-settings',0,0,2,1,1),(25,8,'Add to library','add','Add','add',1,0,2,1,1),(26,8,'Cancel / Back to library','cancel',NULL,'cancel',1,0,1,1,1),(27,8,'Category','category','Category','category',1,0,2,2,1),(28,8,'Sub category','subcategory','Subcategory','subcategory',1,0,2,3,1);

UNLOCK TABLES;

/*Table structure for table `dlayer_modules` */

DROP TABLE IF EXISTS `dlayer_modules`;

CREATE TABLE `dlayer_modules` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_modules` */

LOCK TABLES `dlayer_modules` WRITE;

insert  into `dlayer_modules`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (1,'template','Template designer','Create and manage the templates for your site. - (Working)',1,1),(2,'widget','Widget designer','Create and manage your reusable and dynamic blocks. Using the widget designer you create either static or dynamic reusable blocks. If there is an elements or function that you need to appear on multiple pages it should probably be a widget.',4,0),(3,'form','Form builder','Create and manage the forms for your site. - (Working)',3,1),(4,'content','Content manager','Create and manage the site content. - (Working)',2,1),(5,'website','Web site manager','Manage site structure and site level widget data. - (Preview)',5,1),(6,'question','Question manager','Create quizzes, tests and polls, system supports multiple pages, multiple questions types, for example text, image, video and multiple answer types, free text, multiple choice, true or false. Results are summed and calculated and can either be displayed or stored for just the administrator.',5,0),(7,'dlayer','Dlayer','Home',0,1),(8,'image','Image library','Manage all your images. - (Preview)',6,1);

UNLOCK TABLES;

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

LOCK TABLES `dlayer_sessions` WRITE;

insert  into `dlayer_sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('dqm1aqqiokc4grk7gi1m1p9dv4','','PHPSESSID',1405520991,3601,'__ZF|a:5:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1405524591;}s:20:\"dlayer_session_image\";a:1:{s:3:\"ENT\";i:1405524590;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1405524590;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1405524590;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1405524590;}}dlayer_session_image|a:6:{s:9:\"edit_mode\";i:0;s:4:\"sort\";N;s:10:\"sort_order\";N;s:4:\"tool\";N;s:9:\"image_ids\";a:0:{}s:3:\"tab\";N;}dlayer_session_template|a:4:{s:6:\"div_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";N;}dlayer_session_form|a:5:{s:8:\"field_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:6:\"return\";N;s:7:\"form_id\";N;}dlayer_session_content|a:6:{s:6:\"div_id\";N;s:10:\"content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:7:\"page_id\";N;s:11:\"template_id\";N;}');

UNLOCK TABLES;

/*Table structure for table `dlayer_settings` */

DROP TABLE IF EXISTS `dlayer_settings`;

CREATE TABLE `dlayer_settings` (
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
  CONSTRAINT `dlayer_settings_ibfk_1` FOREIGN KEY (`setting_group_id`) REFERENCES `dlayer_settings_groups` (`id`),
  CONSTRAINT `dlayer_settings_ibfk_2` FOREIGN KEY (`scope_id`) REFERENCES `dlayer_settings_scope` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_settings` */

LOCK TABLES `dlayer_settings` WRITE;

insert  into `dlayer_settings`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (1,1,'Color palettes','Color palettes','<p>You can define three color palettes for each of your web sits, the colors you define here will be shown anytime you need a tool requires you to choose a color.</p>\r\n\r\n<p>You will always be able to choose a color that is not in one of your three  palettes, think of these as quick access.</p>','/dlayer/settings/palettes',1,'All color pickers',1,1),(2,3,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the content manager, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/content/settings/base-font-family',2,'Content module, all text',1,1),(3,3,'Heading styles','Set the styles for the six heading types','<p>Define the styles for the page title and the five sub headings, H2 through H6.</p>\r\n\r\n<p>Anywhere you need to choose one of the heading types the styles defined here will be used.</p>','/content/settings/headings',3,'Heading tool',2,1),(4,4,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the form builder, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/form/settings/base-font-family',2,'Forms module, all text',1,1);

UNLOCK TABLES;

/*Table structure for table `dlayer_settings_groups` */

DROP TABLE IF EXISTS `dlayer_settings_groups`;

CREATE TABLE `dlayer_settings_groups` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `url` (`url`),
  KEY `sort_order` (`sort_order`),
  KEY `enabled` (`enabled`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `dlayer_settings_groups_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_settings_groups` */

LOCK TABLES `dlayer_settings_groups` WRITE;

insert  into `dlayer_settings_groups`(`id`,`name`,`module_id`,`title`,`url`,`sort_order`,`enabled`) values (1,'App',7,'Dlayer settings','/dlayer/settings/index',1,1),(2,'Template',1,'Template designer settings','/template/settings/index',2,1),(3,'Content',4,'Content designer settings','/content/settings/index',3,1),(4,'Form',3,'Form builder settings','/form/settings/index',4,1),(5,'Widget',2,'Widget designer settings','/widget/settings/index',5,1),(6,'Web site',5,'Web site designer settings','/website/settings/index',7,1),(7,'Question',6,'Question manager settings','/question/settings/index',6,1),(8,'Image',8,'Image library settings','/image/settings/index',8,1);

UNLOCK TABLES;

/*Table structure for table `dlayer_settings_scope` */

DROP TABLE IF EXISTS `dlayer_settings_scope`;

CREATE TABLE `dlayer_settings_scope` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_settings_scope` */

LOCK TABLES `dlayer_settings_scope` WRITE;

insert  into `dlayer_settings_scope`(`id`,`scope`) values (1,'App'),(2,'Module'),(3,'Tool');

UNLOCK TABLES;

/*Table structure for table `user_settings_color_history` */

DROP TABLE IF EXISTS `user_settings_color_history`;

CREATE TABLE `user_settings_color_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_settings_color_history_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_color_history` */

LOCK TABLES `user_settings_color_history` WRITE;

insert  into `user_settings_color_history`(`id`,`site_id`,`color_hex`) values (1,1,'#f3f1df'),(2,1,'#666666'),(3,1,'#003366'),(4,1,'#FF6600'),(5,1,'FFFFFF'),(6,2,'#f3f1df'),(7,2,'#666666'),(8,2,'#003366'),(9,2,'#FF6600'),(10,2,'FFFFFF'),(11,3,'#f3f1df'),(12,3,'#666666'),(13,3,'#003366'),(14,3,'#FF6600'),(15,3,'FFFFFF'),(16,1,'#336699'),(17,1,'#000000'),(18,1,'#336699'),(19,1,'#ff6600'),(20,1,'#336699'),(21,1,'#ff6600'),(22,1,'#336699'),(23,1,'#ff6600'),(24,1,'#336699'),(25,1,'#ff6600'),(26,1,'#336699');

UNLOCK TABLES;

/*Table structure for table `user_settings_color_palette_colors` */

DROP TABLE IF EXISTS `user_settings_color_palette_colors`;

CREATE TABLE `user_settings_color_palette_colors` (
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
  CONSTRAINT `user_settings_color_palette_colors_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_settings_color_palette_colors_ibfk_2` FOREIGN KEY (`palette_id`) REFERENCES `user_settings_color_palettes` (`id`),
  CONSTRAINT `user_settings_color_palette_colors_ibfk_3` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_color_palette_colors` */

LOCK TABLES `user_settings_color_palette_colors` WRITE;

insert  into `user_settings_color_palette_colors`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (1,1,1,1,'Black','#000000'),(2,1,1,2,'Tan','#f3f1df'),(3,1,1,3,'Dark grey','#666666'),(4,1,2,1,'Blue','#336699'),(5,1,2,2,'Dark grey','#666666'),(6,1,2,3,'Grey','#999999'),(7,1,3,1,'Blue','#003366'),(8,1,3,2,'White','#FFFFFF'),(9,1,3,3,'Orange','#FF6600'),(10,2,4,1,'Black','#000000'),(11,2,4,2,'Tan','#f3f1df'),(12,2,4,3,'Dark grey','#666666'),(13,2,5,1,'Blue','#336699'),(14,2,5,2,'Dark grey','#666666'),(15,2,5,3,'Grey','#999999'),(16,2,6,1,'Blue','#003366'),(17,2,6,2,'White','#FFFFFF'),(18,2,6,3,'Orange','#FF6600'),(19,3,7,1,'Black','#000000'),(20,3,7,2,'Tan','#f3f1df'),(21,3,7,3,'Dark grey','#666666'),(22,3,8,1,'Blue','#336699'),(23,3,8,2,'Dark grey','#666666'),(24,3,8,3,'Grey','#999999'),(25,3,9,1,'Blue','#003366'),(26,3,9,2,'White','#FFFFFF'),(27,3,9,3,'Orange','#FF6600');

UNLOCK TABLES;

/*Table structure for table `user_settings_color_palettes` */

DROP TABLE IF EXISTS `user_settings_color_palettes`;

CREATE TABLE `user_settings_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `view_script` (`view_script`),
  CONSTRAINT `user_settings_color_palettes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_color_palettes` */

LOCK TABLES `user_settings_color_palettes` WRITE;

insert  into `user_settings_color_palettes`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values (1,1,'Palette 1','palette-1',1),(2,1,'Palette 2','palette-2',2),(3,1,'Palette 3','palette-3',3),(4,2,'Palette 1','palette-1',1),(5,2,'Palette 2','palette-2',2),(6,2,'Palette 3','palette-3',3),(7,3,'Palette 1','palette-1',1),(8,3,'Palette 2','palette-2',2),(9,3,'Palette 3','palette-3',3);

UNLOCK TABLES;

/*Table structure for table `user_settings_font_families` */

DROP TABLE IF EXISTS `user_settings_font_families`;

CREATE TABLE `user_settings_font_families` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `module_id` tinyint(3) unsigned NOT NULL,
  `font_family_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `module_id` (`module_id`),
  KEY `font_family_id` (`font_family_id`),
  CONSTRAINT `user_settings_font_families_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_settings_font_families_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`),
  CONSTRAINT `user_settings_font_families_ibfk_3` FOREIGN KEY (`font_family_id`) REFERENCES `designer_css_font_families` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_font_families` */

LOCK TABLES `user_settings_font_families` WRITE;

insert  into `user_settings_font_families`(`id`,`site_id`,`module_id`,`font_family_id`) values (1,1,3,2),(2,1,4,1),(3,2,3,1),(4,2,4,1),(5,3,3,1),(6,3,4,1);

UNLOCK TABLES;

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
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#000000',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_headings` */

LOCK TABLES `user_settings_headings` WRITE;

insert  into `user_settings_headings`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (1,1,1,1,2,1,22,'#000000',1),(2,1,2,1,2,1,18,'#000000',2),(3,1,3,1,2,1,16,'#000000',3),(4,1,4,1,2,2,14,'#000000',4),(5,1,5,2,2,1,14,'#000000',5),(6,1,6,1,1,1,12,'#000000',6),(7,2,1,1,2,1,22,'#000000',1),(8,2,2,1,2,1,18,'#000000',2),(9,2,3,1,2,1,16,'#000000',3),(10,2,4,1,2,2,14,'#000000',4),(11,2,5,2,2,1,14,'#000000',5),(12,2,6,1,1,1,12,'#000000',6),(13,3,1,1,2,1,22,'#000000',1),(14,3,2,1,2,1,18,'#000000',2),(15,3,3,1,2,1,16,'#000000',3),(16,3,4,1,2,2,14,'#000000',4),(17,3,5,2,2,1,14,'#000000',5),(18,3,6,1,1,1,12,'#000000',6);

UNLOCK TABLES;

/*Table structure for table `user_site_content_heading` */

DROP TABLE IF EXISTS `user_site_content_heading`;

CREATE TABLE `user_site_content_heading` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name to identity content',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_content_heading_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_heading` */

LOCK TABLES `user_site_content_heading` WRITE;

insert  into `user_site_content_heading`(`id`,`site_id`,`name`,`content`) values (1,1,'Page title','Page title!'),(2,1,'Page sub title','Page sub title!'),(3,1,'Page heading','Page heading!'),(4,2,'Page title','Page title!'),(5,2,'Page sub title','Page sub title!'),(6,2,'Page heading','Page heading!'),(7,3,'Page title','Page title!'),(8,3,'Page sub title','Page sub title!'),(9,3,'Page heading','Page heading!');

UNLOCK TABLES;

/*Table structure for table `user_site_content_text` */

DROP TABLE IF EXISTS `user_site_content_text`;

CREATE TABLE `user_site_content_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name so user can identity content',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_content_text_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_text` */

LOCK TABLES `user_site_content_text` WRITE;

insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (1,1,'Menu notice','Menu goes in this section.'),(2,1,'Lorem ipsum','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lorem ligula, ornare ac massa sit amet, luctus dictum lacus. Suspendisse ac nibh vel turpis ultrices aliquet. Proin luctus auctor accumsan. Sed tristique magna eu odio egestas tincidunt.'),(3,2,'Menu notice','Menu goes in this section.'),(4,2,'Lorem ipsum','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lorem ligula, ornare ac massa sit amet, luctus dictum lacus. Suspendisse ac nibh vel turpis ultrices aliquet. Proin luctus auctor accumsan. Sed tristique magna eu odio egestas tincidunt.'),(5,3,'Menu notice','Menu goes in this section.'),(6,3,'Lorem ipsum','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lorem ligula, ornare ac massa sit amet, luctus dictum lacus. Suspendisse ac nibh vel turpis ultrices aliquet. Proin luctus auctor accumsan. Sed tristique magna eu odio egestas tincidunt.');

UNLOCK TABLES;

/*Table structure for table `user_site_form_field_attributes` */

DROP TABLE IF EXISTS `user_site_form_field_attributes`;

CREATE TABLE `user_site_form_field_attributes` (
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
  CONSTRAINT `user_site_form_field_attributes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_form_field_attributes_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_forms` (`id`),
  CONSTRAINT `user_site_form_field_attributes_ibfk_3` FOREIGN KEY (`field_id`) REFERENCES `user_site_form_fields` (`id`),
  CONSTRAINT `user_site_form_field_attributes_ibfk_4` FOREIGN KEY (`attribute_id`) REFERENCES `designer_form_field_attributes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field_attributes` */

LOCK TABLES `user_site_form_field_attributes` WRITE;

insert  into `user_site_form_field_attributes`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (1,1,1,1,1,'40'),(2,1,1,1,2,'255'),(3,1,1,1,7,'Enter your name'),(4,1,1,2,3,'40'),(5,1,1,2,4,'3'),(6,1,1,2,8,'Enter your comment'),(7,1,1,3,5,'20'),(8,1,1,3,6,'255'),(9,1,1,3,9,'Enter your password'),(10,2,2,4,1,'40'),(11,2,2,4,2,'255'),(12,2,2,4,7,'Enter your name'),(13,2,2,5,3,'40'),(14,2,2,5,4,'3'),(15,2,2,5,8,'Enter your comment'),(16,2,2,6,5,'20'),(17,2,2,6,6,'255'),(18,2,2,6,9,'Enter your password'),(19,3,3,7,1,'40'),(20,3,3,7,2,'255'),(21,3,3,7,7,'Enter your name'),(22,3,3,8,3,'40'),(23,3,3,8,4,'3'),(24,3,3,8,8,'Enter your comment'),(25,3,3,9,5,'20'),(26,3,3,9,6,'255'),(27,3,3,9,9,'Enter your password');

UNLOCK TABLES;

/*Table structure for table `user_site_form_field_row_background_colors` */

DROP TABLE IF EXISTS `user_site_form_field_row_background_colors`;

CREATE TABLE `user_site_form_field_row_background_colors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  KEY `field_id` (`field_id`),
  CONSTRAINT `user_site_form_field_row_background_colors_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_form_field_row_background_colors_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_forms` (`id`),
  CONSTRAINT `user_site_form_field_row_background_colors_ibfk_3` FOREIGN KEY (`field_id`) REFERENCES `user_site_form_fields` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field_row_background_colors` */

LOCK TABLES `user_site_form_field_row_background_colors` WRITE;

insert  into `user_site_form_field_row_background_colors`(`id`,`site_id`,`form_id`,`field_id`,`color_hex`) values (1,1,1,1,'#f3f1df'),(2,1,1,3,'#f3f1df'),(3,2,2,4,'#f3f1df'),(4,2,2,6,'#f3f1df'),(5,3,3,7,'#f3f1df'),(6,3,3,9,'#f3f1df');

UNLOCK TABLES;

/*Table structure for table `user_site_form_fields` */

DROP TABLE IF EXISTS `user_site_form_fields`;

CREATE TABLE `user_site_form_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  KEY `field_type_id` (`field_type_id`),
  KEY `tool_id` (`tool_id`),
  CONSTRAINT `user_site_form_fields_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_form_fields_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_forms` (`id`),
  CONSTRAINT `user_site_form_fields_ibfk_3` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_types` (`id`),
  CONSTRAINT `user_site_form_fields_ibfk_4` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tools` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_fields` */

LOCK TABLES `user_site_form_fields` WRITE;

insert  into `user_site_form_fields`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (1,1,1,1,12,'Your name','Please enter your name',1),(2,1,1,2,13,'Your comment','Please enter your comment',2),(3,1,1,3,15,'Password','Please enter your password',3),(4,2,2,1,12,'Your name','Please enter your name',1),(5,2,2,2,13,'Your comment','Please enter your comment',2),(6,2,2,3,15,'Your password','Please enter your password',3),(7,3,3,1,12,'Your name','Please enter your name',1),(8,3,3,2,13,'Your comment','Please enter your comment',2),(9,3,3,3,15,'Your password','Please enter your password',3);

UNLOCK TABLES;

/*Table structure for table `user_site_form_settings` */

DROP TABLE IF EXISTS `user_site_form_settings`;

CREATE TABLE `user_site_form_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `width` int(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Minimum form display width',
  `legend` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Fieldset legend text for form',
  `button` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Text for the submit button',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  CONSTRAINT `user_site_form_settings_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_form_settings_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_forms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_settings` */

LOCK TABLES `user_site_form_settings` WRITE;

insert  into `user_site_form_settings`(`id`,`site_id`,`form_id`,`width`,`legend`,`button`) values (1,1,1,600,'My form','Save'),(2,2,2,600,'My form','Save'),(3,3,3,600,'My form','Save');

UNLOCK TABLES;

/*Table structure for table `user_site_forms` */

DROP TABLE IF EXISTS `user_site_forms`;

CREATE TABLE `user_site_forms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_forms` */

LOCK TABLES `user_site_forms` WRITE;

insert  into `user_site_forms`(`id`,`site_id`,`name`) values (1,1,'Sample form'),(2,2,'Sample form'),(3,3,'Sample form');

UNLOCK TABLES;

/*Table structure for table `user_site_history` */

DROP TABLE IF EXISTS `user_site_history`;

CREATE TABLE `user_site_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) unsigned NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `identity_id` (`identity_id`),
  CONSTRAINT `user_site_history_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_history_ibfk_2` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_history` */

LOCK TABLES `user_site_history` WRITE;

insert  into `user_site_history`(`id`,`identity_id`,`site_id`) values (1,1,1),(2,2,2),(3,3,3);

UNLOCK TABLES;

/*Table structure for table `user_site_image_library` */

DROP TABLE IF EXISTS `user_site_image_library`;

CREATE TABLE `user_site_image_library` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `sub_category_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `category_id` (`category_id`),
  KEY `sub_category_id` (`sub_category_id`),
  CONSTRAINT `user_site_image_library_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `user_site_image_library_categories` (`id`),
  CONSTRAINT `user_site_image_library_ibfk_3` FOREIGN KEY (`sub_category_id`) REFERENCES `user_site_image_library_sub_categories` (`id`),
  CONSTRAINT `user_site_image_library_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library` */

LOCK TABLES `user_site_image_library` WRITE;

insert  into `user_site_image_library`(`id`,`site_id`,`name`,`category_id`,`sub_category_id`) values (1,1,'Gradient 1',1,1),(2,1,'Gradient 2',1,1),(3,1,'Gradient 3',1,1),(4,1,'Gradient 4',1,1),(5,1,'Gradient 5',1,1),(6,1,'Gradient 6',1,1),(7,1,'Gradient 7',1,1);

UNLOCK TABLES;

/*Table structure for table `user_site_image_library_categories` */

DROP TABLE IF EXISTS `user_site_image_library_categories`;

CREATE TABLE `user_site_image_library_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_image_library_categories_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_categories` */

LOCK TABLES `user_site_image_library_categories` WRITE;

insert  into `user_site_image_library_categories`(`id`,`site_id`,`name`) values (1,1,'Backgrounds');

UNLOCK TABLES;

/*Table structure for table `user_site_image_library_links` */

DROP TABLE IF EXISTS `user_site_image_library_links`;

CREATE TABLE `user_site_image_library_links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `library_id` int(11) unsigned NOT NULL,
  `version_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `library_id` (`library_id`),
  KEY `version_id` (`version_id`),
  CONSTRAINT `user_site_image_library_links_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_image_library_links_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `user_site_image_library` (`id`),
  CONSTRAINT `user_site_image_library_links_ibfk_3` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_versions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_links` */

LOCK TABLES `user_site_image_library_links` WRITE;

insert  into `user_site_image_library_links`(`id`,`site_id`,`library_id`,`version_id`) values (1,1,1,1),(2,1,2,2),(3,1,3,3),(4,1,4,4),(5,1,5,5),(6,1,6,6),(7,1,7,7);

UNLOCK TABLES;

/*Table structure for table `user_site_image_library_sub_categories` */

DROP TABLE IF EXISTS `user_site_image_library_sub_categories`;

CREATE TABLE `user_site_image_library_sub_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `user_site_image_library_sub_categories_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_image_library_sub_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `user_site_image_library_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_sub_categories` */

LOCK TABLES `user_site_image_library_sub_categories` WRITE;

insert  into `user_site_image_library_sub_categories`(`id`,`site_id`,`category_id`,`name`) values (1,1,1,'Misc.');

UNLOCK TABLES;

/*Table structure for table `user_site_image_library_versions` */

DROP TABLE IF EXISTS `user_site_image_library_versions`;

CREATE TABLE `user_site_image_library_versions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `extension` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '.jpg',
  `width` smallint(6) NOT NULL DEFAULT '0',
  `height` smallint(6) NOT NULL DEFAULT '0',
  `size` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_image_library_versions_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_versions` */

LOCK TABLES `user_site_image_library_versions` WRITE;

insert  into `user_site_image_library_versions`(`id`,`site_id`,`uploaded`,`extension`,`width`,`height`,`size`) values (1,1,'2014-07-15 14:37:58','.jpg',960,720,12000),(2,1,'2014-07-15 14:38:08','.jpg',960,720,12000),(3,1,'2014-07-15 14:38:15','.jpg',960,720,12000),(4,1,'2014-07-15 14:38:26','.jpg',960,720,12000),(5,1,'2014-07-15 14:38:37','.jpg',960,720,12000),(6,1,'2014-07-15 14:38:45','.jpg',960,720,12000),(7,1,'2014-07-15 14:39:20','.jpg',960,720,12000);

UNLOCK TABLES;

/*Table structure for table `user_site_page_content` */

DROP TABLE IF EXISTS `user_site_page_content`;

CREATE TABLE `user_site_page_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `content_type` int(11) unsigned NOT NULL,
  `sort_order` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_type` (`content_type`),
  KEY `sort_order` (`sort_order`),
  KEY `div_id` (`div_id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_page_content_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_ibfk_3` FOREIGN KEY (`content_type`) REFERENCES `designer_content_types` (`id`),
  CONSTRAINT `user_site_page_content_ibfk_5` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  CONSTRAINT `user_site_page_content_ibfk_6` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content` */

LOCK TABLES `user_site_page_content` WRITE;

insert  into `user_site_page_content`(`id`,`site_id`,`page_id`,`div_id`,`content_type`,`sort_order`) values (1,1,1,1,2,1),(2,1,1,1,2,2),(3,1,1,3,1,1),(4,1,1,4,2,1),(5,1,1,4,1,2),(6,1,1,4,1,3),(7,1,1,4,1,4),(8,1,1,4,3,5),(9,2,2,5,2,1),(10,2,2,5,2,2),(11,2,2,7,1,1),(12,2,2,8,2,1),(13,2,2,8,1,2),(14,2,2,8,1,3),(15,2,2,8,1,4),(16,2,2,8,3,5),(17,3,3,9,2,1),(18,3,3,9,2,2),(19,3,3,11,1,1),(20,3,3,12,2,1),(21,3,3,12,1,2),(22,3,3,12,1,3),(23,3,3,12,1,4),(24,3,3,12,3,5);

UNLOCK TABLES;

/*Table structure for table `user_site_page_content_container_background_colors` */

DROP TABLE IF EXISTS `user_site_page_content_container_background_colors`;

CREATE TABLE `user_site_page_content_container_background_colors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `content_type` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `div_id` (`div_id`),
  KEY `content_type` (`content_type`),
  KEY `user_site_content_container_background_colors_ibfk_4` (`content_id`),
  CONSTRAINT `user_site_page_content_container_background_colors_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_page_content_container_background_colors_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_container_background_colors_ibfk_3` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  CONSTRAINT `user_site_page_content_container_background_colors_ibfk_4` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  CONSTRAINT `user_site_page_content_container_background_colors_ibfk_5` FOREIGN KEY (`content_type`) REFERENCES `designer_content_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_container_background_colors` */

LOCK TABLES `user_site_page_content_container_background_colors` WRITE;

insert  into `user_site_page_content_container_background_colors`(`id`,`site_id`,`page_id`,`div_id`,`content_id`,`content_type`,`color_hex`) values (1,1,1,4,6,1,'#f3f1df'),(2,2,2,8,14,1,'#f3f1df'),(3,3,3,12,22,1,'#f3f1df');

UNLOCK TABLES;

/*Table structure for table `user_site_page_content_container_margins` */

DROP TABLE IF EXISTS `user_site_page_content_container_margins`;

CREATE TABLE `user_site_page_content_container_margins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `content_type` int(11) unsigned NOT NULL,
  `top` int(4) NOT NULL DEFAULT '0',
  `right` int(4) NOT NULL DEFAULT '0',
  `bottom` int(4) NOT NULL DEFAULT '0',
  `left` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `div_id` (`div_id`),
  KEY `content_type` (`content_type`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `user_site_page_content_container_margins_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_page_content_container_margins_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_container_margins_ibfk_3` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  CONSTRAINT `user_site_page_content_container_margins_ibfk_4` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  CONSTRAINT `user_site_page_content_container_margins_ibfk_5` FOREIGN KEY (`content_type`) REFERENCES `designer_content_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_container_margins` */

LOCK TABLES `user_site_page_content_container_margins` WRITE;

insert  into `user_site_page_content_container_margins`(`id`,`site_id`,`page_id`,`div_id`,`content_id`,`content_type`,`top`,`right`,`bottom`,`left`) values (3,1,1,4,6,1,0,50,0,50),(5,1,1,4,8,3,0,50,0,50),(6,2,2,8,16,3,0,50,0,50),(7,3,3,12,24,3,0,50,0,50),(8,2,2,8,14,1,0,50,0,50),(9,3,3,12,22,1,0,50,0,50);

UNLOCK TABLES;

/*Table structure for table `user_site_page_content_form` */

DROP TABLE IF EXISTS `user_site_page_content_form`;

CREATE TABLE `user_site_page_content_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `width` int(4) unsigned NOT NULL DEFAULT '0',
  `padding` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `form_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `form_id` (`form_id`),
  CONSTRAINT `user_site_page_content_form_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_page_content_form_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_form_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  CONSTRAINT `user_site_page_content_form_ibfk_4` FOREIGN KEY (`form_id`) REFERENCES `user_site_forms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_form` */

LOCK TABLES `user_site_page_content_form` WRITE;

insert  into `user_site_page_content_form`(`id`,`site_id`,`page_id`,`content_id`,`width`,`padding`,`form_id`) values (1,1,1,8,700,10,1),(2,2,2,16,700,10,2),(3,3,3,24,700,10,3);

UNLOCK TABLES;

/*Table structure for table `user_site_page_content_heading` */

DROP TABLE IF EXISTS `user_site_page_content_heading`;

CREATE TABLE `user_site_page_content_heading` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `heading_id` int(11) unsigned NOT NULL,
  `data_id` int(11) unsigned NOT NULL,
  `width` int(3) unsigned NOT NULL DEFAULT '12',
  `padding_top` int(3) unsigned NOT NULL DEFAULT '12',
  `padding_bottom` int(3) unsigned NOT NULL DEFAULT '12',
  `padding_left` int(3) unsigned NOT NULL DEFAULT '12',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `site_id` (`site_id`),
  KEY `heading_id` (`heading_id`),
  KEY `data_id` (`data_id`),
  CONSTRAINT `user_site_page_content_heading_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_heading_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  CONSTRAINT `user_site_page_content_heading_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_page_content_heading_ibfk_5` FOREIGN KEY (`heading_id`) REFERENCES `user_settings_headings` (`id`),
  CONSTRAINT `user_site_page_content_heading_ibfk_6` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_heading` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_heading` */

LOCK TABLES `user_site_page_content_heading` WRITE;

insert  into `user_site_page_content_heading`(`id`,`site_id`,`page_id`,`content_id`,`heading_id`,`data_id`,`width`,`padding_top`,`padding_bottom`,`padding_left`) values (1,1,1,1,1,1,1015,12,12,5),(2,1,1,2,3,2,1015,12,12,5),(3,1,1,4,4,3,815,12,12,5),(4,2,2,9,1,4,1015,12,12,5),(5,2,2,10,3,5,1015,12,12,5),(6,2,2,12,4,6,815,12,12,5),(7,3,3,17,1,7,1015,12,12,5),(8,3,3,18,3,8,1015,12,12,5),(9,3,3,20,4,9,815,12,12,5);

UNLOCK TABLES;

/*Table structure for table `user_site_page_content_text` */

DROP TABLE IF EXISTS `user_site_page_content_text`;

CREATE TABLE `user_site_page_content_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `width` int(4) unsigned NOT NULL DEFAULT '0',
  `padding` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `data_id` int(11) unsigned NOT NULL COMMENT 'Id of content in data table',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `site_id` (`site_id`),
  KEY `data_id` (`data_id`),
  CONSTRAINT `user_site_page_content_text_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_3` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_4` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_text` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_text` */

LOCK TABLES `user_site_page_content_text` WRITE;

insert  into `user_site_page_content_text`(`id`,`site_id`,`page_id`,`content_id`,`width`,`padding`,`data_id`) values (1,1,1,3,180,10,1),(2,1,1,5,200,10,2),(3,1,1,6,200,10,2),(4,1,1,7,200,10,2),(5,2,2,11,180,10,3),(6,2,2,13,200,10,4),(7,2,2,14,200,10,4),(8,2,2,15,200,10,4),(9,3,3,19,180,10,5),(10,3,3,21,200,10,6),(11,3,3,22,200,10,6),(12,3,3,23,200,10,6);

UNLOCK TABLES;

/*Table structure for table `user_site_pages` */

DROP TABLE IF EXISTS `user_site_pages`;

CREATE TABLE `user_site_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_site_pages_ibfk_2` (`template_id`),
  CONSTRAINT `user_site_pages_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_pages_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_pages` */

LOCK TABLES `user_site_pages` WRITE;

insert  into `user_site_pages`(`id`,`site_id`,`template_id`,`name`,`title`,`description`) values (1,1,1,'Sample page','Sample page title','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin fringilla quam ipsum, ut lacinia augue tincidunt et. Curabitur ac mi nulla. Proin volutpat lacus non lobortis sollicitudin. Ut cursus id felis sit amet scelerisque. Mauris et neque sed urna dignissim lobortis in ut turpis. Pellentesque laoreet eros tincidunt sollicitudin consectetur. Duis at eleifend magna. Quisque eu laoreet odio. Nam quis neque ut lectus tristique iaculis. Suspendisse posuere, lorem sed placerat cursus, quam turpis consectetur leo, at interdum lacus nisi non leo. Aenean leo justo, dictum eu elementum in, interdum quis velit.'),(2,2,2,'Sample page','Sample page title','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin fringilla quam ipsum, ut lacinia augue tincidunt et. Curabitur ac mi nulla. Proin volutpat lacus non lobortis sollicitudin. Ut cursus id felis sit amet scelerisque. Mauris et neque sed urna dignissim lobortis in ut turpis. Pellentesque laoreet eros tincidunt sollicitudin consectetur. Duis at eleifend magna. Quisque eu laoreet odio. Nam quis neque ut lectus tristique iaculis. Suspendisse posuere, lorem sed placerat cursus, quam turpis consectetur leo, at interdum lacus nisi non leo. Aenean leo justo, dictum eu elementum in, interdum quis velit.'),(3,3,3,'Sample page','Sample page title','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin fringilla quam ipsum, ut lacinia augue tincidunt et. Curabitur ac mi nulla. Proin volutpat lacus non lobortis sollicitudin. Ut cursus id felis sit amet scelerisque. Mauris et neque sed urna dignissim lobortis in ut turpis. Pellentesque laoreet eros tincidunt sollicitudin consectetur. Duis at eleifend magna. Quisque eu laoreet odio. Nam quis neque ut lectus tristique iaculis. Suspendisse posuere, lorem sed placerat cursus, quam turpis consectetur leo, at interdum lacus nisi non leo. Aenean leo justo, dictum eu elementum in, interdum quis velit.');

UNLOCK TABLES;

/*Table structure for table `user_site_template_div_background_colors` */

DROP TABLE IF EXISTS `user_site_template_div_background_colors`;

CREATE TABLE `user_site_template_div_background_colors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`),
  KEY `div_id` (`div_id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_template_div_background_colors_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_template_div_background_colors_ibfk_2` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  CONSTRAINT `user_site_template_div_background_colors_ibfk_3` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_background_colors` */

LOCK TABLES `user_site_template_div_background_colors` WRITE;

insert  into `user_site_template_div_background_colors`(`id`,`site_id`,`template_id`,`div_id`,`color_hex`) values (1,1,1,1,'#003366'),(2,1,1,3,'#FF6600'),(3,2,2,5,'#003366'),(4,2,2,7,'#FF6600'),(5,3,3,9,'#003366'),(6,3,3,11,'#FF6600');

UNLOCK TABLES;

/*Table structure for table `user_site_template_div_borders` */

DROP TABLE IF EXISTS `user_site_template_div_borders`;

CREATE TABLE `user_site_template_div_borders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `position` enum('top','right','bottom','left') COLLATE utf8_unicode_ci NOT NULL,
  `style` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `width` int(3) unsigned NOT NULL DEFAULT '1',
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#000000',
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  KEY `template_id` (`template_id`),
  KEY `div_id` (`div_id`),
  KEY `style` (`style`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_template_div_borders_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_template_div_borders_ibfk_2` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  CONSTRAINT `user_site_template_div_borders_ibfk_3` FOREIGN KEY (`style`) REFERENCES `designer_css_border_styles` (`style`),
  CONSTRAINT `user_site_template_div_borders_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_borders` */

LOCK TABLES `user_site_template_div_borders` WRITE;

UNLOCK TABLES;

/*Table structure for table `user_site_template_div_sizes` */

DROP TABLE IF EXISTS `user_site_template_div_sizes`;

CREATE TABLE `user_site_template_div_sizes` (
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
  CONSTRAINT `user_site_template_div_sizes_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_template_div_sizes_ibfk_3` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  CONSTRAINT `user_site_template_div_sizes_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_sizes` */

LOCK TABLES `user_site_template_div_sizes` WRITE;

insert  into `user_site_template_div_sizes`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (1,1,1,1,1020,0,125),(2,1,1,2,1020,0,575),(3,1,1,3,200,0,575),(4,1,1,4,820,0,575),(5,2,2,5,1020,0,125),(6,2,2,6,1020,0,575),(7,2,2,7,200,0,575),(8,2,2,8,820,0,575),(9,3,3,9,1020,0,125),(10,3,3,10,1020,0,575),(11,3,3,11,200,0,575),(12,3,3,12,820,0,575);

UNLOCK TABLES;

/*Table structure for table `user_site_template_divs` */

DROP TABLE IF EXISTS `user_site_template_divs`;

CREATE TABLE `user_site_template_divs` (
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
  CONSTRAINT `user_site_template_divs_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_template_divs_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_divs` */

LOCK TABLES `user_site_template_divs` WRITE;

insert  into `user_site_template_divs`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (1,1,1,0,1),(2,1,1,0,2),(3,1,1,2,1),(4,1,1,2,2),(5,2,2,0,1),(6,2,2,0,2),(7,2,2,6,1),(8,2,2,6,2),(9,3,3,0,1),(10,3,3,0,2),(11,3,3,10,1),(12,3,3,10,2);

UNLOCK TABLES;

/*Table structure for table `user_site_templates` */

DROP TABLE IF EXISTS `user_site_templates`;

CREATE TABLE `user_site_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_templates_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_templates` */

LOCK TABLES `user_site_templates` WRITE;

insert  into `user_site_templates`(`id`,`site_id`,`name`) values (1,1,'Sample template'),(2,2,'Sample template'),(3,3,'Sample template');

UNLOCK TABLES;

/*Table structure for table `user_sites` */

DROP TABLE IF EXISTS `user_sites`;

CREATE TABLE `user_sites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `identity_id` (`identity_id`),
  CONSTRAINT `user_sites_ibfk_1` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_sites` */

LOCK TABLES `user_sites` WRITE;

insert  into `user_sites`(`id`,`identity_id`,`name`) values (1,1,'Sample site 1'),(2,2,'Sample site 1'),(3,3,'Sample site 1');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
