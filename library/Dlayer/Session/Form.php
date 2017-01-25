<?php

/**
 * Custom session class for the Form Builder, stores all the vars that we need to manage the environment,
 * attempting to not have any visible get vars which may confuse the user.
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Session_Form extends Zend_Session_Namespace
{
    /**
     * @param string $namespace
     * @param bool $singleInstance
     * @return void
     */
    public function __construct(
        $namespace = 'dlayer_session_form',
        $singleInstance = false
    ) {
        parent::__construct($namespace, $singleInstance);

        $this->setExpirationSeconds(3600);
    }

    /**
     * Set the id for the selected form
     *
     * @todo This should check validity
     * @param integer $id
     *
     * @return boolean
     */
    public function setFormId($id)
    {
        $this->form_id = intval($id);

        return true;
    }

    /**
     * Get the id of the current form
     *
     * @return integer|NULL
     */
    public function formId()
    {
        return $this->form_id;
    }

    /**
     * Clears all the session values for the Form Builder
     *
     * @param boolean $reset If set to true the form id is also cleared
     * @return void
     */
    public function clearAll($reset = false)
    {
        if ($reset === true) {
            $this->form_id = null;
        }
    }

    /**
     * Clear the currently set field id, set field_id to NULL
     *
     * @return void
     */
    public function clearFieldId()
    {
        $this->field_id = null;
    }
}
