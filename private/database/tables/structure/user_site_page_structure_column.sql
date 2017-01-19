
CREATE TABLE `user_site_page_structure_column` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`page_id` int(11) unsigned NOT NULL,
	`row_id` int(11) unsigned DEFAULT NULL,
	`size` tinyint(2) unsigned NOT NULL DEFAULT '12',
	`column_type_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '3',
	`offset` tinyint(2) unsigned NOT NULL DEFAULT '0',
	`sort_order` int(11) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `row_id` (`row_id`),
	KEY `sort_order` (`sort_order`),
	KEY `page_id` (`page_id`),
	KEY `column_type_id` (`column_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
