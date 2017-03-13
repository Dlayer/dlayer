
ALTER TABLE `dlayer`.`user_site_row_styling`
    ADD CONSTRAINT `user_site_row_styling_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_row_styling_fk2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
    ADD CONSTRAINT `user_site_row_styling_fk3` FOREIGN KEY (`row_id`) REFERENCES `user_site_page_structure_row` (`id`);
