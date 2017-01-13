
ALTER TABLE `dlayer`.`dlayer_module_tool_tab`
	ADD CONSTRAINT `dlayer_module_tool_tab_fk1` FOREIGN KEY (`module_id`) REFERENCES `dlayer_module` (`id`),
	ADD CONSTRAINT `dlayer_module_tool_tab_fk2` FOREIGN KEY (`tool_id`) REFERENCES `dlayer_module_tool` (`id`);
