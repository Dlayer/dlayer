
ALTER TABLE `dlayer`.`user_site_form`
    ADD CONSTRAINT `user_site_form_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
