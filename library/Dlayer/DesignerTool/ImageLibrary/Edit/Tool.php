<?php

/**
 * Edit base library details
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ImageLibrary_Edit_Tool extends Dlayer_Tool_Module_Image
{
	/**
	 * Add a new image to the library, validates data and image and then
	 * creates a thubnail for the library view
	 *
	 * @return array image id and version id for the newly added image, user is
	 *               sent to the detail page afer uploading an image
	 */
	public function process()
	{
		if($this->validated == TRUE)
		{
			$this->editImage();
		}

		return array(
			'multiple' => '', 'ids' => array(
				array(
					'id' => $this->image_id,
					'type' => Dlayer_Session_Image::IMAGE,
				), array(
					'id' => $this->version_id, 'type' => Dlayer_Session_Image::VERSION,
				),
			),
		);
	}

	/**
	 * Check to see if the information supplied is valid. If all the values
	 * are valid the values are written to the $this->params property
	 *
	 * @param array $params Params post array
	 * @param integer $site_id
	 * @param integer|NULL $category_id
	 * @param integer|NULL $sub_category_id
	 * @param integer|NULL $image_id
	 * @param integer|NULL $version_id
	 *
	 * @return boolean
	 */
	public function validate(array $params = array(), $site_id,
		$category_id = NULL, $sub_category_id = NULL, $image_id = NULL, $version_id = NULL)
	{
		$this->site_id = $site_id;
		$this->category_id = $category_id;
		$this->sub_category_id = $sub_category_id;
		$this->image_id = $image_id;
		$this->version_id = $version_id;
		$this->session_dlayer = new Dlayer_Session();

		if($this->validateValues($params) == TRUE &&
			$this->validateData($params) == TRUE
		)
		{
			$this->params = $this->prepare($params);
			$this->validated = TRUE;

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function autoValidate(array $params = array(), $site_id,
		$category_id = NULL, $sub_category_id = NULL, $image_id = NULL, $version_id = NULL)
	{
		// Not currently used by tool, may be used by the presets later
		return FALSE;
	}

	public function autoProcess()
	{
		// Not currently used by tool, may be used by the presets later
	}

	/**
	 * Check that the required values have been sent through as part of the
	 * params array, another method will validate the values themselves
	 *
	 * @param array $params Params array to check
	 *
	 * @return boolean TRUE if the required values exists in the array
	 */
	private function validateValues(array $params = array())
	{
		if(array_key_exists('category', $params) == TRUE &&
			array_key_exists('sub_category', $params) == TRUE &&
			array_key_exists('name', $params) == TRUE &&
			array_key_exists('description', $params) == TRUE
		)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Check that the submitted data values are all in the correct format
	 * and that the values themselves are valid
	 *
	 * @param array $params Params array to check
	 *
	 * @return boolean TRUE if the values are valid
	 */
	private function validateData(array $params = array())
	{
		$model_categories = new Dlayer_DesignerTool_ImageLibrary_Category_Model();

		if(strlen(trim($params['name'])) > 0 &&
			strlen(trim($params['description'])) > 0 &&
			$model_categories->categoryIdExists($this->site_id,
				intval($params['category'])) == TRUE &&
			$model_categories->subCategoryIdExists($this->site_id,
				intval($params['category']),
				intval($params['sub_category'])) == TRUE
		)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Prepare the data, converts all the array values to the required data
	 * type and trims and string values, called after the data has been
	 * validated
	 *
	 * @param array $params Params array to prepare
	 *
	 * @return array Prepared data array
	 */
	protected function prepare(array $params)
	{
		return array(
			'name' => trim($params['name']),
			'description' => trim($params['description']),
			'category_id' => intval($params['category']),
			'sub_category_id' => intval($params['sub_category']),
		);
	}

	/**
	 * Edit the details for the selected library image
	 *
	 * @return void
	 */
	private function editImage()
	{
		$model_image = new Dlayer_Model_Image_Image();
		$model_image->editLibraryDetails($this->site_id, $this->image_id,
			$this->params);
	}
}
