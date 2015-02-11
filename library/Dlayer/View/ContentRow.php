<?php
/**
* Content row view helper, this is called by the page view helper on each 
* content area div, it is resposible for calling the content view helper on 
* each of the generated rows.
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_View_ContentRow extends Zend_View_Helper_Abstract 
{
	/**
	* Override the hinting for the view property so that we can see the view 
	* helpers that have been defined
	* 
	* @var Dlayer_View_Codehinting
	*/
	public $view;
	
	/**
	* Full content row data array for the entire page, passed into the view 
	* helper once and reused for all subsequent calls, more performant
	* 
	* @var array
	*/
	private $content_rows = array();
	
	/**
	* Id of the current div
	* 
	* @param integer
	*/
	private $div_id;
		
	/**
	* Id of the selected template div
	* 
	* @param integer|NULL
	*/
	private $selected_div_id;
	
	/**
	* Id of the selected content row,
	* 
	* @param integer|NULL
	*/
	private $selected_content_row_id;
	
	/**
	* Id of the selected content
	* 
	* @param integer|NULL
	*/
	private $selected_content_id;
	
	/** 
	* The content row view helpers generated the invisible content rows 
	* divs, these hoold content items, for each content row the content view 
	* helper is called which in turns generates the page comtent
	* 
	* @return Dlayer_View_ContentRow
	*/
	public function contentRow() 
	{
		return $this;
	}
	
	/**
	* Set the id of the current template div, this is used to check to see 
	* if there are any defined content rows
	* 
	* @param integer $id Id of the current div
	* @return Dlayer_View_ContentRow
	*/
	public function divId($id) 
	{
		$this->div_id = $id;

		return $this;
	}
	
	/**
	* Set the id of the selected template div, this controls whether or not 
	* the selectable class should be applied to a content row, if it is a child 
	* of the template div it is selectable
	* 
	* @param integer|NULL $id Id of the selected div
	* @return Dlayer_View_ContentRow
	*/
	public function selectedDivId($id) 
	{
		$this->selected_div_id = $id;
		
		return $this;
	}
	
	/**
	* Set the id of the selected content row, this controls whether or not the 
	* selected class is applied to the content row, it is also allows us 
	* to control whether or not content items will be selectable
	* 
	* @param integer $id Id of the selected content row
	* @return Dlayer_View_ContentRow
	*/
	public function selectedContentRowId($id) 
	{
		$this->selected_content_row_id = $id;

		return $this;
	}
	
	/**
	* Set the id of the selected content item, this controls whether or not 
	* the selected class is applied to a content item when it is generated.
	* 
	* @param integer $id Id of the selected content row
	* @return Dlayer_View_ContentRow
	*/
	public function selectedContentId($id) 
	{
		$this->selected_content_id = $id;

		return $this;
	}
	
	/**
	* Set the data for the content rows, data array will be for the entire 
	* page.
	* 
	* The content row data array is passed in using this method for 
	* performance reasons, this view helper will be called many times by the 
	* page view helper, once for each end child div, they all need access to 
	* the same data so it makes sense to set it once.
	* 
	* @param array $content_rows
	* @return Dlayer_View_ContentRow
	*/
	public function setContentRows(array $content_rows)
	{
		$this->content_rows = $content_rows;
		
		return $this;
	}
	
	/**
	* The is the worker method for the view helper, it checks to see if there 
	* are content rows for the current template div id and then calls the 
	* bnase content view helper to generate the content for each row
	* 
	* Unlike the majority of view helpers this method is public because it 
	* will called directly in other view helpers 
	* 
	* @return string The generated html
	*/
	public function render() 
	{
		$html = '';
				
		if(array_key_exists($this->div_id, $this->content_rows) == TRUE) {
						
			foreach($this->content_rows[$this->div_id] as $content_row) {
				
				$class = 'row';
					
				if($this->selected_div_id != NULL && 
					$this->selected_div_id == $this->div_id) {
					
					if($content_row['id'] == $this->selected_content_row_id) {
						$class .= ' selected-row';
					} else {
						if($this->selected_content_row_id == NULL) {
							$class .= ' selectable"';
						}
					}
				}
				
				/**
				* Fetch the content for the current content row, request 
				* passed off to content view helper
				*/
				$this->view->content()->contentRow($content_row['id']);
				$this->view->content()->selectedContentRowId(
					$this->selected_content_row_id);
				$this->view->content()->selectedContentId(
					$this->selected_content_id);
				
				$content = $this->view->content()->render();
				
				if(strlen($content) != 0) {
					$row_content = $content;
				} else {
					$row_content = '<h3>Content row 
					<small>Add content items to this row</small></h3>';
				}
				
				$html .= "<div id=\"content_row_{$content_row['id']}\" ";
				$html .= "class=\"" . $class . "\">" . $row_content;
				$html .= '</div>';
			}
		}
	
		return $html;
	}
}