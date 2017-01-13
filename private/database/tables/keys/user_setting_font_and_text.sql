
ALTER TABLE `dlayer`.`user_setting_font_and_text`
	ADD CONSTRAINT `user_setting_font_and_text_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	ADD CONSTRAINT `user_setting_font_and_text_fk2` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`),
	ADD CONSTRAINT `user_setting_font_and_text_fk3` FOREIGN KEY (`font_family_id`) REFERENCES `designer_css_font_family` (`id`),
	ADD CONSTRAINT `user_setting_font_and_text_fk4` FOREIGN KEY (`text_weight_id`) REFERENCES `designer_css_text_weight` (`id`);
