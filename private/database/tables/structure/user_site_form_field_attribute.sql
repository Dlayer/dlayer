
CREATE TABLE `user_site_form_field_attribute` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`form_id` int(11) unsigned NOT NULL,
	`field_id` int(11) unsigned NOT NULL,
	`attribute_id` tinyint(3) unsigned NOT NULL,
	`attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `form_id` (`form_id`),
	KEY `field_id` (`field_id`),
	KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
