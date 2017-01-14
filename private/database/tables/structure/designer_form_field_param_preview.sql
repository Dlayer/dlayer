
CREATE TABLE `designer_form_field_param_preview` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`field_type_id` tinyint(3) unsigned NOT NULL,
	`field_attribute_id` tinyint(3) unsigned NOT NULL,
	`preview_method_id` tinyint(3) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `field_attribute_id` (`field_attribute_id`),
	KEY `preview_method_id` (`preview_method_id`),
	KEY `field_type_id` (`field_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
