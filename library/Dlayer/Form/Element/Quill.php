<?php

/**
 * Quill rich text field and hidden input for html
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Form_Element_Quill extends Zend_Form_Element_Textarea
{
    /**
     * Default form view helper to use for rendering
     * @var string
     */
    public $helper = 'formElementQuill';
}
