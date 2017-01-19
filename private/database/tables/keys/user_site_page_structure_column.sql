
ALTER TABLE `dlayer`.`user_site_page_structure_column`
    ADD CONSTRAINT `user_site_page_structure_column_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_page_structure_column_fk2` FOREIGN KEY (`row_id`) REFERENCES `user_site_page_structure_row` (`id`),
    ADD CONSTRAINT `user_site_page_structure_column_fk3` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
    ADD CONSTRAINT `user_site_page_structure_column_fk4` FOREIGN KEY (`column_type_id`) REFERENCES `designer_column_type` (`id`);
