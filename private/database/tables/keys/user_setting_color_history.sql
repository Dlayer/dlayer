
ALTER TABLE `dlayer`.`user_setting_color_history`
	ADD CONSTRAINT `user_setting_color_history_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
