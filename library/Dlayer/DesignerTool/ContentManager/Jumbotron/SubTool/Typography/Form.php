<?php

/**
 * Typography sub tools for the Jumbotron content item
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Jumbotron_SubTool_Typography_Form extends
    Dlayer_DesignerTool_ContentManager_Shared_Form_Typography
{
    /**
     * Set the properties for the form
     *
     * @param array $tool Tool and environment data array
     * @param array $data Current data for content item
     * @param integer $instances Instances of content data on web site
     * @param array $element_data
     * @param array|NULL $options Zend form options
     */
    public function __construct(array $tool, array $data, $instances, array $element_data, $options = null)
    {
        $this->content_type = 'Jumbotron';
        $this->sub_tool_model = 'Typography';

        parent::__construct($tool, $data, $instances, $element_data, $options);
    }
}
