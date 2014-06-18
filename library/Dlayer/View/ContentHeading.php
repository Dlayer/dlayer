<?php
/**
* A heading is a string wrapped in one of the 7 heading tags. The styles for
* each of the heading types will have already been defined either by the user
* or defaulted when a site was created for the user
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ContentHeading.php 1961 2014-06-17 00:01:52Z Dean.Blackborough $
*/
class Dlayer_View_ContentHeading extends Zend_View_Helper_Abstract
{
    /**
    * Override the hinting for the view property so that we can see the view
    * helpers that have been defined
    *
    * @var Dlayer_View_Codehinting
    */
    public $view;

    /**
    * Data array for the heading
    *
    * @var array
    */
    private $data = array();

    /**
    * Is the content item currently selectable? 
    * 
    * A content item is only selectable when its page div has been selected 
    * and no content items have been selected
    *
    * @var boolean
    */
    private $selectable;

    /**
    * Is this content item currently selected, as in is the content item in 
    * edit mode
    *
    * @var boolean
    */
    private $selected;
    
    /**
    * The number of content items in the page div, used to work out if the 
    * move down control is required for the item
    * 
    * @param integer
    */
    private $items;

    /**
    * A heading is a string wrapped in one of the 7 heading tags. The styles
    * for each of the heading types will have already been defined either by
    * the user or defaulted when a site was created for the user
    *
    * @param array $data Content data array. contains the heading string and
    *                    the css styles for the heading
    * @param boolean $selectable Should the content item be selectable for 
    *                            moving and editing
    * @param boolean $selected Is the content block currently selected for
    *                          editing
    * @param integer $items Total number of content items in page div
    * @return Dlayer_View_ContentHeading
    */
    public function contentHeading(array $data, $selectable=FALSE,
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
    * Before setting an params all internal params are rese incase the view
    * helper is called multiple times within the same script
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
    * Render method, this is the base worker method for the view helper, it
    * generates the html for the content block using the supplied params.
    *
    * @return string The generated html
    */
    private function render()
    {
        $tag = $this->view->escape($this->data['tag']);

        $id = 'heading:heading:' . 
        $this->view->escape($this->data['content_id']);
        $class = NULL;
        $html = '';

        if($this->selectable == TRUE) {

            if($this->selected == TRUE) {
                $class = 'c_selected';
            } else {
                $class = 'c_selectable';
            }
            
            $container_width = intval($this->data['padding_left']) + 
            intval($this->data['width']) + $this->data['container_margin'];
            
            $mover_width = $container_width - 2;
            
            $html .= '<div class="content_item ' . $class . 
            '" style="width:' . $container_width . 'px;">';
            
            $mover = $this->view->moverContentItem($this->data['content_id'], 
            $this->data['div_id'], $this->data['page_id'], 'heading', 
            $mover_width);
            
            if($this->data['sort_order'] != 1) {
                $html .= $mover->up();
            }            
        }

        $html .= '<' . $tag . ' class="item c_item_' . 
        $this->view->escape($this->data['content_id']) . '" id="' . $id . 
        '" style="margin:0px; padding:' . 
        $this->view->escape($this->data['padding_top']) . 'px 0px ' .
        $this->view->escape($this->data['padding_bottom']) . 'px ' .
        $this->view->escape($this->data['padding_left']) . 'px; width:' .
        $this->view->escape($this->data['width']) . 'px;' . 
        $this->view->contentStyles()->contentItem($this->data['content_id']) . 
        '">' .$this->view->escape($this->data['heading']) . '</' . $tag . '>';
        
        if($this->selectable == TRUE) {
            if($this->items != $this->data['sort_order']) {
                $html .= $mover->down();
            }
            $html .= '</div>';
        }

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