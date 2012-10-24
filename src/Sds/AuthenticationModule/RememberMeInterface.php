<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule;

interface RememberMeInterface
{

    public function getIdentity();

    
    public function loginSuccess($identity, $rememberMe);


    public function logout();
}
