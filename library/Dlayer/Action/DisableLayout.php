<?php
/**
* Turns off the layout for the controller, this will generally be called in 
* AJAX and redirect actions, no point loading the layout if we aren't intending 
* on uysing it.
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: DisableLayout.php 1942 2014-06-15 12:52:34Z Dean.Blackborough $
*/
class Dlayer_Action_DisableLayout extends Zend_Controller_Action_Helper_Abstract
{
    /**
    * Turns off the layout for the controller, this will generally be called in 
    * AJAX and redirect actions, no point loading the layout if we aren't 
    * intending on using it, we can optionally disable the view script
    * 
    * @param boolean $view_script Render view script
    * @return void
    */
    function direct($view_script=TRUE) 
    {
        Zend_Layout::getMvcInstance()->disableLayout();
        
        if($view_script == FALSE) {
            $helper = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'viewRenderer');
            $helper->setNoRender(TRUE);
        }
    }
}