<?php

/**
 * Text content item data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Text_SubTool_Typography_Ribbon extends Dlayer_Ribbon_Content
{
    /**
     * Fetch the view data for the current tool tab, typically the returned array will have at least two indexes,
     * one for the form and another with the data required by the preview functions
     *
     * @param array $tool Tool and environment data
     *
     * @return array
     */
    public function viewData(array $tool)
    {
        $this->tool = $tool;

        $this->contentData();
        $this->elementData();

        return array(
            'form' => new Dlayer_DesignerTool_ContentManager_Text_SubTool_Typography_Form(
                $tool,
                $this->content_data,
                $this->instancesOfData(),
                $this->element_data
            ),
            'preview' => $this->previewData()
        );
    }

    /**
     * Fetch the data array for the content item, if in edit mode mode populate the values otherwise every value is
     * set to FALSE, the tool form can simply check to see if the value is FALSe or not and then set the existing value
     *
     * @return void Writes to $this->content_data
     */
    protected function contentData()
    {
        if ($this->content_fetched === false) {
            $this->content_data = array(
                'font_family_id' => false,
            );

            if ($this->tool['content_id'] !== null) {
                $model = new Dlayer_DesignerTool_ContentManager_Text_SubTool_Typography_Model();
                $font_family_id = $model->fontFamily(
                    $this->tool['site_id'],
                    $this->tool['page_id'],
                    $this->tool['content_id']
                );

                if ($font_family_id !== false) {
                    $this->content_data['font_family_id'] = $font_family_id;
                }
            }

            $this->content_fetched = true;
        }
    }

    /**
     * Element data, data required to build the inputs
     *
     * @return array
     */
    protected function elementData()
    {
        if ($this->element_data_fetched === false) {

            $this->element_data = array(
                'font_families' => false
            );

            $model = new Dlayer_DesignerTool_ContentManager_Text_SubTool_Typography_Model();
            $font_families = $model->fontFamiliesForSelect();
            if($font_families !== false) {
                $this->element_data['font_families'] = $font_families;
            }

            $this->element_data_fetched = true;
        }
    }

    /**
     * Fetch the data required by the preview functions
     *
     * @return array
     */
    protected function previewData()
    {
        $this->contentData();

        return array(
            'id' => $this->tool['content_id'],
            'font_family_id' => $this->content_data['font_family_id']
        );
    }

    /**
     * Fetch the number of instances for the content items data
     *
     * @return integer
     */
    protected function instancesOfData()
    {
        return 0;
    }
}
