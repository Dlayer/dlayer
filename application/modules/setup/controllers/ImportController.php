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
        $this->view->environment = APPLICATION_ENV;
    }

    /**
     * Demo database import
     *
     * @return void
     */
    public function demoAction()
    {
        $this->_helper->setLayoutProperties($this->nav_bar_items, '/setup/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Setup: Demo database', '', false);
    }

    /**
     * Reset and demo database import
     *
     * @return void
     */
    public function resetDemoAction()
    {
        $this->_helper->setLayoutProperties($this->nav_bar_items, '/setup/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Setup: Reset to demo database', '', false);
    }

    /**
     * Clean database import
     *
     * @return void
     */
    public function cleanAction()
    {
        $this->_helper->setLayoutProperties($this->nav_bar_items, '/setup/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Setup: Clean database', '', false);
    }

    /**
     * Reset and clean database import
     *
     * @return void
     */
    public function resetCleanAction()
    {
        $this->_helper->setLayoutProperties($this->nav_bar_items, '/setup/index/index', array('css/dlayer.css'),
            array(), 'Dlayer.com - Setup: Reset to clean database', '', false);
    }

    /**
     * Create the demo database structure
     */
    public function createStructureAction()
    {
        $this->_helper->disableLayout(FALSE);

        $model = new Setup_Model_Import();
        $model->resetMessages();
        $model->resetErrors();

        if (APPLICATION_ENV !== 'production') {
            $result = $model->createTables();
        } else {
            $result = false;
            $model->addError("Import functions are only available when environment is not set to 'production'");
        }

        if ($result === true) {
            $html = '<h2>Success</h2>';
            $html .= "<ul>";
            foreach ($model->messages() as $message) {
                $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        } else {
            $html = '<h2>Error!</h2>';
            $html .= "<ul>";
            if (count($model->messages()) > 0) {
                foreach ($model->messages() as $message) {
                    $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
                }
            }
            foreach ($model->errors() as $message) {
                $html .= "<li><span class=\"text-danger glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        }

        echo $html;
    }

    /**
     * Import the demo database data
     */
    public function importDemoDataAction()
    {
        $this->_helper->disableLayout(FALSE);

        $model = new Setup_Model_Import();
        $model->resetMessages();
        $model->resetErrors();

        if (APPLICATION_ENV !== 'production') {
            $result = $model->importTableData(false);
        } else {
            $result = false;
            $model->addError("Import functions are only available when environment is not set to 'production'");
        }

        if ($result === true) {
            $html = '<h2>Success</h2>';
            $html .= "<ul>";
            foreach ($model->messages() as $message) {
                $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        } else {
            $html = '<h2>Error!</h2>';
            $html .= "<ul>";
            if (count($model->messages()) > 0) {
                foreach ($model->messages() as $message) {
                    $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
                }
            }
            foreach ($model->errors() as $message) {
                $html .= "<li><span class=\"text-danger glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        }

        echo $html;
    }

    /**
     * Drop all the dlayer tables
     */
    public function dropTablesAction()
    {
        $this->_helper->disableLayout(FALSE);

        $model = new Setup_Model_Import();
        $model->resetMessages();
        $model->resetErrors();

        if (APPLICATION_ENV !== 'production') {
            $result = $model->dropTables();
        } else {
            $result = false;
            $model->addError("Import functions are only available when environment is not set to 'production'");
        }

        if ($result === true) {
            $html = '<h2>Success</h2>';
            $html .= "<ul>";
            foreach ($model->messages() as $message) {
                $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        } else {
            $html = '<h2>Error!</h2>';
            $html .= "<ul>";
            if (count($model->messages()) > 0) {
                foreach ($model->messages() as $message) {
                    $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
                }
            }
            foreach ($model->errors() as $message) {
                $html .= "<li><span class=\"text-danger glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        }

        echo $html;
    }

    /**
     * Import the demo database data
     */
    public function importCleanDataAction()
    {
        $this->_helper->disableLayout(false);

        $model = new Setup_Model_Import();
        $model->resetMessages();
        $model->resetErrors();

        if (APPLICATION_ENV !== 'production') {
            $result = $model->importTableData(true);
        } else {
            $result = false;
            $model->addError("Import functions are only available when environment is not set to 'production'");
        }

        if ($result === true) {
            $html = '<h2>Success</h2>';
            $html .= "<ul>";
            foreach ($model->messages() as $message) {
                $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        } else {
            $html = '<h2>Error!</h2>';
            $html .= "<ul>";
            if (count($model->messages()) > 0) {
                foreach ($model->messages() as $message) {
                    $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
                }
            }
            foreach ($model->errors() as $message) {
                $html .= "<li><span class=\"text-danger glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        }

        echo $html;
    }

    /**
     * Import the demo database data
     */
    public function setForeignKeysAction()
    {
        $this->_helper->disableLayout(FALSE);

        $model = new Setup_Model_Import();
        $model->resetMessages();
        $model->resetErrors();

        if (APPLICATION_ENV !== 'production') {
            $result = $model->setForeignKeys();
        } else {
            $result = false;
            $model->addError("Import functions are only available when environment is not set to 'production'");
        }

        if ($result === true) {
            $html = '<h2>Success</h2>';
            $html .= "<ul>";
            foreach ($model->messages() as $message) {
                $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        } else {
            $html = '<h2>Error!</h2>';
            $html .= "<ul>";
            if (count($model->messages()) > 0) {
                foreach ($model->messages() as $message) {
                    $html .= "<li><span class=\"text-success glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>  {$message}</li>";
                }
            }
            foreach ($model->errors() as $message) {
                $html .= "<li><span class=\"text-danger glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>  {$message}</li>";
            }
            $html .= "</ul>";
        }

        echo $html;
    }
}
