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
    }

    public function postUpdate(User $user, LifecycleEventArgs $event)
    {
        $user->setFullName($user->getFirstName() . ' ' . $user->getLastName());
    }

    public function postLoad(User $user, LifecycleEventArgs $event)
    {
        $user->setFullName($user->getFirstName() . ' ' . $user->getLastName());
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