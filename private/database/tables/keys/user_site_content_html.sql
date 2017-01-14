
ALTER TABLE `dlayer`.`user_site_content_html`
	ADD CONSTRAINT `user_site_content_html_fk1` FOREIGN KEY (`site_id`) REFERENCES `user_site` (`id`);
