<?php
/**
* Content page view helper, generates the html for a content page by first 
* looping through the template divs to create a page and then adding the 
* content items, widgets as forms as the divs are added to the page
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
    * Selected element
    *
    * @var integer|NULL
    */
    private $div_id;

    /**
    * Selected content
    *
    * @var integer|NULL
    */
    private $content_id;

    /**
    * Content page view helper, generates the html for a content page by first 
    * looping through the template divs to create a page and then adding the 
    * content items, widgets as forms as the divs are added to the page
    * 
    * @param array $template Template div data array
    * @param array $template_styles Template styles data array, contains all 
    * 								styles for template divs
    * @param array $contennt_styles Content styles data array, contains all the 
    * 								styles for the content containers
    * @param array $content Content data array for page
    * @param integer|NULL $div_id Selected element in designer
    * @param integer|NULL $content_id Selected element in designer
    * @return Dlayer_View_Page
    */
    public function page(array $template, array $template_styles, 
    array $content_styles, array $content, $div_id=NULL, $content_id=NULL)
    {
        $this->resetParams();

        $this->template = $template;
        $this->div_id = $div_id;
        $this->content_id = $content_id;
        
        // Pass the style attributes array to the styles view helper
        $this->view->templateStyles()->setStyles($template_styles);

        // Pass the content to the base content view helper
        $this->view->content()->setContent($content);
        
        // Pass the additional styles attributes to the styles view helper
        $this->view->contentStyles()->setStyles($content_styles);

        return $this;
    }

    /**
    * Reset any internal params, need to reset the params in case the view
    * helper is called multiple times within the same view.
    *
    * @return Dlayer_View_Page
    */
    private function resetParams()
    {
        $this->html = '';
        $this->template = array();
        $this->div_id = NULL;
        $this->content_id = NULL;
        $this->view->templateStyles()->setStyles(array());
        $this->view->contentStyles()->setStyles(array());

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
				$this->html .= $this->childHtml($div['id'], $div['children'], 
					$div['sizes']['fixed']);
                $this->html .= '</div>' . PHP_EOL;
            }
        } else {
            // The template has not yet been worked on, show a default div
            // for the user to work on
            if($this->div_id == NULL) {
                $class = ' class="selectable"';
            } else {
                $class = ' class="selected"';
            }

            $this->html = "<div id=\"template_div_0\" ";
            $this->html .= "style=\"width:" . Dlayer_Config::DESIGNER_WIDTH . 
            "px; min-height:" . Dlayer_Config::DESIGNER_HEIGHT . "px;\"";
            $this->html .= "{$class}>&nbsp;</div>" . PHP_EOL;
        }

        return $this->html;
    }

    /**
    * Rescursive method to generate the html for the child divs, continues
    * calling itself until there are no more children for the given div.
    * If a div has no children the content view helper is called to checked for
    * content, content can only be added to a template div that has no children
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

                $html .= "<div id=\"template_div_{$div['id']}\"";
                $html .= $this->templateStyles($div['id'], $div['sizes'],
                $params['children']);
                $html .= "{$params['class']}>" . PHP_EOL;
                $html .= $this->childHtml($div['id'], $div['children'], 
                	$div['sizes']['fixed']);
                $html .= '</div>' . PHP_EOL;
            }
        } else {
            //$this->view->content()->divId($parent_id);
            //$this->view->content()->contentId($this->content_id);
            //$this->view->content()->selectedDivId($this->div_id);
            
            //$content = $this->view->content()->render();

            //if(strlen($content) > 0) {
              //  $html .= $content . PHP_EOL;
            //} else {
            	if($fixed == 1) {
            		$label = 'Fixed height';
            	} else {
            		$label = 'Dynamic height';
				}
				
				$html .= '
				<div class="row">
				<div class="col-md-12">
				<h3>' . $label . ' content block <small>Add content items to this area</small></h3>
				</div>
				</div>' . PHP_EOL;
            //}
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
    * Set the params for the current div, currently the selector class, 
    * bootstrap container class and a boolean for children
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