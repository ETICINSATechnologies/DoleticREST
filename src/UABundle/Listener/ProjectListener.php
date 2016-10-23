<?php

namespace UABundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use UABundle\Entity\Project;

class ProjectListener
{
    // Create number using existing numbers
    public function prePersist(Project $project, LifecycleEventArgs $event)
    {

    }

    public function preUpdate(Project $project, LifecycleEventArgs $event)
    {

    }
}