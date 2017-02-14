<?php

/**
 * Pass the control bar options to the layout
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Action_PopulateControlBar extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Sey layout properties
     *
     * @param array $buttons Buttons for control bar
     * @param array $dropdowns Drop down data array for control bar
     * @return void
     */
    function direct(array $buttons, array $dropdowns)
    {
        $layout = Zend_Layout::getMvcInstance();
        $layout->assign('show_control_bar', true);
        $layout->assign('control_bar_buttons', $buttons);
        $layout->assign('control_bar_drops', $dropdowns);
    }
}
