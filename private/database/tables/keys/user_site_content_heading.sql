
ALTER TABLE `dlayer`.`user_site_content_heading`
    ADD CONSTRAINT `user_site_content_heading_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
