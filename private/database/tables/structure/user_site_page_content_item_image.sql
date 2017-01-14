
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
	KEY `version_id` (`version_id`),
	KEY `content_id` (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
