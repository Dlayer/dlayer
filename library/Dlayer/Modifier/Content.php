<?php
/**
* Content modifier request class
*
* A tool can request one or more modifications, this class validates the
* modifier reqquest and the passes the request onto the correct content
* modifier
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Modifier_Content
{
    CONST CONTAINER_WIDTH = 'container_width';

    private $modifiers =
    array(Dlayer_Modifier_Content::CONTAINER_WIDTH =>
    'Dlayer_Modifier_Content_ContainerWidth');

    private $site_id;
    private $template_id;
    private $div_id;

    private $modifier;
    private $params = array();

    /**
    * Set up the modifier request object, need to define the site id, template
    * id and template div id, used by all mofifiers
    *
    * @param integer $site_id
    * @param integer $template_id;
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
    * Request a modifier and set the params array
    *
    * @param string $modifier Modifier being requested, class constants should
    *                         be useds to choose modifier
    * @param array $params Params data array, values required are specific to
    *                      each modifier, when the modifier is called the
    *                      params array will be checked before calling the
    *                      modifiers modify() method
    * @return void
    */
    public function request($modifier, array $params)
    {
        if(array_key_exists($modifier, $this->modifiers) == TRUE) {
            $this->modifier = $modifier;
            $this->params = $params;

            $this->callModifier();
        } else {
            throw new Exception('Requested modifier does not exist in
            Dlayer_Modifier_Content()');
        }
    }

    /**
    * Switch statement for the request method, if the modifier exists a call
    * is made to the modifier, is not an exception is thrown, an exception
    * will only be thrown if the developer has failed to add the case
    * statement for a modifier
    *
    * @return void Throws an exception if the modifier doesn't ezist in the
    *              switch statement
    */
    private function callModifier()
    {
        switch($this->modifier) {
            case Dlayer_Modifier_Content::CONTAINER_WIDTH:
                $this->containerWidth();
            break;

            default:
                throw new Exception('Modifier not found in
                Dlayer_Modifier_Content::request()');
            break;
        }
    }

    /**
    * Container width modifier
    *
    * Checks to see if the required params exist in the params array, if the
    * expected params exist the modifier runs making the required changes
    *
    * @return void
    */
    private function containerWidth()
    {
        $modifier = new Dlayer_Modifier_Content_ContainerWidth($this->site_id,
        $this->template_id, $this->div_id);

        if($modifier->validateParams($this->params) == TRUE) {
            $modifier->modify();
        }
    }
}