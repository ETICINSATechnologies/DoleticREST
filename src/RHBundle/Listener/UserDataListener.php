<?php

namespace RHBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use KernelBundle\Entity\User;
use RHBundle\Entity\UserData;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserDataListener
{

    const ITERATIONS = 99;
    const PASSWORD_LENGTH = 16;
    const BASE_STRING = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postPersist(UserData $userData, LifecycleEventArgs $event)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        if ($userName = $this->makeUserName($userData->getFirstname(), $userData->getLastname())) {
            $password = $this->makeRandomPassword();
            $user = new User();
            $user
                ->setUsername($userName)
                ->setEmail($userData->getEmail())
                ->setPlainPassword($password)
                ->setUserData($userData);
            $entityManager->persist($user);

            $message = new \Swift_Message();
            $message
                ->setSubject('Compte Doletic créé !')
                ->setFrom($this->container->getParameter('mailer_user'))
                ->setTo($userData->getEmail())
                ->setBody($this->container->get('templating')->render(
                    '@RH/emails/welcome.html.twig',
                    [
                        'name' => $userData->getFullname(),
                        'url' => $this->container->getParameter('doletic_url'),
                        'jeName' => $this->container->getParameter('je_name'),
                        'webmaster' => $this->container->getParameter('webmaster_email'),
                        'username' => $userName,
                        'password' => $password
                    ]
                ));

            $this->container->get('mailer')->send($message, $failures);

        } else {
            $entityManager->remove($userData);
        }
        $entityManager->flush();
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
}