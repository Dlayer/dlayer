<?php
/**
* Base abstract class for all tool closess. All tool classes must define the 
* abstracts methods below
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Tool.php 1321 2013-12-04 02:13:43Z Dean.Blackborough $
*/
abstract class Dlayer_Tool
{
    protected $params = array();
    protected $params_auto = array();

    protected $validated = FALSE;
    protected $validated_auto = FALSE;
}