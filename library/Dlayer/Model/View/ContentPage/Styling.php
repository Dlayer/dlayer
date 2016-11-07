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
            'background_color' => $this->contentItemBackgroundColors()
        );
    }

    /**
     * Fetch the background colour styles
     *
     * @todo The different styles will probably be fields of the table, rather than different tables, may just
     * need one select and methods to organise, for now keep it separate, maybe rename the table for now
     *
     * @return array|FALSE
     */
    private function contentItemBackgroundColors()
    {
        $sql = "SELECT background_color 
                FROM user_site_page_styling_content_item_background_color 
                WHERE site_id = :site_id 
                AND page_id = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id);
        $stmt->bindValue(':page_id', $this->page_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
