<?php
/**
* Generates the html for the movement controls, up and down in the form 
* builder 
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_View_MoverFormField extends Zend_View_Helper_Abstract 
{
    /**
    * Override the hinting for the view property so that we can see the view
    * helpers that have been defined
    *
    * @var Dlayer_View_Codehinting
    */
    public $view;
    
    private $field_id;
    private $type;
    
    private $html;
    
    /**
    * Generates the html for the movement controls, up and down in the form 
    * builder
    * 
    * @param integer $field_id Id of the form field
    * @param string $type Form field type
    * @return Dlayer_View_MoverFormField
    */
    public function moverFormField($field_id, $type) 
    {
        $this->resetParams();
        
        $this->field_id = $field_id;
        $this->type = $type;
        
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
        $this->field_id = NULL;
        $this->type = NULL;
        
        $this->html = '';
    }
    
    /**
    * Html for the up control
    * 
    * @return string 
    */
    public function up() 
    {
        $this->html = $this->movementControls('up', 'Move up');
        
        return $this;
    }
    
    /**
    * Html for the down control
    * 
    * @return string 
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
        $this->view->escape($this->field_id) . 
        '" style="display:none;">' . 
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
