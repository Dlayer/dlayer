
CREATE TABLE `user_setting_color_palette_color` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`palette_id` int(11) unsigned NOT NULL,
	`color_type_id` tinyint(3) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `palette_id` (`palette_id`),
	KEY `color_type_id` (`color_type_id`),
	CONSTRAINT `user_setting_color_palette_color_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	CONSTRAINT `user_setting_color_palette_color_ibfk_2` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_type` (`id`),
	CONSTRAINT `user_setting_color_palette_color_ibfk_3` FOREIGN KEY (`palette_id`) REFERENCES `user_setting_color_palette` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
