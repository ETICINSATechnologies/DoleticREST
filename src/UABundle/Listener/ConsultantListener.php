<?php

namespace UABundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UABundle\Entity\Consultant;

class ConsultantListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(Consultant $consultant, LifecycleEventArgs $event)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $lastConsultant = $entityManager->getRepository('UABundle:Consultant')->findBy(['project' => $consultant->getProject()], ['number' => 'DESC'], 1);
        $number = 1;
        if(isset($lastConsultant) && !empty($lastConsultant)) {
            $number = $lastConsultant[max(array_keys($lastConsultant))]->getNumber() + 1;
        }
        $consultant->setNumber($number);
    }

    public function preRemove(Consultant $consultant, LifecycleEventArgs $event)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $consultants = $entityManager->getRepository('UABundle:Consultant')->findBy(['project' => $consultant->getProject()], ['number' => 'ASC']);
        if(isset($consultants) && !empty($consultants)) {
            $n = 1;
            foreach ($consultants as $currentConsultant) {
                if ($currentConsultant->getNumber() != $n) {
                    $currentConsultant->setNumber($n);
                    $entityManager->persist($currentConsultant);
                }
                if($currentConsultant->getId() != $consultant->getId()) {
                    $n++;
                }
            }
        }
    }
}