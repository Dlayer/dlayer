
ALTER TABLE `dlayer`.`user_site`
    ADD CONSTRAINT `user_site_fk1` FOREIGN KEY (`identity_id`) REFERENCES `dlayer_identity` (`id`);

