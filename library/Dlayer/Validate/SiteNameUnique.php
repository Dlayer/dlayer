<?php

/**
 * Check to see if the name is unique, needs to be unique for the user,
 * not for the entire table
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Validate_SiteNameUnique extends Zend_Validate_Abstract
{
    private $identity_id;
    private $site_id = null;

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
     *                               check, value required in edit mode so row is
     *                               excluded from query
     * @param array $options
     * @return void
     */
    public function __construct(
        $identity_id,
        $site_id = null,
        $options = array()
    ) {
        $this->identity_id = $identity_id;

        if ($site_id != null) {
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

        $model = new Dlayer_Model_Admin_Site();

        if ($model->nameUnique($value, $this->identity_id, $this->site_id) === true) {
            return true;
        } else {
            $this->_error(self::SITE_NAME_UNIQUE);
            return false;
        }
    }
}
