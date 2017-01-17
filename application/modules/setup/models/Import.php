<?php

ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

/**
 * Import model
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Setup_Model_Import extends Zend_Db_Table_Abstract
{
    private $tables = array(
        'designer_color_palette',
        'designer_color_palette_color',
        'designer_color_type',
        'designer_content_heading',
        'designer_content_type',
        'designer_css_border_style',
        'designer_css_font_family',
        'designer_css_text_decoration',
        'designer_css_text_style',
        'designer_css_text_weight',
        'designer_form_field_attribute',
        'designer_form_field_attribute_type',
        'designer_form_field_param_preview',
        'designer_form_field_type',
        'designer_form_layout',
        'designer_form_preview_method',
        'dlayer_identity',
        'dlayer_module',
        'dlayer_module_tool',
        'dlayer_module_tool_tab',
        'dlayer_session',
        'dlayer_setting',
        'dlayer_setting_group',
        'dlayer_setting_scope',
        'user_setting_color_history',
        'user_setting_color_palette',
        'user_setting_color_palette_color',
        'user_setting_font_and_text',
        'user_setting_heading',
        'user_site',
        'user_site_content_heading',
        'user_site_content_html',
        'user_site_content_jumbotron',
        'user_site_content_text',
        'user_site_form',
        'user_site_form_field',
        'user_site_form_field_attribute',
        'user_site_form_field_row_background_color',
        'user_site_form_layout',
        'user_site_form_setting',
        'user_site_history',
        'user_site_image_library',
        'user_site_image_library_category',
        'user_site_image_library_link',
        'user_site_image_library_sub_category',
        'user_site_image_library_version',
        'user_site_image_library_version_meta',
        'user_site_page',
        'user_site_page_content_item_form',
        'user_site_page_content_item_heading',
        'user_site_page_content_item_html',
        'user_site_page_content_item_image',
        'user_site_page_content_item_jumbotron',
        'user_site_page_content_item_text',
        'user_site_page_meta',
        'user_site_page_structure_column',
        'user_site_page_structure_content',
        'user_site_page_structure_row',
        'user_site_page_styling_column_background_color',
        'user_site_page_styling_content_item_background_color',
        'user_site_page_styling_content_item_typography',
        'user_site_page_styling_page_background_color',
        'user_site_page_styling_row_background_color'
    );

    private $tables_clean = array(
        'designer_color_palette',
        'designer_color_palette_color',
        'designer_color_type',
        'designer_content_heading',
        'designer_content_type',
        'designer_css_border_style',
        'designer_css_font_family',
        'designer_css_text_decoration',
        'designer_css_text_style',
        'designer_css_text_weight',
        'designer_form_field_attribute',
        'designer_form_field_attribute_type',
        'designer_form_field_param_preview',
        'designer_form_field_type',
        'designer_form_layout',
        'designer_form_preview_method',
        'dlayer_module',
        'dlayer_module_tool',
        'dlayer_module_tool_tab',
        'dlayer_setting',
        'dlayer_setting_group',
        'dlayer_setting_scope'
    );

    private $messages = array();
    private $errors = array();

    /**
     * Set foreign key checks value
     *
     * @param integer $value
     * @return string
     */
    public function setForeignKeyChecks($value)
    {
        return "SET FOREIGN_KEY_CHECKS = {$value};" . PHP_EOL;
    }

    /**
     * Reset the messages array
     *
     * @return void
     */
    public function resetMessages()
    {
        $this->messages = array();
    }

    /**
     * Reset the errors array
     *
     * @return void
     */
    public function resetErrors()
    {
        $this->errors = array();
    }

    /**
     * Get message
     *
     * @return array
     */
    public function messages()
    {
        return $this->messages;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Add an error to the errors array
     *
     * @param string $message
     */
    public function addError($message)
    {
        $this->errors[] = $message;
    }

    /**
     * Add an error to the messages array
     *
     * @param string $message
     */
    private function addMessage($message)
    {
        $this->messages[] = $message;
    }

    /**
     * Number of database tables
     */
    public function numberOfTables()
    {
        return count($this->tables);
    }

    /**
     * Number of tables in database
     */
    public function numberOfTablesInDatabase()
    {
        $stmt = $this->_db->prepare('SHOW TABLES');
        $stmt->execute();

        return count($stmt->fetchAll());
    }

    /**
     * Create tables, stops on error
     *
     * @return boolean
     */
    public function createTables()
    {
        if ($this->numberOfTablesInDatabase() === 0) {
            foreach ($this->tables as $table) {
                $file = file_get_contents(DLAYER_SETUP_PATH . '/tables/structure/' . $table . '.sql');
                if ($file !== false) {

                    try {
                        $stmt = $this->_db->prepare($file);
                        $result = $stmt->execute();
                    } catch (Exception $e) {
                        $this->addError('Unable to create table: ' . $table . ' ' . $e->getMessage());
                        return false;
                    }

                    if ($result === false) {
                        $this->addError('Unable to create table: ' . $table);
                        return false;
                    } else {
                        $this->addMessage('Successfully created table: ' . $table);
                    }
                } else {
                    $this->addError('Unable to read file to create table: ' . $table);
                    return false;
                }
            }
        } else {
            $this->addError('Your database has tables, this script will not run until you empty your database, please make 
            sure to make a backup first');

            return false;
        }

        return true;
    }

    /**
     * Import the table data
     *
     * @param boolean $clean
     * @return boolean
     */
    public function importTableData($clean = false)
    {
        if ($this->numberOfTablesInDatabase() === $this->numberOfTables()) {

            $query = '';

            if ($clean === false) {
                $tables = $this->tables;
            } else {
                $tables = $this->tables_clean;
            }

            foreach ($tables as $k => $table) {
                $file = file_get_contents(DLAYER_SETUP_PATH . '/tables/data/' . $table . '.sql');
                if ($file !== false) {
                    $query .= $file . PHP_EOL;
                } else {
                    $this->addError('Unable to read file to import data for table: ' . $table);
                    return false;
                }
            }

            try {
                $stmt = $this->_db->prepare($query);
                $result = $stmt->execute();
            } catch (Exception $e) {
                $this->addError('Error importing data ' . $e->getMessage());
                return false;
            }

            if ($result !== false) {
                $this->addMessage('Data imported');
            } else {
                $this->addError('Error importing data');
                return false;
            }
        } else {
            $this->addError('The number of table in the database is not correct, if differs from what we expect, there are 
             ' .  $this->numberOfTables() . ' defined for Dlayer but ' . $this->numberOfTablesInDatabase() . ' in your Database');

            return false;
        }

        return true;
    }

    /**
     * Drop all the Dlayer tables
     *
     * @return boolean
     */
    public function dropTables()
    {
        $query = $this->setForeignKeyChecks(0);

        foreach ($this->tables as $k => $table) {
            $query .= "DROP TABLE `{$table}`;" . PHP_EOL;
        }

        $query .= $this->setForeignKeyChecks(1);

        try {
            $stmt = $this->_db->prepare($query);
            $result = $stmt->execute();
        } catch (Exception $e) {
            $this->addError('Error dropping Dlayer tables ' . $e->getMessage());
            return false;
        }

        if ($result !== false) {
            $this->addMessage('All Dlayer tables dropped:');
            foreach ($this->tables as $table) {
                $this->addMessage(" --- Table `{$table}` dropped");
            }
            return true;
        } else {
            $this->addError('Error dropping Dlayer tables');
            return false;
        }
    }

    /**
     * Set the foreign keys
     *
     * @return boolean
     */
    public function setForeignKeys()
    {
        if ($this->numberOfTablesInDatabase() === $this->numberOfTables()) {
            foreach ($this->tables as $table) {
                $file = file_get_contents(DLAYER_SETUP_PATH . '/tables/keys/' . $table . '.sql');
                if ($file !== false) {

                    try {
                        $stmt = $this->_db->prepare($file);
                        $result = $stmt->execute();
                    } catch (Exception $e) {
                        $this->addError('Unable to set foreign keys for table: ' . $table . ' ' . $e->getMessage());
                        return false;
                    }

                    if ($result === false) {
                        $this->addError('Unable to set foreign keys for table: ' . $table);
                        return false;
                    } else {
                        $this->addMessage('Successfully set foreign keys for table: ' . $table);
                    }
                } else {
                    $this->addError('Unable to read file to set foreign keys for table: ' . $table);
                    return false;
                }
            }
        } else {
            $this->addError('The number of table in the database is not correct, if differs from what we expect, there are 
             ' .  $this->numberOfTables() . ' defined for Dlayer but ' . $this->numberOfTablesInDatabase() . ' in your Database');

            return false;
        }

        return true;
    }

}
