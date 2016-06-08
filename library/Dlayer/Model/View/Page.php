<?php

/**
 * Responsible for fetching all the data that makes up the structure of a content page as well as the content itself
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Page extends Zend_Db_Table_Abstract
{
	/**
	 * @var integer
	 */
	private $site_id;
	/**
	 * @var integer
	 */
	private $page_id;

	/**
	 * Fetch all the content rows that have been assigned to the requested content page, the results will be grouped
	 * by column id with null (0 in code) being rows that are assigned to the body div, rows can only ever be
	 * assigned to columns or the body div
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @return array Always returns an array
	 */
	public function rows($site_id, $page_id)
	{
		$sql = 'SELECT uspsr.id AS row_id, uspsr.column_id 
				FROM user_site_page_structure_row uspsr 
				WHERE uspsr.site_id = :site_id
				AND uspsr.page_id = :page_id 
				ORDER BY uspsr.column_id ASC, uspsr.sort_order ASC';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$rows = array();

		foreach($result as $row)
		{
			if($row['column_id'] !== 0)
			{
				$rows[$row['column_id']][] = array('id' => $row['id']);
			}
			else
			{
				$rows[0][] = array('id' => $row['id']);
			}
		}

		return $rows;
	}

	/**
	 * Fetch all the content items that have been attached to the requested content page, as we loop through the
	 * results the details for each content item type are pulled, the results are group by row id and returned as a
	 * single array
	 *
	 * @return array Content items indexed by row id
	 */
	public function content($site_id, $page_id)
	{
		$this->site_id = $site_id;
		$this->page_id = $page_id;

		$sql = "SELECT uspcr.id AS content_row_id, uspci.id AS content_id, 
				dct.`name` AS content_type 
				FROM user_site_page_content_item uspci 
				JOIN user_site_page_content_rows uspcr 
					ON uspci.content_row_id = uspcr.id 
					AND uspcr.site_id = :site_id 
					AND uspcr.page_id = :page_id 
				JOIN designer_content_type dct ON uspci.content_type = dct.id 
				WHERE uspci.site_id = :site_id 
				AND uspci.page_id = :page_id 
				ORDER BY uspcr.sort_order ASC, uspci.sort_order ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		if(count($result) > 0)
		{

			$content = array();

			foreach($result as $row)
			{
				switch($row['content_type'])
				{
					case 'text':
						$data = $this->text($row['content_id']);
					break;

					case 'heading':
						$data = $this->heading($row['content_id']);
					break;

					case 'form':
						$data = $this->form($row['content_id']);
						if($data != FALSE)
						{
							$data['form'] = new Dlayer_Designer_Form(
								$this->site_id, $data['form_id'], TRUE, NULL);
						}
					break;

					case 'jumbotron':
						$data = $this->jumbotron($row['content_id']);
					break;

					case 'image':
						$data = $this->image($row['content_id']);
					break;

					default:
						$data = FALSE;
					break;
				}

				if($data != FALSE)
				{
					$content[$row['content_row_id']][] =
						array('type' => $row['content_type'], 'data' => $data);
				}
			}

			return $content;
		}
		else
		{
			return array();
		}
	}

	/**
	 * Fetch the data for the text content item
	 *
	 * @param integer $content_id Content id
	 * @return array|FALSE We either return the data array for the text
	 *    content item or FALSE if the data can't be pulled from the database
	 */
	private function text($content_id)
	{
		$model_text = new Dlayer_Model_View_Content_Items_Text();

		return $model_text->data($this->site_id, $this->page_id, $content_id);
	}

	/**
	 * Fetch the data for the jumbotron content item
	 *
	 * @param integer $content_id Content id
	 * @return array|FALSE We either return the data array for the jumbotron
	 *    content item or FALSE if the data can't be pulled from the database
	 */
	private function jumbotron($content_id)
	{
		$model_jumbotron = new Dlayer_Model_View_Content_Items_Jumbotron();

		return $model_jumbotron->data($this->site_id, $this->page_id,
			$content_id);
	}

	/**
	 * Fetch the data for the image content item
	 *
	 * @param integer $content_id Content id
	 * @return array|FALSE We either return the data array for the image content
	 *    item or FALSE if the data can't be pulled from the database
	 */
	private function image($content_id)
	{
		$model_image = new Dlayer_Model_View_Content_Items_Image();

		return $model_image->data($this->site_id, $this->page_id, $content_id);
	}

	/**
	 * Fetch the data for a heading content item
	 *
	 * @param integer $content_id
	 * @return array|FALSE We either return the data array for the heading
	 *    content item or FALSE if the data can't be pulled from the database
	 */
	private function heading($content_id)
	{
		$model_heading = new Dlayer_Model_View_Content_Items_Heading();

		return $model_heading->data($this->site_id, $this->page_id,
			$content_id);
	}

	/**
	 * Fetch the data for a form, forms simply sit in a container defined by
	 * the user, the majority of the form layout options will have been defined
	 * in the Form builder
	 *
	 * @param integer $content_id
	 * @return array|FALSE We either return the data array for the requested
	 *    content item of FALSE if the data can't be pulled
	 */
	private function form($content_id)
	{
		$model_form = new Dlayer_Model_View_Content_Items_Form();

		return $model_form->data($this->site_id, $this->page_id, $content_id);
	}
}
