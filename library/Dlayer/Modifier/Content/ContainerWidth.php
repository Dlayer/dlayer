<?php
/**
* Content width modifier
*
* Called when the widths of one or more content containers needs to be updated
* because of a change in the template designer.
*
* The modifier is passed the new width for the page template div and the
* base width for the page template div in the params array, using these two
* values the modifier works out how, if at all each content container neeeds
* to modified
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ContainerWidth.php 1861 2014-05-27 11:30:18Z Dean.Blackborough $
*/
class Dlayer_Modifier_Content_ContainerWidth
{
    private $site_id;
    private $template_id;
    private $div_id;

    /**
    * If the params have been validated this property will be set to TRUE,
    * only when this is true will the processing code in the modify() method
    * run
    *
    * @var boolean
    */
    private $params_valid = FALSE;

    private $content_ids;
    private $modification_ids;
    private $params;

    /**
    * Constructor, set the site id, template id and id of the selected div
    *
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $div_id
    * @return void
    */
    public function __construct($site_id, $template_id, $div_id)
    {
        $this->site_id = $site_id;
        $this->template_id = $template_id;
        $this->div_id = $div_id;
    }

    /**
    * Check to see if the correct indexes exists in the params array, the
    * processing code inside the modify method will only run after this
    * method has been called and validated correctly
    *
    * The base width and new width need to exist in the array, old width is
    * the original width for the template div, new width is the new width
    * once the tool that called the modifier has run
    *
    * @param array $params
    * @return boolean
    */
    public function validateParams(array $params)
    {
        if(array_key_exists('new_width', $params) == TRUE &&
        array_key_exists('old_width', $params) == TRUE) {
            $this->params = $params;
            $this->params_valid = TRUE;
        }

        return $this->params_valid;
    }

    /**
    * Fetch the ids of the content that has been assigned to the selected
    * content block. A modification may not be required on each content block
    * but they all needs to be pulled to check
    *
    * @return void
    */
    private function contentIds()
    {
        $model_pages = new Dlayer_Model_Page();

        $this->content_ids = $model_pages->templateDivContent($this->div_id,
        $this->site_id, $this->template_id);
    }

    /**
    * Checks the content items to see which content blocks need to have their
    * widths altered after a change in one of the other designers.
    *
    * If a content container is the same width as the page container div it
    * will be reduced or increased by the modification width.
    *
    * If a content container is currently smaller than the page div but due to
    * the change will now be larger than the containing div its width will be
    * updated so as to ensure the previous spacing value. If the content item
    * is the same width as the page div it will be adjusted to fit the new
    * page div
    *
    * The content ids that require modification are written to the
    * modifications_ids array along with the new data
    *
    * @return void
    */
    private function checkContentIds()
    {
        $this->modification_ids = array();

        foreach($this->content_ids as $content) {
            switch($content['type']) {
                case 'heading':
                    $this->checkHeadingContent($content);
                break;

                case 'text':
                    $this->checkTextContent($content);
                break;
                
                case 'form':
                    $this->checkFormContent($content);
                break;

                default:
                    throw new Exception('Content type ' .
                    $content['type'] . ' not set in
                    Dlayer_Modifier_Content_ContainerWidth::checkContentIds');
                break;
            }
        }
    }

    /**
    * Check text content block to see if the container needs to be
    * modified, if a text content item needs to be modified the id and new
    * width value is written to the modification_ids array
    *
    * @param array $content Content data array
    * @return void
    */
    private function checkTextContent(array $content)
    {
    	$model_modifier_content_text = 
    	new Dlayer_Model_Modifiers_Content_Text();        
        $item_dimensions = $model_modifier_content_text->itemDimensions(
        $content['id'], $this->site_id);

        $new_container_width = $this->newWidthBasicContainer(
        $item_dimensions['full_width'], $item_dimensions['margins']['full'], 
        $this->params['old_width'], $this->params['new_width']);

        if($new_container_width != FALSE) {
            // Need to take current padding values away from the new container
            // width
            $this->modification_ids[] = array('id'=>$content['id'],
            'new_width'=>$new_container_width - $item_dimensions['padding'], 
            'margins'=>$item_dimensions['margins'], 'type'=>'text');
        }
    }
    
    /**
    * Check form content item to see if the container needs to be
    * modified, if a form content item needs to be modified the id and new
    * width value is written to the modification_ids array
    *
    * @param array $content Content data array
    * @return void
    */
    private function checkFormContent(array $content)
    {
    	$model_modifier_content_form = 
    	new Dlayer_Model_Modifiers_Content_Form();
    	$item_dimensions = $model_modifier_content_form->itemDimensions(
    	$content['id'], $this->site_id);
    	
        $new_container_width = $this->newWidthBasicContainer(
        $item_dimensions['full_width'], $item_dimensions['margins']['full'], 
        $this->params['old_width'], $this->params['new_width']);

        if($new_container_width != FALSE) {
            // Need to take current padding values away from the new container
            // width
            $this->modification_ids[] = array('id'=>$content['id'],
            'new_width'=>$new_container_width - $item_dimensions['padding'],
            'margins'=>$item_dimensions['margins'], 'type'=>'form');
        }
    }

    /**
    * Check heading content block to see if the container needs to be
    * modified, if a heading content item needs to be modified the id and new
    * width value is written to the modification_ids array
    *
    * @param array $content Content data array
    * @return void
    */
    private function checkHeadingContent(array $content)
    {
    	$model_modifier_content_heading = 
    	new Dlayer_Model_Modifiers_Content_Heading();
        $item_dimensions = $model_modifier_content_heading->itemDimensions(
        $content['id'], $this->site_id);

        $new_container_width = $this->newWidthBasicContainer(
        $item_dimensions['full_width'], $item_dimensions['margins']['full'], 
        $this->params['old_width'], $this->params['new_width']);

        if($new_container_width != FALSE) {
            // Need to take left padding value away from width to get the new 
            // width for the heading item
            $this->modification_ids[] = array('id'=>$content['id'],
            'new_width'=>$new_container_width - $item_dimensions['padding'],
            'margins'=>$item_dimensions['margins'], 'type'=>'heading');
        }
    }

    /**
    * Check to see if a basic container needs to have its width modified and
    * if so return the new width for the container
    * 
    * Combined margin value for containers is used in checks but the width 
    * returned is the new width for the content item, the modify methods can 
    * override the new width and reduce the margin values if that makes sense
    *
    * @param integer $content_item_width With of the content item being checked
    * @param integer $content_item_margin Full margin value (left and right) 
    * 									  for the content item container
    * @param integer $old_width Original width of template div before tool was
    *                           run
    * @param integer $new_width New width of template div after tool has run
    * @return integer|FALSE New container width or FALSE if no change is
    *                       necessary
    */
    private function newWidthBasicContainer($content_item_width, 
    $content_item_margin, $old_width, $new_width)
    {
        if($content_item_width + $content_item_margin == $old_width) {
            // Content container was the same size as the page div
            $new_container_width = $new_width - $content_item_margin;
        } else if(($content_item_width + $content_item_margin) >= $new_width) {
            // Content container will now be larger or the same size as the
            // page div
            $new_container_width = $content_item_width -
            ($old_width - $new_width) - $content_item_margin;
        } else if(($content_item_width + $content_item_margin) < $new_width && 
        ($content_item_width + $content_item_margin) >= 
        ($old_width - ($new_width - $old_width))) {
            // Content container is smaller than the page div by a value
            // between the change width and zero
            $new_container_width = $content_item_width +
            ($new_width - $old_width) - $content_item_margin;
        } else {
            // No change necessary
            $new_container_width = FALSE;
        }

        return $new_container_width;
    }

    /**
    * Modifiy the widths of all the requested content item container, passes 
    * eachs of the requests through to a method for the content item type
    *
    * @return void
    */
    public function modify()
    {
        if($this->params_valid == TRUE) {

            $this->contentIds();

            $this->checkContentIds();

            if(count($this->modification_ids) > 0) {
                foreach($this->modification_ids as $container) {

                    switch($container['type']) {
                        case 'text':
                        	$this->modifyTextContainer($container);
                        break;
                        
                        case 'heading':
                        	$this->modifyHeadingContainer($container);
                        break;
                        
                        case 'form':
                            $this->modifyFormContainer($container);
                        break;

                        default:
                            throw new Exception('Content type ' .
                            $content['type'] . ' not set in
                            Dlayer_Modifier_Content_ContainerWidth::modify');
                        break;
                    }
                }
            }
        }
    }
    
    /**
    * Modify the text content item container 
    * 
    * @todo The container array already includes the current continer margin 
    * values, need to pass the data to the model, the model can then decide if 
    * the margin should be adjusted rather than the width. Will also need to 
    * pass through the original width (or change value) so it can be used in 
    * the margin calculation
    * 
    * @param array $container Container data array, contains id and new width
    * @return void
    */
    private function modifyTextContainer(array $container) 
    {
    	$model_modifier_content_text = 
    	new Dlayer_Model_Modifiers_Content_Text();
    	$model_modifier_content_text->setWidth($container['id'], 
    	$container['new_width'], $this->site_id);
    }
    
    /**
    * Modify the heading content item container 
    * 
    * @todo The container array already includes the current continer margin 
    * values, need to pass the data to the model, the model can then decide if 
    * the margin should be adjusted rather than the width. Will also need to 
    * pass through the original width (or change value) so it can be used in 
    * the margin calculation
    * 
    * @param array $container Container data array, contains id and new width
    * @return void
    */
    private function modifyHeadingContainer(array $container) 
    {
    	$model_modifier_content_heading = 
    	new Dlayer_Model_Modifiers_Content_Heading();
    	$model_modifier_content_heading->setWidth($container['id'], 
    	$container['new_width'], $this->site_id);
    }
    
    /**
    * Modify the form content item container 
    * 
    * @todo The container array already includes the current continer margin 
    * values, need to pass the data to the model, the model can then decide if 
    * the margin should be adjusted rather than the width. Will also need to 
    * pass through the original width (or change value) so it can be used in 
    * the margin calculation
    * 
    * @param array $container Container data array, contains id and new width
    * @return void
    */
    private function modifyFormContainer(array $container) 
    {
    	$model_modifier_content_form = 
    	new Dlayer_Model_Modifiers_Content_Form();
    	$model_modifier_content_form->setWidth($container['id'], 
    	$container['new_width'], $this->site_id);
    }
}