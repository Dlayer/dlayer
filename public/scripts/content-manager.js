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
	highlightColor: '#e1dc50',
	clickColor: '#c3be50',

	/**
	 * Add the hover event for the content page and the click event to store session value
	 */
	pageSelector: function()
	{
		var selector = 'div.container-fluid.selectable';

		$(selector).hover(
			function()
			{
				contentManager.pageBackgroundColor = $(this).css('background-color');
				$(this).css('background-color', contentManager.highlightColor);
				$(this).css('cursor', 'pointer');
			},
			function ()
			{
				$(this).css('background-color', contentManager.pageBackgroundColor);
			}
		);
		$(selector).click(
			function(e)
			{
				e.preventDefault();

				$(this).css('background-color', contentManager.clickColor);

				window.location.replace('/content/design/set-page-selected');
			}
		);
	},

	/**
	 * Selector for rows, adds a hover event to change the background colour and then a click event to allow the
	 * row to be selected
	 */
	rowSelector: function()
	{
		var selector = 'div.selected > div.row.selectable';
		var background_color = null;

		$(selector).hover(
			function() {
				background_color = $(this).css('background-color');
				$(this).css('background-color', contentManager.highlightColor);
				$(this).css('cursor', 'pointer');
				$(this).find('div.row-mover').show();
			},
			function() {
				$(this).css('background-color', background_color);
				$(this).find('div.row-mover').hide();
			}
		);
		$(selector).click(
			function() {
				$(this).css('background-color', contentManager.clickColor);

				var id = this.id.replace('row-', '');

				window.location.replace('/content/design/set-selected-row/id/' + id);
			}
		);
	},

	/**
	 * Selector for columns, adds a hover event to change the background colour and then a click event to allow the
	 * column to be selected
	 */
	columnSelector: function()
	{
		var selector = '.row.selected > .column.selectable';
		var background_color = null;

		$(selector).hover(
			function() {
				background_color = $(this).css('background-color');
				$(this).css('background-color', contentManager.highlightColor);
				$(this).css('cursor', 'pointer');
				$(this).find('div.column-mover').show();
			},
			function() {
				$(this).css('background-color', background_color);
				$(this).find('div.column-mover').hide();
			}
		);
		$(selector).click(
			function() {
				$(this).css('background-color', contentManager.clickColor);

				var id = this.id.replace('column-', '');

				window.location.replace('/content/design/set-selected-column/id/' + id);
			}
		);
	},

	/**
	 * Selector for content items, adds a hover event to change the background colour and then a click even to allow the
	 * content item to be selected for editing
	 */
	contentSelector: function()
	{
		var selector = '.column.selected > .content.selectable';
		var background_color = null;

		$(selector).hover(
			function() {
				background_color = $(this).css('background-color');
				$(this).css('background-color', contentManager.highlightColor);
				$(this).css('cursor', 'pointer');
				$('.content-mover-' + $(this).data('content-id')).show();
			},
			function() {
				$(this).css('background-color', background_color);
				$('.content-mover-' + $(this).data('content-id')).hide();
			}
		);
		$(selector).click(
			function() {
				$(this).css('background-color', contentManager.clickColor);

				window.location.replace('/content/design/set-selected-content/id/' +
					$(this).data('content-id') + '/tool/' + $(this).data('tool') + '/content-type/' +
					$(this).data('content-type'));
			}
		);
	},

	/**
	 * Row movement controls, show when a row has the selectable class applied
	 *
	 * @todo UX is currently incorrect for controls, check #127871441 in Pivotal
	 */
	rowMover: function()
	{
		var selector = '.selected div.row.selectable';

		$(selector).each(
			function(index)
			{
				var id = this.id.replace('row-', '');

				if(index !== 0) {
					$(this).prepend(contentManager.moverButton('row-mover', 'up', 'Display sooner', id));
				}
				if(index !== ($(selector).length - 1)) {
					$(this).append(contentManager.moverButton('row-mover', 'down', 'Display later', id));
				}
			}
		);

		$(".row-mover").click(
			function(e) {
				e.stopPropagation();
				window.location.replace('/content/design/move-row/direction/' + $(this).data('move') +
					'/id/' + $(this).data('id'));
			}
		);
	},

	/**
	 * Column movement controls, show when a column has the selectable class applied
	 *
	 * @todo UX is currently incorrect for controls, check #127871441 in Pivotal
	 */
	columnMover: function()
	{
		var selector = '.selected div.column.selectable';

		$(selector).each(
			function(index)
			{
				var id = this.id.replace('column-', '');

				if(index !== 0) {
					$(this).prepend(contentManager.moverButton('column-mover', 'up', 'Display sooner', id));
				}
				if(index !== ($(selector).length - 1)) {
					$(this).append(contentManager.moverButton('column-mover', 'down', 'Display later', id));
				}
			}
		);

		$(".column-mover").click(
			function(e) {
				e.stopPropagation();
				window.location.replace('/content/design/move-column/direction/' + $(this).data('move') +
					'/id/' + $(this).data('id'));
			}
		);
	},

	/**
	 * Content item movement controls, shows when a content items has the selectable class applied to it
	 *
	 * @todo UX is currently incorrect for controls, check #127871441 in Pivotal
	 */
	contentMover: function()
	{
		var selector = 'div.column.selected .content.selectable';

		$(selector).each(
			function(index)
			{
				var id = this.id.split(':');
				id = id[2];

				if(index !== 0) {
					$(this).prepend(contentManager.moverButton('content-mover', 'up', 'Display sooner', id));

				}
				if(index !== ($(selector).length - 1)) {
					$(this).append(contentManager.moverButton('content-mover', 'down', 'Display later', id));
				}
			}
		);

		$(".content-mover").click(
			function(e) {
				e.stopPropagation();
				window.location.replace('/content/design/move-content/direction/' + $(this).data('move') +
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
