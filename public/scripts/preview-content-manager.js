/**
 * Preview functions for the Content manager
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
var previewContentManager =
{
    highlight: false,
    changed: false,
    visible: false,
    animateDuration: 800,
    highlightDuration: 400,

    /**
     * Display a message if any data has changed and not yet been saved
     */
    unsaved: function ()
    {
        if (previewContentManager.visible === false) {
            if (previewContentManager.changed === true) {
                $('p.unsaved').show('medium');
                previewContentManager.visible = true;
            }
        }
    },

    /**
     * Add a slight highlight to the item that has just been changed
     *
     * @param {String} selector Element selector
     * @param {Number} effect_length Length for effect, defaults to highlightDuration if not set
     */
    highlightItem: function (selector, effect_length)
    {
        if (typeof effect_length == 'undefined') {
            effect_length = previewContentManager.highlightDuration;
        }

        if (previewContentManager.highlight === true) {
            $(selector).effect("highlight", {}, effect_length);
        }
    },

    /**
     * Set an animate the new background color
     *
     * @param {String} selector
     * @param {String} new_value
     */
    setAndAnimateBackgroundColor: function (selector, new_value)
    {
        if (new_value.length === 7) {
            $(selector).animate({'backgroundColor': new_value}, previewContentManager.animateDuration);

            previewContentManager.changed = true;
        } else {
            if (new_value.length === 0) {
                $(selector).css('background-color', 'inherit');
                previewContentManager.changed = true;
            }
        }

        previewContentManager.unsaved();
    },

    /**
     * Preview function for an elements background color, updates the item with the passed in value
     *
     * @param {Number} content_id Id of the content item
     * @param {String} value The background color to set
     */
    contentItemBackgroundColor: function (content_id, value)
    {
        $('#params-content_background_color').change(function ()
        {
            var new_value = this.value;
            var selector = '.content[data-content-id="' + content_id + '"]';

            previewContentManager.setAndAnimateBackgroundColor(selector, new_value);
        });
    },

    /**
     * Background colour preview, column
     *
     * @param {Number} column_id Id of the column
     * @param {String} value The background color to set
     */
    columnBackgroundColor: function (column_id, value)
    {
        $('#params-background_color').change(function ()
        {
            var new_value = this.value;
            var selector = '.column[data-column-id="' + column_id + '"]';

            previewContentManager.setAndAnimateBackgroundColor(selector, new_value);
        });
    },

    /**
     * Background colour preview, row
     *
     * @param {Number} row_id Id of the row
     * @param {String} value The background color to set
     */
    rowBackgroundColor: function (row_id, value)
    {
        $('#params-background_color').change(function ()
        {
            var new_value = this.value;
            var selector = '.row[data-row-id="' + row_id + '"]';

            previewContentManager.setAndAnimateBackgroundColor(selector, new_value);

        });
    },

    /**
     * Background colour preview, page
     *
     * @param {String} value The background color to set
     */
    pageBackgroundColor: function (value)
    {
        $('#params-background_color').change(function ()
        {
            var new_value = this.value;
            var selector = '.container-fluid.selected';

            previewContentManager.setAndAnimateBackgroundColor(selector, new_value);
        });
    },

    /**
     * Font family for a content item
     *
     * @param {Number} content_id Id of the content item
     * @param {Array} font_families The font families supported by the system
     */
    contentItemFontFamily: function (content_id, font_families)
    {
        $('#params-font_family_id').change(function ()
        {
            var selector = '.content[data-content-id="' + content_id + '"]';

            if ($(this).val() in font_families) {
                $(selector).css('font-family', font_families[$(this).val()]);

                previewContentManager.changed = true;
            }

            previewContentManager.unsaved();
        });
    }
};
