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
  `type` enum('Primary','Secondary','Tertiary') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
  `r` tinyint(3) NOT NULL DEFAULT '0',
  `g` tinyint(3) NOT NULL DEFAULT '0',
  `b` tinyint(3) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `palette_id` (`palette_id`),
  CONSTRAINT `designer_color_palette_colors_ibfk_1` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palettes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palette_colors` */

insert  into `designer_color_palette_colors`(`id`,`palette_id`,`type`,`name`,`hex`,`r`,`g`,`b`,`enabled`) values (1,1,'Primary','Black','#000000',0,0,0,1),(2,1,'Secondary','Tan','#f3f1df',127,127,127,1),(3,1,'Tertiary','Dark grey','#666666',102,102,102,1),(4,2,'Primary','Blue','#336699',51,102,127,1),(5,2,'Secondary','Dark grey','#666666',102,102,102,1),(6,2,'Tertiary','Grey','#999999',127,127,127,1),(7,3,'Primary','Blue','#003366',0,51,102,1),(8,3,'Secondary','White','#FFFFFF',127,127,127,1),(9,3,'Tertiary','Orange','#FF6600',127,102,0,1);

/*Table structure for table `designer_color_palettes` */

DROP TABLE IF EXISTS `designer_color_palettes`;

CREATE TABLE `designer_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_color_palettes` */

insert  into `designer_color_palettes`(`id`,`name`,`enabled`) values (1,'Palette A',1),(2,'Palette B',1),(3,'Palette C',1);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tools` */

insert  into `dlayer_module_tools`(`id`,`module_id`,`name`,`process_model`,`script`,`icon`,`base`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','','cancel','cancel.png',1,1,1,1),(2,1,'Split horizontal','SplitHorizontal','split-horizontal','split-horizontal.png',1,2,1,1),(3,1,'Split vertical','SplitVertical','split-vertical','split-vertical.png',1,2,2,1),(6,1,'Resize','Resize','resize','resize.png',0,3,3,1),(7,1,'Background color','BackgroundColor','background-color','background-color.png',1,4,1,1),(8,1,'Border','Border','border','border.png',0,4,2,1),(9,4,'Cancel','','cancel','cancel.png',1,1,1,1),(10,4,'Text','Text','text','text.png',0,2,1,1),(11,4,'Header','Header','header','header.png',0,2,2,1),(12,3,'Text','Text','text','text.png',0,1,1,1),(13,3,'Text area','Text area','textarea','textarea.png',0,1,2,1);

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

insert  into `dlayer_sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('03opbd1j96rm37lvm619i8ns20','','PHPSESSID',1363114355,1440,''),('03s3c533fos0fjqkph7joff2a3','','PHPSESSID',1363187844,1440,''),('04a9ff5o86ssg7pmh78kvt95q1','','PHPSESSID',1363185182,1440,''),('051v9decn13uq8nn72kesj1po1','','PHPSESSID',1362855311,1440,''),('06oi9hs16orfi2gcemr2m1b7a2','','PHPSESSID',1362971718,1440,''),('08at4rt5rshsp4rrs9ol6ll6g3','','PHPSESSID',1362885806,1440,''),('09h6sbea85qta3jj1uga7ifna5','','PHPSESSID',1362447394,1440,''),('0a74etucjhicopvmd3mlt1enk5','','PHPSESSID',1363232535,1440,''),('0achif32c5l69aurimb48b40q2','','PHPSESSID',1362533309,1440,''),('0afjgfqeadbmuiefai1uu4dff2','','PHPSESSID',1363144360,1440,''),('0alahttb9gltfm3uq8j0tk6t03','','PHPSESSID',1363144565,1440,''),('0ap1pi18rj9kpd7pgiedr7b1v0','','PHPSESSID',1362449527,1440,''),('0ar2352o612hp0sq10a9eqin03','','PHPSESSID',1363186160,1440,''),('0bcp6ei2h71i1kbjf8p6hf1tc4','','PHPSESSID',1363186679,1440,''),('0bd7nq87tb99qhks8d3u6ap665','','PHPSESSID',1362447202,1440,''),('0bml0mtc86cd4idk94gpb9b491','','PHPSESSID',1362447202,1440,''),('0dsjnrv95i9if07rmpb975kof5','','PHPSESSID',1363114113,1440,''),('0ef56491hisla7hcudu3405r66','','PHPSESSID',1362886447,1440,''),('0em2vcs2q3ilv2pcbk0emf3qn2','','PHPSESSID',1362355257,1440,''),('0i8opubt000uvgen29kpqgojr6','','PHPSESSID',1362355296,1440,''),('0icbufdc39i5v8slur7f03nso3','','PHPSESSID',1363186156,1440,''),('0iglrklu343avs6c5jkr80htg5','','PHPSESSID',1363186158,1440,''),('0isoivh7odgmdnhteeqpkekde1','','PHPSESSID',1362678325,1440,''),('0jgs70pm0g3at3ctj8upl3f4h1','','PHPSESSID',1362449320,1440,''),('0kc8eossa78fek1l58955i5o13','','PHPSESSID',1362706507,1440,''),('0m1edmdq7uikai3vumfv3frmk4','','PHPSESSID',1362677182,1440,''),('0nii3lsppk19l1c35ei96t6n50','','PHPSESSID',1362704989,1440,''),('0o72710f3tvrgbdr88pcmqpon6','','PHPSESSID',1362971721,1440,''),('0qoafhtfq8cstk69lv30ngeg55','','PHPSESSID',1363113614,1440,''),('0s3bhpna3grt4afs73odca2cf7','','PHPSESSID',1362503229,1440,''),('0t21nledjfu65a0mepnbrmvgk3','','PHPSESSID',1362503183,1440,''),('0t7cb05qkpudhcv6rsklrek872','','PHPSESSID',1363186445,1440,''),('0tdlkot31n6jkc4kka1da95rm6','','PHPSESSID',1363186631,1440,''),('0th0vf19hqair0oqc4orc1vdh5','','PHPSESSID',1362504308,1440,''),('10ikr97gsnrkifq0h4vt2koae6','','PHPSESSID',1362854700,1440,''),('10m90uetltcjv78p2ko26gnk97','','PHPSESSID',1363114249,1440,''),('10qrs8u5akoj1eujaca412ffs2','','PHPSESSID',1362559810,1440,''),('11ef08o9rglacicigph0c3ufa1','','PHPSESSID',1362855375,1440,''),('12jk07697he1674pt2uesmst25','','PHPSESSID',1362885941,1440,''),('148k6tcu4ukp8kbmpccqscesi5','','PHPSESSID',1363188002,1440,''),('14ehvscohq10ho9d6sjoq5k4d5','','PHPSESSID',1362676219,1440,''),('15vd67kkdiumpke0ppqdc8sp04','','PHPSESSID',1362447455,1440,''),('16ur8le42uai6kfrrss4hpelr6','','PHPSESSID',1362676231,1440,''),('18h38kvuks7h54d00grctdcma0','','PHPSESSID',1363186795,1440,''),('18p1m2cdf6hf0dfuramc9uap90','','PHPSESSID',1363187906,1440,''),('1979su67nojcrr3lj33omk3u62','','PHPSESSID',1362884829,1440,''),('19gla0nnqhplunff8bml11one1','','PHPSESSID',1363185330,1440,''),('19v3shh4n1hv3grjjjjo67oe61','','PHPSESSID',1363112308,1440,''),('1ah3e5eg2jtrpehvlj35tba2r3','','PHPSESSID',1362421681,1440,''),('1bcjhmbuse2orqg7mo0iopqai3','','PHPSESSID',1363144547,1440,''),('1bodmf1lorubcs442f5jdcu7s6','','PHPSESSID',1362678433,1440,''),('1brrsk84f0pd330pp0pbbpq5q7','','PHPSESSID',1362855348,1440,''),('1dg39sr4v80ttbfncgkkpiknf7','','PHPSESSID',1362885806,1440,''),('1dit6k0lsmm0pajeh2829fma57','','PHPSESSID',1362422867,1440,''),('1e2ju0fcqs1t1ue6ltl9p74jr4','','PHPSESSID',1362884959,1440,''),('1ebha2l58b085dtvbt50v5nsf5','','PHPSESSID',1363114112,1440,''),('1epgd2qt23udfunq7rp6fjrek5','','PHPSESSID',1362679406,1440,''),('1fqlonq15idijbia0po4aquis5','','PHPSESSID',1362854712,1440,''),('1galphhdtlj5r3vd8h6if3cdd2','','PHPSESSID',1362856519,1440,''),('1hhcub3lsn7e7sqto617gg7f15','','PHPSESSID',1362678335,1440,''),('1i4acvrnp8a8viiecita1nlch4','','PHPSESSID',1362885225,1440,''),('1ino4rfd55o0jio5fulu08itn7','','PHPSESSID',1363187461,1440,''),('1jnl60funcbk1cetvq5a48akr7','','PHPSESSID',1363113440,1440,''),('1k8noi18cvnor9pbhofnemep40','','PHPSESSID',1362355220,1440,''),('1kpbbrukp3iv4rtvcmme9ujck4','','PHPSESSID',1362885868,1440,''),('1ojeloteh1a7egpnpagfrj6ps5','','PHPSESSID',1362355179,1440,''),('1qe41oqao77a70p8hasedf0u11','','PHPSESSID',1362855418,1440,''),('1qgh8jl1s54h9g62jp83ti9bt5','','PHPSESSID',1362855424,1440,''),('1rcaco76h2r0iqighehll4otf1','','PHPSESSID',1362854414,1440,''),('1rnq5h6cru3scqhi8osbvpas25','','PHPSESSID',1363185274,1440,''),('1ssdqb9pineuucl5q3r4cr7ir2','','PHPSESSID',1363232508,1440,''),('1steof9qh35ficmmn299o4eui2','','PHPSESSID',1362533177,1440,''),('1t88mjbtm98macl7n2tks5qpd4','','PHPSESSID',1362421679,1440,''),('1tjtq5ne5ntcrliannoskpsnn2','','PHPSESSID',1362504364,1440,''),('1v517ikll0t4rod5l8v8jvpqv0','','PHPSESSID',1363004713,1440,''),('2015mcrnt19vrabt9iv47dic32','','PHPSESSID',1363185602,1440,''),('20vq72g80hrs9iu1a7d1647so5','','PHPSESSID',1362855420,1440,''),('222r19aclj849d17ust93f0v20','','PHPSESSID',1363144472,1440,''),('22jsemg15ufa8v1icmf62b72a6','','PHPSESSID',1363187726,1440,''),('22pn7r33sc1b7p49935t8029q4','','PHPSESSID',1363186163,1440,''),('2318dnosvvgcnfumd8frgm3pf3','','PHPSESSID',1362854651,1440,''),('24t6dkru06otsfbbqu1j751v27','','PHPSESSID',1362678341,1440,''),('25nrdb1u7qniolhrkrfcijdh40','','PHPSESSID',1363114305,1440,''),('25r81cpqpsde9pbgovg5fkinf6','','PHPSESSID',1362854423,1440,''),('26g1emobrkom3069ce1pg9h3i0','','PHPSESSID',1362679355,1440,''),('27cnu6jidnjdnll22p7kebqhs6','','PHPSESSID',1362855423,1440,''),('27f4rlgpdot2pqekdb774dqed0','','PHPSESSID',1362355164,1440,''),('27iha77ubvf96pd9t6go426d12','','PHPSESSID',1363144079,1440,''),('28iosm5elo7hn7f7v7hsnmlkt0','','PHPSESSID',1362856519,1440,''),('29la3atqpr70m396ag6hr8r4g3','','PHPSESSID',1362679355,1440,''),('29omhmpkkqht16ft9faq4spiv6','','PHPSESSID',1362405843,1440,''),('2a3n4gecqai0en16v1j652r602','','PHPSESSID',1362855032,1440,''),('2apvmk1399id73shihjbjhtbt2','','PHPSESSID',1362855444,1440,''),('2b0die1m5u6s1bauprm8npkud6','','PHPSESSID',1363187950,1440,''),('2bnmjregaslm439motfl3n2i95','','PHPSESSID',1362855091,1440,''),('2cv7qnmlg0bm137658rg9m6lo0','','PHPSESSID',1362534892,1440,''),('2d5mkhi7v07o152u5ie5uig341','','PHPSESSID',1362880171,1440,''),('2djvn2lvckidssdc1euog5es15','','PHPSESSID',1362958297,1440,''),('2fij3us43dp8j3rn6opgo9qlr3','','PHPSESSID',1362854421,1440,''),('2fnd8hsjm3ljdq8a6ad6g5v2i5','','PHPSESSID',1362855420,1440,''),('2g3255seovp6eeb0120ahjo1p3','','PHPSESSID',1362857096,1440,''),('2gito6f2663rn9rmqda322p7v2','','PHPSESSID',1362885069,1440,''),('2gvi94tdafdul4o30vlv226ql5','','PHPSESSID',1362504407,1440,''),('2hbiclduai9vrcr9te9n9ipce7','','PHPSESSID',1363144359,1440,''),('2i5v1q1irrvavudfcau9labub7','','PHPSESSID',1363113384,1440,''),('2jds1ecp4djkeb2fmuq07vcck2','','PHPSESSID',1363144549,1440,''),('2kn1bjkhb7q1nhap9i82fra545','','PHPSESSID',1362504302,1440,''),('2puu91f6hg0jvp9c4qj06mrmi7','','PHPSESSID',1362885651,1440,''),('2qtk3mnkorgv83uajhg32uo8e2','','PHPSESSID',1363185001,1440,''),('2qtv9d3t126k9qo4d8to0p8eo0','','PHPSESSID',1363144196,1440,''),('2rnjik98lm295i341s8auui7e7','','PHPSESSID',1362502769,1440,''),('2spusvejqht2g1b1j892b1lhv3','','PHPSESSID',1362971723,1440,''),('35bultbk1kgmv4rncmso2s4f60','','PHPSESSID',1362502179,1440,''),('37o6fsgs417542ga34pe69la95','','PHPSESSID',1363232951,1440,''),('386d2vatn6n3npp7ctj2rkoh40','','PHPSESSID',1363185600,1440,''),('394aj5oncus666hd5meeosmec0','','PHPSESSID',1362855311,1440,''),('3a0bo4p3pd3mf1mesf1dmr72t5','','PHPSESSID',1362355352,1440,'dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"4\";}dlayer_session_template|a:1:{s:11:\"template_id\";i:1;}dlayer_session_content|a:2:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;}'),('3b8jvsh10cfpvjlgrlje8kd5m0','','PHPSESSID',1362676230,1440,''),('3beekeus3v2t5gk3vmhsfb5b80','','PHPSESSID',1363185334,1440,''),('3bof5o110ilim95rdn7dtpvsn5','','PHPSESSID',1362885225,1440,''),('3bqj1qpe7tlh00fclh3alvtmt5','','PHPSESSID',1362971126,1440,''),('3c49oe67g841akfhqg18okgev0','','PHPSESSID',1362884873,1440,''),('3cfkqe0gm5lhtd1lu090pdb7u5','','PHPSESSID',1362679377,1440,''),('3dksr7h3uvui0vk6oig7ptvje4','','PHPSESSID',1363187998,1440,''),('3e2uqe11d2848u00h33dim7960','','PHPSESSID',1362409450,1440,''),('3ehbsjdeb0iaq49poipv89u7t6','','PHPSESSID',1362677187,1440,''),('3h4mgqg9ssnh358csm3j50d361','','PHPSESSID',1363187461,1440,''),('3icmqsseiru10hefte2b7m0vo2','','PHPSESSID',1362855216,1440,''),('3iiic1g9phnmdqb42ilu6efd00','','PHPSESSID',1362857101,1440,''),('3j1pdnhkp9g4eet29ub8v1dhb1','','PHPSESSID',1362855023,1440,''),('3la5f9ngt4m01mrbr67m1kurl6','','PHPSESSID',1363187497,1440,''),('3m24lgb4jmiv23iebqruvmn1g5','','PHPSESSID',1362706523,1440,''),('3me5tm4fl4rnkgq6phs48dmkb6','','PHPSESSID',1363112081,1440,''),('3ocmtq2a7epvi440hu0rknqc86','','PHPSESSID',1363185593,1440,''),('3ocul4dsm8up1bqeo9tbq2mr04','','PHPSESSID',1363144019,1440,''),('3otq4fckrnfhbrfkflhjc2p2r2','','PHPSESSID',1363111772,1440,''),('3qoamric2fs5lvvch1cu0fecr2','','PHPSESSID',1363114247,1440,''),('3qorg1um3eas9uhqckojl01hk7','','PHPSESSID',1362533176,1440,''),('3rbg294mha66u1qjkfq3e02hc3','','PHPSESSID',1362880149,1440,''),('3rd1gam6g8dfr05rjfjjjkf024','','PHPSESSID',1362534672,1440,''),('3rdqkojauk76abds0rvrsrgne2','','PHPSESSID',1362449309,1440,''),('3t331ccusq7lrb3o3lqpk2d7m7','','PHPSESSID',1362855420,1440,''),('3tspt0pk703le29ge5lrfqjqg3','','PHPSESSID',1362355298,1440,''),('3u6a0dvlj6v1fpbu4mtl2hqog2','','PHPSESSID',1362504297,1440,''),('426ngbi2tsjd641kavlm3bh9i4','','PHPSESSID',1362971170,1440,''),('42cmk0dr38c2lkv3cl77unq715','','PHPSESSID',1362534649,1440,''),('431fv6gi7k1snfi4tn5nkm2lh5','','PHPSESSID',1362534361,1440,''),('43a44u5bsjvv59raj13hngjbb5','','PHPSESSID',1363185107,1440,''),('43vjc056vnr5e8finoub3blhd5','','PHPSESSID',1363012008,1440,''),('443497l57c7mt16clhmji5fj52','','PHPSESSID',1362886134,1440,''),('45fq2oafibcme8h7b3n47aa6p6','','PHPSESSID',1362447506,1440,''),('4744nnhu82i3vhbvrm0i2r5t00','','PHPSESSID',1362885163,1440,''),('47jqb2im4t1s7qrmrf5dum7vo4','','PHPSESSID',1362970884,1440,''),('48eccma43s6l8ab88t46a2h0g0','','PHPSESSID',1363144566,1440,''),('490pnelmsdpiqbfnfugl2eb9n7','','PHPSESSID',1362884830,1440,''),('498mq3ji6131aagj1r4u3sk7c7','','PHPSESSID',1362534891,1440,''),('49k8pj6rpa3vi0lmndsbubdim5','','PHPSESSID',1363232823,1440,''),('4b48uha3ckonftq10i571ebfb3','','PHPSESSID',1362533161,1440,''),('4gmmcvrln5u7t3ki4879vv61f6','','PHPSESSID',1362504340,1440,''),('4h4hvaufj62h8eerp8plakifs1','','PHPSESSID',1362355221,1440,''),('4hrk51erg5gvdkdaija0muia40','','PHPSESSID',1362707175,1440,''),('4i68pepapadsflgjpjqjdj8d01','','PHPSESSID',1363144360,1440,''),('4jjjp5s6sgjpa7mnt84cu23fn0','','PHPSESSID',1362971720,1440,''),('4l9drba5ldlbuug79u1somgf50','','PHPSESSID',1363187856,1440,''),('4lc5cddmc1tgfvkl2dmiks0b74','','PHPSESSID',1363114002,1440,''),('4mf6a6me0ebnjl4r25sb7vs547','','PHPSESSID',1362534650,1440,''),('4nvcrn5hhuklk309addned7uv0','','PHPSESSID',1362413170,1440,''),('4o21ovlf9hdmh27t1b64tnkq75','','PHPSESSID',1362855481,1440,''),('4oh3k7ecno9i86nnj2eq34lv13','','PHPSESSID',1363188001,1440,''),('4q25ar2bi94nb6auhcg53kg2a3','','PHPSESSID',1362885225,1440,''),('4rtq0sldq7puvncqopcp5320g4','','PHPSESSID',1362704997,1440,''),('4sbe6iadl8fb0vfh2oq5v001u4','','PHPSESSID',1363112310,1440,''),('4tgq4572hu2kgrhvffifmo1fg5','','PHPSESSID',1363187830,1440,''),('4ubhj8qros4kl054qvs6eqk354','','PHPSESSID',1362534746,1440,''),('4vkkmqcjps15lhi1ule7bp12a3','','PHPSESSID',1362449641,1440,'dlayer_session_content|a:5:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";N;s:19:\"selected_content_id\";N;s:7:\"tool_id\";N;}dlayer_session|a:1:{s:9:\"module_id\";s:1:\"4\";}'),('501gcvkp8r309r655s0oli8bo0','','PHPSESSID',1362676224,1440,''),('50g9uvm7vl4kvokgmefatq25v3','','PHPSESSID',1362422854,1440,''),('50sp6fifkeonl4s9gtiuf8cti4','','PHPSESSID',1362884874,1440,''),('50u3jqttqouqte0eipiqr9t2h5','','PHPSESSID',1363111769,1440,''),('52p8iibvhjm30taq9eflkla160','','PHPSESSID',1362971168,1440,''),('576d8uf8ohk96dg7i62s6r5bq6','','PHPSESSID',1362503230,1440,''),('57j9dudm46adamd00bejvguvo3','','PHPSESSID',1362884335,1440,''),('58itha7ab9pg1keet6239s5730','','PHPSESSID',1362534651,1440,''),('5942ge8jc6esid9cv06g79pb14','','PHPSESSID',1362677980,1440,''),('59dunqkaqquotmts6u720cjcq1','','PHPSESSID',1362504341,1440,''),('59g3uu566320gr84uas0vc7q46','','PHPSESSID',1362855219,1440,''),('59n5n17jklco0ggub0c8pp0ot5','','PHPSESSID',1363185323,1440,''),('5b3qqh4hfgi7mrql0vnij4q7t5','','PHPSESSID',1362855350,1440,''),('5be8ndh1u7f6o3b7f7f65mpb75','','PHPSESSID',1363112076,1440,''),('5c7rcucjtgjlsa9535egs39u34','','PHPSESSID',1363114112,1440,''),('5cg81aoo7lqhjo3q8d67b2tdq5','','PHPSESSID',1362409088,1440,''),('5dnec4r7196golk0rbqarkf836','','PHPSESSID',1362884875,1440,''),('5f52731vdhdjctch5aeg51ugt1','','PHPSESSID',1363185109,1440,''),('5f5rd0jl8fc5f7mbmia3hquu74','','PHPSESSID',1362856335,1440,''),('5fn052trff6dlgtgt8vv253155','','PHPSESSID',1362857102,1440,''),('5iqvujdprdlj7lbmta4hn636c1','','PHPSESSID',1362421678,1440,''),('5jpu3mjv24uj3keh03lq0vfon3','','PHPSESSID',1363186615,1440,''),('5lbu1qhh05c54np1iakogik9n2','','PHPSESSID',1362854425,1440,''),('5lng840m6us514ufuvskhdu0o5','','PHPSESSID',1363185114,1440,''),('5m27ibml2dk7uqttgqqbr72hd4','','PHPSESSID',1362885806,1440,''),('5oppi3umejlr36pcob7k7b16t1','','PHPSESSID',1362884561,1440,''),('5ouleli1jeooirbqiljdciktv5','','PHPSESSID',1362676229,1440,''),('5rdobb1tgci8ssrh28b46pcnm5','','PHPSESSID',1362857134,1440,''),('5rippoi61k3bqeh9nkr2qr7ko2','','PHPSESSID',1362971125,1440,''),('5s3ehl8jc4cfambc1l0j9rjmt4','','PHPSESSID',1362856813,1440,''),('5t2rbab0lhr61an29k9dn8kuu0','','PHPSESSID',1362502178,1440,''),('5umrsrh4q7imdquatoddvvb220','','PHPSESSID',1363113275,1440,''),('5v8bhc6e1foheprmt43ch1snp6','','PHPSESSID',1363232951,1440,''),('5v8v2aacdjbqsl1lijp5pjam67','','PHPSESSID',1362534671,1440,''),('651o8270png44ltfkaek97md55','','PHPSESSID',1362855419,1440,''),('653t3nju24ldgq6b91rtqgfng7','','PHPSESSID',1362500338,1440,'dlayer_session_content|a:2:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;}dlayer_session|a:1:{s:9:\"module_id\";s:1:\"4\";}'),('66mdjern0d17gq9qfkhils0e30','','PHPSESSID',1362504361,1440,''),('66rhlrq9m4onvt1b6c10lcc037','','PHPSESSID',1363144288,1440,''),('69dciou476qg3go552rbriena4','','PHPSESSID',1363012010,1440,''),('6a1dh21hkhik84ljli1uba7u30','','PHPSESSID',1362533207,1440,''),('6archaqlollnmqeot2gr0fjub1','','PHPSESSID',1362884961,1440,''),('6bhsgk7g3fbktl704uo7uvpjg4','','PHPSESSID',1362855420,1440,''),('6c2mo8pdfcgfjtpdn0bvgskl16','','PHPSESSID',1362855442,1440,''),('6c5mpt22lr8g50i10o9coioek5','','PHPSESSID',1362678005,1440,''),('6cpcapmlhb055ddufh0l18mbp7','','PHPSESSID',1362447506,1440,''),('6d0rgaofhi1cmqaqhd5dj3p825','','PHPSESSID',1362502769,1440,''),('6er2pl57tkpv32g3ds44b1ski6','','PHPSESSID',1362884874,1440,''),('6fff6t921ddm0r4omptuithup1','','PHPSESSID',1363233031,1440,''),('6fu7vu4plb1f4i58ftmdk9f2e7','','PHPSESSID',1363186807,1440,''),('6g9sh2jg4f8q49boc1r1h83td6','','PHPSESSID',1362855123,1440,''),('6gp20kacv2k21u6ko9j4g985o0','','PHPSESSID',1362855418,1440,''),('6je80pvr58uioui1uq0use6dn6','','PHPSESSID',1362678334,1440,''),('6jqm8ti20sehepajokjur15197','','PHPSESSID',1363187498,1440,''),('6n7e19murlr1bg6qinuabbcd70','','PHPSESSID',1362855556,1440,''),('6ojj4ftddcbcoohkka9a08e2v2','','PHPSESSID',1362707213,1440,''),('6p32378gt4cni38dmdhbiefq70','','PHPSESSID',1362677967,1440,''),('6p3dg3ifqg81b2onms9s7o1ij4','','PHPSESSID',1362855479,1440,''),('6qs04dl3v56nirtfgsumh9jr83','','PHPSESSID',1362880143,1440,''),('6rtq0b8eaqe8glsa7v49262dm2','','PHPSESSID',1363112315,1440,''),('6seaefas5jne51bqf5ed2nh0p6','','PHPSESSID',1363187830,1440,''),('6skugrr30tgv93cj361l8mfhu2','','PHPSESSID',1362855554,1440,''),('6t9fte808u5hpfaidns8mmvq27','','PHPSESSID',1363144473,1440,''),('6uc0cbj5l9e7fctqjpiujci3k2','','PHPSESSID',1362503229,1440,''),('6ul4kkgljrohc7uft7trkggqh4','','PHPSESSID',1363232534,1440,''),('706m6ann60au80l3qisl8hpfn5','','PHPSESSID',1362970881,1440,''),('70c2lrojlvft89n0t9tvftjup5','','PHPSESSID',1362856170,1440,''),('70d939rddbqic8i45dnlfdpgn7','','PHPSESSID',1362855216,1440,''),('70oqv6f3qvmh1pmo51nv1lcmn0','','PHPSESSID',1363144509,1440,''),('72n60n13cv46vnkf99egdrl1e3','','PHPSESSID',1362503241,1440,''),('73m3lmjk7oe5bdo3548m5sjie4','','PHPSESSID',1363144290,1440,''),('74tpfncov2ultbu7842alc0d75','','PHPSESSID',1362533230,1440,''),('75mn2hpg8ncn3isj9v69u1rbv2','','PHPSESSID',1362885811,1440,''),('7b0dcotgpa876hu1dvm1k3l3j0','','PHPSESSID',1363114331,1440,''),('7bb5ohivv2uj2gbe63js3t9i07','','PHPSESSID',1363232624,1440,''),('7brre89u3b56l1h3j2i33dlqk4','','PHPSESSID',1362679035,1440,''),('7ekvoadp2cbru3sujl2n74k0t6','','PHPSESSID',1362855263,1440,''),('7g758r09td8p7ov7366tkoi082','','PHPSESSID',1362885226,1440,''),('7i2m8jsr45gkpu0plp771rc9r7','','PHPSESSID',1362535096,1440,''),('7kbfi3mg9upg8rso066o8ff8q4','','PHPSESSID',1363185418,1440,''),('7kh2helfskkt60n3o3lbpi20e1','','PHPSESSID',1363187675,1440,''),('7l2j9aq28unr39kfffo2hmpmr1','','PHPSESSID',1362855374,1440,''),('7lul309fgim66csbitkhe8vdq4','','PHPSESSID',1363185402,1440,''),('7n4fjkiuq91282hvdj81h88sb0','','PHPSESSID',1362446944,1440,''),('7o6p693a75b6bh3cptb0qccjd6','','PHPSESSID',1362409432,1440,''),('7pbav3i5s401kv00olj2t4p4m0','','PHPSESSID',1362679354,1440,''),('7qdmqosu6r443k0lcchh95v333','','PHPSESSID',1362855423,1440,''),('7qphtqt3bd00fd1n0fhda5nia6','','PHPSESSID',1362854420,1440,''),('7qrcb7k5t12h9tagetsripv1o2','','PHPSESSID',1362503241,1440,''),('7s1ddegar4diadiorv46ki8qh6','','PHPSESSID',1363187948,1440,''),('7t5vbsdlshprag37imsh4c7375','','PHPSESSID',1363111842,1440,''),('7va6f5q4js1lmc1n877260gni0','','PHPSESSID',1363187836,1440,''),('7vco0e3hp1grbnukk2qrgdbff0','','PHPSESSID',1363232625,1440,''),('7vd22sb8cplevt9v5vdie53tc7','','PHPSESSID',1362504376,1440,''),('80c2fganpqmg84kj93k8g59ja6','','PHPSESSID',1362504296,1440,''),('82ee25uilbq00kt81cfiqn11j2','','PHPSESSID',1363111857,1440,''),('8474ph9p2bl606i997c348dja1','','PHPSESSID',1363113615,1440,''),('8724rstc2e4b36k2l546269860','','PHPSESSID',1363113277,1440,''),('898ji3jfdbfipos26i2l7vqr76','','PHPSESSID',1362855478,1440,''),('89gd1b42hcbi3saa9nrv6sqih1','','PHPSESSID',1362503183,1440,''),('8a62400pl0k80v0ls78irt3724','','PHPSESSID',1363186742,1440,''),('8b6jtlrel3j05uttjvc6p7eqm6','','PHPSESSID',1363114113,1440,''),('8b6qb3buh40tfbgmtc879a2hk7','','PHPSESSID',1363187463,1440,''),('8bm145a2lsb6ld9dljrvkiodj6','','PHPSESSID',1362885715,1440,''),('8d3p6kbptrevr2b17psamgabu1','','PHPSESSID',1363232511,1440,''),('8dca5cnp50kmidp9dmr2q367m0','','PHPSESSID',1363186450,1440,''),('8f0h2noa9iuhtk595cibbk2af6','','PHPSESSID',1363144079,1440,''),('8fakb3tbadqvva971mupb37uc6','','PHPSESSID',1362854648,1440,''),('8gmh54q79757eq9s4mtfs7ihc6','','PHPSESSID',1362707251,1440,''),('8gsekfb7jepb3nhq4hg1iadsb6','','PHPSESSID',1363144196,1440,''),('8gtqv37cujefggkup04glgkt11','','PHPSESSID',1362502749,1440,''),('8h11f8fmr5i2ffc07c6k6p1fv1','','PHPSESSID',1362408160,1440,''),('8hmquts2o2r8307uop77didib5','','PHPSESSID',1363185418,1440,''),('8iq7mj85krklsdg20p1pdpejc7','','PHPSESSID',1362856406,1440,''),('8j3idhia3uj67fh08tei43vrs0','','PHPSESSID',1363233033,1440,''),('8jrfvqutas1ksstbtrmf78a1h3','','PHPSESSID',1362855217,1440,''),('8khj5k8nevmtuh8fpc23isg5l4','','PHPSESSID',1363185252,1440,''),('8kraq6ljatipedd75gr344qua0','','PHPSESSID',1362855033,1440,''),('8le1l5k52q13arf3v645rjtem4','','PHPSESSID',1362857095,1440,''),('8lh29kuac9frrucp7oo7ktvij4','','PHPSESSID',1362880147,1440,''),('8psggced16ctjodsm8i9uhdu30','','PHPSESSID',1363185598,1440,''),('8qbbhtovlbgn0ebkt33pnobdj6','','PHPSESSID',1362678335,1440,''),('8rpchb1b5fcl2gr99jk8fgrb63','','PHPSESSID',1362855421,1440,''),('8t4o8vdpeubp1vee5st4pth4v0','','PHPSESSID',1362855035,1440,''),('8td4bhq2m9hvuehu5jeqe22h30','','PHPSESSID',1363186607,1440,''),('929de33gq6c8e3b6fvvt189u92','','PHPSESSID',1362855221,1440,''),('939m880ptmd2ku7a8ro71r61h0','','PHPSESSID',1362504305,1440,''),('96ddt4mf6kfmqcb24nmo9ddri3','','PHPSESSID',1363111858,1440,''),('96o4oit89b2rq6pf8uj26026n0','','PHPSESSID',1363188003,1440,''),('9838nmf14lju5ptodc0nr5rd67','','PHPSESSID',1362355256,1440,''),('98fcmubgs3uln8atbsqffbgi97','','PHPSESSID',1363185594,1440,''),('993jlieq61oich09kqudr2h9u5','','PHPSESSID',1362355178,1440,''),('997dr5kq4jkdj5ivl6fvl090v6','','PHPSESSID',1362970987,1440,''),('9ahg5rk41f3pv934csh7s4rco3','','PHPSESSID',1362500338,1440,''),('9arrmi2j5lvagm069l6rnuck72','','PHPSESSID',1363113616,1440,''),('9bd0uiu7u95jeih6mcsm145754','','PHPSESSID',1363144507,1440,''),('9bfeqab2c89v52mq0l2p4ausp4','','PHPSESSID',1362855216,1440,''),('9ckdctulcbs6lh6bfsdaqrvir5','','PHPSESSID',1362534473,1440,''),('9f96inqdbr72cbc4sqrvvr2g53','','PHPSESSID',1362355255,1440,''),('9fapbbv1ipfnccetpcdhfp6ba0','','PHPSESSID',1362504409,1440,''),('9hp174foaem84ierm1kuiureg4','','PHPSESSID',1363002843,1440,''),('9k2ls3p60m2hi3rbaijk7bq164','','PHPSESSID',1363111770,1440,''),('9k5tkpjpcnttjvvatqd4m0acg5','','PHPSESSID',1362884858,1440,''),('9ke1v84k5r87og53jgao6aq8f6','','PHPSESSID',1362409088,1440,''),('9l9m7be3qfqtmq6hjmguqut7e5','','PHPSESSID',1363232823,1440,''),('9la4rv6f1n9vdggautq0f269s6','','PHPSESSID',1362885071,1440,''),('9ls07iu1p9crod8lgpjapp5h85','','PHPSESSID',1363185402,1440,''),('9nla29lilal770nh48evpqfjk1','','PHPSESSID',1362856405,1440,''),('9p2tqqc3cbjhob6gia3hq01077','','PHPSESSID',1363113053,1440,''),('9p479p2b7gdg1aalm7s9h60mu7','','PHPSESSID',1362855218,1440,''),('9qdurf9a72v5nvgpgo2v6l0jh3','','PHPSESSID',1362503182,1440,''),('9rheviu1vgq98ja48su8fdl0s6','','PHPSESSID',1363144473,1440,''),('9rok4k24h7i63rkq4sp2udb3n4','','PHPSESSID',1362449528,1440,''),('9s8vt9n9fphsgfgtirc90urus5','','PHPSESSID',1363111844,1440,''),('9sdc8sec9acq3sujpi78mtr8u5','','PHPSESSID',1362958300,1440,''),('9stti7k1r5f1p8nioptor44ug3','','PHPSESSID',1363185301,1440,''),('9t2dld5gj9cfgn1grp32jvd2v4','','PHPSESSID',1362677310,1440,''),('9t73tgb1t2v7f41eqe56ji3d96','','PHPSESSID',1363187949,1440,''),('9tfg0mico4he7t4es4jo8v3lt4','','PHPSESSID',1362855424,1440,''),('9ttqh6hmqadsm0hmva4ujqhjo3','','PHPSESSID',1362533163,1440,''),('9uof7fhe07jtp6rm5mhjf6km24','','PHPSESSID',1362855766,1440,''),('9v1qaqum52phsfn253jt1p6qm6','','PHPSESSID',1363232510,1440,''),('a0s0jjo4o0gig1gff8di6qnlt4','','PHPSESSID',1363113904,1440,''),('a3t2moaqr58rl2rslmb3mdtt27','','PHPSESSID',1363186753,1440,''),('a4sai1f6uuhrfj30lscoqblgr4','','PHPSESSID',1363112064,1440,''),('a57l280ou0f0c0ibdgk87nlia3','','PHPSESSID',1362559810,1440,''),('a5c1bp1s70uunlrmjpghtfee40','','PHPSESSID',1363144391,1440,''),('a708vit7p8ckkes8b6fdt3b1j0','','PHPSESSID',1362971154,1440,''),('a9598b92rvt2lficn5jnoski57','','PHPSESSID',1363187854,1440,''),('abj1bj81ohhtr3q89c1763ukq4','','PHPSESSID',1363113273,1440,''),('abv1pgstiavnm8qflio2n55vh3','','PHPSESSID',1362971828,1440,''),('ac28pcbqv0df93hhqgmgrfurm4','','PHPSESSID',1363185270,1440,''),('aeqfon04m2gv0j55ep315sgdd7','','PHPSESSID',1362704992,1440,''),('ahhsgibht704gp2fj4n2ue0sr0','','PHPSESSID',1363232766,1440,''),('ajj5oihccf5idooa61dokn8l67','','PHPSESSID',1362885901,1440,''),('ajkir84tj5rg59g4jjf1l12qv2','','PHPSESSID',1362502759,1440,''),('akgm33hbhbskfbf7t0ovispji5','','PHPSESSID',1362855038,1440,''),('andd8kvl0g82d12krrm45138g3','','PHPSESSID',1363112077,1440,''),('annmq8964qrv5bs1levlptq7t6','','PHPSESSID',1363112797,1440,''),('ap4utt0ofgblu4nkbm31hd5o63','','PHPSESSID',1363186155,1440,''),('aph4ntu2ifstipup8g1anis183','','PHPSESSID',1363232470,1440,''),('aro4r8g9hl8sbdlc7itd8jvci3','','PHPSESSID',1362355178,1440,''),('asfo2bsk1oije8ua12drlhu3e2','','PHPSESSID',1363112080,1440,''),('atjmgqi8uh3j6msm7udfdvado5','','PHPSESSID',1362496734,1440,''),('au0cff26j0aijrk8njqaemgtl7','','PHPSESSID',1362855265,1440,''),('aurnajm6c8cdvkfbs5s8ree0e3','','PHPSESSID',1362677968,1440,''),('b0ik135s6tqu829glgarsvlkd1','','PHPSESSID',1362855419,1440,''),('b1eb4gdossdrmmmvo37bd1pgu2','','PHPSESSID',1362855422,1440,''),('b1t3j2it22ck8p4pl5hboi2116','','PHPSESSID',1362855419,1440,''),('b24b8rb3biot0uqmb9t724f9q1','','PHPSESSID',1362855373,1440,''),('b2lpk1hgv2tqcigsvpln8n7up2','','PHPSESSID',1362855221,1440,''),('b43sa7tk84f05dhlsern4ev9u5','','PHPSESSID',1363144549,1440,''),('b4j5l6pl8e94vif6ouaem5to76','','PHPSESSID',1363113876,1440,''),('b6k1obticbu4dfu77c3q74u8t1','','PHPSESSID',1362886233,1440,''),('b7uj9qkas9c18avfllka40uo31','','PHPSESSID',1362885224,1440,''),('b8smccu6lgk1954ijuj869qoj4','','PHPSESSID',1363144551,1440,''),('baq3qq3gjp2u0fu4sur5cr1p10','','PHPSESSID',1362503184,1440,''),('bbukbfqosn90pjv0e332t6fo92','','PHPSESSID',1362856891,1440,''),('bcjsjmhton3r2apv1bj1dao8f0','','PHPSESSID',1362677181,1440,''),('bd43j7o6t9m9akbc9m861lesj0','','PHPSESSID',1362855214,1440,''),('bdl8can368rksga12g0iulfid3','','PHPSESSID',1362447395,1440,''),('bdrpf1960ffj2ia3c1l9fe14e7','','PHPSESSID',1363232762,1440,''),('be8v1n2jdei6shr5gn9b4jc236','','PHPSESSID',1363012012,1440,''),('bf8k4siigja8op20f8mccvs4n2','','PHPSESSID',1363144513,1440,''),('bhr719f12h2uu9blsqmuc8a336','','PHPSESSID',1362855349,1440,''),('bjve1kmlni2qsahq3brrmps0h0','','PHPSESSID',1362855264,1440,''),('bmqb02dq3l4q0l7j1bftrpbbu4','','PHPSESSID',1362534747,1440,''),('bmrvi5q0k8n15nrqhu40694cf6','','PHPSESSID',1362355257,1440,''),('bmu9dcpkc9er6pbnvljgeenp96','','PHPSESSID',1362503183,1440,''),('bmvonmqg5l2oaauecej8lbpku5','','PHPSESSID',1363232952,1440,''),('bn2fcjkm4m3bf7kh53n99fq7c0','','PHPSESSID',1362886135,1440,''),('bn4mcaotgv0423mrmks2gpfmf1','','PHPSESSID',1362449308,1440,''),('bnd0th0e3urmmo1c3dcqh295b7','','PHPSESSID',1362678335,1440,''),('bonkm4g8kov4srsg9utol1lgs6','','PHPSESSID',1363185430,1440,''),('bope4880c7ul94uo80qvrkjmd7','','PHPSESSID',1363184999,1440,''),('bpalk0n0fmh2pp3d7v3nd0gaj6','','PHPSESSID',1362679356,1440,''),('bsffa27tvbk09sjrt8a74q0k00','','PHPSESSID',1362854735,1440,''),('c0fjg7amsga1v4t7ermc5e6ia1','','PHPSESSID',1362884333,1440,''),('c198cgd5enkn6380ismhjvi5g4','','PHPSESSID',1363144511,1440,''),('c39ut08ngg174ac6tf7d0f5s32','','PHPSESSID',1362855374,1440,''),('c3r1oeu2d18dpmp7142ft2lo26','','PHPSESSID',1362409087,1440,''),('c4h9f9dt4hrjrj9lto7m0oik00','','PHPSESSID',1362679330,1440,''),('c5ko3ns6f01gqu9ioj8oaf5vj7','','PHPSESSID',1362970885,1440,''),('c6ejsm4blvakc6cfbgc8m5q8c6','','PHPSESSID',1363111836,1440,''),('c7jm46p5fntrcfn2eq5onhgok2','','PHPSESSID',1363171191,1440,''),('c7pn4j5hbfpkshnd0tfqj9ejq0','','PHPSESSID',1362679264,1440,''),('c7uhed00k98j8ep3pa2f59pqi7','','PHPSESSID',1362855554,1440,''),('c8djduqsnkmsdhu3cfns19u8o3','','PHPSESSID',1363112317,1440,''),('c9tq7vsfm5brc1o44nualc3hl5','','PHPSESSID',1362679407,1440,''),('caqov5h66ftokocmtmt8610b45','','PHPSESSID',1362677184,1440,''),('cbnja67pn9m2li244nn7iaq6e0','','PHPSESSID',1363144289,1440,''),('cf8appkkc3enp7kf5c2bvi94j1','','PHPSESSID',1363114333,1440,''),('cg6ln5bctteo3mol28jpomkrh6','','PHPSESSID',1362855351,1440,''),('cjnmhr8kfs9hv7pa6gpmerqo63','','PHPSESSID',1363232830,1440,''),('ckeg90jtkvocacf9ofai7seqf4','','PHPSESSID',1363112798,1440,''),('clf2i6ec0bihi01ufr2ptgb7n6','','PHPSESSID',1362884586,1440,''),('cmcp4itthdidp1da60fb9fj8a1','','PHPSESSID',1363187868,1440,''),('cnk24mbilk70ujtk0mkdl1hof6','','PHPSESSID',1362855265,1440,''),('cnl6ddbjn0q0noftplf5ocju25','','PHPSESSID',1363187463,1440,''),('coaccc0835j97q4prhieb27584','','PHPSESSID',1362504577,1440,''),('crroolmqdchpge2fls7idc6kd0','','PHPSESSID',1362533164,1440,''),('ct3532bj1h3384b1jbociifst0','','PHPSESSID',1363185966,1440,''),('cu7bad551lvoadt3jnl0fv55r2','','PHPSESSID',1363185002,1440,''),('cudsti724mqjlvlleocqth8ng2','','PHPSESSID',1363186806,1440,''),('cv5j04gq2c03755g6k54seq616','','PHPSESSID',1362885811,1440,''),('cvafih3gblhudek5svhfusk7p3','','PHPSESSID',1362856893,1440,''),('d1bd2u6kmri9gfebtj0ca13785','','PHPSESSID',1363186444,1440,''),('d1lqsvq5k4gccro5jfg9shbb91','','PHPSESSID',1363144514,1440,''),('d4ct00dt6l5m62nuh2gkhdq3i0','','PHPSESSID',1362408159,1440,''),('d5qlka4qbg15krmju2i996unc7','','PHPSESSID',1363111771,1440,''),('d68tuulksklvhur2i8mtheoft5','','PHPSESSID',1363187851,1440,''),('d7dcm85csoesisf5samo3i50t6','','PHPSESSID',1363187837,1440,''),('d7sg1mpnhsrm8hh0r827kqt8s3','','PHPSESSID',1362706509,1440,''),('d8hcpi9cs3ohgntvpilnmtab40','','PHPSESSID',1362884958,1440,''),('d94f5esv82qjq0bo7tn4j1vai1','','PHPSESSID',1362533333,1440,''),('d9pg787l4bsvaqvocpsh1utn66','','PHPSESSID',1362855310,1440,''),('dahfcvdsiv4gvdpredcm1o6au6','','PHPSESSID',1362884588,1440,''),('dcliomggetc0kq58viui462sf2','','PHPSESSID',1363144516,1440,''),('dd6v8cjpqjefq3cfecbtiio9p2','','PHPSESSID',1363187833,1440,''),('ddf57gdccc47ic1c7l3oggdut3','','PHPSESSID',1362422866,1440,''),('dgg57jipicjv7clpnljiuho6c5','','PHPSESSID',1363113280,1440,''),('dhdk4r5ce2nnp1rjqgl2lgvgg5','','PHPSESSID',1363232956,1440,''),('dl2hbfmbc1h58q32ub130f97l5','','PHPSESSID',1362678310,1440,''),('dld3ruro5o23aaf5f923ftlts1','','PHPSESSID',1362884563,1440,''),('dlv29dc1b98iuuvntduvmllfm7','','PHPSESSID',1362449289,1440,''),('dml93kbgqcpm5kmast6f154oq3','','PHPSESSID',1362855012,1440,''),('dmmv8scrl5o8ro900svgo25907','','PHPSESSID',1363187497,1440,''),('dnoceeu7lsfdcemredrkgalgv3','','PHPSESSID',1362855351,1440,''),('do9t6jpndt3nkv5510a5v1u697','','PHPSESSID',1362707174,1440,''),('dsdds7kjujc1mqtvld3in4hsl3','','PHPSESSID',1363185276,1440,''),('du0kdlua58nc5tdueer8vc6l52','','PHPSESSID',1363144360,1440,''),('du9jmdeop6rdpnmkgjiunn9q66','','PHPSESSID',1362533334,1440,''),('dv0cf5mqi6d0e1k84ar87bk8s6','','PHPSESSID',1363113048,1440,''),('dvc8sqdfrkj7bar1hvf59uilu3','','PHPSESSID',1363144473,1440,''),('dvd4f2viff6ml92e82uabs6p55','','PHPSESSID',1362676222,1440,''),('dvkcj86oe8vgtppiu49o8dsg20','','PHPSESSID',1363113049,1440,''),('e2p18nf4dg8t9ktkt5mob4sig4','','PHPSESSID',1362885941,1440,''),('e5dcm76c2f007j7iaacfhvfnd4','','PHPSESSID',1363112496,1440,''),('e6if5569sigqtj2cpu74tosa91','','PHPSESSID',1362534559,1440,''),('e71hp96ljcabmumbtmtvces0h7','','PHPSESSID',1362504476,1440,''),('e89uu6cktl3262jkesm77lq0e2','','PHPSESSID',1362856381,1440,''),('e9msi3k92a3p0ur4cff29lkj74','','PHPSESSID',1363144118,1440,''),('e9n4fi1vfloqnste3heg83stq7','','PHPSESSID',1362355289,1440,''),('eb5t6o1f8mtv8qhh5kmokt0r05','','PHPSESSID',1362449288,1440,''),('ebf7ttgfqcsnn0mnms1bdmgs11','','PHPSESSID',1362358385,1440,''),('ebh6i8upm76502u0b44bqosuo0','','PHPSESSID',1363112808,1440,''),('ebrqkvj7glob0sov2ihf8o0335','','PHPSESSID',1362855417,1440,''),('ec7og92n30jch8anm7tm7qtbf5','','PHPSESSID',1362884831,1440,''),('ecfcc4huu2ai0vedsqivcmko05','','PHPSESSID',1362534613,1440,''),('ecpq32phjn3fi7tjlc86tl7ht5','','PHPSESSID',1362503241,1440,''),('ee59gm7pv33haghnpbnhodt6h2','','PHPSESSID',1363232851,1440,''),('efb2c4j5eqj1n5fu1drb6n4jp1','','PHPSESSID',1363185325,1440,''),('efnalb4haodlk7qfvt1f5gg877','','PHPSESSID',1363111838,1440,''),('egvu6t5duuid7ehh2cmgfs6tn4','','PHPSESSID',1362679036,1440,''),('eh8gcmarvnpdo7aaedb9h51qq0','','PHPSESSID',1362855607,1440,''),('ehnjrj9gt1ajovbhaeeimmdgk2','','PHPSESSID',1362355203,1440,''),('ejb7fe9lod49492l6bs2tghi82','','PHPSESSID',1362884598,1440,''),('ekim3fmls3q66n0lr137sflca7','','PHPSESSID',1362504334,1440,''),('ekiosnlqci91o7crdmropsmqm1','','PHPSESSID',1363185109,1440,''),('em1cvot7c468fvrj7beriaord0','','PHPSESSID',1362886005,1440,''),('em4epl399putlivec668b32hk1','','PHPSESSID',1362447394,1440,''),('em73gcle1ekq7icjmcim01jbc3','','PHPSESSID',1362855416,1440,''),('eoceep6er1qseelva09uvp6hv0','','PHPSESSID',1362502164,1440,''),('ep63e0olbmr7p6qcgenp3hjpm6','','PHPSESSID',1362533158,1440,''),('epr1hk2ikhg7d21qdbm6u4pi17','','PHPSESSID',1362534472,1440,''),('epu59k6ol315f07nbc2hp856d5','','PHPSESSID',1363113050,1440,''),('erqe0kp24k9ku2btbi8mufqcp2','','PHPSESSID',1363186612,1440,''),('es9rs14tr4keash449243g6t05','','PHPSESSID',1362679356,1440,''),('esrc9q1dc4t0ho2de4lvadqsr1','','PHPSESSID',1362533449,1440,''),('eu820usqigcsmg2tec4744e462','','PHPSESSID',1362355288,1440,''),('eu851md8llkd7fe2jepa9o4f51','','PHPSESSID',1363187905,1440,''),('f0dt36vdrn6a9ckhgqfokgiki0','','PHPSESSID',1363232500,1440,''),('f0q9l8o6a1sp66egi4d7eb9ik2','','PHPSESSID',1362504323,1440,''),('f2mao9cihpbrkuv1ttvu0nm2u7','','PHPSESSID',1362855422,1440,''),('f6e86bv9973ioo3e3or66iaci3','','PHPSESSID',1363232625,1440,''),('f71v4laiire605k46gp8shpmu4','','PHPSESSID',1362503187,1440,''),('f7ejpdb00phke56hhj3gpj7561','','PHPSESSID',1362355286,1440,''),('f7thgt0v13329tkjms63cau4i3','','PHPSESSID',1362678434,1440,''),('f9rdd3pkd1sfaeb26krhuq2ev5','','PHPSESSID',1363232763,1440,''),('fa4ipfhj596fau9bv79nlg8662','','PHPSESSID',1362359143,1440,''),('fa5234vlle7j346ufvvifn7el5','','PHPSESSID',1363187498,1440,''),('fc8nt0p12fnrs7mrr8q50n83b1','','PHPSESSID',1362971952,1440,''),('fdjssds027mumhjmbque3241u5','','PHPSESSID',1362854733,1440,''),('ffjpg2922t9mebeku2nguseg13','','PHPSESSID',1362885804,1440,''),('fi8qg61ols1u1vdr9cikafh1h0','','PHPSESSID',1362884830,1440,''),('fidr0f5kccj16g7jsm797jjo91','','PHPSESSID',1362855220,1440,''),('fj0di0skmbv8pk0morrvqjmic6','','PHPSESSID',1362447125,1440,''),('fjloqc6crceb4n0ds72oanpcp6','','PHPSESSID',1362502019,1440,''),('flmatr43bsrrll5n7s20hp6vk5','','PHPSESSID',1362886232,1440,''),('fmdt7oivs8nbk67bkotcnbfai7','','PHPSESSID',1363185106,1440,''),('fniuoatq44nb3i638upqfjdlm6','','PHPSESSID',1362857097,1440,''),('frdgvmjn1m0n8dqonbjib6ruc2','','PHPSESSID',1362855768,1440,''),('fth53k94cf8tfnaak7bbuo4h83','','PHPSESSID',1362677932,1440,''),('ftjj178jd0ikc88c9qr0r7mgc3','','PHPSESSID',1362856371,1440,''),('fuislgfmk0pd80s7lf7ifiq2d6','','PHPSESSID',1362855037,1440,''),('fuqc854m0dbh8gmlnk4ie66ge0','','PHPSESSID',1362533347,1440,''),('fv0r5ldn38hv0ipkcn807grre3','','PHPSESSID',1363187843,1440,''),('fv805cg85dbklkkku8er2l6f33','','PHPSESSID',1363114308,1440,''),('g0m35ta1nbaf0701i24o08j3b3','','PHPSESSID',1363232831,1440,''),('g3dj98i4rtqfhue6qsti89psv7','','PHPSESSID',1363185254,1440,''),('g49tiihabjukfksv7it1a514g1','','PHPSESSID',1363186613,1440,''),('g4agokd4sck5c5a6sbp9mh97e1','','PHPSESSID',1362970979,1440,''),('g52o8cjeclelm4lacq59hauin5','','PHPSESSID',1362355290,1440,''),('g57tb9jfdgntciasdl7et8vdk5','','PHPSESSID',1362447473,1440,''),('g639584hecfs251ohqehff4t14','','PHPSESSID',1362855416,1440,''),('g7acdce57uggrs6l9i745p09s5','','PHPSESSID',1363185110,1440,''),('g97ea4toelemut5drb3elfa315','','PHPSESSID',1363113618,1440,''),('ga4dnj5khoe80dfrjb8kcvhhs6','','PHPSESSID',1363187624,1440,''),('gaoj15l8du4tejou5favg8a4v7','','PHPSESSID',1362704995,1440,''),('gcgro6t032c8kcbsug94ou3025','','PHPSESSID',1363004712,1440,''),('gd5qpe1868qsqss5gpijnf5s71','','PHPSESSID',1362355291,1440,''),('gfc062fuu32on6t3od9ltntb36','','PHPSESSID',1363112315,1440,''),('gfk8htvkt6dqrjtmeutt9gq7s2','','PHPSESSID',1362855219,1440,''),('ghcfrs1blpvbjl0b1mdav0rl87','','PHPSESSID',1362504306,1440,''),('giq3sbsrt3q6kta3rtm59eke60','','PHPSESSID',1362678342,1440,''),('gjmvrgfk9ig7s88k87d476leh7','','PHPSESSID',1362885900,1440,''),('gjobdtegifbdasgi36lh6jfd97','','PHPSESSID',1363186746,1440,''),('gk1tr37bv2akelverqtcojkhr1','','PHPSESSID',1362504329,1440,''),('gkq8ktpe1ngn4ue9g502v4id84','','PHPSESSID',1362855217,1440,''),('glh4vde2ouvdenn3se26dl3ol1','','PHPSESSID',1362970979,1440,''),('gnj29f1uetvmmdenogg08au643','','PHPSESSID',1363232765,1440,''),('gnp3se0p30s9vtfvcd77l6khr6','','PHPSESSID',1362422945,1440,''),('gp58kqmetjeieq43sf69ruj6j2','','PHPSESSID',1362359139,1440,''),('gpumlekh8as1d7kk2ee0bvuu77','','PHPSESSID',1362855417,1440,''),('grff9es8c55u3giip6bq582mc2','','PHPSESSID',1363185417,1440,''),('gsh92bu71d6obi3t7mksll3554','','PHPSESSID',1363112806,1440,''),('gtno463eu4bu8ht3vjean19ga6','','PHPSESSID',1362857100,1440,''),('h0actj74l728tr54sfa039cmp5','','PHPSESSID',1362885807,1440,''),('h0o9apr70mhll815o0s8lb7o32','','PHPSESSID',1362534362,1440,''),('h2b8n05in9o1n3jqae9h5d4tp6','','PHPSESSID',1362855264,1440,''),('h2o7aql542ibvj7rvcr29ledu6','','PHPSESSID',1362854759,1440,''),('h33l8v3c3l6ldlvlbv5vcdq4v6','','PHPSESSID',1362855033,1440,''),('h3q1eqfi0hls727oqmprt2udn7','','PHPSESSID',1362504347,1440,''),('h3vot5uifad7rkssgc4nra1q71','','PHPSESSID',1363186451,1440,''),('h46riu71g1rtihrgvuihd07f75','','PHPSESSID',1362355205,1440,''),('h4d6m6rtcehf05d5uv00hu4j46','','PHPSESSID',1362676226,1440,''),('h4p0ruavjv5cch00gukl3an612','','PHPSESSID',1362855470,1440,''),('h4s8bma9u9btv8rkc8932uu493','','PHPSESSID',1363144493,1440,''),('h6ljo2tnst233v3hf3kq30kp81','','PHPSESSID',1362857133,1440,''),('h78p7i8t18plv45l9bsnpf22e6','','PHPSESSID',1363187913,1440,''),('h7unn1m8shcaje94mcs48euj24','','PHPSESSID',1363144548,1440,''),('h8b13cen49k6vcp7m964mfp7r4','','PHPSESSID',1363113050,1440,''),('h9imfl23lodq4btc5u6vc6rfa6','','PHPSESSID',1362854699,1440,''),('h9k9smv22nea6022ab0pk7crb5','','PHPSESSID',1363113440,1440,''),('ha5k4t9r55e2j3it8k7c4l2ac4','','PHPSESSID',1363113051,1440,''),('hbrrn0fdl5rp3u058ajquivcr4','','PHPSESSID',1363144079,1440,''),('hcgc0spe9q06bggrcsms6ooan3','','PHPSESSID',1362503182,1440,''),('hdi7ke11dv01lsa49ijc68ao37','','PHPSESSID',1362533336,1440,''),('hdl17k2oss9rpkql7p2lkjh5n3','','PHPSESSID',1362880163,1440,''),('he978nm5pcgpac99e2k4tkv5t5','','PHPSESSID',1362449308,1440,''),('heclivtj575rgouj0pm23hnve1','','PHPSESSID',1362855419,1440,''),('hi2r3blibi1mhcq9k42ebeju96','','PHPSESSID',1363232534,1440,''),('hig14usi5b5oalho0qb7echn30','','PHPSESSID',1363144117,1440,''),('hiruupc2upvuuj4p8ojq1rksv1','','PHPSESSID',1362679331,1440,''),('hjivvg0qfr1c5uf5o49r22ht36','','PHPSESSID',1362886446,1440,''),('hk19fohj47d3q2r729ec72rf61','','PHPSESSID',1362423624,1440,''),('hl8brtp1jqsq57jqqhski65dj3','','PHPSESSID',1362854759,1440,''),('hlkc1rk723bkgi9ac0c70hrsj3','','PHPSESSID',1363233032,1440,'dlayer_session|a:2:{s:9:\"module_id\";s:1:\"3\";s:7:\"site_id\";i:1;}dlayer_session_form|a:2:{s:7:\"form_id\";i:1;s:7:\"tool_id\";N;}dlayer_session_template|a:3:{s:11:\"template_id\";i:1;s:7:\"tool_id\";N;s:15:\"selected_div_id\";N;}dlayer_session_content|a:5:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";N;s:19:\"selected_content_id\";N;s:7:\"tool_id\";N;}'),('hnk5b5al1t47suiisncgjg3ir0','','PHPSESSID',1362355286,1440,''),('hpoe1oqu7c5irscvmd50k9e1o1','','PHPSESSID',1363113906,1440,''),('hpufm3qg37nm75q4rrtdnranf3','','PHPSESSID',1362880169,1440,''),('hu0oes3cbfg1npb0trj0j09gu4','','PHPSESSID',1362533208,1440,''),('hv08pcrkoa0pr0dc125nl7slt2','','PHPSESSID',1362855423,1440,''),('hvn2tdkottceau6d3mue3fulh2','','PHPSESSID',1362446947,1440,''),('hvrhunu7q261q4a332fpi8dr11','','PHPSESSID',1362678438,1440,''),('i09hojd64cdv5uuh50rg59i883','','PHPSESSID',1362855121,1440,''),('i11co0qrbohr5munvht6s35oe4','','PHPSESSID',1363185964,1440,''),('i12jqfoknc977jn8cecgoga0c3','','PHPSESSID',1362405072,1440,''),('i1dfd9gsdmcamc5qp0uldv3io7','','PHPSESSID',1362885894,1440,''),('i3gjbhtp40ed42473dnj8bunq5','','PHPSESSID',1363112462,1440,''),('i3rlkr6rdq1e8tbm277ufen0s0','','PHPSESSID',1362421777,1440,''),('i5mkou5pjavt4uojjv5qo92sj3','','PHPSESSID',1363186758,1440,''),('i6mp4maf4oo96rdr69c0nhoat3','','PHPSESSID',1362503240,1440,''),('i71ateuvk45fkejth28o55duv0','','PHPSESSID',1362502748,1440,''),('i7bojcaontqjskmvdh2arpd0n7','','PHPSESSID',1363113274,1440,''),('i9o17jjauk70q8uunv17f898h5','','PHPSESSID',1362706510,1440,''),('i9o17uhfdi9g8a62m43m7t9qb0','','PHPSESSID',1363113442,1440,''),('iara30r1imqhe41lvep9nqcrf7','','PHPSESSID',1363232452,1440,''),('ihb1rtml3652mbai6qj92t47e2','','PHPSESSID',1363112316,1440,''),('iihgtabiq891hd7uv9p9jdm895','','PHPSESSID',1363232936,1440,''),('ij6n1fjsacbh021r4q3uri92h0','','PHPSESSID',1362534367,1440,''),('ij8l0sei48v0tth2biph97u8j2','','PHPSESSID',1363186698,1440,''),('ilkgvg2827n5v6ueptg9dl3kg6','','PHPSESSID',1362678319,1440,''),('iln08o7pfg6b6lu90i8bo0jg80','','PHPSESSID',1363232516,1440,''),('imvbgc5qg4omh9373ooj6jq143','','PHPSESSID',1363144196,1440,''),('ip3qp193dt0ime4koltdat4oc1','','PHPSESSID',1362884563,1440,''),('ir4mlbf2vl894ms1abqoov51c4','','PHPSESSID',1362677933,1440,''),('ir77716mqecn8etefmhok862s0','','PHPSESSID',1362449603,1440,''),('irmidn6eivpssbjloi64iipf62','','PHPSESSID',1362359136,1440,''),('irt99m6gl236ru6eklmvau1d17','','PHPSESSID',1363144577,1440,''),('it0ud5utnc4c7uv6vmotmudp21','','PHPSESSID',1362855421,1440,''),('j1gapje8jfjih760488a6iilt3','','PHPSESSID',1362679778,1440,''),('j32dccig21jhgop89tkkdtra97','','PHPSESSID',1363232848,1440,''),('j3d7utpin9psrcfh90vhaev4t7','','PHPSESSID',1363114313,1440,''),('j3rmhdcijiolfqardtj4d9pmp1','','PHPSESSID',1362534651,1440,''),('j4p6esquk45arvvjp6om65kcm7','','PHPSESSID',1363186679,1440,''),('j596e26c79515lmb8b9me42214','','PHPSESSID',1363144494,1440,''),('j5b12rtj0s69puue1ptm2jm3f4','','PHPSESSID',1363144195,1440,''),('j62d520nhl32rggmcbrjqf3d43','','PHPSESSID',1362678349,1440,''),('j6kfcbmherfqlmgm751qa53r86','','PHPSESSID',1362884336,1440,''),('j9b5ud8u4gn50m1a43a2gg7tq0','','PHPSESSID',1363112755,1440,''),('j9iddtvfraknemkbql5sjfbfu1','','PHPSESSID',1362704993,1440,''),('jb5uvo1dfif599jqj1uiplvs65','','PHPSESSID',1362855419,1440,''),('jeso4b71bp8321ala4sg169dq2','','PHPSESSID',1362679281,1440,''),('jevjqmcoqcf5k2kv4oauv0tvu5','','PHPSESSID',1362971719,1440,''),('jfnb7co9762gvedubknq5mouj4','','PHPSESSID',1362970881,1440,''),('jg051l4m3mpbopjborqc4v59a3','','PHPSESSID',1362970977,1440,''),('jgjihqitolirua148ptnoahtk3','','PHPSESSID',1363111840,1440,''),('jgk1uv2unmcuqms3kuc989b5j3','','PHPSESSID',1363144017,1440,''),('jktq7j1n29nlcsnl1d2su0p6f7','','PHPSESSID',1362409449,1440,''),('jm9otas8r7uoo7dnv9lo48f6a2','','PHPSESSID',1363144196,1440,''),('jpvubsm6kgmsm8lgvpv01dilo6','','PHPSESSID',1362677316,1440,''),('js9h0gd0gprrvc1868o4vgh3r2','','PHPSESSID',1363186608,1440,''),('jsau8u8lut26smn7oe32utvj22','','PHPSESSID',1363112879,1440,''),('jtlav5844nlkij9atsj7qj4n30','','PHPSESSID',1362678326,1440,''),('jutgl5mu3bkji4t382c8vqjfh6','','PHPSESSID',1362679036,1440,''),('jvd6lkpustsmu9thqms1q432k4','','PHPSESSID',1362503183,1440,''),('jvgppmi2a254ss38tqj6edglh7','','PHPSESSID',1363191605,1440,''),('jvh20c2bsj9fvnm5qvtb049686','','PHPSESSID',1363185590,1440,''),('jvqfv9mjqal2snh21kh5jdm9d2','','PHPSESSID',1363144392,1440,''),('jvv6gun7mfg4l3eoculnk4jvl6','','PHPSESSID',1362677981,1440,''),('k229616gg6435pg26j27fgff55','','PHPSESSID',1362447386,1440,''),('k32v0n2kicve64ggb8evntrvg7','','PHPSESSID',1363187726,1440,''),('k3vilhapg8hc39npdfblk01jp1','','PHPSESSID',1362855443,1440,''),('k550phnsjhan1lt7toj60hecv6','','PHPSESSID',1362856821,1440,''),('k6utheu237e0p855gda621a5k5','','PHPSESSID',1362855478,1440,''),('k71aev4u08but9ovumktbltl22','','PHPSESSID',1362503183,1440,''),('k7q1jeen6mfo225k63am9c11c1','','PHPSESSID',1362971167,1440,''),('k8ruq7868lfug7h74ehbc6ndm1','','PHPSESSID',1362855219,1440,''),('k95qre51v1clh8ug87j9apvnc6','','PHPSESSID',1362502020,1440,''),('k9acfem4sfkb07jv6d4smd4474','','PHPSESSID',1363114002,1440,''),('k9gg46abnu1dt7gsefbtkit6n2','','PHPSESSID',1362855423,1440,''),('kc815mco1chnrvho3pksmcuft3','','PHPSESSID',1363187464,1440,''),('kcdp1pp3r1uk58f24tlg7ukni4','','PHPSESSID',1363187835,1440,''),('kd3l41o75t3noj3lspa8nt8nn7','','PHPSESSID',1362508178,1440,''),('kfkrqgcatlgr6tmr8m74v19pq7','','PHPSESSID',1363114332,1440,''),('kg7908opdbaaajhm1osf7slg74','','PHPSESSID',1362707251,1440,'dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"4\";}dlayer_session_content|a:5:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";N;s:19:\"selected_content_id\";N;s:7:\"tool_id\";N;}'),('kh95ndoj8k4oipls4m0b3qrfp1','','PHPSESSID',1362447126,1440,''),('khkd8ke777t1gl8dp3mltt3pd3','','PHPSESSID',1362502086,1440,''),('ki6dsqk62vfqn8h3p1rq9tfoi3','','PHPSESSID',1362679777,1440,''),('km786f9mmb66nhk1c2mm2ci6j6','','PHPSESSID',1362447456,1440,''),('knkctea7uraljoa29fopmjks63','','PHPSESSID',1362884856,1440,''),('koc0828c2bi1dna2lfiifcm6j0','','PHPSESSID',1362855094,1440,''),('kpd50fdg6rfoa7mgpn7414go97','','PHPSESSID',1363114252,1440,''),('kpvsg2pnig93ct114ktu0trm90','','PHPSESSID',1363187917,1440,''),('kqgniab3q670gpm2ph1ll8c786','','PHPSESSID',1363113907,1440,''),('kr2nmoclh5emjbci5jq0ee3v23','','PHPSESSID',1363232935,1440,''),('kste7qoe36iqdk2l7rna25h9v4','','PHPSESSID',1362855220,1440,''),('kvnmms6qpc0r1vmk3pv9po9a45','','PHPSESSID',1363232847,1440,''),('l1ineatjmtpomov11of3480k42','','PHPSESSID',1362707214,1440,''),('l2a7dfehjarce30aukelifqad1','','PHPSESSID',1362855608,1440,''),('l47u4fink7shfniltv72i8l9e0','','PHPSESSID',1363185332,1440,''),('l5216p9kfcj9mdq25e67rm12j6','','PHPSESSID',1363185112,1440,''),('l5hvpqrp430mg0koeodv0iv1b4','','PHPSESSID',1363185179,1440,''),('l69780sl60hbbul8s8jj04frf6','','PHPSESSID',1363187464,1440,''),('l9erhvo8dokfl25duang7hris1','','PHPSESSID',1363111845,1440,''),('la2cleb27ci836ju5qt0572a84','','PHPSESSID',1362676226,1440,''),('laa4ernfmdomfnupo0iu9bquq2','','PHPSESSID',1362447385,1440,''),('lapp9ci3qm2hp2t8bend1jig64','','PHPSESSID',1363185274,1440,''),('lbic9i94j4150n5fjjhqv0vum6','','PHPSESSID',1362856814,1440,''),('lbvo0lmf6alcl1p7anme115ld7','','PHPSESSID',1362496736,1440,''),('ld12t6h4k5cooih4rpcie52l33','','PHPSESSID',1363185277,1440,''),('ld3a5v9cq0g1psm9kcooki8du2','','PHPSESSID',1363185251,1440,''),('li49dfv3fu01n10gqvm8m4c5d2','','PHPSESSID',1363233025,1440,''),('ligol2fpj97m7bu99hjhk9nfq4','','PHPSESSID',1362971125,1440,''),('lingjrf1tnov1mha57b5vsvc06','','PHPSESSID',1362857099,1440,''),('littv4rll46065ej8i4ghut007','','PHPSESSID',1362677604,1440,''),('lld6e1u78ki07l0rf6u6e5he03','','PHPSESSID',1363187998,1440,''),('lmg9f8j7dpa9hf81c1qmsddq07','','PHPSESSID',1362855215,1440,''),('lmtdumg4mnngroiqu4kob1nlv3','','PHPSESSID',1363144195,1440,''),('lnhu3vstm4p2355bprbb27j9a1','','PHPSESSID',1363144505,1440,''),('lnuiq3abpmaem4sn99btt347m3','','PHPSESSID',1362533173,1440,''),('lr3acj9lr4fnftv4er00vus186','','PHPSESSID',1362855765,1440,''),('lrlcm43ukdjq1qd7ah23h0j5e0','','PHPSESSID',1363112312,1440,''),('lsupt6do0tf5clsk38v2rgrfj7','','PHPSESSID',1362884830,1440,''),('lv5jin370o5dr7acejknfaf7i7','','PHPSESSID',1363144078,1440,''),('lva75b072vqr36v974pm3suee0','','PHPSESSID',1362855470,1440,''),('m06vjupg7ngo0kcisk22b96p44','','PHPSESSID',1362502017,1440,''),('m1r9v233qqfra0muf5e8qucl26','','PHPSESSID',1362677604,1440,''),('m2e4ui5en1jiuij7crndmdqdi2','','PHPSESSID',1362970884,1440,''),('m2lkhk5efl41b87oigto54bv06','','PHPSESSID',1362855424,1440,''),('m3663evmgd59ld4hggii4b5ds7','','PHPSESSID',1362855443,1440,''),('m3935kdqgrk3akrf8cdkqugk06','','PHPSESSID',1362496737,1440,''),('m4u7hae1vh27f57abcu9ljv4b0','','PHPSESSID',1362447474,1440,''),('m5gv91jt2hv4ltv5ud09a947s4','','PHPSESSID',1363113905,1440,''),('m790mbrp7kn2tv06k7t8o9c6g0','','PHPSESSID',1362679281,1440,''),('m7tf91q3utqnf7fehoq713tmm0','','PHPSESSID',1362504363,1440,''),('m92cvgr719lhti2s2r8ea3i2i7','','PHPSESSID',1362355219,1440,''),('maq2rn5623ppr8vn1usr8eu0k5','','PHPSESSID',1363232515,1440,''),('mdqcsep90ve2jpntnukk4s3bv4','','PHPSESSID',1363144119,1440,''),('me15pjdnurp43op82jsu8p8hn5','','PHPSESSID',1362679356,1440,''),('me4lusrp8orpn47ol0n47oet93','','PHPSESSID',1362504351,1440,''),('meeunsc4m264lium73dbjtd7n5','','PHPSESSID',1363187913,1440,''),('mg7f6jcuo48r8fsd9nf2e5mr86','','PHPSESSID',1362884562,1440,''),('mi3fohrai9p5raj7llg6c0mco2','','PHPSESSID',1363113631,1440,''),('miirr05jtomb9088tvdfg3rgd3','','PHPSESSID',1363187456,1440,''),('mknsnmoujcnaflt81o6r62kgl0','','PHPSESSID',1362355177,1440,''),('mlqc8rn90l0d6btdm565pu1cm0','','PHPSESSID',1362706525,1440,''),('modibvnolm0mumg0vrjav65cb3','','PHPSESSID',1363144077,1440,''),('moh2t8nqdj1oe5qhjkblb8po97','','PHPSESSID',1362885807,1440,''),('mou22f9981j4tgnqjpn0dd4fb2','','PHPSESSID',1362855351,1440,''),('mp8uh7m3i3nb1v7ik0g6o10650','','PHPSESSID',1363186602,1440,''),('mppfdujvmhl5pbskrjah9jib22','','PHPSESSID',1363144494,1440,''),('mrj377pcpo6hncqljpusvmf890','','PHPSESSID',1362504348,1440,''),('ms1s89p2rmf8ee6u7f96fe7hd5','','PHPSESSID',1362504327,1440,''),('mu3npcp8m4a5ldc9fbph41f3k3','','PHPSESSID',1363232763,1440,''),('n02aaa14hgn88gbfc66lds1el3','','PHPSESSID',1363004715,1440,''),('n038c1a58nq92tq6trnlhrin50','','PHPSESSID',1363185596,1440,''),('n13ho5rdv6tlggdlkrtr50i9v4','','PHPSESSID',1363113279,1440,''),('n28n2ci797hi5v14k5kel3ick3','','PHPSESSID',1362447393,1440,''),('n64g27el6c196guk02ehe9ku06','','PHPSESSID',1362678006,1440,''),('n6cbpb0t006fgkj119e0ecv1p4','','PHPSESSID',1362855262,1440,''),('na8oj35q4rtdt77kgklg99orh4','','PHPSESSID',1362855351,1440,''),('nastm7jrnm0fuccunlik0e12b3','','PHPSESSID',1363187607,1440,''),('nb74g018sgstlg87eh2a324k65','','PHPSESSID',1362971829,1440,''),('ncc4lbam7aes36ts67j6bnltb2','','PHPSESSID',1363112718,1440,''),('ncdvftv48tlspgqetu66vjamk3','','PHPSESSID',1362856520,1440,''),('ndb1t0u9r444rholnk1n1d9oc3','','PHPSESSID',1362856518,1440,''),('ndp9ocf92vq02dpnt2afvg0lu4','','PHPSESSID',1362679263,1440,''),('nf8qtg8f84lclasbni7tc4s5j6','','PHPSESSID',1363232471,1440,''),('nfb3a8pio9rt1lvo626nn1vpg1','','PHPSESSID',1363187464,1440,''),('nfep5b8lkfhcgav7v2j0jinfg1','','PHPSESSID',1363232513,1440,''),('nfi7do1d52ja0i4k92bbljcvm6','','PHPSESSID',1363113882,1440,''),('ngel1lvpd3uvlm147t3l94j052','','PHPSESSID',1362855477,1440,''),('ngg8d44uadkv6qi2s54rcud5o5','','PHPSESSID',1362884859,1440,''),('ngjgh9arqkhd9gdcp870s6cku2','','PHPSESSID',1362880173,1440,''),('ni093oropakskvkml4spk8orr5','','PHPSESSID',1362502127,1440,''),('nik1i5686slrh9d0reb2an5nu1','','PHPSESSID',1362884830,1440,''),('nj44ecdp12gtsvpgg2glgndhu3','','PHPSESSID',1362502163,1440,''),('nmn1pii2ted36v5bib7ims61q6','','PHPSESSID',1362857120,1440,''),('nopq8jt3eps6qepp5f5n48upl7','','PHPSESSID',1363185108,1440,''),('nplfqq7oi5ehg3208auv0j3ve5','','PHPSESSID',1362676227,1440,''),('npuj7cgqoe8od9mmbkb3n8krh5','','PHPSESSID',1362884857,1440,''),('nrjgr7ut155b8s0fsml94u7ct3','','PHPSESSID',1362857197,1440,''),('ns5jb4megfck68st5uggcn95a1','','PHPSESSID',1362855033,1440,''),('nvdgrektehh1etqnkgkgv9cfq6','','PHPSESSID',1362857093,1440,''),('o063c1f574od9rp1rcjnh7rr16','','PHPSESSID',1362355352,1440,''),('o0a2aj0li7ap1cd5sv50eq1gs4','','PHPSESSID',1362885715,1440,''),('o1fno1i6m8b1rdrh1r5k8ej893','','PHPSESSID',1362503225,1440,''),('o1leomqsk5ndttds6h9bct4s37','','PHPSESSID',1363114251,1440,''),('o2598phsankppp4k1pvctuoq60','','PHPSESSID',1362355255,1440,''),('o2fvfkd29rl583l8i33mtg0l10','','PHPSESSID',1362855480,1440,''),('o2qvihuu7s9v8emsbkb7cueoe2','','PHPSESSID',1363185322,1440,''),('o55p378pkagiquhblvuk8evl07','','PHPSESSID',1363232503,1440,''),('o5fi7tuk2t8r7gi6t734shsfr0','','PHPSESSID',1362856371,1440,''),('o5m2t7n503iuhtgo86avtusu83','','PHPSESSID',1363185346,1440,''),('o5vm6o3lu4skoa9qjjj9hjbra0','','PHPSESSID',1362533308,1440,''),('o62lthi99e1v2plqer1e3ijlh4','','PHPSESSID',1362359137,1440,''),('o6inbfl9pfti366hqj7r1no1i4','','PHPSESSID',1362947450,1440,''),('o6nskmutnli8s8anf0t6rtocu6','','PHPSESSID',1362534364,1440,''),('o8a7ks4j6l4aga660kbgf2vgd3','','PHPSESSID',1363112493,1440,''),('o9l4ol5cm16bv59cl4vh1kbq97','','PHPSESSID',1362971165,1440,''),('oc0aeiq9gs3u585uo9ooeaqkc4','','PHPSESSID',1362534553,1440,''),('od4bs11sg15lr25tg7erbeus12','','PHPSESSID',1363187458,1440,''),('od9tmu4vpf1b97e361bsbolia2','','PHPSESSID',1363112806,1440,''),('odjql4i091u07mgr72kiihp750','','PHPSESSID',1362504295,1440,''),('oe3po1s7vh18lmc4m040l4p8l7','','PHPSESSID',1363144289,1440,''),('oe5ii176eujq73bri56nngddp5','','PHPSESSID',1362559810,1440,'dlayer_session|a:1:{s:7:\"site_id\";i:1;}'),('oecguvmasju92fatoahra8ntp5','','PHPSESSID',1362886038,1440,''),('oeviuaq1rrfju4ssrhk5eriu83','','PHPSESSID',1362885163,1440,''),('of45q46t2amb3m0fikonpb81o2','','PHPSESSID',1363185954,1440,''),('oibs0255kjd87oi6004222eio0','','PHPSESSID',1362359138,1440,''),('oiro1e8mntfa1l3uc73p0883c0','','PHPSESSID',1362856178,1440,''),('ojjpfeu3qg7u8vt68j7fgfqk57','','PHPSESSID',1362359141,1440,''),('omnugcqg63nfqn9vi0a24f63i6','','PHPSESSID',1363114306,1440,''),('oqo3bd7vg2383j19het7p0ath2','','PHPSESSID',1362885839,1440,''),('os7saf1fps541fbvqeeas0foa6','','PHPSESSID',1362534275,1440,''),('ovkdhkubanmudbmpipdj0npe33','','PHPSESSID',1363185301,1440,''),('ovnlr10m3sar56r56oo89q44r6','','PHPSESSID',1363113277,1440,''),('ovorcve57t663ajk570en494a0','','PHPSESSID',1363185599,1440,''),('p0bffatlg832te6obhslvf85s5','','PHPSESSID',1362855424,1440,''),('p18otijuv45v4e2el9g3951e23','','PHPSESSID',1362679037,1440,''),('p2e4gf1qe1v8h25pl1ij8mdm90','','PHPSESSID',1363144578,1440,''),('p2g2meiovsleuaeqg3kajh4k41','','PHPSESSID',1362678349,1440,''),('p2vuc3em9gjj6jn9hni3lcl807','','PHPSESSID',1362449639,1440,''),('p39hi9m5uo16lii8mtsp0eifu1','','PHPSESSID',1362449321,1440,''),('p3fhb61jr464953hoo5ec11nd1','','PHPSESSID',1363185328,1440,''),('p481sr0dv077pnc3ski79toha5','','PHPSESSID',1362449604,1440,''),('p8n2e1j4jlci3ecd4o18g8epo0','','PHPSESSID',1362355293,1440,''),('pam6bjmtvnljvc2l50l62q3jo3','','PHPSESSID',1362421776,1440,''),('pbcdgjnqc3n8tlr7qnq8ufl1n0','','PHPSESSID',1362535096,1440,''),('pc47gap25fl64up7kqucar53b5','','PHPSESSID',1362885164,1440,''),('pd6uafjmclp34ebhlibh7q6v85','','PHPSESSID',1362855374,1440,''),('pg25t544ha9ri21k9fkm7r2a62','','PHPSESSID',1363144503,1440,''),('phr6d415rah2gqoihphi4jt7j2','','PHPSESSID',1362503228,1440,''),('pivg9fnfjroiv3lc8u4i7pftp2','','PHPSESSID',1362534279,1440,''),('pmvnatt7ju9j7jnu6eqjs68a80','','PHPSESSID',1363113633,1440,''),('pn4k855hdikgv1vg473loctmm1','','PHPSESSID',1362422855,1440,''),('pnp9cvpbddu3b8haius8iukci5','','PHPSESSID',1363185271,1440,''),('poaknrflls1rirbievl9fmqu44','','PHPSESSID',1363185952,1440,''),('ppa0pm5vkbmf0s2s0rumdanhe5','','PHPSESSID',1362855480,1440,''),('ppm5pl04e96nsq63v5ss1bs7p5','','PHPSESSID',1362855221,1440,''),('pqp8a06qnlbpv98lnsvv3isr92','','PHPSESSID',1363232955,1440,''),('prt833987ejtdbqsodkn9if480','','PHPSESSID',1363113051,1440,''),('prtvcc09ofklabgglbad4716m4','','PHPSESSID',1363144021,1440,''),('pu85191ge9vham482p19pbl8b4','','PHPSESSID',1362855423,1440,''),('pvd5ulb005co6qdcggl9b72tg6','','PHPSESSID',1362534650,1440,''),('pvdgbljkasaojrkh7fpr7qdcg1','','PHPSESSID',1362971165,1440,''),('q0gdagml26dlp4ljrpbignjjl2','','PHPSESSID',1362886039,1440,''),('q0rbhh62a35rcr0qekso285ku2','','PHPSESSID',1362706522,1440,''),('q20hubj89b8bvao7u9r7j4tdj1','','PHPSESSID',1362534613,1440,''),('q4uuic3ao06uavqi4a3pm971k3','','PHPSESSID',1362885731,1440,''),('q5p655sorubetnd4il2u9g8l74','','PHPSESSID',1363186743,1440,''),('q65p1rpbor451stttbcm6smh35','','PHPSESSID',1363144361,1440,''),('q6ln4fh0g8g5t7u1hb75457240','','PHPSESSID',1363232766,1440,''),('q6nau8t9br78mq5imh2rci0l22','','PHPSESSID',1362855421,1440,''),('q6qohgss2t85p9cur4pdtn62a4','','PHPSESSID',1363113443,1440,''),('qak761rr1urj9tp3cq9oobo4g1','','PHPSESSID',1362856382,1440,''),('qbg1ljaeanosr9ji30or7hdut4','','PHPSESSID',1362855217,1440,''),('qc7s1grocrme2llpc2is900i37','','PHPSESSID',1363144290,1440,''),('qcbb8do337s5870rt7us7ihkk6','','PHPSESSID',1362886066,1440,''),('qcc3uhtdr2qljnl49c6rtmdas5','','PHPSESSID',1363232504,1440,''),('qd33usaadetai9he96dcut35t2','','PHPSESSID',1362855265,1440,''),('qdqc7bnktoh28s3ndrd3j4t4t7','','PHPSESSID',1363113049,1440,''),('qfev1hub3gfsen04n5me7nlns7','','PHPSESSID',1363187834,1440,''),('qfroueo91ib0v993h10ghpkha4','','PHPSESSID',1363113615,1440,''),('qg7rp9nublp7f8grkfd6bjj242','','PHPSESSID',1362502072,1440,''),('qghgnr51cqj5nbkl9g2blr9454','','PHPSESSID',1362421906,1440,''),('qk9262dia6e27v5f0sukv83p63','','PHPSESSID',1362855444,1440,''),('qkal7tsgponn0d7f2m1nac15c5','','PHPSESSID',1362508179,1440,''),('qks48ecll5k58nsvjg1hfjpjr0','','PHPSESSID',1362856235,1440,''),('qlgos3ru4hvf3c43c2tjq9uke3','','PHPSESSID',1363114306,1440,''),('qppeki3pm4hc54ac1caeqjfoa3','','PHPSESSID',1362857119,1440,''),('qrv8kq14vkoer935e55uhdes17','','PHPSESSID',1362683377,1440,''),('qu7rat3kis9dfdfiuicmt5lms6','','PHPSESSID',1362706524,1440,''),('quc4ht6kqf1rb3fhvkr2k69ij4','','PHPSESSID',1363186736,1440,''),('qug0loi3g4ajtnd4688sjurtb5','','PHPSESSID',1363111839,1440,''),('r02ovfmhlanfph9udhmo6pjbs3','','PHPSESSID',1362449309,1440,''),('r0rnsv94fquo8s8coqa7pedh74','','PHPSESSID',1363186754,1440,''),('r1bkbdujaoc9aivhf6k6d96br7','','PHPSESSID',1362504377,1440,''),('r1u7th72ur4q35i01r6c9vsat2','','PHPSESSID',1362449287,1440,''),('r1ucua1nfdas5q83lqbal6fjt0','','PHPSESSID',1362534554,1440,''),('r348vbaekctj80pcmbuj92bcv1','','PHPSESSID',1362854711,1440,''),('r47ua5i49u2ph9vbr1ron73182','','PHPSESSID',1363113049,1440,''),('r4s2ebep3u4npn0bi20losf0p3','','PHPSESSID',1362502760,1440,''),('r6nmmadl5041rlbp496pvu66h7','','PHPSESSID',1362880167,1440,''),('r6rcrs2l5artj02ergo1922jb2','','PHPSESSID',1362504472,1440,''),('ra9oivf16ks16palr17lkq6lv3','','PHPSESSID',1362856890,1440,''),('rakgugg7e450g8n41bgvg0h050','','PHPSESSID',1362502769,1440,''),('rbpk98k9himuck0pjpr2dg3771','','PHPSESSID',1362447475,1440,''),('rbu75hret5og2819usb81nkgn6','','PHPSESSID',1363187498,1440,''),('rdir0lnc0ergq94krm18qef354','','PHPSESSID',1362503224,1440,''),('rf17i278c3hreqd9n8vbufg8l5','','PHPSESSID',1362880148,1440,''),('rich6r31alo4qhfd5vdfdmfh54','','PHPSESSID',1363113906,1440,''),('rla5gqmdlfsv50rgm7hbre0807','','PHPSESSID',1362854580,1440,''),('rlau27m2aqqa3c8ri4nalvfb64','','PHPSESSID',1362855146,1440,''),('rsmb8i0rldu0pbfl2strbr2mi7','','PHPSESSID',1362855024,1440,''),('rtvpj2r0pjdv2vh9uj4b9id5q0','','PHPSESSID',1362884597,1440,''),('ru8scj6qmbn5kppd9u4egdb7p6','','PHPSESSID',1363144391,1440,''),('ruiuegkhp9mh5gt6edj4g20fm5','','PHPSESSID',1362855220,1440,''),('rvgms9jiejrfj9jddspq8o26h0','','PHPSESSID',1362855640,1440,''),('s2af2r3hhujnstorbncqpd0qu6','','PHPSESSID',1362502751,1440,''),('s2bcvf1pkt80dnq1c67iv38i66','','PHPSESSID',1362355256,1440,''),('s2ngbniesd6dlgmbo7urh4dfd4','','PHPSESSID',1362855221,1440,''),('s32djbhc4ssi50qprfu0qu7v56','','PHPSESSID',1362971153,1440,''),('s34qj3f7ci316lohsqqmul9903','','PHPSESSID',1362886006,1440,''),('s3sk42srh98b8jf6aok1a87e03','','PHPSESSID',1362449641,1440,''),('s4mq4hts4m7n73i7geoo808ni3','','PHPSESSID',1363144492,1440,''),('s56ie4so3f53sbi27c1hihsq75','','PHPSESSID',1362405074,1440,''),('s5b734sq4gih2uqb30mm9jhhg4','','PHPSESSID',1362958299,1440,''),('s6t7o7otrmtvbu0pgb82sqf2o0','','PHPSESSID',1362947451,1440,''),('s7hgsiujs2h6o0jagfj7tl5gt6','','PHPSESSID',1362503184,1440,''),('s8cfobepkfonk6c5cfn5f506l3','','PHPSESSID',1363186162,1440,''),('s9f4g280at5qrrsv4871mo6d74','','PHPSESSID',1362884562,1440,''),('s9jlffajsdlve722qdru4kdu07','','PHPSESSID',1363114111,1440,''),('sb1jh0pnj43l2c9t3o0q7kfv52','','PHPSESSID',1363113289,1440,''),('sbocnjti2nned35spf7mfv63f6','','PHPSESSID',1363232953,1440,''),('sc7gas1c28tafagq6jam036kn0','','PHPSESSID',1362885893,1440,''),('sca7jl6n5icibh8ovumjt1ikm7','','PHPSESSID',1362678319,1440,''),('ses218fuspg03hllh7psvueqh5','','PHPSESSID',1362855092,1440,''),('sf377h8cvnlf4f2fu5q0erop31','','PHPSESSID',1362534566,1440,''),('sf7d1dchphirv1bi51mu6k5nb0','','PHPSESSID',1362678326,1440,''),('sh16a61c2inojm2v5c7s4afkf4','','PHPSESSID',1362409569,1440,''),('sh4deqocdmckvclt5c239k7b00','','PHPSESSID',1362856235,1440,''),('silp7a187vccpq5vvv1g86aso5','','PHPSESSID',1362855311,1440,''),('sj44a771l8os1eb57tomltuv15','','PHPSESSID',1363012006,1440,''),('sl2k1m74lmbqdk2kual8q94725','','PHPSESSID',1363187867,1440,''),('slvj6vea4d5f9j9dhedhmrhs50','','PHPSESSID',1363185116,1440,''),('snoubcpi5l1dndskbmqt5if1n0','','PHPSESSID',1362534746,1440,''),('soi8993u7qddk4i3o7qd8bkqv2','','PHPSESSID',1362884961,1440,''),('soornt9bne3vsaqvntug4q2tk3','','PHPSESSID',1362504294,1440,''),('ss097mthtlekf15gmfr43nhnq7','','PHPSESSID',1363232764,1440,''),('svfh5q85g4prc9k01b06n1tl21','','PHPSESSID',1362678437,1440,''),('t009dttburbkeqpft9figeoet6','','PHPSESSID',1362856338,1440,''),('t0kpq4n2c6j8lnlqtdobmjsom3','','PHPSESSID',1362857090,1440,''),('t40jioqrds4pjjdu0jnt19hk87','','PHPSESSID',1362504378,1440,''),('t420tv8r58fe7p5vsvutk7cr51','','PHPSESSID',1362885227,1440,''),('t4a3a55ftmjmmdb4otqq405hg5','','PHPSESSID',1363185432,1440,''),('t767nri9j4glem94q0ftj7niq5','','PHPSESSID',1363185178,1440,''),('t7nursek7pau554073agje4pj2','','PHPSESSID',1362447394,1440,''),('t92q1nhg0rou93e2jrvcl85ps6','','PHPSESSID',1362884960,1440,''),('ta6p9jts0pkjelsl4g1dq4eod1','','PHPSESSID',1362855373,1440,''),('tac9g0magm1lb9tblegjsnjf41','','PHPSESSID',1363112899,1440,''),('tbhluo49c4g07e2dkdmfcj3lp4','','PHPSESSID',1363187920,1440,''),('tbieaeg6jqvniqljolb22imsb3','','PHPSESSID',1362427226,1440,''),('tc3ip0bap71agui9rq8n32bd32','','PHPSESSID',1362504578,1440,''),('tcg4rbsmtggstkcrrn1pkkeog0','','PHPSESSID',1362854415,1440,''),('tcitj3k76qq9ov4v900v8o5qb7','','PHPSESSID',1363112305,1440,''),('td9bde9totibvgdk8h8b8bh016','','PHPSESSID',1363185769,1440,''),('tdd5v8sv70ls1kok1cc596dmj0','','PHPSESSID',1363185592,1440,''),('tdfv7v03lrvr1sjo0kosog4m26','','PHPSESSID',1363187464,1440,''),('tdusnmt2jd6n897becem3116g6','','PHPSESSID',1362856006,1440,''),('tf537kt45kb1s7e0ns6eafjgf5','','PHPSESSID',1363113562,1440,''),('tfjuif3aftikethjcrnjpcfmo7','','PHPSESSID',1362504365,1440,''),('tgdlqjjak698j5v983iq9v2rv3','','PHPSESSID',1362677186,1440,''),('th7v40hkaube8d9m7q2bunog83','','PHPSESSID',1362884859,1440,''),('tikkgco6vj6scnbtvbvhprdha6','','PHPSESSID',1363111845,1440,''),('tl0cqbfq5jevo3r5chrhqa8lv6','','PHPSESSID',1362422541,1440,''),('tl22htbvre29i7h5b75i7kjhv7','','PHPSESSID',1362886066,1440,''),('tnhsr04u9781m9qr9qhut9vfa5','','PHPSESSID',1362533346,1440,''),('trutgja7vjs31mpf05mebp9q90','','PHPSESSID',1363112460,1440,''),('ts1td76ni5p377dbjk5thnpfl1','','PHPSESSID',1362504469,1440,''),('ttrefkvv0pigldtf51djbe6n95','','PHPSESSID',1362534276,1440,''),('tuu3d1cosaco08onvsqjtfnu50','','PHPSESSID',1363112898,1440,''),('tv1crebojlj579m8vt8oujsv63','','PHPSESSID',1362971126,1440,''),('u0s07tdllgenfkv1qace56t6t3','','PHPSESSID',1362970882,1440,''),('u2uevo3e5li2ei03p532g62nc7','','PHPSESSID',1362678311,1440,''),('u39vci7fls7emn4ianirctgfu0','','PHPSESSID',1363111847,1440,''),('u5lmilckqgkv0rrv4tuspl67c1','','PHPSESSID',1362679377,1440,''),('u5udah7lvfssiitprhevp5drl4','','PHPSESSID',1362677309,1440,''),('u71jg249tm60ub7v2ahph1m532','','PHPSESSID',1362885942,1440,''),('u7adath2f5o1b3l42mik5jces2','','PHPSESSID',1363187496,1440,''),('ubt0nl3l1men1pblshimotnko1','','PHPSESSID',1363187459,1440,''),('ucav1ui800d0qssjnh05rqmkj1','','PHPSESSID',1362422853,1440,''),('ue7fk5t4t46skmu7eoa4ikass5','','PHPSESSID',1362359141,1440,''),('ufpjr37icd3e0ca1q7hdguint2','','PHPSESSID',1363144119,1440,''),('uifnelujq7a8ul25fda8dhvi57','','PHPSESSID',1362446949,1440,''),('ujnto1iqa4v2erqja2agmpg9l2','','PHPSESSID',1362359134,1440,''),('ulkp478nefhckicsojuc2nb2j3','','PHPSESSID',1363187463,1440,''),('und36o7k5si0rjtfuhvqrg14q4','','PHPSESSID',1362449640,1440,''),('upiteofn14v0ambbso0dan1mo3','','PHPSESSID',1362678318,1440,''),('utlhbnk40e838cl1lpuqgebq70','','PHPSESSID',1363113053,1440,''),('uufcj074knv10fqtab5o9m4aq5','','PHPSESSID',1362854422,1440,''),('v0s3fsuuhh1ki21h5s663sjfr3','','PHPSESSID',1362855641,1440,''),('v2q0e4hke9uiokgutjrlcb4su2','','PHPSESSID',1362707237,1440,''),('v3qp7p5nq90uu3a24401rc8sr7','','PHPSESSID',1363144390,1440,''),('v619532q19i2i5jmc1t9g4gnp2','','PHPSESSID',1362678311,1440,''),('v6a78dg1innmh6qleq1jenlut0','','PHPSESSID',1363187918,1440,''),('v7mkvkmdv8qr3q7pbhlr99uhr7','','PHPSESSID',1362502017,1440,''),('v833jcpirhe3k7kv5j6okeb596','','PHPSESSID',1362855350,1440,''),('v8kpfduhpsbgdie9i6uenfb904','','PHPSESSID',1362503241,1440,''),('v9hrqk8ldoppamq3vmg31ooej6','','PHPSESSID',1362855147,1440,''),('vbh6kt5i4spmu8lrogf02fcvn1','','PHPSESSID',1362707215,1440,''),('ve7e1ivjrbjgokqbva7clqqbq5','','PHPSESSID',1362534567,1440,''),('vfae7476c8krsk8hskvnonrrp2','','PHPSESSID',1362855553,1440,''),('vff5r4kp2i4t36u0m6dn5h9vr6','','PHPSESSID',1362855090,1440,''),('vgglrjog1vp68n4qvnp3d1pkv2','','PHPSESSID',1363112719,1440,''),('vgsf6mqdvqcgt83ovm93ilh8p4','','PHPSESSID',1362855418,1440,''),('vi1jv63bcujm05gppgsq1usmo5','','PHPSESSID',1363144079,1440,''),('vimfo6d7hfqi6c1optmdtgrl30','','PHPSESSID',1362855479,1440,''),('vjkse1hkpr9uv2iie2ujjunfa7','','PHPSESSID',1363187999,1440,''),('vkju3jdibvqc57l0dar6i89jo2','','PHPSESSID',1363185345,1440,''),('vlhkvr3tgvvdaergqdamv7csh5','','PHPSESSID',1362534278,1440,''),('vlm42559frs72uiqugf5sf1316','','PHPSESSID',1362855418,1440,''),('vmpochj6majnjcotr9oqoi5qv7','','PHPSESSID',1363113445,1440,''),('vn46bj4bl82rfhklah6gds3ss7','','PHPSESSID',1362533765,1440,''),('vp2ii0o3vqo8vk9ubuncq4ifg7','','PHPSESSID',1362678004,1440,''),('vpshbiahhbb07jfghn5aukc5q5','','PHPSESSID',1363112464,1440,''),('vq2o4j2r8hil0tikg0vkjac0k7','','PHPSESSID',1362678342,1440,''),('vrqtsmicfbaiuglktqa7m189c1','','PHPSESSID',1362502065,1440,''),('vsvir10n78ag98bd9lhehcngr5','','PHPSESSID',1363112314,1440,'');

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

insert  into `form_field_types`(`id`,`name`,`description`,`enabled`) values (1,'Text','Allows a user to enter a single line, for example their name or email.',1),(2,'Textarea','gg',1);

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

/*Table structure for table `user_settings_color_palettes` */

DROP TABLE IF EXISTS `user_settings_color_palettes`;

CREATE TABLE `user_settings_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `palette_id` int(11) unsigned NOT NULL,
  `sort_order` tinyint(2) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `site_id` (`site_id`),
  KEY `palette_id` (`palette_id`),
  CONSTRAINT `user_settings_color_palettes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_settings_color_palettes_ibfk_3` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palettes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_settings_color_palettes` */

insert  into `user_settings_color_palettes`(`id`,`site_id`,`palette_id`,`sort_order`,`enabled`) values (1,1,1,1,1),(2,1,2,2,1),(3,1,3,3,1);

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
  CONSTRAINT `user_settings_headings_ibfk_6` FOREIGN KEY (`heading_id`) REFERENCES `designer_html_headings` (`id`),
  CONSTRAINT `user_settings_headings_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_settings_headings_ibfk_3` FOREIGN KEY (`style_id`) REFERENCES `designer_css_text_styles` (`id`),
  CONSTRAINT `user_settings_headings_ibfk_4` FOREIGN KEY (`weight_id`) REFERENCES `designer_css_text_weights` (`id`),
  CONSTRAINT `user_settings_headings_ibfk_5` FOREIGN KEY (`decoration_id`) REFERENCES `designer_css_text_decorations` (`id`)
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
  CONSTRAINT `user_site_page_content_ibfk_4` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_page_content_ibfk_5` FOREIGN KEY (`div_id`) REFERENCES `user_site_template_divs` (`id`),
  CONSTRAINT `user_site_page_content_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_ibfk_3` FOREIGN KEY (`content_type`) REFERENCES `designer_content_types` (`id`)
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
  CONSTRAINT `user_site_page_content_text_ibfk_3` FOREIGN KEY (`title_style_id`) REFERENCES `user_settings_headings` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
