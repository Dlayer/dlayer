
CREATE TABLE `user_site_form_field` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`form_id` int(11) unsigned NOT NULL,
	`field_type_id` tinyint(3) unsigned NOT NULL,
	`sort_order` int(11) unsigned NOT NULL DEFAULT '1',
	`deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `form_id` (`form_id`),
	KEY `field_type_id` (`field_type_id`),
    KEY `deleted` (`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
