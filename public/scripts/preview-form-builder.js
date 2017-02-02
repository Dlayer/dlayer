/**
 * Preview functions for the Form Builder
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
var previewFormBuilder =
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
            if (previewFormBuilder.visible === false) {
                if (previewFormBuilder.changed === true) {
                    $('p.unsaved').show('medium');
                    previewFormBuilder.visible = true;
                }
            }
        },

        /**
         * Convert new lines to line breaks
         *
         * @param {String} value
         * @returns {XML|string|void}
         */
        nl2br: function (value)
        {
            return value.replace(/\n/g, "<br />");
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
                effect_length = previewFormBuilder.highlightDuration;
            }

            if (previewFormBuilder.highlight === true) {
                $(selector).effect("highlight", {}, effect_length);
            }
        },

        /**
         * Set and animate the new background color
         *
         * @param {String} selector
         * @param {String} new_value
         */
        setAndAnimateBackgroundColor: function (selector, new_value)
        {
            if (new_value.length === 7) {
                $(selector).animate({'backgroundColor': new_value}, previewFormBuilder.animateDuration);

                previewFormBuilder.changed = true;
            }
            else {
                if (new_value.length === 0) {
                    $(selector).css('background-color', 'inherit');
                    previewFormBuilder.changed = true;
                }
            }

            previewFormBuilder.unsaved();
        },

        /**
         * Preview function for an field rows background color
         *
         * @param {Number} field_id Id of the field
         * @param {String} value The background color to set
         */
        rowBackgroundColor: function (field_id, value)
        {
            $('#params-row_background_color').change(function ()
            {
                var new_value = this.value;
                var selector = '.field_row[data-id="' + field_id + '"]';

                previewFormBuilder.setAndAnimateBackgroundColor(selector, new_value);
            });
        }
    };
