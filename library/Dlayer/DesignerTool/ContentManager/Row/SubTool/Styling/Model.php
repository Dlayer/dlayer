<?php

/**
 * Data model for the styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Row_SubTool_Styling_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the background color assigned to the selected row
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return string|false
     */
    public function backgroundColor($site_id, $page_id, $id)
    {
        $sql = "SELECT background_color 
                FROM user_site_page_styling_row_background_color
                WHERE site_id = :site_id 
                AND page_id = :page_id 
                AND row_id = :row_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':row_id', $id);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return $result['background_color'];
        } else {
            return false;
        }
    }

    /**
     * Check to see if there is an existing background colour defined for the row
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return integer|false
     */
    public function existingBackgroundColor($site_id, $page_id, $id)
    {
        $sql = "SELECT id 
                FROM user_site_page_styling_row_background_color 
                WHERE site_id = :site_id 
                AND page_id = :page_id 
                AND row_id = :row_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':row_id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Add a new background color to the row
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     * @param string $color_hex
     *
     * @return boolean
     */
    public function addBackgroundColor($site_id, $page_id, $id, $color_hex)
    {
        $sql = "INSERT INTO user_site_page_styling_row_background_color 
                (site_id, page_id, row_id, background_color) 
                VALUES 
                (:site_id, :page_id, :row_id, :background_color)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':row_id', $id);
        $stmt->bindValue(':background_color', $color_hex);

        return $stmt->execute();
    }

    /**
     * Edit the background color for the selected row, optionally delete any set values
     *
     * @param integer $id
     * @param string $color_hex
     *
     * @return boolean
     */
    public function editBackgroundColor($id, $color_hex)
    {
        if (strlen($color_hex) !== 0) {
            return $this->updateBackgroundColor($id, $color_hex);
        } else {
            return $this->deleteBackgroundColor($id);
        }
    }

    /**
     * Update the background colour for the row
     *
     * @param integer $id
     * @param string $color_hex
     *
     * @return boolean
     */
    protected function updateBackgroundColor($id, $color_hex)
    {
        $sql = "UPDATE user_site_page_styling_row_background_color 
                SET background_color = :background_color 
                WHERE id = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':background_color', $color_hex);

        return $stmt->execute();
    }

    /**
     * Remove a background colour for the selected row
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function deleteBackgroundColor($id)
    {
        $sql = "DELETE FROM user_site_page_styling_row_background_color 
                WHERE id = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}
