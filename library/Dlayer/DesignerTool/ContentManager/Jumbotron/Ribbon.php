<?php

/**
 * Jumbotron content item ribbon data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Jumbotron_Ribbon extends Dlayer_Ribbon_Content
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
			'form' => new Dlayer_DesignerTool_ContentManager_Jumbotron_Form(
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
	 * Fetch the existing data for the content item, if in edit mode mode populate the values otherwise every value is
	 * set to FALSE, the tool form can simply check to see if the value is FALSE or not and then set the existing value
	 *
	 * @return void
	 */
	protected function contentData()
	{
	    if ($this->content_fetched === false) {
            $this->content_data = array(
                'name' => false,
                'title' => false,
                'intro' => false,
                'button_label' => false
            );

            if ($this->tool['content_id'] !== false) {
                $model_jumbotron = new Dlayer_DesignerTool_ContentManager_Jumbotron_Model();
                $existing_data = $model_jumbotron->existingData($this->tool['site_id'], $this->tool['content_id']);

                if ($existing_data !== false) {
                    $title = false;
                    $intro = false;
                    $content_bits = explode(Dlayer_Config::CONTENT_DELIMITER, $existing_data['content']);
                    switch (count($content_bits)) {
                        case 2:
                            $title = $content_bits[0];
                            $intro = $content_bits[1];
                            break;

                        case 1:
                            $title = $content_bits[0];
                            break;
                    }

                    $this->content_data['name'] = $existing_data['name'];
                    $this->content_data['title'] = $title;
                    $this->content_data['intro'] = $intro;
                    $this->content_data['button_label'] = $existing_data['button_label'];
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
                $model = new Dlayer_DesignerTool_ContentManager_Jumbotron_Model();
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
                'title' => $this->content_data['title'],
                'intro' => $this->content_data['intro']
            );

            $this->preview_data_fetched = true;
        }
    }
}
