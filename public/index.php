<?php
/**
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/

if(file_exists('dlayer.lck') === true)
{
	header("Location: http://www.dlayer.com/down.html"); exit();
}

// Define path to application directory
defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
	
include(APPLICATION_PATH . '/configs/environment.php');

// Define application environment
defined('APPLICATION_ENV') 
	|| define('APPLICATION_ENV', 
	(getenv('APPLICATION_ENV') ? 
	getenv('APPLICATION_ENV') : $environemnt));
	
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
	realpath(APPLICATION_PATH . '/../library'),
	get_include_path(),
)));

// Version number and release date
define('VERSION_NO', $version_no);
define('VERSION_DATE', $version_release_date);

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
	APPLICATION_ENV,
	APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap()
			->run();