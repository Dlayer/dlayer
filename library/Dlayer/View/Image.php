<?php

/**
 * Image content item view helper, image may include a link to expand and a caption
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_Image extends Zend_View_Helper_Abstract
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
	private $data;

	/**
	 * @var boolean Is the content item selectable?
	 */
	private $selectable;

	/**
	 * @var boolean Is the content item selected?
	 */
	private $selected;

	/**
	 * Constructor for view helper, data is set via the setter methods
	 *
	 * @param array $data Content item data array
	 * @param boolean $selectable
	 * @param boolean $selected
	 * @return Dlayer_View_Image
	 */
	public function image(array $data, $selectable = FALSE, $selected = FALSE)
	{
		$this->resetParams();

		$this->data = $data;
		$this->selectable = $selectable;
		$this->selected = $selected;

		return $this;
	}

	/**
	 * Reset any internal params, we do this because the view helper could be called many times within the view script
	 *
	 * @return void
	 */
	private function resetParams()
	{
		$this->data = array();
		$this->selectable = FALSE;
		$this->selected = FALSE;
	}

	/**
	 * Generate the html for the content item
	 *
	 * @return string
	 */
	private function render()
	{
		// The id of a content item is defined as follows [item_type]:[tool]:[id]
		$id = 'image:image:' . $this->view->escape($this->data['content_id']);
		$class = 'content';

		if($this->selectable === TRUE)
		{
			$class .= ' selectable';
		}
		if($this->selected === TRUE)
		{
			$class = ' selected';
		}

		$html = '<div id="' . $id . '" class="' . $class . '"/>';

		$html .= '<img src="/images/library/' . $this->view->escape($this->data['library_id']) . '/' .
			$this->view->escape($this->data['version_id']) . $this->view->escape($this->data['extension']) .
			'" class="img-responsive" title="' . $this->view->escape($this->data['name']) . '" />';

		if(strlen($this->data['caption']) > 0)
		{
			$html .= '<p class="img-caption text-muted text-center small">' . $this->view->escape($this->data['caption']) . '</p>';
		}

		$html .= '</div>';

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
