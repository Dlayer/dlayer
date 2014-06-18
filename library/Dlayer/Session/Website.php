<?php
/**
* Custom session class for the web site module, store vars which we need to
* manage the environment, attemping to not have visible get vars so this class
* will deal with the values
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Website.php 1595 2014-02-20 00:38:26Z Dean.Blackborough $
*/
class Dlayer_Session_Website extends Zend_Session_Namespace
{
    /**
    * @param string $namespace
    * @param bool $singleInstance
    * @return void
    */
    public function __construct($namespace = 'dlayer_session_website',
    $singleInstance = false)
    {
        parent::__construct($namespace, $singleInstance);

        $this->setExpirationSeconds(3600);
    }

    /**
    * Set the id for the page that the user wants to manage
    *
    * @todo Need to check that the page id is valid
    * @param integer $id
    * @return void
    */
    public function setPageId($id)
    {
        $this->page_id = intval($id);
    }

    /**
    * Get the id of the page that the user is currently working on
    *
    * @return integer|NULL
    */
    public function pageId()
    {
        return $this->page_id;
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
    * Clears the session values for the web site manager, these are the vars 
    * that relate to the current state of the designer, selected page, 
    * tool and tool tab.
    * 
    * @return void
    */
    public function clearAll($reset=FALSE)
    {
        $this->tool = NULL;
        $this->tab = NULL;
        $this->page_id = NULL;
    }
}