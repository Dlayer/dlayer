<?php
/**
* A ribbon displays for every tool, each ribbon has a number of tabs
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Tab.php 1928 2014-06-12 13:53:38Z Dean.Blackborough $
*/
class Dlayer_Ribbon_Tab
{
    private $model_ribbon_tab;

    /**
    * Set up any properties required by the class
    *
    * @return void
    */
    public function __construct()
    {
        $this->model_ribbon_tab = new Dlayer_Model_Ribbon_Tab();
    }

    /**
    * Fetch the view script for the tool tab, the view script is typically
    * a folder which matches the tool followed by a view script for the
    * requested tab. If the tool isn't valid or currently enabled FALSE will be
    * returned.
    *
    * @param integer $module
    * @param string $tool Requested tool name
    * @param string $tab Requested tool tab name
    * @return string|FALSE Either the view script or FALSE if tool not valid
    *                      for some reason
    */
    public function viewScript($module, $tool, $tab)
    {
        return $this->model_ribbon_tab->tabViewScript($module, $tool, $tab);
    }

    /**
    * Fetch the multi use status of the tool tab. If the tool tab is a multi
    * user tool after processing the user will be returned back to the
    * designer with the tool and tab still selected
    *
    * @param string $module
    * @param string $tool
    * @param string $tab
    * @return boolean
    */
    public function multiUse($module, $tool, $tab)
    {
        return $this->model_ribbon_tab->multiUseToolTab($module, $tool, $tab);
    }

    /**
    * Fetch the data that is required to generate the ribbon html for the
    * requested tool and tab
    *
    * @param string $module
    * @param string $tool
    * @param string $tab
    * @param boolean $edit_mode If the current tool in edit mode
    * @return array
    */
    public function viewData($module, $tool, $tab, $edit_mode=FALSE)
    {
        $session_dlayer = new Dlayer_Session();

        switch($module) {
            case 'template':
                $template_ribbon = new Dlayer_Ribbon_Data_Template();
                $session_template  = new Dlayer_Session_Template();

                $data = $template_ribbon->viewData($session_dlayer->siteId(),
                $session_template->templateId(), $session_template->divId(),
                $tool, $tab);
            break;

            case 'content':
                $content_ribbon = new Dlayer_Ribbon_Data_Content();
                $session_content  = new Dlayer_Session_Content();

                $data = $content_ribbon->viewData($session_dlayer->siteId(),
                $session_content->pageId(), $session_content->divId(),
                $tool, $tab, $session_content->contentId(), $edit_mode);
            break;

            case 'form':
                $form_ribbon = new Dlayer_Ribbon_Data_Form();
                $session_form = new Dlayer_Session_Form();

                $data = $form_ribbon->viewData($session_dlayer->siteId(),
                $session_form->formId(), $tool, $tab,
                $session_form->fieldId(), $edit_mode);
            break;
            
            case 'website':
                $data = NULL;
            break;
            
            case 'image':
                $image_ribbon = new Dlayer_Ribbon_Data_Image();
                $session_image  = new Dlayer_Session_Image();

                $data = $image_ribbon->viewData($session_dlayer->siteId(),
                $tool, $tab, $session_image->id(), 
                $session_image->id(Dlayer_Session_Image::CATEGORY), 
                $session_image->id(Dlayer_Session_Image::SUBCATEGORY), 
                $edit_mode);
            break;

            default:
                throw new Exception('Module "' . $module . '"not set in ' .
                __CLASS__ . ' ' . __METHOD__);
            break;
        }

        return $data;
    }
}