<?php

/**
 * Base ribbon data class for ribbon tools, returns all the data required to generate the tool tab views.
 * The contents of a ribbon data class depend on the tool, the only stipulations being that the tool ribbon class
 * implements the abstract methods
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
abstract class Dlayer_Ribbon_Content
{
	protected $site_id;
	protected $page_id;
	protected $div_id;
	protected $tool;
	protected $tab;
	protected $multi_use;
	protected $edit_mode;
	protected $content_row_id;
	protected $content_id;

	/**
	 * Data method foe the content manager tools, returns the data required
	 * by the view
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param string $tool
	 * @param string $tab
	 * @param integer $multi_use
	 * @param boolean $edit_mode
	 * @param integer|NULL $content_row_id
	 * @param integer|NULL $content_id
	 * @return array|FALSE Either a data array for the tool tab view script or
	 *    FALSE if no data is required
	 */
	abstract public function viewData($site_id, $page_id, $div_id, $tool,
		$tab, $multi_use, $edit_mode = FALSE, $content_row_id = NULL,
		$content_id = NULL);

	/**
	 * Take the supplied params and write their values to the internal
	 * properties
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param string $tool
	 * @param string $tab
	 * @param integer $multi_use
	 * @param boolean $edit_mode
	 * @param integer|NULL $content_row_id
	 * @param integer|NULL $content_id
	 * @return void
	 */
	protected function writeParams($site_id, $page_id, $div_id, $tool, $tab,
		$multi_use, $edit_mode, $content_row_id, $content_id)
	{
		$this->site_id = $site_id;
		$this->page_id = $page_id;
		$this->div_id = $div_id;
		$this->tool = $tool;
		$this->tab = $tab;
		$this->multi_use = $multi_use;
		$this->edit_mode = $edit_mode;
		$this->content_row_id = $content_row_id;
		$this->content_id = $content_id;
	}

	/**
	 * Fetch the data for the content item, the array will either have the
	 * values for the content item if in edit mode or just the keys with
	 * FALSE as the valkue if the tool is in add mode
	 *
	 * @return array
	 */
	abstract protected function contentItem();
}
