<?php
/**
* Edit the size and position values for the heading content item
* 
* This tool is consistent among several content items, the base logic 
* is all part of the base position content tool, this class only needs to 
* exist so the system can find the tool and so the content type can be set 
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Tool_Content_Position_Heading extends 
Dlayer_Tool_Content_Position_Position
{
	protected $content_type = 'heading';
}