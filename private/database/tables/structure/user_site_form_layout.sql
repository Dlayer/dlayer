
CREATE TABLE `user_site_form_layout` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`form_id` int(11) unsigned NOT NULL,
	`title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`sub_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`submit_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`reset_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`layout_id` tinyint(3) unsigned NOT NULL,
	`horizontal_width_label` tinyint(2) unsigned NOT NULL,
	`horizontal_width_field` tinyint(2) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `form_id` (`form_id`),
	KEY `layout_id` (`layout_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
