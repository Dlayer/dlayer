
Changelog
======

Full changelog for Dlayer since the v1.00 release.

v1.08: 2017-01-26
--------

- I have removed the full SQL exports, no longer required, setup module will be used for all imports.
- Added foundation for the Form Builder, this shows the currently selected form, the control bar and ribbon.
- Added a Preview mode to display the final form.
- Moving to a separate layout per designer.

v1.07: 2017-01-25 
--------

- Added the foundation code for the Form Builder module.
- You can now add and edit form definitions, name and title as of this release.
- Added initial code for the Form Builder session class.
- Minor styling updates to forms, the further reading block and lists.

v1.06: 2017-01-23 
--------

- Removed additional terminators in SQL data files. [Bugfix]
- Added a settings sub tool to columns, allows the column width and offset to be defined. [Feature]
- Added a glyph style field to tool tabs table, added to allow glyph icons to be rotated.
- Moved column type from the columns structure table, now a separate table. [Database]
- Added a responsive sub tool to columns, you can now set the column width for the ‘xs’, ‘sm’ and ‘lg’ layouts, Dlayer defaults to ‘md’. [Feature]
- Added a control bar to the bottom of the designer, houses the cancel button and navigation controls for Content Manager. [UX]
- The tool buttons are now in the new control bar. [UX]
- Added missing foreign keys. [Database]
- Removed redundant tables from the database. [Database]
- Updated the tool ribbon classes, general refactoring.
- Other minor fixes and improvements.

v1.05:  2017-01-17
--------

- I have added a live preview when editing text, jumbotron and heading content items. [Feature]
- Corrected the class names for the heading tool; it will now correctly load in the demo. [Bugfix]
- Added a setting to application.ini which controls whether or not the test credentials display on the sign-in page. [Feature]
- Split the database export into three files per table, one for the structure, another for the data and a third to define the foreign keys.
- I have added a setup module; this allows you to create the tables for the database and imports the required data, there are four options, import demo database, import base database, reset to demo state and reset to clean state. [Feature]

v1.04: 2017-01-09 
--------

- I have updated the styling sub tools, the Form, Model and Tool classes extend from shared classes as per the typography sub tool.
- If you only have one page in the Content Manager, it is now automatically selected.
- The title and subtitle set for a form now display in the Content Manager [Bugfix].
- I have updated the content for the demo sign-in page; it now shows the changelog for the latest version.
- The heading type is now updateable for heading based content items [Bugfix].
- If you try to create a new content item when in edit mode for an existing content item you will no longer be met with a nasty error [Bugfix].
- I have added controls to select the sibling (next|previous) content items in a column; this should reduce the number of clicks when editing [UX].
- I have added titles above each of the new navigation controls, ‘Parents’ and ‘Column content items’.

v1.03: 2017-01-07
--------

- The page tool is now auto selected in the designer, both on initial entry and whenever you click the cancel button. It is stupid to force you to choose the page when there is only ever one page which always needs to be selected. [UX]
- Added select parent row to the column tool, now easier to go back. [UX]
- Added select parent column/page to the row tool, now easier to go back. [UX]
- Added nesting support for rows and columns. [Feature]
- The ‘Add row’ and ‘Add content’ tools are aware of state, they will only display when relevant. [UX]
- I have added the ability to collapse top level rows so you can concentrate on a particular area of the design. [UX]
- The min-height on a page is only applied when the page is empty.
- I have updated the sample site for all three demo users.
- Creating a default site no longer errors, an issue with insert default text weights. [Bugfix]
- Removed the log links, not currently necessary.
- Updated the code hinting in all view files, now correctly shows all view helpers.
- Added select parent row and column to content item tools, now easier to go back. [UX]
- I have reduced the size of all the buttons in the designer. [UI]
- I have updated the content for the demo home page and the Content Manager home page.
- Set the stable version to v1.03.
- Refactoring.

v1.02: 2016-12-31 
--------

- Initial support for shared tool classes, for now simply extend from a Shared folder. [Feature]
- Fixed a bug with typography sub tool, font family and text weight values not getting set, query had an excess inner join that wouldn't work if font family was null. [Bug]
- Added text weight to typography sub tool for Form content items. [Feature]
- Added text weight to typography sub tool for Heading content items. [Feature]
- Added text weight to typography sub tool for Jumbotron content items. [Feature]
- Added text weight to typography sub tool for Image content items. [Feature]
- Added additional support for shared tools, simple to now have a shared form, tool, model or ribbon class.
- Updated the colour of action buttons for tools, there were too many blue buttons.
- Added a divider to tab p[ages that have multiple forms, for example, add row.
- Added typography sub tool to HTML tool. [Feature]
- Initial help text for Page, Column and Row tool tabs hidden behind a collapse.

v1.01: 2016-12-26 
--------

- Corrected ordinal for release date. [Bug]
- Directory separator incorrect. [Bug]
- Added the ability to set text weight on text content items. [Feature]
- Updated model to only save typography values when necessary.
- Initial work on shared models.
- Added preview for text weight changes. [Feature]
- README updated to show last stable/complete release.

v1.00: 2016-12-22 
--------
Welcome to the first official open source release of Dlayer; it is not a complete product yet but for reasons I have outlined on my blog many times it feels right to badge it as v1.00.

Over the coming weeks, I will continue to polish the core of the Content manager and work towards returning the module that I removed in the last part of this year.

A full set-up process will appear in the new year along with simple reset scripts to ease development.

