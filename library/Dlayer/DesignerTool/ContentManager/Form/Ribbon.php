<?php

/**
 * Import form ribbon data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Form_Ribbon extends Dlayer_Ribbon_Content
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
        $this->instancesOfData();

        return array(
            'form' => new Dlayer_DesignerTool_ContentManager_Form_Form(
                $tool,
                $this->content_data,
                $this->instances_of,
                $this->elementData()
            ),
            'instances' => $this->instances_of
        );
    }

    /**
     * Fetch any data required to build the elements
     *
     * @return array
     */
    protected function elementData()
    {
        $data = array();

        $model_form = new Dlayer_DesignerTool_ContentManager_Form_Model();
        $forms = $model_form->forms($this->tool['site_id']);

        if (count($forms) > 0) {
            $data['forms'] = $forms;
        }

        return $data;
    }

    /**
     * Fetch the data array for the content item, if in edit mode mode populate the values otherwise every value is
     * set to FALSE, the tool form can simply check to see if the value is FALSE or not and then set the existing value
     *
     * @return void
     */
    protected function contentData()
    {
        if ($this->content_fetched === false) {
            $this->content_data = array(
                'form_id' => false
            );

            if ($this->tool['content_id'] !== false) {
                $model_form = new Dlayer_DesignerTool_ContentManager_Form_Model();
                $form_id = $model_form->existingData($this->tool['site_id'], $this->tool['content_id']);

                if ($form_id !== false) {
                    $this->content_data['form_id'] = $form_id;
                }
            }

            $this->content_fetched = true;
        }
    }

    /**
     * Fetch the number of instances for the content items data
     *
     * @return void
     */
    protected function instancesOfData()
    {
        $this->instances_of = 0;
    }
}
