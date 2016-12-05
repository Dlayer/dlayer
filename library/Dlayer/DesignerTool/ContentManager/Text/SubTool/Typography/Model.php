<?php

/**
 * Data model for the typography sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Text_SubTool_Typography_Model extends Zend_Db_Table_Abstract
{
    /**
     * Fetch the font family for a content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return string|false
     */
    public function fontFamily($site_id, $page_id, $id)
    {
        $sql = "SELECT dcff.css  
                FROM user_site_page_styling_content_item_typography uspscit 
                JOIN designer_css_font_family dcff ON 
                  uspscit.font_family_id = dcff.id
                WHERE uspscit.site_id = :site_id 
                AND uspscit.page_id = :page_id 
                AND uspscit.content_id = :content_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        if ($result !== false) {
            return $result['css'];
        } else {
            return false;
        }
    }

    /**
     * Check to see if there is an existing font family defined for the content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return integer|false
     */
    public function existingFontFamily($site_id, $page_id, $id)
    {
        $sql = "SELECT id 
                FROM user_site_page_styling_content_item_typography 
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
     * Add a new font family for the current content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     * @param integer $font_family_id
     *
     * @return boolean
     */
    public function addBackgroundColor($site_id, $page_id, $id, $font_family_id)
    {
        $sql = "INSERT INTO user_site_page_styling_content_item_typography 
                (site_id, page_id, content_id, font_family_id) 
                VALUES 
                (:site_id, :page_id, :content_id, :font_family_id)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $id);
        $stmt->bindValue(':font_family_id', $font_family_id);

        return $stmt->execute();
    }

    /**
     * Edit the font family for a content item, optionally delete the existing value if the user is clearing the value
     *
     * @param integer $id
     * @param integer $font_family_id
     *
     * @return boolean
     */
    public function editFontFamily($id, $font_family_id)
    {
        if (intval($font_family_id) === 0) {
            return $this->updateFontFamily($id, $font_family_id);
        } else {
            return $this->deleteFontFamily($id);
        }
    }

    /**
     * Update font family for a content item
     *
     * @param integer $id
     * @param integer $font_family_id
     *
     * @return boolean
     */
    protected function updateFontFamily($id, $font_family_id)
    {
        $sql = "UPDATE user_site_page_styling_content_item_typography 
                SET font_family_id = :font_family_id  
                WHERE id = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':font_family_id', $font_family_id);

        return $stmt->execute();
    }

    /**
     * Remove the font family for a content item
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function deleteFontFamily($id)
    {
        $sql = "DELETE FROM user_site_page_styling_content_item_typography 
                WHERE id = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }
}
