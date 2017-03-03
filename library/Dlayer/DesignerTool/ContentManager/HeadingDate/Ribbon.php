<?php

/**
 * Heading & Date content item ribbon data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_HeadingDate_Ribbon extends Dlayer_Ribbon_Content
{

    /**
     * Fetch the view data for the current tool tab, typically the returned array will have at least two indexes,
     * one for the form and another with the data required by the preview functions
     *
     * @param array $tool Tool and environment data
     * @return array
     */
    public function viewData(array $tool)
    {
        $this->tool = $tool;

        $this->contentData();
        $this->previewData();
        $this->instancesOfData();
        $this->elementData();

        return array(
            'form' => new Dlayer_DesignerTool_ContentManager_HeadingDate_Form(
                $tool,
                $this->content_data,
                $this->instances_of,
                $this->element_data
            ),
            'preview' => $this->preview_data,
            'instances' => $this->instances_of
        );
    }

    /**
     * Fetch the data required to build the elements
     *
     * @return array
     */
    protected function elementData()
    {
        if ($this->element_data_fetched === false) {
            $this->element_data = array();

            $model = new Dlayer_DesignerTool_ContentManager_HeadingDate_Model();
            $heading_types = $model->headingTypes();

            if (count($heading_types) > 0) {
                $this->element_data['type'] = $heading_types;
            }

            $this->element_data['format'] = $model->formats();

            $this->element_data_fetched = true;
        }
    }

    /**
     * Fetch the data array for the content item, if in edit mode mode populate the values otherwise every value is
     * set to FALSE, the tool form can simply check to see if the value is FALSe or not and then set the existing value
     *
     * @return void
     */
    protected function contentData()
    {
        if ($this->content_fetched === false) {
            $this->content_data = array(
                'name' => false,
                'heading' => false,
                'type' => false,
                'date' => false,
                'format' => false
            );

            if ($this->tool['content_id'] !== null) {
                $model = new Dlayer_DesignerTool_ContentManager_HeadingDate_Model();
                $existing_data = $model->existingData($this->tool['site_id'], $this->tool['content_id']);

                if ($existing_data !== false) {
                    $content_bits = explode(Dlayer_Config::CONTENT_DELIMITER, $existing_data['content']);

                    $this->content_data['name'] = $existing_data['name'];
                    $this->content_data['heading'] = $content_bits[0];
                    $this->content_data['date'] = $content_bits[1];
                    $this->content_data['format'] = $existing_data['format'];
                    $this->content_data['type'] = intval($existing_data['heading_id']);
                }
            }

            $this->content_fetched = true;
        }
    }

    /**
     * Fetch the number of instances for the content item data
     *
     * @return void
     */
    protected function instancesOfData()
    {
        $this->instancesOfDataForBaseTool('HeadingDate');
    }

    /**
     * Fetch the data required by the preview functions
     *
     * @return void
     */
    protected function previewData()
    {
        if ($this->preview_data_fetched === false) {

            $this->contentData();

            $this->preview_data = array(
                'heading' => $this->content_data['heading'],
                'date' => date($this->content_data['format'], strtotime($this->content_data['date']))
            );

            $this->preview_data_fetched = true;
        }
    }
}
