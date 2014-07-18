<?php
/**
* Helper tools class, contains helper functions that don't yet have a place 
* anywhere else, individual functions or groups may be moved into new/other 
* classes if it makes sense later
* 
* @author Dean Blackborough
* @copyright G3D Development Limited
* @version $Id: Helper.php 1421 2014-01-20 16:23:02Z Dean.Blackborough $
*/
class Dlayer_Helper 
{
    /**
    * Fetch a $_GET param and check to ensure it is an integer value, if no 
    * values exists or it is not a integer or no $_GET param exists return the 
    * default value or NULL
    * 
    * @param string $var Name of the $_GET var to fetch
    * @param integer|NULL $default Default value if no value found or type incorrect
    * @return integer|NULL
    */
    public static function getInteger($var, $default=NULL) 
    {
        $value = Zend_Controller_Front::getInstance()->getRequest()->getParam(
        $var, $default);
        
        if($default !== NULL) {
            if($value !== $default && is_numeric($value) == TRUE) {
                return intval($value);
            } else {
                return $default;
            }
        } else {
            if($value === NULL) {
                return NULL;
            } else {
                if(is_numeric($value) == TRUE) {
                    return intval($value);
                } else {
                    return NULL;
                }
            }
        }
    }
    
    /**
    * Convert the given template name, strip the chars leaving the id, this 
    * can then be checked for validaty 
    * 
    * @param string $name Template div name/id
    * @return integer|FALSE Returns the id of a valid div after checking the 
    *                       database or FALSE if no div found
    */
    public static function convertDivIdStringToId($name) 
    {
        $id = str_replace('template_div_', '', $name);
        
        if(is_numeric($id) == TRUE) {
            return intval($id);
        } else {
            return FALSE;
        }
    }
    
    /**
    * Convert filesize into readable format
    * 
    * @param integer $bytes 
    * @return string More human readable version of filesize
    */
    public static function readableFilesize($bytes=0) 
    {
        if($bytes < 1024) {
            return $bytes . ' bytes';
        } else if($bytes < 1024*1024) {
            return number_format($bytes/(1024), 1) . ' kb';
        } else {
            return number_format($bytes/(1024*1024), 2) . ' mb';
        }
    }
}