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

insert  into `dlayer_sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('05p0ba03e50bmv60rn1c1adqo6','','PHPSESSID',1362014706,1440,''),('07geganiu1bk7eea3d2j2co4n7','','PHPSESSID',1362014766,1440,''),('0abkp36f12hm8kaikcf17e4807','','PHPSESSID',1362014704,1440,''),('0erahhj9u59tgg29jp5hul64p5','','PHPSESSID',1362014705,1440,''),('0gr561q7npnunph5eoungpuss7','','PHPSESSID',1362014884,1440,''),('0ip6k0slr67urkn1s15u82v1u4','','PHPSESSID',1362014632,1440,''),('0ovufqk699e7t2q6b87g0dc8g6','','PHPSESSID',1362013931,1440,''),('0qh9flrat2rog6dl1ff7sqqv37','','PHPSESSID',1362014767,1440,''),('0u9pr1g2thlv8s3r2q48ph8l16','','PHPSESSID',1362014597,1440,''),('1iei607trftdh7o8u8m31ng511','','PHPSESSID',1362014574,1440,''),('1rj4fp431oik9es6rr385o6hm3','','PHPSESSID',1362014589,1440,''),('23g82oh60vidbf8sijkurrvkn0','','PHPSESSID',1362013922,1440,''),('2ck0sbrf00tevlrqs0n2ma9p11','','PHPSESSID',1362014653,1440,''),('2l401kgcc7j051oi23fjrimp93','','PHPSESSID',1362014767,1440,''),('2pc9p3gokcjlqm4i0a3crd2pf6','','PHPSESSID',1362014976,1440,''),('2r7mka5737gjq48imt6u2cq514','','PHPSESSID',1362153626,1440,''),('2urjtps28pj33jlkem9n4uplr2','','PHPSESSID',1362014631,1440,''),('2vda8aehpfalmgtd3n0bm5jt60','','PHPSESSID',1362015032,1440,''),('34b2ms5dfh3mqgm4t6pkb8vpa0','','PHPSESSID',1362154071,1440,''),('3f981fpabhtcculkrsp868p4r3','','PHPSESSID',1362014579,1440,''),('3h84a0ao4btao8ilbp0uio89u4','','PHPSESSID',1362013666,1440,''),('3v2eh1jack7cpi9ln8s0b9ujd7','','PHPSESSID',1362014981,1440,''),('458qselh5phc75ti9v8peasda3','','PHPSESSID',1362013916,1440,''),('4a75tnrv544rnn06rj98mv7lp0','','PHPSESSID',1362014628,1440,''),('4a8cedjneta2rpmlvjff146it5','','PHPSESSID',1362014871,1440,''),('4budsb9e207q4ha9nvjov56n95','','PHPSESSID',1362014636,1440,''),('4il379t6htrjq8dqmm96e32ig4','','PHPSESSID',1362014957,1440,''),('4moq9qm825cq8poe7qqsj32df2','','PHPSESSID',1362154383,1440,''),('4p0madcj0sl49phhbqb77070v4','','PHPSESSID',1362153873,1440,''),('4sk27m50gr959tllukqg178qb6','','PHPSESSID',1362014630,1440,''),('52j9gc3auui8ef3sthnp0rt5k0','','PHPSESSID',1362014586,1440,''),('55bge0hl3il52pshd9jnm0c203','','PHPSESSID',1362014744,1440,''),('56s4cikmn54hoftnaprl8efqj6','','PHPSESSID',1362014879,1440,''),('58g8ahqc2ro966504o9c71k3m3','','PHPSESSID',1362013608,1440,''),('58q40elnat3ic526tq4maijh66','','PHPSESSID',1362014980,1440,''),('5d9jb8nmsro09raq3640tm6ep3','','PHPSESSID',1362013662,1440,''),('5fmbio991t86dsjrbk8vbq33d0','','PHPSESSID',1362014961,1440,''),('5iqaltj0omklk04bm0jnofirn4','','PHPSESSID',1362013920,1440,''),('5tmr9fb05dso6lnsi3h62qe6k3','','PHPSESSID',1362014955,1440,''),('5umsuthbhhgk3gufmbln1j3ch7','','PHPSESSID',1362014762,1440,''),('608eq0ebp8tjcscqevc8i7ml72','','PHPSESSID',1362015038,1440,''),('6dorehbmb8qs8l8ep2s6b8e847','','PHPSESSID',1362015040,1440,''),('6gpj68jtjkcjg9qpgqp7jhpbe3','','PHPSESSID',1362014975,1440,''),('6hhja7lk7oor7prn6kaqfiv7i2','','PHPSESSID',1362013609,1440,''),('6jjaa3rhttlvggvammcdeqtng4','','PHPSESSID',1362014190,1440,''),('6q1u9euocl24mnt2elnb3a6q77','','PHPSESSID',1362013599,1440,''),('734ab7guulut6osf2heig5p760','','PHPSESSID',1362014627,1440,''),('743klfnmrqrco0f6dn5ev100b7','','PHPSESSID',1362014880,1440,''),('7d8shiss3i25n367ktvju0p8q5','','PHPSESSID',1362154083,1440,''),('7jje007tn66fhbvcj2cn8gd7c5','','PHPSESSID',1362013918,1440,''),('7k29j2mkvrn1634c2p37tmuka1','','PHPSESSID',1362013942,1440,''),('7k3o2sgbqolffpd64m90mv1ud7','','PHPSESSID',1362153634,1440,''),('7o16j0420rd6nre8cdbfuvhb31','','PHPSESSID',1362014766,1440,''),('7v0uremb11i1e1uvrunsscl1r3','','PHPSESSID',1362015047,1440,''),('80bilgnhiv96oenc2039rede32','','PHPSESSID',1362013601,1440,''),('82ak6o2g5j2br96rit07poc766','','PHPSESSID',1362014629,1440,''),('83cen44hhju4k9u318bpk32ta0','','PHPSESSID',1362014743,1440,''),('86mla034q8i35b0c8ibelivel0','','PHPSESSID',1362014762,1440,''),('88b0a8o6tv0ecbb0ejv72iddj0','','PHPSESSID',1362014706,1440,''),('89lurq272ok2e3bdoftnugbvb5','','PHPSESSID',1362153871,1440,''),('8hbsfo76ko14t9qs151n4vrte7','','PHPSESSID',1362013658,1440,''),('8u1rs5qvbhfp0m229mvbrg6s46','','PHPSESSID',1362014599,1440,''),('969jtg6gpimq7iu4hecepma784','','PHPSESSID',1362014762,1440,''),('9eiv0u5gjtdod3uudq1tnnfu25','','PHPSESSID',1362013517,1440,''),('9ln3q46ql36c9h4pmm5its8iu5','','PHPSESSID',1362013667,1440,''),('9nm7do98k2l9snj2uvirqb7dh0','','PHPSESSID',1362014737,1440,''),('9tdki65gm549au9o5l0r9ncmq0','','PHPSESSID',1362014742,1440,''),('9u1ua3i7iv3a9ek6h4rafe9ib4','','PHPSESSID',1362152217,1440,''),('a19filegtc3lc7i7c9tn8pc9l4','','PHPSESSID',1362014867,1440,''),('a23g0dn814amrsj5m19iv0lie4','','PHPSESSID',1362153628,1440,''),('a68bgnusfibesulmc5gau0ms41','','PHPSESSID',1362013957,1440,''),('ab8b1ofgl78vd82d89l83chbn1','','PHPSESSID',1362153933,1440,''),('asl94lkpbm326u27f31t8ueni1','','PHPSESSID',1362015041,1440,''),('bii01ikdnqh4ev9dt916d2sd45','','PHPSESSID',1362014871,1440,''),('bljf7fbogbi6itc6efhehgapt7','','PHPSESSID',1362013935,1440,''),('c82v51mavickc7h1bhq9b0g683','','PHPSESSID',1362013951,1440,''),('cbi24ga9rdcudgifg7e9s1fg31','','PHPSESSID',1362014864,1440,''),('cekss36i0hud0jca9sja5q15l2','','PHPSESSID',1362013919,1440,''),('cip5nokotddihnqpi3fuvhg6h5','','PHPSESSID',1362154075,1440,''),('cl9ld1e6nc0cujo5pmn4b3neq2','','PHPSESSID',1362015059,1440,''),('cp1t18p090bb6abng90bkcune6','','PHPSESSID',1362153844,1440,''),('cvaob6vm1ph5bon5ed9febit87','','PHPSESSID',1362013663,1440,''),('dcma0nhvp2apak4tbmgienqfp4','','PHPSESSID',1362014186,1440,''),('dp12f7eme600ho6o644p0d9620','','PHPSESSID',1362014762,1440,''),('elhrqfs4ip3n3ij0ea15e0n4r4','','PHPSESSID',1362014767,1440,''),('esaai8d6fm755kkpb94e0raap6','','PHPSESSID',1362013437,1440,''),('fiq713c6qgeg9d52lq6pjnem84','','PHPSESSID',1362014171,1440,''),('fktremlupo9h2sd3ugrhdbeo85','','PHPSESSID',1362014739,1440,''),('fvu6eptukfpcfasmhtr7i59tj5','','PHPSESSID',1362014962,1440,''),('g375gef37gihr7f3mdpstasnh7','','PHPSESSID',1362014865,1440,''),('gjlghet8vk8a85qsqjsd6a4u12','','PHPSESSID',1362014654,1440,''),('gs9fe4e611fv45ts1oo2g5fbi2','','PHPSESSID',1362014576,1440,''),('gtjrg5m6v1262mroao8vclm3f6','','PHPSESSID',1362153843,1440,''),('guid59psb4lfld83jilha2h282','','PHPSESSID',1362014974,1440,''),('gv6dq97augqn1r2a8fg1i9ac44','','PHPSESSID',1362014599,1440,''),('h286su7kpkp8ui4801qo3deg72','','PHPSESSID',1362014872,1440,''),('h76id5qd4knfhcfes6gobotck0','','PHPSESSID',1362014972,1440,''),('h9eauk20rogkoijmao0g4q4ic2','','PHPSESSID',1362013925,1440,''),('hi2efiic4d90rrtnu3jnnuli87','','PHPSESSID',1362014711,1440,''),('hjh3gq4tq6953aruhbrrhipi94','','PHPSESSID',1362014876,1440,''),('hqhfmn0cq61gttt934mn7bqkh0','','PHPSESSID',1362013940,1440,''),('hqqpkjggebrude2d8pnk9hqqr5','','PHPSESSID',1362014970,1440,''),('hv06kliv0q62mut8af7dp0h3r7','','PHPSESSID',1362014766,1440,''),('i76k1ulauh78ghscql24bint35','','PHPSESSID',1362153870,1440,''),('ib1vq4pv6ajdjgd0ff8lcvjrp1','','PHPSESSID',1362013946,1440,''),('id7c4ssk4pjq8ibb8llnhmfs06','','PHPSESSID',1362015132,1440,''),('iggn3k7ug3sea0d49uacc4ibt5','','PHPSESSID',1362014711,1440,''),('isbetrkkfkju4h1ggj91fs3nf0','','PHPSESSID',1362013927,1440,''),('j0o7oj1m9sqge2stoikcsstvp7','','PHPSESSID',1362015065,1440,''),('jefcdr2usthi8i9lcv5gtvkac5','','PHPSESSID',1362014875,1440,''),('jh680bbgd49numbfvacj2nqf11','','PHPSESSID',1362014709,1440,''),('jifr2oak273svnaj4o8f71tni7','','PHPSESSID',1362013950,1440,''),('jq6kielbvpl267n8n8mjbho9q3','','PHPSESSID',1362154383,1440,'dlayer_session|a:2:{s:9:\"module_id\";s:1:\"4\";s:7:\"site_id\";i:1;}dlayer_session_content|a:9:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";s:3:\"159\";s:19:\"selected_content_id\";N;s:7:\"tool_id\";s:2:\"10\";s:9:\"tool_name\";s:4:\"text\";s:10:\"tool_model\";s:4:\"Text\";s:13:\"ribbon_tab_id\";s:2:\"23\";s:15:\"ribbon_tab_name\";N;}'),('jqpsc0ju9p1kmfn8q32e97l7e7','','PHPSESSID',1362014869,1440,''),('k1s3e5pns3g0dppe2qqbedob53','','PHPSESSID',1362014191,1440,''),('k47pjc53tqgs8ial4g441f2m11','','PHPSESSID',1362015026,1440,''),('k7264vjaad2gqh3uv75n3716h0','','PHPSESSID',1362014962,1440,''),('kbl0iu38e614k84inofrj91cq4','','PHPSESSID',1362015168,1440,''),('kfnt95r9eud1ncq8anja9v80i3','','PHPSESSID',1362013436,1440,''),('kjo7krrn3seleuncf2ho6qi613','','PHPSESSID',1362014759,1440,''),('kktfe2c4ji8pot6lckue2p5h55','','PHPSESSID',1362014185,1440,''),('kohvkiqocqr6up5nhgeitj1ff0','','PHPSESSID',1362014735,1440,''),('kr3abf827bjhe633i9d5c47p86','','PHPSESSID',1362013928,1440,''),('lk9gdt08qkhfmtnbsqcsvjt3e0','','PHPSESSID',1362014358,1440,''),('llos0b9bitpn8l03a4qsfmhrl6','','PHPSESSID',1362014357,1440,''),('m2n4o4ist48a49cfifvc7ajmq5','','PHPSESSID',1362014587,1440,''),('m7nm6dkv4usl4stmceab52ejt1','','PHPSESSID',1362014863,1440,''),('m9u98367bqdul1un7jdcnha3b3','','PHPSESSID',1362013923,1440,''),('mfi0sqlmhocma2ublb7cp9p4b3','','PHPSESSID',1362015131,1440,''),('mrgohngshrrfve0iks02386746','','PHPSESSID',1362013934,1440,''),('mt8oa3lda49atsev7j1eiflq86','','PHPSESSID',1362014882,1440,''),('mv1i4i0guhqrkmaoh0lsluibb6','','PHPSESSID',1362014577,1440,''),('n9r7qvfueo229ihlenfdnqf5k0','','PHPSESSID',1362153842,1440,''),('no67n8nhdn69ig86hgc20cjru6','','PHPSESSID',1362153877,1440,''),('nt7ci5gipf6usm40uisj7fj5j7','','PHPSESSID',1362154073,1440,''),('o1rip733pqqs69nvo389ok39l3','','PHPSESSID',1362014955,1440,''),('o3jf19k3sp6oshftu471mhjtp5','','PHPSESSID',1362014978,1440,''),('o457c4beaaieo9kt9tv6iuf7e2','','PHPSESSID',1362014873,1440,''),('o7972p4jskeab15sms248ome27','','PHPSESSID',1362015066,1440,''),('o8oi1v5sivf0pvljpinkok4li4','','PHPSESSID',1362014868,1440,''),('o9n7ft3ntu7o3jtniebkkeae32','','PHPSESSID',1362013953,1440,''),('ofucc7su4jvgu2urs36d5mene3','','PHPSESSID',1362014744,1440,''),('ofvmd6g3kvort2clb821fp3j60','','PHPSESSID',1362014600,1440,''),('oll5g5vapoj5rqgsndhkdieng6','','PHPSESSID',1362014883,1440,''),('oq9h73b55qeaeu11b0seino556','','PHPSESSID',1362014878,1440,''),('pbvr2e1usoao9cr1svajdi4u90','','PHPSESSID',1362014971,1440,''),('pf20itfsdqsa3g7ub4evd7q0e4','','PHPSESSID',1362014870,1440,''),('pg9bi7ir1dmm9jsugdukfdk9q5','','PHPSESSID',1362013437,1440,''),('phl1s0ci2cpf1pmmp44i6p97t0','','PHPSESSID',1362013659,1440,''),('pnl4b6iegi3nbd0t7ba0cuu1b5','','PHPSESSID',1362013665,1440,''),('pq65sv76b4i33oc2rmcbb6s5e6','','PHPSESSID',1362014736,1440,''),('ptg0l7irb15todmdh2uhsejue0','','PHPSESSID',1362013608,1440,''),('pue7qa4l37hatrvmqo4ncos331','','PHPSESSID',1362014584,1440,''),('q3cfs8clss6e5nev0fg16vtk11','','PHPSESSID',1362014760,1440,''),('q4uc7trcv8sungt718ikifjck4','','PHPSESSID',1362015053,1440,''),('r82rrflaoe4j84cneqvd3e5de5','','PHPSESSID',1362013933,1440,''),('rfggk4rhc1cilohu0q6gisv5a2','','PHPSESSID',1362014580,1440,''),('rfmkodlki5e98eaeeghv9igth4','','PHPSESSID',1362153624,1440,''),('riusrnb0glql4onlqkbl814og2','','PHPSESSID',1362154077,1440,''),('rjoei1mpaaa06foiia0nql1ng7','','PHPSESSID',1362014600,1440,''),('s4sr19fvem656e1fi3nb1feug6','','PHPSESSID',1362014767,1440,''),('sct4rn79a14btf8ua87aslgef5','','PHPSESSID',1362153621,1440,''),('sfphvd3qalj2pgjlv190t570q0','','PHPSESSID',1362014597,1440,''),('t0fveaot9ad7fcg9dcd73itpl1','','PHPSESSID',1362014767,1440,''),('t187v2ai1sim2mssr43eosujv6','','PHPSESSID',1362014712,1440,''),('t1is3cre0etbrq9nbp4d060gd1','','PHPSESSID',1362014582,1440,''),('t2u5g8c8pv7biuo3gkvvls2m54','','PHPSESSID',1362014761,1440,''),('tjiuncu5enu25g74dpnaggeqb3','','PHPSESSID',1362014172,1440,''),('u01hgq283rv35sapni5djtp445','','PHPSESSID',1362014959,1440,''),('u39b86mm7us6i4essa4808k6q1','','PHPSESSID',1362153913,1440,''),('udg84uch3k4to7n5icv87e4v43','','PHPSESSID',1362013440,1440,''),('ue284s1al78hd789amt02uvkr5','','PHPSESSID',1362015020,1440,''),('us7dnfud7a0ikflg8s6cli3g42','','PHPSESSID',1362014766,1440,''),('v8jj6rs3ullmkl7psctmgc6l85','','PHPSESSID',1362153878,1440,''),('vfi72crd7him4o5k0oilgjb557','','PHPSESSID',1362014881,1440,''),('vfqlab44d7usfrj15vdtr9gld7','','PHPSESSID',1362013607,1440,''),('vhq88o4kco1mr8j07t9mhc3nf1','','PHPSESSID',1362014767,1440,''),('vjn5vtoi6qrjeh7rkn6dl0d832','','PHPSESSID',1362014598,1440,''),('vvncjlb19ap02lkugkp3r7uib6','','PHPSESSID',1362014357,1440,'');

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
  `width` int(4) NOT NULL DEFAULT '1',
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

/*Table structure for table `user_site_template_settings_color_palettes` */

DROP TABLE IF EXISTS `user_site_template_settings_color_palettes`;

CREATE TABLE `user_site_template_settings_color_palettes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(11) unsigned NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `palette_id` int(11) unsigned NOT NULL,
  `sort_order` tinyint(2) NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `enabled` (`enabled`),
  KEY `site_id` (`site_id`),
  KEY `template_id` (`template_id`),
  KEY `palette_id` (`palette_id`),
  CONSTRAINT `user_site_template_settings_color_palettes_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`),
  CONSTRAINT `user_site_template_settings_color_palettes_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_template_settings_color_palettes_ibfk_3` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palettes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_settings_color_palettes` */

insert  into `user_site_template_settings_color_palettes`(`id`,`site_id`,`template_id`,`palette_id`,`sort_order`,`enabled`) values (1,1,1,1,1,1),(2,1,1,2,2,1),(3,1,1,3,3,1);

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
