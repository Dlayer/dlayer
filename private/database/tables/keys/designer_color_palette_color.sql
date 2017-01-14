
ALTER TABLE `dlayer`.`designer_color_palette_color`
    ADD CONSTRAINT `designer_color_palette_color_fk1` FOREIGN KEY (`palette_id`) REFERENCES `dlayer`.`designer_color_palette`(`id`);
