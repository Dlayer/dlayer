<?php

/**
 * The ribbon displays the controls for the selected tool, there will always be one tab but a tool can have many ribbon tabs
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_Ribbon extends Zend_Db_Table_Abstract
{
	/**
	 * Fetches all the tabs for the selected tool, if the tool is in edit mode additional tool tabs can be pulled from the system
	 *
	 * @todo Needs to be replaced by modularToolTabs()
	 * @param string $module
	 * @param string $tool
	 * @param boolean $edit_mode Are there any edit only tabs
	 * @return array
	 */
	public function tabs($module, $tool, $edit_mode = FALSE)
	{
		$sql = "SELECT dmtt.`name` AS tab_name, dmtt.view_script AS tab, dmtt.glyph 
				FROM dlayer_module_tool_tab dmtt
				JOIN dlayer_module_tool dmt ON dmtt.tool_id = dmt.id 
					AND dmt.enabled = 1
					AND dmt.folder = :tool
					AND dmtt.module_id = dmt.module_id
				JOIN dlayer_module dm ON dmt.module_id = dm.id
				WHERE dm.`name` = :module
				AND dm.enabled = 1
				AND dmtt.enabled = 1 ";
		if($edit_mode == FALSE)
		{
			$sql .= "AND dmtt.edit_mode = 0 ";
		}
		$sql .= "ORDER BY dmtt.sort_order ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	/**
	 * Fetch the modular tool tabs for the selected tool
	 * @todo Rename once tabs() refactored away
	 *
	 *
	 */
	public function modularToolTabs($module, $tool_model, $edit_mode = FALSE)
	{
		$sql = "SELECT dmt.name AS tool_name, dmtt.name AS sub_tool_name, dmtt.view_script, 
				dmtt.sub_tool_model  
				FROM dlayer_module_tool_tab dmtt 
				JOIN dlayer_module dm 
					ON dmtt.module_id = dm.id
					AND dm.enabled = 1 
					AND dm.`name` = :module 
				JOIN dlayer_module_tool dmt 
					ON dmtt.tool_id = dmt.id 
					AND dmt.enabled = 1 
					AND dmt.tool_model = :tool_model
				WHERE dmtt.enabled = 1 ";
		if($edit_mode === FALSE)
		{
			$sql .= "AND dmtt.edit_mode = 0 ";
		}
		$sql .= "ORDER BY dmtt.sort_order ASC";

		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->bindValue(':tool_model', $tool_model, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetchAll();
	}
}
