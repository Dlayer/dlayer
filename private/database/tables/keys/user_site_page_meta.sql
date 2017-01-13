
ALTER TABLE `dlayer`.`user_site_page_meta`
	ADD CONSTRAINT `user_site_page_meta_fk1` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`);
