
ALTER TABLE `dlayer`.`user_site_image_library_category`
	ADD CONSTRAINT `user_site_image_library_category_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
