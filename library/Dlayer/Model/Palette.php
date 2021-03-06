<?php

/**
 * Color palette model
 *
 * When a user creates a site they define three color palettes, anytime they
 * need to choose a color for a tool these three palettes are shown to them
 * in the order they specifed
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 * @category Model
 */
class Dlayer_Model_Palette extends Zend_Db_Table_Abstract
{
    /**
     * Fetch all the colors that have been defined for the requested color
     * palette. The tab name relates to the palette order, so palette one
     * will be shown on tab 1
     *
     * @param integer $site_id
     * @param string $tab
     * @return array|FALSE
     */
    public function colorsByPaletteTab($site_id, $tab)
    {
        $sql = 'SELECT dct.type, uscpc.`name`, uscpc.color_hex
				FROM user_setting_color_palette uscp
				JOIN user_setting_color_palette_color uscpc
				ON uscp.id = uscpc.palette_id
				AND uscpc.site_id = :site_id
				JOIN designer_color_type dct ON uscpc.color_type_id = dct.id
				WHERE uscp.site_id = :site_id
				AND uscp.view_script = :tab
				ORDER BY uscpc.id ASC';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':tab', $tab, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchAll();

        if (count($result) == 3) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Fetch the two defined color palettes and all the colors (10), returns
     * the color palette name, color and color name grouped by palette
     *
     * Used by the color picker in the designers
     *
     * @param integer $site_id
     * @return array|FALSE
     */
    public function palettes($site_id)
    {
        $sql = "SELECT uscp.`name` AS palette, uscpc.palette_id,
				uscpc.`name`, uscpc.color_hex
				FROM user_setting_color_palette_color uscpc
				JOIN user_setting_color_palette uscp
				ON uscpc.palette_id = uscp.id
				WHERE uscpc.site_id = :site_id
				ORDER BY uscpc.palette_id, uscpc.color_type_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        if (count($result) == 10) {

            $palettes = array();

            foreach ($result as $color) {
                $palettes[$color['palette_id']]['name'] = $color['palette'];
                $palettes[$color['palette_id']]['colors'][] =
                    array(
                        'name' => $color['name'],
                        'color_hex' => $color['color_hex']
                    );
            }

            return $palettes;
        } else {
            return false;
        }
    }

    /**
     * fetch the last few unique colors used for the requested site
     *
     * Used by the color picker in the designers
     *
     * @param integer $site_id
     * @param integer $n Defaults to 5 last colors
     * @return array
     */
    public function lastNColors($site_id, $n = 5)
    {
        $sql = "SELECT color_hex
				FROM user_setting_color_history
				WHERE site_id = :site_id
				GROUP BY color_hex, id
				ORDER BY id DESC
				LIMIT :limit";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $n, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Add a new entry into the colour history table for the given site
     *
     * @todo Probably wise to get it to check for duplicates before adding history data
     * @todo Add in a check to see what is passing empty values
     *
     * @param integer $site_id
     * @param string $color_hex
     * @return boolean
     */
    public function addToHistory($site_id, $color_hex)
    {
        if (strlen($color_hex) === 7) {
            $sql = "INSERT INTO user_setting_color_history
                    (site_id, color_hex)
                    VALUES
                    (:site_id, :color_hex)";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
            $stmt->bindValue(':color_hex', $color_hex, PDO::PARAM_STR);
            return $stmt->execute();
        } else {
            return true;
        }
    }
}
