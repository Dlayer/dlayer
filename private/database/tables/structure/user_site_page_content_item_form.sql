
CREATE TABLE `user_site_page_content_item_form` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`page_id` int(11) unsigned NOT NULL,
	`content_id` int(11) unsigned NOT NULL,
	`form_id` int(11) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `page_id` (`page_id`),
	KEY `content_id` (`content_id`),
	KEY `form_id` (`form_id`),
	CONSTRAINT `user_site_page_content_item_form_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	CONSTRAINT `user_site_page_content_item_form_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
	CONSTRAINT `user_site_page_content_item_form_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
	CONSTRAINT `user_site_page_content_item_form_ibfk_4` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
