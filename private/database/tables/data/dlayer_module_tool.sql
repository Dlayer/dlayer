INSERT INTO `dlayer_module_tool` (`id`, `module_id`, `name`, `model`, `group_id`, `sort_order`, `enabled`) VALUES
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Cancel', 'Cancel', 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Text', 'Text', 4, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Heading', 'Heading', 4, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Form', 'Form', 5, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Add row(s)', 'AddRow', 3, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Jumbotron', 'Jumbotron', 4, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Row', 'Row', 3, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Image', 'Image', 5, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Page', 'Page', 99, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Column', 'Column', 3, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Add column(s)', 'AddColumn', 3, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'HTML', 'Html', 4, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Cancel', 'Cancel', 0, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Text', 'Text', 2, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Textarea', 'Textarea', 2, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Email', 'Email', 2, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Password', 'Password', 2, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Stacked layout', 'StackedLayout', 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Inline layout', 'InlineLayout', 1, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Horizontal layout', 'HorizontalLayout', 1, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Titles', 'Title', 1, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Buttons', 'Button', 1, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Name', 'PresetName', 3, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Email', 'PresetEmail', 3, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Address', 'PresetAddress', 3, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Comment', 'PresetComment', 3, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Date', 'Date', 2, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Heading & Date', 'HeadingDate', 4, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Date of Birth', 'PresetDateOfBirth', 3, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), 'Alternate rows', 'StylingAlternateRow', 4, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), 'Rich text', 'RichText', 4, 6, 0);
