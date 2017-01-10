
CREATE TABLE `designer_css_border_style` (
	`id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
	`style` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
	`sort_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `style` (`style`),
	KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Border styles that can be used within the designers';
