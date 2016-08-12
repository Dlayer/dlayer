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
	 * Fetch the current data id for a content item
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @return integer|FALSE Should only return FALSE if the query failed for some reason
	 */
	private function currentDataId($site_id, $page_id, $content_id)
	{
		$sql = "SELECT data_id
				FROM user_site_page_content_item_text 
				WHERE site_id = :site_id 
				AND page_id = :page_id 
				AND content_id = :content_id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['data_id']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Check to see if the content exists in the data tables, if so we re-=use the data from a previous content item
	 *
	 * @param integer $site_id
	 * @param string $content
	 * @param integer|NULL $ignore_id
	 * @return integer|FALSE Id of the existing data array or FALSE if a new content item
	 */
	private function existingDataId($site_id, $content, $ignore_id = NULL)
	{
		$sql = "SELECT id 
                FROM user_site_content_text  
                WHERE site_id = :site_id  
				AND UPPER(content) = :content";
		if($ignore_id !== NULL)
		{
			$sql .= " AND id != :ignore_id LIMIT 1";
		}
		else
		{
			$sql .= " LIMIT 1";
		}
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content', strtoupper($content), PDO::PARAM_STMT);
		if($ignore_id !== NULL)
		{
			$stmt->bindValue(':ignore_id', $ignore_id, PDO::PARAM_INT);
		}
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
	 * Update the data for the existing data id
	 *
	 * @param integer $site_id
	 * @param integer $id
	 * @param string $name
	 * @param string $content
	 * @return boolean
	 */
	private function updateData($site_id, $id, $name, $content)
	{
		$sql = "UPDATE user_site_content_text 
				SET `name` = :name, content = :content 
				WHERE site_id = :site_id 
				AND id = :data_id 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':data_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$result = $stmt->execute();

		return $result;
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
	 * Edit the existing data
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @param array $params The params data array from the tool
	 * @return TRUE
	 * @throws Exception
	 */
	public function edit($site_id, $page_id, $content_id, array $params)
	{
		/**
		 * @var FALSE|integer If not false delete the data for this data id
		 */
		$delete = FALSE;

		$current_data_id = $this->currentDataId($site_id, $page_id, $content_id);
		if($current_data_id === FALSE)
		{
			throw new Exception('Error fetching the existing data id for content id: ' . $current_data_id);
		}

		$new_data_id = $this->existingDataId($site_id, $params['content'], $current_data_id);

		if(array_key_exists('instances', $params) === TRUE)
		{
			if($params['instances'] === 1)
			{
				if($new_data_id === FALSE)
				{
					if($this->updateData($site_id, $current_data_id, $params['name'], $params['content']) === FALSE)
					{
						throw new Exception('Error updating the data for content id: ' . $current_data_id);
					}
				}
				else
				{
					if($this->assignNewDataId($site_id, $new_data_id, $current_data_id) === FALSE)
					{
						throw new Exception('Error updating data id for text content items using data id: ' .
							$current_data_id);
					}

					$delete = $current_data_id;
				}
			}
			else
			{
				if($new_data_id === FALSE)
				{
					$new_data_id = $this->addData($site_id, $params['name'], $params['content']);
					$this->assignNewDataIdToContentItem($site_id, $new_data_id, $content_id);
				}
				else
				{
					$this->assignNewDataIdToContentItem($site_id, $new_data_id, $content_id);
				}
			}
		}
		else
		{
			if($new_data_id === FALSE)
			{
				if($this->updateData($site_id, $current_data_id, $params['name'], $params['content']) === FALSE)
				{
					throw new Exception('Error updating the data for content id: ' . $current_data_id);
				}
			}
			else
			{
				if($this->assignNewDataIdToContentItem($site_id, $new_data_id, $content_id) === FALSE)
				{
					throw new Exception('Error updating data id for content id: ' . $content_id);
				}

				$delete = $current_data_id;
			}
		}

		if($delete !== FALSE)
		{
			$this->deleteDataId($site_id, $delete);
		}

		return TRUE;
	}

	/**
	 * Check to see how many instances there are of the content item data within the site
	 *
	 * @param integer $site_id
	 * @param integer $content_id
	 * @return integer Number of instances
	 */
	public function instancesOfData($site_id, $content_id)
	{
		$sql = "SELECT COUNT(content.id) AS instances
				FROM user_site_page_content_item_text content
				WHERE content.data_id = (
					SELECT uspcit.data_id 
					FROM user_site_page_content_item_text uspcit 
					WHERE uspcit.site_id = :site_id  
					AND uspcit.content_id = :content_id 
					LIMIT 1
				)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return intval($result['instances']);
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Assign a new data id to the content items that use the supplied data id
	 *
	 * @param integer $site_id
	 * @param integer $new_data_id
	 * @param integer $current_data_id
	 * @return boolean
	 */
	private function assignNewDataId($site_id, $new_data_id, $current_data_id)
	{
		$sql = "UPDATE user_site_page_content_item_text 
				SET data_id = :new_data_id 
				WHERE site_id = :site_id 
				AND data_id = :current_data_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':new_data_id', $new_data_id, PDO::PARAM_INT);
		$stmt->bindValue(':current_data_id', $current_data_id, PDO::PARAM_INT);
		$result = $stmt->execute();

		return $result;
	}

	/**
	 * Assign a new data id to a content item
	 *
	 * @param integer new_data_id
	 * @param integer $content_id
	 * @return boolean
	 */
	private function assignNewDataIdToContentItem($site_id, $new_data_id, $content_id)
	{
		$sql = "UPDATE user_site_page_content_item_text 
				SET data_id = :new_data_id 
				WHERE site_id = :site_id 
				AND content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':new_data_id', $new_data_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$result = $stmt->execute();

		return $result;
	}

	/**
	 * Delete data id
	 *
	 * @param integer $site_id
	 * @param integer $delete_id
	 * @return void
	 */
	private function deleteDataId($site_id, $delete_id)
	{
		$sql = "DELETE FROM user_site_content_text 
					WHERE site_id = :site_id 
					AND id = :delete_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':delete_id', $delete_id, PDO::PARAM_INT);
		$stmt->execute();
	}
}
