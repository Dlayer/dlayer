/*
SQLyog Enterprise v11.3 (32 bit)
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

insert  into `designer_color_palette_colors`(`id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (1,1,1,'Black','#000000'),(2,1,2,'Tan','#f3f1df'),(3,1,3,'Dark grey','#666666'),(4,2,1,'Blue','#336699'),(5,2,2,'Dark grey','#666666'),(6,2,3,'Grey','#999999'),(7,3,1,'Blue','#003366'),(8,3,2,'White','#FFFFFF'),(9,3,3,'Orange','#FF6600');

/*Table structure for table `designer_color_palettes` */

DROP TABLE IF EXISTS `designer_color_palettes`;

CREATE TABLE `designer_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palettes` */

insert  into `designer_color_palettes`(`id`,`name`,`view_script`) values (1,'Palette 1','palette-1'),(2,'Palette 2','palette-2'),(3,'Palette 3','palette-3');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_headings` */

insert  into `designer_content_headings`(`id`,`name`,`tag`,`sort_order`) values (1,'Page title','h1',1),(2,'Heading 1','h2',2),(3,'Heading 2','h3',3),(4,'Heading 3','h4',4),(5,'Heading 4','h5',5),(6,'Heading 5','h6',6),(7,'Heading 6','h7',7);

/*Table structure for table `designer_content_types` */

DROP TABLE IF EXISTS `designer_content_types`;

CREATE TABLE `designer_content_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_content_types` */

insert  into `designer_content_types`(`id`,`name`,`description`) values (1,'text','Text block'),(2,'heading','Heading');

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

insert  into `designer_css_border_styles`(`id`,`name`,`style`,`sort_order`) values (1,'Solid','solid',2),(2,'Dashed','dashed',3),(3,'No border','none',1);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_font_families` */

insert  into `designer_css_font_families`(`id`,`name`,`description`,`css`,`sort_order`) values (1,'Helvetica','Helvetica, Arial, Nimbus Sans L','Helvetica, Arial, \"Nimbus Sans L\", sans-serif',1),(2,'Lucida Grande','Lucida Grande, Lucida Sans Unicode, Bitstream Vera Sans','\"Lucida Grande\", \"Lucida Sans Unicode\", \"Bitstream Vera Sans\", sans-serif',2),(3,'Georgia','Georgia, URW Bookman L','Georgia, \"URW Bookman L\", serif',3),(4,'Corbel','Corbel, Arial, Helvetica, Nimbus Sans L, Liberation Sans','Corbel, Arial, Helvetica, \"Nimbus Sans L\", \"Liberation Sans\", sans-serif',4),(5,'Code','Consolas, Bitstream Vera Sans Mono, Andale Mono, Monaco, Lucida Console','Consolas, \"Bitstream Vera Sans Mono\", \"Andale Mono\", Monaco, \"Lucida Console\", monospace',5),(6,'Verdana','Verdana, Geneva','Verdana, Geneva, sans-serif',6),(7,'Tahoma','Tahoma, Geneva','Tahoma, Geneva, sans-serif',7);

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

insert  into `designer_css_text_decorations`(`id`,`name`,`css`,`sort_order`) values (1,'None','none',1),(2,'Underline','underline',2),(3,'Strike-through','line-through',3);

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

insert  into `designer_css_text_styles`(`id`,`name`,`css`,`sort_order`) values (1,'Normal','normal',1),(2,'Italic','italic',2),(3,'Oblique','oblique',3);

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

insert  into `designer_css_text_weights`(`id`,`name`,`css`,`sort_order`) values (1,'Normal','400',1),(2,'Bold','700',2),(3,'Light','100',3);

/*Table structure for table `dlayer_development_log` */

DROP TABLE IF EXISTS `dlayer_development_log`;

CREATE TABLE `dlayer_development_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `change` text COLLATE utf8_unicode_ci NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `release` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_development_log` */

insert  into `dlayer_development_log`(`id`,`change`,`added`,`release`,`enabled`) values (1,'Added a development log to Dlayer to show changes to the application, two reasons, one to spur on my development, two, to show the public what I am adding.','2013-04-05 00:38:16',0,1),(2,'Added a pagination view helper, update of my existing pagination view helper.','2013-04-05 00:38:52',0,1),(6,'Added a helper class to the library, initially only a couple of static helper functions.','2013-04-08 01:20:22',0,1),(7,'Updated the pagination view helper, added the ability to define text to use for links and also updated the logic for \'of n\' text.','2013-04-08 02:03:42',0,1),(8,'Updated the default styling for tables, header rows and table rows.','2013-04-08 02:19:22',0,1),(9,'Added the form for the add text field tool in the forms builder.','2013-04-12 18:15:57',0,1),(10,'Updated the base forms class, addElementsToForm() method updated, now able to create multiple fieldsets within a form, one fieldset per method call','2013-04-14 18:18:04',0,1),(11,'Updated all the help text for the template designer, simpler language.','2013-04-16 18:19:34',0,1),(12,'Added the form for the add textarea tool in the forms builder.','2013-04-20 18:20:36',0,1),(13,'Updated the pagination view helper, can now show either \'item n-m of o\' or \'page n of m\' between the next and previous links.','2013-04-21 18:46:50',0,1),(14,'Added base tool process model for the form builder, working on the add text field process tool model.','2013-04-25 01:37:41',0,1),(16,'Text field can now be added to a form in the form builder, still need to add supporting for editing a field.','2013-05-04 22:44:24',0,1),(17,'Text area field can now be added to the form, edit mode still needs to be added.','2013-05-12 02:27:58',0,1),(18,'Form builder now supports and displayed text area fields which have been added to the form defintion.','2013-05-12 02:28:13',0,1),(19,'Added initial styling for the form builder forms.','2013-05-12 03:12:49',0,1),(20,'The add field forms in the form builder now add the attributes for the text and textarea field types.','2013-05-14 01:48:24',0,1),(21,'Field attributes are now saved to the database and then pulled in the form builder and attached to the inputs.','2013-05-15 01:43:55',0,1),(22,'Reworked the javascript, selector functions have been moved to the module javascript files rather than the base Dlayer object.','2013-05-21 01:49:48',0,1),(23,'Public set methods (div and form field) now check that the given id belongs to the currently set template/form and site.','2013-05-28 01:02:38',0,1),(24,'Form module ribbon forms now show existing values when in edit mode.','2013-06-01 01:26:25',0,1),(25,'Edit mode in place for form text fields and form textarea fields','2013-06-11 00:00:23',0,1),(26,'Updated the template module and template session class, updated names of some logic vars, names more clear, wasn\'t always obvious what a var referred to.','2013-06-12 00:43:42',0,1),(27,'Multi use tool setting was not being respected in the form builder when adding a new field, field id was not being stored in session.','2013-06-16 21:09:23',0,1),(28,'Form fields not being pulled from database in correct order.','2013-06-16 21:09:54',0,1),(29,'Fixed a bug with the expand and contact tabs of the resize tool in the template designer, border widths were not being added to div width meaning that the split positions were not being calculated correctly.','2013-06-19 01:25:20',0,1),(30,'Pagination view helper wasn\'t escaping all developer defined text.','2013-06-25 23:31:43',0,1),(31,'Template module tool process methods now double check that the tool posted matches the tool defined in the session.','2013-06-25 23:51:11',0,1),(32,'Wife had a baby, Jack James','2013-06-28 05:41:00',1,1),(33,'Added the forms for the content headings to the content settings page, initially it just allows the user to update the params for the headings, there is no live preview or formatting.','2013-08-16 02:42:41',0,1),(34,'Added initial styling for the heading setting forms and added initial styling for the heading previews.','2013-08-16 03:37:51',0,1),(35,'Added live preview to the content settings page (header styles) defaults to show saved styles and then on change updates the previews.','2013-08-20 17:10:04',0,1),(36,'Refactored the designer js, all modules, simplifed the base dlayer object and moved all the js that was sitting in view files. Structure of the scripts folder now matches images and styles folders.','2013-08-21 01:46:02',0,1),(37,'Upgraded to jquery-1.10.2, fixed a small jquery issue with chrome, multi-line comment at top of script.','2013-08-22 23:53:30',0,1),(38,'Moved all the jquery required for the initial content module settings into the Dlayer js object.','2013-08-23 23:14:30',0,1),(39,'Added tabs to the content manager settings page, going to be too many settings for one page and the new layout will allow more detail to be given to the user.','2013-08-24 23:15:15',0,1),(40,'Added some default styling to the app, a tags and list items.','2013-08-25 01:57:42',0,1),(41,'Updated static validation helper class, now calls the new colorHex validation class','2013-08-26 02:50:26',0,1),(42,'Removed RGB entries for colours in the database, not required at the moment, going to just use hex values initially.','2013-08-28 00:47:24',0,1),(43,'Updated database and code, all fields relating to colour update to color_hex as that is currently what the field contains, later we can add a colour object is required with the RGB values and palette data, keeping things simple initially.','2013-08-28 00:48:48',0,1),(44,'Added the heading content type view helper to the content module, initially it adds all the header tag styles inline, this will be rectified later.','2013-08-29 02:37:13',0,1),(45,'Added a base font families table to the database and a corresponding font families settings table, allows the user to define the base font family per site/module, as in a base font family for the content manager and then the base font family for forms, support for the widget designer will be added later.','2013-08-29 19:54:42',0,1),(46,'Added the ability to define the base font family in the content module, the value is not currently being used by the designer, that support will be added shortly.','2013-09-06 16:44:18',0,1),(47,'Added a splash page to the app, this will be where the user logs in to get to their control panel.','2013-09-06 22:54:02',0,1),(48,'Re-skinned the app, new styling on the splash page, setting pages, base pages and development log.','2013-09-06 22:54:52',0,1),(49,'Re-skinned the designers, content manager, template designer and form builder','2013-09-09 00:42:34',0,1),(50,'Updated the tool bars in the three designers, tool icons are going to be larger.','2013-09-11 02:57:06',0,1),(51,'Added new tool icons for the template designer, setting the new style for the app, going for a sketchy look.','2013-09-11 15:23:44',0,1),(52,'Added new ribbon helper images for the split vertical and split horizontal tool, in the style of the new tool icons.','2013-09-12 01:34:09',0,1),(53,'Added new ribbon helper images for the resize tool and border tool','2013-09-12 18:30:43',0,1),(54,'Added a font size validator, PHP and JS. Added a hex regex for validation to the Dlayer JS object. Updated all the text in the app, now simpler and more consistent. Added custom titles to all pages. Updated for form formatting in the form builder, now appears against a white preview div.','2013-09-17 01:29:32',0,1),(55,'My standard development practice is to add enabled fields to most tables, the app takes the status fields into account and either processes, adds etc based on the status. Dlayer is an alpha level app at the moment, even though it is small, currently 36 tables, I don\'t need anything complicating the code, as such I have removed the enabled field from most tables. It still exists in a few base tables which control access to modules and access to tools but has been removed elsewhere. As parts of the app get more stable I will add back in the status fields as required.','2013-09-17 22:55:58',0,1),(56,'There was a layout file per module, because of the app design this wasn\'t needed, now use one layout file and the controller has an array of the css and js includes required for the controller actions.','2013-09-18 01:32:41',0,1),(57,'Site id was missing from 6 of the child layout tables, added site id, updated the models and simplified some of the layout queries that no longer need to do a join.','2013-09-19 17:50:13',0,1),(58,'Full app testing, fixed three minor bugs relating to the resize and border tools.','2013-09-20 02:53:29',0,1),(59,'Added a selected state to the toolbar buttons in the template designer, content manager and form builder.','2013-09-21 01:46:45',0,1),(60,'Reworked the template module ribbon data classes, now rely more on the base abstract class and there is less duplication, fixed a small bug when changing borders, incorrect id var was being used.','2013-09-23 15:07:29',0,1),(61,'Reworked the form module ribbon data classes, now rely more on the base abstract class and there is less duplication, system mirrors the more functional template designer.','2013-09-24 02:01:45',0,1),(62,'At the start of building this version of Dlayer I modified my development approach a little for this project. Typically I can plan the models and classes required to solve a problem fairly easily, with Dlayer because of the complexity I opted for a more procedural approach, this allowed me to put in place the structure for the first designer (template designer) which I then duplicated and modified for the form builder and content manager. \r\n\r\nAll three modules ended up with a very similar base, for the last week I’ve been refactoring the code adding core classes and models which handle the majority of the base functionality for each module, the ribbon, tool bars and tool processing code. \r\n','2013-10-01 18:25:30',0,1),(63,'Fixed a bug with the manual split tools, javascript wasn\'t taking the border of the parent element into account when drawing and calculating the split position and size of the new children.','2013-10-02 14:54:15',0,1),(64,'Split the content data methods out into their own models to match the rest of the system and as pre-planning for additional changes. Moved the margin settings for a heading, was defined in the heading styles settings, now defined per heading.','2013-10-02 17:45:30',0,1),(65,'Added new tool icons for the form builder and content manager and updated the cancel image for all three modules, didn\'t match the rest of the images.','2013-10-05 02:28:16',0,1),(66,'Initial content module ribbon development, ribbon classes and models.','2013-10-06 14:09:28',0,1),(67,'Ribbon forms in place for add heading and add text, now need to work on the tool processing code.','2013-10-06 23:35:12',0,1),(68,'Heading tool class now in place, heading can be added to the selected element, get positioned at the end of any existing content, obviously this will change with additional development.','2013-10-09 15:37:52',0,1),(69,'Simple text content block can now be added to the selected element.','2013-10-09 20:35:25',0,1),(70,'Render method on the base view helper was being called twice because of the way it was designer, removed the call to render() in toString() and now call render directly.','2013-10-09 21:09:55',0,1),(71,'Base content view helper, div_id was incorrectly commented as being the id of the div currently selected on the page, for adding content. Code and comments updated to make it clear that it actually refers to the id of the current div in the content data array. Added a method to set the id for the the currently selected div, if any.','2013-10-09 22:50:04',0,1),(72,'Modified the styling, switched to a light theme, going to work better for the alpha due to the limited number of tools in all the modules, darker theme can be added back in as an option later.','2013-10-12 01:03:44',0,1),(73,'Added the ability to edit both the heading and text content types. User chooses a div and then the content block, ribbon updates and they make the required changes.','2013-10-13 12:13:34',0,1),(74,'Set sensible values for text box width and padding, uses the containing div as a guide.','2013-10-13 12:20:32',0,1),(75,'Initial alpha release!','2013-10-14 01:39:45',1,1),(76,'There are two exit modes for a tool, multi-use where all session values remain and non multi-use when they are all cleared, for the content manager added a third mode to enable some vars to be kept.','2013-10-15 16:49:06',0,1),(77,'After adding or editing a text block the base content block remains selected, tool and content ids now cleared, better usability than previous set up.','2013-10-15 16:49:23',0,1),(78,'Fixed a small bug with heading tool, view script folder case incorrect, errored on case indifferent servers.','2013-10-23 02:07:17',0,1),(79,'List of sites now pulled from database on home page, adding a link to allow user to activate a site rather than default to the first.','2013-10-24 02:26:17',0,1),(80,'User is now able to choose a new site to work on from the sites list. On selecting the last accessed site is updated so that the next time the user accesses Dlayer the last accessed site is selected. As there is no authentication system yet site changes will affect all users.','2013-10-28 16:54:57',0,1),(81,'Added a validate site id view helper, checks site id exists in session and also a valid site id, later it will also check against the user/auth id.','2013-10-30 01:32:10',0,1),(82,'Added a validate template id view helper, checks template id is valid, as in exists in the database and belongs to the site id in the session.','2013-10-30 01:58:23',0,1),(83,'Added a validate form id view helper, checks form id is valid, as in exists in the database and belongs to the site id in the session.','2013-10-30 02:07:19',0,1),(84,'Added a validate content id view helper, checks content id is valid, as in exists in the database and belongs to the site id in the session.','2013-10-30 02:21:46',0,1),(85,'Template list, page list and form list now come from the database, not static text, design options only show for active item.','2013-11-01 02:38:21',0,1),(86,'Added an activate method to allow the user to switch the template, page or form they are working on with the site.','2013-11-01 23:24:34',0,1),(87,'A user can now create a new site, a site is currently just a unique name.','2013-11-06 01:52:52',0,1),(88,'Added the ability to edit a site, as per add site a site is currently just a unique name, this will develop later.','2013-11-07 01:56:41',0,1),(89,'Updated the formInputsData methods in forms, now checks the return type of model data and then acts accordingly, form elements now check to ensure data index exists before setting value.','2013-11-08 16:57:10',0,1),(90,'Added add and edit template, currently a template is just a unique name for the site.','2013-11-08 16:57:25',0,1),(91,'Added add and edit form, currently a form is just a unique name for the site.','2013-11-09 12:57:30',0,1),(92,'Add and edit new page in place, user needs to choose template to base page upon, enter a name and also the title to use for the page, as the system evolves more will need to be defined. Removed addDefaultElementDecorators() methods from site form classes, no need to override the default in the base form class as nothing was being changed. ','2013-11-10 13:00:52',0,1),(93,'Added my authentication system to Dlayer, because demo usernames and passwords are exposed an account can only login from one location, timeout on session is an hour so if a user exists without logging out the account will become available for another user after an hour. ','2013-11-13 13:01:44',0,1),(94,'Minor release, fixed heading tool and made some UX tweaks to tools','2013-10-23 16:38:09',1,1),(95,'Minor release, added the base creation tools, new site, template, form and page.','2013-11-10 16:38:53',1,1),(96,'Release messages highlighted in the development log.','2013-11-13 16:46:38',0,1),(97,'Started publically showing updates, SVN log extends much further back in history but I saw no need to transfer messages across.','2013-04-04 16:49:23',1,1),(98,'Site list now pulls sites based on identity. Updated site history table/code and action helper to check site id validity, now all use the current identity.','2013-11-14 01:43:18',0,1),(99,'No longer able to edit the name of the first sample site, used by the history tables and always defaulted if no other data in the system for identity.','2013-11-14 01:45:14',0,1),(100,'Notification next to username/password combinations if the account if currently logged in. Added a \"What is dlayer?\" page, it gives a brief overview of Dlayer and the history behind it.\r\n','2013-11-14 23:50:49',0,1),(101,'Updated database, added defaults for all settings for the three test sites.','2013-11-16 14:48:23',0,1),(102,'Fixed a bug with the activate methods, validate template id action helper was using the wrong session when in the content module.','2013-11-17 19:55:21',0,1),(103,'Added 1 sample site, 1 sample template and 1 sample page for each user, enough to allow people to play.','2013-11-17 19:55:44',0,1),(104,'Minor release, authentication system in place.','2013-11-17 20:56:23',1,1),(105,'Once you create a page from a template there need to be restrictions in place to either limit what tools can be used on an active template or extra code to manage structural  changes behind the scenes. Until I put some initial restrictions in place I have disabled the template designer, hoping to re-enable it within the next two weeks.','2013-11-17 20:03:54',0,1),(106,'Updated server to PHP 5.4, switched crypt() over to SHA_512, test identity credentials updated.','2013-11-19 01:34:16',0,1),(107,'In the template designer a tool can now be disabled if using it would be destructive. For example when a page is created from a template if the specified template div has content assigned to it on one or more pages, splitting the div would currently make the content appear to disappear. Logic needs to be added to gracefully handle these destructive changes, for now though the app just forbids access.','2013-11-19 17:20:07',0,1),(108,'Added new icons for disabled toolbar buttons, desaturated version of the icon.','2013-11-20 02:15:32',0,1),(109,'Updated the set tool action, when a tool has been disabled in the view the set tool action checks to ensure that the disabled URL can’t be called manually by the user.','2013-11-20 17:40:21',0,1),(110,'Added base font family settings to the form builder module, as per content manager module, value is not yet used in the designer.','2013-11-21 01:23:51',0,1),(111,'Xbox One and Forza 5 released.','2013-11-22 09:00:00',1,1),(112,'Updated the help text in form builder for text and textarea field tools, little more clear on what happens after a field has been added to their form.','2013-11-26 17:24:37',0,1),(113,'Added password tool to form builder, users can now add password fields to their forms.','2013-11-27 02:11:08',0,1),(114,'Temporarily added the resize tool in the template designer to the disabled tools list if template div has content on an active page. I need to develop a system that makes changes to pages in the background when a template is updated, because the resize tool affects more than the selected div I have for now disabled access until I develop the system which updates data between modules.','2013-11-27 15:18:25',0,1),(115,'History of Dlayer split out from the What is Dlayer? page.','2013-11-29 02:12:14',0,1),(116,'Base modifier system in place, this is called when there needs to be interaction between modules, if a user changes something in one module that affects data in another module modifiers can be sent requests to check to see if any changes are required and then make them if necessary.','2013-12-01 02:27:30',0,1),(117,'Border tool re-instated in the template designer when a user chooses to work on a template block which has content applied to it on a page based upon the current template. A change width modifier has been added, this modifier checks all the content items to see if the widths for the containers need to be updated (The width of a page div will change if a border is added, edited or removed on a  template block). ','2013-12-01 02:27:40',0,1),(118,'New release, modifier system, password tool in form builder, new settings for form builder, template designer tool restrictions and general tweaks.','2013-12-01 12:24:18',1,1),(119,'Abstract validate and autoValidate methods moved from base tool class down a level into the base module tool class, additional context data will be needed for validations and it will differ by module.','2013-12-02 17:09:17',0,1),(120,'Container for text content can now no be larger that the page block it is being added to.','2013-12-02 17:23:46',0,1),(121,'Base font family settings set for the content manager and form builder now used in the designers.','2013-12-04 02:14:51',0,1),(122,'Minor release, validation, settings and general small fixes.','2013-12-04 02:15:23',1,1),(123,'Added width and left margin to heading content type, width and left padding when summed can be no larger than the containing page block.','2013-12-13 14:53:05',0,1),(124,'Added a container div around content items in the content designer, js hover and click events moved to the parent container item, this is so that the movement controls will only show for each content item on hover.','2013-12-18 16:22:43',0,1);

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

insert  into `dlayer_identities`(`id`,`identity`,`credentials`,`logged_in`,`last_login`,`last_action`,`enabled`) values (1,'user-1@dlayer.com','$6$rounds=5000$jks453yuyt55d$CZJCjaieFQghQ6MwQ1OUI5nVKDy/Fi2YXk7MyW2hcex9AdJ/jvZA8ulvjzK1lo3rRVFfmd10lgjqAbDQM4ehR1',1,'2013-12-18 15:22:19','2013-12-18 16:20:29',1),(2,'user-2@dlayer.com','$6$rounds=5000$jks453yuyt55d$ZVEJgs2kNjxOxNEayqqoh2oJUiGbmxIKRqOTxVM05MP2YRcAjE9adCZfQBWCc.qe1nDjEM9.ioivNz3c/qyZ80',0,'2013-11-17 19:48:08','2013-11-17 19:49:20',1),(3,'user-3@dlayer.com','$6$rounds=5000$jks453yuyt55d$NYF6yCvxXplefx7nr8vDe4cUGBEFtd3G5vuJ2utfqvPwEf3dSgNXNTcGbFO6WrJSn21CXHgZwNOQHy691E/Rm.',0,'2013-11-17 19:49:30','2013-11-17 19:50:44',1);

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tabs` */

insert  into `dlayer_module_tool_tabs`(`id`,`module_id`,`tool_id`,`name`,`view_script`,`multi_use`,`default`,`sort_order`,`enabled`) values (1,1,2,'Quick split','quick',0,1,1,1),(2,1,2,'Split with mouse','advanced',0,0,2,1),(3,1,2,'Help','help',0,0,3,1),(4,1,3,'Quick split','quick',0,1,1,1),(5,1,3,'Split with mouse','advanced',0,0,2,1),(6,1,3,'Help','help',0,0,3,1),(7,1,7,'Palette 1','palette-1',0,1,1,1),(8,1,7,'Palette 2','palette-2',0,0,2,1),(9,1,7,'Palette 3','palette-3',0,0,3,1),(10,1,7,'Set custom color','advanced',0,0,4,1),(11,1,7,'Help','help',0,0,5,1),(12,1,6,'Set custom size','advanced',1,0,4,1),(14,1,6,'Help','help',0,0,5,1),(15,1,6,'Expand','expand',1,1,1,1),(16,1,6,'Contract','contract',1,0,2,1),(17,1,6,'Adjust height','height',1,0,3,1),(20,1,8,'Set custom border','advanced',1,0,2,1),(21,1,8,'Help','help',0,0,3,1),(22,1,8,'Full border','full',0,1,1,1),(23,4,10,'Text','text',1,1,1,1),(24,4,11,'Heading','heading',1,1,1,1),(25,4,10,'Help','help',0,0,2,1),(26,4,11,'Help','help',0,0,2,1),(27,3,12,'Text','text',0,1,1,1),(28,3,12,'Help','help',0,0,2,1),(29,3,13,'Text area','textarea',0,1,1,1),(30,3,13,'Help','help',0,0,2,1),(31,3,15,'Password','password',1,1,1,1),(32,3,15,'Help','help',0,0,2,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tools` */

insert  into `dlayer_module_tools`(`id`,`module_id`,`name`,`tool`,`tool_model`,`folder`,`icon`,`base`,`destructive`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','cancel',NULL,'cancel','cancel.png',1,0,1,1,1),(2,1,'Split horizontal','split-horizontal','SplitHorizontal','split-horizontal','split-horizontal.png',1,1,2,1,1),(3,1,'Split vertical','split-vertical','SplitVertical','split-vertical','split-vertical.png',1,1,2,2,1),(6,1,'Resize','resize','Resize','resize','resize.png',0,1,3,3,1),(7,1,'Background color','background-color','BackgroundColor','background-color','background-color.png',1,0,4,1,1),(8,1,'Border','border','Border','border','border.png',0,0,4,2,1),(9,4,'Cancel','cancel',NULL,'cancel','cancel.png',1,0,1,1,1),(10,4,'Text','text','Text','text','text.png',0,0,2,2,1),(11,4,'Heading','heading','Heading','heading','heading.png',0,0,2,1,1),(12,3,'Text','text','Text','text','text.png',0,0,2,1,1),(13,3,'Text area','textarea','Textarea','textarea','textarea.png',0,0,2,2,1),(14,3,'Cancel','cancel',NULL,'cancel','cancel.png',1,0,1,1,1),(15,3,'Password','password','Password','password','password.png',1,0,2,3,1);

/*Table structure for table `dlayer_modules` */

DROP TABLE IF EXISTS `dlayer_modules`;

CREATE TABLE `dlayer_modules` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `button_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_modules` */

insert  into `dlayer_modules`(`id`,`name`,`button_name`,`title`,`description`,`icon`,`sort_order`,`enabled`) values (1,'template','Template','Template designer','Create and manage the templates for your site.','template.png',1,1),(2,'widget','Widget','Widget designer','Create and manage your reusable and dynamic blocks. Using the widget designer you create either static or dynamic reusable blocks. If there is an elements or function that you need to appear on multiple pages it should probably be a widget.','widget.png',4,0),(3,'form','Forms','Form builder','Create and manage the forms for your site.','form.png',3,1),(4,'content','Content','Content manager','Create and manage the site content.','content.png',2,1),(5,'website','Website','Website manager','Create the structure and relationships between the pages in your site, you also manage the site data that can be used by your dynamic widgets, for example a menu or gallery.','website.png',5,0),(6,'question','Question','Question manager','Create quizzes, tests and polls, system supports multiple pages, multiple questions types, for example text, image, video and multiple answer types, free text, multiple choice, true or false. Results are summed and calculated and can either be displayed or stored for just the administrator.','question.png',5,0);

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

insert  into `dlayer_sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('2kujnppj8dqolfu6jpqev58kl5','','PHPSESSID',1387383629,3601,'__ZF|a:2:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1387387229;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1387387229;}}dlayer_session_content|a:7:{s:7:\"page_id\";i:1;s:6:\"div_id\";N;s:10:\"content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";s:1:\"1\";s:10:\"tool_model\";s:4:\"Text\";}dlayer_session|a:3:{s:11:\"identity_id\";s:1:\"1\";s:7:\"site_id\";s:1:\"1\";s:6:\"module\";s:7:\"content\";}'),('4s5jqujvathbrao3gq5j3ssl95','','PHPSESSID',1387227031,3601,'__ZF|a:4:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1387230631;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1387230631;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1387230631;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1387230631;}}dlayer_session_content|a:6:{s:7:\"page_id\";N;s:6:\"div_id\";N;s:10:\"content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";N;}dlayer_session_template|a:6:{s:11:\"template_id\";N;s:4:\"tool\";N;s:6:\"div_id\";N;s:10:\"tool_model\";s:6:\"Border\";s:16:\"tool_destructive\";s:1:\"0\";s:3:\"tab\";N;}dlayer_session_form|a:4:{s:8:\"field_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:7:\"form_id\";N;}'),('kp18pck754a0ju9ke13jvh2i96','','PHPSESSID',1386881305,3601,'__ZF|a:4:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1386884905;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1386884904;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1386884904;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1386884904;}}dlayer_session_content|a:7:{s:7:\"page_id\";N;s:6:\"div_id\";N;s:10:\"content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";N;s:10:\"tool_model\";s:7:\"Heading\";}dlayer_session_template|a:4:{s:6:\"div_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";N;}dlayer_session_form|a:4:{s:8:\"field_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:7:\"form_id\";N;}'),('oq473i279adprkhbmi0551oo85','','PHPSESSID',1387047026,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1387050625;}}'),('pisa5a4ojukeknv5vg0vcsv6n4','','PHPSESSID',1386791695,3601,'__ZF|a:1:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1386795295;}}'),('s4s6d5v9fa6j2i76t14stlgfl2','','PHPSESSID',1386124929,3601,'__ZF|a:4:{s:14:\"dlayer_session\";a:1:{s:3:\"ENT\";i:1386128529;}s:22:\"dlayer_session_content\";a:1:{s:3:\"ENT\";i:1386127116;}s:19:\"dlayer_session_form\";a:1:{s:3:\"ENT\";i:1386127116;}s:23:\"dlayer_session_template\";a:1:{s:3:\"ENT\";i:1386127116;}}dlayer_session_content|a:6:{s:7:\"page_id\";N;s:6:\"div_id\";N;s:10:\"content_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";N;}dlayer_session_form|a:4:{s:7:\"form_id\";N;s:8:\"field_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;}dlayer_session_template|a:4:{s:6:\"div_id\";N;s:4:\"tool\";N;s:3:\"tab\";N;s:11:\"template_id\";N;}');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `form_field_attributes` */

insert  into `form_field_attributes`(`id`,`field_type_id`,`name`,`attribute`,`attribute_type_id`) values (1,1,'Size','size',1),(2,1,'Max length','maxlength',1),(3,2,'Columns','cols',1),(4,2,'Rows','rows',1),(5,3,'Size','size',1),(6,3,'Max length','maxlength',1);

/*Table structure for table `form_field_types` */

DROP TABLE IF EXISTS `form_field_types`;

CREATE TABLE `form_field_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `form_field_types` */

insert  into `form_field_types`(`id`,`name`,`type`,`description`) values (1,'Test','text','A single line input'),(2,'Textarea','textarea','A multiple line input'),(3,'Password','password','A password input');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_form_field_attributes` */

insert  into `user_form_field_attributes`(`id`,`site_id`,`form_id`,`field_id`,`attribute_id`,`attribute`) values (1,1,1,1,1,'40'),(2,1,1,1,2,'255'),(3,1,1,2,3,'40'),(4,1,1,2,4,'3'),(5,1,1,3,5,'20'),(6,1,1,3,6,'255');

/*Table structure for table `user_form_fields` */

DROP TABLE IF EXISTS `user_form_fields`;

CREATE TABLE `user_form_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  KEY `field_type_id` (`field_type_id`),
  CONSTRAINT `user_form_fields_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_form_fields_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_forms` (`id`),
  CONSTRAINT `user_form_fields_ibfk_3` FOREIGN KEY (`field_type_id`) REFERENCES `form_field_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_form_fields` */

insert  into `user_form_fields`(`id`,`site_id`,`form_id`,`field_type_id`,`label`,`description`) values (1,1,1,1,'Test field','Description for text field'),(2,1,1,2,'Text area field','Description for text area field'),(3,1,1,3,'Password','Enter your credentials');

/*Table structure for table `user_forms` */

DROP TABLE IF EXISTS `user_forms`;

CREATE TABLE `user_forms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_forms_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_forms` */

insert  into `user_forms`(`id`,`site_id`,`name`) values (1,1,'Sample form');

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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_color_palette_colors` */

insert  into `user_settings_color_palette_colors`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`color_hex`) values (10,1,1,1,'Black','#000000'),(11,1,1,2,'Tan','#f3f1df'),(12,1,1,3,'Dark grey','#666666'),(13,1,2,1,'Blue','#336699'),(14,1,2,2,'Dark grey','#666666'),(15,1,2,3,'Grey','#999999'),(16,1,3,1,'Blue','#003366'),(17,1,3,2,'White','#FFFFFF'),(18,1,3,3,'Green','#000000'),(19,2,4,1,'Black','#000000'),(20,2,4,2,'Tan','#f3f1df'),(21,2,4,3,'Dark grey','#666666'),(22,2,5,1,'Blue','#336699'),(23,2,5,2,'Dark grey','#666666'),(24,2,5,3,'Grey','#999999'),(25,2,6,1,'Blue','#003366'),(26,2,6,2,'White','#FFFFFF'),(27,2,6,3,'Green','#000000'),(34,3,7,1,'Black','#000000'),(35,3,7,2,'Tan','#f3f1df'),(36,3,7,3,'Dark grey','#666666'),(37,3,8,1,'Blue','#336699'),(38,3,8,2,'Dark grey','#666666'),(39,3,8,3,'Grey','#999999'),(40,3,9,1,'Blue','#003366'),(41,3,9,2,'White','#FFFFFF'),(42,3,9,3,'Green','#000000');

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

insert  into `user_settings_color_palettes`(`id`,`site_id`,`name`,`view_script`,`sort_order`) values (1,1,'Palette 1','palette-1',1),(2,1,'Palette 2','palette-2',2),(3,1,'Palette 3','palette-3',3),(4,2,'Palette 1','palette-1',1),(5,2,'Palette 2','palette-2',2),(6,2,'Palette 3','palette-3',3),(7,3,'Palette 1','palette-1',1),(8,3,'Palette 2','palette-2',2),(9,3,'Palette 3','palette-3',3);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_font_families` */

insert  into `user_settings_font_families`(`id`,`site_id`,`module_id`,`font_family_id`) values (1,1,4,1),(2,1,3,1),(3,2,4,1),(4,2,3,1),(6,3,4,1),(7,3,3,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_headings` */

insert  into `user_settings_headings`(`id`,`site_id`,`heading_id`,`style_id`,`weight_id`,`decoration_id`,`size`,`color_hex`,`sort_order`) values (1,1,1,1,2,1,22,'#81A594',1),(2,1,2,1,2,1,18,'#81A594',2),(3,1,3,1,2,1,16,'#81A594',3),(4,1,4,1,2,1,14,'#81A594',4),(5,1,5,2,2,1,14,'#81A594',5),(6,1,6,1,1,1,12,'#81A594',6),(7,1,7,2,1,1,12,'#000000',7),(8,2,1,1,2,1,22,'#81A594',1),(9,2,2,1,2,1,18,'#81A594',2),(10,2,3,1,2,1,16,'#81A594',3),(11,2,4,1,2,1,14,'#81A594',4),(12,2,5,2,2,1,14,'#81A594',5),(13,2,6,1,1,1,12,'#81A594',6),(14,2,7,2,1,1,12,'#000000',7),(15,3,1,1,2,1,22,'#81A594',1),(16,3,2,1,2,1,18,'#81A594',2),(17,3,3,1,2,1,16,'#81A594',3),(18,3,4,1,2,1,14,'#81A594',4),(19,3,5,2,2,1,14,'#81A594',5),(20,3,6,1,1,1,12,'#81A594',6),(21,3,7,2,1,1,12,'#000000',7);

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

insert  into `user_site_history`(`id`,`identity_id`,`site_id`) values (1,1,1),(2,2,2),(3,3,3);

/*Table structure for table `user_site_page_content` */

DROP TABLE IF EXISTS `user_site_page_content`;

CREATE TABLE `user_site_page_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `content_type` int(11) unsigned NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content` */

insert  into `user_site_page_content`(`id`,`site_id`,`page_id`,`div_id`,`content_type`,`sort_order`) values (1,1,1,1,2,1),(2,1,1,4,2,1),(3,1,1,4,1,2),(4,1,1,4,2,3),(5,1,1,4,1,4),(6,2,2,5,2,1),(7,2,2,8,2,1),(8,2,2,8,1,2),(9,2,2,8,2,3),(10,2,2,8,1,4),(11,3,3,9,2,1),(12,3,3,12,2,1),(13,3,3,12,1,2),(14,3,3,12,2,3),(15,3,3,12,1,4),(16,1,1,4,1,5),(17,1,1,4,1,6);

/*Table structure for table `user_site_page_content_heading` */

DROP TABLE IF EXISTS `user_site_page_content_heading`;

CREATE TABLE `user_site_page_content_heading` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `heading_id` int(11) unsigned NOT NULL,
  `heading` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `width` int(3) unsigned NOT NULL DEFAULT '12',
  `margin_top` int(3) unsigned NOT NULL DEFAULT '12',
  `margin_bottom` int(3) unsigned NOT NULL DEFAULT '12',
  `margin_left` int(3) unsigned NOT NULL DEFAULT '12',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `site_id` (`site_id`),
  KEY `heading_id` (`heading_id`),
  CONSTRAINT `user_site_page_content_heading_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_heading_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  CONSTRAINT `user_site_page_content_heading_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_page_content_heading_ibfk_5` FOREIGN KEY (`heading_id`) REFERENCES `user_settings_headings` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_heading` */

insert  into `user_site_page_content_heading`(`id`,`site_id`,`page_id`,`content_id`,`heading_id`,`heading`,`width`,`margin_top`,`margin_bottom`,`margin_left`) values (1,1,1,1,1,'Page title!',975,12,12,5),(2,1,1,2,2,'Content heading',825,12,12,5),(3,1,1,4,3,'Content sub heading',825,12,12,5),(4,2,2,6,1,'Page title',975,12,12,5),(5,2,2,7,2,'Content heading',825,12,12,5),(6,2,2,9,3,'Content sub heading',825,12,12,5),(7,3,3,11,1,'Page title',975,12,12,5),(8,3,3,12,2,'Content heading',825,12,12,5),(9,3,3,14,3,'Content sub heading',825,12,12,5);

/*Table structure for table `user_site_page_content_text` */

DROP TABLE IF EXISTS `user_site_page_content_text`;

CREATE TABLE `user_site_page_content_text` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `page_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `width` int(4) unsigned NOT NULL DEFAULT '0',
  `padding` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  KEY `site_id` (`site_id`),
  CONSTRAINT `user_site_page_content_text_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_3` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_text` */

insert  into `user_site_page_content_text`(`id`,`site_id`,`page_id`,`content_id`,`width`,`padding`,`content`) values (1,1,1,3,810,10,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac vehicula massa, at elementum odio. Vivamus suscipit commodo nulla ut luctus. Nam vehicula augue quam, vel pellentesque lacus sollicitudin sit amet. Quisque at massa leo. Curabitur molestie velit dui. Quisque vel congue neque, ut interdum justo. Aenean sodales ornare sapien, id semper nisl iaculis et. Fusce ac velit sed tellus interdum dictum et eget ipsum. Fusce ac blandit mauris...'),(2,1,1,5,810,10,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac vehicula massa, at elementum odio. Vivamus suscipit commodo nulla ut luctus. Nam vehicula augue quam, vel pellentesque lacus sollicitudin sit amet. Quisque at massa leo. Curabitur molestie velit dui. Quisque vel congue neque, ut interdum justo. Aenean sodales ornare sapien, id semper nisl iaculis et. Fusce ac velit sed tellus interdum dictum et eget ipsum. Fusce ac blandit mauris.'),(3,2,2,8,810,10,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac vehicula massa, at elementum odio. Vivamus suscipit commodo nulla ut luctus. Nam vehicula augue quam, vel pellentesque lacus sollicitudin sit amet. Quisque at massa leo. Curabitur molestie velit dui. Quisque vel congue neque, ut interdum justo. Aenean sodales ornare sapien, id semper nisl iaculis et. Fusce ac velit sed tellus interdum dictum et eget ipsum. Fusce ac blandit mauris.'),(4,2,2,10,810,10,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac vehicula massa, at elementum odio. Vivamus suscipit commodo nulla ut luctus. Nam vehicula augue quam, vel pellentesque lacus sollicitudin sit amet. Quisque at massa leo. Curabitur molestie velit dui. Quisque vel congue neque, ut interdum justo. Aenean sodales ornare sapien, id semper nisl iaculis et. Fusce ac velit sed tellus interdum dictum et eget ipsum. Fusce ac blandit mauris.'),(5,3,3,13,810,10,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac vehicula massa, at elementum odio. Vivamus suscipit commodo nulla ut luctus. Nam vehicula augue quam, vel pellentesque lacus sollicitudin sit amet. Quisque at massa leo. Curabitur molestie velit dui. Quisque vel congue neque, ut interdum justo. Aenean sodales ornare sapien, id semper nisl iaculis et. Fusce ac velit sed tellus interdum dictum et eget ipsum. Fusce ac blandit mauris.'),(6,3,3,15,810,10,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac vehicula massa, at elementum odio. Vivamus suscipit commodo nulla ut luctus. Nam vehicula augue quam, vel pellentesque lacus sollicitudin sit amet. Quisque at massa leo. Curabitur molestie velit dui. Quisque vel congue neque, ut interdum justo. Aenean sodales ornare sapien, id semper nisl iaculis et. Fusce ac velit sed tellus interdum dictum et eget ipsum. Fusce ac blandit mauris.'),(7,1,1,16,810,10,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac vehicula massa, at elementum odio. Vivamus suscipit commodo nulla ut luctus. Nam vehicula augue quam, vel pellentesque lacus sollicitudin sit amet. Quisque at massa leo.'),(8,1,1,17,810,10,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac vehicula massa, at elementum odio. Vivamus suscipit commodo nulla ut luctus. Nam vehicula augue quam, vel pellentesque lacus sollicitudin sit amet. Quisque at massa leo.');

/*Table structure for table `user_site_pages` */

DROP TABLE IF EXISTS `user_site_pages`;

CREATE TABLE `user_site_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_site_pages_ibfk_2` (`template_id`),
  CONSTRAINT `user_site_pages_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_pages_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_pages` */

insert  into `user_site_pages`(`id`,`site_id`,`template_id`,`name`,`title`) values (1,1,1,'Sample page','Sample page'),(2,2,2,'Sample page','Sample page'),(3,3,3,'Sample page','Sample page');

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

insert  into `user_site_template_div_background_colors`(`id`,`site_id`,`template_id`,`div_id`,`color_hex`) values (1,1,1,1,'#666666'),(2,1,1,3,'#f3f1df'),(3,2,2,5,'#000000'),(4,2,2,7,'#f3f1df'),(5,3,3,9,'#000000'),(6,3,3,11,'#f3f1df');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_borders` */

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

insert  into `user_site_template_div_sizes`(`id`,`site_id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (1,1,1,1,980,0,125),(2,1,1,2,980,0,375),(3,1,1,3,150,0,375),(4,1,1,4,830,0,375),(5,2,2,5,980,0,125),(6,2,2,6,980,0,375),(7,2,2,7,150,0,375),(8,2,2,8,830,0,375),(9,3,3,9,980,0,125),(10,3,3,10,980,0,375),(11,3,3,11,150,0,375),(12,3,3,12,830,0,375);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_divs` */

insert  into `user_site_template_divs`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (1,1,1,0,1),(2,1,1,0,2),(3,1,1,2,1),(4,1,1,2,2),(5,2,2,0,1),(6,2,2,0,2),(7,2,2,6,1),(8,2,2,6,2),(9,3,3,0,1),(10,3,3,0,2),(11,3,3,10,1),(12,3,3,10,2);

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

insert  into `user_site_templates`(`id`,`site_id`,`name`) values (1,1,'Template 1'),(2,2,'Template 1'),(3,3,'Template 1');

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

insert  into `user_sites`(`id`,`identity_id`,`name`) values (1,1,'Sample site 1'),(2,2,'Sample site 1'),(3,3,'Sample site 1');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
