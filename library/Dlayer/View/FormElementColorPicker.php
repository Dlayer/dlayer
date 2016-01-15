<?php
/**
* View helper for the Dlayer colour picker, contains a hidden input and a 
* div to invoke the color picker
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_View_FormElementColorPicker extends Zend_View_Helper_FormElement
{
    public function formElementColorPicker($name, $value = null, 
    $attribs = null)
    {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable

        $xhtml = '<div class="clearfix"></div>'
        		. '<div class="color_picker col-xs-4" id="picker_' 
        		. $this->view->escape($id) . '" style="background-color:' 
        		. $this->view->escape($value) . ';">&nbsp;</div>' 
        		. '<input type="hidden"'
                . ' name="' . $this->view->escape($name) . '"'
                . ' id="' . $this->view->escape($id) . '"'
                . ' value="' . $this->view->escape($value) . '"'
                . $this->_htmlAttribs($attribs)
                . $this->getClosingBracket(); 
                
        if($attribs['clear_link'] == TRUE) {
			$xhtml .= ' <a href="#" class="btn btn-default btn-xs color_picker_clear"> Clear</a>';
		}                

        return $xhtml;
    }
}
