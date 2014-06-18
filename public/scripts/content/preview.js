/**
* Javascript containing all the preview functions for the Content manager 
* editing tools
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development limited
* @version $Id$
*/

dlayer.preview.content = {}
dlayer.preview.content.changed = false;
dlayer.preview.content.visible = false;
dlayer.preview.content.highlight = true;
dlayer.preview.content.fn = {}

/** 
* Preview function for content container background color, changes the 
* background color as the user move focus from the field.
* 
* @param integer content_id Id of the content item container being edited
* @param string value Initial value for the background color
* @param boolean optional If the value is optional the user should be able 
						  to clear the value, shouldn't default to initial 
						  value, if not set, defaults to false	
* @return void
*/
dlayer.preview.content.fn.container_background_color = function(content_id, 
value, optional) 
{
	if(typeof optional == 'undefined') { optional = false }
	
	$('#params-background_color').change(function() 
	{
	    var selector = '.c_item_' + content_id;
	    var new_value = this.value;
	    
	    if(new_value.length == 7) {	    	
	    	$(selector).css('background-color', new_value);
			dlayer.preview.content.changed = true;
	    } else {
	    	if(new_value.length == 0) {
	    		$(selector).css('background-color', 'inherit');
	    		dlayer.preview.content.changed = true;
			}
	    }
	    
	    dlayer.preview.content.fn.unsaved();
	});
}

/**
* Preview function for content container margins, updates the margins in the 
* Content manager design as the user modified the values. The input types are 
* numbers so the event fires onchange, 
* 
* There will always be a margin value for each container so we we don't need 
* to be concerned with optional values.
* 
* @param integer content_id Id of the content item
* @param integer margin Margin position, top, right, left or bottom
* @param integer value Current margin value
* @return void 
*/
dlayer.preview.content.fn.container_margin = function(content_id, margin, 
value) 
{
	$('#params-' + margin).change(function() 
	{
		var selector = '#page .c_item_' + content_id;
	    var new_value = parseInt(this.value, 10);
	    var current_value = parseInt($(selector).css('margin-' + margin), 10);
	    
	    if(new_value != NaN && current_value != NaN && 
	    new_value != current_value && new_value > 0) {
	        $(selector).css('margin-' + margin, new_value + 'px');
	        dlayer.preview.content.fn.highlight(selector);
	        dlayer.preview.content.changed = true;
	    }
	    
	    dlayer.preview.content.fn.unsaved();
	});
}

/**
* Display a message if any data has changed and not yet been saved
* 
* @return void
*/
dlayer.preview.content.fn.unsaved = function() 
{
	if(dlayer.preview.content.visible == false) {
		if(dlayer.preview.content.changed == true) {
			$('p.unsaved').show('medium');
			dlayer.preview.content.visible = true;
		}				
	}
}

/**
* Add a hightlight to the content item that has just been changed
* 
* @param string selector Element selector
* @param integer time Length for effect, defaults to 500 if not set
* @return void
*/
dlayer.preview.content.fn.highlight = function(selector, time) 
{
	if(typeof time == 'undefined') { time = 400 }
	
	if(dlayer.preview.content.highlight == true) {
		$(selector).effect("highlight", {}, time);
	}
}