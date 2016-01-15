<?php
/**
* Resize ribbon model, fetches all the data needed by the resize ribbon forms.
* For the forms we need to return the divs that will be affected if the edge 
* of the selected div is modified
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
*/
class Dlayer_Ribbon_Template_Resize extends Dlayer_Ribbon_Module_Template 
{
    private $divs;
    private $template_width = Dlayer_Config::DESIGNER_WIDTH;
    
    /**
    * Data array for the selected template div
    * 
    * @var array
    */
    private $div = array();
    
    private $top_edge = array();
    private $right_edge = array();
    private $bottom_edge = array();
    private $left_edge = array();
    
    private $border_widths = array();
    
    /**
    * Fetch the resizing data for the selected tab, returns an array 
    * containing the ids of the divs that site either site of the edge of 
    * the selected div that is being modified. These ids are then passed to 
    * the forms and the process model works out how to adjust the sizes after 
    * a change.
    * 
    * The user could be trying to move any edge of a div so we need to work 
    * out the straddling divs for each edge, the view scripts works out 
    * whether or not the control is needed for a particlular edge
    * 
    * @param integer $site_id Current site id
    * @param integer $template_id Current template id
    * @param integer $div_id Id of the selected div
    * @param string $tool Name of the selected tool
    * @param string $tab Name of the selected tool tab
    * @param return array
    */
    public function viewData($site_id, $template_id, $div_id, $tool, $tab) 
    {
        $this->writeParams($site_id, $template_id, $div_id, $tool, $tab);
        
        $model_borders = new Dlayer_Model_Ribbon_Styles();
        $this->border_widths = $model_borders->borderWidths($site_id, 
        $template_id);
        
        $this->templateDivs();
        
        $this->edgePositions();
        
        $this->div = $this->divs[$div_id];
        
        $this->straddleEdges();
        
        return array('div'=>$this->div, 'top'=>$this->top_edge, 
        'right'=>$this->right_edge, 'bottom'=>$this->bottom_edge, 
        'left'=>$this->left_edge);
    }
    
    /** 
    * Work out the edge positions for each of the divs in the template, 
    * loops through the array adding an edge index with values for top, right, 
    * bottom and left. We need this to calculate which divs will be affected 
    * if an edge is moved
    * 
    * @return void Writes aditional data to the divs array
    */
    private function edgePositions() 
    {
        foreach($this->divs as $k=>$div) {
            $edges = array('top'=>$div['positions']['top'], 
                           'right'=>$div['positions']['left'] 
                           + $div['sizes']['width'],
                           'bottom'=>$div['positions']['top'] + 
                           $div['sizes']['height'],
                           'left'=>$div['positions']['left']);
            $this->divs[$k]['edges'] = $edges;
        }
    }
    
    /**
    * Calculate the positions and sizes for all the divs that make up the 
    * template, we initially select all the top level divs and then a recursive 
    * method is called to calculate the positions for all the children
    * 
    * @return void Data is written to the $this->divs array, we store the 
    *              sizes (width and height) for each div along with the 
    *              absolute position within the template (left and top)
    */
    private function templateDivs() 
    {
        $model_template = new Dlayer_Model_View_Template();
        
        // Position for first div
        $top = 0;
        $left = 0;
        
        // Pull the base level divs for the template
        $divs = $model_template->divsByParentId($this->site_id, 
        $this->template_id, 0, $this->border_widths);
        
        // Loop through the divs calculating the position for each div, we 
        // calculate the top and left position updating the initial position 
        // vars as we go for future divs
        if(count($divs) > 0) {
            foreach($divs as $div) {
                
                $positions = $this->absolutePositions($div['sort_order'], 
                $div['sizes'], $top, $left, $this->template_width);
                
                $top = $positions['top'];
                $left = $positions['left'];
                
                $this->divs[$div['id']] = 
                    array('id'=>$div['id'], 
                          'sizes'=>$div['sizes'], 
                          'positions'=>$positions['positions']);
                                      
                $this->templateChildDivs($div['id'], $positions['positions'], 
                $div['sizes']['width']);
            }
        }
    }
    
    /**
    * Fetch the child divs and calculate their positions, recusive method, 
    * it will carry on calling itself until all the children have been 
    * selected
    * 
    * @param integer $parent_id
    * @param array $parent_positions Positions array for parent div, left and 
    *                                top position
    * @param integer $parent_width Width of the parent div, used to calculate 
    *                              if the div is part of a vertical split 
    *                              group or horizonatl split group
    * @return void Data is written to the $this->divs array
    */
    private function templateChildDivs($parent_id, array $parent_positions, 
    $parent_width) 
    {
        $model_template = new Dlayer_Model_View_Template();
        
        $divs = $model_template->divsByParentId($this->site_id, 
        $this->template_id, $parent_id, $this->border_widths);
        
        $top = $parent_positions['top'];
        $left = $parent_positions['left'];
        
        // Loop through the divs calculating the position for each div, we 
        // calculate the top and left position updating the initial position 
        // vars as we go for future divs
        if(count($divs) > 0) {        
            foreach($divs as $div) {
                
                $positions = $this->absolutePositions($div['sort_order'], 
                $div['sizes'], $top, $left, $parent_width);
                
                $top = $positions['top'];
                $left = $positions['left'];
                                
                $this->divs[$div['id']] = 
                    array('id'=>$div['id'], 
                          'sizes'=>$div['sizes'], 
                          'positions'=>$positions['positions']);
                                      
                $this->templateChildDivs($div['id'], $positions['positions'], 
                $parent_width);
            }
        }
    }
       
    /**
    * Calculate the absolute positions for the selected div and update the 
    * top and left positions for the next method call
    * 
    * @param integer $sort_order Sort order of div in group
    * @param array $sizes Sizes data array for div, contains width and height
    * @param integer $top Top position for previous/parent div
    * @param integer $left Left position for previous/parent div
    * @param integer $parent_width Parent width position, used to work out if 
    *                              this divs are horizontal or vertical
    * @return array Array contains the absolute top and left position for the 
    *               div as well as the new positions for the left and top 
    *               for the next call
    */
    private function absolutePositions($sort_order, array $sizes, $top, $left, 
    $parent_width) 
    {
        $positions = array();
                
        if($sort_order == 1) {
            $positions['top'] = $top;
            $positions['left'] = $left;
            
            if($sizes['width'] == $parent_width) {
                $top += $sizes['height'];
            } else {
                $left += $sizes['width'];
            }                
        } else {
            if($sizes['width'] == $parent_width) {
                $positions['top'] = $top;
                $positions['left'] = $left;
                
                $top += $sizes['height'];
            } else {
                $positions['top'] = $top;
                $positions['left'] = $left;
                
                $left += $sizes['width'];
            }
        }
        
        return array('positions'=>$positions, 
                     'top'=>$top, 
                     'left'=>$left);
    }
    
    /**
    * Work out which divs straddle each of the edges of the selected div, we 
    * loop over each of the divs in the divs array ignoring the selected div
    * 
    * @return void Writes the ids of the divs to the edge properties
    */
    private function straddleEdges() 
    {
        $this->top_edge = array('above'=>array(), 'below'=>array());
        $this->right_edge = array('right'=>array(), 'left'=>array());
        $this->bottom_edge = array('above'=>array(), 'below'=>array());
        $this->left_edge = array('right'=>array(), 'left'=>array());
        
        foreach($this->divs as $k=>$div) {
            if($k != $this->div['id']) {
                // Above and below the top edge
                if($this->div['edges']['top'] == 
                $div['edges']['bottom']) {
                    $this->top_edge['above'][] = $k;
                }            
                if($this->div['edges']['top'] == 
                $div['edges']['top']) {
                    $this->top_edge['below'][] = $k;
                }
                
                // Above and below the bottom edge
                if($this->div['edges']['bottom'] == 
                $div['edges']['top']) {
                    $this->bottom_edge['below'][] = $k;
                }            
                if($this->div['edges']['bottom'] == 
                $div['edges']['bottom']) {
                    $this->bottom_edge['above'][] = $k;
                }
                
                // Right and left of right edge
                if($this->div['edges']['right'] == 
                $div['edges']['right']) {
                    $this->right_edge['left'][] = $k;
                }            
                if($this->div['edges']['right'] == 
                $div['edges']['left']) {
                    $this->right_edge['right'][] = $k;
                }
                
                // Right and left of left edge
                if($this->div['edges']['left'] == 
                $div['edges']['right']) {
                    $this->left_edge['left'][] = $k;
                }            
                if($this->div['edges']['left'] == 
                $div['edges']['left']) {
                    $this->left_edge['right'][] = $k;
                }
            }
        }
    }
}