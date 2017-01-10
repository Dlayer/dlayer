
CREATE TABLE `user_site_image_library_link` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`library_id` int(11) unsigned NOT NULL,
	`version_id` int(11) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `library_id` (`library_id`),
	KEY `version_id` (`version_id`),
	CONSTRAINT `user_site_image_library_link_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	CONSTRAINT `user_site_image_library_link_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `user_site_image_library` (`id`),
	CONSTRAINT `user_site_image_library_link_ibfk_3` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_version` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
