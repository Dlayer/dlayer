
CREATE TABLE `user_site_page_structure_column` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`page_id` int(11) unsigned NOT NULL,
	`row_id` int(11) unsigned DEFAULT NULL,
	`size` tinyint(2) unsigned NOT NULL DEFAULT '12',
	`column_type` enum('xs','sm','md','lg') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'md',
	`offset` tinyint(2) unsigned NOT NULL DEFAULT '0',
	`sort_order` int(11) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `row_id` (`row_id`),
	KEY `sort_order` (`sort_order`),
	KEY `page_id` (`page_id`),
	CONSTRAINT `user_site_page_structure_column_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	CONSTRAINT `user_site_page_structure_column_ibfk_2` FOREIGN KEY (`row_id`) REFERENCES `user_site_page_structure_row` (`id`),
	CONSTRAINT `user_site_page_structure_column_ibfk_3` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
