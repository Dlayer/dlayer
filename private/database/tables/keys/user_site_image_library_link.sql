
ALTER TABLE `dlayer`.`user_site_image_library_link`
    ADD CONSTRAINT `user_site_image_library_link_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_image_library_link_fk2` FOREIGN KEY (`library_id`) REFERENCES `user_site_image_library` (`id`),
    ADD CONSTRAINT `user_site_image_library_link_fk3` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_version` (`id`);
