<?php

/**
 * Handle any app authentication
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright G3D Development Limited
 * @license https://github.com/Dlayer/dlayer/blob/master/LICENSE
 */
class Dlayer_Model_Authentication extends Zend_Db_Table_Abstract
{
    private $salt = null;

    private $identity_id = null;

    /**
     * Set the salt to use for all crypt calls
     *
     * @param string $salt
     *
     * @return void
     */
    public function setSalt($salt)
    {
        $this->salt = '$6$rounds=5000$' . $salt . '$';
    }

    /**
     * Get the salt
     *
     * @return string
     * @throws Exception
     */
    private function salt()
    {
        if ($this->salt !== null && strlen($this->salt) > 3) {
            return $this->salt;
        } else {
            throw new Exception('Salt not or salt  set in authentication model');
        }
    }

    /**
     * Check to see if the supplied identity and credentials exist in the
     * database, account needs to be active
     *
     * @param string $identity Username, always an email address
     * @param string $credentials Password for identity
     *
     * @return boolean FALSE if identity and credentials don't exist
     * @throws Exception
     */
    public function checkCredentials($identity, $credentials)
    {
        if ($this->salt != null) {
            $sql = "SELECT di.id
					FROM dlayer_identity di
					WHERE di.identity = :identity
					AND di.credentials = :credentials
					AND logged_in = 0
					AND enabled = 1
					LIMIT 1";
            $stmt = $this->_db->prepare($sql);
            $stmt->bindValue(':identity', $identity, PDO::PARAM_STR);
            $stmt->bindValue(':credentials',
                $this->hashedCredentials($credentials), PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch();

            if ($result != false) {
                $this->identity_id = $result['id'];

                return true;
            } else {
                return false;
            }
        } else {
            throw new Exception('Salt not set in authentication model');
        }
    }

    /**
     * Return the hashed string for the given credetials string, crypt SHA-512
     *
     * @param string $credentials
     *
     * @return string Hashed string, uses crypt() with a salt
     */
    private function hashedCredentials($credentials)
    {
        return crypt($credentials, $this->salt());
    }

    /**
     * Return the identity id for the currently logged in user, if the identity
     * id does not exist return FALSE
     *
     * @return integer|FALSE
     */
    public function identityId()
    {
        if ($this->identity_id != null) {
            return $this->identity_id;
        } else {
            return false;
        }
    }

    /**
     * Logout the identity, updated the logged in value, sets it to 0
     *
     * @param integer $identity_id
     *
     * @return void
     */
    public function logoutIdentity($identity_id)
    {
        $sql = "UPDATE dlayer_identity
				SET logged_in = 0
				WHERE id = :identity_id
				LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Login the identity, updates the last login time and sets the logged in
     * value to 1.
     *
     * @param integer $identity_id
     *
     * @return void
     */
    public function loginIdentity($identity_id)
    {
        $sql = "UPDATE dlayer_identity
				SET logged_in = 1, last_login = NOW(), last_action = NOW()
				WHERE id = :identity_id
				LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Logout any inactive identities, will have a last_action timestamp that
     * is older than the current time minus the timeout in seconds
     *
     * @param integer $timeout
     *
     * @return void
     */
    public function logoutInactiveIdenties($timeout)
    {
        $sql = "UPDATE dlayer_identity
		SET logged_in = 0
		WHERE last_action < (NOW() - INTERVAL :timeout SECOND)";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':timeout', $timeout, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Update the last action time for the currently logged in identity
     *
     * @param integer $identity_id
     *
     * @return boolean
     */
    public function updateLastActionTimestamp($identity_id)
    {
        $sql = "UPDATE dlayer_identity
				SET last_action = NOW()
				WHERE id = :identity_id
				LIMIT 1";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':identity_id', $identity_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Fetch all the test identities
     *
     * @return array
     */
    public function testIdentities()
    {
        $sql = "SELECT id, identity, logged_in
				FROM dlayer_identity
				ORDER BY id ASC";
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
