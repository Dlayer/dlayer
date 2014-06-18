/**
* Javascript required for the form builder settings
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development limited
* @version $Id: settings.js 1306 2013-12-01 12:21:22Z Dean.Blackborough $
*/

dlayer.settings.form = {}
dlayer.settings.form.fn = {}

dlayer.settings.form.font_families = [];

/**
* Update the font family for the preview paragraphs
* 
* @param integer font_family
* @return void
*/
dlayer.settings.form.fn.preview_font_families = function(font_family_id) 
{
    $('.font_preview > p.switch').css('font-family', 
    dlayer.settings.form.font_families[font_family_id]);
}