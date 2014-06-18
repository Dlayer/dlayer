<?php
/**
* Development log
* 
* The site shows a sub set of the development changes, the development log 
* shows more friendly versions of some SVN updates
*
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Development.php 1240 2013-11-14 16:27:15Z Dean.Blackborough $
* @category Model
*/
class Dlayer_Model_Development extends Zend_Db_Table_Abstract
{
    /**
    * Fetch the development changes, records are pulled back based on the 
    * current pagination params
    *
    * @param integer $n Number of records to return
    * @param integer $start Start selecting at this record
    * @return array Result array has two indexes, results and count, results
    *               is the array of returned records, count is the number
    *               of records in the result set
    */
    public function updates($n=25, $start=0)
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS `change`,
                DATE_FORMAT(added, '%D %b %Y') AS change_date, `release` 
                FROM dlayer_development_log
                WHERE enabled = 1
                ORDER BY added DESC ";
        if($start == 0) {
            $sql .= "LIMIT :limit";
        } else {
            $sql .= "LIMIT :start, :limit";
        }

        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':limit', $n, PDO::PARAM_INT);
        if($start > 0) {
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        }
        $stmt->execute();

        $results = $stmt->fetchAll();

        $stmt = $this->_db->prepare("SELECT FOUND_ROWS()");
        $stmt->execute();

        $count = $stmt->fetch();

        return array('results'=>$results,
                     'count'=>intval($count['FOUND_ROWS()']));
    }
}