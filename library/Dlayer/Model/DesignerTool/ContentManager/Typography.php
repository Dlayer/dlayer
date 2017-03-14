<?php

/**
 * Typography helper model
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_DesignerTool_ContentManager_Typography extends Zend_Db_Table_Abstract
{
    /**
     * Check to see if the given font id is valid
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function fontFamilyIdValid($id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `designer_css_font_family` 
                WHERE 
                    `id` = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch() !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check to see if the given font weight is valid
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function fontWeightIdValid($id)
    {
        $sql = "SELECT 
                    `id` 
                FROM 
                    `designer_css_text_weight` 
                WHERE 
                     `id` = :id 
                LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch() !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fetch the font families array to use in select menus
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
     * Fetch the font weights array to use in select menus
     *
     * @return array|false
     */
    public function fontWeightsForSelect()
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
    public function fontWeightsForPreview()
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
