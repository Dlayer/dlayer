<?php

/**
 * Designer tool base model.
 *
 * There is a one to one relationships between the tools in the designer and
 * the tool classes, a tool handles just one task, for example splitting a div.
 *
 * Currently this model just checks that the tool is valid but later it will
 * handle logging for the undo system
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 * @category Model
 */
class Dlayer_Model_Tool extends Zend_Db_Table_Abstract
{
	/**
	 * Fetch all the enabled tools for a module
	 *
	 * @param string $module
	 * @return array
	 */
	public function tools($module)
	{
		$sql = "SELECT dmt.`name`, dmt.`model`, dmt.group_id 
				FROM dlayer_module_tool dmt 
				JOIN dlayer_module dm 
					ON dmt.module_id = dm.id 
					AND dm.enabled = 1 
					AND dm.`name` = :module 
				WHERE dmt.enabled = 1 
				ORDER BY dmt.group_id ASC, dmt.sort_order ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$tools = array();

		foreach($result as $row) {
			$tools[$row['group_id']][] = $row;
		}

		return $tools;
	}

	/**
	 * Check to see if the requested tool is valid, if so return the tool model, script name for default tab and
	 * the optional name of the sub tool
	 *
	 * @param string $module
	 * @param integer $tool Name of the requested tool
	 * @return array|FALSE Either the tool data array or FALSE is the tool is not valid or disabled
	 */
	public function toolAndDefaultTab($module, $tool)
	{
		$sql = "SELECT dmt.model AS tool, dmtt.script AS tab, dmtt.model AS sub_tool
				FROM dlayer_module_tool dmt 
				JOIN dlayer_module dm 
					ON dmt.module_id = dm.id 
					AND dm.enabled = 1 
					AND dm.`name` = :module 
				JOIN dlayer_module_tool_tab dmtt 
					ON dmt.id = dmtt.tool_id 
					AND dmtt.module_id = dm.id 
					AND dmtt.enabled = 1
				WHERE dmt.enabled = 1 
				AND dmt.model = :tool 
				AND dmtt.default = 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return $result;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Fetch the tool tabs for the selected tool
	 *
	 * @param string $module
	 * @param string $tool
	 * @param boolean $edit_mode
	 * @return array|FALSE
	 */
	public function toolTabs($module, $tool, $edit_mode = FALSE)
	{
		$sql = "SELECT dmtt.`name`, dmt.`model` AS tool, dmtt.model AS sub_tool, 
				dmtt.name AS `name`, dmtt.script, dmtt.glyph
				FROM dlayer_module_tool_tab dmtt 
				JOIN dlayer_module dm 
					ON dmtt.module_id = dm.id
					AND dm.enabled = 1 
					AND dm.`name` = :module 
				JOIN dlayer_module_tool dmt 
					ON dmtt.tool_id = dmt.id 
					AND dmt.enabled = 1 
					AND dmt.model = :tool
				WHERE dmtt.enabled = 1 ";
		if($edit_mode === FALSE)
		{
			$sql .= "AND dmtt.edit_mode = 0 ";
		}
		$sql .= "ORDER BY dmtt.sort_order ASC";

		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetchAll();

		if(count($result) > 0)
		{
			return $result;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Check to see if the requested sub tool is valid, needs to exist in the
	 * database and also be a sub tool for the base tool
	 *
	 * @param string $module
	 * @param string $tool
	 * @param string $sub_tool_model
	 * @return boolean TRUE is the tool exists
	 */
	public function subToolValid($module, $tool, $sub_tool_model)
	{
		$sql = "SELECT dmtt.id
				FROM dlayer_module_tool_tab dmtt
				JOIN dlayer_module_tool dmt ON dmtt.tool_id = dmt.id
				AND dmt.tool = :tool
				AND dmt.enabled = 1
				JOIN dlayer_module dm ON dmt.module_id = dm.id
				AND dm.`name` = :module
				AND dm.enabled = 1
				WHERE dmtt.sub_tool_model = :sub_tool_model
		AND dmtt.enabled = 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->bindValue(':sub_tool_model', $sub_tool_model, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Check to see if the tab exists for the requested tool
	 *
	 * @param integer $module
	 * @param string $tool Name of the requested tool
	 * @param string $tab Name of the tool tab view script
	 * @return boolean
	 */
	public function tabExists($module, $tool, $tab)
	{
		$sql = "SELECT dmtt.id
				FROM dlayer_module_tool_tab dmtt
				JOIN dlayer_module_tool dmt 
					ON dmtt.tool_id = dmt.id
					AND dmt.enabled = 1
					AND dmt.model = :tool
				JOIN dlayer_module dm 
					ON dmtt.module_id = dmt.module_id
					AND dm.enabled = 1
					AND dm.`name` = :module
				WHERE dmtt.script = :tab
				AND dmtt.enabled = 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->bindValue(':tab', $tab, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Check to see if the tab exists for the requested tool
	 *
	 * @param integer $module
	 * @param string $tool Name of the requested tool
	 * @param string $tab Name of the tool tab view script
	 * @return boolean
	 */
	public function multiUse($module, $tool, $tab)
	{
		$sql = "SELECT dmtt.multi_use
				FROM dlayer_module_tool_tab dmtt
				JOIN dlayer_module_tool dmt 
					ON dmtt.tool_id = dmt.id
					AND dmt.enabled = 1
					AND dmt.model = :tool
				JOIN dlayer_module dm 
					ON dmtt.module_id = dmt.module_id
					AND dm.enabled = 1
					AND dm.`name` = :module
				WHERE dmtt.script = :tab
				AND dmtt.enabled = 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->bindValue(':tab', $tab, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result !== FALSE && intval($result['multi_use']) === 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
