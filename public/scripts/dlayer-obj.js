/**
* Dlayer javascript object, contains al the js required by the app.
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
	* @returns {String}
	*/
	rgbToHex: function(colorStr)
	{
		var hex = '#';
	    $.each(colorStr.substring(4).split(','), function(i, str){
	        var h = ($.trim(str.replace(')',''))*1).toString(16);
	        hex += (h.length == 1) ? "0" + h : h;
	    });
	    return hex;
	},
    
	ribbon: {
        
		tabs: {
			/**
			* Adds click events for the ribbon tabs, on click sets the
			* selected tab as active and then calls a function to make an
			* AJAX call for the tab content
			*
			* @param {String} Module that the function is being called from
			* @param {string} The name of the selected tool, used by the
							  AJAX function for validation purposes
			* @returns {Void}
			*/
			clicks: function(module, tool) {
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
			},
            
			/**
			* Load the content for the selected tool and tab
			*
			* @param {String} Name of the tool tab
			* @param {String} Name of the tool
			* @param {String} Name of the module, ribbon-tab-html is always
							  part of the design controller in the requested
							  module
			* @returns {Void}
			*/
			content: function(tab, tool, module)
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
				    var div = $('#template div.selected');

				    var x = div.width();
				    var y = div.height();

				    background_color = div.css('background-color');
				    div.css('backgroundColor', '#000000');
				    div.addClass('active');

				    if(contents == null) {
				        contents = div.html();
				    }

				    $('#template div.selected').mousemove(function(e)
				    {
				        var split_position = e.pageY - this.offsetTop;

				        if(split_position < y && split_position > 0) {
				            var split_box =
                            '<div class="horizontal_splitter" style="width:' +
				            x + 'px; height:' + split_position + 'px;"></div>';

				            div.html(split_box);

				            dlayer.tools.template.fn.splitInfo(
                            split_position, y-split_position);
				        }
				    });

				    $('#template div.selected').click(function(e)
				    {
				        var split_position = e.pageY - this.offsetTop;

				        // Get the dimensions of the current select div
				        var x = $('#template div.selected').width();
				        var y = $('#template div.selected').height();

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
				    div.addClass('active');

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
				        $('#template div.selected').unbind('mousemove');
				        $('#template div.selected').unbind('click');
				        var div = $('#template div.selected');
				        div.removeClass('active');
				        div.css('background-color', background_color);
				        div.html(contents);
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
				    $('p.advanced_info').show();
				    $('p.advanced_info > span.one').html(one);
				    $('p.advanced_info > span.two').html(two);
				}
			}
		},
        
		content: {
            
			fn: {
                
				/**
				* AJAX for import text select, fetches the json based on the
                * chosen option and then passes the data to the name and
                * content fields
				*
				* @returns {Void}
				*/
				import_text: function()
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
									$('form #params-content').val(
                                    data.content);
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
				},
                
				/**
				* AJAX for import heading select, fetches the json based
                * on the chosen option and then passes the data to the name
                * and content fields
				*
				* @returns {Void}
				*/
				import_heading: function()
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
			}
		}
	},
    
	preview: {
        
		content: {
            
			changed: false,
            
			visible: false,
            
			highlight: true,
            
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
				},
                
				/**
				* Preview function for content container margins, updates
                * the margins in the Content manager design as the user
                * modified the values. The input types are numbers so the
                * event fires onchange,
				*
				* There will always be a margin value for each container so
                * we don't need to be concerned with optional values.
				*
				* @param {Integer} Id of the content item
				* @param {Integer} Margin position, top, right, left or bottom
				* @returns {Void}
				*/
				container_margin: function(content_id, margin)
				{
					$('#params-' + margin).change(function()
					{
						var selector = '#page .c_item_' + content_id;
					    var new_value = parseInt(this.value, 10);
					    var current_value = parseInt($(selector).css(
                        'margin-' + margin), 10);

					    if(new_value != NaN && current_value != NaN &&
					    new_value != current_value && new_value > 0) {
					        $(selector).css('margin-' + margin, new_value + 'px');
					        dlayer.preview.content.fn.highlight(selector);
					        dlayer.preview.content.changed = true;
					    }

					    dlayer.preview.content.fn.unsaved();
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
								  width, for example padding, borders and
								  margins
				* @returns {Void}
				*/
				container_width: function(content_id, page_container_width,
                width, attributes)
				{
					$('#params-width').change(function() {
						var new_width = parseInt(this.value, 10);
                        var selector = '.c_item_' + content_id;

                        if(new_width != NaN && new_width > 0) {
                            
                            // Check padding value in designer in case 
                            // it has been modified by other preview methods
                            var client_padding = parseInt(
                            $(selector).css('padding'));
                            
                            if(attributes.padding != client_padding) {
                                attributes.padding = client_padding;
                            }
                            
                            var total_width = new_width +
                            (attributes.padding * 2) +
                            attributes.margins.left +
                            attributes.margins.right;
                            var container_width = new_width;

                            if(total_width <= page_container_width) {
                                dlayer.preview.content.fn.
                                set_content_item_widths(selector, total_width,
                                container_width);

                                dlayer.preview.content.fn.highlight(selector);
                            } else {
                                // Check width value in designer in case 
                                // it has been modified by other preview 
                                // methods
                                var client_width = parseInt(
                                $(selector).css('width'));
                                if(width != client_width) {
                                    width = client_width;
                                }
                                // Trigger change event when value reset
                                $('#params-width').val(width).trigger('change');
                            }
                        }
					});
				},

                /**
                * Prevuew function for content container padding changes.
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
                        var selector = '.c_item_' + content_id;

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

                                dlayer.preview.content.fn.highlight(selector);
                            } else {
                                // Check width value in designer in case 
                                // it has been modified by other preview 
                                // methods
                                padding = dlayer.preview.content.fn.
                                check_client_attribute_value(selector, 
                                'padding', padding);
                                
                                // Trigger change event when value reset
                                $('#params-padding').val(padding).
                                trigger('change');

                                // Add highlight effect
                                dlayer.preview.content.fn.highlight(selector);
                            }
                        }
                    });
                },

                /**
                * Preview function for content container padding changes where
                * the width of the item doesn't need to be altered. Updates
                * the padding of the content container to the selected value
                *
                * @param {Integer} Id of the content item
                * @param {String} Padding position, either top or bottom
                * @param {Integer} Current top padding value for the content
                                   item
                * @returns {Void}
                */
                container_padding_vertical: function(content_id, position,
                padding)
                {
                    var positions = ['top', 'bottom'];

                    if(positions.indexOf(position) > -1) {
                        $('#params-padding_' + position).change(function() {
                            var new_padding = parseInt(this.value, 10);
                            var selector = '.c_item_' + content_id;

                            if(new_padding != NaN &&
                            new_padding >= 0) {
                                dlayer.preview.content.fn.
                                set_content_item_padding_value(selector,
                                position, new_padding);

                                dlayer.preview.content.fn.highlight(selector);
                            }
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
                * @paran {String} Margin position, either right or left
                * @param {Integer} Current margin value
                * @param {Object} Other attributes that affect container
                *                 width, for example width, borders and
                *                 margins
                * @returns {Void}
                */
                container_padding_horizontal: function(content_id, 
                page_container_width, position, margin, attributes)
                {
                    var positions = ['left', 'right'];
                    
                    if(positions.indexOf(position) > -1) {
                        $('#params-padding_' + position).change(function() {
                            var new_padding = parseInt(this.value, 10);
                            var selector = '.c_item_' + content_id;
                            
                            if(new_padding != NaN && new_padding >= 0) {
                                var total_width = new_padding +
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

                                    dlayer.preview.content.fn.highlight(
                                    selector);
                                } else {
                                    // Trigger change event when value reset
                                    $('#params-padding_' + position).val(
                                    padding).trigger('change');

                                    // Add highlight effect
                                    dlayer.preview.content.fn.highlight(
                                    selector);
                                }
                            }
                        });
                    }
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
                        var selector = '.c_item_' + content_id;
                        var current_value = $(selector).text();

                        if(this.value.trim() != current_value) {
                            $(selector).html(this.value.trim());
                            dlayer.preview.content.fn.highlight(selector, 1500);
                            dlayer.preview.content.highlight = false;
                            dlayer.preview.content.changed = true;
                        }

                        dlayer.preview.content.fn.unsaved();
                    });
                    
                    $('#params-' + field).change(function()
                    {
                        dlayer.preview.content.highlight = true;
                        var selector = '.c_item_' + content_id;
                        var current_value = $(selector).text();

                        if(this.value.trim() != current_value) {
                            $(selector).html(this.value.trim());
                            dlayer.preview.content.fn.highlight(selector);
                            dlayer.preview.content.changed = true;
                        }

                        dlayer.preview.content.fn.unsaved();
                    });
                    
                    $('#params-' + field).blur(function()
                    {
                        dlayer.preview.content.highlight = true;
                        var selector = '.c_item_' + content_id;

                        if(dlayer.preview.content.changed == true) {
                            dlayer.preview.content.fn.highlight(selector);
                        }
                    });
                },
                
                /**
                * Check current client attribute value against the default 
                * value passed into the preview functions
                * 
                * @param {String} Jquery selector
                * @param {String} Attribute to check
                * @param {Integer} Current value, at page load
                * @returns {Integer} Value to use for calcualtions
                */
                check_client_attribute_value: function(selector, attribute, 
                value) 
                {
                    var client_value = parseInt($(selector).css('width'));
                    
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
				* Display a message if any data has changed and not yet been
                * saved
				*
				* @returns {Void}
				*/
				unsaved: function()
				{
					if(dlayer.preview.content.visible == false) {
						if(dlayer.preview.content.changed == true) {
							$('p.unsaved').show('medium');
							dlayer.preview.content.visible = true;
						}
					}
				},
                
				/**
				* Add a hightlight to the content item that has just been
                * changed
				*
				* @param {String Element selector
				* @param {Integer} Length for effect, defaults to 500 if not set
				* @returns {Void}
				*/
				highlight: function(selector, time)
				{
					if(typeof time == 'undefined') { time = 400 }

					if(dlayer.preview.content.highlight == true) {
						$(selector).effect("highlight", {}, time);
					}
				}
			}
		},
        
		form: {
            
			changed: false,
            
			visible: false,
            
			highlight: true,
            
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
				},
                
				/**
				* Preview function for row background styling color, changes the background
				* color as the user move focus from the field.
				*
				* @param {Integer} Id of the field being edited
				* @param {String} Initial value for the background color
				* @param {Boolean} If the value is optional the user should be able to clear
								  the value, shouldn't default to initial value, if not set
								  defaults to false
				* @returns {Void}
				*/
				row_background_color: function(field_id, value,
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
				},
                
				/**
				* Display a message if any data has changed and not yet been saved
				*
				* @returns {Void}
				*/
				unsaved: function()
				{
					if(dlayer.preview.form.visible == false) {
						if(dlayer.preview.form.changed == true) {
							$('p.unsaved').show('medium');
							dlayer.preview.form.visible = true;
						}
					}
				},
                
				/**
				* Add a hightlight to the element that has just been changed
				*
				* @param {String} Element selector
				* @param {Integer} Length for effect, defaults to 500 if not set
				* @returns {Void}
				*/
				highlight: function(selector, time)
				{
					if(typeof time == 'undefined') { time = 400 }

					if(dlayer.preview.form.highlight == true) {
						$(selector).effect("highlight", {}, time);
					}
				}
			}
		}
	},
    
	selectors: {
        
		/**
		* Select function for the content module, allows a div to be selected so that
		* a content block can be added to it
		*
		* @returns {Void}
		*/
		content: function()
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
		},
        
		/**
		* Select function for the content module, allows a content item to be
		* selected once a page/template div has been selected
		*
		* @returns {Void}
		*/
		contentItem: function()
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
	},
	movers: {
		/**
		* Move a content item, either up or down, how to move the item depends on the
		* class attached to the div
		*
		* @returns {Void}
		*/
		contentItem: function()
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
		},
        
		/**
		* Attach the movement controls and events, allows a form field to be moved up
		* down on the form
		*
		* @return {Void}
		*/
		formFields: function()
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

        			$('#params-left').val(left);
        			$('#params-right').val(right);

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
			pageContainer: function()
			{
				$('#page_container_metrics').click(
					function() {
						$('#page_container_metrics > .title').toggle();
						$('#page_container_metrics > .metrics').toggle();
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
		* Close the color picker, set the invoker element and incoker div to the
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
	}
}