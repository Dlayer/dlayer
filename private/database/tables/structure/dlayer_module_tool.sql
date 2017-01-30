
CREATE TABLE `dlayer_module_tool` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`module_id` tinyint(3) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`group_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
	`sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `module_id` (`module_id`,`model`),
	KEY `enabled` (`enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
