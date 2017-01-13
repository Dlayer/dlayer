
CREATE TABLE `user_site_history` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`identity_id` int(11) unsigned NOT NULL,
	`site_id` int(11) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `identity_id` (`identity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
