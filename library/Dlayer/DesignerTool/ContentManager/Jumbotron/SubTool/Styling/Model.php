<?php

/**
 * Data model for the styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Jumbotron_SubTool_Styling_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the background color for a content item
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
                FROM user_site_page_styling_content_item_background_color
                WHERE site_id = :site_id 
                AND page_id = :page_id 
                AND content_id = :content_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result !== false) {
            return $result['background_color'];
        } else {
            return false;
        }
    }

    /**
     * Check to see if there is an existing background colour defined for the content item
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
                FROM user_site_page_styling_content_item_background_color 
                WHERE site_id = :site_id 
                AND page_id = :page_id 
                AND content_id = :content_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result !== false) {
            return intval($result['id']);
        } else {
            return false;
        }
    }

    /**
     * Add a new background colour for the current content item
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
        $sql = "INSERT INTO user_site_page_styling_content_item_background_color 
                (site_id, page_id, content_id, background_color) 
                VALUES 
                (:site_id, :page_id, :content_id, :background_color)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $id);
        $stmt->bindValue(':background_color', $color_hex);

        return $stmt->execute();
    }

    /**
     * Edit the background colour for a content item, optionally delete the existing value if the user is clearing the
     * value
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
     * Update background colour for a content item
     *
     * @param integer $id
     * @param string $color_hex
     *
     * @return boolean
     */
    protected function updateBackgroundColor($id, $color_hex)
    {
        $sql = "UPDATE user_site_page_styling_content_item_background_color 
                SET background_color = :background_color 
                WHERE id = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':background_color', $color_hex);

        return $stmt->execute();
    }

    /**
     * Remove a background colour for a content item
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function deleteBackgroundColor($id)
    {
        $sql = "DELETE FROM user_site_page_styling_content_item_background_color 
                WHERE id = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}
