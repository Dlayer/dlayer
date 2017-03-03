
CREATE TABLE `user_site_page_content_item_rich_text` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `site_id` int(11) unsigned NOT NULL,
    `page_id` int(11) unsigned NOT NULL,
    `content_id` int(11) unsigned NOT NULL,
    `data_id` int(11) unsigned NOT NULL COMMENT 'Id of content in data table',
    PRIMARY KEY (`id`),
    KEY `page_id` (`page_id`),
    KEY `content_id` (`content_id`),
    KEY `site_id` (`site_id`),
    KEY `data_id` (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
