<?php
/**
* Simple pagination view helper, generates next and previous links as well as
* 'Records n - m of o' text. Generated a s a UL/LI with a pagination class
* The pagination html is based purely on the vars passed to this helper, it is 
* not tied to the model data in anyway
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Pagination.php 1568 2014-02-14 14:59:50Z Dean.Blackborough $
*/
class Dlayer_View_Pagination extends Zend_View_Helper_Abstract 
{
    private $per_page;
    private $start;
    private $total;
    private $url;
    private $previous;
    private $next;
    private $record;
    private $records;
    private $text_style;
    
    /**
    * Simple pagination view helper, generates next and previous links as well 
    * as the text between the links. The text between the links can be either 
    * of the following formats, 'item n-m of o' or 'page n of m'. All the text 
    * can be changed to whatever suits bests.
    * 
    * @param integer $per_page The number of results per page
    * @param integer $start Start record for paging
    * @param integer $total Total number of results in the full recordset
    * @param string $url URL to use for pagination links, typically the url 
    *                    of the current page
    * @param integer $text_style Text style for text between links, 
    *                            1 = item based, 2 = page based
    * @param string $previous Previous page link text
    * @param string $next Next page link text
    * @param string $record Records n of m text, not relevant if page based 
    *                       text is used
    * @param string $records Rather than work out plural for text, just set it, 
    *                        not relevant if page based text is used
    * @return DLayer_View_Pagination 
    */
    public function pagination($per_page, $start, $total, $url, $text_style=1, 
    $previous='Previous', $next='Next', $record='Record', $records='Records') 
    {
        $this->resetParams();
        
        $this->per_page = intval($per_page);
        $this->start = intval($start);
        $this->total = intval($total);
        $this->url = $this->view->escape($url);
        $this->previous = $this->view->escape($previous);
        $this->next = $this->view->escape($next);
        $this->record = $this->view->escape($record);
        $this->records = $this->view->escape($records);
        if(in_array($text_style, array(1, 2)) == TRUE) {
            $this->text_style = $text_style;
        }
        
        return $this;
    }
    
    /**
    * Reset any internal params, need to reset the params in case the view 
    * helper is called multiple times within the same view.
    * 
    * @return void
    */
    public function resetParams() 
    {
        $this->per_page = 0;
        $this->start = 0;
        $this->total = 0;
        $this->url = NULL;
        $this->text_style = 1;
    }
    
    /**
    * Generate the pagination html
    * 
    * @return string 
    */
    private function render() 
    {
        if($this->total > 0) {        
            $html = '<ul class="pagination">' . PHP_EOL;
            
            $html .= $this->previousPage();            
            $html .= $this->recordsText();            
            $html .= $this->nextPage();
            
            $html .= '</ul>' . PHP_EOL;
        
            return $html;        
        } else {
            return '';
        }
        
        return $html;
    }
    
    /**
    * Generate the html for the previous page link
    * 
    * @return string
    */
    private function previousPage() 
    {
        $html = '';
        
        if($this->start > 0 && ($this->start < $this->total)) { 
            if($this->start > $this->per_page) {
                $html .= '<li>';
                $html .= '<a href="' . $this->url . '/start/';
                $html .= ($this->start - $this->per_page) . '">';
                $html .= $this->previous  .'</a></li>' . PHP_EOL;
            } else {
                $html .= '<li>';
                $html .= '<a href="' . $this->url . '">';
                $html .= $this->previous . '</a></li>' . PHP_EOL;
            }
        }
        
        return $html;
    }
    
    /**
    * Generate the html for the next page link
    * 
    * @return string
    */
    private function nextPage() 
    {
        $html = '';
        
        if($this->total > ($this->start + $this->per_page)) {
            $html .= '<li>'; 
            $html .= '<a href="' . $this->url . '/start/'; 
            $html .= ($this->start + $this->per_page) . '">';
            $html .= $this->next . '</a></li>' . PHP_EOL;
        }
        
        return $html;
    }
    
    /**
    * Generate the html for the current page text, shows which records have 
    * been selected and if more than one page how many records in total
    * 
    * @return string
    */
    private function recordsText() 
    {
        $html = '';
        
        if($this->text_style == 1) {        
            if($this->total > 1) {
                $first = $this->start + 1;
                $of_text = '';
                
                if($this->total > $this->start + $this->per_page) {
                    $last = $this->start + $this->per_page;
                    $of_text = ' of ' . $this->total;
                } else {
                    $last = $this->total;
                }
                            
                $html .= '<li><strong>' . $this->records . ' ' . $first; 
                $html .= ' - ' . $last . $of_text . '</strong></li>' . PHP_EOL;
            } else {
                $html .= '<li><strong>' . $this->record . ' 1 of 1</strong></li>' . 
                PHP_EOL;
            }
        } else {
            if($this->total > $this->per_page) {
                $pages = ceil($this->total/$this->per_page);
                $page = ceil($this->start/$this->per_page)+1;
                
                $html .= '<li><strong>Page ' . $page. ' of ' . $pages . 
                '</strong></li>' . PHP_EOL;
            } else {
                $html .= '<li><strong>Page 1</strong></li>' . PHP_EOL;
            }
        }
        
        return $html;
    }
    
    /**
    * The view helpers can be output directly, no need to call and return the 
    * render method, we define the __toString method so that echo and print 
    * calls on the object return the html generated by the render method
    * 
    * @return string Generated html
    */
    public function __toString() 
    {
        return $this->render();
    }
} 