
ALTER TABLE `dlayer`.`user_setting_color_palette`
	ADD CONSTRAINT `user_setting_color_palette_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
