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
	protected $tool;

	/**
	 * Fetch the view data for the tool tab, contains an index with the form (pre filled if necessary) and another
	 * with the data required by the live preview functions
	 *
	 * @param array $tool Tool and environment data array
	 * @return array Data array for view
	 */
	public function viewData(array $tool)
	{
		$this->tool = $tool;

		return array('form' => new Dlayer_Form_Content_Text($tool, $this->contentData(), $this->instancesOfData()));
	}

	/**
	 * Fetch the existing data for the content item, always returns  a data array, if not in edit mode the values will
	 * all be FALSE
	 *
	 * @return array
	 */
	protected function contentData()
	{
		$data = array(
			'name' => FALSE,
			'content' => FALSE
		);

		if($this->tool['content_id'] !== NULL)
		{
			$model_text = new Dlayer_Model_Page_Content_Items_Text();
			$existing_data = $model_text->existingData($this->tool['site_id'], $this->tool['content_id']);
			if($existing_data !== FALSE)
			{
				$data['name'] = $existing_data['name'];
				$data['content'] = $existing_data['content'];
			}
		}

		return $data;
	}

	/**
	 * Fetch the number of instances for the content item data
	 *
	 * @return integer
	 */
	protected function instancesOfData()
	{
		$instances = 0;

		if($this->tool['content_id'] !== NULL)
		{
			$model_text = new Dlayer_Model_Page_Content_Items_Text();
			$instances = $model_text->instancesOfData($this->tool['site_id'], $this->tool['content_id']);
		}

		return $instances;
	}
}
