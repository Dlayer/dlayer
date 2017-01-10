
CREATE TABLE `user_setting_font_and_text` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`module_id` tinyint(3) unsigned NOT NULL,
	`font_family_id` tinyint(3) unsigned NOT NULL,
	`text_weight_id` tinyint(3) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `module_id` (`module_id`),
	KEY `font_family_id` (`font_family_id`),
	KEY `text_weight_id` (`text_weight_id`),
	CONSTRAINT `user_setting_font_and_text_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	CONSTRAINT `user_setting_font_and_text_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`),
	CONSTRAINT `user_setting_font_and_text_ibfk_3` FOREIGN KEY (`font_family_id`) REFERENCES `designer_css_font_family` (`id`),
	CONSTRAINT `user_setting_font_and_text_ibfk_4` FOREIGN KEY (`text_weight_id`) REFERENCES `designer_css_text_weight` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
