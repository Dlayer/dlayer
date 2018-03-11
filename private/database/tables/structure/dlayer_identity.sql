
CREATE TABLE `dlayer_identity` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`identity` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
	`credentials` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`logged_in` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`last_login` DATETIME NOT NULL,
	`last_action` DATETIME NOT NULL,
	`enabled` tinyint(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `username` (`identity`),
	KEY `enabled` (`enabled`),
	KEY `logged_in` (`logged_in`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
