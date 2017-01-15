<?php

/**
 * Setup controller
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Setup_ImportController extends Zend_Controller_Action
{
    /**
     * Type hinting for action helpers, hints the property to the code
     * hinting class which exists in the library
     *
     * @var Dlayer_Action_CodeHinting
     */
    protected $_helper;

    /**
     * @var array Nav bar items for public version of nav bar
     */
    private $nav_bar_items = array(
        array(
            'uri' => '/dlayer/index/home',
            'name' => 'Dlayer Demo',
            'title' => 'Dlayer.com: Web development simplified',
        ),
        array(
            'uri' => '/setup/index/index',
            'name' => 'Setup',
            'title' => 'Setup Dlayer'
        ),
        array(
            'uri' => 'http://www.dlayer.com/docs/',
            'name' => 'Docs',
            'title' => 'Read the Docs for Dlayer'
        ),
    );

    /**
     * Init the controller, run any set up code required by all the actions
     * in the controller
     *
     * @return void
     */
    public function init()
    {

    }

    /**
     * Dlayer splash page
     *
     * @return void
     */
    public function demoAction()
    {
        $this->_helper->setLayoutProperties($this->nav_bar_items, '/setup/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Setup', '', false);
    }

    /**
     * Long script example
     */
    public function demoImportAction()
    {
        $this->_helper->disableLayout(FALSE);

        $model = new Setup_Model_Import();
        $result = $model->createTables();

        if ($result === true) {
            $html = '<h2>Success</h2>';
            $html .= "<ul>";
            foreach ($model->messages() as $message) {
                $html .= "<li>{$message}</li>";
            }
            $html .= "</ul>";
        } else {
            $html = '<h2>Error!</h2>';
            $html .= "<ul>";
            if (count($model->messages()) > 0) {
                foreach ($model->messages() as $message) {
                    $html .= "<li>{$message}</li>";
                }
            }
            foreach ($model->errors() as $message) {
                $html .= "<li>{$message}</li>";
            }
            $html .= "</ul>";
        }

        echo $html;
    }
}
