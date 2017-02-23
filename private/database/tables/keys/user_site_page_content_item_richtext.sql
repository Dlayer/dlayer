
ALTER TABLE `dlayer`.`user_site_page_content_item_richtext`
    ADD CONSTRAINT `user_site_page_content_item_richtext_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_richtext_fk2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_richtext_fk3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_richtext_fk4` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_text` (`id`);
