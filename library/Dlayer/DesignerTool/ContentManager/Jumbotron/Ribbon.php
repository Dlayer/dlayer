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

		return array(
			'form' => new Dlayer_DesignerTool_ContentManager_Jumbotron_Form($tool, $this->contentData(),
				$this->instancesOfData(), array()),
            'preview' => $this->previewData()
		);
	}

	/**
	 * Fetch the existing data for the content item, if in edit mode mode populate the values otherwise every value is
	 * set to FALSE, the tool form can simply check to see if the value is FALSE or not and then set the existing value
	 *
	 * @return array
	 */
	protected function contentData()
	{
		$data = array(
			'name' => FALSE,
			'title' => FALSE,
			'intro' => FALSE,
			'button_label' => FALSE
		);

		if($this->tool['content_id'] !== FALSE)
		{
			$model_jumbotron = new Dlayer_DesignerTool_ContentManager_Jumbotron_Model();
			$existing_data = $model_jumbotron->existingData($this->tool['site_id'], $this->tool['content_id']);

			if($existing_data !== FALSE)
			{
				$title = FALSE;
				$intro = FALSE;
				$content_bits = explode(Dlayer_Config::CONTENT_DELIMITER, $existing_data['content']);
				switch(count($content_bits))
				{
					case 2:
						$title = $content_bits[0];
						$intro = $content_bits[1];
					break;

					case 1:
						$title = $content_bits[0];
					break;
				}

				$data['name'] = $existing_data['name'];
				$data['title'] = $title;
				$data['intro'] = $intro;
				$data['button_label'] = $existing_data['button_label'];
			}
		}

		return $data;
	}

	/**
	 * Fetch the number of instances for the content items data
	 *
	 * @return integer
	 */
	protected function instancesOfData()
	{
		$instances = 0;

		if($this->tool['content_id'] !== NULL)
		{
			$model_jumbotron = new Dlayer_DesignerTool_ContentManager_Jumbotron_Model();
			$instances = $model_jumbotron->instancesOfData($this->tool['site_id'], $this->tool['content_id']);
		}

		return $instances;
	}

    /**
     * Fetch the data required by the preview functions
     *
     * @return array
     */
    protected function previewData()
    {
        $data = $this->contentData();

        $this->preview_data = array(
            'title' => $data['title'],
            'intro' => $data['intro']
        );

        return $this->preview_data;
    }
}
