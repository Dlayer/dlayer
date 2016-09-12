/**
 * Dlayer functions usable through out the designers
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
var dlayerDesigner;
dlayerDesigner = {
	/**
	 * Convert a RGB value to a hex value, returns either a valid hex value
	 * or false
	 *
	 * @returns {String|Boolean}
	 */
	rgbToHex: function(colorStr)
	{
		if(colorStr != 'rgba(0, 0, 0, 0)')
		{
			var hex = '#';
			$.each(colorStr.substring(4).split(','), function(i, str)
			{
				var h = ($.trim(str.replace(')', '')) * 1).toString(16);
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
	 */
	colorPicker: {

		element: null,
		rgb: null,
		value: null,

		/**
		 * Start the colour pickers
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
			 * @returns {Boolean}
			 */
			$('.ribbon a.color-picker-clear').click(
				function()
				{
					var element =
						$(this).siblings('.color-picker').attr('id').replace('picker-', '');

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
		 */
		close: function()
		{
			$('.color-picker-tool').slideUp();

			if(dlayerDesigner.colorPicker.value != null)
			{
				$('.ribbon #picker-' + dlayerDesigner.colorPicker.element).css(
					'background-color', dlayerDesigner.colorPicker.rgb);

				$('#' + dlayerDesigner.colorPicker.element).val(
					dlayerDesigner.colorPicker.value).trigger('change');
			}
		},

		/**
		 * Attach the events to the colour picker
		 */
		events: function()
		{
			$('.ribbon .color-picker-tool .close-color-picker').click(
				function()
				{
					dlayerDesigner.colorPicker.close();
				}
			);

			$('.ribbon .color-picker-tool .palette .color').click(
				function()
				{
					dlayerDesigner.colorPicker.rgb =
						$(this).css('background-color');
					dlayerDesigner.colorPicker.value =
						dlayer.fn.rgbToHex($(this).css('background-color'));

					dlayerDesigner.colorPicker.close();
				}
			);

			$('.ribbon .color-picker-tool .history .color').click(
				function()
				{
					dlayerDesigner.colorPicker.rgb =
						$(this).css('background-color');
					dlayerDesigner.colorPicker.value =
						dlayer.fn.rgbToHex($(this).css('background-color'));

					dlayerDesigner.colorPicker.close();
				}
			);

			$('.ribbon .color-picker-tool .custom .color').change(
				function()
				{
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
	 */
	imagePicker: {

		url: '/content/ajax/image-picker',
		method: 'GET',
		dataType: 'html',
		openSelector: ".open-image-picker",
		selector: '.image-picker',

		/**
		 * Start the image picker, adds the on click event to the image picker button
		 */
		start: function()
		{
			$(dlayerDesigner.imagePicker.openSelector).on("click", function()
			{
				$(dlayerDesigner.imagePicker.selector).slideDown();

				$.ajax({
					url: dlayerDesigner.imagePicker.url,
					method: dlayerDesigner.imagePicker.method,
					dataType: dlayerDesigner.imagePicker.dataType
				}).done(function(html)
				{
					dlayerDesigner.imagePicker.populate(html);
				});
			});
		},

		/**
		 * Close the image picker
		 */
		close: function()
		{
			$(dlayerDesigner.imagePicker.selector + " .close").on("click", function()
			{
				$(dlayerDesigner.imagePicker.selector + ' .loading').hide();
				$(dlayerDesigner.imagePicker.selector).slideUp();
			});
		},

		/**
		 * On change fire an Ajax request with the chosen category, posted to the image picker which then sets the
		 * category, if valid, and returns the new state
		 */
		setSelectedCategory: function()
		{
			$(dlayerDesigner.imagePicker.selector + " .category-selector").on("change", function()
			{
				var category_id = $(this).val();

				if(category_id !== 'null')
				{
					$(dlayerDesigner.imagePicker.selector + ' .form').hide();
					$(dlayerDesigner.imagePicker.selector + ' .loading').show();

					$.ajax({
						url: dlayerDesigner.imagePicker.url,
						method: dlayerDesigner.imagePicker.method,
						dataType: dlayerDesigner.imagePicker.dataType,
						data: {
							category_id: category_id
						}
					}).done(function(html)
					{
						dlayerDesigner.imagePicker.populate(html);
					});
				}
			});
		},

		/**
		 * On change fire an Ajax request with the chosen sub category, posted to the image picker which then sets
		 * the sub category, if valid, and returns the new state
		 */
		setSelectedSubCategory: function()
		{
			$(dlayerDesigner.imagePicker.selector + " .sub-category-selector").on("change", function()
			{
				var sub_category_id = $(this).val();

				if(sub_category_id !== 'null')
				{
					$(dlayerDesigner.imagePicker.selector + ' .form').hide();
					$(dlayerDesigner.imagePicker.selector + ' .loading').show();

					$.ajax({
						url: dlayerDesigner.imagePicker.url,
						method: dlayerDesigner.imagePicker.method,
						dataType: dlayerDesigner.imagePicker.dataType,
						data: {
							sub_category_id: sub_category_id
						}
					}).done(function(html)
					{
						dlayerDesigner.imagePicker.populate(html);
					});
				}
			});
		},

		/**
		 * Set the selected image, fires an Ajax request asking for the image id to be set and then returns the
		 * new state with versions being displayed
		 */
		setSelectedImage: function()
		{
			$(dlayerDesigner.imagePicker.selector + " .image-selector").on("click", function()
			{
				var image_id = $(this).data('image-id');

				$(dlayerDesigner.imagePicker.selector + ' .form').hide();
				$(dlayerDesigner.imagePicker.selector + ' .loading').show();

				$.ajax({
					url: dlayerDesigner.imagePicker.url,
					method: dlayerDesigner.imagePicker.method,
					dataType: dlayerDesigner.imagePicker.dataType,
					data: {
						image_id: image_id
					}
				}).done(function(html)
				{
					dlayerDesigner.imagePicker.populate(html);
				});
			});
		},

		/**
		 * Clear the selected category, fires an Ajax request asking for category to be cleared and then returns the
		 * new state of the image picker
		 */
		clearSelectedCategory: function()
		{
			$(dlayerDesigner.imagePicker.selector + " span.clear-selected-category").on("click", function()
			{
				$(dlayerDesigner.imagePicker.selector + ' .form').hide();
				$(dlayerDesigner.imagePicker.selector + ' .loading').show();

				$.ajax({
					url: dlayerDesigner.imagePicker.url,
					method: dlayerDesigner.imagePicker.method,
					dataType: dlayerDesigner.imagePicker.dataType,
					data: {
						category_id: 'clear'
					}
				}).done(function(html)
				{
					dlayerDesigner.imagePicker.populate(html);
				});
			});
		},

		/**
		 * Clear the selected sub category, fires an Ajax request asking for the sub category to be cleared and
		 * then returns the new state of the image picker
		 */
		clearSelectedSubCategory: function()
		{
			$(dlayerDesigner.imagePicker.selector + " span.clear-selected-sub-category").on("click", function()
			{
				$(dlayerDesigner.imagePicker.selector + ' .form').hide();
				$(dlayerDesigner.imagePicker.selector + ' .loading').show();

				$.ajax({
					url: dlayerDesigner.imagePicker.url,
					method: dlayerDesigner.imagePicker.method,
					dataType: dlayerDesigner.imagePicker.dataType,
					data: {
						sub_category_id: 'clear'
					}
				}).done(function(html)
				{
					dlayerDesigner.imagePicker.populate(html);
				});
			});
		},

		/**
		 * Clear the selected image, fires an Ajax request asking for the image to be cleared and then returns the
		 * new state of the image picker
		 */
		clearSelectedImage: function()
		{
			$(dlayerDesigner.imagePicker.selector + " span.clear-selected-image").on("click", function()
			{
				$(dlayerDesigner.imagePicker.selector + ' .form').hide();
				$(dlayerDesigner.imagePicker.selector + ' .loading').show();

				$.ajax({
					url: dlayerDesigner.imagePicker.url,
					method: dlayerDesigner.imagePicker.method,
					dataType: dlayerDesigner.imagePicker.dataType,
					data: {
						image_id: 'clear'
					}
				}).done(function(html)
				{
					dlayerDesigner.imagePicker.populate(html);
				});
			});
		},

		/**
		 * Select the image, sets the image id and version id in the session and updates the related hidden input
		 * and selection preview
		 */
		selectImage: function()
		{
			$(dlayerDesigner.imagePicker.selector + " .version-selector").on("click", function()
			{
				$(dlayerDesigner.imagePicker.selector + ' .form').hide();
				$(dlayerDesigner.imagePicker.selector + ' .loading').show();

				var image_id = $(this).data('image-id');
				var version_id = $(this).data('version-id');

				$.ajax({
					url: '/content/ajax/image-picker-select-image',
					method: dlayerDesigner.imagePicker.method,
					dataType: 'json',
					data: {
						image_id: image_id,
						version_id: version_id
					}
				}).done(function(data)
				{
					dlayerDesigner.imagePicker.finalise(image_id, version_id, data.name, data.dimensions,
						data.size, data.extension);
				});
			});
		},

		/**
		 * Complete the image picker request, passes the set version if to the image pickers corresponding hidden
		 * field updates, updates the class for the select button and populates the preview
		 */
		finalise: function(image_id, version_id, name, dimensions, size, extension)
		{
			$(dlayerDesigner.imagePicker.selector + " .close").trigger('click');

			$(dlayerDesigner.imagePicker.openSelector).text('Image selected');

			$(dlayerDesigner.imagePicker.openSelector).removeClass('btn-danger').addClass('btn-success');

			$('#params-version_id').val(version_id);

			$(".image-picker-preview .name").text(name);
			$(".image-picker-preview .dimensions").text(dimensions);
			$(".image-picker-preview .size").text(size);
			$(".image-picker-preview .image").attr('src', '/images/library/' + image_id + '/' +
				version_id + extension);

			$('.image-picker-preview').show();
		},

		/**
		 * Populate the form, hide the loading indicator and show the form
		 *
		 * @param {String} html
		 */
		populate: function(html)
		{
			$(dlayerDesigner.imagePicker.selector + ' .loading').hide();
			$(dlayerDesigner.imagePicker.selector + ' .form').html(html);
			$(dlayerDesigner.imagePicker.selector + ' .form').show();
		}
	},

	/**
	 * Add the AJAX for the tabs
	 */
	tabs: {

		/**
		 * Add the click events
		 */
		start: function(module, tool)
		{
			$('.ribbon ul.nav-tabs > li').click(function() {

				if($(this).hasClass('active') === false)
				{
					var tab_script = $(this).data('tab-script');
					$('.ribbon ul.nav-tabs > li').removeClass('active');
					$(this).addClass('active');
					$('.ribbon > div.content').removeClass('open');
					$('.ribbon > div.content[data-tab-content="' + tab_script + '"]').addClass('open');

					dlayerDesigner.tabs.load(module, $(this).data('tool'), $(this).data('sub-tool'), tab_script);
				}
			})
		},

		load: function(module, tool, sub_tool, tab_script, reload)
		{
			//if(typeof reload == 'undefined') { reload = false; }

			var data = {
				tool: tool,
				tab_script: tab_script
			};
			(sub_tool.length > 0) ? data.sub_tool = sub_tool: null;

			var uri = '/' + module + '/design/ribbon-tab-html';
			$.post(
				uri,
				data,
				function(data) {
					$('.ribbon > div.content[data-tab-content="' + tab_script + '"]').html(data).addClass('open');
					//$('#color_picker').hide();
					if(reload == true) { window.location.replace('/' + module + '/design/'); }
				},
				'html'
			)
		}
	}
};
