
ALTER TABLE `dlayer`.`user_site_content_rich_text`
    ADD CONSTRAINT `user_site_content_rich_text_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
