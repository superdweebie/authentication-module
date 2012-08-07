<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthModule\Authentication\Adapter;

use DoctrineModule\Authentication\Adapter\ObjectRepository;
/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class DoctrineAdapter implements AdapterInterface
{
    protected $adapter;

    public function __construct(ObjectRepository $adapter){
        $this->adapter = $adapter;
    }

    public function setIdentityValue($identityValue){
        $this->adapter->setIdentityValue($identityValue);
    }

    public function setCredentialValue($credentialValue){
        $this->adapter->setCredentialValue($credentialValue);
    }

    public function authenticate(){
        return $this->adapter->authenticate();
    }
}
