
CREATE TABLE `user_site` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`identity_id` int(11) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `identity_id` (`identity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
