<?php

/**
 * Responsible for fetching all the data that makes up the structure of a content page as well as the content itself
 *
 * @category View model: These models are used to generate the data in the designers, the user data and later the web site
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_View_ContentPage extends Zend_Db_Table_Abstract
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
     * Fetch all the columns that have been assigned to the content oage, the results will be grouped by row id, columns
     * can only ever be assigned to columns
     *
     * @return array Always returns an array
     */
    public function columns()
    {
        $sql = 'SELECT uspsc.id, uspsc.row_id, uspsc.size, uspsc.column_type, uspsc.offset
				FROM user_site_page_structure_column uspsc 
				JOIN user_site_page_structure_row uspsr ON uspsc.row_id = uspsr.id 
					AND uspsr.site_id = :site_id 
					AND uspsr.page_id = :page_id 
				WHERE uspsc.site_id = :site_id 
				AND uspsc.page_id = :page_id 
				ORDER BY uspsr.sort_order, uspsc.sort_order';
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
                'size' => intval($column['size']),
                'class' => $column['column_type'],
                'offset' => intval($column['offset']),
            );
        }

        return $columns;
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
        $sql = 'SELECT uspsc.id AS content_id, uspsc.column_id, dct.name AS content_type 
                FROM user_site_page_structure_content uspsc
                JOIN designer_content_type dct ON uspsc.content_type = dct.id
                JOIN user_site_page_structure_column uspscol ON uspsc.column_id = uspscol.id 
                    AND uspscol.site_id = :site_id 
                    AND uspscol.page_id = :page_id 
                WHERE uspsc.site_id = :site_id
                AND uspsc.page_id = :page_id  
                ORDER BY uspscol.sort_order, uspsc.sort_order';
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':page_id', $this->page_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $content = array();

        foreach ($result as $row) {
            switch ($row['content_type']) {
                case 'text':
                    $content_item = $this->text($row['content_id']);
                    break;

                case 'heading':
                    $content_item = $this->heading($row['content_id']);
                    break;

                case 'form':
                    $content_item = $this->form($row['content_id']);

                    if ($content_item !== false) {
                        $content_item['form'] = new Dlayer_Designer_Form($this->site_id,
                            $content_item['form_id'], true, null);
                    }
                    break;

                case 'jumbotron':
                    $content_item = $this->jumbotron($row['content_id']);
                    break;

                case 'image':
                    $content_item = $this->image($row['content_id']);
                    break;

                case 'html':
                    $content_item = $this->html($row['content_id']);
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
                    'data' => $content_item
                );
            }
        }

        return $content;
    }

    /**
     * Fetch all the data for a 'text' based content item
     *
     * @param integer $id Id of the content item
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function text($id)
    {
        $model_text = new Dlayer_Model_View_ContentPage_Item_Text();

        return $model_text->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'jumbotron' based content item
     *
     * @param integer $id Id of the content item
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function jumbotron($id)
    {
        $model_jumbotron = new Dlayer_Model_View_ContentPage_Item_Jumbotron();

        return $model_jumbotron->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'html' snippet
     *
     * @param integer $id Id of the content item
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function html($id)
    {
        $model_html = new Dlayer_Model_View_ContentPage_Item_Html();

        return $model_html->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'heading' based content item
     *
     * @param integer $id Id of the content item
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function image($id)
    {
        $model_image = new Dlayer_Model_View_ContentPage_Item_Image();

        return $model_image->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'heading' based content item
     *
     * @param integer $id Id of the content item
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function heading($id)
    {
        $model_heading = new Dlayer_Model_View_ContentPage_Item_Heading();

        return $model_heading->data($this->site_id, $this->page_id, $id);
    }

    /**
     * Fetch all the data for a 'form' based content item
     *
     * @param integer $id Id of the content item
     * @return array|FALSE Either an array of the data for the content item or FALSE upon error
     */
    private function form($id)
    {
        $model_form = new Dlayer_Model_View_ContentPage_Item_Form();

        return $model_form->data($this->site_id, $this->page_id, $id);
    }
}