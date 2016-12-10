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
        /**
         * @todo Check the settings for the module
         */
        define('DEFAULT_FONT_FAMILY_FOR_MODULE', 1);
    }
}
