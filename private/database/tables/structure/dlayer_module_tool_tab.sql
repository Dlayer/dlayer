
CREATE TABLE `dlayer_module_tool_tab` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`module_id` tinyint(2) unsigned NOT NULL,
	`tool_id` int(11) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`script` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`glyph` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`glyph_style` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`multi_use` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`edit_mode` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`default` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `module_tool_model` (`module_id`,`tool_id`,`model`),
	KEY `enabled` (`enabled`),
	KEY `module_id` (`module_id`),
	KEY `tool_id` (`tool_id`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
