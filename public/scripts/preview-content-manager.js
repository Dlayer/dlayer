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
    animateDuration: 600,
    hightlightDuration: 400,

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
     * @param {Number} effect_length Length for effect, defaults to hightlightDuration if not set
     */
    highlightItem: function (selector, effect_length)
    {
        if (typeof effect_length == 'undefined') {
            effect_length = previewContentManager.hightlightDuration;
        }

        if (previewContentManager.highlight === true) {
            $(selector).effect("highlight", {}, effect_length);
        }
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

            if (new_value.length === 7) {
                $(selector).animate({'backgroundColor': new_value}, previewContentManager.animateDuration);

                previewContentManager.changed = true;
            } else {
                if (new_value.length == 0) {
                    $(selector).css('background-color', 'inherit');
                    previewContentManager.changed = true;
                }
            }

            previewContentManager.unsaved();
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

            if (new_value.length === 7) {
                $(selector).animate({'backgroundColor': new_value}, previewContentManager.animateDuration);

                previewContentManager.changed = true;
            } else {
                if (new_value.length == 0) {
                    $(selector).css('background-color', 'inherit');
                    previewContentManager.changed = true;
                }
            }

            previewContentManager.unsaved();
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

            if (new_value.length === 7) {
                $(selector).animate({'backgroundColor': new_value}, previewContentManager.animateDuration);

                previewContentManager.changed = true;
            } else {
                if (new_value.length == 0) {
                    $(selector).css('background-color', 'inherit');
                    previewContentManager.changed = true;
                }
            }

            previewContentManager.unsaved();
        });
    }
};
