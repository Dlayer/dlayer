
CREATE TABLE `user_site_form_setting` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`form_id` int(11) unsigned NOT NULL,
	`width` int(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Minimum form display width',
	`legend` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Fieldset legend text for form',
	`button` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Text for the submit button',
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `form_id` (`form_id`),
	CONSTRAINT `user_site_form_setting_ibfk_1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	CONSTRAINT `user_site_form_setting_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
