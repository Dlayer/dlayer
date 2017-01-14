
CREATE TABLE `user_site_page_structure_row` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`page_id` int(11) unsigned NOT NULL,
	`column_id` int(11) DEFAULT NULL,
	`sort_order` int(11) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `page_id` (`page_id`),
	KEY `column_id` (`column_id`),
	KEY `site_id` (`site_id`),
	KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
