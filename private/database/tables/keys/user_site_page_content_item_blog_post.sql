
ALTER TABLE `dlayer`.`user_site_page_content_item_blog_post`
    ADD CONSTRAINT `user_site_page_content_item_blog_post_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_blog_post_fk2` FOREIGN KEY (`page_id`) REFERENCES `user_site_page` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_blog_post_fk3` FOREIGN KEY (`content_id`) REFERENCES `user_site_page_structure_content` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_blog_post_fk4` FOREIGN KEY (`heading_id`) REFERENCES `designer_content_heading` (`id`),
    ADD CONSTRAINT `user_site_page_content_item_blog_post_fk5` FOREIGN KEY (`data_id`) REFERENCES `user_site_content_blog_post` (`id`);
