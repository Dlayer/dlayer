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

/*Table structure for table `designer_css_text_decoration` */

DROP TABLE IF EXISTS `designer_css_text_decoration`;

CREATE TABLE `designer_css_text_decoration` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `css` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_css_text_decoration` */

insert  into `designer_css_text_decoration`(`id`,`name`,`css`,`sort_order`,`enabled`) values (1,'None','none',1,1),(2,'Underline','underline',2,1),(3,'Strike-through','line-through',3,1);

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

/*Table structure for table `designer_html_titles` */

DROP TABLE IF EXISTS `designer_html_titles`;

CREATE TABLE `designer_html_titles` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `designer_html_titles` */

insert  into `designer_html_titles`(`id`,`name`,`tag`,`sort_order`,`enabled`) values (1,'Page title','h1',1,1),(2,'Heading 1','h2',2,1),(3,'Heading 2','h3',3,1),(4,'Heading 3','h4',4,1),(5,'Heading 4','h5',5,1),(6,'Heading 5','h6',6,1),(7,'Heading 6','h7',7,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tabs` */

insert  into `dlayer_module_tool_tabs`(`id`,`module_id`,`tool_id`,`name`,`script_name`,`multi_use`,`default`,`sort_order`,`enabled`) values (1,1,2,'Quick split','quick',0,1,1,1),(2,1,2,'Split with mouse','advanced',0,0,2,1),(3,1,2,'Help','help',0,0,3,1),(4,1,3,'Quick split','quick',0,1,1,1),(5,1,3,'Split with mouse','advanced',0,0,2,1),(6,1,3,'Help','help',0,0,3,1),(7,1,7,'Palette 1','palette-1',0,1,1,1),(8,1,7,'Palette 2','palette-2',0,0,2,1),(9,1,7,'Palette 3','palette-3',0,0,3,1),(10,1,7,'Set custom color','advanced',0,0,4,1),(11,1,7,'Help','help',0,0,5,1),(12,1,6,'Set custom size','advanced',0,0,5,1),(14,1,6,'Help','help',0,0,6,1),(15,1,6,'Expand','expand',1,1,1,1),(16,1,6,'Contract','contract',1,0,2,1),(17,1,6,'Adjust height','height',1,0,3,1),(20,1,8,'Set custom border','advanced',1,1,2,1),(21,1,8,'Help','help',0,0,3,1),(22,1,8,'Full border','full',0,0,1,1),(23,4,10,'Text','text',1,1,1,1),(24,4,11,'Header','header',1,1,1,1),(25,4,10,'Help','help',0,0,2,1),(26,4,11,'Help','help',0,0,2,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tools` */

insert  into `dlayer_module_tools`(`id`,`module_id`,`name`,`process_model`,`script`,`icon`,`base`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','','cancel','cancel.png',1,1,1,1),(2,1,'Split horizontal','SplitHorizontal','split-horizontal','split-horizontal.png',1,2,1,1),(3,1,'Split vertical','SplitVertical','split-vertical','split-vertical.png',1,2,2,1),(6,1,'Resize','Resize','resize','resize.png',0,3,3,1),(7,1,'Background color','BackgroundColor','background-color','background-color.png',1,4,1,1),(8,1,'Border','Border','border','border.png',0,4,2,1),(9,4,'Cancel','','cancel','cancel.png',1,1,1,1),(10,4,'Text','Text','text','text.png',0,2,1,1),(11,4,'Header','Header','header','header.png',0,2,2,1);

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

insert  into `dlayer_modules`(`id`,`name`,`title`,`description`,`icon`,`sort_order`,`enabled`) values (1,'template','Template designer','Design templates, you can then create pages uses the templates, a page must inherit a template.','template.png',1,1),(2,'widget','Widget designer','Design your own widgets, thinks of widgets as mini templates/pages, they can be added to both pages and templates and can contain pretty much any type of content.','widget.png',4,1),(3,'form','Forms builder','If you need to add a form to your site, create it using the forms builder, you can then attach the form as you would any piece of content.','form.png',3,1),(4,'content','Content manager','Add your content to your web pages.','content.png',2,1),(5,'website','Website manager','This allows you to set up how the pages within the website link together, from this your menus and sitemap will be constructed.','website.png',5,1);

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

insert  into `dlayer_sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('09h6sbea85qta3jj1uga7ifna5','','PHPSESSID',1362447394,1440,''),('0ap1pi18rj9kpd7pgiedr7b1v0','','PHPSESSID',1362449527,1440,''),('0bd7nq87tb99qhks8d3u6ap665','','PHPSESSID',1362447202,1440,''),('0bml0mtc86cd4idk94gpb9b491','','PHPSESSID',1362447202,1440,''),('0em2vcs2q3ilv2pcbk0emf3qn2','','PHPSESSID',1362355257,1440,''),('0i8opubt000uvgen29kpqgojr6','','PHPSESSID',1362355296,1440,''),('0jgs70pm0g3at3ctj8upl3f4h1','','PHPSESSID',1362449320,1440,''),('0s3bhpna3grt4afs73odca2cf7','','PHPSESSID',1362503229,1440,''),('0t21nledjfu65a0mepnbrmvgk3','','PHPSESSID',1362503183,1440,''),('0th0vf19hqair0oqc4orc1vdh5','','PHPSESSID',1362504308,1440,''),('15vd67kkdiumpke0ppqdc8sp04','','PHPSESSID',1362447455,1440,''),('1ah3e5eg2jtrpehvlj35tba2r3','','PHPSESSID',1362421681,1440,''),('1dit6k0lsmm0pajeh2829fma57','','PHPSESSID',1362422867,1440,''),('1k8noi18cvnor9pbhofnemep40','','PHPSESSID',1362355220,1440,''),('1ojeloteh1a7egpnpagfrj6ps5','','PHPSESSID',1362355179,1440,''),('1t88mjbtm98macl7n2tks5qpd4','','PHPSESSID',1362421679,1440,''),('1tjtq5ne5ntcrliannoskpsnn2','','PHPSESSID',1362504364,1440,''),('27f4rlgpdot2pqekdb774dqed0','','PHPSESSID',1362355164,1440,''),('29omhmpkkqht16ft9faq4spiv6','','PHPSESSID',1362405843,1440,''),('2gvi94tdafdul4o30vlv226ql5','','PHPSESSID',1362504407,1440,''),('2kn1bjkhb7q1nhap9i82fra545','','PHPSESSID',1362504302,1440,''),('2rnjik98lm295i341s8auui7e7','','PHPSESSID',1362502769,1440,''),('35bultbk1kgmv4rncmso2s4f60','','PHPSESSID',1362502179,1440,''),('3a0bo4p3pd3mf1mesf1dmr72t5','','PHPSESSID',1362355352,1440,'dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"4\";}dlayer_session_template|a:1:{s:11:\"template_id\";i:1;}dlayer_session_content|a:2:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;}'),('3e2uqe11d2848u00h33dim7960','','PHPSESSID',1362409450,1440,''),('3rdqkojauk76abds0rvrsrgne2','','PHPSESSID',1362449309,1440,''),('3tspt0pk703le29ge5lrfqjqg3','','PHPSESSID',1362355298,1440,''),('3u6a0dvlj6v1fpbu4mtl2hqog2','','PHPSESSID',1362504297,1440,''),('45fq2oafibcme8h7b3n47aa6p6','','PHPSESSID',1362447506,1440,''),('4gmmcvrln5u7t3ki4879vv61f6','','PHPSESSID',1362504340,1440,''),('4h4hvaufj62h8eerp8plakifs1','','PHPSESSID',1362355221,1440,''),('4nvcrn5hhuklk309addned7uv0','','PHPSESSID',1362413170,1440,''),('4vkkmqcjps15lhi1ule7bp12a3','','PHPSESSID',1362449641,1440,'dlayer_session_content|a:5:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";N;s:19:\"selected_content_id\";N;s:7:\"tool_id\";N;}dlayer_session|a:1:{s:9:\"module_id\";s:1:\"4\";}'),('50g9uvm7vl4kvokgmefatq25v3','','PHPSESSID',1362422854,1440,''),('576d8uf8ohk96dg7i62s6r5bq6','','PHPSESSID',1362503230,1440,''),('59dunqkaqquotmts6u720cjcq1','','PHPSESSID',1362504341,1440,''),('5cg81aoo7lqhjo3q8d67b2tdq5','','PHPSESSID',1362409088,1440,''),('5iqvujdprdlj7lbmta4hn636c1','','PHPSESSID',1362421678,1440,''),('5t2rbab0lhr61an29k9dn8kuu0','','PHPSESSID',1362502178,1440,''),('653t3nju24ldgq6b91rtqgfng7','','PHPSESSID',1362500338,1440,'dlayer_session_content|a:2:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;}dlayer_session|a:1:{s:9:\"module_id\";s:1:\"4\";}'),('66mdjern0d17gq9qfkhils0e30','','PHPSESSID',1362504361,1440,''),('6cpcapmlhb055ddufh0l18mbp7','','PHPSESSID',1362447506,1440,''),('6d0rgaofhi1cmqaqhd5dj3p825','','PHPSESSID',1362502769,1440,''),('6uc0cbj5l9e7fctqjpiujci3k2','','PHPSESSID',1362503229,1440,''),('72n60n13cv46vnkf99egdrl1e3','','PHPSESSID',1362503241,1440,''),('7n4fjkiuq91282hvdj81h88sb0','','PHPSESSID',1362446944,1440,''),('7o6p693a75b6bh3cptb0qccjd6','','PHPSESSID',1362409432,1440,''),('7qrcb7k5t12h9tagetsripv1o2','','PHPSESSID',1362503241,1440,''),('7vd22sb8cplevt9v5vdie53tc7','','PHPSESSID',1362504376,1440,''),('80c2fganpqmg84kj93k8g59ja6','','PHPSESSID',1362504296,1440,''),('89gd1b42hcbi3saa9nrv6sqih1','','PHPSESSID',1362503183,1440,''),('8gtqv37cujefggkup04glgkt11','','PHPSESSID',1362502749,1440,''),('8h11f8fmr5i2ffc07c6k6p1fv1','','PHPSESSID',1362408160,1440,''),('939m880ptmd2ku7a8ro71r61h0','','PHPSESSID',1362504305,1440,''),('9838nmf14lju5ptodc0nr5rd67','','PHPSESSID',1362355256,1440,''),('993jlieq61oich09kqudr2h9u5','','PHPSESSID',1362355178,1440,''),('9ahg5rk41f3pv934csh7s4rco3','','PHPSESSID',1362500338,1440,''),('9f96inqdbr72cbc4sqrvvr2g53','','PHPSESSID',1362355255,1440,''),('9fapbbv1ipfnccetpcdhfp6ba0','','PHPSESSID',1362504409,1440,''),('9ke1v84k5r87og53jgao6aq8f6','','PHPSESSID',1362409088,1440,''),('9qdurf9a72v5nvgpgo2v6l0jh3','','PHPSESSID',1362503182,1440,''),('9rok4k24h7i63rkq4sp2udb3n4','','PHPSESSID',1362449528,1440,''),('ajkir84tj5rg59g4jjf1l12qv2','','PHPSESSID',1362502759,1440,''),('aro4r8g9hl8sbdlc7itd8jvci3','','PHPSESSID',1362355178,1440,''),('atjmgqi8uh3j6msm7udfdvado5','','PHPSESSID',1362496734,1440,''),('baq3qq3gjp2u0fu4sur5cr1p10','','PHPSESSID',1362503184,1440,''),('bdl8can368rksga12g0iulfid3','','PHPSESSID',1362447395,1440,''),('bmrvi5q0k8n15nrqhu40694cf6','','PHPSESSID',1362355257,1440,''),('bmu9dcpkc9er6pbnvljgeenp96','','PHPSESSID',1362503183,1440,''),('bn4mcaotgv0423mrmks2gpfmf1','','PHPSESSID',1362449308,1440,''),('c3r1oeu2d18dpmp7142ft2lo26','','PHPSESSID',1362409087,1440,''),('coaccc0835j97q4prhieb27584','','PHPSESSID',1362504577,1440,''),('d4ct00dt6l5m62nuh2gkhdq3i0','','PHPSESSID',1362408159,1440,''),('ddf57gdccc47ic1c7l3oggdut3','','PHPSESSID',1362422866,1440,''),('dlv29dc1b98iuuvntduvmllfm7','','PHPSESSID',1362449289,1440,''),('e71hp96ljcabmumbtmtvces0h7','','PHPSESSID',1362504476,1440,''),('e9n4fi1vfloqnste3heg83stq7','','PHPSESSID',1362355289,1440,''),('eb5t6o1f8mtv8qhh5kmokt0r05','','PHPSESSID',1362449288,1440,''),('ebf7ttgfqcsnn0mnms1bdmgs11','','PHPSESSID',1362358385,1440,''),('ecpq32phjn3fi7tjlc86tl7ht5','','PHPSESSID',1362503241,1440,''),('ehnjrj9gt1ajovbhaeeimmdgk2','','PHPSESSID',1362355203,1440,''),('ekim3fmls3q66n0lr137sflca7','','PHPSESSID',1362504334,1440,''),('em4epl399putlivec668b32hk1','','PHPSESSID',1362447394,1440,''),('eoceep6er1qseelva09uvp6hv0','','PHPSESSID',1362502164,1440,''),('eu820usqigcsmg2tec4744e462','','PHPSESSID',1362355288,1440,''),('f0q9l8o6a1sp66egi4d7eb9ik2','','PHPSESSID',1362504323,1440,''),('f71v4laiire605k46gp8shpmu4','','PHPSESSID',1362503187,1440,''),('f7ejpdb00phke56hhj3gpj7561','','PHPSESSID',1362355286,1440,''),('fa4ipfhj596fau9bv79nlg8662','','PHPSESSID',1362359143,1440,''),('fj0di0skmbv8pk0morrvqjmic6','','PHPSESSID',1362447125,1440,''),('fjloqc6crceb4n0ds72oanpcp6','','PHPSESSID',1362502019,1440,''),('g52o8cjeclelm4lacq59hauin5','','PHPSESSID',1362355290,1440,''),('g57tb9jfdgntciasdl7et8vdk5','','PHPSESSID',1362447473,1440,''),('gd5qpe1868qsqss5gpijnf5s71','','PHPSESSID',1362355291,1440,''),('ghcfrs1blpvbjl0b1mdav0rl87','','PHPSESSID',1362504306,1440,''),('gk1tr37bv2akelverqtcojkhr1','','PHPSESSID',1362504329,1440,''),('gnp3se0p30s9vtfvcd77l6khr6','','PHPSESSID',1362422945,1440,''),('gp58kqmetjeieq43sf69ruj6j2','','PHPSESSID',1362359139,1440,''),('h3q1eqfi0hls727oqmprt2udn7','','PHPSESSID',1362504347,1440,''),('h46riu71g1rtihrgvuihd07f75','','PHPSESSID',1362355205,1440,''),('hcgc0spe9q06bggrcsms6ooan3','','PHPSESSID',1362503182,1440,''),('he978nm5pcgpac99e2k4tkv5t5','','PHPSESSID',1362449308,1440,''),('hk19fohj47d3q2r729ec72rf61','','PHPSESSID',1362423624,1440,''),('hnk5b5al1t47suiisncgjg3ir0','','PHPSESSID',1362355286,1440,''),('hvn2tdkottceau6d3mue3fulh2','','PHPSESSID',1362446947,1440,''),('i12jqfoknc977jn8cecgoga0c3','','PHPSESSID',1362405072,1440,''),('i3rlkr6rdq1e8tbm277ufen0s0','','PHPSESSID',1362421777,1440,''),('i6mp4maf4oo96rdr69c0nhoat3','','PHPSESSID',1362503240,1440,''),('i71ateuvk45fkejth28o55duv0','','PHPSESSID',1362502748,1440,''),('ir77716mqecn8etefmhok862s0','','PHPSESSID',1362449603,1440,''),('irmidn6eivpssbjloi64iipf62','','PHPSESSID',1362359136,1440,''),('jktq7j1n29nlcsnl1d2su0p6f7','','PHPSESSID',1362409449,1440,''),('jvd6lkpustsmu9thqms1q432k4','','PHPSESSID',1362503183,1440,''),('k229616gg6435pg26j27fgff55','','PHPSESSID',1362447386,1440,''),('k71aev4u08but9ovumktbltl22','','PHPSESSID',1362503183,1440,''),('k95qre51v1clh8ug87j9apvnc6','','PHPSESSID',1362502020,1440,''),('kh95ndoj8k4oipls4m0b3qrfp1','','PHPSESSID',1362447126,1440,''),('khkd8ke777t1gl8dp3mltt3pd3','','PHPSESSID',1362502086,1440,''),('km786f9mmb66nhk1c2mm2ci6j6','','PHPSESSID',1362447456,1440,''),('laa4ernfmdomfnupo0iu9bquq2','','PHPSESSID',1362447385,1440,''),('lbvo0lmf6alcl1p7anme115ld7','','PHPSESSID',1362496736,1440,''),('m06vjupg7ngo0kcisk22b96p44','','PHPSESSID',1362502017,1440,''),('m3935kdqgrk3akrf8cdkqugk06','','PHPSESSID',1362496737,1440,''),('m4u7hae1vh27f57abcu9ljv4b0','','PHPSESSID',1362447474,1440,''),('m7tf91q3utqnf7fehoq713tmm0','','PHPSESSID',1362504363,1440,''),('m92cvgr719lhti2s2r8ea3i2i7','','PHPSESSID',1362355219,1440,''),('me4lusrp8orpn47ol0n47oet93','','PHPSESSID',1362504351,1440,''),('mknsnmoujcnaflt81o6r62kgl0','','PHPSESSID',1362355177,1440,''),('mrj377pcpo6hncqljpusvmf890','','PHPSESSID',1362504348,1440,''),('ms1s89p2rmf8ee6u7f96fe7hd5','','PHPSESSID',1362504327,1440,''),('n28n2ci797hi5v14k5kel3ick3','','PHPSESSID',1362447393,1440,''),('ni093oropakskvkml4spk8orr5','','PHPSESSID',1362502127,1440,''),('nj44ecdp12gtsvpgg2glgndhu3','','PHPSESSID',1362502163,1440,''),('o063c1f574od9rp1rcjnh7rr16','','PHPSESSID',1362355352,1440,''),('o1fno1i6m8b1rdrh1r5k8ej893','','PHPSESSID',1362503225,1440,''),('o2598phsankppp4k1pvctuoq60','','PHPSESSID',1362355255,1440,''),('o62lthi99e1v2plqer1e3ijlh4','','PHPSESSID',1362359137,1440,''),('odjql4i091u07mgr72kiihp750','','PHPSESSID',1362504295,1440,''),('oe5ii176eujq73bri56nngddp5','','PHPSESSID',1362504577,1440,'dlayer_session|a:2:{s:7:\"site_id\";i:1;s:9:\"module_id\";s:1:\"4\";}dlayer_session_content|a:8:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";N;s:19:\"selected_content_id\";N;s:7:\"tool_id\";N;s:9:\"tool_name\";N;s:10:\"tool_model\";N;s:13:\"ribbon_tab_id\";N;}dlayer_session_template|a:7:{s:11:\"template_id\";i:1;s:7:\"tool_id\";N;s:15:\"selected_div_id\";N;s:9:\"tool_name\";N;s:10:\"tool_model\";N;s:13:\"ribbon_tab_id\";N;s:15:\"ribbon_tab_name\";N;}'),('oibs0255kjd87oi6004222eio0','','PHPSESSID',1362359138,1440,''),('ojjpfeu3qg7u8vt68j7fgfqk57','','PHPSESSID',1362359141,1440,''),('p2vuc3em9gjj6jn9hni3lcl807','','PHPSESSID',1362449639,1440,''),('p39hi9m5uo16lii8mtsp0eifu1','','PHPSESSID',1362449321,1440,''),('p481sr0dv077pnc3ski79toha5','','PHPSESSID',1362449604,1440,''),('p8n2e1j4jlci3ecd4o18g8epo0','','PHPSESSID',1362355293,1440,''),('pam6bjmtvnljvc2l50l62q3jo3','','PHPSESSID',1362421776,1440,''),('phr6d415rah2gqoihphi4jt7j2','','PHPSESSID',1362503228,1440,''),('pn4k855hdikgv1vg473loctmm1','','PHPSESSID',1362422855,1440,''),('qg7rp9nublp7f8grkfd6bjj242','','PHPSESSID',1362502072,1440,''),('qghgnr51cqj5nbkl9g2blr9454','','PHPSESSID',1362421906,1440,''),('r02ovfmhlanfph9udhmo6pjbs3','','PHPSESSID',1362449309,1440,''),('r1bkbdujaoc9aivhf6k6d96br7','','PHPSESSID',1362504377,1440,''),('r1u7th72ur4q35i01r6c9vsat2','','PHPSESSID',1362449287,1440,''),('r4s2ebep3u4npn0bi20losf0p3','','PHPSESSID',1362502760,1440,''),('r6rcrs2l5artj02ergo1922jb2','','PHPSESSID',1362504472,1440,''),('rakgugg7e450g8n41bgvg0h050','','PHPSESSID',1362502769,1440,''),('rbpk98k9himuck0pjpr2dg3771','','PHPSESSID',1362447475,1440,''),('rdir0lnc0ergq94krm18qef354','','PHPSESSID',1362503224,1440,''),('s2af2r3hhujnstorbncqpd0qu6','','PHPSESSID',1362502751,1440,''),('s2bcvf1pkt80dnq1c67iv38i66','','PHPSESSID',1362355256,1440,''),('s3sk42srh98b8jf6aok1a87e03','','PHPSESSID',1362449641,1440,''),('s56ie4so3f53sbi27c1hihsq75','','PHPSESSID',1362405074,1440,''),('s7hgsiujs2h6o0jagfj7tl5gt6','','PHPSESSID',1362503184,1440,''),('sh16a61c2inojm2v5c7s4afkf4','','PHPSESSID',1362409569,1440,''),('soornt9bne3vsaqvntug4q2tk3','','PHPSESSID',1362504294,1440,''),('t40jioqrds4pjjdu0jnt19hk87','','PHPSESSID',1362504378,1440,''),('t7nursek7pau554073agje4pj2','','PHPSESSID',1362447394,1440,''),('tbieaeg6jqvniqljolb22imsb3','','PHPSESSID',1362427226,1440,''),('tc3ip0bap71agui9rq8n32bd32','','PHPSESSID',1362504578,1440,''),('tfjuif3aftikethjcrnjpcfmo7','','PHPSESSID',1362504365,1440,''),('tl0cqbfq5jevo3r5chrhqa8lv6','','PHPSESSID',1362422541,1440,''),('ts1td76ni5p377dbjk5thnpfl1','','PHPSESSID',1362504469,1440,''),('ucav1ui800d0qssjnh05rqmkj1','','PHPSESSID',1362422853,1440,''),('ue7fk5t4t46skmu7eoa4ikass5','','PHPSESSID',1362359141,1440,''),('uifnelujq7a8ul25fda8dhvi57','','PHPSESSID',1362446949,1440,''),('ujnto1iqa4v2erqja2agmpg9l2','','PHPSESSID',1362359134,1440,''),('und36o7k5si0rjtfuhvqrg14q4','','PHPSESSID',1362449640,1440,''),('v7mkvkmdv8qr3q7pbhlr99uhr7','','PHPSESSID',1362502017,1440,''),('v8kpfduhpsbgdie9i6uenfb904','','PHPSESSID',1362503241,1440,''),('vrqtsmicfbaiuglktqa7m189c1','','PHPSESSID',1362502065,1440,'');

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
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `user_site_page_content_text_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `user_site_pages` (`id`),
  CONSTRAINT `user_site_page_content_text_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_content` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_page_content_text` */

insert  into `user_site_page_content_text`(`id`,`page_id`,`content_id`,`width`,`padding`,`title`,`show_title`,`content`) values (1,1,1,970,5,'Test content',1,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>'),(2,1,2,970,5,'Test content 2',1,'<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tincidunt tristique venenatis. Praesent elementum risus id odio tincidunt consectetur. Aliquam a tortor ligula. Suspendisse facilisis fermentum lectus, eu tempus sapien imperdiet ac. Aenean ut eleifend lacus.</p>');

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

/*Table structure for table `user_site_settings_color_palettes` */

DROP TABLE IF EXISTS `user_site_settings_color_palettes`;

CREATE TABLE `user_site_settings_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `palette_id` int(11) unsigned NOT NULL,
  `sort_order` tinyint(2) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `site_id` (`site_id`),
  KEY `palette_id` (`palette_id`),
  CONSTRAINT `user_site_settings_color_palettes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_settings_color_palettes_ibfk_3` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palettes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_settings_color_palettes` */

insert  into `user_site_settings_color_palettes`(`id`,`site_id`,`palette_id`,`sort_order`,`enabled`) values (1,1,1,1,1),(2,1,2,2,1),(3,1,3,3,1);

/*Table structure for table `user_site_settings_html_titles` */

DROP TABLE IF EXISTS `user_site_settings_html_titles`;

CREATE TABLE `user_site_settings_html_titles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `title_id` tinyint(3) unsigned NOT NULL,
  `style_id` tinyint(3) unsigned NOT NULL,
  `weight_id` tinyint(3) unsigned NOT NULL,
  `decoration_id` tinyint(3) unsigned NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `title_id` (`title_id`),
  KEY `style_id` (`style_id`),
  KEY `weight_id` (`weight_id`),
  KEY `decoration_id` (`decoration_id`),
  CONSTRAINT `user_site_settings_html_titles_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_settings_html_titles_ibfk_2` FOREIGN KEY (`title_id`) REFERENCES `designer_html_titles` (`id`),
  CONSTRAINT `user_site_settings_html_titles_ibfk_3` FOREIGN KEY (`style_id`) REFERENCES `designer_css_text_styles` (`id`),
  CONSTRAINT `user_site_settings_html_titles_ibfk_4` FOREIGN KEY (`weight_id`) REFERENCES `designer_css_text_weights` (`id`),
  CONSTRAINT `user_site_settings_html_titles_ibfk_5` FOREIGN KEY (`decoration_id`) REFERENCES `designer_css_text_decoration` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_settings_html_titles` */

insert  into `user_site_settings_html_titles`(`id`,`site_id`,`title_id`,`style_id`,`weight_id`,`decoration_id`,`sort_order`,`enabled`) values (1,1,1,1,2,1,1,1),(2,1,2,1,2,1,2,1),(3,1,3,1,2,1,3,1),(4,1,4,1,2,1,4,1),(5,1,5,2,2,1,5,1),(6,1,6,1,1,1,6,1),(7,1,7,2,1,1,7,1);

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
