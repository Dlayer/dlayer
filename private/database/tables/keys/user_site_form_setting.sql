
ALTER TABLE `dlayer`.`user_site_form_layout`
    ADD CONSTRAINT `user_site_form_setting_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_form_setting_fk2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`);
