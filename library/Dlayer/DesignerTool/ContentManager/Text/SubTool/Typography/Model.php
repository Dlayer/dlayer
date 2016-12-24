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
     * Fetch the font and text values for the current content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return array|false
     */
    public function fontAndTextValues($site_id, $page_id, $id)
    {
        $sql = "SELECT 
                    `uspscit`.`font_family_id`,
                    `uspscit`.`text_weight_id`
                FROM 
                    `user_site_page_styling_content_item_typography` `uspscit` 
                JOIN 
                    `designer_css_font_family` `dcff` ON
                        `uspscit`.`font_family_id` = `dcff`.`id`
                WHERE 
                    `uspscit`.`site_id` = :site_id AND 
                    `uspscit`.`page_id` = :page_id AND 
                    `uspscit`.`content_id` = :content_id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $id);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return array(
                'font_family_id' => ($result['font_family_id'] === null) ? null : intval($result['font_family_id']),
                'text_weight_id' => ($result['text_weight_id'] === null) ? null : intval($result['text_weight_id'])
            );
        } else {
            return false;
        }
    }

    /**
     * Check to see if there if there is a row for ant text and font values
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return integer|false
     */
    public function existingFontAndTextValues($site_id, $page_id, $id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `user_site_page_styling_content_item_typography` 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `content_id` = :content_id AND 
                    (
                        `text_weight_id` IS NOT NULL OR 
                        `font_family_id` IS NOT NULL
                    )
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
    public function addFontFamily($site_id, $page_id, $id, $font_family_id)
    {
        $sql = "INSERT INTO `user_site_page_styling_content_item_typography` 
                (
                    `site_id`, 
                    `page_id`, 
                    `content_id`, 
                    `font_family_id`
                ) 
                VALUES 
                (
                    :site_id, 
                    :page_id, 
                    :content_id, 
                    :font_family_id
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $id);
        $stmt->bindValue(':font_family_id', $font_family_id);

        return $stmt->execute();
    }

    /**
     * Add a new text weight settings for the current content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     * @param integer $text_weight_id
     *
     * @return boolean
     */
    public function addTextWeight($site_id, $page_id, $id, $text_weight_id)
    {
        $sql = "INSERT INTO `user_site_page_styling_content_item_typography` 
                (
                    `site_id`, 
                    `page_id`, 
                    `content_id`, 
                    `text_weight_id`
                ) 
                VALUES 
                (
                    :site_id, 
                    :page_id, 
                    :content_id, 
                    :text_weight_id
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id);
        $stmt->bindValue(':page_id', $page_id);
        $stmt->bindValue(':content_id', $id);
        $stmt->bindValue(':text_weight_id', $text_weight_id);

        return $stmt->execute();
    }

    /**
     * Edit the font family for a content item, optionally clear the existing value if the user is clearing the value
     *
     * @param integer $id
     * @param integer $font_family_id
     *
     * @return boolean
     */
    public function editFontFamily($id, $font_family_id)
    {
        if (intval($font_family_id) !== DEFAULT_FONT_FAMILY_FOR_MODULE) {
            return $this->updateFontFamily($id, $font_family_id);
        } else {
            return $this->clearFontFamily($id);
        }
    }

    /**
     * Edit the text weight for a content item, optionally clear the existing value if the user is clearing the value
     *
     * @param integer $id
     * @param integer $text_weight_id
     *
     * @return boolean
     */
    public function editTextWeight($id, $text_weight_id)
    {
        if (intval($text_weight_id) !== DEFAULT_TEXT_WEIGHT_FOR_MODULE) {
            return $this->updateTextWeight($id, $text_weight_id);
        } else {
            return $this->clearTextWeight($id);
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
        $sql = "UPDATE 
                    `user_site_page_styling_content_item_typography` 
                SET 
                    `font_family_id` = :font_family_id  
                WHERE
                    `id` = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':font_family_id', $font_family_id);

        return $stmt->execute();
    }

    /**
     * Update text weight for a content item
     *
     * @param integer $id
     * @param integer $text_weight_id
     *
     * @return boolean
     */
    protected function updateTextWeight($id, $text_weight_id)
    {
        $sql = "UPDATE 
                    `user_site_page_styling_content_item_typography` 
                SET 
                    `text_weight_id` = :text_weight_id  
                WHERE
                    `id` = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':text_weight_id', $text_weight_id);

        return $stmt->execute();
    }

    /**
     * Remove the font family for a content item
     *
     * @param integer $id
     * @return boolean
     */
    protected function clearFontFamily($id)
    {
        $sql = "UPDATE `user_site_page_styling_content_item_typography` 
                SET 
                    `font_family_id` = NULL
                WHERE 
                    `id` = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    /**
     * Remove the text weight for a content item
     *
     * @param integer $id
     * @return boolean
     */
    protected function clearTextWeight($id)
    {
        $sql = "UPDATE `user_site_page_styling_content_item_typography` 
                SET 
                    `text_weight_id` = NULL
                WHERE 
                    `id` = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    /**
     * Font family valid
     *
     * @param integer $font_family_id
     * @return boolean
     */
    public function fontFamilyIdValid($font_family_id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `designer_css_font_family` 
                WHERE 
                    `id` = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $font_family_id);
        $stmt->execute();

        if ($stmt->fetch() !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Text weight valid
     *
     * @param integer $text_weight_id
     * @return boolean
     */
    public function textWeightIdValid($text_weight_id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `designer_css_text_weight` 
                WHERE 
                     `id` = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $text_weight_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch() !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fetch the font families supported by Dlayer for the select
     *
     * @return array|false
     */
    public function fontFamiliesForSelect()
    {
        $sql = "SELECT 
                    `id`, 
                    `name`   
                FROM 
                    `designer_css_font_family` 
                ORDER BY 
                    `name` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        $font_families = array();

        foreach ($stmt->fetchAll() as $row) {
            $font_families[intval($row['id'])] = $row['name'];
        }

        if (count($font_families) > 0) {
            return $font_families;
        } else {
            return false;
        }
    }

    /**
     * Fetch the text weights support by Dlayer for the select
     *
     * @return array|false
     */
    public function textWeightsForSelect()
    {
        $sql = "SELECT 
                    `id`, 
                    `name` 
                FROM 
                    `designer_css_text_weight` 
                ORDER BY 
                    `sort_order` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        $text_weights = array();

        foreach ($stmt->fetchAll() as $row) {
            $text_weights[intval($row['id'])] = $row['name'];
        }

        if (count($text_weights) > 0) {
            return $text_weights;
        } else {
            return false;
        }
    }

    /**
     * Fetch the font families supported by Dlayer for the preview
     *
     * @return array|false
     */
    public function fontFamiliesForPreview()
    {
        $sql = "SELECT 
                    `id`, 
                    `css`   
                FROM 
                    `designer_css_font_family`";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        $font_families = array();

        foreach ($stmt->fetchAll() as $row) {
            $font_families[intval($row['id'])] = $row['css'];
        }

        if (count($font_families) > 0) {
            return $font_families;
        } else {
            return false;
        }
    }

    /**
     * Fetch the font weights supported by Dlayer for preview
     *
     * @return array|false
     */
    public function textWeightsForPreview()
    {
        $sql = "SELECT 
                    `id`, 
                    `css`
                FROM 
                    `designer_css_text_weight`";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        $text_weights = array();

        foreach ($stmt->fetchAll() as $row) {
            $text_weights[intval($row['id'])] = $row['css'];
        }

        if (count($text_weights) > 0) {
            return $text_weights;
        } else {
            return false;
        }
    }
}
