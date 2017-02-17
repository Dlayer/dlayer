
CREATE TABLE `user_site_page_content_item_heading_date` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `site_id` int(11) unsigned NOT NULL,
    `page_id` int(11) unsigned NOT NULL,
    `content_id` int(11) unsigned NOT NULL,
    `heading_id` tinyint(3) unsigned NOT NULL,
    `format` varchar(25) NOT NULL,
    `data_id` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `site_id` (`site_id`),
    KEY `page_id` (`page_id`),
    KEY `content_id` (`content_id`),
    KEY `heading_id` (`heading_id`),
    KEY `data_id` (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
