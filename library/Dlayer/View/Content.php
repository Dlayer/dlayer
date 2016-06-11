<?php

/**
 * Base content view helper, it gets called by the column view helper and generates the data for all the content items
 * that sit in the container. The html for the individual content items is handled by a view helper for each content
 * type
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_View_Content extends Zend_View_Helper_Abstract
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
	 * @param integer|NULL Id of the selected column, if any
	 */
	private $selected_content_id;

	/**
	 * Constructor for view helper, data is set via the setter methods
	 *
	 * @return Dlayer_View_Content
	 */
	public function content()
	{
		return $this;
	}

	/**
	 * Set the column id for the column for which we need to generate data
	 *
	 * @param integer $id
	 * @return Dlayer_View_Content
	 */
	public function setColumnId($id)
	{
		$this->column_id = $id;

		return $this;
	}

	/**
	 * Set the id of the selected content item, this controls whether or not the selected class get applied to a
	 * content item
	 *
	 * @param integer $id Id of the selected content item
	 * @return Dlayer_View_Column
	 */
	public function setSelectedContentId($id)
	{
		$this->selected_content_id = $id;

		return $this;
	}

	/**
	 * Set the content data array for the entire page, this array contains all
	 * the content items.
	 *
	 * The content data array is passed in using this method for performance
	 * reasons, this view helper will be called many times by the content row
	 * view helper, once per content area row, they all need access to
	 * the same data so it makes sense to set it once.
	 *
	 * @param array $content
	 * @return Dlayer_View_Content
	 */
	public function setContent(array $content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * THis is the worker method for the view helper, it checks to see if there
	 * is any defined content for the current content row and then passes the
	 * request of to the relevant child view helper.
	 *
	 * The result html is stored until all the content items have been generated
	 * and then the concatenated string is passed back to the content row view
	 * helper
	 *
	 * Unlike the majority of view helpers this method is public because it
	 * will called directly in other view helpers
	 *
	 * @param boolean $preview Is the view helper is preview mode
	 * @return string The generated html
	 */
	public function render($preview = FALSE)
	{
		$html = '';

		if(array_key_exists($this->content_row_id, $this->content) == TRUE)
		{

			foreach($this->content[$this->content_row_id] as $content)
			{

				$selectable = FALSE;
				$selected = FALSE;
				$items = count($this->content[$this->content_row_id]);

				if($this->selected_content_row_id != NULL &&
					$this->selected_content_row_id == $this->content_row_id
				)
				{
					$selectable = TRUE;
				}

				$selected = FALSE;

				if($this->selected_content_id != NULL &&
					$this->selected_content_id == $content['data']['content_id']
				)
				{
					$selected = TRUE;
				}

				switch($content['type'])
				{
					case 'text':
						$html .= $this->view->contentText($content['data'],
							$selectable, $selected, $items);
					break;

					case 'heading':
						$html .= $this->view->contentHeading(
							$content['data'], $selectable, $selected, $items);
					break;

					case 'jumbotron':
						$html .= $this->view->contentJumbotron(
							$content['data'], $selectable, $selected, $items);
					break;

					case 'form':
						$html .= $this->view->contentForm($content['data'],
							$selectable, $selected, $items);
					break;

					case 'image':
						$html .= $this->view->contentImage($content['data'],
							$selectable, $selected, $items, $preview);
					break;

					default:
					break;
				}

			}
		}

		return $html;
	}
}
