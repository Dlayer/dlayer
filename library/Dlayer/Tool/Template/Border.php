<?php
/**
* Set or reset the borders for the selected div
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Border.php 1861 2014-05-27 11:30:18Z Dean.Blackborough $
*/
class Dlayer_Tool_Template_Border extends Dlayer_Tool_Module_Template
{
    private $model_div;
    private $model_border;

    /**
    * Sets the border for the requested div, position, style, width and
    * colour. When a border is added, deleted or updated the size of the div
    * may also need to change.
    *
    * The no border option removes the requested border and alters the size of
    * the div back to what it would have been before the border.
    *
    * Borders widths are always taken from the height and width of the div,
    * we have no way of knowing which surrounding divs to alter should it be
    * added to the div
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id
    */
    public function process($site_id, $template_id, $id)
    {
        if($this->validated == TRUE) {

            $this->model_div = new Dlayer_Model_Template_Div();
            $this->model_border = new Dlayer_Model_Template_Div_Border();

            $existing_border = $this->model_border->existingBorder($site_id,
            $template_id, $id, $this->params['position']);

            if($this->params['style'] != 'none') {
                if($existing_border == FALSE) {
                    $this->addBorderAndResizeDiv($site_id, $template_id, $id);
                } else {
                    if($existing_border == intval($this->params['width'])) {
                        $this->model_border->updateBorderStyleAndColor(
                        $site_id, $template_id, $id, $this->params['position'],
                        $this->params['style'], $this->params['color_hex']);
                        
                        $this->addToColorHistory($site_id, 
                        $this->params['color_hex']);
                    } else {
                        $this->updateBorderAndResizeDiv($site_id, $template_id,
                        $id, $existing_border);
                    }
                }
            } else {
                if($existing_border != FALSE) {
                    $this->deleteBorderAndResizeDiv($site_id, $template_id,
                    $id, $existing_border);
                }
            }
        }
    }

    /**
    * Delete the currently set border and update the size for the div
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Id of the selected div
    * @param integer $existing_border Existing border width
    * @return void
    */
    private function deleteBorderAndResizeDiv($site_id, $template_id, $id,
    $existing_border)
    {
        if(in_array($this->params['position'], array('top', 'bottom')) == TRUE) {
            $height = $this->model_div->height($site_id, $id);
            $this->model_div->setHeight($site_id, $id,
            intval($height['height'] + $existing_border), $height['fixed']);
        } else {
            $width = $this->model_div->width($site_id, $id);
            $new_width = intval($width + $existing_border);

            // If a left or right border is being removed we need to check
            // to see if content containers need their widths modified
            /*if($this->needToModifyContent($id, $site_id,
            $template_id) == TRUE) {
                $modifier = new Dlayer_Modifier_Content($site_id, $template_id,
                $id);
                $modifier->request(Dlayer_Modifier_Content::CONTAINER_WIDTH,
                array('new_width'=>$new_width, 'old_width'=>$width));
            }

            $this->model_div->setWidth($site_id, $id, $new_width);*/
        }

        $this->model_border->deleteBorder($site_id, $template_id, $id,
        $this->params['position']);
    }

    /**
    * Update the current border and update the size for the div to take into
    * account the different border width
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Id of the selected div
    * @param integer $existing_border Existing border width
    * @return void
    */
    private function updateBorderAndResizeDiv($site_id, $template_id, $id,
    $existing_border)
    {
        if(in_array($this->params['position'], array('top', 'bottom')) == TRUE) {
            $height = $this->model_div->height($site_id, $id);

            $new_height = ($height['height'] + $existing_border) -
            intval($this->params['width']);

            $this->model_div->setHeight($site_id, $id, $new_height,
            $height['fixed']);
        } else {
            $width = $this->model_div->width($site_id, $id);

            $new_width = ($width + $existing_border) -
            intval($this->params['width']);

            // Border width is being modified, may need to modify content
            // containers, depends on their current size in relation to the
            // page div id
            /*if($this->needToModifyContent($id, $site_id,
            $template_id) == TRUE) {
                $modifier = new Dlayer_Modifier_Content($site_id, $template_id,
                $id);
                $modifier->request(Dlayer_Modifier_Content::CONTAINER_WIDTH,
                array('new_width'=>$new_width,
                'old_width'=>$width));
            }*/

            $this->model_div->setWidth($site_id, $id, $new_width);
        }

        $this->model_border->updateBorder($site_id, $template_id, $id,
        $this->params['position'], $this->params['style'],
        $this->params['width'], $this->params['color_hex']);
        
        $this->addToColorHistory($site_id, $this->params['color_hex']);
    }

    /**
    * Update the assigned borders for the div. Currently assigned borders are
    * deleted and then the new borders are applied.
    *
    * Before deleting and applying the new borders the div is checked to ensure
    * that the new can be defined for the div without making it collpase.
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Id of the selected div
    * @param integer $existing_borders Currently assigned borders.
    * @return void
    */
    private function updateBordersAndResizeDiv($site_id, $template_id, $id,
    $existing_borders)
    {
        $current_width = $this->model_div->width($site_id, $id);
        $current_height = $this->model_div->height($site_id, $id);

        $no_border_width = $current_width;
        $no_border_height = $current_height;

        foreach($existing_borders as $position=>$width) {
            if(in_array($position, array('top', 'bottom')) == TRUE) {
                $no_border_height['height'] += $width;
            } else {
                $no_border_width += $width;
            }
        }

        $double_borders = intval($this->params_auto['width'] * 2);

        if(($double_borders < $no_border_height['height']) &&
        ($double_borders < $no_border_width)) {
            $this->deleteBordersAndResizeDiv($site_id, $template_id, $id,
            $existing_borders);

            $this->addBordersAndResizeDiv($site_id, $template_id, $id);
        }
    }

    /**
    * Add border to the requested div and update the size to take the border
    * into account, before adding the border we check to see if the width of
    * the border is greater than the size of the div
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Id of the selected div
    * @return void
    */
    private function addBorderAndResizeDiv($site_id, $template_id, $id)
    {
        if(in_array($this->params['position'], array('top', 'bottom')) == TRUE) {
            $new_height = $this->newHeight($site_id, $id,
            $this->params['width']);

            if($new_height != FALSE) {
                $this->model_div->setHeight($site_id, $id,
                $new_height['height'], $new_height['fixed']);
            }
        } else {
            $new_width = $this->newWidth($site_id, $id, $this->params['width']);

            if($new_width != FALSE) {

                // If a left or right border is being added we need to check
                // to see if content containers need their widths modified
                /*if($this->needToModifyContent($id, $site_id,
                $template_id) == TRUE) {
                    $modifier = new Dlayer_Modifier_Content($site_id,
                    $template_id, $id);
                    $modifier->request(
                    Dlayer_Modifier_Content::CONTAINER_WIDTH,
                    array('new_width'=>$new_width,
                    'old_width'=>$new_width + $this->params['width']));
                }*/

                // Set the new width for the template div
                $this->model_div->setWidth($site_id, $id, $new_width);
            }
        }

        $this->model_border->addBorder($site_id, $template_id, $id,
        $this->params['position'], $this->params['style'],
        $this->params['width'], $this->params['color_hex']);
        
        $this->addToColorHistory($site_id, $this->params['color_hex']);
    }

    /**
    * Check to see if the supplied border is larger than the set height of the
    * div, border is taken away from height, can't be equal to or larger
    * than height.
    *
    * @param integer $site_id
    * @param integer $id
    * @param integer $border_width Border width
    * @return array|FALSE Array contains the new height for the div and whether
    * or not the div is a fixed height div
    */
    private function newHeight($site_id, $id, $border_width)
    {
        $height = $this->model_div->height($site_id, $id);

        if($border_width < $height['height']) {
            return array('height'=>intval($height['height']-$border_width),
                         'fixed'=>$height['fixed']);
        } else {
            return FALSE;
        }
    }

    /**
    * Check to see if the supplied border is larger than the set width of the
    * div, border is taken away from width so can't be equal to or larger
    * than width.
    *
    * @param integer $site_id
    * @param integer $id
    * @param integer $border_width Border width
    * @return integer|FALSE Either the new width or FALSE if check failed
    */
    private function newWidth($site_id, $id, $border_width)
    {
        $width = $this->model_div->width($site_id, $id);

        if($border_width < $width) {
            return intval($width - $border_width);
        } else {
            return FALSE;
        }
    }

    /**
    * Check to see if all the required params have been supplied, we need the
    * position for the border, the style, the width and the color.
    *
    * @param array $params Params post array
    * @return boolean
    */
    public function validate(array $params = array())
    {
        if(array_key_exists('position', $params) == TRUE &&
        array_key_exists('style', $params) == TRUE &&
        array_key_exists('width', $params) == TRUE &&
        array_key_exists('color_hex', $params) == TRUE &&
        Dlayer_Validate::borderPosition($params['position']) == TRUE &&
        Dlayer_Validate::borderStyle($params['style']) == TRUE) {
            if($params['style'] != 'none') {
                if(intval($params['width']) > 0 &&
                Dlayer_Validate::colorHex($params['color_hex']) == TRUE) {
                    $this->params = $params;
                    $this->validated = TRUE;
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                $this->params = $params;
                $this->validated = TRUE;
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    /**
    * Check to see if all the required params have been supplied, the position
    * and widths should be defined, user defines the colour and the style.
    *
    * @param array $params Params post array
    * @return boolean
    */
    public function autoValidate(array $params = array())
    {
        if(array_key_exists('position', $params) == TRUE &&
        $params['position'] = 'full' &&
        array_key_exists('style', $params) == TRUE &&
        array_key_exists('width', $params) == TRUE &&
        array_key_exists('color_hex', $params) == TRUE) {
            if($params['style'] != 'none') {
                if(Dlayer_Validate::borderStyle($params['style']) == TRUE &&
                intval($params['width']) > 0 &&
                Dlayer_Validate::colorHex($params['color_hex']) == TRUE) {
                    $this->params_auto = $params;
                    $this->validated_auto = TRUE;
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                $this->params_auto = $params;
                $this->validated_auto = TRUE;
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    /**
    * Auto process method for borders, takes the pre defined full borders and
    * assigns then to the selected div.
    *
    * What happens depends on the current status of the div, if clear, the
    * borders get added assuming they won't collpase the div.  defined options
    * and applies them.
    *
    * If the div already has borders we check the size if they don't exists
    * and if size is valid we remove the assigned borders and replace with the
    * requested.
    *
    * Clear removes all assigned borders.
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id
    */
    public function autoProcess($site_id, $template_id, $id)
    {
        if($this->validated_auto == TRUE) {

            $this->model_div = new Dlayer_Model_Template_Div();
            $this->model_border = new Dlayer_Model_Template_Div_Border();

            $existing_borders = $this->model_border->existingBorders($site_id,
            $template_id, $id);

            if($this->params_auto['style'] != 'none') {
                if($existing_borders == FALSE) {
                    $this->addBordersAndResizeDiv($site_id, $template_id,
                    $id);
                } else {
                    $this->updateBordersAndResizeDiv($site_id, $template_id,
                    $id, $existing_borders);
                }
            } else {
                if($existing_borders != FALSE) {
                    $this->deleteBordersAndResizeDiv($site_id, $template_id, $id,
                    $existing_borders);
                }
            }
        }
    }

    /**
    * Delete any currently set borders updating the size of the div as the
    * border are deleted
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Id of the selected div
    * @param integer $existing_borders Currently assigned borders
    * @return void
    */
    private function deleteBordersAndResizeDiv($site_id, $template_id, $id,
    $existing_borders)
    {
        foreach($existing_borders as $position=>$border_width) {
            if(in_array($position, array('top', 'bottom')) == TRUE) {
                $height = $this->model_div->height($site_id, $id);
                $this->model_div->setHeight($site_id, $id,
                intval($height['height'] + $border_width), $height['fixed']);
            } else {
                $width = $this->model_div->width($site_id, $id);

                $new_width = intval($width + $border_width);

                /*if($this->needToModifyContent($id, $site_id,
                $template_id) == TRUE) {
                    $modifier = new Dlayer_Modifier_Content($site_id,
                    $template_id, $id);
                    $modifier->request(Dlayer_Modifier_Content::CONTAINER_WIDTH,
                    array('new_width'=>$new_width, 'old_width'=>$width));
                }*/

                $this->model_div->setWidth($site_id, $id,
                intval($width + $border_width));
            }

            $this->model_border->deleteBorder($site_id, $template_id, $id,
            $position);
        }
    }

    /**
    * Add the full border to the requested div and update the size of the div
    * to take account of the border.
    *
    * Before adding the border a check is done to see if the div can support
    * the border widths, height and width of div need to be greater than
    * the borders.
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $id Id of the selected div
    * @return void
    */
    private function addBordersAndResizeDiv($site_id, $template_id, $id)
    {
        $new_height = $this->newHeight($site_id, $id,
        ($this->params_auto['width'] * 2));
        $new_width = $this->newWidth($site_id, $id,
        ($this->params_auto['width'] * 2));

        if($new_height != FALSE && $new_width != FALSE) {

            $modifier = new Dlayer_Modifier_Content($site_id, $template_id,
            $id);
            $modifier->request(Dlayer_Modifier_Content::CONTAINER_WIDTH,
            array('new_width'=>$new_width,
            'old_width'=>$new_width + ($this->params_auto['width'] * 2)));

            $this->model_div->setHeight($site_id, $id, $new_height['height'],
            $new_height['fixed']);

            $this->model_div->setWidth($site_id, $id, $new_width);

            $positions = array('top', 'right', 'bottom', 'left');

            foreach($positions as $position) {
                $this->model_border->addBorder($site_id, $template_id, $id,
                $position, $this->params_auto['style'],
                $this->params_auto['width'], $this->params_auto['color_hex']);
            }
        }
    }
}