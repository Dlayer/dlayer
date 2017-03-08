<?php

/**
 * Horizontal rule model
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_HorizontalRule_Model extends
    Dlayer_DesignerTool_ContentManager_Shared_Model_Content
{
    /**
     * Edit the content item
     *
     * @param integer $site_id
     * @param integer $page_id
     * @param integer $content_id
     * @param array $params The params data array from the tool
     *
     * @return true
     * @throws Exception
     */
    public function edit($site_id, $page_id, $content_id, array $params)
    {
        return false;
    }
}
