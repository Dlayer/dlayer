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
			function(e) {
				$(this).css('background-color', contentManager.clickColor);

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
			function(e) {
				$(this).css('background-color', contentManager.clickColor);

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
				$(this).css('background-color', contentManager.highlightColor);
				$(this).css('cursor', 'pointer');
				var id = $(this).data('content-id');
				$('.content-mover-' + id).show();
			},
			function() {
				$(this).css('background-color', background_color);
				var id = $(this).data('content-id');
				$('.content-mover-' + id).hide();
			}
		);
		$(selector).click(
			function(e) {
				$(this).css('background-color', contentManager.clickColor);

				var bits = this.id.split(':');
				var id = bits[2];
				var tool = bits[1];
				var content_type = bits[0];

				window.location.replace('/content/design/set-selected-content/id/' +
					id + '/tool/' + tool + '/content-type/' + content_type);
			}
		);
	},

	/**
	 * Row movement controls, show when a row has the selectable class applied
	 *
	 * @todo UX is currently incorrect for controls, check #127871441 in Pivotal
	 * @return {Void}
	 */
	rowMover: function()
	{
		var selector = '.selected div.row.selectable';

		$(selector).each(
			function(index)
			{
				var id = this.id.replace('row-', '');

				if(index !== 0) {
					$(this).prepend('<div class="row-mover" id="up:' + id + '">Display sooner</div>');
				}
				if(index !== ($(selector).length - 1)) {
					$(this).append('<div class="row-mover" id="down:' + id + '">Display later</div>');
				}
			}
		);

		$(".row-mover").click(
			function(e) {
				e.stopPropagation();
				var params = this.id.split(':');
				window.location.replace('/content/design/move-row/direction/' + params[0] + '/id/' + params[1]);
			}
		);
	},

	/**
	 * Column movement controls, show when a column has the selectable class applied
	 *
	 * @todo UX is currently incorrect for controls, check #127871441 in Pivotal
	 * @return {Void}
	 */
	columnMover: function()
	{
		var selector = '.selected div.column.selectable';

		$(selector).each(
			function(index)
			{
				var id = this.id.replace('column-', '');

				if(index !== 0) {
					$(this).prepend('<div class="column-mover" id="up:' + id + '">Display sooner</div>');
				}
				if(index !== ($(selector).length - 1)) {
					$(this).append('<div class="column-mover" id="down:' + id + '">Display later</div>');
				}
			}
		);

		$(".column-mover").click(
			function(e) {
				e.stopPropagation();
				var params = this.id.split(':');
				window.location.replace('/content/design/move-column/direction/' + params[0] + '/id/' + params[1]);
			}
		);
	},

	/**
	 * Content item movement controls, shows when a content items has the selectable class applied to it
	 *
	 * @todo UX is currently incorrect for controls, check #127871441 in Pivotal
	 * @return {Void}
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
					$(this).prepend('<div class="content-mover content-mover-' + id + '" data-move="up" data-content-id="' + id + '">Display sooner</div>');
				}
				if(index !== ($(selector).length - 1)) {
					$(this).append('<div class="content-mover content-mover-' + id + '" data-move="down" data-content-id="' + id + '">Display later</div>');
				}
			}
		);

		$(".content-mover").click(
			function(e) {
				e.stopPropagation();
				window.location.replace('/content/design/move-content/direction/' + $(this).data('move') + '/id/' + $(this).data('content-id'));
			}
		);
	}
}
