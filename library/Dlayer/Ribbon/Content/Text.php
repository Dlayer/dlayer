<?php

/**
 * Text content item ribbon data class, fetches all the data required by the base tool tab
 *
 * @todo Need to extend a base class when we have it working again, also need to add the code for preview mode and editing content items
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Ribbon_Content_Text
{
	/**
	 * Fetch the view data for the tool tab, contains an index with the form (pre filled if necessary) and another
	 * with the data required by the live preview functions
	 *
	 * @param array $tool Tool and environment data array
	 * @return array Data array for view
	 */
	public function viewData(array $tool)
	{
		return array('form' => new Dlayer_Form_Content_Text($tool));
	}
}
