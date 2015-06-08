<?php
/**
* Generates the html and javascript for the color picker, called on ribbon 
* tabs that have color inputs that need to be replaced by calls to the color 
* picker
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: ColorPicker.php 1685 2014-03-16 20:48:23Z Dean.Blackborough $
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
	* Generates the html and javascript for the color picker, called on ribbon 
	* tabs that have color inputs that need to the replaced by calls to the 
	* color picker
	* 
	* The color picker and javscript methods should be returned individually 
	* in different parts of the script, javascript at the end of the script 
	* after all html, color picker before any contols
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
		$this->html = '<script type="text/javascript">
		dlayer.designers.color_picker();
		dlayer.designers.color_picker_invoke();
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
	public function picker($palettes, $history, $custom=TRUE) 
	{
		// Start color picker container
		$this->html = '<div class="color_picker_tool panel panel-default">';
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
					$html .= '<div class="col-xs-12"><h4>' . $this->view->escape($palette['name']) . 
						' <small>The five colours defined for this palette</small></h4></div>';
					
					$colors = '';
					$labels = '';
					
					$html .= '<div class="col-xs-1">&nbsp;</div>';
					
					foreach($palette['colors'] as $color) {
						$colors .= '<div class="color col-xs-2" style="background-color:' . 
						$this->view->escape($color['color_hex']) . ';" title="' . 
						$this->view->escape($color['name']) . '">&nbsp;</div>';
					}
					
					$html .= $colors;
					$html .= '<hr />';
					
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
			$html .= '<div class="col-xs-12"><h4>History <small>Last five colours you used across Dlayer</small></h4></div>';
			
			foreach($history as $color) {
				$html .= '<div class="color col-xs-offset-1 col-xs-2" style="background-color:' . 
				$this->view->escape($color['color_hex']) . ';">&nbsp;</div>';
				$html .= '<div class="color-name col-xs-9 text-muted">' . 
				$this->view->escape($color['color_hex']) . '</div>';
				$html .= '<div class="clearfix"></div>';
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
			<div class="col-xs-12"><h4>Custom <small>Select a custom colour</small></h4>
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
