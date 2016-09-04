<?php
/**
* AJAX controller for all the ajax calls used in the Content manager designer
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Content_AjaxController extends Zend_Controller_Action
{
	/**
	* Type hinting for action helpers, hints the property to the code
	* hinting class which exists in the library
	*
	* @var Dlayer_Action_CodeHinting
	*/
	protected $_helper;

	private $site_id;
	private $page_id;

	/**
	 * @var Dlayer_Session_Designer
	 */
	private $session_designer;

	/**
	 * @var Dlayer_Model_ImagePicker
	 */
	private $model_image_picker;

	/**
	* Initialise the controller, run any required set up code and set properties required by controller actions
	*
	* @return void
	*/
	public function init()
	{
		$this->_helper->authenticate();

		$this->_helper->disableLayout(FALSE);

		$this->_helper->setModule();

		$this->_helper->validateSiteId();

		$session_dlayer = new Dlayer_Session();
		$this->site_id = $session_dlayer->siteId();

		$this->session_content = new Dlayer_Session_Content();
		$this->page_id = $this->session_content->pageId();

		$this->session_designer = new Dlayer_Session_Designer();
	}
	
	/**
	* Fetches the data belonging to the option in the import select menu and 
	* then returns the json so that the tool fields can be updated
	* 
	* @return void
	*/
	public function importTextAction() 
	{
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		
		$model_text_data = new Dlayer_Model_Page_Content_Items_Text();
		$import_data = $model_text_data->existingTextContent(
			$this->session_dlayer->siteId(), 
			$this->getRequest()->getParam('id'));
		
		$json = array('data'=>FALSE);
		
		if($import_data != FALSE) {
			$json = array('data'=>true, "name"=>$import_data['name'], 
			"text"=>$import_data['content']);
		}
		
		echo Zend_Json::encode($json);
	}
	
	/**
	* Fetches the data belonging to the option in the import select menu and 
	* then returns the json so that the tool fields can be updated
	* 
	* @return string
	*/
	public function importJumbotronAction() 
	{
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		
		$model_text_data = new Dlayer_Model_Page_Content_Items_Jumbotron();
		$import_data = $model_text_data->existingJumbotronContent(
			$this->session_dlayer->siteId(), 
			$this->getRequest()->getParam('id'));
		
		$json = array('data'=>FALSE);
		
		if($import_data != FALSE) {
			$json = array('data'=>true, "name"=>$import_data['name'],
				"title"=>$import_data['title'], 
				"sub_title"=>$import_data['sub_title']);
		}
		
		echo Zend_Json::encode($json);
	}
	
	/**
	* Fetches the data belonging to the option in the import select menu and 
	* then returns the json so that the tool fields can be updated
	* 
	* @return string
	*/
	public function importHeadingAction() 
	{
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		
		$model_text_data = new Dlayer_Model_Page_Content_Items_Heading();
		$import_data = $model_text_data->existingHeadingContent(
			$this->session_dlayer->siteId(), 
			$this->getRequest()->getParam('id'));
		
		$json = array('data'=>FALSE);
		
		if($import_data != FALSE) {
			$json = array('data'=>true, "name"=>$import_data['name'],
				"heading"=>$import_data['heading'], 
				"sub_heading"=>$import_data['sub_heading']);
		}
		
		echo Zend_Json::encode($json);
	}
	
	/**
	* Select the image, sets the image id and version id in the session and 
	* the returns the name of the image to be passed to the image picker, 
	* button is updated with the name
	* 
	* @return string
	*/
	public function imagePickerSelectImageAction() 
	{
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		
		$image_id = $this->getRequest()->getParam('image_id');
		$version_id = $this->getRequest()->getParam('version_id');
		
		$this->model_image_picker = new Dlayer_Model_ImagePicker();
		
		$image = $this->model_image_picker->validateImage($this->site_id, $image_id, $version_id);
			
		$json = array('data'=>FALSE);
			
		if($image != FALSE) {
			
			$this->session_designer->setImagePickerImageId($image_id);
			$this->session_designer->setImagePickerVersionId($version_id);
			
			$json = array(
				'data'=>true, 
				'name'=>$image['name'], 
				'dimensions'=>$image['dimensions'], 
				'size'=>$image['size'], 
				'extension'=>$image['extension']
			);
		}
		
		echo Zend_Json::encode($json);
	}
	
	/**
	* Returns the minimum width for the selected form, required so that we 
	* can disable the save button if the form won't fit and put up a message.
	* 
	* @return void
	*/
	public function formMinimumWidthAction() 
	{
		$this->getResponse()->setHeader('Content-Type', 'application/json');
		
		$model_form_data = new Dlayer_Model_Page_Content_Items_Form();
		$minimum_width = $model_form_data->minimumWidth(
		$this->session_dlayer->siteId(), 
		$this->getRequest()->getParam('data_id'), FALSE);
		
		$json = array('data'=>FALSE);
		
		if($minimum_width != FALSE) {
			$json['data'] = TRUE;
			$json['width'] = intval($minimum_width);
		}
		
		echo Zend_Json::encode($json);
	}
	
	/**
	* Image picker ajax request
	* 
	* Needs to either default all the values or just present the initial 
	* category select
	*/
	function imagePickerAction() 
	{
		$this->getResponse()->setHeader('Content-Type', 'application/html');
		
		$category_id = $this->getRequest()->getParam('category_id');
		$sub_category_id = $this->getRequest()->getParam('sub_category_id');
		$image_id = $this->getRequest()->getParam('image_id');

		/**
		 *
		 *
		 * Move these, session class can do the checks
		 *
		 *
		 *
		 */
		if($category_id !== NULL) {
			if($category_id !== 'clear') {
				$this->session_designer->setImagePickerCategoryId(
					intval($category_id));
			} else {
				$this->session_designer->clearImagePickerCategoryId();
			}
		}
		
		if($sub_category_id !== NULL) {
			if($sub_category_id !== 'clear') {
				$this->session_designer->setImagePickerSubCategoryId(
					intval($sub_category_id));
			} else {
				$this->session_designer->clearImagePickerSubCategoryId();
			}
		}
		
		if($image_id !== NULL) {
			if($image_id !== 'clear') {
				$this->session_designer->setImagePickerImageId(
					intval($image_id));
			} else {
				$this->session_designer->clearImagePickerImageId();
			}
		}
		
		$this->model_image_picker = new Dlayer_Model_ImagePicker();
		
		$category_id = $this->session_designer->imagePickerCategoryId();
		$sub_category_id = $this->session_designer->imagePickerSubCategoryId();
		$image_id = $this->session_designer->imagePickerImageId();
		$version_id = $this->session_designer->imagePickerVersionId();
		
		$this->view->visible = FALSE;
		
		if($category_id !== NULL && $sub_category_id !== NULL && 
			$image_id !== NULL && $version_id !== NULL) {
				
			$this->view->visible = TRUE;
		}
		
		$this->view->category = $this->imagePickerCategory($this->site_id, $category_id);
		$this->view->sub_category = $this->imagePickerSubCategory($this->site_id, $category_id, $sub_category_id);
		$this->view->images = $this->imagePickerImages($this->site_id, $category_id, $sub_category_id, $image_id);
		
		echo $this->view->render('ajax/image-picker.phtml');
	}
	
	/**
	* Image picker category
	* 
	* @param integer $site_id
	* @param integer|NULL $category_id
	* @return string
	*/
	function imagePickerCategory($site_id, $category_id) 
	{
		if($category_id == NULL) {
			$this->view->categories = $this->model_image_picker->categories(
				$site_id);
			return $this->view->render('ajax/image-picker-categories.phtml');
		} else {
			$this->view->category = $this->model_image_picker->category(
				$site_id, $category_id);
			return $this->view->render('ajax/image-picker-category.phtml');
		}
	}
	
	/**
	* Image picker sub category
	* 
	* @param integer $site_id
	* @param integer|NULL $category_id 
	* @param integer|NULL $sub_category_id
	* @return string
	*/
	function imagePickerSubCategory($site_id, $category_id, $sub_category_id) 
	{
		if($category_id === NULL)
		{
			return NULL;
		}
		else
		{
			if($sub_category_id === NULL)
			{
				$this->view->sub_categories = $this->model_image_picker->subCategories($site_id,
					$category_id);
					
				return $this->view->render(
					'ajax/image-picker-sub-categories.phtml');
			} else {
				$this->view->sub_category = 
					$this->model_image_picker->subCategory($site_id, 
					$category_id, $sub_category_id);
				
				// Return the sub category name
				return $this->view->render(
					'ajax/image-picker-sub-category.phtml');
			}
		}
	}
	
	/**
	* Image picker image list
	* 
	* @param integer $site_id
	* @param integer|NULL $category_id
	* @param integer|NULL $sub_category_id
	* @param integer|NULL $image_id
	* @return string
	*/
	function imagePickerImages($site_id, $category_id, $sub_category_id, 
		$image_id) 
	{
		if($category_id === NULL) {
			//	No category		
			return NULL;
		} else {
			if($sub_category_id === NULL) {
				// No sub category
				return NULL;
			} else {
				if($image_id == NULL) {
					$this->view->images = $this->model_image_picker->images(
						$site_id, $category_id, $sub_category_id);

					return $this->view->render(
						'ajax/image-picker-images.phtml');
				} else {
					$this->view->image = $this->model_image_picker->image(
						$site_id, $category_id, $image_id);
						
					$this->view->version_id = 
						$this->session_designer->imagePickerVersionId();
						
					$this->view->versions = 
						$this->model_image_picker->versions($site_id, 
						$category_id, $image_id);
					
					return $this->view->render('ajax/image-picker-versions.phtml');					
				}
			}
		}
	}
}
