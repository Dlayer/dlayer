<?php

/**
 * Column setting sub tool ribbon class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Column_SubTool_Settings_Ribbon extends Dlayer_Ribbon_Content
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

        return array(
            'form' => new Dlayer_DesignerTool_ContentManager_Column_SubTool_Settings_Form(
                $tool,
                $this->content_data,
                $this->instancesOfData(),
                array()
            )
        );
    }

    /**
     * Fetch the data array for the column, if in edit mode populate the values otherwise every value is
     * set to FALSE, the tool form can simply check to see if the value is FALSE, if not it can use the value directly
     *
     * @return void
     */
    protected function contentData()
    {
        if ($this->content_fetched === false) {
            $this->content_data = array(
                'width' => false,
                'offset' => false,
                'column_type' => false
            );

            $model = new Dlayer_DesignerTool_ContentManager_Column_SubTool_Settings_Model();
            $width_properties = $model->widthProperties(
                $this->tool['site_id'],
                $this->tool['page_id'],
                $this->tool['column_id']
            );

            if ($width_properties !== false) {
                $this->content_data['width'] = $width_properties['width'];
                $this->content_data['offset'] = $width_properties['offset'];
                $this->content_data['column_type'] = $width_properties['column_type'];
            }

            $this->content_fetched = true;
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
