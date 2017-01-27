<?php
/**
* Base class for all the layout helper classes
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
*/
abstract class Dlayer_Form_LayoutDecorator
{
	protected $builder;
	protected $selected_field_id;
	
	/**
	* @param boolean $builder Is the form being rendered in builder mode
	* @param integer|NULL $selected_field_id Id of the field currently selected 
	* 	in the designer, NULL if nothing is set
	* @return void
	*/
	public function __construct($builder=FALSE, $selected_field_id=NULL)
	{
		$this->builder = $builder;
		$this->selected_field_id = $selected_field_id;
	}
	
	/**
	* Return the data array for the form decorator
	* 
	* @return array
	*/
	abstract public function form();
	
	/**
	* Fetch the decorator array for form fields
	* 
	* @param integer $field_id Id of the current field
	* @param integer|NULL $selected_field_id Id of the field selected in the 
	* 	designer or NULL
	* @param integer $options Optional options array
	* @return array
	*/
	abstract public function field($field_id, array $options=array());
}
