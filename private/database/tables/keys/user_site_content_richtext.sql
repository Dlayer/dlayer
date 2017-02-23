
ALTER TABLE `dlayer`.`user_site_content_richtext`
    ADD CONSTRAINT `user_site_content_richtext_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
