
ALTER TABLE `dlayer`.`user_site_image_library_sub_category`
    ADD CONSTRAINT `user_site_image_library_sub_category_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_image_library_sub_category_fk2` FOREIGN KEY (`category_id`) REFERENCES `user_site_image_library_category` (`id`);
