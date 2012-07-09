<?php
/**
 * @package    SdsAuthModule
 * @license    MIT
 */
namespace Sds\AuthModule\Model;

use Sds\Common\User\RoleAwareUserInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class DefaultUser implements RoleAwareUserInterface
{

    /**
     *
     * @var string
     */
    protected $username = 'guest';

    /**
     *
     * @var array
     */
    protected $roles = [SdsCommon\AccessControl\Constant\Role::guest];

    /**
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     *
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = (string) $username;
    }

    /**
     *
     * @param array $roles
     */
    public function setRoles(array $roles){
        $this->roles = $roles;
    }

    /**
     *
     * @param string $role
     */
    public function addRole($role){
        $this->roles[] = $role;
    }

    /**
     *
     * @param string $role
     */
    public function removeRole($role){
        if(($key = array_search($role, $this->roles)) !== false)
        {
            unset($this->roles[$key]);
        }
    }

    /**
     *
     * @return array
     */
    public function getRoles(){
        return $this->roles;
    }

    /**
     *
     * @param string $role
     * @return boolean
     */
    public function hasRole($role){
        return in_array($role, $this->roles);
    }
}