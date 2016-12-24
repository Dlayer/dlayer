<?php
/**
* Bootsrap for the content module, content module allows a user to create pages 
* and manage the content for pages
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Content_Bootstrap extends Zend_Application_Module_Bootstrap 
{
    public function _initModuleDefaults()
    {
        $dlayer_session = new Dlayer_Session();
        $model_settings = new Dlayer_Model_Settings();

        $font_and_text_settings = $model_settings->definedFontAndTextSettings('content', $dlayer_session->siteId());

        if ($font_and_text_settings !== false) {
            define('DEFAULT_FONT_FAMILY_FOR_MODULE', intval($font_and_text_settings['font_family_id']));
            define('DEFAULT_TEXT_WEIGHT_FOR_MODULE', intval($font_and_text_settings['text_weight_id']));
        }
    }
}
