/**
* Javascript required for the template module tools
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development limited
* @version $Id: tools.js 1842 2014-05-19 14:59:09Z Dean.Blackborough $
*/

dlayer.tools.template = {}
dlayer.tools.template.fn = {}

/**
* Horizontal split, visual representation of where the split will occur, user 
* needs to click for the request to be sent to the tool model
* 
* @return void
*/
dlayer.tools.template.fn.horizontalSplit = function() 
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
            var split_box = '<div class="horizontal_splitter" style="width:' + 
            x + 'px; height:' + split_position + 'px;"></div>';
            
            div.html(split_box);
            
            dlayer.tools.template.fn.splitInfo(split_position, y-split_position);
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
                       window.location.replace('/template/design/');
                   }
               }
            );
        }
        
        console.log('Div split horizontally');
    });
}

/**
* Vertical split, visual representation of where the split will occur, user 
* needs to click for the request to be sent to the tool model
* 
* @return void
*/
dlayer.tools.template.fn.verticalSplit = function() 
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
            var split_box = '<div class="vertical_splitter" style="width:' + 
            (split_position) + 'px; height:' + y + 'px;"></div>';
            
            div.html(split_box);
            
            dlayer.tools.template.fn.splitInfo(split_position, x-split_position);
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
                       window.location.replace('/template/design/');
                   }
               }
            );
        }
        
        console.log('Div split vertically');
    });
}

/**
* Reset function for the split tools
* 
* @return void
*/
dlayer.tools.template.fn.splitReset = function() 
{   
    if(contents != null) {
        $('#template div.selected').unbind('mousemove');
        $('#template div.selected').unbind('click');
        var div = $('#template div.selected');
        div.removeClass('active');
        div.css('background-color', background_color);
        div.html(contents);
    }
}

/**
* Update the info block with sizes for each of the blocks based on where 
* the split line is
* 
* @param integer one
* @param integer two
* @return void
*/
dlayer.tools.template.fn.splitInfo = function(one, two) 
{   
    $('p.advanced_info').show();
    $('p.advanced_info > span.one').html(one);
    $('p.advanced_info > span.two').html(two);
}