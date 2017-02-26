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

        return array(
            'form' => new Dlayer_DesignerTool_ContentManager_BlogPost_Form(
                $tool,
                $this->content_data,
                $this->instances_of,
                array()
            ),
            'preview' => $this->preview_data,
            'instances' => $this->instances_of
        );
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
