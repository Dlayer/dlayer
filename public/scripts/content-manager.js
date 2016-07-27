/**
 * Javascript for the Content manager
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
var contentManager =
{
	pageBackgroundColor: null,

	/**
	 * Add the hover event for the content page and the click event to store session value
	 *
	 * @returns {Void}
	 */
	pageSelector: function()
	{
		var selector = 'div.container-fluid.selectable';

		$(selector).hover(
			function()
			{
				contentManager.pageBackgroundColor = $(this).css('background-color');
				$(this).css('background-color', '#e1dc50');
				$(this).css('cursor', 'pointer');
			},
			function ()
			{
				$(this).css('background-color', contentManager.pageBackgroundColor);
			}
		);
		$(selector).click(
			function()
			{
				$(this).css('background-color','#c3be50');

				window.location.replace('/content/design/set-page-selected');
			}
		);
	},

	/**
	 * Selector for rows, adds a hover event to change the background colour and then a click event to allow the
	 * row to be selected
	 *
	 * @returns {Void}
	 */
	rowSelector: function()
	{
		var selector = 'div.selected > div.row.selectable';
		var background_color = null;

		$(selector).hover(
			function() {
				background_color = $(this).css('background-color');
				$(this).css('background-color', '#e1dc50');
				$(this).css('cursor', 'pointer');
			},
			function() {
				$(this).css('background-color', background_color);
			}
		);
		$(selector).click(
			function() {
				$(this).css('background-color', '#66a7ba');

				var id = this.id.replace('row-', '');

				window.location.replace('/content/design/set-selected-row/id/' + id);
			}
		);
	},

	/**
	 * Selector for columns, adds a hover event to change the background colour and then a click event to allow the
	 * column to be selected
	 *
	 * @returns {Void}
	 */
	columnSelector: function()
	{
		var selector = '.row.selected > .column.selectable';
		var background_color = null;

		$(selector).hover(
			function() {
				background_color = $(this).css('background-color');
				$(this).css('background-color', '#e1dc50');
				$(this).css('cursor', 'pointer');
			},
			function() {
				$(this).css('background-color', background_color);
			}
		);
		$(selector).click(
			function() {
				$(this).css('background-color', '#66a7ba');

				var id = this.id.replace('column-', '');

				window.location.replace('/content/design/set-selected-column/id/' + id);
			}
		);
	},

	/**
	 * Selector for content items, adds a hover event to change the background colour and then a click even to allow the
	 * content item to be selected for editing
	 *
	 * @returns {Void}
	 */
	contentSelector: function()
	{
		var selector = '.column.selected > .content.selectable';
		var background_color = null;

		$(selector).hover(
			function() {
				background_color = $(this).css('background-color');
				$(this).css('background-color', '#e1dc50');
				$(this).css('cursor', 'pointer');
			},
			function() {
				$(this).css('background-color', background_color);
			}
		);
		$(selector).click(
			function() {
				$(this).css('background-color', '#66a7ba');

				var bits = this.id.split(':');
				var id = bits[2];
				var tool = bits[1];
				var content_type = bits[0];

				window.location.replace('/content/design/set-selected-content/id/' +
					id + '/tool/' + tool + '/content-type/' + content_type);
			}
		);
	}
}
