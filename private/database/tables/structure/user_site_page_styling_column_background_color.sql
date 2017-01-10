
CREATE TABLE `user_site_page_styling_column_background_color` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`page_id` int(11) unsigned NOT NULL,
	`column_id` int(11) unsigned NOT NULL,
	`background_color` char(7) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `page_id` (`page_id`),
	KEY `column_id` (`column_id`),
	CONSTRAINT `user_site_page_styling_column_background_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	CONSTRAINT `user_site_page_styling_column_background_color_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
	CONSTRAINT `user_site_page_styling_column_background_color_ibfk_3` FOREIGN KEY (`column_id`) REFERENCES `user_site_page_structure_column` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
