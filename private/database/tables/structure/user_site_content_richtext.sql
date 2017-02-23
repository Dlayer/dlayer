
CREATE TABLE `user_site_content_richtext` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` INT(11) UNSIGNED NOT NULL,
    `name` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name so user can identity content',
    `content` TEXT COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    KEY `site_id` (`site_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
