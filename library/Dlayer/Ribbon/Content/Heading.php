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
		return array(
			'name' => FALSE,
			'heading' => FALSE,
			'sub_heading' => FALSE,
			'heading_type' => FALSE
		);
	}

	/**
	 * Fetch the number of instances for the content items data
	 *
	 * @return integer
	 */
	protected function instancesOfData()
	{
		return 0;
	}
}
