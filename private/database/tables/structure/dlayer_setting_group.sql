
CREATE TABLE `dlayer_setting_group` (
	`id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
	`module_id` tinyint(3) unsigned NOT NULL,
	`title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`tab_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`url` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	`sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `name` (`name`),
	UNIQUE KEY `url` (`url`),
	KEY `sort_order` (`sort_order`),
	KEY `enabled` (`enabled`),
	KEY `module_id` (`module_id`),
	CONSTRAINT `dlayer_setting_group_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
