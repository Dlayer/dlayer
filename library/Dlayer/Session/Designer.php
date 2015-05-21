<?php
/**
* Custom session class for the designers, stores all the vars that are 
* needed by the tools that exist acroiss the designers, for example the 
* image picker
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Content.php 1568 2014-02-14 14:59:50Z Dean.Blackborough $
*/
class Dlayer_Session_Designer extends Zend_Session_Namespace 
{
	/**
	* @param string $namespace
	* @param bool $singleInstance
	* @return void
	*/
	public function __construct($namespace = 'dlayer_session_designer', 
		$singleInstance = false) 
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
	* @return void
	*/
	public function setImagePickerCategoryId($id) 
	{
		return $this->image_picker_category_id = intval($id);
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
	* @return void
	*/
	public function setImagePickerSubCategoryId($id) 
	{
		return $this->image_picker_sub_category_id = intval($id);
	}

	/**
	* Set the image id for the image picker
	* 
	* @param integer $id
	* @return void
	*/
	public function setImagePickerImageId($id) 
	{
		return $this->image_picker_image_id = intval($id);
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
	}
}