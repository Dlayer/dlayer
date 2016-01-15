<?php
/**
* Resize the selected block by moving the edges either in or out, there is also
* a nufge and pull mode for the height which allows the blocks to be made
* larger without taking height from the surrounding blocks.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Tool_Template_Resize extends Dlayer_Tool_Module_Template
{
    private $model_div;
    private $model_template;

    /**
    * Alters the selected block by the requested nudge value, divs around the
    * block alter in size to compensate for the new size
    *
    * @param integer $site_id Site id
    * @param integer $template_id Template id
    * @param integer $id Template div id
    * @return void
    */
    public function process($site_id, $template_id, $id)
    {

    }

    /**
    * Check to see if we have been given the correct values and if they are
    * of the right format, if all valuesd are valid the values are passed to
    * the param array
    *
    * @param array $params Params post array
    * @return boolean
    */
    public function validate(array $params = array())
    {
        $this->validated = TRUE;
        $this->params = $params;
        return TRUE;
    }

    /**
    * Check to see if we have been given the correct values and if they are
    * of the right format, if all values are valid the values are passed to
    * the param array and the validated param is set to TRUE
    *
    * @param array $params Params post array
    * @return boolean
    */
    public function autoValidate(array $params = array())
    {
        if(array_key_exists('decrease', $params) == TRUE &&
        array_key_exists('increase', $params) == TRUE &&
        array_key_exists('dimension', $params) == TRUE &&
        array_key_exists('value', $params) == TRUE &&
        array_key_exists('combine', $params) == TRUE &&
        in_array($params['dimension'], array('height','width')) == TRUE &&
        in_array($params['combine'], array(1,0)) == TRUE &&
        in_array($params['mode'], array('larger','smaller')) == TRUE) {
            $this->params_auto = $params;
            $this->validated_auto = TRUE;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Get the div ids from the params array, always returns an array regardless
    * of whether the param string contains anything
    *
    * @param string $key Key to pull ids from
    * @return array
    */
    private function idsFromParamString($key)
    {
        if(strlen($this->params_auto[$key]) > 0) {
            return explode(':', $this->params_auto[$key]);
        } else {
            return array();
        }
    }

    /**
    * Check to see if any of the given divs will end up collapsing if they are
    * reduced by the given height
    *
    * @param array $divs
    * @return boolean
    */
    private function collapsableHeight($divs)
    {
        $check = array();

        foreach($divs as $id=>$height) {
            if($height['height'] <= $this->params_auto['value']) {
                $check[] = TRUE;
            }
        }

        if(count($check) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
    * Check to see if any of the given divs will end up collapsing if they are
    * reduced by the given width
    *
    * @param array $divs
    * @return boolean
    */
    private function collapsableWidth($divs)
    {
        $check = array();

        foreach($divs as $id=>$width) {
            if($width <= $this->params_auto['value']) {
                $check[] = TRUE;
            }
        }

        if(count($check) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
    * Alter the heights for the given divs
    *
    * @param integer $site_id
    * @param integer $value Increase/descrease amount
    * @param array $increase_divs Array of divs that need to increase in height
    * @param array $decrease_divs Array of divs that need to decrease in height
    * @return void
    */
    private function setHeights($site_id, $value, array $increase_divs,
    array $decrease_divs)
    {
        foreach($increase_divs as $div_id => $height) {
            $this->model_div->setHeight($site_id, $div_id,
            ($height['height'] + $value),
            $height['fixed']);
        }

        foreach($decrease_divs as $div_id => $height) {
            $this->model_div->setHeight($site_id, $div_id,
            ($height['height'] - $value),
            $height['fixed']);
        }
    }

    /**
    * Alter the widths for the given divs
    *
    * @param integer $site_id
    * @param integer $value Increase/descrease amount
    * @param array $increase_divs Array of divs that need to increase in width
    * @param array $decrease_divs Array of divs that need to decrease in width
    * @return void
    */
    private function setWidths($site_id, $value, array $increase_divs,
    array $decrease_divs)
    {
        foreach($increase_divs as $div_id => $width) {
            $this->model_div->setWidth($site_id, $div_id, ($width + $value));
        }

        foreach($decrease_divs as $div_id => $width) {
            $this->model_div->setWidth($site_id, $div_id, ($width - $value));
        }
    }

    /**
    * Resizes the selected block by the given nudge value, depending on the
    * mode the surrounding blocks may change in side if necessary. Changes
    * that could collapse the selected block or surrounding blocks are ignored.
    *
    * @todo Will need to work on some sort of notification for the user if
    *       a request cannot be processed for some reason
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Template div id
    * @return void
    */
    public function autoProcess($site_id, $template_id, $id)
    {
        if($this->validated_auto == TRUE) {

            $this->model_template = new Dlayer_Model_View_Template();
            $this->model_div = new Dlayer_Model_Template_Div();

            if($this->params_auto['dimension'] == 'height') {
                if($this->params_auto['combine'] == 1) {
                    $this->processCombineHeightChanges($site_id, $template_id,
                    $id);
                } else {
                    $this->processHeightChanges($site_id, $template_id, $id);
                }
            } else {
                $this->processCombineWidthChanges($site_id, $template_id, $id);
            }
        }
    }

    /**
    * Attempt to process the requested change in width updating the relevant
    * divs in the template as appropriate
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Template div id
    * @return void
    */
    private function processCombineWidthChanges($site_id, $template_id, $id)
    {
        $width_selected = $this->model_div->width($site_id, $id);

        // If the div is being reduced in size we need to ensure that it
        // doesn't get reduced to a negative or zero value
        $process = TRUE;

        if($this->params_auto['mode'] == 'smaller') {
            if($this->params_auto['value'] >= $width_selected) {
                $process = FALSE;
            } else {
                $new_width = $width_selected - $this->params_auto['value'];
            }
        } else {
            $new_width = $width_selected + $this->params_auto['value'];
        }

        if($process == TRUE) {
            $inc_div_ids = $this->idsFromParamString('increase');
            $dec_div_ids = $this->idsFromParamString('decrease');

            // Check to see if the ids supplied in the increase and
            // decrease params exists, we also pull back the widths of
            // the divs that are getting smaller so that we can check to
            // ensure none of them will collapse
            $increase_divs = $this->model_template->widths($inc_div_ids,
            $template_id, $site_id);
            $decrease_divs = $this->model_template->widths($dec_div_ids,
            $template_id, $site_id);

            if(is_array($increase_divs) && is_array($decrease_divs)
            && $this->collapsableWidth($decrease_divs) == FALSE) {
                $this->model_div->setWidth($site_id, $id, $new_width);

                $this->setWidths($site_id, $this->params_auto['value'],
                $increase_divs, $decrease_divs);
            }
        }
    }

    /**
    * Alter the height of the requested div and all its parents
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Template div id
    * @return void
    */
    private function processHeightChanges($site_id, $template_id, $id)
    {
        $height_selected = $this->model_div->height($site_id, $id);

        $parent_ids = $this->model_template->parents($id, $template_id, $site_id);

        $process = TRUE;

        if($this->params_auto['mode'] == 'smaller') {
            if($this->params_auto['value'] >= $height_selected['height']) {
                $process = FALSE;
            } else {
                $new_height = $height_selected['height'] -
                $this->params_auto['value'];
            }
        } else {
            $new_height = $height_selected['height'] +
            $this->params_auto['value'];
        }

        if($process == TRUE) {
            $divs = $this->model_template->heights($parent_ids, $template_id,
            $site_id);

            if($this->params_auto['mode'] == 'smaller') {
                if(is_array($divs) &&
                $this->collapsableHeight($divs) == FALSE) {
                    $this->model_div->setHeight($site_id, $id, $new_height,
                    $height_selected['fixed']);

                    $this->setHeights($site_id, $this->params_auto['value'],
                    array(), $divs);
                }
            } else {
                if(is_array($divs)) {
                    $this->model_div->setHeight($site_id, $id, $new_height,
                    $height_selected['fixed']);

                    $this->setHeights($site_id, $this->params_auto['value'],
                    $divs, array());
                }
            }
        }
    }

    /**
    * Attempt to process the requested change in height updating the relevant
    * divs in the template as appropriate
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Template div id
    * @return void
    */
    private function processCombineHeightChanges($site_id, $template_id, $id)
    {
        $height_selected = $this->model_div->height($site_id, $id);

        // If the div is being reduced in size we need to ensure that it
        // doesn't get reduced to a negative or zero value
        $process = TRUE;

        if($this->params_auto['mode'] == 'smaller') {
            if($this->params_auto['value'] >= $height_selected['height']) {
                $process = FALSE;
            } else {
                $new_height = $height_selected['height'] -
                $this->params_auto['value'];
            }
        } else {
            $new_height = $height_selected['height'] +
            $this->params_auto['value'];
        }

        if($process == TRUE) {
            $inc_div_ids = $this->idsFromParamString('increase');
            $dec_div_ids = $this->idsFromParamString('decrease');

            // Check to see if the ids supplied in the increase and
            // decrease params exists, we also pull back the heights of
            // the divs that are getting smaller so that we can check to
            // ensure none of them will collapse
            $increase_divs = $this->model_template->heights($inc_div_ids,
            $template_id, $site_id);
            $decrease_divs = $this->model_template->heights($dec_div_ids,
            $template_id, $site_id);

            if(is_array($increase_divs) && is_array($decrease_divs)
            && $this->collapsableHeight($decrease_divs) == FALSE) {
                $this->model_div->setHeight($site_id, $id, $new_height,
                $height_selected['fixed']);

                $this->setHeights($site_id, $this->params_auto['value'],
                $increase_divs, $decrease_divs);
            }
        }
    }
}