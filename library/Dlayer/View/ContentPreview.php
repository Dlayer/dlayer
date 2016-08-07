<?php

/**
 * Preview version of the content view helper
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_ContentPreview extends Zend_View_Helper_Abstract
{
	/**
	 * Override the hinting for the view property so that we can see the view
	 * helpers that have been defined
	 *
	 * @var Dlayer_View_Codehinting
	 */
	public $view;

	/**
	 * @var array Content data array for the entire page
	 */
	private $content = array();

	/**
	 * @param integer Id of the current column
	 */
	private $column_id;

	/**
	 * Constructor for view helper, data is set via the setter methods
	 *
	 * @return Dlayer_View_ContentPreview
	 */
	public function contentPreview()
	{
		return $this;
	}

	/**
	 * Set the column id for the column for which we need to generate data
	 *
	 * @param integer $id
	 * @return Dlayer_View_ContentPreview
	 */
	public function setColumnId($id)
	{
		$this->column_id = $id;

		return $this;
	}

	/**
	 * Pass in the content data for the content page. The content data is passed in using this setter because the
	 * view helper will be called many times to generate a content page and we only want to pass what could be a
	 * very large data array once
	 *
	 * @param array $content
	 * @return Dlayer_View_ContentPreview
	 */
	public function setContent(array $content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Generate the html for the content items, it checks to see if there is any content for the currently set
	 * column and then generates the html
	 *
	 * Unlike the majority of the view helpers within Dlayer the render method is public, we will be calling it
	 * directly from other view helpers
	 */
	public function render()
	{
		$html = '';

		if(array_key_exists($this->column_id, $this->content) === TRUE)
		{
			foreach($this->content[$this->column_id] as $content)
			{
				switch($content['type'])
				{
					case 'heading':
						$html .= $this->view->headingPreview($content['data']);
					break;

					case 'text':
						$html .= $this->view->textPreview($content['data']);
					break;

					case 'jumbotron':
						$html .= $this->view->jumbotronPreview($content['data']);
					break;

					case 'image':
						$html .= $this->view->imagePreview($content['data']);
					break;

					case 'form':
						$html .= $this->view->importedFormPreview($content['data']);
					break;

					default:
					break;
				}
			}
		}

		return $html;
	}
}
