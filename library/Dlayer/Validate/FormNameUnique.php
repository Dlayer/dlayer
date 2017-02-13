<?php

/**
 * Validation for the form name, needs to be unique for the site
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Validate_FormNameUnique extends Zend_Validate_Abstract
{
    private $site_id = null;
    private $form_id = null;

    const FORM_NAME_UNIQUE = 'formNameUnique';

    protected $_messageTemplates = array(
        self::FORM_NAME_UNIQUE => "The name you have entered is already being used by another form, please try again"
    );

    /**
     * Set the options for the validator
     *
     * @param $site_id
     * @param integer|null $form_id
     * @param array $options
     */
    public function __construct($site_id, $form_id = null, array $options = array())
    {
        $this->site_id = $site_id;
        $this->form_id = $form_id;
    }

    /**
     * The validation check
     *
     * @param string $value The value to check
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        $model = new Dlayer_Model_Admin_Form();
        if ($model->nameUnique($value, $this->site_id, $this->form_id) === true) {
            return true;
        } else {
            $this->_error(self::FORM_NAME_UNIQUE);
            return false;
        }
    }
}
