<?php
/**
* A tools ribbon can have multiple tabs
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Model_Ribbon_Tab extends Zend_Db_Table_Abstract
{
	/**
	* Get the folder name and view script name for the requested module,
	* tool and tab. The folder name and view name relate to the location of
	* the ribbon tab view script under /module/views/scripts/design/ribbon
	*
	* @param integer $module
	* @param string $tool Name of the requeted tool
	* @param string $tab Name of the tool tab
	* @return string|FALSE Path for view script, folder and file name
	*/
	public function tabViewScriptPath($module, $tool, $tab)
	{
		$sql = "SELECT dmt.folder, dmtt.view_script
				FROM dlayer_module_tool_tab dmtt
				JOIN dlayer_module_tool dmt ON dmtt.tool_id = dmt.id
				AND dmt.enabled = 1
				AND dmt.folder = :tool
				JOIN dlayer_module dm ON dmtt.module_id = dmt.module_id
				AND dm.enabled = 1
				AND dm.`name` = :module
				WHERE dmtt.view_script = :tab
				AND dmtt.enabled = 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->bindValue(':tab', $tab, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return "{$result['folder']}/{$result['view_script']}";
		} else {
			return FALSE;
		}
	}
}
