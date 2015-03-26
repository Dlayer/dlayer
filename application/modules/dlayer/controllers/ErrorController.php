<?php
/**
* Error controller, all errors are routed to this controller
* 
* @author Dean Blackborough <dean@g3d-development.com
* @copyright G3D Development Limited
* @version $Id: ErrorController.php 1515 2014-02-01 23:15:22Z Dean.Blackborough $
*/
class Dlayer_ErrorController extends Zend_Controller_Action
{
	/**
	* Type hinting for action helpers, hints the property to the code 
	* hinting class which exists in the library
	* 
	* @var Dlayer_Action_CodeHinting
	*/
	protected $_helper;
	
	private $layout;
	
	/**
	* Init the controller, run any set up code required by all the actions 
	* in the controller
	* 
	* @return void
	*/
	public function init()
	{
		$this->_helper->setLayout('error');
		
		// Include js and css files in layout
		$this->layout = Zend_Layout::getMvcInstance();
		$this->layout->assign('js_include', array());
		$this->layout->assign('css_include', array());
		
	}

	/**
	* Default error action, dumps the error or exception
	* 
	* @return void
	*/
	public function errorAction()
	{        
		$errors = $this->_getParam('error_handler');
		
		if (!$errors || !$errors instanceof ArrayObject) {
			$this->view->message = 'You have reached the error page';
			return;
		}
		
		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$priority = Zend_Log::NOTICE;
				$this->view->message = 'Page not found';
			break;
			
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:
				$this->getResponse()->setHttpResponseCode(500);
				$priority = Zend_Log::CRIT;
				$this->view->message = 'Application error';
			break;
			
			default:
				// application error
				$this->getResponse()->setHttpResponseCode(500);
				$priority = Zend_Log::CRIT;
				$this->view->message = 'Application error';
			break;
		}
		
		// Log exception, if logger available
		if ($log = $this->getLog()) {
			$log->log($this->view->message, $priority, $errors->exception);
			$log->log('Request Parameters', $priority, $errors->request->getParams());
		}
		
		// conditionally display exceptions
		if ($this->getInvokeArg('displayExceptions') == true) {
			$this->view->exception = $errors->exception;
		}
		
		$this->view->request = $errors->request;
		$this->view->request_params = $errors->request->getParams();
	}

	/**
	* Returns the eror log
	* 
	*/
	public function getLog()
	{
		$bootstrap = $this->getInvokeArg('bootstrap');
		if (!$bootstrap->hasResource('Log')) {
			return false;
		}
		$log = $bootstrap->getResource('Log');
		return $log;
	}
}