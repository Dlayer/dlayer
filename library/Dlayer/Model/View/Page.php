<?php
/**
* Content page view model
*
* The view model is responsible for fetching all the data required to generate
* a content page.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
* @category View model
*/
class Dlayer_Model_View_Page extends Zend_Db_Table_Abstract
{
	private $site_id;
	private $page_id;
	
	/**
	* fetch all the content rows that have been defined for the requested 
	* page, results are grouped by template div id
	* 
	* @poram integer $site_id
	* @param integer $page_id
	* @return array An array containing all the content rows grouped by div id, 
	* 	if there are no results an empty array is returned
	*/
	public function contentRows($site_id, $page_id) 
	{
		$sql = "SELECT uspcr.div_id, uspcr.id AS content_row_id 
				FROM user_site_page_content_rows uspcr 
				WHERE uspcr.site_id = :site_id 
				AND uspcr.page_id = :page_id 
				ORDER BY uspcr.div_id ASC, uspcr.sort_order ASC ";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		
		$content_rows = array();
		
		if(count($result) > 0) {
			foreach($result as $row) {
				$content_rows[$row['div_id']][] = 
					array('id'=>$row['content_row_id']);
			}
		}
		
		return $content_rows;
	}

	/**
	* Fetch all the content items that have been defined for the requested 
	* page, as we loop through the results the details for each particula 
	* content item are fetched from the relevant data tables. The results are 
	* grouped by content row id and then returned as a single array
	*
	* @return array An array of the content indexed by content row id, if 
	* 	there is no content the returned array is empty
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

		if(count($result) > 0) {

			$content = array();

			foreach($result as $row) {
				switch($row['content_type']) {
					case 'text':
						$data = $this->text($row['content_id']);
						break;

					case 'heading':
						$data = $this->heading($row['content_id']);
						break;

					case 'form':
						$data = $this->form($row['content_id']);
						if($data != FALSE) {
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
				
				if($data != FALSE) {
					$content[$row['content_row_id']][] = 
						array('type'=>$row['content_type'], 'data'=>$data);
				}
			}

			return $content;
		} else {
			return array();
		}
	}

	/**
	* Fetch the data for the text content item
	*
	* @param integer $content_id Content id
	* @return array|FALSE We either return the data array for the text 
	* 	content item or FALSE if the data can't be pulled from the database
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
	* 	content item or FALSE if the data can't be pulled from the database
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
	* 	item or FALSE if the data can't be pulled from the database
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
	* 	content item or FALSE if the data can't be pulled from the database
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
	* 	content item of FALSE if the data can't be pulled
	*/
	private function form($content_id)
	{
		$model_form = new Dlayer_Model_View_Content_Items_Form();
		return $model_form->data($this->site_id, $this->page_id, $content_id);
	}
}
