<?php
/**
* Generates the HTML and javascript calls for the colour picker, can be called 
* anywhere in the app but typically the user will see it inside the right 
* hand side tool bar.
* 
* Can be attached anywhere there is a colour input or multiple colour inputs
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_View_ColorPicker extends Zend_View_Helper_Abstract 
{
	/**
	* Override the hinting for the view property so that we can see the view
	* helpers that have been defined
	*
	* @var Dlayer_View_Codehinting
	*/
	public $view;
	
	private $html;
	
	/**
	* Resets the params for the colour picker.
	* 
	* The Javascript and html methods need to be called individually, examples 
	* below.
	* 
	* Example usage, <?php echo $this->colorPicker()->javascript(); ?> 
	* and <?php echo $this->colorPicker()->picker(TRUE, FALSE, TRUE); ?>
	* 
	* @return Dlayer_View_ColorPicker
	*/
	public function colorPicker() 
	{
		$this->resetParams();
		
		return $this;
	}
	
	/**
	* Reset any internal params, need to reset the params in case the view 
	* helper is called multiple times within the same view.
	* 
	* @return void
	*/
	public function resetParams() 
	{
		$this->html = '';
	}
	
	/**
	* The javascript that attaches the onclick events to the inputs and also 
	* manages all the functionality of the color picker
	* 
	* @return Dlayer_View_ColorPicker
	*/
	public function javascript() 
	{
		$this->html = '<script>
			dlayerDesigner.colorPicker.start();
			dlayerDesigner.colorPicker.events();
			</script>';
		
		return $this;
	}
	
	/**
	* Generates the html for the color picker, developer can define if they 
	* want to include each of the sections, palettes, history and custom, 
	* by passing in either the data or FALSE
	* 
	* @param array|FALSE $palettes 
	* @param array|FALSE $history
	* @param boolean $custom
	* @return Dlayer_View_ColorPicker
	*/
	public function picker($palettes, $history, $custom = true)
	{
		// Start color picker container
		$this->html = '<div class="color-picker-tool panel panel-default">';
		$this->html .= '<div class="panel-heading"><h4>Colour picker 
			<small>Select a colour</small> <span class="glyphicon
			 glyphicon-remove close-color-picker pull-right" title="Close colour picker" 
			 aria-hidden="true"></span></h4></div>';
		$this->html .= '<div class="panel-body">';
		$this->html .= $this->palettes($palettes);
		$this->html .= $this->history($history);
		$this->html .= $this->custom($custom);
		$this->html .= '</div>';
		$this->html .= '</div>';
		
		return $this;
	}
	
	/**
	* Generate the html for the palettes section of the color picker
	* 
	* @param array|FALSE $palettes 
	* @return string
	*/
	private function palettes($palettes) 
	{
		$html = '';
		
		if($palettes != FALSE) {
			if(count($palettes) == 2) {
				foreach($palettes as $palette) {
					$html .= '<div class="palette row">';
					$html .= '<div class="col-lg-12 col-xs-12 col-sm-6"><h4>' . $this->view->escape($palette['name']) . 
						' <small>Your chosen colours</small></h4></div>';
					
					$colors = '';
					$x = 0;
					
					foreach($palette['colors'] as $color) 
					{
						if($x === 0) 
						{
							$offset = ' col-lg-offset-1 col-sm-offset-0 col-xs-offset-1';
						}
						else 
						{
							$offset = NULL;
						}
						
						$colors .= '<div class="color col-lg-2 col-xs-2 col-sm-1' . $offset .  
						'" style="background-color:' . $this->view->escape($color['color_hex']) . 
						';" title="' . $this->view->escape($color['name']) . '">&nbsp;</div>';
						
						$x++;
					}
					
					$html .= $colors;

					$html .= '</div>';
				}
			} else {
				$html .= '<p>Unable to fetch the palettes for this web 
				site, please go to <a href="/dlayer/settings/palettes">app 
				settings</a> and define your colour palettes.</p>';
			}
		}
		
		return $html;
	}
	
	/**
	* Generate the html for the history part of the color picker
	* 
	* @param array|FALSE $history
	* @return string
	*/
	private function history($history) 
	{
		$html = '';
		
		if($history != FALSE) {
			$html .= '<div class="history row">';
			$html .= '<div class="col-xs-12 col-sm-12"><h4>History <small>Last five 
				colours you used across Dlayer</small></h4></div>';
				
			$x = 0;
			
			foreach($history as $color) 
			{
				$html .= '<div class="color col-lg-offset-1 col-lg-2 col-xs-offset-1 col-xs-2 col-sm-1" style="background-color:' . 
					$this->view->escape($color['color_hex']) . ';">&nbsp;</div>';
				$html .= '<div class="color-label col-lg-8 col-xs-9 col-sm-2 text-muted">' .
					$this->view->escape($color['color_hex']) . '</div>';
					
				if($x === 2) 
				{
					$html .= '<div class="clearfix visbile-sm"></div>';
				}
				
				$x++;
			}
			
			$html .= '</div>';
		}
		
		return $html;
	}
	
	/**
	* Generate the html for the custom control on the color picker
	* 
	* @param boolean $custom
	* @return string
	*/
	private function custom($custom=TRUE)
	{
		$html = '';
		
		if($custom == TRUE) {
			$html .= '<div class="custom row">
			<div class="col-lg-12 col-sm-6 col-xs-12"><h4>Custom <small>Select a custom colour</small></h4></div>
			<div class="col-lg-12 col-sm-6 col-xs-12" style="margin-top: 5px;">
			<label>Choose colour</label> <input type="color" name="color" class="color" size="7" 
			maxlength="7" value="000000"> 
			</div></div>';
		}
		
		return $html;
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
		return $this->html;
	}
	
}
