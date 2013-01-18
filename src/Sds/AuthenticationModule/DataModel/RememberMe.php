<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule\DataModel;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 *
 * @license MIT
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 *
 * @ODM\Document
 */
class RememberMe
{

    /**
     *
     * @ODM\Id(strategy="none")
     */
    protected $series;

    /**
     *
     * @ODM\String
     */
    protected $token;

    /**
     *
     * @ODM\String
     */
    protected $identityName;

    public function getSeries() {
        return $this->series;
    }

    public function setSeries($series) {
        $this->series = (string) $series;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = (string) $token;
    }

    public function getIdentityName() {
        return $this->identityName;
    }

    public function setIdentityName($identityName) {
        $this->identityName = (string) $identityName;
    }

    public function __construct($series, $token, $identityName){
        $this->setSeries($series);
        $this->setToken($token);
        $this->setIdentityName($identityName);
    }
}
