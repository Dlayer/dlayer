<?php

/**
 * Preview version of the image content item view helper
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_ImagePreview extends Zend_View_Helper_Abstract
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
	 * Constructor for view helper, data is set via the setter methods
	 *
	 * @param array $data Content item data array
	 * @return Dlayer_View_ImagePreview
	 */
	public function imagePreview(array $data)
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
		$this->data = array();
	}

	/**
	 * Generate the html for the content item
	 *
	 * @return string
	 */
	private function render()
	{
		$html = '<a href="#" class="image-modal-dialog">';
		$html .= '<img src="/images/library/' . $this->view->escape($this->data['library_id']) . '/' .
			$this->view->escape($this->data['version_id']) . $this->view->escape($this->data['extension']) .
			'" class="img-responsive" title="' . $this->view->escape($this->data['name']) . '" />';

		if(strlen($this->data['caption']) > 0)
		{
			$html .= '<p class="img-caption text-muted text-center small">' . $this->view->escape($this->data['caption']) . '</p>';
		}
		$html .= '</a>';

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
