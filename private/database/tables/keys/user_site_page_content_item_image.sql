
ALTER TABLE `dlayer`.`user_site_page_content_item_image`
    ADD CONSTRAINT `user_site_page_content_item_image_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_image_fk2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_image_fk3` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_version` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_image_fk4` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`);
