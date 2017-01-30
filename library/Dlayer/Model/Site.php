<?php

/**
 * Site model
 *
 * A user can create as many sites as they like, a site will be tied to a
 * URL.
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 * @category Model
 */
class Dlayer_Model_Site extends Zend_Db_Table_Abstract
{
    /**
     * Fetch all the sites for the requested identiti
     *
     * @param integer $identity_id
     *
     * @return array Array of the sites, name and id, result is always an array
     *                because there will always be an example site
     */
    public function byIdentity($identity_id)
    {
        $sql = "SELECT id, `name`
				FROM user_site
				WHERE identity_id = :identity_id
				ORDER BY `name` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Fetch a list of sites for the control bar
     *
     * @param integer $identity_id
     * @param integer $active_site_id
     *
     * @return array Array of the sites, name and id, for the control bar
     */
    public function sitesForControlBar($identity_id, $active_site_id)
    {
        $sql = "SELECT 
                    `id`, 
                    `name`
				FROM 
				    `user_site`
				WHERE 
				    `identity_id` = :identity_id
				ORDER BY 
				    `name` ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        $stmt->execute();

        $sites = array();

        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $append = null;
            if (intval($row['id']) === $active_site_id) {
                $append = ' (Active)';
            }
            $sites[] = array(
                'uri' => '/dlayer/index/activate/site/' . $row['id'],
                'name' => $row['name'] . $append
            );
        }

        return $sites;
    }

    /**
     * Fetch the id for the last accessed site, if for some reason there is
     * no existing value we pull the id for the 'Sample site'
     *
     * @return array, Site name and site id
     */
    public function lastAccessedSite($identity_id)
    {
        $sql = "SELECT us.`name`, ush.site_id
				FROM user_site_history ush
				JOIN user_site us ON ush.site_id = us.id
				WHERE us.identity_id = :identity_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result !== false) {
            return $result;
        } else {
            $name = 'Sample site 1';

            $sql = "SELECT id
					FROM user_site
					WHERE identity_id = :identity_id
					AND `name` = :name";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch();

            if ($result !== false) {
                // Insert entry into history table
                $sql = "INSERT INTO user_site_history
						(identity_id, site_id)
						VALUES
						(:identity_id, :site_id)";
                $stmt = $this->_db->prepare($sql);
                $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
                $stmt->bindValue(':site_id', $result['id'], PDO::PARAM_INT);
                $stmt->execute();

                return array('name' => $name, 'site_id' => $result['id']);
            } else {
                $model_sites = new Dlayer_Model_Site();
                $site_id = $model_sites->addSite($name, $identity_id);

                return array('name' => $name, 'site_id' => $site_id);
            }
        }
    }

    /**
     * Fetch the details for the requested web site
     *
     * The method should only be called after the validateSiteId(); action helper, the helper checks that the
     * site id exists and belongs to the currently logged in user
     *
     * @param integer $site_id
     *
     * @return array|FALSE Either and indexed array of the site data or FALSE
     */
    public function site($site_id)
    {
        $sql = "SELECT id, `name` 
				FROM user_site
				WHERE id = :site_id
				LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Check to see if the supplied id is a valid site
     *
     * @param integer $site_id
     * @param integer $identity_id
     *
     * @return boolean TRUE if the site id is valid
     */
    public function valid($site_id, $identity_id)
    {
        $sql = "SELECT id
				FROM user_site
				WHERE id = :site_id
				AND identity_id = :identity_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch() != false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update the site history table, this table stores the id of the last
     * accessed site for the user.
     *
     * @param integer $site_id
     * @param integer $identity_id
     *
     * @return void
     */
    public function setLastAccessedSite($site_id, $identity_id)
    {
        $sql = "UPDATE user_site_history
				SET site_id = :site_id
				WHERE identity_id = :identity_id
				LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Check to see if the site name is unique, needs to be unique for the
     * current identity id
     *
     * @param string $name
     * @param inetegr $identity_id
     * @param integer|NULL $site_id If in edit mode we need to supply the id of
     *                               the current site so that the row can be
     *                               excluded from the query
     *
     * @return boolean TRUE if the tested site name is unique
     */
    public function nameUnique($name, $identity_id, $site_id = null)
    {
        $where = null;

        if ($site_id != null) {
            $where = 'AND id != :site_id ';
        }

        $sql = "SELECT id
				FROM user_site
				WHERE UPPER(`name`) = :name
				AND identity_id = :identity_id ";
        $sql .= $where;
        $sql .= "LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':name', strtoupper($name), PDO::PARAM_STR);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        if ($site_id != null) {
            $stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        }
        $stmt->execute();

        $result = $stmt->fetch();

        if ($result == false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Add a new website and set the defaul options
     *
     * @param string $name Site name
     * @param integer $identity_id Id of the user site belongs to
     *
     * @return integer|FALSE Either the id of the new site or FALSE upon failure
     */
    private function addSite($name, $identity_id)
    {
        $sql = "INSERT INTO `user_site` 
				(
				    `identity_id`, 
				    `name`
                ) 
				VALUES 
				(
				    :identity_id, 
				    :name
                )";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        $result = $stmt->execute();

        if ($result === true) {
            $site_id = $this->_db->lastInsertId('user_site');

            $model_settings = new Dlayer_Model_Settings();
            $model_settings->setDefaultColorPalettes($site_id);
            $model_settings->setDefaultColourPaletteColors($site_id);
            $model_settings->setDefaultBaseFontFamilies($site_id);
            $model_settings->setDefaultHeadingStyles($site_id);
            $model_settings->setDefaultHistoryColors($site_id);

            return $site_id;
        } else {
            return false;
        }
    }

    /**
     * Edit the details for the requested web site
     *
     * @param string $name
     * @param integer $id
     *
     * @return boolean
     */
    private function editSite($name, $id)
    {
        $sql = "UPDATE user_site
				SET `name` = :name
				WHERE id = :site_id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':site_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Save the web site, either inserts a new record or updates the given record
     *
     * @param string $name Name of site within Dlayer
     * @param integer|NULL $id Site id when editing
     *
     * @return integer|FALSE Either the site id or FALSE upon failure
     */
    public function saveSite($name, $id = null)
    {
        if ($id === null) {
            $session_dlayer = new Dlayer_Session();
            $id = $this->addSite($name, $session_dlayer->identityId());
        } else {
            $id = $this->editSite($name, $id);
        }

        return $id;
    }
}
