
CREATE TABLE `user_site_page_content_item_jumbotron` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`site_id` int(11) unsigned NOT NULL,
	`page_id` int(11) unsigned NOT NULL,
	`content_id` int(11) unsigned NOT NULL,
	`data_id` int(11) unsigned NOT NULL,
	`button_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `site_id` (`site_id`),
	KEY `page_id` (`page_id`),
	KEY `content_id` (`content_id`),
	KEY `data_id` (`data_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
