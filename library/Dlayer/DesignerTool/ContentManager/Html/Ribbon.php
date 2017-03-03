<?php

/**
 * HTML content item ribbon data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Html_Ribbon extends Dlayer_Ribbon_Content
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
        $this->instancesOfData();

        return array(
            'form' => new Dlayer_DesignerTool_ContentManager_Html_Form(
                $tool,
                $this->content_data,
                $this->instances_of,
                array()
            ),
            'instances' => $this->instances_of
        );
    }

    /**
     * Fetch the existing data for the content item, always returns  a data array, if not in edit mode the values will
     * all be FALSE
     *
     * @return void
     */
    protected function contentData()
    {
        if ($this->content_fetched === false) {
            $this->content_data = array(
                'name' => false,
                'content' => false
            );

            if ($this->tool['content_id'] !== null) {
                $model = new Dlayer_DesignerTool_ContentManager_Html_Model();
                $existing_data = $model->existingData($this->tool['site_id'], $this->tool['content_id']);
                if ($existing_data !== false) {
                    $this->content_data['name'] = $existing_data['name'];
                    $this->content_data['content'] = $existing_data['content'];
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
        $this->instancesOfDataForBaseTool('Html');
    }
}
