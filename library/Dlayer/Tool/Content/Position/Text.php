<?php
/**
* Edit the size and position values for the text content item
* 
* This tool is consistent among several content items, the base logic 
* is all part of the base position content tool, this class only needs to 
* exist so the system can find the tool and so the content type can be set 
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_Tool_Content_Position_Text extends 
Dlayer_Tool_Content_Position_Position
{
	protected $content_type = 'text';
}