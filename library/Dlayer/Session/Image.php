<?php
/**
* Custom session class for the image library module, store vars which we need to
* manage the environment, attempting to not have visible get vars so this class
* will deal with the values
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Session_Image extends Zend_Session_Namespace
{
    CONST IMAGE = 'image';
    CONST VERSION = 'version';
    CONST CATEGORY = 'category';
    CONST SUB_CATEGORY = 'sub_category';
        
    CONST SORT_NAME = 'name';
    CONST SORT_UPLOADED = 'uploaded';
    CONST SORT_SIZE = 'size';
    
    private $sort_options = array(Dlayer_Session_Image::SORT_NAME, 
    Dlayer_Session_Image::SORT_UPLOADED, Dlayer_Session_Image::SORT_SIZE);
    
    //public $image_ids = array();
    
    /**
    * @param string $namespace
    * @param bool $singleInstance
    * @return void
    */
    public function __construct($namespace = 'dlayer_session_image',
    $singleInstance = false)
    {
        parent::__construct($namespace, $singleInstance);

        $this->setExpirationSeconds(3600);
    }

    /**
    * Set the id for the image, category or sub category that the user is 
    * currently working with
    *
    * @todo, Check type and also then check validity of id
    * @param integer $id
    * @param string $type Use the constants to set type
    * @return boolean
    */
    public function setImageId($id, $type=Dlayer_Session_Image::IMAGE)
    {
        $this->image_ids[$type] = $id;
        
        return true;
    }
    
    /**
    * Set if we are in edit mode, used for category and sub category editing, 
    * only tools that doesn't require an image to be selected
    * 
    * @param integer $edit_mode Defaults to 0 for FALSE
    * @return void
    */
    public function setEditMode($edit_mode=0) 
    {
        $this->edit_mode = $edit_mode;
    }
    
    /**
    * Check to see if we are in edit mode for categories and sub categories
    * 
    * @return integer
    */
    public function editMode() 
    {
        if(isset($this->edit_mode) == TRUE) {
            return $this->edit_mode;
        } else {
            return 0;
        }
    }

    /**
    * Get the id of the image, category or subcategory
    *
    * @param string $type Use constants to define type
    * @return integer|NULL
    * 
    */
    public function imageId($type=Dlayer_Session_Image::IMAGE)
    {
        if(isset($this->image_ids) == TRUE && 
        is_array($this->image_ids) == TRUE && 
        array_key_exists($type, $this->image_ids) == TRUE) {
            return $this->image_ids[$type];
        } else {
            return NULL;
        }
    }
    
    /**
    * Set the sort method for the image library, the defined constants can 
    * be used for sorting, initially name, uploaded and size
    * 
    * If incorrect values are used the sort properties default to name and 
    * ascending
    *
    * @param string $sort Use the constants to set sort type
    * @param string $order Sort order, either asc or desc
    * @return void
    */
    public function setSort($sort=Dlayer_Session_Image::SORT_NAME, 
    $order='asc')
    {
        if(in_array($sort, $this->sort_options) == TRUE && 
        in_array($order, array('asc', 'desc')) == TRUE) {
            $this->sort = $sort;
            $this->sort_order = $order;
        } else {
            $this->sort = Dlayer_Session_Image::SORT_NAME;
            $this->sort_order = 'asc';
        }
    }
    
    /**
    * Fetch the sort order and sort direction, if the values haven't been 
    * previousl;y set the default is returned, name and ascending
    * 
    * @return array Two indexes, sort and order
    */
    public function sortOrder() 
    {
        if($this->sort != NULL & $this->sort_order != NULL) {
            return array('sort'=>$this->sort, 'order'=>$this->sort_order);
        } else {
            return array('sort'=>Dlayer_Session_Image::SORT_NAME, 
            'order'=>'asc');
        }
    }

	/**
	 * Set the selected tool, before setting we check to see if the requested
	 * tool is valid, if valid we set the default tab for the tool
	 *
	 * @param string $tool Name of the tool to set
	 * @return boolean
	 */
	public function setTool($tool)
	{
		$session_dlayer = new Dlayer_Session();
		$model_tool = new Dlayer_Model_Tool();

		$tool = $model_tool->toolAndDefaultTab($session_dlayer->module(), $tool);

		if($tool !== FALSE)
		{
			$this->tool = $tool['tool'];
			$this->setRibbonTab($tool['tab'], $tool['sub_tool']);

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
	 * @param string $tab
	 * @param string|NULL $sub_tool
	 * @return void
	 */
	public function setRibbonTab($tab, $sub_tool=NULL)
	{
		$this->tab = $tab;
		$this->sub_tool = $sub_tool;
	}

	/**
	 * Returns the data array for the currently selected tool, if no tool is set the method returns FALSE, a tool is
	 * the combination of the tool itself and the selected tab
	 *
	 * @return array|FALSE
	 */
	public function tool()
	{
		if($this->tool !== NULL && $this->tab !== NULL)
		{
			return array(
				'tool' => $this->tool,
				'sub_tool' => $this->sub_tool, // Sub tool model can be NULL
				'tab' => $this->tab
			);
		}
		else
		{
			return FALSE;
		}
	}
    
    /**
    * Clear the set tool
    */
    public function clearTool() 
    {
        $this->tool = NULL;
    }

	/**
	 * Clears the session values for the Image library
	 *
	 * @param boolean $reset If TRUE also clears form_id and return param
	 * @return void
	 */
	public function clearAll($reset = FALSE)
	{
		$this->tool = NULL;
		$this->sub_tool = NULL;
		$this->tab = NULL;
		$this->image_ids = NULL;
	}
}
