
ALTER TABLE `dlayer`.`user_site_page_structure_content`
    ADD CONSTRAINT `user_site_page_structure_content_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_page_structure_content_fk2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
    ADD CONSTRAINT `user_site_page_structure_content_fk3` FOREIGN KEY (`content_type`) REFERENCES `designer_content_type` (`id`),
    ADD CONSTRAINT `user_site_page_structure_content_fk4` FOREIGN KEY (`column_id`) REFERENCES `user_site_page_structure_column` (`id`);
