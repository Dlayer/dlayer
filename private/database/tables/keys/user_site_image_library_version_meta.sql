
ALTER TABLE `dlayer`.`user_site_image_library_version_meta`
    ADD CONSTRAINT `user_site_image_library_version_meta_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_image_library_version_meta_fk2` FOREIGN KEY (`library_id`) REFERENCES `user_site_image_library` (`id`),
    ADD CONSTRAINT `user_site_image_library_version_meta_fk3` FOREIGN KEY (`version_id`) REFERENCES `user_site_image_library_version` (`id`);
