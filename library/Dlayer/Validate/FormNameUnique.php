<?php
/**
* Check to see if the name is unique, needs to be unique for the site id, not 
* the entire table
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: FormNameUnique.php 1211 2013-11-10 14:54:33Z Dean.Blackborough $
*/
class Dlayer_Validate_FormNameUnique extends Zend_Validate_Abstract 
{
	private $site_id = NULL;
	private $form_id = NULL;
	
    const FORM_NAME_UNIQUE = 'formNameUnique';

    protected $_messageTemplates = array(
        self::FORM_NAME_UNIQUE => "The supplied form name is not valid, 
        you have used it for another form"
    );
       
    /**
    * Sets validator options
    *
    * @param integer $site_id Site id to use to limit query
    * @param integer|NULL $form_id Form id to ignore when doing the check, 
    * 							   value required in edit mode so that row is 
    * 							   excluded from query
    * @param array $options
    * @return void
    */
    public function __construct($site_id, $form_id=NULL, 
    $options = array())
    {
    	$this->site_id = $site_id;
    	
        if($form_id != NULL) {
			$this->form_id = $form_id;
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
        
        $model_forms = new Dlayer_Model_Form();
        
        if($model_forms->nameUnique($value, $this->site_id, 
        $this->form_id) == TRUE) {
			return TRUE;
        } else {
			$this->_error(self::FORM_NAME_UNIQUE);
            return FALSE;
        }
    }
}
