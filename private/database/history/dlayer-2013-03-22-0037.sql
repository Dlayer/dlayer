/*
SQLyog Enterprise v11.01 (64 bit)
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

/*Table structure for table `dlayer_module_tool_tabs` */

DROP TABLE IF EXISTS `dlayer_module_tool_tabs`;

CREATE TABLE `dlayer_module_tool_tabs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(2) unsigned NOT NULL,
  `tool_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `script_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `multi_use` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `sort_order` (`sort_order`),
  KEY `enabled` (`enabled`),
  KEY `module_id` (`module_id`),
  KEY `tool_id` (`tool_id`),
  CONSTRAINT `dlayer_module_tool_tabs_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`),
  CONSTRAINT `dlayer_module_tool_tabs_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tools` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tabs` */

insert  into `dlayer_module_tool_tabs`(`id`,`module_id`,`tool_id`,`name`,`script_name`,`multi_use`,`default`,`sort_order`,`enabled`) values (1,1,2,'Quick split','quick',0,1,1,1),(2,1,2,'Split with mouse','advanced',0,0,2,1),(3,1,2,'Help','help',0,0,3,1),(4,1,3,'Quick split','quick',0,1,1,1),(5,1,3,'Split with mouse','advanced',0,0,2,1),(6,1,3,'Help','help',0,0,3,1),(7,1,7,'Palette 1','palette-1',0,1,1,1),(8,1,7,'Palette 2','palette-2',0,0,2,1),(9,1,7,'Palette 3','palette-3',0,0,3,1),(10,1,7,'Set custom color','advanced',0,0,4,1),(11,1,7,'Help','help',0,0,5,1),(12,1,6,'Set custom size','advanced',0,0,5,1),(14,1,6,'Help','help',0,0,6,1),(15,1,6,'Expand','expand',1,1,1,1),(16,1,6,'Contract','contract',1,0,2,1),(17,1,6,'Adjust height','height',1,0,3,1),(20,1,8,'Set custom border','advanced',1,1,2,1),(21,1,8,'Help','help',0,0,3,1),(22,1,8,'Full border','full',0,0,1,1),(23,4,10,'Text','text',1,1,1,1),(24,4,11,'Header','header',1,1,1,1),(25,4,10,'Help','help',0,0,2,1),(26,4,11,'Help','help',0,0,2,1),(27,3,12,'Text field','text',0,1,1,1),(28,3,12,'Help','help',0,0,2,1);

/*Table structure for table `dlayer_module_tools` */

DROP TABLE IF EXISTS `dlayer_module_tools`;

CREATE TABLE `dlayer_module_tools` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `process_model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `script` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Script name in ribbon view folder',
  `icon` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `base` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Can tool run on base div',
  `group_id` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Group within toolbar',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Sort order within group',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tool` (`module_id`,`script`),
  KEY `group_id` (`group_id`),
  KEY `sort_order` (`sort_order`),
  CONSTRAINT `dlayer_module_tools_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_modules` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tools` */

insert  into `dlayer_module_tools`(`id`,`module_id`,`name`,`process_model`,`script`,`icon`,`base`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','','cancel','cancel.png',1,1,1,1),(2,1,'Split horizontal','SplitHorizontal','split-horizontal','split-horizontal.png',1,2,1,1),(3,1,'Split vertical','SplitVertical','split-vertical','split-vertical.png',1,2,2,1),(6,1,'Resize','Resize','resize','resize.png',0,3,3,1),(7,1,'Background color','BackgroundColor','background-color','background-color.png',1,4,1,1),(8,1,'Border','Border','border','border.png',0,4,2,1),(9,4,'Cancel','','cancel','cancel.png',1,1,1,1),(10,4,'Text','Text','text','text.png',0,2,1,1),(11,4,'Header','Header','header','header.png',0,2,2,1),(12,3,'Text','Text','text','text.png',0,2,1,1),(13,3,'Text area','Text area','textarea','textarea.png',0,2,2,1),(14,3,'Cancel','','cancel','cancel.png',1,1,1,1);

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

insert  into `dlayer_sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('001ob53qr2chh2ccstjqjepa00','','PHPSESSID',1363797464,1440,''),('09obkurklpqb4fqkt4cevejrl4','','PHPSESSID',1363724415,1440,''),('0vpjbq6vp9sjd0ltr6d6hgpmf7','','PHPSESSID',1363490151,1440,''),('13q88ug6fp4bmd522o8ifomod4','','PHPSESSID',1363793710,1440,''),('152d2rnb5cksebn6jm8kgjvds0','','PHPSESSID',1363793324,1440,''),('15lr8bkeibobckbmbs1jh35hu7','','PHPSESSID',1363489776,1440,''),('1793o6lhtnognqeditlmhput06','','PHPSESSID',1363792950,1440,''),('1a2fmelf97r4ji5pqbl8u1g4u4','','PHPSESSID',1363657476,1440,''),('1faan5r6agi6hbenqk37uejkg7','','PHPSESSID',1363571691,1440,''),('1lgsm40sl3ogajbbv69hg31e76','','PHPSESSID',1363489746,1440,''),('1ru92k6mdf16m3k1i1kl1mjcg0','','PHPSESSID',1363793766,1440,''),('21sdq7gv7k1d0a5dvth746d3i4','','PHPSESSID',1363724239,1440,''),('29edigpd1i5fgpmsaa8c2je482','','PHPSESSID',1363797453,1440,''),('2aq0euf7vhm9u1miiecdphknq2','','PHPSESSID',1363911715,1440,''),('2ieo0kmjp45c3fr51amq69r1q0','','PHPSESSID',1363792824,1440,''),('2nfpcvh0pcvkv5p02q9luv89f2','','PHPSESSID',1363571689,1440,''),('2ro3maqch19jn27tb5oajpuiu5','','PHPSESSID',1363489536,1440,''),('2shn2o7ohkjj3cn1hvtmo0dtc3','','PHPSESSID',1363724237,1440,''),('2uslm8oi7rgkqn92bvar1qtop0','','PHPSESSID',1363797368,1440,''),('3r6sfqg7hbmnvo9g4j5bbactc6','','PHPSESSID',1363911717,1440,''),('3sj6h556dl85jbheedeenjn2n0','','PHPSESSID',1363489622,1440,''),('3ss1uek282dve6h0t9f5brnqh2','','PHPSESSID',1363724227,1440,''),('40gfkt3qkhgdl69sa65drvscn7','','PHPSESSID',1363490152,1440,''),('41ncm3lin917n4ua8gfbfcjba5','','PHPSESSID',1363724228,1440,''),('43ikba3e4hfe9dtcic15k2vjr3','','PHPSESSID',1363724157,1440,''),('4grmbed0dl0cvm6qgahbms17c4','','PHPSESSID',1363725545,1440,''),('4h53o3h200o46sa37q3nqk4cd6','','PHPSESSID',1363797369,1440,''),('52qslbtajf537v6jt6pect2ge5','','PHPSESSID',1363657474,1440,''),('57ejq0dtbotqcbds108b7645d0','','PHPSESSID',1363795500,1440,''),('5btc8a17b9umi4bv0g4061e9g7','','PHPSESSID',1363793765,1440,''),('5c1p798u7jp5e238he6pq6vb11','','PHPSESSID',1363795498,1440,''),('5suuejpc940ibd3r2mhr0crr30','','PHPSESSID',1363724363,1440,''),('62mvi7uksnrnmqs0bso9g55iv4','','PHPSESSID',1363793325,1440,''),('64uefihec7431c5daskoucvoq0','','PHPSESSID',1363724503,1440,''),('69kbp95jbr5f7a0a0u3ubndri6','','PHPSESSID',1363493939,1440,''),('6ep0hh9dslhmu73ncls75hpr75','','PHPSESSID',1363793711,1440,''),('6lca0paraan40lpbeosr8o6qs4','','PHPSESSID',1363656201,1440,''),('6rlhprdua3qolt955hkjlfi3m4','','PHPSESSID',1363724174,1440,''),('6t54tdvucartrr3rflaofq9702','','PHPSESSID',1363723386,1440,''),('7aoduhuvbg7apb0e31apa6r7j3','','PHPSESSID',1363912416,1440,'dlayer_session|a:2:{s:9:\"module_id\";s:1:\"1\";s:7:\"site_id\";i:1;}dlayer_session_template|a:4:{s:11:\"template_id\";i:1;s:4:\"tool\";s:16:\"background-color\";s:15:\"selected_div_id\";s:3:\"161\";s:3:\"tab\";s:9:\"palette-1\";}dlayer_session_content|a:2:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;}'),('7n6qq7d9qpcof64n4lto80ihc4','','PHPSESSID',1363797453,1440,''),('816tj8rasibp6nnomt07nmvkn3','','PHPSESSID',1363656353,1440,''),('8au22vmitghk9estedvo2skoe3','','PHPSESSID',1363729146,1440,''),('8cgedn91b9m08b9t0regkm5f25','','PHPSESSID',1363724218,1440,''),('8k7alr01k97smohohsb6b9sp46','','PHPSESSID',1363724365,1440,''),('8m1stqfkldq3ih4gn1hkmerpl7','','PHPSESSID',1363724157,1440,''),('964agmea7q669q8crf1ibgvf05','','PHPSESSID',1363797494,1440,''),('98jjeeii08eojak95oaf7esmh5','','PHPSESSID',1363489748,1440,''),('9c0ns4mhaqkcnqli7eos62tgt5','','PHPSESSID',1363720150,1440,''),('9cjhaii5drrmhoonhblqamju10','','PHPSESSID',1363489806,1440,''),('9efbim78712ogtai39kr2gur24','','PHPSESSID',1363724304,1440,''),('9hcv4krqtqqjq9j9nloio424c3','','PHPSESSID',1363793331,1440,''),('9ndhhvpfr67mk0dt2j8cq3cnc6','','PHPSESSID',1363489540,1440,''),('a1u2e0nqe868dfecpudq93bb63','','PHPSESSID',1363489532,1440,''),('a22a74c7qeg19gjf5e3kcemch1','','PHPSESSID',1363724507,1440,''),('ace421q7f26u99cj08rvqqdhj3','','PHPSESSID',1363489690,1440,''),('ag50l64iu4an4ppd5frrckbj91','','PHPSESSID',1363490215,1440,''),('aqri6i34ee9sn69ecvgeed2d20','','PHPSESSID',1363490338,1440,''),('arue6b5da3kj2m7900m53le2j0','','PHPSESSID',1363724222,1440,''),('bbagosk6iass4m8r6597l553h6','','PHPSESSID',1363489669,1440,''),('bbde7vspe9mr9hcgbmefamp4o1','','PHPSESSID',1363596650,1440,''),('bmpin03p7l60v6b1l1s414qhm7','','PHPSESSID',1363797594,1440,''),('bpfrlvl1cru5qegjvbqbhcr3k0','','PHPSESSID',1363489804,1440,''),('bqpk7v4ir1kbc69nc6vm5i7nb0','','PHPSESSID',1363797543,1440,''),('c21i9c8cl7m3h9db1vflt5pto5','','PHPSESSID',1363489745,1440,''),('c423kjpgafqqs25qb39bj4h175','','PHPSESSID',1363797907,1440,''),('clp5nf4nnda6u96lna1roog544','','PHPSESSID',1363489880,1440,''),('clpfsmcegfd5vrgnmngui98b42','','PHPSESSID',1363793764,1440,''),('cq0pr2o8if5mrfnvl9sifdn5l4','','PHPSESSID',1363912416,1440,''),('crr9jba0nnjebr7n241ud83lj0','','PHPSESSID',1363724419,1440,''),('d234kemt74lpes70nt30efrgo0','','PHPSESSID',1363571697,1440,''),('d7vtv9ik7gi7np2a83ji8qi0k4','','PHPSESSID',1363656202,1440,''),('djd38q3ofpeb4piqf46q77dfm1','','PHPSESSID',1363793325,1440,''),('dls52ll4755p6se9jervek6931','','PHPSESSID',1363724499,1440,''),('dmilar16am0mavlufsf2el75n0','','PHPSESSID',1363797504,1440,''),('dncuulm48o5chejmoqi5jl3h83','','PHPSESSID',1363792949,1440,''),('ds79i5h99q3s9kbtjg4idcljd6','','PHPSESSID',1363571694,1440,''),('duroope5cfp68qpti0tnmed3p7','','PHPSESSID',1363489533,1440,''),('ech3all12d3ce245hatr4h5t44','','PHPSESSID',1363912367,1440,''),('ehu39d0cgm6j1s6ucrcc8febc3','','PHPSESSID',1363724498,1440,''),('eq7c2su642bssqcead94chcjs0','','PHPSESSID',1363490158,1440,''),('f5qia9fe93tokrvbct2krrnsj6','','PHPSESSID',1363797093,1440,''),('ffel9hqmaj3orhqf70oitn81l5','','PHPSESSID',1363723389,1440,''),('fgqfdr3gdsb5tso0rt8bi1qb77','','PHPSESSID',1363793323,1440,''),('fn5tnv2r4441tafr4bth7tqur0','','PHPSESSID',1363490156,1440,''),('focupha98ateu3ukrodqtukrc2','','PHPSESSID',1363720147,1440,''),('g0qfjr1nushnq6paul172k0i85','','PHPSESSID',1363797493,1440,''),('g9led94ro7oq91bti0otgivbh7','','PHPSESSID',1363656235,1440,''),('h1a4inq7feogfkm1r9ot6r9vh6','','PHPSESSID',1363724460,1440,''),('hkqt3oku2n4gst7tkkv3gb0631','','PHPSESSID',1363489606,1440,''),('ifnfussmpsna7t8orej3393di1','','PHPSESSID',1363911716,1440,''),('ik7cbkl2gmel1kilglto45pbp6','','PHPSESSID',1363724154,1440,''),('isvgu7tt9q791705sbu0uq96f1','','PHPSESSID',1363797509,1440,''),('itb3hguhss79n30uav01qa3h07','','PHPSESSID',1363795504,1440,''),('j11vsfcsr2mg4oq5prcipfr1c5','','PHPSESSID',1363792826,1440,''),('j8s3rd9l50lfm7frd49lr8s2d3','','PHPSESSID',1363724232,1440,''),('jvhlrqdpp0u1il2dutdk1fh4u0','','PHPSESSID',1363797416,1440,''),('k66nkpnia1rgasrbqfv4a8hrj2','','PHPSESSID',1363489670,1440,''),('ke4rv6mlprgjg6rue9mfpddu04','','PHPSESSID',1363793766,1440,''),('kgkpqg0m1t60282lasecgg0np4','','PHPSESSID',1363797087,1440,''),('kmab7k4efvkk0ahcperh5a1292','','PHPSESSID',1363792821,1440,''),('krdccpgg5c3alg5k1124332jr4','','PHPSESSID',1363797370,1440,''),('kuh3umpt292o0d6j2fra2pv6m2','','PHPSESSID',1363795505,1440,''),('l8b206rqbhfpgi98a4svffgs84','','PHPSESSID',1363490158,1440,''),('lhh1cgadrt7tca52dunfl0pqc5','','PHPSESSID',1363489620,1440,''),('lls774dk9tb6h6eaflfm02v6c0','','PHPSESSID',1363657476,1440,''),('lovolkaj29hidj4jlcvghq4kf4','','PHPSESSID',1363724220,1440,''),('lt6m34lsfa527dt1hsse1fgjt7','','PHPSESSID',1363793711,1440,''),('ltsj6b02mppej740pshn8732n7','','PHPSESSID',1363720149,1440,''),('lv04laq55v29h9ap833to5l3p7','','PHPSESSID',1363797505,1440,''),('m4sgl6bet3mft1hon033801bs4','','PHPSESSID',1363489618,1440,''),('manek5pa00dtrmj1mnmui5ig11','','PHPSESSID',1363793333,1440,''),('mevd20392ogaosgkqsaiq8fif3','','PHPSESSID',1363571699,1440,''),('mh8bh7b7n8gmet5bkl9bhc4l52','','PHPSESSID',1363656354,1440,''),('mov782d98afk7s0ogm9bt97a93','','PHPSESSID',1363489689,1440,''),('mqv2kq1jlnlgmn0uhslrcs7fc1','','PHPSESSID',1363490311,1440,''),('n756mqkfmdfsn8mm8s3oeqkoj7','','PHPSESSID',1363724219,1440,''),('naskl6gs4bdf4gfg26sdgmdla3','','PHPSESSID',1363912366,1440,''),('nfq0hc5tjuujbfg490dv9ku7i3','','PHPSESSID',1363795502,1440,''),('npatgepihcpsjp5qhhi89tcpj5','','PHPSESSID',1363801508,1440,''),('nskqtgpe96q9iu0ev3q25ueg44','','PHPSESSID',1363571693,1440,''),('nvcnvjefef5k8nkj9qi3b2i4f5','','PHPSESSID',1363797451,1440,''),('osl6sdt3tnl76je1qa8v17vco1','','PHPSESSID',1363489744,1440,''),('otn7cpk6mrj13spomgrgf3kth7','','PHPSESSID',1363489807,1440,''),('p0vv9smnu4isk6lopesu1pajg4','','PHPSESSID',1363912369,1440,''),('p4thnn8h6f21o296hso9qeivh0','','PHPSESSID',1363490154,1440,''),('p6h1mbpkbp73c3rqjaea6rqft2','','PHPSESSID',1363793776,1440,''),('pasjpnk8f3bh0q4qa66hkah4b7','','PHPSESSID',1363724228,1440,''),('pdj01vuoq1psaqicrvjbsdgti1','','PHPSESSID',1363797091,1440,''),('qfo9sf33aqrhn5houd3hbs0q30','','PHPSESSID',1363656207,1440,''),('qm0498c395dj0rdkekb7h5ogv1','','PHPSESSID',1363489623,1440,''),('qua896ajnca5ca1c24ccqcq1m2','','PHPSESSID',1363489602,1440,''),('r1aj38m5fcfueu9979a73ikm34','','PHPSESSID',1363489619,1440,''),('r9b9bqotcgluf5a28chphoh9u3','','PHPSESSID',1363596650,1440,'dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('rnk5ecsdi0i7u795l8dm6h9vq1','','PHPSESSID',1363797086,1440,''),('s3ntt0s8rigc92c7eelhgmn893','','PHPSESSID',1363490155,1440,''),('s907vq5sr87ggdcvcdeera1i10','','PHPSESSID',1363724156,1440,''),('sb35cduh13n42ht8t43fmjl2v1','','PHPSESSID',1363793709,1440,''),('sbvn9sbkp25ei07h65dtam83l6','','PHPSESSID',1363489774,1440,''),('sev9a39k63chtiujcclv7kkvq0','','PHPSESSID',1363797499,1440,''),('sjveps94f6vhnep83j42p7p4p1','','PHPSESSID',1363656204,1440,''),('sufdlrk9plb94jcb8obsp7vj84','','PHPSESSID',1363793326,1440,''),('t5b61m1cb8nr66avnoi3ja0085','','PHPSESSID',1363793327,1440,''),('tkm8l91eadigv0nn3hgne75ni1','','PHPSESSID',1363724409,1440,''),('tr1hgeeuee313u2n2tu2o3cpg2','','PHPSESSID',1363489686,1440,''),('trglrvd4g48l2u632p7h63ibl1','','PHPSESSID',1363490196,1440,''),('tvg2c0l3vs754dl1c3ql551qd4','','PHPSESSID',1363723390,1440,''),('u4o2f5qdrvu8hcggt0qv1f3903','','PHPSESSID',1363489685,1440,''),('uah0aurjbo9og28oc387danek3','','PHPSESSID',1363793775,1440,''),('uakaatb3ihocvqm3cao46hqob3','','PHPSESSID',1363489604,1440,''),('uas820pesrjf8687dtmuojp505','','PHPSESSID',1363793776,1440,''),('ugatp3sa7hm979sjc9mc7b9ot4','','PHPSESSID',1363724155,1440,''),('ur3475a2c21ukh1j4i2dik0796','','PHPSESSID',1363911713,1440,''),('urvupnatqit127fbg2vi9r2t51','','PHPSESSID',1363724302,1440,''),('uslv5qrefrshjl7hl7pn68r0r3','','PHPSESSID',1363656205,1440,''),('v2ugb5qsb3kckhq1i0vu1885s7','','PHPSESSID',1363724445,1440,''),('v6on1n47hoq45q8rmisjs1fbr1','','PHPSESSID',1363489687,1440,''),('vl3kjgfo2fnilupui8nsh1moo1','','PHPSESSID',1363797088,1440,''),('vmtk1f308dsaevnu4613a1id31','','PHPSESSID',1363489617,1440,''),('vt2sdfnfbjfl0ephnvpuepbvg0','','PHPSESSID',1363489530,1440,'');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_color_palette_colors` */

insert  into `user_settings_color_palette_colors`(`id`,`site_id`,`palette_id`,`color_type_id`,`name`,`hex`,`r`,`g`,`b`,`enabled`) values (10,1,1,1,'Black','#000000',0,0,0,1),(11,1,1,2,'Tan','#f3f1df',127,127,127,1),(12,1,1,3,'Dark grey','#666666',102,102,102,1),(13,1,2,1,'Blue','#336699',51,102,127,1),(14,1,2,2,'Dark grey','#666666',102,102,102,1),(15,1,2,3,'Grey','#999999',127,127,127,1),(16,1,3,1,'Blue','#003366',0,51,102,1),(17,1,3,2,'White','#FFFFFF',127,127,127,1);

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

insert  into `user_site_template_div_background_colors`(`id`,`template_id`,`div_id`,`hex`) values (17,1,160,'#000000'),(18,1,161,'#666666'),(20,1,159,'#f3f1df');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_borders` */

insert  into `user_site_template_div_borders`(`id`,`template_id`,`div_id`,`position`,`style`,`width`,`hex`) values (1,1,159,'top','dashed',5,'#000000'),(2,1,159,'right','solid',5,'#000000'),(3,1,159,'bottom','solid',5,'#000000'),(4,1,159,'left','solid',5,'#000000');

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
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_sizes` */

insert  into `user_site_template_div_sizes`(`id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (158,1,158,980,0,190),(159,1,159,970,0,350),(160,1,160,140,0,190),(161,1,161,840,0,190);

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
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_divs` */

insert  into `user_site_template_divs`(`id`,`site_id`,`template_id`,`parent_id`,`sort_order`) values (158,1,1,0,1),(159,1,1,0,2),(160,1,1,158,1),(161,1,1,158,2);

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
