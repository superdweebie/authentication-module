<?php
/**
 * @package    Sds
 * @license    MIT
 */
namespace Sds\AuthenticationModule;

use Sds\AuthenticationModule\DataModel\RememberMe;
use Sds\AuthenticationModule\Options\RememberMeService as RememberMeServiceOptions;
use Zend\Math\Rand;

class RememberMeService implements RememberMeInterface
{

    protected $options;

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        if (!$options instanceof RememberMeServiceOptions) {
            $options = new RememberMeServiceOptions($options);
        }
        $this->options = $options;
    }

    public function __construct($options) {
        $this->setOptions($options);
    }

    public function getIdentity(){
        list($series, $token, $identityName) = $this->getCookieValues();
        $documentManager = $this->options->getDocumentManager();
        $repository = $documentManager->getRepository('Sds\AuthenticationModule\DataModel\RememberMe');
        $record = $repository->findOneBy(['series' => $series]);

        if ( ! $record){
            //If no record found matching the cookie, then ignore it, and remove the cookie.
            $this->removeCookie();
            return false;
        }

        if ($record->getIdentityName() != $identityName){
            //Something has gone very wrong if the identityName doesn't match, remove cookie, and db record
            $this->removeCookie();
            $this->removeSeriesRecord();
            return false;
        }

        if ($record->getToken() != $token){
            //If tokens don't match, then session theft has occured. Delete all user records, and cookie.
            $this->removeCookie();
            $this->removeIdentityRecords();
            return false;
        }

        //If we have got this far, then the identity is good.
        //Update the token.

        $newToken = $this->createToken();

        $record->setToken($newToken);
        $documentManager->flush();

        $this->setCookie($series, $newToken, $identityName);

        $identityRepository = $documentManager->getRepository($this->options->getIdentityClass());
        $identityProperty = $this->options->getIdentityProperty();
        $identity = $identityRepository->findOneBy([$identityProperty => $identityName]);
        if (! $identity){
            //although the cookie and rememberme record match, there is no matching registered user!
            $this->removeCookie();
            $this->removeIdentityRecords();
            return false;
        }

        return $identity;
    }

    public function loginSuccess($identity, $rememberMe){

        $this->removeSeriesRecord();

        if ($rememberMe){
            //Set rememberMe cookie
            $series = $this->createSeries();
            $token = $this->createToken();
            $identityName = $identity->{'get' . ucfirst($this->options->getIdentityProperty())}();

            $record = new RememberMe($series, $token, $identityName);

            $documentManager = $this->options->getDocumentManager();
            $documentManager->persist($record);
            $documentManager->flush();

            $this->setCookie($series, $token, $identityName);
        } else {
            $this->removeCookie();
        }
    }

    public function logout(){
        $this->removeSeriesRecord();
        $this->removeCookie();
    }

    protected function setCookie($series, $token, $identityName){
        setcookie(
            $this->options->getCookieName(),
            "$series\n$token\n$identityName",
            time() + $this->options->getCookieExpire(),
            null,
            null,
            $this->options->getSecureCookie()
        );
    }

    protected function getCookieValues(){
        if (!isset($_COOKIE[$this->options->getCookieName()])){
            return;
        }
        return explode("\n", $_COOKIE[$this->options->getCookieName()]);
    }

    protected function removeCookie(){
        setcookie(
            $this->options->getCookieName(),
            "",
            time() - 3600,
            null,
            null,
            $this->options->getSecureCookie()
        );
    }

    protected function removeSeriesRecord(){
        $cookieValues = $this->getCookieValues();
        if ($cookieValues){
            $series = $cookieValues[0];

            //Remove any existing db record
            $this->options->getDocumentManager()
                ->createQueryBuilder('Sds\AuthenticationModule\DataModel\RememberMe')
                ->remove()
                ->field('series')->equals($series)
                ->getQuery()
                ->execute();
        }
    }

    protected function removeIdentityRecords(){
        $cookieValues = $this->getCookieValues();
        if ($cookieValues){
            $identityName = $cookieValues[2];

            //Remove any existing db record
            $this->options->getDocumentManager()
                ->createQueryBuilder('Sds\AuthenticationModule\DataModel\RememberMe')
                ->remove()
                ->field('identityName')->equals($identityName)
                ->getQuery()
                ->execute();
        }
    }

    protected function createToken($length = 32)
    {
        $rand = Rand::getString($length, null, true);
        return $rand;
    }

    protected function createSeries($length = 32)
    {
        $rand = Rand::getString($length, null, true);
        return $rand;
    }
}
