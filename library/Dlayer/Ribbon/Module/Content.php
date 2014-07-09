<?php
/**
* The ribbon classes return all the data required to generate the view for the
* selected ribbon tab. Some of these classes are very simple, some are much
* more completed, by extending this abstract class we ensure some consistency
* as the complexity of the application grows.
*
* Ribbon models only have one public method, viewData(), this should return
* either an array containing the required data or FALSE is there is no data,
* the format of the data depends on both tghe requested tool and the requested
* tabl, all we require is an array or FALSE, the view script works out
* what it needs to do with the array
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Content.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
abstract class Dlayer_Ribbon_Module_Content
{
    protected $site_id;
    protected $page_id;
    protected $div_id;
    protected $tool;
    protected $tab;
    protected $multi_use;
    protected $content_id;
    protected $edit_mode;

    /**
    * Data method for the content manager designer ribbons, returns the data
    * required by the view for the requested tool and tab.
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer $multi_use Multi use value for tool tab
    * @param integer|NULL $content_id Selected content item
    * @param boolean $edit_mode Is the tool tab in edit mode
    * @return array|FALSE
    */
    abstract public function viewData($site_id, $page_id, $div_id, $tool, 
    $tab, $multi_use, $content_id=NULL, $edit_mode=FALSE);

    /**
    * Take the supplied params and write them to the private properties
    *
    * @param integer $site_id
    * @param integer $page_id
    * @param integer $div_id
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param integer $multi_use Multi use value for tool tab
    * @param integer|NULL $content_id Selected content item
    * @param boolean $edit_mode Is the tool tab in edit mode
    * @return array|FALSE
    */
    protected function writeParams($site_id, $page_id, $div_id, $tool, $tab, 
    $multi_use, $content_id, $edit_mode)
    {
        $this->site_id = $site_id;
        $this->page_id = $page_id;
        $this->div_id = $div_id;
        $this->tool = $tool;
        $this->tab = $tab;
        $this->multi_use = $multi_use;
        $this->content_id = $content_id;
        $this->edit_mode = $edit_mode;
    }
    
    /**
    * Fetch the values for the content item container. 
    * 
    * If the tool is in edit mode we return the current values otherwise 
    * sensible defaults are calculated based on the parent page div.
    *
    * @return array
    */
    abstract protected function container();
    
    /**
    * Fetch the default data for the tool forms, either pulls the currently 
    * set data or allows us to define the initial values
    *
    * @return array
    */
    abstract protected function existingData();
}
