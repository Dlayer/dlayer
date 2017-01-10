
CREATE TABLE `user_site_page_content_item_heading` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`page_id` int(11) unsigned NOT NULL,
	`content_id` int(11) unsigned NOT NULL,
	`heading_id` tinyint(3) unsigned NOT NULL,
	`data_id` int(11) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `page_id` (`page_id`),
	KEY `content_id` (`content_id`),
	KEY `heading_id` (`heading_id`),
	KEY `data_id` (`data_id`),
	CONSTRAINT `user_site_page_content_item_heading_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	CONSTRAINT `user_site_page_content_item_heading_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
	CONSTRAINT `user_site_page_content_item_heading_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
	CONSTRAINT `user_site_page_content_item_heading_ibfk_4` FOREIGN KEY (`heading_id`) REFERENCES `designer_content_heading` (`id`),
	CONSTRAINT `user_site_page_content_item_heading_ibfk_5` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_heading` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
