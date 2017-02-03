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
                    $(this).find('div.field-mover').show();
                },
                function()
                {
                    $(this).css('background-color', background_color);
                    $(this).find('div.field-mover').hide();
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
        },

        /**
         * Field movement controls
         */
        fieldMover: function()
        {
            var selector = 'div.field_row';

            $(selector).each(
                function(index)
                {
                    var id = $(this).data('id');

                    if(index !== 0)
                    {
                        $(this).prepend(formBuilder.moverButton('field-mover', 'up', 'Display sooner', id));
                    }
                    if(index !== ($(selector).length - 1))
                    {
                        $(this).append(formBuilder.moverButton('field-mover', 'down', 'Display later', id));
                    }
                }
            );

            $(".field-mover").click(
                function(e)
                {
                    e.stopPropagation();
                    window.location.replace('/form/design/move/direction/' + $(this).data('move') +
                        '/id/' + $(this).data('id'));
                }
            );
        },

        /**
         * Generate the html for the movement controls
         *
         * @param moverClass Class for div
         * @param direction Direction of movement
         * @param text Text for button
         * @param id Id of the item being moved
         * @return {string}
         */
        moverButton: function(moverClass, direction, text, id)
        {
            return '<div class="' + moverClass + ' ' + moverClass + '-' + id + '" data-move="' + direction +
                '" data-id="' + id + '">' + text + '</div>';
        }
    };
