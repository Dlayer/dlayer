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
		$xhtml = '<div class="clearfix"></div>'
				. '<a class="btn btn-danger open-image-picker" '
				. 'href="#" role="button">Select image</a>'  
				. '<input type="hidden"'
				. ' name="' . $this->view->escape($name) . '"'
				. ' id="' . $this->view->escape($id) . '"'
				. ' value="' . $this->view->escape($value) . '"'
				. $this->_htmlAttribs($attribs)
				. $this->getClosingBracket();
				
		$xhtml .= '
		<div class="row image-picker-preview" style="padding-top:5px;">
			<div class="col-xs-12">
				<h4>Selected <small>Preview of selection</small></h4>
			</div>
			<div class="col-xs-4">
				<img src="/images/dlayer/image-picker-preview.jpg" class="ipp-image img-thumbnail" title="Image picker preview" alt="Selected image place holder" width="90" height="70">
			</div>
			<div class="col-xs-8">
				<p>
					<strong>Name:</strong> <span class="ipp-name">[Name]</span><br>
					<strong>Dimenisons:</strong> <span class="ipp-dimensions">[Dimensions]</span><br>
					<strong>Size:</strong> <span class="ipp-size">[Size]</span>
				</p>
			</div>
		</div>';

		return $xhtml;
	}
}
