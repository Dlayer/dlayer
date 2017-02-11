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

		$this->contentData();
		$this->previewData();
		$this->instancesOfData();

		return array(
			'form' => new Dlayer_DesignerTool_ContentManager_Text_Form(
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
                $model_text = new Dlayer_DesignerTool_ContentManager_Text_Model();
                $existing_data = $model_text->existingData($this->tool['site_id'], $this->tool['content_id']);
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
	    if ($this->instances_of_fetched === false) {

	        $this->instances_of = 0;

            if ($this->tool['content_id'] !== null) {
                $model = new Dlayer_DesignerTool_ContentManager_Text_Model();
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
