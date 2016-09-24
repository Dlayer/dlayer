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
			'form' => new Dlayer_DesignerTool_ContentManager_Image_Form($tool, $this->contentData(),
				$this->instancesOfData(), array()), 'image' => $this->selectedImage()
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
			$model_image = new Dlayer_DesignerTool_ContentManager_Image_Model();
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
		$session_designer = new Dlayer_Session_Designer();

		$image = FALSE;
		$from_session = FALSE;

		if($this->tool['content_id'] !== FALSE)
		{
			if($session_designer->imagePickerCategoryId() !== NULL &&
				$session_designer->imagePickerSubCategoryId() !== NULL &&
				$session_designer->imagePickerImageId() !== NULL &&
				$session_designer->imagePickerCategoryId() !== NULL)
			{
				$from_session = TRUE;
			}
			else
			{
				// Set in session
				$model_image = new Dlayer_DesignerTool_ContentManager_Image_Model();
				$libraryProperties = $model_image->imageLibraryParams($this->tool['site_id'], $this->tool['page_id'],
					$this->tool['content_id']);

				if($libraryProperties !== FALSE)
				{
					$session_designer->setImagePickerCategoryId($libraryProperties['category_id']);
					$session_designer->setImagePickerSubCategoryId($libraryProperties['sub_category_id']);
					$session_designer->setImagePickerImageId($libraryProperties['image_id']);
					$session_designer->setImagePickerVersionId($libraryProperties['version_id']);

					$from_session = TRUE;
				}
			}
		}

		if($from_session === TRUE)
		{
			$model_image = new Dlayer_DesignerTool_ContentManager_Image_Model();
			$preview = $model_image->previewImage($this->tool['site_id'], $session_designer->imagePickerImageId(),
				$session_designer->imagePickerVersionId());

			if($preview !== FALSE) {
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
