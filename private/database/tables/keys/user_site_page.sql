
ALTER TABLE `dlayer`.`user_site_page`
	ADD CONSTRAINT `user_site_page_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
