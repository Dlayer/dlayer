<?php
/**
* Content area styles view helper, generates the style string for each of the 
* content areas on the page, it will call a child view helper for each of the 
* styling groups that can be assigned to content areas.
* 
* Content areas are template divs, I only use a different name to signify 
* context, initially this view helper and the template styles view helper will 
* be very similar, that will change as both designers evolve
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_View_ContentAreaStyles extends Zend_View_Helper_Abstract 
{
	/**
	* Override the hinting for the view property so that we can see the view 
	* helpers that have been defined
	* 
	* @var Dlayer_View_Codehinting
	*/
	public $view;

	/**
	* The Id of the current content row
	* 
	* @var integer
	*/
	private $id; 
	
	private $sizes;
	private $children;
	private $content;
	
	/**
	* The complete styles data array for all the content areas that make up 
	* the content page, grouped by style type
	* 
	* @var array
	*/
	private $styles;
	
	/**
	* Partial style string
	* 
	* @var string
	*/
	private $html;
	
	/** 
	* Content area styles view helper, generates the style string for each of 
	* the content areas on the page, it will call a child view helper for each 
	* of the styling groups that can be assigned to content areas
	* 
	* @return Dlayer_View_ContentAreaStyles
	*/
	public function contentAreaStyles() 
	{
		return $this;
	}
	
	/**
	* Reset any internal params, we need to reset the internal params in case 
	* the view helper is called multiple times within the same script.
	* 
	* The styles data array is not reset as it contains the data for all the 
	* content items currently defined on the page, this view helper is called 
	* by each content item so to increase performances we only set the 
	* styles data once
	* 
	* @return void
	*/
	private function resetParams() 
	{
		$this->html = '';
		$this->id = NULL;
		$this->sizes = array();
		$this->children = FALSE;
		$this->content = FALSE;
	}
	
	/**
	* Set the id of the current content area, in addition this will call the 
	* reset method to clear any previousy set values
	* 
	* @param integer $id
	* @param array $sizes
	* @param boolean $children
	* @param boolean $content
	* @return Dlayer_View_ContentAreaStyles
	*/
	public function contentArea($id, array $sizes, $children=FALSE, 
		$content=FALSE) 
	{
		$this->resetParams();
		
		$this->id = $id;
		$this->sizes = $sizes;
		$this->children = $children;
		$this->content = $content;

		return $this;
	}
	
	/**
	* Pass in the styles data array, this array contains any and all content 
	* area styles defined for the page
	* 
	* The styles data array is indexed by style type, the render method will 
	* check each of the style types and call a child view helper where relevant
	* 
	* The styles data array is passed into the view helper using this method 
	* for performance reasons. This view helper and as a result all the child 
	* view helpers will be called for each content area, the data is passed 
	* in once by this method in the page view helper to ensure we aren't 
	* passing around several copies of what could be a large array.
	* 
	* @param array $styles The defined styles for every content area that makes 
	* 	up the page
	* @return Dlayer_View_ContentAreaStyles
	*/
	public function setStyles(array $styles)
	{
		$this->styles = $styles;
		
		return $this;
	}
	
	/**
	* This is the worker method for the view helper, it is responsible for 
	* calling each of the child view helpers to generate a style string if 
	* data is defined for the current content area
	* 
	* @return string The generated html
	*/
	private function render() 
	{
		$html = '';
		
		
		$html = "width:{$this->sizes['width']}px;";

		/**
		* The actual height of a div is either fixed or dynamic, scales with 
		* content. In the designer div without children need a height so that 
		* they can be selected by the user, in those cases a min height is set
		*/
		if($this->sizes['height'] != 0) {
			$html .= ' height:' . $this->view->escape($this->sizes['height']) . 
				'px;';
		} else {
			if($this->children == FALSE) {
				if($this->content == FALSE) {
					$html .= ' min-height:' . $this->view->escape(
					$this->sizes['design_height']) . 'px;';
				}
			}
		}
		
		if(array_key_exists('background_colors', $this->styles) == TRUE && 
			array_key_exists($this->id, 
				$this->styles['background_colors']) == TRUE) {
			
			$html .= $this->view->stylesBackgroundColor(
				$this->styles['background_colors'][$this->id]);
		}
		
		$this->html = ' style="' . $html . '" ';
		
		return $this->html;
	}
	
	/**
	* This view helper can be ouput directly using print and echo, there is no 
	* need to call the render method. The __toString method is defined to allow 
	* this functionality, all it does it call the render method
	*
	* @return string The html generated by the render method
	*/
	public function __toString() 
	{
		return $this->render();
	}
}