<?php

/**
 * Text content item ribbon data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Heading_Ribbon extends Dlayer_Ribbon_Content
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

		return array(
			'form' => new Dlayer_DesignerTool_ContentManager_Heading_Form(
			    $tool,
                $this->content_data,
                $this->instances_of,
				$this->elementData()
            ),
            'preview' => $this->preview_data,
            'instances' => $this->instances_of
		);
	}

	/**
	 * fetch the data required to build the elements
	 *
	 * @return array
	 */
	protected function elementData()
	{
		$data = array();

		$model_heading = new Dlayer_DesignerTool_ContentManager_Heading_Model();
		$heading_types = $model_heading->headingTypesForSelect();

		if(count($heading_types) > 0)
		{
			$data['heading_type'] = $heading_types;
		}

		return $data;
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
                'sub_heading' => false,
                'heading_type' => false
            );

            if ($this->tool['content_id'] !== null) {
                $model_heading = new Dlayer_DesignerTool_ContentManager_Heading_Model();
                $existing_data = $model_heading->existingData($this->tool['site_id'], $this->tool['content_id']);

                if ($existing_data !== false) {
                    $heading = false;
                    $sub_heading = false;
                    $content_bits = explode(Dlayer_Config::CONTENT_DELIMITER, $existing_data['content']);
                    switch (count($content_bits)) {
                        case 2:
                            $heading = $content_bits[0];
                            $sub_heading = $content_bits[1];
                            break;

                        case 1:
                            $heading = $content_bits[0];
                            break;
                    }

                    $this->content_data['name'] = $existing_data['name'];
                    $this->content_data['heading'] = $heading;
                    $this->content_data['sub_heading'] = $sub_heading;
                    $this->content_data['heading_type'] = intval($existing_data['heading_id']);
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
                $model = new Dlayer_DesignerTool_ContentManager_Heading_Model();
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
                'title' => $this->content_data['heading'],
                'subtitle' => $this->content_data['sub_heading']
            );

            $this->preview_data_fetched = true;
        }
    }
}
