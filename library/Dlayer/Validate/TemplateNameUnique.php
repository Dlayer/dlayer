<?php
/**
* Check to see if the name is unique, needs to be unique for the site id, not 
* the entire table
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: TemplateNameUnique.php 1211 2013-11-10 14:54:33Z Dean.Blackborough $
*/
class Dlayer_Validate_TemplateNameUnique extends Zend_Validate_Abstract 
{
	private $site_id = NULL;
	private $template_id = NULL;
	
    const TEMPLATE_NAME_UNIQUE = 'templateNameUnique';

    protected $_messageTemplates = array(
        self::TEMPLATE_NAME_UNIQUE => "The supplied template name is not valid, 
        you have used it for another template"
    );
       
    /**
    * Sets validator options
    *
    * @param integer $site_id Site id to use to limit query
    * @param integer|NULL $template_id Template id to ignore when doing the 
    * 								   check, value required in edit mode so 
    * 								   that row is excluded from query
    * @param array $options
    * @return void
    */
    public function __construct($site_id, $template_id=NULL, 
    $options = array())
    {
    	$this->site_id = $site_id;
    	
        if($template_id != NULL) {
			$this->template_id = $template_id;
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
        
        $model_templates = new Dlayer_Model_Template();
        
        if($model_templates->nameUnique($value, $this->site_id, 
        $this->template_id) == TRUE) {
			return TRUE;
        } else {
			$this->_error(self::TEMPLATE_NAME_UNIQUE);
            return FALSE;
        }
    }
}
