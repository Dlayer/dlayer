<?php
/**
* Template view helper, generates the html for the selected template, 
* essentially it just loops through the divs that make up the template adding 
* the styles, widgets and forms as necessary
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Template.php 1724 2014-04-13 15:12:59Z Dean.Blackborough $
*/
class Dlayer_View_Template extends Zend_View_Helper_Abstract 
{
	/**
	* Override the hinting for the view property so that we can see the view 
	* helpers that have been defined
	* 
	* @var Dlayer_View_Codehinting
	*/
	public $view;

	/**
	* Generated html
	* 
	* @var string
	*/
	private $html;

	/**
	* template data array, multi-dimensional array contains all the divs that 
	* make up the template
	* 
	* @var array
	*/
	private $template;

	/**
	* Styles data array for the entire template
	* 
	* @var array
	*/
	private $styles;

	/**
	* Selected element
	* 
	* @var integer|NULL
	*/
	private $div_id;

	/** 
	* Template layout view helper, generates the html for the selected template,
	* essentially it just loops through the divs that make up the template
	* adding the styles as necessary
	* 
	* @param array $template Div template data array
	* @param array $styles Styles data array for template
	* @param integer|NULL $div_id Selected element in designer
	* @return Dlayer_View_Template
	*/
	public function template(array $template, array $styles, 
		$div_id=NULL) 
	{
		$this->resetParams();

		$this->template = $template;
		$this->styles = $styles;
		$this->div_id = $div_id;

		// Pass the style attributes array to the styles view helper
		$this->view->templateStyles()->setStyles($this->styles);

		return $this;
	}

	/**
	* Reset any internal params, need to reset the params in case the view 
	* helper is called multiple times within the same view.
	* 
	* @return Dlayer_View_Template
	*/
	private function resetParams() 
	{
		$this->html = '';
		$this->temaplate = array();
		$this->styles = array();
		$this->div_id = NULL;

		return $this;
	}

	/**
	* Render method, this is the base worker method for the view helper, it 
	* loops through the first level of the template array calling a recursive 
	* method to generate the htmlo for any and all children
	* 
	* @return string The generated html
	*/
	private function render() 
	{
		if(count($this->template) > 0) {

			$this->html  = '';

			foreach($this->template as $div) {

				$params = $this->divParams($div['children'], $div['id']);

				$this->html .= "<div id=\"template_div_{$div['id']}\"";                
				$this->html .= $this->templateStyles($div['id'], $div['sizes'], 
					$params['children']);
				$this->html .= "{$params['class']}>" . PHP_EOL;
				$this->html .= $this->childHtml($div['id'], 
					$this->div_id, $div['children']);
				$this->html .= '</div>' . PHP_EOL;
			}
		} else {
			// The template has not yet been worked on, show a default div 
			// for the user to work on
			if($this->div_id === 0) {
				$class = ' class="selected"';
			} else {
				$class = ' class="selectable"';
			}

			$this->html = "<div id=\"template_div_0\" ";
			$this->html .= "style=\"width:" . Dlayer_Config::DESIGNER_WIDTH . 
			"px; min-height:" . Dlayer_Config::DESIGNER_HEIGHT . "px;\"";
			$this->html .= "{$class}>&nbsp;</div>" .PHP_EOL;
		}

		return $this->html;
	}

	/**
	* Rescursive method to generate the html for the child divs, continues 
	* calling itself until there are no more children for the gioven div
	* 
	* @param integer $parent_id
	* @param integer $div_id Id of the selected div
	* @param array $children Array of the child divs
	* @return string
	*/
	function childHtml($parent_id, $div_id=NULL, array $children) 
	{
		$html = '';

		if(count($children) > 0) {
			foreach($children as $div) {

				$params = $this->divParams($div['children'], $div['id']);

				$html .= "<div id=\"template_div_{$div['id']}\"";
				$html .= $this->templateStyles($div['id'], $div['sizes'], 
					$params['children']);
				$html .= "{$params['class']}>" . PHP_EOL;
				$html .= $this->childHtml($div['id'], $div_id, 
					$div['children']);
				$html .= '</div>' . PHP_EOL;
			}
		} else {
			$html .= '
			<div class="row">
			<div class="col-md-12">
			<h3>Content block <small>This area can be split or have widgets 
				or forms added to it.</small></h3>
			</div>
			</div>';
		}

		return $html;
	}

	/**
	* Generate the style string for the given div, calls a view helper which in 
	* terms calls a view helper for each style attribute
	* 
	* @param integer $id Div id
	* @param array $sizes Sizes data array for the div
	* @param boolean $children Does the div have any children?
	* @return string
	*/
	private function templateStyles($id, $sizes, $children) 
	{
		return $this->view->templateStyles()->div($id, $sizes, $children);
	}

	/**
	* Set the params for the current div, currently the selector class and 
	* the boolean for whether or not there are children
	* 
	* @return array
	*/
	private function divParams(array $children, $id) 
	{
		$child_divs = FALSE;
		$class = '';

		if(count($children) == 0) {			
			if($this->div_id != NULL && $this->div_id == $id) {
				$class = ' class="selected container"';
			} else {
				$class = ' class="selectable container"';
			}
		} else {
			$child_divs = TRUE;
		}

		return array('children'=>$child_divs, 'class'=>$class);
	}

	/**
	* The view helpers can be output directly, no need to call and return the 
	* render method, we define the __toString method so that echo and print 
	* calls on the object return the html generated by the render method
	* 
	* @return string The html generated by the render method
	*/
	public function __toString() 
	{
		return $this->render();
	}
}