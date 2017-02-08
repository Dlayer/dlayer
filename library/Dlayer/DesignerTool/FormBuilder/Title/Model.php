<?php

/**
 * Data model for the title tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_FormBuilder_Title_Model extends Zend_Db_Table_Abstract
{
    /**
     * Set the titles
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param string $title
     * @param string $subtitle
     *
     * @return boolean
     */
    public function updateTitles($site_id, $form_id, $title, $subtitle)
    {
        
    }
}
