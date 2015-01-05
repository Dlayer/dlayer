<?php
/**
* Base settings module, conatins all the methods for settings data that is 
* not module specific
* 
* @author Dean Blackborough <dean@g3d-development.com>
* @copyright G3D Development Limited
* @version $Id: Settings.php 1724 2014-04-13 15:12:59Z Dean.Blackborough $
*/
class Dlayer_Model_Settings extends Zend_Db_Table_Abstract 
{   
    /**
    * Fetch all font families
    * 
    * @return array
    */
    public function fontFamilies() 
    {
        $sql = "SELECT dcff.id, dcff.css, dcff.description 
                FROM designer_css_font_families dcff 
                ORDER BY dcff.sort_order ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $rows = array();
        
        foreach($result as $row) {
            $rows[$row['id']] = array('name'=>$row['description'], 
            'css'=>$row['css']);
        }
        
        return $rows;
    }
    
    /**
    * Fetch all font styles
    * 
    * @return array
    */
    public function fontStyles() 
    {
        $sql = "SELECT dcts.id, dcts.css, dcts.`name` 
                FROM designer_css_text_styles dcts 
                ORDER BY dcts.sort_order";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $rows = array();
        
        foreach($result as $row) {
            $rows[$row['id']] = array('name'=>$row['name'], 
            'css'=>$row['css']);
        }
        
        return $rows;
    }
    
    /**
    * Fetch all the font weights
    * 
    * @return array
    */
    public function fontWeights() 
    {
        $sql = "SELECT dctw.id, dctw.css, dctw.`name` 
                FROM designer_css_text_weights dctw 
                ORDER BY dctw.sort_order";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $rows = array();
        
        foreach($result as $row) {
            $rows[$row['id']] = array('name'=>$row['name'], 
            'css'=>$row['css']);
        }
        
        return $rows;
    }
    
    /**
    * Fetch all the font decorations
    * 
    * @return array
    */
    public function fontDecorations() 
    {
        $sql = "SELECT dctd.id, dctd.css, dctd.`name` 
                FROM designer_css_text_decorations dctd 
                ORDER BY dctd.sort_order";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $rows = array();
        
        foreach($result as $row) {
            $rows[$row['id']] = array('name'=>$row['name'], 
            'css'=>$row['css']);
        }
        
        return $rows;
    }
    
    /**
    * Fetch all the heading styles 
    * 
    * @return array 
    */
    public function headingStyles() 
    {
        $sql = "SELECT dch.id, dch.`name` 
                FROM designer_content_headings dch 
                ORDER BY dch.sort_order ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        
        $rows = array();
        
        foreach($result as $row) {
            $rows[$row['id']] = array('name'=>$row['name']);
        }
        
        return $rows;
    }
    
    /**
    * Create the initial color palettes, called when a new site is created
    * 
    * @param integer $site_id
    * @return void
    */
    public function setDefaultColorPalettes($site_id) 
    {
    	$sql = "INSERT INTO user_settings_color_palettes 
    			(site_id, `name`, view_script, sort_order) 
    			VALUES 
    			(:site_id, :name, :view_script, :sort_order)";
    	$stmt = $this->_db->prepare($sql);
    	$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
    	
		for($i=1;$i<4;$i++) {
			$stmt->bindValue(':name', 'Palette ' . $i, PDO::PARAM_STR);
			$stmt->bindValue(':view_script', 'palette-' . $i, PDO::PARAM_STR);
			$stmt->bindValue(':sort_order', $i, PDO::PARAM_INT);
			$stmt->execute();
		}
    }
    
    /**
    * Set the initial colors for the initial palettes, called when a new 
    * site is created
    * 
    * @param integer $site_id
    * @return void
    */
    public function setDefaultColourPaletteColors($site_id) 
    {
    	$palettes = array();
    	
		$palettes[1] = array(array('type'=>1, 'name'=>'Black', 'hex'=>'#000000'), 
		array('type'=>2, 'name'=>'Tan', 'hex'=>'#f3f1df'), 
		array('type'=>3, 'name'=>'Dark grey', 'hex'=>'#666666'));
		
		$palettes[2] = array(array('type'=>1, 'name'=>'Blue', 'hex'=>'#336699'), 
		array('type'=>2, 'name'=>'Dark grey', 'hex'=>'#666666'), 
		array('type'=>3, 'name'=>'Grey', 'hex'=>'#999999'));
		
		$palettes[3] = array(array('type'=>1, 'name'=>'Blue', 'hex'=>'#003366'), 
		array('type'=>2, 'name'=>'White', 'hex'=>'#FFFFFF'), 
		array('type'=>3, 'name'=>'Orange', 'hex'=>'#FF6600'));
		
		$sql = "INSERT INTO user_settings_color_palette_colors 
				(site_id, palette_id, color_type_id, `name`, color_hex) 
				VALUES 
				(:site_id, :palette_id, :color_type_id, :name, :color_hex)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		
		foreach($palettes as $i=>$palette) {
			
			$sql_palette = "SELECT id FROM user_settings_color_palettes 
							WHERE site_id = :site_id 
							AND view_script = :view_script 
							LIMIT 1";
			$stmt_palette = $this->_db->prepare($sql_palette);
			$stmt_palette->bindValue(':site_id', $site_id, PDO::PARAM_INT);
			$stmt_palette->bindValue(':view_script', 'palette-' . $i, 
			PDO::PARAM_INT);
			$stmt_palette->execute();
			
			$result = $stmt_palette->fetch();
			
			$palette_id = $result['id'];
			
			foreach($palette as $color) {
				$stmt->bindValue(':palette_id', $palette_id, PDO::PARAM_INT);
				$stmt->bindValue(':color_type_id', $color['type'], 
				PDO::PARAM_INT);
				$stmt->bindValue(':name', $color['name'], PDO::PARAM_STR);
				$stmt->bindValue(':color_hex', $color['hex'], PDO::PARAM_STR);
				$stmt->execute();
			}			
		}
	}
    
    /**
    * Set the initial base font families, called when a new site is created, 
    * set the content and form builder to Helvetica, Arial, Nimbus Sans L
    * 
    * @param integer $site_id
    * @return void
    */
    public function setDefaultBaseFontFamilies($site_id) 
    {
        $sql = "INSERT INTO user_settings_font_families 
                (site_id, module_id, font_family_id) 
                VALUES 
                (:site_id, :module_id, :font_family_id)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':font_family_id', 1, PDO::PARAM_INT);
        
        $stmt->bindValue(':module_id', 3, PDO::PARAM_INT);
        $stmt->execute();
        
        $stmt->bindValue(':module_id', 4, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    /**
    * Set the initial heading styles, called when a new site is created
    * 
    * @param integer $site_id 
    * @return void
    */
    public function setDefaultHeadingStyles($site_id) 
    {
        $headings = array();
        
        $headings[] = array('heading_id'=>1, 'style_id'=>1, 'weight_id'=>2, 
        'decoration_id'=>1, 'size'=>22, 'color_hex'=>'#000000', 
        'sort_order'=>1);
        
        $headings[] = array('heading_id'=>2, 'style_id'=>1, 'weight_id'=>2, 
        'decoration_id'=>1, 'size'=>18, 'color_hex'=>'#000000', 
        'sort_order'=>2);
        
        $headings[] = array('heading_id'=>3, 'style_id'=>1, 'weight_id'=>2, 
        'decoration_id'=>1, 'size'=>16, 'color_hex'=>'#000000', 
        'sort_order'=>3);
        
        $headings[] = array('heading_id'=>4, 'style_id'=>1, 'weight_id'=>2, 
        'decoration_id'=>2, 'size'=>14, 'color_hex'=>'#000000', 
        'sort_order'=>4);
        
        $headings[] = array('heading_id'=>5, 'style_id'=>2, 'weight_id'=>2, 
        'decoration_id'=>1, 'size'=>14, 'color_hex'=>'#000000', 
        'sort_order'=>5);
        
        $headings[] = array('heading_id'=>6, 'style_id'=>1, 'weight_id'=>1, 
        'decoration_id'=>1, 'size'=>12, 'color_hex'=>'#000000', 
        'sort_order'=>6);
        
        $sql = "INSERT user_settings_headings 
                (site_id, heading_id, style_id, weight_id, decoration_id, 
                size, color_hex, sort_order) 
                VALUES 
                (:site_id, :heading_id, :style_id, :weight_id, :decoration_id, 
                :size, :color_hex, :sort_order)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        
        foreach($headings as $heading) {
            $stmt->bindValue(':heading_id', $heading['heading_id'], 
            PDO::PARAM_INT);
            $stmt->bindValue(':style_id', $heading['style_id'], 
            PDO::PARAM_INT);
            $stmt->bindValue(':weight_id', $heading['weight_id'], 
            PDO::PARAM_INT);
            $stmt->bindValue(':decoration_id', $heading['decoration_id'], 
            PDO::PARAM_INT);
            $stmt->bindValue(':size', $heading['size'], PDO::PARAM_INT);
            $stmt->bindValue(':color_hex', $heading['color_hex'], 
            PDO::PARAM_INT);
            $stmt->bindValue(':sort_order', $heading['sort_order'], 
            PDO::PARAM_INT);
            $stmt->execute();
        }
    }
    
    /**
    * Fetch all the active setting groups, only pulls back groups for active 
    * modules
    * 
    * @return array
    */
    public function settingGroups() 
    {
		$sql = "SELECT dsg.`name`, dsg.title, dsg.url 
				FROM dlayer_settings_groups dsg 
				JOIN dlayer_modules dm ON dsg.module_id = dm.id 
					AND dm.enabled = 1 
				WHERE dsg.enabled = 1
				ORDER BY dsg.sort_order ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->execute();
		
		return $stmt->fetchAll();
    }
    
    /**
    * Fetch all the active settings for the requested setting group, setting, 
    * group and module all need to be active
    * 
    * @param string $group
    * @return array
    */
    public function settings($group) 
    {
		$sql = "SELECT ds.`name`, ds.title, ds.url 
				FROM dlayer_settings ds 
				JOIN dlayer_settings_groups dsg ON ds.setting_group_id = dsg.id 
					AND ds.enabled = 1 
				JOIN dlayer_modules dm ON dsg.module_id = dm.id 
					AND dm.enabled = 1 
				WHERE ds.enabled = 1 
				AND dsg.`name` = :group 
				ORDER BY ds.sort_order ASC";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':group', $group, PDO::PARAM_STR);
		$stmt->execute();
		
		return $stmt->fetchAll();
    }
    
    /**
    * Setting details
    * 
    * @param string $url
    * @return array|FALSE
    */
    public function setting($url) 
    {
		$sql = "SELECT ds.`name`, ds.title, ds.description, dss.scope, 
				ds.scope_details 
				FROM dlayer_settings ds 
				JOIN dlayer_settings_scope dss ON ds.scope_id = dss.id 
				WHERE ds.url = :url 
				AND ds.enabled = 1";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':url', $url, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch();
    }
    
    /**
    * Set the initial values for the color history table, just use three 
    * colors from one tablet and two from another
    * 
    * @param integer $site_id
    * @return void
    */
    public function setDefaultHistoryColors($site_id) 
    {
		// Need to add five initial history colors for the newly  created site
		
		$colors = array('#f3f1df', '#666666', '#003366', '#FF6600', 'FFFFFF');
		
		$sql = "INSERT INTO user_settings_color_history 
				(site_id, color_hex) 
				VALUES 
				(:site_id, :color_hex)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
		
		foreach($colors as $color) {
			$stmt->bindValue(':color_hex', $color, PDO::PARAM_STR);
			$stmt->execute();
		}
    }
}