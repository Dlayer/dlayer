
ALTER TABLE `dlayer`.`dlayer_setting`
    ADD CONSTRAINT `dlayer_setting_fk11` FOREIGN KEY (`setting_group_id`) REFERENCES `dlayer_setting_group` (`id`),
    ADD CONSTRAINT `dlayer_setting_fk22` FOREIGN KEY (`scope_id`) REFERENCES `dlayer_setting_scope` (`id`);
