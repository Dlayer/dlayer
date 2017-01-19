
CREATE TABLE `user_setting_heading` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`heading_id` tinyint(3) unsigned NOT NULL,
	`style_id` tinyint(3) unsigned NOT NULL,
	`weight_id` tinyint(3) unsigned NOT NULL,
	`decoration_id` tinyint(3) unsigned NOT NULL,
	`size` tinyint(3) unsigned NOT NULL DEFAULT '12',
	`color_hex` char(7) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#000000',
	`sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `style_id` (`style_id`),
	KEY `weight_id` (`weight_id`),
	KEY `decoration_id` (`decoration_id`),
	KEY `heading_id` (`heading_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
