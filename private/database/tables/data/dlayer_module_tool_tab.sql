INSERT INTO `dlayer_module_tool_tab`
(
    `id`,
    `module_id`,
    `tool_id`,
    `name`,
    `script`,
    `model`,
    `glyph`,
    `glyph_style`,
    `multi_use`,
    `edit_mode`,
    `default`,
    `sort_order`,
    `enabled`
)
VALUES
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'Text'), 'Plain text', 'text', NULL, 'pencil',
           NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Heading'), 'Heading', 'heading', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Text'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Heading'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Form'), 'Form', 'form', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Form'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Text'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Text'), 'Typography', 'typography', 'Typography', 'font', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'AddRow'), 'Row', 'add-row', NULL, 'align-justify', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'AddRow'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Jumbotron'), 'Jumbotron', 'jumbotron', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Jumbotron'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Row'), 'Row', 'row', NULL, 'align-justify', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Image'), 'Image', 'image', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Image'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Row'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Page'), 'Page', 'page', NULL, 'file', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Page'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` =
                  'content'), (SELECT `dlayer_module_tool`.`id`
                               FROM `dlayer_module_tool`
                                   INNER JOIN `dlayer_module`
                                       ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                          `dlayer_module`.`name` = 'content'
                               WHERE `dlayer_module_tool`.`model` =
                                     'Column'), 'Column', 'column', NULL, 'align-justify', "transform: rotate(90deg);", 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Column'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` =
                  'content'), (SELECT `dlayer_module_tool`.`id`
                               FROM `dlayer_module_tool`
                                   INNER JOIN `dlayer_module`
                                       ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                          `dlayer_module`.`name` = 'content'
                               WHERE `dlayer_module_tool`.`model` =
                                     'AddColumn'), 'Add Column', 'add-column', NULL, 'align-justify', "transform: rotate(90deg);", 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'AddColumn'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Heading'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Column'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 0, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Row'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Page'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Form'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Image'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Jumbotron'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Html'), 'HTML', 'html', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Html'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Html'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Heading'), 'Typography', 'typography', 'Typography', 'font', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Jumbotron'), 'Typography', 'typography', 'Typography', 'font', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Image'), 'Typography', 'typography', 'Typography', 'font', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Form'), 'Typography', 'typography', 'Typography', 'font', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Html'), 'Typography', 'typography', 'Typography', 'font', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Column'), 'Settings', 'settings', 'Settings', 'cog', NULL, 1, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` =
                  'content'), (SELECT `dlayer_module_tool`.`id`
                               FROM `dlayer_module_tool`
                                   INNER JOIN `dlayer_module`
                                       ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                          `dlayer_module`.`name` = 'content'
                               WHERE `dlayer_module_tool`.`model` =
                                     'Column'), 'Responsive', 'responsive', 'Responsive', 'equalizer', "transform: rotate(90deg);", 1, 0, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Text'), 'Text', 'text', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Text'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Textarea'), 'Textarea', 'textarea', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Textarea'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Email'), 'Email', 'email', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Email'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Password'), 'Password', 'password', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Password'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Text'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Textarea'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Email'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Password'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Text'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'StackedLayout'), 'Stacked', 'stacked-layout', NULL, 'blackboard', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'StackedLayout'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'InlineLayout'), 'Inline', 'inline-layout', NULL, 'blackboard', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'InlineLayout'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'HorizontalLayout'), 'Horizontal', 'horizontal-layout', NULL, 'blackboard', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'HorizontalLayout'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'TItle'), 'Title', 'title', NULL, 'header', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'TItle'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Button'), 'Buttons', 'button', NULL, 'text-background', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Button'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Textarea'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Email'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Password'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'PresetName'), 'Name', 'preset-name', NULL, 'pencil', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'PresetName'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'PresetEmail'), 'Email', 'preset-email', NULL, 'pencil', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'PresetEmail'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'PresetAddress'), 'Address', 'preset-address', NULL, 'pencil', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'PresetAddress'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'PresetComment'), 'Comment', 'preset-comment', NULL, 'pencil', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'PresetComment'), 'Help', 'help', NULL, 'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Text'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Heading'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Form'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Jumbotron'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Image'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Html'), 'Delete', 'delete', 'Delete', 'remove', NULL, 0, 1, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Date'), 'Date', 'date', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` =
                                              'Date'), 'Styling', 'styling', 'Styling', 'tint', NULL, 1, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` = 'Date'), 'Delete', 'delete', 'Delete',
           'remove', NULL, 1, 0, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` = 'Date'), 'Help', 'help', NULL, 'info-sign',
           NULL, 0, 0, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'HeadingDate'), 'Heading & Date',
           'heading-date', NULL, 'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'HeadingDate'), 'Styling', 'styling',
           'Styling', 'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'HeadingDate'), 'Typography', 'typography',
           'Typography', 'font', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'HeadingDate'), 'Delete', 'delete',
           'Delete', 'remove', NULL, 0, 1, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'HeadingDate'), 'Help', 'help', NULL,
           'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'form'
                                        WHERE `dlayer_module_tool`.`model` = 'PresetDateOfBirth'), 'Date of Birth', 'preset-date-of-birth', NULL,
           'pencil', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                     FROM `dlayer_module_tool`
                                         INNER JOIN `dlayer_module`
                                             ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                `dlayer_module`.`name` = 'form'
                                     WHERE `dlayer_module_tool`.`model` = 'PresetDateOfBirth'), 'Help', 'help', NULL,
           'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                     FROM `dlayer_module_tool`
                                         INNER JOIN `dlayer_module`
                                             ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                `dlayer_module`.`name` = 'form'
                                     WHERE `dlayer_module_tool`.`model` = 'StylingAlternateRow'), 'Alternate row', 'alternate-row', NULL,
           'tint', NULL, 0, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'form'), (SELECT `dlayer_module_tool`.`id`
                                     FROM `dlayer_module_tool`
                                         INNER JOIN `dlayer_module`
                                             ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                `dlayer_module`.`name` = 'form'
                                     WHERE `dlayer_module_tool`.`model` = 'StylingAlternateRow'), 'Help', 'help', NULL,
           'info-sign', NULL, 0, 0, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                     FROM `dlayer_module_tool`
                                         INNER JOIN `dlayer_module`
                                             ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                `dlayer_module`.`name` = 'content'
                                     WHERE `dlayer_module_tool`.`model` = 'RichText'), 'Text', 'rich-text', NULL,
           'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'RichText'), 'Help', 'help', NULL,
           'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'BlogPost'), 'Blog post', 'blog-post', NULL,
           'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'BlogPost'), 'Help', 'help', NULL,
           'info-sign', NULL, 0, 0, 0, 5, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'RichText'), 'Styling', 'styling', 'Styling',
           'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'RichText'), 'Typography', 'typography', 'Typography',
           'font', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'RichText'), 'Delete', 'delete', 'Delete',
           'remove', NULL, 1, 0, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'BlogPost'), 'Styling', 'styling', 'Styling',
           'tint', NULL, 1, 1, 0, 2, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'BlogPost'), 'Typography', 'typography', 'Typography',
           'font', NULL, 1, 1, 0, 3, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'BlogPost'), 'Delete', 'delete', 'Delete',
           'remove', NULL, 1, 0, 0, 4, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'HorizontalRule'), 'Horizontal Rule', 'horizontal-rule', NULL,
           'pencil', NULL, 1, 0, 1, 1, 1),
    (NULL, (SELECT `id`
            FROM `dlayer_module`
            WHERE `name` = 'content'), (SELECT `dlayer_module_tool`.`id`
                                        FROM `dlayer_module_tool`
                                            INNER JOIN `dlayer_module`
                                                ON `dlayer_module_tool`.`module_id` = `dlayer_module`.`id` AND
                                                   `dlayer_module`.`name` = 'content'
                                        WHERE `dlayer_module_tool`.`model` = 'HorizontalRule'), 'Help', 'help', NULL,
           'info-sign', NULL, 0, 0, 0, 2, 1);
