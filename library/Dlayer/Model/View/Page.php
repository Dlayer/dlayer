<?php

/**
 * Responsible for fetching all the data that makes up the structure of a content page as well as the content itself
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web
 *     site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_Page extends Zend_Db_Table_Abstract
{
    /**
     * @var integer
     */
    private $site_id;
    /**
     * @var integer
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
     * Fetch all the rows that have been assigned to the requested content page, the results will be grouped
     * by column id with null (0 in code) being rows that are assigned to the body div, rows can only ever be
     * assigned to columns or the body div
     *
     * @return array Always returns an array
     */
    public function rows()
    {
        $sql = 'SELECT uspsr.id AS row_id, uspsr.column_id 
				FROM user_site_page_structure_row uspsr 
				WHERE uspsr.site_id = :site_id
				AND uspsr.page_id = :page_id 
				ORDER BY uspsr.column_id ASC, uspsr.sort_order ASC';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $rows = array();

        foreach ($result as $row) {
            if ($row['column_id'] !== null) {
                $rows[intval($row['column_id'])][] = array(
                    'id' => intval($row['row_id']),
                    'column_id' => intval($row['column_id']),
                );
            } else {
                $rows[0][] = array('id' => intval($row['row_id']), 'column_id' => 0);
            }
        }

        return $rows;
    }

    /**
     * Fetch all the columns that have been assigned to the current content page, the results will be grouped by
     * row id, columns can only ever be assigned to rows
     *
     * @return array Always returns an array
     */
    public function columns()
    {
        $sql = "SELECT 
                    `uspsc`.`id`, 
                    `uspsc`.`row_id`, 
                    `uspsc`.`size`, 
                    `dct`.`column_type`, 
                    `uspsc`.`offset`
				FROM 
				    `user_site_page_structure_column` `uspsc` 
				INNER JOIN 
				    `user_site_page_structure_row` `uspsr` ON 
				        `uspsc`.`row_id` = `uspsr`.`id` AND 
				         `uspsr`.`site_id` = :site_id AND 
				         `uspsr`.`page_id` = :page_id 
                INNER JOIN 
                    `designer_column_type` `dct` ON 
                        `uspsc`.`column_type_id` = `dct`.`id` 
				WHERE 
				    `uspsc`.`site_id` = :site_id AND 
				    `uspsc`.`page_id` = :page_id 
				ORDER BY 
				    `uspsr`.`sort_order` ASC, 
				    `uspsc`.`sort_order` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $columns = array();

        foreach ($result as $column) {
            $columns[intval($column['row_id'])][] = array(
                'id' => intval($column['id']),
                'row_id' => intval($column['row_id']),
                'width' => intval($column['size']),
                'column_type' => $column['column_type'],
                'offset' => intval($column['offset']),
            );
        }

        return $columns;
    }

    /**
     * Fetch all the defined responsive column widths, results are grouped by column_id
     *
     * @return array Always returns an array
     */
    public function responsiveColumnWidths()
    {
        $sql = "SELECT 
                    `uspscr`.`column_id`,
                    `uspscr`.`size` AS `width`, 
                    `dct`.`column_type`
                FROM 
                    `user_site_page_structure_column_responsive` `uspscr` 
                INNER JOIN 
                    `designer_column_type` dct ON 
                        `uspscr`.`column_type_id` = `dct`.`id` 
                WHERE 
                    `uspscr`.`site_id` = :site_id AND 
                    `uspscr`.`page_id` = :page_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $widths = array();

        foreach ($result as $row) {
            $widths[intval($row['column_id'])][$row['column_type']] = intval($row['width']);
        }

        return $widths;
    }

    /**
     * Fetch all the content items that have been attached to the requested content page, as we loop through the
     * results the details for each content item type are pulled, the results are grouped by column id and returned
     * as a single array
     *
     * @return array Content items indexed by row id
     */
    public function content()
    {
        $sql = "SELECT 
                    `uspsc`.`id` AS `content_id`, 
                    `uspsc`.`column_id`, 
                    `dct`.`name` AS `content_type` 
                FROM 
                    `user_site_page_structure_content` `uspsc`
                INNER JOIN 
                    `designer_content_type` `dct` ON 
                        `uspsc`.`content_type` = `dct`.`id`
                INNER JOIN 
                    `user_site_page_structure_column` `uspscol` ON 
                        `uspsc`.`column_id` = uspscol.id AND 
                        `uspscol`.`site_id` = :site_id AND 
                        `uspscol`.`page_id` = :page_id 
                WHERE 
                    `uspsc`.`site_id` = :site_id AND 
                    `uspsc`.`page_id` = :page_id AND 
                    `uspsc`.`deleted` = 0 
                ORDER BY 
                    `uspscol`.`sort_order`, 
                    `uspsc`.`sort_order`";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $content = array();

        foreach ($result as $row) {
            switch ($row['content_type']) {
                case 'BlogPost':
                    $content_item = $this->blogPost($row['content_id']);
                    break;

                case 'Form':
                    $content_item = $this->form($row['content_id']);

                    if ($content_item !== false) {
                        $content_item['form'] = new Dlayer_Designer_Form($this->site_id,
                            $content_item['form_id'], false, null);
                    }
                    break;

                case 'Heading':
                    $content_item = $this->heading($row['content_id']);
                    break;

                case 'HeadingDate':
                    $content_item = $this->headingDate($row['content_id']);
                    break;

                case 'Html':
                    $content_item = $this->html($row['content_id']);
                    break;

                case 'Image':
                    $content_item = $this->image($row['content_id']);
                    break;

                case 'Jumbotron':
                    $content_item = $this->jumbotron($row['content_id']);
                    break;

                case 'RichText':
                    $content_item = $this->richText($row['content_id']);
                    break;

                case 'Text':
                    $content_item = $this->text($row['content_id']);
                    break;

                default:
                    $content_item = false;
                    break;
            }

            if ($content_item !== false) {
                $content[intval($row['column_id'])][] = array(
                    'column_id' => intval($row['column_id']),
                    'content_id' => intval($row['content_id']),
                    'type' => $row['content_type'],
                    'data' => $content_item,
                );
            }
        }

        return $content;
    }

    /**
     * Fetch all the data for a 'text' based content item
     *
     * @param integer $id Id of the content item
     *
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function text($id)
    {
        $model_text = new Dlayer_Model_View_Page_Content_Text();

        return $model_text->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'jumbotron' based content item
     *
     * @param integer $id Id of the content item
     *
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function jumbotron($id)
    {
        $model_jumbotron = new Dlayer_Model_View_Page_Content_Jumbotron();

        return $model_jumbotron->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'html' snippet
     *
     * @param integer $id Id of the content item
     *
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function html($id)
    {
        $model_html = new Dlayer_Model_View_Page_Content_Html();

        return $model_html->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'heading' based content item
     *
     * @param integer $id Id of the content item
     *
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function image($id)
    {
        $model_image = new Dlayer_Model_View_Page_Content_Image();

        return $model_image->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'heading' based content item
     *
     * @param integer $id Id of the content item
     *
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function heading($id)
    {
        $model_heading = new Dlayer_Model_View_Page_Content_Heading();

        return $model_heading->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'heading-date' based content item
     *
     * @param integer $id Id of the content item
     *
     * @return array|false Either an array of the data for the content item or FALSE upon error
     */
    private function headingDate($id)
    {
        $model = new Dlayer_Model_View_Page_Content_HeadingDate();

        return $model->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'form' based content item
     *
     * @param integer $id Id of the content item
     *
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function form($id)
    {
        $model_form = new Dlayer_Model_View_Page_Content_Form();

        return $model_form->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'rich-text' content item
     *
     * @param integer $id Id of the content item
     *
     * @return array|false Either an array of the data for the content item or false upon error
     */
    private function richText($id)
    {
        $model = new Dlayer_Model_View_Page_Content_RichText();

        return $model->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'blog post' content item
     *
     * @param integer $id Id of the content item
     *
     * @return array|false Either an array of the data for the content item or false upon error
     */
    private function blogPost($id)
    {
        $model = new Dlayer_Model_View_Page_Content_BlogPost();

        return $model->data($this->site_id, $this->page_id, $id);
    }
}
