
CREATE TABLE `dlayer_session` (
	`session_id` char(32) COLLATE utf8_unicode_ci NOT NULL,
	`save_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	`modified` int(11) DEFAULT NULL,
	`lifetime` int(11) DEFAULT NULL,
	`session_data` text COLLATE utf8_unicode_ci,
	PRIMARY KEY (`session_id`,`save_path`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
