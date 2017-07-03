<?php

namespace KernelBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Google_Client;
use Google_Service_Directory;
use Google_Service_Directory_User;
use Google_Service_Directory_UserName;
use Google_Service_Exception;
use KernelBundle\Entity\User;
use PhpOffice\PhpWord\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserListener
{

    const ITERATIONS = 99;
    const PASSWORD_LENGTH = 16;
    const BASE_STRING = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const TOKEN_FILE = __DIR__ . '/../../../ressources/token.json';
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(User $user, LifecycleEventArgs $event)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        if ($userName = $this->makeUserName($user->getFirstName(), $user->getLastName())) {
            $userPassword = $user->getPlainPassword();
            if (!isset($userPassword)) {
                $password = $this->makeRandomPassword();
                $user->setPlainPassword($password);
            }
            $user->setUsername($userName)->setEnabled(true);

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

        } else {
            $entityManager->remove($user);
            $entityManager->flush();
        }
    }

    public function postPersist(User $user, LifecycleEventArgs $event)
    {
        $user->setFullName($user->getFirstName() . ' ' . $user->getLastName());
        $userPositions = $user->getPositions();
        if (isset($userPositions)) {
            foreach ($userPositions as $userPosition) {
                if ($userPosition->isMain()) {
                    $user->setMainPosition($userPosition->getPosition());
                    break;
                }
            }
        }
        $this->setMemberships($user);

        //Creation gmail account through gmail api
        try {
            $this->createGMailAccount($user);
        }catch(Exception $exception){
            print ($exception->getMessage());
        }
    }

    public function postUpdate(User $user, LifecycleEventArgs $event)
    {
        $user->setFullName($user->getFirstName() . ' ' . $user->getLastName());
        $userPositions = $user->getPositions();
        if (isset($userPositions)) {
            foreach ($userPositions as $userPosition) {
                if ($userPosition->isMain()) {
                    $user->setMainPosition($userPosition->getPosition());
                    break;
                }
            }
        }
        $this->setMemberships($user);
        $this->updateGoogleAccount($user);
    }

    public function createGMailAccount(User $user){

        require_once __DIR__ . '/../../../vendor/autoload.php';
        session_start();

        $SCOPES = array(
            "https://www.googleapis.com/auth/admin.directory.user"
        );

        $client = new Google_Client();
        $client->setApplicationName("Doletic");
        $client->setScopes($SCOPES);
        $client->setSubject($this->container->getParameter('webmaster_email'));
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
            $createUserResult = $service -> users -> insert($userInstance);
            var_dump($createUserResult);
        }
        catch (Google_Service_Exception $gse)
        {
            echo $gse->getMessage();
        }
    }

    public function updateGoogleAccount(User $user){

        require_once __DIR__ . '/../../../vendor/autoload.php';
        session_start();


        $SCOPES = array(
            "https://www.googleapis.com/auth/admin.directory.user"
        );
        $HELP_DIR = __DIR__ . '/../../../ressources/debug.txt';

        $client = new Google_Client();
        $client->setApplicationName("Doletic");
        $client->setScopes($SCOPES);
        $client->setSubject($this->container->getParameter('webmaster_email'));
        $service = new Google_Service_Directory($client);
        $token = @file_get_contents(self::TOKEN_FILE);
        // Refresh token when expired
        $client->setAccessToken($token);


        if (isset($token))  $client->setAccessToken($token);

        $userInstance = new Google_Service_Directory_User();
        $userInstance -> setHashFunction("MD5");
        $userInstance -> setPassword(hash("md5", $user->getPassword()));
        $userInstance -> setSuspended(!$user->isEnabled());

        try
        {
            $rep = $service -> users -> update($this->getEticEmail($user) ,$userInstance);
            file_put_contents($HELP_DIR, print_r($rep, true));
        }
        catch (Google_Service_Exception $gse)
        {
            file_put_contents($HELP_DIR, print_r($gse->getMessage(), true));
        }
    }

    public function postLoad(User $user, LifecycleEventArgs $event)
    {
        $user->setFullName($user->getFirstName() . ' ' . $user->getLastName());
        foreach ($user->getPositions() as $userPosition) {
            if ($userPosition->isMain()) {
                $user->setMainPosition($userPosition->getPosition());
                break;
            }
        }
        $this->setMemberships($user);
    }

    private function makeUserName($firstName, $lastName)
    {
        $userName = strtolower(substr($firstName, 0, 1) . str_replace(" ", "", $lastName));
        $ok = false;
        $index = 0;
        $userRepository = $this->container->get('doctrine')->getRepository('KernelBundle:User');
        // Conditions on index to avoid infinite loop
        while (!$ok && $index < self::ITERATIONS) {
            $temp = $userName . ($index > 0 ? $index : '');
            $user = $userRepository->findOneBy(['username' => $temp]);
            if (!isset($user)) {
                $ok = true;
                $userName = $temp;
                break;
            }
            $index++;
        }

        return $index == self::ITERATIONS ? false : $userName;
    }

    private function makeRandomPassword()
    {
        return substr(str_shuffle(self::BASE_STRING), 0, self::PASSWORD_LENGTH);
    }

    private function setMemberships(&$user) {
        // Set consultant value
        if ($user->getConsultantMembership() == null) {
            $user->setConsultant(0);
        } else if ($user->getConsultantMembership()->isValid()) {
            $user->setConsultant(2);
        } else {
            $user->setConsultant(1);
        }

        // Set administrator value
        $memberships = $user->getAdministratorMemberships();
        if(isset($memberships)) {
            foreach ($memberships as $membership) {
                if ($membership->isActive() && $membership->isValid()) {
                    $user->setAdministrator(2);
                    break;
                } else if ($membership->isActive() && !$membership->isValid()) {
                    $user->setAdministrator(1);
                    break;
                }
            }
        }
        if ($user->getAdministrator() == null || $user->getAdministrator() < 1) {
            $user->setAdministrator(0);
        }
    }

    public function getEticEmail(User $user){
        return $user->getFirstName().".".$user->getLastName()."@".$this-> container->getParameter('je_domain');
    }

    public function refreshToken(Google_Client $client){
        if ($client->isAccessTokenExpired()) {
            // the new access token comes with a refresh token as well
            file_put_contents(self::TOKEN_FILE, print_r(json_encode($client->getRefreshToken()), true));
            $client->fetchAccessTokenWithRefreshToken(@file_get_contents(self::TOKEN_FILE));
        }
    }
}