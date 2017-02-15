/**
 * Base preview code for designers
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
var preview =
    {
        highlight: false,
        changed: false,
        visible: false,
        animateDuration: 800,
        highlightDuration: 400,

        /**
         * Display a message if any data has changed and not yet been saved
         */
        unsaved: function()
        {
            if (previewContentManager.visible === false) {
                if (previewContentManager.changed === true) {
                    $('p.unsaved').show('medium');
                    previewContentManager.visible = true;
                    dlayerDesigner.tabs.reload = true;
                }
            }
        },

        /**
         * Convert new lines to line breaks
         *
         * @param {String} value
         * @returns {XML|string|void}
         */
        nl2br: function(value)
        {
            return value.replace(/\n/g, "<br />");
        },

        /**
         * Add a slight highlight to the item that has just been changed
         *
         * @param {String} selector Element selector
         * @param {Number} effect_length Length for effect, defaults to highlightDuration if not set
         */
        highlightItem: function(selector, effect_length)
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
        setAndAnimateBackgroundColor: function(selector, new_value)
        {
            if (new_value.length === 7) {
                $(selector).animate({'backgroundColor': new_value}, previewContentManager.animateDuration);

                previewContentManager.changed = true;
            }
            else {
                if (new_value.length === 0) {
                    $(selector).css('background-color', 'inherit');
                    previewContentManager.changed = true;
                }
            }

            previewContentManager.unsaved();
        }
    };
