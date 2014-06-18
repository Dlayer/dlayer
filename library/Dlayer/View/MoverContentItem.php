<?php
/**
* Generates the html for the movement controls, up and down in the content 
* manager
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: MoverContentItem.php 1640 2014-03-06 10:04:29Z Dean.Blackborough $
*/
class Dlayer_View_MoverContentItem extends Zend_View_Helper_Abstract 
{
    /**
    * Override the hinting for the view property so that we can see the view
    * helpers that have been defined
    *
    * @var Dlayer_View_Codehinting
    */
    public $view;
    
    private $content_id;
    private $div_id;
    private $page_id;
    private $type;
    private $width;
    
    private $html;
    
    /**
    * Generates the html for the movement controls, up and down in the content 
	* manager
    * 
    * @param integer $content_id Id of the content item
    * @param integer $div_id Id of the page div content is applied to
    * @param integer $page_id Id of the page
    * @param string $type Content item type
    * @param integer $width Width of the mover
    * @return Dlayer_View_MoverContentItem
    */
    public function moverContentItem($content_id, $div_id, $page_id, $type, 
    $width) 
    {
        $this->resetParams();
        
        $this->content_id = $content_id;
        $this->div_id = $div_id;
        $this->page_id = $page_id;
        $this->type = $type;
        $this->width = $width;
        
        return $this;
    }
    
    /**
    * Reset any internal params, need to reset the params in case the view 
    * helper is called multiple times within the same view.
    * 
    * @return void
    */
    public function resetParams() 
    {
        $this->content_id = NULL;
        $this->div_id = NULL;
        $this->page_id = NULL;
        $this->type = NULL;
        $this->width = 0;
        
        $this->html = '';
    }
    
    /**
    * Html for the up control
    * 
    * @return Dlayer_View_MoverContentItem 
    */
    public function up() 
    {
        $this->html = $this->movementControls('up', 'Move up');
        
        return $this;
    }
    
    /**
    * Html for the down control
    * 
    * @return Dlayer_View_MoverContentItem 
    */
    public function down() 
    {
    	$this->html = $this->movementControls('down', 'Move down');
        
        return $this;
    }
    
    /**
    * Html for the movement controls
    * 
    * @param string $movement Direction of movement
    * @param string $label Label for movement control
    * @return string
    */
    private function movementControls($movement, $label) 
    {
		return '<div class="move" id="' . 
		$this->view->escape($movement) . ':' . 
        $this->view->escape($this->type) . ':' . 
        $this->view->escape($this->content_id). ':' . 
        $this->view->escape($this->div_id) . ':' . 
        $this->view->escape($this->page_id) . '" style="width:' . 
        $this->width . 'px; display:none;">' . 
        $this->view->escape($label) . '</div>';
    }
    
    /**
    * The view helpers can be output directly, we define the __toString 
    * method so that echo and print calls on the object return the html 
    * 
    * @return string Generated html
    */
    public function __toString() 
    {
        return $this->html;
    }
    
}
