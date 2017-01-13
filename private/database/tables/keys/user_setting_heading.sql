
ALTER TABLE `dlayer`.`user_setting_heading`
	ADD CONSTRAINT `user_setting_heading_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	ADD CONSTRAINT `user_setting_heading_fk2` FOREIGN KEY (`style_id`) REFERENCES `designer_css_text_style` (`id`),
	ADD CONSTRAINT `user_setting_heading_fk3` FOREIGN KEY (`weight_id`) REFERENCES `designer_css_text_weight` (`id`),
	ADD CONSTRAINT `user_setting_heading_fk4` FOREIGN KEY (`decoration_id`) REFERENCES `designer_css_text_decoration` (`id`),
	ADD CONSTRAINT `user_setting_heading_fk5` FOREIGN KEY (`heading_id`) REFERENCES `designer_content_heading` (`id`);
