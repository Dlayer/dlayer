<?php

/**
 * Form for the text content item tool
 *
 * The form is used by the Text content item to allow a user to define or edit
 * a text content item, a text content item is essentially just a plain text
 * block. This form is also used by the edit version of the tool.
 *
 * @todo Work on this form and then create the base form for the module
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Content_Text extends Dlayer_Form
{
	/**
	 * Set up the tool elements, these are the elements that are part of every tool and set the environment
	 * properties and tool options
	 *
	 * @return void The elements are written to the $this->elements private property
	 */
	protected function addToolElements()
	{
		// Tool
		// content type
		// Multi-use

		// Page id
		// row id
		// column id
		// content id
	}

	protected function addUserElements()
	{
		// Name
		// Text
	}

	protected function addSubmitElement()
	{
		// Submit
	}


	protected function setUpFormElements()
	{
		// TODO: Implement setUpFormElements() method.
	}

	protected function addCustomElementDecorators()
	{
		// TODO: Implement addCustomElementDecorators() method.
	}

	/**
	 * Add validation rules
	 *
	 * @return void
	 */
	protected function validationRules()
	{
		// TODO: Implement validationRules() method.
	}

	/**
	 * Add the default element decorators
	 *
	 * @return void
	 */
	protected function addDefaultElementDecorators()
	{
		// TODO: Implement addDefaultElementDecorators() method.
	}
}
