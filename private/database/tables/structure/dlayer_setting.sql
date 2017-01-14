
CREATE TABLE `dlayer_setting` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`setting_group_id` tinyint(3) unsigned NOT NULL,
	`name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
	`title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`description` text COLLATE utf8_unicode_ci NOT NULL,
	`url` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	`scope_id` tinyint(3) unsigned NOT NULL,
	`scope_details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `setting_group_id` (`setting_group_id`,`name`),
	UNIQUE KEY `url` (`url`),
	KEY `sort_order` (`sort_order`),
	KEY `enabled` (`enabled`),
	KEY `scope_id` (`scope_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
