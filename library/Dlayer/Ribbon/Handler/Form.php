<?php

/**
 * Handler class for the Form Builder tools, simply passes the request off to the specific ribbon class for the tool
 *
 * The handlers are similar for each of the designers, the difference being the designer environment variables that are
 * passed in
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Ribbon_Handler_Form
{
    /**
     * @var integer $site_id Id of the selected site
     */
    private $site_id;

    /**
     * @var integer $form_id Id of the selected form
     */
    private $form_id;

    /**
     * @var integer $multi_use Is the tool a multi use tool?
     */
    private $multi_use;

    /**
     * @var boolean $edit_mode Is the tool in what would be considered edit mode
     */
    private $edit_mode;

    /**
     * @var integer|NULL Id of the selected field, if any
     */
    private $field_id;

    /**
     * Constructor for class, set required data
     *
     * @param integer $site_id
     * @param integer $form_id
     * @param string $tool
     * @param string $tab
     * @param integer $multi_use
     * @param boolean $edit_mode
     * @param integer|null $field_id
     *
     * @return array|FALSE Returns an array of the data necessary to create the tool tab for the tool or false if
     * there is no data or something went wrong
     */
    public function viewData(
        $site_id,
        $form_id,
        $tool,
        $tab,
        $multi_use,
        $edit_mode = false,
        $field_id = null
    ) {
        $this->site_id = $site_id;
        $this->form_id = $form_id;
        $this->multi_use = $multi_use;
        $this->edit_mode = $edit_mode;
        $this->field_id = $field_id;

        switch ($tool) {
            case 'Text':
                $data = $this->text($tool, $tab);
                break;

            case 'Textarea':
                $data = $this->textarea($tool, $tab);
                break;

            case 'Email':
                $data = $this->email($tool, $tab);
                break;

            case 'Password':
                $data = $this->password($tool, $tab);
                break;

            case 'InlineLayout':
                $data = $this->inlineLayout($tool, $tab);
                break;

            case 'StackedLayout':
                $data = $this->stackedLayout($tool, $tab);
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Base tool params, uses by every tool, accessible via $data['tool'] in the view
     *
     * @param string $tool
     *
     * @return array
     */
    private function toolParams($tool)
    {
        return array(
            'site_id' => $this->site_id,
            'name' => $tool,
            'form_id' => $this->form_id,
            'field_id' => $this->field_id,
            'multi_use' => $this->multi_use,
        );
    }

    /**
     * Fetch the view tab data for the Text element tool, returns an array containing the form and any additional
     * data required for the view
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|false
     */
    private function text($tool, $tab)
    {
        switch ($tab) {
            case 'text':
                $ribbon_text = new Dlayer_DesignerTool_FormBuilder_Text_Ribbon();
                $data = $ribbon_text->viewData($this->toolParams($tool));
                break;

            case 'styling':
                $ribbon_text = new Dlayer_DesignerTool_FormBuilder_Text_SubTool_Styling_Ribbon();
                $data = $ribbon_text->viewData($this->toolParams($tool));
                break;

            case 'delete':
                $ribbon_text = new Dlayer_DesignerTool_FormBuilder_Text_SubTool_Delete_Ribbon();
                $data = $ribbon_text->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the Textarea element tool, returns an array containing the form and any additional
     * data required for the view
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|false
     */
    private function textarea($tool, $tab)
    {
        switch ($tab) {
            case 'textarea':
                $ribbon_textarea = new Dlayer_DesignerTool_FormBuilder_Textarea_Ribbon();
                $data = $ribbon_textarea->viewData($this->toolParams($tool));
                break;

            case 'styling':
                $ribbon_textarea = new Dlayer_DesignerTool_FormBuilder_Textarea_SubTool_Styling_Ribbon();
                $data = $ribbon_textarea->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the Email element tool, returns an array containing the form and any additional
     * data required for the view
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|false
     */
    private function email($tool, $tab)
    {
        switch ($tab) {
            case 'email':
                $ribbon_email = new Dlayer_DesignerTool_FormBuilder_Email_Ribbon();
                $data = $ribbon_email->viewData($this->toolParams($tool));
                break;

            case 'styling':
                $ribbon_email = new Dlayer_DesignerTool_FormBuilder_Email_SubTool_Styling_Ribbon();
                $data = $ribbon_email->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the Password element tool, returns an array containing the form and any additional
     * data required for the view
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|false
     */
    private function password($tool, $tab)
    {
        switch ($tab) {
            case 'password':
                $ribbon_password = new Dlayer_DesignerTool_FormBuilder_Password_Ribbon();
                $data = $ribbon_password->viewData($this->toolParams($tool));
                break;

            case 'styling':
                $ribbon_password = new Dlayer_DesignerTool_FormBuilder_Password_SubTool_Styling_Ribbon();
                $data = $ribbon_password->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the Inline layout tool, returns an array containing the form and
     * any additional data required for the view
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|false
     */
    private function inlineLayout($tool, $tab)
    {
        switch ($tab) {
            case 'inline-layout':
                $ribbon_layout = new Dlayer_DesignerTool_FormBuilder_InlineLayout_Ribbon();
                $data = $ribbon_layout->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }

    /**
     * Fetch the view tab data for the stacked layout tool, returns an array containing the form and
     * any additional data required for the view
     *
     * @param string $tool The tool name
     * @param string $tab The tool tab name
     *
     * @return array|false
     */
    private function stackedLayout($tool, $tab)
    {
        switch ($tab) {
            case 'stacked-layout':
                $ribbon_layout = new Dlayer_DesignerTool_FormBuilder_StackedLayout_Ribbon();
                $data = $ribbon_layout->viewData($this->toolParams($tool));
                break;

            default:
                $data = false;
                break;
        }

        return $data;
    }
}
