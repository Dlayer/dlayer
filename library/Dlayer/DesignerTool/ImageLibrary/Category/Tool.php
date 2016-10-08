<?php

/**
 * Add or edit an image cotegory
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ImageLibrary_Category_Tool extends Dlayer_Tool_Module_Image
{
	/**
	 * Add or edit the selected image category, uses the data in the params
	 * array, this data will have already been both validated and prepared
	 * by the tool class
	 *
	 * @return array Contains relevant id and type of id
	 */
	public function process()
	{
		if($this->validated === TRUE)
		{
			if($this->category_id === NULL)
			{
				$ids = $this->addCategory();
				if($ids !== FALSE)
				{
					$this->category_id = $ids['category_id'];
					$this->sub_category_id = $ids['sub_category_id'];
				}
			}
			else
			{
				$this->editCategory();
			}
		}

		/**
		 * Need to review this
		 */

		return array(
			'multiple' => '',
			'ids' => array(
				array(
					'id' => $this->category_id,
					'type' => Dlayer_Session_Image::CATEGORY,
				), array(
					'id' => $this->sub_category_id,
					'type' => Dlayer_Session_Image::SUB_CATEGORY,
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
		if(array_key_exists('name', $params) == TRUE)
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
		$model_tool = new Dlayer_DesignerTool_ImageLibrary_Category_Model();

		if(strlen(trim($params['name'])) > 0 &&
			$model_tool->categoryExists($this->site_id, trim($params['name']), $this->category_id) === FALSE)
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
			'name' => trim($params['name'])
		);
	}

	/**
	 * Add the new category
	 *
	 * @return array|FALSE Ids for the newly created category and sub category
	 */
	public function addCategory()
	{
		$sub_category_id = FALSE;
		$model_tool = new Dlayer_DesignerTool_ImageLibrary_Category_Model();

		$category_id = $model_tool->addCategory($this->site_id, $this->params['name']);

		if($category_id !== FALSE)
		{
			$sub_category_id = $model_tool->addSubCategory($this->site_id, $category_id,
				Dlayer_Config::IMAGE_LIBRARY_DEFAULT_SUB_CATEGORY);
		}

		if($category_id !== FALSE && $sub_category_id !== FALSE)
		{
			return array(
				'category_id' => $category_id,
				'sub_category_id' => $sub_category_id,
			);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Edit the selected category
	 *
	 * @return void
	 */
	public function editCategory()
	{
		$this->model_categories->editCategory($this->site_id,
			$this->category_id, $this->params['name']);
	}
}
