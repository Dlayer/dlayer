
ALTER TABLE `dlayer`.`user_site_image_library_version`
    ADD CONSTRAINT `user_site_image_library_version_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_image_library_version_fk2` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identity` (`id`),
    ADD CONSTRAINT `user_site_image_library_version_fk3` FOREIGN KEY (`library_id`) REFERENCES `user_site_image_library` (`id`),
    ADD CONSTRAINT `user_site_image_library_version_fk4` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`);
