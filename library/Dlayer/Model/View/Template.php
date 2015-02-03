<?php
/**
* Template view model
* 
* The view model is responsible for fetching all the data that makes up a 
* template as shown in the designers.
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Template.php 1004 2013-09-29 00:07:09Z Dean.Blackborough $
* @category View model
*/
class Dlayer_Model_View_Template extends Zend_Db_Table_Abstract
{
    /**
    * Fetch the div heights for the requested array of div ids. In addition 
    * to returning an array which contains all the heights indexed by div id 
    * it ensures that the correct number of results are returned and checks 
    * that all the divs belong to the given template and site
    * 
    * @param array $ids Array of div ids
    * @param integer $template_id
    * @param integer $site_id
    * @return array|FALSE Array containing two indexes for each div id, the
    *                     height and whether or not the div is a ficed height 
    *                     item
    */
    public function heights(array $ids, $template_id, $site_id)
    {
        if(count($ids) > 0) {
            $sql = "SELECT ustds.div_id, ustds.height, ustds.design_height
                    FROM user_site_template_div_sizes ustds
                    JOIN user_site_templates ust ON ustds.template_id = ust.id
                    WHERE ustds.template_id = :template_id
                    AND ust.site_id = :site_id
                    AND ustds.div_id IN (" . implode(', ', $ids) . ")";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll();

            if(count($result) == count($ids)) {
                $heights = array();

                foreach($result as $row) {
                    if($row['height'] != 0) {
                        $heights[$row['div_id']] =
                            array('height'=>intval($row['height']),
                                  'fixed'=>TRUE);
                    } else {
                        $heights[$row['div_id']] =
                            array('height'=>intval($row['design_height']),
                                  'fixed'=>FALSE);
                    }
                }

                return $heights;
            } else {
                return FALSE;
            }
        } else {
            return array();
        }
    }

    /**
    * Fetch the div widths for the requested array of div ids. In addition 
    * to returning an array which contains all the widths indexed by div id 
    * it ensures that the correct number of results are returned and checks 
    * that all the divs belong to the given template and site
    *
    * @param array $ids Array of div ids
    * @param integer $template_id
    * @param integer $site_id
    * @return array|FALSE Div indexed array with the with of the div as the 
    *                     value
    */
    public function widths(array $ids, $template_id, $site_id)
    {
        if(count($ids) > 0) {
            $sql = "SELECT ustds.div_id, ustds.width
                    FROM user_site_template_div_sizes ustds
                    WHERE ustds.site_id = :site_id
                    AND ustds.template_id = :template_id
                    AND ustds.div_id IN (" . implode(', ', $ids) . ")";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll();

            if(count($result) == count($ids)) {
                $widths = array();

                foreach($result as $row) {
                    $widths[$row['div_id']] = intval($row['width']);
                }

                return $widths;
            } else {
                return FALSE;
            }
        } else {
            return array();
        }
    }

    /**
    * Fetch all the parents of the requested div, calls a recursive method 
    * which carries on going until all the parents have been selected
    *
    * @param integer $id Id of the div we want to pull parents for
    * @param integer $template_id
    * @param integer $site_id
    * @return array Indexed array of div ids
    */
    public function parents($id, $template_id, $site_id)
    {
        $stmt = $this->parentsSqlStatement();
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if($result != FALSE) {
            $this->parents[] = $result['parent_id'];
            $this->parents($result['parent_id'], $template_id, $site_id);
        }

        return $this->parents;
    }

    /**
    * Private property to store the div ids when the parents() method is 
    * called
    *
    * @var array
    */
    private $parents = array();

    /**
    * Private property used to store the prepared statement for the parents() 
    * method, because only the params change there is no need to re prepare the 
    * query
    * 
    * @var PDOStatement
    */
    private $stmt_parents = NULL;

    /**
    * Returns the prepared statement for the parents() method, checks to 
    * see if the statement has already been prepared, if so returns the 
    * prepared statement reather than preparing again
    *
    * @return PDOStatement
    */
    private function parentsSqlStatement()
    {
        if($this->stmt_parents == NULL) {
            $sql = "SELECT parent_id
                    FROM user_site_template_divs
                    WHERE id = :id
                    AND template_id = :template_id
                    AND site_id = :site_id
                    AND parent_id <> 0
                    LIMIT 1";
            return $this->_db->prepare($sql);
        } else {
            return $this->stmt_parents;
        }
    }

    /**
    * Check to see if the template is empty, as in no divs have been added to 
    * the template, 
    * 
    * Check to see if the template is empty, this is the only time that the
    * div id should be equal to zero. Used by the set div id method in the 
    * session template class, it is possible for the user to set the div id 
    * to zero when the template is empty and only when the template is empty
    *
    * @param integer $site_id
    * @param integer $template_id
    * @return boolean TRUE if the template is empty
    */
    public function templateEmpty($site_id, $template_id)
    {
        $sql = "SELECT id
                FROM user_site_template_divs
                WHERE site_id = :site_id
                AND template_id = :template_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        if(count($result) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
    * Check to see if the div id exists for the given template, if the div is 
    * the base div, with an id of zero we just default to TRUE.
    *
    * @param integer $id Template div id
    * @param integer $template_id Template id
    * @return boolean TRUE if the div exists in the template
    */
    public function divExists($id, $template_id)
    {
        if($id != 0) {
            $sql = "SELECT ustd.id
                    FROM user_site_template_divs ustd
                    JOIN user_site_templates ust ON ustd.template_id = ust.id
                    WHERE ustd.id = :id
                    AND ustd.template_id = :template_id";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch();

            if($result != FALSE) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

    /**
    * Private property to store the site id so it doesn't need to be passed in 
    * multiple times
    * 
    * @var integer
    */
    private $site_id;
    
    /**
    * Private property to store the template is so it doesn't need to be passed 
    * in multiple times
    * 
    * @var integer
    */
    private $template_id;

    /**
    * Prepared statement for the query used by the template method, query is 
    * used by the template and the recursive child method for the template
    *
    * @var PDOStatement
    */
    private $stmt_template = NULL;

    /**
    * Prepare the template method stmt, called by the base method and the
    * recursive child method, this method either returns the already
    * generated statement or create the statement
    *
    * @return PDOStatement
    */
    private function stmtTemplate()
    {
        if($this->stmt_template == NULL) {
            $sql = "SELECT ustd.id, ustds.width, ustds.height,
                    ustds.design_height, 
                    IF(ustds.height=0,0,1) AS fixed 
                    FROM user_site_template_divs ustd
                    JOIN user_site_template_div_sizes ustds
                        ON ustd.id = ustds.div_id
                        AND ustds.site_id = :site_id
                    JOIN user_site_templates ust
                        ON ustd.template_id = ust.id
                        AND ust.site_id = :site_id
                    WHERE ustd.site_id = :site_id
                    AND ustd.template_id = :template_id
                    AND ustd.parent_id = :parent_id
                    ORDER BY ustd.sort_order ASC";
            return $this->_db->prepare($sql);
        } else {
            return $this->stmt_template;
        }
    }

    /**
    * Fetch the divs that make up the given template, calls a recursive
    * method to fetch all the child divs. The array returned by this method
    * needs to be passed to the template view helper
    *
    * @param integer $site_id
    * @param integer $template_id
    * @return array
    */
    public function template($site_id, $template_id)
    {
        $this->site_id = $site_id;
        $this->template_id = $template_id;

        $stmt = $this->stmtTemplate();
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':template_id', $this->template_id, PDO::PARAM_INT);
        $stmt->bindValue(':parent_id', 0, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $template = array();

        foreach($result as $row) {
            $div = array('id'=>$row['id'],
                         'sizes'=>array('width'=>$row['width'],
                                        'height'=>$row['height'],
                                        'design_height'=>$row['design_height'], 
                                        'fixed'=>$row['fixed']));
            $div['children'] = $this->templateDivChildren($row['id']);

            $template[] = $div;
        }

        return $template;
    }

    /**
    * Fetch the children for the requested div, recursive method, carries on 
    * fetching all the children till there are no more to select. Always 
    * returns an array, regardless of whether or not there are childrem
    * 
    * @param integer $parent_id
    * @return array Array of children for the requested div
    */
    private function templateDivChildren($parent_id)
    {
        $stmt = $this->stmtTemplate();
        $stmt->bindValue(':site_id', $this->site_id, PDO::PARAM_INT);
        $stmt->bindValue(':template_id', $this->template_id, PDO::PARAM_INT);
        $stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $children = array();

        if(count($result) > 0) {
            foreach($result as $row) {
                $div = array('id'=>$row['id'],
                             'sizes'=>array('width'=>$row['width'],
                                            'height'=>$row['height'],
                                            'design_height'=>$row['design_height'], 
                                            'fixed'=>$row['fixed']));

                $div['children'] = $this->templateDivChildren($row['id']);

                $children[] = $div;
            }
        }

        return $children;
    }
    
    /**
    * Fetch the divs that are children of the requested parent, returns an 
    * array with the divs and their total widths and heights using the design 
    * height if required.
    * 
    * The total width or height of a div includes the propeties that get 
    * added to the widget or height, an exmaple being borders.
    * 
    * @param integer $site_id
    * @param integer $template_id
    * @param integer $parent_id Id of the parent div
    * @param array $borders Array of borders for the template
    * @return array
    */
    public function divsByParentId($site_id, $template_id, $parent_id=0, 
    array $borders=array()) 
    {
        $sql = "SELECT ustd.id, ustds.width, ustds.height, ustds.design_height, 
                ustd.sort_order 
                FROM user_site_template_divs ustd 
                JOIN user_site_template_div_sizes ustds 
                    ON ustd.id = ustds.div_id 
                WHERE ustd.site_id = :site_id 
                AND ustd.template_id = :template_id 
                AND ustd.parent_id = :parent_id 
                AND ustds.site_id = :site_id 
                ORDER BY ustd.sort_order ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':parent_id', $parent_id, PDO::PARAM_INT);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':template_id', $template_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $divs = array();
        
        foreach($result as $row) {
            
            $sizes = array('width'=>$row['width']);
            
            if($row['height'] != 0) {
                $sizes['height'] = $row['height'];
            } else {
                $sizes['height'] = $row['design_height'];
            }
            
            if(array_key_exists($row['id'], $borders) == TRUE) {
                $sizes['height'] += $borders[$row['id']]['height'];
                $sizes['width'] += $borders[$row['id']]['width'];
            } 
            
            $row['sizes'] = $sizes;
            
            $divs[] = $row;
        }
        
        return $divs;
    }
}
