
CREATE TABLE `designer_color_palette_color` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`palette_id` int(11) unsigned NOT NULL,
	`color_type_id` tinyint(3) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `palette_id` (`palette_id`),
	KEY `color_type_id` (`color_type_id`),
	CONSTRAINT `designer_color_palette_color_ibfk_1` FOREIGN KEY (`palette_id`) REFERENCES `designer_color_palette` (`id`),
	CONSTRAINT `designer_color_palette_color_ibfk_2` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
