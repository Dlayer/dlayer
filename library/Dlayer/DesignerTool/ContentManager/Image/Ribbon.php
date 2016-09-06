<?php

/**
 * Image content item ribbon data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Image_Ribbon extends Dlayer_Ribbon_Content
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
			'form' => new Dlayer_Form_Content_Image($tool, $this->contentData(), $this->instancesOfData(), array()),
			'image' => $this->selectedImage()
		);
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
			'version_id' => FALSE,
			'expand' => FALSE,
			'caption' => FALSE
		);

		if($this->tool['content_id'] !== FALSE)
		{
			$model_image = new Dlayer_Model_Page_Content_Items_Image();
			$existing_data = $model_image->existingData($this->tool['site_id'], $this->tool['content_id']);

			if($existing_data !== FALSE)
			{
				$data['version_id'] = intval($existing_data['version_id']);
				$data['expand'] = intval($existing_data['expand']);
				$data['caption'] = $existing_data['caption'];
			}
		}

		return $data;
	}

	/**
	 * Fetch the data for the selected image if the user is in edit mode
	 *
	 * @return array|FALSE
	 */
	private function selectedImage()
	{
		$image = FALSE;

		$session_designer = new Dlayer_Session_Designer();

		if($this->tool['content_id'] !== FALSE && $session_designer->imagePickerCategoryId() !== NULL &&
			$session_designer->imagePickerSubCategoryId() !== NULL &&
			$session_designer->imagePickerImageId() !== NULL &&
			$session_designer->imagePickerCategoryId() !== NULL)
		{
			$model_image = new Dlayer_Model_Page_Content_Items_Image();
			$preview = $model_image->previewImage($this->tool['site_id'], $session_designer->imagePickerImageId(),
				$session_designer->imagePickerVersionId());

			if($preview != FALSE) {
				$image = array(
					'image_id' => $session_designer->imagePickerImageId(),
					'version_id' => $session_designer->imagePickerVersionId(),
					'name' => $preview['name'],
					'dimensions' => $preview['dimensions'],
					'size' => $preview['size'],
					'extension' => $preview['extension']
				);
			}
		}

		return $image;
	}

	/**
	 * Fetch the number of instances for the content items data
	 *
	 * @return integer
	 */
	protected function instancesOfData()
	{
		$instances = 0;

		return $instances;
	}
}
