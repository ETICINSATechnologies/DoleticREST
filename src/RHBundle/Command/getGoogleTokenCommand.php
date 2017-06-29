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




class getGoogleTokenCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:getGoogleToken')

            // the short description shown while running "php bin/console list"
            ->setDescription('This function get a token from google API')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This function get a token from google API')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';
        session_start();
        date_default_timezone_set('America/Los_Angeles');

        $REDIRECT_URI = 'http://localhost:8080/';
        $KEY_LOCATION = __DIR__ . '/../../../ressources/client_secret.json';
        $TOKEN_FILE = __DIR__ . '/../../../ressources/token.json';

        $SCOPES = array(
            "https://www.googleapis.com/auth/admin.directory.user"
        );

        $client = new Google_Client();
        $client->setApplicationName("Doletic");
        $client->setAuthConfig($KEY_LOCATION);

        // Incremental authorization
        $client->setIncludeGrantedScopes(true);

        // Allow access to Google API when the user is not present.
        $client->setAccessType('online');
        $client->setRedirectUri($REDIRECT_URI);
        $client->setScopes($SCOPES);

        $code = $this->getContainer()->getParameter('code');
        $token = @file_get_contents($TOKEN_FILE);

        //If we have a code, let's get the token
        if (isset($code) && !empty($code) && $code != null) {
            try {
                // Exchange the one-time authorization code for an access token
                $tokenArray = $client->fetchAccessTokenWithAuthCode($code);

                //Let's see if we get a token or an error message
                if(array_key_exists ( "access_token" , $tokenArray )){
                    print_r($tokenArray."\n");
                    file_put_contents($TOKEN_FILE, json_encode($tokenArray));
                }else if(array_key_exists ( "error" , $tokenArray )){
                    print("invalid token : " . $tokenArray["error"] . "\n");
                    exit ;
                }else{
                    print_r("unknown error : " . $tokenArray . "\n");
                    exit ;
                }
                header('Location: ' . filter_var($REDIRECT_URI, FILTER_SANITIZE_URL));
            }
            catch (\Google_Service_Exception $e) {
                print_r($e . "\n");
            }
            print("Token enregistré, vous pouvez désormais accèder à toutes les fonctionnalité de l'API GMail\n");
            exit ;
        }

        //Si je n'ai pas de token, générer une URL pour récupérer le code
        if (!isset($token) or $token == null or empty($token)) {

            // Generate a URL to request access from Google's OAuth 2.0 server:
            $authUrl = $client->createAuthUrl();
            // Redirect the user to Google's OAuth server
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));

            print ("debug : No token found\n");
            print ("Veuillez copier-coller cette url dans votre navigateur : " . $authUrl . "\n");

            exit ;
        }
        else{
            print ("debug : token : " . $token . "\n");
        }
    }
}