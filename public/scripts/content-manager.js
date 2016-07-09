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
		$('div.container-fluid.selectable').hover(
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
		$('div.container-fluid.selectable').click(
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
		var background_color = null;

		$('div.selected > div.row.selectable').hover(
			function() {
				background_color = $(this).css('background-color');
				$(this).css('background-color', '#e1dc50');
				$(this).css('cursor', 'pointer');
			},
			function() {
				$(this).css('background-color', background_color);
			}
		);
		$('div.selected > div.row.selectable').click(
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
		var background_color = null;

		$('.row.selected > .column.selectable').hover(
			function() {
				background_color = $(this).css('background-color');
				$(this).css('background-color', '#e1dc50');
				$(this).css('cursor', 'pointer');
			},
			function() {
				$(this).css('background-color', background_color);
			}
		);
		$('.row.selected > .column.selectable').click(
			function() {
				$(this).css('background-color', '#66a7ba');

				var id = this.id.replace('column-', '');

				window.location.replace('/content/design/set-selected-column/id/' + id);
			}
		);
	},
}
