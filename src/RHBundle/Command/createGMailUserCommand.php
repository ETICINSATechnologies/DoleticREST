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
use Google_Service_Gmail;
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

        $REDIRECT_URI = 'http://localhost:8080/';
        $KEY_LOCATION = __DIR__ . '/../../../client_secret.json';
        $TOKEN_FILE   = "token.txt";

        $client = new Google_Client();
        $client->setApplicationName("Doletic");

        $token = $this->getContainer()->getParameter('token');

        print ("debug : début test");

        $client = new Google_Client();
        $client->setApplicationName("ClientWeb2");
        $service = new Google_Service_Directory($client);

        if (isset($token)) {
            $client->setAccessToken($token);
        }
        $key = file_get_contents($KEY_LOCATION);
        $client->useApplicationDefaultCredentials();
        $token = $client->getAccessToken();

        $userInstance = new Google_Service_Directory_User();
        $nameInstance = new Google_Service_Directory_UserName();

        $nameInstance -> setGivenName('Testing 1');
        $nameInstance -> setFamilyName('Testing 1');

        $userInstance -> setName($nameInstance);
        $userInstance -> setHashFunction("MD5");
        $userInstance -> setPrimaryEmail('tete@domain.com');
        $userInstance -> setPassword(hash("md5", "password"));
        try
        {
            $createUserResult = $service -> users -> insert($userInstance);
            var_dump($createUserResult);
        }
        catch (Google_Service_Exception $gse)
        {
            echo "User already exists: ".$gse->getMessage();
        }

        print ("debug : Fin de la méthode");
    }
}