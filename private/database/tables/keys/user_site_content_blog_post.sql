
ALTER TABLE `dlayer`.`user_site_content_blog_post`
    ADD CONSTRAINT `user_site_content_blog_post_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
