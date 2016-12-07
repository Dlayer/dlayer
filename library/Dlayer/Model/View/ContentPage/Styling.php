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
class Dlayer_Model_View_ContentPage_Styling extends Zend_Db_Table_Abstract
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
     * @var array Data array containing all the content item styles group by styl;ing group and content id
     */
    private $content_items = array(
        'background_colors' => false,
    );

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
        return array(
            'background_color' => $this->contentItemBackgroundColors(),
            'font-family' => $this->contentItemFontFamilies()
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
     * Fetch the background color styles array indexed by content item id
     *
     * @return array
     */
    private function contentItemBackgroundColors()
    {
        $sql = "SELECT content_id, background_color 
                FROM user_site_page_styling_content_item_background_color 
                WHERE site_id = :site_id 
                AND page_id = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id);
        $stmt->bindValue(':page_id', $this->page_id);
        $stmt->execute();

        $styles = array();

        foreach($stmt->fetchAll() as $row) {
            $styles[intval($row['content_id'])] = $row['background_color'];
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
        $sql = "SELECT uspscit.content_id, dcff.css 
                FROM user_site_page_styling_content_item_typography uspscit 
                JOIN designer_css_font_family dcff 
                    ON uspscit.font_family_id = dcff.id 
                WHERE uspscit.site_id = :site_id 
                AND uspscit.page_id = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id);
        $stmt->bindValue(':page_id', $this->page_id);
        $stmt->execute();

        $styles = array();

        foreach($stmt->fetchAll() as $row) {
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
        $sql = "SELECT column_id, background_color 
                FROM user_site_page_styling_column_background_color 
                WHERE site_id = :site_id 
                AND page_id = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id);
        $stmt->bindValue(':page_id', $this->page_id);
        $stmt->execute();

        $styles = array();

        foreach($stmt->fetchAll() as $row) {
            $styles[intval($row['column_id'])] = $row['background_color'];
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
        $sql = "SELECT row_id, background_color 
                FROM user_site_page_styling_row_background_color 
                WHERE site_id = :site_id 
                AND page_id = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id);
        $stmt->bindValue(':page_id', $this->page_id);
        $stmt->execute();

        $styles = array();

        foreach($stmt->fetchAll() as $row) {
            $styles[intval($row['row_id'])] = $row['background_color'];
        }

        return $styles;
    }
}
