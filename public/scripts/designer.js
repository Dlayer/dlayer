/**
* Dlayer functions usable through out the designers
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
var dlayerDesigner =
{
	/**
	* Convert a RGB value to a hex value, returns either a valid hex value
	* or false
	*
	* @returns {String|false}
	*/
	rgbToHex: function(colorStr)
	{
		if(colorStr != 'rgba(0, 0, 0, 0)')
		{
			var hex = '#';
			$.each(colorStr.substring(4).split(','), function(i, str){
				var h = ($.trim(str.replace(')',''))*1).toString(16);
				hex += (h.length == 1) ? "0" + h : h;
			});
		}
		else
		{
			hex = false;
		}

		return hex;
	},

	/**
	* If a user selects a colour input the colour picker opens allowing
	* the m to pick a couolor either from their palettes, there history or
	* by choosing a manual colour
	*
	* The colour picker may need to be called multiple times within a view,
	* the picker itself is universal, when opened it stores the id of the
	* element that invoked it and sets the value to a hidden field
	*
	* @returns {Void}
	*/
	colorPicker: {

		element: null,
		rgb: null,
		value: null,

		/**
		* Start the colour pickers
		*
		* @returns {Void}
		*/
		start: function()
		{
			/**
			* Add a click event to any relevant input so open the picker,
			* displays the picker, sets the element var to the id of the element
			* that opened it and the clears any existing set values from other
			* instances of the picker
			*
			* The picker can only be active for one element at a time
			*/
			$('.ribbon .color-picker').click(
				function()
				{
					$('.color-picker-tool').slideDown();

					dlayerDesigner.colorPicker.value = null;
					dlayerDesigner.colorPicker.element = this.id.replace('picker-', '');
				}
			);

			/**
			* Attach a click even for the clear links. Each colour input will
			* have a clear link that closes the picker, resets any vars and then
			* resets the picker field
			*
			* @returns {false}
			*/
			$('.ribbon a.color-picker-clear').click(
				function() {
					var element =
					$(this).siblings('.color-picker').attr('id').
						replace('picker-', '');

					$('.ribbon #picker-' + element).css(
						'background-color', 'inherit');
					$('#' + element).val('').trigger('change');

					return false;
				}
			);
		},

		/**
		* Close the colour picker and set the value of the picker element
		* and hidden element to the value selected
		*
		* @returns {Void}
		*/
		close: function()
		{
			$('.color-picker-tool').slideUp();

			if(dlayerDesigner.colorPicker.value != null) {
				$('.ribbon #picker-' + dlayerDesigner.colorPicker.element).css(
					'background-color', dlayerDesigner.colorPicker.rgb);

				$('#' + dlayerDesigner.colorPicker.element).val(
					dlayerDesigner.colorPicker.value).trigger('change');
			}
		},

		/**
		* Attach the events to the colour picker
		*
		* @returns {Void}
		*/
		events: function()
		{
			$('.ribbon .color-picker-tool .close-color-picker').click(
				function() {
					dlayerDesigner.colorPicker.close();
				}
			);

			$('.ribbon .color-picker-tool .palette .color').click(
				function() {
					dlayerDesigner.colorPicker.rgb =
						$(this).css('background-color');
					dlayerDesigner.colorPicker.value =
						dlayer.fn.rgbToHex($(this).css('background-color'));

					dlayerDesigner.colorPicker.close();
				}
			);

			$('.ribbon .color-picker-tool .history .color').click(
				function() {
					dlayerDesigner.colorPicker.rgb =
						$(this).css('background-color');
					dlayerDesigner.colorPicker.value =
						dlayer.fn.rgbToHex($(this).css('background-color'));

					dlayerDesigner.colorPicker.close();
				}
			);

			$('.ribbon .color-picker-tool .custom .color').change(
				function() {
					dlayerDesigner.colorPicker.rgb = $(this).val();
					dlayerDesigner.colorPicker.value = $(this).val();

					dlayerDesigner.colorPicker.close();
				}
			);
		}
	}
}
