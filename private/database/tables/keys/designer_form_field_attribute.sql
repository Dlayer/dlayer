
ALTER TABLE `dlayer`.`designer_form_field_attribute`
    ADD CONSTRAINT `designer_form_field_attribute_fk1` FOREIGN KEY (`field_type_id`) REFERENCES `designer_form_field_type` (`id`),
    ADD CONSTRAINT `designer_form_field_attribute_fk2` FOREIGN KEY (`attribute_type_id`) REFERENCES `designer_form_field_attribute_type` (`id`);
