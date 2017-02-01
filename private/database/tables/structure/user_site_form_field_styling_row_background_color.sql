
CREATE TABLE `user_site_form_field_styling_row_background_color` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`form_id` int(11) unsigned NOT NULL,
	`field_id` int(11) unsigned NOT NULL,
	`background_color` char(7) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `form_id` (`form_id`),
	KEY `field_id` (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
