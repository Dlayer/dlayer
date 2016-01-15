<?php
/**
* Check to see if the name is unique, needs to be unique for the sitee, not 
* the entire table
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Validate_PageNameUnique extends Zend_Validate_Abstract 
{
	private $site_id = NULL;
	private $page_id = NULL;
	
    const PAGE_NAME_UNIQUE = 'pageNameUnique';

    protected $_messageTemplates = array(
        self::PAGE_NAME_UNIQUE => "The supplied page name is not valid, 
        you have used it for another page in your site"
    );
       
    /**
    * Sets validator options
    *
    * @param integer $site_id Site id to use to limit query
    * @param integer|NULL $page_id Page id to ignore when doing the check, 
    * 							   value required in edit mode so that row is 
    * 							   excluded from query
    * @param array $options
    * @return void
    */
    public function __construct($site_id, $page_id=NULL, 
    $options = array())
    {
    	$this->site_id = $site_id;
    	
        if($page_id != NULL) {
			$this->page_id = $page_id;
        }
    }

    /**
    * Run the validation
    * 
    * @param string $value
    * @return boolean
    */
    public function isValid($value)
    {
        $this->_setValue($value);
        
        $model_pages = new Dlayer_Model_Page();
        
        if($model_pages->nameUnique($value, $this->site_id, 
        $this->page_id) == TRUE) {
			return TRUE;
        } else {
			$this->_error(self::PAGE_NAME_UNIQUE);
            return FALSE;
        }
    }
}
