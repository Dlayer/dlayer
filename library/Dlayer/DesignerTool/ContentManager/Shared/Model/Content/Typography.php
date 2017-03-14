<?php

/**
 * Shared model class for typography tools
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Shared_Model_Content_Typography
{
    private $model;

    public function __construct()
    {
        $this->model = new Dlayer_Model_DesignerTool_ContentManager_ContentStyling();
    }

    /**
     * Check to see if there is an existing font family defined
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Content id
     *
     * @return integer|false
     */
    public function existingFontFamilyId($site_id, $page_id, $id)
    {
        return $this->model->existingAttributeId($site_id, $page_id, $id, 'font-family');
    }

    /**
     * Set font family
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Content id
     * @param string $family_id
     *
     * @return boolean
     */
    public function addFontFamily($site_id, $page_id, $id, $family_id)
    {
        return $this->model->addAttributeValue($site_id, $page_id, $id, 'font-family', $family_id);
    }

    /**
     * Edit the set font family, removes the value if being cleared
     *
     * @param integer $id
     * @param string $family_id
     *
     * @return boolean
     */
    public function editFontFamily($id, $family_id)
    {
        return $this->model->editAttributeValue($id, $family_id);
    }

    /**
     * Fetch the current font family id
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return array|false
     */
    public function fontFamily($site_id, $page_id, $id)
    {
        return $this->model->getAttributeValue($site_id, $page_id, $id, 'font-family');
    }

    /**
     * Check to see if there is an existing font weight defined
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Content id
     *
     * @return integer|false
     */
    public function existingFontWeightId($site_id, $page_id, $id)
    {
        return $this->model->existingAttributeId($site_id, $page_id, $id, 'font-weight');
    }

    /**
     * Set font weight
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id Content id
     * @param string $weight_id
     *
     * @return boolean
     */
    public function addFontWeight($site_id, $page_id, $id, $weight_id)
    {
        return $this->model->addAttributeValue($site_id, $page_id, $id, 'font-weight', $weight_id);
    }

    /**
     * Edit the set font weight, removes the value if being cleared
     *
     * @param integer $id
     * @param string $weight_id
     *
     * @return boolean
     */
    public function editFontWeight($id, $weight_id)
    {
        return $this->model->editAttributeValue($id, $weight_id);
    }

    /**
     * Fetch the current font weight id
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $id
     *
     * @return array|false
     */
    public function fontWeight($site_id, $page_id, $id)
    {
        return $this->model->getAttributeValue($site_id, $page_id, $id, 'font-weight');
    }
}
