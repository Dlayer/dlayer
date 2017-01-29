<?php
/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define path to library
defined('DLAYER_LIBRARY_PATH')
|| define('DLAYER_LIBRARY_PATH', realpath(dirname(__FILE__) . '/../library'));

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV',
    (getenv('APPLICATION_ENV') ?
        getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
