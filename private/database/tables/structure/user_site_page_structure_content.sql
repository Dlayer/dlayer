
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
	KEY `column_id` (`column_id`),
	CONSTRAINT `user_site_page_structure_content_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	CONSTRAINT `user_site_page_structure_content_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
	CONSTRAINT `user_site_page_structure_content_ibfk_4` FOREIGN KEY (`content_type`) REFERENCES `designer_content_type` (`id`),
	CONSTRAINT `user_site_page_structure_content_ibfk_5` FOREIGN KEY (`column_id`) REFERENCES `user_site_page_structure_column` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
