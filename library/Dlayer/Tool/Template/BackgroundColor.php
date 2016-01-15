<?php
/**
* Set or reset the background color for the selected block
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Tool_Template_BackgroundColor extends Dlayer_Tool_Module_Template
{
    private $model_background_color;


    /**
    * Check to see if the requested color is none or a hex value. If a hex
    * value call the clear method otherwise insert the color into the
    * database
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id
    */
    public function process($site_id, $template_id, $id)
    {
        var_dump($this->params);
        die();
    }

    /**
    * Check that we have been given a backgound color value, hex value or
    * none. None is for when we need to reset the background color.
    *
    * @param array $params Params post array
    * @return boolean
    */
    public function validate(array $params = array())
    {
        if($this->validateColor($params) == TRUE) {
            $this->params = $params;
            $this->validated = TRUE;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Check that we have been given a backgound color value, hex value or
    * none. None is for when we need to reset the background color.
    *
    * @param array $params Params post array
    * @return boolean
    */
    public function autoValidate(array $params = array())
    {
        if($this->validateColor($params) == TRUE) {
            $this->params_auto = $params;
            $this->validated_auto = TRUE;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Check to see if the requested color is none or a hex value. If a hex
    * value call the clear method otherwise insert the color into the
    * database.
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id
    */
    public function autoProcess($site_id, $template_id, $id)
    {
        if($this->validated_auto == TRUE) {

            $this->model_background_color =
            new Dlayer_Model_Template_Div_BackgroundColor();

            $this->addBackgroundColor($site_id, $template_id, $id,
            $this->params_auto['color_hex']);
        }
    }

    /**
    * Validate the provided array to see if the requested color is valid,
    * in this case the auto tool and manual tool need to use the same
    * validation method. Check the value is either none, 7 charcters long and
    * starts with a hash
    *
    * @param array $params
    * @return boolean
    */
    private function validateColor(array $params = array())
    {
        if(array_key_exists('color_hex', $params) == TRUE &&
        (strlen($params['color_hex']) == 7 ||
        $params['color_hex'] == 'none')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Insert the background color into the database, method checks to see if a
    * row already exists and if so updates the current color
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Template div id
    * @param string $color_hex
    * @return void
    */
    private function addBackgroundColor($site_id, $template_id, $id, $color_hex)
    {
        $exists = $this->model_background_color->checkForBackgroundColor(
        $site_id, $template_id, $id);

        if($exists == TRUE) {
            if($color_hex != 'none') {
                $this->model_background_color->updateBackgroundColor($site_id,
                $template_id, $id, $color_hex);
                
                $this->addToColorHistory($site_id, $color_hex);
            } else {
                $this->model_background_color->deleteBackgroundColor($site_id,
                $template_id, $id);
            }
        } else {
            if($color_hex != 'none') {
                $this->model_background_color->insertBackgroundColor($site_id,
                $template_id, $id, $color_hex);
                
                $this->addToColorHistory($site_id, $color_hex);
            }
        }
    }
}