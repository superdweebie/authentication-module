<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\Options;

use Sds\AuthenticationModule\RememberMeInterface;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Storage\StorageInterface;
use Zend\Stdlib\AbstractOptions;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class AuthenticationService extends AbstractOptions
{

    protected $modes;

    protected $perRequestAdapter;

    protected $perSessionStorage;

    protected $perSessionAdapter;

    protected $rememberMeService;

    public function getModes() {
        return $this->modes;
    }

    public function setModes(array $modes) {
        $this->modes = $modes;
    }

    public function getPerRequestAdapter() {
        return $this->perRequestAdapter;
    }

    public function setPerRequestAdapter(AdapterInterface $perRequestAdapter) {
        $this->perRequestAdapter = $perRequestAdapter;
    }

    public function getPerSessionStorage() {
        return $this->perSessionStorage;
    }

    public function setPerSessionStorage(StorageInterface $perSessionStorage) {
        $this->perSessionStorage = $perSessionStorage;
    }

    public function getPerSessionAdapter() {
        return $this->perSessionAdapter;
    }

    public function setPerSessionAdapter(AdapterInterface $perSessionAdapter) {
        $this->perSessionAdapter = $perSessionAdapter;
    }

    public function getRememberMeService() {
        return $this->rememberMeService;
    }

    public function setRememberMeService(RememberMeInterface $rememberMeService) {
        $this->rememberMeService = $rememberMeService;
    }
}
