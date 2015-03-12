<?php
/**
* Page content model, handles all the generic database changes for the
* content type models
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Content.php 1568 2014-02-14 14:59:50Z Dean.Blackborough $
*/
class Dlayer_Model_Page_Content extends Zend_Db_Table_Abstract
{
	/**
	* Add a new content row to the requested content area (div id)
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @return integer Id of the newly created content row
	*/
	public function addContentRow($site_id, $page_id, $div_id) 
	{
		$sort_order = $this->newRowSortOrderValue($site_id, $page_id, $div_id, 
			'user_site_page_content_rows');
			
		$sql = 'INSERT INTO user_site_page_content_rows 
				(site_id, page_id, div_id, sort_order) 
				VALUES 
				(:site_id, :page_id, :div_id, :sort_order)';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();
		
		return intval($this->_db->lastInsertId('user_site_page_content_rows'));
	}
	
	/**
	* Add a new content item into the content items table, this is not the 
	* data for the item itself, just the base definition for an item, the 
	* specific item data will be stored in a sub table
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param string $content_type
	* @return integer The Id of the newly created content item
	*/
	public function addContentItem($site_id, $page_id, $div_id, 
		$content_row_id, $content_type)
	{
		$sort_order = $this->newItemSortOrderValue($site_id, $page_id, 
		$content_row_id);

		$sql = "INSERT INTO user_site_page_content_item 
				(site_id, page_id, row_id, content_type, sort_order)
				VALUES
				(:site_id, :page_id, :content_row_id,
				(SELECT id FROM designer_content_type 
				WHERE `name` = :content_type), :sort_order)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();

		return intval($this->_db->lastInsertId('user_site_page_content_item'));
	}
	
	/**
	* Calculate the new sort order value for the new content row, 
	* fetches the current MAX value and then increments by 1
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id 
	* @return integer New sort order
	*/
	private function newRowSortOrderValue($site_id, $page_id, $div_id) 
	{
		$sql = "SELECT IFNULL(MAX(sort_order), 0) + 1 AS sort_order
				FROM user_site_page_content_rows 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND div_id = :div_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();

		return intval($result['sort_order']);
	}
	
	/**
	* Calculate the new sort order value for the new content item, 
	* fetches the current MAX value and then increments by 1
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id 
	* @return integer New sort order
	*/
	private function newItemSortOrderValue($site_id, $page_id, $content_row_id) 
	{
		$sql = "SELECT IFNULL(MAX(sort_order), 0) + 1 AS sort_order
				FROM user_site_page_content_item 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND row_id = :content_row_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();

		return intval($result['sort_order']);
	}
	
	/**
	* Check to see if the given content row id is valid, it has to belong to 
	* the supplied div id, page and site
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @return boolean TRUE if the content row id is valid
	*/
	public function validContentRowId($site_id, $page_id, $div_id, 
		$content_row_id) 
	{
		$sql = 'SELECT uspcr.id
				FROM user_site_page_content_rows uspcr
				WHERE uspcr.site_id = :site_id 
				AND uspcr.page_id = :page_id 
				AND uspcr.div_id = :div_id 
				AND uspcr.id = :content_row_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Check to see if the requested content item is valid, it has to belong
	* to the requested page, be for the requested div and also be of the
	* correct content type
	*
	* @param integer $content_id
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param string $content_type
	* @return boolean
	*/
	public function valid($content_id, $site_id, $page_id, $div_id, 
		$content_row_id, $content_type)
	{
		$sql = "SELECT uspci.id 
				FROM user_site_page_content_item uspci 
				JOIN user_site_page_content_rows uspcr ON uspci.row_id = uspcr.id 
					AND uspcr.div_id = :div_id 
					AND uspcr.site_id = :site_id 
					AND uspcr.page_id = :page_id 
				JOIN designer_content_type dct 
					ON uspci.content_type = dct.id 
					AND dct.`name` = :content_type 
				WHERE uspci.site_id = :site_id 
				AND uspci.page_id = :page_id 
				AND uspci.row_id  = :content_row_id
				AND uspci.id = :content_id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	* Move the requested content item, either moves up or down increasing or 
	* descreasing the display sort order
	* 
	* Once the sort order of the current item has been calculated and the 
	* id of the sibling item that needs to be altered has been calcualted two 
	* requests are sent to update the sort orders
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param string $content_type
	* @param string $direction
	* @return void
	*/
	public function moveContentItem($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, $content_type, $direction)
	{
		$sort_order = $this->itemSortOrder($site_id, $page_id, $div_id, 
			$content_row_id, $content_id, $content_type);
		
		var_dump($sort_order);
			
		die;
			
		$process = FALSE;

		if($sort_order != FALSE) {
			switch($direction) {
				case 'up':
					if($sort_order > 1) {						
						$sibling_content_id = 
							$this->contentItemBySortOrder($site_id, $page_id, 
							$content_row_id, $sort_order-1);
							
						if($sibling_content_id != FALSE) {
							$process = TRUE;
							$new_sort_order = $sort_order - 1;
							$sibling_sort_order = $sort_order;
						}
					}
				break;

				case 'down':
					if($sort_order < $this->numberOfContentItems($site_id,
					$page_id, $content_row_id)) {
						$sibling_content_id = 
							$this->contentItemBySortOrder($site_id, $page_id, 
							$content_row_id, $sort_order+1);
							
						if($sibling_content_id != FALSE) {
							$process = TRUE;
							$new_sort_order = $sort_order + 1;
							$sibling_sort_order = $sort_order;
						}
					}
				break;

				default:
					throw new Exception('Direction \'' . $direction . '\' not
					found in Dlayer_Model_Page_Content::moveContentItem()');
				break;
			}
			
			// Update the sort orders for the selected content item and the 
			// affected content item
			if($process == TRUE) {				
				$this->setContentItemSortOrder($site_id, $page_id, 
					$content_row_id, $content_id, $new_sort_order);
					
				$this->setContentItemSortOrder($site_id, $page_id, 
					$content_row_id, $sibling_content_id, $sibling_sort_order);
			}
		} else {
			throw new Exception('Error returned when trying to fetch the 
				sort order of the content item in 
				Dlayer_Model_Page_Content::moveContentItem();');
		}
	}
	
	/**
	* Update the sort order for a content row
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id 
	* @param integer $content_row_id
	* @param integer $sort_order
	*/
	private function setContentRowSortOrder($site_id, $page_id, $div_id, 
		$content_row_id, $sort_order) 
	{
		$sql = 'UPDATE user_site_page_content_rows 
				SET sort_order = :sort_order 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND div_id = :div_id 
				AND id = :content_row_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Update the sort order for a content item
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @param integer $content_id
	* @param integer $sort_order
	* @return void
	*/
	private function setContentItemSortOrder($site_id, $page_id, 
		$content_row_id, $content_id, $sort_order)
	{
		$sql = "UPDATE user_site_page_content_item 
				SET sort_order = :sort_order
				WHERE id = :content_id 
				AND site_id = :site_id 
				AND page_id = :page_id 
				AND row_id = :content_row_id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Fetch the current sort order for the requested content item
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param integer $content_id 
	* @param string $content_type
	* @return integer|FALSE The sort order for the selected content item or 
	* 	FALSE if unable to pull the data
	*/
	private function itemSortOrder($site_id, $page_id, $div_id, 
		$content_row_id, $content_id, $content_type)
	{
		$sql = 'SELECT uspci.sort_order 
				FROM user_site_page_content_item uspci 
				JOIN designer_content_type dct 
					ON uspci.content_type = dct.id 
					AND dct.`name` = :content_type 
				JOIN user_site_page_content_rows uspcr 
					ON uspcr.id = uspci.row_id 
					AND uspcr.id = :content_row_id 
					AND uspcr.site_id = :site_id 
					AND uspcr.page_id = :page_id
				WHERE uspci.site_id = :site_id 
				AND uspci.page_id = :page_id 
				AND uspci.row_id = :content_row_id
				AND uspci.id = :content_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return intval($result['sort_order']);
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch the sort order for the requested content row
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @return integer|FALSE The sort order for the selected content row or 
	* 	FALSE if unable to pull the data
	*/
	private function rowSortOrder($site_id, $page_id, $div_id, $content_row_id) 
	{
		$sql = 'SELECT sort_order 
				FROM user_site_page_content_rows 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND div_id = :div_id 
				AND id = :content_row_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();
		
		if($result != FALSE) {
			return intval($result['sort_order']);
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch the content row id based on the requested sort order
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $sort_order
	* @return integer|FALSE Either return the id of the content row based on 
	* 	the sort order or FALSE if unable to fetch the id
	*/
	private function contentRowBySortOrder($site_id, $page_id, $div_id, 
		$sort_order)
	{
		$sql = 'SELECT id 
				FROM user_site_page_content_rows 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND div_id = :div_id 
				AND sort_order = :sort_order';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetch();

		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
	}

	/**
	* Fetch the content item which has the requested sort order
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @param integer $sort_order
	* @return integer|FALSE $content_id
	*/
	private function contentItemBySortOrder($site_id, $page_id, 
		$content_row_id, $sort_order)
	{
		$sql = "SELECT id
				FROM user_site_page_content_item 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND row_id = :content_row_id 
				AND sort_order = :sort_order
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return intval($result['id']);
		} else {
			return FALSE;
		}
	}
	
	/**
	* Fetch the total number of content rows that have been defined for the 
	* template div id
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @return integer Number of content rows in the template div id
	*/
	private function numberOfContentRows($site_id, $page_id, $div_id) 
	{
		$sql = 'SELECT id 
				FROM user_site_page_content_rows 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND div_id = :div_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->execute();
		
		return count($stmt->fetchAll());
	}

	/**
	* Fetch the total number of content items that have been defined for the 
	* selected content row id
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $content_row_id
	* @return integer Number of content items in the content row
	*/
	private function numberOfContentItems($site_id, $page_id, $content_row_id)
	{
		$sql = "SELECT id
				FROM user_site_page_content_item 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND row_id = :content_row_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->execute();

		return count($stmt->fetchAll());
	}
	
	/**
	* Move the requested content row, either moves up or down. 
	* 
	* Once the sort order of the current item has been calculated and the 
	* id of the sibling item that needs to be altered two requests are sent 
	* to update the sort orders
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $content_row_id
	* @param string $direction
	* @return void
	*/
	public function moveContentRow($site_id, $page_id, $div_id, 
		$content_row_id, $direction)
	{
		$sort_order = $this->rowSortOrder($site_id, $page_id, $div_id, 
			$content_row_id);
			
		$process = FALSE;

		if($sort_order != FALSE) {
			switch($direction) {
				case 'up':
					if($sort_order > 1) {						
						$sibling_content_row_id = 
							$this->contentRowBySortOrder($site_id, $page_id, 
							$div_id, $sort_order-1);
							
						if($sibling_content_row_id != FALSE) {
							$process = TRUE;
							$new_sort_order = $sort_order - 1;
							$sibling_sort_order = $sort_order;
						}
					}
				break;

				case 'down':
					if($sort_order < $this->numberOfContentRows($site_id,
					$page_id, $div_id)) {
						$sibling_content_row_id = 
							$this->contentRowBySortOrder($site_id, $page_id, 
							$div_id, $sort_order+1);
							
						if($sibling_content_row_id != FALSE) {
							$process = TRUE;
							$new_sort_order = $sort_order + 1;
							$sibling_sort_order = $sort_order;
						}
					}
				break;

				default:
					throw new Exception('Direction \'' . $direction . '\' not
					found in Dlayer_Model_Page_Content::moveContentRow()');
				break;
			}
			
			// Update the sort orders for the selected content row and the 
			// affected content row
			if($process == TRUE) {				
				$this->setContentRowSortOrder($site_id, $page_id, $div_id, 
					$content_row_id, $new_sort_order);
					
				$this->setContentRowSortOrder($site_id, $page_id, $div_id, 
					$sibling_content_row_id, $sibling_sort_order);
			}
		} else {
			throw new Exception('Error returned when trying to fetch the 
				sort order of the content row in 
				Dlayer_Model_Page_Content::moveContentRow();');
		}
	}
}