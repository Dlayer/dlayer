<?php

/**
 * Import form ribbon data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Form_Ribbon extends Dlayer_Ribbon_Content
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
			'form' => new Dlayer_Form_Content_Form($tool, $this->contentData(), $this->instancesOfData(),
				$this->elementData())
		);
	}

	/**
	 * Fetch any data required to build the elements
	 *
	 * @return array
	 */
	protected function elementData()
	{
		$data = array();

		$model_form = new Dlayer_Model_Page_Content_Items_Form();
		$forms = $model_form->forms($this->tool['site_id']);

		if(count($forms) > 0)
		{
			$data['forms'] = $forms;
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
			'form_id' => FALSE
		);

		if($this->tool['content_id'] !== FALSE)
		{
			$model_form = new Dlayer_Model_Page_Content_Items_Form();
			$form_id = $model_form->existingData($this->tool['site_id'], $this->tool['content_id']);

			if($form_id !== FALSE)
			{
				$data['form_id'] = $form_id;
			}
		}

		return $data;
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
