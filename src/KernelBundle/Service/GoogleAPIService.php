<?php

namespace KernelBundle\Service;


use Google_Client;
use Google_Service_Directory;
use Google_Service_Directory_User;
use Google_Service_Directory_UserName;
use Google_Service_Exception;
use KernelBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;


class GoogleAPIService
{

    private $container;
    const PASSWORD_LENGTH = 16;
    const BASE_STRING = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const TOKEN_FILE = __DIR__ . '/../../../ressources/token.json';
    const KEY_LOCATION = __DIR__ . '/../../../ressources/client_secret.json';
    const HELP_DIR = __DIR__ . '/../../../ressources/debug.txt';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createGMailAccount(User $user)
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';
        session_start();

        $SCOPES = array(
            "https://www.googleapis.com/auth/admin.directory.user"
        );

        $client = new Google_Client();
        $client->setApplicationName("Doletic");
        $client->setScopes($SCOPES);
        $client->setSubject($this->container->getParameter('webmaster_email'));
        $client->setAuthConfig(self::KEY_LOCATION);
        $service = new Google_Service_Directory($client);
        $token = @file_get_contents(self::TOKEN_FILE);
        // Refresh token when expired
        $client->setAccessToken($token);
        $this->refreshToken($client);

        if (isset($token))  $client->setAccessToken($token);

        $userInstance = new Google_Service_Directory_User();
        $nameInstance = new Google_Service_Directory_UserName();

        $nameInstance -> setGivenName($user->getFirstName());
        $nameInstance -> setFamilyName($user->getLastName());

        $userInstance -> setName($nameInstance);
        $userInstance -> setHashFunction("MD5");
        $userInstance -> setPrimaryEmail($this->getEticEmail($user));
        $userInstance -> setPassword(hash("md5",$this->makeRandomPassword()));
        $userInstance -> setAddresses($user->getAddress());
        $userInstance -> setPhones($user->getTel());
        $userInstance -> setIsAdmin($user->getAdministrator());

        try
        {
            $this->sendConfirmationInscriptionMail($user);
            $service -> users -> insert($userInstance);
        }
        catch (Google_Service_Exception $gse)
        {
            file_put_contents(self::HELP_DIR, print_r($gse->getMessage(), true)); $gse->getMessage();
        }
    }

    public function updateGoogleAccount(User $user)
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';
        session_start();

        $SCOPES = array(
            "https://www.googleapis.com/auth/admin.directory.user"
        );

        $client = new Google_Client();
        $client->setApplicationName("Doletic");
        $client->setScopes($SCOPES);
        $client->setSubject($this->container->getParameter('webmaster_email'));
        $client->setAuthConfig(self::KEY_LOCATION);
        $service = new Google_Service_Directory($client);
        $token = @file_get_contents(self::TOKEN_FILE);
        // Refresh token when expired

        $client->setAccessToken($token);
        $this->refreshToken($client);

        if (isset($token)) $client->setAccessToken($token);

        $userInstance = new Google_Service_Directory_User();
        if (!empty($user->getPlainPassword()) and $user->getPlainPassword() != null ) {
            $userInstance->setHashFunction("MD5");
            $userInstance->setPassword(hash("md5", $user->getPlainPassword()));
            $this->sendConfirmationUpdatePasswordMail($user);
        }
        $userInstance -> setSuspended(!$user->isEnabled());

        file_put_contents(self::HELP_DIR, print_r($userInstance, true));

        try
        {
            $service -> users -> update($this->getEticEmail($user) ,$userInstance);
        }
        catch (Google_Service_Exception $gse)
        {
            file_put_contents(self::HELP_DIR, print_r($gse->getMessage(), true));
        }
    }

    public function makeRandomPassword()
    {
        return substr(str_shuffle(self::BASE_STRING), 0, self::PASSWORD_LENGTH);
    }

    public function refreshToken(Google_Client $client){
        if ($client->isAccessTokenExpired()) {
            // the new access token comes with a refresh token as well
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        }
    }

    public function getEticEmail(User $user){
        return $user->getFirstName().".".$user->getLastName()."@".$this-> container->getParameter('je_domain');
    }

    public function sendConfirmationUpdatePasswordMail(User $user){
        if ($this->container->getParameter('mailer_password') !== null) {
            $message = new \Swift_Message();
            $message
                ->setSubject('Ton mot de passe Doletic a été modifié.')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($user->getEmail())
                ->setBody($this->container->get('templating')->render(
                    ':emails:update_pass.html.twig',
                    [
                        'user' => $user
                    ]
                ));

            $this->container->get('mailer')->send($message);
        }
    }

    public function sendConfirmationInscriptionMail(User $user){
        if ($this->container->getParameter('mailer_password') !== null) {
            $message = new \Swift_Message();
            $message
                ->setSubject('Compte Doletic créé !')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($user->getEmail())
                ->setBody($this->container->get('templating')->render(
                    ':emails:welcome.html.twig',
                    [
                        'user' => $user,
                        'url' => $this->container->getParameter('doletic_url'),
                        'jeName' => $this->container->getParameter('je_name'),
                        'webmaster' => $this->container->getParameter('webmaster_email')
                    ]
                ));
            $this->container->get('mailer')->send($message);
        }
    }

}