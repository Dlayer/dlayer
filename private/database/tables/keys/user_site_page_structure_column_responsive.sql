
ALTER TABLE `dlayer`.`user_site_page_structure_column_responsive`
    ADD CONSTRAINT `user_site_page_structure_column_responsive_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_page_structure_column_responsive_fk2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
    ADD CONSTRAINT `user_site_page_structure_column_responsive_fk3` FOREIGN KEY (`column_id`) REFERENCES `user_site_page_structure_column` (`id`),
    ADD CONSTRAINT `user_site_page_structure_column_responsive_fk4` FOREIGN KEY (`column_type_id`) REFERENCES `designer_column_type` (`id`);
