/**
* Javascript containing all the preview functions for the Form builder 
* editing tools
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development limited
* @version $Id: preview.js 1961 2014-06-17 00:01:52Z Dean.Blackborough $
*/

dlayer.preview.form = {}
dlayer.preview.form.changed = false;
dlayer.preview.form.visible = false;
dlayer.preview.form.highlight = true;
dlayer.preview.form.fn = {}

/**
* Preview function for row attributes, updates the value in the Form builder 
* as the user changes the value
* 
* @param integer field_id Id of the field being edited
* @param string attribute Field attribute being updated
* @param string element HTML element that is being updated
* @param string value Initial value for the text string
* @param boolean optional If the value is optional the user should be able 
				          to clear the value, shouldn't default to initial 
				          value, if not set defaults to false	
* @return void
*/
dlayer.preview.form.fn.row_attribute = function(field_id, attribute, element, 
value, optional) 
{
	if(typeof optional == 'undefined') { optional = false }
	
	$('#params-' + attribute).keyup(function() 
	{
		var selector = '.row_' + field_id + ' ' + element;
		var current_value = $(selector).text();
		
		if(this.value.trim().length > 0 && 
		this.value.trim() != current_value) {
			$(selector).html(this.value.trim());
			dlayer.preview.form.fn.highlight(selector, 1500);
			dlayer.preview.form.highlight = false;
			dlayer.preview.form.changed = true;
		} else {
			if(this.value.trim().length == 0) {
				if(optional == false) {
					$(selector).html(value);
					$('#params-' + attribute).val(value);
				} else {
					$(selector).html('');
					$('#params-' + attribute).val('');
					dlayer.preview.form.highlight = true;
					dlayer.preview.form.fn.highlight(selector);
					dlayer.preview.form.changed = true;
				}
			}
		}
		
		dlayer.preview.form.fn.unsaved();
	});
    
    $('#params-' + attribute).change(function() 
    {
    	dlayer.preview.form.highlight = true;
    	var selector = '.row_' + field_id + ' ' + element;
    	var current_value = $(selector).text();
    	
        if(this.value.trim().length > 0 && 
        this.value.trim() != current_value) {
            $(selector).html(this.value.trim());
            dlayer.preview.form.fn.highlight(selector);
            dlayer.preview.form.changed = true;
        }
        
        dlayer.preview.form.fn.unsaved();
    });
    
    $('#params-' + attribute).blur(function() 
    {
    	dlayer.preview.form.highlight = true;
    	var selector = '.row_' + field_id + ' ' + element;
    	
    	if(dlayer.preview.form.changed == true) {
			dlayer.preview.form.fn.highlight(selector);
    	}
    });
}

/**
* Preview function for field attributes, updates the attribute value in the 
* Form builder as the user changes the value. Updates the value for the user 
* on key up and on value change.
* 
* @param integer field_id Id of the field being edited
* @param string attribute Field attribute being updated
* @param string field_attribute Element attribute that is being updated
* @param string value Initial value for the text string
* @param boolean optional If the value is optional the user should be able to clear 
				  the value, shouldn't default to initial value, if not set 
				  defaults to false	
* @return void
*/
dlayer.preview.form.fn.field_attribute_string = function(field_id, attribute, 
field_attribute, value, optional) 
{
	if(typeof optional == 'undefined') { optional = false }
	
	$('#params-' + attribute).keyup(function() 
	{
		var selector = '#field_' + field_id;
		var current_value = $(selector).attr(field_attribute);
		
		if(this.value.trim().length > 0 && 
		this.value.trim() != current_value) {
			$(selector).attr(field_attribute, this.value.trim());
			dlayer.preview.form.fn.highlight(selector, 1500);
			dlayer.preview.form.highlight = false;
			dlayer.preview.form.changed = true;
		} else {
			if(this.value.trim().length == 0) {
				if(optional == false) {
					$(selector).attr(field_attribute, value);
					$('#params-' + attribute).val(value);
				} else {
					$(selector).attr(field_attribute, '');
					$('#params-' + attribute).val('');
					dlayer.preview.form.highlight = true;
					dlayer.preview.form.fn.highlight(selector);
					dlayer.preview.form.changed = true;
				}
			}
		}
		
		dlayer.preview.form.fn.unsaved();
	});
    
    $('#params-' + attribute).change(function() 
    {
    	dlayer.preview.form.highlight = true;
    	var selector = '#field_' + field_id;
        var current_value = $('#field_' + field_id).attr(field_attribute);
        
        if(this.value.trim().length > 0 && 
        this.value.trim() != current_value) {
            $(selector).attr(field_attribute, this.value.trim());
            dlayer.preview.form.fn.highlight(selector);
            dlayer.preview.form.changed = true;
        }
        
        dlayer.preview.form.fn.unsaved();
    });
    
    $('#params-' + attribute).blur(function() 
    {
    	dlayer.preview.form.highlight = true;
    	var selector = '#field_' + field_id;
    	
    	if(dlayer.preview.form.changed == true) {
			dlayer.preview.form.fn.highlight(selector);
    	}
    });
}

/** 
* Preview function for row background styling color, changes the background 
* color as the user move focus from the field.
* 
* @param integer field_id Id of the field being edited
* @param string value Initial value for the background color
* @param boolean optional If the value is optional the user should be able to clear 
				  the value, shouldn't default to initial value, if not set 
				  defaults to false	
* @return void
*/
dlayer.preview.form.fn.row_background_color = function(field_id, value, 
optional) 
{
	if(typeof optional == 'undefined') { optional = false }
	
	$('#params-background_color').change(function() 
	{
	    var new_value = this.value;
	    
	    if(new_value.length == 7) {	    	
	    	$('.row_' + field_id).css('background-color', new_value);
			dlayer.preview.form.changed = true;
	    } else {
	    	if(new_value.length == 0) {
	    		$('.row_' + field_id).css('background-color', 'inherit');
	    		dlayer.preview.form.changed = true;
			}
	    }
	    
	    dlayer.preview.form.fn.unsaved();
	});
}

/**
* Preview function for field attributes, updates the attribute value in the 
* Form builder as the user changes the value. Unlike the string version of the 
* method this checks for an integer value and only fires onchange.
* 
* @param integer field_id Id of the field being edited
* @param string attribute Field attribute being updated
* @param string field_attribute Element attribute that is being updated
* @param string value Initial value for the text string
* @param boolean optional If the value is optional the user should be able to clear 
				  the value, shouldn't default to initial value, if not set 
				  defaults to false	
* @return void
*/
dlayer.preview.form.fn.field_attribute_integer = function(field_id, attribute, 
field_attribute, value, optional) 
{
	if(typeof optional == 'undefined') { optional = false }
		
	$('#params-' + attribute).change(function() 
	{
		dlayer.preview.form.highlight = true;
		var selector = '#field_' + field_id;
	    var new_value = parseInt(this.value, 10);
	    var current_value = parseInt(
	    $(selector).attr(field_attribute), 10);
	    
	    if(new_value != NaN && 
	    current_value != NaN && 
	    new_value != current_value && 
	    new_value > 0) {
	        $(selector).attr(field_attribute, new_value);
	        dlayer.preview.form.fn.highlight(selector);
	        dlayer.preview.form.changed = true;
	    } else {
			if(optional == false) {
				$(selector).attr(field_attribute, value);
				$('#params-' + attribute).val(value);
			} else {
				$(selector).attr(field_attribute, '');
				$('#params-' + attribute).val('');
				dlayer.preview.form.fn.highlight(selector);
				dlayer.preview.form.changed = true;
			}
	    }
	    
	    dlayer.preview.form.fn.unsaved();
	});
}

/**
* Display a message if any data has changed and not yet been saved
* 
* @return void
*/
dlayer.preview.form.fn.unsaved = function() 
{
	if(dlayer.preview.form.visible == false) {
		if(dlayer.preview.form.changed == true) {
			$('p.unsaved').show('medium');
			dlayer.preview.form.visible = true;
		}				
	}
}

/**
* Add a hightlight to the element that has just been changed
* 
* @param string selector Element selector
* @param integer time Length for effect, defaults to 500 if not set
* @return void
*/
dlayer.preview.form.fn.highlight = function(selector, time) 
{
	if(typeof time == 'undefined') { time = 400 }
	
	if(dlayer.preview.form.highlight == true) {
		$(selector).effect("highlight", {}, time);
	}
}