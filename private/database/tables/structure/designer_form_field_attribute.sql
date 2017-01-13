
CREATE TABLE `designer_form_field_attribute` (
	`id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
	`field_type_id` tinyint(3) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`attribute` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`attribute_type_id` tinyint(3) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `field_type_id` (`field_type_id`),
	KEY `attribute_type_id` (`attribute_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
