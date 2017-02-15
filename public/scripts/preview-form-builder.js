/**
 * Preview functions for the Form Builder
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
var previewFormBuilder =
    {
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

                preview.setAndAnimateBackgroundColor(selector, new_value);
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

                        preview.changed = true;
                    }
                } else {
                    if (optional === true) {
                        $(selector).removeAttr(attribute);

                        previewForm.changed = true;
                    } else {
                        $(selector).attr(attribute, initial_value);
                        $(element).val(initial_value);
                    }
                }

                preview.unsaved();
            });

            $(element).blur(function()
            {
                if (preview.changed === true) {
                    preview.highlight = true;
                    preview.highlightItem(selector);
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
                            $(ui_element).html(preview.nl2br(this.value.trim()));
                        } else {
                            $(ui_element).html(this.value.trim());
                        }

                        preview.changed = true;
                    }
                } else {
                    if (optional === true) {
                        $(ui_element).html("");

                        preview.changed = true;
                    } else {
                        $(ui_element).html(initial_value);
                        $(element).val(initial_value);
                    }
                }

                preview.unsaved();
            });

            $(element).blur(function()
            {
                if (preview.changed === true) {
                    preview.highlight = true;
                    preview.highlightItem(ui_element);
                }
            });
        }
    };
