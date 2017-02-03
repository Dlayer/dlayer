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
        },

        /**
         * Update an element attribute
         *
         * @param {String} element Element to attach event to
         * @param {String} field_id Field selector
         * @param {String} attribute Attribute
         * @param {String} initial_value Initial value
         * @param {Boolean} optional Is the value optional
         */
        attributeValue: function(element, field_id, attribute, initial_value, optional)
        {
            var selector = '#field_' + field_id;

            $(element).bind("keyup change", function()
            {
                if (this.value.trim().length > 0) {
                    if (this.value.trim() !== initial_value) {
                        $(selector).attr(attribute, this.value.trim());

                        previewFormBuilder.changed = true;
                    }
                } else {
                    if (optional === true) {
                        $(selector).removeAttr(attribute);

                        previewFormBuilder.changed = true;
                    } else {
                        $(selector).attr(attribute, initial_value);
                        $(element).val(initial_value);
                    }
                }

                previewFormBuilder.unsaved();
            });

            $(element).blur(function()
            {
                if (previewFormBuilder.changed === true) {
                    previewFormBuilder.highlight = true;
                    previewFormBuilder.highlightItem(selector);
                }
            });
        },

        /**
         * Update an element attribute
         *
         * @param {String} element Element to attach event to
         * @param {String} field_id Field selector
         * @param {String} ui_element The UI element to change
         * @param {String} initial_value Initial value
         * @param {Boolean} nl2br Apply nl2br
         * @param {Boolean} optional Is the value optional
         */
        elementValue: function(element, field_id, ui_element, initial_value, nl2br, optional)
        {
            $(element).bind("keyup change", function()
            {
                if (this.value.trim().length > 0) {
                    if (this.value.trim() !== initial_value) {
                        if (nl2br === true) {
                            $(ui_element).html(previewFormBuilder.nl2br(this.value.trim()));
                        } else {
                            $(ui_element).html(this.value.trim());
                        }

                        previewFormBuilder.changed = true;
                    }
                } else {
                    if (optional === true) {
                        $(ui_element).html("");

                        previewFormBuilder.changed = true;
                    } else {
                        $(ui_element).html(initial_value);
                        $(element).val(initial_value);
                    }
                }

                previewFormBuilder.unsaved();
            });

            $(element).blur(function()
            {
                if (previewFormBuilder.changed === true) {
                    previewFormBuilder.highlight = true;
                    previewFormBuilder.highlightItem(ui_element);
                }
            });
        }
    };
