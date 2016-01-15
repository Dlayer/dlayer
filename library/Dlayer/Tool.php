<?php
/**
* Base abstract class for all tool closess. All tool classes must define the 
* abstracts methods below
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
abstract class Dlayer_Tool
{
	protected $params = array();
	protected $params_auto = array();

	protected $validated = FALSE;
	protected $validated_auto = FALSE;
}