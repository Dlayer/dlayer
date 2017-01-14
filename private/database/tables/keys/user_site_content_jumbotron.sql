
ALTER TABLE `dlayer`.`user_site_content_jumbotron`
    ADD CONSTRAINT `user_site_content_jumbotron_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
