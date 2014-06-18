<?php
/**
* Set the layout file to use for the controller, typically in the case of 
* Dlayer these will match the name of the module that the controller is in
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: SetLayout.php 47 2012-06-23 15:25:29Z Dean.Blackborough $
*/
class Dlayer_Action_SetLayout extends Zend_Controller_Action_Helper_Abstract
{
    /**
    * Set the layout file to use for the controller, typically in the case of 
    * Dlayer these will match the name of the module that the controller is in, 
    * pass in the file name without the extension, layout file must exist in 
    * /applications.views/layouts
    * 
    * @param string $layout Name of layout file, no extension
    * @return void
    */
    function direct($layout) 
    {
        Zend_Layout::getMvcInstance()->setLayout($layout);
    }
}