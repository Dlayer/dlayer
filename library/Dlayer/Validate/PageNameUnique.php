<?php
/**
 * Validate the page name, needs to be unique for the current site
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Validate_PageNameUnique extends Zend_Validate_Abstract 
{
	private $site_id = NULL;
	private $page_id = NULL;
	
    const PAGE_NAME_UNIQUE = 'pageNameUnique';

    protected $_messageTemplates = array(
        self::PAGE_NAME_UNIQUE => "The supplied page name is not valid, you have used it for another page in your web site"
    );

	/**
	 * Set the option for the validator
	 *
	 * @param $site_id
	 * @param integer|null $page_id
	 * @param array $options
	 * @return void
	 */
    public function __construct($site_id, $page_id=NULL, $options=array())
    {
    	$this->site_id = $site_id;
	    $this->page_id = $page_id;
    }

	/**
	 * Validation check
	 *
	 * @param string $value Value to validate
	 * @return boolean
	 */
	public function isValid($value)
    {
        $this->_setValue($value);
        
        $model_pages = new Dlayer_Model_ContentPage();
        
        if($model_pages->nameUnique($value, $this->site_id, $this->page_id) == TRUE)
        {
			return TRUE;
        }
        else
        {
			$this->_error(self::PAGE_NAME_UNIQUE);
            return FALSE;
        }
    }
}
