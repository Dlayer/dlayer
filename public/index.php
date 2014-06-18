<?php
/**
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: index.php 1240 2013-11-14 16:27:15Z Dean.Blackborough $
*/

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV') 
    || define('APPLICATION_ENV', 
    (getenv('APPLICATION_ENV') ? 
    getenv('APPLICATION_ENV') : 'development'));
    
$include = NULL;

if(APPLICATION_ENV == 'production') {
	$include = realpath(APPLICATION_PATH . '/../../Zend-Framework/Zend-1.12.3');
}

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    $include,
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();