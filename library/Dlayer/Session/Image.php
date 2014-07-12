<?php
/**
* Custom session class for the image library module, store vars which we need to
* manage the environment, attempting to not have visible get vars so this class
* will deal with the values
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Session_Image extends Zend_Session_Namespace
{
    CONST IMAGE = 'image';
    CONST CATEGORY = 'category';
    CONST SUB_CATEGORY = 'sub_category';
        
    CONST SORT_NAME = 'name';
    CONST SORT_UPLOADED = 'uploaded';
    CONST SORT_SIZE = 'size';
    
    private $sort_options = array(SELF::SORT_NAME, 
    SELF::SORT_UPLOADED, SELF::SORT_SIZE);
    
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
    public function setId($id, $type=Dlayer_Session_Image::IMAGE)
    {
        $this->ids[$type] = intval($id);
        
        return true;
    }

    /**
    * Get the id of the image, category or subcategory
    *
    * @param string $type Use constants to define type
    * @return integer|NULL
    * 
    */
    public function id($type=Dlayer_Session_Image::IMAGE)
    {
        if(is_array($this->ids) == TRUE && 
        array_key_exists($type, $this->ids) == TRUE) {
            return $this->ids[$type];
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
            $this->sort = SELF::SORT_NAME;
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
            return array('sort'=>SELF::SORT_NAME, 'order'=>'asc');
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

        $tool_details = $model_tool->valid($session_dlayer->module(), $tool);

        if($tool_details != FALSE) {
            $this->tool = $tool;
            $this->tool_model = $tool_details['tool_model'];
            $this->tool_destructive = $tool_details['destructive'];
            $this->setRibbonTab($tool_details['tab']);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Set the tool tab
    *
    * @param string $tab
    * @return void
    */
    public function setRibbonTab($tab)
    {
        $this->tab = $tab;
    }

    /**
    * Returns the data array for the currently selected tool, if no tool is
    * set the method returns FALSE
    *
    * @return array|FALSE Array contains two indexes, tool and tab, name is
    *                     the name of the tool, tab is the name of the
    *                     selected tab
    */
    public function tool()
    {
        if($this->tool != NULL && $this->tab != NULL &&
        $this->tool_model != NULL) {
            return array('tool'=>$this->tool,
                         'tab'=>$this->tab,
                         'model'=>$this->tool_model, 
                         'destructive'=>$this->tool_destructive);
        } else {
            return FALSE;
        }
    }
    
    /**
    * Clears the session values for the image library, these are the vars 
    * that relate to the current state of the designer, selected image, 
    * tool and tool tab.
    * 
    * @return void
    */
    public function clearAll($reset=FALSE)
    {
        $this->tool = NULL;
        $this->tab = NULL;
        $this->ids = array();
    }
}