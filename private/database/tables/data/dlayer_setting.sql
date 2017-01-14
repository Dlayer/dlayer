
insert  into `dlayer_setting`(`id`,`setting_group_id`,`name`,`title`,`description`,`url`,`scope_id`,`scope_details`,`sort_order`,`enabled`) values
    (1,1,'Colour palettes','Colour palettes','<p>You can define three colour palettes for each of your web sites, the colours you define here will be shown anytime you need a tool that requires you to choose a colour.</p>\r\n\r\n<p>You will always be able to choose a colour that is not in one of your three palettes, think of these as quick access.</p>','/dlayer/settings/palettes',1,'All colour pickers',2,1),
    (2,3,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the content manager, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/content/settings/base-font-family',2,'Content module, all text',2,1),
    (3,3,'Heading styles','Set the styles for the six heading types','<p>Define the styles for the page title and the five sub headings, H2 through H6.</p>\r\n\r\n<p>Anywhere you need to choose one of the heading types the styles defined here will be used.</p>','/content/settings/headings',3,'Heading tool',3,1),
    (4,4,'Base font family','Set the base font for all text','<p>Set the base font family for the text in the form builder, the user’s  web browser will attempt to use each of the fonts in the order they are specified until a valid font is found.</p>\r\n\r\n<p>All content unless styled otherwise will appear using the selected base font family.</p>','/form/settings/base-font-family',2,'Forms module, all text',2,1),
    (5,1,'Overview','Overview','<p>Settings overview.</p>','/dlayer/settings/index',1,NULL,1,1),
    (6,2,'Overview','Overview','<p>Template designer settings overview.</p>','/template/settings/index',2,NULL,1,1),
    (7,3,'Overview','Overview','<p>Content manager settings overview.</p>','/content/settings/index',2,NULL,1,1),
    (8,4,'Overview','Overview','<p>Form builder settings overview.</p>','/form/settings/index',2,NULL,1,1),
    (9,8,'Overview','Overview','<p>Image library settings overview.</p>','/image/settings/index',2,NULL,1,1),
    (10,6,'Overview','Overview','<p>Web site manager settings overview.</p>','/website/settings/index',2,NULL,1,1),
    (11,5,'Overview','Overview','<p>Widget designer settings overview</p>','/widget/settings/index',2,NULL,1,1);
