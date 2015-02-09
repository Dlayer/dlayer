<?php
/**
* This is the base content view helper, it is called by the content row view 
* helper and generates all the html the content items that have been added to 
* the requested row, once all the html has been generated the string is passed 
* back to the content row view helper.
* 
* The html for individual content items is handled by child view helpers, there 
* is one for each content type, this helper passes the requests on and then 
* concatenates the output
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
	* Full content data array for the entire page, passed into the view 
	* helper once and reused for all subsequent calls, more performant
	* 
	* @var array
	*/
	private $content = array();

	/**
	* Id of the current content row
	* 
	* @param integer
	*/
	private $content_row_id;

	/**
	* If od the selected content row
	* 
	* @param integer|NULL
	*/
	private $selected_content_row_id;

	/**
	* Id of the selected content item
	* 
	* @param integer|NULL
	*/
	private $selected_content_id;

	/** 
	* This is the base content view helper, it is called by the content row 
	* view helper and generates all the html the content items that have been 
	* added to the requested row, once all the html has been generated the 
	* string is passed back to the content row view helper.
	* 
	* The html for individual content items is handled by child view 
	* helpers, there is one for each content type, this helper passes the 
	* requests on and then concatenates the output
	* 
	* @return Dlayer_View_Content
	*/
	public function content() 
	{
		return $this;
	}
	
	/**
	* Set the id of the current content row, this is used to check if there 
	* is any content to be generated
	* 
	* @param integer $id Id of the current content row
	* @return Dlayer_View_Content
	*/
	public function contentRow($id) 
	{
		$this->content_row_id = $id;
	}
	
	/**
	* Set the id of the selected content row, this controls whether or not the 
	* content items within the row should have the selectable class applied to 
	* them
	* 
	* @param integer $id Id of the selected content row
	* @return Dlayer_View_Content
	*/
	public function selectedContentRowId($id) 
	{
		$this->selected_content_row_id = $id;

		return $this;
	}
	
	/**
	* Set the id of the selected content item, this controls whether or not the 
	* selected class is applied to the content item
	* 
	* @param integer $id Id of the selected content item
	* @return Dlayer_View_Content
	*/
	public function selectedContentId($id) 
	{
		$this->selected_content_id = $id;

		return $this;
	}

	/**
	* Set the content data array for the entire page, this array contains all 
	* the content items.
	* 
	* The content data array is passed in using this method for performance 
	* reasons, this view helper will be called many times by the content row 
	* view helper, once per content area row, they all need access to 
	* the same data so it makes sense to set it once.
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
	* THis is the worker method for the view helper, it checks to see if there 
	* is any defined content for the current content row and then passes the 
	* request of to the relevant child view helper. 
	* 
	* The result html is stored until all the content items have been generated
	* and then the concatenated string is passed back to the content row view 
	* helper
	* 
	* Unlike the majority of view helpers this method is public because it 
	* will called directly in other view helpers 
	* 
	* @return string The generated html
	*/
	public function render() 
	{
		$html = '';
		
		if(array_key_exists($this->content_row_id, $this->content) == TRUE) {
			
			foreach($this->content[$this->content_row_id] as $content) {
				
				$selectable = FALSE;
				$selected = FALSE;
				$items = count($this->content[$this->content_row_id]);
				
				if($this->selected_content_row_id != NULL && 
					$this->selected_content_row_id == $this->content_row_id) {
						$selectable = TRUE;
				}
				
				$selected = FALSE;
				
				if($this->selected_content_id != NULL && 
					$this->selected_content_id == $content['data']['content_id']) {
						$selected = TRUE;
				}
				
				switch($content['type']) {
					/*case 'text':
						$html .= $this->view->contentText(
							$content['data'], FALSE, FALSE, 1);
						break;*/

					case 'heading':                                        
						$html .= $this->view->contentHeading(
							$content['data'], $selectable, $selected, $items);
						break;

					case 'form':                                        
						$html .= $this->view->contentForm(
							$content['data'], FALSE, FALSE, 1);
						break;

					default:
						break;
				}
				
			}
			
			/*

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
			}*/
		}

		return $html;
	}
}