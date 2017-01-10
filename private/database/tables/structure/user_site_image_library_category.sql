
CREATE TABLE `user_site_image_library_category` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	CONSTRAINT `user_site_image_library_category_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
