<?php

namespace SdsAuthModule\Controller\Behaviour;

trait ActiveUser {

    protected $activeUser;
        
    protected function getActiveUser(){
        if(!$this->activeUser){
            $this->activeUser = $this->locator->get('active_user');            
        }
        return $this->activeUser;
    }
}