
ALTER TABLE `dlayer`.`user_site_history`
    ADD CONSTRAINT `user_site_history_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_history_fk2` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identity` (`id`);
