<?php

/**
 * Content heading item data model, all the methods required to manage a
 * the content heading items
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_Page_Content_Items_Heading extends Dlayer_Model_Page_Content_Item
{
	/**
	 * Add a new heading content item
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @param array $params The params data array from the tool
	 * @return boolean
	 */
	public function add($site_id, $page_id, $content_id, array $params)
	{
		$result = false;

		if(strlen($params['sub_heading']) > 0)
		{
			$content = $params['heading'] . Dlayer_Config::CONTENT_DELIMITER . $params['sub_heading'];
		}
		else
		{
			$content = $params['heading'];
		}

		$data_id = $this->existingDataId($site_id, $content);

		if($data_id === FALSE)
		{
			$data_id = $this->addData($site_id, $params['name'], $content);
		}

		if($data_id !== FALSE)
		{
			$sql = "INSERT INTO user_site_page_content_item_heading 
                    (site_id, page_id, content_id, heading_id, data_id) 
                    VALUES 
                    (:site_id, :page_id, :content_id, :heading_id, :data_id)";
			$stmt = $this->_db->prepare($sql);
			$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
			$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
			$stmt->bindValue(':heading_id', $params['heading_type'], PDO::PARAM_INT);
			$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
			$result = $stmt->execute();
		}

		return $result;
	}

	/**
	 * Check to see if the content exists in the data tables, if so we re-use the data from a previous content item
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param string $content
	 * @param integer|NULL $ignore_id
	 * @return integer|FALSE Id of the existing data array or FALSE if a new content item
	 */
	private function existingDataId($site_id, $content, $ignore_id = NULL)
	{
		$sql = "SELECT id 
                FROM user_site_content_heading 
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
	 * @since 0.99
	 * @param integer $site_id
	 * @param string $name
	 * @param string $content
	 * @return integer|FALSE The id for the new data or FALSE upon failure
	 */
	private function addData($site_id, $name, $content)
	{
		$sql = "INSERT INTO user_site_content_heading 
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
			return intval($this->_db->lastInsertId('user_site_content_heading'));
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * fetch the existing data for the content item
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $id
	 * @return array|FALSE The data array for the content or FALSE upon failure
	 */
	public function existingData($site_id, $id)
	{
		$sql = "SELECT uspcih.heading_id, usch.`name`, usch.content
				FROM user_site_page_content_item_heading uspcih 
				JOIN user_site_content_heading usch 
					ON uspcih.data_id = usch.id
					AND usch.site_id = :site_id 
				WHERE uspcih.site_id = :site_id
				AND uspcih.content_id = :content_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	 * Check to see how many instances there are of the content item data within the site
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $content_id
	 * @return integer Number of instances
	 */
	public function instancesOfData($site_id, $content_id)
	{
		$sql = "SELECT COUNT(content.id) AS instances
				FROM user_site_page_content_item_heading content
				WHERE content.data_id = (
					SELECT uspcit.data_id 
					FROM user_site_page_content_item_heading uspcit 
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
	 * Fetch the current data id for a content item
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @return integer|FALSE Should only return FALSE if the query failed for some reason
	 */
	private function currentDataId($site_id, $page_id, $content_id)
	{
		$sql = "SELECT data_id
				FROM user_site_page_content_item_heading 
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
		$sql = "UPDATE user_site_content_heading 
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
	 * Assign a new data id to the content items that use the supplied data id
	 *
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $new_data_id
	 * @param integer $current_data_id
	 * @return boolean
	 */
	private function assignNewDataId($site_id, $new_data_id, $current_data_id)
	{
		$sql = "UPDATE user_site_page_content_item_heading 
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
	 * @since 0.99
	 * @param integer $site_id
	 * @param integer $new_data_id
	 * @param integer $content_id
	 * @return boolean
	 */
	private function assignNewDataIdToContentItem($site_id, $new_data_id, $content_id)
	{
		$sql = "UPDATE user_site_page_content_item_heading 
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
		$sql = "DELETE FROM user_site_content_heading  
					WHERE site_id = :site_id 
					AND id = :delete_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':delete_id', $delete_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	 * Edit the existing data
	 *
	 * @since 0.99
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

		if(strlen($params['sub_heading']) > 0)
		{
			$content = $params['heading'] . Dlayer_Config::CONTENT_DELIMITER . $params['sub_heading'];
		}
		else
		{
			$content = $params['heading'];
		}

		$new_data_id = $this->existingDataId($site_id, $content, $current_data_id);

		if(array_key_exists('instances', $params) === TRUE)
		{
			if($params['instances'] === 1)
			{
				if($new_data_id === FALSE)
				{
					if($this->updateData($site_id, $current_data_id, $params['name'], $content) === FALSE)
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
					$new_data_id = $this->addData($site_id, $params['name'], $content);
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
				if($this->updateData($site_id, $current_data_id, $params['name'], $content) === FALSE)
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
	 * Add a heading content item
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $div_id
	 * @param integer $content_row_id
	 * @param integer $content_id
	 * @param array $params The data for the heading content item
	 * @return void
	 */
	public function addContentItemData($site_id, $page_id, $div_id,
		$content_row_id, $content_id, array $params)
	{
		$data_id = $this->contentDataExists($site_id, $params['heading'],
			$params['sub_heading']);

		if($data_id == FALSE)
		{
			$data_id = $this->addToDataTable($site_id, $params['name'],
				$params['heading'], $params['sub_heading']);
		}

		$sql = "INSERT INTO user_site_page_content_item_heading 
				(site_id, page_id, content_id, heading_id, data_id)
				VALUES
				(:site_id, :page_id, :content_id, :heading_id, :data_id)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':heading_id', $params['heading_type'],
			PDO::PARAM_INT);
		$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
		$stmt->execute();
	}

	/**
	 * Check to see if the text content exists in the heading data table, if
	 * it does we can use the id for the previously stored value
	 *
	 * @param integer $site_id
	 * @param string $heading The main heading string
	 * @param string $sub_heading The sub heading string
	 * @return integer|FALSE Either return the id for the existing text content
	 *    string or FALSE if the test is a new string
	 */
	private function contentDataExists($site_id, $heading, $sub_heading = '')
	{
		if(strlen($sub_heading) > 0)
		{
			$content = trim(strtoupper($heading)) . '-:-' .
				trim(strtoupper($sub_heading));
		}
		else
		{
			$content = trim(strtoupper($heading));
		}

		$sql = "SELECT usch.id 
				FROM user_site_content_heading usch 
				WHERE usch.site_id = :site_id 
				AND UPPER(usch.content) = :content 
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			return intval($result['id']);
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Add the content into the content data table and return the id for the
	 * newly stored string
	 *
	 * @param integer $site_id
	 * @param string $name
	 * @param string $heading
	 * @param string $sub_heading
	 * @return integer Id of the text in the content data table
	 */
	private function addToDataTable($site_id, $name, $heading, $sub_heading)
	{
		if(strlen($sub_heading) > 0)
		{
			$content = trim($heading) . '-:-' . trim($sub_heading);
		}
		else
		{
			$content = trim($heading);
		}

		$sql = "INSERT INTO user_site_content_heading 
				(site_id, `name`, content) 
				VALUES 
				(:site_id, :name, :content)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_STR);
		$stmt->execute();

		return $this->_db->lastInsertId('user_site_content_heading');
	}

	/**
	 * Update the content data text for the given data id
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @param string $name
	 * @param string $heading
	 * @param string $sub_heading
	 * @return integer Id for the updated content
	 */
	private function updateContentData($site_id, $page_id, $content_id,
		$name, $heading, $sub_heading = '')
	{
		if(strlen($sub_heading) > 0)
		{
			$content = trim($heading) . '-:-' . trim($sub_heading);
		}
		else
		{
			$content = trim($heading);
		}

		$sql = "UPDATE user_site_content_heading 
				SET `name` = :name, content = :content 
				WHERE site_id = :site_id 
				AND id = (SELECT uspcih.data_id 
				FROM user_site_page_content_item_heading uspcih 
				WHERE uspcih.content_id = :content_id 
				AND uspcih.site_id = :site_id 
				AND uspcih.page_id = :page_id 
				LIMIT 1)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':content', $content, PDO::PARAM_LOB);
		$stmt->execute();

		return $this->contentDataExists($site_id, $heading, $sub_heading);
	}

	/**
	 * Edit the data for the selected heading content item
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
			$data_id = $this->contentDataExists($site_id, $params['heading'],
				$params['sub_heading']);

			if($data_id == FALSE)
			{
				$data_id = $this->addToDataTable($site_id, $params['name'],
					$params['heading'], $params['sub_heading']);
			}
			else
			{
				$data_id = $this->updateContentData($site_id, $page_id,
					$content_id, $params['name'], $params['heading'],
					$params['sub_heading']);
			}
		}
		else
		{
			$data_id = $this->updateContentData($site_id, $page_id,
				$content_id, $params['name'], $params['heading'],
				$params['sub_heading']);
		}

		$sql = "UPDATE user_site_page_content_item_heading 
				SET heading_id = :heading_id, data_id = :data_id 
				WHERE site_id = :site_id
				AND page_id = :page_id
				AND content_id = :content_id
				LIMIT 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':heading_id', $params['heading_type'],
			PDO::PARAM_INT);
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
		$sql = "SELECT uspci.id, usch.`name`, usch.content AS heading, 
				uspcih.heading_id 
				FROM user_site_page_content_item_heading uspcih 
				JOIN user_site_page_content_item uspci ON uspcih.content_id = uspci.id 
					AND uspci.site_id = :site_id
					AND uspci.page_id = :page_id 
					AND uspci.content_row_id = :content_row_id 
					AND uspci.id = :content_id 
				JOIN user_site_content_heading usch ON uspcih.data_id = usch.id 
					AND usch.site_id = :site_id 
				WHERE uspcih.site_id = :site_id 
				AND uspcih.page_id = :page_id
				AND uspcih.content_id = :content_id";
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

			$exploded = explode('-:-', $result['heading']);

			switch(count($exploded))
			{
				case 1:
					$result['sub_heading'] = '';
				break;

				case 2:
					$result['heading'] = $exploded['0'];
					$result['sub_heading'] = $exploded['1'];
				break;

				default:
					$result['sub_heading'] = '';
				break;
			}

			return $result;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Calculate the number of instances of the heading content item text
	 * within the entire site
	 *
	 * @param integer $site_id
	 * @param integer $content_id
	 * @return integer Returns the count of the number of times the heading
	 *    text has been used within the site
	 */
	private function contentDataInstances($site_id, $content_id)
	{
		$sql = "SELECT COUNT(uspcih.id) AS instances 
				FROM user_site_page_content_item_heading uspcih 
				WHERE uspcih.site_id = :site_id 
				AND uspcih.data_id = (SELECT ref_data.data_id 
				FROM user_site_page_content_item_heading ref_data 
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
	 * Fetch the existsing heading content that matches the supplied id
	 *
	 * @param integer $site_id
	 * @param integer $id
	 * @return array|FALSE Either returns the data array for the heading
	 *    content or FALSE if an invalid id was supplied
	 */
	public function existingHeadingContent($site_id, $data_id)
	{
		$sql = "SELECT `name`, content 
				FROM user_site_content_heading 
				WHERE site_id = :site_id 
				AND id = :data_id";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':data_id', $data_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		$exploded = explode('-:-', $result['content']);

		switch(count($exploded))
		{
			case 1:
				$result['heading'] = $exploded[0];
				$result['sub_heading'] = '';
			break;

			case 2:
				$result['heading'] = $exploded[0];
				$result['sub_heading'] = $exploded[1];
			break;

			default:
				$result['heading'] = '';
				$result['sub_heading'] = '';
			break;
		}

		return $result;
	}

	/**
	 * Fetch all the defined names and ids for the heading data stored in the
	 * database, used by the import heading tool
	 *
	 * @param integer $site_id
	 * @return array
	 */
	public function existingHeadingContentNames($site_id)
	{
		$sql = "SELECT id, `name` 
				FROM user_site_content_heading 
				WHERE site_id = :site_id
				ORDER BY `name` ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	 * Fetch the data required by the live editing preview functions, in this
	 * case the current title and sub title values
	 *
	 * @param integer $site_id
	 * @param integer $page_id
	 * @param integer $content_id
	 * @return array|FALSE Eithers returns the required data array or FALSE if
	 *    the data cannot be found
	 */
	public function previewData($site_id, $page_id, $content_id)
	{
		$sql = 'SELECT uspcih.content_id, usch.content 
				FROM user_site_page_content_item_heading uspcih 
				JOIN user_site_content_heading usch 
					ON uspcih.data_id = usch.id 
					AND usch.site_id = :site_id 
				WHERE uspcih.site_id = :site_id 
				AND uspcih.page_id = :page_id 
				AND uspcih.content_id = :content_id 
				LIMIT 1';
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		$stmt->bindValue(':page_id', $page_id, PDO::PARAM_INT);
		$stmt->bindValue(':content_id', $content_id, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			$content = $this->splitContent($result['content']);

			$result['heading'] = $content['heading'];
			$result['sub_heading'] = $content['sub_heading'];
		}

		return $result;
	}

	/**
	 * Split the content field into heading and sub heading
	 *
	 * @param string $content
	 * @return array
	 */
	private function splitContent($content)
	{
		$exploded = explode('-:-', $content);

		$result = array();

		switch(count($exploded))
		{
			case 1:
				$result['heading'] = $exploded[0];
				$result['sub_heading'] = '';
			break;

			case 2:
				$result['heading'] = $exploded[0];
				$result['sub_heading'] = $exploded[1];
			break;

			default:
				$result['heading'] = '';
				$result['sub_heading'] = '';
			break;
		}

		return $result;
	}
}
