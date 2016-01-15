<?php
/**
* Template styles view helper, generates the initial style attribute for 
* each template div, width and height and then calls all the additional 
* template style view helpers to generate the attributes for the rest of 
* the styles that have been defined for each template div
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_View_TemplateStyles extends Zend_View_Helper_Abstract 
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
	* Style attributes data array for the div in the template data array. To 
	* reduce the number of database calls all the styles for the template are 
	* pulled in one go, this data is fed to the styles view helper and passed 
	* to each of the sub view helpers as required
	* 
	* @var array
	*/
	private $styles = array();
	
	/**
	* The Id for the current div
	* 
	* @var integer
	*/
	private $id; 
	
	/**
	* The sizes data array, contains three indexes for the current div, width, 
	* height and fixed height
	* 
	* @var array
	*/
	private $sizes;
	
	/**
	* Does the div have any children, if the div has no children we need to set
	* a min height for the div to ensure that it doesn't collapose.
	* 
	* @var boolean
	*/
	private $children;
	
	/**
	* Is there any defined content for the current content area
	* 
	* @var boolean
	*/
	private $content;
	
	/** 
	* Template styles view helper, generates the initial style attribute for 
	* each template div, width and height and then calls all the additional 
	* template style view helpers to generate the attributes for the rest of 
	* the styles that have been defined for each template div
	* 
	* @return Dlayer_View_TemplateStyles
	*/
	public function templateStyles() 
	{
		return $this;
	}
	
	/**
	* Reset any internal params, need to reset the params in case the view 
	* helper is called multiple times within the same view.
	* 
	* The styles data array is not reset, the array contains data for all the 
	* divs in the temaplate, it would make no sense to clear it, needed for 
	* additional calls
	* 
	* @return void
	*/
	private function resetParams() 
	{
		$this->html = '';
		$this->id = NULL;
		$this->sizes = array();
		$this->children = TRUE;
		$this->content = FALSE;
	}
	
	/**
	* Set the base data for the div, clears any params that have been set by 
	* previous calls within the current view
	* 
	* @param integer $id Id of the current div
	* @param array $sizes Sizes data array, contains indexes for width, height, 
	*                     design_height and whether the div is a fixed height
	*                     div
	* @param boolean $children Does the current div have children
	* @param boolean $content Is there defined content for the selected area
	* @return Dlayer_View_TemplateStyles
	*/
	public function div($id, array $sizes, $children=TRUE, $content=FALSE) 
	{
		$this->resetParams();
		
		$this->id = $id;
		$this->sizes = $sizes;
		$this->children = $children;
		$this->content = $content;

		return $this;
	}
	
	/**
	* Set the template styles data array, this array contains all the defined 
	* styles for the current template. THe array is broken down and the 
	* individual data arrays are passed to the child view helpers. The child 
	* view helpers are reposible for generating the partial style strings for 
	* each style option, background color, border etc
	* 
	* The styles data array is passed in using this method for performance 
	* reasons. The view helper and as a result the child view helpers are 
	* called for each div in the template array if there is style data. All the 
	* view helpers operate on the same array, it is not duplicated.
	* 
	* @param array $styles
	* @return Dlayer_View_TemplateStyles
	*/
	public function setStyles(array $styles)
	{
		$this->styles = $styles;
		
		return $this;
	}
	
	/**
	* Render method, this is the base worker method for the view helper, it 
	* generates the html.
	* 
	* @return string The generated html
	*/
	private function render() 
	{
		// A div always has a width in the designer
		$this->html = " style=\"width:{$this->sizes['width']}px;";

		/**
		* The actual height of a div is either fixed or dynamic, scales with 
		* content. In the designer div without children need a height so that 
		* they can be selected by the user, in those cases a min height is set
		*/
		if($this->sizes['height'] != 0) {
			$this->html .= ' height:' . $this->view->escape(
			$this->sizes['height']) . 'px;';
		} else {
			if($this->children == FALSE) {
				if($this->content == FALSE) {
					$this->html .= ' min-height:' . $this->view->escape(
					$this->sizes['design_height']) . 'px;';
				}
			}
		}
		
		$this->html .= '"';
	
		return $this->html;
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