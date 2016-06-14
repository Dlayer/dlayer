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

				// Hack to set rows and columns to transparent, fix later
				//$('div.content-fluid div.row').css('background-color', 'transparent');
				//$('div.content-manager > div.content-fluid div.col-lg-9').css('background-color', 'transparent');
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
	}
}
