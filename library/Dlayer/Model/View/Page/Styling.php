<?php

/**
 * Base styling class for a content page, fetches all the styling data
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the
 *     generated web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Page_Styling extends Zend_Db_Table_Abstract
{
    /**
     * @var integer The id of the currently selected site
     */
    private $site_id;

    /**
     * @var integer The od of the currently selected page
     */
    private $page_id;

    /**
     * Set the site id and page id
     *
     * @param integer $site_id
     * @param integer $page_id
     *
     * @return void
     */
    public function setUp($site_id, $page_id)
    {
        $this->site_id = $site_id;
        $this->page_id = $page_id;
    }

    /**
     * Return the content item styles, grouped by styling group and content id, contaisn the data for every content
     * item on the given page
     *
     * @return array
     */
    public function contentItems()
    {
        /**
         * @todo Once we have transferred all styling to new tables this could be done in a single query, no need for four
         */
        return array(
            'background_color' => $this->contentItemBackgroundColors(),
            'border_top' => $this->contentItemsBorderTop(),
            'font_family' => $this->contentItemFontFamilies(),
            'text_weight' => $this->contentItemFontWeights()
        );
    }

    /**
     * Return the column styles, grouped by styling group and then column id, contains the data for all the columns
     * that make up the page
     *
     * @return array
     */
    public function columns()
    {
        return array(
            'background_color' => $this->columnBackgroundColors()
        );
    }

    /**
     * Return the row styles, grouped by styling group and then row id, contains the data for all the rows
     * that make up the page
     *
     * @return array
     */
    public function rows()
    {
        return array(
            'background_color' => $this->rowBackgroundColors()
        );
    }

    /**
     * Return the content container styles, grouped by styling group and then page id, contains all the data for the
     * selected page content container
     *
     * @return array
     */
    public function contentContainer()
    {
        return array(
            'background_color' => $this->contentContainerBackgroundColors()
        );
    }

    /**
     * Return the HTML styles, grouped by styling group and then page id, contains all the data for the selected
     * page
     *
     * @return array
     */
    public function page()
    {
        return array(
            'background_color' => $this->contentContainerBackgroundColors()
        );
    }

    /**
     * Return the HTML styles, grouped by styling group and then page id, contains all the data for the selected
     * page
     *
     * @return array
     */
    public function html()
    {
        return array(
            'background_color' => $this->htmlBackgroundColor()
        );
    }

    /**
     * Fetch the background color styles array indexed by content item id
     *
     * @return array
     */
    private function contentItemBackgroundColors()
    {
        $sql = "SELECT 
                    `content_id`, 
                    `value` 
                FROM 
                    `user_site_content_styling` 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `attribute` = :attribute";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', 'background-color', PDO::PARAM_STR);
        $stmt->execute();

        $styles = array();

        foreach ($stmt->fetchAll() as $row) {
            $styles[intval($row['content_id'])] = $row['value'];
        }

        return $styles;
    }

    /**
     * Fetch the border top styles for the content items indexed by content id
     *
     * @todo This is how the rest of the styling code needs to work
     * @return array
     */
    private function contentItemsBorderTop()
    {
        $sql = "SELECT 
                    `content_id`, 
                    `value` 
                FROM 
                    `user_site_content_styling` 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `attribute` = :attribute";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', 'border-top', PDO::PARAM_STR);
        $stmt->execute();

        $styles = array();

        foreach ($stmt->fetchAll() as $row) {
            $styles[intval($row['content_id'])] = $row['value'];
        }

        return $styles;
    }

    /**
     * Fetch the defined font families indexed by content id
     *
     * @return array
     */
    private function contentItemFontFamilies()
    {
        $sql = "SELECT 
                    `uscs`.`content_id`, 
                    `dcff`.`css` 
                FROM 
                    `user_site_content_styling` `uscs`
                INNER JOIN 
                    `designer_css_font_family` `dcff` ON 
                        `uscs`.`value` = `dcff`.`id` 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `attribute` = :attribute";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', 'font-family', PDO::PARAM_STR);
        $stmt->execute();

        $styles = array();

        foreach ($stmt->fetchAll() as $row) {
            $styles[intval($row['content_id'])] = $row['css'];
        }

        return $styles;
    }

    /**
     * Fetch the defined font weights indexed by content id
     *
     * @return array
     */
    private function contentItemFontWeights()
    {
        $sql = "SELECT 
                    `uscs`.`content_id`, 
                    `dctw`.`css` 
                FROM 
                    `user_site_content_styling` `uscs`
                INNER JOIN 
                    `designer_css_text_weight` `dctw` ON 
                        `uscs`.`value` = `dctw`.`id` 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `attribute` = :attribute";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', 'font-weight', PDO::PARAM_STR);
        $stmt->execute();

        $styles = array();

        foreach ($stmt->fetchAll() as $row) {
            $styles[intval($row['content_id'])] = $row['css'];
        }

        return $styles;
    }

    /**
     * Fetch the background color styles array indexed by column id
     *
     * @return array
     */
    private function columnBackgroundColors()
    {
        $sql = "SELECT 
                    `column_id`, 
                    `value` 
                FROM 
                    `user_site_column_styling`  
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `attribute` = :attribute";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', 'background-color', PDO::PARAM_STR);
        $stmt->execute();

        $styles = array();

        foreach ($stmt->fetchAll() as $row) {
            $styles[intval($row['column_id'])] = $row['value'];
        }

        return $styles;
    }

    /**
     * Fetch the background color styles array indexed by row id
     *
     * @return array
     */
    private function rowBackgroundColors()
    {
        $sql = "SELECT 
                    `row_id`, 
                    `value` 
                FROM 
                    `user_site_row_styling` 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `attribute` = :attribute";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', 'background-color', PDO::PARAM_STR);
        $stmt->execute();

        $styles = array();

        foreach ($stmt->fetchAll() as $row) {
            $styles[intval($row['row_id'])] = $row['value'];
        }

        return $styles;
    }

    /**
     * Fetch the background color styles for the content container
     *
     * @return array
     */
    private function contentContainerBackgroundColors()
    {
        $sql = "SELECT 
                    `page_id`, 
                    `value` 
                FROM 
                    `user_site_page_styling` 
                WHERE 
                    `site_id` = :site_id AND 
                    `page_id` = :page_id AND 
                    `attribute` = :attribute";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', 'background-color', PDO::PARAM_STR);
        $stmt->execute();

        $styles = array();

        foreach ($stmt->fetchAll() as $row) {
            $styles[intval($row['page_id'])] = $row['value'];
        }

        return $styles;
    }

    /**
     * Fetch the background color styles for HTML/page
     *
     * @return string|false
     */
    private function htmlBackgroundColor()
    {
        $sql = "SELECT 
                    `value` 
                FROM 
                    `user_site_html_styling` 
                WHERE 
                    `site_id` = :site_id AND 
                    `attribute` = :attribute";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':attribute', 'background-color', PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result != false) {
            return $result['value'];
        } else {
            return false;
        }
    }
}
