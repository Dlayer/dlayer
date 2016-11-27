<?php

/**
 * Helper tools class, contains helper functions that don't yet have a place
 * anywhere else, individual functions or groups may be moved into new/other
 * classes if it makes sense later
 *
 * @author Dean Blackborough
 * @copyright G3D Development Limited
 */
class Dlayer_Helper
{
	/**
	 * Fetch a $_GET param and return the integer value, use the default value if no value is found
	 *
	 * @param string $var Name of the $_GET var to fetch
	 * @param integer|NULL $default Default value if no value found or type incorrect
	 *
	 * @return integer|NULL
	 */
	public static function getParamAsInteger($var, $default = NULL)
	{
		if(Zend_Controller_Front::getInstance()
			->getRequest()
			->getParam($var, $default) !== '') {
			return intval(Zend_Controller_Front::getInstance()
				->getRequest()
				->getParam($var, $default));
		} else {
			return intval($default);
		}
	}

	/**
	 * Fetch a $_GET param and return the integer value, use the default value if no value is found
	 *
	 * @param string $var Name of the $_GET var to fetch
	 * @param integer|NULL $default Default value if no value found or type incorrect
	 *
	 * @return integer|NULL
	 */
	public static function getParamAsString($var, $default = NULL)
	{
		if(Zend_Controller_Front::getInstance()
				->getRequest()
				->getParam($var, $default) !== '') {
			return Zend_Controller_Front::getInstance()
				->getRequest()
				->getParam($var);
		} else {
			return $default;
		}
	}

	/**
	 * Convert the given bytes file size into human readable text
	 *
	 * @since 0.99
	 *
	 * @param integer $bytes
	 *
	 * @return string More human readable version of file size
	 */
	public static function readableFilesize($bytes = 0)
	{
		if($bytes < 1024)
		{
			return $bytes . ' bytes';
		}
		else
		{
			if($bytes < 1024 * 1024)
			{
				return number_format($bytes / (1024), 1) . ' kb';
			}
			else
			{
				return number_format($bytes / (1024 * 1024), 2) . ' mb';
			}
		}
	}

	/**
	 * Convert an array, for example the array returned by
	 * PDOStatement::fetchAll into a simple array, index and value, typically
	 * for passing to a select menu
	 *
	 * @param array $array The array to convert
	 * @param string $index Key to use for the array index
	 * @param string $value Key to use for the array value
	 *
	 * @return array
	 */
	public static function convertToSimpleArray(array $array, $index, $value)
	{
		$simple_array = array();

		foreach($array as $row)
		{
			$simple_array[$row[$index]] = $row[$value];
		}

		return $simple_array;
	}

	/**
	 * Write a message to the application log
	 *
	 * @param string $message
	 * @return void
	 */
	public static function sendToInfoLog($message)
	{
		/**
		 * @var Zend_Log
		 */
		$logger = Zend_Registry::get('log-app');
		$logger->info($message);
	}

    /**
     * Write a message to the error log
     *
     * @param string $message
     * @return void
     */
    public static function sendToErrorLog($message)
    {
        /**
         * @var Zend_Log
         */
        $logger = Zend_Registry::get('log-error');
        $logger->err($message);
    }
}
