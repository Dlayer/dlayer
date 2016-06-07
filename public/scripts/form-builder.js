/**
 * Javascript for the Form builder
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
var formBuilder =
{
	backgroundColor: null,

	/**
	 * Attach the movement controls to the form field rows, allows the user to move the form fields up or down
	 *
	 * @return {Void}
	 */
	move: function ()
	{
		var fields = $('.builder-form .field_row');

		fields.each(function (index, field)
		{
			var params = this.id.split(':');

			if (index !== 0)
			{
				$(field).prepend('<div class="btn btn-xs btn-primary btn-block move move-' + params[1] + '" id="up:' +
					params[0] + ':' + params[2] + '">Display sooner</div>');
			}
			if (index !== fields.length - 1)
			{
				$(field).append('<div class="btn btn-xs btn-primary btn-block move move-' + params[1] + '" id="down:' +
					params[0] + ':' + params[2] + '">Display later</div>');
			}
		});

		$('.builder-form .field_row > .move').click(function ()
			{
				$(this).css('background-color', '#505050');
				$(this).css('color', '#ebebeb');

				var params = this.id.split(':');

				window.location.replace('/form/design/move-field/direction/' + params[0] + '/type/' + params[1] +
					'/field-id/' + params[2]);

				return false;
			}
		);
	},

	/**
	 * Selector for form fields, allows a field row to be selected for editing, also shows the movement controls
	 *
	 * @returns {Void}
	 */
	select: function()
	{
		var fieldRow = $('.builder-form .field_row');

		fieldRow.hover(
			function() {
				if($(this).hasClass('selected') === false)
				{
					formBuilder.backgroundColor = $(this).css('background-color');
					$(this).css('background-color', '#e1dc50');
					$(this).css('cursor', 'pointer');
					$(this).find('.move').show();
				}
			},
			function() {
				if($(this).hasClass('selected') === false)
				{
					$(this).css('background-color', formBuilder.backgroundColor);
					$(this).find('.move').hide();
				}
			}
		);
		fieldRow.click(
			function() {
				if($(this).hasClass('selected') === false)
				{
					$(this).css('background-color','#c3be50');

					var params = this.id.split(':');

					window.location.replace('/form/design/set-selected-field/selected/' + params[2] + '/tool/' +
						params[1] + '/type/' + params[0]);
				}
			}
		);
	},

	/**
	 * Toggle the test widths to show what the form will look like at different sizes
	 *
	 * @returns {Void}
	 */
	toggleWidths: function()
	{
		var testWidthButtons = $(".set-form-display-size a");

		testWidthButtons.on("click", function()
		{
			// Update button status
			testWidthButtons.removeClass('btn-primary').addClass('btn-default');
			$(this).addClass('btn-primary');

			// Fetch requested size
			var size = this.id.replace('size-', '');

			$('.builder-form').removeClass('col-md-12 col-md-9 col-md-6 col-md-3').addClass('col-md-' + size);
		});
	},

	/**
	 * Toggle for additional fields in tools
	 *
	 * @return {Void}
	 */
	toggleAdditionalFields: function()
	{
		$('div.form-group-collapsed label').on('click', function()
		{
			var toggle_element = $(this).find('span');
			var field_to_show = '#params-' + toggle_element.attr('id').replace('fgc-', '');

			if(toggle_element.hasClass('glyphicon-plus'))
			{
				toggle_element.removeClass('glyphicon-plus').addClass('glyphicon-minus');

				$(field_to_show).show();
				$(field_to_show).next('p.help-block').show();
			} else {
				toggle_element.removeClass('glyphicon-minus').
				addClass('glyphicon-plus');

				$(field_to_show).hide();
				$(field_to_show).next('p.help-block').hide();
			}
		});
	}
}
