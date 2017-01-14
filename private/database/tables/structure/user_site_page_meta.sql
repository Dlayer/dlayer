
CREATE TABLE `user_site_page_meta` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`page_id` int(11) unsigned NOT NULL,
	`title` text COLLATE utf8_unicode_ci NOT NULL,
	`description` text COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`,`page_id`),
	KEY `page_id` (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
