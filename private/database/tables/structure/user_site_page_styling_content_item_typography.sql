
CREATE TABLE `user_site_page_styling_content_item_typography` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`page_id` int(11) unsigned NOT NULL,
	`content_id` int(11) unsigned NOT NULL,
	`font_family_id` tinyint(3) unsigned DEFAULT NULL,
	`text_weight_id` tinyint(3) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `page_id` (`page_id`),
	KEY `content_id` (`content_id`),
	KEY `font_family_id` (`font_family_id`),
	KEY `text_weight_id` (`text_weight_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
