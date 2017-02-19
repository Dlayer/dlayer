
insert  into `user_setting_font_and_text`(`id`,`site_id`,`module_id`,`font_family_id`,`text_weight_id`) values
    (NULL,1,(SELECT `id`
             FROM `dlayer_module`
             WHERE `name` = 'form'),1,1),
    (NULL,1,(SELECT `id`
             FROM `dlayer_module`
             WHERE `name` = 'content'),1,1),
    (NULL,2,(SELECT `id`
             FROM `dlayer_module`
             WHERE `name` = 'form'),1,1),
    (NULL,2,(SELECT `id`
             FROM `dlayer_module`
             WHERE `name` = 'content'),1,1),
    (NULL,3,(SELECT `id`
             FROM `dlayer_module`
             WHERE `name` = 'form'),1,1),
    (NULL,3,(SELECT `id`
             FROM `dlayer_module`
             WHERE `name` = 'content'),1,1);
