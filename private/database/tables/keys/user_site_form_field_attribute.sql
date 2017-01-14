
ALTER TABLE `dlayer`.`user_site_form_field_attribute`
    ADD CONSTRAINT `user_site_form_field_attribute_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_form_field_attribute_fk2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`),
    ADD CONSTRAINT `user_site_form_field_attribute_fk3` FOREIGN KEY (`field_id`) REFERENCES `user_site_form_field` (`id`),
    ADD CONSTRAINT `user_site_form_field_attribute_fk4` FOREIGN KEY (`attribute_id`) REFERENCES `designer_form_field_attribute` (`id`);
