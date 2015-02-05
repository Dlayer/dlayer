<?php
/**
* Custom session class for the content module, stores all the vars that we 
* need to manager the environment, attempting to not have any visible get vars 
* which may confused the user. 
* 
* The session class handles the page id, corresponding template id, tool and 
* ribbon and depending on what the user is doing either the div id or the 
* template id
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Content.php 1568 2014-02-14 14:59:50Z Dean.Blackborough $
*/
class Dlayer_Session_Content extends Zend_Session_Namespace 
{
    /**
    * @param string $namespace
    * @param bool $singleInstance
    * @return void
    */
    public function __construct($namespace = 'dlayer_session_content', 
    $singleInstance = false) 
    {
        parent::__construct($namespace, $singleInstance);
        
        $this->setExpirationSeconds(3600);
    }
    
    /**
    * Set the id for the site template that the user wants to work on
    * 
    * @param integer $id
    * @return void
    */
    public function setTemplateId($id) 
    {
        $this->template_id = intval($id);
    }
    
    /**
    * Get the id of the template that the user is currently working on
    * 
    * @return integer|NULL
    */
    public function templateId() 
    {
        return $this->template_id;
    }
    
    /**
    * Set the id for the selected page
    * 
    * @param integer $id
    * @return void
    */
    public function setPageId($id) 
    {
        $this->page_id = intval($id);
    }
    
    /**
    * Get the id of the page the user is working on
    * 
    * @return integer|NULL
    */
    public function pageId() 
    {
        return $this->page_id;
    }
    
    /**
    * Set the id for the seelcted content row
    * 
    * @param integer $id
    * @return void
    */
    public function setContentRowId($id) 
    {
        $this->content_row_id = intval($id);
    }
    
    /**
    * Get the id of the selected content row
    * 
    * @return integer|NULL
    */
    public function contentRowId() 
    {
		return $this->content_row_id;
    }
    
    /**
    * Set the id of the block that the user wants to add content to.
    * 
    * By default when a user sets a content block id the id of any content rows 
    * and content items is cleared
    * 
    * @param integer $div_id 
    * @param boolean $clear_content_ids Clear the content row id and content id
    * @return void
    */
    public function setDivId($div_id, $clear_content_ids=TRUE) 
    {
        $this->div_id = intval($div_id);
        
        if($clear_content_ids == TRUE) {
            $this->content_id = NULL;
            $this->content_row_id = NULL;
        }
    }
        
    /** 
    * Clear the currently set content id value, content_id is set to NULL
    * 
    * @return void
    */
    public function clearContentId() 
    {
        $this->content_id = NULL;
    }
    
    /**
    * Set the content item that the user wants to edit. A check is done to 
    * ensure that the content item belongs to the page/template div set in the 
    * session and that it is off the expected type.
    *
    * @param integer $content_id
    * @param string $content_type Type of content item, heading, text, html
    * @return boolean
    */
    public function setContentId($content_id, $content_type)
    {
        $session_content = new Dlayer_Session_Content();
        $session_dlayer = new Dlayer_Session();
        
        $model_content = new Dlayer_Model_Page_Content();
        
        if($model_content->valid($content_id, $session_dlayer->siteId(), 
        $session_content->pageId(), $session_content->divId(), 
        $content_type) == TRUE) {
            $this->content_id = intval($content_id);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
    * Get the id of the selected template div
    *
    * @return integer|NULL
    */
    public function divId()
    {
        return $this->div_id;
    }
    
    /**
    * Get the id of the selected content block
    * 
    * @return integer|NULL
    */
    public function contentId() 
    {
        return $this->content_id;
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
                         'model'=>$this->tool_model);
        } else {
            return FALSE;
        }
    }
        
    /**
    * Clears the session values for the content manager, these are the vars 
    * that relate to the current state of the designer, selected div, 
    * content item and tool and tool tab, leaves page_id and template_id set, 
    * just resets the state of the designer.
    * 
    * @param boolean $reset If TRUE also clears page_id and template_id
    * @return void
    */
    public function clearAll($reset=FALSE) 
    {
        $this->div_id = NULL;
        $this->content_id = NULL;
        $this->tool = NULL;
        $this->tab = NULL;
        if($reset==TRUE) {
            $this->page_id = NULL;
            $this->template_id = NULL;
        }
    }
}