<?php
/**
* Content item metrics model, fetches all the data required to generate the 
* content item metrics box for the different content items
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Model_Page_Content_Metrics extends Zend_Db_Table_Abstract
{
	private $site_id;
	private $page_id;
	private $div_id;
	private $content_id;
	private $content_type;
	
	/**
	* Property which can be used to validate whether the content item is valid, 
	* stop un-neccesary processing
	* 
	* @var boolean
	*/
	private $valid = FALSE;
	
	/**
	* Default values for border metrics
	* 
	* @var array
	*/
	private $border = array('top'=>0, 'right'=>0, 'bottom'=>0, 'left'=>0);
	
	/**
	* Default values for margin metrics
	* 
	* @var array
	*/
	private $margin = array('top'=>0, 'right'=>0, 'bottom'=>0, 'left'=>0);
	
	/**
	* Default values for the padding metrics
	* 
	* @var array
	*/
	private $padding = array('top'=>0, 'right'=>0, 'bottom'=>0, 'left'=>0);
	
	private $model_position;
	
	/**
	* Fetch all the data values for the selected content item, these values 
	* will be displayed in the content item metrics box inside the Content 
	* manager designer
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_id
	* @return array|FALSE Either the nmetrics data array or FALSE if no 
	* 					   data can be found or the content item isn't valid
	*/
	public function data($site_id, $page_id, $div_id, $content_id) 
	{
		$this->site_id = $site_id;
		$this->page_id = $page_id;
		$this->div_id = $div_id;
		$this->content_id = $content_id;
		
		$this->model_position = new Dlayer_Model_Page_Content_Position();
		
		$this->validContentItem();
		
		if($this->valid == TRUE) {
			$metrics = $this->itemData();
			
			if($metrics != FALSE) {
				return $metrics;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	/**
	* Check that the content item exists and set the $this->content_type 
	* property
	* 
	* @return void
	*/
	private function validContentItem() 
	{
		$sql = "SELECT dct.`name` 
				FROM user_site_page_content uspc 
				JOIN designer_content_types dct ON uspc.content_type = dct.id 
				WHERE uspc.site_id = :site_id 
				AND uspc.page_id = :page_id 
				AND uspc.div_id = :div_id 
				AND uspc.id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $this->div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $this->content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			$this->content_type = $result['name'];
			$this->valid = TRUE;
		}		
	}
	
	/**
	* put your comment there...
	* 
	* @return array|FALSE
	* 
	*/
	private function itemData() 
	{
		switch($this->content_type) {
			case 'text':
				$data = $this->text();
			break;
			
			case 'heading':
				$data = $this->heading();
			break;
			
			case 'form':
				$data = $this->form();
			break;
			
			default:
				$data = FALSE;
			break;
		}
		
		return $data;
	}
	
	/**
	* Fetch all the metric values for the selected text content item
	* 
	* @return array|FALSE Array containing all the metric values or FALSE if 
	* 					  the data could not be selected
	*/
	private function text() 
	{
		$sql = "SELECT uspct.width, uspct.padding 
				FROM user_site_page_content_text uspct 
				WHERE uspct.site_id = :site_id 
				AND uspct.page_id = :page_id 
				AND uspct.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $this->content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			
			$border = $this->border;
			$margin = $this->model_position->marginValues($this->site_id, 
			$this->page_id, $this->div_id, $this->content_id, 'text');
			
			if($margin == FALSE) {
				$margin = $this->margin;
			}
			
			$metrics = array('width'=>intval($result['width']), 
			'height'=>'Dynamic', 'padding'=>array(
			'top'=>intval($result['padding']), 
			'right'=>intval($result['padding']),
			'bottom'=>intval($result['padding']),
			'left'=>intval($result['padding'])), 
			'border'=>$this->border, 'margin'=>$margin);
			
			return $metrics;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch all the metric values for the selected heading content item
	* 
	* @return array|FALSE Array containing all the metric values or FALSE if 
	* 					  the data could not be selected
	*/
	private function heading() 
	{
		$sql = "SELECT uspch.width, uspch.padding_top, uspch.padding_bottom, 
				uspch.padding_left
				FROM user_site_page_content_heading uspch
				WHERE uspch.site_id = :site_id 
				AND uspch.page_id = :page_id 
				AND uspch.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $this->content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			
			$border = $this->border;
			$margin = $this->model_position->marginValues($this->site_id, 
			$this->page_id, $this->div_id, $this->content_id, 'heading');
			
			if($margin == FALSE) {
				$margin = $this->margin;
			}
			
			$metrics = array('width'=>intval($result['width']), 
			'height'=>'Dynamic', 'padding'=>array(
			'top'=>intval($result['padding_top']), 
			'right'=>0, 'bottom'=>intval($result['padding_bottom']),
			'left'=>intval($result['padding_left'])), 
			'border'=>$this->border, 'margin'=>$margin);
			
			return $metrics;
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch all the metric values for the selected form content item
	* 
	* @return array|FALSE Array containing all the metric values or FALSE if 
	* 					  the data could not be selected
	*/
	private function form() 
	{
		$sql = "SELECT uspcf.width, uspcf.padding 
				FROM user_site_page_content_form uspcf 
				WHERE uspcf.site_id = :site_id 
				AND uspcf.page_id = :page_id 
				AND uspcf.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $this->content_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			
			$border = $this->border;
			$margin = $this->model_position->marginValues($this->site_id, 
			$this->page_id, $this->div_id, $this->content_id, 'form');
			
			if($margin == FALSE) {
				$margin = $this->margin;
			}
			
			$metrics = array('width'=>intval($result['width']), 
			'height'=>'Dynamic', 'padding'=>array(
			'top'=>intval($result['padding']), 
			'right'=>intval($result['padding']),
			'bottom'=>intval($result['padding']),
			'left'=>intval($result['padding'])), 
			'border'=>$this->border, 'margin'=>$margin);
			
			return $metrics;
		} else {
			return FALSE;
		}
	}
}