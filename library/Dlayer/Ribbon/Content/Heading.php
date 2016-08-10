<?php

/**
 * Text content item ribbon data class, fetches all the data required by the base tool tab
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Ribbon_Content_Heading extends Dlayer_Ribbon_Content
{

	/**
	 * Fetch the view data for the current tool tab, typically the returned array will have at least two indexes,
	 * one for the form and another with the data required by the preview functions
	 *
	 * @param array $tool Tool and environment data
	 * @return array
	 */
	public function viewData(array $tool)
	{
		$this->tool = $tool;

		return array(
			'form' => new Dlayer_Form_Content_Heading($tool, $this->contentData(), $this->instancesOfData(),
				$this->elementData())
		);
	}

	/**
	 * fetch the data required to build the elements
	 *
	 * @return array
	 */
	protected function elementData()
	{
		$data = array();

		$model_settings = new Dlayer_Model_Settings();
		$heading_types = $model_settings->headingTypes();

		if(count($heading_types) > 0)
		{
			$data['heading_type'] = $heading_types;
		}

		return $data;
	}

	/**
	 * Fetch the data array for the content item, if in edit mode mode populate the values otherwise every value is
	 * set to FALSE, the tool form can simply check to see if the value is FALSe or not and then set the existing value
	 *
	 * @return array
	 */
	protected function contentData()
	{
		$data = array(
			'name' => FALSE,
			'heading' => FALSE,
			'sub_heading' => FALSE,
			'heading_type' => FALSE
		);

		if($this->tool['content_id'] !== NULL)
		{
			$model_heading = new Dlayer_Model_Page_Content_Items_Heading();
			$existing_data = $model_heading->existingData($this->tool['site_id'], $this->tool['content_id']);

			if($existing_data !== FALSE)
			{
				$heading = FALSE;
				$sub_heading = FALSE;
				$content_bits = explode(Dlayer_Config::CONTENT_DELIMITER, $existing_data['content']);
				switch(count($content_bits))
				{
					case 2:
						$heading = $content_bits[0];
						$sub_heading = $content_bits[1];
					break;

					case 1:
						$heading = $content_bits[0];
					break;
				}

				$data['name'] = $existing_data['name'];
				$data['heading'] = $heading;
				$data['sub_heading'] = $sub_heading;
				$data['heading_type'] = intval($existing_data['heading_id']);
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
			$model_text = new Dlayer_Model_Page_Content_Items_Heading();
			$instances = $model_text->instancesOfData($this->tool['site_id'], $this->tool['content_id']);
		}

		return $instances;
	}
}
