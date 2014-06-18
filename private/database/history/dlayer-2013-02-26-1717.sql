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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tool_tabs` */

insert  into `dlayer_module_tool_tabs`(`id`,`module_id`,`tool_id`,`name`,`script_name`,`multi_use`,`default`,`sort_order`,`enabled`) values (1,1,2,'Quick split','quick',0,1,1,1),(2,1,2,'Split with mouse','advanced',0,0,2,1),(3,1,2,'Help','help',0,0,3,1),(4,1,3,'Quick split','quick',0,1,1,1),(5,1,3,'Split with mouse','advanced',0,0,2,1),(6,1,3,'Help','help',0,0,3,1),(7,1,7,'Palette 1','palette-1',0,1,1,1),(8,1,7,'Palette 2','palette-2',0,0,2,1),(9,1,7,'Palette 3','palette-3',0,0,3,1),(10,1,7,'Set custom color','advanced',0,0,4,1),(11,1,7,'Help','help',0,0,5,1),(12,1,6,'Set custom size','advanced',0,0,5,1),(14,1,6,'Help','help',0,0,6,1),(15,1,6,'Expand','expand',1,1,1,1),(16,1,6,'Contract','contract',1,0,2,1),(17,1,6,'Adjust height','height',1,0,3,1),(20,1,8,'Set custom border','advanced',1,1,2,1),(21,1,8,'Help','help',0,0,3,1),(22,1,8,'Full border','full',0,0,1,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_module_tools` */

insert  into `dlayer_module_tools`(`id`,`module_id`,`name`,`process_model`,`script`,`icon`,`base`,`group_id`,`sort_order`,`enabled`) values (1,1,'Cancel','','cancel','cancel.png',1,1,1,1),(2,1,'Split horizontal','SplitHorizontal','split-horizontal','split-horizontal.png',1,2,1,1),(3,1,'Split vertical','SplitVertical','split-vertical','split-vertical.png',1,2,2,1),(6,1,'Resize','Resize','resize','resize.png',0,3,3,1),(7,1,'Background color','BackgroundColor','background-color','background-color.png',1,4,1,1),(8,1,'Border','Border','border','border.png',0,4,2,1),(9,4,'Cancel','','cancel','cancel.png',1,1,1,1);

/*Table structure for table `dlayer_modules` */

DROP TABLE IF EXISTS `dlayer_modules`;

CREATE TABLE `dlayer_modules` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dlayer_modules` */

insert  into `dlayer_modules`(`id`,`name`,`description`,`icon`,`sort_order`,`enabled`) values (1,'template','Template designer','template.png',1,1),(2,'widget','Widget designer','widget.png',4,0),(3,'form','Forms builder','form.png',3,0),(4,'content','Content manager','content.png',2,1),(5,'website','Website manager','website.png',5,0);

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

insert  into `dlayer_sessions`(`session_id`,`save_path`,`name`,`modified`,`lifetime`,`session_data`) values ('00pmbdlkv6j1lri06d2ib8b9i5','','PHPSESSID',1361897776,1440,''),('02379ovlhv8bd1a2je2n52ln10','','PHPSESSID',1361898902,1440,''),('07678l0gv690f24mnfnmpmokg1','','PHPSESSID',1361844984,1440,''),('08u33mgguehgtv950boee2mid6','','PHPSESSID',1361811671,1440,''),('0gca7d91udtsbr5e561irmfts2','','PHPSESSID',1361898890,1440,''),('0hdln09sjciuu030aq7ukl9h94','','PHPSESSID',1361899000,1440,''),('0i6oj6n53g0pmd82dgscppnp35','','PHPSESSID',1361842196,1440,''),('0kg5tkcgs855t8e4md43472ln6','','PHPSESSID',1361898888,1440,''),('0o0pi49pksrvq7uq6qojk9krm7','','PHPSESSID',1361812186,1440,''),('0oeeq7g6gfqf46a2juhusuj884','','PHPSESSID',1361812436,1440,''),('0s1k9cedhmcsn5pa6igki10ps3','','PHPSESSID',1361896604,1440,''),('0s2gmji49tb0unu9uetvrvc6v4','','PHPSESSID',1361845483,1440,''),('0t3g437tsmrptrko9vfeiihbo3','','PHPSESSID',1361845572,1440,''),('0t5va8099qu16rb0f2flje37c4','','PHPSESSID',1361811421,1440,''),('129p8j5jb1lvcd0fe20qb4i780','','PHPSESSID',1361760381,1440,''),('12tn92kogb6dgfr8fil5g9s2d6','','PHPSESSID',1361899026,1440,''),('14j9dag8d77vlirfrbsbbfb2d5','','PHPSESSID',1361898886,1440,''),('15m888l1s5dsh26qtclpm4uio7','','PHPSESSID',1361762802,1440,''),('1648579ei9t1itohb8d0886f56','','PHPSESSID',1361845566,1440,''),('1941u66atjit41bhvu6v6h3gr2','','PHPSESSID',1361761413,1440,''),('19s8akhqgchp9ors8ej7inmmn7','','PHPSESSID',1361812184,1440,''),('1bqkcj40ebmpmdgh084vifsll0','','PHPSESSID',1361844571,1440,''),('1dordafpvqg2idl45btg01sp27','','PHPSESSID',1361845435,1440,''),('1f0idlmjmni1aq9v8fmupa4bf5','','PHPSESSID',1361898998,1440,''),('1fd3jdsr7dgqmsllkv4mhf18o5','','PHPSESSID',1361802779,1440,''),('1hfhv7np8c18bh7e17kiql4fe3','','PHPSESSID',1361844628,1440,''),('1il9doohbejcg03u6have5ns67','','PHPSESSID',1361898436,1440,''),('1jsmfrnbuddq3u33km1fbj6m35','','PHPSESSID',1361803530,1440,''),('1k2d86hm0fno928082q5u163g4','','PHPSESSID',1361761406,1440,''),('1lbpnhq6qt4kgou3imud2gk216','','PHPSESSID',1361898996,1440,''),('1nnp484evt4v1lnhjf8spb8ti0','','PHPSESSID',1361842401,1440,''),('1us3gucana8qoimk2krajn8fa1','','PHPSESSID',1361890554,1440,''),('1v7ppr1bdlpr7pa3rso3a3tdd1','','PHPSESSID',1361844983,1440,''),('2321sdfloor3e0qpcia6e4oln4','','PHPSESSID',1361842198,1440,''),('24gpfd1o30v1kb63b3k31g9i00','','PHPSESSID',1361845489,1440,''),('2651i25gf42e9qcs6uo5g77kq4','','PHPSESSID',1361898880,1440,''),('281o552vhhhcd74hj8quvlo5l3','','PHPSESSID',1361841922,1440,''),('28td5tge6b45pqusn2qepjt4i4','','PHPSESSID',1361803250,1440,''),('2943jtrsamt9hkavokct9c7cu6','','PHPSESSID',1361761407,1440,''),('2bl4auj47mqa3flqdk04r7leu4','','PHPSESSID',1361888951,1440,''),('2c4ond3m6b81bqduqf00ace117','','PHPSESSID',1361842539,1440,''),('2cs0l7pn3a7fd4jch8fl9l7sl1','','PHPSESSID',1361812196,1440,''),('2e96v333u3c35luk0bhn01mv26','','PHPSESSID',1361898968,1440,''),('2etfnl70m0f3pl93lkffsggfi5','','PHPSESSID',1361811814,1440,''),('2fff1cknmnpnasuo5lgt412001','','PHPSESSID',1361888933,1440,''),('2h9ragkef9hcet5cf0tof3kqe0','','PHPSESSID',1361897778,1440,''),('2horom8ht4gtgdcm6j90s16sf2','','PHPSESSID',1361898994,1440,''),('2ivg4ueiktu1mbpnbf5tucbuq0','','PHPSESSID',1361897284,1440,''),('2klbjo428rha7aicg9oo7105o1','','PHPSESSID',1361898994,1440,''),('2lvnmkuki7s37v9rk6l2tdier5','','PHPSESSID',1361803418,1440,''),('2meh9jcra5k64a1d5tso92mtb4','','PHPSESSID',1361844461,1440,''),('2mk66p6aotmj90pnddtq0ibup4','','PHPSESSID',1361845048,1440,''),('2nq0uqpa27knad43jih5r4st40','','PHPSESSID',1361811689,1440,''),('2p8dfdfq5sapgq0dfscl5j2up1','','PHPSESSID',1361811419,1440,''),('2rbcgdt0g6godrd93i7aove4k7','','PHPSESSID',1361897283,1440,''),('2v86t9ugi422rc5m3i4l37p3m0','','PHPSESSID',1361812419,1440,''),('30ud822rgsetr7vcv4kt99sf35','','PHPSESSID',1361845434,1440,''),('32c0jqbe7lq1u87aijb2ffb4l7','','PHPSESSID',1361763079,1440,''),('3504uionbs3bk81pt69g09dbe0','','PHPSESSID',1361899028,1440,''),('363l4qgedsfj067moek5qc8f16','','PHPSESSID',1361897414,1440,''),('378258kfjrruhtivumimssfgt6','','PHPSESSID',1361811477,1440,''),('393oqsrfgbuv03892r5f6prv51','','PHPSESSID',1361803374,1440,''),('39uv7oqmj41t0dfivtkjea8oo6','','PHPSESSID',1361845066,1440,''),('3b8re06uuc6qe708825f514lg2','','PHPSESSID',1361760630,1440,''),('3gsp72g7uadkmapmk8i24ivi17','','PHPSESSID',1361802801,1440,''),('3hg1hacu7ue0c470mjie2ephh3','','PHPSESSID',1361802775,1440,''),('3hjjod094q430knffm028jts34','','PHPSESSID',1361802812,1440,''),('3hud8s6j458t19mpvggnk4aup0','','PHPSESSID',1361812772,1440,''),('3p3dah4frrpclmjtvjriepco00','','PHPSESSID',1361888933,1440,''),('3qslgtet773172l82gptjnc2o1','','PHPSESSID',1361842900,1440,''),('3sbdru6mi9r9630vef2t9g3bs1','','PHPSESSID',1361897580,1440,''),('3tiq5jhfoh26vubfjens8ir4j7','','PHPSESSID',1361762804,1440,''),('3uu2thfv0vt1lip0ni4lnd73f3','','PHPSESSID',1361846089,1440,'dlayer_session|a:3:{s:9:\"module_id\";s:1:\"4\";s:7:\"site_id\";i:1;s:11:\"template_id\";i:1;}dlayer_session_template|a:5:{s:7:\"tool_id\";N;s:16:\"selected_element\";N;s:9:\"tool_name\";N;s:10:\"tool_model\";N;s:10:\"ribbon_tab\";N;}'),('417r5ufcvas8tudrd6qbn4nsg6','','PHPSESSID',1361845294,1440,''),('418crpm32hb3nmufhpamk86rv0','','PHPSESSID',1361760631,1440,''),('45038m81gqg3o2m6litckfuat7','','PHPSESSID',1361897255,1440,''),('47scvf3ckd669a8fa09ptecpp7','','PHPSESSID',1361760467,1440,''),('49djud4h6h2vpd32msf5jqdv72','','PHPSESSID',1361761368,1440,''),('4cnuoo45pu3atsisld7u55l0m5','','PHPSESSID',1361842541,1440,''),('4ethmhn011sssgl4iu3aukjhe2','','PHPSESSID',1361898890,1440,''),('4f22kof6adbfcg79e5ur2aqk37','','PHPSESSID',1361844643,1440,''),('4hksg10fu3igpbi9d6kl7u98r3','','PHPSESSID',1361803529,1440,''),('4ibsqlf7itv0orc5q8quejip51','','PHPSESSID',1361842899,1440,''),('4jcv7n7fql4jscbi7l7nvhcc12','','PHPSESSID',1361890005,1440,''),('4jh5bagbr2kvbhcfjjtjnjee23','','PHPSESSID',1361763385,1440,''),('4knug1uhr1d30n7b87893sl235','','PHPSESSID',1361898972,1440,''),('4lt2dus65hiijdl0qaf0gg9s51','','PHPSESSID',1361845615,1440,''),('4rga4lldfq7ddklc5l6o2a4vb3','','PHPSESSID',1361761245,1440,''),('4rlmpq8i7cl9l2v8v7ekqhk554','','PHPSESSID',1361898904,1440,''),('4rp2odrdsfg6ujautsqf1811r4','','PHPSESSID',1361898988,1440,''),('4ua8ktdoijjp647f197bcfd115','','PHPSESSID',1361811645,1440,''),('4uoi4nor6aj4v25d9v4red8bi1','','PHPSESSID',1361802834,1440,''),('5325slvcur6htjnfop5ba2d9a0','','PHPSESSID',1361761460,1440,''),('5b6cf6bh7jnn7n0qldtc51rkn0','','PHPSESSID',1361812182,1440,''),('5d88uslptmvtrt155mv8ebfku6','','PHPSESSID',1361842536,1440,''),('5e6gdndjqo9c6k46pjdafjc1q3','','PHPSESSID',1361802832,1440,''),('5ftctoehbtufrqnrhqclqeqjv2','','PHPSESSID',1361898990,1440,''),('5h83a6gok2env522nfjviosg25','','PHPSESSID',1361845427,1440,''),('5l03v845ktvpdsolrvi78dkv62','','PHPSESSID',1361811418,1440,''),('5q2rntnluf6hvdnuhschn4kl73','','PHPSESSID',1361763399,1440,''),('600ge1i1mf807o4celoegd8sa1','','PHPSESSID',1361844822,1440,''),('62o402bo5tk1fn4jbclskm0a75','','PHPSESSID',1361897268,1440,''),('64ra65ifiipopnqqp6k0o6mnv0','','PHPSESSID',1361896839,1440,''),('67uglceg6n6rcs0j1u4qnv10d3','','PHPSESSID',1361760456,1440,''),('6bekkr6a1b3kvv5v91lqqmj326','','PHPSESSID',1361842398,1440,''),('6bfjal10olrjlnkj0dj2ncpc06','','PHPSESSID',1361842905,1440,''),('6ch1sgqsd7em4arvl9591r1141','','PHPSESSID',1361888949,1440,''),('6eja68h90o93g9r1adkb1krrb3','','PHPSESSID',1361760564,1440,''),('6fl4fm8amlr030lsklus3ml7n7','','PHPSESSID',1361802802,1440,''),('6h2hnef17u90cmnq8i0144f2m3','','PHPSESSID',1361802787,1440,''),('6hjts0l15shnn3b4h1l1g1pk41','','PHPSESSID',1361811420,1440,''),('6i5e4rs85h76g988nvvma2am84','','PHPSESSID',1361897065,1440,''),('6ippa4db88hh3m0hcegf2e67s5','','PHPSESSID',1361761306,1440,''),('6kqjtqt8euid16bc0j68bksji1','','PHPSESSID',1361897702,1440,''),('6mrvcenb3amkqig9tk4ao78a85','','PHPSESSID',1361898969,1440,''),('6n2npr50447055g4m3hfcode83','','PHPSESSID',1361889786,1440,''),('6oar83qb416k65u1oil1k800e2','','PHPSESSID',1361845566,1440,''),('6rgt8t3cmt3c166knm4g1tqqp5','','PHPSESSID',1361761198,1440,''),('6sojvlj82gen6bfprv5dqkj026','','PHPSESSID',1361897744,1440,''),('6u584imm9gsqklhv5np9uu4sa1','','PHPSESSID',1361888653,1440,''),('73iv3r97f7jp11bcinpcii9b75','','PHPSESSID',1361844458,1440,''),('73k188g4gvk8p871pc25j3i3e2','','PHPSESSID',1361803146,1440,''),('76cibg74ihof62osliim6ugd02','','PHPSESSID',1361845613,1440,''),('794ob381k4igrn5q2gdrb6mgi6','','PHPSESSID',1361896642,1440,''),('7a6t9g6dtn1i3lqgvrsjvvll05','','PHPSESSID',1361897736,1440,''),('7aq4je66qltv370ba6ib71jsn6','','PHPSESSID',1361811418,1440,''),('7dtc336175ca2lvnq7uaj3dtr7','','PHPSESSID',1361844469,1440,''),('7ehal3h8n8u0h1uebirhrls285','','PHPSESSID',1361898773,1440,''),('7fafud12l4vq1f4l0tlbjna6p0','','PHPSESSID',1361803619,1440,''),('7h1es4bhufeleeonlpk8cdu9g0','','PHPSESSID',1361760641,1440,''),('7kbugtm9k6um0oootsl8lo3in5','','PHPSESSID',1361842196,1440,''),('7kd0t2krj2hrvi9tnut55i5tj2','','PHPSESSID',1361802928,1440,''),('7l2qn1ruoh5hljciumpcjt51r3','','PHPSESSID',1361811647,1440,''),('7m0iuv27v95ebf9d04fld21jg5','','PHPSESSID',1361895808,1440,''),('7qt3p9ddvm89agdvrpeierq5l2','','PHPSESSID',1361802778,1440,''),('7retcs5uuvcgcms9cdj2qnd2a7','','PHPSESSID',1361803584,1440,''),('7s3bj4sb6f6dti1kh8p6b4g7u7','','PHPSESSID',1361898970,1440,''),('808c8q8u19muji2l0elu1rdbo4','','PHPSESSID',1361897605,1440,''),('80jet0hd0mqt5frdt2srt7qb85','','PHPSESSID',1361763084,1440,''),('82e7m5v8d8qf5i16bdp9rtgsm5','','PHPSESSID',1361812505,1440,''),('85adp240t7j9msiavf82sdru94','','PHPSESSID',1361898884,1440,''),('863knpkkmj7dn6pv0jiopsqf76','','PHPSESSID',1361842411,1440,''),('86m9820kduqkvbfcj29v1lfn53','','PHPSESSID',1361844463,1440,''),('88cfn0hfamuc0bshagjdrchv61','','PHPSESSID',1361842419,1440,''),('88clon6qqojjm2a6s06jb6l7g6','','PHPSESSID',1361842417,1440,''),('8a3a85j06i83mbaom6l91ofah0','','PHPSESSID',1361897604,1440,''),('8a5o3ds4kiivrt2kteskrn6356','','PHPSESSID',1361812197,1440,''),('8bfj34355c9g9r4t88clc0e945','','PHPSESSID',1361888982,1440,''),('8bnd181itkvjucd9r59rtavk60','','PHPSESSID',1361761344,1440,''),('8d7q0elegvmdktvkf76mjbdam4','','PHPSESSID',1361811960,1440,''),('8gh5rcnflks8virek1cjoogom4','','PHPSESSID',1361803451,1440,''),('8h68b8s6rermo0s9ker4ppm5t1','','PHPSESSID',1361898873,1440,''),('8qg8p794g6lbreojb4sjnibip4','','PHPSESSID',1361898875,1440,''),('8s6op2g1m8fjsfe8vnf7rkq7k0','','PHPSESSID',1361841923,1440,''),('8vl8sima29b0p19s7hqdp3s756','','PHPSESSID',1361803409,1440,''),('92lfu97f9ceugu826urt3vsq03','','PHPSESSID',1361896682,1440,''),('93ip552buh1e8449lucgaplpn2','','PHPSESSID',1361803533,1440,''),('94dm5egth590g56jd1r069fek3','','PHPSESSID',1361897270,1440,''),('94gdtrvnirdd124nh4eggk7gp4','','PHPSESSID',1361803436,1440,''),('94sb3tldu67sfta2eq24p4tgp0','','PHPSESSID',1361803614,1440,''),('9cfoda94oknn880eqav60tfav0','','PHPSESSID',1361899017,1440,''),('9m11dk7n5403et8prjbt4995n4','','PHPSESSID',1361842265,1440,''),('9m495c0e1vo362acmaf0pb38s3','','PHPSESSID',1361842267,1440,''),('9m5pcrd59qmqrmuqk4t72ra7a6','','PHPSESSID',1361842529,1440,''),('9mvo5lcmvgpmefle5d0lqqbpi0','','PHPSESSID',1361899025,1440,''),('9nvjre4rd6fk6ephljk69998l1','','PHPSESSID',1361845486,1440,''),('9r1d4ohtn1a4f00a5qhrub0276','','PHPSESSID',1361760621,1440,''),('9tr3lv0lmnoj9fkj59q2cf8266','','PHPSESSID',1361802830,1440,''),('9v89n41b31c0sr9ob7asdd9k07','','PHPSESSID',1361897795,1440,''),('9vetbpk3mkvar0o7c2tla2ik36','','PHPSESSID',1361811640,1440,''),('a36hkbgfveifqvf9cn7eac0o63','','PHPSESSID',1361898949,1440,''),('a3dhsdah9o5d4c894esn2atk61','','PHPSESSID',1361760622,1440,''),('a7do6bvurfck2ol4q3pdsjk653','','PHPSESSID',1361803579,1440,''),('ac2a2jiq5fkbrh31c7d88q7c21','','PHPSESSID',1361803225,1440,''),('acl6ab4ncm6dsnjaje445g6054','','PHPSESSID',1361897908,1440,''),('adqpvs6o0hbs16elvk8mep1u67','','PHPSESSID',1361897785,1440,''),('ae0slf12gl87msuc0ttun94054','','PHPSESSID',1361845614,1440,''),('ae3f5vm5hhoemhv4e4qil3s1i3','','PHPSESSID',1361761207,1440,''),('ahctlvsjfriguj5f003soq3f41','','PHPSESSID',1361897277,1440,''),('aiqk4u86kc48vtrc3kb904lsu2','','PHPSESSID',1361811670,1440,''),('alqf6ui5nq7ih1kp0vkje6ps51','','PHPSESSID',1361802795,1440,''),('an02971s6es8t44hhu1vu3ldh5','','PHPSESSID',1361898955,1440,''),('apihr2idhje3npam2aud1foc63','','PHPSESSID',1361761246,1440,''),('apoj9humren59q3bsd6i8lfss7','','PHPSESSID',1361898437,1440,''),('auhm82p2vt7v2pci6ub9v5bkt2','','PHPSESSID',1361898992,1440,''),('avc8erjunkhbo64sol7h6mq1g2','','PHPSESSID',1361899019,1440,''),('b30a7ff4ratll8a3kh8d0tptd0','','PHPSESSID',1361803409,1440,''),('b4oj2ii7hbtj0eghv5thv0av51','','PHPSESSID',1361760342,1440,''),('b7qgc5t8ni44l538j6j451lo26','','PHPSESSID',1361889782,1440,''),('bfdi3lg46gil20cgrqpdu003c6','','PHPSESSID',1361761329,1440,''),('bfidoic97rvf94verfajr2kji7','','PHPSESSID',1361812772,1440,''),('bgjbjm7adjkaghbk223jdt6eb1','','PHPSESSID',1361844320,1440,''),('bi2qfemf53f8lfkrjp766va6b7','','PHPSESSID',1361888963,1440,''),('bql9qdhllrkoami6e81m0ti4u6','','PHPSESSID',1361760529,1440,''),('bqls9u21n4nn8ar5j6cvs9u2s1','','PHPSESSID',1361897059,1440,''),('brfmb3lgsfr2qhffd7okfuaer3','','PHPSESSID',1361898993,1440,''),('bvpulepccjqhu3rdh9ve5q5bc1','','PHPSESSID',1361802788,1440,''),('c15b64i5uc02918vccudbep6e1','','PHPSESSID',1361897744,1440,''),('c2sjln0csndk50potbqici2uq0','','PHPSESSID',1361842267,1440,''),('c5f01ccn1vumjeonige4mlaaf2','','PHPSESSID',1361896841,1440,''),('c9724gjbcema0pvbuo3gmq2q30','','PHPSESSID',1361845428,1440,''),('cbgtmg0v1etcemudlo23s2e0f5','','PHPSESSID',1361890552,1440,''),('cccad5p4tda5rv5fp3ih989u07','','PHPSESSID',1361844467,1440,''),('cdb09fq55pb9v7td6jgupq0r03','','PHPSESSID',1361842423,1440,''),('cdldp2g53pgg4ehc3k0r197ea5','','PHPSESSID',1361760595,1440,''),('cfa3nmcit7svo91jrmkv0loei7','','PHPSESSID',1361844612,1440,''),('cgj6l0bemerbo3fe2g2ngah911','','PHPSESSID',1361803618,1440,''),('chaejur3g06k67di6iqbcb77f4','','PHPSESSID',1361898889,1440,''),('chkdahas124llmc0q530u6gnu5','','PHPSESSID',1361898971,1440,''),('cign25l08p7mr9nq3emlauuua7','','PHPSESSID',1361897779,1440,''),('cn62es3dvvc7pe5jegjiriu0o0','','PHPSESSID',1361802798,1440,''),('cnqe6qe31ebap7to9bpiimuid0','','PHPSESSID',1361898953,1440,''),('cptlau80t3hgtcp54sujclt7q7','','PHPSESSID',1361898988,1440,''),('cqgf918ujmgpfm0cb4qdae8uv4','','PHPSESSID',1361898898,1440,''),('crqpv3gib40lv4963faq43a6e6','','PHPSESSID',1361811694,1440,''),('ctdfdoqrag86ojh2pqfqdvl6o3','','PHPSESSID',1361803481,1440,''),('cuaulbsp630esvu95kna00qor1','','PHPSESSID',1361896649,1440,''),('d0mg7nii6f517f9fjqvgoq2ce7','','PHPSESSID',1361811414,1440,''),('d2edkkr4li0scpg0s3872irus6','','PHPSESSID',1361763398,1440,''),('d8oudvjfps075kjatneuoqc3d4','','PHPSESSID',1361812185,1440,''),('defubtsqcbjdtdreca0kdf5bk2','','PHPSESSID',1361845484,1440,''),('diaopfdodvbdos05magdtjac90','','PHPSESSID',1361898804,1440,''),('dmk6dv2ri7r2v52ha7p5g76757','','PHPSESSID',1361844571,1440,''),('dphjqvo03b1aq2adas4nl7mnf7','','PHPSESSID',1361802792,1440,''),('dplqa36vpe3ndjvrj1eu0o0fo6','','PHPSESSID',1361812187,1440,''),('dqjsbhdrqd6kb4llhskdk5m441','','PHPSESSID',1361842422,1440,''),('duc0tqb08rh7d1kb7hrtij21k1','','PHPSESSID',1361898970,1440,''),('duf5q0eovpfe953eubdo0g63k7','','PHPSESSID',1361897413,1440,''),('e02m9mg95ff6qdku0tr0kcnfi3','','PHPSESSID',1361842540,1440,''),('e06aqneebmbksptrcmnidala35','','PHPSESSID',1361811644,1440,''),('e43hc88isi82beheu2jhriqg86','','PHPSESSID',1361888990,1440,''),('e4dplr81b4fpr7dke8iqb4p9r0','','PHPSESSID',1361844951,1440,''),('eetkah2ve17vik1ahni6acunm0','','PHPSESSID',1361897288,1440,''),('efe6a9s2qale3tiihnbu37crd6','','PHPSESSID',1361897282,1440,''),('efpdmgjufdfn9dhjll4juia1n2','','PHPSESSID',1361888950,1440,''),('egfar4qv7lvmeh5t10u9pk2sj2','','PHPSESSID',1361846090,1440,''),('egg0mopm1vudr2brkp69ruoiv4','','PHPSESSID',1361898974,1440,''),('einlu1a96cdja4fgjd355mb0b1','','PHPSESSID',1361898946,1440,''),('eit61qtnrb9c91jntr7loooeb2','','PHPSESSID',1361812506,1440,''),('ekshb5t2dbtvbgsigh6r5vgt76','','PHPSESSID',1361842019,1440,''),('ennujfrhml96j1s69vi301uu22','','PHPSESSID',1361897783,1440,''),('er30umsp005a40ogk7jmaf7mi3','','PHPSESSID',1361842531,1440,''),('es3m2vue9vktut2pas9540bpc5','','PHPSESSID',1361761462,1440,''),('esm0gj1f42cmv68rg7lra7avf5','','PHPSESSID',1361842400,1440,''),('f0uke9sik83io94jkaqkk79t94','','PHPSESSID',1361898900,1440,''),('f1sdcid081dl617r1eclmh3vu7','','PHPSESSID',1361896648,1440,''),('f1vk4mv4m3t3o7gqk2vhkmbh10','','PHPSESSID',1361761399,1440,''),('f384d06lsjmj0092jrg0amr2o6','','PHPSESSID',1361898885,1440,''),('f9dfe1qv38jpc65i0mm1fdhp33','','PHPSESSID',1361803613,1440,''),('fd6r1ogjbb1fkjvqni2brihl61','','PHPSESSID',1361896640,1440,''),('fed9oo8vh2m41ng3k9iet8ofu3','','PHPSESSID',1361844466,1440,''),('feh8u163drcvjbvde9ms2e6340','','PHPSESSID',1361897803,1440,''),('ffbmdmissvr8hsk8suns9vpeq4','','PHPSESSID',1361844780,1440,''),('ffijffdocc2ef0qmpoak09p6j3','','PHPSESSID',1361897066,1440,''),('ffk6ikap200v5qt4tvu91dn3r0','','PHPSESSID',1361898978,1440,''),('fiuaiu82ue2360g7j0u09lig53','','PHPSESSID',1361842412,1440,''),('fma452od601his4ruvbmm14nl7','','PHPSESSID',1361889772,1440,''),('fq411vpa6n68ji5tkenirc6tn7','','PHPSESSID',1361898870,1440,''),('fqqsnajvl9acef3f93m26k00r2','','PHPSESSID',1361844629,1440,''),('frib8tarp8tpeoliutai9kfli4','','PHPSESSID',1361898773,1440,''),('fsor87hd3r1r8b3skjad7v59n6','','PHPSESSID',1361802780,1440,''),('g6lsanrtqd9qd4jb6h789no7e2','','PHPSESSID',1361803147,1440,''),('g8f0t157v4aim2nmm859e9l2n6','','PHPSESSID',1361811640,1440,''),('gbtauogeuga577vbj5sekbr850','','PHPSESSID',1361897287,1440,''),('gh5o0mhekileul0uebp39v5g04','','PHPSESSID',1361897782,1440,''),('ghu1umnq1vt84morfn0m215b56','','PHPSESSID',1361890019,1440,''),('gjj16qmjv8vuvdbuc6q6l1l822','','PHPSESSID',1361889765,1440,''),('gjvgnu5b055ervekavdrn6i5a3','','PHPSESSID',1361812428,1440,''),('gkm89likqa19j918mbkpv9h5e5','','PHPSESSID',1361762812,1440,''),('gl8e4gnob81g3i9vvrgqvuj711','','PHPSESSID',1361842266,1440,''),('gm7p7bj9sbp202k53vpjakvs81','','PHPSESSID',1361844475,1440,''),('gmks04b3cesvfls5s9depn8qm1','','PHPSESSID',1361842420,1440,''),('gq7v0fruapfhqpfji7jj8nk9f7','','PHPSESSID',1361760617,1440,''),('gsrvl4tfgqmq777cpjhr3qv373','','PHPSESSID',1361812430,1440,''),('gu2kcs24825p407f10n7m61d67','','PHPSESSID',1361888650,1440,''),('h0s70n620v7rv2oljo4j01vdf5','','PHPSESSID',1361889769,1440,''),('h0u919uuealnjmr7fmm4jrc865','','PHPSESSID',1361897062,1440,''),('h17snmo3mae88f0cibuf4kksb0','','PHPSESSID',1361844570,1440,''),('h24p3brsgfukg7tbcpfn8gf832','','PHPSESSID',1361889763,1440,''),('h2p0q2k2k4oodl642gatmqgg35','','PHPSESSID',1361812201,1440,''),('h3633o8c2e4klbt7u9hun5ofr5','','PHPSESSID',1361812419,1440,''),('h4bhv1g19jr74sdokkb68qcds6','','PHPSESSID',1361803547,1440,''),('h4r8a3j9skh3aglrql54ssnru3','','PHPSESSID',1361811415,1440,''),('h5ja3buec3gj44t6228q9rfg77','','PHPSESSID',1361888964,1440,''),('h5q23o0jnih4m0lmcjk43vu005','','PHPSESSID',1361803226,1440,''),('h6n66nj5h8a0l5m82ocmdsn1d3','','PHPSESSID',1361760396,1440,''),('hckiqnqvtgcqmjft265b4jsic1','','PHPSESSID',1361803418,1440,''),('hd4m3v6pbkuhvciinmc2m25lo7','','PHPSESSID',1361811668,1440,''),('he4o12i0k5ljrbb49lmd9dd7j1','','PHPSESSID',1361802804,1440,''),('hi0dd1vhl368vqt7r91uce5eq4','','PHPSESSID',1361802786,1440,''),('hitpqmn3mqfi88u01qvpneult2','','PHPSESSID',1361889770,1440,''),('ho52i355r3ji2dkv7tvbshpua3','','PHPSESSID',1361898876,1440,''),('hrdv0699rsn8obmi6vfv2pf3j5','','PHPSESSID',1361897267,1440,''),('hteedefr514cbo3ra5c17jd3c7','','PHPSESSID',1361898972,1440,''),('htmaraunf1afj5vovhc34f0q00','','PHPSESSID',1361802958,1440,''),('huhlr1vmj0kfdekv28e3voiq97','','PHPSESSID',1361802939,1440,''),('i39d8cedi0p0qltf6dn5809ah0','','PHPSESSID',1361811672,1440,''),('i3hpu92v0lb2su47cn0k6brbo3','','PHPSESSID',1361891192,1440,''),('i5su7h7kie5tj0p65h43h0mhq1','','PHPSESSID',1361803534,1440,''),('i6ru2c667e4hkodfrjj26a2lj0','','PHPSESSID',1361760458,1440,''),('i84h5hvnrr1oh4cr26j9r277o0','','PHPSESSID',1361761477,1440,''),('i90t15bj10cru5mvtqmmgh7fn6','','PHPSESSID',1361890016,1440,''),('i9aojo2chma449d6v503rfn4t0','','PHPSESSID',1361844473,1440,''),('ib3k2q4qvqujhcq0nqpt4ahon6','','PHPSESSID',1361898966,1440,''),('ic4makglb61semqa7k7npq4o21','','PHPSESSID',1361802950,1440,''),('icod0q58lblqppb3tons96n2c7','','PHPSESSID',1361845480,1440,''),('imhb832rto3ga86p24ptgkgf96','','PHPSESSID',1361898991,1440,''),('ine2nchof2l1lbveg5599uk493','','PHPSESSID',1361844456,1440,''),('inkg67a450rp1qu7anl52oi5e5','','PHPSESSID',1361898967,1440,''),('ispid0l91dokka5j8na3i7iso0','','PHPSESSID',1361890548,1440,''),('ivr8c3fjete5jeu8o82d2g3k72','','PHPSESSID',1361898901,1440,''),('ivtt4p9nlaq4ih17dfm9m3afe0','','PHPSESSID',1361841594,1440,''),('j6t4g2t8cg2srhlg0o5097tuj3','','PHPSESSID',1361803436,1440,''),('j9mle2kqcjvtitg5bkbf5na3d3','','PHPSESSID',1361761476,1440,''),('ja7gbgl2nrqme1dnhpn98g26j5','','PHPSESSID',1361760563,1440,''),('jdnv7nl578b4aunca8m5uel045','','PHPSESSID',1361896604,1440,''),('jej7fiiavnunnd3i9d9p6uosv2','','PHPSESSID',1361897253,1440,''),('jgditp2kj6jbss740371ds8l22','','PHPSESSID',1361898979,1440,''),('jjaitkhor4347v01teh9d31bm6','','PHPSESSID',1361803370,1440,''),('jjmlbjnj656mlk75keiqnrius7','','PHPSESSID',1361761394,1440,''),('jjrkl9i7ufarqm26odvrda9ba2','','PHPSESSID',1361895486,1440,''),('jjvr4e9rub1062ds7tqf9u83l4','','PHPSESSID',1361897256,1440,''),('jk3vstv9je65tsuk8autttojo1','','PHPSESSID',1361812182,1440,''),('jkcf8ne1jobf3rt32bg4lcjk67','','PHPSESSID',1361811815,1440,''),('jkljanoknn304rsjclob0ebi02','','PHPSESSID',1361761366,1440,''),('jkr4k3vlg5hrpu2gr4e9cin435','','PHPSESSID',1361844609,1440,''),('jo028ua30t1t3dmoooa0ciua72','','PHPSESSID',1361898883,1440,''),('jq410d28t5s3v2bm2tjkqc78e0','','PHPSESSID',1361844608,1440,''),('jqevvb0tc7r38bsj6pv10r3fd0','','PHPSESSID',1361845065,1440,''),('jqo912dnvpaltpgpsb92q3akt3','','PHPSESSID',1361812811,1440,''),('jrcv4pc8mhkb6tuu9la272ark6','','PHPSESSID',1361899022,1440,''),('jsoclifntle1eb4irphq6iibm4','','PHPSESSID',1361888960,1440,''),('jti8fheafm6h1d7v6hhvpaiki5','','PHPSESSID',1361811483,1440,''),('k0ip776jsbs9i6v6e5k7apg500','','PHPSESSID',1361844468,1440,''),('k1lf20ijognqsp155l0qsnej22','','PHPSESSID',1361897798,1440,''),('k3vm8268ah3i639rapqsjq67j6','','PHPSESSID',1361802932,1440,''),('k5eefg3k3jmsrce37gvnvo7g02','','PHPSESSID',1361898992,1440,''),('k5ndu87ur5tpej4rnna1brbu00','','PHPSESSID',1361844952,1440,''),('kcijq82jakvrghp68e667rl9i3','','PHPSESSID',1361763089,1440,''),('ke499ermrugqd7dga094t9d7f4','','PHPSESSID',1361844761,1440,''),('kjmooavcc7ivadktbtubuu8nn0','','PHPSESSID',1361803373,1440,''),('kl2j4hp7nujmpp7k0u71jls9t3','','PHPSESSID',1361845481,1440,''),('km9ru7mlqaoirb7c03pmcto4n3','','PHPSESSID',1361890006,1440,''),('ko3cfb83q44omlqfkrt4cm6hv0','','PHPSESSID',1361844777,1440,''),('kp464hdhke8h4ng5un64b7jfa7','','PHPSESSID',1361811416,1440,''),('ksjpg1jpel00860avo01nhvou6','','PHPSESSID',1361897701,1440,''),('kubtg70t5h9onjk68ee15kc9k5','','PHPSESSID',1361897414,1440,''),('kvbunspbe2bkrnorapvoa6lst2','','PHPSESSID',1361812811,1440,''),('kvc0bmoflisj0m65igls8qtc10','','PHPSESSID',1361842533,1440,''),('l1ldjk3r6io17qekqgpbdl0eq4','','PHPSESSID',1361844587,1440,''),('l3j9crt7dsesknh6u8ubs32n10','','PHPSESSID',1361897285,1440,''),('l43ilb8hp7po8s3in418tbbc93','','PHPSESSID',1361842906,1440,''),('l6uuuh71gaelm029bi6p3c0kg5','','PHPSESSID',1361897260,1440,''),('l9aebr2n88704065v81bqkbfe6','','PHPSESSID',1361898995,1440,''),('ld8shcnmla16nit491mtpk54f6','','PHPSESSID',1361898973,1440,''),('lf1shr4085l88hkfc75ro2emj0','','PHPSESSID',1361898881,1440,''),('lgj3qcjfsckv4hte3jq4uohf45','','PHPSESSID',1361890010,1440,''),('lgjroo19095cj5un8g8ttbrbg2','','PHPSESSID',1361803452,1440,''),('lkgjecn5lbn5ff8kg0jp74glt0','','PHPSESSID',1361888950,1440,''),('lleu0qm7ca5peht7l1ucffijj2','','PHPSESSID',1361888988,1440,''),('lq30098j4k4745dh7j34ji1692','','PHPSESSID',1361761461,1440,''),('lr9cjoeulsppbj1t9heng82vo5','','PHPSESSID',1361895487,1440,''),('lri18rtu6f549b6dnnu2ms0ig3','','PHPSESSID',1361845485,1440,''),('lrmj1g8pgr9fm2fkgbrk95t0o5','','PHPSESSID',1361888675,1440,''),('lsccpfip665vtpcqjdggr9rsl1','','PHPSESSID',1361761412,1440,''),('lu1m4ee7vdnmtbl5b7hglfmrq2','','PHPSESSID',1361841595,1440,''),('m081q3b03esbemrmjoe3l2tis4','','PHPSESSID',1361897802,1440,''),('m1gjcbmht71suddg5ojt0l18o3','','PHPSESSID',1361890553,1440,''),('m1upii5tkutmr9mhmd83ekg1b0','','PHPSESSID',1361890008,1440,''),('m2chnpqov39ukt863si33k6g45','','PHPSESSID',1361898887,1440,''),('m3q6vhufieicaupn4ae6nm1u60','','PHPSESSID',1361899020,1440,''),('m58s2p42tei5qiffev8u8a0ht0','','PHPSESSID',1361802836,1440,''),('mdd27gkaqdask8i9kiu5jg5p47','','PHPSESSID',1361888951,1440,''),('mg5gjbkkovgttr2jd6q37ghgd1','','PHPSESSID',1361761305,1440,''),('mgo6tpa7sqib3rvch4d66uc9f1','','PHPSESSID',1361803435,1440,''),('mhmtta2p24ejms4m33tope77s1','','PHPSESSID',1361842200,1440,''),('mj4qhif6g87sf85fh6l4bot3o3','','PHPSESSID',1361760555,1440,''),('mpo9unprn70l1kpu8dnbllarr2','','PHPSESSID',1361898772,1440,''),('mskrj7o6k3u2d7df5325nra9t7','','PHPSESSID',1361845585,1440,''),('mt02bf5bvdjd4fdbl6ikg2fbp6','','PHPSESSID',1361897258,1440,''),('n0ir4ja6jtnlpelq34nce3f0o0','','PHPSESSID',1361811477,1440,''),('n26dde1vhqbfkiop77adu5kcj7','','PHPSESSID',1361898883,1440,''),('n2m39qtntannt6oo6mfs1sonm1','','PHPSESSID',1361842538,1440,''),('n4b7hteiqmiqv79vbndp0fos41','','PHPSESSID',1361763058,1440,''),('n4rbhuh8ndbikm24vkl72c9r56','','PHPSESSID',1361845017,1440,''),('n8osgmkit38v99sn75p8eo4j56','','PHPSESSID',1361803408,1440,''),('na7kdvtopuphspbj3gk2iri4f2','','PHPSESSID',1361811420,1440,''),('nb8gvice7h5b0iqd2o4bm11jp4','','PHPSESSID',1361845617,1440,''),('ncmtf0hde5gbfui1f2a5opd973','','PHPSESSID',1361898773,1440,''),('ndd3f28rf0g7i1kpv5i6aksid2','','PHPSESSID',1361845482,1440,''),('ne2cm07ni1oacog63ar58hqnn0','','PHPSESSID',1361898886,1440,''),('ne5f7lji7f61ss25hkj90ipus7','','PHPSESSID',1361842904,1440,''),('neiec48p6p786a2g516cogceh3','','PHPSESSID',1361899015,1440,''),('njsbng8qs5akk5g4o393htouj7','','PHPSESSID',1361889768,1440,''),('nk29pn17sj1m9cd2u86u6ne0s4','','PHPSESSID',1361812202,1440,''),('nl4mh23241dta02tlbvoem2sk4','','PHPSESSID',1361844315,1440,''),('nls7nudaa9fid28t2aihd7u5b3','','PHPSESSID',1361898903,1440,''),('npt1tqqrhhocen96tia3mevvg6','','PHPSESSID',1361888951,1440,''),('nsdu2i1ori8u757kruqai0ain5','','PHPSESSID',1361812183,1440,''),('o26sf54gs5boer5n5un6vomch7','','PHPSESSID',1361844820,1440,''),('o3sgnvioj2im77tn2qmhf8gbp7','','PHPSESSID',1361844317,1440,''),('o76pcafo36mbjlab86io7ouug2','','PHPSESSID',1361890551,1440,''),('o9j02j97bmtg2i0fkt9donbd43','','PHPSESSID',1361802794,1440,''),('ocb9su01b2t9t8ok6fafl24hi7','','PHPSESSID',1361844587,1440,''),('ogcqbu38v6f2hpj8eu7albrd03','','PHPSESSID',1361842268,1440,''),('oi3od7pn562u82ljqm53c6c7r7','','PHPSESSID',1361897794,1440,''),('ois0sqcj9sqddslm39p1afr9f2','','PHPSESSID',1361803371,1440,''),('on12nekv35g63ncv1hioje7rk2','','PHPSESSID',1361898882,1440,''),('on1r0mo7ndchut0a7tecrtvk90','','PHPSESSID',1361760427,1440,''),('onsdklkij6oto5j1m3ivuo0925','','PHPSESSID',1361761322,1440,''),('opopteuj5dkk7c5ck7slkco6s5','','PHPSESSID',1361760615,1440,''),('orcdps5fnq5m0njc0kahe4fut1','','PHPSESSID',1361811816,1440,''),('p0dcv56lvllr3homo1e9d0jsq4','','PHPSESSID',1361803617,1440,''),('p0uhua2u7n660aut3miqvhpf81','','PHPSESSID',1361842421,1440,''),('p1b5litbok0q9q01n7e8ttsl03','','PHPSESSID',1361897796,1440,''),('p263969bp5652p23gshdqjvo75','','PHPSESSID',1361898881,1440,''),('p3ubsijcqlc6pkaoovru8c64s3','','PHPSESSID',1361895810,1440,''),('p4jc6dmvv8n1nrl9b29k648504','','PHPSESSID',1361845574,1440,''),('p8g6n9ku5og772ala8so1rfn44','','PHPSESSID',1361803620,1440,''),('p8ije2h00hp8kuuon4om028ug6','','PHPSESSID',1361803580,1440,''),('pa78tsbo8hcc1410osbt0ojtv3','','PHPSESSID',1361842018,1440,''),('padmjtm0spsb5lmvuikohjser7','','PHPSESSID',1361898993,1440,''),('pae3hhhbg5j2s5mbvua6u3tms3','','PHPSESSID',1361898967,1440,''),('pasaepi1ogslpfdjo7gksgif16','','PHPSESSID',1361890549,1440,''),('pekiuh69t02cbi4cm4fikn70k3','','PHPSESSID',1361802949,1440,''),('pkd8fu16iqavvdudvs36572k44','','PHPSESSID',1361842416,1440,''),('pkkm8iaqrkg1g7k14ks4i7f035','','PHPSESSID',1361844762,1440,''),('pm4614ttei190gd5tge7k2a302','','PHPSESSID',1361803528,1440,''),('pofsfbh3202gvr6uk6l68f6pu1','','PHPSESSID',1361897691,1440,''),('ppatekceu4lb9058b30tgojht1','','PHPSESSID',1361897581,1440,''),('pucsuug89udke2eht1tfj6iso2','','PHPSESSID',1361829792,1440,''),('q0fmvh5d3acvh8ke6ipjuucpl2','','PHPSESSID',1361890011,1440,''),('q42eqrf2cskrjqeshqmtfgl3s4','','PHPSESSID',1361845080,1440,''),('q4odnig6i94tq7aaa83smm7ir2','','PHPSESSID',1361763383,1440,''),('q4qo5de23htncou3qp85oh93e1','','PHPSESSID',1361898902,1440,''),('q6i4lmqhk3aauk04td7kjc5q76','','PHPSESSID',1361842907,1440,''),('q9ji80hhme3t3mlkd43f45hf04','','PHPSESSID',1361898887,1440,''),('q9p8kjk9qmg64kmqoq1fi7mud3','','PHPSESSID',1361897800,1440,''),('qa0rp7qpu1clkok1v5j9j80as3','','PHPSESSID',1361803482,1440,''),('qc3p1i4fqspuqtannci3no5on6','','PHPSESSID',1361803318,1440,''),('qds38m8ujq24saak8hc7goksa5','','PHPSESSID',1361802953,1440,''),('qen647jr62f1m00tv07spe9rq6','','PHPSESSID',1361888947,1440,''),('qh1iea9qk0vfvslj3fsds3g5h4','','PHPSESSID',1361896840,1440,''),('qm87keg2b6p5barq4hvia76k30','','PHPSESSID',1361811434,1440,''),('qn20prq6gn85qev53sbm4blgc5','','PHPSESSID',1361899012,1440,''),('qq64s4sb3o07lcrrdrav2lvo60','','PHPSESSID',1361803224,1440,''),('qqfabhtlicao4il8412vc86537','','PHPSESSID',1361897791,1440,''),('qqkktcqaio537lirqpe2t2c1n0','','PHPSESSID',1361844314,1440,''),('qrr9epf5s83bu8tgbbi3eb0bm6','','PHPSESSID',1361845575,1440,''),('quffh4rljomqpu65jtfr76oct0','','PHPSESSID',1361888950,1440,''),('qvn9i9mjg54p4fgp6srb8vgup4','','PHPSESSID',1361897280,1440,''),('qvp2kskt5fkfio4llmbbi66c04','','PHPSESSID',1361898976,1440,''),('r4b0vvm05rhauqn08550dfc1k1','','PHPSESSID',1361760556,1440,''),('r4n2lr8sc3r4tjqr9a22as49b2','','PHPSESSID',1361842897,1440,''),('r5jadsb37drocs8g8emmuonnj1','','PHPSESSID',1361896643,1440,''),('r7l03nc4aq1rr88t6i30uq6cg6','','PHPSESSID',1361899030,1440,''),('r7lcv4bofgn0nnolrim25ahnm1','','PHPSESSID',1361897734,1440,''),('r98lcjr84dabqqjq672lu7ebp5','','PHPSESSID',1361897060,1440,''),('ra14v39rdq4nl710ulg9qsd141','','PHPSESSID',1361889783,1440,''),('ra3qobjg7usesj26mn4g4g1q54','','PHPSESSID',1361802957,1440,''),('raqqp2dj0vbedj9lu148anf9v2','','PHPSESSID',1361888961,1440,''),('rc4st3m0qmmnkpdtvaqjgppmt2','','PHPSESSID',1361898943,1440,''),('rd75tbhqp865arst5seaj6a634','','PHPSESSID',1361761222,1440,''),('rhvndiisle8f5ja43c5bkg8nr0','','PHPSESSID',1361760460,1440,''),('rjc47ik3b0sl7hadci5ahghu16','','PHPSESSID',1361898989,1440,''),('rmocrg1ap1n06e0cm8pd4guks0','','PHPSESSID',1361897258,1440,''),('rrhndjkithh0pei5e42u8v1kd3','','PHPSESSID',1361889793,1440,''),('rsjiie0okujuark45chlchj5k2','','PHPSESSID',1361842418,1440,''),('rtmdgqk5qfe0b4jgqbc8cn2821','','PHPSESSID',1361896679,1440,''),('ruqm599j10mhke8v4mstangur5','','PHPSESSID',1361803419,1440,''),('rv41lnd5qp3386ukkd78td8435','','PHPSESSID',1361845478,1440,''),('s0ip3njqhvlbs2qorvhq9rf3c7','','PHPSESSID',1361890015,1440,''),('s2jtj1msousaij9v5sbjvugj96','','PHPSESSID',1361761321,1440,''),('s3ih1ag2vg2udukn8tn5a3ij77','','PHPSESSID',1361812506,1440,''),('s4fnimp568lq1of7ts1id0p065','','PHPSESSID',1361802790,1440,''),('s4vmtf0kr5up26kuo10qq6cof0','','PHPSESSID',1361897698,1440,''),('s6qci84sh9qqi073h8eq0ph9b1','','PHPSESSID',1361845578,1440,''),('sae35eo2nlookns8mo587me346','','PHPSESSID',1361762813,1440,''),('scbp06695fbjri8fofilb2nog4','','PHPSESSID',1361844954,1440,''),('scq0l1ih74af8tiq1jqvcq8292','','PHPSESSID',1361896641,1440,''),('sd124b0654igferitnkgtnqt42','','PHPSESSID',1361898773,1440,''),('se3fs5bv3rs6j3dalftg3aju00','','PHPSESSID',1361811673,1440,''),('sjh0ai5fh23qdbsrn7iea3ri46','','PHPSESSID',1361845479,1440,''),('skh2080mue07vjih0598c85ct2','','PHPSESSID',1361802814,1440,''),('slbeq5bm8rrb2c441jd8d34cg3','','PHPSESSID',1361898990,1440,''),('sm2lb28mp82tor82osfp2tgq45','','PHPSESSID',1361802936,1440,''),('smt207ggb2sb5sh8mhh1o5rlh0','','PHPSESSID',1361802935,1440,''),('snkdrl2t2j5erva5hj4e352l50','','PHPSESSID',1361812432,1440,''),('sqacs91e3udb7nc647lsa1qbg2','','PHPSESSID',1361803532,1440,''),('srbu68lkpt183kfsl4nd5hndm3','','PHPSESSID',1361803320,1440,''),('srm43dq3scl2vkbaun69h1mit1','','PHPSESSID',1361812428,1440,''),('ssd7tgc66ukmg4pdc1e3amvmd6','','PHPSESSID',1361802796,1440,''),('sv2tad2i9c7o7qhg6sqqlrbr61','','PHPSESSID',1361888965,1440,''),('t1gc49nc9r0p2qt1cu38fd7sp4','','PHPSESSID',1361898438,1440,''),('t1ihqg7an5bik6119st4bb1p21','','PHPSESSID',1361802824,1440,''),('t24sfk64j6gbi55m3gn7abqpp5','','PHPSESSID',1361760593,1440,''),('t4qm6hrt2oev628hpnlrorg151','','PHPSESSID',1361898951,1440,''),('tg08946n6jll7evsdprns6g4j1','','PHPSESSID',1361803326,1440,''),('tg24nb0sremp9ua4nllqptqgb4','','PHPSESSID',1361844457,1440,''),('tkjbjv6lo4ciu5cvpqsjmqr1f6','','PHPSESSID',1361899030,1440,'dlayer_session|a:3:{s:9:\"module_id\";s:1:\"1\";s:7:\"site_id\";i:1;s:11:\"template_id\";i:1;}dlayer_session_template|a:7:{s:7:\"tool_id\";N;s:15:\"selected_div_id\";N;s:11:\"template_id\";i:1;s:9:\"tool_name\";N;s:10:\"tool_model\";N;s:13:\"ribbon_tab_id\";N;s:15:\"ribbon_tab_name\";N;}dlayer_session_content|a:4:{s:11:\"template_id\";i:1;s:7:\"page_id\";i:1;s:15:\"selected_div_id\";N;s:19:\"selected_content_id\";N;}'),('tllbqklnvab73vpkfihvnlbaf1','','PHPSESSID',1361803536,1440,''),('to788gdftjo5vf0sa71sbennr0','','PHPSESSID',1361844471,1440,''),('tqfuqhu49sq555p5ot7iql7gm1','','PHPSESSID',1361844465,1440,''),('tr203g699t4gq96v37uplnpnv2','','PHPSESSID',1361803548,1440,''),('tsgeadtm4u3o0dsi5trdr1cba6','','PHPSESSID',1361761328,1440,''),('tt3nuaa7t60eg34n4ahgl728t6','','PHPSESSID',1361802840,1440,''),('u010qikdn9a8g5r4lvh1l8t8k3','','PHPSESSID',1361812434,1440,''),('u0jpnt7g7uq2n828t5np429ev6','','PHPSESSID',1361844776,1440,''),('u2i6nb8f088t1on3kcqu2iae82','','PHPSESSID',1361898985,1440,''),('u2nmpek5rrj16d0oit5b5a3502','','PHPSESSID',1361889767,1440,''),('u31jjlgp78q8sab923vj4l4706','','PHPSESSID',1361761239,1440,''),('u6e5np987ltv5iepratgejtpr4','','PHPSESSID',1361845582,1440,''),('ua9822dk7u4kkdal2konvbdar2','','PHPSESSID',1361760610,1440,''),('ual22n45egaviobvn5btp55s33','','PHPSESSID',1361890013,1440,''),('ud25dbe2ve6ulvvbg5bvil8fa5','','PHPSESSID',1361760642,1440,''),('udic7kipbg79ic4jtpn52ulfr0','','PHPSESSID',1361888948,1440,''),('uhfoaohvbivvtoj7cu557iaaa2','','PHPSESSID',1361760547,1440,''),('ujm1rhqntivav097e642d58od0','','PHPSESSID',1361897416,1440,''),('ukm55a8vb0hu9jhtulus1kjk37','','PHPSESSID',1361812189,1440,''),('uu7geqrr4n4igj895s3pvp87k2','','PHPSESSID',1361761399,1440,''),('uuqmm2jl8bpa2giqh284mtp2l6','','PHPSESSID',1361842899,1440,''),('uvi2kp7uhfkh7ra7dh20atv9j7','','PHPSESSID',1361803328,1440,''),('v0a0bo1p1hi99kkvpn6rl5e0m3','','PHPSESSID',1361899001,1440,''),('v0g4t8i486sidleji6r8sc2qb2','','PHPSESSID',1361802816,1440,''),('v0popnakpc7fv5curso7pj1p32','','PHPSESSID',1361898877,1440,''),('v48vr36jv0jsrgmfn7bb7uqao6','','PHPSESSID',1361802791,1440,''),('v56oooe76tdkfalt8l54kd28q5','','PHPSESSID',1361842543,1440,''),('v6pblttib8s4oknttuk34qaih7','','PHPSESSID',1361845490,1440,''),('vdj5tddsr8n87fpkunjgmpbc93','','PHPSESSID',1361803249,1440,''),('ve45uvmd52a32k8cip2evmk570','','PHPSESSID',1361842528,1440,''),('ve85042jqh84d5ufdnh46ue3u2','','PHPSESSID',1361811646,1440,''),('veaqabpjb4lets2p0aufnk4390','','PHPSESSID',1361899000,1440,''),('vei38i4u9rh48pklapf353f9v0','','PHPSESSID',1361760609,1440,''),('vg3vd0bucdd3u2ubh2dat3u1o7','','PHPSESSID',1361803615,1440,''),('vikqva91d2adt1ev45vf4akhk1','','PHPSESSID',1361760429,1440,''),('vjgb5b9g5il64c1rc972eqmn61','','PHPSESSID',1361897690,1440,''),('vkic1ub55j8epjk9ivfecm0sl0','','PHPSESSID',1361844313,1440,''),('vlk0c4cuvfbo9i2mifrh8ni6l4','','PHPSESSID',1361888981,1440,''),('vmulneg6v9hk4q21ca1k030vi0','','PHPSESSID',1361898899,1440,''),('vummfoubu1n1rg5mcuu77i9mo3','','PHPSESSID',1361829794,1440,''),('vvccje6c15g65bsc71vh1l2bu1','','PHPSESSID',1361845583,1440,'');

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
  CONSTRAINT `user_site_pages_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `user_site_templates` (`id`),
  CONSTRAINT `user_site_pages_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_sites` (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_background_colors` */

insert  into `user_site_template_div_background_colors`(`id`,`template_id`,`div_id`,`hex`) values (17,1,160,'#000000'),(18,1,161,'#666666'),(19,1,159,'#f3f1df');

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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_site_template_div_borders` */

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

insert  into `user_site_template_div_sizes`(`id`,`template_id`,`div_id`,`width`,`height`,`design_height`) values (158,1,158,980,0,120),(159,1,159,980,0,380),(160,1,160,120,0,120),(161,1,161,860,0,120);

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
