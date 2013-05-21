<?php

namespace Sds\AuthenticationModule\Test\TestAsset;

use Sds\IdentityModule\DataModel\Identity;

class TestData{

    public static function create($documentManager){

        //Create data in the db to query against
        $documentManager->getConnection()->selectDatabase('authenticationModuleTest');

        $identity = new Identity;
        $identity->setIdentityName('toby');
        $identity->setFirstName('Toby');
        $identity->setLastName('McQueen');
        $identity->setEmail('toby@here.com');
        $identity->setCredential('password');

        $documentManager->persist($identity);

        $documentManager->flush();
        $documentManager->clear();
    }

    public static function remove($documentManager){
        //Cleanup db after all tests have run
        $collections = $documentManager->getConnection()->selectDatabase('authenticationModuleTest')->listCollections();
        foreach ($collections as $collection) {
            $collection->remove(array(), array('safe' => true));
        }
    }
}