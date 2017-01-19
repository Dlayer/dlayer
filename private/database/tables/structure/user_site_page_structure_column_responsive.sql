
CREATE TABLE `dlayer`.`user_site_page_structure_column_responsive`(
    `site_id` INT(11) UNSIGNED NOT NULL,
    `page_id` INT(11) UNSIGNED NOT NULL,
    `column_id` INT(11) UNSIGNED NOT NULL,
    `column_type_id` TINYINT(3) UNSIGNED NOT NULL,
    `size` TINYINT(2) UNSIGNED NOT NULL DEFAULT 12,
    PRIMARY KEY (`site_id`, `page_id`, `column_id`, `column_type_id`)
) ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;
