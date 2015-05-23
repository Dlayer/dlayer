<?php
/**
* View helper for Dlayer image picker
* 
* @author Dean Blackborough <dean@g3d-development.com>
*/
class Dlayer_View_FormElementImagePicker extends Zend_View_Helper_FormElement
{
	public function formElementImagePickler($name, $value = null, 
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
		
		$xhtml .= '<input type="text"'
				. ' name="' . $this->view->escape($name) . '"'
				. ' id="' . $this->view->escape($id) . '"'
				. ' value="Click to choose an image"'
				. $disabled
				. $this->_htmlAttribs($attribs)
				. $this->getClosingBracket();

		return $xhtml;
	}
}
