<?php

/**
 * Data model for the styling sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Text_SubTool_Styling_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the background color for a content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     *
     * @return string|false
     */
    public function contentBackgroundColor($site_id, $page_id, $content_id)
    {
        $sql = 'SELECT background_color 
                FROM user_site_page_styling_content_item_background_color
                WHERE site_id = :site_id 
                AND page_id = :page_id 
                AND content_id = :content_id 
                LIMIT 1';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $content_id);
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
     * @param integer $content_id
     *
     * @return integer|false
     */
    public function existingBackgroundColorContentItem($site_id, $page_id, $content_id)
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
        $stmt->bindValue(':content_id', $content_id);
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
     * @param integer $content_id
     * @param string $color_hex
     *
     * @return boolean
     */
    public function addBackgroundColorContentItem($site_id, $page_id, $content_id, $color_hex)
    {
        $sql = "INSERT INTO user_site_page_styling_content_item_background_color 
                (site_id, page_id, content_id, background_color) 
                VALUES 
                (:site_id, :page_id, :content_id, :background_color)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $content_id);
        $stmt->bindValue(':background_color', $color_hex);

        return $stmt->execute();
    }

    /**
     * Edit the background colour for a content item, optionally delete the existing value if the user is clearing the
     * value
     *
     * @todo This will have to switch to SET NULL as more fields are added to the table
     *
     * @param integer $id
     * @param string $color_hex
     *
     * @return boolean
     */
    public function editBackgroundColorContentItem($id, $color_hex)
    {
        if (strlen($color_hex) !== 0) {
            return $this->updateBackgroundColorContentItem($id, $color_hex);
        } else {
            return $this->deleteBackgroundColorContentItem($id);
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
    protected function updateBackgroundColorContentItem($id, $color_hex)
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
    protected function deleteBackgroundColorContentItem($id)
    {
        $sql = "DELETE FROM user_site_page_styling_content_item_background_color 
                WHERE id = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}
