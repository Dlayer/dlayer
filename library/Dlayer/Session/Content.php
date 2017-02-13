<?php

/**
 * Custom session class for the content module, stores all the vars that we
 * need to manager the environment, attempting to not have any visible get vars
 * which may confused the user.
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Session_Content extends Zend_Session_Namespace
{
    /**
     * @param string $namespace
     * @param bool $singleInstance
     * @return void
     */
    public function __construct(
        $namespace = 'dlayer_session_content',
        $singleInstance = false
    ) {
        parent::__construct($namespace, $singleInstance);

        $this->setExpirationSeconds(3600);
    }

    /**
     * Set the id for the selected page
     *
     * @todo This should check validity
     * @param integer $id
     * @return void
     */
    public function setPageId($id)
    {
        $this->page_id = intval($id);
    }

    /**
     * Get the id of the page the user is working on
     *
     * @return integer|NULL
     */
    public function pageId()
    {
        return $this->page_id;
    }

    /**
     * Set a var to signify that the page is selected in the Content manager, when we set the page as selected we
     * also set the selected column to 0, rows can be added to columns and the base page container so we use 0 to
     * signify the page container
     *
     * @return void
     */
    public function setPageSelected()
    {
        $this->page_selected = true;

        $this->setColumnId(0);
        $this->row_id = null;
    }

    /**
     * Check to see if the page is selected
     *
     * @todo Not keen on this returning TRUE|NULL, should be TRUE|FALSE based on method name although other methods return INT|NULL, review later
     * @return TRUE|NULL
     */
    public function pageSelected()
    {
        return $this->page_selected;
    }

    /**
     * Set the id for the selected row. By default the id of any previously selected content will be cleared
     *
     * @todo This should check validity
     * @param integer $id
     * @param boolean $clear_content_id Clear the id of any previously selected content ids
     * @return void
     */
    public function setRowId($id, $clear_content_id = true)
    {
        $this->row_id = intval($id);

        if ($clear_content_id === true) {
            $this->content_id = null;
        }
    }

    /**
     * Get the id of the selected row
     *
     * @return integer|NULL
     */
    public function rowId()
    {
        return $this->row_id;
    }

    /**
     * Set the id for the selected column
     *
     * @todo This should check validity
     * @param integer $id
     * @return void
     */
    public function setColumnId($id)
    {
        $this->column_id = intval($id);
    }

    /**
     * Get the id of the selected column
     *
     * @return integer|NULL
     */
    public function columnId()
    {
        return $this->column_id;
    }

    /**
     * Clear the currently set content id value, content_id is set to NULL
     *
     * @return void
     */
    public function clearContentId()
    {
        $this->content_id = null;
    }

    /**
     * Set the id of the content item being selected aftre checking to ensure it the supplied params are valid
     *
     * @param integer $content_id
     * @param string $content_type
     * @return boolean
     */
    public function setContentId($content_id, $content_type)
    {
        $session_dlayer = new Dlayer_Session();
        $model_content = new Dlayer_Model_Page();

        if ($model_content->validItem($content_id, $session_dlayer->siteId(), $this->pageId(), $this->columnId(),
                $content_type) === true
        ) {
            $this->content_id = intval($content_id);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the id of the selected content block
     *
     * @return integer|NULL
     */
    public function contentId()
    {
        return $this->content_id;
    }

    /**
     * Clears the session values for the content manager, these are the vars
     * that relate to the current state of the designer, selected div,
     * content row, content item, tool and tab.
     *
     * The page id and template id are left set, essentially the state of the
     * designer is reset back to default
     *
     * @param boolean $reset If set to TRUE all the content session values are
     *    cleared, this will include the page id and then template id
     * @return void
     */
    public function clearAll($reset = false)
    {
        $this->page_selected = null;
        $this->column_id = null;
        $this->row_id = null;
        $this->content_id = null;

        if ($reset == true) {
            $this->page_id = null;
        }
    }
}
