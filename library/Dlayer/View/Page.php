<?php
/**
* Content page view helper, generates all the html for a content page by first
* creating the template, adding the content rows to the content areas and then
* assigning the content items to the content rows.
*
* The content items, rows, and all styles, template and content items have been
* passed into the view helper, these are passed to the relevant view helpers as
* soon as possible for performance reasons and then it is down to each
* dependant view helper to check for data in the base data arrays
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_View_Page extends Zend_View_Helper_Abstract
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
	* Template data array, multi-dimensional array contains all the divs that
	* make up the template
	*
	* @var array
	*/
	private $template;

	/**
	* Id of the selected content area
	*
	* @var integer|NULL
	*/
	private $selected_div_id;

	/**
	* Id of the selected content row
	*
	* @var integer|NULL
	*/
	private $selected_content_row_id;

	/**
	* Id of the selected content item
	*
	* @var integer|NULL
	*/
	private $selected_content_id;

	/**
	* Content page view helper, generates all the html for a content page by
	* first creating the template, adding the content rows to the content
	* areas and then assigning the content items to the content rows.
	*
	* The content items, rows, and all styles, template and content items
	* have been passed into the view helper, these are passed to the relevant
	* view helpers as soon as possible for performance reasons and then it
	* is down to each dependant view helper to check for data in the base
	* data arrays
	*
	* @param array $template Template div data array
	* @param array $content_rows Content row data array for the page
	* @param array $content Content data array for page, contains the
	* 	raw data for all the content items that have been assigned to the
	* 	current page
	* @param array $template_styles Template styles data array, contains all
	* 	the styles for the divs that make up the template the page is based
	* 	upon
	* @param array $content_row_styles Content row styles data array, contains 
	* 	all the styles that have been assigned to the content rows for the 
	* 	current page
	* @param array $content_container_styles Content container styles data 
	* 	array, contains all the styles that have been assigned to the content 
	* 	item containers for the current page
	* @param array $content_styles Content styles data array, contains all
	* 	the styles that have been assigned to content items for the current
	* 	page
	* @param integer|NULL $div_id Id of the currently selected div, referred to
	* 	later as the content area
	* @param integer|NULL $content_row_id Id of the selected content row
	* @param integer|NULL $content_id Id of the selected content item
	* @return Dlayer_View_Page
	*/
	public function page(array $template, array $content_rows, array $content,
		array $template_styles, array $content_row_styles, 
		array $content_container_styles, array $content_styles, 
		$selected_div_id=NULL, $selected_content_row_id=NULL, 
		$selected_content_id=NULL)
	{
		$this->resetParams();

		// Assign template array and set designer ids
		$this->template = $template;
		
		$this->selected_div_id = $selected_div_id;
		$this->selected_content_row_id = $selected_content_row_id;
		$this->selected_content_id = $selected_content_id;
		
		/** 
		* Pass the template styles data array to the base template styles 
		* view helper, the template styles view helper will call child view 
		* helpers for each of the defined style groups
		*/
		$this->view->templateStyles()->setStyles($template_styles);
		
		/**
		* Pass in the content row styles indexed by style type for all the 
		* content row defined on the content page. The content row styles 
		* view helper will call a child view helper for each of the defined 
		* styles
		*/
		$this->view->contentRowStyles()->setStyles($content_row_styles);
		
		/**
		* Pass in the content item container styles indexed by style type for 
		* all the content items defined on the content page. The content 
		* container styles view helper will call a child view helper for 
		* each of the defined styles
		*/
		$this->view->contentContainerStyles()->setStyles(
			$content_container_styles);
			
		/**
		* Pass in the content item styles indexed by style type for 
		* all the content items defined on the content page. The content 
		* styles view helper will call a child view helper for each of the 
		* defined styles
		*/
		$this->view->contentItemStyles()->setStyles($content_styles);
		
		/** 
		* Pass the content rows data array to the content row view helper, 
		* the content row view helper calls the content view helper
		*/
		$this->view->contentRow()->setContentRows($content_rows);
		
		/**
		* Pass the content data array to the base content view helper, the 
		* content view helper will call a child content view for each of the 
		* content types.
		*/
		$this->view->content()->setContent($content);

		return $this;
	}

	/**
	* Reset any internal params, we need to reset the params for the view 
	* helper in case it is called multiple times within the same view
	*
	* @return Dlayer_View_Page
	*/
	private function resetParams()
	{
		$this->html = '';
		$this->template = array();
		$this->selected_div_id = NULL;
		$this->selected_content_row_id = NULL;
		$this->selected_content_id = NULL;
		
		/**
		* Reset the data arrays for all the depeendant view helpers
		*/
		$this->view->templateStyles()->setStyles(array());
		$this->view->contentContainerStyles()->setStyles(array());
		$this->view->content()->setContent(array());

		return $this;
	}

	/**
	* Render method, this is the base worker method for the view helper, it 
	* loops through the first level of the template data array and then calls 
	* a recursive method on each id to generate the html for any and all 
	* children
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
				
				// Set the styles for the template div
				$this->html .= $this->templateStyles($div['id'], 
					$div['sizes'], $params['children'], FALSE);
				
				// Set the css classes
				$this->html .= "{$params['class']}>";
				
				/**
				* Generate all the child html by calling the recursive 
				* childHtml method
				*/
				$this->html .= $this->childHtml($div['id'], 
					$div['children'], $div['sizes']['fixed']);
					
				// Close the template div
				$this->html .= '</div>' . PHP_EOL;
			}
		} else {
			throw new Exception('There are no items in the template array');
			
			/**
			* THis method is here for historical purposes only, the base div 
			* for a template used to be defined here, now the base div is 
			* defined in the database
			*/
		}

		return $this->html;
	}

	/**
	* Recursive method to ghenerate the html for all the child template 
	* divs, their stylying and all the content. It will carry on being called 
	* until there are no more child divs
	* 
	* If there are no children for a given div this method calls the content 
	* row view helkper which in turns calls the content and styling view 
	* helpers.
	*
	* @param integer $parent_id
	* @param array $children Array of the child divs
	* @param integer $fixed Fixed height setting for parent/container,
	* 						1 or 0.
	* @return string
	*/
	function childHtml($parent_id, array $children, $fixed)
	{
		$html = '';

		if(count($children) > 0) {
			foreach($children as $div) {

				$params = $this->divParams($div['children'], $div['id']);
				
				// Generate the content row html
				$this->view->contentRow()->divId($div['id']);
				$this->view->contentRow()->selectedDivId($this->selected_div_id);
				$this->view->contentRow()->selectedContentRowId(
					$this->selected_content_row_id);
				$this->view->contentRow()->selectedContentId(
					$this->selected_content_id);			

				$content_rows = $this->view->contentRow()->render();
				
				$content = FALSE;
				
				if(strlen($content_rows) > 0) {
					$content = TRUE;
				}

				$html .= "<div id=\"template_div_{$div['id']}\"";
				$html .= $this->templateStyles($div['id'], $div['sizes'],
					$params['children'], $content);
				$html .= "{$params['class']}>" . PHP_EOL;
				$html .= $this->childHtml($div['id'], $div['children'],
					$div['sizes']['fixed']);
				$html .= '</div>' . PHP_EOL;
			}
		} else {
			// Generate the content row html
			$this->view->contentRow()->divId($parent_id);
			$this->view->contentRow()->selectedDivId($this->selected_div_id);
			$this->view->contentRow()->selectedContentRowId(
				$this->selected_content_row_id);
			$this->view->contentRow()->selectedContentId(
				$this->selected_content_id);			

			$content_rows = $this->view->contentRow()->render();
			
			$content = FALSE;
			
			if(strlen($content_rows) > 0) {
				$content = TRUE;
			}
			
			if($content == TRUE) {
				$html .= $content_rows;
			} else {
				if($fixed == 1) {
					$label = 'Fixed height';
				} else {
					$label = 'Dynamic height';
				}

				$html .= '
				<div class="row">
				<div class="col-md-12">
				<h3>' . $label . ' content area <small>Add content rows and then content items to this area</small></h3>
				</div>
				</div>' . PHP_EOL;
			}
		}

		return $html;
	}

	/**
	* Generate the style style for the given tem,plate div, calls a view helper 
	* which in turns calls a child view helper for each style group
	*
	* @param integer $id Div id
	* @param array $sizes Sizes data array for the div
	* @param boolean $children Does the div have any children?
	* @param boolean $content Is there defined content for the content area
	* @return string
	*/
	private function templateStyles($id, $sizes, $children, $content=FALSE)
	{
		return $this->view->templateStyles()->div($id, $sizes, $children, 
			$content);
	}

	/**
	* Set the params for the current div, this is the selector class, bootstrap 
	* container class and a boolean stating whether or not the div has children
	* 
	* @return array
	*/
	private function divParams(array $children, $id)
	{
		$child_divs = FALSE;
		$class = 'container';

		if(count($children) == 0) {
			$class = 'container';
			
			if($this->selected_div_id != NULL) {
				if($this->selected_content_row_id == NULL && 
				$this->selected_div_id == $id) {
					$class .= ' selected-area';	
				}				
			} else {
				if($this->selected_div_id == NULL) {
					if($this->selected_content_row_id == NULL) {}
					$class .= ' selectable';
				}
			}
			
			$class = 'class="' . $class . '"';			
		} else {
			$class = '';
			$child_divs = TRUE;
		}

		return array('children'=>$child_divs, 'class'=>$class);
	}

	/**
	* THis view helper can be ouput directly using print and echo, there is no 
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