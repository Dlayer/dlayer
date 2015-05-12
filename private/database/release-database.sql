/*
SQLyog Enterprise v12.11 (64 bit)
MySQL - 5.6.21-log : Database - dlayer
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

insert  into `designer_color_palette`(`id`,`name`,`view_script`) values (1,'Palette 1','palette-1'),(2,'Palette 2','palette-2');

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

insert  into `designer_color_palette_color`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (1,1,1,'Black','#000000'),(2,1,2,'Dark grey','#333333'),(3,1,3,'Grey','#555555'),(4,1,4,'Light grey','#777777'),(5,1,5,'Off white','#EEEEEE'),(6,2,1,'Blue','#337ab7'),(7,2,2,'Green','#5cb85c'),(8,2,3,'Light blue','#5bc0de'),(9,2,4,'Amber','#f0ad4e'),(10,2,5,'Red','#d9534f');

/*Table structure for table `designer_color_type` */

DROP TABLE IF EXISTS `designer_color_type`;

CREATE TABLE `designer_color_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_type` */

insert  into `designer_color_type`(`id`,`type`) values (1,'Primary'),(2,'Secondary'),(3,'Tertiary'),(4,'Quaternary'),(5,'Quinary');

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

insert  into `designer_content_heading`(`id`,`name`,`tag`,`sort_order`) values (1,'Page title','h1',1),(2,'Content heading 1','h2',2),(3,'Content heading 2','h3',3),(4,'Content heading 3','h4',4),(5,'Content heading 4','h5',5),(6,'Content heading 5','h6',6);

/*Table structure for table `designer_content_type` */

DROP TABLE IF EXISTS `designer_content_type`;

CREATE TABLE `designer_content_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_type` */

insert  into `designer_content_type`(`id`,`name`,`description`) values (1,'text','Text block'),(2,'heading','Heading'),(3,'form','Form'),(4,'jumbotron','Jumbotron'),(5,'image','Image');

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

insert  into `designer_css_border_style`(`id`,`name`,`style`,`sort_order`) values (1,'Solid','solid',2),(2,'Dashed','dashed',3),(3,'No border','none',1);

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

insert  into `designer_css_font_family`(`id`,`name`,`description`,`css`,`sort_order`) values (1,'Helvetica','Helvetica, Arial, Nimbus Sans L','Helvetica, Arial, \"Nimbus Sans L\", sans-serif',1),(2,'Lucida Grande','Lucida Grande, Lucida Sans Unicode, Bitstream Vera Sans','\"Lucida Grande\", \"Lucida Sans Unicode\", \"Bitstream Vera Sans\", sans-serif',2),(3,'Georgia','Georgia, URW Bookman L','Georgia, \"URW Bookman L\", serif',3),(4,'Corbel','Corbel, Arial, Helvetica, Nimbus Sans L, Liberation Sans','Corbel, Arial, Helvetica, \"Nimbus Sans L\", \"Liberation Sans\", sans-serif',4),(5,'Code','Consolas, Bitstream Vera Sans Mono, Andale Mono, Monaco, Lucida Console','Consolas, \"Bitstream Vera Sans Mono\", \"Andale Mono\", Monaco, \"Lucida Console\", monospace',5),(6,'Verdana','Verdana, Geneva','Verdana, Geneva, sans-serif',6),(7,'Tahoma','Tahoma, Geneva','Tahoma, Geneva, sans-serif',7),(8,'Segoe','Segoe UI, Helvetica, Arial, Sans-Serif;','\"Segoe UI\", Helvetica, Arial, \"Sans-Serif\"',8);

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

insert  into `designer_css_text_decoration`(`id`,`name`,`css`,`sort_order`) values (1,'None','none',1),(2,'Underline','underline',2),(3,'Strike-through','line-through',3);

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

insert  into `designer_css_text_style`(`id`,`name`,`css`,`sort_order`) values (1,'Normal','normal',1),(2,'Italic','italic',2),(3,'Oblique','oblique',3);

/*Table structure for table `designer_css_text_weight` */

DROP TABLE IF EXISTS `designer_css_text_weight`;

CREATE TABLE `designer_css_text_weight` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_weight` */

insert  into `designer_css_text_weight`(`id`,`name`,`css`,`sort_order`) values (1,'Normal','400',1),(2,'Bold','700',2),(3,'Light','100',3);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_attribute` */

insert  into `designer_form_field_attribute`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (1,1,'Size','size',1),(2,1,'Max length','maxlength',1),(3,2,'Columns','cols',1),(4,2,'Rows','rows',1),(5,3,'Size','size',1),(6,3,'Max length','maxlength',1),(7,1,'Placeholder','placeholder',2),(8,2,'Placeholder','placeholder',2),(9,3,'Placeholder','placeholder',2);

/*Table structure for table `designer_form_field_attribute_type` */

DROP TABLE IF EXISTS `designer_form_field_attribute_type`;

CREATE TABLE `designer_form_field_attribute_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_attribute_type` */

insert  into `designer_form_field_attribute_type`(`id`,`name`,`type`) values (1,'Integer','integer'),(2,'String','string');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_param_preview` */

insert  into `designer_form_field_param_preview`(`id`,`field_type_id`,`field_attribute_id`,`preview_method_id`) values (1,1,1,3),(2,1,2,3),(3,1,7,1),(4,2,3,3),(5,2,4,3),(6,2,8,1),(7,3,5,3),(8,3,6,3),(9,3,9,1);

/*Table structure for table `designer_form_field_type` */

DROP TABLE IF EXISTS `designer_form_field_type`;

CREATE TABLE `designer_form_field_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_field_type` */

insert  into `designer_form_field_type`(`id`,`name`,`type`,`description`) values (1,'Text','text','A single line field'),(2,'Textarea','textarea','A multiple line field'),(3,'Password','password','A password field');

/*Table structure for table `designer_form_preview_method` */

DROP TABLE IF EXISTS `designer_form_preview_method`;

CREATE TABLE `designer_form_preview_method` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_form_preview_method` */

insert  into `designer_form_preview_method`(`id`,`method`) values (1,'field_attribute_string'),(2,'row_attribute'),(3,'field_attribute_integer');

/*Table structure for table `dlayer_development_log` */

DROP TABLE IF EXISTS `dlayer_development_log`;

CREATE TABLE `dlayer_development_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `change` text COLLATE utf8_unicode_ci NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `release` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=592 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_development_log` */

insert  into `dlayer_development_log`(`id`,`change`,`added`,`release`,`enabled`) values (1,'Added a development log to Dlayer to show changes to the application, two reasons, one to spur on my development, two, to show the public what I am adding.','2013-04-05 00:38:16',0,1),(2,'Added a pagination view helper, update of my existing pagination view helper.','2013-04-05 00:38:52',0,1),(6,'Added a helper class to the library, initially only a couple of static helper functions.','2013-04-08 01:20:22',0,1),(7,'Updated the pagination view helper, added the ability to define text to use for links and also updated the logic for \'of n\' text.','2013-04-08 02:03:42',0,1),(8,'Updated the default styling for tables, header rows and table rows.','2013-04-08 02:19:22',0,1),(9,'Added the form for the add text field tool in the forms builder.','2013-04-12 18:15:57',0,1),(10,'Updated the base forms class, addElementsToForm() method updated, now able to create multiple fieldsets within a form, one fieldset per method call','2013-04-14 18:18:04',0,1),(11,'Updated all the help text for the template designer, simpler language.','2013-04-16 18:19:34',0,1),(12,'Added the form for the add textarea tool in the forms builder.','2013-04-20 18:20:36',0,1),(13,'Updated the pagination view helper, can now show either \'item n-m of o\' or \'page n of m\' between the next and previous links.','2013-04-21 18:46:50',0,1),(14,'Added base tool process model for the form builder, working on the add text field process tool model.','2013-04-25 01:37:41',0,1),(16,'Text field can now be added to a form in the form builder, still need to add supporting for editing a field.','2013-05-04 22:44:24',0,1),(17,'Text area field can now be added to the form, edit mode still needs to be added.','2013-05-12 02:27:58',0,1),(18,'Form builder now supports and displayed text area fields which have been added to the form defintion.','2013-05-12 02:28:13',0,1),(19,'Added initial styling for the form builder forms.','2013-05-12 03:12:49',0,1),(20,'The add field forms in the form builder now add the attributes for the text and textarea field types.','2013-05-14 01:48:24',0,1),(21,'Field attributes are now saved to the database and then pulled in the form builder and attached to the inputs.','2013-05-15 01:43:55',0,1),(22,'Reworked the javascript, selector functions have been moved to the module javascript files rather than the base Dlayer object.','2013-05-21 01:49:48',0,1),(23,'Public set methods (div and form field) now check that the given id belongs to the currently set template/form and site.','2013-05-28 01:02:38',0,1),(24,'Form module ribbon forms now show existing values when in edit mode.','2013-06-01 01:26:25',0,1),(25,'Edit mode in place for form text fields and form textarea fields','2013-06-11 00:00:23',0,1),(26,'Updated the template module and template session class, updated names of some logic vars, names more clear, wasn\'t always obvious what a var referred to.','2013-06-12 00:43:42',0,1),(27,'Multi use tool setting was not being respected in the form builder when adding a new field, field id was not being stored in session.','2013-06-16 21:09:23',0,1),(28,'Form fields not being pulled from database in correct order.','2013-06-16 21:09:54',0,1),(29,'Fixed a bug with the expand and contact tabs of the resize tool in the template designer, border widths were not being added to div width meaning that the split positions were not being calculated correctly.','2013-06-19 01:25:20',0,1),(30,'Pagination view helper wasn\'t escaping all developer defined text.','2013-06-25 23:31:43',0,1),(31,'Template module tool process methods now double check that the tool posted matches the tool defined in the session.','2013-06-25 23:51:11',0,1),(32,'Wife had a baby, Jack James','2013-06-28 05:41:00',1,1),(33,'Added the forms for the content headings to the content settings page, initially it just allows the user to update the params for the headings, there is no live preview or formatting.','2013-08-16 02:42:41',0,1),(34,'Added initial styling for the heading setting forms and added initial styling for the heading previews.','2013-08-16 03:37:51',0,1),(35,'Added live preview to the content settings page (header styles) defaults to show saved styles and then on change updates the previews.','2013-08-20 17:10:04',0,1),(36,'Refactored the designer js, all modules, simplifed the base dlayer object and moved all the js that was sitting in view files. Structure of the scripts folder now matches images and styles folders.','2013-08-21 01:46:02',0,1),(37,'Upgraded to jquery-1.10.2, fixed a small jquery issue with chrome, multi-line comment at top of script.','2013-08-22 23:53:30',0,1),(38,'Moved all the jquery required for the initial content module settings into the Dlayer js object.','2013-08-23 23:14:30',0,1),(39,'Added tabs to the content manager settings page, going to be too many settings for one page and the new layout will allow more detail to be given to the user.','2013-08-24 23:15:15',0,1),(40,'Added some default styling to the app, a tags and list items.','2013-08-25 01:57:42',0,1),(41,'Updated static validation helper class, now calls the new colorHex validation class','2013-08-26 02:50:26',0,1),(42,'Removed RGB entries for colours in the database, not required at the moment, going to just use hex values initially.','2013-08-28 00:47:24',0,1),(43,'Updated database and code, all fields relating to colour update to color_hex as that is currently what the field contains, later we can add a colour object is required with the RGB values and palette data, keeping things simple initially.','2013-08-28 00:48:48',0,1),(44,'Added the heading content type view helper to the content module, initially it adds all the header tag styles inline, this will be rectified later.','2013-08-29 02:37:13',0,1),(45,'Added a base font families table to the database and a corresponding font families settings table, allows the user to define the base font family per site/module, as in a base font family for the content manager and then the base font family for forms, support for the widget designer will be added later.','2013-08-29 19:54:42',0,1),(46,'Added the ability to define the base font family in the content module, the value is not currently being used by the designer, that support will be added shortly.','2013-09-06 16:44:18',0,1),(47,'Added a splash page to the app, this will be where the user logs in to get to their control panel.','2013-09-06 22:54:02',0,1),(48,'Re-skinned the app, new styling on the splash page, setting pages, base pages and development log.','2013-09-06 22:54:52',0,1),(49,'Re-skinned the designers, content manager, template designer and form builder','2013-09-09 00:42:34',0,1),(50,'Updated the tool bars in the three designers, tool icons are going to be larger.','2013-09-11 02:57:06',0,1),(51,'Added new tool icons for the template designer, setting the new style for the app, going for a sketchy look.','2013-09-11 15:23:44',0,1),(52,'Added new ribbon helper images for the split vertical and split horizontal tool, in the style of the new tool icons.','2013-09-12 01:34:09',0,1),(53,'Added new ribbon helper images for the resize tool and border tool','2013-09-12 18:30:43',0,1),(54,'Added a font size validator, PHP and JS. Added a hex regex for validation to the Dlayer JS object. Updated all the text in the app, now simpler and more consistent. Added custom titles to all pages. Updated for form formatting in the form builder, now appears against a white preview div.','2013-09-17 01:29:32',0,1),(55,'My standard development practice is to add enabled fields to most tables, the app takes the status fields into account and either processes, adds etc based on the status. Dlayer is an alpha level app at the moment, even though it is small, currently 36 tables, I don\'t need anything complicating the code, as such I have removed the enabled field from most tables. It still exists in a few base tables which control access to modules and access to tools but has been removed elsewhere. As parts of the app get more stable I will add back in the status fields as required.','2013-09-17 22:55:58',0,1),(56,'There was a layout file per module, because of the app design this wasn\'t needed, now use one layout file and the controller has an array of the css and js includes required for the controller actions.','2013-09-18 01:32:41',0,1),(57,'Site id was missing from 6 of the child layout tables, added site id, updated the models and simplified some of the layout queries that no longer need to do a join.','2013-09-19 17:50:13',0,1),(58,'Full app testing, fixed three minor bugs relating to the resize and border tools.','2013-09-20 02:53:29',0,1),(59,'Added a selected state to the toolbar buttons in the template designer, content manager and form builder.','2013-09-21 01:46:45',0,1),(60,'Reworked the template module ribbon data classes, now rely more on the base abstract class and there is less duplication, fixed a small bug when changing borders, incorrect id var was being used.','2013-09-23 15:07:29',0,1),(61,'Reworked the form module ribbon data classes, now rely more on the base abstract class and there is less duplication, system mirrors the more functional template designer.','2013-09-24 02:01:45',0,1),(62,'At the start of building this version of Dlayer I modified my development approach a little for this project. Typically I can plan the models and classes required to solve a problem fairly easily, with Dlayer because of the complexity I opted for a more procedural approach, this allowed me to put in place the structure for the first designer (template designer) which I then duplicated and modified for the form builder and content manager. \r\n\r\nAll three modules ended up with a very similar base, for the last week I’ve been refactoring the code adding core classes and models which handle the majority of the base functionality for each module, the ribbon, tool bars and tool processing code. \r\n','2013-10-01 18:25:30',0,1),(63,'Fixed a bug with the manual split tools, javascript wasn\'t taking the border of the parent element into account when drawing and calculating the split position and size of the new children.','2013-10-02 14:54:15',0,1),(64,'Split the content data methods out into their own models to match the rest of the system and as pre-planning for additional changes. Moved the margin settings for a heading, was defined in the heading styles settings, now defined per heading.','2013-10-02 17:45:30',0,1),(65,'Added new tool icons for the form builder and content manager and updated the cancel image for all three modules, didn\'t match the rest of the images.','2013-10-05 02:28:16',0,1),(66,'Initial content module ribbon development, ribbon classes and models.','2013-10-06 14:09:28',0,1),(67,'Ribbon forms in place for add heading and add text, now need to work on the tool processing code.','2013-10-06 23:35:12',0,1),(68,'Heading tool class now in place, heading can be added to the selected element, get positioned at the end of any existing content, obviously this will change with additional development.','2013-10-09 15:37:52',0,1),(69,'Simple text content block can now be added to the selected element.','2013-10-09 20:35:25',0,1),(70,'Render method on the base view helper was being called twice because of the way it was designer, removed the call to render() in toString() and now call render directly.','2013-10-09 21:09:55',0,1),(71,'Base content view helper, div_id was incorrectly commented as being the id of the div currently selected on the page, for adding content. Code and comments updated to make it clear that it actually refers to the id of the current div in the content data array. Added a method to set the id for the the currently selected div, if any.','2013-10-09 22:50:04',0,1),(72,'Modified the styling, switched to a light theme, going to work better for the alpha due to the limited number of tools in all the modules, darker theme can be added back in as an option later.','2013-10-12 01:03:44',0,1),(73,'Added the ability to edit both the heading and text content types. User chooses a div and then the content block, ribbon updates and they make the required changes.','2013-10-13 12:13:34',0,1),(74,'Set sensible values for text box width and padding, uses the containing div as a guide.','2013-10-13 12:20:32',0,1),(75,'Dlayer - Release 0.01 - Initial alpha release!','2013-10-14 01:39:45',1,1),(76,'There are two exit modes for a tool, multi-use where all session values remain and non multi-use when they are all cleared, for the content manager added a third mode to enable some vars to be kept.','2013-10-15 16:49:06',0,1),(77,'After adding or editing a text block the base content block remains selected, tool and content ids now cleared, better usability than previous set up.','2013-10-15 16:49:23',0,1),(78,'Fixed a small bug with heading tool, view script folder case incorrect, errored on case indifferent servers.','2013-10-23 02:07:17',0,1),(79,'List of sites now pulled from database on home page, adding a link to allow user to activate a site rather than default to the first.','2013-10-24 02:26:17',0,1),(80,'User is now able to choose a new site to work on from the sites list. On selecting the last accessed site is updated so that the next time the user accesses Dlayer the last accessed site is selected. As there is no authentication system yet site changes will affect all users.','2013-10-28 16:54:57',0,1),(81,'Added a validate site id view helper, checks site id exists in session and also a valid site id, later it will also check against the user/auth id.','2013-10-30 01:32:10',0,1),(82,'Added a validate template id view helper, checks template id is valid, as in exists in the database and belongs to the site id in the session.','2013-10-30 01:58:23',0,1),(83,'Added a validate form id view helper, checks form id is valid, as in exists in the database and belongs to the site id in the session.','2013-10-30 02:07:19',0,1),(84,'Added a validate content id view helper, checks content id is valid, as in exists in the database and belongs to the site id in the session.','2013-10-30 02:21:46',0,1),(85,'Template list, page list and form list now come from the database, not static text, design options only show for active item.','2013-11-01 02:38:21',0,1),(86,'Added an activate method to allow the user to switch the template, page or form they are working on with the site.','2013-11-01 23:24:34',0,1),(87,'A user can now create a new site, a site is currently just a unique name.','2013-11-06 01:52:52',0,1),(88,'Added the ability to edit a site, as per add site a site is currently just a unique name, this will develop later.','2013-11-07 01:56:41',0,1),(89,'Updated the formInputsData methods in forms, now checks the return type of model data and then acts accordingly, form elements now check to ensure data index exists before setting value.','2013-11-08 16:57:10',0,1),(90,'Added add and edit template, currently a template is just a unique name for the site.','2013-11-08 16:57:25',0,1),(91,'Added add and edit form, currently a form is just a unique name for the site.','2013-11-09 12:57:30',0,1),(92,'Add and edit new page in place, user needs to choose template to base page upon, enter a name and also the title to use for the page, as the system evolves more will need to be defined. Removed addDefaultElementDecorators() methods from site form classes, no need to override the default in the base form class as nothing was being changed. ','2013-11-10 13:00:52',0,1),(93,'Added my authentication system to Dlayer, because demo usernames and passwords are exposed an account can only login from one location, timeout on session is an hour so if a user exists without logging out the account will become available for another user after an hour. ','2013-11-13 13:01:44',0,1),(94,'Dlayer - Release 0.02 - Minor release, fixed heading tool and made some UX tweaks to tools','2013-10-23 16:38:09',1,1),(95,'Dlayer - Release 0.03 - Minor release, added the base creation tools, new site, template, form and page.','2013-11-10 16:38:53',1,1),(96,'Release messages highlighted in the development log.','2013-11-13 16:46:38',0,1),(97,'Started publically showing updates, SVN log extends much further back in history but I saw no need to transfer messages across.','2013-04-04 16:49:23',1,1),(98,'Site list now pulls sites based on identity. Updated site history table/code and action helper to check site id validity, now all use the current identity.','2013-11-14 01:43:18',0,1),(99,'No longer able to edit the name of the first sample site, used by the history tables and always defaulted if no other data in the system for identity.','2013-11-14 01:45:14',0,1),(100,'Notification next to username/password combinations if the account if currently logged in. Added a \"What is dlayer?\" page, it gives a brief overview of Dlayer and the history behind it.\r\n','2013-11-14 23:50:49',0,1),(101,'Updated database, added defaults for all settings for the three test sites.','2013-11-16 14:48:23',0,1),(102,'Fixed a bug with the activate methods, validate template id action helper was using the wrong session when in the content module.','2013-11-17 19:55:21',0,1),(103,'Added 1 sample site, 1 sample template and 1 sample page for each user, enough to allow people to play.','2013-11-17 19:55:44',0,1),(104,'Dlayer - Release 0.04 - Authentication system in place.','2013-11-17 20:56:23',1,1),(105,'Once you create a page from a template there need to be restrictions in place to either limit what tools can be used on an active template or extra code to manage structural  changes behind the scenes. Until I put some initial restrictions in place I have disabled the template designer, hoping to re-enable it within the next two weeks.','2013-11-17 20:03:54',0,1),(106,'Updated server to PHP 5.4, switched crypt() over to SHA_512, test identity credentials updated.','2013-11-19 01:34:16',0,1),(107,'In the template designer a tool can now be disabled if using it would be destructive. For example when a page is created from a template if the specified template div has content assigned to it on one or more pages, splitting the div would currently make the content appear to disappear. Logic needs to be added to gracefully handle these destructive changes, for now though the app just forbids access.','2013-11-19 17:20:07',0,1),(108,'Added new icons for disabled toolbar buttons, desaturated version of the icon.','2013-11-20 02:15:32',0,1),(109,'Updated the set tool action, when a tool has been disabled in the view the set tool action checks to ensure that the disabled URL can’t be called manually by the user.','2013-11-20 17:40:21',0,1),(110,'Added base font family settings to the form builder module, as per content manager module, value is not yet used in the designer.','2013-11-21 01:23:51',0,1),(111,'Xbox One and Forza 5 released.','2013-11-22 09:00:00',1,1),(112,'Updated the help text in form builder for text and textarea field tools, little more clear on what happens after a field has been added to their form.','2013-11-26 17:24:37',0,1),(113,'Added password tool to form builder, users can now add password fields to their forms.','2013-11-27 02:11:08',0,1),(114,'Temporarily added the resize tool in the template designer to the disabled tools list if template div has content on an active page. I need to develop a system that makes changes to pages in the background when a template is updated, because the resize tool affects more than the selected div I have for now disabled access until I develop the system which updates data between modules.','2013-11-27 15:18:25',0,1),(115,'History of Dlayer split out from the What is Dlayer? page.','2013-11-29 02:12:14',0,1),(116,'Base modifier system in place, this is called when there needs to be interaction between modules, if a user changes something in one module that affects data in another module modifiers can be sent requests to check to see if any changes are required and then make them if necessary.','2013-12-01 02:27:30',0,1),(117,'Border tool re-instated in the template designer when a user chooses to work on a template block which has content applied to it on a page based upon the current template. A change width modifier has been added, this modifier checks all the content items to see if the widths for the containers need to be updated (The width of a page div will change if a border is added, edited or removed on a  template block). ','2013-12-01 02:27:40',0,1),(118,'Dlayer - Release 0.05 - Modifier system, password tool in form builder, new settings for form builder, template designer tool restrictions and general tweaks.','2013-12-01 12:24:18',1,1),(119,'Abstract validate and autoValidate methods moved from base tool class down a level into the base module tool class, additional context data will be needed for validations and it will differ by module.','2013-12-02 17:09:17',0,1),(120,'Container for text content can now no be larger that the page block it is being added to.','2013-12-02 17:23:46',0,1),(121,'Base font family settings set for the content manager and form builder now used in the designers.','2013-12-04 02:14:51',0,1),(122,'Dlayer - Release 0.06 -  Minor release, validation, settings and general small fixes.','2013-12-04 02:15:23',1,1),(123,'Added width and left margin to heading content type, width and left padding when summed can be no larger than the containing page block.','2013-12-13 14:53:05',0,1),(124,'Added a container div around content items in the content designer, js hover and click events moved to the parent container item, this is so that the movement controls will only show for each content item on hover.','2013-12-18 16:22:43',0,1),(125,'Movement controls added to content items, not yet active.','2013-12-21 21:12:43',0,1),(126,'Content items in the content manager can now be moved around, the user needs to select the page block then as they hover over the content items up and down movement links appear.','2013-12-23 12:30:41',0,1),(127,'Dlayer - Release 0.07 - Minor release, content items can be moved and heading content item updated.','2013-12-23 12:32:08',1,1),(128,'Removed the mode switching buttons, don\'t really do anything yet, also, not sure where to add them in the new designer yet.','2014-01-12 11:10:16',0,1),(129,'Updated the styling in the template designer, matches the new design.','2014-01-14 11:31:16',0,1),(130,'Modified the base width of the app, now 1366 pixels, this will match the Windows 8 version of Dlayer when developed. All the base pages have been updated along with the setting sections.','2014-01-10 14:17:40',0,1),(131,'Expand and Contract options for resize tool now no longer shows the options that can\'t be used for the selected block, previously all options were shown and the form button was disabled if not relevant. The ribbon has been moved to the right hand side below the tool buttons, no longer pushes the design down.','2014-01-15 01:03:54',0,1),(132,'Updated the styling in the content manager, matches the new design.','2014-01-15 01:22:00',0,1),(133,'Updated the styling in the form builder, matches the new design.','2014-01-16 00:14:18',0,1),(134,'Fixed the content manager heading tool, the left margin value wasn\'t being passed through in the post data array, this was causing the validate method to return FALSE and the tool to never process correctly. The heading tool now checks the size of the page block it is being added, this is done so that sensible defaults can be calculated and to ensure that a user can\'t add a heading container which is larger than the page block.','2014-01-17 15:10:25',0,1),(135,'When I resized the designers I realised I had sinned, the width and heights were defaulted within the code, now corrected, there is no such thing as a value that won\'t need to be changed at some point during the projects life.','2014-01-17 15:24:09',0,1),(136,'Reworked the toolbar panels, now only show tools when relevant, the selected tool is clearer and styling has been updated. Tool options styling has been simplified, forms are now clearer.','2014-01-19 00:54:04',0,1),(137,'Top menu updated to show state.','2014-01-19 01:35:16',0,1),(138,'Add new site wasn\'t creating three default palettes for the user, later users will be able to define their own palettes during create site or modify the default palettes.','2014-01-19 16:18:05',0,1),(139,'Adding a new website now inserts initial values for the content manager heading styles, can be updated by the user in the settings.','2014-01-19 19:49:50',0,1),(140,'Adding a new website now inserts initial values for the base font family to use in the content manager and form builder.','2014-01-19 20:50:07',0,1),(141,'If there is no data for a new user a sample site is created, three colour palettes are created and default values are set for the heading styles and base font family settings. Pages, templates and forms are not created, when the designers are more functional there will be sample templates, forms and pages for the sampkle site.','2014-01-20 15:36:40',0,1),(142,'Dlayer - Release 0.08 - New release, new cleaner design for all the designers, bugs fixes and tweaks.','2014-01-20 15:37:34',1,1),(143,'Database work to support allowing a form to be imported as a content item.','2014-01-20 22:16:01',0,1),(144,'Updated \'What is Dlayer?\' page.','2014-01-21 01:20:54',0,1),(145,'Minor style and content changes.','2014-01-22 00:33:56',0,1),(146,'Additional base development to allow forms to be added a content item.','2014-01-24 00:34:24',0,1),(147,'Dlayer - Release 0.09 - Minor release, contains the base code which I will build to allow forms to be added as content items in the form builder.','2014-01-24 00:37:35',1,1),(148,'Custom option for background color now allows the user to choose a color using the HTML5 color picker.','2014-01-24 16:06:27',0,1),(149,'Upgraded the tool controls in the template design, now using HTML5 elements where appropriate.','2014-01-24 16:12:42',0,1),(150,'Upgraded the tool controls in the content manager and form builder, now also using HTML5 elements where appropriate.','2014-01-24 16:46:53',0,1),(151,'Updated the content manager heading style setting forms, now use HTML5 elements where appropriate.','2014-01-24 16:56:28',0,1),(152,'Dlayer - Release 0.10 - Minor release, added custom option for back colour in the template designer and switched a few form elements over to HTML5','2014-01-25 00:58:06',1,1),(153,'Dlayer - Release 0.11 - Minor release, housekeeping','2014-01-25 16:54:44',1,1),(154,'Added ability to define placeholder text for text, text area and password tools in the Form builder.','2014-01-25 22:12:15',0,1),(155,'Styling updates, also added another font family to the base font family settings.','2014-01-26 17:12:32',0,1),(156,'Reworked the settings pages, now possible to jump between modules without having the leave the settings section.','2014-01-27 01:30:01',0,1),(157,'Added a footer to the app, provides access to development log and development plan when in the designers.','2014-01-27 01:48:12',0,1),(158,'Import form tool added to tool bar and relevant entries added to database, data form not yet in place.','2014-01-27 02:15:14',0,1),(159,'Show identity (email) on menu bar to assist users that use more than one account.','2014-01-28 01:16:44',0,1),(160,'Inputs all displays for the import form tool.','2014-01-28 01:35:20',0,1),(161,'Updated the definition for the module session reset methods, wasn\'t completely clear about what would be cleared. Initial validation in place for import form tool, doesn\'t yet calculate and approximate width for a form and whether it will fit in the page block, that will be added later.','2014-01-29 16:32:05',0,1),(162,'Development plan now shows progress messages.','2014-01-29 16:45:21',0,1),(163,'Import form tool in content manager allows user to add form as a content item, not yet rendered in the designer or or editable.','2014-01-30 00:50:55',0,1),(164,'Content manager design view now shows the imported form, styling is not working correctly.','2014-01-30 21:29:25',0,1),(165,'Added ability to move form content items around in the content manager, same movement controls as text and heading content items.','2014-01-31 16:13:22',0,1),(166,'Updated select and move js, with earlier tools, content type and tool where the same, that changed with the import form tool.','2014-01-31 20:34:31',0,1),(167,'Updated process controller in content manager, needed to stop using tool for processing, no longer always going to match the content type so need separate vars.','2014-02-01 16:25:06',0,1),(168,'Added ability to edit the details for the selected form in the content manager.','2014-02-01 16:29:02',0,1),(169,'Updated container width modifier, now looks at form content items.','2014-02-01 22:19:27',0,1),(170,'Added a page for known bugs.','2014-02-01 22:32:53',0,1),(171,'Dlayer - Release 0.12 - Major milestone release, three modules are now communicating with each other, the Template designer, Form builder and Content manager. The import form tool is now in place, a form can be added as a content item. All forms retain their links with the Form builder so changes are shown immediately.','2014-02-01 22:56:51',1,1),(172,'Styling updates. Designer hover styling, text area font size and also the movement controls in the content manager.','2014-02-03 17:07:54',0,1),(173,'Moved model methods required by modifiers into their own model classes, need to keep separate from the general user processing code.','2014-02-04 01:05:32',0,1),(174,'Both setting menus, section and setting now come from the database, tied to the modules so settings groups and settings will only show if module, group and setting are active.','2014-02-07 15:43:05',0,1),(175,'Updated the currently disabled modules, been lots of base changes that hadn’t be carried across, now all consistent.','2014-02-08 11:01:48',0,1),(176,'Updated the content module tool and model classes, much clearer now because the content type will not always match the tool type, method names were not obvious.','2014-02-10 16:40:13',0,1),(177,'Added a mover view helper, generates the html for the movement controls in the content manager.','2014-02-11 17:14:13',0,1),(178,'Added movement controls view helper for form builder.','2014-02-12 17:00:35',0,1),(179,'Added ability to move form fields around on the form, same controls as content manager.','2014-02-14 00:56:56',0,1),(180,'Stopped showing the move up and move down controls for the first and last form fields respectively.','2014-02-14 01:52:37',0,1),(181,'Dlayer - Release 0.13 - Maintenance release, reworked some of the tools code and added ability to move assigned form fields around.','2014-02-14 14:44:20',1,1),(182,'Dlayer - Release 0.14 - Bug fix release, a couple of bugs appeared in the last version, now fixed, affected text modifier and add text tool.','2014-02-16 22:37:12',1,1),(183,'Updated the tools, removed fields and logic no longer required now that the tools are text buttons not images.','2014-02-17 11:08:21',0,1),(184,'Web site manager framework code in place, still working on the preview.','2014-02-18 23:05:17',0,1),(185,'Content update, A bug was listed in the development plan but really needed to also be in the bugs section. Added new sections to the development plan.','2014-02-19 17:04:23',0,1),(186,'Dlayer - Release 0.15 - Content release, new content and also includes base code required by the Website manager.','2014-02-19 17:09:11',1,1),(187,'Minor styling updates to tools and tool options/ribbon.','2014-02-24 01:02:52',0,1),(188,'Initial preview design for web site manager added, non functional, just shows initial tools and controls.','2014-02-24 17:09:24',0,1),(189,'Dlayer release 0.16 - Web site manager preview.','2014-02-24 17:17:17',1,1),(190,'Initial design for the colour picker in place, not yet functional.','2014-02-27 01:30:49',0,1),(191,'Colour picker shows the live data for the three palettes.','2014-03-02 16:48:15',0,1),(192,'Added a history table for used colours, colour picker now shows the last five used unique colours.','2014-03-03 00:30:10',0,1),(193,'Added colour picker to custom tab of background colour tool, allows user to choose colour from palettes, history and create a custom colour, history section not yet updated with new values.','2014-03-03 02:00:51',0,1),(194,'Moved all colour picker logic into a view helper, will be called multiple times within app, developer gets to define which of the three sections they want to include in the picker.','2014-03-04 02:21:44',0,1),(195,'Added colour picker to both tabs of the border tool. Switched colour picker to be a class rather than an id, javascript was failing with ajax caching issue, not all close.','2014-03-06 02:04:45',0,1),(196,'Dlayer - Release 0.17 - Colour picker in place in Template designer.','2014-03-06 09:20:17',1,1),(197,'Updated the help tabs for the three active tools in the Content manager, give a more detailed overview of the tool.','2014-03-06 11:00:37',0,1),(198,'Content manager tools updated, added the ability to allow tabs which only show in edit mode, for each tool this is currently a styling tab.','2014-03-06 16:28:34',0,1),(199,'Extended Zend forms, added a colour picker input, includes hidden element for value and the div invoke the picker.','2014-03-06 16:41:45',0,1),(200,'Updated the help tabs for the five active tools in the Template designer, give a much more detailed overview for each tool.','2014-03-06 17:04:04',0,1),(201,'Modifying the tool system in the Content manager to support sub tools.','2014-03-07 23:48:53',0,1),(202,'Added the forms and view data for the container styling tab of the text tool.','2014-03-07 23:50:24',0,1),(203,'Added ability to define whether a clear link should be added after the colour selector, with container styling it is valid that a user want to reset a colour.','2014-03-08 01:25:20',0,1),(204,'Modified the Content manager process controller to look to see if request should be sent to a sub tool rather than the base tool for the content item type.','2014-03-09 17:27:50',0,1),(205,'Sub tool in place which allows a user to define the background colour for a text content item, edit the colour and then clear the colour if they want to.','2014-03-11 02:47:09',0,1),(206,'Renamed style view helper classes, responsible only for templates so changing name accordingly to make way for content versions.','2014-03-12 16:00:15',0,1),(207,'Text content item containers now use the background colour defined in the tools styling tab.','2014-03-13 17:26:36',0,1),(208,'TitanFall released on PC.','2014-03-14 16:21:07',1,1),(209,'Edit mode Content manager, selecting a different tool wasn\'t clearing the content id, tabs which should only appear in edit mode were showing for other content tools.','2014-03-14 16:34:22',0,1),(210,'Mouse cursor now correctly switching when choosing a page block.','2014-03-14 16:37:15',0,1),(211,'Added a styling tab to the heading content item tool when in edit mode, allows user to define background colour for heading container.','2014-03-14 16:46:15',0,1),(212,'Content tools set to multi use, return user back to editor with tool still selected.','2014-03-16 16:51:59',0,1),(213,'Added ability to define a background colour for an imported form item, use styling tab.','2014-03-16 16:52:06',0,1),(214,'Dlayer - Release 0.18 - Added a styling tab to each of the Content manager tools.','2014-03-16 16:59:49',1,1),(215,'Updated all the Content manager tool forms, now all derive from a base form for the Content manager, this extends the base Dlayer form. Updated all the Content manager tool data classes, now all derive from a base tool data class for the Content manager, this extends the base tool class.','2014-04-02 16:51:29',0,1),(216,'Fixed a bug with Template designer, unable to select base block with a new template.','2014-04-07 15:58:21',0,1),(217,'Edit field forms in the Form builder not always behaving correctly, occasionally a new field was being added rather than the selected one being edited. Updated all the Form builder tool forms, now all derive from a base form for the Form builder, this extends the base Dlayer form.','2014-04-07 16:22:51',0,1),(218,'Fixed a bug with create site script, was attempting to create an extra heading that couldn\'t be referenced back to designer headings.','2014-04-07 16:30:59',0,1),(219,'Added a base form class for app level forms, updated all base level forms to extend new base class.','2014-04-10 17:22:05',0,1),(220,'Create site script now inserts initial values into the colour history table.','2014-04-12 16:40:47',0,1),(221,'Fixed a few minor bugs found during pre release testing.','2014-04-12 17:03:36',0,1),(222,'Minor styling updates to designers.','2014-04-13 01:10:03',0,1),(223,'Dlayer - Release 0.19 - Maintenance release, refactoring, tweaks and bug fixes.','2014-04-13 01:57:20',1,1),(224,'Added field type to Form builder tools, works in conjunction with tool value for when the tool and field type don\'t match, an example being the email field which is a text field.','2014-04-14 02:41:31',0,1),(225,'Styling issue with tool forms, some fields not displaying using the correct font families.','2014-04-15 01:27:44',0,1),(226,'Added a name and email tool to the form builder, these are quick versions of the text tool, values preset. Currently only the field values are preset, as the system evolves validation values and other attributes will be preset as well.','2014-04-15 16:15:33',0,1),(227,'Updated form builder in designer, wasn\'t selecting the correct tool when editing using a quick tool, name and email.','2014-04-15 16:44:32',0,1),(228,'Form builder now has field type and tool as properties, updated selectors and movers to take new params into account, new name and email fields where being selected as text fields, their base type.','2014-04-16 01:51:13',0,1),(229,'Updated maintenance page, text wasn\'t accurate.','2014-04-17 16:33:13',0,1),(230,'Dlayer - Release 0.20 - Added two quick tools to the Form builder, name and email, these add a pre populated text field, as the Form builder develops these tools will add the correct validation rules and set other options. ','2014-04-17 16:34:48',1,1),(231,'Added position tab to Import form tool, has inputs for top, right, bottom and left.','2014-04-22 01:46:26',0,1),(232,'Added position tab to heading and text content item tools, not yet functional.','2014-04-23 01:29:30',0,1),(233,'Updated margins container table in database, fields don\'t need margin_ prefixed, margin table so top, right, bottom and left is sufficient.','2014-04-25 16:51:38',0,1),(234,'Added position model, will be used by the Content manger sub tools.','2014-04-25 16:56:57',0,1),(235,'Styling tab of text content tool now adds the position values (margins) to the database, can be updated and deleted dependant on posted data.','2014-04-27 13:23:34',0,1),(236,'Content item view helper now uses defined margin values.','2014-04-28 01:57:05',0,1),(237,'Content text view helper now correctly sizes the selectable content item container if margin (position) values have been set.','2014-04-28 16:51:21',0,1),(238,'Edit text content item updated, validation now includes container position (margin) values when calculating if content item will be larger than the page container.','2014-04-28 17:21:33',0,1),(239,'Updated Container width modifier, now aware of position values (margin) for a text content item. margin values only used in calculations, not modified, this will change in a later development branch as the modifier system gets more smart, it should prioritise margin changes over content item width changes.','2014-04-29 02:21:38',0,1),(240,'Position tab disabled for Heading and Import form tools, will be enabled in next release.','2014-04-29 02:24:15',0,1),(241,'Updated the modifier system, now aware of margin values (position) on text content items, value taken into account when calculating how the width needs to be adjusted.','2014-04-30 16:03:20',0,1),(242,'Dlayer - Release 0.21 - Position tab added to text content item tool.','2014-04-30 17:21:52',1,1),(243,'Added heading position and import form position sub tools.','2014-05-01 16:15:07',0,1),(244,'Enabled position tabs for Heading and Import form tools.','2014-05-01 16:16:37',0,1),(245,'Updated the form and heading view helpers, now aware of container margins.','2014-05-01 16:35:11',0,1),(246,'Updated modifier system, now aware of margins applied to form and heading content containers.','2014-05-02 01:23:57',0,1),(247,'Updated login page, focus now goes straight to username.','2014-05-02 01:36:24',0,1),(248,'Dlayer - Release 0.22 - Position tab added to import form and heading tools.','2014-05-02 01:42:41',1,1),(249,'Removed the headings from the content sub tools tabs, duplicated tab text and pushed text/controls down.','2014-05-02 14:55:37',0,1),(250,'Added three preset links to the import form tool position tab, sets the margin values to left, right and center align the selected content item.','2014-05-02 16:46:53',0,1),(251,'Preset links added to the heading and text tools position tabs, same functionality as import form.','2014-05-02 16:48:40',0,1),(252,'Quick tools in Form builder (name and email) no longer show the form when the user is adding the field, only when they are editing the field.','2014-05-03 15:30:46',0,1),(253,'Dlayer - Release 0.24 - UX improvements.','2014-05-03 15:48:14',1,1),(254,'Added support for edit mode only tool tabs in the Form builder, same functionality as the Content manager.','2014-05-04 16:13:27',0,1),(255,'Updated Content manager process controller, now knows to look for sub tools.','2014-05-04 16:16:30',0,1),(256,'Added styling sub tool to Form builder text tool, shows control which will allow a background colour to be set for the row, not yet functional, just display at this point.','2014-05-04 23:08:13',0,1),(257,'Styling sub tool for text field now allows a user to define row background colour, update it and delete it.','2014-05-05 15:45:22',0,1),(258,'Form builder now displays the assigned styles in the designer view.','2014-05-09 16:09:28',0,1),(259,'Moved content view models, placement didn\'t fit with addition of content style view models.','2014-05-09 16:33:51',0,1),(260,'Defined background colours for form field rows now appear when in the Content manager.','2014-05-10 01:15:29',0,1),(261,'Added styling tab to textarea tool in Form builder, only shows when editing a field.','2014-05-10 01:40:49',0,1),(262,'Added styling tab to Name, Email and Password tools, as per other sub tools, only shows on edit.','2014-05-12 21:49:51',0,1),(263,'Fixed bug with select content item in Content manager, when a margin is applied content item not selectable when user clicks margin around item.','2014-05-12 22:21:18',0,1),(264,'Fixed bug in Form builder, after addition quick fields not remaining selected.','2014-05-12 22:21:33',0,1),(265,'Updated sample data for websites.','2014-05-12 22:26:20',0,1),(266,'Dlayer - Release 0.25 - Styling tab in Form builder.','2014-05-12 22:35:08',1,1),(267,'Fixed a bug with the manual split tools in template designer, occasionaly not sending request through.','2014-05-13 15:25:52',0,1),(268,'Added an information block in Content manager when both page container and tool selected, gives width of content container and its height.','2014-05-13 15:25:58',0,1),(269,'Added page container metrics blocks to Template designer, shows when a page container and tool are selected.','2014-05-19 11:44:17',0,1),(270,'Fixed a bug with the split tools, by default all newly creating blocks are now fixed height, converted to dynamic height automatically if children are added, another split. - Later the system will allow the user to override this and set the height manually, either pixels or dynamic.','2014-05-19 11:57:47',0,1),(271,'Page container metrics in Template designer and Content manager now hidden behind toggle.','2014-05-19 12:21:49',0,1),(272,'Dlayer - Release 0.26 - Added page container metrics blocks to Content manager and Template designer and fixed two bugs in the Template designer.','2014-05-19 15:44:38',1,1),(273,'Added the html and styling for the content item metrics section in the Content manager, also included the JS to toggle the metrics.','2014-05-24 17:09:37',0,1),(274,'Content manager now shows content item metrics for text content items.','2014-05-25 16:53:31',0,1),(275,'Content item metrics block now shows correct data for heading and form content types.','2014-05-26 01:09:57',0,1),(276,'All tools that use a colour now write to the colour history table, previously the colour palette was showing 5 static history colours.','2014-05-26 16:25:19',0,1),(277,'Updated site content.','2014-05-26 23:57:02',0,1),(278,'Refactoring.','2014-05-27 00:23:16',0,1),(279,'Dlayer.com - Release 0.27 - Content item metrics and colour picker history.','2014-05-27 12:24:14',1,1),(280,'Added in js to preview form field label changes, updates designer live, if the field is marked as required in the tool form clearing the value resets it to the initial value.','2014-05-27 15:36:21',0,1),(281,'Updated the live preview js, now two base methods, one that deals with html element values and one that handles form field attribute values.','2014-05-28 00:44:48',0,1),(282,'Message now displays when data needs to be saved, displays above form when any data is modified, called by the preview functions.','2014-05-28 00:59:03',0,1),(283,'Updated the preview methods for form field params, now aware of types, strings and integers, only process when values are valid. Added tables to manage links between preview methods and form field attributes base on attribute type.','2014-05-28 16:11:39',0,1),(284,'Preview js methods and data now pulled from the database for the selected field, currently limited to text fields.','2014-05-29 17:08:36',0,1),(285,'Form builder was not using correct builder method for name and email inputs, needs to use custom method so later specific validation rules and options can be set. Data changed method (form builder edit preview) firing sometimes when data hadn\'t changed. Updated the styling for the Data changed message, now can\'t be missed','2014-05-31 15:43:32',0,1),(286,'Edit previews now displays for all form builder field types.','2014-05-31 16:01:52',0,1),(287,'Created the js for the row background colour change preview. Modified the selected style, now includes a top and bottom border for when the user clears the row background colour, this way the selected item is still visible. Colour picker now triggers a change even on the hidden input used to store the colour.','2014-06-01 00:45:37',0,1),(288,'Existing data for row background colour now passed through to js preview methods. Updated the ribbon data classes, edit mode is now passed through to all data classes to reduce work in default tool mode.','2014-06-01 15:38:18',0,1),(289,'Dlayer.com - Release 0.28 - Form builder now has live previews when form data is being amended.','2014-06-01 15:53:20',1,1),(290,'Moved preview data for editing field data from controller to ribbon data classes as per styling preview data.','2014-06-02 14:38:10',0,1),(291,'Preview code to set original value if field empty was overriding changed values on keyup (tab)','2014-06-02 14:44:48',0,1),(292,'Clear link for row background colour now correctly clears the background colour in the picker and the form field row. Need to add a reset link to return the value to the original value if it existed.','2014-06-02 14:53:51',0,1),(293,'Added tab to import form tool in Content manager, include a link to jump directly to Form builder (non functional)','2014-06-02 15:14:09',0,1),(294,'Link now takes user directly to Form builder with form selected.','2014-06-02 15:46:58',0,1),(295,'Link now appears in Form builder when a user jumps to it from the Content manager, takes them back to exactly where they were.','2014-06-02 15:59:57',0,1),(296,'Dlayer - Release 0.29 - Preview system bug fixes and module jumping.','2014-06-03 01:03:44',1,1),(297,'Added data tables for text and heading content to database.','2014-06-03 12:21:27',0,1),(298,'Text and heading data now pulled from linked data tables, no longer static in the content container item tables.','2014-06-03 13:04:05',0,1),(299,'Heading and text tools forms updated, now pull data from the linked data tables. Add and edit not yet updated to write to new table and check for duplicate content.','2014-06-03 13:24:51',0,1),(300,'Added name to text and heading tool forms, will be used to identity text data items so they can easily be re-used.','2014-06-03 13:47:47',0,1),(301,'Updated heading and text tools, now aware of content data tables and either insert new content data item or fetch id of existing data item based on supplied content.','2014-06-04 16:29:14',0,1),(302,'Minor styling updates for all forms.','2014-06-05 01:05:58',0,1),(303,'Dlayer - Internal release 0.30 - Text and heading content tools reference based.','2014-06-09 16:39:51',1,1),(304,'Updated all ribbon data classes, edit mode boolean now passed in so it can be forwarded to forms.','2014-06-10 10:43:26',0,1),(305,'Edit mode status boolean made available to all ribbon forms.','2014-06-10 12:01:17',0,1),(306,'Instances select added to edit heading and text tools, when the content item data is being used by more than the selected content item the user now has a choice about whether to update the text data for all instances or just the selected content item - not yet functional, just displays option when appropriate.','2014-06-10 12:38:17',0,1),(307,'Heading and text tools correctly update data based on the instances option.','2014-06-10 23:40:59',0,1),(308,'Dlayer - Release 0.31 - Text data for text and heading tools now assigned by reference, not static, text data can be used by multiple items.','2014-06-12 10:39:26',1,1),(309,'Import text tool added, currently not functional, forms and tool classes created.','2014-06-13 15:19:33',0,1),(310,'Initial AJAX in place to populate the textarea when the user chooses to text to import.','2014-06-14 00:49:30',0,1),(311,'Import tool now functional, allows used to choose existing text to import into a new content container.','2014-06-14 23:08:24',0,1),(312,'Updated form class, added a view mode param, in view mode ids are not added to form field rows.','2014-06-14 23:54:45',0,1),(313,'Updated settings, when base level is selected, user now directed to first setting within group.','2014-06-15 00:12:57',0,1),(314,'Dlayer - Release 0.32 - Added import text tool.','2014-06-15 00:19:56',1,1),(315,'Updated the help text for the import text tool.','2014-06-15 14:51:59',0,1),(316,'Added import heading tool, same functionality as import text tool.','2014-06-16 01:21:48',0,1),(317,'Dlayer - Release 0.33 - Added import heading tool.','2014-06-16 01:30:59',1,1),(318,'Added highlight effect to form field preview changes in form builder. Slightly modified tool controls styling.','2014-06-16 13:34:35',0,1),(319,'Added live edit preview for set content container background colour in Content manager.','2014-06-16 23:51:24',0,1),(320,'Added live edit preview for container container position updates.','2014-06-17 00:36:27',0,1),(321,'Moved all js back into a single file, Dlayer object being split over multiple files was causing issues with code completion, will split later in development.','2014-06-17 15:11:05',0,1),(322,'Created base js functions which will update the width and padding for a content container taking into account all the other attributes that affect the total width of an item.','2014-06-17 17:03:01',0,1),(323,'Created base js functions which will alter individual padding values, both top and bottom which don’t affect container width and left and right which do.','2014-06-17 17:26:52',0,1),(324,'Created base js functions which will alter content item content.','2014-06-18 01:00:58',0,1),(325,'Moved everything to GitHub after Codespaces.com collapsed.','2014-06-18 17:01:05',1,1),(326,'Tested preview functions for heading tool, text tool and import form tool, all function correctly.','2014-06-19 00:34:41',0,1),(327,'Data for previews now passed from ribbon data class to view.','2014-06-19 11:41:50',0,1),(328,'Dlayer - Release 0.35 - Live previews in Content manager. (Release 0.34 was to test git release management)','2014-06-19 13:06:56',1,1),(329,'Removed all the old js files now that the entire Dlayer object is within a single file. Updated environment settings, couple of minor issues after initial release from github.','2014-06-19 16:41:53',0,1),(330,'Tool tab switch now looks at the preview state properties, if there are unsaved changes the designer does a window.replace after switching the tab, this resets the designer view.','2014-06-20 02:00:29',0,1),(331,'Moved all preview state vars and methods above module properties.','2014-06-20 02:10:01',0,1),(332,'Updated base font styling for Dlayer. Modified the layout and styling for the setting pages.','2014-06-20 15:29:39',0,1),(333,'Updated margin (position) preview methods, weren\'t taking into account other attributes which affect container width.','2014-06-21 01:04:52',0,1),(334,'Preset position quick links now trigger the margin preview methods.','2014-06-21 01:08:07',0,1),(335,'Dlayer - Release 0.36 - Fixed live preview and other minor tweaks.','2014-06-21 15:06:43',1,1),(336,'Styling updates for notices and development messages. Now unable to import form if not forms exist for site. Create new page form no longer shows if no templates exist for site. Content updates.','2014-06-23 01:55:07',0,1),(337,'The base div for a template is now a real div, as such all the Template designer tools can now be used on it increasing design options.','2014-06-23 01:56:15',0,1),(338,'Dlayer - Release 0.37 - Initial template div now a \'real\' div.','2014-06-23 02:04:52',1,1),(339,'Content updates: Updated the default tool bar text in Form builder and development plan.','2014-06-24 13:10:21',0,1),(340,'Added ability to define the minimum width for a form in the Form builder, first of many settings.','2014-06-24 15:24:41',0,1),(341,'Form builder now shows the form at the requested minimum width, defaults to 600 pixels.','2014-06-24 16:29:51',0,1),(342,'Import form tool updated, on add the tool checks to ensure submitted width is not smaller than the minimum form width, on edit the width field is updated with a min attribute.\r\n','2014-06-24 17:04:30',0,1),(343,'Add new form now inserts a default value for minimum width, for now the value is defined as 600.','2014-06-24 17:19:29',0,1),(344,'Dlayer - Release 0.38 - First form option added, minimum width, also partly resolved one of the known bugs.','2014-06-24 17:23:30',1,1),(345,'Added ability to define form legend to form settings tool.','2014-06-25 01:19:49',0,1),(346,'Updated Form builder and Content manager, legend now show on all user created and imported forms.','2014-06-25 01:33:48',0,1),(347,'Added description for pages, on both add and edit page forms.','2014-06-25 02:08:58',0,1),(348,'Updated top menu, designer menu item is now a drop down that includes links to the other designers.','2014-06-25 15:01:31',0,1),(349,'Updated form settings tool, can now define the submit button text.','2014-06-25 16:26:31',0,1),(350,'Dlayer - Release 0.39 - More form settings.','2014-06-25 16:30:09',1,1),(351,'Design colours were not consistent across entire site, now are.','2014-06-26 15:22:27',0,1),(352,'Initial module code in place for Image library, need to work on layout.','2014-06-30 14:50:03',0,1),(353,'Image library ribbon data classes in place, differ to other ribbon data classes because three ids can exist, image, category and sub category.','2014-07-01 22:56:03',0,1),(354,'Preview of add category tool in place in Image library.','2014-07-02 00:11:30',0,1),(355,'Additional improvements to form styling.','2014-07-03 16:44:10',0,1),(356,'Preview of add sub category tool in place in Image library.','2014-07-03 16:57:15',0,1),(357,'Preview of add to library tool in place in Image library.','2014-07-04 00:48:18',0,1),(358,'Preview of filter form for Image library.','2014-07-07 16:03:41',0,1),(359,'Dlayer - Release 0.40 - Image library preview.','2014-07-07 16:04:13',1,1),(360,'Edit mode status now passed into the form builder ribbon forms.','2014-07-08 14:44:42',0,1),(361,'Updated Content manager tools, multi use param now passed from database to tool forms through tool data classes.','2014-07-08 23:28:15',0,1),(362,'Updated the Form builder, multi use param now passed down from database to Tool forms, not manually set.','2014-07-08 23:58:14',0,1),(363,'Updated Image library preview, multi use param now passed from database to Image library tool forms.','2014-07-09 00:09:19',0,1),(364,'Updated import form tool, submit button now disabled by default until valid selection made in form select.','2014-07-09 16:12:18',0,1),(365,'Updated the import form tool, now won\'t allow the user to import a a form into a page container that is too small for the form, if the form is too small a clear message is show above the form.','2014-07-09 16:24:22',0,1),(366,'Content manager tools now multi use, div, content item and tool tab remain selected after processing if request valid.','2014-07-09 17:20:01',0,1),(367,'Updated Form builder, set some tool tabs to multi use, tool, and tab remain selected after valid submission.','2014-07-09 17:27:24',0,1),(368,'Dlayer - Release 0.41 - Bug fixes and house keeping tasks.','2014-07-09 17:30:06',1,1),(369,'Initial database layout for Image library and categories in place, includes versioning tables.','2014-07-10 17:12:16',0,1),(370,'Updated the image library session class, now has methods for setting and fetching the sort and order values, initially limited to name, uploaded and size in ascending and descending order.','2014-07-11 17:07:48',0,1),(371,'Thumbnails are now displaying using data from the database, not a static preview.','2014-07-12 02:17:18',0,1),(372,'Default category and sub category set and/or created when user browses to Image library.','2014-07-12 17:26:24',0,1),(373,'Filter form in place, shows categories and sub categories, AJAX to update sub categories select and submission sets new session values.','2014-07-13 01:44:17',0,1),(374,'Reworked the image library tools, ids are now passed into the validate methods ready for later use, used to be the process methods, tools are starting to require environment ids for validation, other modules need to be updated in the same manner.','2014-07-13 14:00:17',0,1),(375,'Added the ability to create a category in the Image library, automatically creates the initial sub category.','2014-07-14 17:30:04',0,1),(376,'Added the ability to create a sub category in the Image library.','2014-07-15 00:14:13',0,1),(377,'Added ability to edit categories and sub categories in Image library, user is not allowed to edit initial category of auto created sub categories.','2014-07-15 14:30:06',0,1),(378,'Dlayer - Release 0.42 - Image library preview updated.','2014-07-15 14:55:55',1,1),(379,'Added version to image session, user needs to be able to select a specific version of an Image library image.','2014-07-15 16:37:52',0,1),(380,'Updated tools in Image library, version id now passed in along with other environment params.','2014-07-15 16:52:29',0,1),(381,'Added ability to select image and get directed to detail page (empty), selected tool is cancelled as it won\'t relate to the newly selected image.','2014-07-15 17:14:42',0,1),(382,'Preview of image detail page in place, not functional.','2014-07-16 00:42:01',0,1),(383,'Filter hidden on the image detail page as it is not relevant.','2014-07-16 00:50:06',0,1),(384,'Dlayer - Release 0.43 - Preview of image detail page and tool updates.','2014-07-16 00:50:45',1,1),(385,'Dlayer - Release 0.43.1 - Fixed bug with Image session class.','2014-07-16 15:30:37',1,1),(386,'Detail data on image detail page now dynamic, not a static preview.','2014-07-18 00:17:16',0,1),(387,'Added description to add to library tool form.','2014-07-18 00:22:31',0,1),(388,'Added preview for copy tool, appears in the tool box when viewing the detail page as it requires an image to work on.','2014-07-18 00:56:43',0,1),(389,'Added the help tab for the crop tool, required because I need a tool id for the version table to develop the version listing.','2014-07-18 15:36:37',0,1),(390,'Updated database, added tool id into versions table to record the tool used to create version.','2014-07-18 16:05:32',0,1),(391,'Detail page now shows the version history for the selected image, individual versions are selectable.','2014-07-18 16:45:52',0,1),(392,'Added sort to library, initially the user can sort by name, size and uploaded date in ascending and descending order.','2014-07-20 16:34:16',0,1),(393,'Dlayer - Release 0.44 - Detail page now dynamic, added sort to the library and other minor updates.','2014-07-20 16:37:45',1,1),(394,'Sort options only display if there are images in the category and sub category, not relevant otherwise.','2014-07-21 00:48:54',0,1),(395,'Added an all option to the sub category select and updated the sub category tool so that a all category cannot be created by the user.','2014-07-21 00:51:35',0,1),(396,'All subcategory returns all the images in the base category sort as per the sort settings.','2014-07-21 00:55:49',0,1),(397,'Added pagination to the Image library, defaults to 24 images per page, only shows when relevant.','2014-07-21 01:23:56',0,1),(398,'Dlayer - Release 0.45 - Added pagination to Image library, defaults to 24 thumbnails per page, also added a display all sub category.','2014-07-21 01:30:09',1,1),(399,'Updated the image library tools, now able to return and set multiple session ids after processing tool.','2014-07-21 14:53:06',0,1),(400,'Updated validation for edit versions of Category and Sub category tool.','2014-07-21 14:53:11',0,1),(401,'Add to library tool now works, new image added to library along with all relevant image data. Thumbnails aren\'t yet created by the uploader, thumbnails are the original images with width and height set.','2014-07-22 16:03:26',0,1),(402,'Fixed a few small issues with image library, wasn\'t always pulling the correct info for an image.','2014-07-22 16:04:36',0,1),(403,'Added image type to detail page, for example image/jpeg.','2014-07-22 16:16:13',0,1),(404,'Dlayer - Release 0.46 - Add to library tool now functional.','2014-07-22 16:16:53',1,1),(405,'Updated add to library form, category options now pulled from database for selected site. Sub category select defaults top empty, added AJAX call to populate values when category selected.','2014-07-23 15:38:57',0,1),(406,'Dlayer - Release 0.46.1 - Updated Add to library tool, category and sub category selects now pulling the correct data.','2014-07-23 15:41:41',1,1),(407,'Updated copy tool, now uses same AJAX to select sub category based on selected category.','2014-07-23 16:35:03',0,1),(408,'Copy tool creates a new copy of the selected image and version.','2014-07-24 00:35:35',0,1),(409,'Copy tool now copies image in files system.','2014-07-24 00:53:38',0,1),(410,'Added the ability to edit the base details for a library image, name, description, category and sub category.','2014-07-24 16:29:02',0,1),(411,'Dlayer - Release 0.47 - Added a copy tool to the Image library along with an Edit tool which lets the user edit the base details for a library image.','2014-07-24 16:43:46',1,1),(412,'Added a development module, this is so new library code can be tested, developing a basic image resizer which will then be used to generate thumbnails in the Image library.','2014-08-01 14:07:00',0,1),(413,'Created basic jpeg resizer, maintains aspect ratio when creating thumbnail.','2014-08-02 02:38:55',0,1),(414,'Added gif and png resizers.','2014-08-02 16:29:24',0,1),(415,'Added advanced image resizers (jpeg, png and gif), in addition to image size these allow the user to define canvas background colour, quality/compression and file name suffix.','2014-08-02 23:44:51',0,1),(416,'Added maintain aspect ratio setting to resizers, if left as TRUE, images are best fit with padding, if set to FALSE, images are stretched to fit.','2014-08-03 00:02:45',0,1),(417,'Created a crop class, crops the supplied image validating all the params, required for the crop tool processing.','2014-08-06 16:29:23',0,1),(418,'Created png and gif versions of cropper to go along with the jpeg cropper.','2014-08-06 16:42:02',0,1),(419,'Extended advanced resizer for Image library, now able to define destination path and filename and resize images smaller than required width and height, Small images placed in the middle of the destination canvas with the relevant padding.','2014-08-08 15:31:05',0,1),(420,'Dlayer - Release 0.48 - Library development for Image library resize and Image library crop tool.','2014-08-09 17:02:09',1,1),(421,'Dlayer - Release 0.49 - External pages now all styled using bootstrap, access to app disabled till designer styling complete.','2014-12-19 15:53:58',1,1),(422,'Styling complete in base module (dlayer)','2015-01-05 12:23:47',0,1),(423,'Base styling complete in the Template designer, management and settings.','2015-01-05 13:23:36',0,1),(424,'Base styling in Content manager and Form builder, management and settings.','2015-01-06 17:35:32',0,1),(425,'Base styling for Web site manager and Image library. Updated action links in module overviews, now buttons.','2015-01-09 01:03:29',0,1),(426,'Dlayer - Release 0.50 - Base styling complete, access to app restored. Access to designers disabled till styling updates complete, will be enabled on a module by module basis.','2015-01-09 01:04:32',1,1),(427,'Setting minimum form width under form settings no longer has any effect, need to work out how to handle this given the change to creating bootstrap driven sites.','2015-01-11 14:31:57',0,1),(428,'Mobile styling, in place for all pages except the designers, you can now manage all settings and basic management using a tablet or phone. At this time I am not going to add mobile support to the designers, not worth the effort until they are more functional and even then support is questionable.','2015-01-12 14:32:14',0,1),(429,'Updated the live previews in the Form builder, wasn’t updating the field description after Bootstrap styling updates.','2015-01-13 16:53:39',0,1),(430,'Updated move controls for form fields, not working after Bootstrap updates.','2015-01-14 01:41:40',0,1),(431,'New colour picker styling, simple Bootstrap panel.','2015-01-14 16:24:35',0,1),(432,'Bootstrap styling now complete in the form builder, this was quite a larger task in the end because I needed to update all the tools and tabs as well as the designer UI. Updating the other designers, bar a few tool issues in the Template designer should be simpler to complete.','2015-01-15 01:15:19',0,1),(433,'Dlayer - Release 0.51 - Form builder update complete, now wearing a new Bootstrap style as per the rest of the redesign.','2015-01-15 01:33:37',1,1),(434,'Dlayer - Release 0.51.1 - Content update.','2015-01-16 15:04:01',1,1),(435,'New styling for Web site manager tool bar, ribbon and tools.','2015-01-18 15:31:38',0,1),(436,'New layout and styling for the management area in the Web site manager, can now collapse sections and controls are more clear.','2015-01-19 16:50:52',0,1),(437,'Dlayer - Release 0.52 - Web site manager styling update complete, access returned.','2015-01-20 14:56:27',1,1),(438,'Styling updates to Image library tools, ribbon and tool forms.','2015-01-21 16:36:13',0,1),(439,'Updated logic for showing and hiding tools, depends on whether a tool is selected and whether an image is selected, now don\'t show library management tools (category, add) when an image is selected.','2015-01-21 16:49:51',0,1),(440,'New layout and styling for Image library, library and detail view.','2015-01-23 20:13:15',0,1),(441,'Fixed bug with add to library, mime checks failing. Fixed the sorting options, failing for size because data was moved to a meta table.\r\n','2015-01-24 02:54:53',0,1),(442,'New sample form data for all three users.','2015-01-25 01:25:32',0,1),(443,'Dlayer  - Release 0.53 - Image library update complete.','2015-01-25 01:29:13',1,1),(444,'New layout for Template designer tools, preset section custom to Template designer.','2015-01-27 16:57:26',0,1),(445,'Disabled all Template designer tools except split horizontal.','2015-01-28 01:35:10',0,1),(446,'Disabled the modifier system, no longer called by Template designer.','2015-01-29 15:24:23',0,1),(447,'Content update, designer overview pages now have more information and the text for the template designer tools has been made simpler.','2015-01-31 16:33:13',0,1),(448,'Updated split horizontal tool, all divs are now created as dynamic height, design height is set for designer view, ignored when content applied.','2015-02-02 17:04:51',0,1),(449,'Added content block metrics to Template designer, show when a tool is selected, allow a user to switch a content block between fixed and dynamic height setting. Modified the create rows tool in Template designer, custom tool was not taken the 15px bootstrap defined padding into account.\r\n','2015-02-03 15:47:27',0,1),(450,'Added a sample template for each user and site, initially just a simple header, content area and footer based template.','2015-02-03 15:49:59',0,1),(451,'Template designer content blocks now named according to height setting, content block metrics now display when a block is selected rather than block and tool, valid to need to switch height setting without selecting a tool.','2015-02-03 16:36:00',0,1),(452,'Dlayer - Internal release 0.53.5 - Template designer update complete, creates bootstrap valid templates, limited to a single tool currently, create rows.','2015-02-03 16:44:25',1,1),(453,'New layout for Content manager, design area, tools and default ribbon views complete.','2015-02-04 15:54:52',0,1),(454,'Content manager page updated to support new template structure.','2015-02-04 15:55:29',0,1),(455,'Added the content row view helper, it is called by the page view helper. The content row view helper now calls the base content view helper, it was previously being called by the page view helper.','2015-02-09 16:55:39',0,1),(456,'Text, Heading and Form content items now display again on generated pages, work within the new page structure, tools and selection still need to be updated','2015-02-10 16:24:40',0,1),(457,'Added a second selected state to the Content manager ribbon, now have default, area selected and row selected, all guide the user.','2015-02-12 00:25:28',0,1),(458,'Add content row tool in place, reworked the process controller to handle auto tools, previously all tools were manual tools.','2015-02-13 15:38:13',0,1),(459,'Reworked the Content manager process method for tools, the base data methods to fetch the data for tools and the interface for the tools themselves.','2015-02-16 00:49:55',0,1),(460,'Add content item tool now works again, required a fairly large rework of the base content item management code.','2015-02-16 16:05:27',0,1),(461,'Edit content heading item working, also reworked the code to handle management of content instances.','2015-02-17 17:12:11',0,1),(462,'New sample content page for each of the test sites, only selectable content item being headings.','2015-02-18 01:11:51',0,1),(463,'Dlayer - Release 0.54 - Template designer and Content manager now open.','2015-02-18 01:12:52',1,1),(464,'Updated the form and tool data class for text content item.','2015-02-18 16:40:37',0,1),(465,'Base Content manager tool class more capable, moved shared methods into it and set up new abstract methods.','2015-02-18 16:41:34',0,1),(466,'Add text item tool works, updated selector to allow selection of text content items ready for edit mode.','2015-02-19 15:23:48',0,1),(467,'Edit text content item works.','2015-02-19 15:46:30',0,1),(468,'Moved the instances input definition to the base Content manager tool class, can be called by any tool form when required.','2015-02-19 15:57:22',0,1),(469,'Template designer now shows a visual notification of dependant content items when a content area is selected, not the specific content items as there may be many types, just a  generic item.','2015-02-19 16:41:51',0,1),(470,'Dlayer - Release 0.55 - Content manager text item tool.','2015-02-19 16:50:15',1,1),(471,'Updated selector to allow forms to be selected in Content manager.','2015-02-20 16:46:51',0,1),(472,'Updated the import form tool, add function now in place.','2015-02-21 16:32:05',0,1),(473,'Fixed a bug in form builder, unable to add form field, error with sub query.','2015-02-21 16:35:59',0,1),(474,'Import form tool now allows user to change the form linked to the item, edit mode.','2015-02-21 16:39:15',0,1),(475,'Added ability to jump from selected form in Content manager to the Form builder with the form selected. You can also jump back to the Content manager with state maintained.','2015-02-23 00:49:27',0,1),(476,'Moved check for defined content in page view helper, incorrect height setting being defined when content exists.','2015-02-23 14:57:07',0,1),(477,'Movement controls show for content rows when parent content area selected.','2015-02-23 16:43:55',0,1),(478,'Added ability to move content rows within a content area, up and down controls display when hovering over a selectable content row.','2015-02-24 14:30:32',0,1),(479,'New sample data for the three test users.','2015-02-24 14:40:40',0,1),(480,'Dlayer - Release 0.56 - Import form tool','2015-02-24 15:34:32',1,1),(481,'Size and position tab added to text content item tool, size can be set as a value between one and twelve.','2015-02-25 19:24:21',0,1),(482,'Size and position tab added to import form tool, size can be set as a value between one and twelve.','2015-02-26 01:48:28',0,1),(483,'Size and position tab added to heading content item tool, size can be set as a value between one and twelve.','2015-02-26 14:44:46',0,1),(484,'Dlayer - Release 0.57 - Size and position tab added to Content manager Text, Heading and Import form tool.','2015-02-26 14:47:51',1,1),(485,'Added small support to the heading content item tool, sub heading text is optional.','2015-02-26 16:10:46',0,1),(486,'Updated logic for Form, tab of import form tool, data now comes from a ribbon data class.','2015-02-27 15:10:38',0,1),(487,'Updated the tool tab styling, now smaller to allow more tabs per tool. Added spacing below the Return to previous designer button in Form builder.','2015-02-27 15:59:53',0,1),(488,'Added ability to define background colour for the text content item container, value not yet used within the design view.','2015-02-28 02:00:28',0,1),(489,'Updated development plan.','2015-02-28 02:32:18',0,1),(490,'Reworked the page view helper to support content row styles and content container styles being defined along with content item styles.','2015-03-01 14:12:15',0,1),(491,'Added content container view helper, calls child view helpers to generate style string for content items, applied to the text, heading and form content items.','2015-03-02 01:43:12',0,1),(492,'Added ability to define content container background colour for Heading and Form content items, styles tab now appears when in edit mode.','2015-03-02 15:49:24',0,1),(493,'Updated the bugs page.','2015-03-02 16:14:59',0,1),(494,'Dlayer - Release 0.58 - Styles tab added to Text, Heading and Import form tool','2015-03-02 16:15:48',1,1),(495,'Added ability to define text content item background colour.','2015-03-03 17:45:37',0,1),(496,'Added ability to define background colour for heading and form content items.','2015-03-04 08:53:50',0,1),(497,'Added ability to create a jumbotron (masthead) content item.','2015-03-05 16:09:55',0,1),(498,'Added ability to select and edit a jumbotron content item.','2015-03-05 16:39:53',0,1),(499,'New sample content page data for the three test web sites.','2015-03-05 16:54:57',0,1),(500,'Dlayer - Release 0.59 - Content item background colour and new content item.','2015-03-05 17:01:18',1,1),(501,'Updated the default colour palettes, switched them with two that match the base Bootstrap styles.','2015-03-06 11:49:49',0,1),(502,'Required tool fields now have red asterisk to identify them.','2015-03-06 12:03:17',0,1),(503,'Added the size and position tab to the Jumbotron tool, initially only allows you to control the size of the item.','2015-03-11 16:03:22',0,1),(504,'Added the styling tab to the Jumbotron tool, initially it only allows you to define the background colour for the Jumbotron itself.','2015-03-11 16:14:48',0,1),(505,'Added movement controls for content items, adjust display order, had to move the selection class for the content items up to the parent element, not yet functional.','2015-03-12 12:45:19',0,1),(506,'Processing code in place to allow user to alter the display of content items within a content row.','2015-03-12 13:46:57',0,1),(507,'Dlayer - Release 0.60 - Added ability to move content items within a row and also added styling and size and position tabs to the Jumbotron content item tool.','2015-03-12 14:25:38',1,1),(508,'UI for Import form tool in place in Content manager.','2015-03-13 16:25:12',0,1),(509,'Processing code now in place for the import text tool.','2015-03-13 16:25:17',0,1),(510,'Added ability to allow user to update name for reference text data, Text, Heading and Jumbotron tools','2015-03-13 16:45:59',0,1),(511,'Bug: Edit Jumbotron throwing an error.','2015-03-13 16:48:11',0,1),(512,'UI for import heading tool now in place in Content manager.','2015-03-13 17:41:08',0,1),(513,'Processing code now in place for the import heading tool.','2015-03-14 14:37:09',0,1),(514,'Dlayer - Release 0.61 - Added import heading and import text tool to Content manager.','2015-03-14 14:39:37',1,1),(515,'Added ability to define the offset for a text content item on the size and position tab.','2015-03-15 14:53:42',0,1),(516,'Text content view helper now aware of offset value and applies relevant class when required.','2015-03-15 14:59:45',0,1),(517,'Jumbotron, Heading and Form content items now allow the offset to be defined on the size and position tab.','2015-03-15 15:20:50',0,1),(518,'Modified the tools section in the Content manager, added a heading to clearly separate sections allowing for slightly simpler tool names.','2015-03-16 13:04:59',0,1),(519,'Added import jumbotron tool, similar to the import text and heading tools, using existing data.','2015-03-16 15:30:40',0,1),(520,'Dlayer - Release 0.62 - Added ability to define the offset for content items and also added a new tool to the Content manager, Import jumbotron.','2015-03-16 15:32:17',1,1),(521,'Added move row tool, allows a content row to be moved from one content area to another, movement within a content area is managed via the visual tools upon row hover.','2015-03-17 18:21:32',0,1),(522,'Updated the logic for the auto tools, more of the returned data is definable within the tools.','2015-03-17 18:21:42',0,1),(523,'Added a reordering function that reorders content rows when a row is moved out of an content area, in place to stop issues when using the visual movement tools after the move row tool has been used.','2015-03-17 18:21:48',0,1),(524,'Reworked the logic that displays tools in Content manager, needed to be aware of difference between structure based tools and standard tools, differing logic controls tool visibility.','2015-03-18 15:29:10',0,1),(525,'Added move item tool, allows a content item to be moved to another content row, movement within a content row is managed by the visual controls in the designer when a content row is selected.','2015-03-18 18:55:19',0,1),(526,'Added logic to update the new environment state after move row and move item tool processing, all done invisibly to the user so they can continue working without realising another content area and content row may have been selected.','2015-03-18 18:57:28',0,1),(527,'Dlayer - Release 0.63 - Added move item and move row tools, provide movement functions not covered by the visual tools in the designer.','2015-03-19 11:01:52',1,1),(528,'Renamed add content row tool, need to add a new content row to allow management of the row.','2015-03-19 11:38:25',0,1),(529,'Selecting a content row now also selects the content row tool allowing access to the row sub tools.','2015-03-25 15:05:04',0,1),(530,'UI in place for styling tab of content row tool, field to allow user to set background colour for row.','2015-03-25 15:35:35',0,1),(531,'Background colour can now be defined for a content row using the styling sub tool.','2015-03-25 15:53:53',0,1),(532,'Updated auto tool code, now able to look for and load sub tools.','2015-03-25 16:11:26',0,1),(533,'Designer view updated to apply styles to content rows if defined.','2015-03-26 12:03:53',0,1),(534,'Dlayer - Release 0.64 - Added ability to define styling for content rows, initially just background colour.','2015-03-26 16:36:38',1,1),(535,'Bug fix: Content area selector now clears defined content row background colours to aid with content area selection.','2015-03-26 16:37:16',0,1),(536,'Bug fix: Updated the content row selector, clears the background colour for a content item and content item container if defined to ease with selecting content rows.','2015-03-27 16:41:20',0,1),(537,'Bug fix: Updated content item selector, now clears the background colour for content item and content item container if defined, helps with selecting content items.','2015-03-27 17:10:22',0,1),(538,'Filed a new bug, preset tools in Form builder.','2015-03-29 16:10:49',0,1),(539,'Calculate a suggested size for a new text content item and use that to create items, uses rules outlined on help tab.','2015-03-31 15:03:01',0,1),(540,'Suggested size now calculated for heading, jumbotron content items tools and all import items, uses the rules outlined on the tool help tabs.','2015-03-31 15:15:52',0,1),(541,'Dlayer - Release 0.65 - Fixed selector bug and added logic to calculate sensible default sizes for newly added content items','2015-03-31 15:35:19',1,1),(542,'Added the live editing preview methods for text content changes, designer updates the design view in real-time when the content is altered.','2015-04-01 16:04:21',0,1),(543,'Added live editing preview for text item size and offset values, updates the design view based on the sets sizes, combined size and offset cannot exceed 12, JavaScript will limit inputs as necessary.','2015-04-07 16:51:53',0,1),(544,'Added live editing previews for text content item container and element background colours, works in exactly the same way as the similar feature in the Form builder.','2015-04-08 14:42:03',0,1),(545,'Added live editing previews for Import form tool, changes to form content item size, offset, background colour and container background colour now show in the designer during editing.','2015-04-09 11:32:05',0,1),(546,'Added live editing previews for Jumbotron tool, changes to jumbotron content, size, offset and background colour now show live in the designer.','2015-04-09 13:10:16',0,1),(547,'Added live editing previews for heading tool, changes to heading content, size, offset and background colours now show live in the designer.','2015-04-09 17:23:00',0,1),(548,'Updated integrity of database, foreign keys where removed from some tables during major restructure.','2015-04-10 00:50:31',0,1),(549,'Dlayer - Release 0.66 - Added live editing previews for Content manager tools.','2015-04-12 01:36:28',1,1),(550,'Added a \"Why use Dlayer?\" page.','2015-04-21 12:51:16',0,1),(551,'Moved import form tool into the create section.','2015-04-21 15:54:19',0,1),(552,'Added toggle to collapse tool sections in  Content manager, import tool section collapsed by default unless an import tool is in use.','2015-04-21 15:54:25',0,1),(553,'After fields are added using the pre-set tools in the Form builder the user is now correctly returned to the designer with the relevant standard tool selected.','2015-04-21 15:54:35',0,1),(554,'Updated tool section in Form builder, now includes sub titles and collapses the standard section when not being used.','2015-04-21 17:08:40',0,1),(555,'Updated the styles for selectors, selectable items or areas turn yellow when the mouse is hovered over them, selected items or areas have a dotted blue border, less invasive to the designer.','2015-04-21 17:17:12',0,1),(556,'Bug fix: Return to previous designer button on Form builder (after jumping from Content manager) was disappearing after changes in the Form builder.','2015-04-21 17:22:02',0,1),(557,'Dlayer - Release 0.67 - UI and UX updates.','2015-04-22 11:58:47',1,1),(558,'Minor changes to Image library, changed initial category and added new sample images.','2015-04-22 12:32:58',0,1),(559,'Updated library view code that checks revisions, not looking at correct information - versions not yet creatable by users.','2015-04-22 12:52:18',0,1),(560,'Minor UI changes to library view, also added the number of versions next to the image name.','2015-04-22 13:07:32',0,1),(561,'Added code to handle displaying images within the Content manager, users are not yet able to add an image via a tool, only works because I\'ve added the entries in the database.','2015-04-23 12:06:08',0,1),(562,'Updated the sample site for each test user to display a small image content item from the relevant Image library.','2015-04-23 12:06:19',0,1),(563,'Required asterisks missing from tool form fields in Form builder.','2015-04-23 12:13:20',0,1),(564,'Dlayer - Release 0.68 - Initial development for image content item support.','2015-04-23 12:13:25',1,1),(565,'Content update - Content manager overview and home page once logged in.','2015-05-02 23:51:06',0,1),(566,'Reworked the help text content and layout in the side panel in the Content manager, guides the user first, explains afterwards.','2015-05-02 23:51:13',0,1),(567,'Content update - Template designer overview.','2015-05-03 00:14:47',0,1),(568,'Reworked the help text content and layout in the side panel in the Template designer, guides the user first, explains afterwards.','2015-05-03 22:55:40',0,1),(569,'Updated the History of Dlayer page, now includes a little more background, What is Dlayer? page, Web site manager overview and Form builder overview.','2015-05-03 23:49:54',0,1),(570,'Minor UX updates to Template designer, mirror previous changes to Content manager.','2015-05-04 00:12:08',0,1),(571,'Content update - Image library overview.','2015-05-04 16:45:21',0,1),(572,'Added widget designer overview and initial settings pages.','2015-05-05 11:40:32',0,1),(573,'Dlayer - Release 0.69 - Content update, now more in line with specification, also opened the base of the Widget designer.','2015-05-05 11:52:23',1,1),(574,'Bug fix: Code which fetches the background colour for an item, container and row no longer doesn\'t select the defined colour if the item is selected in the designer, the selected status has been updated, code no longer relevant.\r\n','2015-05-07 11:29:06',0,1),(575,'Initial design work on Image picker.','2015-05-07 11:29:15',0,1),(576,'Minor updates to the layout of the colour picker, closer to new image picker design.','2015-05-07 11:29:34',0,1),(577,'Minor update to Image library UI.','2015-05-07 15:20:43',0,1),(578,'Initial tool view code in place for add image, doesn\'t yet use Image picker and tool processing code not in place.','2015-05-08 16:21:02',0,1),(579,'Some fields in Content manager not marked as required when they are.','2015-05-09 11:53:14',0,1),(580,'Image can now be inserted using the image tool, simple select to choose image at the moment, image picker not functional yet.','2015-05-09 11:53:31',0,1),(581,'Added a caption to the insert image tool, caption appears below image.','2015-05-09 11:53:51',0,1),(582,'Added a suggested maximum size to the suggested size logic, instead of content items automatically spanning the entire width of a content row they will be now be set to the suggested maximum size on initial insertion, for images this defaults to six.','2015-05-09 12:33:02',0,1),(583,'Content updates, help text for Content manager tools.','2015-05-09 16:16:00',0,1),(584,'Inserted images can now be edited.','2015-05-11 15:57:17',0,1),(585,'Preview link in Content manager nav bar, opens preview of current design in a new window, additional work still required because helper content areas and content rows are still visible.','2015-05-11 15:57:26',0,1),(586,'Dlayer - Release 0.70 - Add image content item in place, also added ability to view preview of current design without Dlayer UI.','2015-05-11 15:58:59',1,1),(587,'Added size and position tab to image tool.','2015-05-11 18:26:02',0,1),(588,'Added styling tab to image tool.','2015-05-11 18:34:14',0,1),(589,'Design preview no longer shows helper content areas and content rows.','2015-05-12 00:30:45',0,1),(590,'Expand option for images now applied in preview, images open up in a modal dialog.','2015-05-12 12:46:28',0,1),(591,'Content updates.','2015-05-12 13:09:41',0,1);

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

insert  into `dlayer_identity`(`id`,`identity`,`credentials`,`logged_in`,`last_login`,`last_action`,`enabled`) values (1,'user-1@dlayer.com','$6$rounds=5000$jks453yuyt55d$CZJCjaieFQghQ6MwQ1OUI5nVKDy/Fi2YXk7MyW2hcex9AdJ/jvZA8ulvjzK1lo3rRVFfmd10lgjqAbDQM4ehR1',0,'2015-05-12 12:43:06','2015-05-12 13:07:14',1),(2,'user-2@dlayer.com','$6$rounds=5000$jks453yuyt55d$ZVEJgs2kNjxOxNEayqqoh2oJUiGbmxIKRqOTxVM05MP2YRcAjE9adCZfQBWCc.qe1nDjEM9.ioivNz3c/qyZ80',0,'2015-04-23 11:58:19','2015-04-23 12:01:04',1),(3,'user-3@dlayer.com','$6$rounds=5000$jks453yuyt55d$NYF6yCvxXplefx7nr8vDe4cUGBEFtd3G5vuJ2utfqvPwEf3dSgNXNTcGbFO6WrJSn21CXHgZwNOQHy691E/Rm.',0,'2015-04-23 12:01:17','2015-04-23 12:03:24',1);

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

insert  into `dlayer_module`(`id`,`name`,`title`,`description`,`sort_order`,`enabled`) values (1,'template','Template designer','Design new templates and tweak existing ones. <span class=\"label label-warning\">On hold</span>',6,1),(2,'widget','Widget designer','Design new widgets and tweak existing ones. <span class=\"label label-primary\">Early development</span>',2,1),(3,'form','Form builder','Create new forms, manage existing forms and submissions. <span class=\"label label-success\">Active development</span>',3,1),(4,'content','Content manager','Create new content pages and manage existing ones. <span class=\"label label-success\">Active development</span>',1,1),(5,'website','Web site manager','Organise your web site. <span class=\"label label-info\">Preview</span>',5,1),(6,'question','Question manager','Create quizzes, tests and polls. <span class=\"label label-default\">In planning</span>',8,0),(7,'dlayer','Dlayer','Home',0,1),(8,'image','Image library','Manage your media library. <span class=\"label label-success\">Active development</span>',4,1),(9,'data','Data manager','Manage your data. <span class=\"label label-default\">In planning</span>',7,0);

/*Table structure for table `dlayer_module_tool` */

DROP TABLE IF EXISTS `dlayer_module_tool`;

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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool` */

insert  into `dlayer_module_tool`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','cancel',NULL,'cancel',1,0,1,1,1),(2,1,'Create rows','split-horizontal','SplitHorizontal','split-horizontal',1,1,2,1,1),(3,1,'Split vertical','split-vertical','SplitVertical','split-vertical',1,1,2,2,0),(6,1,'Resize','resize','Resize','resize',0,1,2,3,0),(7,1,'Background colour','background-color','BackgroundColor','background-color',1,0,3,1,0),(8,1,'Border','border','Border','border',1,0,3,2,0),(9,4,'Cancel','cancel',NULL,'cancel',2,0,1,1,1),(10,4,'Text','text','Text','text',0,0,3,2,1),(11,4,'Heading','heading','Heading','heading',0,0,3,1,1),(12,3,'Text','text','Text','text',0,0,4,1,1),(13,3,'Text area','textarea','Textarea','textarea',0,0,4,2,1),(14,3,'Cancel','cancel',NULL,'cancel',2,0,1,1,1),(15,3,'Password','password','Password','password',0,0,4,3,1),(16,4,'Form','import-form','ImportForm','import-form',0,0,3,4,1),(17,5,'Cancel','cancel',NULL,'cancel',0,0,1,1,1),(18,5,'New page','new-page','NewPage','new-page',0,0,2,2,1),(19,5,'Move page','move-page','MovePage','move-page',0,0,2,1,1),(20,3,'Email','email','Email','email',0,0,3,2,1),(21,3,'Name','name','Name','name',0,0,3,1,1),(22,4,'Text','import-text','ImportText','import-text',0,0,4,2,1),(23,4,'Heading','import-heading','ImportHeading','import-heading',0,0,4,3,1),(24,3,'Controls','form-settings','FormSettings','form-settings',1,0,2,1,1),(25,8,'Add to library','add','Add','add',1,0,2,1,1),(26,8,'Cancel / Back to library','cancel',NULL,'cancel',0,0,1,1,1),(27,8,'Category','category','Category','category',1,0,2,2,1),(28,8,'Sub category','subcategory','Subcategory','subcategory',1,0,2,3,1),(29,8,'Clone','copy','Copy','copy',0,0,3,2,1),(30,8,'Crop','crop','Crop','crop',0,0,4,1,1),(31,8,'Edit','edit','Edit','edit',0,0,3,1,1),(32,4,'Add content row','add-content-row','AddContentRow','add-content-row',1,0,2,1,1),(34,4,'Jumbotron','jumbotron','Jumbotron','jumbotron',0,0,3,3,1),(35,4,'Jumbotron','import-jumbotron','ImportJumbotron','import-jumbotron',0,0,4,4,1),(36,4,'Move row','move-row','MoveRow','move-row',1,0,2,3,1),(37,4,'Move item','move-item','MoveItem','move-item',1,0,2,4,1),(38,4,'Content row','content-row','ContentRow','content-row',1,0,2,2,1),(39,4,'Image','image','Image','image',0,0,3,5,1),(40,4,'Carousel','carousel','ImageCarousel','carousel',0,0,3,6,0);

/*Table structure for table `dlayer_module_tool_tab` */

DROP TABLE IF EXISTS `dlayer_module_tool_tab`;

CREATE TABLE `dlayer_module_tool_tab` (
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
  CONSTRAINT `dlayer_module_tool_tab_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`),
  CONSTRAINT `dlayer_module_tool_tab_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tab` */

insert  into `dlayer_module_tool_tab`(`id`,`module_id`,`tool_id`,`name`,`view_script`,`sub_tool_model`,`multi_use`,`edit_mode`,`default`,`sort_order`,`enabled`) values (1,1,2,'Quick','quick',NULL,0,0,1,1,1),(2,1,2,'Custom','advanced',NULL,0,0,0,2,1),(3,1,2,'?','help',NULL,0,0,0,3,1),(4,1,3,'Quick','quick',NULL,0,0,1,1,1),(5,1,3,'Mouse','advanced',NULL,0,0,0,2,1),(6,1,3,'?','help',NULL,0,0,0,3,1),(7,1,7,'#1','palette-1',NULL,0,0,1,1,1),(8,1,7,'#2','palette-2',NULL,0,0,0,2,1),(9,1,7,'#3','palette-3',NULL,0,0,0,3,1),(10,1,7,'Custom','advanced',NULL,0,0,0,4,1),(11,1,7,'?','help',NULL,0,0,0,5,1),(12,1,6,'Custom','advanced',NULL,0,0,0,4,1),(14,1,6,'?','help',NULL,0,0,0,5,1),(15,1,6,'Push','expand',NULL,0,0,1,1,1),(16,1,6,'Pull','contract',NULL,0,0,0,2,1),(17,1,6,'Height','height',NULL,0,0,0,3,1),(20,1,8,'Custom','advanced',NULL,0,0,0,2,1),(21,1,8,'?','help',NULL,0,0,0,3,1),(22,1,8,'Full border','full',NULL,0,0,1,1,1),(23,4,10,'Text','text',NULL,1,0,1,1,1),(24,4,11,'Heading','heading',NULL,1,0,1,1,1),(25,4,10,'?','help',NULL,0,0,0,4,1),(26,4,11,'?','help',NULL,0,0,0,4,1),(27,3,12,'Field','text',NULL,1,0,1,1,1),(28,3,12,'?','help',NULL,0,0,0,3,1),(29,3,13,'Field','textarea',NULL,1,0,1,1,1),(30,3,13,'?','help',NULL,0,0,0,3,1),(31,3,15,'Field','password',NULL,1,0,1,1,1),(32,3,15,'?','help',NULL,0,0,0,3,1),(33,4,16,'Import','import-form',NULL,1,0,1,1,1),(34,4,16,'?','help',NULL,0,0,0,5,1),(35,5,18,'Page','new-page',NULL,0,0,1,1,1),(36,5,18,'?','help',NULL,0,0,0,2,1),(37,5,19,'Page','move-page',NULL,0,0,1,1,1),(38,5,19,'?','help',NULL,0,0,0,2,1),(39,4,10,'Styles','styling','Styling_Text',1,1,0,3,1),(40,4,11,'Styles','styling','Styling_Heading',1,1,0,3,1),(41,4,16,'Styles','styling','Styling_ImportForm',1,1,0,4,1),(42,3,20,'Field','email',NULL,1,0,1,1,1),(43,3,20,'?','help',NULL,0,0,0,3,1),(44,3,21,'Field','name',NULL,1,0,1,1,1),(45,3,21,'?','help',NULL,0,0,0,3,1),(46,4,16,'Size & position','position','Position_ImportForm',1,1,0,3,1),(47,4,10,'Size & position','position','Position_Text',1,1,0,2,1),(48,4,11,'Size & position','position','Position_Heading',1,1,0,2,1),(49,3,12,'Styling','styling','Styling_Text',1,1,0,2,1),(50,3,13,'Styling','styling','Styling_Textarea',1,1,0,2,1),(51,3,15,'Styling','styling','Styling_Password',1,1,0,2,1),(54,4,16,'Form','edit',NULL,0,1,0,2,1),(55,4,22,'Import','import-text',NULL,1,0,1,1,1),(56,4,22,'?','help',NULL,0,0,0,2,1),(57,4,23,'Import','import-heading',NULL,1,0,1,1,1),(58,4,23,'?','help',NULL,0,0,2,2,1),(59,3,24,'Settings','form-settings',NULL,1,0,1,1,1),(60,3,24,'?','help',NULL,0,0,0,2,1),(61,8,25,'Image','add',NULL,0,0,1,1,1),(62,8,25,'?','help',NULL,0,0,0,2,1),(63,8,27,'Category','category',NULL,0,0,1,1,1),(64,8,27,'?','help',NULL,0,0,0,2,1),(65,8,28,'Sub category','subcategory',NULL,0,0,1,1,1),(66,8,28,'?','help',NULL,0,0,0,2,1),(67,8,29,'Clone','copy',NULL,0,0,1,1,1),(68,8,29,'?','help',NULL,0,0,0,2,1),(69,8,30,'?','help',NULL,0,0,0,2,1),(70,8,31,'Edit','edit',NULL,0,0,1,1,1),(71,8,31,'?','help',NULL,0,0,0,2,1),(72,8,30,'Crop','crop',NULL,0,0,1,1,1),(73,4,32,'Row','add-content-row',NULL,0,0,1,1,1),(74,4,32,'?','help',NULL,0,0,0,2,1),(77,4,34,'Jumbotron','jumbotron',NULL,1,0,1,1,1),(78,4,34,'?','help',NULL,0,0,0,4,1),(79,4,34,'Styles','styling','Styling_Jumbotron',1,1,0,3,1),(80,4,34,'Size & position','position','Position_Jumbotron',1,1,0,2,1),(81,4,35,'Import','import-jumbotron',NULL,1,0,1,1,1),(82,4,35,'?','help',NULL,0,0,0,2,1),(83,4,36,'Move','move-row',NULL,1,0,1,1,1),(84,4,36,'?','help',NULL,0,0,0,2,1),(85,4,37,'Move','move-item',NULL,1,0,1,1,1),(86,4,37,'?','help',NULL,0,0,0,2,1),(87,4,38,'Row','content-row',NULL,0,0,1,1,1),(88,4,38,'Styles','styling','Styling_ContentRow',0,0,0,2,1),(89,4,39,'Image','image',NULL,1,0,1,1,1),(90,4,39,'?','help',NULL,0,0,0,4,1),(91,4,40,'Carousel','carousel',NULL,1,0,1,1,1),(92,4,40,'?','help',NULL,0,0,0,2,1),(93,4,39,'Size & position','position','Position_Image',1,1,0,2,1),(94,4,39,'Styles','styling','Styling_Image',1,1,0,3,1);

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

insert  into `dlayer_session`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('rkls3nc716rm80d3lvuomgmke1','','PHPSESSID',1431432557,3601,'__ZF|a:5:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1431436157;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1431436138;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1431436138;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1431436138;}s:20:\"dlayer_session_image\";a:1:{s:3:\"ENT\";i:1431436138;}}dlayer_session_content|a:8:{s:7:\"page_id\";N;s:6:\"div_id\";N;s:14:\"content_row_id\";N;s:10:\"content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";N;s:10:\"tool_model\";s:7:\"MoveRow\";}dlayer_session_template|a:4:{s:6:\"div_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";N;}dlayer_session_form|a:5:{s:8:\"field_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:7:\"form_id\";N;s:6:\"return\";N;}dlayer_session_image|a:3:{s:4:\"tool\";N;s:3:\"tab\";N;s:9:\"image_ids\";a:0:{}}');

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

insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values (1,1,'Colour palettes','Colour palettes','<p>You can define three colour palettes for each of your web sites, the colours you define here will be shown anytime you need a tool that requires you to choose a colour.</p>\r\n\r\n<p>You will always be able to choose a colour that is not in one of your three palettes, think of these as quick access.</p>','/dlayer/settings/palettes',1,'All colour pickers',2,1),(2,3,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the content manager, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/content/settings/base-font-family',2,'Content module, all text',2,1),(3,3,'Heading styles','Set the styles for the six heading types','<p>Define the styles for the page title and the five sub headings, H2 through H6.</p>\r\n\r\n<p>Anywhere you need to choose one of the heading types the styles defined here will be used.</p>','/content/settings/headings',3,'Heading tool',3,1),(4,4,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the form builder, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/form/settings/base-font-family',2,'Forms module, all text',2,1),(5,1,'Overview','Overview','<p>Settings overview.</p>','/dlayer/settings/index',1,NULL,1,1),(6,2,'Overview','Overview','<p>Template designer settings overview.</p>','/template/settings/index',2,NULL,1,1),(7,3,'Overview','Overview','<p>Content manager settings overview.</p>','/content/settings/index',2,NULL,1,1),(8,4,'Overview','Overview','<p>Form builder settings overview.</p>','/form/settings/index',2,NULL,1,1),(9,8,'Overview','Overview','<p>Image library settings overview.</p>','/image/settings/index',2,NULL,1,1),(10,6,'Overview','Overview','<p>Web site manager settings overview.</p>','/website/settings/index',2,NULL,1,1),(11,5,'Overview','Overview','<p>Widget designer settings overview</p>','/widget/settings/index',2,NULL,1,1);

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

insert  into `dlayer_setting_group`(`id`,`name`,`module_id`,`title`,`tab_title`,`url`,`sort_order`,`enabled`) values (1,'App',7,'Dlayer settings','Dlayer','/dlayer/settings/index',1,1),(2,'Template',1,'Template designer settings','Template designer','/template/settings/index',2,1),(3,'Content',4,'Content designer settings','Content manager','/content/settings/index',3,1),(4,'Form',3,'Form builder settings','Form builder','/form/settings/index',4,1),(5,'Widget',2,'Widget designer settings','Widget designer','/widget/settings/index',5,1),(6,'Web site',5,'Web site designer settings','Web site manager','/website/settings/index',7,1),(7,'Question',6,'Question manager settings','Question manager','/question/settings/index',6,1),(8,'Image',8,'Image library settings','Image library','/image/settings/index',8,1);

/*Table structure for table `dlayer_setting_scope` */

DROP TABLE IF EXISTS `dlayer_setting_scope`;

CREATE TABLE `dlayer_setting_scope` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_setting_scope` */

insert  into `dlayer_setting_scope`(`id`,`scope`) values (1,'App'),(2,'Module'),(3,'Tool');

/*Table structure for table `user_setting_color_history` */

DROP TABLE IF EXISTS `user_setting_color_history`;

CREATE TABLE `user_setting_color_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_setting_color_history_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_color_history` */

insert  into `user_setting_color_history`(`id`,`site_id`,`color_hex`) values (1,1,'#337ab7'),(2,1,'#5cb85c'),(3,1,'#555555'),(4,1,'#EEEEEE'),(5,1,'#f0ad4e'),(6,2,'#337ab7'),(7,2,'#5cb85c'),(8,2,'#555555'),(9,2,'#EEEEEE'),(10,2,'#f0ad4e'),(13,3,'#337ab7'),(14,3,'#5cb85c'),(15,3,'#555555'),(16,3,'#EEEEEE'),(17,3,'#f0ad4e'),(25,1,'#f0ad4e'),(26,1,'#337ab7'),(27,1,'#777777'),(28,1,'#eeeeee'),(29,1,'#eeeeee'),(30,2,'#5bc0de'),(31,2,'#eeeeee'),(32,3,'#eeeeee'),(33,1,'#777777'),(34,1,'#777777'),(35,1,'#eeeeee'),(36,1,'#eeeeee'),(37,1,'#eeeeee'),(38,1,'#337ab7'),(39,1,'#eeeeee'),(40,1,'#eeeeee'),(41,1,'#eeeeee'),(42,1,'#f0ad4e');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_color_palette` */

insert  into `user_setting_color_palette`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values (1,1,'Palette 1','palette-1',1),(2,1,'Palette 2','palette-2',2),(3,2,'Palette 1','palette-1',1),(4,2,'Palette 2','palette-2',2),(5,3,'Palette 1','palette-1',1),(6,3,'Palette 2','palette-2',2);

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_color_palette_color` */

insert  into `user_setting_color_palette_color`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (1,1,1,1,'Black','#000000'),(2,1,1,2,'Dark grey','#333333'),(3,1,1,3,'Grey','#555555'),(4,1,1,4,'Light grey','#777777'),(5,1,1,5,'Off white','#EEEEEE'),(6,1,2,1,'Blue','#337ab7'),(7,1,2,2,'Green','#5cb85c'),(8,1,2,3,'Light blue','#5bc0de'),(9,1,2,4,'Amber','#f0ad4e'),(10,1,2,5,'Red','#d9534f'),(11,2,3,1,'Black','#000000'),(12,2,3,2,'Dark grey','#333333'),(13,2,3,3,'Grey','#555555'),(14,2,3,4,'Light grey','#777777'),(15,2,3,5,'Off white','#EEEEEE'),(18,2,4,1,'Blue','#337ab7'),(19,2,4,2,'Green','#5cb85c'),(20,2,4,3,'Light blue','#5bc0de'),(21,2,4,4,'Amber','#f0ad4e'),(22,2,4,5,'Red','#d9534f'),(25,3,5,1,'Black','#000000'),(26,3,5,2,'Dark grey','#333333'),(27,3,5,3,'Grey','#555555'),(28,3,5,4,'Light grey','#777777'),(29,3,5,5,'Off white','#EEEEEE'),(32,3,6,1,'Blue','#337ab7'),(33,3,6,2,'Green','#5cb85c'),(34,3,6,3,'Light blue','#5bc0de'),(35,3,6,4,'Amber','#f0ad4e'),(36,3,6,5,'Red','#d9534f');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_font_family` */

insert  into `user_setting_font_family`(`id`,`site_id`,`module_id`,`font_family_id`) values (1,1,3,1),(2,1,4,1),(3,2,3,1),(4,2,4,1),(5,3,3,1),(6,3,4,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_setting_heading` */

insert  into `user_setting_heading`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (1,1,1,1,2,1,22,'#000000',1),(2,1,2,1,2,1,18,'#000000',2),(3,1,3,1,2,1,16,'#000000',3),(4,1,4,1,2,2,14,'#000000',4),(5,1,5,2,2,1,14,'#000000',5),(6,1,6,1,1,1,12,'#000000',6),(7,2,1,1,2,1,22,'#000000',1),(8,2,2,1,2,1,18,'#000000',2),(9,2,3,1,2,1,16,'#000000',3),(10,2,4,1,2,2,14,'#000000',4),(11,2,5,2,2,1,14,'#000000',5),(12,2,6,1,1,1,12,'#000000',6),(13,3,1,1,2,1,22,'#000000',1),(14,3,2,1,2,1,18,'#000000',2),(15,3,3,1,2,1,16,'#000000',3),(16,3,4,1,2,2,14,'#000000',4),(17,3,5,2,2,1,14,'#000000',5),(18,3,6,1,1,1,12,'#000000',6);

/*Table structure for table `user_site` */

DROP TABLE IF EXISTS `user_site`;

CREATE TABLE `user_site` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `identity_id` (`identity_id`),
  CONSTRAINT `user_site_ibfk_1` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identity` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site` */

insert  into `user_site`(`id`,`identity_id`,`name`) values (1,1,'Sample site 1'),(2,2,'Sample site 1'),(3,3,'Sample site 1');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_heading` */

insert  into `user_site_content_heading`(`id`,`site_id`,`name`,`content`) values (1,1,'Intro content title','This is a content title-:-Sub title for content title'),(2,2,'Intro content title','Content title-:-Content sub title'),(3,3,'Intro content title','Content title-:-Content sub title');

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

insert  into `user_site_content_jumbotron`(`id`,`site_id`,`name`,`content`) values (1,1,'Page masthead','Welcome to my site-:-Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est.'),(2,2,'Page masthead','Welcome to my site-:-Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est.'),(3,3,'Page masthead','Welcome to my site-:-Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus.');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_content_text` */

insert  into `user_site_content_text`(`id`,`site_id`,`name`,`content`) values (1,1,'Page intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum.'),(2,1,'Page text one','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum. Maecenas a nisl sollicitudin, ullamcorper arcu et, iaculis erat. Nulla et sapien ut elit sodales blandit. Donec ut turpis mattis, tempor ipsum eu, vehicula diam. Quisque eleifend rhoncus molestie. Suspendisse interdum ante vitae justo rutrum, in ullamcorper magna maximus. Mauris ut erat dolor. In non lobortis tellus. Etiam laoreet at mauris eget facilisis. In eu tortor vitae augue porttitor tincidunt porttitor pretium ex. Cras eu ex neque.'),(3,1,'Page text two','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum. Maecenas a nisl sollicitudin, ullamcorper arcu et, iaculis erat. Nulla et sapien ut elit sodales blandit. Donec ut turpis mattis, tempor ipsum eu, vehicula diam. Quisque eleifend rhoncus molestie. Suspendisse interdum ante vitae justo rutrum, in ullamcorper magna maximus. Mauris ut erat dolor. In non lobortis tellus. Etiam laoreet at mauris eget facilisis. In eu tortor vitae augue porttitor tincidunt porttitor pretium ex. Cras eu ex neque.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum. Maecenas a nisl sollicitudin, ullamcorper arcu et, iaculis erat. Nulla et sapien ut elit sodales blandit. Donec ut turpis mattis, tempor ipsum eu, vehicula diam. Quisque eleifend rhoncus molestie. Suspendisse interdum ante vitae justo rutrum, in ullamcorper magna maximus. Mauris ut erat dolor. In non lobortis tellus. Etiam laoreet at mauris eget facilisis. In eu tortor vitae augue porttitor tincidunt porttitor pretium ex. Cras eu ex neque.'),(4,2,'Intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat'),(5,2,'Page text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat. Integer viverra, arcu nec condimentum elementum, justo ipsum gravida eros, nec efficitur nulla quam vel massa. Nulla faucibus lorem purus, at commodo dolor ultrices luctus. Cras dapibus eget sapien a mollis. Curabitur vulputate pulvinar sapien, ac tristique mi mattis id.\r\n\r\nPellentesque at finibus felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut a mauris id nisl placerat pretium. Maecenas quam urna, rhoncus quis ipsum id, pharetra molestie odio. Praesent malesuada ornare nunc, at egestas nulla porttitor eget. Vestibulum in purus in nisi consectetur vulputate imperdiet at urna. Pellentesque consectetur hendrerit urna quis accumsan. Etiam tempus nisl ac nisi sollicitudin, at lacinia eros blandit. Nulla porttitor mauris a nisl pretium, sit amet hendrerit nisi suscipit. Proin egestas, eros id tempus pulvinar, nunc libero finibus magna, eget egestas lorem mi non quam.'),(6,3,'Intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat.'),(7,3,'Page text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat. Integer viverra, arcu nec condimentum elementum, justo ipsum gravida eros, nec efficitur nulla quam vel massa. Nulla faucibus lorem purus, at commodo dolor ultrices luctus. Cras dapibus eget sapien a mollis. Curabitur vulputate pulvinar sapien, ac tristique mi mattis id.\r\n\r\nPellentesque at finibus felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut a mauris id nisl placerat pretium. Maecenas quam urna, rhoncus quis ipsum id, pharetra molestie odio. Praesent malesuada ornare nunc, at egestas nulla porttitor eget. Vestibulum in purus in nisi consectetur vulputate imperdiet at urna. Pellentesque consectetur hendrerit urna quis accumsan. Etiam tempus nisl ac nisi sollicitudin, at lacinia eros blandit. Nulla porttitor mauris a nisl pretium, sit amet hendrerit nisi suscipit. Proin egestas, eros id tempus pulvinar, nunc libero finibus magna, eget egestas lorem mi non quam.'),(8,1,'Page intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum ante at mauris iaculis, id sagittis velit aliquam. Fusce in nulla a magna varius posuere. Proin congue, ligula non pellentesque mollis, est justo pharetra dui, dapibus pretium eros sem placerat ipsum.'),(9,2,'Intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien.'),(10,3,'Intro text','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris. Nam eget purus est. Suspendisse vehicula consectetur dapibus. Cras ut euismod nisi, vel commodo erat. Aliquam a semper sapien. Cras fringilla ultricies elit, finibus mollis enim lobortis consequat.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. In a pretium elit. Maecenas sagittis erat id leo tincidunt, ut faucibus tellus suscipit. Phasellus ex purus, vehicula nec lacinia non, sagittis ac mauris.');

/*Table structure for table `user_site_form` */

DROP TABLE IF EXISTS `user_site_form`;

CREATE TABLE `user_site_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form` */

insert  into `user_site_form`(`id`,`site_id`,`name`) values (1,1,'Contact form'),(2,1,'Subscribe'),(3,2,'Contact form'),(4,2,'Subscribe'),(5,3,'Contact form'),(6,3,'Subscribe');

/*Table structure for table `user_site_form_field` */

DROP TABLE IF EXISTS `user_site_form_field`;

CREATE TABLE `user_site_form_field` (
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
  CONSTRAINT `user_site_form_field_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_form_field_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`),
  CONSTRAINT `user_site_form_field_ibfk_3` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_type` (`id`),
  CONSTRAINT `user_site_form_field_ibfk_4` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field` */

insert  into `user_site_form_field`(`id`,`site_id`,`form_id`,`field_type_id`,`tool_id`,`label`,`description`,`sort_order`) values (1,1,1,1,12,'Your name','Please enter your name',1),(2,1,1,1,12,'Your email','Please enter your email address',2),(3,1,1,2,13,'Comment','Please enter your comment',3),(4,1,2,1,12,'Your name','Please enter your name',1),(5,1,2,1,12,'Your email','Please enter your email address',2),(6,2,3,1,12,'Your name','Please enter your name',1),(7,2,3,1,12,'Your email','Please enter your email address',2),(8,2,3,2,13,'Comment','Please enter your comment',3),(9,2,4,1,12,'Your name','Please enter your name',1),(10,2,4,1,12,'Your email','Please enter your email address',2),(11,3,5,1,12,'Your name','Please enter your name',1),(12,3,5,1,12,'Your email','Please enter your email address',2),(13,3,5,2,13,'Comment','Please enter your comment',3),(14,3,6,1,12,'Your name','Please enter your name',1),(15,3,6,1,12,'Your email','Please enter your email address',2);

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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field_attribute` */

insert  into `user_site_form_field_attribute`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (1,1,1,1,1,'40'),(2,1,1,1,2,'255'),(3,1,1,1,7,'Enter your name'),(4,1,1,2,1,'40'),(5,1,1,2,2,'255'),(6,1,1,2,7,'Enter your email'),(7,1,1,3,3,'40'),(8,1,1,3,4,'3'),(9,1,1,3,8,'Dlayer is starting to look interesting'),(10,1,2,4,1,'40'),(11,1,2,4,2,'255'),(12,1,2,4,7,'Enter your name'),(13,1,2,5,1,'40'),(14,1,2,5,2,'255'),(15,1,2,5,7,'Enter your email'),(16,2,3,6,1,'40'),(17,2,3,6,2,'255'),(18,2,3,6,7,'Enter your name'),(19,2,3,7,1,'40'),(20,2,3,7,2,'255'),(21,2,3,7,7,'Enter your email'),(22,2,3,8,3,'40'),(23,2,3,8,4,'3'),(24,2,3,8,8,'Dlayer is starting to look interesting'),(25,2,4,9,1,'40'),(26,2,4,9,2,'255'),(27,2,4,9,7,'Enter your name'),(28,2,4,10,1,'40'),(29,2,4,10,2,'255'),(30,2,4,10,7,'Enter your email'),(31,3,5,11,1,'40'),(32,3,5,11,2,'255'),(33,3,5,11,7,'Enter your name'),(34,3,5,12,1,'40'),(35,3,5,12,2,'255'),(36,3,5,12,7,'Enter your email'),(37,3,5,13,3,'40'),(38,3,5,13,4,'3'),(39,3,5,13,8,'Dlayer is starting to look interesting'),(40,3,6,14,1,'40'),(41,3,6,14,2,'255'),(42,3,6,14,7,'Enter your name'),(43,3,6,15,1,'40'),(44,3,6,15,2,'255'),(45,3,6,15,7,'Enter your email');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_field_row_background_color` */

insert  into `user_site_form_field_row_background_color`(`id`,`site_id`,`form_id`,`field_id`,`color_hex`) values (1,1,2,5,'#eeeeee');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_form_setting` */

insert  into `user_site_form_setting`(`id`,`site_id`,`form_id`,`width`,`legend`,`button`) values (1,1,1,500,'Contact me','Save'),(2,1,2,600,'Subscribe to my newlestter','Subscribe'),(3,2,3,600,'My form','Save'),(4,2,4,600,'Subscribe to my newlestter','Subscribe'),(5,3,5,600,'My form','Save'),(6,3,6,600,'Subscribe to my newlestter','Subscribe');

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

insert  into `user_site_history`(`id`,`identity_id`,`site_id`) values (1,1,1),(2,2,2),(3,3,3);

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

insert  into `user_site_image_library`(`id`,`site_id`,`name`,`description`,`category_id`,`sub_category_id`) values (1,1,'Autumn path','Public domain image.',1,1),(2,1,'Downtown Boston','Public domain image.',1,1),(3,1,'Horses','Public domain image.',1,1),(4,1,'Old lantern and brush','Public domain image.',1,1),(5,1,'Robin','Public domain image.',1,1),(6,1,'Signs','Public domain image.',1,1),(7,1,'Spring coffee','Public domain image.',1,1),(8,3,'Autumn path','Public domain image.',3,3),(9,3,'Downtown Boston','Public domain image.',3,3),(10,3,'Horses','Public domain image.',3,3),(11,3,'Old lantern and brush','Public domain image.',3,3),(12,3,'Robin','Public domain image.',3,3),(13,3,'Signs','Public domain image.',3,3),(14,3,'Spring coffee','Public domain image.',3,3),(15,2,'Autumn path','Public domain image.',2,2),(16,2,'Downtown Boston','Public domain image.',2,2),(17,2,'Horses','Public domain image.',2,2),(18,2,'Old lantern and brush','Public domain image.',2,2),(19,2,'Robin','Public domain image.',2,2),(20,2,'Signs','Public domain image.',2,2),(21,2,'Spring coffee','Public domain image.',2,2),(22,1,'Autumn path - Clone','Clone or original image.',1,1);

/*Table structure for table `user_site_image_library_category` */

DROP TABLE IF EXISTS `user_site_image_library_category`;

CREATE TABLE `user_site_image_library_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_image_library_category_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_category` */

insert  into `user_site_image_library_category`(`id`,`site_id`,`name`) values (1,1,'Uncategorised'),(2,2,'Uncategorised'),(3,3,'Uncategorised');

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

insert  into `user_site_image_library_link`(`id`,`site_id`,`library_id`,`version_id`) values (1,1,1,1),(2,1,2,2),(3,1,3,3),(4,1,4,4),(5,1,5,5),(6,1,6,6),(7,1,7,23),(8,3,8,8),(9,3,9,9),(10,3,10,10),(11,3,11,11),(12,3,12,12),(13,3,13,13),(14,3,14,14),(15,2,15,15),(16,2,16,16),(17,2,17,17),(18,2,18,18),(19,2,19,19),(20,2,20,20),(21,2,21,21),(22,1,22,22);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_image_library_sub_category` */

insert  into `user_site_image_library_sub_category`(`id`,`site_id`,`category_id`,`name`) values (1,1,1,'Misc.'),(2,2,2,'Misc.'),(3,3,3,'Misc.');

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

insert  into `user_site_image_library_version`(`id`,`site_id`,`library_id`,`uploaded`,`tool_id`,`identity_id`) values (1,1,1,'2015-04-22 12:21:09',25,1),(2,1,2,'2015-04-22 12:21:45',25,1),(3,1,3,'2015-04-22 12:22:06',25,1),(4,1,4,'2015-04-22 12:22:28',25,1),(5,1,5,'2015-04-22 12:22:54',25,1),(6,1,6,'2015-04-22 12:23:17',25,1),(7,1,7,'2015-04-22 12:23:39',25,1),(8,3,8,'2015-04-22 12:29:00',25,3),(9,3,9,'2015-04-22 12:29:18',25,3),(10,3,10,'2015-04-22 12:29:31',25,3),(11,3,11,'2015-04-22 12:29:41',25,3),(12,3,12,'2015-04-22 12:29:53',25,3),(13,3,13,'2015-04-22 12:30:08',25,3),(14,3,14,'2015-04-22 12:30:24',25,3),(15,2,15,'2015-04-22 12:30:55',25,2),(16,2,16,'2015-04-22 12:31:08',25,2),(17,2,17,'2015-04-22 12:31:22',25,2),(18,2,18,'2015-04-22 12:31:35',25,2),(19,2,19,'2015-04-22 12:31:50',25,2),(20,2,20,'2015-04-22 12:32:02',25,2),(21,2,21,'2015-04-22 12:32:15',25,2),(22,1,22,'2015-04-22 12:39:27',29,1),(23,1,7,'2015-04-22 12:47:14',30,1);

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

insert  into `user_site_image_library_version_meta`(`id`,`site_id`,`library_id`,`version_id`,`extension`,`type`,`width`,`height`,`size`) values (1,1,1,1,'.jpg','image/jpeg',615,453,173442),(2,1,2,2,'.jpg','image/jpeg',615,461,124479),(3,1,3,3,'.jpg','image/jpeg',615,389,42910),(4,1,4,4,'.jpg','image/jpeg',615,410,51533),(5,1,5,5,'.jpg','image/jpeg',615,407,32763),(6,1,6,6,'.jpg','image/jpeg',615,461,49367),(7,1,7,7,'.jpg','image/jpeg',615,410,47362),(8,3,8,8,'.jpg','image/jpeg',615,453,173442),(9,3,9,9,'.jpg','image/jpeg',615,461,124479),(10,3,10,10,'.jpg','image/jpeg',615,389,42910),(11,3,11,11,'.jpg','image/jpeg',615,410,51533),(12,3,12,12,'.jpg','image/jpeg',615,407,32763),(13,3,13,13,'.jpg','image/jpeg',615,461,49367),(14,3,14,14,'.jpg','image/jpeg',615,410,47362),(15,2,15,15,'.jpg','image/jpeg',615,453,173442),(16,2,16,16,'.jpg','image/jpeg',615,461,124479),(17,2,17,17,'.jpg','image/jpeg',615,389,42910),(18,2,18,18,'.jpg','image/jpeg',615,410,51533),(19,2,19,19,'.jpg','image/jpeg',615,407,32763),(20,2,20,20,'.jpg','image/jpeg',615,461,49367),(21,2,21,21,'.jpg','image/jpeg',615,410,47362),(22,1,22,22,'.jpg','image/jpeg',615,453,173442),(23,1,7,23,'.jpg','image/jpeg',561,367,42624);

/*Table structure for table `user_site_page` */

DROP TABLE IF EXISTS `user_site_page`;

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

insert  into `user_site_page`(`id`,`site_id`,`template_id`,`name`,`title`,`description`) values (1,1,1,'Doodling','Showcasing content items','Displays all the current content items'),(2,2,2,'Doodling','Showcasing content items','Displays all the current content items'),(3,3,3,'Doodling','Showcasing content items','Displays all current content items');

/*Table structure for table `user_site_page_content_item` */

DROP TABLE IF EXISTS `user_site_page_content_item`;

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

insert  into `user_site_page_content_item`(`id`,`site_id`,`page_id`,`content_row_id`,`content_type`,`sort_order`) values (1,1,1,1,4,1),(2,1,1,2,2,1),(3,1,1,2,1,2),(4,1,1,3,1,1),(5,1,1,3,3,2),(6,2,2,5,4,1),(7,2,2,6,2,1),(8,2,2,6,1,3),(9,2,2,7,1,1),(10,2,2,7,3,2),(11,3,3,9,4,1),(12,3,3,10,2,1),(13,3,3,10,1,2),(14,3,3,11,1,1),(15,3,3,11,3,2),(16,1,1,2,5,3),(17,2,2,6,5,2),(18,3,3,10,5,3);

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
  CONSTRAINT `user_site_page_content_item_form_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`),
  CONSTRAINT `user_site_page_content_item_form_ibfk_4` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_form` */

insert  into `user_site_page_content_item_form`(`id`,`site_id`,`page_id`,`content_id`,`form_id`) values (1,1,1,5,1),(2,2,2,10,3),(3,3,3,15,5);

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

insert  into `user_site_page_content_item_heading`(`id`,`site_id`,`page_id`,`content_id`,`heading_id`,`data_id`) values (1,1,1,2,2,1),(2,2,2,7,2,2),(3,3,3,12,2,3);

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
  KEY `content_id` (`content_id`),
  KEY `version_id` (`version_id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`),
  CONSTRAINT `user_site_page_content_item_image_ibfk_4` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_version` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_image` */

insert  into `user_site_page_content_item_image`(`id`,`site_id`,`page_id`,`content_id`,`version_id`,`expand`,`caption`) values (1,1,1,16,23,1,'Caption for this image.'),(2,2,2,17,15,1,'Caption for this image.'),(3,3,3,18,11,1,'Caption for this image.');

/*Table structure for table `user_site_page_content_item_jumbotron` */

DROP TABLE IF EXISTS `user_site_page_content_item_jumbotron`;

CREATE TABLE `user_site_page_content_item_jumbotron` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `data_id` int(11) unsigned NOT NULL,
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

insert  into `user_site_page_content_item_jumbotron`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values (1,1,1,1,1),(2,2,2,6,2),(3,3,3,11,3);

/*Table structure for table `user_site_page_content_item_size` */

DROP TABLE IF EXISTS `user_site_page_content_item_size`;

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

insert  into `user_site_page_content_item_size`(`id`,`site_id`,`page_id`,`content_id`,`size`,`offset`) values (1,1,1,4,6,0),(2,1,1,5,6,0),(3,2,2,9,6,0),(4,2,2,10,6,0),(5,3,3,14,6,0),(6,3,3,15,6,0),(7,1,1,1,12,0),(8,1,1,3,9,0),(9,1,1,2,12,0),(10,2,2,8,9,0),(11,3,3,13,9,0),(12,1,1,16,3,0),(13,2,2,17,3,0),(14,3,3,18,3,0);

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
  CONSTRAINT `user_site_page_content_item_text_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content_item` (`id`),
  CONSTRAINT `user_site_page_content_item_text_ibfk_4` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_text` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_item_text` */

insert  into `user_site_page_content_item_text`(`id`,`site_id`,`page_id`,`content_id`,`data_id`) values (1,1,1,3,8),(2,1,1,4,3),(3,2,2,8,9),(4,2,2,9,5),(5,3,3,13,10),(6,3,3,14,7);

/*Table structure for table `user_site_page_content_rows` */

DROP TABLE IF EXISTS `user_site_page_content_rows`;

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

insert  into `user_site_page_content_rows`(`id`,`site_id`,`page_id`,`div_id`,`sort_order`) values (1,1,1,2,1),(2,1,1,3,1),(3,1,1,3,2),(4,1,1,3,3),(5,2,2,6,1),(6,2,2,7,1),(7,2,2,7,2),(8,2,2,7,3),(9,3,3,10,1),(10,3,3,11,1),(11,3,3,11,2),(12,3,3,11,3);

/*Table structure for table `user_site_page_styles_container_background_color` */

DROP TABLE IF EXISTS `user_site_page_styles_container_background_color`;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styles_container_background_color` */

insert  into `user_site_page_styles_container_background_color`(`id`,`site_id`,`page_id`,`content_id`,`color_hex`) values (2,1,1,3,'#eeeeee'),(3,2,2,8,'#eeeeee'),(4,3,3,13,'#eeeeee');

/*Table structure for table `user_site_page_styles_item_background_color` */

DROP TABLE IF EXISTS `user_site_page_styles_item_background_color`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_styles_item_background_color` */

/*Table structure for table `user_site_page_styles_row_background_color` */

DROP TABLE IF EXISTS `user_site_page_styles_row_background_color`;

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

DROP TABLE IF EXISTS `user_site_template`;

CREATE TABLE `user_site_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_template_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template` */

insert  into `user_site_template`(`id`,`site_id`,`name`) values (1,1,'Sample template'),(2,2,'Sample template'),(3,3,'Sample template');

/*Table structure for table `user_site_template_div` */

DROP TABLE IF EXISTS `user_site_template_div`;

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

insert  into `user_site_template_div`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (1,1,1,0,1),(2,1,1,1,1),(3,1,1,1,2),(4,1,1,1,3),(5,2,2,0,1),(6,2,2,5,1),(7,2,2,5,2),(8,2,2,5,3),(9,3,3,0,1),(10,3,3,9,1),(11,3,3,9,2),(12,3,3,9,3);

/*Table structure for table `user_site_template_div_background_color` */

DROP TABLE IF EXISTS `user_site_template_div_background_color`;

CREATE TABLE `user_site_template_div_background_color` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`),
  KEY `div_id` (`div_id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_template_div_background_color_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `user_site_template` (`id`),
  CONSTRAINT `user_site_template_div_background_color_ibfk_2` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_div` (`id`),
  CONSTRAINT `user_site_template_div_background_color_ibfk_3` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_background_color` */

/*Table structure for table `user_site_template_div_border` */

DROP TABLE IF EXISTS `user_site_template_div_border`;

CREATE TABLE `user_site_template_div_border` (
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
  CONSTRAINT `user_site_template_div_border_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `user_site_template` (`id`),
  CONSTRAINT `user_site_template_div_border_ibfk_2` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_div` (`id`),
  CONSTRAINT `user_site_template_div_border_ibfk_3` FOREIGN KEY (`style`) REFERENCES `designer_css_border_style` (`style`),
  CONSTRAINT `user_site_template_div_border_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_border` */

/*Table structure for table `user_site_template_div_size` */

DROP TABLE IF EXISTS `user_site_template_div_size`;

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

insert  into `user_site_template_div_size`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (1,1,1,1,996,0,0),(2,1,1,2,996,0,150),(3,1,1,3,996,0,400),(4,1,1,4,996,0,150),(5,2,2,5,996,0,0),(6,2,2,6,996,0,150),(7,2,2,7,996,0,400),(8,2,2,8,996,0,150),(9,3,3,9,996,0,0),(10,3,3,10,996,0,150),(11,3,3,11,996,0,400),(12,3,3,12,996,0,150);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
