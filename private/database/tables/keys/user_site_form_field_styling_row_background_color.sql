
ALTER TABLE `dlayer`.`user_site_form_field_styling_row_background_color`
    ADD CONSTRAINT `user_site_form_field_styling_row_background_color_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_form_field_styling_row_background_color_fk2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`),
    ADD CONSTRAINT `user_site_form_field_styling_row_background_color_fk3` FOREIGN KEY (`field_id`) REFERENCES `user_site_form_field` (`id`);
