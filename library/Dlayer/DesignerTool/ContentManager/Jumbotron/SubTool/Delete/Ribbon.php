<?php

/**
 * Jumbotron ribbon data class for delete sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Jumbotron_SubTool_Delete_Ribbon extends Dlayer_Ribbon_Content
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

        return array(
            'form' => new Dlayer_DesignerTool_ContentManager_Jumbotron_SubTool_Delete_Form(
                $tool,
                array(),
                0,
                array()
            )
        );
    }

    /**
     * Fetch the data array for the content item, if in edit mode mode populate the values otherwise every value is
     * set to FALSE, the tool form can simply check to see if the value is FALSe or not and then set the existing value
     *
     * @return array
     */
    protected function contentData()
    {
        // TODO: Implement contentData() method.
    }

    /**
     * Fetch the number of instances for the content items data
     *
     * @return integer
     */
    protected function instancesOfData()
    {
        // TODO: Implement instancesOfData() method.
    }
}
