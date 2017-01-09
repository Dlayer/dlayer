<?php

/**
 * Text content item ribbon data class
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Text_Ribbon extends Dlayer_Ribbon_Content
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

		return array(
			'form' => new Dlayer_DesignerTool_ContentManager_Text_Form($tool, $this->contentData(),
				$this->instancesOfData(), array()),
            'preview' => $this->previewData()
		);
	}

	/**
	 * Fetch the existing data for the content item, always returns  a data array, if not in edit mode the values will
	 * all be FALSE
	 *
	 * @return array
	 */
	protected function contentData()
	{
		$data = array(
			'name' => FALSE,
			'content' => FALSE
		);

		if($this->tool['content_id'] !== NULL)
		{
			$model_text = new Dlayer_DesignerTool_ContentManager_Text_Model();
			$existing_data = $model_text->existingData($this->tool['site_id'], $this->tool['content_id']);
			if($existing_data !== FALSE)
			{
				$data['name'] = $existing_data['name'];
				$data['content'] = $existing_data['content'];
			}
		}

		return $data;
	}

	/**
	 * Fetch the number of instances for the content item data
	 *
	 * @return integer
	 */
	protected function instancesOfData()
	{
		$instances = 0;

		if($this->tool['content_id'] !== NULL)
		{
			$model_text = new Dlayer_DesignerTool_ContentManager_Text_Model();
			$instances = $model_text->instancesOfData($this->tool['site_id'], $this->tool['content_id']);
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
            'text' => $data['content']
        );

        return $this->preview_data;
    }
}
