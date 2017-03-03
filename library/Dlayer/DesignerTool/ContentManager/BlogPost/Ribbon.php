<?php

/**
 * Blog post content item ribbon data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_BlogPost_Ribbon extends Dlayer_Ribbon_Content
{
    /**
     * Fetch the view data for the tool tab, contains an index with the form (pre filled if necessary) and another
     * with the data required by the live preview functions
     *
     * @param array $tool Tool and environment data array
     * @return array Data array for view
     */
    public function viewData(array $tool)
    {
        $this->tool = $tool;

        $this->contentData();
        $this->previewData();
        $this->instancesOfData();
        $this->elementData();

        return array(
            'form' => new Dlayer_DesignerTool_ContentManager_BlogPost_Form(
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

            $model = new Dlayer_DesignerTool_ContentManager_BlogPost_Model();
            $heading_types = $model->headingTypes();

            if (count($heading_types) > 0) {
                $this->element_data['type'] = $heading_types;
            }

            $this->element_data['format'] = $model->formats();

            $this->element_data_fetched = true;
        }
    }

    /**
     * Fetch the existing data for the content item, always returns  a data array, if not in edit mode the values will
     * all be false
     *
     * @return void
     */
    protected function contentData()
    {
        if ($this->content_fetched === false) {
            $this->content_data = array(
                'name' => false,
                'content' => false,
                'heading' => false,
                'type' => false,
                'date' => false,
                'format' => false
            );

            if ($this->tool['content_id'] !== null) {
                $model = new Dlayer_DesignerTool_ContentManager_BlogPost_Model();
                $existing_data = $model->existingData($this->tool['site_id'], $this->tool['content_id']);
                if ($existing_data !== false) {

                    $bits = explode(Dlayer_Config::CONTENT_DELIMITER, $existing_data['content']);
                    if (count($bits) === 3) {
                        $this->content_data['name'] = $existing_data['name'];
                        $this->content_data['content'] = $bits[2];
                        $this->content_data['format'] = $existing_data['format'];
                        $this->content_data['type'] = $existing_data['heading_id'];
                        $this->content_data['date'] = $bits[1];
                        $this->content_data['heading'] = $bits[0];
                    }
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
        if ($this->instances_of_fetched === false) {

            $this->instances_of = 0;

            if ($this->tool['content_id'] !== null) {
                $model = new Dlayer_DesignerTool_ContentManager_BlogPost_Model();
                $this->instances_of = $model->instancesOfData($this->tool['site_id'], $this->tool['content_id']);
            }

            $this->instances_of_fetched = true;
        }
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
                'text' => $this->content_data['content']
            );

            $this->preview_data_fetched = true;
        }
    }
}
