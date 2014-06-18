/**
* Javascript required for the content settings
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development limited
* @version $Id: settings.js 913 2013-09-16 15:57:30Z Dean.Blackborough $
*/

dlayer.settings.content = {}
dlayer.settings.content.fn = {}

dlayer.settings.content.font_styles = [];
dlayer.settings.content.font_weights = [];
dlayer.settings.content.font_decorations = [];
dlayer.settings.content.font_families = [];

/**
* Update the heading preview based on the font style selected in the 
* select menu
* 
* @param integer heading_id
* @param integer font_style_id
* @return void
*/
dlayer.settings.content.fn.preview_font_styles = function(heading_id, 
font_style_id) 
{
    $('#preview_' + heading_id + ' > h2').css('font-style', 
    dlayer.settings.content.font_styles[font_style_id]);
}

/**
* Update the heading preview based on the font weight selected in the 
* select menu
* 
* @param integer heading_id
* @param integer font_weight_id
* @return void
*/    
dlayer.settings.content.fn.preview_font_weights = function(heading_id, 
font_weight_id) 
{
    $('#preview_' + heading_id + ' > h2').css('font-weight', 
    dlayer.settings.content.font_weights[font_weight_id]);
}

/**
* Update the heading preview based on the font decoration selected in the 
* select menu
* 
* @param integer heading_id
* @param integer font_decoration_id
* @return void
*/
dlayer.settings.content.fn.preview_font_decorations = function(heading_id, font_decoration_id) 
{
    $('#preview_' + heading_id + ' > h2').css('text-decoration', 
    dlayer.settings.content.font_decorations[font_decoration_id]);
}

/**
* Update the heading preview based on the font size in the input
* 
* @param integer heading_id
* @param integer size
* @return void
*/
dlayer.settings.content.fn.preview_font_sizes = function(heading_id, size) 
{
    var font_size = parseInt(size);
    
    if(font_size >= 6 && font_size <= 72) {
        $('#preview_' + heading_id + ' > h2').css('font-size', size);
    }
}

/**
* Update the heading preview based on the font colour in the input
* 
* @param integer heading_id
* @param string color
* @return void
*/
dlayer.settings.content.fn.preview_font_colors = function(heading_id, color) 
{
    var regex = /^(#)([0-9a-fA-F]{3})([0-9a-fA-F]{3})?$/;
    
    if(regex.test(color) == true) {    
        $('#preview_' + heading_id + ' > h2').css('color', color);
    }
}

/**
* Update the font family for the preview paragraphs
* 
* @param integer font_family
* @return void
*/
dlayer.settings.content.fn.preview_font_families = function(font_family_id) 
{
    $('.font_preview > p.switch').css('font-family', 
    dlayer.settings.content.font_families[font_family_id]);
}