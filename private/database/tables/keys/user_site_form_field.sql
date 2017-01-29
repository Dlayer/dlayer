
ALTER TABLE `dlayer`.`user_site_form_field`
	ADD CONSTRAINT `user_site_form_field_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	ADD CONSTRAINT `user_site_form_field_fk2` FOREIGN KEY (`form_id`) REFERENCES `user_site_form` (`id`),
	ADD CONSTRAINT `user_site_form_field_fk3` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_type` (`id`);
