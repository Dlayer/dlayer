<?php

/**
 * Text content item view helper, a text block is simple a string of text enclosed within p tags
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_Text extends Zend_View_Helper_Abstract
{
	/**
	 * Override the hinting for the view property so that we can see the view
	 * helpers that have been defined
	 *
	 * @var Dlayer_View_Codehinting
	 */
	public $view;

	/**
	 * @var array Data array for the content item
	 */
	private $data = array();

	/**
	 *  Constructor for view helper, data is set via the setter methods
	 *
	 * @param array $data Content item data array
	 * @return Dlayer_View_Text
	 */
	public function text(array $data)
	{
		$this->resetParams();

		$this->data = $data;

		return $this;
	}

	/**
	 * Reset any internal params, we do this because the view helper could be called many times within the view script
	 *
	 * @return void
	 */
	private function resetParams()
	{
		$this->data = NULL;
	}

	/**
	 * Generate the html for the content item
	 */
	private function render()
	{
		// The id of a content item is defined as follows [tool]:[item_type]:[id]
		$id = 'text:text:' . $this->view->escape($this->data['content_id']);

		$html = '<p>' . nl2br($this->view->escape($this->data['content']), TRUE) . '</p>';

		return $html;
	}

	/**
	 * The view helper can be output directly, there is no need to call the render method, simply echo or print
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}
}
