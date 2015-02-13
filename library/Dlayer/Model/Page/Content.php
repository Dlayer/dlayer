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
		$sort_order = $this->newSortOrderValue($site_id, $page_id, $div_id, 
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
		
		return $this->_db->lastInsertId('user_site_page_content_rows');
	}
	
	/**
	* Add a new content item to the given page and page content block
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param string $content_type
	* @return integer Id of new content item
	*/
	public function addContentItem($site_id, $page_id, $div_id, $content_type)
	{
		$sort_order = $this->newSortOrder($site_id, $page_id, $div_id);

		$sql = "INSERT INTO user_site_page_content
				(site_id, page_id, div_id, content_type, sort_order)
				VALUES
				(:site_id, :page_id, :div_id,
				(SELECT id FROM designer_content_types
				WHERE `name` = :content_type), :sort_order)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_type', $content_type, PDO::PARAM_STR);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->execute();

		return $this->_db->lastInsertId('user_site_page_content');
	}
	
	/**
	* Calculate the new sort order value for the new content row or content 
	* item, fetches the current MAX value and then increments by 1
	* 
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id 
	* @param string $table Table to run the query against
	* @return integer New sort order
	*/
	private function newSortOrderValue($site_id, $page_id, $div_id, 
		$table='user_site_page_content_item') 
	{
		$sql = "SELECT IFNULL(MAX(sort_order), 0) + 1 AS sort_order
				FROM {$table} 
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
					AND dct.`name` = 'heading'
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
	* Move the requested content item, either up or down. Once sort order of
	* the current item has been worked out and the id of the other item that
	* needs to be changed the requests are sent to move the two items
	*
	* @param string $direction
	* @param string $content_type
	* @param integer $content_id
	* @param integer $div_id
	* @param integer $page_id
	* @param integer $site_id
	* @return void
	*/
	public function moveContentItem($direction, $content_type, $content_id,
	$div_id, $page_id, $site_id)
	{
		$process = FALSE;

		/**
		* @todo Need to update this, check the types against the database
		*/
		if(in_array($content_type, array('text', 'heading', 'form')) == TRUE) {

			$sort_order = $this->sortOrder($site_id, $page_id, $div_id,
			$content_type, $content_id);

			if($sort_order != FALSE) {
				$process = TRUE;
			}
		}

		if($process == TRUE) {

			switch($direction) {
				case 'up':
					if($sort_order > 1) {
						$sibling_content_id = $this->contentItemBySortOrder(
						$site_id, $page_id, $div_id, $sort_order-1);

						$this->setSortOrder($site_id, $content_id,
						$sort_order-1);

						$this->setSortOrder($site_id, $sibling_content_id,
						$sort_order);
					}
				break;

				case 'down':
					if($sort_order < $this->numberContentItems($site_id,
					$page_id, $div_id)) {
						$sibling_content_id = $this->contentItemBySortOrder(
						$site_id, $page_id, $div_id, $sort_order+1);

						$this->setSortOrder($site_id, $content_id,
						$sort_order+1);

						$this->setSortOrder($site_id, $sibling_content_id,
						$sort_order);
					}
				break;

				default:
					throw new Exception('Direction \'' . $direction . '\' not
					found in Dlayer_Model_Page_Content::moveContentItem()');
				break;
			}

		} else {
			throw new Exception('Content type \'' . $content_type . '\' not
			supported in Dlayer_Model_Page_Content::moveContentItem() or
			sort order not returned by Dlayer_Model_Page_Content::sortOrder');
		}
	}

	/**
	* Update the sort order for the requested content block
	*
	* @param integer $site_id
	* @param integer $content_id
	* @param integer $sort_order
	* @return void
	*/
	private function setSortOrder($site_id, $content_id, $sort_order)
	{
		$sql = "UPDATE user_site_page_content
				SET sort_order = :sort_order
				WHERE id = :content_id
				AND site_id = :site_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':sort_order', $sort_order, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	* Fetch the sort order for the requested content block
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param string $content_type
	* @param integer $content_id
	* @return integer|FALSE Current sort order
	*/
	private function sortOrder($site_id, $page_id, $div_id, $content_type,
	$content_id)
	{
		$sql = "SELECT uspc.sort_order
				FROM user_site_page_content uspc
				JOIN designer_content_types dtc ON uspc.content_type = dtc.id
				WHERE uspc.site_id = :site_id
				AND uspc.page_id = :page_id
				AND uspc.div_id = :div_id
				AND dtc.`name` = :content_type
				AND uspc.id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
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
	* Fetch the content item which has the requested sort order
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @param integer $sort_order
	* @return integer|FALSE $content_id
	*/
	private function contentItemBySortOrder($site_id, $page_id, $div_id,
	$sort_order)
	{
		$sql = "SELECT id
				FROM user_site_page_content
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND div_id = :div_id
				AND sort_order = :sort_order
				LIMIT 1";
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
	* Fetch the total number of content items for the page div
	*
	* @param integer $site_id
	* @param integer $page_id
	* @param integer $div_id
	* @return integer Number of content items
	*/
	private function numberContentItems($site_id, $page_id, $div_id)
	{
		$sql = "SELECT id
				FROM user_site_page_content
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND div_id = :div_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':div_id', $div_id, PDO::PARAM_INT);
		$stmt->execute();

		return count($stmt->fetchAll());
	}
}