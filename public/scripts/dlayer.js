/**
* Base javascript file for Dlayer, all functions extends this object
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development limited
* @version $Id: dlayer.js 1882 2014-06-01 15:01:22Z Dean.Blackborough $
*/
var contents = null;

var dlayer = {}

dlayer.debug = debug;

dlayer.ribbon = {}
dlayer.ribbon.tabs = {}
dlayer.tools = {}
dlayer.preview = {}
dlayer.selectors = {} 
dlayer.movers = {}
dlayer.settings = {}
dlayer.designers = {}
dlayer.designers.metrics = {}
dlayer.designers.color_picker_value = null;
dlayer.designers.color_picker_rgb = null;
dlayer.designers.color_picker_element = null;

/**
* Adds click events for the ribbon tabs, on click sets the selected tab as 
* active and then calls a function to make an AJAX call for the tab content
* 
* @param string module Module that the function is being called from
* @param string tool The name of the selected tool, used by the AJAX function 
*                    for validation purposes
* @return void
*/
dlayer.ribbon.tabs.clicks = function(module, tool) 
{
    $('#ribbon > .tabs > .tab').click(
        function() {
            /* Only switch if the tab is not already selected */
            if($(this).hasClass('selected') == false) {
                $('#ribbon > .tabs > .tab').removeClass('selected');
                $(this).addClass('selected');
                
                var tab = this.id.replace('tab_', '');
                
                $('#ribbon > .content').removeClass('open');
                $('#tab_content_' + tab).addClass('open');
                
                dlayer.ribbon.tabs.content(tab, tool, module);
            }
        }
    );
}

/**
* Load the content for the selected tool and tab
* 
* @param string tab Name of the tool tab
* @param string tool Name of the tool
* @param string module Name of the module, ribbon-tab-html is always part of 
*                      the design controller in the requested module
* @return void
*/
dlayer.ribbon.tabs.content = function(tab, tool, module) 
{
    $.post('/' + module + '/design/ribbon-tab-html', 
           { tab: tab, 
             tool: tool },
           function(data) {
               $('#tab_content_' + tab).html(data);
               $('#color_picker').hide();
           }, 
           'html');
}

/**
* Select function for the content module, allows a div to be selected so that 
* a content block can be added to it
* 
* @return void
*/
dlayer.selectors.content = function() 
{
    $('div.selectable').hover(
        function() {
            background_color = $(this).css('background-color');
            $(this).css('background-color', '#e1dc50');
            $(this).css('cursor', 'pointer');
        }, 
        function() {
            $(this).css('background-color', background_color);
        }
    );
    $('div.selectable').click(
        function() {
            $(this).css('background-color','#c3be50');
            
            var id = this.id.replace('template_div_', '');
            window.location.replace(
            '/content/design/set-selected-div/selected/' + id);
        }
    );
}

/**
* Select function for the content module, allows a content item to be 
* selected once a page/template div has been selected
* 
* @return void
*/
dlayer.selectors.contentItem = function() 
{
    $('.c_selectable').hover(
        function() {
            background_color = $(this).css('background-color');
            $(this).css('background-color', '#ebebeb');
            $(this).find('.move').show();
        }, 
        function() {
            $(this).css('background-color', background_color);
            $(this).find('.move').hide();
        }
    );
    $('.c_selectable').click(
        function() {
            $(this).css('background-color','#e1e1e1');
            
            var params = $(this).find('.item')[0].id.split(':');
                       
            window.location.replace(
            '/content/design/set-selected-content/selected/' + params[2] + 
            '/content-type/' + params[0] + '/tool/' + params[1]);
        }
    );
}

/**
* Select function for the template module, allows a div to be selected so that 
* the user can work on it, modify its styles, change size or split
* 
* @return void
*/
dlayer.selectors.template = function() 
{
    $('div.selectable').hover(
        function() {
            background_color = $(this).css('background-color');
            $(this).css('background-color', '#e1dc50');
        }, 
        function() {
            $(this).css('background-color', background_color);
        }
    );
    $('div.selectable').click(
        function() {
            $(this).css('background-color','#c3be50');
            
            var id = this.id.replace('template_div_', '');
            window.location.replace(
            '/template/design/set-selected-div/selected/' + id);
        }
    );
}

/**
* Preset the position values for the selected content item, user has three 
* choices, left, right and center aligned
* 
* @type void
*/
dlayer.designers.set_position_presets = function(page_container, 
content_container) 
{
	$('#ribbon .set_position').click(
        function() {
        	var alignment = this.id.replace('set_position_', '');
        	var left = 0;
        	var right = 0;
        	var diff = 0;
        	
        	if(page_container != content_container && content_container < 
        	page_container) {
				switch(alignment) {
					case 'right':
						left = page_container - content_container;
					break;
					
					case 'center':
						diff = page_container - content_container;
						if(diff % 2 == 0) {
							left = diff / 2;
							right = left;
						} else {
							left = (diff - 1) / 2;
							right = left + 1;
						}
					break;
					
					default:
						// Left is the default position for an item, leave/set 
						// both values to 0, set in case user has changed them
					break;
        		}				
        	}
        	
        	$('#params-left').val(left);
        	$('#params-right').val(right);
        	
        	return false;
        }
    );
}

/**
* Invoke the color picker, resets the color value for the object and stores 
* id of the element that is calling the picker
* 
* @return void
*/
dlayer.designers.color_picker_invoke = function() 
{
    $('#ribbon .color_picker').click(
        function() {
        	$('.color_picker_tool').slideDown();
        	
        	var element = this.id;
        	
        	dlayer.designers.color_picker_value = null;
        	dlayer.designers.color_picker_element = 
        	this.id.replace('picker_', '');
        }
    );
    
    $('#ribbon a.color_picker_clear').click(
        function() {        	
        	var element = 
        	$(this).siblings('.color_picker').attr('id').replace('picker_', '');
        	
        	$('#ribbon #picker_' + element).css('background-color', 'inherit');
        	$('#' + element).val('').trigger('change');
        	
        	return false;
        }
    );
}

/**
* Close the color picker, set the invoker element and incoker div to the 
* selected color and value
* 
* @return void
*/
dlayer.designers.color_picker_close = function() 
{
	$('.color_picker_tool').slideUp();
	
	if(dlayer.designers.color_picker_value != null) {		
		$('#ribbon #picker_' + dlayer.designers.color_picker_element).css(
        'background-color', dlayer.designers.color_picker_rgb);
		$('#' + dlayer.designers.color_picker_element).val(
		dlayer.designers.color_picker_value).trigger('change');
		
	}
}

/**
* Click events for the color picker, sets the values in the object
* 
* @return void
*/
dlayer.designers.color_picker = function() 
{
	$('#ribbon .color_picker_tool .close a').click(
        function() {
        	dlayer.designers.color_picker_close();
        }
    );
	
    $('#ribbon .color_picker_tool .palette .color').click(
        function() {
        	dlayer.designers.color_picker_rgb = 
        	$(this).css('background-color');
        	dlayer.designers.color_picker_value = 
        	dlayer.rgbToHex($(this).css('background-color'));
        	
        	dlayer.designers.color_picker_close();
        }
    );
    
    $('#ribbon .color_picker_tool .history .color').click(
        function() {
        	dlayer.designers.color_picker_rgb = 
        	$(this).css('background-color');
        	dlayer.designers.color_picker_value = 
        	dlayer.rgbToHex($(this).css('background-color'));
        	
        	dlayer.designers.color_picker_close();
        }
    );
    
    $('#ribbon .color_picker_tool .custom .color').change(
        function() {
        	dlayer.designers.color_picker_rgb = $(this).val();
        	dlayer.designers.color_picker_value = $(this).val();
        	
        	dlayer.designers.color_picker_close();
        }
    );
}

/**
* Convert the rgb value in a hex for the inputs
* 
* @return string
*/
dlayer.rgbToHex = function(colorStr) 
{
	var hex = '#';
    $.each(colorStr.substring(4).split(','), function(i, str){
        var h = ($.trim(str.replace(')',''))*1).toString(16);
        hex += (h.length == 1) ? "0" + h : h;
    });
    return hex;
}

/**
* Select function for the forms module, allows a form input to be selected so 
* that it can be edited
* 
* @return void
*/
dlayer.selectors.form = function() 
{
    $('#form div.row').hover(
        function() {
            background_color = $(this).css('background-color');
            $(this).css('background-color', '#e1dc50');
            $(this).find('.move').show();
        }, 
        function() {
            $(this).css('background-color', background_color);
            $(this).find('.move').hide();
        }
    );
    $('#form div.row').click(
        function() {
            $(this).css('background-color','#c3be50');
            
            var params = this.id.split(':');
            
            window.location.replace(
            '/form/design/set-selected-field/selected/' + params[2] + 
            '/tool/' + params[1] + '/type/' + params[0]);
        }
    );
}

/**
* Move a content item, either up or down, how to move the item depends on the 
* class attached to the div
* 
* @return void
*/
dlayer.movers.contentItem = function() 
{
    $('.c_selectable > .move').click(
        function() {
            $(this).css('background-color','#505050');
            $(this).css('color','#ebebeb');
            
            var params = this.id.split(':');
            
            window.location.replace(
            '/content/design/move-content/direction/' + params[0] + 
            '/type/' + params[1] + '/content-id/' + params[2] + '/div-id/' + 
            params[3] + '/page-id/' + params[4]);
        }
    );
}

/** 
* Page content metrics
* 
* @return void
*/
dlayer.designers.metrics.pageContainer = function() 
{
	$('#page_container_metrics').click(
		function() {
			$('#page_container_metrics > .title').toggle();
			$('#page_container_metrics > .metrics').toggle();
		}
	);
}

/** 
* Content item metrics
* 
* @return void
*/
dlayer.designers.metrics.contentItems = function() 
{
	$('#content_item_metrics').click(
		function() {
			$('#content_item_metrics > .title').toggle();
			$('#content_item_metrics > .metrics').toggle();
		}
	);
}

/**
* Attach the movement controls and events, allows a form field to be moved up 
* down on the form
* 
* @return void
*/
dlayer.movers.formFields = function() 
{
	var fields = $('#form .row').length - 1;
	
	$('#form .row').each(function(index) {
		var params = this.id.split(':');
		
		if(index !== 0) {
			$(this).prepend('<div class="move move-' + params[1] + 
			'" id="up:' + params[0] + ':' + params[2] + '">Move up</div>');
		}
		if(index !== fields) {
			$(this).append('<div class="move move-' + params[1] + 
			'" id="down:' + params[0] + ':' + params[2] + '">Move down</div>');
		}
	});
	
	$('#form .row > .move').click(
        function() {
            $(this).css('background-color','#505050');
            $(this).css('color','#ebebeb');
                        
            var params = this.id.split(':');
            
            window.location.replace(
            '/form/design/move-field/direction/' + params[0] + 
            '/type/' + params[1] + '/field-id/' + params[2]);
            
            return false;
        }
    );
}