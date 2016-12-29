<?php

/**
 * Image content item data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Image_SubTool_Typography_Ribbon extends Dlayer_Ribbon_Content
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
        $this->previewData();

        return array(
            'form' => new Dlayer_DesignerTool_ContentManager_Image_SubTool_Typography_Form(
                $tool,
                $this->content_data,
                $this->instancesOfData(),
                $this->element_data
            ),
            'preview' => $this->preview_data
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
                'text_weight_id' => false
            );

            if ($this->tool['content_id'] !== null) {
                $model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Typography();

                $font_and_text_values = $model->fontAndTextValues(
                    $this->tool['site_id'],
                    $this->tool['page_id'],
                    $this->tool['content_id']
                );

                if ($font_and_text_values !== false) {
                    if ($font_and_text_values['text_weight_id'] !== null) {
                        $this->content_data['text_weight_id'] = $font_and_text_values['text_weight_id'];
                    }

                    if ($font_and_text_values['font_family_id'] !== null) {
                        $this->content_data['font_family_id'] = $font_and_text_values['font_family_id'];
                    }
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
                'font_families' => false,
                'text_weights' => false
            );

            $model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Typography();

            $font_families = $model->fontFamiliesForSelect();
            if ($font_families !== false) {
                $this->element_data['font_families'] = $font_families;
            }

            $text_weights = $model->textWeightsForSelect();
            if ($text_weights !== false) {
                $this->element_data['text_weights'] = $text_weights;
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
        if ($this->element_data_fetched === false || $this->preview_data_fetched === false) {

            $this->contentData();

            $this->preview_data = array(
                'id' => $this->tool['content_id'],
                'font_family_id' => $this->content_data['font_family_id'],
                'font_families' => false,
                'text_weights' => false
            );

            $model = new Dlayer_DesignerTool_ContentManager_Shared_Model_Typography();

            $font_families = $model->fontFamiliesForPreview();
            if ($font_families !== false) {
                $this->preview_data['font_families'] = $font_families;
            }

            $text_weights = $model->textWeightsForPreview();
            if ($text_weights !== false) {
                $this->preview_data['text_weights'] = $text_weights;
            }

            $this->preview_data_fetched = true;
        }
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
