<?php
/**
* Generate the html for a bootstrap 3 navbar, the navbar name/image can be 
* defined as well as the menu items, if a children key exists a drop down will 
* be created. The inverted style can be set by calling the inverted() method
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_View_Bootstrap3Navbar extends Zend_View_Helper_Abstract
{
	/**
	* Override the hinting for the view property so that we can see the view
	* helpers that have been defined
	*
	* @var Dlayer_View_Codehinting
	*/
	public $view;

	private $navbar_id = NULL;
	private $navbar_class;
	private $container_class;

	private $brand;
	private $navbar_items;
	private $active_uri;

	/**
	* Generates a simple bootstrap navbar
	*
	* @param string $brand Brand name/img, appears to let of navbar
	* @param array $navbar_items Array containing the navbar items, each item
	* 	should be an array with the folowing keys, uri, title, name and and
	* 	optionally children. A driop down will created for all the items in the 
	* 	children array
	* @param string $active_uri The Uri of the active item
	* @return Dlayer_View_Bootstrap3Navbar
	*/
	public function bootstrap3Navbar($brand, array $navbar_items,
		$active_url='')
	{
		$this->resetParams();

		$this->brand = $brand;
		$this->navbar_items = $navbar_items;
		$this->active_uri = $active_url;

		// Custom id incase called multiple times withion a view
		if($this->navbar_id == NULL) {
			$this->navbar_id = 1;
		} else {
			$this->navbar_id += 1;
		}

		return $this;
	}

	/**
	* Reset any internal params, we need to reset the internal params in
	* case the helper is called multiple times withing the same view.
	*
	* We don't reset the menu_id, needs to be incremented in case we have
	* multiple bootstrap navbars
	*
	* @return void
	*/
	public function resetParams()
	{
		$this->brand = '';
		$this->navbar_items = array();
		$this->active_uri = '';

		$this->navbar_class = 'navbar-default';
		$this->container_class = 'container';
	}

	/**
	* Brand and toggle html
	*
	* @return string
	*/
	private function brandAndToggle()
	{
		return '<div class="navbar-header">' . 
			'<button type="button" class="navbar-toggle collapsed" 
			data-toggle="collapse" 
			data-target="#bs-navbar-collapse-' . $this->navbar_id .'">' . 
			'<span class="sr-only">Toggle navigation</span>' . 
			'<span class="icon-bar"></span><span class="icon-bar"></span>' . 
			'<span class="icon-bar"></span></button>' . 
			'<a class="navbar-brand" href="/">' . $this->brand . 
			'</a></div>';
	}

	/**
	* Navigation items
	*
	* @return string
	*/
	private function navbarItems()
	{
		$html = '<div class="collapse navbar-collapse"
		id="bs-navbar-collapse-' . $this->navbar_id . '">';
		$html .= '<ul class="nav navbar-nav">';

		foreach($this->navbar_items as $item) {
			if(array_key_exists('children', $item) == FALSE) {
				if($this->active_uri !== $item['uri']) {
					$html .= $this->item($item);
				} else {
					$html .= '<li class="active"><a href="' . $item['uri'] .
					'" title="' . $item['title']. '">'. $item['name'] .
					' <span class="sr-only">(current)</span></a></li>';
				}
			} else {
				$html .= '<li class="dropdown">';
				$html .= '<a href="#" class="dropdown-toggle"
				data-toggle="dropdown" role="button" aria-expanded="false"
				title="'. $item['title'] . '">' . $item['name'] .
				'<span class="caret"></span></a>' . PHP_EOL;
				$html .= '<ul class="dropdown-menu" role="menu">';

				foreach($item['children'] as $item) {
					$html .= $this->item($item);
				}

				$html .= '</ul></li>';
			}
		}

		$html .= '</ul></div>';

		return $html;
	}

	/**
	* Create html for a single Li
	*
	* @return string
	*/
	private function item(array $item)
	{
		return '<li><a href="' . $item['uri'] . '" title="' . 
			$item['title']. '">'. $item['name'] . '</a></li>';
	}

	/**
	* Generate the html for the complete navbar, result is returned to
	* __toString when the user prints/echos the view helper
	*
	* @return string
	*/
	private function render()
	{
		$html = '<nav class="navbar ' . $this->navbar_class . 
			'" role="navigation"><div class="' . $this->container_class . '">';

		$html .= $this->brandAndToggle();
		$html .= $this->navbarItems();

		$html .= '</div></nav>';

		return $html;
	}

	/**
	* Switch the navbar style to the inverted style
	*
	* @return Dlayer_View_Bootstrap3Navbar
	*/
	public function inverted()
	{
		$this->navbar_class = 'navbar-inverse';

		return $this;
	}
	
	/**
	* Override the container class for the container div
	* 
	* @param string $container_class Defaults to container
	* @return Dlayer_View_Bootstrap3Navbar
	*/
	public function containerClass($container_class) 
	{
		$this->container_class = $container_class;
		
		return $this;
	}

	/**
	* The view helpers can be output directly, no need to call and return the
	* render method, we define the __toString method so that echo and print
	* calls on the object return the html generated by the render method
	*
	* @return string Generated html
	*/
	public function __toString()
	{
		return $this->render();
	}
}
