/**
* Dlayer javascript object, contains all the custom js fucntions required 
* by Dlayer 
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development limited
*/
var contents = null;

var dlayer = {
	
	debug: debug,

	/**
	* Convert the rgb value in a hex for the inputs
	*
	* @returns {String|false}
	*/
	rgbToHex: function(colorStr)
	{		
		if(colorStr != 'rgba(0, 0, 0, 0)') {
			var hex = '#';
			$.each(colorStr.substring(4).split(','), function(i, str){
				var h = ($.trim(str.replace(')',''))*1).toString(16);
				hex += (h.length == 1) ? "0" + h : h;
			});
		} else {
			hex = false;
		}
		
		return hex;
	},
	
	ribbon: {
		
		tabs: {
			/**
			* Adds click events for the ribbon tabs, on click sets the
			* selected tab as active and then calls a function to make an
			* AJAX call for the tab content
			* 
			* @todo Need to clean this method up, duplication added when 
			* updated to deal with tab switching after preview functions called
			*
			* @param {String} Module that the function is being called from
			* @param {string} The name of the selected tool, used by the
							  AJAX function for validation purposes
			* @returns {Void}
			*/
			clicks: function(module, tool) {
				$('#ribbon .nav-tabs > li').click(
					function() {
						/* Only switch if the tab is not already selected */
						if($(this).hasClass('selected') == false) {			                
							if(dlayer.preview.changed == true) {
							   $('#ribbon .nav-tabs > li').removeClass('active');
							   $(this).addClass('active');

							   var tab = this.id.replace('tab_', '');

							   $('#ribbon > .content').removeClass('open');
							   $('#tab_content_' + tab).addClass('open');
							   
							   dlayer.ribbon.tabs.content(tab, tool, 
							   module, true);
							} else {
							   $('#ribbon .nav-tabs > li').removeClass('active');
							   $(this).addClass('active');
							   
							   var tab = this.id.replace('tab_', '');
							   
							   $('#ribbon > .content').removeClass('open');
							   $('#tab_content_' + tab).addClass('open');
							
							   dlayer.ribbon.tabs.content(tab, tool, module);
							}
						}
					}
				);
			},
			
			/**
			* Load the content for the selected tool and tab
			*
			* @param {String} Name of the tool tab
			* @param {String} Name of the tool
			* @param {String} Name of the module, ribbon-tab-html is always
			*				  part of the design controller in the requested
			*				  module
			* @param {Boolean} Release
			* @returns {Void}
			*/
			content: function(tab, tool, module, reload)
			{
				if(typeof reload == 'undefined') { reload = false; }
				
				$.post('/' + module + '/design/ribbon-tab-html',
					   { tab: tab,
						 tool: tool },
					   function(data) {
						   $('#tab_content_' + tab).html(data);
						   $('#color_picker').hide();
						   if(reload == true) {
							   window.location.replace(
							   '/' + module + '/design/');                               
						   }
					   },
					   'html');
			}
		}
	},
	tools: {
		
		template: {
			
			fn: {
				
				/**
				* Horizontal split, visual representation of where the split
				* will occur, user needs to click for the request to be sent
				* to the tool model
				*
				* @returns {Void}
				*/
				horizontalSplit: function()
				{
					var div = $('div.template-designer div.selected');

					var x = div.width();
					var y = div.height();

					background_color = div.css('background-color');
					div.css('backgroundColor', '#000000');
					div.addClass('tool-horizontal-split');

					if(contents == null) {
						contents = div.html();
					}

					$('div.template-designer div.selected').mousemove(function(e)
					{
						var split_position = e.pageY - this.offsetTop;

						if(split_position < y && split_position > 0) {
							var split_box =
							'<div class="horizontal-splitter" style="width:' +
							x + 'px; height:' + split_position + 'px;"></div>';

							div.html(split_box);

							dlayer.tools.template.fn.splitInfo(
							split_position, y-split_position);
						}
					});

					$('div.template-designer div.selected').click(function(e)
					{
						var split_position = e.pageY - this.offsetTop;

						// Get the dimensions of the current select div
						var x = $('div.template-designer div.selected').width();
						var y = $('div.template-designer div.selected').height();

						if(split_position < y && split_position > 0) {
							$.post('/template/process/tool',
							   { tool: 'split-horizontal',
								 id: this.id,
								 params: { x: x,
										   y_1: split_position,
										   y_2: y-split_position }
							   },
							   function() {
								   if(debug == 0) {
									   window.location.replace(
									   '/template/design/');
								   }
							   }
							);
						}

						console.log('Div split horizontally');
					});
				},
				
				/**
				* Vertical split, visual representation of where the split
				* will occur, user needs to click for the request to be sent
				* to the tool model
				*
				* @returns {Void}
				*/
				verticalSplit: function()
				{
					var div = $('#template div.selected');

					var x = div.width();
					var y = div.height();

					background_color = div.css('background-color');
					div.css('backgroundColor', '#000000');				    

					if(contents == null) {
						contents = div.html();
					}

					$('#template div.selected').mousemove(function(e)
					{
						var split_position = e.pageX - this.offsetLeft;

						if(split_position < x && split_position > 0) {
							var split_box =
							'<div class="vertical_splitter" style="width:' +
							(split_position) + 'px; height:' + y + 'px;"></div>';

							div.html(split_box);

							dlayer.tools.template.fn.splitInfo(
							split_position, x-split_position);
						}
					});

					$('#template div.selected').click(function(e)
					{
						var split_position = e.pageX - this.offsetLeft;

						// Get the dimensions of the current select div
						var x = $('#template div.selected').width();
						var y = $('#template div.selected').height();

						if(split_position < x && split_position > 0) {
							$.post('/template/process/tool',
							   { tool: 'split-vertical',
								 id: this.id,
								 params: { x_1: split_position,
										   x_2: x-split_position,
										   y: y }
							   },
							   function() {
								   if(debug == 0) {
									   window.location.replace(
									   '/template/design/');
								   }
							   }
							);
						}

						console.log('Div split vertically');
					});
				},
				
				/**
				* Reset function for the split tools
				*
				* @returns {Void}
				*/
				splitReset: function()
				{
					if(contents != null) {
						$('div.template-designer div.selected').unbind('mousemove');
						$('div.template-designer div.selected').unbind('click');
						var div = $('div.template-designer div.selected');
						div.css('background-color', background_color);
						div.html(contents);
						div.removeClass('tool-horizontal-split');
					}
				},
				
				/**
				* Update the info block with sizes for each of the blocks
				* based on where the split line is
				*
				* @param {Integer} Block one width
				* @param {Integer} Block two width
				* @returns {Void}
				*/
				splitInfo: function(one, two)
				{
					$('p.advanced-info').show();
					$('p.advanced-info .one').html(one);
					$('p.advanced-info .two').html(two);
				}
			}
		},
		
		content: {
			
			fn: {
				
				/**
				* Ajax for the import text tool, when a user selects an option 
				* on the import text menu the content for the selected 
				* data is copied into the relevant fields.
				* 
				* The name for the content item is also copied, just in case 
				* the user makes a change to the import content
				* 
				* @returns {Void}
				*/
				import_text: function()
				{
					$('form #select_imported_text').change(function()
					{
						var id = $('form #select_imported_text').val();

						if(id != 0) {
							$.getJSON('/content/ajax/import-text',
							{ id: id },
							function(data) {

								if(data.data == true) {
									$('form #params-text').val(data.text);
									$('form #params-name').val(data.name);
									$('form #params-text').effect('highlight');
								} else {
									var error = 'There was an error selecting the ' + 
									'text content from the system.';
									$('form #params-text').val(error);
									$('form #params-name').val('');
									$('form #params-text').effect('highlight', 
										{ color: '#c9302c' });
								}
							});
						} else {
							$('form #params-text').val('Select an existing ' + 
							'piece of content using the select menu above.');
							$('form #params-name').val('');
							$('form #params-text').effect('highlight', 
								{ color: '#c9302c' });
						}
					});
				},
				
				/**
				* Ajax for the import heading tool, when a user selects an 
				* option on the import heading menu the content for the 
				* selected data is copied into the relevant fields
				* 
				* The name for the content item is also copied, just in case 
				* the user makes a change to the import content
				* 
				* @returns {Void}
				*/
				import_heading: function()
				{
					$('form #select_imported_text').change(function()
					{
						var id = $('form #select_imported_text').val();

						if(id != 0) {
							$.getJSON('/content/ajax/import-heading',
							{ id: id },
							function(data) {

								if(data.data == true) {
									$('form #params-heading').val(
										data.heading);
									$('form #params-sub_heading').val(
										data.sub_heading);
									$('form #params-name').val(data.name);
									$('form #params-heading').effect(
										'highlight');
									$('form #params-sub_heading').effect(
									'highlight');
								} else {
									var error = 'There was an error ' + 
									'selecting the text content from the ' + 
									'system.';
									$('form #params-heading').val(error);
									$('form #params-sub_heading').val(error);
									$('form #params-name').val('');
									$('form #params-heading').effect(
										'highlight', { color: '#c9302c' });
									$('form #params-sub_heading').effect(
										'highlight', { color: '#c9302c' });
								}
							});
						} else {
							var error = 'Select an existing piece of ' + 
							'content using the select menu above.'
							
							$('form #params-heading').val(error);
							$('form #params-sub_heading').val(error);
							$('form #params-name').val('');
							$('form #params-heading').effect('highlight', 
								{ color: '#c9302c' });
							$('form #params-sub_heading').effect('highlight', 
								{ color: '#c9302c' });
						}
					});
				},
				
				/**
				* AJAX for the import form tool, fetches the minimum width for 
				* the selected form and then depending on the result and 
				* the width of the content container updates the tool form
				* 
				* @param {Integer} Page container width
				* @returns {Void}
				*/
				import_form: function(page_container_width) 
				{
					$('form #params-form_id').change(function()
					{
						var data_id = $('form #params-form_id').val();
						$('form p.validation').hide();

						if(data_id != 0) {
							$.getJSON('/content/ajax/form-minimum-width',
							{ data_id: data_id },
							function(data) {
								var enable = false;
								
								if(data.data == true) {
									if(data.width <= page_container_width) {
										enable = true;
									}
								}
								
								if(enable == true) {
									$('form #submit').removeAttr('disabled');
								} else {
									$('form #submit').attr('disabled', 
									'disabled');
									$('p.validation').show();
								}                                
							});
						} else {
							$('form #submit').attr('disabled', 'disabled');
							$('p.validation').hide();
						}
					});
				}, 
				
				/**
				* Ajax for the import jumbotron tool, when a user selects an 
				* option on the import jumbotron menu the content for the 
				* selected data is copied into the relevant fields
				* 
				* The name for the content item is also copied, just in case 
				* the user makes a change to the imported content
				* 
				* @returns {Void}
				*/
				import_jumbotron: function()
				{
					$('form #select_imported_text').change(function()
					{
						var id = $('form #select_imported_text').val();

						if(id != 0) {
							$.getJSON('/content/ajax/import-jumbotron',
							{ id: id },
							function(data) {

								if(data.data == true) {
									$('form #params-title').val(data.title);
									$('form #params-sub_title').val(
										data.sub_title);
									$('form #params-name').val(data.name);
									$('form #params-title').effect('highlight');
									$('form #params-sub_title').effect('highlight');
								} else {
									var error = 'There was an error ' + 
									'selecting the text content from the ' + 
									'system.';
									$('form #params-title').val(error);
									$('form #params-sub_title').val(error);
									$('form #params-name').val('');
									$('form #params-title').effect(
										'highlight', { color: '#c9302c' });
									$('form #params-sub_title').effect(
										'highlight', { color: '#c9302c' });
								}
							});
						} else {
							var error = 'Select an existing piece of ' + 
							'content using the select menu above.'
							
							$('form #params-title').val(error);
							$('form #params-sub_title').val(error);
							$('form #params-name').val('');
							$('form #params-title').effect('highlight', 
								{ color: '#c9302c' });
							$('form #params-sub_title').effect('highlight', 
								{ color: '#c9302c' });
						}
					});
				},
				
				/**
				* Highlights the content area selected in the menu
				* 
				* @returns {Void}
				*/
				move_row: function() 
				{
					$('form #params-content_area_id').change(function()
					{
						var id = $('form #params-content_area_id').val();
						
						if(id != 0) {
							$('#template_div_' + id).effect('highlight', 2000);
						}
					});
				},
				
				/**
				* Highlights the content row selected in the menu
				* 
				* @returns {Void}
				*/
				move_item: function() 
				{
					$('form #params-new_content_row_id').change(function()
					{
						var id = $('form #params-new_content_row_id').val();
						
						if(id != 0) {
							$('#content_row_' + id).effect('highlight', 2000);
						}
					});
				}
			}
		}, 
		
		image: {
			
			fn: {
				
				/**
				* AJAX for filter selected, updates the sub categories select
				* based on the selected category
				*
				* @returns {Void}
				*/
				sub_categories_filter: function()
				{
					$('#category_filter').change(function()
					{
						var data_id = $('#category_filter').val();

						$.getJSON('/image/ajax/sub-categories',
						{ category_id: data_id },
						function(data) {
							
							$('#sub_category_filter').empty(); 
							
							$.each(data.sub_categories, function(i, value) {
								$('#sub_category_filter').append($('<option>').text(value.value).attr('value', value.id));
							});
						});
					});
				},
				
				/**
				* AJAX for categories selecte on Add to library tool, populates 
				* the sub categories select based on category selected
				*
				* @returns {Void}
				*/
				sub_categories: function()
				{
					$('#params-category').change(function()
					{
						var data_id = $('#params-category').val();
						
						$.getJSON('/image/ajax/sub-categories',
						{ category_id: data_id, 
						  all: 0 },
						function(data) {
							
							$('#params-sub_category').empty(); 
							
							$.each(data.sub_categories, function(i, value) {
								$('#params-sub_category').append($('<option>').text(value.value).attr('value', value.id));
							});
						});
					});
				}
			}
		}
	},
	
	preview: {
		
		changed: false,
		
		visible: false,
		
		highlight: false,
		
		/**
		* Convert newlines to breaks
		* 
		* @return {String}
		*/
		nl2br: function(value) 
		{
			return value.replace(/\n/g, "<br />");
		},
		
		/**
		* Display a message if any data has changed and not yet been
		* saved
		*
		* @returns {Void}
		*/
		unsaved: function()
		{
			if(dlayer.preview.visible == false) {
				if(dlayer.preview.changed == true) {
					$('p.unsaved').show('medium');
					dlayer.preview.visible = true;
				}
			}
		},
		
		/**
		* Add a highlight to the item that has just been changed
		*
		* @param {String Element selector
		* @param {Integer} Length for effect, defaults to 500 if not set
		* @returns {Void}
		*/
		highlightItem: function(selector, time)
		{
			if(typeof time == 'undefined') { time = 400 }

			if(dlayer.preview.highlight == true) {
				$(selector).effect("highlight", {}, time);
			}
		},
		
		content: {
			
			fn: {
				
				/** 
				* Preview function which updates the text for an element, 
				* 
				* @param {Object} The json containing all the values 
				* 	required. The names in the array are content_selector, 
				* 	container_selector and initial value
				* @param {String} The selector for the tool form field, this is 
				* 	the tool field that contains the content
				* @param {Boolean} Is the value optional, if yes the user can 
					the value other it resets the value to default
				* @return {Void}
				*/
				elementText: function(options, field_selector, optional) 
				{
					// Set optional if not set					
					if(typeof optional == 'undefined') { optional = false }
					
					// Set highlight to true, only called once for onkey up
					dlayer.preview.highlight = true;
					
					/**
					* Update the value on keyup, reset to default if optional 
					* is set to false and tool field is cleared
					*/					
					$(field_selector).keyup(function()
					{
						var current_value = $(options.content_selector).text();

						if(this.value.trim().length > 0) {
							if(this.value.trim() != current_value) {
								$(options.content_selector).html(
									dlayer.preview.nl2br(this.value.trim()));
								dlayer.preview.highlightItem(
									options.container_selector, 1500);
								dlayer.preview.highlight = false;
								dlayer.preview.changed = true;
							}
						} else {
							if(optional == false) {
								$(options.content_selector).html(
									dlayer.preview.nl2br(
									options.initial_value));
								$(field_selector).val(options.initial_value);
							} else {
								$(options.content_selector).html('');
								$(field_selector).val('');
								dlayer.preview.highlight = true;
								dlayer.preview.highlightItem(
									options.container_selector);
								dlayer.preview.changed = true;
							}
							
						}

						dlayer.preview.unsaved();
					});
					
					/**
					* Highlight the content item on blue if the value has been 
					* changed
					*/
					$(field_selector).blur(function()
					{
						dlayer.preview.highlight = true;

						if(dlayer.preview.changed == true) {
							dlayer.preview.highlightItem(
								preview.container_selector, 1500);
						}
					});
				},
				
				/** 
				* Preview function which updates the text for an element, 
				* this method will not add BR tags into the content as per the 
				* elementText function. 
				* 
				* @param {Object} The json containing all the values 
				* 	required. The names in the array are content_selector, 
				* 	container_selector and initial value
				* @param {String} The selector for the tool form field, this is 
				* 	the tool field that contains the content
				* @param {Boolean} Is the value optional, if yes the user can 
				*	the value other it resets the value to default
				* @todo THis method doesn't need to be its own functrion, BR 
				* 	setting should be a param 
				* @return {Void}
				*/
				elementTextNoBr: function(options, field_selector, optional) 
				{
					// Set optional if not set					
					if(typeof optional == 'undefined') { optional = false }
					
					// Set highlight to true, only called once for onkey up
					dlayer.preview.highlight = true;
					
					/**
					* Update the value on keyup, reset to default if optional 
					* is set to false and tool field is cleared
					*/					
					$(field_selector).keyup(function()
					{
						var current_value = $(options.content_selector).text();

						if(this.value.trim().length > 0) {
							if(this.value.trim() != current_value) {
								$(options.content_selector).html(
									this.value.trim());
								dlayer.preview.highlightItem(
									options.container_selector, 1500);
								dlayer.preview.highlight = false;
								dlayer.preview.changed = true;
							}
						} else {
							if(optional == false) {
								$(options.content_selector).html(
									options.initial_value);
								$(field_selector).val(options.initial_value);
							} else {
								$(options.content_selector).html('');
								$(field_selector).val('');
								dlayer.preview.highlight = true;
								dlayer.preview.highlightItem(
									options.container_selector);
								dlayer.preview.changed = true;
							}
							
						}

						dlayer.preview.unsaved();
					});
					
					/**
					* Highlight the content item on blue if the value has been 
					* changed
					*/
					$(field_selector).blur(function()
					{
						dlayer.preview.highlight = true;

						if(dlayer.preview.changed == true) {
							dlayer.preview.highlightItem(
								preview.container_selector, 1500);
						}
					});
				},
				
				/** 
				* Preview function which updates the heading text for a content 
				* item, acts differently to the base element text method 
				* because the he content is html, includes small tag so need 
				* to incorporate it
				* 
				* @param {Object} The json containing all the values 
				* 	required. The names in the array are content_selector, 
				* 	container_selector and initial value
				* @param {String} The selector for the tool form field, this is 
				* 	the tool field that contains the content
				* @param {Boolean} Is the value optional, if yes the user can 
					the value other it resets the value to default
				* @return {Void}
				*/
				headingText: function(preview, field_selector, optional) 
				{
					// Set optional if not set					
					if(typeof optional == 'undefined') { optional = false }
					
					// Set highlight to true, only called once for onkey up
					dlayer.preview.highlight = true;
					
					/**
					* Update the value on keyup, reset to default if optional 
					* is set to false and tool field is cleared
					*/					
					$(field_selector).keyup(function()
					{
						// Fetch current sub heading text content						
						var sub_heading_value = 
							$(preview.content_selector_sub_heading).text();
							
						// Strip sub heading from fetched text
						var current_value = 
							$(preview.content_selector).text().replace(
							sub_heading_value, '');

						if(this.value.trim().length > 0) {
							if(this.value.trim() != current_value) {
								$(preview.content_selector).html(
								this.value.trim() + ' <small>' + 
								sub_heading_value + '</small>');
								dlayer.preview.highlightItem(
									preview.container_selector, 1500);
								dlayer.preview.highlight = false;
								dlayer.preview.changed = true;
							}
						} else {
							if(optional == false) {
								$(preview.content_selector).html(
									preview.initial_value + ' <small>' + 
									sub_heading_value + '</small>');
								$(field_selector).val(preview.initial_value);
							} else {
								$(preview.content_selector).html(
									'<small></small>');
								$(field_selector).val('');
								dlayer.preview.highlight = true;
								dlayer.preview.highlightItem(
									preview.container_selector);
								dlayer.preview.changed = true;
							}
							
						}

						dlayer.preview.unsaved();
					});
					
					/**
					* Highlight the content item on blue if the value has been 
					* changed
					*/
					$(field_selector).blur(function()
					{
						dlayer.preview.highlight = true;

						if(dlayer.preview.changed == true) {
							dlayer.preview.highlightItem(
								preview.container_selector, 1500);
						}
					});
				},
				
				/** 
				* Preview function which updates the size of a content item, as 
				* in updates the bootstrap column class for the container
				* 
				* @param {Integer} The id of the content container
				* @param {String} The selector for the tool form field that 
				* 	contains the width value
				* @param {String} The bootstrap column class size, either sm, 
					xs, md or lg
				* @return {Void}
				*/
				containerWidth: function(content_id, field_selector_width, 
					bootstrap_column_size)  
				{
					// Set column class if not set
					if(typeof bootstrap_column_size == 'undefined') { 
						bootstrap_column_size = 'md' 
					}
					
					$(field_selector_width).change(function()
					{
						var process = false;
												
						var bootstrap_class = 'col-' + 
							bootstrap_column_size + '-';
						var bootstrap_offset_class = 'col-' + 
							bootstrap_column_size + '-offset-';
						var new_width = parseInt(this.value, 10);
						
						var designer_width = 12;
												
						var class_list = $(
							'.content-container-' + content_id).attr(
							'class').split(/\s+/);
							
						var size_pattern = 'col-' + bootstrap_column_size + 
							'-(\\d+)';
							
						var offset_pattern = 'col-' + bootstrap_column_size + 
							'-offset-(\\d+)';
						
						var size = dlayer.preview.content.helper.pullSizeFromClass(
							content_id, size_pattern, bootstrap_class);
												
						var offset = dlayer.preview.content.helper.pullSizeFromClass(
							content_id, offset_pattern, bootstrap_offset_class);
						
						if(size.process == true && offset.process == true) {							
							if(new_width != size.size && 
								(new_width + offset.size) <= 12) {
									
								$('.content-container-' + content_id).removeClass(
								bootstrap_class + size.size).addClass(
								bootstrap_class + new_width);
							} else {
								$(field_selector_width).val(12-offset.size);
							}
							
							dlayer.preview.highlight = true;
							dlayer.preview.highlightItem(
								'.content-container-' + content_id);
							dlayer.preview.changed = true;
						}
						
						dlayer.preview.unsaved();
					});
				}, 
				
				/** 
				* Preview function which updates the offset for a content 
				* item, as in updates the bootstrap offset column class for 
				* the container
				* 
				* @param {Integer} The id of the content container
				* @param {String} The selector for the tool form field that 
				* 	contains the offset value
				* @param {String} The bootstrap column class size, either sm, 
					xs, md or lg
				* @return {Void}
				*/
				containerOffset: function(content_id, field_selector_offset, 
					bootstrap_column_size)  
				{
					// Set column class if not set
					if(typeof bootstrap_column_size == 'undefined') { 
						bootstrap_column_size = 'md' 
					}
					
					$(field_selector_offset).change(function()
					{
						var process = false;
												
						var bootstrap_class = 'col-' + 
							bootstrap_column_size + '-';
						var bootstrap_offset_class = 'col-' + 
							bootstrap_column_size + '-offset-';
						var new_offset = parseInt(this.value, 10);
						
						var designer_width = 12;
												
						var class_list = $(
							'.content-container-' + content_id).attr(
							'class').split(/\s+/);
							
						var size_pattern = 'col-' + bootstrap_column_size + 
							'-(\\d+)';
							
						var offset_pattern = 'col-' + bootstrap_column_size + 
							'-offset-(\\d+)';
						
						var size = dlayer.preview.content.helper.pullSizeFromClass(
							content_id, size_pattern, bootstrap_class);
												
						var offset = dlayer.preview.content.helper.pullSizeFromClass(
							content_id, offset_pattern, bootstrap_offset_class);
						
						if(offset.process == true && size.process == true) {
							if(new_offset != offset.size && 
								(new_offset + size.size) <= 12) {
									
								$('.content-container-' + content_id).removeClass(
								bootstrap_offset_class + offset.size).addClass(
								bootstrap_offset_class + new_offset);
							} else {
								$(field_selector_offset).val(12-size.size);
							}
							
							dlayer.preview.highlight = true;
							dlayer.preview.highlightItem(
								'.content-container-' + content_id);
							dlayer.preview.changed = true;
						}
						
						dlayer.preview.unsaved();
					});
				}, 
				
				/**
				* Preview function which updates the background colour for the 
				* requested page element
				*
				* @param {String} Selector for the element being affected
				* @param {String} Selector for the tool form field
				* @returns {Void}
				*/
				elementBackgroundColor: function(element_selector, 
					field_selector)
				{
					$(field_selector).change(function()
					{
						var new_value = this.value;
						
						console.log(new_value);
						console.log($(element_selector));
						$(element_selector).css('background-color', 
								new_value);

						if(new_value.length == 7) {
							$(element_selector).css('background-color', 
								new_value);
							dlayer.preview.changed = true;
						} else {
							if(new_value.length == 0) {
								$(element_selector).css('background-color', 
									'inherit');
								dlayer.preview.changed = true;
							}
						}

						dlayer.preview.unsaved();
					});
				},
			}, 
			
			helper: {
				
				/**
				* Searches the classes assigned to an element, finds the one 
				* that matches the regex pattern and then pulls the size value 
				* from the matched class
				* 
				* @param {Integer} The id for the content item
				* @param {String} The pattern for the regex
				* @param {String} Partial bootstrap classname to pull size from
				* @return {Object}
				*/
				pullSizeFromClass: function(content_id, pattern, 
					bootstrap_class) 
				{
					var class_list = $(
						'.content-container-' + content_id).attr(
						'class').split(/\s+/);
					
					var result = { process: false, size: 0 }
												
					$.each(class_list, function(index, item) {
						
						matched = item.match(new RegExp(pattern));
						
						console.log(matched);
						
						if(matched != null) {
							var current_bootstrap_class = matched[0];
							
							result.size = parseInt(
								current_bootstrap_class.replace(
								bootstrap_class, ''), 10);
							result.process = true;
						}
					});
					
					return result;
				}
			}
		},
		
		contentOld: {
			
			fn: {
				
				/**
				* Preview function for content container background color,
				* changes the background color as the user move focus from
				* the field.
				*
				* @param {Integer} Id of the content item container being edited
				* @param {String} Initial value for the background color
				* @param {Boolean} If the value is optional the user should be
								   able to clear the value, shouldn't default
								   to initial value, if not set, defaults to
								   false
				* @return void
				*/
				container_background_color: function(content_id,
				value, optional)
				{
					if(typeof optional == 'undefined') { optional = false }

					$('#params-background_color').change(function()
					{
						var selector = '.c-item-' + content_id;
						var new_value = this.value;
						dlayer.preview.highlight = true;

						if(new_value.length == 7) {
							$(selector).css('background-color', new_value);
							dlayer.preview.changed = true;
						} else {
							if(new_value.length == 0) {
								$(selector).css('background-color', 'inherit');
								dlayer.preview.changed = true;
							}
						}

						dlayer.preview.unsaved();
					});
				},
				
				/**
				* Preview function for content container width changes.
				* Updates the width of the content container to the selected
				* width whilst also checking to ensure that the combined value
				* of the width and all other attributes doesn't exceed the
				* usable size of the page container
				*
				* @param {Integer} Id of the content item
				* @param {Integer} Usable width of the page container
				* @param {Integer} Current width of the content item, this 
								   is the value we reset to if invalid value 
								   supplied, this value will be checked against 
								   the current value in designer incase another 
								   preview method has modified it 
				* @param {Object} Other attributes that affect container
								  width, for example paddings, borders and
								  margins
				* @returns {Void}
				*/
				container_width: function(content_id, page_container_width,
				width, attributes)
				{
					$('#params-width').change(function() {
						
						var new_width = parseInt(this.value, 10);
						var selector = '.c-item-' + content_id;
						dlayer.preview.highlight = true;

						if(new_width != NaN && new_width > 0) {
							
							// Check padding values in designer in case they 
							// have been modified by other preview methods
							attributes.paddings.left = dlayer.preview.
							content.fn.check_client_attribute_value(selector, 
							'padding-left', attributes.paddings.left);
							
							attributes.paddings.right = dlayer.preview.
							content.fn.check_client_attribute_value(selector, 
							'padding-right', attributes.paddings.right);
						   
							var total_width = new_width +
							attributes.paddings.left +
							attributes.paddings.right +
							attributes.margins.left +
							attributes.margins.right;
							var container_width = new_width;

							if(total_width <= page_container_width) {
								dlayer.preview.content.fn.
								set_content_item_widths(selector, total_width,
								container_width);
								
								dlayer.preview.highlightItem(selector, 1500);
								dlayer.preview.changed = true;
							} else {
								// Check width value in designer in case 
								// it has been modified by other preview 
								// methods
								width = dlayer.preview.content.fn.
								check_client_attribute_value(selector, 
								'width', width);
								
								// Trigger change event when value reset
								$('#params-width').val(width).trigger('change');
								dlayer.preview.changed = true;
							}
						}
						
						dlayer.preview.unsaved();
					});
				},

				/**
				* Preview function for content container padding changes, used 
				* when the same padding value is being used around the entire 
				* container.
				* 
				* Updates the padding of the content container to the selected
				* values whilst also checking to ensure that the combined
				* value of the padding and all other attrbiutes doesn't exceed
				* the usable size of the page container
				*
				* @param {Integer} Id of the content item
				* @param {Integer} Usable width of the page container
				* @param {Integer} Current padding value for the content item
				* @param {Object} Other attributes that affect container
								  width, for example width, borders and
								  margins
				* @returns {Void}
				*/
				container_padding: function(content_id, page_container_width,
				padding, attributes)
				{
					$('#params-padding').change(function() {
						
						var new_padding = parseInt(this.value, 10);
						var selector = '.c-item-' + content_id;
						dlayer.preview.highlight = true;

						if(new_padding != NaN && new_padding >= 0) {
							
							// Check width value in designer in case 
							// it has been modified by other preview methods                            
							attributes.width = dlayer.preview.content.fn.
							check_client_attribute_value(selector, 'width', 
							attributes.width);
							
							var total_width = (new_padding * 2) +
							attributes.margins.left +
							attributes.margins.right +
							attributes.width;
							var container_width = attributes.width;

							if(total_width <= page_container_width) {
								dlayer.preview.content.fn.
								set_content_item_padding(selector, new_padding);
								dlayer.preview.content.fn.
								set_content_item_widths(selector, total_width,
								container_width);

								dlayer.preview.highlightItem(selector);
								dlayer.preview.changed = true;
							} else {
								// Check padding value in designer in case 
								// it has been modified by other preview 
								// methods
								padding = dlayer.preview.content.fn.
								check_client_attribute_value(selector, 
								'padding', padding);
								
								// Trigger change event when value reset
								$('#params-padding').val(padding).
								trigger('change');

								// Add highlight effect
								dlayer.preview.highlightItem(selector);
								dlayer.preview.changed = true;
							}
						}
						
						dlayer.preview.unsaved();
					});
				},

				/**
				* Preview function for content container padding changes where
				* the width of the item doesn't need to be altered. Updates
				* the padding of the content container to the selected value
				*
				* @param {Integer} Id of the content item
				* @param {String} Padding position, either top or bottom
				* @param {Integer} Current padding value for the content item
				* @returns {Void}
				*/
				container_padding_vertical: function(content_id, position,
				padding)
				{
					var positions = ['top', 'bottom'];

					if(positions.indexOf(position) > -1) {
						$('#params-padding_' + position).change(function() {
							
							var new_padding = parseInt(this.value, 10);
							var selector = '.c-item-' + content_id;
							dlayer.preview.highlight = true;

							if(new_padding != NaN && new_padding >= 0) {
								dlayer.preview.content.fn.
								set_content_item_padding_value(selector,
								position, new_padding);

								dlayer.preview.highlightItem(selector);
								dlayer.preview.changed = true;
							}
							
							dlayer.preview.unsaved();
						});
					}
				},
				
				/**
				* Preview function for content container margin (position) 
				* changes, the width of the item doesn't need to be altered. 
				* Updates the margin of the content container to the 
				* selected value
				*
				* @param {Integer} Id of the content item
				* @param {String} Margin position, either top or bottom
				* @param {Integer} Current margin value for the content item
				* @returns {Void}
				*/
				container_margin_vertical: function(content_id, position,
				margin)
				{
					var positions = ['top', 'bottom'];

					if(positions.indexOf(position) > -1) {
						$('#params-' + position).change(function() {
							
							var new_margin = parseInt(this.value, 10);
							var selector = '.c-item-' + content_id;
							dlayer.preview.highlight = true;

							if(new_margin != NaN && new_margin >= 0) {
								dlayer.preview.content.fn.
								set_content_item_margin_value(selector,
								position, new_margin);

								dlayer.preview.highlightItem(selector);
								dlayer.preview.changed = true;
							}
							
							dlayer.preview.unsaved();
						});
					}
				},

				/**
				* Preview function for content container padding changes where
				* the width of the content item needs to be altered. Updates
				* the padding value and also checks to ensure that the new
				* padding value along with other width attributes doesn't
				* exceed the page container.
				*
				* @param {Integer} Content id
				* @param {Integer} Page container width
				* @paran {String} Padding position, either right or left
				* @param {Integer} Current padding value
				* @param {Object} Other attributes that affect container
				*                 width, for example width, borders and
				*                 margins
				* @returns {Void}
				*/
				container_padding_horizontal: function(content_id, 
				page_container_width, position, padding, attributes)
				{
					var positions = ['left', 'right'];
					
					if(positions.indexOf(position) > -1) {
						$('#params-padding_' + position).change(function() {
							
							var new_padding = parseInt(this.value, 10);
							var selector = '.c-item-' + content_id;
							dlayer.preview.highlight = true;
							
							// Check width value in designer in case 
							// it has been modified by other preview methods                            
							attributes.width = dlayer.preview.content.fn.
							check_client_attribute_value(selector, 'width', 
							attributes.width);
							
							// Fetch the horixzontal padding value not being 
							// altered by this preview method
							if(position == 'left') {
								var sibling_position = 'right';
							} else {
								var sibling_padding = 'left';
							}
							
							attributes.padding = parseInt($(selector).css(
							'padding-' + sibling_position), 10);
							
							if(isNaN(attributes.padding) == true) {
								attributes.padding = 0;
							}
							
							if(new_padding != NaN && new_padding >= 0) {
								var total_width = new_padding + 
								attributes.padding + 
								attributes.margins.left +
								attributes.margins.right +
								attributes.width;
								var container_width = attributes.width;

								if(total_width <= page_container_width) {
									dlayer.preview.content.fn.
									set_content_item_padding_value(selector, 
									position, new_padding);
									dlayer.preview.content.fn.
									set_content_item_widths(selector, 
									total_width, container_width);

									dlayer.preview.highlightItem(selector);
									dlayer.preview.changed = true;
								} else {
									// Check padding value in designer in case 
									// it has been modified by other preview 
									// methods
									padding = dlayer.preview.content.fn.
									check_client_attribute_value(selector, 
									'padding-' + position, padding);
									
									// Trigger change event when value reset
									$('#params-padding_' + position).val(
									padding).trigger('change');

									// Add highlight effect
									dlayer.preview.highlightItem(
									selector);
									dlayer.preview.changed = true;
								}
							}
							
							dlayer.preview.unsaved();
						});
					}
				},
				
				/**
				* Preview function for content container margin changes where
				* the width of the content item needs to be altered. Updates
				* the margin value and also checks to ensure that the new
				* margin value along with other width attributes doesn't
				* exceed the page container.
				*
				* @param {Integer} Content id
				* @param {Integer} Page container width
				* @paran {String} Margin position, either right or left
				* @param {Integer} Current margin value
				* @param {Object} Other attributes that affect container
				*                 width, for example width, borders and
				*                 padding
				* @returns {Void}
				*/
				container_margin_horizontal: function(content_id, 
				page_container_width, position, margin, attributes)
				{
					var positions = ['left', 'right'];
					
					if(positions.indexOf(position) > -1) {
						$('#params-' + position).change(function() {
							
							var new_margin = parseInt(this.value, 10);
							var selector = '.c-item-' + content_id;
							dlayer.preview.highlight = true;
							
							// Check width value in designer in case 
							// it has been modified by other preview methods                            
							attributes.width = dlayer.preview.content.fn.
							check_client_attribute_value(selector, 'width', 
							attributes.width);
							
							// Fetch the horizontal margin value not being 
							// altered by this preview method
							if(position == 'left') {
								var sibling_position = 'right';
							} else {
								var sibling_position = 'left';
							}
							
							attributes.margin_sibling = parseInt($(selector).
							css('margin-' + sibling_position), 10);
							
							if(isNaN(attributes.margin_sibling) == true) {
								attributes.margin_sibling = 0;
							}
							
							if(new_margin != NaN && new_margin >= 0) {
								var total_width = new_margin + 
								attributes.margin_sibling + 
								attributes.paddings.left +
								attributes.paddings.right +
								attributes.width;
								var container_width = attributes.width;

								if(total_width <= page_container_width) {
									dlayer.preview.content.fn.
									set_content_item_margin_value(selector, 
									position, new_margin);
									dlayer.preview.content.fn.
									set_content_item_widths(selector, 
									total_width, container_width);

									dlayer.preview.highlightItem(selector);
									dlayer.preview.changed = true;
								} else {
									// Check margin value in designer in case 
									// it has been modified by other preview 
									// methods
									client_margin = dlayer.preview.content.fn.
									check_client_attribute_value(selector, 
									'margin-' + position, margin);
									
									// Trigger change event when value reset
									$('#params-' + position).val(
									client_margin).trigger('change');

									// Add highlight effect
									dlayer.preview.highlightItem(
									selector);
									dlayer.preview.changed = true;
								}
							}
							
							dlayer.preview.unsaved();
						});
					}
				},
				
				/**
				* Preview function for heading type, switches the heading tab 
				* when the user changes the heading type in the select
				* 
				* @param {Integer} Content id
				* @returns {Void}
				*/
				heading_type: function(content_id) 
				{
					$('#params-heading_type').change(function() 
					{
						var selector = '.c-item-' + content_id;
						var h_tag = $(selector)[0].tagName;
						var heading = $('.c_selected').html();
						dlayer.preview.highlight = true;
						
						$('.c_selected').html(heading.replace('<' + 
						h_tag.toLowerCase(), '<h' + this.value)
						.replace('</' + h_tag.toLowerCase(), 
						'</h' + this.value));
						
						dlayer.preview.highlightItem(selector);
						dlayer.preview.changed = true;
						dlayer.preview.unsaved(); 
					});
				},
				
				/**
				* Preview function for content item content, updates the 
				* content on keyup, change and blur
				* 
				* @param {Integer} Content id
				* @param {String} Field to read data from
				* @returns {Void}
				*/
				container_content: function(content_id, field) 
				{
					$('#params-' + field).keyup(function()
					{
						var selector = '.c-item-' + content_id;
						var current_value = $(selector).text();
						dlayer.preview.highlight = true;

						if(this.value.trim() != current_value) {
							$(selector).html(this.value.trim());
							dlayer.preview.highlightItem(selector, 1500);
							dlayer.preview.highlight = false;
							dlayer.preview.changed = true;
						}

						dlayer.preview.unsaved();
					});
					
					$('#params-' + field).change(function()
					{
						dlayer.preview.highlight = true;
						var selector = '.c-item-' + content_id;
						var current_value = $(selector).text();

						if(this.value.trim() != current_value) {
							$(selector).html(this.value.trim());
							dlayer.preview.highlightItem(selector);
							dlayer.preview.changed = true;
						}

						dlayer.preview.unsaved();
					});
					
					$('#params-' + field).blur(function()
					{
						dlayer.preview.highlight = true;
						var selector = '.c-item-' + content_id;

						if(dlayer.preview.changed == true) {
							dlayer.preview.highlightItem(selector);
						}
						
						dlayer.preview.unsaved();
					});
				},
				
				/** 
				* Check current client attribute value against the default 
				* value passed into the preview functions
				* 
				* @param {String} Jquery selector
				* @param {String} Attribute to check
				* @param {Integer} Current value, at page load
				* @returns {Integer} Value to use for calculations
				*/
				check_client_attribute_value: function(selector, attribute, 
				value) 
				{
					var client_value = parseInt($(selector).css(attribute));
					
					if(value != client_value) {
						return client_value;
					} else {
						return value;
					} 
				},    

				/**
				* Set the widths for a content item, container and the
				* movement controls
				*
				* @param {String} Jquery selector
				* @param {Integer} Total width of content container, including
				*                  margins
				* @param {Integer} Width of the content item
				* @returns {Void}
				*/
				set_content_item_widths: function(selector, total_width,
				container_width)
				{
					// Set width for content item
					$(selector).css('width', container_width + 'px');
					// Set the width for the container
					$(selector).parent().css('width', total_width + 'px');
					// Set the width for the movement controls
					$(selector).siblings().css('width', total_width-2 + 'px');
				},

				/**
				* Set the padding for a content item 
				*
				* @param {String} Jquery selector
				* @param {Integer} New padding value
				* @returns {Void}
				*/
				set_content_item_padding: function(selector, padding)
				{
					$(selector).css('padding', padding + 'px');
				},

				/**
				* Set a specific padding value for a content item
				*
				* @param {String} Jquery selector
				* @param {String} Padding position
				* @param {Integer} New padding value 
				* @returns {Void}
				*/
				set_content_item_padding_value: function(selector, position,
				padding)
				{
					$(selector).css('padding-' + position, padding + 'px');
				},
				
				/**
				* Set a specific margin value for a content item
				*
				* @param {String} Jquery selector
				* @param {String} Margin position
				* @param {Integer} New margin value 
				* @returns {Void}
				*/
				set_content_item_margin_value: function(selector, position,
				margin)
				{
					$(selector).css('margin-' + position, margin + 'px');
				},
			}
		},
		
		form: {
			
			fn: {
				
				/**
				* Preview function for row attributes, updates the value
				* in the Form builder as the user changes the value
				*
				* @param {Integer} Id of the field being edited
				* @param {String} Field attribute being updated
				* @param {String} HTML element that is being updated
				* @param {String} Initial value for the text string
				* @param {Boolean} If the value is optional the user should
								   be able to clear the value, shouldn't
								   default to initial value, if not set
								   defaults to false
				* @returns {Void}
				*/
				row_attribute: function(field_id, attribute, element, value,
				optional)
				{
					if(typeof optional == 'undefined') { optional = false }

					$('#params-' + attribute).keyup(function()
					{
						var selector = '.row_' + field_id + ' ' + element;
						var current_value = $(selector).text();

						if(this.value.trim().length > 0 &&
						this.value.trim() != current_value) {
							$(selector).html(this.value.trim());
							dlayer.preview.highlightItem(selector, 1500);
							dlayer.preview.highlight = false;
							dlayer.preview.changed = true;
						} else {
							if(this.value.trim().length == 0) {
								if(optional == false) {
									$(selector).html(value);
									$('#params-' + attribute).val(value);
								} else {
									$(selector).html('');
									$('#params-' + attribute).val('');
									dlayer.preview.highlight = true;
									dlayer.preview.highlightItem(selector);
									dlayer.preview.changed = true;
								}
							}
						}

						dlayer.preview.unsaved();
					});

					$('#params-' + attribute).change(function()
					{
						dlayer.preview.highlight = true;
						var selector = '.row_' + field_id + ' ' + element;
						var current_value = $(selector).text();

						if(this.value.trim().length > 0 &&
						this.value.trim() != current_value) {
							$(selector).html(this.value.trim());
							dlayer.preview.highlightItem(selector);
							dlayer.preview.changed = true;
						}

						dlayer.preview.unsaved();
					});

					$('#params-' + attribute).blur(function()
					{
						dlayer.preview.highlight = true;
						var selector = '.row_' + field_id + ' ' + element;

						if(dlayer.preview.changed == true) {
							dlayer.preview.highlightItem(selector);
						}
					});
				},
				
				/**
				* Preview function for field attributes, updates the attribute value in the
				* Form builder as the user changes the value. Updates the value for the user
				* on key up and on value change.
				*
				* @param {Integer} Id of the field being edited
				* @param {String} Field attribute being updated
				* @param {String} Element attribute that is being updated
				* @param {String} Initial value for the text string
				* @param {Boolean} If the value is optional the user should be able to clear
								  the value, shouldn't default to initial value, if not set
								  defaults to false
				* @returns {Void}
				*/
				field_attribute_string: function(field_id, attribute,
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
							dlayer.preview.highlightItem(selector, 1500);
							dlayer.preview.highlight = false;
							dlayer.preview.changed = true;
						} else {
							if(this.value.trim().length == 0) {
								if(optional == false) {
									$(selector).attr(field_attribute, value);
									$('#params-' + attribute).val(value);
								} else {
									$(selector).attr(field_attribute, '');
									$('#params-' + attribute).val('');
									dlayer.preview.highlight = true;
									dlayer.preview.highlightItem(selector);
									dlayer.preview.changed = true;
								}
							}
						}

						dlayer.preview.unsaved();
					});

					$('#params-' + attribute).change(function()
					{
						dlayer.preview.highlight = true;
						var selector = '#field_' + field_id;
						var current_value = $('#field_' + field_id).attr(field_attribute);

						if(this.value.trim().length > 0 &&
						this.value.trim() != current_value) {
							$(selector).attr(field_attribute, this.value.trim());
							dlayer.preview.highlightItem(selector);
							dlayer.preview.changed = true;
						}

						dlayer.preview.unsaved();
					});

					$('#params-' + attribute).blur(function()
					{
						dlayer.preview.highlight = true;
						var selector = '#field_' + field_id;

						if(dlayer.preview.changed == true) {
							dlayer.preview.highlightItem(selector);
						}
					});
				},
				
				/**
				* Preview function for the field row background colour, 
				* updates the background colour when a user chooses a colour 
				* in the colour picker
				*
				* @param {Integer} Id of the field being edited
				* @param {String} Initial value for the background color
				* @param {Boolean} If the value is optional the user should be able to clear
								  the value, shouldn't default to initial value, if not set
								  defaults to false
				* @returns {Void}
				*/
				rowBackgroundColor: function(field_id, value,
				optional)
				{
					if(typeof optional == 'undefined') { optional = false }

					$('#params-background_color').change(function()
					{
						var new_value = this.value;

						if(new_value.length == 7) {
							$('.row_' + field_id).css('background-color', new_value);
							dlayer.preview.changed = true;
						} else {
							if(new_value.length == 0) {
								$('.row_' + field_id).css('background-color', 'inherit');
								dlayer.preview.changed = true;
							}
						}

						dlayer.preview.unsaved();
					});
				},
				
				/**
				* Preview function for field attributes, updates the attribute value in the
				* Form builder as the user changes the value. Unlike the string version of the
				* method this checks for an integer value and only fires onchange.
				*
				* @param {Integer} Id of the field being edited
				* @param {String} Field attribute being updated
				* @param {String} Element attribute that is being updated
				* @param {String} Initial value for the text string
				* @param {Boolean} If the value is optional the user should be able to clear
								  the value, shouldn't default to initial value, if not set
								  defaults to false
				* @returns {Void}
				*/
				field_attribute_integer: function(field_id, attribute,
				field_attribute, value, optional)
				{
					if(typeof optional == 'undefined') { optional = false }

					$('#params-' + attribute).change(function()
					{
						dlayer.preview.highlight = true;
						var selector = '#field_' + field_id;
						var new_value = parseInt(this.value, 10);
						var current_value = parseInt(
						$(selector).attr(field_attribute), 10);

						if(new_value != NaN &&
						current_value != NaN &&
						new_value != current_value &&
						new_value > 0) {
							$(selector).attr(field_attribute, new_value);
							dlayer.preview.highlightItem(selector);
							dlayer.preview.changed = true;
						} else {
							if(optional == false) {
								$(selector).attr(field_attribute, value);
								$('#params-' + attribute).val(value);
							} else {
								$(selector).attr(field_attribute, '');
								$('#params-' + attribute).val('');
								dlayer.preview.highlightItem(selector);
								dlayer.preview.changed = true;
							}
						}

						dlayer.preview.unsaved();
					});
				},
			}
		}
	},
	
	selectors: {
		
		/**
		* Select function for the content module, allows a content area (div) 
		* to be selected so that a content row can be selected allowing a 
		* content item to be selected or added
		*
		* @returns {Void}
		*/
		contentArea: function()
		{
			var area_background_color;
			var row_background_colors = {};
			
			$('div.selectable').hover(
				function() {
					area_background_color = $(this).css('background-color');
					$(this).css('background-color', '#e1dc50');
					$(this).css('cursor', 'pointer');
					
					/**
					* Store background color for each row if a value has 
					* been set
					*/
					var area_id = this.id;
					
					$('#' + area_id + ' > div.row').each(function() 
					{
						var row = this;
						var bg_color = dlayer.rgbToHex($(row).css(
							'background-color'));
							
						if(bg_color != false) {
							row_background_colors[row.id] = bg_color;
							
							$('#' + area_id + ' > #' + row.id).css(
								'background-color', 'transparent');
						}						
					});
				},
				function() {
					$(this).css('background-color', area_background_color);
					
					/**
					* Re-assign the assigned background colour if it 
					* exists in the data array
					*/
					var area_id = this.id;
					
					$('#' + area_id + ' > div.row').each(function() 
					{
						var row = this;
						
						if(row_background_colors[row.id] != undefined) {
							$('#' + area_id + ' > #' + row.id).css(
								'background-color', 
								row_background_colors[row.id]);
						}
					});
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
		},
		
		/**
		* Select function for the content module, allows a content row to be 
		* selected once a content area has been selected, once a content row 
		* has been selected the user can either select a content item or add 
		* a new content item
		* 
		* @returns {Void}
		*/
		contentRow: function() 
		{
			var background_color = null;
			var content_container_background_colors = {};
			var content_background_colors = {};
			
			$('div.container > div.selectable').hover(
				function() {
					background_color = $(this).css('background-color');
					$(this).css('background-color', '#e1dc50');
					$(this).css('cursor', 'pointer');
					$(this).find('.move').show();
					
					/**
					* Store background color for each content item 
					* container and content item
					*/
					var row_id = this.id;
					
					$('#' + row_id + ' .item').each(function() 
					{
						var params = this.id.split(':');
						var item_id = params[2];
						
						var bg_color = dlayer.rgbToHex(
							$('.content-container-' + item_id).css(
							'background-color'));
																					
						if(bg_color != false) {
							
							content_container_background_colors[item_id] = 
								bg_color;
							
							$('.content-container-' + item_id).css(
								'background-color', 'transparent');
						}
						
						var bg_color = dlayer.rgbToHex(
							$('.content-' + item_id).css('background-color'));
																					
						if(bg_color != false) {
							
							content_background_colors[item_id] = bg_color;
							
							$('.content-' + item_id).css('background-color', 
								'transparent');
						}
					});
				}, 
				function() {
					$(this).css('background-color', background_color);
					$(this).find('.move').hide();
					
					/**
					* Re-assign the background color for the content container 
					* and content item if values exist in the objects
					*/
					var row_id = this.id;
					
					$('#' + row_id + ' .item').each(function() 
					{
						var params = this.id.split(':');
						var item_id = params[2];
						
						if(content_container_background_colors[item_id] != 
							undefined) {
							$('.content-container-' + item_id).css(
								'background-color', 
								content_container_background_colors[item_id]);
						}
						
						if(content_background_colors[item_id] != 
							undefined) {
							$('.content-' + item_id).css(
								'background-color', 
								content_background_colors[item_id]);
						}
					});
				}			
			);
			$('div.container > div.selectable').click(
				function() {
					$(this).css('background-color', '#66a7ba');
					
					var id = this.id.replace('content_row_', '');
					
					window.location.replace(
					'/content/design/set-selected-content-row/selected/' + id);
				}			
			);
		},
		
		/**
		* Select function for the content module, allows a content item to be
		* selected once bothj a content area and content row have been selected, 
		* this enabled edit mode for the requested content item
		*
		* @returns {Void}
		*/
		contentItem: function()
		{
			var item_container_background_color = null;
			var item_background_color = null;
			
			$('div.selected-row > .selectable').hover(
				function() {
					
					var params = this.id.split(':');
					var item_id = params[2];
					
					item_container_background_color = $(
						'.content-container-' + item_id).css(
						'background-color');
					$('.content-container-' + item_id).css(
						'background-color', '#e1dc50');
					item_background_color = $(
					'.content-' + item_id).css('background-color');
					$('.content-' + item_id).css('background-color', '#e1dc50');
						
					$(this).css('cursor', 'pointer');
					$(this).find('.move').show();
				},
				function() {
					var params = this.id.split(':');
					var item_id = params[2];
					
					$('.content-container-' + item_id).css('background-color', 
						item_container_background_color);
					$('.content-' + item_id).css('background-color', 
						item_background_color);
					$(this).find('.move').hide();
				}
			);
			$('div.selected-row > .selectable').click(
				function() {
					$(this).css('background-color','#66a7ba');

					var params = this.id.split(':');

					window.location.replace(
					'/content/design/set-selected-content/selected/' + params[2] +
					'/content-type/' + params[0] + '/tool/' + params[1]);
				}
			);
		},
		
		/**
		* Select function for the template module, allows a div to be selected so that
		* the user can work on it, modify its styles, change size or split
		*
		* @returns {Void}
		*/
		template: function()
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
		},
		
		/**
		* Select function for the forms module, allows a form input to be selected so
		* that it can be edited
		*
		* @returns {Void}
		*/
		form: function()
		{
			$('#design div.field_row').hover(
				function() {
					background_color = $(this).css('background-color');
					$(this).css('background-color', '#e1dc50');
					$(this).css('cursor', 'pointer');
					$(this).find('.move').show();
				},
				function() {
					$(this).css('background-color', background_color);
					$(this).find('.move').hide();
				}
			);
			$('#design div.field_row').click(
				function() {
					$(this).css('background-color','#c3be50');

					var params = this.id.split(':');

					window.location.replace(
					'/form/design/set-selected-field/selected/' + params[2] +
					'/tool/' + params[1] + '/type/' + params[0]);
				}
			);
		}
	},
	movers: {
			
		/**
		* Attach the movement controls and events to allow content items to be 
		* moved within a content row
		*
		* @return {Void}
		*/
		contentItems: function()
		{
			var rows = $('.selected-row .item.selectable').length;
			
			$('.selected-row .item.selectable').each(function(index)
			{
				var id = this.id.split(':');
				id = id[0] + ':' + id[2];
				
				if(index !== 0) {
					$(this).prepend(dlayer.movers.button('move', 
						'move-up', 'up', 'Display sooner', id));
				}
				if(index !== (rows-1)) {
					$(this).append(dlayer.movers.button('move', 
						'move-down', 'down', 'Display later', id));
				}
			});
			
			$('.selected-row .item.selectable > .move > .btn').click(
				function() {
					var params = this.id.split(':');
					
					window.location.replace(
					'/content/design/move-content-item/direction/' + 
						params[0] + '/id/' + params[2] + '/type/' + params[1]);

					return false;
				}
			);
		},
		
		/**
		* Attach the movement controls and events, allows a form field to be 
		* moved up and down on the form
		*
		* @return {Void}
		*/
		formFields: function()
		{
			var fields = $('#form .field_row').length - 1;

			$('#design .field_row').each(function(index) {
				var params = this.id.split(':');

				if(index !== 0) {
					$(this).prepend('<div class="btn btn-xs btn-default btn-block move move-' + params[1] +
					'" id="up:' + params[0] + ':' + params[2] + '">Move up</div>');
				}
				if(index !== fields) {
					$(this).append('<div class="btn btn-xs btn-default btn-block move move-' + params[1] +
					'" id="down:' + params[0] + ':' + params[2] + '">Move down</div>');
				}
			});

			$('#design .field_row > .move').click(
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
		},
		
		/**
		* Generate the html for the movement buttons
		* 
		* @param base_class Base css class
		* @param move_class Specific movement class
		* @param direction Direction of intended movement
		* @param label Label for button
		* @param id Id for button
		* 
		* @returns {String}
		*/
		button: function(base_class, move_class, direction, label, id) 
		{
			var button = '<div class="move">';
			button += '<div class="btn btn-xs btn-default btn-block ';
			button += move_class + '" id="' + direction + ':' + id + '">';
			button += label;
			button += '</div>';
			button += '</div>';
			
			return button;
		},
		
		/**
		* Attach the movement controls and events to allow content rows to be 
		* moved within a content area
		*
		* @return {Void}
		*/
		contentRows: function()
		{
			var rows = $('.selected-area .row.selectable').length;
			
			$('.selected-area .row.selectable').each(function(index)
			{
				id = this.id.replace('content_row_', '');
				
				if(index !== 0) {
					$(this).prepend(dlayer.movers.button('move', 
						'move-up', 'up', 'Move up', id));
				}
				if(index !== (rows-1)) {
					$(this).append(dlayer.movers.button('move', 
						'move-down', 'down', 'Move down', id));
				}
			});
			
			$('.selected-area .row.selectable > .move > .btn').click(
				function() {
					var params = this.id.split(':');
					
					window.location.replace(
					'/content/design/move-content-row/direction/' + 
						params[0] + '/id/' + params[1]);

					return false;
				}
			);
		}
	},
	
	settings: {
		
		content: {
			
			font_styles: [],
			
			font_weights: [],
			
			font_decorations: [],
			
			font_families: [],
			
			fn: {
				
				/**
				* Update the heading preview based on the font style selected in the
				* select menu
				*
				* @param {Integer}
				* @param {Integer}
				* @returns {Void}
				*/
				preview_font_styles: function(heading_id,
				font_style_id)
				{
					$('#preview_' + heading_id + ' > h2').css('font-style',
					dlayer.settings.content.font_styles[font_style_id]);
				},
				
				/**
				* Update the heading preview based on the font weight selected in the
				* select menu
				*
				* @param {Integer}
				* @param {Integer}
				* @returns {Void}
				*/
				preview_font_weights: function(heading_id,
				font_weight_id)
				{
					$('#preview_' + heading_id + ' > h2').css('font-weight',
					dlayer.settings.content.font_weights[font_weight_id]);
				},
				
				/**
				* Update the heading preview based on the font decoration selected in the
				* select menu
				*
				* @param {Integer}
				* @param {Integer}
				* @returns {Void}
				*/
				preview_font_decorations: function(heading_id, font_decoration_id)
				{
					$('#preview_' + heading_id + ' > h2').css('text-decoration',
					dlayer.settings.content.font_decorations[font_decoration_id]);
				},
				
				/**
				* Update the heading preview based on the font size in the input
				*
				* @param {Integer}
				* @param {Integer}
				* @returns {Void}
				*/
				preview_font_sizes: function(heading_id, size)
				{
					var font_size = parseInt(size);

					if(font_size >= 6 && font_size <= 72) {
						$('#preview_' + heading_id + ' > h2').css('font-size', size);
					}
				},
				
				/**
				* Update the heading preview based on the font colour in the input
				*
				* @param {Integer}
				* @param  {String}
				* @returns {Void}
				*/
				preview_font_colors: function(heading_id, color)
				{
					var regex = /^(#)([0-9a-fA-F]{3})([0-9a-fA-F]{3})?$/;

					if(regex.test(color) == true) {
						$('#preview_' + heading_id + ' > h2').css('color', color);
					}
				},
				
				/**
				* Update the font family for the preview paragraphs
				*
				* @param {Integer}
				* @returns {Void}
				*/
				preview_font_families: function(font_family_id)
				{
					$('.font_preview > p.switch').css('font-family',
					dlayer.settings.content.font_families[font_family_id]);
				}
			}
		},
		form: {
			
			font_families: [],
			
			fn: {
				/**
				* Update the font family for the preview paragraphs
				*
				* @param {Integer} Font family id
				* @returns {Void}
				*/
				preview_font_families: function(font_family_id)
				{
					$('.font_preview > p.switch').css('font-family',
					dlayer.settings.form.font_families[font_family_id]);
				}
			}
		}
	},
	
	designers: {
		
		/**
		* Preset the position values for the selected content item, user has
		* three choices, left, right and center aligned
		*
		* @param {Integer} Page container width
		* @param {Integer} Content container width
		* @returns {Void}
		*/
		set_position_presets: function(page_container, content_container)
		{
			$('#ribbon .set_position').click(
				function() {
					var alignment = this.id.replace('set_position_', '');
					var left = 0;
					var right = 0;
					var diff = 0;

					if(page_container != content_container &&
					content_container < page_container) {
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
								// Left is the default position for an item,
								// leave/set both values to 0, set in case
								// user has changed them
							break;
						}
					}

					$('#params-left').val(left).trigger('change');
					$('#params-right').val(right).trigger('change');;

					return false;
				}
			);
		},
		
		metrics: {
			
			/**
			* Page content metrics
			*
			* @returns {Void}
			*/
			contentBlocks: function()
			{
				$('#content-block-metrics').click(
					function() {
						$('#content-block-metrics .metrics-title').toggle();
						$('#content-block-metrics .metrics').toggle();
					}
				);
			},
			
			/**
			* Content item metrics
			*
			* @returns {Void}
			*/
			contentItems: function()
			{
				$('#content_item_metrics').click(
					function() {
						$('#content_item_metrics > .title').toggle();
						$('#content_item_metrics > .metrics').toggle();
					}
				);
			}
		},
		
		color_picker_value: null,
		
		color_picker_rgb: null,
		
		color_picker_element: null,
		
		/**
		* Invoke the color picker, resets the color value for the object and stores
		* id of the element that is calling the picker
		*
		* @returns {Void}
		*/
		color_picker_invoke: function()
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
		},
		
		/**
		* Close the color picker, set the invoker element and invoker div to the
		* selected color and value
		*
		* @returns {Void}
		*/
		color_picker_close: function()
		{
			$('.color_picker_tool').slideUp();

			if(dlayer.designers.color_picker_value != null) {
				$('#ribbon #picker_' + dlayer.designers.color_picker_element).css(
				'background-color', dlayer.designers.color_picker_rgb);
				$('#' + dlayer.designers.color_picker_element).val(
				dlayer.designers.color_picker_value).trigger('change');

			}
		},
		
		/**
		* Click events for the color picker, sets the values in the object
		*
		* @returns {Void}
		*/
		color_picker: function()
		{
			$('#ribbon .color_picker_tool .close').click(
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
		},
		
		/**
		* Open the image picker, the state of the image is calculated by 
		* the action, it checks to see what session values are set and 
		* generates the picker based on those vars
		*
		* @returns {Void}
		*/
		imagePickerOpen: function()
		{
			$(".open-image-picker-tool").on("click", function() {
				
				$('.image-picker-tool').show();
				
				$.ajax({
					url: '/content/ajax/image-picker',
					mehtod: 'GET',
					dataType: 'html'
				}).done(function(html) {
					$('.image-picker-tool .loading').hide();
					$('.image-picker-tool .form').html(html);
				});
			});
		},
		
		/**
		* Close the image picker
		* 
		* @returns {Void}
		*/
		imagePickerClose: function() 
		{
			$(".image-picker-tool .close").on("click", function() {
				$('.image-picker-tool').hide();
			});
		}
	}
}