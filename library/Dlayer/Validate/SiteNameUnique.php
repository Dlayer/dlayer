<?php
/**
* Check to see if the name is unique, needs to be unique for the user, 
* not for the entire table
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Validate_SiteNameUnique extends Zend_Validate_Abstract 
{
    private $identity_id;
	private $site_id = NULL;
	
    const SITE_NAME_UNIQUE = 'siteNameUnique';

    protected $_messageTemplates = array(
        self::SITE_NAME_UNIQUE => "The supplied site name is not valid, it has 
        been used for another site"
    );
       
    /**
    * Sets validator options
    *
    * @param integer $identity_id
    * @param integer|NULL $site_id Site id to ignore when doing the unique 
    * 							   check, value required in edit mode so row is 
    * 							   excluded from query
    * @param array $options
    * @return void
    */
    public function __construct($identity_id, $site_id=NULL, 
    $options = array())
    {
        $this->identity_id = $identity_id;
        
        if($site_id != NULL) {
			$this->site_id = $site_id;
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
        
        $model_sites = new Dlayer_Model_Site();
        
        if($model_sites->nameUnique($value, $this->identity_id, 
        $this->site_id) == TRUE) {
			return TRUE;
        } else {
			$this->_error(self::SITE_NAME_UNIQUE);
            return FALSE;
        }
    }
}
