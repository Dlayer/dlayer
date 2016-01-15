<?php
/**
* A form content item is simply a form from the Content manager in a container, 
* the majority of the form display options will be defined as part of the form, 
* this view helper will only add custom options defined by sub tools
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_View_ContentForm extends Zend_View_Helper_Abstract
{
	/**
	* Override the hinting for the view property so that we can see the view
	* helpers that have been defined
	*
	* @var Dlayer_View_Codehinting
	*/
	public $view;

	/**
	* Data array for the form item
	*
	* @var array
	*/
	private $data = array();

	/**
	* Is the content item currently selectable? 
	* 
	* @var boolean
	*/
	private $selectable;

	/**
	* Is the content item currently selected withing the designer view?
	*
	* @var boolean
	*/
	private $selected;

	/**
	* The number of content items in the content row
	* 
	* @param integer
	*/
	private $items;

	/**
	* A form content item is simply a form from the Content manager in a 
	* container, the majority of the form display options will be defined as 
	* part of the form, this view helper will only add custom options 
	* defined by sub tools
	* 
	* @param array $data Content data array. containns all the data required 
	* 	to generate the html for the requested Form builder form
	* @param boolean $selectable Should the selectable class be applied to the 
	* 	content item, a content item is selectable when its content row has 
	* 	been selected
	* @param boolean $selected Should the selected class be applied to the 
	* 	content item, an item is selected when in edit mode, either by being 
	* 	selectable directly or after addition
	* @param integer $items The total number of content items within the 
	* 	content row, this is to help with the addition of the visual movment 
	* 	controls
	* @return Dlayer_View_ContentForm
	*/
	public function contentForm(array $data, $selectable=FALSE,
		$selected=FALSE, $items=1)
	{	
		$this->resetParams();

		$this->data = $data;
		$this->selectable = $selectable;
		$this->selected = $selected;
		$this->items = $items;

		return $this;
	}

	/**
	* Reset any internal params, we need to reset the params for the view 
	* helper in case it is called multiple times within the same view
	*
	* @return void
	*/
	private function resetParams()
	{
		$this->data = NULL;
		$this->selectable = FALSE;
		$this->selected = FALSE;
	}

	/**
	* This is the worker method for the view helper, it generates the html 
	* for the content item and the html for the content item container and 
	* the movement controls
	*
	* @return string The generated html
	*/
	private function render()
	{
		/**
		* The id for a content item is defined as the content type, 
		* tool used to create the item and then the id for the content item, 
		* this allows the selectors to set the correct environment vars
		*/
		$id = 'form:import-form:' . $this->view->escape(
			$this->data['content_id']);
		$container_class = 'imported-form item content-container-' .  
			$this->view->escape($this->data['content_id']);
		$content_class = 'content-' . $this->view->escape(
			$this->data['content_id']);
			
		if($this->selectable == TRUE) {
			if($this->selected == FALSE) {
				$container_class .= ' selectable';
			} else {
				$container_class .= ' selected-item';
			}
		}
		
		if($this->data['size'] != NULL) {
			$width = 'col-md-' . $this->view->escape($this->data['size']);
		} else {
			$width = 'col-md-12';
		}
		
		if($this->data['offset'] != NULL) {
			$width .= ' col-md-offset-' . $this->view->escape(
				$this->data['offset']);
		}
		
		$container_styles = $this->view->contentContainerStyles()->contentItem(
			$this->data['content_id']);
			
		$content_item_styles = $this->view->contentItemStyles()->contentItem(
			$this->data['content_id']);
			
		$html = '<div class="' . $width . ' ' . $container_class . '"' . 
			' id="' . $id . '"'; 
		$html .= $container_styles;
		$html .= '>';
		$html .= '<div class="' . $content_class . '"'; 
		$html .= $content_item_styles;
		$html .= '>';
		
		if($this->data['titles']['show'] == TRUE) {
			$html .= '<h3>';
			$html .= $this->view->escape($this->data['titles']['title']);
			if(strlen($this->data['titles']['sub_title']) > 0) {
				$html .= ' <small>' . 
					$this->view->escape($this->data['titles']['sub_title']) . 
					'</small>';
			}
			$html .= '</h3>';
		}
		
		$html .= $this->data['form']->form();
		$html .= '</div>';
		$html .= '</div>';

		return $html;
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