<?php

/**
 * Typography sub tool
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_DesignerTool_ContentManager_Html_SubTool_Typography_Tool extends
    Dlayer_DesignerTool_ContentManager_Shared_Tool_Typography
{
    /**
     * Generate the return ids array
     *
     * @return array
     */
    protected function returnIds()
    {
        return array(
            array(
                'type' => 'page_id',
                'id' => $this->page_id,
            ),
            array(
                'type' => 'row_id',
                'id' => $this->row_id,
            ),
            array(
                'type' => 'column_id',
                'id' => $this->column_id,
            ),
            array(
                'type' => 'tool',
                'id' => 'Html',
            ),
            array(
                'type' => 'tab',
                'id' => 'typography',
                'sub_tool' => 'Typography'
            ),
            array(
                'type' => 'content_id',
                'id' => $this->content_id,
                'content_type' => 'Html'
            )
        );
    }
}
