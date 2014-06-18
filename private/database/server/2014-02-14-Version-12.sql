-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: infongd8489:3316
-- Generation Time: Feb 14, 2014 at 04:13 PM
-- Server version: 5.1.73
-- PHP Version: 5.3.3-7+squeeze18
-- 
-- Database: `db495875811`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_color_palette_colors`
-- 

CREATE TABLE `designer_color_palette_colors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `palette_id` int(11) unsigned NOT NULL,
  `color_type_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `palette_id` (`palette_id`),
  KEY `color_type_id` (`color_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `designer_color_palette_colors`
-- 

INSERT INTO `designer_color_palette_colors` VALUES (1, 1, 1, 'Black', '#000000');
INSERT INTO `designer_color_palette_colors` VALUES (2, 1, 2, 'Tan', '#f3f1df');
INSERT INTO `designer_color_palette_colors` VALUES (3, 1, 3, 'Dark grey', '#666666');
INSERT INTO `designer_color_palette_colors` VALUES (4, 2, 1, 'Blue', '#336699');
INSERT INTO `designer_color_palette_colors` VALUES (5, 2, 2, 'Dark grey', '#666666');
INSERT INTO `designer_color_palette_colors` VALUES (6, 2, 3, 'Grey', '#999999');
INSERT INTO `designer_color_palette_colors` VALUES (7, 3, 1, 'Blue', '#003366');
INSERT INTO `designer_color_palette_colors` VALUES (8, 3, 2, 'White', '#FFFFFF');
INSERT INTO `designer_color_palette_colors` VALUES (9, 3, 3, 'Orange', '#FF6600');

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_color_palettes`
-- 

CREATE TABLE `designer_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `designer_color_palettes`
-- 

INSERT INTO `designer_color_palettes` VALUES (1, 'Palette 1', 'palette-1');
INSERT INTO `designer_color_palettes` VALUES (2, 'Palette 2', 'palette-2');
INSERT INTO `designer_color_palettes` VALUES (3, 'Palette 3', 'palette-3');

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_color_types`
-- 

CREATE TABLE `designer_color_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `designer_color_types`
-- 

INSERT INTO `designer_color_types` VALUES (1, 'Primary');
INSERT INTO `designer_color_types` VALUES (2, 'Secondary');
INSERT INTO `designer_color_types` VALUES (3, 'Tertiary');

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_content_headings`
-- 

CREATE TABLE `designer_content_headings` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `designer_content_headings`
-- 

INSERT INTO `designer_content_headings` VALUES (1, 'Page title', 'h1', 1);
INSERT INTO `designer_content_headings` VALUES (2, 'Heading 1', 'h2', 2);
INSERT INTO `designer_content_headings` VALUES (3, 'Heading 2', 'h3', 3);
INSERT INTO `designer_content_headings` VALUES (4, 'Heading 3', 'h4', 4);
INSERT INTO `designer_content_headings` VALUES (5, 'Heading 4', 'h5', 5);
INSERT INTO `designer_content_headings` VALUES (6, 'Heading 5', 'h6', 6);

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_content_types`
-- 

CREATE TABLE `designer_content_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `designer_content_types`
-- 

INSERT INTO `designer_content_types` VALUES (1, 'text', 'Text block');
INSERT INTO `designer_content_types` VALUES (2, 'heading', 'Heading');
INSERT INTO `designer_content_types` VALUES (3, 'form', 'Form');

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_css_border_styles`
-- 

CREATE TABLE `designer_css_border_styles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `style` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `style` (`style`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Border styles that can be used within the designers' AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `designer_css_border_styles`
-- 

INSERT INTO `designer_css_border_styles` VALUES (1, 'Solid', 'solid', 2);
INSERT INTO `designer_css_border_styles` VALUES (2, 'Dashed', 'dashed', 3);
INSERT INTO `designer_css_border_styles` VALUES (3, 'No border', 'none', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_css_font_families`
-- 

CREATE TABLE `designer_css_font_families` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `designer_css_font_families`
-- 

INSERT INTO `designer_css_font_families` VALUES (1, 'Helvetica', 'Helvetica, Arial, Nimbus Sans L', 'Helvetica, Arial, "Nimbus Sans L", sans-serif', 1);
INSERT INTO `designer_css_font_families` VALUES (2, 'Lucida Grande', 'Lucida Grande, Lucida Sans Unicode, Bitstream Vera Sans', '"Lucida Grande", "Lucida Sans Unicode", "Bitstream Vera Sans", sans-serif', 2);
INSERT INTO `designer_css_font_families` VALUES (3, 'Georgia', 'Georgia, URW Bookman L', 'Georgia, "URW Bookman L", serif', 3);
INSERT INTO `designer_css_font_families` VALUES (4, 'Corbel', 'Corbel, Arial, Helvetica, Nimbus Sans L, Liberation Sans', 'Corbel, Arial, Helvetica, "Nimbus Sans L", "Liberation Sans", sans-serif', 4);
INSERT INTO `designer_css_font_families` VALUES (5, 'Code', 'Consolas, Bitstream Vera Sans Mono, Andale Mono, Monaco, Lucida Console', 'Consolas, "Bitstream Vera Sans Mono", "Andale Mono", Monaco, "Lucida Console", monospace', 5);
INSERT INTO `designer_css_font_families` VALUES (6, 'Verdana', 'Verdana, Geneva', 'Verdana, Geneva, sans-serif', 6);
INSERT INTO `designer_css_font_families` VALUES (7, 'Tahoma', 'Tahoma, Geneva', 'Tahoma, Geneva, sans-serif', 7);
INSERT INTO `designer_css_font_families` VALUES (8, 'Segoe', 'Segoe UI, Helvetica, Arial, Sans-Serif;', '"Segoe UI", Helvetica, Arial, "Sans-Serif"', 8);

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_css_text_decorations`
-- 

CREATE TABLE `designer_css_text_decorations` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `designer_css_text_decorations`
-- 

INSERT INTO `designer_css_text_decorations` VALUES (1, 'None', 'none', 1);
INSERT INTO `designer_css_text_decorations` VALUES (2, 'Underline', 'underline', 2);
INSERT INTO `designer_css_text_decorations` VALUES (3, 'Strike-through', 'line-through', 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_css_text_styles`
-- 

CREATE TABLE `designer_css_text_styles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `designer_css_text_styles`
-- 

INSERT INTO `designer_css_text_styles` VALUES (1, 'Normal', 'normal', 1);
INSERT INTO `designer_css_text_styles` VALUES (2, 'Italic', 'italic', 2);
INSERT INTO `designer_css_text_styles` VALUES (3, 'Oblique', 'oblique', 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `designer_css_text_weights`
-- 

CREATE TABLE `designer_css_text_weights` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `designer_css_text_weights`
-- 

INSERT INTO `designer_css_text_weights` VALUES (1, 'Normal', '400', 1);
INSERT INTO `designer_css_text_weights` VALUES (2, 'Bold', '700', 2);
INSERT INTO `designer_css_text_weights` VALUES (3, 'Light', '100', 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `dlayer_development_log`
-- 

CREATE TABLE `dlayer_development_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `change` text COLLATE utf8_unicode_ci NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `release` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=172 ;

-- 
-- Dumping data for table `dlayer_development_log`
-- 

INSERT INTO `dlayer_development_log` VALUES (1, 'Added a development log to Dlayer to show changes to the application, two reasons, one to spur on my development, two, to show the public what I am adding.', '2013-04-05 00:38:16', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (2, 'Added a pagination view helper, update of my existing pagination view helper.', '2013-04-05 00:38:52', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (6, 'Added a helper class to the library, initially only a couple of static helper functions.', '2013-04-08 01:20:22', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (7, 'Updated the pagination view helper, added the ability to define text to use for links and also updated the logic for ''of n'' text.', '2013-04-08 02:03:42', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (8, 'Updated the default styling for tables, header rows and table rows.', '2013-04-08 02:19:22', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (9, 'Added the form for the add text field tool in the forms builder.', '2013-04-12 18:15:57', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (10, 'Updated the base forms class, addElementsToForm() method updated, now able to create multiple fieldsets within a form, one fieldset per method call', '2013-04-14 18:18:04', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (11, 'Updated all the help text for the template designer, simpler language.', '2013-04-16 18:19:34', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (12, 'Added the form for the add textarea tool in the forms builder.', '2013-04-20 18:20:36', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (13, 'Updated the pagination view helper, can now show either ''item n-m of o'' or ''page n of m'' between the next and previous links.', '2013-04-21 18:46:50', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (14, 'Added base tool process model for the form builder, working on the add text field process tool model.', '2013-04-25 01:37:41', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (16, 'Text field can now be added to a form in the form builder, still need to add supporting for editing a field.', '2013-05-04 22:44:24', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (17, 'Text area field can now be added to the form, edit mode still needs to be added.', '2013-05-12 02:27:58', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (18, 'Form builder now supports and displayed text area fields which have been added to the form defintion.', '2013-05-12 02:28:13', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (19, 'Added initial styling for the form builder forms.', '2013-05-12 03:12:49', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (20, 'The add field forms in the form builder now add the attributes for the text and textarea field types.', '2013-05-14 01:48:24', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (21, 'Field attributes are now saved to the database and then pulled in the form builder and attached to the inputs.', '2013-05-15 01:43:55', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (22, 'Reworked the javascript, selector functions have been moved to the module javascript files rather than the base Dlayer object.', '2013-05-21 01:49:48', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (23, 'Public set methods (div and form field) now check that the given id belongs to the currently set template/form and site.', '2013-05-28 01:02:38', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (24, 'Form module ribbon forms now show existing values when in edit mode.', '2013-06-01 01:26:25', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (25, 'Edit mode in place for form text fields and form textarea fields', '2013-06-11 00:00:23', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (26, 'Updated the template module and template session class, updated names of some logic vars, names more clear, wasn''t always obvious what a var referred to.', '2013-06-12 00:43:42', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (27, 'Multi use tool setting was not being respected in the form builder when adding a new field, field id was not being stored in session.', '2013-06-16 21:09:23', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (28, 'Form fields not being pulled from database in correct order.', '2013-06-16 21:09:54', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (29, 'Fixed a bug with the expand and contact tabs of the resize tool in the template designer, border widths were not being added to div width meaning that the split positions were not being calculated correctly.', '2013-06-19 01:25:20', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (30, 'Pagination view helper wasn''t escaping all developer defined text.', '2013-06-25 23:31:43', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (31, 'Template module tool process methods now double check that the tool posted matches the tool defined in the session.', '2013-06-25 23:51:11', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (32, 'Wife had a baby, Jack James', '2013-06-28 05:41:00', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (33, 'Added the forms for the content headings to the content settings page, initially it just allows the user to update the params for the headings, there is no live preview or formatting.', '2013-08-16 02:42:41', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (34, 'Added initial styling for the heading setting forms and added initial styling for the heading previews.', '2013-08-16 03:37:51', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (35, 'Added live preview to the content settings page (header styles) defaults to show saved styles and then on change updates the previews.', '2013-08-20 17:10:04', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (36, 'Refactored the designer js, all modules, simplifed the base dlayer object and moved all the js that was sitting in view files. Structure of the scripts folder now matches images and styles folders.', '2013-08-21 01:46:02', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (37, 'Upgraded to jquery-1.10.2, fixed a small jquery issue with chrome, multi-line comment at top of script.', '2013-08-22 23:53:30', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (38, 'Moved all the jquery required for the initial content module settings into the Dlayer js object.', '2013-08-23 23:14:30', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (39, 'Added tabs to the content manager settings page, going to be too many settings for one page and the new layout will allow more detail to be given to the user.', '2013-08-24 23:15:15', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (40, 'Added some default styling to the app, a tags and list items.', '2013-08-25 01:57:42', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (41, 'Updated static validation helper class, now calls the new colorHex validation class', '2013-08-26 02:50:26', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (42, 'Removed RGB entries for colours in the database, not required at the moment, going to just use hex values initially.', '2013-08-28 00:47:24', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (43, 'Updated database and code, all fields relating to colour update to color_hex as that is currently what the field contains, later we can add a colour object is required with the RGB values and palette data, keeping things simple initially.', '2013-08-28 00:48:48', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (44, 'Added the heading content type view helper to the content module, initially it adds all the header tag styles inline, this will be rectified later.', '2013-08-29 02:37:13', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (45, 'Added a base font families table to the database and a corresponding font families settings table, allows the user to define the base font family per site/module, as in a base font family for the content manager and then the base font family for forms, support for the widget designer will be added later.', '2013-08-29 19:54:42', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (46, 'Added the ability to define the base font family in the content module, the value is not currently being used by the designer, that support will be added shortly.', '2013-09-06 16:44:18', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (47, 'Added a splash page to the app, this will be where the user logs in to get to their control panel.', '2013-09-06 22:54:02', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (48, 'Re-skinned the app, new styling on the splash page, setting pages, base pages and development log.', '2013-09-06 22:54:52', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (49, 'Re-skinned the designers, content manager, template designer and form builder', '2013-09-09 00:42:34', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (50, 'Updated the tool bars in the three designers, tool icons are going to be larger.', '2013-09-11 02:57:06', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (51, 'Added new tool icons for the template designer, setting the new style for the app, going for a sketchy look.', '2013-09-11 15:23:44', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (52, 'Added new ribbon helper images for the split vertical and split horizontal tool, in the style of the new tool icons.', '2013-09-12 01:34:09', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (53, 'Added new ribbon helper images for the resize tool and border tool', '2013-09-12 18:30:43', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (54, 'Added a font size validator, PHP and JS. Added a hex regex for validation to the Dlayer JS object. Updated all the text in the app, now simpler and more consistent. Added custom titles to all pages. Updated for form formatting in the form builder, now appears against a white preview div.', '2013-09-17 01:29:32', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (55, 'My standard development practice is to add enabled fields to most tables, the app takes the status fields into account and either processes, adds etc based on the status. Dlayer is an alpha level app at the moment, even though it is small, currently 36 tables, I don''t need anything complicating the code, as such I have removed the enabled field from most tables. It still exists in a few base tables which control access to modules and access to tools but has been removed elsewhere. As parts of the app get more stable I will add back in the status fields as required.', '2013-09-17 22:55:58', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (56, 'There was a layout file per module, because of the app design this wasn''t needed, now use one layout file and the controller has an array of the css and js includes required for the controller actions.', '2013-09-18 01:32:41', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (57, 'Site id was missing from 6 of the child layout tables, added site id, updated the models and simplified some of the layout queries that no longer need to do a join.', '2013-09-19 17:50:13', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (58, 'Full app testing, fixed three minor bugs relating to the resize and border tools.', '2013-09-20 02:53:29', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (59, 'Added a selected state to the toolbar buttons in the template designer, content manager and form builder.', '2013-09-21 01:46:45', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (60, 'Reworked the template module ribbon data classes, now rely more on the base abstract class and there is less duplication, fixed a small bug when changing borders, incorrect id var was being used.', '2013-09-23 15:07:29', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (61, 'Reworked the form module ribbon data classes, now rely more on the base abstract class and there is less duplication, system mirrors the more functional template designer.', '2013-09-24 02:01:45', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (62, 'At the start of building this version of Dlayer I modified my development approach a little for this project. Typically I can plan the models and classes required to solve a problem fairly easily, with Dlayer because of the complexity I opted for a more procedural approach, this allowed me to put in place the structure for the first designer (template designer) which I then duplicated and modified for the form builder and content manager. \r\n\r\nAll three modules ended up with a very similar base, for the last week I’ve been refactoring the code adding core classes and models which handle the majority of the base functionality for each module, the ribbon, tool bars and tool processing code. \r\n', '2013-10-01 18:25:30', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (63, 'Fixed a bug with the manual split tools, javascript wasn''t taking the border of the parent element into account when drawing and calculating the split position and size of the new children.', '2013-10-02 14:54:15', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (64, 'Split the content data methods out into their own models to match the rest of the system and as pre-planning for additional changes. Moved the margin settings for a heading, was defined in the heading styles settings, now defined per heading.', '2013-10-02 17:45:30', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (65, 'Added new tool icons for the form builder and content manager and updated the cancel image for all three modules, didn''t match the rest of the images.', '2013-10-05 02:28:16', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (66, 'Initial content module ribbon development, ribbon classes and models.', '2013-10-06 14:09:28', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (67, 'Ribbon forms in place for add heading and add text, now need to work on the tool processing code.', '2013-10-06 23:35:12', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (68, 'Heading tool class now in place, heading can be added to the selected element, get positioned at the end of any existing content, obviously this will change with additional development.', '2013-10-09 15:37:52', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (69, 'Simple text content block can now be added to the selected element.', '2013-10-09 20:35:25', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (70, 'Render method on the base view helper was being called twice because of the way it was designer, removed the call to render() in toString() and now call render directly.', '2013-10-09 21:09:55', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (71, 'Base content view helper, div_id was incorrectly commented as being the id of the div currently selected on the page, for adding content. Code and comments updated to make it clear that it actually refers to the id of the current div in the content data array. Added a method to set the id for the the currently selected div, if any.', '2013-10-09 22:50:04', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (72, 'Modified the styling, switched to a light theme, going to work better for the alpha due to the limited number of tools in all the modules, darker theme can be added back in as an option later.', '2013-10-12 01:03:44', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (73, 'Added the ability to edit both the heading and text content types. User chooses a div and then the content block, ribbon updates and they make the required changes.', '2013-10-13 12:13:34', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (74, 'Set sensible values for text box width and padding, uses the containing div as a guide.', '2013-10-13 12:20:32', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (75, 'Dlayer - Release 1 - Initial alpha release!', '2013-10-14 01:39:45', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (76, 'There are two exit modes for a tool, multi-use where all session values remain and non multi-use when they are all cleared, for the content manager added a third mode to enable some vars to be kept.', '2013-10-15 16:49:06', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (77, 'After adding or editing a text block the base content block remains selected, tool and content ids now cleared, better usability than previous set up.', '2013-10-15 16:49:23', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (78, 'Fixed a small bug with heading tool, view script folder case incorrect, errored on case indifferent servers.', '2013-10-23 02:07:17', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (79, 'List of sites now pulled from database on home page, adding a link to allow user to activate a site rather than default to the first.', '2013-10-24 02:26:17', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (80, 'User is now able to choose a new site to work on from the sites list. On selecting the last accessed site is updated so that the next time the user accesses Dlayer the last accessed site is selected. As there is no authentication system yet site changes will affect all users.', '2013-10-28 16:54:57', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (81, 'Added a validate site id view helper, checks site id exists in session and also a valid site id, later it will also check against the user/auth id.', '2013-10-30 01:32:10', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (82, 'Added a validate template id view helper, checks template id is valid, as in exists in the database and belongs to the site id in the session.', '2013-10-30 01:58:23', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (83, 'Added a validate form id view helper, checks form id is valid, as in exists in the database and belongs to the site id in the session.', '2013-10-30 02:07:19', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (84, 'Added a validate content id view helper, checks content id is valid, as in exists in the database and belongs to the site id in the session.', '2013-10-30 02:21:46', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (85, 'Template list, page list and form list now come from the database, not static text, design options only show for active item.', '2013-11-01 02:38:21', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (86, 'Added an activate method to allow the user to switch the template, page or form they are working on with the site.', '2013-11-01 23:24:34', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (87, 'A user can now create a new site, a site is currently just a unique name.', '2013-11-06 01:52:52', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (88, 'Added the ability to edit a site, as per add site a site is currently just a unique name, this will develop later.', '2013-11-07 01:56:41', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (89, 'Updated the formInputsData methods in forms, now checks the return type of model data and then acts accordingly, form elements now check to ensure data index exists before setting value.', '2013-11-08 16:57:10', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (90, 'Added add and edit template, currently a template is just a unique name for the site.', '2013-11-08 16:57:25', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (91, 'Added add and edit form, currently a form is just a unique name for the site.', '2013-11-09 12:57:30', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (92, 'Add and edit new page in place, user needs to choose template to base page upon, enter a name and also the title to use for the page, as the system evolves more will need to be defined. Removed addDefaultElementDecorators() methods from site form classes, no need to override the default in the base form class as nothing was being changed. ', '2013-11-10 13:00:52', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (93, 'Added my authentication system to Dlayer, because demo usernames and passwords are exposed an account can only login from one location, timeout on session is an hour so if a user exists without logging out the account will become available for another user after an hour. ', '2013-11-13 13:01:44', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (94, 'Dlayer - Release 2 - Minor release, fixed heading tool and made some UX tweaks to tools', '2013-10-23 16:38:09', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (95, 'Dlayer - Release 3 - Minor release, added the base creation tools, new site, template, form and page.', '2013-11-10 16:38:53', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (96, 'Release messages highlighted in the development log.', '2013-11-13 16:46:38', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (97, 'Started publically showing updates, SVN log extends much further back in history but I saw no need to transfer messages across.', '2013-04-04 16:49:23', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (98, 'Site list now pulls sites based on identity. Updated site history table/code and action helper to check site id validity, now all use the current identity.', '2013-11-14 01:43:18', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (99, 'No longer able to edit the name of the first sample site, used by the history tables and always defaulted if no other data in the system for identity.', '2013-11-14 01:45:14', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (100, 'Notification next to username/password combinations if the account if currently logged in. Added a "What is dlayer?" page, it gives a brief overview of Dlayer and the history behind it.\r\n', '2013-11-14 23:50:49', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (101, 'Updated database, added defaults for all settings for the three test sites.', '2013-11-16 14:48:23', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (102, 'Fixed a bug with the activate methods, validate template id action helper was using the wrong session when in the content module.', '2013-11-17 19:55:21', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (103, 'Added 1 sample site, 1 sample template and 1 sample page for each user, enough to allow people to play.', '2013-11-17 19:55:44', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (104, 'Dlayer - Release 4 - Authentication system in place.', '2013-11-17 20:56:23', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (105, 'Once you create a page from a template there need to be restrictions in place to either limit what tools can be used on an active template or extra code to manage structural  changes behind the scenes. Until I put some initial restrictions in place I have disabled the template designer, hoping to re-enable it within the next two weeks.', '2013-11-17 20:03:54', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (106, 'Updated server to PHP 5.4, switched crypt() over to SHA_512, test identity credentials updated.', '2013-11-19 01:34:16', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (107, 'In the template designer a tool can now be disabled if using it would be destructive. For example when a page is created from a template if the specified template div has content assigned to it on one or more pages, splitting the div would currently make the content appear to disappear. Logic needs to be added to gracefully handle these destructive changes, for now though the app just forbids access.', '2013-11-19 17:20:07', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (108, 'Added new icons for disabled toolbar buttons, desaturated version of the icon.', '2013-11-20 02:15:32', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (109, 'Updated the set tool action, when a tool has been disabled in the view the set tool action checks to ensure that the disabled URL can’t be called manually by the user.', '2013-11-20 17:40:21', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (110, 'Added base font family settings to the form builder module, as per content manager module, value is not yet used in the designer.', '2013-11-21 01:23:51', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (111, 'Xbox One and Forza 5 released.', '2013-11-22 09:00:00', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (112, 'Updated the help text in form builder for text and textarea field tools, little more clear on what happens after a field has been added to their form.', '2013-11-26 17:24:37', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (113, 'Added password tool to form builder, users can now add password fields to their forms.', '2013-11-27 02:11:08', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (114, 'Temporarily added the resize tool in the template designer to the disabled tools list if template div has content on an active page. I need to develop a system that makes changes to pages in the background when a template is updated, because the resize tool affects more than the selected div I have for now disabled access until I develop the system which updates data between modules.', '2013-11-27 15:18:25', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (115, 'History of Dlayer split out from the What is Dlayer? page.', '2013-11-29 02:12:14', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (116, 'Base modifier system in place, this is called when there needs to be interaction between modules, if a user changes something in one module that affects data in another module modifiers can be sent requests to check to see if any changes are required and then make them if necessary.', '2013-12-01 02:27:30', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (117, 'Border tool re-instated in the template designer when a user chooses to work on a template block which has content applied to it on a page based upon the current template. A change width modifier has been added, this modifier checks all the content items to see if the widths for the containers need to be updated (The width of a page div will change if a border is added, edited or removed on a  template block). ', '2013-12-01 02:27:40', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (118, 'Dlayer - Release 5 - Modifier system, password tool in form builder, new settings for form builder, template designer tool restrictions and general tweaks.', '2013-12-01 12:24:18', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (119, 'Abstract validate and autoValidate methods moved from base tool class down a level into the base module tool class, additional context data will be needed for validations and it will differ by module.', '2013-12-02 17:09:17', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (120, 'Container for text content can now no be larger that the page block it is being added to.', '2013-12-02 17:23:46', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (121, 'Base font family settings set for the content manager and form builder now used in the designers.', '2013-12-04 02:14:51', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (122, 'Dlayer - Release 6 -  Minor release, validation, settings and general small fixes.', '2013-12-04 02:15:23', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (123, 'Added width and left margin to heading content type, width and left padding when summed can be no larger than the containing page block.', '2013-12-13 14:53:05', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (124, 'Added a container div around content items in the content designer, js hover and click events moved to the parent container item, this is so that the movement controls will only show for each content item on hover.', '2013-12-18 16:22:43', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (125, 'Movement controls added to content items, not yet active.', '2013-12-21 21:12:43', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (126, 'Content items in the content manager can now be moved around, the user needs to select the page block then as they hover over the content items up and down movement links appear.', '2013-12-23 12:30:41', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (127, 'Dlayer - Release 7 - Minor release, content items can be moved and heading content item updated.', '2013-12-23 12:32:08', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (128, 'Removed the mode switching buttons, don''t really do anything yet, also, not sure where to add them in the new designer yet.', '2014-01-12 11:10:16', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (129, 'Updated the styling in the template designer, matches the new design.', '2014-01-14 11:31:16', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (130, 'Modified the base width of the app, now 1366 pixels, this will match the Windows 8 version of Dlayer when developed. All the base pages have been updated along with the setting sections.', '2014-01-10 14:17:40', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (131, 'Expand and Contract options for resize tool now no longer shows the options that can''t be used for the selected block, previously all options were shown and the form button was disabled if not relevant. The ribbon has been moved to the right hand side below the tool buttons, no longer pushes the design down.', '2014-01-15 01:03:54', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (132, 'Updated the styling in the content manager, matches the new design.', '2014-01-15 01:22:00', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (133, 'Updated the styling in the form builder, matches the new design.', '2014-01-16 00:14:18', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (134, 'Fixed the content manager heading tool, the left margin value wasn''t being passed through in the post data array, this was causing the validate method to return FALSE and the tool to never process correctly. The heading tool now checks the size of the page block it is being added, this is done so that sensible defaults can be calculated and to ensure that a user can''t add a heading container which is larger than the page block.', '2014-01-17 15:10:25', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (135, 'When I resized the designers I realised I had sinned, the width and heights were defaulted within the code, now corrected, there is no such thing as a value that won''t need to be changed at some point during the projects life.', '2014-01-17 15:24:09', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (136, 'Reworked the toolbar panels, now only show tools when relevant, the selected tool is clearer and styling has been updated. Tool options styling has been simplified, forms are now clearer.', '2014-01-19 00:54:04', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (137, 'Top menu updated to show state.', '2014-01-19 01:35:16', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (138, 'Add new site wasn''t creating three default palettes for the user, later users will be able to define their own palettes during create site or modify the default palettes.', '2014-01-19 16:18:05', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (139, 'Adding a new website now inserts initial values for the content manager heading styles, can be updated by the user in the settings.', '2014-01-19 19:49:50', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (140, 'Adding a new website now inserts initial values for the base font family to use in the content manager and form builder.', '2014-01-19 20:50:07', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (141, 'If there is no data for a new user a sample site is created, three colour palettes are created and default values are set for the heading styles and base font family settings. Pages, templates and forms are not created, when the designers are more functional there will be sample templates, forms and pages for the sampkle site.', '2014-01-20 15:36:40', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (142, 'Dlayer - Release 8 - New release, new cleaner design for all the designers, bugs fixes and tweaks.', '2014-01-20 15:37:34', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (143, 'Database work to support allowing a form to be imported as a content item.', '2014-01-20 22:16:01', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (144, 'Updated ''What is Dlayer?'' page.', '2014-01-21 01:20:54', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (145, 'Minor style and content changes.', '2014-01-22 00:33:56', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (146, 'Additional base development to allow forms to be added a content item.', '2014-01-24 00:34:24', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (147, 'Dlayer - Release 9 - Minor release, contains the base code which I will build to allow forms to be added as content items in the form builder.', '2014-01-24 00:37:35', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (148, 'Custom option for background color now allows the user to choose a color using the HTML5 color picker.', '2014-01-24 16:06:27', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (149, 'Upgraded the tool controls in the template design, now using HTML5 elements where appropriate.', '2014-01-24 16:12:42', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (150, 'Upgraded the tool controls in the content manager and form builder, now also using HTML5 elements where appropriate.', '2014-01-24 16:46:53', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (151, 'Updated the content manager heading style setting forms, now use HTML5 elements where appropriate.', '2014-01-24 16:56:28', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (152, 'Dlayer - Release 10 - Minor release, added custom option for back colour in the template designer and switched a few form elements over to HTML5', '2014-01-25 00:58:06', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (153, 'Dlayer - Release 11 - Minor release, housekeeping', '2014-01-25 16:54:44', 1, 1);
INSERT INTO `dlayer_development_log` VALUES (154, 'Added ability to define placeholder text for text, text area and password tools in the Form builder.', '2014-01-25 22:12:15', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (155, 'Styling updates, also added another font family to the base font family settings.', '2014-01-26 17:12:32', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (156, 'Reworked the settings pages, now possible to jump between modules without having the leave the settings section.', '2014-01-27 01:30:01', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (157, 'Added a footer to the app, provides access to development log and development plan when in the designers.', '2014-01-27 01:48:12', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (158, 'Import form tool added to tool bar and relevant entries added to database, data form not yet in place.', '2014-01-27 02:15:14', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (159, 'Show identity (email) on menu bar to assist users that use more than one account.', '2014-01-28 01:16:44', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (160, 'Inputs all displays for the import form tool.', '2014-01-28 01:35:20', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (161, 'Updated the definition for the module session reset methods, wasn''t completely clear about what would be cleared. Initial validation in place for import form tool, doesn''t yet calculate and approximate width for a form and whether it will fit in the page block, that will be added later.', '2014-01-29 16:32:05', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (162, 'Development plan now shows progress messages.', '2014-01-29 16:45:21', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (163, 'Import form tool in content manager allows user to add form as a content item, not yet rendered in the designer or or editable.', '2014-01-30 00:50:55', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (164, 'Content manager design view now shows the imported form, styling is not working correctly.', '2014-01-30 21:29:25', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (165, 'Added ability to move form content items around in the content manager, same movement controls as text and heading content items.', '2014-01-31 16:13:22', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (166, 'Updated select and move js, with earlier tools, content type and tool where the same, that changed with the import form tool.', '2014-01-31 20:34:31', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (167, 'Updated process controller in content manager, needed to stop using tool for processing, no longer always going to match the content type so need separate vars.', '2014-02-01 16:25:06', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (168, 'Added ability to edit the details for the selected form in the content manager.', '2014-02-01 16:29:02', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (169, 'Updated container width modifier, now looks at form content items.', '2014-02-01 22:19:27', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (170, 'Added a page for known bugs.', '2014-02-01 22:32:53', 0, 1);
INSERT INTO `dlayer_development_log` VALUES (171, 'Major milestone release, three modules are now communicating with each other, the Template designer, Form builder and Content manager. The import form tool is now in place, a form can be added as a content item. All forms retain their links with the Form builder so changes are shown immediately.', '2014-02-01 22:56:51', 1, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `dlayer_identities`
-- 

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `dlayer_identities`
-- 

INSERT INTO `dlayer_identities` VALUES (1, 'user-1@dlayer.com', '$6$rounds=5000$jks453yuyt55d$CZJCjaieFQghQ6MwQ1OUI5nVKDy/Fi2YXk7MyW2hcex9AdJ/jvZA8ulvjzK1lo3rRVFfmd10lgjqAbDQM4ehR1', 0, '2014-02-11 23:32:41', '2014-02-11 23:41:01', 1);
INSERT INTO `dlayer_identities` VALUES (2, 'user-2@dlayer.com', '$6$rounds=5000$jks453yuyt55d$ZVEJgs2kNjxOxNEayqqoh2oJUiGbmxIKRqOTxVM05MP2YRcAjE9adCZfQBWCc.qe1nDjEM9.ioivNz3c/qyZ80', 0, '2014-02-07 02:39:53', '2014-02-07 02:40:10', 1);
INSERT INTO `dlayer_identities` VALUES (3, 'user-3@dlayer.com', '$6$rounds=5000$jks453yuyt55d$NYF6yCvxXplefx7nr8vDe4cUGBEFtd3G5vuJ2utfqvPwEf3dSgNXNTcGbFO6WrJSn21CXHgZwNOQHy691E/Rm.', 0, '2014-02-07 02:40:20', '2014-02-07 02:40:35', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `dlayer_module_tool_tabs`
-- 

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
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

-- 
-- Dumping data for table `dlayer_module_tool_tabs`
-- 

INSERT INTO `dlayer_module_tool_tabs` VALUES (1, 1, 2, 'Quick', 'quick', 0, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (2, 1, 2, 'Mouse', 'advanced', 0, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (3, 1, 2, 'Help', 'help', 0, 0, 3, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (4, 1, 3, 'Quick', 'quick', 0, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (5, 1, 3, 'Mouse', 'advanced', 0, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (6, 1, 3, 'Help', 'help', 0, 0, 3, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (7, 1, 7, '#1', 'palette-1', 0, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (8, 1, 7, '#2', 'palette-2', 0, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (9, 1, 7, '#3', 'palette-3', 0, 0, 3, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (10, 1, 7, 'Custom', 'advanced', 0, 0, 4, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (11, 1, 7, 'Help', 'help', 0, 0, 5, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (12, 1, 6, 'Custom', 'advanced', 1, 0, 4, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (14, 1, 6, 'Help', 'help', 0, 0, 5, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (15, 1, 6, 'Expand', 'expand', 1, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (16, 1, 6, 'Contract', 'contract', 1, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (17, 1, 6, 'Height', 'height', 1, 0, 3, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (20, 1, 8, 'Custom', 'advanced', 1, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (21, 1, 8, 'Help', 'help', 0, 0, 3, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (22, 1, 8, 'Full border', 'full', 0, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (23, 4, 10, 'Text', 'text', 1, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (24, 4, 11, 'Heading', 'heading', 1, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (25, 4, 10, 'Help', 'help', 0, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (26, 4, 11, 'Help', 'help', 0, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (27, 3, 12, 'Text', 'text', 0, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (28, 3, 12, 'Help', 'help', 0, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (29, 3, 13, 'Text area', 'textarea', 0, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (30, 3, 13, 'Help', 'help', 0, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (31, 3, 15, 'Password', 'password', 1, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (32, 3, 15, 'Help', 'help', 0, 0, 2, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (33, 4, 16, 'Import form', 'import-form', 1, 1, 1, 1);
INSERT INTO `dlayer_module_tool_tabs` VALUES (34, 4, 16, 'Help', 'help', 0, 0, 2, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `dlayer_module_tools`
-- 

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
  KEY `destructive` (`destructive`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `dlayer_module_tools`
-- 

INSERT INTO `dlayer_module_tools` VALUES (1, 1, 'Cancel', 'cancel', NULL, 'cancel', 'cancel.png', 1, 0, 1, 1, 1);
INSERT INTO `dlayer_module_tools` VALUES (2, 1, 'Split horizontal', 'split-horizontal', 'SplitHorizontal', 'split-horizontal', 'split-horizontal.png', 1, 1, 2, 1, 1);
INSERT INTO `dlayer_module_tools` VALUES (3, 1, 'Split vertical', 'split-vertical', 'SplitVertical', 'split-vertical', 'split-vertical.png', 1, 1, 2, 2, 1);
INSERT INTO `dlayer_module_tools` VALUES (6, 1, 'Resize', 'resize', 'Resize', 'resize', 'resize.png', 0, 1, 2, 3, 1);
INSERT INTO `dlayer_module_tools` VALUES (7, 1, 'Background color', 'background-color', 'BackgroundColor', 'background-color', 'background-color.png', 1, 0, 3, 1, 1);
INSERT INTO `dlayer_module_tools` VALUES (8, 1, 'Border', 'border', 'Border', 'border', 'border.png', 0, 0, 3, 2, 1);
INSERT INTO `dlayer_module_tools` VALUES (9, 4, 'Cancel', 'cancel', NULL, 'cancel', 'cancel.png', 1, 0, 1, 1, 1);
INSERT INTO `dlayer_module_tools` VALUES (10, 4, 'Text', 'text', 'Text', 'text', 'text.png', 0, 0, 2, 2, 1);
INSERT INTO `dlayer_module_tools` VALUES (11, 4, 'Heading', 'heading', 'Heading', 'heading', 'heading.png', 0, 0, 2, 1, 1);
INSERT INTO `dlayer_module_tools` VALUES (12, 3, 'Text', 'text', 'Text', 'text', 'text.png', 0, 0, 2, 1, 1);
INSERT INTO `dlayer_module_tools` VALUES (13, 3, 'Text area', 'textarea', 'Textarea', 'textarea', 'textarea.png', 0, 0, 2, 2, 1);
INSERT INTO `dlayer_module_tools` VALUES (14, 3, 'Cancel', 'cancel', NULL, 'cancel', 'cancel.png', 1, 0, 1, 1, 1);
INSERT INTO `dlayer_module_tools` VALUES (15, 3, 'Password', 'password', 'Password', 'password', 'password.png', 1, 0, 2, 3, 1);
INSERT INTO `dlayer_module_tools` VALUES (16, 4, 'Import form', 'import-form', 'ImportForm', 'import-form', 'import-form.png', 0, 0, 3, 1, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `dlayer_modules`
-- 

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `dlayer_modules`
-- 

INSERT INTO `dlayer_modules` VALUES (1, 'template', 'Template', 'Template designer', 'Create and manage the templates for your site.', 'template.png', 1, 1);
INSERT INTO `dlayer_modules` VALUES (2, 'widget', 'Widget', 'Widget designer', 'Create and manage your reusable and dynamic blocks. Using the widget designer you create either static or dynamic reusable blocks. If there is an elements or function that you need to appear on multiple pages it should probably be a widget.', 'widget.png', 4, 0);
INSERT INTO `dlayer_modules` VALUES (3, 'form', 'Forms', 'Form builder', 'Create and manage the forms for your site.', 'form.png', 3, 1);
INSERT INTO `dlayer_modules` VALUES (4, 'content', 'Content', 'Content manager', 'Create and manage the site content.', 'content.png', 2, 1);
INSERT INTO `dlayer_modules` VALUES (5, 'website', 'Website', 'Website manager', 'Create the structure and relationships between the pages in your site, you also manage the site data that can be used by your dynamic widgets, for example a menu or gallery.', 'website.png', 5, 0);
INSERT INTO `dlayer_modules` VALUES (6, 'question', 'Question', 'Question manager', 'Create quizzes, tests and polls, system supports multiple pages, multiple questions types, for example text, image, video and multiple answer types, free text, multiple choice, true or false. Results are summed and calculated and can either be displayed or stored for just the administrator.', 'question.png', 5, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `dlayer_sessions`
-- 

CREATE TABLE `dlayer_sessions` (
  `session_id` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `save_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modified` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `session_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`session_id`,`save_path`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `dlayer_sessions`
-- 

INSERT INTO `dlayer_sessions` VALUES ('043ae99656c3072b7ba81fe06f1a3df5', '/tmp', 'PHPSESSID', 1392204119, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392207719;}}');
INSERT INTO `dlayer_sessions` VALUES ('08105b9cc6236c8e9d05915ec9535d66', '/tmp', 'PHPSESSID', 1392240292, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392243892;}}');
INSERT INTO `dlayer_sessions` VALUES ('10c6d92714ad3c6ee91661022e0e43bf', '/tmp', 'PHPSESSID', 1392265694, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392269294;}}');
INSERT INTO `dlayer_sessions` VALUES ('13625d0b96a579a0ace8c613919de489', '/tmp', 'PHPSESSID', 1392289605, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392293205;}}');
INSERT INTO `dlayer_sessions` VALUES ('171bc327b3a5eec7d374bee7e1460f31', '/tmp', 'PHPSESSID', 1392236090, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392239690;}}');
INSERT INTO `dlayer_sessions` VALUES ('1a81ce22594c9487e5201063f781bc04', '/tmp', 'PHPSESSID', 1392171896, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392175496;}}');
INSERT INTO `dlayer_sessions` VALUES ('1e259136e2cd968b66eddfc2127c07bc', '/tmp', 'PHPSESSID', 1392318532, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392322132;}}');
INSERT INTO `dlayer_sessions` VALUES ('20122595271b597feb3a3f16d09de74d', '/tmp', 'PHPSESSID', 1392361798, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392365398;}}');
INSERT INTO `dlayer_sessions` VALUES ('279a3893ebbe0db2342b37a597054986', '/tmp', 'PHPSESSID', 1392246405, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392250005;}}');
INSERT INTO `dlayer_sessions` VALUES ('32e4ceb0a22d946d3476ddf299885f5a', '/tmp', 'PHPSESSID', 1392170927, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392174527;}}');
INSERT INTO `dlayer_sessions` VALUES ('366e1548760f7d9bdd42db7e06d136ef', '/tmp', 'PHPSESSID', 1392365594, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392369194;}}');
INSERT INTO `dlayer_sessions` VALUES ('372e9f331133fbbbbef2107ff39a9b02', '/tmp', 'PHPSESSID', 1392275043, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392278643;}}');
INSERT INTO `dlayer_sessions` VALUES ('39c39cba054978b89b4045eafe727436', '/tmp', 'PHPSESSID', 1392210673, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392214273;}}');
INSERT INTO `dlayer_sessions` VALUES ('3ccc14e1f2be8184bf7054a2ed9f4372', '/tmp', 'PHPSESSID', 1392314738, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392318338;}}');
INSERT INTO `dlayer_sessions` VALUES ('3d0d37ce352687cd2dae65c2cb2caa01', '/tmp', 'PHPSESSID', 1392254384, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392257984;}}');
INSERT INTO `dlayer_sessions` VALUES ('3f15830512e5086bf9c0f0f4fbbf3138', '/tmp', 'PHPSESSID', 1392204227, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392207827;}}');
INSERT INTO `dlayer_sessions` VALUES ('42dbc5b92cf0f29bee5c7df196acf9d9', '/tmp', 'PHPSESSID', 1392276071, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392279671;}}');
INSERT INTO `dlayer_sessions` VALUES ('43eb615da45b61822b0485bfd581bc14', '/tmp', 'PHPSESSID', 1392157513, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392161113;}}');
INSERT INTO `dlayer_sessions` VALUES ('4692eab299fb395c80c90d3213b272ba', '/tmp', 'PHPSESSID', 1392268183, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392271783;}}');
INSERT INTO `dlayer_sessions` VALUES ('4815d1a60b65b93220f1a4cd54b97caa', '/tmp', 'PHPSESSID', 1392214275, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392217875;}}');
INSERT INTO `dlayer_sessions` VALUES ('511287412b635e0dcd05ee656e06d523', '/tmp', 'PHPSESSID', 1392307437, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392311037;}}');
INSERT INTO `dlayer_sessions` VALUES ('53fe862e49a62eac13cf25eee03f97f8', '/tmp', 'PHPSESSID', 1392323416, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392327016;}}');
INSERT INTO `dlayer_sessions` VALUES ('54b458c98ce54f9c4e414f3dd2e4a1e6', '/tmp', 'PHPSESSID', 1392318608, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392322208;}}');
INSERT INTO `dlayer_sessions` VALUES ('54bd3e4c02d1822fec40b9d1ecfe15e9', '/tmp', 'PHPSESSID', 1392179837, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392183437;}}');
INSERT INTO `dlayer_sessions` VALUES ('5b9b7938143e1d6b43d9345b59afbfaa', '/tmp', 'PHPSESSID', 1392202848, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392206448;}}');
INSERT INTO `dlayer_sessions` VALUES ('6380b29ab5fb41f388f7382926419219', '/tmp', 'PHPSESSID', 1392246525, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392250125;}}');
INSERT INTO `dlayer_sessions` VALUES ('6666f3ec8af55554b5d31a47ab18206f', '/tmp', 'PHPSESSID', 1392362894, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392366494;}}');
INSERT INTO `dlayer_sessions` VALUES ('67571934adf6572ef1159d6d44be6b7a', '/tmp', 'PHPSESSID', 1392169481, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392173081;}}');
INSERT INTO `dlayer_sessions` VALUES ('6c7ad6b04977fa7f39d0bb9681000a37', '/tmp', 'PHPSESSID', 1392335171, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392338771;}}');
INSERT INTO `dlayer_sessions` VALUES ('6fa6158b557388e12e80952d3e6871ff', '/tmp', 'PHPSESSID', 1392320128, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392323728;}}');
INSERT INTO `dlayer_sessions` VALUES ('7059017ced7cea5a236a359728c7e2fa', '/tmp', 'PHPSESSID', 1392210596, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392214196;}}');
INSERT INTO `dlayer_sessions` VALUES ('7292a89d3f027c70cc69c63ecf2d509e', '/tmp', 'PHPSESSID', 1392246454, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392250054;}}');
INSERT INTO `dlayer_sessions` VALUES ('73a1d684f0b44f548d3d1913c2bc5b46', '/tmp', 'PHPSESSID', 1392363895, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392367495;}}');
INSERT INTO `dlayer_sessions` VALUES ('74a14e4cf504c38590810d052276ff8c', '/tmp', 'PHPSESSID', 1392297246, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392300846;}}');
INSERT INTO `dlayer_sessions` VALUES ('769dd09876e44967c5f7ea5cdb069d90', '/tmp', 'PHPSESSID', 1392350765, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392354365;}}');
INSERT INTO `dlayer_sessions` VALUES ('7711b89ef9ed64bc7eb8ac1d2b673746', '/tmp', 'PHPSESSID', 1392289672, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392293272;}}');
INSERT INTO `dlayer_sessions` VALUES ('7aafdd06835fbcce17b146846fbca3fc', '/tmp', 'PHPSESSID', 1392368974, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392372574;}}');
INSERT INTO `dlayer_sessions` VALUES ('7d892da880eb97c8766c3d7bf7bb90b2', '/tmp', 'PHPSESSID', 1392197609, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392201209;}}');
INSERT INTO `dlayer_sessions` VALUES ('8036440cab1b65907fca757b5b20e361', '/tmp', 'PHPSESSID', 1392275047, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392278647;}}');
INSERT INTO `dlayer_sessions` VALUES ('8067511a84d0cad13dbe1afa1f8ae1d6', '/tmp', 'PHPSESSID', 1392268258, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392271858;}}');
INSERT INTO `dlayer_sessions` VALUES ('87b74abf4ffaab0a1dd5157bf2987b14', '/tmp', 'PHPSESSID', 1392163335, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392166935;}}');
INSERT INTO `dlayer_sessions` VALUES ('889d1b86a92f7e6f58a637c185ed9e19', '/tmp', 'PHPSESSID', 1392275047, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392278647;}}');
INSERT INTO `dlayer_sessions` VALUES ('8cea1549d91649849f33b53035b5d5f9', '/tmp', 'PHPSESSID', 1392265947, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392269547;}}');
INSERT INTO `dlayer_sessions` VALUES ('8d3919ec694c314c22dccaa80aebac01', '/tmp', 'PHPSESSID', 1392351255, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392354855;}}');
INSERT INTO `dlayer_sessions` VALUES ('8e4e040ee46bf12d9a08cee6dc6f52dc', '/tmp', 'PHPSESSID', 1392355200, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392358800;}}');
INSERT INTO `dlayer_sessions` VALUES ('8eb7775bad1efd9cda4f24f110b9149f', '/tmp', 'PHPSESSID', 1392350016, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392353616;}}');
INSERT INTO `dlayer_sessions` VALUES ('9270bcb51124c824b0f39368b3a93b0f', '/tmp', 'PHPSESSID', 1392232876, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392236476;}}');
INSERT INTO `dlayer_sessions` VALUES ('96af61a4f73de131b2600c9b8c4d8ca3', '/tmp', 'PHPSESSID', 1392167816, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392171416;}}');
INSERT INTO `dlayer_sessions` VALUES ('96d8e89de514aaa536fd012dfb43a50d', '/tmp', 'PHPSESSID', 1392304286, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392307886;}}');
INSERT INTO `dlayer_sessions` VALUES ('9780719ece36c7431edc10c2ab6e8997', '/tmp', 'PHPSESSID', 1392310775, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392314375;}}');
INSERT INTO `dlayer_sessions` VALUES ('9f8c58bed99e0560894e967284aafad9', '/tmp', 'PHPSESSID', 1392375080, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392378680;}}');
INSERT INTO `dlayer_sessions` VALUES ('a29276de06453acb18ad3c503e0a5156', '/tmp', 'PHPSESSID', 1392160077, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392163677;}}');
INSERT INTO `dlayer_sessions` VALUES ('a4a1f40b844363896d51f1845b4c3288', '/tmp', 'PHPSESSID', 1392282876, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392286476;}}');
INSERT INTO `dlayer_sessions` VALUES ('a541806566d72c8f305db58aa16eacb3', '/tmp', 'PHPSESSID', 1392355306, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392358906;}}');
INSERT INTO `dlayer_sessions` VALUES ('a8ed6234b2a93b1ae25aea1df4287c37', '/tmp', 'PHPSESSID', 1392189961, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392193561;}}');
INSERT INTO `dlayer_sessions` VALUES ('ab5a1218b1fa7d5ea5eb346b554043cf', '/tmp', 'PHPSESSID', 1392225633, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392229233;}}');
INSERT INTO `dlayer_sessions` VALUES ('ae8a12fa975d7dd86b4d79b109776e89', '/tmp', 'PHPSESSID', 1392240351, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392243951;}}');
INSERT INTO `dlayer_sessions` VALUES ('b002fdaf5a72225025fb11f17e084038', '/tmp', 'PHPSESSID', 1392271572, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392275172;}}');
INSERT INTO `dlayer_sessions` VALUES ('b27cd299184aff81bbe244cf9bef7d04', '/tmp', 'PHPSESSID', 1392232771, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392236371;}}');
INSERT INTO `dlayer_sessions` VALUES ('b34ccb458681673676c1bde1796fb072', '/tmp', 'PHPSESSID', 1392275044, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392278644;}}');
INSERT INTO `dlayer_sessions` VALUES ('b55cff7b5eca674e10c490605c348339', '/tmp', 'PHPSESSID', 1392263076, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392266676;}}');
INSERT INTO `dlayer_sessions` VALUES ('b809c0c6d26364d7ab27cdaa6dc01845', '/tmp', 'PHPSESSID', 1392368901, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392372501;}}');
INSERT INTO `dlayer_sessions` VALUES ('bd7fde4b278c1c59d6bfc73b6ab4b22e', '/tmp', 'PHPSESSID', 1392201764, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392205364;}}');
INSERT INTO `dlayer_sessions` VALUES ('c13e0cb7f7d124b5a203002c33883f37', '/tmp', 'PHPSESSID', 1392319954, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392323554;}}');
INSERT INTO `dlayer_sessions` VALUES ('c64d7f82c9a5ffe28fb409bf68e540b4', '/tmp', 'PHPSESSID', 1392312710, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392316310;}}');
INSERT INTO `dlayer_sessions` VALUES ('ccb87ed84b376b29272ebfa63f92031f', '/tmp', 'PHPSESSID', 1392158461, 3601, '__ZF|a:4:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392162061;}s:23:"dlayer_session_template";a:1:{s:3:"ENT";i:1392162061;}s:22:"dlayer_session_content";a:1:{s:3:"ENT";i:1392162012;}s:19:"dlayer_session_form";a:1:{s:3:"ENT";i:1392161722;}}dlayer_session|a:3:{s:11:"identity_id";s:1:"1";s:7:"site_id";s:1:"1";s:6:"module";s:8:"template";}dlayer_session_template|a:6:{s:11:"template_id";i:4;s:4:"tool";N;s:6:"div_id";s:2:"16";s:10:"tool_model";s:15:"BackgroundColor";s:16:"tool_destructive";s:1:"0";s:3:"tab";N;}dlayer_session_form|a:1:{s:7:"form_id";N;}dlayer_session_content|a:7:{s:7:"page_id";s:1:"4";s:6:"div_id";s:2:"15";s:10:"content_id";N;s:4:"tool";N;s:3:"tab";N;s:11:"template_id";s:1:"4";s:10:"tool_model";s:4:"Text";}');
INSERT INTO `dlayer_sessions` VALUES ('d14889bf598f376624ea7ec40d945864', '/tmp', 'PHPSESSID', 1392233495, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392237095;}}');
INSERT INTO `dlayer_sessions` VALUES ('d38ccd747cde0deae78eb37ec3e4e801', '/tmp', 'PHPSESSID', 1392275969, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392279569;}}');
INSERT INTO `dlayer_sessions` VALUES ('d6d0e9a461e5df38c2be244214ccd009', '/tmp', 'PHPSESSID', 1392318357, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392321957;}}');
INSERT INTO `dlayer_sessions` VALUES ('d726c995409c02a936b71eb42bc146e2', '/tmp', 'PHPSESSID', 1392303921, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392307521;}}');
INSERT INTO `dlayer_sessions` VALUES ('d8075501f04940efa6387040e6d7f09a', '/tmp', 'PHPSESSID', 1392157872, 3601, '__ZF|a:4:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392161472;}s:23:"dlayer_session_template";a:1:{s:3:"ENT";i:1392161471;}s:22:"dlayer_session_content";a:1:{s:3:"ENT";i:1392161471;}s:19:"dlayer_session_form";a:1:{s:3:"ENT";i:1392161471;}}dlayer_session_template|a:6:{s:11:"template_id";N;s:6:"div_id";N;s:4:"tool";N;s:3:"tab";N;s:10:"tool_model";s:6:"Border";s:16:"tool_destructive";s:1:"0";}dlayer_session_form|a:5:{s:7:"form_id";N;s:8:"field_id";N;s:4:"tool";N;s:3:"tab";N;s:10:"tool_model";s:8:"Textarea";}dlayer_session_content|a:7:{s:7:"page_id";N;s:6:"div_id";N;s:10:"content_id";N;s:4:"tool";N;s:3:"tab";N;s:11:"template_id";N;s:10:"tool_model";s:4:"Text";}');
INSERT INTO `dlayer_sessions` VALUES ('d9adbc23f052b6f119cb6e30596c3440', '/tmp', 'PHPSESSID', 1392254491, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392258091;}}');
INSERT INTO `dlayer_sessions` VALUES ('ded0e00c6ae2197bc60ea73d325edb55', '/tmp', 'PHPSESSID', 1392160006, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392163606;}}');
INSERT INTO `dlayer_sessions` VALUES ('e69d75edf31cd9e1ee91eff8f9978e34', '/tmp', 'PHPSESSID', 1392198521, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392202121;}}');
INSERT INTO `dlayer_sessions` VALUES ('f3d11822105ddf53ea805e4a66ba93f0', '/tmp', 'PHPSESSID', 1392314169, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392317769;}}');
INSERT INTO `dlayer_sessions` VALUES ('f44ac1cef0bb59f8e59b486aca937cb1', '/tmp', 'PHPSESSID', 1392374417, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392378017;}}');
INSERT INTO `dlayer_sessions` VALUES ('ffb82abc0a35250046e5c04450269da8', '/tmp', 'PHPSESSID', 1392189812, 3601, '__ZF|a:1:{s:14:"dlayer_session";a:1:{s:3:"ENT";i:1392193412;}}');

-- --------------------------------------------------------

-- 
-- Table structure for table `form_field_attribute_types`
-- 

CREATE TABLE `form_field_attribute_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `form_field_attribute_types`
-- 

INSERT INTO `form_field_attribute_types` VALUES (1, 'Integer', 'integer');
INSERT INTO `form_field_attribute_types` VALUES (2, 'String', 'string');

-- --------------------------------------------------------

-- 
-- Table structure for table `form_field_attributes`
-- 

CREATE TABLE `form_field_attributes` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attribute` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attribute_type_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field_type_id` (`field_type_id`),
  KEY `attribute_type_id` (`attribute_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `form_field_attributes`
-- 

INSERT INTO `form_field_attributes` VALUES (1, 1, 'Size', 'size', 1);
INSERT INTO `form_field_attributes` VALUES (2, 1, 'Max length', 'maxlength', 1);
INSERT INTO `form_field_attributes` VALUES (3, 2, 'Columns', 'cols', 1);
INSERT INTO `form_field_attributes` VALUES (4, 2, 'Rows', 'rows', 1);
INSERT INTO `form_field_attributes` VALUES (5, 3, 'Size', 'size', 1);
INSERT INTO `form_field_attributes` VALUES (6, 3, 'Max length', 'maxlength', 1);
INSERT INTO `form_field_attributes` VALUES (7, 1, 'Placeholder', 'placeholder', 2);
INSERT INTO `form_field_attributes` VALUES (8, 2, 'Placeholder', 'placeholder', 2);
INSERT INTO `form_field_attributes` VALUES (9, 3, 'Placeholder', 'placeholder', 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `form_field_types`
-- 

CREATE TABLE `form_field_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `form_field_types`
-- 

INSERT INTO `form_field_types` VALUES (1, 'Test', 'text', 'A single line input');
INSERT INTO `form_field_types` VALUES (2, 'Textarea', 'textarea', 'A multiple line input');
INSERT INTO `form_field_types` VALUES (3, 'Password', 'password', 'A password input');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_settings_color_palette_colors`
-- 

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
  KEY `color_type_id` (`color_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

-- 
-- Dumping data for table `user_settings_color_palette_colors`
-- 

INSERT INTO `user_settings_color_palette_colors` VALUES (1, 1, 1, 1, 'Black', '#000000');
INSERT INTO `user_settings_color_palette_colors` VALUES (2, 1, 1, 2, 'Tan', '#f3f1df');
INSERT INTO `user_settings_color_palette_colors` VALUES (3, 1, 1, 3, 'Dark grey', '#666666');
INSERT INTO `user_settings_color_palette_colors` VALUES (4, 1, 2, 1, 'Blue', '#336699');
INSERT INTO `user_settings_color_palette_colors` VALUES (5, 1, 2, 2, 'Dark grey', '#666666');
INSERT INTO `user_settings_color_palette_colors` VALUES (6, 1, 2, 3, 'Grey', '#999999');
INSERT INTO `user_settings_color_palette_colors` VALUES (7, 1, 3, 1, 'Blue', '#003366');
INSERT INTO `user_settings_color_palette_colors` VALUES (8, 1, 3, 2, 'White', '#666666');
INSERT INTO `user_settings_color_palette_colors` VALUES (9, 1, 3, 3, 'Orange', '#FF6600');
INSERT INTO `user_settings_color_palette_colors` VALUES (10, 2, 4, 1, 'Black', '#000000');
INSERT INTO `user_settings_color_palette_colors` VALUES (11, 2, 4, 2, 'Tan', '#f3f1df');
INSERT INTO `user_settings_color_palette_colors` VALUES (12, 2, 4, 3, 'Dark grey', '#666666');
INSERT INTO `user_settings_color_palette_colors` VALUES (13, 2, 5, 1, 'Blue', '#336699');
INSERT INTO `user_settings_color_palette_colors` VALUES (14, 2, 5, 2, 'Dark grey', '#666666');
INSERT INTO `user_settings_color_palette_colors` VALUES (15, 2, 5, 3, 'Grey', '#999999');
INSERT INTO `user_settings_color_palette_colors` VALUES (16, 2, 6, 1, 'Blue', '#003366');
INSERT INTO `user_settings_color_palette_colors` VALUES (17, 2, 6, 2, 'White', '#666666');
INSERT INTO `user_settings_color_palette_colors` VALUES (18, 2, 6, 3, 'Orange', '#FF6600');
INSERT INTO `user_settings_color_palette_colors` VALUES (19, 3, 7, 1, 'Black', '#000000');
INSERT INTO `user_settings_color_palette_colors` VALUES (20, 3, 7, 2, 'Tan', '#f3f1df');
INSERT INTO `user_settings_color_palette_colors` VALUES (21, 3, 7, 3, 'Dark grey', '#666666');
INSERT INTO `user_settings_color_palette_colors` VALUES (22, 3, 8, 1, 'Blue', '#336699');
INSERT INTO `user_settings_color_palette_colors` VALUES (23, 3, 8, 2, 'Dark grey', '#666666');
INSERT INTO `user_settings_color_palette_colors` VALUES (24, 3, 8, 3, 'Grey', '#999999');
INSERT INTO `user_settings_color_palette_colors` VALUES (25, 3, 9, 1, 'Blue', '#003366');
INSERT INTO `user_settings_color_palette_colors` VALUES (26, 3, 9, 2, 'White', '#666666');
INSERT INTO `user_settings_color_palette_colors` VALUES (27, 3, 9, 3, 'Orange', '#FF6600');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_settings_color_palettes`
-- 

CREATE TABLE `user_settings_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `view_script` char(9) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `view_script` (`view_script`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `user_settings_color_palettes`
-- 

INSERT INTO `user_settings_color_palettes` VALUES (1, 1, 'Palette 1', 'palette-1', 1);
INSERT INTO `user_settings_color_palettes` VALUES (2, 1, 'Palette 2', 'palette-2', 2);
INSERT INTO `user_settings_color_palettes` VALUES (3, 1, 'Palette 3', 'palette-3', 3);
INSERT INTO `user_settings_color_palettes` VALUES (4, 2, 'Palette 1', 'palette-1', 1);
INSERT INTO `user_settings_color_palettes` VALUES (5, 2, 'Palette 2', 'palette-2', 2);
INSERT INTO `user_settings_color_palettes` VALUES (6, 2, 'Palette 3', 'palette-3', 3);
INSERT INTO `user_settings_color_palettes` VALUES (7, 3, 'Palette 1', 'palette-1', 1);
INSERT INTO `user_settings_color_palettes` VALUES (8, 3, 'Palette 2', 'palette-2', 2);
INSERT INTO `user_settings_color_palettes` VALUES (9, 3, 'Palette 3', 'palette-3', 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_settings_font_families`
-- 

CREATE TABLE `user_settings_font_families` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `module_id` tinyint(3) unsigned NOT NULL,
  `font_family_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `module_id` (`module_id`),
  KEY `font_family_id` (`font_family_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `user_settings_font_families`
-- 

INSERT INTO `user_settings_font_families` VALUES (1, 1, 3, 8);
INSERT INTO `user_settings_font_families` VALUES (2, 1, 4, 1);
INSERT INTO `user_settings_font_families` VALUES (3, 2, 3, 1);
INSERT INTO `user_settings_font_families` VALUES (4, 2, 4, 1);
INSERT INTO `user_settings_font_families` VALUES (5, 3, 3, 1);
INSERT INTO `user_settings_font_families` VALUES (6, 3, 4, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_settings_headings`
-- 

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
  KEY `heading_id` (`heading_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

-- 
-- Dumping data for table `user_settings_headings`
-- 

INSERT INTO `user_settings_headings` VALUES (1, 1, 1, 1, 2, 1, 22, '#000000', 1);
INSERT INTO `user_settings_headings` VALUES (2, 1, 2, 1, 2, 1, 18, '#000000', 2);
INSERT INTO `user_settings_headings` VALUES (3, 1, 3, 1, 2, 1, 16, '#000000', 3);
INSERT INTO `user_settings_headings` VALUES (4, 1, 4, 1, 2, 2, 14, '#000000', 4);
INSERT INTO `user_settings_headings` VALUES (5, 1, 5, 2, 2, 1, 14, '#000000', 5);
INSERT INTO `user_settings_headings` VALUES (6, 1, 6, 1, 1, 1, 12, '#000000', 6);
INSERT INTO `user_settings_headings` VALUES (8, 2, 1, 1, 2, 1, 22, '#000000', 1);
INSERT INTO `user_settings_headings` VALUES (9, 2, 2, 1, 2, 1, 18, '#000000', 2);
INSERT INTO `user_settings_headings` VALUES (10, 2, 3, 1, 2, 1, 16, '#000000', 3);
INSERT INTO `user_settings_headings` VALUES (11, 2, 4, 1, 2, 2, 14, '#000000', 4);
INSERT INTO `user_settings_headings` VALUES (12, 2, 5, 2, 2, 1, 14, '#000000', 5);
INSERT INTO `user_settings_headings` VALUES (13, 2, 6, 1, 1, 1, 12, '#000000', 6);
INSERT INTO `user_settings_headings` VALUES (15, 3, 1, 1, 2, 1, 22, '#000000', 1);
INSERT INTO `user_settings_headings` VALUES (16, 3, 2, 1, 2, 1, 18, '#000000', 2);
INSERT INTO `user_settings_headings` VALUES (17, 3, 3, 1, 2, 1, 16, '#000000', 3);
INSERT INTO `user_settings_headings` VALUES (18, 3, 4, 1, 2, 2, 14, '#000000', 4);
INSERT INTO `user_settings_headings` VALUES (19, 3, 5, 2, 2, 1, 14, '#000000', 5);
INSERT INTO `user_settings_headings` VALUES (20, 3, 6, 1, 1, 1, 12, '#000000', 6);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_form_field_attributes`
-- 

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
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

-- 
-- Dumping data for table `user_site_form_field_attributes`
-- 

INSERT INTO `user_site_form_field_attributes` VALUES (1, 1, 1, 1, 1, '40');
INSERT INTO `user_site_form_field_attributes` VALUES (2, 1, 1, 1, 2, '255');
INSERT INTO `user_site_form_field_attributes` VALUES (3, 1, 1, 2, 3, '40');
INSERT INTO `user_site_form_field_attributes` VALUES (4, 1, 1, 2, 4, '2');
INSERT INTO `user_site_form_field_attributes` VALUES (5, 1, 1, 3, 5, '20');
INSERT INTO `user_site_form_field_attributes` VALUES (6, 1, 1, 3, 6, '255');
INSERT INTO `user_site_form_field_attributes` VALUES (7, 2, 2, 4, 1, '40');
INSERT INTO `user_site_form_field_attributes` VALUES (8, 2, 2, 4, 2, '255');
INSERT INTO `user_site_form_field_attributes` VALUES (9, 2, 2, 5, 3, '40');
INSERT INTO `user_site_form_field_attributes` VALUES (10, 2, 2, 5, 4, '2');
INSERT INTO `user_site_form_field_attributes` VALUES (11, 2, 2, 6, 5, '20');
INSERT INTO `user_site_form_field_attributes` VALUES (12, 2, 2, 6, 6, '255');
INSERT INTO `user_site_form_field_attributes` VALUES (13, 3, 3, 7, 1, '40');
INSERT INTO `user_site_form_field_attributes` VALUES (14, 3, 3, 7, 2, '255');
INSERT INTO `user_site_form_field_attributes` VALUES (15, 3, 3, 8, 3, '40');
INSERT INTO `user_site_form_field_attributes` VALUES (16, 3, 3, 8, 4, '2');
INSERT INTO `user_site_form_field_attributes` VALUES (17, 3, 3, 9, 5, '20');
INSERT INTO `user_site_form_field_attributes` VALUES (18, 3, 3, 9, 6, '255');
INSERT INTO `user_site_form_field_attributes` VALUES (19, 1, 1, 1, 7, 'e.g., Joe Bloggs');
INSERT INTO `user_site_form_field_attributes` VALUES (20, 1, 1, 2, 8, 'e.g., I love your app, thank you :)');
INSERT INTO `user_site_form_field_attributes` VALUES (21, 1, 1, 3, 9, 'e.g., ********');
INSERT INTO `user_site_form_field_attributes` VALUES (22, 2, 2, 4, 7, 'e.g., Joe Bloggs');
INSERT INTO `user_site_form_field_attributes` VALUES (23, 2, 2, 5, 8, 'e.g., I love your app, thank you :)');
INSERT INTO `user_site_form_field_attributes` VALUES (24, 2, 2, 6, 9, 'e.g., ********');
INSERT INTO `user_site_form_field_attributes` VALUES (25, 3, 3, 7, 7, 'e.g., Joe Bloggs');
INSERT INTO `user_site_form_field_attributes` VALUES (26, 3, 3, 8, 8, 'e.g., I love your app, thank you :)');
INSERT INTO `user_site_form_field_attributes` VALUES (27, 3, 3, 9, 9, 'e.g., ********');
INSERT INTO `user_site_form_field_attributes` VALUES (28, 1, 4, 10, 1, '40');
INSERT INTO `user_site_form_field_attributes` VALUES (29, 1, 4, 10, 2, '255');
INSERT INTO `user_site_form_field_attributes` VALUES (30, 1, 4, 10, 7, 'Feedback here...');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_form_fields`
-- 

CREATE TABLE `user_site_form_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `form_id` int(11) unsigned NOT NULL,
  `field_type_id` tinyint(3) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `form_id` (`form_id`),
  KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `user_site_form_fields`
-- 

INSERT INTO `user_site_form_fields` VALUES (1, 1, 1, 1, 'Name', 'Please enter your name');
INSERT INTO `user_site_form_fields` VALUES (2, 1, 1, 2, 'Comment', 'Please enter the comment you want to post');
INSERT INTO `user_site_form_fields` VALUES (3, 1, 1, 3, 'Password', 'Enter a password');
INSERT INTO `user_site_form_fields` VALUES (4, 2, 2, 1, 'Name', 'Please enter your name');
INSERT INTO `user_site_form_fields` VALUES (5, 2, 2, 2, 'Comment', 'Please enter the comment you want to post');
INSERT INTO `user_site_form_fields` VALUES (6, 2, 2, 3, 'Password', 'Enter a password');
INSERT INTO `user_site_form_fields` VALUES (7, 3, 3, 1, 'Name', 'Please enter your name');
INSERT INTO `user_site_form_fields` VALUES (8, 3, 3, 2, 'Comment', 'Please enter the comment you want to post');
INSERT INTO `user_site_form_fields` VALUES (9, 3, 3, 3, 'Password', 'Enter a password');
INSERT INTO `user_site_form_fields` VALUES (10, 1, 4, 1, 'Describe your first impressions', 'Did you find it easy to use? Was it responsive?');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_forms`
-- 

CREATE TABLE `user_site_forms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `user_site_forms`
-- 

INSERT INTO `user_site_forms` VALUES (1, 1, 'Sample form');
INSERT INTO `user_site_forms` VALUES (2, 2, 'Sample form');
INSERT INTO `user_site_forms` VALUES (3, 3, 'Sample form');
INSERT INTO `user_site_forms` VALUES (4, 1, 'Rate D-Layer');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_history`
-- 

CREATE TABLE `user_site_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) unsigned NOT NULL,
  `site_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `identity_id` (`identity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `user_site_history`
-- 

INSERT INTO `user_site_history` VALUES (1, 1, 1);
INSERT INTO `user_site_history` VALUES (2, 2, 2);
INSERT INTO `user_site_history` VALUES (3, 3, 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_page_content`
-- 

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
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

-- 
-- Dumping data for table `user_site_page_content`
-- 

INSERT INTO `user_site_page_content` VALUES (1, 3, 1, 12, 2, 1);
INSERT INTO `user_site_page_content` VALUES (2, 3, 1, 12, 1, 2);
INSERT INTO `user_site_page_content` VALUES (3, 3, 1, 12, 2, 3);
INSERT INTO `user_site_page_content` VALUES (4, 3, 1, 12, 1, 4);
INSERT INTO `user_site_page_content` VALUES (5, 2, 2, 8, 2, 1);
INSERT INTO `user_site_page_content` VALUES (6, 2, 2, 8, 2, 3);
INSERT INTO `user_site_page_content` VALUES (7, 2, 2, 8, 1, 2);
INSERT INTO `user_site_page_content` VALUES (8, 2, 2, 8, 1, 4);
INSERT INTO `user_site_page_content` VALUES (9, 1, 3, 4, 1, 2);
INSERT INTO `user_site_page_content` VALUES (10, 1, 3, 4, 1, 4);
INSERT INTO `user_site_page_content` VALUES (11, 1, 3, 4, 2, 1);
INSERT INTO `user_site_page_content` VALUES (12, 1, 3, 4, 2, 3);
INSERT INTO `user_site_page_content` VALUES (13, 1, 3, 4, 3, 5);
INSERT INTO `user_site_page_content` VALUES (14, 2, 2, 8, 3, 5);
INSERT INTO `user_site_page_content` VALUES (15, 3, 1, 12, 3, 5);
INSERT INTO `user_site_page_content` VALUES (16, 1, 4, 15, 3, 1);
INSERT INTO `user_site_page_content` VALUES (17, 1, 4, 16, 1, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_page_content_form`
-- 

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
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `user_site_page_content_form`
-- 

INSERT INTO `user_site_page_content_form` VALUES (1, 1, 3, 13, 600, 10, 1);
INSERT INTO `user_site_page_content_form` VALUES (2, 2, 2, 14, 600, 10, 2);
INSERT INTO `user_site_page_content_form` VALUES (3, 3, 1, 15, 600, 10, 3);
INSERT INTO `user_site_page_content_form` VALUES (4, 1, 4, 16, 198, 10, 4);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_page_content_heading`
-- 

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
  KEY `heading_id` (`heading_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `user_site_page_content_heading`
-- 

INSERT INTO `user_site_page_content_heading` VALUES (1, 3, 1, 1, 1, 'Lorem ipsum dolor sit amet,', 815, 12, 12, 5);
INSERT INTO `user_site_page_content_heading` VALUES (2, 3, 1, 3, 3, 'Lorem ipsum dolor sit amet', 815, 12, 12, 5);
INSERT INTO `user_site_page_content_heading` VALUES (3, 2, 2, 5, 1, 'Lorem ipsum dolor sit amet', 815, 12, 12, 5);
INSERT INTO `user_site_page_content_heading` VALUES (4, 2, 2, 6, 3, 'Lorem ipsum dolor sit amet', 815, 12, 12, 5);
INSERT INTO `user_site_page_content_heading` VALUES (5, 1, 3, 11, 1, 'Lorem ipsum dolor sit amet', 815, 12, 12, 5);
INSERT INTO `user_site_page_content_heading` VALUES (6, 1, 3, 12, 3, 'Lorem ipsum dolor sit amet', 815, 12, 12, 5);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_page_content_text`
-- 

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
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `user_site_page_content_text`
-- 

INSERT INTO `user_site_page_content_text` VALUES (1, 3, 1, 2, 800, 10, 'Pellentesque porttitor mi ligula, et auctor est egestas sed. Maecenas eu adipiscing nunc. Proin dapibus mauris in pulvinar sagittis. In eu posuere nulla. Pellentesque luctus blandit massa, sed blandit nulla volutpat a. Pellentesque scelerisque ligula pretium, pellentesque nulla et, faucibus nisl. Sed convallis consequat nibh et lacinia. Suspendisse ac ultricies lectus. Suspendisse justo turpis, dictum eu orci eget, faucibus mollis lorem.');
INSERT INTO `user_site_page_content_text` VALUES (2, 3, 1, 4, 800, 10, 'Pellentesque porttitor mi ligula, et auctor est egestas sed. Maecenas eu adipiscing nunc. Proin dapibus mauris in pulvinar sagittis. In eu posuere nulla. Pellentesque luctus blandit massa, sed blandit nulla volutpat a. Pellentesque scelerisque ligula pretium, pellentesque nulla et, faucibus nisl. Sed convallis consequat nibh et lacinia. Suspendisse ac ultricies lectus. Suspendisse justo turpis, dictum eu orci eget, faucibus mollis lorem. Pellentesque porttitor mi ligula, et auctor est egestas sed. Maecenas eu adipiscing nunc. Proin dapibus mauris in pulvinar sagittis. In eu posuere nulla. Pellentesque luctus blandit massa, sed blandit nulla volutpat a. Pellentesque scelerisque ligula pretium, pellentesque nulla et, faucibus nisl. Sed convallis consequat nibh et lacinia. Suspendisse ac ultricies lectus. Suspendisse justo turpis, dictum eu orci eget, faucibus mollis lorem.');
INSERT INTO `user_site_page_content_text` VALUES (3, 2, 2, 7, 800, 10, 'Pellentesque porttitor mi ligula, et auctor est egestas sed. Maecenas eu adipiscing nunc. Proin dapibus mauris in pulvinar sagittis. In eu posuere nulla. Pellentesque luctus blandit massa, sed blandit nulla volutpat a. Pellentesque scelerisque ligula pretium, pellentesque nulla et, faucibus nisl. Sed convallis consequat nibh et lacinia. Suspendisse ac ultricies lectus. Suspendisse justo turpis, dictum eu orci eget, faucibus mollis lorem.');
INSERT INTO `user_site_page_content_text` VALUES (4, 2, 2, 8, 800, 10, 'Pellentesque porttitor mi ligula, et auctor est egestas sed. Maecenas eu adipiscing nunc. Proin dapibus mauris in pulvinar sagittis. In eu posuere nulla. Pellentesque luctus blandit massa, sed blandit nulla volutpat a. Pellentesque scelerisque ligula pretium, pellentesque nulla et, faucibus nisl. Sed convallis consequat nibh et lacinia. Suspendisse ac ultricies lectus. Suspendisse justo turpis, dictum eu orci eget, faucibus mollis lorem. Pellentesque porttitor mi ligula, et auctor est egestas sed. Maecenas eu adipiscing nunc. Proin dapibus mauris in pulvinar sagittis. In eu posuere nulla. Pellentesque luctus blandit massa, sed blandit nulla volutpat a. Pellentesque scelerisque ligula pretium, pellentesque nulla et, faucibus nisl. Sed convallis consequat nibh et lacinia. Suspendisse ac ultricies lectus. Suspendisse justo turpis, dictum eu orci eget, faucibus mollis lorem.');
INSERT INTO `user_site_page_content_text` VALUES (5, 1, 3, 9, 800, 10, 'Pellentesque porttitor mi ligula, et auctor est egestas sed. Maecenas eu adipiscing nunc. Proin dapibus mauris in pulvinar sagittis. In eu posuere nulla. Pellentesque luctus blandit massa, sed blandit nulla volutpat a. Pellentesque scelerisque ligula pretium, pellentesque nulla et, faucibus nisl. Sed convallis consequat nibh et lacinia. Suspendisse ac ultricies lectus. Suspendisse justo turpis, dictum eu orci eget, faucibus mollis lorem.');
INSERT INTO `user_site_page_content_text` VALUES (6, 1, 3, 10, 800, 10, 'Pellentesque porttitor mi ligula, et auctor est egestas sed. Maecenas eu adipiscing nunc. Proin dapibus mauris in pulvinar sagittis. In eu posuere nulla. Pellentesque luctus blandit massa, sed blandit nulla volutpat a. Pellentesque scelerisque ligula pretium, pellentesque nulla et, faucibus nisl. Sed convallis consequat nibh et lacinia. Suspendisse ac ultricies lectus. Suspendisse justo turpis, dictum eu orci eget, faucibus mollis lorem. Pellentesque porttitor mi ligula, et auctor est egestas sed. Maecenas eu adipiscing nunc. Proin dapibus mauris in pulvinar sagittis. In eu posuere nulla. Pellentesque luctus blandit massa, sed blandit nulla volutpat a. Pellentesque scelerisque ligula pretium, pellentesque nulla et, faucibus nisl. Sed convallis consequat nibh et lacinia. Suspendisse ac ultricies lectus. Suspendisse justo turpis, dictum eu orci eget, faucibus mollis lorem.');
INSERT INTO `user_site_page_content_text` VALUES (7, 1, 4, 17, 782, 10, 'Jools goes mad for this stew in the colder months of the year, and the kids love it too. It''s a straightforward beef stew to which all sorts of root veg can be added. I really like making it with squash and Jerusalem artichokes, which partly cook into the sauce, making it really sumptuous with an unusual and wonderful flavour. The great thing about this stew is that it gets put together very quickly, and this is partly to do with the fact that no time is spent browning the meat. Even though this goes against all my training, I experimented with two batches of meat – I browned one and put the other straight into the pot. The latter turned out to be the sweeter and cleaner-tasting, so I''ve stopped browning the meat for most of my stews these days.\r\n\r\nPreheat the oven to 160ºC/300ºF/gas 2. Put a little oil and your knob of butter into an appropriately sized pot or casserole pan. Add your onion and all the sage leaves and fry for 3 or 4 minutes. Toss the meat in a little seasoned flour, then add it to the pan with all the vegetables, the tomato purée, wine and stock, and gently stir together. \r\n\r\n Season generously with freshly ground black pepper and just a little salt. Bring to the boil, place a lid on top, then cook in the preheated oven until the meat is tender. Sometimes this takes 3 hours, sometimes 4 – it depends on what cut of meat you''re using and how fresh it is. The only way to test is to mash up a piece of meat and if it falls apart easily it''s ready. Once it''s cooked, you can turn the oven down to about 110°C/225°F/gas ¼ and just hold it there until you''re ready to eat. \r\n\r\n The best way to serve this is by ladling big spoonfuls into bowls, accompanied by a glass of French red wine and some really fresh, warmed bread. Mix the lemon zest, chopped rosemary and garlic together and sprinkle over the stew before eating. Just the smallest amount will make a world of difference – as soon as it hits the hot stew it will release an amazing fragrance.');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_pages`
-- 

CREATE TABLE `user_site_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_site_pages_ibfk_2` (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `user_site_pages`
-- 

INSERT INTO `user_site_pages` VALUES (1, 3, 3, 'Sample page', 'Sample page');
INSERT INTO `user_site_pages` VALUES (2, 2, 2, 'Sample page', 'Sample page');
INSERT INTO `user_site_pages` VALUES (3, 1, 1, 'Sample page', 'Sample page');
INSERT INTO `user_site_pages` VALUES (4, 1, 4, 'home', 'Welcome to my test site');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_template_div_background_colors`
-- 

CREATE TABLE `user_site_template_div_background_colors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `div_id` int(11) unsigned NOT NULL,
  `color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`),
  KEY `div_id` (`div_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `user_site_template_div_background_colors`
-- 

INSERT INTO `user_site_template_div_background_colors` VALUES (1, 1, 1, 1, '#FF6600');
INSERT INTO `user_site_template_div_background_colors` VALUES (2, 1, 1, 3, '#003366');
INSERT INTO `user_site_template_div_background_colors` VALUES (3, 2, 2, 5, '#FF6600');
INSERT INTO `user_site_template_div_background_colors` VALUES (4, 2, 2, 7, '#003366');
INSERT INTO `user_site_template_div_background_colors` VALUES (5, 3, 3, 11, '#003366');
INSERT INTO `user_site_template_div_background_colors` VALUES (6, 3, 3, 9, '#FF6600');
INSERT INTO `user_site_template_div_background_colors` VALUES (7, 1, 4, 13, '#000000');
INSERT INTO `user_site_template_div_background_colors` VALUES (8, 1, 4, 15, '#f3f1df');
INSERT INTO `user_site_template_div_background_colors` VALUES (9, 1, 4, 16, '#666666');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_template_div_borders`
-- 

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
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `user_site_template_div_borders`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_template_div_sizes`
-- 

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
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `user_site_template_div_sizes`
-- 

INSERT INTO `user_site_template_div_sizes` VALUES (1, 1, 1, 1, 1020, 0, 120);
INSERT INTO `user_site_template_div_sizes` VALUES (2, 1, 1, 2, 1020, 0, 580);
INSERT INTO `user_site_template_div_sizes` VALUES (3, 1, 1, 3, 200, 0, 580);
INSERT INTO `user_site_template_div_sizes` VALUES (4, 1, 1, 4, 820, 0, 580);
INSERT INTO `user_site_template_div_sizes` VALUES (5, 2, 2, 5, 1020, 0, 120);
INSERT INTO `user_site_template_div_sizes` VALUES (6, 2, 2, 6, 1020, 0, 580);
INSERT INTO `user_site_template_div_sizes` VALUES (7, 2, 2, 7, 200, 0, 580);
INSERT INTO `user_site_template_div_sizes` VALUES (8, 2, 2, 8, 820, 0, 580);
INSERT INTO `user_site_template_div_sizes` VALUES (9, 3, 3, 9, 1020, 0, 120);
INSERT INTO `user_site_template_div_sizes` VALUES (10, 3, 3, 10, 1020, 0, 580);
INSERT INTO `user_site_template_div_sizes` VALUES (11, 3, 3, 11, 200, 0, 580);
INSERT INTO `user_site_template_div_sizes` VALUES (12, 3, 3, 12, 820, 0, 580);
INSERT INTO `user_site_template_div_sizes` VALUES (13, 1, 4, 13, 1020, 0, 90);
INSERT INTO `user_site_template_div_sizes` VALUES (14, 1, 4, 14, 1020, 0, 610);
INSERT INTO `user_site_template_div_sizes` VALUES (15, 1, 4, 15, 218, 0, 610);
INSERT INTO `user_site_template_div_sizes` VALUES (16, 1, 4, 16, 802, 0, 610);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_template_divs`
-- 

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
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- 
-- Dumping data for table `user_site_template_divs`
-- 

INSERT INTO `user_site_template_divs` VALUES (1, 1, 1, 0, 1);
INSERT INTO `user_site_template_divs` VALUES (2, 1, 1, 0, 2);
INSERT INTO `user_site_template_divs` VALUES (3, 1, 1, 2, 1);
INSERT INTO `user_site_template_divs` VALUES (4, 1, 1, 2, 2);
INSERT INTO `user_site_template_divs` VALUES (5, 2, 2, 0, 1);
INSERT INTO `user_site_template_divs` VALUES (6, 2, 2, 0, 2);
INSERT INTO `user_site_template_divs` VALUES (7, 2, 2, 6, 1);
INSERT INTO `user_site_template_divs` VALUES (8, 2, 2, 6, 2);
INSERT INTO `user_site_template_divs` VALUES (9, 3, 3, 0, 1);
INSERT INTO `user_site_template_divs` VALUES (10, 3, 3, 0, 2);
INSERT INTO `user_site_template_divs` VALUES (11, 3, 3, 10, 1);
INSERT INTO `user_site_template_divs` VALUES (12, 3, 3, 10, 2);
INSERT INTO `user_site_template_divs` VALUES (13, 1, 4, 0, 1);
INSERT INTO `user_site_template_divs` VALUES (14, 1, 4, 0, 2);
INSERT INTO `user_site_template_divs` VALUES (15, 1, 4, 14, 1);
INSERT INTO `user_site_template_divs` VALUES (16, 1, 4, 14, 2);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_site_templates`
-- 

CREATE TABLE `user_site_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `user_site_templates`
-- 

INSERT INTO `user_site_templates` VALUES (1, 1, 'Sample template');
INSERT INTO `user_site_templates` VALUES (2, 2, 'Sample template');
INSERT INTO `user_site_templates` VALUES (3, 3, 'Sample template');
INSERT INTO `user_site_templates` VALUES (4, 1, 'dg-temp');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_sites`
-- 

CREATE TABLE `user_sites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identity_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `identity_id` (`identity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `user_sites`
-- 

INSERT INTO `user_sites` VALUES (1, 1, 'Sample site 1');
INSERT INTO `user_sites` VALUES (2, 2, 'Sample site 1');
INSERT INTO `user_sites` VALUES (3, 3, 'Sample site 1');

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `designer_color_palette_colors`
-- 
ALTER TABLE `designer_color_palette_colors`
  ADD CONSTRAINT `designer_color_palette_colors_ibfk_1` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palettes` (`id`),
  ADD CONSTRAINT `designer_color_palette_colors_ibfk_2` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_types` (`id`);

-- 
-- Constraints for table `dlayer_module_tool_tabs`
-- 
ALTER TABLE `dlayer_module_tool_tabs`
  ADD CONSTRAINT `dlayer_module_tool_tabs_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`),
  ADD CONSTRAINT `dlayer_module_tool_tabs_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tools` (`id`);

-- 
-- Constraints for table `dlayer_module_tools`
-- 
ALTER TABLE `dlayer_module_tools`
  ADD CONSTRAINT `dlayer_module_tools_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`);

-- 
-- Constraints for table `form_field_attributes`
-- 
ALTER TABLE `form_field_attributes`
  ADD CONSTRAINT `form_field_attributes_ibfk_1` FOREIGN KEY (`field_type_id`) REFERENCES `form_field_types` (`id`),
  ADD CONSTRAINT `form_field_attributes_ibfk_2` FOREIGN KEY (`attribute_type_id`) REFERENCES `form_field_attribute_types` (`id`);

-- 
-- Constraints for table `user_settings_color_palette_colors`
-- 
ALTER TABLE `user_settings_color_palette_colors`
  ADD CONSTRAINT `user_settings_color_palette_colors_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_settings_color_palette_colors_ibfk_2` FOREIGN KEY (`palette_id`) REFERENCES `user_settings_color_palettes` (`id`),
  ADD CONSTRAINT `user_settings_color_palette_colors_ibfk_3` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_types` (`id`);

-- 
-- Constraints for table `user_settings_color_palettes`
-- 
ALTER TABLE `user_settings_color_palettes`
  ADD CONSTRAINT `user_settings_color_palettes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`);

-- 
-- Constraints for table `user_settings_font_families`
-- 
ALTER TABLE `user_settings_font_families`
  ADD CONSTRAINT `user_settings_font_families_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_settings_font_families_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`),
  ADD CONSTRAINT `user_settings_font_families_ibfk_3` FOREIGN KEY (`font_family_id`) REFERENCES `designer_css_font_families` (`id`);

-- 
-- Constraints for table `user_settings_headings`
-- 
ALTER TABLE `user_settings_headings`
  ADD CONSTRAINT `user_settings_headings_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_settings_headings_ibfk_3` FOREIGN KEY (`style_id`) REFERENCES `designer_css_text_styles` (`id`),
  ADD CONSTRAINT `user_settings_headings_ibfk_4` FOREIGN KEY (`weight_id`) REFERENCES `designer_css_text_weights` (`id`),
  ADD CONSTRAINT `user_settings_headings_ibfk_5` FOREIGN KEY (`decoration_id`) REFERENCES `designer_css_text_decorations` (`id`),
  ADD CONSTRAINT `user_settings_headings_ibfk_6` FOREIGN KEY (`heading_id`) REFERENCES `designer_content_headings` (`id`);

-- 
-- Constraints for table `user_site_form_field_attributes`
-- 
ALTER TABLE `user_site_form_field_attributes`
  ADD CONSTRAINT `user_site_form_field_attributes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_site_form_field_attributes_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_forms` (`id`),
  ADD CONSTRAINT `user_site_form_field_attributes_ibfk_3` FOREIGN KEY (`field_id`) REFERENCES `user_site_form_fields` (`id`),
  ADD CONSTRAINT `user_site_form_field_attributes_ibfk_4` FOREIGN KEY (`attribute_id`) REFERENCES `form_field_attributes` (`id`);

-- 
-- Constraints for table `user_site_form_fields`
-- 
ALTER TABLE `user_site_form_fields`
  ADD CONSTRAINT `user_site_form_fields_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_site_form_fields_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_forms` (`id`),
  ADD CONSTRAINT `user_site_form_fields_ibfk_3` FOREIGN KEY (`field_type_id`) REFERENCES `form_field_types` (`id`);

-- 
-- Constraints for table `user_site_forms`
-- 
ALTER TABLE `user_site_forms`
  ADD CONSTRAINT `user_site_forms_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site_forms` (`id`);

-- 
-- Constraints for table `user_site_history`
-- 
ALTER TABLE `user_site_history`
  ADD CONSTRAINT `user_site_history_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_site_history_ibfk_2` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identities` (`id`);

-- 
-- Constraints for table `user_site_page_content`
-- 
ALTER TABLE `user_site_page_content`
  ADD CONSTRAINT `user_site_page_content_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  ADD CONSTRAINT `user_site_page_content_ibfk_3` FOREIGN KEY (`content_type`) REFERENCES `designer_content_types` (`id`),
  ADD CONSTRAINT `user_site_page_content_ibfk_5` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  ADD CONSTRAINT `user_site_page_content_ibfk_6` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`);

-- 
-- Constraints for table `user_site_page_content_form`
-- 
ALTER TABLE `user_site_page_content_form`
  ADD CONSTRAINT `user_site_page_content_form_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_site_page_content_form_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  ADD CONSTRAINT `user_site_page_content_form_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  ADD CONSTRAINT `user_site_page_content_form_ibfk_4` FOREIGN KEY (`form_id`) REFERENCES `user_site_forms` (`id`);

-- 
-- Constraints for table `user_site_page_content_heading`
-- 
ALTER TABLE `user_site_page_content_heading`
  ADD CONSTRAINT `user_site_page_content_heading_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  ADD CONSTRAINT `user_site_page_content_heading_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  ADD CONSTRAINT `user_site_page_content_heading_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_site_page_content_heading_ibfk_5` FOREIGN KEY (`heading_id`) REFERENCES `user_settings_headings` (`id`);

-- 
-- Constraints for table `user_site_page_content_text`
-- 
ALTER TABLE `user_site_page_content_text`
  ADD CONSTRAINT `user_site_page_content_text_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  ADD CONSTRAINT `user_site_page_content_text_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`),
  ADD CONSTRAINT `user_site_page_content_text_ibfk_3` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`);

-- 
-- Constraints for table `user_site_pages`
-- 
ALTER TABLE `user_site_pages`
  ADD CONSTRAINT `user_site_pages_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_site_pages_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`);

-- 
-- Constraints for table `user_site_template_div_background_colors`
-- 
ALTER TABLE `user_site_template_div_background_colors`
  ADD CONSTRAINT `user_site_template_div_background_colors_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  ADD CONSTRAINT `user_site_template_div_background_colors_ibfk_2` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  ADD CONSTRAINT `user_site_template_div_background_colors_ibfk_3` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`);

-- 
-- Constraints for table `user_site_template_div_borders`
-- 
ALTER TABLE `user_site_template_div_borders`
  ADD CONSTRAINT `user_site_template_div_borders_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  ADD CONSTRAINT `user_site_template_div_borders_ibfk_2` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  ADD CONSTRAINT `user_site_template_div_borders_ibfk_3` FOREIGN KEY (`style`) REFERENCES `designer_css_border_styles` (`style`),
  ADD CONSTRAINT `user_site_template_div_borders_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`);

-- 
-- Constraints for table `user_site_template_div_sizes`
-- 
ALTER TABLE `user_site_template_div_sizes`
  ADD CONSTRAINT `user_site_template_div_sizes_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  ADD CONSTRAINT `user_site_template_div_sizes_ibfk_3` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  ADD CONSTRAINT `user_site_template_div_sizes_ibfk_4` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`);

-- 
-- Constraints for table `user_site_template_divs`
-- 
ALTER TABLE `user_site_template_divs`
  ADD CONSTRAINT `user_site_template_divs_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  ADD CONSTRAINT `user_site_template_divs_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`);

-- 
-- Constraints for table `user_site_templates`
-- 
ALTER TABLE `user_site_templates`
  ADD CONSTRAINT `user_site_templates_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`);

-- 
-- Constraints for table `user_sites`
-- 
ALTER TABLE `user_sites`
  ADD CONSTRAINT `user_sites_ibfk_1` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identities` (`id`);
