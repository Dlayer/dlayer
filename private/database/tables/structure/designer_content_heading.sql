
CREATE TABLE `designer_content_heading` (
	`id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`tag` char(2) COLLATE utf8_unicode_ci NOT NULL,
	`sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
