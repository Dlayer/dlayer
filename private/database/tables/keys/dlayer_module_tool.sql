
ALTER TABLE `dlayer`.`dlayer_module_tool`
	ADD CONSTRAINT `dlayer_module_tool_fk1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`);
