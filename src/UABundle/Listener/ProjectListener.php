<?php

namespace UABundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UABundle\Entity\Project;

class ProjectListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function prePersist(Project $project, LifecycleEventArgs $event)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $lastProject = $entityManager->getRepository('UABundle:Project')->findBy([], ['number' => 'DESC'], 1);
        $number = 1;
        if (isset($lastProject) && !empty($lastProject)) {
            $number = $lastProject[max(array_keys($lastProject))]->getNumber() + 1;
        }
        $project
            ->setNumber($number)
            ->setCreationDate(new \DateTime())
            ->setLastUpdate($project->getCreationDate());

    }

    public function preUpdate(Project $project, LifecycleEventArgs $event)
    {
        $project->setLastUpdate(new \DateTime());
    }

    public function postLoad(Project $project, LifecycleEventArgs $event)
    {
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $project->setUserHasRights($this->container->get('ua.project.rights_service')->userHasRights($currentUser, $project));
    }

    public function postPersist(Project $project, LifecycleEventArgs $event)
    {
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $project->setUserHasRights($this->container->get('ua.project.rights_service')->userHasRights($currentUser, $project));
    }

    public function postUpdate(Project $project, LifecycleEventArgs $event)
    {
        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $project->setUserHasRights($this->container->get('ua.project.rights_service')->userHasRights($currentUser, $project));
    }
}