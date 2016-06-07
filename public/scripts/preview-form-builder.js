/**
 * Preview functions for the form builder
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

	/**
	 * Display a message if any data has changed and not yet been saved
	 *
	 * @returns {Void}
	 */
	unsaved: function()
	{
		if(previewFormBuilder.visible === false)
		{
			if(previewFormBuilder.changed === true)
			{
				$('p.unsaved').show('medium');
				previewFormBuilder.visible = true;
			}
		}
	},

	/**
	 * Add a highlight to the item that has just been changed
	 *
	 * @param {String Element selector
	 * @param {Integer} Length for effect, defaults to 500 if not set
	 * @returns {Void}
	 */
	highlightItem: function(selector, time)
	{
		if(typeof time == 'undefined')
		{
			time = 400
		}

		if(previewFormBuilder.highlight === true)
		{
			$(selector).effect("highlight", {}, time);
		}
	},

	/**
	 * Preview function for integer based field attributes, updates the attribute value in on the form as the user
	 * makes changes in the tool
	 *
	 * @param {Integer} Id of the field being edited
	 * @param {String} Field attribute being updated
	 * @param {String} Element attribute that is being updated
	 * @param {String} Initial value for the text string
	 * @param {Boolean} If the value is optional the user should be able to clear the value, shouldn't default to initial value, if not set  defaults to false
	 * @returns {Void}
	 */
	elementAttributeInteger: function (field_id, attribute, field_attribute, value, optional)
	{
		if (typeof optional == 'undefined')
		{
			optional = false
		}

		$('#params-' + attribute).change(function ()
		{
			previewFormBuilder.highlight = true;

			var selector = '#field_' + field_id;
			var new_value = parseInt(this.value, 10);
			var current_value = parseInt($(selector).attr(field_attribute), 10);

			if (new_value !== NaN && current_value !== NaN && new_value !== current_value && new_value > 0)
			{
				$(selector).attr(field_attribute, new_value);
				previewFormBuilder.highlightItem(selector);
				dlayer.preview.changed = true;
			}
			else
			{
				if (optional == false)
				{
					$(selector).attr(field_attribute, value);
					$('#params-' + attribute).val(value);
				}
				else
				{
					$(selector).attr(field_attribute, '');
					$('#params-' + attribute).val('');
					previewFormBuilder.highlightItem(selector);
					previewFormBuilder.changed = true;
				}
			}

			previewFormBuilder.unsaved();
		});
	},

	/**
	 * Preview function for string based field attributes, updates the attribute value in on the form as the user
	 * makes changes in the tool
	 *
	 * @param {Integer} Id of the field being edited
	 * @param {String} Field attribute being updated
	 * @param {String} Element attribute that is being updated
	 * @param {String} Initial value for the text string
	 * @param {Boolean} If the value is optional the user should be able to clear the value, shouldn't default to initial value, if not set defaults to false
	 * @returns {Void}
	 */
	elementAttributeString: function(field_id, attribute, field_attribute, value, optional)
	{
		if(typeof optional == 'undefined')
		{
			optional = false
		}

		$('#params-' + attribute).keyup(function()
		{
			var selector = '#field_' + field_id;
			var current_value = $(selector).attr(field_attribute);

			if(this.value.trim().length > 0 && this.value.trim() !== current_value)
			{
				$(selector).attr(field_attribute, this.value.trim());
				previewFormBuilder.highlightItem(selector, 1500);
				previewFormBuilder.highlight = false;
				previewFormBuilder.changed = true;
			}
			else
			{
				if(this.value.trim().length == 0)
				{
					if(optional == false)
					{
						$(selector).attr(field_attribute, value);
						$('#params-' + attribute).val(value);
					}
					else
					{
						$(selector).attr(field_attribute, '');
						$('#params-' + attribute).val('');
						previewFormBuilder.highlight = true;
						previewFormBuilder.highlightItem(selector);
						previewFormBuilder.changed = true;
					}
				}
			}

			previewFormBuilder.unsaved();
		});

		$('#params-' + attribute).change(function()
		{
			previewFormBuilder.highlight = true;
			var selector = '#field_' + field_id;
			var current_value = $('#field_' + field_id).attr(field_attribute);

			if(this.value.trim().length > 0 && this.value.trim() !== current_value)
			{
				$(selector).attr(field_attribute, this.value.trim());
				previewFormBuilder.highlightItem(selector);
				previewFormBuilder.changed = true;
			}

			previewFormBuilder.unsaved();
		});

		$('#params-' + attribute).blur(function()
		{
			previewFormBuilder.highlight = true;
			var selector = '#field_' + field_id;

			if(previewFormBuilder.changed == true)
			{
				previewFormBuilder.highlightItem(selector);
			}
		});
	},

	/**
	 * Preview function for row background colour, updates the form as the user makes the change in the tool
	 *
	 * @param {Integer} Id of the field being edited
	 * @param {String} Initial value for the background color
	 * @param {Boolean} If the value is optional the user should be able to clear the value, shouldn't default to initial value, if not set defaults to false
	 * @returns {Void}
	 */
	rowBackgroundColor: function(field_id, value, optional)
	{
		if(typeof optional == 'undefined')
		{
			optional = false
		}

		$('#params-background_color').change(function()
		{
			var new_value = this.value;

			if(new_value.length === 7)
			{
				$('.row_' + field_id).css('background-color', new_value);
				previewFormBuilder.changed = true;
			}
			else
			{
				if(new_value.length == 0)
				{
					$('.row_' + field_id).css('background-color', 'inherit');
					previewFormBuilder.changed = true;
				}
			}

			previewFormBuilder.unsaved();
		});
	},

	/**
	 * Preview function for row attributes (label, description etc), updates the value on the form as the user updates the tool
	 *
	 * @param {Integer} Id of the field being edited
	 * @param {String} Field attribute being updated
	 * @param {String} HTML element that is being updated
	 * @param {String} Initial value for the text string
	 * @param {Boolean} If the value is optional the user shouldbe able to clear the value, shouldn't default to initial value, if not set defaults to false
	 * @returns {Void}
	 */
	rowAttribute: function(field_id, attribute, element, value, optional)
	{
		if(typeof optional == 'undefined')
		{
			optional = false
		}

		$('#params-' + attribute).keyup(function()
		{
			var selector = '.row_' + field_id + ' ' + element;
			var current_value = $(selector).text();

			if(this.value.trim().length > 0 && this.value.trim() !== current_value)
			{
				$(selector).html(this.value.trim());
				previewFormBuilder.highlightItem(selector, 1500);
				previewFormBuilder.highlight = false;
				previewFormBuilder.changed = true;
			}
			else
			{
				if(this.value.trim().length == 0)
				{
					if(optional == false)
					{
						$(selector).html(value);
						$('#params-' + attribute).val(value);
					}
					else
					{
						$(selector).html('');
						$('#params-' + attribute).val('');
						previewFormBuilder.highlight = true;
						previewFormBuilder.highlightItem(selector);
						previewFormBuilder.changed = true;
					}
				}
			}

			previewFormBuilder.unsaved();
		});

		$('#params-' + attribute).change(function()
		{
			previewFormBuilder.highlight = true;
			var selector = '.row_' + field_id + ' ' + element;
			var current_value = $(selector).text();

			if(this.value.trim().length > 0 && this.value.trim() !== current_value)
			{
				$(selector).html(this.value.trim());
				previewFormBuilder.highlightItem(selector);
				previewFormBuilder.changed = true;
			}

			previewFormBuilder.unsaved();
		});

		$('#params-' + attribute).blur(function()
		{
			previewFormBuilder.highlight = true;
			var selector = '.row_' + field_id + ' ' + element;

			if(previewFormBuilder.changed === true)
			{
				previewFormBuilder.highlightItem(selector);
			}
		});
	},
}
