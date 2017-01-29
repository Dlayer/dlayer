/**
 * Javascript for the Form Builder
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
var formBuilder =
    {
        highlightColor: '#e1dc50',
        clickColor: '#c3be50',

        /**
         * Selector for form fields, add a hover event to change the background colour and then a click event to allow
         * the field to be selected for editing
         */
        fieldSelector: function()
        {
            var selector = 'div.field_row';
            var background_color = null;

            $(selector).hover(
                function()
                {
                    background_color = $(this).css('background-color');
                    $(this).css('background-color', formBuilder.highlightColor);
                    $(this).css('cursor', 'pointer');
                },
                function()
                {
                    $(this).css('background-color', background_color);
                }
            );
            $(selector).click(
                function()
                {
                    $(this).css('background-color', formBuilder.clickColor);

                    window.location.replace('/form/design/set-selected-field/id/' +
                        $(this).data('id') + '/tool/' + $(this).data('tool'));
                }
            );
        }
    };
