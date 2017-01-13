
CREATE TABLE `user_site_page_structure_content` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`page_id` int(11) unsigned NOT NULL,
	`column_id` int(11) unsigned NOT NULL,
	`content_type` int(11) unsigned NOT NULL,
	`sort_order` int(11) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `sort_order` (`sort_order`),
	KEY `site_id` (`site_id`),
	KEY `page_id` (`page_id`),
	KEY `content_type` (`content_type`),
	KEY `column_id` (`column_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
