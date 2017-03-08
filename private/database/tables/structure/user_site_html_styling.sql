
CREATE TABLE `user_site_html_styling` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `site_id` int(10) unsigned NOT NULL,
    `attribute` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
    `value` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
