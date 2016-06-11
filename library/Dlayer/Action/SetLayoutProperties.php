<?php

/**
 * Set the layout properties for the controller actions, css and js files to include, the title for the page and
 * also the data array for the nav bar
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Action_SetLayoutProperties extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Pass in the values which need to be passed to the layout
	 *
	 * @param array $nav_bar_items
	 * @param string $active_nav_bar_uri
	 * @param array $css_includes
	 * @param array $js_includes
	 * @param string $title
	 * @param string|null $preview_uri
	 * @param boolean $signed_in Is the user signed in to app?
	 * @return void
	 */
	public function direct(array $nav_bar_items, $active_nav_bar_uri, array $css_includes, array $js_includes, $title,
		$preview_uri = '', $signed_in = TRUE)
	{
		$layout = Zend_Layout::getMvcInstance();

		$layout->assign('js_include', $js_includes);
		$layout->assign('css_include', $css_includes);
		$layout->assign('css_include', $css_includes);
		$layout->assign('title', $title);

		$layout->assign('nav', array('class' => 'top_nav', 'items' => $nav_bar_items, 'active_uri' => $active_nav_bar_uri));

		if(strlen($preview_uri) > 0)
		{
			$layout->assign('preview_uri', $preview_uri);
		}

		$layout->assign('signed_in', $signed_in);
	}
}
