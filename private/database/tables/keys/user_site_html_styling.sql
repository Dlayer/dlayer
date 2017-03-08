
ALTER TABLE `dlayer`.`user_site_html_styling`
    ADD CONSTRAINT `user_site_html_styling_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
