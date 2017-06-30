<?php
/**
 * Created by PhpStorm.
 * User: josquin
 * Date: 22/06/17
 * Time: 16:48
 */

namespace RHBundle\Command;

use Google_Client;
use Google_Service_Directory;
use Google_Service_Directory_User;
use Google_Service_Directory_UserName;
use Google_Service_Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;




class createGMailUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:createGMailUser')

            // the short description shown while running "php bin/console list"
            ->setDescription('This function create a gmail account')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This function create a gmail account')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';
        session_start();

        $TOKEN_FILE = __DIR__ . "/../../../ressources/token.json";
        $SCOPES = array(
            "https://www.googleapis.com/auth/admin.directory.user"
        );

        $client = new Google_Client();
        $client->setApplicationName("Doletic");
        $client->setScopes($SCOPES);
        $client->setSubject($this->getContainer()->getParameter('webmaster_email'));
        $service = new Google_Service_Directory($client);
        $token = @file_get_contents($TOKEN_FILE);
        // Refresh token when expired
        $client->setAccessToken($token);
        if ($client->isAccessTokenExpired()) {
            // the new access token comes with a refresh token as well
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        }


        if (isset($token))  $client->setAccessToken($token);

        $userInstance = new Google_Service_Directory_User();
        $nameInstance = new Google_Service_Directory_UserName();

        $nameInstance -> setGivenName('givenName3');
        $nameInstance -> setFamilyName('familyName3');

        $userInstance -> setName($nameInstance);
        $userInstance -> setHashFunction("MD5");
        $userInstance -> setPrimaryEmail('newEmail3@etic-insa.com');
        $userInstance -> setPassword(hash("md5", "password3"));

        try
        {
            $createUserResult = $service -> users -> insert($userInstance);
            var_dump($createUserResult);
        }
        catch (Google_Service_Exception $gse)
        {
            echo $gse->getMessage();
        }



        print ("debug : Fin de la méthode\n");
    }
}