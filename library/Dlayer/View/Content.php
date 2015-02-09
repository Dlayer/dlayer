<?php
/**
* Base content view helper, called by the template class for each div, generates 
* all the htmlo for the content blocks by passing the requests onto the child 
* view helpers
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_View_Content extends Zend_View_Helper_Abstract 
{
	/**
	* Override the hinting for the view property so that we can see the view 
	* helpers that have been defined
	* 
	* @var Dlayer_View_Codehinting
	*/
	public $view;

	/**
	* Full content data array for the entire page, passed into the view helper 
	* once and reused for subsequent calls
	* 
	* @var array
	*/
	private $content = array();

	/**
	* Current div id
	* 
	* @param integer
	*/
	private $div_id;

	/**
	* Selected div id
	* 
	* @param integer|NULL
	*/
	private $selected_div_id;

	/**
	* Selected content id
	* 
	* @param integer|NULL
	*/
	private $content_id;

	/** 
	* Content view helper, generates the html for each of the content blocks. 
	* This is done by passing the details for each content block type onto a 
	* child view helper, these view helpers generate their html and pass it 
	* back so it can be return to the page template view helper
	* 
	* @return Dlayer_View_Content
	*/
	public function content() 
	{
		return $this;
	}

	/**
	* Set the id for the current div. This is used to check if there is any 
	* content to display for the selected div
	* 
	* @param integer $div_id Id of the current div
	* @return Dlayer_View_Content
	*/
	public function divId($div_id) 
	{
		$this->div_id = $div_id;

		return $this;
	}

	/**
	* Set the id for the selected div id
	* 
	* @param integer|NULL $selected_div_id
	* @return Dlayer_View_Content
	*/
	public function selectedDivId($selected_div_id) 
	{
		$this->selected_div_id = $selected_div_id;

		return $this;
	}

	/**
	* Set the id for the selected content item, this is usesd to turn the 
	* selecting on and off for content items, if the content id is not NULL 
	* we turn off the ability to select a content item
	* 
	* @param integer $div_id Id of the selected content block
	* @return Dlayer_View_Content
	*/
	public function contentId($content_id) 
	{
		$this->content_id = $content_id;

		return $this;
	}

	/**
	* Set the content data array for the entire page. This array contains all 
	* the content blocks.
	* 
	* The content data array is passed in using this method for performance 
	* reasons. The view helper is called many times per page, each call needs
	* access to the content array, by setting it before calling the view code 
	* we can ensure that it only needs to be set once.
	* 
	* @param array $content
	* @return Dlayer_View_Content
	*/
	public function setContent(array $content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	* Render method, this is the worker method for the view helper, it checks 
	* to see if there is any defined content for the requested div and if 
	* found loops over the array calling the relevant view helpers. The 
	* result html from each view helper is written to the html param to later ]
	* be passed back to the page template view helper.
	* 
	* Unlike most of the view helper the render method is public in this view 
	* helper
	* 
	* @return string The generated html
	*/
	public function render() 
	{
		$html = '';
		if(array_key_exists($this->div_id, $this->content) == TRUE) {

			$selectable = FALSE;

			if($this->selected_div_id != NULL && 
			$this->selected_div_id == $this->div_id) {
				$selectable = TRUE;
			}

			$items = count($this->content[$this->div_id]);

			foreach($this->content[$this->div_id] as $content_item) {

				if($content_item['data']['content_id'] == $this->content_id) {
					$selected = TRUE;
				} else {
					$selected = FALSE;
				}

				switch($content_item['type']) {
					case 'text':
						$html .= $this->view->contentText(
							$content_item['data'], $selectable, $selected,  $items);
						break;

					case 'heading':                                        
						$html .= $this->view->contentHeading(
							$content_item['data'], $selectable, $selected, $items);
						break;

					case 'form':                                        
						$html .= $this->view->contentForm(
							$content_item['data'], $selectable, $selected, $items);
						break;

					default:
						break;
				}
			}
		}

		return $html;
	}
}