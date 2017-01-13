
ALTER TABLE `dlayer`.`designer_content_type`
	ADD CONSTRAINT `designer_content_type_fk1` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`);
