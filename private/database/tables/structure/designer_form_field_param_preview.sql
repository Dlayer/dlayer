
CREATE TABLE `designer_form_field_param_preview` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`field_type_id` tinyint(3) unsigned NOT NULL,
	`field_attribute_id` tinyint(3) unsigned NOT NULL,
	`preview_method_id` tinyint(3) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `field_attribute_id` (`field_attribute_id`),
	KEY `preview_method_id` (`preview_method_id`),
	KEY `designer_form_field_param_previews_ibfk_1` (`field_type_id`),
	CONSTRAINT `designer_form_field_param_preview_ibfk_1` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_type` (`id`),
	CONSTRAINT `designer_form_field_param_preview_ibfk_2` FOREIGN KEY (`field_attribute_id`) REFERENCES `designer_form_field_attribute` (`id`),
	CONSTRAINT `designer_form_field_param_preview_ibfk_3` FOREIGN KEY (`preview_method_id`) REFERENCES `designer_form_preview_method` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
