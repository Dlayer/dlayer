
ALTER TABLE `dlayer`.`dlayer_setting_group`
	ADD CONSTRAINT `dlayer_setting_group_fk1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`);
