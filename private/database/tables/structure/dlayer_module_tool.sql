
CREATE TABLE `dlayer_module_tool` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`module_id` tinyint(3) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`base` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`destructive` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`group_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
	`sort_order` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `module_id` (`module_id`,`model`),
	KEY `enabled` (`enabled`),
	CONSTRAINT `dlayer_module_tool_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
