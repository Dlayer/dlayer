
ALTER TABLE `dlayer`.`user_site_page_styling_content_item_typography`
    ADD CONSTRAINT `user_site_page_styling_content_item_typography_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_page_styling_content_item_typography_fk2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
    ADD CONSTRAINT `user_site_page_styling_content_item_typography_fk3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
    ADD CONSTRAINT `user_site_page_styling_content_item_typography_fk4` FOREIGN KEY (`font_family_id`) REFERENCES `designer_css_font_family` (`id`),
    ADD CONSTRAINT `user_site_page_styling_content_item_typography_fk5` FOREIGN KEY (`text_weight_id`) REFERENCES `designer_css_text_weight` (`id`);
