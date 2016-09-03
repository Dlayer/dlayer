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
	},

	/**
	 * If a user wants to include an image we use the image picker, image picker will check environment to preset its
	 * state
	 *
	 * @returns {Void}
	 */
	imagePicker: {

		url: '/content/ajax/image-picker',
		method: 'GET',
		dataType: 'html',
		selector: '.image-picker',

		/**
		 * Start the image picker, adds the on click event to the image picker button
		 *
		 * @returns {Void}
		 */
		start: function()
		{
			$(".open-image-picker").on("click", function() {
				$(dlayerDesigner.imagePicker.selector).slideDown();

				$.ajax({
					url: dlayerDesigner.imagePicker.url,
					method: dlayerDesigner.imagePicker.method,
					dataType: dlayerDesigner.imagePicker.dataType
				}).done(function(html) {
					$(dlayerDesigner.imagePicker.selector + ' .loading').hide();
					$(dlayerDesigner.imagePicker.selector + ' .form').show();
					$(dlayerDesigner.imagePicker.selector + ' .form').html(html);
				});
			});
		},

		/**
		 * Close the image picker
		 *
		 * @returns {Void}
		 */
		close: function()
		{
			$(".image-picker .close").on("click", function() {
				$('.image-picker').slideUp();
			});
		}
	},

	/**
	 * If a user want to select or modify the selected image the image picker needs to open and query the users
	 * Image library
	 *
	 * @returns {Void}
	 */
	imagePickerOld: {

		url: '/content/ajax/image-picker',
		method: 'GET',
		dataType: 'html',

		/**
		 * Close the image picker
		 *
		 * @returns {Void}
		 */
		close: function()
		{
			$(".image-picker-tool .close-image-picker").on("click",
				function() {
					$('.image-picker-tool').hide();
				}
			);
		},

		/**
		 * Cancel the request, clears the hidden field and resets the
		 * select image button and clears any preview
		 *
		 * @returns {Void}
		 */
		cancel: function()
		{
			$(".open-image-picker").text('Select image');

			$(".open-image-picker").
			removeClass('btn-success').
			addClass('btn-danger');

			$('#params-version_id').val('');

			$('.ipp-name').text('[Name]');
			$('.ipp-dimensions').text('[Dimensions]');
			$('.ipp-size').text('[Size]');
			$('.ipp-image').attr('src',
				'/images/dlayer/image-picker-preview.jpg');

			$('.image-picker-preview').hide();
		},

		/**
		 * When a user selects the clear category link the base AJAX
		 * request is made with the category id set to 'clear', the request
		 * will clear the category, sub category, image and image
		 * version ids
		 *
		 * @returns {Void}
		 */
		clearCategory: function()
		{
			$("span.clear-image-picker-category").on("click", function() {
				$('.image-picker-tool').show();

				$.ajax({
					url: dlayer.fn.imagePicker.url,
					method: dlayer.fn.imagePicker.method,
					data: { category_id: 'clear' },
					dataType: dlayer.fn.imagePicker.dataType
				}).done(function(html) {
					$('.image-picker-tool .loading').hide();
					dlayer.fn.imagePicker.cancel();
					$('.image-picker-tool .form').html(html);
				});
			});
		},

		/**
		 * When a user selects the clear sub category link the base AJAX
		 * request is made with the sub category id set to 'clear', the
		 * request will clear the sub category, image and image version ids
		 *
		 * @returns {Void}
		 */
		clearSubCategory: function()
		{
			$("span.clear-image-picker-sub-category").on("click", function() {
				$('.image-picker-tool').show();

				$.ajax({
					url: dlayer.fn.imagePicker.url,
					method: dlayer.fn.imagePicker.method,
					data: { sub_category_id: 'clear' },
					dataType: dlayer.fn.imagePicker.dataType
				}).done(function(html) {
					$('.image-picker-tool .loading').hide();
					dlayer.fn.imagePicker.cancel();
					$('.image-picker-tool .form').html(html);
				});
			});
		},

		/**
		 * When a user selects the clear image link the base AJAX request is
		 * made with the image id set to 'clear', the request will clear
		 * the image and image version ids
		 *
		 * @returns {Void}
		 */
		clearImage: function()
		{
			$("span.clear-image-picker-image").on("click", function() {
				$('.image-picker-tool').show();

				$.ajax({
					url: dlayer.fn.imagePicker.url,
					method: dlayer.fn.imagePicker.method,
					data: { image_id: 'clear' },
					dataType: dlayer.fn.imagePicker.dataType
				}).done(function(html) {
					$('.image-picker-tool .loading').hide();
					dlayer.fn.imagePicker.cancel();
					$('.image-picker-tool .form').html(html);
				});
			});
		},

		/**
		 * Complete the image picker request, passes the selected version
		 * id to the image pickers hidden field updates the select image
		 * button and populates the preview section with the selected image
		 * and version
		 *
		 * @param {Integer} Image id
		 * @param {Integer} Version id
		 * @param {String} Name of the selected image
		 * @param {String} Dimesions of the selected image
		 * @param {String} Size of the selected image
		 * @param {String} Extension for the selected image
		 * @returns {Void}
		 */
		complete: function(image_id, version_id, name, dimensions, size,
		                   extension)
		{
			$('.image-picker-tool .close-image-picker').trigger('click');

			$(".open-image-picker").text('Image selected');

			$(".open-image-picker").
			removeClass('btn-danger').
			addClass('btn-success');

			$('#params-version_id').val(version_id);

			$('.ipp-name').text(name);
			$('.ipp-dimensions').text(dimensions);
			$('.ipp-size').text(size);
			$('.ipp-image').attr('src', '/images/library/' + image_id + '/' +
				version_id + extension);

			$('.image-picker-preview').show();
		},

		/**
		 * Start the image picker, adds the on click event to the image picker button and on click sends the Ajax
		 * request
		 *
		 * @returns {Void}
		 */
		start: function()
		{
			$(".open-image-picker").on("click", function()
			{
				$('.image-picker-tool').slideDown();

				/*$.ajax({
					url: dlayer.fn.imagePicker.url,
					method: dlayer.fn.imagePicker.method,
					dataType: dlayer.fn.imagePicker.dataType
				}).done(function(html) {
					$('.image-picker-tool .loading').hide();
					$('.image-picker-tool .form').show();
					$('.image-picker-tool .form').html(html);
				});*/
			});
		},

		/**
		 * When a user selects an image the image and image version id are
		 * set in the session and then the image picker is closed
		 *
		 * @returns {Void}
		 */
		selectImage: function()
		{
			$(".ip-select-image").on("click", function() {

				var ids = this.id.replace('ip-image-', '');
				ids = ids.split(':');

				var image_id = ids[0];
				var version_id = ids[1];

				$('.image-picker-tool .loading').show();
				$('.image-picker-tool .form').hide();

				$.ajax({
					url: '/content/ajax/image-picker-select-image',
					method: dlayer.fn.imagePicker.method,
					data: {
						image_id: image_id,
						version_id: version_id
					},
					dataType: 'json'
				}).done(function(data) {
					dlayer.fn.imagePicker.complete(image_id, version_id,
						data.name, data.dimensions, data.size,
						data.extension);
				});
			});
		},

		/**
		 * When a user selects a category the base AJAX request is made with
		 * the category set to the chosen value, the AJAX will then return
		 * showing the sub categories
		 *
		 * @returns {Void}
		 */
		setCategory: function()
		{
			$("#ip-category").on("change", function() {

				var category_id = $('#ip-category').val();

				if(category_id != 'null') {
					$('.image-picker-tool').show();

					$.ajax({
						url: dlayer.fn.imagePicker.url,
						method: dlayer.fn.imagePicker.method,
						data: { category_id: category_id },
						dataType: dlayer.fn.imagePicker.dataType
					}).done(function(html) {
						$('.image-picker-tool .loading').hide();
						$('.image-picker-tool .form').html(html);
					});
				}
			});
		},

		/**
		 * When the user selects a sub category the base AJAX is called with
		 * the selected sub category id, the AJAX will return either the
		 * images for that category or all the images if the 'all' sub
		 * category was selected
		 *
		 * @returns {Void}
		 */
		setSubCategory: function()
		{
			$("#ip-sub-category").on("change", function() {

				var sub_category_id = $('#ip-sub-category').val();

				if(sub_category_id != 'null') {
					$('.image-picker-tool').show();

					$.ajax({
						url: dlayer.fn.imagePicker.url,
						method: dlayer.fn.imagePicker.method,
						data: { sub_category_id: sub_category_id },
						dataType: dlayer.fn.imagePicker.dataType
					}).done(function(html) {
						$('.image-picker-tool .loading').hide();
						$('.image-picker-tool .form').html(html);
					});
				}
			});
		},

		/**
		 * When the user selects an image the base AJAX is called with the
		 * image id set, the AJAX returns with all the versions of the
		 * selected image.
		 *
		 * This method is only called when the image has versions
		 *
		 * @returns {Void}
		 */
		setImage: function()
		{
			$(".ip-image").on("click", function() {

				var image_id = this.id.replace('ip-set-image-', '');

				$('.image-picker-tool').show();

				$.ajax({
					url: dlayer.fn.imagePicker.url,
					method: dlayer.fn.imagePicker.method,
					data: { image_id: image_id },
					dataType: dlayer.fn.imagePicker.dataType
				}).done(function(html) {
					$('.image-picker-tool .loading').hide();
					$('.image-picker-tool .form').html(html);
				});
			});
		}
	}
}
