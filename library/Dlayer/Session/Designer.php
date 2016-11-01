<?php

/**
 * Custom session class for the designers, stores all the vars that are
 * needed by the tools that exist acroiss the designers, for example the
 * image picker
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Session_Designer extends Zend_Session_Namespace
{
	/**
	 * @param string $namespace
	 * @param bool $singleInstance
	 *
	 * @return void
	 */
	public function __construct($namespace = 'dlayer_session_designer',
		$singleInstance = FALSE)
	{
		parent::__construct($namespace, $singleInstance);

		$this->setExpirationSeconds(3600);
	}

	/**
	 * Get the currently set image picker category id
	 *
	 * @return integer|NULL
	 */
	public function imagePickerCategoryId()
	{
		return $this->image_picker_category_id;
	}

	/**
	 * Set the category id for the image picker
	 *
	 * @param integer $id
	 *
	 * @return void
	 */
	public function setImagePickerCategoryId($id)
	{
		$this->image_picker_category_id = intval($id);
	}

	/**
	 * Get the currently set image picker sub category id
	 *
	 * @return integer|NULL
	 */
	public function imagePickerSubCategoryId()
	{
		return $this->image_picker_sub_category_id;
	}

	/**
	 * Set the sub category id for the image picker
	 *
	 * @param integer $id
	 *
	 * @return void
	 */
	public function setImagePickerSubCategoryId($id)
	{
		$this->image_picker_sub_category_id = intval($id);
	}

	/**
	 * Set the image id for the image picker
	 *
	 * @param integer $id
	 *
	 * @return void
	 */
	public function setImagePickerImageId($id)
	{
		$this->image_picker_image_id = intval($id);
	}

	/**
	 * Set the version id for the image picker
	 *
	 * @param integer $id
	 *
	 * @return void
	 */
	public function setImagePickerVersionId($id)
	{
		$this->image_picker_version_id = intval($id);
	}

	/**
	 * Get the currently set image picker image id
	 *
	 * @return integer|NULL
	 */
	public function imagePickerImageId()
	{
		return $this->image_picker_image_id;
	}

	/**
	 * Get the currently set image picker version id
	 *
	 * @return integer|NULL
	 */
	public function imagePickerVersionId()
	{
		return $this->image_picker_version_id;
	}

	public function clearImagePickerCategoryId()
	{
		$this->clearAllImagePicker();
	}

	public function clearImagePickerSubCategoryId()
	{
		$this->image_picker_sub_category_id = NULL;
		$this->image_picker_image_id = NULL;
		$this->image_picker_version_id = NULL;
	}

	public function clearImagePickerImageId()
	{
		$this->image_picker_image_id = NULL;
		$this->image_picker_version_id = NULL;
	}

	public function clearImagePickerVersionId()
	{
		$this->image_picker_version_id = NULL;
	}

	/**
	 * Clear all the session values for Image picker
	 *
	 * @return void
	 */
	public function clearAllImagePicker()
	{
		$this->image_picker_category_id = NULL;
		$this->image_picker_sub_category_id = NULL;
		$this->image_picker_image_id = NULL;
		$this->image_picker_version_id = NULL;
	}

	/**
	 * Clear all the session values
	 *
	 * @return void
	 */
	public function clearAll()
	{
		$this->clearAllImagePicker();
		$this->clearAllTool('content');
	}

	/**
	 * Set the requested tool as selected, before setting the tool we check to see if the tool is valid and
	 * then set the default tool tab as active
	 *
	 * @param string $module Current module
	 * @param string $tool Tool model name
	 *
	 * @return boolean
	 */
	public function setTool($module, $tool)
	{
		$model_tool = new Dlayer_Model_Tool();
		$tool = $model_tool->toolAndDefaultTab($module, $tool);

		if($tool !== FALSE)
		{
			$this->tool[$module] = $tool['tool'];
			$this->setToolTab($module, $tool['tab'], $tool['sub_tool']);

			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Set the tool tab
	 *
	 * @param string $module Current module
	 * @param string $tab
	 * @param string|NULL $sub_tool
	 *
	 * @return void
	 */
	public function setToolTab($module, $tab, $sub_tool = NULL)
	{
		$this->tab[$module] = $tab;
		$this->sub_tool[$module] = $sub_tool;
	}

	/**
	 * Returns the data array for the currently selected tool, if no tool is set the method returns FALSE, a
	 * tool is the combination of the tool itself and the selected tab
	 *
	 * @param string $module Current module
	 *
	 * @return array|FALSE
	 */
	public function tool($module)
	{
		if(array_key_exists($module, $this->tool) === TRUE &&
			array_key_exists($module, $this->tab) === TRUE) {

			return array(
				'tool' => $this->tool[$module],
				'sub_tool' => (array_key_exists($module, $this->sub_tool)) ? $this->sub_tool[$module] : NULL,
				'tab' => $this->tab[$module],
			);
		} else {
			return FALSE;
		}
	}

	/**
	 * Clear all the session values for the selected tool
	 *
	 * @param string $module Current module
	 *
	 * @return void
	 */
	public function clearAllTool($module)
	{
		$this->tool[$module] = array();
		$this->sub_tool[$module] = array();
		$this->tab[$module] = array();
	}
}
