/**
* Javascript required for the content manager tools
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development limited
* @version $Id: tools.js 1949 2014-06-16 00:34:49Z Dean.Blackborough $
*/

dlayer.tools.content = {}
dlayer.tools.content.fn = {}

/**
* AJAX for import text select, fetches the json based on the chosen option 
* and then passes the data to the name and content fields
* 
* @type Object
*/
dlayer.tools.content.fn.import_text = function() 
{	
	$('form #select_imported_text').change(function() 
	{
		var data_id = $('form #select_imported_text').val();
		
		if(data_id != 0) {		
			$.getJSON('/content/ajax/import-text', 
			{ data_id: data_id }, 
			function(data) {
				
				if(data.data == true) {
					console.log(data);
					$('form #params-content').val(data.content);
					$('form #params-name').val(data.name);
				} else {
					var error = 
					'There was an error importing the selected text.';
					$('form #params-content').val(error);
				}
			});
		} else {
			$('form #params-content').val('Select an option above.');
		}
	});
}

/**
* AJAX for import heading select, fetches the json based on the chosen option 
* and then passes the data to the name and content fields
* 
* @type Object
*/
dlayer.tools.content.fn.import_heading = function() 
{	
	$('form #select_imported_text').change(function() 
	{
		var data_id = $('form #select_imported_text').val();
		
		if(data_id != 0) {		
			$.getJSON('/content/ajax/import-heading', 
			{ data_id: data_id }, 
			function(data) {
				
				if(data.data == true) {
					console.log(data);
					$('form #params-heading').val(data.content);
					$('form #params-name').val(data.name);
				} else {
					var error = 
					'There was an error importing the selected text.';
					$('form #params-heading').val(error);
				}
			});
		} else {
			$('form #params-heading').val('Select an option above.');
		}
	});
}