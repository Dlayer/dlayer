/**
 * Preview functions for the Content manager
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
var previewContentManager =
    {
        /**
         * Preview function for an elements background color, updates the item with the passed in value
         *
         * @param {Number} content_id Id of the content item
         * @param {String} value The background color to set
         */
        contentItemBackgroundColor: function(content_id, value)
        {
            $('#params-content_background_color').change(function()
            {
                var new_value = this.value;
                var selector = '.content[data-content-id="' + content_id + '"]';

                preview.setAndAnimateBackgroundColor(selector, new_value);
            });
        },

        /**
         * Background colour preview, column
         *
         * @param {Number} column_id Id of the column
         * @param {String} value The background color to set
         */
        columnBackgroundColor: function(column_id, value)
        {
            $('#params-background_color').change(function()
            {
                var new_value = this.value;
                var selector = '.column[data-column-id="' + column_id + '"]';

                preview.setAndAnimateBackgroundColor(selector, new_value);
            });
        },

        /**
         * Background colour preview, row
         *
         * @param {Number} row_id Id of the row
         * @param {String} value The background color to set
         */
        rowBackgroundColor: function(row_id, value)
        {
            $('#params-background_color').change(function()
            {
                var new_value = this.value;
                var selector = '.row[data-row-id="' + row_id + '"]';

                preview.setAndAnimateBackgroundColor(selector, new_value);

            });
        },

        /**
         * Background colour preview, page
         *
         * @param {String} value The background color to set
         */
        pageBackgroundColor: function(value)
        {
            $('#params-background_color').change(function()
            {
                var new_value = this.value;
                var selector = '.container-fluid.selected';

                preview.setAndAnimateBackgroundColor(selector, new_value);
            });
        },

        /**
         * Font family for a content item
         *
         * @param {Number} content_id Id of the content item
         * @param {Array} font_families The font families supported by the system
         */
        contentItemFontFamily: function(content_id, font_families)
        {
            $('#params-font_family_id').change(function()
            {
                var selector = '.content[data-content-id="' + content_id + '"]';

                if ($(this).val() in font_families) {
                    $(selector).css('font-family', font_families[$(this).val()]);

                    preview.changed = true;
                }

                preview.unsaved();
            });
        },

        /**
         * Text weight for a content item
         *
         * @param {Number} content_id Id of the content item
         * @param {Array} text_weights The text weights supported by the system
         */
        contentItemTextWeight: function(content_id, text_weights)
        {
            $('#params-text_weight_id').change(function()
            {
                var selector = '.content[data-content-id="' + content_id + '"]';

                if ($(this).val() in text_weights) {
                    $(selector).css('font-weight', text_weights[$(this).val()]);

                    preview.changed = true;
                }

                preview.unsaved();
            });
        },

        /**
         * Update the text for an element
         *
         * @param {String} field Field selector
         * @param {String} content Content selector
         * @param {String} initial_value Initial value
         * @param {Boolean} nl2br
         * @param {Boolean} optional Is the text optional
         */
        elementText: function(field, content, initial_value, nl2br, optional)
        {
            $(field).keyup(function()
            {
                if (this.value.trim().length > 0) {
                    if (nl2br === true) {
                        $(content).html(preview.nl2br(this.value.trim()));
                    } else {
                        $(content).html(this.value.trim());
                    }

                    preview.changed = true;
                } else {
                    if (optional === true) {
                        $(content).html('');

                        preview.changed = true;
                    } else {
                        $(content).html(preview.nl2br(initial_value));
                        $(field).val(initial_value);
                    }
                }

                preview.unsaved();
            });

            $(field).blur(function()
            {
                if (preview.changed === true) {
                    preview.highlight = true;
                    preview.highlightItem(content);
                }
            });
        },

        /**
         * Update the heading test
         *
         * @param {String} field_title Field title selector
         * @param {String} field_subtitle Field subtitle selector
         * @param {String} content Content selector
         * @param {String} initial_title Initial title value
         * @param {String} initial_subtitle Initial subtitle value
         * @param {Boolean} optional Is the text optional
         */
        headingText: function(field_title, field_subtitle, content, initial_title, initial_subtitle, optional)
        {
            $(field_title).keyup(function()
            {
                if (this.value.trim().length > 0) {
                    $(content).html(this.value.trim() + ' <small>' +
                        $(field_subtitle).val() + '</small>');

                    preview.changed = true;
                } else {
                    if (optional === true) {
                        $(content).html('');

                        preview.changed = true;
                    } else {
                        $(content).html(initial_title + ' <small>' +
                            $(field_subtitle).val() + '</small>');
                        $(field_title).val(initial_title);
                    }
                }

                preview.unsaved();
            });

            $(field_subtitle).keyup(function()
            {
                if (this.value.trim().length > 0) {
                    $(content).html($(field_title).val() + ' <small>' +
                        this.value.trim() + '</small>');

                    preview.changed = true;
                } else {
                    $(content + ' > small').html('');

                    preview.changed = true;
                }

                preview.unsaved();
            });

            $(field_title).blur(function()
            {
                if (preview.changed === true) {
                    preview.highlight = true;
                    preview.highlightItem(content);
                }
            });

            $(field_subtitle).blur(function()
            {
                if (preview.changed === true) {
                    preview.highlight = true;
                    preview.highlightItem(content);
                }
            });
        },

        /**
         * Update heading tag
         *
         * @param {String} field Field title selector
         * @param {String} content Content selector
         */
        headingType: function(field, content)
        {
            $(field).change(function()
            {
                var tag = $(content)[0].tagName.replace('H', '');
                var heading = $(content).parent().html();

                $(content).
                    parent().
                    html(heading.replace('<h' + tag, '<h' + this.value).
                    replace('</h' + tag, '</h' + this.value));

                preview.changed = true;
                preview.highlight = true;
                preview.highlightItem(content);
                preview.unsaved();
            });
        }
    };
