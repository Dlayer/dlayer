<?php
/**
* Custom session class for Dlayer itself, this will manage the selected site, 
* the core environment settings and the details for the current user
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Session extends Zend_Session_Namespace 
{
    /**
    * @param string $namespace
    * @param bool $singleInstance
    * @return void
    */
    public function __construct($namespace='dlayer_session', 
    $singleInstance=false) 
    {
        parent::__construct($namespace, $singleInstance);
        
        /**
        * @todo Expiration timeout needs to be read from config
        */
        $this->setExpirationSeconds(3600);
    }
    
    /**
    * Set the id of the site the user wants to work on
    * 
    * @param integer $id
    * @return void
    */
    public function setSiteId($id) 
    {
        $this->site_id = intval($id);
    }
    
    /**
    * Get the id of the site the user is currently working on
    * 
    * @return integer
    */
    public function siteId() 
    {
        return intval($this->site_id);
    }

    /**
    * Set the identity id
    * 
    * @param integer $identity_id 
    * @return void
    */
    public function setIdentityId($identity_id) 
    {
		$this->identity_id = intval($identity_id);
    }
    
    /**
    * Identity id
    * 
    * @return integer|FALSE FALSE if an identity_id does not exists in session
    */
    public function identityId() 
    {
		if(isset($this->identity_id) && $this->identity_id != NULL) {
			return $this->identity_id;
		} else {
			return FALSE;
		}
    }
    
    /**
    * Clear all session vars
    * 
    * @return void
    */
    public function clearAll() 
    {
		unset($this->identity_id);
		unset($this->module);
		unset($this->site_id);
    }
}
