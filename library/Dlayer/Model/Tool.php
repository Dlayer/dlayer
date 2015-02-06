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
* @category Model
*/
class Dlayer_Model_Tool extends Zend_Db_Table_Abstract
{
	/**
	* Check to see if the requested tool exists in the database and if it
	* exists that it is valid for the given module. If the tool is valid we
	* return the name of the default tab and the tool model name as an array    *
	*
	* @param string $module
	* @param integer $tool Name of the requested tool
	* @return array|FALSE Either the tool data array or FALSE is the tool is
	*                     not valid or disabled
	*/
	public function valid($module, $tool)
	{
		$sql = "SELECT dmtt.view_script AS tab, dmt.tool_model AS tool_model,
				dmt.destructive
				FROM dlayer_module_tool dmt
				JOIN dlayer_module dm ON dmt.module_id = dm.id
				AND dm.enabled = 1
				AND dm.`name` = :module
				JOIN dlayer_module_tool_tab dmtt ON dmt.id = dmtt.tool_id
				AND dmtt.module_id = dm.id
				AND dmtt.enabled = 1
				AND dmtt.default = 1
				WHERE dmt.folder = :tool
				AND dmt.enabled = 1 ";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':module', $module, PDO::PARAM_STR);
		$stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch();

		if($result != FALSE) {
			return $result;
		} else {
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

		if($result != FALSE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
