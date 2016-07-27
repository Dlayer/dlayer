<?php

/**
 * Data model for the text content item
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_Page_Content_Items_Text extends Zend_Db_Table_Abstract
{
	/**
	 * Add a new text content item
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @param array $params The params data array from the tool
	 * @return boolean
	 */
	public function add($site_id, $page_id, $content_id, array $params)
	{
		$result = false;

		$data_id = $this->existingDataId($site_id, $params['content']);

		if($data_id === FALSE)
		{
			$data_id = $this->addData($site_id, $params['name'], $params['content']);
		}

		if($data_id !== FALSE)
		{
			$sql = "INSERT INTO user_site_page_content_item_text 
                    (site_id, page_id, content_id, data_id) 
                    VALUES 
                    (:site_id, :page_id, :content_id, :data_id)";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
			$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
			$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
			$result = $stmt->execute();
		}

		return $result;
	}

	/**
	 * Check to see if the content exists in the data tables, if so we re-=use the data from a previous content item
	 *
	 * @param integer $site_id
	 * @param string $content
	 * @return integer|FALSE Id of the existing data array or FALSE if a new content item
	 */
	private function existingDataId($site_id, $content)
	{
		$sql = "SELECT id 
                FROM user_site_content_text  
                WHERE site_id = :site_id  
				AND UPPER(content) = :content 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content', strtoupper($content), PDO::PARAM_STMT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['id']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Add the new content item data into the content table for text items
	 *
	 * @param integer $site_id
	 * @param string $name
	 * @param string $content
	 * @return integer|FALSE The id for the new data or FALSE upon failure
	 */
	private function addData($site_id, $name, $content)
	{
		$sql = "INSERT INTO user_site_content_text 
				(site_id, `name`, content) 
				VALUES 
				(:site_id, :name, :content)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$result = $stmt->execute();

		if($result === TRUE)
		{
			return intval($this->_db->lastInsertId('user_site_content_text'));
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch the existing data for the content item
	 *
	 * @param integer $site_id
	 * @param integer $id
	 * @return array|FALSE The data array for the content item or FALSE upon failure
	 */
	public function existingData($site_id, $id)
	{
		$sql = "SELECT usct.`name`, usct.content
				FROM user_site_page_content_item_text uspcit 
				JOIN user_site_content_text usct 
					ON uspcit.data_id = usct.id
					AND usct.site_id = :site_id 
				WHERE uspcit.site_id = :site_id
				AND uspcit.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}















	/**
	 * Update the content data text for the given data id
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @param string $name
	 * @param string $content
	 * @return integer Id for the updated content
	 */
	private function updateContentData($site_id, $page_id, $content_id,
		$name, $content)
	{
		$sql = "UPDATE user_site_content_text 
				SET `name` = :name, content = :content 
				WHERE site_id = :site_id 
				AND id = (SELECT uspcit.data_id 
				FROM user_site_page_content_item_text uspcit 
				WHERE uspcit.content_id = :content_id 
				AND uspcit.site_id = :site_id 
				AND uspcit.page_id = :page_id 
				LIMIT 1)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_LOB);
		$stmt->execute();

		return $this->contentDataExists($site_id, $content);
	}

	/**
	 * Edit the data for the selected text content item
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer $content_row_id
	 * @param integer $content_id
	 * @param array $params The data for the new content item
	 * @return void
	 */
	public function editContentItemData($site_id, $page_id, $div_id,
		$content_row_id, $content_id, array $params)
	{
		if($params['instances'] == FALSE)
		{
			$data_id = $this->contentDataExists($site_id, $params['text']);

			if($data_id == FALSE)
			{
				$data_id = $this->addToDataTable($site_id, $params['name'],
					$params['text']);
			}
			else
			{
				$data_id = $this->updateContentData($site_id, $page_id,
					$content_id, $params['name'], $params['text']);
			}
		}
		else
		{
			$data_id = $this->updateContentData($site_id, $page_id,
				$content_id, $params['name'], $params['text']);
		}

		$sql = "UPDATE user_site_page_content_item_text 
				SET data_id = :data_id 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND content_id = :content_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	 * Fetch the data for the content item being edited
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer $content_row_id
	 * @param integer $content_id
	 * @return array|FALSE Returns either the data array or FALSE if no data
	 *    can be found
	 */
	public function formData($site_id, $page_id, $div_id, $content_row_id,
		$content_id)
	{
		$sql = "SELECT uspci.id, usct.`name`, usct.content AS `text`
				FROM user_site_page_content_item_text uspcit 
				JOIN user_site_page_content_item uspci 
					ON uspcit.content_id = uspci.id 
					AND uspci.site_id = :site_id 
					AND uspci.page_id = :page_id 
					AND uspci.content_row_id = :content_row_id 
					AND uspci.id = :content_id 
				JOIN user_site_content_text usct 
					ON uspcit.data_id = usct.id 
					AND usct.site_id = :site_id 
				WHERE uspcit.site_id = :site_id 
				AND uspcit.page_id = :page_id
				AND uspcit.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_row_id', $content_row_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			$result['instances'] = $this->contentDataInstances(
				$site_id, $content_id);

			return $result;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Calculate the number of instances of the text content item text within
	 * the entire site
	 *
	 * @param integer $site_id
	 * @param integer $content_id
	 * @return integer Returns the count of the number of times the text has
	 *    been used within the site
	 */
	private function contentDataInstances($site_id, $content_id)
	{
		$sql = "SELECT COUNT(uspcth.id) AS instances 
				FROM user_site_page_content_item_text uspcth 
				WHERE uspcth.site_id = :site_id 
				AND uspcth.data_id = (SELECT ref_data.data_id 
				FROM user_site_page_content_item_text ref_data 
				WHERE ref_data.content_id = :content_id 
				AND ref_data.site_id = :site_id)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			return intval($result['instances']);
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Fetch the existsing text content that matches the supplied id
	 *
	 * @param integer $site_id
	 * @param integer $id
	 * @return array|FALSE Either returns the data array for the text content
	 *    or FALSE if an invalid id was supplied
	 */
	public function existingTextContent($site_id, $id)
	{
		$sql = "SELECT `name`, content 
				FROM user_site_content_text 
				WHERE site_id = :site_id 
				AND id = :id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}


	/**
	 * Fetch all the defined names and ids for the text data stored in the
	 * database, used by the import text tool
	 *
	 * @param integer $site_id
	 * @return array
	 */
	public function existingTextContentNames($site_id)
	{
		$sql = "SELECT id, `name` 
				FROM user_site_content_text 
				WHERE site_id = :site_id
				ORDER BY `name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	 * Fetch the data required by the preview functions
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @return array|FALSE Contains all the data required to generate the
	 *    preview functions, if nothing cvan be found we return FALSE
	 */
	public function previewData($site_id, $page_id, $content_id)
	{
		$sql = 'SELECT uspcit.content_id, usct.content AS `text`
				FROM user_site_page_content_item_text uspcit 
				JOIN user_site_content_text usct 
					ON uspcit.data_id = usct.id 
					AND usct.site_id = :site_id 
				WHERE uspcit.site_id = :site_id 
				AND uspcit.page_id = :page_id 
				AND uspcit.content_id = :content_id';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}
}
