<?php
/**
* View helper for Dlayer image picker
* 
* @author Dean Blackborough <dean@g3d-development.com>
*/
class Dlayer_View_FormElementImagePicker extends Zend_View_Helper_FormElement
{
	public function formElementImagePicker($name, $value = null, 
		$attribs = null)
	{
		$info = $this->_getInfo($name, $value, $attribs);
		extract($info); // name, value, attribs, options, listsep, disable

		// build the element
		$disabled = '';
		if ($disable) {
			// disabled
			$disabled = ' disabled="disabled"';
		}
		
		$xhtml = '<div class="clearfix"></div>'
				. '<a class="btn btn-danger open-image-picker-tool" href="#" role="button">Select image</a>'  
				. '<input type="hidden"'
				. ' name="' . $this->view->escape($name) . '"'
				. ' id="' . $this->view->escape($id) . '"'
				. ' value="' . $this->view->escape($value) . '"'
				. $this->_htmlAttribs($attribs)
				. $this->getClosingBracket();

		return $xhtml;
	}
}
