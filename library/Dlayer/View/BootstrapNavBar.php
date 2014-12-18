<?php
/**
* Generate the html for a bootstrap navbar, allows the developer to define 
* the brand name, navbar items including dropdowns and allow the inverted 
* style to be selected
* 
* @todo Create another viewhelper to support all the options for a bootstrap 
* navbar, forms, brand images, fixed etc
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
*/
class Dlayer_View_BootstrapNavbar extends Zend_View_Helper_Abstract 
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

	private $brand;
	private $navbar_items;
	private $active_url;

	/**
	* Generates a simple bootstrap navbar
	* 
	* @param string $brand Brand name, appears to let of navbar
	* @param array $navbar_items Array containing the navbar items, each item 
	* 							 should be an array with url, title and name 
	* 							 fields, dropdowns can be created by defining 
	* 							 a children field with the same format array
	* @param string $active_url The URL of the active item, not always the 
	* 							current URL
	* @return Dlayer_View_BootstrapNavbar
	*/
	public function bootstrapNavbar($brand, array $navbar_items, 
	$active_url='') 
	{
		$this->resetParams();

		$this->brand = $brand;
		$this->navbar_items = $navbar_items;
		$this->active_url = $active_url;
		
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
		$this->active_url = '';
		
		$this->navbar_class = 'navbar-default';
	}
	
	/**
	* Brand and toggle html
	* 
	* @return string 
	*/
	private function brandAndToggle() 
	{
		$html = '<div class="navbar-header">' . PHP_EOL;
		$html .= '<button type="button" class="navbar-toggle collapsed" 
		data-toggle="collapse" 
		data-target="#bs-navbar-collapse-' . $this->navbar_id .'">' . PHP_EOL;
		$html .= '<span class="sr-only">Toggle navigation</span>' . PHP_EOL;
		$html .= '<span class="icon-bar"></span>' . PHP_EOL;
		$html .= '<span class="icon-bar"></span>' . PHP_EOL;
		$html .= '<span class="icon-bar"></span>' . PHP_EOL;
		$html .= '</button>' . PHP_EOL;
		$html .= '<a class="navbar-brand" href="/">' . $this->brand . 
		'</a>' . PHP_EOL;
		$html .= '</div>' . PHP_EOL;
		
		return $html;
	}
	
	/**
	* Navigation items
	* 
	* @return string 
	*/
	private function navbarItems() 
	{
		$html = '<div class="collapse navbar-collapse" 
		id="bs-navbar-collapse-' . $this->navbar_id . '">' . PHP_EOL;
		$html .= '<ul class="nav navbar-nav">' . PHP_EOL;
		
		foreach($this->navbar_items as $item) {
			if(array_key_exists('children', $item) == FALSE) {
				if($this->active_url !== $item['url']) {
					$html .= $this->item($item);
				} else {
					$html .= '<li class="active"><a href="' . $item['url'] .  
					'" title="' . $item['title']. '">'. $item['name'] . 
					' <span class="sr-only">(current)</span></a></li>' . PHP_EOL;
				}
			} else {
				$html .= '<li class="dropdown">'. PHP_EOL;
				$html .= '<a href="#" class="dropdown-toggle" 
				data-toggle="dropdown" role="button" aria-expanded="false" 
				title="'. $item['title'] . '">' . $item['name'] . 
				'<span class="caret"></span></a>' . PHP_EOL;
				$html .= '<ul class="dropdown-menu" role="menu">' . PHP_EOL;
				
				foreach($item['children'] as $item) {
					$html .= $this->item($item);
				}

				$html .= '</ul>' . PHP_EOL;
				$html .= '</li>' . PHP_EOL;
			}
		}
					
		$html .= '</ul>' . PHP_EOL;

		$html .= '</div><!-- /.navbar-collapse -->' . PHP_EOL;
		
		return $html;
	}
	
	/**
	* Create html for a single LI
	* 
	* @return string 
	*/
	private function item(array $item)
	{
		return '<li><a href="' . $item['url'] . '" title="' . 
		$item['title']. '">'. $item['name'] . '</a></li>' . PHP_EOL;
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
		'" role="navigation">' . PHP_EOL;
		$html .= '<div class="container">' . PHP_EOL;
		
		$html .= $this->brandAndToggle();
		$html .= $this->navbarItems();
		
		$html .= '</div><!-- /.container-fluid -->' . PHP_EOL;
		$html .= '</nav>' . PHP_EOL;
		
		return $html;
	}
	
	/**
	* Switch the navbar style to the inverted style
	* 
	* @return Dlayer_View_BootstrapNavbar
	*/
	public function inverted() 
	{
		$this->navbar_class = 'navbar-inverse';
		
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
