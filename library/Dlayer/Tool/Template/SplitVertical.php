<?php
/**
* Split the block into 2-5 sections, either manually or using a quick tool
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Tool_Template_SplitVertical extends Dlayer_Tool_Module_Template
{
    /**
    * Splits the selected block in two, takes the given sizes and passes them
    * to the div model which adds them to the database
    *
    * @param integer $site_id Site id
    * @param integer $template_id Template id
    * @param integer $id Template div id
    * @return void
    */
    public function process($site_id, $template_id, $id)
    {
        $model_div = new Dlayer_Model_Template_Div();

        if($this->validated == TRUE) {
            $id_1 = $model_div->add($site_id, $template_id, $id, 1);
            $model_div->setSizes($site_id, $template_id, $id_1,
            $this->params['x_1'], 0, $this->params['y']);

            $id_2 = $model_div->add($site_id, $template_id, $id, 2);
            $model_div->setSizes($site_id, $template_id, $id_2,
            $this->params['x_2'], 0, $this->params['y']);

            $model_div->clearHeight($site_id, $id);
        }
    }

    /**
    * Check to see if we have been given a height and two widths, assuming all
    * values exists and are above zero the request is valid
    *
    * @param array $params Params post array
    * @return boolean
    */
    public function validate(array $params = array())
    {
        if(array_key_exists('x_1', $params) == TRUE
        && array_key_exists('x_2', $params) == TRUE
        && array_key_exists('y', $params) == TRUE) {
            if(intval($params['x_1']) > 0 && intval($params['x_2']) > 0
            && intval($params['y']) > 0) {
                $this->validated = TRUE;
                $this->params = $params;
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
    * Checks to see if the request contains the sections param with the value
    * being between 2 and 5, these arte the only supported quick modes at the
    * moment
    *
    * @param array $params Params post array
    * @return boolean
    */
    public function autoValidate(array $params = array())
    {
        if(array_key_exists('sections', $params) == TRUE &&
        in_array($params['sections'], array(2,3,4,5)) == TRUE) {
            $this->params_auto = $params;
            $this->validated_auto = TRUE;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Attempts to split the block in the the required number of sections, if
    * equal sections are not possible the extra pixels are added to the first
    * section. Once the sizes are calculated the requests are sent to the div
    * models to enter the new divs and sizes
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Template div id
    * @return void
    */
    public function autoProcess($site_id, $template_id, $id)
    {
        if($this->validated_auto == TRUE) {
            $model_div = new Dlayer_Model_Template_Div();

            $height = $model_div->height($site_id, $id);
            $width = $model_div->width($site_id, $id);

            if($width % $this->params_auto['sections'] == 0) {
                for($i=1; $i <= $this->params_auto['sections']; $i++) {
                    $div_id = $model_div->add($site_id, $template_id, $id,
                    $i);
                    $model_div->setSizes($site_id, $template_id, $div_id,
                    intval($width / $this->params_auto['sections']),
                    0, $height['height']);
                }
            } else {
                // Remove remainder, split into equal sections adding the
                // remainder to the first div
                $remaider = $width % $this->params_auto['sections'];

                for($i=0; $i < $this->params_auto['sections']; $i++) {
                    $sort_order = $i+1;
                    $div_id = $model_div->add($site_id, $template_id, $id,
                    $sort_order);

                    $div_width = intval(($width - $remaider) / $this->params_auto['sections']);
                    if($sort_order == 1) {
                        $div_width += $remaider;
                    }

                    $model_div->setSizes($site_id, $template_id, $div_id,
                    $div_width, 0, $height['height']);
                }
            }

            $model_div->clearHeight($site_id, $id);
        }
    }
}