<?php
/**
* A tools ribbon can have multiple tabs
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Tab.php 975 2013-09-25 01:37:47Z Dean.Blackborough $
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
    public function tabViewScript($module, $tool, $tab)
    {
        $sql = "SELECT dmt.folder, dmtt.view_script
                FROM dlayer_module_tool_tabs dmtt
                JOIN dlayer_module_tools dmt ON dmtt.tool_id = dmt.id
                    AND dmt.enabled = 1
                    AND dmt.folder = :tool
                JOIN dlayer_modules dm ON dmt.module_id = dmt.module_id
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

    /**
    * Check to see if the requested tool tab is a mult-use tool, if it is after
    * processing the process controller returns the user to the designer with
    * the tool and tab still selected.
    *
    * @param string $module Module name
    * @param string $tool Tool name
    * @param string $tab Tab name
    * @return integer
    */
    public function multiUseToolTab($module, $tool, $tab)
    {
        $sql = "SELECT dmtt.multi_use
                FROM dlayer_module_tool_tabs dmtt
                JOIN dlayer_module_tools dmt ON dmtt.tool_id = dmt.id
                    AND dmt.enabled = 1
                    AND dmt.folder = :tool
                JOIN dlayer_modules dm ON dmt.module_id = dm.id
                    AND dm.enabled = 1
                    AND dm.`name` = :module
                WHERE dmtt.enabled = 1
                AND dmtt.view_script = :tab";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':module', $module, PDO::PARAM_STR);
        $stmt->bindValue(':tool', $tool, PDO::PARAM_STR);
        $stmt->bindValue(':tab', $tab, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        if($result != FALSE) {
            return intval($result['multi_use']);
        } else {
            return 0;
        }
    }
}
