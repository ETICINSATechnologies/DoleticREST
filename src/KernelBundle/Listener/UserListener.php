<?php

namespace KernelBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use KernelBundle\Entity\User;
use PhpOffice\PhpWord\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserListener
{

    const ITERATIONS = 99;
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
                $password = $this->container->get('google_api_service')->makeRandomPassword();
                $user->setPlainPassword($password);
            }
            $user->setUsername($userName)->setEnabled(true);

            $this->container->get('google_api_service')->sendConfirmationInscriptionMail($user);

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
            $this->container->get('google_api_service')->createGMailAccount($user);
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

    private function setMemberships(User $user) {
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