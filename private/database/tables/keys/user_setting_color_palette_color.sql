
ALTER TABLE `dlayer`.`user_setting_color_palette_color`
	ADD CONSTRAINT `user_setting_color_palette_color_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
	ADD CONSTRAINT `user_setting_color_palette_color_fk2` FOREIGN KEY (`color_type_id`) REFERENCES `designer_color_type` (`id`),
	ADD CONSTRAINT `user_setting_color_palette_color_fk3` FOREIGN KEY (`palette_id`) REFERENCES `user_setting_color_palette` (`id`);
