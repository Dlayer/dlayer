
ALTER TABLE `dlayer`.`designer_form_field_param_preview`
    ADD CONSTRAINT `designer_form_field_param_preview_fk1` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_type` (`id`),
    ADD CONSTRAINT `designer_form_field_param_preview_fk2` FOREIGN KEY (`field_attribute_id`) REFERENCES `designer_form_field_attribute` (`id`),
    ADD CONSTRAINT `designer_form_field_param_preview_fk3` FOREIGN KEY (`preview_method_id`) REFERENCES `designer_form_preview_method` (`id`);
