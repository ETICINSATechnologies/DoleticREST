<?php

namespace KernelBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use KernelBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserListener
{

    const ITERATIONS = 99;
    const PASSWORD_LENGTH = 16;
    const BASE_STRING = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

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

        //Creation gmail account throught gmail api
        $this->createGMailAccount($user);

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
    }

    public function createGMailAccount(User $user){
        //first request to get token

        //second request with token to create account
        /*$postdata = http_build_query('{
                                        "primaryEmail": "test@etic-insa.com",
                                        "name": {
                                                    "givenName": "test",
                                         "familyName": "test"
                                        },
                                        "password": "test"
                                    }');

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context  = stream_context_create($opts);
        $result = file_get_contents('https://www.googleapis.com/admin/directory/v1/users', false, $context);

        var_dump($result);

        */
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
}